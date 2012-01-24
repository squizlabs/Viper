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

        var lang     = null;
        var self     = this;
        var btnGroup = toolbar.createButtonGroup();

        // Create Language button and popup.
        var createLanguageSubContent = document.createElement('div');

        // URL text box.
        var langTextbox = toolbar.createTextbox('', 'Language', function(value) {
            self.rangeToLang(value);
        });
        createLanguageSubContent.appendChild(langTextbox);

        var createLanguageSubSection = toolbar.createSubSection(createLanguageSubContent, true);
        var langTools = toolbar.createToolsPopup('Language', null, [createLanguageSubSection], null, function() {
            if (lang) {
                var range = self.viper.getViperRange();
                range.selectNode(lang);
                ViperSelection.addRange(range);
            }
        });

        var langBtn = toolbar.createButton('', false, 'Toggle Language Options', false, 'lang', null, btnGroup, langTools);

        // Remove Language.
        var removeLanguageBtn = toolbar.createButton('', false, 'Remove Language', false, 'langRemove', function() {
            if (lang) {
                self.removeLanguage(lang);
            }
        }, btnGroup);

        // Update the buttons when the toolbar updates it self.
        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperLangPlugin', function(data) {
            lang = self.getLangElemFromRange();

            if (lang) {
                toolbar.setButtonActive(langBtn);
                toolbar.enableButton(removeLanguageBtn);

                (dfx.getTag('input', createLanguageSubContent)[0]).value = lang.getAttribute('lang');
            } else {
                var startNode = data.range.getStartNode();
                var endNode   = data.range.getEndNode();
                toolbar.setButtonInactive(langBtn);

                toolbar.disableButton(removeLanguageBtn);

                (dfx.getTag('input', createLanguageSubContent)[0]).value = '';
            }//end if
        });

    }

};
