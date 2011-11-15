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

        // Inline toolbar.
        this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperLangPlugin', function(data) {
            self._createInlineToolbarContent(data);
        });

    },

    _createInlineToolbarContent: function(data)
    {
        if (!data.lineage || data.range.collapsed === true) {
            return;
        }

        var self                = this;
        var selectedNode        = data.lineage[data.current];
        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');

        if (selectedNode.nodeType === dfx.ELEMENT_NODE
            || data.range.startContainer === data.range.endContainer
        ) {
            var rangeClone = data.range.cloneRange();
            for (var i = 0; i < data.lineage.length; i++) {
                if (dfx.isTag(data.lineage[i], 'a') === true) {
                    return;
                }
            }

            // Anchor.
            var active = false;
            if (this._inlineToolbarActiveSubSection === 'lang') {
                active = true;
            }

            var attrBtnGroup       = inlineToolbarPlugin.createButtonGroup();
            var langSubSectionCont = document.createElement('div');
            var langIdSubSection   = inlineToolbarPlugin.createSubSection(langSubSectionCont);

            var lang = '';
            var langBtnActive = false;
            if (selectedNode.nodeType === dfx.ELEMENT_NODE) {
                lang = selectedNode.getAttribute('lang');
                if (lang) {
                    langBtnActive = true;
                }
            }

            inlineToolbarPlugin.createButton('', langBtnActive, 'Language', false, 'lang', function(subSectionState) {
                if (subSectionState === true) {
                    self._inlineToolbarActiveSubSection = 'lang';
                }
            }, attrBtnGroup, langIdSubSection, active);

            var langTextBox = inlineToolbarPlugin.createTextbox(selectedNode, lang, 'Language', function(value) {
                if (selectedNode.nodeType === dfx.ELEMENT_NODE) {
                    // Set the attribute of this node.
                    selectedNode.setAttribute('lang', value);
                    self._inlineToolbarActiveSubSection = 'lang';
                } else {
                    ViperSelection.addRange(rangeClone);

                    // Wrap the selection with span tag.
                    var bookmark = self.viper.createBookmark();
                    var span     = document.createElement('span');
                    span.setAttribute('lang', value);

                    // Move the elements between start and end of bookmark to the new
                    // span tag. Then select the new span tag and update selection.
                    if (bookmark.start && bookmark.end) {
                        var start = bookmark.start.nextSibling;
                        while (start !== bookmark.end) {
                            var elem = start;
                            start = start.nextSibling;
                            span.appendChild(elem);
                        }

                        dfx.insertBefore(bookmark.start, span);
                        self.viper.removeBookmark(bookmark);

                        rangeClone.selectNode(span);
                        ViperSelection.addRange(rangeClone);
                        self.viper.adjustRange();

                        // We want to keep this textbox open so set this var.
                        if (dfx.hasClass(langIdSubSection, 'active') === true) {
                            self._inlineToolbarActiveSubSection = 'lang';
                        }

                        self.viper.fireCallbacks('Viper:selectionChanged', rangeClone);
                    }
                }//end if
            });
            langSubSectionCont.appendChild(langTextBox);
            if (active === true) {
                langTextBox.focus();
            }
        }//end if

        this._inlineToolbarActiveSubSection = null;

    }

};
