/**
 * JS Class for the ViperSearchReplacePlugin.
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
function ViperSearchReplacePlugin(viper)
{
    this.viper       = viper;
    this._matchCount = 0;

}

ViperSearchReplacePlugin.prototype = {

    init: function()
    {
        this._initToolbar();

    },

    _initToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        var self  = this;
        var tools = this.viper.ViperTools;

        // Create Search and replace button and popup.
        var content = document.createElement('div');

        // Search text box.
        var search = tools.createTextbox('ViperSearchPlugin:searchInput', 'Search', '', function(value) {
            self.getNumberOfMatches(value);
            self.find(value, false, true);
            self._updateButtonStates();
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
        var replace = tools.createTextbox('ViperSearchPlugin:replaceInput', 'Replace', '', function(value) {
            var search = tools.getItem('ViperSearchPlugin:searchInput').getValue();
            self.getNumberOfMatches(search);
            self.find(search, false, true);

            self._updateButtonStates();
        });
        content.appendChild(replace);

        var replaceAllBtn = tools.createButton('ViperSearchPlugin:replaceAll', 'Replace All', 'Replace All', 'replaceAll', function() {
            if (tools.getItem('ViperSearchPlugin:replaceInput').getValue().toLowerCase() === tools.getItem('ViperSearchPlugin:searchInput').getValue().toLowerCase()) {
                return;
            }

            var replaceCount = 0;
            while (self.find(tools.getItem('ViperSearchPlugin:searchInput').getValue(), false, true) === true) {
                self.replace(tools.getItem('ViperSearchPlugin:replaceInput').getValue());
                replaceCount++;
            }

            self._matchCount = 0;
            self._updateButtonStates();
        }, true);
        var replaceBtn = tools.createButton('ViperSearchPlugin:replace', 'Replace', 'Replace', 'replaceText', function() {
            if (tools.getItem('ViperSearchPlugin:replaceInput').getValue().toLowerCase() === tools.getItem('ViperSearchPlugin:searchInput').getValue().toLowerCase()) {
                return;
            }

            self.replace(tools.getItem('ViperSearchPlugin:replaceInput').getValue());
            self._updateButtonStates();
        }, true);
        content.appendChild(replaceAllBtn);
        content.appendChild(replaceBtn);

        var findNext = tools.createButton('ViperSearchPlugin:findNext', 'Find Next', 'Find Next', '', function() {
            // Find again.
            var found = self.find(tools.getItem('ViperSearchPlugin:searchInput').getValue(), false);
            if (found !== true) {
                self._matchCount = 0;
            }

            self._updateButtonStates(found);
        }, true);
        content.appendChild(findNext);

        // Create the bubble.
        var searchTools = toolbar.createBubble('ViperSearchPlugin:bubble', 'Search & Replace', content);
        var searchBtn   = tools.createButton('searchReplace', '', 'Search & Replace', 'searchReplace');
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

        if (this.viper.isBrowser('firefox') === true) {
            // Select the original range.
            ViperSelection.addRange(clone);
            this.viper.focus();
        }

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
            viperRange = this.viper.getCurrentRange();
            viperRange.setStart(viperRange._getFirstSelectableChild(element), 0);
            viperRange.collapse(true);
        } else {
            viperRange = this.viper.getViperRange();
        }

        if (this.viper.isBrowser('msie') === true) {
            // Range search.
        } else {
            this.viper.focus();
            ViperSelection.addRange(viperRange);

            var found = window.find(text, false, backward);
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

            this.viper.focus();
        }

        return true;

    },

    replace: function(replacement)
    {
        this.viper.focus();

        this.viper.deleteContents();
        var range = this.viper.getCurrentRange();
        var newNode = document.createTextNode(replacement);
        range.insertNode(newNode);
        range.selectNode(newNode);
        ViperSelection.addRange(range);

        this._matchCount--;

    }

};
