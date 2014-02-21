/**
 * +--------------------------------------------------------------------+
 * | This Squiz Viper file is Copyright (c) Squiz Australia Pty Ltd     |
 * | ABN 53 131 581 247                                                 |
 * +--------------------------------------------------------------------+
 * | IMPORTANT: Your use of this Software is subject to the terms of    |
 * | the Licence provided in the file licence.txt. If you cannot find   |
 * | this file please contact Squiz (www.squiz.com.au) so we may        |
 * | provide you a copy.                                                |
 * +--------------------------------------------------------------------+
 *
 */

function ViperImagePlugin(viper)
{
    this.viper = viper;

    this._previewBox    = null;
    this._resizeImage   = null;
    this._ieImageResize = null;
    this._resizeHandles = null;
    this._inlineToolbar = null;
    this._moveImage     = null;

    this._initInlineToolbar();

}

ViperImagePlugin.prototype = {

    init: function()
    {
        this.initTopToolbar();

        var self = this;
        this.viper.registerCallback('Viper:mouseDown', 'ViperImagePlugin', function(e) {
            var target = ViperUtil.getMouseEventTarget(e);
            self._ieImageResize = null;

            if (ViperUtil.isTag(target, 'img') === true) {
                ViperUtil.preventDefault(e);
                self.hideImageResizeHandles();
                self.showImageResizeHandles(target);
                self._cancelMove();
                self._updateToolbars(target);

                var range = self.viper.getViperRange();
                range.selectNode(target);
                ViperSelection.addRange(range);
                self.viper.fireSelectionChanged(range, true);
                ViperSelection.removeAllRanges();

                if (self.viper.isBrowser('msie', '<11') === true && ViperUtil.isTag(target, 'img') === true) {
                    self._ieImageResize = target;
                    self.viper.registerCallback('Viper:mouseUp', 'ViperImagePlugin:ie', function(e) {
                       ViperSelection.removeAllRanges();
                       var range = self.viper.getCurrentRange();
                       if (!target.nextSibling || target.nextSibling.nodeType !== ViperUtil.TEXT_NODE) {
                           var textNode = document.createTextNode('');
                           ViperUtil.insertAfter(target, textNode);
                       }

                       range.setStart(target.nextSibling, 0);
                       range.collapse(true);
                       ViperSelection.addRange(range);

                       ViperUtil.preventDefault(e);
                       self.viper.removeCallback('Viper:mouseUp', 'ViperImagePlugin:ie');
                       ViperSelection.removeAllRanges();
                       return false;
                    });
                }

                // Enable toolbar if its not already due to event cancelation.
                var toolbar = self.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
                if (toolbar && toolbar.isDisabled() === true) {
                    toolbar.enable();
                }

                return false;
            } else {
                self._updateToolbars();
                return self.hideImageResizeHandles(target);
            }
        });

        this.viper.registerCallback('Viper:keyDown', 'ViperImagePlugin', function(e) {
            if (e.which === 8 || e.which === 46) {
                if (self._resizeImage) {
                    if (self.removeImage(self._resizeImage) === true) {
                        self._updateToolbars();
                        self._inlineToolbar.hide();
                        return false;
                    }
                }

                if (self._ieImageResize) {
                    ViperUtil.remove(self._ieImageResize);
                    self._ieImageResize = null;
                    self.viper.fireNodesChanged();
                    return false;
                } else {
                    var range        = self.viper.getViperRange();
                    var selectedNode = range.getNodeSelection();
                    if (selectedNode) {
                        if (self.removeImage(selectedNode) === true) {
                            self._updateToolbars();
                            return false;
                        }
                    }
                }
            }
        });

        this.viper.registerCallback('Viper:getHtml', 'ViperImagePlugin', function(data) {
            var tags = ViperUtil.getClass('ui-resizable', data.element);
            for (var i = 0; i < tags.length; i++) {
                var parent = tags[i].parentNode;
                ViperUtil.removeClass(tags[i], 'ui-resizable');
                ViperUtil.insertBefore(parent, tags[i]);
                self.hideImageResizeHandles(tags[i]);
                ViperUtil.remove(parent);

                // Remove empty style and class attributes.
                if (!tags[i].getAttribute('style')) {
                    tags[i].removeAttribute('style');
                }

                if (!tags[i].getAttribute('class')) {
                    tags[i].removeAttribute('class');
                }
            }
        });

        this.viper.registerCallback('ViperToolbarPlugin:enabled', 'ViperImagePlugin', function(data) {
            self.viper.ViperTools.enableButton('image');
        });

        this.viper.registerCallback('ViperCoreStylesPlugin:afterImageUpdate', 'ViperImagePlugin', function(image) {
            self.showImageResizeHandles(image);
        });

        this.viper.registerCallback(
            ['ViperHistoryManager:beforeUndo', 'Viper:clickedOutside', 'ViperTools:popup:open', 'ViperCoreStylesPlugin:beforeImageUpdate'],
            'ViperImagePlugin',
            function() {
                self.hideImageResizeHandles();
            }
        );

    },

    moveImage: function(image, range)
    {
        if (!range || !image) {
            return;
        }

        return this._rangeToImage(range, image);
    },

    rangeToImage: function(range, url, alt, title)
    {
        if (!range || !url) {
            return;
        }

        return this._rangeToImage(range, null, url, alt, title);

    },

    _rangeToImage: function(range, img, url, alt, title)
    {
        this._resizeImage = null;

        range = range || this.viper.getViperRange();
        var selectedNode = range.getNodeSelection();

        if (ViperUtil.isBlockElement(selectedNode) === true) {
            ViperUtil.setHtml(selectedNode, '&nbsp');
            range.setStart(selectedNode.firstChild, 0);
            range.collapse(true);
            ViperSelection.addRange(range);
        }

        var bookmark = this.viper.createBookmark();

        var elems = ViperUtil.getElementsBetween(bookmark.start, bookmark.end);
        for (var i = 0; i < elems.length; i++) {
            ViperUtil.remove(elems[i]);
        }

        if (!img) {
            img = document.createElement('img');
            img.setAttribute('src', url);

            if (alt !== null) {
                img.setAttribute('alt', alt);
            }

            if (title !== null && ViperUtil.trim(title).length !== 0) {
                img.setAttribute('title', title);
            }
        }

        ViperUtil.insertBefore(bookmark.start, img);

        this.viper.removeBookmark(bookmark);

        ViperSelection.removeAllRanges();

        this.viper.fireSelectionChanged();
        this.viper.fireNodesChanged([this.viper.getViperElement()]);

        return img;

    },

    removeImage: function(image)
    {
        if (image && ViperUtil.isTag(image, 'img') === true) {
            this.hideImageResizeHandles();

            // If there are text nodes around then move the range to one of them,
            // else create a new text node and move the range to it.
            var node  = null;
            var start = 0;
            if (image.nextSibling && image.nextSibling.nodeType === ViperUtil.TEXT_NODE) {
                node = image.nextSibling;
            } else if (image.previousSibling && image.previousSibling.nodeType === ViperUtil.TEXT_NODE) {
                node  = image.previousSibling;
                start = node.data.length;
            } else if (image.parentNode && ViperUtil.isTag(image.parentNode, 'a') === true) {
                if (image.parentNode.nextSibling && image.parentNode.nextSibling.nodeType === ViperUtil.TEXT_NODE) {
                    node = image.parentNode.nextSibling;
                } else if (image.parentNode.previousSibling && image.parentNode.previousSibling.nodeType === ViperUtil.TEXT_NODE) {
                    node = image.parentNode.previousSibling;
                    start = image.parentNode.previousSibling.data.length;
                } else {
                    node = document.createTextNode(' ');
                    ViperUtil.insertAfter(image.parentNode, node);
                }

                ViperUtil.remove(image.parentNode);
            } else {
                node = document.createTextNode(' ');
                ViperUtil.insertAfter(image, node);
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
        } else if (title === null) {
            image.removeAttribute('title');
        } else {
            image.setAttribute('title', title);
        }

    },

    initTopToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        // Preview box to display image info and preview.
        var previewBox = document.createElement('div');
        ViperUtil.addClass(previewBox, 'ViperITP-msgBox');
        ViperUtil.setHtml(previewBox, 'Loading preview');
        ViperUtil.setStyle(previewBox, 'display', 'none');
        this._previewBox = previewBox;

        var self       = this;
        var tools      = this.viper.ViperTools;
        var subContent = this._getToolbarContents('ViperImagePlugin');

        var imgTools = toolbar.createBubble('ViperImagePlugin:bubble', _('Insert Image'), subContent);
        tools.getItem('ViperImagePlugin:bubble').setSubSectionAction('ViperImagePlugin:bubbleSubSection', function() {
            self._setImageAttributes('ViperImagePlugin');
        }, ['ViperImagePlugin:urlInput', 'ViperImagePlugin:altInput', 'ViperImagePlugin:titleInput', 'ViperImagePlugin:isDecorative']);

        // Add the preview panel to the popup contents.
        subContent.appendChild(previewBox);

        var toggleImagePlugin = tools.createButton('image', '', _('Toggle Image Options'), 'Viper-image', null, true);
        toolbar.addButton(toggleImagePlugin);
        toolbar.setBubbleButton('ViperImagePlugin:bubble', 'image');
    },

    _getToolbarContents: function(prefix)
    {
        var self  = this;
        var tools = this.viper.ViperTools;

        // Create Image button and popup.
        var createImageSubContent = document.createElement('div');

        // URL text box.
        var urlTextbox = null;
        var url = tools.createTextbox(prefix + ':urlInput', _('URL'), '', null, true);
        createImageSubContent.appendChild(url);
        urlTextbox = (ViperUtil.getTag('input', createImageSubContent)[0]);

        // Test URL.
        var inputTimeout = null;
        this.viper.registerCallback('ViperTools:changed:' + prefix + ':urlInput', 'ViperImagePlugin', function() {
            clearTimeout(inputTimeout);

            var url = ViperUtil.trim(tools.getItem('ViperImagePlugin:urlInput').getValue());
            if (!url) {
                 ViperUtil.setStyle(self._previewBox, 'display', 'none');
                 tools.setFieldErrors(prefix + ':urlInput', []);
            } else {
                // After a time period update the image preview.
                inputTimeout = setTimeout(function() {
                    self.updateImagePreview(url);
                }, 1000);
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

    _setImageAttributes: function(prefix)
    {
        var tools = this.viper.ViperTools;
        var url   = tools.getItem(prefix + ':urlInput').getValue();
        var alt   = tools.getItem(prefix + ':altInput').getValue();
        var title = tools.getItem(prefix + ':titleInput').getValue();
        var pres  = tools.getItem(prefix + ':isDecorative').getValue();

        if (pres === true) {
            title = null;
            alt   = '';
        } else if (title === '') {
            title = null;
        }

        var image = this._resizeImage;
        if (this.viper.isBrowser('msie', '<11') === true) {
            image = this._ieImageResize;
        }

        if (!image || ViperUtil.isTag(image, 'img') === false) {
            image = this.rangeToImage(this.viper.getViperRange(), this.getImageUrl(url), alt, title);
        } else {
            this.setImageURL(image, this.getImageUrl(url));
            this.setImageAlt(image, alt);
            this.setImageTitle(image, title);

            this.viper.fireNodesChanged([image]);
        }

        this._updateToolbars(image);
        this.showImageResizeHandles(image);

    },

    _updateToolbars: function(image)
    {
        this._updateToolbar(image, 'ViperImagePlugin');
        this._updateToolbar(image, 'vitpImagePlugin');

    },

    _updateToolbar: function(image, toolbarPrefix)
    {
        var tools = this.viper.ViperTools;

        if (image && ViperUtil.isTag(image, 'img') === true) {

            tools.setButtonActive('image');

            this.setUrlFieldValue(image.getAttribute('src'));
            tools.getItem(toolbarPrefix + ':altInput').setValue(image.getAttribute('alt') || '');
            tools.getItem(toolbarPrefix + ':titleInput').setValue(image.getAttribute('title') || '');

            if (!image.getAttribute('alt')) {
                tools.getItem(toolbarPrefix + ':isDecorative').setValue(true);
            } else {
                tools.getItem(toolbarPrefix + ':isDecorative').setValue(false);
            }

            // Update preview pane.
            ViperUtil.empty(this._previewBox);
            this.updateImagePreview(image.getAttribute('src'));
        } else {
            tools.enableButton('image');
            tools.setButtonInactive('image');

            tools.getItem(toolbarPrefix + ':isDecorative').setValue(false);
            tools.getItem(toolbarPrefix + ':urlInput').setValue('');
            tools.getItem(toolbarPrefix + ':altInput').setValue('');
            tools.getItem(toolbarPrefix + ':titleInput').setValue('');
            tools.setFieldErrors(toolbarPrefix + ':urlInput', []);

            // Update preview pane.
            ViperUtil.empty(this._previewBox);
            ViperUtil.setStyle(this._previewBox, 'display', 'none');
        }//end if

    },


    _initInlineToolbar: function()
    {
        var self = this;
        this.viper.registerCallback('ViperInlineToolbarPlugin:initToolbar', 'ViperImagePlugin', function(toolbar) {
            self.createInlineToolbar(toolbar);
        });

        this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperImagePlugin', function(data) {
            self._updateInlineToolbar(data);
        });

    },

    createInlineToolbar: function(toolbar)
    {
        var self       = this;
        var tools      = this.viper.ViperTools;
        var moveButton = null;
        var image      = null;
        var idPrefix   = 'vitpImagePlugin';

        this._inlineToolbar = toolbar;

        // Create a tooltip that will be shown when the image move icon is clicked.
        tools.createToolTip('ViperImageToolbar-tooltip', _('The selected image will be moved to the next location you click. To cancel press the move icon again or ESC'), 'mouse');

        // Image Details.
        var subContent = this._getToolbarContents(idPrefix);
        toolbar.makeSubSection(idPrefix + '-infoSubsection', subContent);
        var imageButton = tools.createButton('vitpImage', '', _('Toggle Image Options'), 'Viper-image', null);
        toolbar.setSubSectionButton('vitpImage', idPrefix + '-infoSubsection');
        toolbar.setSubSectionAction(idPrefix + '-infoSubsection', function() {
            self._setImageAttributes(idPrefix);
        }, [idPrefix + ':urlInput', idPrefix + ':altInput', idPrefix + ':titleInput', idPrefix + ':isDecorative']);

        // Image Move.
        moveButton  = tools.createButton('vitpImageMove', '', _('Move Image'), 'Viper-move', function() {
            self._moveImage = self._resizeImage;

            if (ViperUtil.hasClass(moveButton, 'Viper-selected') === true) {
                self._cancelMove();
                return;
            }

            ViperUtil.addClass(moveButton, 'Viper-selected');

            // Show the tooltip under the mouse pointer.
            tools.getItem('ViperImageToolbar-tooltip').show();

            // When mouse is clicked in content move the image to that selection range.
            self.viper.registerCallback('Viper:mouseUp', 'ViperImagePlugin:move', function(e) {
                var imageElement = self._moveImage;
                self._cancelMove();

                var clickTarget = ViperUtil.getMouseEventTarget(e);
                if (clickTarget) {
                    if (ViperUtil.isTag(clickTarget, 'img') === true
                        || self.viper.isOutOfBounds(clickTarget) === true
                    ) {
                        return;
                    }
                }

                var range = self.viper.getViperRange();
                if (self.viper.rangeInViperBounds(range) === false) {
                    return;
                }

                self.moveImage(imageElement, range);

                range.selectNode(imageElement);
                ViperSelection.addRange(range);
                ViperSelection.removeAllRanges();

                // Show the image resize handles and the toolbar.
                self.showImageResizeHandles(imageElement);
                toolbar.update(null, imageElement);
                self._updateToolbars(imageElement);

                self._moveImage = null;

                return false;
            });

            // If ESC key is pressed cancel the image move.
            ViperUtil.addEvent(document, 'keydown.ViperImagePlugin:move', function(e) {
                if (e.which === 27) {
                    self._cancelMove();
                }
            });
        });

        var buttonGroup = tools.createButtonGroup('vitpImageBtnGroup');
        buttonGroup.appendChild(imageButton);
        buttonGroup.appendChild(moveButton);

        toolbar.addButton(buttonGroup);

    },

    _updateInlineToolbar: function(data)
    {
        var nodeSelection = data.nodeSelection || data.range.getNodeSelection();

        this.hideImageResizeHandles();
        if (nodeSelection && ViperUtil.isTag(nodeSelection, 'img') === true) {
            this._resizeImage = nodeSelection;
            data.toolbar.showButton('vitpImage');
            data.toolbar.showButton('vitpImageMove');

            this.viper.ViperTools.setButtonActive('vitpImage');

            this.showImageResizeHandles(nodeSelection);
            this._updateToolbars(nodeSelection);
            ViperSelection.removeAllRanges();
        }

    },

    _cancelMove: function()
    {
        // Cancel method that is called when image is moved or move event is canceled.
        // It will remove callback methods, change toolbar button statuses etc.
        this.viper.ViperTools.getItem('ViperImageToolbar-tooltip').hide();
        this.viper.removeCallback('Viper:mouseUp', 'ViperImagePlugin:move');
        ViperUtil.removeEvent(document, 'keydown.ViperImagePlugin:move');
        ViperUtil.removeClass(this.viper.ViperTools.getItem('vitpImageMove').element, 'Viper-selected');

        this._moveImage = null;

    },

    setUrlFieldValue: function(url)
    {
        this.viper.ViperTools.getItem('ViperImagePlugin:urlInput').setValue(url);
        this.viper.ViperTools.getItem('vitpImagePlugin:urlInput').setValue(url);

    },

    getImageUrl: function(url)
    {
        return url;

    },

    updateImagePreview: function(url)
    {
        var self = this;
        this.setPreviewContent(false, true);
        this.loadImage(url, function(img) {
            self.setPreviewContent(img);
        });

    },

    loadImage: function(url, callback)
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

    setPreviewContent: function(img, loading)
    {
        var previewBox = this._previewBox;
        ViperUtil.setStyle(previewBox, 'display', 'block');

        if (loading === true) {
            ViperUtil.removeClass(previewBox, 'Viper-info');
            ViperUtil.setHtml(previewBox, _('Loading preview'));
            this.viper.ViperTools.setFieldErrors('ViperImagePlugin:urlInput', []);
        } else if (!img) {
            // Failed to load image.
            ViperUtil.removeClass(previewBox, 'Viper-info');
            ViperUtil.setStyle(previewBox, 'display', 'none');
            this.viper.ViperTools.setFieldErrors('ViperImagePlugin:urlInput', [_('Failed to load image')]);
        } else {
            this.viper.ViperTools.setFieldErrors('ViperImagePlugin:urlInput', []);
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

            ViperUtil.empty(previewBox);
            ViperUtil.setHtml(previewBox, width + 'px x ' + height + 'px<br/>');
            previewBox.appendChild(img);
        }//end if

    },

    showImageResizeHandles: function(image)
    {
        this.hideImageResizeHandles();

        var seHandle = document.createElement('div');
        ViperUtil.addClass(seHandle, 'Viper-image-handle Viper-image-handle-se');

        var swHandle = document.createElement('div');
        ViperUtil.addClass(swHandle, 'Viper-image-handle Viper-image-handle-sw');

        var rect   = ViperUtil.getBoundingRectangle(image);
        var offset = this.viper.getDocumentOffset();
        rect.x1 += offset.x;
        rect.x2 += offset.x;
        rect.y1 += offset.y;
        rect.y2 += offset.y;

        // Set the position of handles.
        ViperUtil.setStyle(swHandle, 'left', rect.x1 + 'px');
        ViperUtil.setStyle(swHandle, 'top', (rect.y2) + 'px');

        ViperUtil.setStyle(seHandle, 'left', (rect.x2) + 'px');
        ViperUtil.setStyle(seHandle, 'top', (rect.y2) + 'px');

        this.viper.addElement(seHandle);
        this.viper.addElement(swHandle);

        this._resizeHandles = [];
        this._resizeHandles.push(seHandle);
        this._resizeHandles.push(swHandle);

        this._resizeImage = image;

        var self = this;

        var _addMouseEvents = function(handle, rev) {
            ViperUtil.addEvent(handle, 'mousedown', function(e) {
                var width    = image.clientWidth;
                var height   = image.clientHeight;
                var prevPosX = e.clientX - offset.x;
                var prevPosY = e.clientY - offset.y;
                var resized  = false;
                var both     = e.shiftKey;
                var ratio    = (height / width);

                image.setAttribute('width', width);
                image.setAttribute('height', height);
                ViperUtil.setStyle(image, 'width', '');
                ViperUtil.setStyle(image, 'height', '');

                self._inlineToolbar.hide();

                ViperUtil.addEvent(Viper.document, 'mousemove.ViperImageResize', function(e) {
                    var wDiff = (e.clientX - prevPosX);
                    var hDiff = (e.clientY - prevPosY);
                    prevPosX  = e.clientX;
                    prevPosY  = e.clientY;
                    resized   = true;

                    if (rev !== true) {
                        width += wDiff;
                    } else {
                        width -= wDiff;
                    }

                    image.setAttribute('width', width);

                    if (both === true) {
                        height += hDiff;
                        image.setAttribute('height', parseInt(height));
                    } else {
                        image.setAttribute('height', parseInt(width * ratio));
                    }

                    var rect = ViperUtil.getBoundingRectangle(image);
                    ViperUtil.setStyle(seHandle, 'left', (rect.x2 + offset.x) + 'px');
                    ViperUtil.setStyle(seHandle, 'top', (rect.y2 + offset.y) + 'px');

                    ViperUtil.setStyle(swHandle, 'left', (rect.x1 + offset.x) + 'px');
                    ViperUtil.setStyle(swHandle, 'top', (rect.y2 + offset.y) + 'px');

                    ViperUtil.preventDefault(e);
                    return false;
                });

                // Remove mousemove event.
                ViperUtil.addEvent(Viper.document, 'mouseup.ViperImageResize', function(e) {
                    ViperUtil.removeEvent(Viper.document, 'mousemove.ViperImageResize');
                    ViperUtil.removeEvent(Viper.document, 'mouseup.ViperImageResize');

                    // If the style attribute is empty, remove it.
                    if (!image.getAttribute('style')) {
                        image.removeAttribute('style');
                    }

                    if (resized === true) {
                        self.viper.fireNodesChanged();
                    }

                    // Show the image toolbar.
                    self._updateToolbars(image);

                    self._inlineToolbar.update(null, image);

                });

                ViperUtil.preventDefault(e);
                return false;
            });
        };

        _addMouseEvents(seHandle);
        _addMouseEvents(swHandle, true);

    },

    hideImageResizeHandles: function(elem)
    {
        if (this._resizeHandles) {
            ViperUtil.remove(this._resizeHandles);
            this._resizeHandles = null;
            this._inlineToolbar.hide();
            this._updateToolbars();
        }

        this._resizeImage = null;

    }

};
