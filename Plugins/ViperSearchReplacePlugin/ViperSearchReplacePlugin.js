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

function ViperSearchReplacePlugin(viper)
{
    this.viper       = viper;
    this._matchCount = 0;
    this._finding = false;

}

ViperSearchReplacePlugin.prototype = {

    init: function()
    {
        this._initToolbar();

        if (ViperUtil.isBrowser('msie') === true) {
            var self = this;
            this.viper.registerCallback('Viper:viperElementFocused', 'ViperSearchReplacePlugin', function() {
                if (self._finding === true) {
                    // Prevent focus events firing as it causes the selection to be
                    // lost during searching (IE only)...
                    return false;
                }
            });
        }

    },

    _initToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        var self  = this;
        var tools = this.viper.ViperTools;

        this.viper.registerCallback('ViperToolbarPlugin:enabled', 'ViperSearchReplacePlugin', function(data) {
            self.viper.ViperTools.enableButton('searchReplace');
        });

        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperSearchReplacePlugin', function(data) {
            self.viper.ViperTools.enableButton('searchReplace');
        });

        // Create Search and replace button and popup.
        var content = document.createElement('div');

        // Search text box.
        var search = tools.createTextbox('ViperSearchPlugin:searchInput', _('Search'), '', function(value) {
            var found = self.find(value);
            if (found !== true) {
                self._matchCount = 0;
            }

            self._updateButtonStates(found);
        });
        tools.setFieldEvent('ViperSearchPlugin:searchInput', 'keyup', function() {
            if (tools.getItem('ViperSearchPlugin:searchInput').getValue()) {
                tools.enableButton('ViperSearchPlugin:findNext');
            } else {
                tools.disableButton('ViperSearchPlugin:findNext');
            }
        });
        content.appendChild(search);

        // Replace text box.
        var replace = tools.createTextbox('ViperSearchPlugin:replaceInput', _('Replace'), '', function(value) {
            var search = tools.getItem('ViperSearchPlugin:searchInput').getValue();
            self.getNumberOfMatches(search);
            self.find(search, false, true);

            self._updateButtonStates();
        });
        content.appendChild(replace);

        var replaceAllBtn = tools.createButton('ViperSearchPlugin:replaceAll', _('Replace All'), _('Replace All'), 'Viper-replaceAll', function() {
            var replaceCount = 0;
            var fromStart    = true;
            while (self.find(tools.getItem('ViperSearchPlugin:searchInput').getValue(), false, fromStart) === true) {
                fromStart = false;
                self.replace(tools.getItem('ViperSearchPlugin:replaceInput').getValue());
                replaceCount++;
            }

            self._matchCount = 0;
            self._updateButtonStates();
            self.viper.fireNodesChanged();
        }, true);
        var replaceBtn = tools.createButton('ViperSearchPlugin:replace', _('Replace'), _('Replace'), 'Viper-replaceText', function() {
            self.replace(tools.getItem('ViperSearchPlugin:replaceInput').getValue());
            self._updateButtonStates();
            self.viper.fireNodesChanged();
        }, true);
        content.appendChild(replaceAllBtn);
        content.appendChild(replaceBtn);

        var findNext = tools.createButton('ViperSearchPlugin:findNext', _('Find Next'), _('Find Next'), '', function() {
            // Find again.
            var found = self.find(tools.getItem('ViperSearchPlugin:searchInput').getValue());
            if (found !== true) {
                // Try from top.
                self.getNumberOfMatches(tools.getItem('ViperSearchPlugin:searchInput').getValue());
                if (self._matchCount > 0) {
                    found = self.find(tools.getItem('ViperSearchPlugin:searchInput').getValue(), false, true);
                    if (found !== true) {
                        self._matchCount = 0;
                    }
                }
            }

            self._updateButtonStates(found);
            return false;
        }, true);
        content.appendChild(findNext);

        // Create the bubble.
        var searchTools = toolbar.createBubble('ViperSearchPlugin:bubble', _('Search & Replace'), content, null, function() {
            self._matchCount = 0;
            self._updateButtonStates(false);
        });
        var searchBtn   = tools.createButton('searchReplace', '', _('Search & Replace'), 'Viper-searchReplace', null, true);
        toolbar.addButton(searchBtn);
        toolbar.setBubbleButton('ViperSearchPlugin:bubble', 'searchReplace');

        // Update the buttons when the toolbar updates it self.
        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperSearchReplacePlugin', null);

    },

    _updateButtonStates: function(hasResult)
    {
        var self  = this;
        var tools = this.viper.ViperTools;

        var enableReplace = true;
        if (hasResult !== true && this._matchCount === 0) {
            enableReplace = false;
        }

        // These selection during these find calls may jump in to other containers
        // so clone the current selection so that we can select it again.
        var clone = this.viper.getCurrentRange();
        if (enableReplace === true) {
            tools.enableButton('ViperSearchPlugin:replace');
            tools.enableButton('ViperSearchPlugin:replaceAll');
        } else {
            tools.disableButton('ViperSearchPlugin:replace');
            tools.disableButton('ViperSearchPlugin:replaceAll');
        }

        // Fix to remove the selection from textbox.
        var val = tools.getItem('ViperSearchPlugin:searchInput').getValue();
        tools.getItem('ViperSearchPlugin:searchInput').setValue('');
        tools.getItem('ViperSearchPlugin:searchInput').setValue(val);

        // Select the original range.
        ViperSelection.addRange(clone);
        this.viper.focus();

    },

    getNumberOfMatches: function(text)
    {
        this._matchCount = 0;
        var fromStart = true;
        while (this.find(text, false, fromStart) === true) {
            this._matchCount++;
            fromStart = false;
        }

        return this._matchCount;

    },

    find: function(text, backward, fromStart, testOnly)
    {
        var element = this.viper.getViperElement();
        if (!text || !element) {
            return;
        }

        var rangeClone = null;
        if (testOnly) {
            rangeClone = this.viper.getCurrentRange().cloneRange();
        }

        var viperRange = null;
        if (fromStart === true) {
            if (Viper.document.activeElement
                && Viper.document.activeElement !== this.element
                && Viper.document.activeElement.blur
                && Viper.document.activeElement !== document.body
            ) {
                // Call the blur method of the active element incase its an input box etc
                // which causes problems on IE when range is set below.
                // Note that the above activeElement != body check is to prevent the best
                // browser in the world changing focus to another window..
                Viper.document.activeElement.blur();
            }

            viperRange = this.viper.getCurrentRange();
            viperRange.setStart(viperRange._getFirstSelectableChild(element), 0);
            viperRange.collapse(true);
        } else {
            viperRange = this.viper.getCurrentRange();
        }

        if (ViperUtil.isBrowser('msie') === true) {
            // Range search.

            if (ViperUtil.isBrowser('msie', '>=11') === true) {
                viperRange = this.viper.getViperRange();
                viperRange.collapse(false);
                var textRange = new ViperIERange(document.body.createTextRange());
                textRange.setStart(viperRange.startContainer, viperRange.startOffset);
                textRange.setEnd(viperRange.endContainer, viperRange.endOffset);
                viperRange = textRange;
            } else {
                viperRange.collapse(false);
            }

            this._finding = true;
            var found = viperRange.rangeObj.findText(text);
            if (testOnly !== true && found === true) {
                viperRange.rangeObj.select();
                ViperSelection.addRange(this.viper.getCurrentRange());
                this.viper.fireSelectionChanged();
                setTimeout(function() {
                    this._finding = false;
                }, 300);
            }

            return found;
        } else {
            this.viper.focus();
            ViperSelection.addRange(viperRange);

            var found = this.viper.getDocumentWindow().find(text, false, backward);
            if (found !== true || this.viper.rangeInViperBounds() === false) {
                if (testOnly === true) {
                    ViperSelection.addRange(rangeClone);
                } else {
                    // Not found or not inside Viper element.
                    ViperSelection.addRange(viperRange);
                    this.viper.focus();
                }

                return false;
            } else if (testOnly === true) {
                ViperSelection.addRange(rangeClone);
                return true;
            }
        }//end if

        return true;

    },

    replace: function(replacement)
    {
        var range = null;
        if (ViperUtil.isBrowser('msie') === true) {
            range = this.viper.getViperRange();
        } else {
            range = this.viper.getCurrentRange();
            if (this.viper.rangeInViperBounds(range) === false) {
                range = this.viper.getViperRange();
            }
        }

        range.deleteContents();

        var newNode = document.createTextNode(replacement);
        range.insertNode(newNode);
        range.selectNode(newNode);
        ViperSelection.addRange(range);

        this._matchCount--;

    }

};
