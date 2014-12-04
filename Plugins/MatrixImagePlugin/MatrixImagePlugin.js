function MatrixImagePlugin(viper)
{
    ViperUtil.inherits('MatrixImagePlugin', 'ViperImagePlugin');
    ViperImagePlugin.call(this, viper);

    this._uploadForm    = null;
    this._inlineUploadForm    = null;
    this._uploading = false;
    this._droppedImageToUpload = [];

}

MatrixImagePlugin.prototype = {

    _isInternalLink: function(url)
    {
        return /^\d+[^@]*$/.test(url);

    },

    initTopToolbar: function()
    {
        // Call the parent method.
        var contents = ViperImagePlugin.prototype.initTopToolbar.call(this);

        var self  = this;
        var tools = this.viper.ViperTools;
        var prefix = 'MatrixImagePlugin';

        var urlRow = tools.createRow('MatrixImagePlugin:urlRow', 'Viper-imageUploadRow');

        // Insert asset picker icon next to url field.
        // Insert anchor row after URL field.
        var urlField    = tools.getItem('ViperImagePlugin:urlInput').element;
        var assetPicker = tools.createButton('MatrixImagePlugin:assetPicker', '', 'Pick Asset', 'Viper-assetSelector-button', function() {
            self.pickAsset('ViperImagePlugin', false);
        });
        // image upload button
        var imageUploader = tools.createButton('MatrixImagePlugin:imageUploader', '', 'Upload Image', 'Viper-uploadImage-button', function() {            
            if(ViperUtil.isBrowser('msie', '<10') === true) {
                // old IE has to display the native upload input
                if(self._uploadForm.css('display') !== 'none') {
                    self._uploadForm.css('display', 'none');
                }
                else {
                    self._uploadForm.css('display', 'block');
                }
            }
            else {
                // use js to trigger file chooser
                $('#'+ prefix + 'uploadImageButton').click();
            }
        });

        // append the hidden file upload form
        var form = this.createUploadImageForm(prefix);


        ViperUtil.insertAfter(urlField, urlRow);
        urlRow.appendChild(urlField);
        urlRow.appendChild(assetPicker);
        urlRow.appendChild(imageUploader);
        urlRow.appendChild(form);

        // append the choose location fields for image upload
        var locationFields = this.createChooseLocationFields(prefix);
        ViperUtil.insertAfter(urlRow, locationFields);


        // append the image upload progress bar
        var imageUploadProgressBar = this.createImageUploadProgressBar(prefix);
        ViperUtil.insertAfter(this._previewBox, imageUploadProgressBar);

        // if the plugin bubble is shown
        ViperUtil.addEvent($('#' + this.viper.getId() + '-image').get(0), 'mousedown', function(e) {
            // reset upload forms   
            self._uploadForm.get(0).reset();
            self._inlineUploadForm.get(0).reset();
            self._uploadForm.css('display', 'none');
            self._inlineUploadForm.css('display', 'none');

            // hide choose location fields
            $('.' + prefix + '-chooseLocationFields').css('display', 'none');     
            $('.uploadImage-progressIndicator').hide();

            // reset choose location fields
            tools.getItem(prefix + ':useCurrentLocation').setValue(false);
            tools.getItem(prefix + ':parentRootNode').setValue('');

            self._uploading = false;

            // if we click on a preview image, have to prepare uploading preview interface
            self._prepareDropppedImageUpload(prefix);

        });


        return contents;

    },

    createInlineToolbar: function(toolbar)
    {
        // Call the parent method.
        ViperImagePlugin.prototype.createInlineToolbar.call(this, toolbar);

        var self  = this;
        var tools = this.viper.ViperTools;
        var prefix = 'vitpMatrixImagePlugin';

        var urlRow = tools.createRow('MatrixImagePlugin:urlRow-vitp', 'Viper-imageUploadRow');

        // Insert asset picker icon next to url field.
        // Insert anchor row after URL field.
        var urlField    = tools.getItem('vitpImagePlugin:urlInput').element;

        var assetPicker = tools.createButton('MatrixImagePlugin:assetPicker-vitp', '', 'Pick Asset', 'Viper-assetSelector-button', function() {
            self.pickAsset('vitpImagePlugin', false);
        });
        // image upload button
        var imageUploader = tools.createButton('vitpMatrixImagePlugin:imageUploader', '', 'Upload Image', 'Viper-uploadImage-button', function() {       
            if(ViperUtil.isBrowser('msie', '<10') === true) {
                // old IE has to display the native upload input
                if(self._inlineUploadForm.css('display') !== 'none') {
                    self._inlineUploadForm.css('display', 'none');
                }
                else {
                    self._inlineUploadForm.css('display', 'block');
                }
            }
            else {
                $('#'+ prefix + 'uploadImageButton').click();
            }
        });


        // append the hidden file upload form
        var form = this.createUploadImageForm(prefix);

        ViperUtil.insertAfter(urlField, urlRow);
        urlRow.appendChild(urlField);
        urlRow.appendChild(assetPicker);
        urlRow.appendChild(imageUploader);

        urlRow.appendChild(form);



        // append the choose location fields for image upload
        var locationFields = this.createChooseLocationFields(prefix);
        ViperUtil.insertAfter(urlRow, locationFields);

        
        // append the image upload progress bar
        var imageUploadProgressBar = this.createImageUploadProgressBar(prefix);
        var titleField = tools.getItem('vitpImagePlugin:titleInput').element;
        ViperUtil.insertAfter(titleField, imageUploadProgressBar);
        

        // reset progress bar and upload form when the plugin is displayed
        ViperUtil.addEvent($('#' + this.viper.getId() + '-vitpImage').get(0), 'mousedown', function(e) {
            // reset upload forms   
            self._uploadForm.get(0).reset();
            self._inlineUploadForm.get(0).reset();
            self._uploadForm.css('display', 'none');
            self._inlineUploadForm.css('display', 'none');

            // hide choose location fields
            $('.' + prefix + '-chooseLocationFields').css('display', 'none');     
            $('.uploadImage-progressIndicator').hide();
            
            // reset choose location fields
            tools.getItem(prefix + ':useCurrentLocation').setValue(false);
            tools.getItem(prefix + ':parentRootNode').setValue('');

            self._uploading = false;

            // if we click on a preview image, have to prepare uploading preview interface
            self._prepareDropppedImageUpload(prefix);

        });

    },


    createUploadImageForm: function(prefix)
    {
        var self = this;
        
        // the hidden file upload form
        var currentUrl = ViperUtil.baseUrl(window.location.href);
        var actionURL = currentUrl + '?SQ_ACTION=image_upload';
        var $form = $('<form id="'+ prefix + 'uploadImage" action="' + actionURL + '" style="display:none;" method="post" class="uploadImageForm" ></form>');
        if(prefix.indexOf('vitp') > -1) {
            this._inlineUploadForm = $form;
        }
        else {
            this._uploadForm = $form;
        }
        $form.append('<input id="'+ prefix + 'uploadImageButton" type="file" name="create_image_upload">');
        $form.append('<input type="hidden" name="create_root_node" value="">');
        $form.append('<input type="hidden" name="alt" value="">');
        $form.append('<input type="hidden" name="title" value="">');
        $form.append('<input type="hidden" name="token" value="">');
        $form.append('<input type="hidden" name="base64" value="">');
        $form.append('<input type="hidden" name="file_name" value="">');
        $form.append('<input type="hidden" name="image_preview_id" value="">');
        $form.append('<input type="button" id="'+ prefix + 'submit_file" style="display:none;" value="Upload File to Server">');


        // update preview from uploaded image
        $form.find('#'+ prefix + 'uploadImageButton').change(function(){
            var fileName = this.value;

            if(typeof fileName !== 'undefined' && fileName) {

                self.setUrlFieldValue('file://' + fileName);          

                // validate file type before sending it to Matrix
                var cleanFileName = fileName.replace(/^.*[\\\/]/, '');
                var isValid = /\.(jpe?g)|(gif)|(png)$/i.test(cleanFileName);
                if(!isValid) {
                    self.viper.ViperTools.setFieldErrors('ViperImagePlugin:urlInput', [_('Incorrect file type')]);
                    self.viper.ViperTools.setFieldErrors('vitpImagePlugin:urlInput', [_('Incorrect file type')]);
                    ViperUtil.setStyle(self._previewBox, 'display', 'none');
                    // disable the apply button
                    if(self.viper.ViperTools.getItem('ViperImagePlugin:bubbleSubSection-applyButton')) {
                        self.viper.ViperTools.disableButton('ViperImagePlugin:bubbleSubSection-applyButton');
                    }
                    if(self.viper.ViperTools.getItem('vitpImagePlugin-infoSubsection-applyButton')) {
                        self.viper.ViperTools.disableButton('vitpImagePlugin-infoSubsection-applyButton');
                    }
                    return;
                }


                // if File API is supported, load preview
                if (window.File && window.FileReader && this.files && this.files[0]) {
                    var reader = new FileReader();
                    self.setPreviewContent(false, true);
                    reader.readAsDataURL(this.files[0]);
                    var fileName = this.value;
                    reader.onload = function (e) {
                            var img = new Image();
                            img.src = e.target.result;
                            img.onload = function(){
                                // image  has been loaded, set it to preview (only works for File API supported browser, not ie8)
                                self.setPreviewContent(img, false);
                        };
                    }
                }

                // show choose location fields
                $('.' + prefix + '-chooseLocationFields').css('display', 'block');       

                // if the editable area does not belong to an asset, disable the choose current location option
                var editableElement = self.viper.getEditableElement();
                var idString = ViperUtil.$(editableElement).attr('id');
                var matches = idString.match(/_([0-9]+)/);
                if(matches == null) {
                     $('.' + prefix + '-chooseLocationFields').find('.Viper-checkbox').css('display', 'none'); 
                }
                else {
                     $('.' + prefix + '-chooseLocationFields').find('.Viper-checkbox').css('display', 'block'); 
                }

                // enable the location selector
                self.viper.ViperTools.getItem(prefix + ':parentRootNode').enable();
                // reseb the use current location checkbox
                self.viper.ViperTools.getItem(prefix + ':useCurrentLocation').setValue(false);



                // enable the apply button
                var button1 = self.viper.ViperTools.getItem('ViperImagePlugin:bubbleSubSection-applyButton');
                var button2 = self.viper.ViperTools.getItem('vitpImagePlugin-infoSubsection-applyButton');
                if(button1) {
                    $(button1.element).html(_('Upload Image'));
                    self.viper.ViperTools.enableButton('ViperImagePlugin:bubbleSubSection-applyButton');
                }
                if(button2) {
                    $(button2.element).html(_('Upload Image'));
                    self.viper.ViperTools.enableButton('vitpImagePlugin-infoSubsection-applyButton');
                }
            }
        });
        return $form[0];
    },



    createImageUploadProgressBar: function(prefix)
    {

        // Preview box to display image info and preview.
        $progressIndicator = $('<div id="' + prefix + '-progressIndicator" class="uploadImage-progressIndicator"></div>');
        $progressIndicator.append('<div class="uploadImage-progress-status"></div>');
        $progressIndicator.append('<div class="uploadImage-progress"><div class="uploadImage-progress-bar"><span class="uploadImage-progress-bar-inner" style="width: 0%;"></span></div></div>');
        $progressIndicator.append('<div class="uploadImage-progress-message"></div>');
        var self = this;

        var $bar = $progressIndicator.find('.progress-bar-inner');
        var $progress = $progressIndicator.find('.progress');
        var $status = $progressIndicator.find('.progress-status');
        var $message = $progressIndicator.find('.progress-message');

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
              $('.uploadImage-progress-status').show();
              $('.uploadImage-progressIndicator').show();
              if(ViperUtil.isBrowser('msie', '<10') !== true) {
                // old IE can't support upload progress
                $('.uploadImage-progress').show();
                $('.uploadImage-progress-bar-inner').show();
              }
              else {
                $('.uploadImage-progress').hide();
                $('.uploadImage-progress-bar-inner').hide();
              }
              $('.uploadImage-progress-status').html(_('Uploading image...'));
              $('.uploadImage-progress-message').hide();
              var percentVal = '2%';
              $('.uploadImage-progress-bar-inner').width(percentVal);
          },
          uploadProgress: function(event, position, total, percentComplete) {
              var percentVal = percentComplete + '%';
              $('.uploadImage-progress-bar-inner').width(percentVal);
          },
          complete: function(xhr) {
                var response = JSON.parse(xhr.responseText);
                self._uploading = false;

                // hide the upload form which was displayed for older IE
                if(ViperUtil.isBrowser('msie', '<10') === true) {
                    uploadForm.css('display', 'none');
                }

                if(response.error) {
                    $('.uploadImage-progress-status').hide();
                    $('.uploadImage-progress').hide();
                    $('.uploadImage-progress-bar-inner').width('0%');
                    $('.uploadImage-progress-message').html(response.error).show();

                    //reset the upload form
                    uploadForm.get(0).reset();

                   
                    // if it's a image preview, we have to locate the preview image and replace it
                    if(response.image_preview_id) {
                        self._setDroppedImageErrorStatus(response.image_preview_id, response.error);
                    }
                    else {
                        // no need to reset url field if it's a image preview to upload, user can just change file name in the url to try again
                        self.setUrlFieldValue('');
                    }

                }
                else {
                    // if upload is successful
                    // set the returned asset id
                    if(response.assetid) {

                        $('.uploadImage-progressIndicator').hide();
                        $('.uploadImage-progress-bar-inner').width('0%');


                        // hide choose location fields
                        $('.' + prefix + '-chooseLocationFields').css('display', 'none');     

                        //reset the upload form
                        uploadForm.get(0).reset();

                        // if it's a image preview, we have to locate the preview image and replace it
                        if(response.image_preview_id) {
                            self._replacePreviewWithOriginal(response.image_preview_id, response.assetid, response.alt, response.title);
                        }
                        else {
                            // otherwise just set the current selected image tag
                            self.setUrlFieldValue(response.assetid);
                            ViperImagePlugin.prototype._setImageAttributes.call(self, 'ViperImagePlugin');
                            ViperImagePlugin.prototype._setImageAttributes.call(self, 'vitpImagePlugin');
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
        var tools = this.viper.ViperTools;
        var self = this;
        var content = document.createElement('div');

        ViperUtil.addClass(content, prefix + '-chooseLocationFields');
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
            if(self.viper.ViperTools.getItem('ViperImagePlugin:bubbleSubSection-applyButton')) {
                self.viper.ViperTools.enableButton('ViperImagePlugin:bubbleSubSection-applyButton');
            }
            if(self.viper.ViperTools.getItem('vitpImagePlugin-infoSubsection-applyButton')) {
                self.viper.ViperTools.enableButton('vitpImagePlugin-infoSubsection-applyButton');
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



        return content;

    },


    updateImagePreview: function(url)
    {

        if (url.match(/^\.\/\?a=/)) {
            url = url.replace(/^\.\/\?a=/, '');
        }

        if (this._isInternalLink(url) === true) {
            var currentUrl = ViperUtil.baseUrl(window.location.href);
            currentUrl     = currentUrl.replace('/_edit', '');
            currentUrl += '?a=' + url;

            url = currentUrl;
        }

        // if it's a inline file upload, don't worry about it, it's already handled elsewhere
        if(url.indexOf("file://") === 0) {
            return;
        }

        this.setPreviewContent(false, true);
        var self = this;
        this._getImage(url, function(img) {
            self.setPreviewContent(img);
        });
    },

    setUrlFieldValue: function(url)
    {
        url = url.replace(/^\.\/\?a=/, '');

        // If there is a shadow asset, chop off the trailing "$"
        if ((url.indexOf(':') !== -1) && (url.substr((url.length - 1)) === '$')) {
                url = url.substr(0, (url.length - 1));
            }

        ViperImagePlugin.prototype.setUrlFieldValue.call(this, url);

    },

    getImageUrl: function(url)
    {
        url = ViperImagePlugin.prototype.getImageUrl.call(this, url);

        if (this._isInternalLink(url) === true) {
            url = './?a=' + url;

            // If this is a shadow asset, add the trailing "$"
            if (url.indexOf(':') !== -1) {
                url += '$';
            }
        }


        // don't worry about file:// url, it woudl be converted else where
        if (url.indexOf("file://") === 0) {
                 url = null;
        }

        return url;

    },


    _setImageAttributes: function(prefix)
    {
        var tools = this.viper.ViperTools;
        var url   = tools.getItem(prefix + ':urlInput').getValue();
        if(url == null) return;
        var matrixPrefix = null;
        var self = this;

        // if we are in the uploading process, don't submit the upload again
        // this prevents Viper setting extra onsubmit event to all forms in the plugin
        if(this._uploading) {
            return;
        }


        // start the upload process
        if (url.indexOf("file://") === 0) {
            var uploadForm = null;
            if(prefix.indexOf('vitp') > -1) {
                uploadForm = this._inlineUploadForm;
                matrixPrefix = 'vitpMatrixImagePlugin';

            }
            else {
                uploadForm = this._uploadForm;
                matrixPrefix = 'MatrixImagePlugin';

            }

            //let's just set the file name from what user inputs
            var filename = url.replace('file://', '');
            uploadForm.find('input[name=file_name]').val(filename);

            // if we are about to upload a dropped image preview
            // we need to set CSS class
            this._setDroppedImageUploadStatus();


            // set the selected parent root node location
            var selectedRootNode = tools.getItem(matrixPrefix + ':parentRootNode').getValue();
            var useCurrentLocation = tools.getItem(matrixPrefix + ':useCurrentLocation').getValue();
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
                    tools.getItem(matrixPrefix + ':useCurrentLocation').setValue(true);
                    uploadForm.find('input[name=create_root_node]').val(currentAssetid);
                }
            }

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
                    var token = $('#token').val();
                    if (token) {
                        uploadForm.find('input[name=token]').val(token);
                        this._uploading = true;
                        uploadForm.submit();
                    }
            }

        }
        else {
            ViperImagePlugin.prototype._setImageAttributes.call(this, prefix);
        }
    },

    
    pickAsset: function(idPrefix, forParentNode)
    {
    var tools       = this.viper.ViperTools;
    var urlField    = tools.getItem(idPrefix + ':urlInput'), altField    = tools.getItem(idPrefix + ':altInput');
    var parentNodeField    = tools.getItem(idPrefix + ':parentRootNode');

    // if it's for parent node seleciton, allow all types
    var allowedTypes = [];
    if(!forParentNode) {
        allowedTypes = ['image', 'thumbnail', 'image_variety'];
    }

   
        
    // if in Matrix backend mode
    if(typeof EasyEditAssetManager === 'undefined') {
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
                        alert(EasyEditLocalise.translate('You have selected a %1 asset. Only image, thumbnail or image variety assets can be selected.',selectedAsset.attribute('type_code')));
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
                }
            }
        });
        });
    }

    },

    
    isPluginElement: function(element)
    {
        var assetFinderOverlay = ViperUtil.getid('ees_assetFinderOverlay');
        if (element !== this._toolbar
            && ViperUtil.isChildOf(element, this._toolbar) === false
            && ViperUtil.isChildOf(element, assetFinderOverlay) === false
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
    
        img.src = url;
    
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
            preview_img.className = 'Viper-imagePaste';
            preview_img.id = 'Viper-imagePaster-' + (newLength - 1);
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
        $('.VipperDroppedImage-msgBox').remove();
        if(image && image.className && image.className.match(/(?:^|\s)Viper-imagePaste(?!\S)/)) {
            var id = image.id.split('-').pop();
            if(this.loadDroppedImageToUpload(id)) {
                // set base64 of original image
                this._inlineUploadForm.find('input[name=base64]').val(this.loadDroppedImageToUpload(id).src);
                this._uploadForm.find('input[name=base64]').val(this.loadDroppedImageToUpload(id).src);
                // set file name
                this._inlineUploadForm.find('input[name=file_name]').val(image.dataset.filename);
                this._uploadForm.find('input[name=file_name]').val(image.dataset.filename);
                // set the preview image id
                this._inlineUploadForm.find('input[name=image_preview_id]').val(image.id);
                this._uploadForm.find('input[name=image_preview_id]').val(image.id);
               
                this.viper.ViperTools.getItem('vitpImagePlugin:urlInput').setValue('file://' + image.dataset.filename);
                this.viper.ViperTools.getItem('ViperImagePlugin:urlInput').setValue('file://' + image.dataset.filename);
            
                // show choose upload location fields
                $('.' + prefix + '-chooseLocationFields').css('display', 'block');
                // chaneg the apply button text to 'upload image'
                var applyButton1 = this.viper.ViperTools.getItem('ViperImagePlugin:bubbleSubSection-applyButton');
                var applyButton2 = this.viper.ViperTools.getItem('vitpImagePlugin-infoSubsection-applyButton');
                $(applyButton1.element).html(_('Upload Image'));
                $(applyButton2.element).html(_('Upload Image'));

                // display previous upload error message
                var errorMessage = image.dataset.error;
                if(errorMessage) {
                    $('.uploadImage-progressIndicator').show();
                    $('.uploadImage-progress-status').hide();
                    $('.uploadImage-progress').hide();
                    $('.uploadImage-progress-message').html(errorMessage).show();
                }

                // display the warning message to ask user to create asset
                $('<div />', {
                    "class": 'VipperDroppedImage-msgBox',
                    }).html(_('Low resolution preview.') + '<br/>' + _('Upload the image to use it in content.')).insertBefore('.Viper-imageUploadRow');              

            }
        }
        else {
                // chaneg the apply button text  back to 'Apply Changes'
                var applyButton1 = this.viper.ViperTools.getItem('ViperImagePlugin:bubbleSubSection-applyButton');
                var applyButton2 = this.viper.ViperTools.getItem('vitpImagePlugin-infoSubsection-applyButton');
                $(applyButton1.element).html(_('Apply Changes'));
                $(applyButton2.element).html(_('Apply Changes'));

        }
    },

    _replacePreviewWithOriginal: function(previewId, assetId, alt, title) {
        var image = $('#' + previewId).get(0);
        if(image) {
            this.setImageURL(image, './?a=' + assetId);
            this.setImageAlt(image, alt);
            this.setImageTitle(image, title);
            $(image).removeClass('Viper-imagePaste');
            $(image).removeClass('imagePaste-loading');
            $(image).removeClass('imagePaste-error');
            $(image).removeAttr('id');
            $(image).removeAttr('data-filename');
            $(image).removeAttr('data-id');
        }
    },


    _setDroppedImageUploadStatus: function() {
        // is this a dropped in image preview?
        var image = this._resizeImage;
        if (ViperUtil.isBrowser('msie', '<11') === true) {
            image = this._ieImageResize;
        }
        if(image && image.className && image.className.match(/(?:^|\s)Viper-imagePaste(?!\S)/)) {
                $(image).removeClass('imagePaste-error');
                $(image).addClass('imagePaste-loading');
        }
    },



    _setDroppedImageErrorStatus: function(previewId, errorMessage) {
        var image = $('#' + previewId).get(0);
        if(image) {
            $(image).removeClass('imagePaste-loading');
            $(image).addClass('imagePaste-error');
            $(image).attr('data-error', errorMessage)
        }
    }

};
