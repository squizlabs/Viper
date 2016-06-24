(function(ViperUtil, ViperSelection, _) {
    function MatrixImagePlugin(viper)
    {
        this._parent = viper.getPluginManager().getPluginObject('ViperImagePlugin');
        this._parent.call(this, viper);

        this._uploadForm    = null;
        this._inlineUploadForm    = null;
        this._uploading = false;
        this._droppedImageToUpload = [];
        this._uploadId = 0;

        this._currentImageData = null;

        this._vitpPreviewBox = null;

    }


    Viper.PluginManager.addPlugin('MatrixImagePlugin', MatrixImagePlugin, 'ViperImagePlugin');

    MatrixImagePlugin.prototype = {

        _isEditPlus: function()
        {
          return (typeof EasyEdit !== 'undefined');
        },

        _isInternalLink: function(url)
        {
            return /^(\.\/\?a=)?\d+[^@]*$/.test(url);

        },

        /* this function creates the custom Matrix image plugin interface */
        createCustomInterface: function(prefix)
        {
            var tools = this.viper.Tools;
            var self  = this;

            var urlField    = tools.getItem(prefix + ':urlInput').element;
            var tabSwitch = tools.createRow(prefix + 'tabSwitch', 'Viper-imageTabSwitch');
            var $assetTab = ViperUtil.$('<a href="#" id="' + prefix + 'tabAsset" class="selected" title="' + _('Choose Image from Matrix Asset') + '">' + _('Asset') + '</a>');
            var $uploadTab = ViperUtil.$('<a href="#" id="' + prefix + 'tabUpload" class="" title="' + _('Upload an Image') + '">' + _('Upload') + '</a>');
            var $urlTab = ViperUtil.$('<a href="#" id="' + prefix + 'tabURL" class="" title="' + _('Image from an URL') + '">' + _('URL') + '</a>');
            tabSwitch.appendChild($assetTab.get(0));
            tabSwitch.appendChild($uploadTab.get(0));
            tabSwitch.appendChild($urlTab.get(0));

            ViperUtil.insertBefore(urlField, tabSwitch);

            // customise url field, add the status and file name indicator
            ViperUtil.$(urlField).find('label').append('<div class="Viper-image-status"><span class="Viper-image-status-indicator"></span><span class="Viper-image-filename-indicator"></span></div>');


            // append asset selector row
            var urlRow = tools.createRow(prefix + ':urlRow', 'Viper-chooseAssetRow');
            var assetPicker = tools.createButton(prefix + ':assetPicker', '', 'Pick Asset', 'Viper-assetSelector-button', function() {
                self.pickAsset(prefix, false);
            });
            ViperUtil.insertAfter(urlField, urlRow);
            urlRow.appendChild(urlField);
            urlRow.appendChild(assetPicker);

            // append image cropper button
            if(self._isEditPlus()) {
                var imageEditor = tools.createButton(prefix + ':imageEditor', '', 'Edit Image', 'Viper-imageEditor-button', function() {
                    var urlField = tools.getItem(prefix + ':urlInput');
                    var value = urlField.getValue();
                    if(value) {
                        // actions to perform after image editing
                        var rawassetid = value.replace(/:v[0-9]+/g, '');
                        var saveCallbackFunc = function() {
                            urlField.setValue(value,false);
                            self.setPreviewContent(false, true, prefix);
                            self.retrieveAssetDetails(value, function(data) {
                                // update interface with asset's variety data and status
                                self.enableAssetStatusIndicator(data);
                                self.enableVarietyChooser(data);
                                // apply the changes straigh because we have already modified the image itself
                                var button = null;
                                if(prefix == 'ViperImagePlugin') {
                                    button = self.viper.Tools.getItem('ViperImagePlugin:bubbleSubSection-applyButton');
                                }
                                else {
                                    button = self.viper.Tools.getItem('vitpImagePlugin-infoSubsection-applyButton');
                                }
                                ViperUtil.$(button.element).mousedown();
                            });
                        };
                        // show the overlay of image editing
                        EasyEditOverlay.showOverlay('imageDetails',{assetid: rawassetid, initAssetid: value, saveCallback: saveCallbackFunc});
                    }
                });
                urlRow.appendChild(imageEditor);
            }

            // append the File row
            var fileRow = this.createFileRow(prefix);
            ViperUtil.insertAfter(urlRow, fileRow);

            // append error message div
            var $errorMessage = ViperUtil.$('<div class="Viper-image-error-message"></div>');
            ViperUtil.insertAfter(fileRow, $errorMessage.get(0));


            // append preview box
            if(prefix == 'vitpImagePlugin') {
                // for inline vitp, we need to create a preview box for it, the main toolbar one already created in parent class
                var vitpPreviewBox = document.createElement('div');
                ViperUtil.addClass(vitpPreviewBox, 'ViperITP-msgBox ViperImagePlugin-previewPanel');
                ViperUtil.setHtml(vitpPreviewBox, 'Loading preview');
                ViperUtil.setStyle(vitpPreviewBox, 'display', 'none');
                this._vitpPreviewBox = vitpPreviewBox;
                ViperUtil.insertAfter($errorMessage.get(0), this._vitpPreviewBox);
            }
            else {
                // move the preview box right under the picker
                ViperUtil.insertAfter($errorMessage.get(0), this._previewBox);
            }



            // add the variety chooser
            var $varietyChooser = ViperUtil.$('<div class="Viper-varietyChooser"><div class="Viper-varietyChooserButton"><span class="Viper-varietyChooser-name">' + _('Original Image') + '</span> : <span class="Viper-varietyChooser-size" /><span class="Viper-varietyChooser-right-arrow"></span></div><div class="Viper-varietyChooser-menu"></div></div>');
            ViperUtil.insertAfter(prefix == 'vitpImagePlugin' ? this._vitpPreviewBox : this._previewBox, $varietyChooser.get(0));

        

            // append the hidden file upload form
            var form = this.createUploadImageForm(prefix);
            ViperUtil.insertAfter($varietyChooser.get(0), form);

            // append the file upload area
            var $fileUploadButton = ViperUtil.$('<div id="Viper-imageUpload-button" class="Viper-button">' + _('Choose File') + '</div>');
            var $fileDropText = ViperUtil.$('<div class="Viper-imageUploadArea-text">' + _('Drop image here or') + '</div>');
            var $fileUploadArea = ViperUtil.$('<div id="' + prefix + 'fileUploadArea" class="Viper-imageUploadArea" ></div>');
            var isAdvancedUpload = function() {
              // drop image support is for those latest browsers
              var div = document.createElement('div');
              return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
            }();
            if(isAdvancedUpload) {
                $fileUploadArea.append($fileDropText);
            }
            $fileUploadArea.append($fileUploadButton);
            ViperUtil.insertAfter($varietyChooser.get(0), $fileUploadArea.get(0));

            // append the choose location fields for image upload
            var locationFields = this.createChooseLocationFields(prefix);
            ViperUtil.insertAfter($fileUploadArea.get(0), locationFields);

            // append the image upload progress bar
            var imageUploadProgressBar = this.createImageUploadProgressBar(prefix);
            ViperUtil.insertAfter(prefix == 'vitpImagePlugin' ? this._vitpPreviewBox : this._previewBox, imageUploadProgressBar);

            // the dividing line
            var $devidingLine = ViperUtil.$('<hr class="Viper-image-hr" />');
            ViperUtil.insertAfter(locationFields, $devidingLine.get(0));

            // handle actions clicking on tabs
            $assetTab.click(function(e) {
                ViperUtil.preventDefault(e);
                ViperUtil.$(this).parent().show();
                ViperUtil.$(this).parent().find('a').removeClass('selected');
                $assetTab.addClass('selected');

                ViperUtil.$(this).parent().parent().find('.Viper-chooseAssetRow .Viper-textbox .Viper-textbox-title').html('ID');

                // if it's a file upload base64, just clean it up
                var value = ViperUtil.$(this).parent().parent().find('.Viper-chooseAssetRow input.Viper-textbox-input').val();
                if(value.indexOf('filepath://') == 0) {
                    ViperUtil.$(this).parent().parent().find('.Viper-chooseAssetRow input.Viper-textbox-input').val('');
                    value = '';
                }
                var src = value.replace(/^\.\/\?a=/, '');

                // Update preview pane.
                self.updateImagePreview(src, prefix);

                var $imageEditorIcon = ViperUtil.$(this).parent().parent().find('.Viper-imageEditor-button');
                if(self._isInternalLink(value)){
                    self.retrieveAssetDetails(src, function(data) {
                        // update interface with asset's variety data and status
                        self.enableAssetStatusIndicator(data);
                        self.enableVarietyChooser(data);
                    });
                    $imageEditorIcon.show();
                }
                else {
                    $imageEditorIcon.hide();
                }
                
                var $assetPickerIcon = ViperUtil.$(this).parent().parent().find('.Viper-assetSelector-button');
                $assetPickerIcon.show();

                ViperUtil.$(this).parent().parent().find('.Viper-chooseAssetRow').show();
                ViperUtil.$(this).parent().parent().find('.Viper-imageUploadArea').hide();


                ViperUtil.$(this).parent().parent().find('.Viper-imageUploadFileRow').hide();
                ViperUtil.$('.Viper-image-error-message').html('').hide();
                // hide choose location fields
                ViperUtil.$('.' + prefix + '-chooseLocationFields').hide();
            })
            $uploadTab.click(function(e) {
                ViperUtil.preventDefault(e);
                ViperUtil.$(this).parent().show();
                ViperUtil.$(this).parent().find('a').removeClass('selected');
                $uploadTab.addClass('selected');


                // reset the base64 file content from previous uploads
                self._inlineUploadForm.find('input[name=base64]').val('');
                self._uploadForm.find('input[name=base64]').val('');

                // disable variety chooser etc
                self.disableAssetStatusIndicator(tools.getItem(prefix + ':urlInput').element);
                self.disableVarietyChooser(tools.getItem(prefix + ':urlInput').element);

                ViperUtil.$(this).parent().parent().find('.Viper-chooseAssetRow').hide();
                ViperUtil.$(this).parent().parent().find('.Viper-imageUploadArea').show();
                ViperUtil.$(this).parent().parent().find('.ViperImagePlugin-previewPanel').hide();

                ViperUtil.$(this).parent().parent().find('.Viper-imageUploadFileRow').hide();
                ViperUtil.$('.Viper-image-error-message').html('').hide();
            })
            $urlTab.click(function(e) {
                ViperUtil.preventDefault(e);
                ViperUtil.$(this).parent().show();
                ViperUtil.$(this).parent().find('a').removeClass('selected');
                $urlTab.addClass('selected');

                ViperUtil.$(this).parent().parent().find('.Viper-chooseAssetRow .Viper-textbox .Viper-textbox-title').html('URL');

                // if it's a file upload base64, just clean it up
                var value = ViperUtil.$(this).parent().parent().find('.Viper-chooseAssetRow input.Viper-textbox-input').val();
                if(value.indexOf('filepath://') == 0) {
                    ViperUtil.$(this).parent().parent().find('.Viper-chooseAssetRow input.Viper-textbox-input').val('');
                    value = '';
                }
                var src = value.replace(/^\.\/\?a=/, '');

                // Update preview pane.
                self.updateImagePreview(src, prefix);

                //disable icons
                var $imageEditorIcon = ViperUtil.$(this).parent().parent().find('.Viper-imageEditor-button');
                $imageEditorIcon.hide();
                var $assetPickerIcon = ViperUtil.$(this).parent().parent().find('.Viper-assetSelector-button');
                $assetPickerIcon.hide();

                // disable variety chooser etc
                self.disableAssetStatusIndicator(tools.getItem(prefix + ':urlInput').element);
                self.disableVarietyChooser(tools.getItem(prefix + ':urlInput').element);


                ViperUtil.$(this).parent().parent().find('.Viper-chooseAssetRow').show();
                ViperUtil.$(this).parent().parent().find('.Viper-imageUploadArea').hide();


                ViperUtil.$(this).parent().parent().find('.Viper-imageUploadFileRow').hide();
                ViperUtil.$('.Viper-image-error-message').html('').hide();
                // hide choose location fields
                ViperUtil.$('.' + prefix + '-chooseLocationFields').hide();

            });

            $fileUploadButton.click(function(e) {
                // click upload button
                ViperUtil.$(this).parent().parent().find('input[name=create_image_upload]').click();
            });

            // drop file to the file upload area to upload
            $fileUploadArea.on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
              })
            .on('dragover dragenter', function() {
                $fileUploadArea.addClass('is-dragover');
              })
            .on('dragleave dragend drop', function() {
                $fileUploadArea.removeClass('is-dragover');
              })
            .on('drop', function(e) {
                droppedFiles = e.originalEvent.dataTransfer.files;
                 if (!droppedFiles || !droppedFiles[0]) {
                    return;
                }
                self.readDroppedImage(droppedFiles[0], function(image, file) {
                    self._inlineUploadForm.find('input[name=base64]').val(image.src);
                    self._uploadForm.find('input[name=base64]').val(image.src);
                    // set file name
                    self._inlineUploadForm.find('input[name=file_name]').val(file.name);
                    self._uploadForm.find('input[name=file_name]').val(file.name);

                    self.viper.Tools.getItem('vitpImagePlugin:urlInput').setValue('filepath://' + file.name);
                    self.viper.Tools.getItem('ViperImagePlugin:urlInput').setValue('filepath://' + file.name);
                    // show choose upload location fields
                    ViperUtil.$('.' + prefix + '-chooseLocationFields').css('display', 'block');
                    // change the apply button text to 'upload image'
                    var applyButton1 = this.viper.Tools.getItem('ViperImagePlugin:bubbleSubSection-applyButton');
                    var applyButton2 = this.viper.Tools.getItem('vitpImagePlugin-infoSubsection-applyButton');
                    ViperUtil.$(applyButton1.element).html(_('Upload Image'));
                    ViperUtil.$(applyButton2.element).html(_('Upload Image'));

                    // enable the apply button (only if we are not in uploading status)
                    this.viper.Tools.enableButton('ViperImagePlugin:bubbleSubSection-applyButton');
                    this.viper.Tools.enableButton('vitpImagePlugin-infoSubsection-applyButton');
                    // hide the URL row and display the file row
                    ViperUtil.$('.Viper-chooseAssetRow').hide();
                    ViperUtil.$('.Viper-imageUploadFileRow').show();

                    // enable the location selector
                    self.viper.Tools.getItem(prefix + ':parentRootNode').disable();
                    // reset the use current location checkbox
                    self.viper.Tools.getItem(prefix + ':useCurrentLocation').setValue(true);

                    // prefill the file name field
                    var fileName = file.name;
                    // if file name is empty, make a random name with correct file extension
                    if(fileName == '') {
                        var imageSrc = image.src;
                        var subString = imageSrc.substring(0, imageSrc.indexOf(";"))
                        var subStringArray = subString.split('/');
                        var fileExt = subStringArray[1];
                        if(fileExt) {
                            var randomName = Math.floor(Math.random() * 1000000);
                            fileName = randomName.toString() + '.' + fileExt;
                        }
                    }
                    this.viper.Tools.getItem(prefix + ':fileInput').setValue(fileName);

                    // update the preview
                    self.setPreviewContent(image, false, prefix);


                    // hide the upload area
                    ViperUtil.$('#' + prefix + 'fileUploadArea').hide();

                });
            });

                  
        },

        /* this function gets called when you click anywhere in viper content, 
        it's used to update the plugin interface 
        */
        _updateToolbar: function(image, toolbarPrefix)
        {
            var toolbar = this.viper.PluginManager.getPlugin('ViperToolbarPlugin');
            var self = this;
            if (!toolbar) {
                return;
            }

            var tools = this.viper.Tools;
            var urlInput = tools.getItem(toolbarPrefix + ':urlInput');
            var $dialog = ViperUtil.$(urlInput.element).parent().parent().parent();

            self._uploadForm.get(0).reset();
            self._inlineUploadForm.get(0).reset();

            if (image && ViperUtil.isTag(image, 'img') === true) {
                tools.setButtonActive('image');

                var src = this.viper.getAttribute(image, 'src');

                // get rid of the trailing timestamp
                if(this._isInternalLink(src)) {
                    src = src.replace(/(\?|&)v=[0-9]+/g, '');
                }

                this.setUrlFieldValue(src);
                tools.getItem(toolbarPrefix + ':altInput').setValue(this.viper.getAttribute(image, 'alt') || '');
                tools.getItem(toolbarPrefix + ':titleInput').setValue(this.viper.getAttribute(image, 'title') || '');

                if (!image.getAttribute('alt')) {
                    tools.getItem(toolbarPrefix + ':isDecorative').setValue(true);
                } else {
                    tools.getItem(toolbarPrefix + ':isDecorative').setValue(false);
                }


                // which tab to open
                if(this._isInternalLink(src)) {
                    $dialog.find('#' + toolbarPrefix + 'tabAsset').click();
                }
                else if (src.indexOf('filepath://') == 0) {
                    $dialog.find('#' + toolbarPrefix + 'tabUpload').click();
                }
                else {
                    $dialog.find('#' + toolbarPrefix + 'tabURL').click();
                }

                // if it's a "droped in content" image upload, we need to prepare ourself
                self._prepareDropppedImageUpload(toolbarPrefix);

            } else {
                tools.enableButton('image');
                tools.setButtonInactive('image');

                tools.getItem(toolbarPrefix + ':isDecorative').setValue(true);
                tools.getItem(toolbarPrefix + ':urlInput').setValue('');
                tools.getItem(toolbarPrefix + ':altInput').setValue('');
                tools.getItem(toolbarPrefix + ':titleInput').setValue('');
                tools.setFieldErrors(toolbarPrefix + ':urlInput', []);

                // Update preview pane.
                ViperUtil.empty(toolbarPrefix == 'vitpImagePlugin' ? this._vitpPreviewBox : this._previewBox);
                ViperUtil.setStyle(toolbarPrefix == 'vitpImagePlugin' ? this._vitpPreviewBox : this._previewBox, 'display', 'none');

                // open asset tab by default
                $dialog.find('#' + toolbarPrefix + 'tabAsset').click();


                self.disableAssetStatusIndicator(tools.getItem(toolbarPrefix + ':urlInput').element);
                self.disableVarietyChooser(tools.getItem(toolbarPrefix + ':urlInput').element);

            }//end if

        },

        /*
         get the asset details
        */
        retrieveAssetDetails: function(assetid, callback)
        {
            assetid = assetid.replace(/(\?|&).*/g, '');
            var exp = /(.*):(v[0-9]+)/g;
            var result = exp.exec(assetid);
            var varietyId = null;
            if(result) {
                assetid = result[1];
                varietyId = result[2];
            }
            if(this._isEditPlus()) {
                EasyEditAssetManager.getAsset(assetid, function(asset){
                    var data = {'assetid' : assetid, 'varietyid' : varietyId, 'attributes' : asset.attr};
                    self._currentImageData = data;
                    callback.call(this, data);
                });
            }
            else {
                var jsMap = parent.frames.sq_sidenav.JS_Asset_Map;
                jsMap.doRequest({
                    _attributes: {
                        action: 'get attributes'
                    },
                    asset: [
                        {
                            _attributes: {
                                assetid: assetid
                            }
                        }
                    ]
                }, function(response) {
                    var data = {'assetid' : assetid, 'varietyid' : varietyId, 'attributes' : response['asset'][0]['_attributes']};

                    var name = '';
                    switch(data.attributes.status) {
                        case "1":
                            name = 'Archived';
                        break;
                        case "2":
                            name = 'Under Construction';
                        break;
                        case "4":
                            name = 'Pending Approval';
                        break;
                        case "8":
                            name = 'Approved To Go Live';
                        break;
                        case "16":
                            name = 'Live';
                        break;
                        case "32":
                            name = 'Up For Review';
                        break;
                        case "64":
                            name = 'Safe Editing';
                        break;
                        case "128":
                            name = 'Safe Editing Pending Approval';
                        break;
                        case "256":
                            name = 'Safe Edit Approved To Go Live';
                        break;
                    }
                    data.attributes.status = name;

                    self._currentImageData = data;
                    callback.call(this, data);
                });
            }
        },

        enableAssetStatusIndicator: function(data)
        {

            var urlInputs = [this.viper.Tools.getItem('ViperImagePlugin:urlInput'), this.viper.Tools.getItem('vitpImagePlugin:urlInput')];
            for (var i in urlInputs) {
                var urlInput = urlInputs[i];
                var $urlInput = ViperUtil.$(urlInput.element);
                $urlInput.find('div.Viper-textbox-main').hide();
                $urlInput.find('div.Viper-image-status').show();
                $urlInput.find('span.Viper-image-filename-indicator').html(data.attributes.title);
                var className = '';
                var self = this;
                className = data.attributes.status.replace(/\s/g, '').toLowerCase();
                // set status color
                $urlInput.find('span.Viper-image-status-indicator').attr('class', 'Viper-image-status-indicator ' + className);
                // click on this div, make it disappear
                $urlInput.find('div.Viper-image-status').click(function() {
                    self.disableAssetStatusIndicator(ViperUtil.$(this).parent().parent());
                    ViperUtil.$(this).parent().find('input.Viper-textbox-input').focus().click();
                })
            }

        },

        disableAssetStatusIndicator: function(urlInput)
        {
            ViperUtil.$(urlInput).find('div.Viper-textbox-main').show();
            ViperUtil.$(urlInput).find('div.Viper-image-status').hide();
        },

        enableVarietyChooser: function(data)
        {
            var urlInputs = {'ViperImagePlugin' : this.viper.Tools.getItem('ViperImagePlugin:urlInput'), 'vitpImagePlugin' : this.viper.Tools.getItem('vitpImagePlugin:urlInput')};
            var self = this;
            var varietyData = data.attributes.varieties;
            if(typeof varietyData == 'string') {
                varietyData = JSON.parse(varietyData);
            }
            varietyData = varietyData.data;

            for (var i in urlInputs) {
                var urlInput = urlInputs[i];
                var $parentDiv = ViperUtil.$(urlInput.element).parent().parent();
                if(urlInput.getValue() != '') {
                    $parentDiv.find('.Viper-varietyChooser').show();
                    $parentDiv.find('.Viper-varietyChooser-menu').hide();
                    $chooser = $parentDiv.find('.Viper-varietyChooserButton');
                    $text = $parentDiv.find('.Viper-varietyChooserButton .Viper-varietyChooser-size');
                    $name = $parentDiv.find('.Viper-varietyChooserButton .Viper-varietyChooser-name');
                    $chooser.attr('data-prefix', i);

                    // if current image is a variety
                    if(data.varietyid && varietyData[data.varietyid])
                    {   
                        // add the chooser's text
                        $text.html(varietyData[data.varietyid].variety_width + ' x ' + varietyData[data.varietyid].variety_height + ' (' + self._readablizeBytes(varietyData[data.varietyid].variety_size) + ')');
                        $name.html(varietyData[data.varietyid].name);
                        // set it as data attr
                        $chooser.attr('data-varietyid', data.varietyid);
                    }
                    else {
                        var originalImageSize = data.attributes.width + ' x ' + data.attributes.height + ' (' + self._readablizeBytes(data.attributes.size) + ')';
                        $text.html(originalImageSize);
                        $name.html(_('Original Image'));
                        // remove the current variety attr
                        $chooser.removeAttr('data-varietyid');
                    }

                    $chooser.unbind( "click" );
                    $chooser.on('click', function() {
                        var $menu = ViperUtil.$(this).parent().find('.Viper-varietyChooser-menu');
                        var currentVarietyId = ViperUtil.$(this).attr('data-varietyid');

                        $menu.empty();

                        $menuList = ViperUtil.$('<ul></ul>');
                        $menu.append($menuList);
                        $originalImageMenuItem = ViperUtil.$('<li><span class="varietyMenuName">' + _('Original Image') + '</span><span class="varietyMenuSize">' + originalImageSize + '</span><span class="varietyMenuChecked"/></li>');
                        $menuList.append($originalImageMenuItem);

                        // if it's image not a variety
                        if(!currentVarietyId) {
                            $originalImageMenuItem.addClass('selected');
                        }

                        var varietyCount = 0;
                        for (var varietyIndex in varietyData) {
                            varietyCount++;
                            var varietySize = varietyData[varietyIndex].variety_width + ' x ' + varietyData[varietyIndex].variety_height + ' (' + self._readablizeBytes(varietyData[varietyIndex].variety_size) + ')';
                            $varietyMenuItem  = ViperUtil.$('<li><span class="varietyMenuName">' + varietyData[varietyIndex].name + '</span><span class="varietyMenuSize">' + varietySize + '</span><span class="varietyMenuChecked"/></li>');
                            $menuList.append($varietyMenuItem);
                            if(varietyIndex == currentVarietyId) {
                                $varietyMenuItem.addClass('selected');
                            }
                            // click on menu item, set the current varietyid
                            $varietyMenuItem.attr('data-id', varietyIndex);
                            $varietyMenuItem.click(function() {
                                $menu.hide();
                                data.varietyid = ViperUtil.$(this).data('id');
                                self.enableVarietyChooser(data);
                                var prefix = ViperUtil.$(this).parent().parent().parent().find('.Viper-varietyChooserButton').attr('data-prefix');
                                var urlInputToUpdate = self.viper.Tools.getItem( prefix + ':urlInput');
                                urlInputToUpdate.setValue(data.assetid + ':' + data.varietyid,false);
                                self.setPreviewContent(false, true, prefix);
                            });
                        }
                        $originalImageMenuItem.click(function() {
                            $menu.hide();
                            data.varietyid = null;
                            self.enableVarietyChooser(data);
                            var prefix = ViperUtil.$(this).parent().parent().parent().find('.Viper-varietyChooserButton').attr('data-prefix');
                            var urlInputToUpdate = self.viper.Tools.getItem(prefix + ':urlInput');
                            urlInputToUpdate.setValue(data.assetid,false);
                            self.setPreviewContent(false, true, prefix);
                        });

                        // work out the position and size of the menu list
                        $menu.toggle();
                        var position = -20 * (varietyCount + 1);
                        var height = -2.05 * position;
                        $menu.css('height', height);
                        // -12 is for position of the left arrow
                        $menu.css('top', position - 12);
                    });
                }
            }

        },

        disableVarietyChooser: function(urlInput)
        {
            var $parentDiv = ViperUtil.$(urlInput).parent().parent();
            $parentDiv.find('.Viper-varietyChooser').hide();
        },

        setPreviewContent: function(img, loading, prefix)
        {
                var previewBox = prefix == 'ViperImagePlugin' ? this._previewBox : this._vitpPreviewBox;
                ViperUtil.setStyle(previewBox, 'display', 'block');

                if (loading === true) {
                    ViperUtil.$(previewBox).append('<div class="loadingPreviewMessage">' + _('Loading preview') + '</div>');
                    ViperUtil.$('.Viper-image-error-message').html('').hide();
                } else if (!img) {
                    // Failed to load image.
                    ViperUtil.removeClass(previewBox, 'Viper-info');
                    ViperUtil.setStyle(previewBox, 'display', 'none');
                    ViperUtil.$('.Viper-image-error-message').html(_('Could not load preview')).show();
                } else {
                    this.viper.Tools.setFieldErrors('ViperImagePlugin:urlInput', []);
                    ViperUtil.$('.Viper-image-error-message').html('').hide();
                    ViperUtil.addClass(previewBox, 'Viper-info');

                    var tmp = document.createElement('div');
                    ViperUtil.setStyle(tmp, 'visibility', 'hidden');
                    ViperUtil.setStyle(tmp, 'left', '-9999px');
                    ViperUtil.setStyle(tmp, 'top', '-9999px');
                    ViperUtil.setStyle(tmp, 'position', 'absolute');
                    tmp.appendChild(img);
                    this.viper.addElement(tmp);

                    ViperUtil.setStyle(img, 'width', '');
                    ViperUtil.setStyle(img, 'height', '');

                    var width  = ViperUtil.getElementWidth(img);
                    var height = ViperUtil.getElementHeight(img);
                    ViperUtil.remove(tmp);

                    img.removeAttribute('height');
                    img.removeAttribute('width');

                    var maxWidth  = 320;
                    var maxHeight = 320;
                    if (height > maxHeight && width > maxWidth) {
                        if (height > width) {
                            ViperUtil.setStyle(img, 'height', 'auto');
                            ViperUtil.setStyle(img, 'width', maxWidth + 'px');
                        } else {
                            ViperUtil.setStyle(img, 'width', maxWidth + 'px');
                            ViperUtil.setStyle(img, 'height', 'auto');
                        }
                    } else if (width > maxWidth) {
                        ViperUtil.setStyle(img, 'width', maxWidth + 'px');
                        ViperUtil.setStyle(img, 'height', 'auto');
                    } else if (height > maxHeight) {
                        ViperUtil.setStyle(img, 'height', maxHeight + 'px');
                        ViperUtil.setStyle(img, 'width', 'auto');
                    }


                    ViperUtil.empty(previewBox);
                   
                    // if it's a very short image (small height value)
                    // we will add a span padding, so that the preview box would have a mininum height, and image would sit in the vertical center
                    if(height < 150) {
                        // the span has a height of 150px
                        var span = document.createElement('span');
                        previewBox.appendChild(span);
                    }

                    previewBox.appendChild(img);

                }//end if
        },

        initTopToolbar: function()
        {
            // Call the parent method.
            var contents = this._parent.prototype.initTopToolbar.call(this);

            var self  = this;
            var tools = this.viper.Tools;
            var prefix = 'ViperImagePlugin';

            self.createCustomInterface(prefix);

            // register event to get rid of the trailing timestamp of v=xx  on all images
            this.viper.registerCallback('Viper:getHtml', 'MatrixImagePlugin', function(data) {
                var imgs = ViperUtil.getTag('img', data.element);
                for (var i = 0; i < imgs.length; i++) {
                    var imageTag = imgs[i];
                    var src = imageTag.getAttribute('src');
                    src = src.replace(/(\?|&)v=[0-9]+$/g, '');
                    imageTag.setAttribute('src', src);
                }
            });


            return contents;
        },


        createInlineToolbar: function(toolbar)
        {
            // Call the parent method.
            this._parent.prototype.createInlineToolbar.call(this, toolbar);

            var self  = this;
            var tools = this.viper.Tools;
            var prefix = 'vitpImagePlugin';

            self.createCustomInterface(prefix);

        },


        _getToolbarContents: function(prefix)
        {
            var self  = this;
            var tools = this.viper.Tools;

            // Create Image button and popup.
            var createImageSubContent = document.createElement('div');

            // URL text box.
            var urlTextbox = null;
            var url = tools.createTextbox(prefix + ':urlInput', _('URL'), '', null, true);
            createImageSubContent.appendChild(url);
            urlTextbox = (ViperUtil.getTag('input', createImageSubContent)[0]);

            // if the URL field is changed, update preview.
            var inputTimeout = null;
            this.viper.registerCallback('ViperTools:changed:' + prefix + ':urlInput', 'ViperImagePlugin', function() {
                clearTimeout(inputTimeout);

                var url = ViperUtil.trim(tools.getItem(prefix + ':urlInput').getValue());
                if (!url) {

                     ViperUtil.setStyle(prefix == 'vitpImagePlugin' ? this._vitpPreviewBox : this._previewBox, 'display', 'none');
                     tools.setFieldErrors(prefix + ':urlInput', []);
                } else {
                    // After a time period update the image preview.
                    inputTimeout = setTimeout(function() {
                        self.updateImagePreview(url, prefix);
                    }, 500);
                }
            });

            // Decorative checkbox.
            var decorative = tools.createCheckbox(prefix + ':isDecorative', _('Image is decorative'), false, function(presVal) {
                if (presVal === true) {
                    tools.getItem(prefix + ':altInput').disable();
                    tools.getItem(prefix + ':titleInput').disable();
                    tools.getItem(prefix + ':altInput').setRequired(false);
                } else {
                    tools.getItem(prefix + ':altInput').setRequired(true);
                    tools.getItem(prefix + ':altInput').enable();
                    tools.getItem(prefix + ':titleInput').enable();
                }
            });
            createImageSubContent.appendChild(decorative);

            // Alt text box.
            var alt = tools.createTextbox(prefix + ':altInput', _('Alt'), '', null, true);
            createImageSubContent.appendChild(alt);

            // Title text box.
            var title = tools.createTextbox(prefix + ':titleInput', _('Title'));
            createImageSubContent.appendChild(title);

            return createImageSubContent;

        },


        createFileRow: function(prefix)
        {
            var self = this;
            var fileRow = this.viper.Tools.createRow(prefix + ':fileRow', 'Viper-imageUploadFileRow');
            var fileInput = this.viper.Tools.createTextbox(prefix + ':fileInput', _('File'), '', null, true);
            ViperUtil.$(fileInput).on('input', function() {
                // enable submit button
                self.viper.Tools.enableButton('ViperImagePlugin:bubbleSubSection-applyButton');
                self.viper.Tools.enableButton('vitpImagePlugin-infoSubsection-applyButton');

            });
            fileRow.appendChild(fileInput);
            return fileRow;
        },


        createUploadImageForm: function(prefix)
        {
            var self = this;
            
            // the hidden file upload form
            var currentUrl = ViperUtil.baseUrl(window.location.href);
            var actionURL = currentUrl + '?SQ_ACTION=image_upload';
            var $form = ViperUtil.$('<form id="'+ prefix + 'uploadImage" action="' + actionURL + '" style="display:none;" method="post" class="uploadImageForm" ></form>');
            if(prefix.indexOf('vitp') > -1) {
                this._inlineUploadForm = $form;
            }
            else {
                this._uploadForm = $form;
            }
            $form.append('<input id="'+ prefix + 'uploadImageButton" type="file" name="create_image_upload">');
            $form.append('<input type="hidden" name="create_root_node" value="">');
            $form.append('<input type="hidden" name="show_in_menu" value="">');
            $form.append('<input type="hidden" name="alt" value="">');
            $form.append('<input type="hidden" name="title" value="">');
            $form.append('<input type="hidden" name="token" value="">');
            $form.append('<input type="hidden" name="base64" value="">');
            $form.append('<input type="hidden" name="file_name" value="">');
            $form.append('<input type="hidden" name="image_preview_id" value="">');
            $form.append('<input type="hidden" name="upload_id" value="">');
            $form.append('<input type="button" id="'+ prefix + 'submit_file" style="display:none;" value="Upload File to Server">');


            // update preview from uploaded image
            $form.find('#'+ prefix + 'uploadImageButton').change(function(){
                var fileName = this.value;
                var prefix = this.id.replace(/uploadImageButton/, '');

                if(typeof fileName !== 'undefined' && fileName) {

                    self.setUrlFieldValue('filepath://' + fileName);          

                    // validate file type before sending it to Matrix
                    var cleanFileName = fileName.replace(/^.*[\\\/]/, '');
                    var isValid = /\.(jpe?g)|(gif)|(png)$/i.test(cleanFileName);
                    if(!isValid) {
                        self.viper.Tools.setFieldErrors('ViperImagePlugin:urlInput', [_('Incorrect file type')]);
                        self.viper.Tools.setFieldErrors('vitpImagePlugin:urlInput', [_('Incorrect file type')]);
                        ViperUtil.setStyle(self._previewBox, 'display', 'none');
                        // disable the apply button
                        if(self.viper.Tools.getItem('ViperImagePlugin:bubbleSubSection-applyButton')) {
                            self.viper.Tools.disableButton('ViperImagePlugin:bubbleSubSection-applyButton');
                        }
                        if(self.viper.Tools.getItem('vitpImagePlugin-infoSubsection-applyButton')) {
                            self.viper.Tools.disableButton('vitpImagePlugin-infoSubsection-applyButton');
                        }
                        return;
                    }

                    // if there is previous image preview specific settings, remove them
                    self._resetDroppedImageUpload();

                    // set the file name
                    ViperUtil.$('.Viper-imageUploadFileRow').show();
                    self.viper.Tools.getItem(prefix + ':fileInput').setValue(cleanFileName);

                    // if File API is supported, load preview
                    if (window.File && window.FileReader && this.files && this.files[0]) {
                        var reader = new FileReader();
                        self.setPreviewContent(false, true, prefix);
                        reader.readAsDataURL(this.files[0]);
                        var fileName = this.value;
                        reader.onload = function (e) {
                                var img = new Image();
                                img.src = e.target.result;
                                img.onload = function(){
                                    // image  has been loaded, set it to preview (only works for File API supported browser, not ie8)
                                    self.setPreviewContent(img, false, prefix);
                            };
                        }
                    }

                    // hide the upload area
                    ViperUtil.$('#' + prefix + 'fileUploadArea').hide();

                    // show choose location fields
                    ViperUtil.$('.' + prefix + '-chooseLocationFields').css('display', 'block');

                    // if the editable area does not belong to an asset, disable the choose current location option
                    var editableElement = self.viper.getEditableElement();
                    var idString = ViperUtil.$(editableElement).attr('id');
                    var matches = idString.match(/_([0-9]+)/);
                    if(matches == null) {
                         ViperUtil.$('.' + prefix + '-chooseLocationFields').find('.Viper-checkbox').css('display', 'none'); 
                    }
                    else {
                         ViperUtil.$('.' + prefix + '-chooseLocationFields').find('.Viper-checkbox').css('display', 'block'); 
                    }

                    // enable the location selector
                    self.viper.Tools.getItem(prefix + ':parentRootNode').disable();
                    // reset the use current location checkbox
                    self.viper.Tools.getItem(prefix + ':useCurrentLocation').setValue(true);



                    // enable the apply button
                    var button1 = self.viper.Tools.getItem('ViperImagePlugin:bubbleSubSection-applyButton');
                    var button2 = self.viper.Tools.getItem('vitpImagePlugin-infoSubsection-applyButton');
                    if(button1) {
                        ViperUtil.$(button1.element).html(_('Upload Image'));
                        self.viper.Tools.enableButton('ViperImagePlugin:bubbleSubSection-applyButton');
                    }
                    if(button2) {
                        ViperUtil.$(button2.element).html(_('Upload Image'));
                        self.viper.Tools.enableButton('vitpImagePlugin-infoSubsection-applyButton');
                    }
                }
            });
            return $form[0];
        },



        createImageUploadProgressBar: function(prefix)
        {

            // Preview box to display image info and preview.
            $progressIndicator = ViperUtil.$('<div id="' + prefix + '-progressIndicator" class="uploadImage-progressIndicator"></div>');
            $progressIndicator.append('<div class="uploadImage-progress-status"></div>');
            $progressIndicator.append('<div class="uploadImage-progress"><div class="uploadImage-progress-bar"><span class="uploadImage-progress-bar-inner" style="width: 0%;"></span></div></div>');

            var self = this;

            var $bar = $progressIndicator.find('.progress-bar-inner');
            var $progress = $progressIndicator.find('.progress');
            var $status = $progressIndicator.find('.progress-status');

            // the progress bar is hidden initially
            $progressIndicator.hide();

            var uploadForm = null;
            if(prefix.indexOf('vitp') > -1) {
                uploadForm = this._inlineUploadForm;
            }
            else {
                uploadForm = this._uploadForm;
            }

            uploadForm.ajaxForm({
              beforeSend: function() {
                  ViperUtil.$('.uploadImage-progress-status').show();
                  ViperUtil.$('.uploadImage-progressIndicator').show();
                  if(ViperUtil.isBrowser('msie', '<10') !== true && self._inlineUploadForm.find('input[name=base64]').val() == '') {
                    // old IE can't support upload progress
                    // and if we are uploading drag dropped image (base64), the progress bar is not accurate, so no showing it
                    ViperUtil.$('.uploadImage-progress').show();
                    ViperUtil.$('.uploadImage-progress-bar-inner').show();
                  }
                  else {
                    ViperUtil.$('.uploadImage-progress').hide();
                    ViperUtil.$('.uploadImage-progress-bar-inner').hide();
                  }
                  ViperUtil.$('.uploadImage-progress-status').html(_('Uploading image...'));
                  ViperUtil.$('.Viper-image-error-message').hide();
                  var percentVal = '2%';
                  ViperUtil.$('.uploadImage-progress-bar-inner').width(percentVal);
              },
              uploadProgress: function(event, position, total, percentComplete) {
                  var percentVal = percentComplete + '%';
                  ViperUtil.$('.uploadImage-progress-bar-inner').width(percentVal);
              },
              complete: function(xhr) {
                    var response = JSON.parse(xhr.responseText);
                    self._uploading = false;

                    // hide the upload form which was displayed for older IE
                    if(ViperUtil.isBrowser('msie', '<10') === true) {
                        uploadForm.css('display', 'none');
                    }

                    if(response.error) {
                        ViperUtil.$('.uploadImage-progress-status').hide();
                        ViperUtil.$('.uploadImage-progress').hide();
                        ViperUtil.$('.uploadImage-progress-bar-inner').width('0%');
                        ViperUtil.$('.Viper-image-error-message').html(response.error).show();

                        //reset the upload form
                        //uploadForm.get(0).reset();

                       
                        // if it's a image preview, we have to locate the preview image and replace it
                        if(response.image_preview_id && response.upload_id) {
                            self._setDroppedImageErrorStatus(response.image_preview_id, response.error, response.upload_id);
                        }

                    }
                    else {
                        // if upload is successful
                        // set the returned asset id
                        if(response.assetid) {

                            ViperUtil.$('.uploadImage-progressIndicator').hide();
                            ViperUtil.$('.uploadImage-progress-bar-inner').width('0%');


                            // hide choose location fields
                            ViperUtil.$('.' + prefix + '-chooseLocationFields').css('display', 'none');     

                            //reset the upload form
                            uploadForm.get(0).reset();

                            // if it's a image preview, we have to locate the preview image and replace it
                            if(response.image_preview_id && response.upload_id) {
                                var image = self._resizeImage;
                                if (ViperUtil.isBrowser('msie', '<11') === true) {
                                       image = self._ieImageResize;
                                }
                                // remove the low resolution warning, only if we are viewing the current completed image
                                if(image && image.dataset.id && image.dataset.id == response.image_preview_id) {
                                    ViperUtil.$('.VipperDroppedImage-msgBox').remove();
                                }
                                self._replacePreviewWithOriginal(response.image_preview_id, response.assetid, response.alt, response.title, response.upload_id);
                            }
                            else {
                                // otherwise just set the current selected image tag
                                self.setUrlFieldValue(response.assetid);
                                if(prefix.match('vitp')){
                                    self._parent.prototype._setImageAttributes.call(self, 'vitpImagePlugin');
                                }
                                else {
                                    self._parent.prototype._setImageAttributes.call(self, 'ViperImagePlugin');
                                }
                                
                            }

                            // refresh asset map
                            if (top.frames.sq_sidenav != null && top.frames.sq_sidenav.JS_Asset_Map && response.root_node) {
                                top.frames.sq_sidenav.JS_Asset_Map.refreshTree(response.root_node);
                            }
                        }                
                    }
              }
            });

            return $progressIndicator[0];
        },


        createChooseLocationFields: function(prefix)
        {
            // Use current location checkbox.
            var tools = this.viper.Tools;
            var self = this;
            var content = document.createElement('div');

            ViperUtil.addClass(content, prefix + '-chooseLocationFields');
            ViperUtil.addClass(content, 'Viper-imageUpload-chooseLocationFields');
            ViperUtil.setStyle(content, 'display', 'none');

            // use current location checkbox
            var useCurrentLocation = tools.createCheckbox(prefix + ':useCurrentLocation', _('Use current asset as upload location'), false, function(presVal) {
                if (presVal === true) {
                    tools.getItem(prefix + ':parentRootNode').disable();
                    tools.disableButton(prefix + ':assetPickerParentRootNode');
                    tools.getItem(prefix + ':parentRootNode').setRequired(false);
                } else {
                    tools.getItem(prefix + ':parentRootNode').enable();
                    tools.enableButton(prefix + ':assetPickerParentRootNode');
                    tools.getItem(prefix + ':parentRootNode').setRequired(true);
                }
                // enable the apply button
                if(self.viper.Tools.getItem('ViperImagePlugin:bubbleSubSection-applyButton')) {
                    self.viper.Tools.enableButton('ViperImagePlugin:bubbleSubSection-applyButton');
                }
                if(self.viper.Tools.getItem('vitpImagePlugin-infoSubsection-applyButton')) {
                    self.viper.Tools.enableButton('vitpImagePlugin-infoSubsection-applyButton');
                }

            });
            content.appendChild(useCurrentLocation);


            // parent root node selector
            var selectorTextbox       = tools.createTextbox(prefix + ':parentRootNode', _('Location'), '', null, true);
            var assetPicker = tools.createButton(prefix + ':assetPickerParentRootNode', '', 'Pick Asset', 'Viper-ees-target', function() {
                self.pickAsset(prefix, true);
            });
            var urlRow = tools.createRow(prefix + ':parentRootNodeRow', 'Viper-urlRow');
            urlRow.appendChild(selectorTextbox);
            urlRow.appendChild(assetPicker);
            content.appendChild(urlRow);

            // use current location checkbox
            var showInMenu = tools.createCheckbox(prefix + ':showInMenu', _('Show in menu'), false, function(presVal) {
                // enable the apply button
                if(self.viper.Tools.getItem('ViperImagePlugin:bubbleSubSection-applyButton')) {
                    self.viper.Tools.enableButton('ViperImagePlugin:bubbleSubSection-applyButton');
                }
                if(self.viper.Tools.getItem('vitpImagePlugin-infoSubsection-applyButton')) {
                    self.viper.Tools.enableButton('vitpImagePlugin-infoSubsection-applyButton');
                }

            });
            content.appendChild(showInMenu);

            return content;

        },


        updateImagePreview: function(url, prefix)
        {
            var self = this;
            if (this._isInternalLink(url) === true) {
                url = url.replace(/^\.\/\?a=/, '');
                var currentUrl = ViperUtil.baseUrl(window.location.href);
                currentUrl     = currentUrl.replace('/_edit', '');
                currentUrl += '?a=' + url;

                url = currentUrl;
            }

            // if it's a inline file upload, don't worry about it, it's already handled elsewhere
            if(url.indexOf("filepath://") === 0 || url.indexOf("data:") === 0 || url.length === 0) {
                ViperUtil.$('.ViperImagePlugin-previewPanel').hide();
                return;
            }

         

            // bust browser cache with a time stamp appended to the image url
            url = url.replace(/(\?|&)v=[0-9]+$/g, '');
            var symbol = url.match(/\?/g) ? '&' : '?';
            url = url + symbol + 'v=' + new Date().getTime();

            this._getImage(url, function(img) {
                self.setPreviewContent(img, false, prefix);
            });
        },

        setUrlFieldValue: function(url)
        {
            url = url.replace(/^\.\/\?a=/, '');

            // If there is a shadow asset, chop off the trailing "$"
            if ((url.indexOf(':') !== -1) && (url.substr((url.length - 1)) === '$')) {
                    url = url.substr(0, (url.length - 1));
                }

            this._parent.prototype.setUrlFieldValue.call(this, url);

        },

        getImageUrl: function(url)
        {
            url = this._parent.prototype.getImageUrl.call(this, url);

            if (this._isInternalLink(url) === true) {
                url = './?a=' + url;

                // If this is a shadow asset, add the trailing "$"
                if (url.indexOf(':') !== -1) {
                    url += '$';
                }
            }


            // don't worry about file:// url, it woudl be converted else where
            if (url.indexOf("filepath://") === 0) {
                     url = null;
            }

            return url;

        },


        _setImageAttributes: function(prefix)
        {
            var tools = this.viper.Tools;
            var url   = tools.getItem(prefix + ':urlInput').getValue();
            
            if(url == null) return;
            var self = this;
            var uploadForm = null;
            if(prefix.indexOf('vitp') > -1) {
                uploadForm = this._inlineUploadForm;

            }
            else {
                uploadForm = this._uploadForm;

            }

            // if we are in the uploading process, don't submit the upload again
            // this prevents Viper setting extra onsubmit event to all forms in the plugin
            if(this._uploading) {
                return;
            }

            // if we are not uploading a image preview
            // remove the css class so it won't be a preview anymore
            if(uploadForm && !uploadForm.find('input[name=base64]').val()) {
                this._removeDroppedImageStatus();
            }

            // start the upload process
            if (url.indexOf("filepath://") === 0) {

                //let's just set the file name from what user inputs
                var fileName   = tools.getItem(prefix + ':fileInput').getValue();
                uploadForm.find('input[name=file_name]').val(fileName);


                // add a unique upload batch id
                this._uploadId = this._uploadId + 1;
                uploadForm.find('input[name=upload_id]').val(this._uploadId);


                // if we are about to upload a dropped image preview
                // we need to set CSS class
                this._setDroppedImageUploadStatus();


                // set the selected parent root node location
                var selectedRootNode = tools.getItem(prefix + ':parentRootNode').getValue();
                var useCurrentLocation = tools.getItem(prefix + ':useCurrentLocation').getValue();
                var showInMenu = tools.getItem(prefix + ':showInMenu').getValue();
                var currentAssetid = null;
                var editableElement = this.viper.getEditableElement();
                var idString = ViperUtil.$(editableElement).attr('id');
                var matches = idString.match(/_([0-9]+)/);
                if(matches !== null && typeof matches[1] !== 'undefined') {
                    currentAssetid = matches[1];
                }

                if(useCurrentLocation) {
                    // use current location
                    uploadForm.find('input[name=create_root_node]').val(currentAssetid);
                }
                else {
                    if(selectedRootNode) {
                        // use selected location
                        uploadForm.find('input[name=create_root_node]').val(selectedRootNode);
                    }
                    else {
                        // nothing selected? fall back to current location
                        tools.getItem(prefix + ':useCurrentLocation').setValue(true);
                        uploadForm.find('input[name=create_root_node]').val(currentAssetid);
                    }
                }

                uploadForm.find('input[name=show_in_menu]').val(showInMenu ? '1' : '0');

                // set alt attribute
                var altValue = tools.getItem(prefix + ':altInput').getValue();
                uploadForm.find('input[name=alt]').val(altValue);

                // set title attribute
                var altValue = tools.getItem(prefix + ':titleInput').getValue();
                uploadForm.find('input[name=title]').val(altValue);
             

                // set the nonce token and submit the form
                if(typeof EasyEdit !== 'undefined') {
                    EasyEdit.getToken(function(token) {
                        uploadForm.find('input[name=token]').val(token);
                        // submit the file upload form
                        self._uploading = true;
                        uploadForm.submit();
                    });
                }
                else {
                        var token = ViperUtil.$('#token').val();
                        if (token) {
                            uploadForm.find('input[name=token]').val(token);
                            this._uploading = true;
                            uploadForm.submit();
                        }
                }

            }
            else {
                this._parent.prototype._setImageAttributes.call(this, prefix);
            }
        },

        
        pickAsset: function(idPrefix, forParentNode)
        {
        var tools       = this.viper.Tools;
        var urlField    = tools.getItem(idPrefix + ':urlInput'), altField    = tools.getItem(idPrefix + ':altInput');
        var parentNodeField    = tools.getItem(idPrefix + ':parentRootNode');
        var self = this;

        // if it's for parent node seleciton, allow all types
        var allowedTypes = [];
        if(!forParentNode) {
            allowedTypes = ['image', 'thumbnail', 'image_variety', 'physical_file'];
        }

       
            
        // if in Matrix backend mode
        if(!this._isEditPlus()) {
            var jsMap = parent.frames.sq_sidenav.JS_Asset_Map;
            var name =idPrefix;
            var safeName = idPrefix;
            var closeOnExit = function() {
                if (document.body.getAttribute('data-use-me-close-on-exit') === '1') {
                    document.body.removeAttribute('data-use-me-close-on-exit');
                    var resizer_frame = window.top.frames['sq_resizer'];
                    if (resizer_frame && !resizer_frame.hidden) {
                        resizer_frame.toggleFrame();
                    }
                }
            };
            var toggleResizerFrame = function() {
                var resizer_frame = window.top.frames['sq_resizer'];
                if (resizer_frame && resizer_frame.hidden) {
                    document.body.setAttribute('data-use-me-close-on-exit', '1');
                    resizer_frame.toggleFrame();
                }
            };
            if (jsMap.isInUseMeMode(name) === true) {
                alert('Asset Finder In Use');
            } else if (jsMap.isInUseMeMode() === true) {
                closeOnExit();
                jsMap.cancelUseMeMode();
            } else {
                toggleResizerFrame();
                jsMap.setUseMeMode(name, safeName, allowedTypes, true, function(data) {
                if(typeof data.assetid !== 'undefined') {
                    closeOnExit();
                    if(forParentNode) {
                        parentNodeField.setValue(data.assetid,false);
                        // enable the apply button
                        if(tools.getItem('ViperImagePlugin:bubbleSubSection-applyButton')) {
                            tools.enableButton('ViperImagePlugin:bubbleSubSection-applyButton');
                        }
                        if(tools.getItem('vitpImagePlugin-infoSubsection-applyButton')) {
                            tools.enableButton('vitpImagePlugin-infoSubsection-applyButton');
                        }
                    }
                    else {
                        urlField.setValue(data.assetid,false);
                        altField.setValue(data.attributes.alt,false);
                        self.setPreviewContent(false, true, 'ViperImagePlugin');
                        self.setPreviewContent(false, true, 'vitpImagePlugin');
                        self._resetDroppedImageUpload();
                        self.retrieveAssetDetails(data.assetid, function(data) {
                            // update interface with asset's variety data and status
                            self.enableAssetStatusIndicator(data);
                            self.enableVarietyChooser(data);
                        });

                    }
                }
                });
                        // close use me mode if user clicks anywhere
                        this.viper.registerCallback(['Viper:mouseDown', 'ViperToolbarPlugin:disabled'], 'MatrixImagePlugin', function(data) {
                            if (jsMap.isInUseMeMode() === true) {
                                    jsMap.cancelUseMeMode();
                            }
                        });
            }
        }
        else {
            // if in EES mode
            EasyEditAssetManager.getCurrentAsset(function(asset){

            var initialValue = null;
            var focusId = asset.id;
            if(forParentNode) {
                initialValue = parentNodeField.getValue();
            }
            else {
                initialValue = urlField.getValue();
            }
            if (/^[0-9]+([:].*)?$/.test(initialValue)) {
                focusId = initialValue;
            }// End if

            EasyEditAssetFinder.init({
                focusAssetId: focusId,
                types: allowedTypes,
                itemRefiner: function(asset) {
                // Unlock image variety from looking dependent. This allows
                // them to be selected.
                if (asset.type_code === 'image_variety') {
                    asset.is_dependant = 0;
                }
                return asset;
                },
                callback: function(selectedAsset){
                    if(allowedTypes.length > 0) {
                        var valid = false;
                        for (var i = 0; i < allowedTypes.length; i++) {
                            if (selectedAsset.attribute('type_code') === allowedTypes[i]) {
                                valid = true;
                                break;
                            }
                        }
                        if(!valid) {
                            alert(EasyEditLocalise._('You have selected a %1 asset. Only image, thumbnail or image variety assets can be selected.',selectedAsset.attribute('type_code')));
                            return;
                        }
                    }

                    var altText = selectedAsset.attribute('alt');
                    if (!altText) {
                        altText = '';
                    }

                    if(forParentNode) {
                        parentNodeField.setValue(selectedAsset.id,false);
                        // enable the apply button
                        if(tools.getItem('ViperImagePlugin:bubbleSubSection-applyButton')) {
                            tools.enableButton('ViperImagePlugin:bubbleSubSection-applyButton');
                        }
                        if(tools.getItem('vitpImagePlugin-infoSubsection-applyButton')) {
                            tools.enableButton('vitpImagePlugin-infoSubsection-applyButton');
                        }
                    }
                    else {
                        urlField.setValue(selectedAsset.id,false);
                        altField.setValue(altText,false);
                        self.setPreviewContent(false, true, 'ViperImagePlugin');
                        self.setPreviewContent(false, true, 'vitpImagePlugin');

                        self._resetDroppedImageUpload();

                        self.retrieveAssetDetails(selectedAsset.id, function(data) {
                            // update interface with asset's variety data and status
                            self.enableAssetStatusIndicator(data);
                            self.enableVarietyChooser(data);
                        });
                    }
                }
            });
            });
        }

        },

        /* this function tells viper click on those overlays are OK, part of the viper plugin */
        isPluginElement: function(element)
        {
            var assetFinderOverlay = ViperUtil.getid('ees_assetFinderOverlay');
            var assetDetailsOverlay = ViperUtil.getid('ees_imageDetailsOverlay');
            var assetEditorOverlay = ViperUtil.getid('ees_imageEditorOverlay');
            if (element !== this._toolbar
                && ViperUtil.isChildOf(element, this._toolbar) === false
                && ViperUtil.isChildOf(element, assetFinderOverlay) === false
                && ViperUtil.isChildOf(element, assetDetailsOverlay) === false
                && ViperUtil.isChildOf(element, assetEditorOverlay) === false
            ) {
                return false;
            }

            return true;

        },
        
        _getImage: function(url, callback)
        {
            var img    = new Image();
            img.onload = function() {
                callback.call(this, img);
            };
        
            img.onerror = function() {
                callback.call(this, false);
            };
        
            this.viper.setAttribute(img, 'src', url);
        
        },


        setImageURL: function(image, url)
        {
            if (!image) {
                return;
            }

            // bust browser cache with a time stamp appended to the image url
            url = url.replace(/(\?|&)v=[0-9]+$/g, '');
            var symbol = url.match(/\?/g) ? '&' : '?';
            url = url + symbol + 'v=' + new Date().getTime();

            this.viper.setAttribute(image, 'src', url);

        },

        /* below functions handle the dropped image to upload */

        insertDroppedImage: function(image, range, fileInfo)
        {
            var self = this;
            image.onload = function () {
                fileInfo    = fileInfo || {};
                range       = range || self.viper.getViperRange();
                image.alt   = fileInfo.name || '';
                // store the image in temp array
                var newLength = self.storeDroppedImageToUpload(image);

                // create a preview image
                var preview_img = new Image();
                preview_img.src = self.imageToDataUri(image, image.width, image.height, 10);
                preview_img.width = image.width;
                preview_img.height = image.height;
                preview_img.setAttribute('data-imagepaste', 'true');
                preview_img.setAttribute('data-filename', fileInfo.name || '');
                preview_img.setAttribute('data-id', newLength - 1);

                // insert a preview
                self._rangeToImage(range, preview_img);
            }

        },


        imageToDataUri: function(img, width, height, scale) {

            /// create an off-screen canvas
            var canvas = document.createElement('canvas');
            var ctx =  canvas.getContext('2d');
            var maxWidth = 100;

            if(width > maxWidth) {
                scale = width / maxWidth;
                // set its dimension to target size
                canvas.width = width / scale;
                canvas.height = height / scale;
            }


            /// draw source image into the off-screen canvas:
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

            /// encode image to data-uri with base64 version of compressed image
            return canvas.toDataURL();
        },

        storeDroppedImageToUpload: function(image) {
            var newLength = this._droppedImageToUpload.push(image);
            return newLength;
        },

        loadDroppedImageToUpload: function(id) {
            if(this._droppedImageToUpload[id]) {
                return this._droppedImageToUpload[id];
            }
            return false;
        },

        _prepareDropppedImageUpload: function(prefix) {
            // is this a dropped in image preview?
            var image = this._resizeImage;
            if (ViperUtil.isBrowser('msie', '<11') === true) {
                image = this._ieImageResize;
            }
            // remove any dropped image warning message, we will insert later
            ViperUtil.$('.VipperDroppedImage-msgBox').remove();
            if(image && image.dataset && image.dataset.imagepaste && image.dataset.imagepaste == 'true' && image.dataset.id) {
                var id = image.dataset.id;
                if(this.loadDroppedImageToUpload(id)) {
                    // set base64 of original image
                    this._inlineUploadForm.find('input[name=base64]').val(this.loadDroppedImageToUpload(id).src);
                    this._uploadForm.find('input[name=base64]').val(this.loadDroppedImageToUpload(id).src);
                    // set file name
                    this._inlineUploadForm.find('input[name=file_name]').val(image.dataset.filename);
                    this._uploadForm.find('input[name=file_name]').val(image.dataset.filename);
                    // set the preview image id
                    this._inlineUploadForm.find('input[name=image_preview_id]').val(id);
                    this._uploadForm.find('input[name=image_preview_id]').val(id);
                   
                    this.viper.Tools.getItem('vitpImagePlugin:urlInput').setValue('filepath://' + image.dataset.filename);
                    this.viper.Tools.getItem('ViperImagePlugin:urlInput').setValue('filepath://' + image.dataset.filename);
                
                    // show choose upload location fields
                    ViperUtil.$('.' + prefix + '-chooseLocationFields').css('display', 'block');
                    // change the apply button text to 'upload image'
                    var applyButton1 = this.viper.Tools.getItem('ViperImagePlugin:bubbleSubSection-applyButton');
                    var applyButton2 = this.viper.Tools.getItem('vitpImagePlugin-infoSubsection-applyButton');
                    ViperUtil.$(applyButton1.element).html(_('Upload Image'));
                    ViperUtil.$(applyButton2.element).html(_('Upload Image'));


                    // enable the apply button (only if we are not in uploading status)
                    if(!image.dataset.imagepasteStatus || image.dataset.imagepasteStatus != 'loading') {
                        this.viper.Tools.enableButton('ViperImagePlugin:bubbleSubSection-applyButton');
                        this.viper.Tools.enableButton('vitpImagePlugin-infoSubsection-applyButton');
                    }

                    // display previous upload error message
                    var errorMessage = image.dataset.error;
                    if(errorMessage) {
                        ViperUtil.$('.uploadImage-progressIndicator').show();
                        ViperUtil.$('.uploadImage-progress-status').hide();
                        ViperUtil.$('.uploadImage-progress').hide();
                        ViperUtil.$('.Viper-image-error-message').html(errorMessage).show();
                    }

                    // display the warning message to ask user to create asset
                    ViperUtil.$('<div />', {
                        "class": 'VipperDroppedImage-msgBox'
                        }).html(_('Low resolution preview.') + '<br/>' + _('Upload the image to use it in the content.')).insertBefore('.Viper-chooseAssetRow');              

                    // hide the URL row and display the file row
                    ViperUtil.$('.Viper-chooseAssetRow').hide();
                    ViperUtil.$('.Viper-imageUploadFileRow').show();


                    // enable the location selector
                    this.viper.Tools.getItem(prefix + ':parentRootNode').disable();
                    // reset the use current location checkbox
                    this.viper.Tools.getItem(prefix + ':useCurrentLocation').setValue(true);
                    

                    // prefill the file name field
                    var fileName = image.dataset.filename;
                    // if file name is empty, make a random name with correct file extension
                    if(fileName == '') {
                        var imageSrc = image.src;
                        var subString = imageSrc.substring(0, imageSrc.indexOf(";"))
                        var subStringArray = subString.split('/');
                        var fileExt = subStringArray[1];
                        if(fileExt) {
                            var randomName = Math.floor(Math.random() * 1000000);
                            fileName = randomName.toString() + '.' + fileExt;
                        }
                    }
                    this.viper.Tools.getItem(prefix + ':fileInput').setValue(fileName);
                }
            }
            else {
                    // remove those image preview specific settings from plugin interface
                    this._resetDroppedImageUpload();
            }
        },


        _resetDroppedImageUpload: function() {
                return;
                    // chaneg the apply button text  back to 'Apply Changes'
                    var applyButton1 = this.viper.Tools.getItem('ViperImagePlugin:bubbleSubSection-applyButton');
                    var applyButton2 = this.viper.Tools.getItem('vitpImagePlugin-infoSubsection-applyButton');
                    ViperUtil.$(applyButton1.element).html(_('Apply Changes'));
                    ViperUtil.$(applyButton2.element).html(_('Apply Changes'));
                    // hide the warning message
                    ViperUtil.$('.VipperDroppedImage-msgBox').hide();
                    // remove the base64 image from upload form
                    this._inlineUploadForm.find('input[name=base64]').val('');
                    this._uploadForm.find('input[name=base64]').val('');

                    // hide the file row and display the url row
                    ViperUtil.$('.Viper-imageUploadRow').show();
                    ViperUtil.$('.Viper-imageUploadFileRow').hide();

                    // remove file name
                    tools.getItem('vitpImagePlugin:fileInput').setValue('');
                    tools.getItem('ViperImagePlugin:fileInput').setValue('');
        },

        _replacePreviewWithOriginal: function(previewId, assetId, alt, title, uploadId) {
            // is this a dropped in image preview?
            var image = ViperUtil.$('[data-imagepaste="true"][data-upload-id="' + uploadId +'"][data-id="' + previewId +'"]').get(0);
            if(image) {
                this.setImageURL(image, './?a=' + assetId);
                this.setImageAlt(image, alt);
                this.setImageTitle(image, title);
                ViperUtil.$(image).removeAttr('data-imagepaste');
                ViperUtil.$(image).removeAttr('data-imagepaste-status');
                ViperUtil.$(image).removeAttr('id');
                ViperUtil.$(image).removeAttr('data-filename');
                ViperUtil.$(image).removeAttr('data-id');
            }
        },


        _setDroppedImageUploadStatus: function() {
            // is this a dropped in image preview?
            var image = this._resizeImage;
            if (ViperUtil.isBrowser('msie', '<11') === true) {
                image = this._ieImageResize;
            }
            if(image && image.dataset && image.dataset.imagepaste && image.dataset.imagepaste == 'true') {
                    ViperUtil.$(image).attr('data-imagepaste-status', 'loading');
                    ViperUtil.$(image).attr('data-upload-id', this._uploadId);
            }
        },



        _setDroppedImageErrorStatus: function(previewId, errorMessage, uploadId) {
             // is this a dropped in image preview?
            var image = ViperUtil.$('[data-imagepaste="true"][data-upload-id="' + uploadId +'"][data-id="' + previewId +'"]').get(0);
            if(image) {
                ViperUtil.$(image).attr('data-imagepaste-status', 'error')
                ViperUtil.$(image).attr('data-error', errorMessage)
            }
        },

        _removeDroppedImageStatus: function(previewId, errorMessage) {
            // is this a dropped in image preview?
            var image = this._resizeImage;
            if (ViperUtil.isBrowser('msie', '<11') === true) {
                image = this._ieImageResize;
            }
            if(image && image.dataset && image.dataset.imagepaste && image.dataset.imagepaste == 'true') {
                    ViperUtil.$(image).removeAttr('data-imagepaste');
                    ViperUtil.$(image).removeAttr('data-imagepaste-status');
                    ViperUtil.$(image).removeAttr('data-upload-id');
            }
        },


        _readablizeBytes: function(bytes) {

            var s = [
                _('bytes'),
                _('kb'),
                _('MB'),
                _('GB'),
                _('TB'),
                _('PB')
            ];
            var e = Math.floor(Math.log(bytes)/Math.log(1024));
            return (bytes/Math.pow(1024, Math.floor(e))).toFixed(2)+" "+s[e];

        }, //  End readablizeBytes.


    };
})(Viper.Util, Viper.Selection, Viper._);
