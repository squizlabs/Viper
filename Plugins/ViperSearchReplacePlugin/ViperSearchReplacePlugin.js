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
            self.updateMatchesCount(self.getNumberOfMatches(value));
            self.find(value, false, true);

            self._updateButtonStates();
        });
        content.appendChild(search);

        // Replace text box.
        var replace = tools.createTextbox('ViperSearchPlugin:replaceInput', 'Replace', '');
        content.appendChild(replace);

        // Info Box.
        this._infoBox = document.createElement('div');
        dfx.setStyle(this._infoBox, 'display', 'none');
        dfx.addClass(this._infoBox, 'ViperITP-msgBox ViperSearchPlugin-info info');
        content.appendChild(this._infoBox);

        // Buttons.
        var findPrev = tools.createButton('ViperSearchPlugin:findPrev', '', 'Find Previous', 'prevIssue', function() {
            self.find(tools.getItem('ViperSearchPlugin:searchInput').getValue(), true);
            self._updateButtonStates();
        }, true);
        content.appendChild(findPrev);

        var replaceBtnsGroup = tools.createButtonGroup('ViperSearchPlugin:replaceButtons');
        content.appendChild(replaceBtnsGroup);

        var replaceAllBtn = tools.createButton('ViperSearchPlugin:replaceAll', 'Replace All', 'Replace All', 'replaceAll', function() {
            var replaceCount = 0;
            while (self.find(tools.getItem('ViperSearchPlugin:searchInput').getValue(), false, true) === true) {
                self.replace(tools.getItem('ViperSearchPlugin:replaceInput').getValue());
                replaceCount++;
            }

            self.updateMessage(replaceCount + ' instances were replaced');

        }, true);
        var replaceBtn = tools.createButton('ViperSearchPlugin:replace', 'Replace', 'Replace', 'replaceText', function() {
            self.replace(tools.getItem('ViperSearchPlugin:replaceInput').getValue());
        }, true);
        tools.addButtonToGroup('ViperSearchPlugin:replaceAll', 'ViperSearchPlugin:replaceButtons');
        tools.addButtonToGroup('ViperSearchPlugin:replace', 'ViperSearchPlugin:replaceButtons');

        var findNext = tools.createButton('ViperSearchPlugin:findNext', '', 'Find Next', 'nextIssue', function() {
            // Find again.
            self.find(tools.getItem('ViperSearchPlugin:searchInput').getValue(), false);
            self._updateButtonStates();

        }, true);
        content.appendChild(findNext);

        // Create the bubble.
        var searchTools = toolbar.createBubble('ViperSearchPlugin:bubble', 'Search & Replace', content);
        var searchBtn   = tools.createButton('searchReplace', 'Search', 'Toggle Search & Replace', 'searchReplace');
        toolbar.addButton(searchBtn);
        toolbar.setBubbleButton('ViperSearchPlugin:bubble', 'searchReplace');

        // Update the buttons when the toolbar updates it self.
        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperSearchReplacePlugin', null);

    },

    _updateButtonStates: function()
    {
        var self  = this;
        var tools = this.viper.ViperTools;

        var enableReplace = false;

        // These selection during these find calls may jump in to other containers
        // so clone the current selection so that we can select it again.
        var clone = this.viper.getCurrentRange();

        // Is there a next result?
        if (self.find(tools.getItem('ViperSearchPlugin:searchInput').getValue(), false) === true) {
            self.find(tools.getItem('ViperSearchPlugin:searchInput').getValue(), true);
            tools.enableButton('ViperSearchPlugin:findNext');
            enableReplace = true;
        } else {
            if (this.viper.isBrowser('firefox') === true) {
                self.find(tools.getItem('ViperSearchPlugin:searchInput').getValue(), true);
            }
            tools.disableButton('ViperSearchPlugin:findNext');
        }

        // Is there a previous result?
        if (self.find(tools.getItem('ViperSearchPlugin:searchInput').getValue(), true) === true) {
            self.find(tools.getItem('ViperSearchPlugin:searchInput').getValue(), false);
            tools.enableButton('ViperSearchPlugin:findPrev');
            enableReplace = true;
        } else {
            // Set the previous button state to disabled.
            tools.disableButton('ViperSearchPlugin:findPrev');
        }

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
        var matches = 0;
        while (this.find(text) === true) {
            matches++;
        }

        this._matchCount = matches;

        return matches;

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
        this.updateMatchesCount(this._matchCount);

    },

    updateMatchesCount: function(count)
    {
        if (dfx.getStyle(this._infoBox, 'display') === 'none') {
            dfx.blindDown(this._infoBox);
        }

        var content = '';
        if (count <= 0) {
            content = 'No matches found';

            dfx.removeClass(this._infoBox, 'matchesFound');
            dfx.addClass(this._infoBox, 'noMatches');
        } else {
            content = count + ' instances found';

            dfx.removeClass(this._infoBox, 'noMatches');
            dfx.addClass(this._infoBox, 'matchesFound');
        }

        this.updateMessage(content);

    },

    updateMessage: function(msg)
    {
        dfx.setHtml(this._infoBox, msg);

    }

};
