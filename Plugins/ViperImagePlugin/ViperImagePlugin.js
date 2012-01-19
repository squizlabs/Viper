/**
 * JS Class for the ViperImagePlugin.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program as the file license.txt. If not, see
 * <http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt>
 *
 * @package    Viper
 * @author     Squiz Pty Ltd <products@squiz.net>
 * @copyright  2010 Squiz Pty Ltd (ACN 084 670 600)
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPLv2
 */
function ViperImagePlugin(viper)
{
    this.viper = viper;

}

ViperImagePlugin.prototype = {

    init: function()
    {
        this._initToolbar();

        var self = this;
        this.viper.registerCallback('Viper:mouseDown', 'ViperImagePlugin', function(e) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isTag(target, 'img') === true) {
                var range = self.viper.getViperRange();
                range.selectNode(target);
                ViperSelection.addRange(range);
                dfx.preventDefault(e);
                return false;
            }
        });

    },

    rangeToImage: function(range, url, alt)
    {
        if (!range || !url) {
            return;
        }

        range = range || this.viper.getViperRange();

        var bookmark = this.viper.createBookmark();

        var elems = dfx.getElementsBetween(bookmark.start, bookmark.end);
        for (var i = 0; i < elems.length; i++) {
            dfx.remove(elems[i]);
        }

        var img = document.createElement('img');
        img.setAttribute('src', url);

        if (alt) {
            img.setAttribute('alt', alt);
        }

        dfx.insertBefore(bookmark.start, img);

        this.viper.removeBookmark(bookmark);

        range.selectNode(img);
        ViperSelection.addRange(range);

        this.viper.fireSelectionChanged();
        this.viper.fireNodesChanged([this.viper.getViperElement()]);

        return img;

    },

    removeImage: function(image)
    {
        if (image && dfx.isTag(image, 'img') === true) {
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

            dfx.remove(image);

            var range = this.viper.getViperRange();
            range.setStart(node, start);
            range.collapse(true);
            ViperSelection.addRange(range);
        }
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

    _initToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        // Image var is updated when the updateToolbar event callback is called.
        var image = null;
        var self  = this;

        // Preview box to display image info and preview.
        var previewBox = document.createElement('div');
        dfx.addClass(previewBox, 'ViperITP-msgBox');
        dfx.setHtml(previewBox, 'Loading preview');
        dfx.setStyle(previewBox, 'display', 'none');

        var setImageAttributes = function(url, alt) {
            if (!image || dfx.isTag(image, 'img') === false) {
                image = self.rangeToImage(self.viper.getViperRange(), url, alt);
            } else {
                self.setImageURL(image, url);
                self.setImageAlt(image, alt);
            }
        };

        var setPreviewContent = function(img, loading) {
            dfx.setStyle(previewBox, 'display', 'block');

            if (loading === true) {
                dfx.removeClass(previewBox, 'info');
                dfx.setHtml(previewBox, 'Loading preview');
            } else if (!img) {
                // Failed to load image.
                dfx.addClass(previewBox, 'info');
                dfx.setHtml(previewBox, 'Failed to load image');
            } else {
                dfx.addClass(previewBox, 'info');

                var tmp = document.createElement('div');
                dfx.setStyle(tmp, 'visibility', 'hidden');
                dfx.setStyle(tmp, 'left', '-9999px');
                dfx.setStyle(tmp, 'top', '-9999px');
                dfx.setStyle(tmp, 'position', 'absolute');
                tmp.appendChild(img);
                document.body.appendChild(tmp);

                dfx.setStyle(img, 'width', '');
                dfx.setStyle(img, 'height', '');

                var width  = dfx.getElementWidth(img);
                var height = dfx.getElementHeight(img);
                dfx.remove(tmp);

                var maxWidth  = 300;
                var maxHeight = 300;
                if (height > maxHeight && width > maxWidth) {
                    if (height > width) {
                        img.setAttribute('height', '300px');
                    } else {
                        img.setAttribute('width', '300px');
                    }
                } else if (width > maxWidth) {
                    img.setAttribute('width', '300px');
                } else if (height > maxHeight) {
                    img.setAttribute('height', '300px');
                }

                dfx.empty(previewBox);
                dfx.setHtml(previewBox, width + 'px x ' + height + 'px<br/>');
                previewBox.appendChild(img);
            }//end if
        };

        var btnGroup = toolbar.createButtonGroup();

        // Create Image button and popup.
        var createImageSubContent = document.createElement('div');

        // URL text box.
        var urlTextbox = null;
        var url = toolbar.createTextbox('', 'URL', function(value) {
            setImageAttributes(value, (dfx.getTag('input', createImageSubContent)[1]).value);
        });
        createImageSubContent.appendChild(url);
        urlTextbox = (dfx.getTag('input', createImageSubContent)[0]);

        // Test URL.
        dfx.addEvent(urlTextbox, 'blur', function() {
            if (dfx.isBlank(dfx.trim(urlTextbox.value)) === true) {
                return;
            }

            // Show loading box.
            setPreviewContent(false, true);

            dfx.getImage(urlTextbox.value, function(img) {
                setPreviewContent(img);
            });
        });

        // Alt text box.
        var alt = toolbar.createTextbox('', 'Alt', function(value) {
            setImageAttributes(urlTextbox.value, value);
        });
        createImageSubContent.appendChild(alt);

        var createImageSubSection = toolbar.createSubSection(createImageSubContent, true);
        var imgTools = toolbar.createToolsPopup('Insert Image', null, [createImageSubSection], null, function() {
        });

        // Add the preview panel to the popup contents.
        createImageSubContent.appendChild(previewBox);

        var urlBtn = toolbar.createButton('', false, 'Toggle Image Options', false, 'image', null, btnGroup, imgTools);

        // Update the buttons when the toolbar updates it self.
        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperImagePlugin', function(data) {
            var range = data.range;
            image     = range.getNodeSelection();
            if (image && dfx.isTag(image, 'img') === true) {
                toolbar.setButtonActive(urlBtn);

                (dfx.getTag('input', createImageSubContent)[0]).value = image.getAttribute('src');
                (dfx.getTag('input', createImageSubContent)[1]).value = image.getAttribute('alt');

                // Update preview pane.
                dfx.empty(previewBox);
                setPreviewContent(image.cloneNode(true));
            } else {
                if (image) {
                    toolbar.disableButton(urlBtn);
                } else {
                    toolbar.enableButton(urlBtn);
                }

                toolbar.setButtonInactive(urlBtn);
                toolbar.closePopup(imgTools);

                (dfx.getTag('input', createImageSubContent)[0]).value = '';
                (dfx.getTag('input', createImageSubContent)[1]).value = '';

                // Update preview pane.
                dfx.empty(previewBox);
            }//end if
        });

    }

};
