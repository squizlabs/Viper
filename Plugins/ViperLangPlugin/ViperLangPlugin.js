/**
 * JS Class for the ViperLangPlugin.
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
function ViperLangPlugin(viper)
{
    this.viper = viper;

}

ViperLangPlugin.prototype = {

    init: function()
    {
        var self = this;
        this._initToolbarContent();

    },

    getLangElemFromRange: function()
    {
        var range      = this.viper.getViperRange();
        var commonElem = range.getCommonElement();
        var viperElem  = this.viper.getViperElement();

        var element = this.viper.getWholeElementSelection(range);
        if (element) {
            commonElem = element;
        }

        if (dfx.isChildOf(commonElem, viperElem) === false) {
            return;
        }

        while (commonElem && commonElem !== viperElem) {
            var lang = commonElem.getAttribute('lang');
            if (lang) {
                return commonElem;
            }

            commonElem = commonElem.parentNode;
        }

        return null;

    },

    rangeToLang: function(lang)
    {
        var attributes = {
            attributes: {
                lang: lang
            }
        };

        var element = this.viper.getWholeElementSelection();
        if (element) {
            element.setAttribute('lang', lang);
            this.viper.selectElement(element);
        } else {
            this.viper.surroundContents('span', attributes);
        }

        this.viper.fireSelectionChanged();
        this.viper.fireNodesChanged([this.viper.getViperElement()]);

    },

    _initToolbarContent: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        var lang  = null;
        var self  = this;
        var tools = this.viper.ViperTools;

        // Create Language button and popup.
        var createLanguageSubContent = document.createElement('div');

        // URL text box.
        var langTextbox = tools.createTextbox('ViperLangPlugin:lang', 'Language', '', function(value) {
            self.rangeToLang(value);
        });
        createLanguageSubContent.appendChild(langTextbox);

        toolbar.createBubble('ViperLangPlugin:bubble', 'Language', createLanguageSubContent);

        tools.createButton('ViperLangPlugin:toggle', 'Lang', 'Toggle Language Options', 'lang');
        tools.createButton('ViperLangPlugin:remove', 'RLang', 'Remove Language', 'langRemove', function() {
            if (lang) {
                self.removeLanguage(lang);
            }
        });
        var btnGroup = tools.createButtonGroup('ViperLangPlugin:buttons');
        tools.addButtonToGroup('ViperLangPlugin:toggle', 'ViperLangPlugin:buttons');
        tools.addButtonToGroup('ViperLangPlugin:remove', 'ViperLangPlugin:buttons');
        toolbar.addButton(btnGroup);
        toolbar.setBubbleButton('ViperLangPlugin:bubble', 'ViperLangPlugin:toggle');

        // Update the buttons when the toolbar updates it self.
        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperLangPlugin', function(data) {
            lang = self.getLangElemFromRange();

            if (lang) {
                tools.setButtonActive('ViperLangPlugin:toggle');
                tools.enableButton('ViperLangPlugin:remove');

                //(dfx.getTag('input', createLanguageSubContent)[0]).value = lang.getAttribute('lang');
            } else {
                var startNode = data.range.getStartNode();
                var endNode   = data.range.getEndNode();
                tools.setButtonInactive('ViperLangPlugin:toggle');

                tools.disableButton('ViperLangPlugin:remove');

                //(dfx.getTag('input', createLanguageSubContent)[0]).value = '';
            }//end if
        });

    }

};
