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
    this.viper = viper;

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

        // Link var is updated when the updateToolbar event callback is called.
        var link = null;

        var setLinkAttributes = function(url, title) {
            if (!link) {
                link = self.rangeToLink(self.viper.getViperRange(), url, title);
            } else {
                self.setLinkURL(link, url);
                self.setLinkTitle(link, title);
            }
        };

        var self     = this;
        var btnGroup = toolbar.createButtonGroup();

        // Create Search and replace button and popup.
        var searchReplaceSubContent = document.createElement('div');

        // Search text box.
        var search = toolbar.createTextbox('', 'Search', function(value) {
            self.find(value);
        });
        searchReplaceSubContent.appendChild(search);

        // Replace text box.
        var replace = toolbar.createTextbox('', 'Replace with', function(value) {
            setLinkAttributes((dfx.getTag('input', searchReplaceSubContent)[0]).value, value);
        });
        searchReplaceSubContent.appendChild(replace);

        var findNext = toolbar.createButton('Find Next', false, 'Find Next', false, 'findNext', function() {
            // Find again.
            if (self.find((dfx.getTag('input', searchReplaceSubContent)[0]).value) === false) {
                alert('Not found');
            }
        });
        searchReplaceSubContent.appendChild(findNext);

        var replaceBtn = toolbar.createButton('Replace', false, 'Replace', false, 'replaceText', function() {
            self.replace((dfx.getTag('input', searchReplaceSubContent)[1]).value);
        });
        searchReplaceSubContent.appendChild(replaceBtn);

        var replaceAllBtn = toolbar.createButton('Replace All', false, 'Replace All', false, 'replaceAll', function() {
            while (self.find((dfx.getTag('input', searchReplaceSubContent)[0]).value) === true) {
                self.replace((dfx.getTag('input', searchReplaceSubContent)[1]).value);
            }
        });
        searchReplaceSubContent.appendChild(replaceAllBtn);

        var createLinkSubSection = toolbar.createSubSection(searchReplaceSubContent, true);
        var searchTools = toolbar.createToolsPopup('Search & Replace', null, [createLinkSubSection], null, function() {
            if (link) {
                var range = self.viper.getViperRange();
                range.selectNode(link);
                ViperSelection.addRange(range);
            }
        });

        var searchBtn = toolbar.createButton('Search', false, 'Toggle Search & Replace', false, 'searchReplace', null, btnGroup, searchTools);

        // Update the buttons when the toolbar updates it self.
        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperSearchReplacePlugin', null);

    },

    find: function(text)
    {
        var element = this.viper.getViperElement();
        if (!text || !element) {
            return;
        }

        var viperRange = this.viper.getViperRange();

        if (this.viper.isBrowser('msie') === true) {
            // Range search.
        } else {
            this.viper.focus();
            ViperSelection.addRange(viperRange);

            var found = window.find(text);
            if (!found || this.viper.rangeInViperBounds() === false) {
                // Not found or not inside Viper element.
                ViperSelection.addRange(viperRange);
                this.viper.focus();
                return false;
            }

            this.viper.focus();
        }

        return true;

    },

    replace: function(replacement)
    {
        this.viper.deleteContents();
        var range = this.viper.getCurrentRange();
        var newNode = document.createTextNode(replacement);
        range.insertNode(newNode);
        range.selectNode(newNode);
        ViperSelection.addRange(range);


    }

};
