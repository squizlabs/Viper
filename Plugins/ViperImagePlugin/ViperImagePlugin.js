function ViperImagePlugin(viper)
{
    this.viper = viper;

    this._previewBox       = null;
    this._resizeImage      = null;
    this._resizeWidgetElem = null;
    this._imageStyleAttr   = null;

}

ViperImagePlugin.prototype = {

    init: function()
    {
        this.initToolbar();

        var self = this;
        this.viper.registerCallback('Viper:mouseDown', 'ViperImagePlugin', function(e) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isTag(target, 'img') === true) {
                dfx.preventDefault(e);
                self.hideImageResizeHandles();
                self.showImageResizeHandles(target);
                self._updateToolbar(target);
                ViperSelection.removeAllRanges();
                return false;
            } else {
                self._updateToolbar();
                return self.hideImageResizeHandles(target);
            }
        });

        this.viper.registerCallback('Viper:keyDown', 'ViperImagePlugin', function(e) {
            if (e.which === 8 || e.which === 46) {
                if (self._resizeImage) {
                    if (self.removeImage(self._resizeImage) === true) {
                        self._updateToolbar();
                        return false;
                    }
                }

                var range        = self.viper.getViperRange();
                var selectedNode = range.getNodeSelection();
                if (selectedNode) {
                    if (self.removeImage(selectedNode) === true) {
                        self._updateToolbar();
                        return false;
                    }
                }
            }
        });

        this.viper.registerCallback('ViperHistoryManager:beforeUndo', 'ViperImagePlugin', function() {
            self.hideImageResizeHandles();
        });

    },

    rangeToImage: function(range, url, alt, title)
    {
        if (!range || !url) {
            return;
        }

        this._resizeImage = null;

        range = range || this.viper.getViperRange();
        var selectedNode = range.getNodeSelection();

        if (dfx.isBlockElement(selectedNode) === true) {
            dfx.setHtml(selectedNode, '&nbsp');
            range.setStart(selectedNode.firstChild, 0);
            range.collapse(true);
            ViperSelection.addRange(range);
        }

        var bookmark = this.viper.createBookmark();

        var elems = dfx.getElementsBetween(bookmark.start, bookmark.end);
        for (var i = 0; i < elems.length; i++) {
            dfx.remove(elems[i]);
        }

        var img = document.createElement('img');
        img.setAttribute('src', url);

        if (alt !== null) {
            img.setAttribute('alt', alt);
        }

        if (title !== null && dfx.trim(title).length !== 0) {
            img.setAttribute('title', title);
        }

        dfx.insertBefore(bookmark.start, img);

        this.viper.removeBookmark(bookmark);

        range.selectNode(img);
        ViperSelection.addRange(range);
        ViperSelection.removeAllRanges();

        this.viper.fireSelectionChanged();
        this.viper.fireNodesChanged([this.viper.getViperElement()]);

        return img;

    },

    removeImage: function(image)
    {
        if (image && dfx.isTag(image, 'img') === true) {
            this.hideImageResizeHandles();

            // If there are text nodes around then move the range to one of them,
            // else create a new text node and move the range to it.
            var node  = null;
            var start = 0;
            if (image.nextSibling && image.nextSibling.nodeType === dfx.TEXT_NODE) {
                node = image.nextSibling;
            } else if (image.previousSibling && image.previousSibling.nodeType === dfx.TEXT_NODE) {
                node  = image.previousSibling;
                start = node.data.length;
            } else {
                node = document.createTextNode(' ');
                dfx.insertAfter(image, node);
            }

            image.parentNode.removeChild(image);

            var range = this.viper.getViperRange();
            range.setStart(node, start);
            range.collapse(true);
            ViperSelection.addRange(range);

            if (this.viper.isBrowser('chrome') === true || this.viper.isBrowser('safari') === true) {
                this.viper.fireNodesChanged();
            }

            return true;
        }

        return false;
    },

    setImageAlt: function(image, alt)
    {
        if (!image) {
            return;
        }

        image.setAttribute('alt', alt);

    },

    setImageURL: function(image, url)
    {
        if (!image) {
            return;
        }

        image.setAttribute('src', url);

    },

    setImageTitle: function(image, title)
    {
        if (!image) {
            return;
        }

        image.setAttribute('title', title);

    },

    initToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        var self = this;

        // Preview box to display image info and preview.
        var previewBox = document.createElement('div');
        dfx.addClass(previewBox, 'ViperITP-msgBox');
        dfx.setHtml(previewBox, 'Loading preview');
        dfx.setStyle(previewBox, 'display', 'none');
        this._previewBox = previewBox;

        var tools = this.viper.ViperTools;

        var setImageAttributes = function() {
            var url   = tools.getItem('ViperImagePlugin:urlInput').getValue();
            var alt   = tools.getItem('ViperImagePlugin:altInput').getValue();
            var title = tools.getItem('ViperImagePlugin:titleInput').getValue();
            var pres  = tools.getItem('ViperImagePlugin:isPresentational').getValue();

            if (pres === true) {
                title = null;
                alt   = '';
            }

            if (!self._resizeImage || dfx.isTag(self._resizeImage, 'img') === false) {
                self.rangeToImage(self.viper.getViperRange(), self.getImageUrl(url), alt, title);
            } else {
                self.setImageURL(self._resizeImage, self.getImageUrl(url));
                self.setImageAlt(self._resizeImage, alt);
                self.setImageTitle(self._resizeImage, title);

                self.viper.fireNodesChanged([self._resizeImage]);
            }
        };

        // Create Image button and popup.
        var createImageSubContent = document.createElement('div');

        // URL text box.
        var urlTextbox = null;
        var url = tools.createTextbox('ViperImagePlugin:urlInput', 'URL', '', null, true);
        createImageSubContent.appendChild(url);
        urlTextbox = (dfx.getTag('input', createImageSubContent)[0]);

        // Test URL.
        var inputTimeout = null;
        this.viper.registerCallback('ViperTools:changed:ViperImagePlugin:urlInput', 'ViperLinkPlugin', function() {
            clearTimeout(inputTimeout);

            var url = dfx.trim(tools.getItem('ViperImagePlugin:urlInput').getValue());
            if (!url) {
                 dfx.setStyle(previewBox, 'display', 'none');
                 tools.setFieldErrors('ViperImagePlugin:urlInput', []);
            } else {
                // After a time period update the image preview.
                inputTimeout = setTimeout(function() {
                    self.updateImagePreview(url);
                }, 1000);
            }
        });

        // Presentational checkbox.
        var presentational = tools.createCheckbox('ViperImagePlugin:isPresentational', 'Image is presentational', false, function(presVal) {
            if (presVal === true) {
                tools.getItem('ViperImagePlugin:altInput').disable();
                tools.getItem('ViperImagePlugin:titleInput').disable();
                tools.getItem('ViperImagePlugin:altInput').setRequired(false);
            } else {
                tools.getItem('ViperImagePlugin:altInput').setRequired(true);
                tools.getItem('ViperImagePlugin:altInput').enable();
                tools.getItem('ViperImagePlugin:titleInput').enable();
            }
        });
        createImageSubContent.appendChild(presentational);

        // Alt text box.
        var alt = tools.createTextbox('ViperImagePlugin:altInput', 'Alt', '', null, true);
        createImageSubContent.appendChild(alt);

        // Title text box.
        var title = tools.createTextbox('ViperImagePlugin:titleInput', 'Title');
        createImageSubContent.appendChild(title);

        var imgTools = toolbar.createBubble('ViperImagePlugin:bubble', 'Insert Image', createImageSubContent);
        tools.getItem('ViperImagePlugin:bubble').setSubSectionAction('ViperImagePlugin:bubbleSubSection', function() {
            setImageAttributes();
        }, ['ViperImagePlugin:urlInput', 'ViperImagePlugin:altInput', 'ViperImagePlugin:titleInput', 'ViperImagePlugin:isPresentational']);

        // Add the preview panel to the popup contents.
        createImageSubContent.appendChild(previewBox);

        var toggleImagePlugin = tools.createButton('image', '', 'Toggle Image Options', 'image', null, true);
        toolbar.addButton(toggleImagePlugin);
        toolbar.setBubbleButton('ViperImagePlugin:bubble', 'image');

    },

    _updateToolbar: function(image)
    {
        var tools = this.viper.ViperTools;

        if (image && dfx.isTag(image, 'img') === true) {
            tools.setButtonActive('image');

            this.setUrlFieldValue(image.getAttribute('src'));
            tools.getItem('ViperImagePlugin:altInput').setValue(image.getAttribute('alt'));
            tools.getItem('ViperImagePlugin:titleInput').setValue(image.getAttribute('title'));

            if (!image.getAttribute('alt')) {
                tools.getItem('ViperImagePlugin:isPresentational').setValue(true);
            }

            // Update preview pane.
            dfx.empty(this._previewBox);
            this.updateImagePreview(image.getAttribute('src'));
        } else {
            tools.enableButton('image');

            tools.setButtonInactive('image');

            tools.getItem('ViperImagePlugin:isPresentational').setValue(false);
            tools.getItem('ViperImagePlugin:urlInput').setValue('');
            tools.getItem('ViperImagePlugin:altInput').setValue('');
            tools.getItem('ViperImagePlugin:titleInput').setValue('');
            tools.setFieldErrors('ViperImagePlugin:urlInput', []);

            // Update preview pane.
            dfx.empty(this._previewBox);
            dfx.setStyle(this._previewBox, 'display', 'none');
        }//end if

    },

    setUrlFieldValue: function(url)
    {
        this.viper.ViperTools.getItem('ViperImagePlugin:urlInput').setValue(url);

    },

    getImageUrl: function(url)
    {
        return url;

    },

    updateImagePreview: function(url)
    {
        this.setPreviewContent(false, true);
        var self = this;
        dfx.getImage(url, function(img) {
            self.setPreviewContent(img);
        });

    },

    setPreviewContent: function(img, loading)
    {
        var previewBox = this._previewBox;
        dfx.setStyle(previewBox, 'display', 'block');

        if (loading === true) {
            dfx.removeClass(previewBox, 'info');
            dfx.setHtml(previewBox, 'Loading preview');
            this.viper.ViperTools.setFieldErrors('ViperImagePlugin:urlInput', []);
        } else if (!img) {
            // Failed to load image.
            dfx.removeClass(previewBox, 'info');
            dfx.setStyle(previewBox, 'display', 'none');
            this.viper.ViperTools.setFieldErrors('ViperImagePlugin:urlInput', ['Failed to load image']);
        } else {
            this.viper.ViperTools.setFieldErrors('ViperImagePlugin:urlInput', []);
            dfx.addClass(previewBox, 'info');

            var tmp = document.createElement('div');
            dfx.setStyle(tmp, 'visibility', 'hidden');
            dfx.setStyle(tmp, 'left', '-9999px');
            dfx.setStyle(tmp, 'top', '-9999px');
            dfx.setStyle(tmp, 'position', 'absolute');
            tmp.appendChild(img);
            this.viper.addElement(tmp);

            dfx.setStyle(img, 'width', '');
            dfx.setStyle(img, 'height', '');

            var width  = dfx.getElementWidth(img);
            var height = dfx.getElementHeight(img);
            dfx.remove(tmp);

            var maxWidth  = 185;
            var maxHeight = 185;
            if (height > maxHeight && width > maxWidth) {
                if (height > width) {
                    img.setAttribute('height', maxHeight + 'px');
                } else {
                    img.setAttribute('width', maxWidth + 'px');
                }
            } else if (width > maxWidth) {
                img.setAttribute('width', maxWidth + 'px');
            } else if (height > maxHeight) {
                img.setAttribute('height', maxHeight + 'px');
            }

            dfx.empty(previewBox);
            dfx.setHtml(previewBox, width + 'px x ' + height + 'px<br/>');
            previewBox.appendChild(img);
        }//end if

    },

    showImageResizeHandles: function(image)
    {
        if (!image || !image.parentNode) {
            return;
        }

        if (this._resizeImage !== image) {
            this._imageStyleAttr = image.getAttribute('style');
        }

        var self = this;
        dfxjQuery(image).resizable({
            handles: 'se,sw',
            aspectRatio: true,
            stop: function() {
                self._fixImageResize();
                self.hideImageResizeHandles(image);
                self.viper.fireNodesChanged();
                self.showImageResizeHandles(image);
            },
            resize: function(e) {
                self._fixImageResize();
            }
        });

        this._resizeImage = image;

        var imageFloat = dfx.getStyle(image, 'float');

        this._resizeWidgetElem = dfxjQuery(image).resizable('widget').get(0);
        dfx.setStyle(this._resizeWidgetElem, 'position', 'relative');
        dfx.setStyle(this._resizeWidgetElem, 'display', 'inline-block');
        dfx.setStyle(this._resizeWidgetElem, 'float', imageFloat);
        dfx.setStyle(this._resizeWidgetElem, 'width', 'auto');
        dfx.setStyle(this._resizeWidgetElem, 'height', 'auto');
        dfx.setStyle(this._resizeWidgetElem, 'overflow', '');

    },

    hideImageResizeHandles: function(elem)
    {
        if (!this._resizeImage) {
            return;
        }

        if (elem && elem.nodeType === dfx.ELEMENT_NODE) {
            if (this._resizeWidgetElem === elem || dfx.isChildOf(elem, this._resizeWidgetElem)) {
                return false;
            }
        }

        var width  = dfx.getStyle(this._resizeImage, 'width');
        var height = dfx.getStyle(this._resizeImage, 'height');

        dfxjQuery(this._resizeImage).resizable('destroy');

        if (!this._resizeImage.className) {
            this._resizeImage.removeAttribute('class');
        }

        this._resizeImage.setAttribute('style', this._imageStyleAttr);

        // Fix jQuery fails.
        dfx.setStyle(this._resizeImage, 'width', width);
        dfx.setStyle(this._resizeImage, 'height', height);
        this._fixImageResize();
        this._resizeImage = null;

    },

    _fixImageResize: function()
    {
        dfx.setStyle(this._resizeImage, 'display', '');
        dfx.setStyle(this._resizeImage, 'left', '');
        dfx.setStyle(this._resizeImage, 'top', '');
        dfx.setStyle(this._resizeImage, 'resize', '');
        dfx.setStyle(this._resizeImage, 'position', '');

        if (this._resizeWidgetElem) {
            dfx.setStyle(this._resizeWidgetElem, 'left', '');
            dfx.setStyle(this._resizeWidgetElem, 'top', '');
            dfx.setStyle(this._resizeWidgetElem, 'overflow', '');
        }

    }

};
