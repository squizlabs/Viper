/**
 * JS Class for the ViperAcronymPlugin.
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
function ViperAcronymPlugin(viper)
{
    this.viper = viper;

}

ViperAcronymPlugin.prototype = {

    init: function()
    {
        this._initInlineToolbar();
        this._initToolbar();

    },

    rangeToAcronym: function(range, title)
    {
        if (!range || !title) {
            return;
        }

        range = range || this.viper.getViperRange();

        var bookmark = this.viper.createBookmark(range);

        var elem = document.createElement('acronym');
        elem.setAttribute('title', title);

        var elems = dfx.getElementsBetween(bookmark.start, bookmark.end);
        for (var i = 0; i < elems.length; i++) {
            elem.appendChild(elems[i]);
        }

        dfx.insertBefore(bookmark.start, elem);

        this.viper.removeBookmark(bookmark);
        range.selectNode(elem);
        ViperSelection.addRange(range);

        this.viper.fireSelectionChanged();
        this.viper.fireNodesChanged([this.viper.getViperElement()]);

        return elem;

    },

    removeAcronym: function(elem)
    {
        if (!elem && elem.parentNode) {
            return;
        }

        var firstChild = elem.firstChild;
        var lastChild  = elem.lastChild;

        while (elem.firstChild) {
            this.viper.insertBefore(elem, elem.firstChild);
        }

        dfx.remove(elem);

        var range = this.viper.getViperRange();
        range.setStart(firstChild, 0);
        range.setEnd(lastChild, lastChild.data.length);
        ViperSelection.addRange(range);
        this.viper.fireSelectionChanged(true);
        this.viper.fireNodesChanged([this.viper.getViperElement()]);

    },

    setTitle: function(elem, title)
    {
        if (!elem) {
            return;
        }

        elem.setAttribute('title', title);

    },

    getAcronymFromRange: function(range)
    {
        var selectedNode = range.getNodeSelection();
        if (selectedNode && dfx.isTag(selectedNode, 'acronym') === true) {
            return selectedNode;
        }

        var viperElem = this.viper.getViperElement();
        var common    = range.getCommonElement();
        while (common) {
            if (dfx.isTag(common, 'acronym') === true) {
                return common;
            } else if (common === viperElem || dfx.isBlockElement(common) === true) {
                break;
            }

            common = common.parentNode;
        }

        return null;

    },

    _initInlineToolbar: function()
    {
        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');
        if (!inlineToolbarPlugin) {
            return;
        }

        var self = this;
        var subSectionActive = false;
        this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperAcronymPlugin', function(data) {
            var rangeClone       = data.range.cloneRange();
            var currentIsAcronym = false;

            // Check if we need to show the acronym options.
            if (rangeClone.collapsed === true || dfx.isBlockElement(data.lineage[data.current]) === true) {
                return;
            }

            var startNode = data.range.getStartNode();
            var endNode   = data.range.getEndNode();
            if (startNode && endNode && startNode.parentNode !== endNode.parentNode) {
                return;
            }

            if (dfx.isTag(data.lineage[data.current], 'acronym') === true) {
                // If the selection is a whole A tag then by default show the
                // acronym sub section.
                subSectionActive = true;
                currentIsAcronym = true;
            } else {
                subSectionActive = false;
            }

            if (currentIsAcronym !== true
                && (data.lineage[data.current].nodeType !== dfx.TEXT_NODE
                || dfx.isTag(data.lineage[data.current].parentNode, 'acronym') === false)
                && rangeClone.collapsed === true) {
                return;
            }

            // Get the acronym from lineage.
            var acronym     = null;
            var linIndex = -1;
            for (var i = data.current; i >= 0; i--) {
                if (dfx.isTag(data.lineage[i], 'acronym') === true) {
                    acronym     = data.lineage[i];
                    linIndex = i;
                    break;
                }
            }

            var isAcronym = false;
            var titleAttr = '';
            if (acronym) {
                // Get the current value from the acronym tag.
                titleAttr = acronym.getAttribute('title') || '';
                isAcronym = true;
            }

            var group          = inlineToolbarPlugin.createButtonGroup();
            var subSectionCont = document.createElement('div');
            var subSection     = inlineToolbarPlugin.createSubSection(subSectionCont);

            // Acronym button.
            if (currentIsAcronym !== true && acronym) {
                inlineToolbarPlugin.createButton('', isAcronym, 'Toggle Acronym Options', false, 'acronym', function() {
                    // Select the whole acronym using the lineage.
                    inlineToolbarPlugin.selectLineageItem(linIndex);
                }, group);
            } else {
                inlineToolbarPlugin.createButton('', isAcronym, 'Toggle Acronym Options', false, 'acronym', null, group, subSection, subSectionActive);
            }

            if (isAcronym === true) {
                // Add the remove acronym button.
                inlineToolbarPlugin.createButton('', false, 'Remove Acronym', false, 'acronymRemove', function() {
                    self.removeAcronym(acronym);
                }, group);
            }

            var setAcronymAttributes = function(title) {
                subSectionActive = true;
                ViperSelection.addRange(rangeClone);

                if (!acronym) {
                    acronym = self.rangeToAcronym(data.range, title);
                } else {
                    self.setTitle(acronym, title);
                }
            };

            // Sub section.
            var titleTextbox = inlineToolbarPlugin.createTextbox(null, titleAttr, 'Title', function(value) {
                setAcronymAttributes(value);
            }, false, true);

            subSectionCont.appendChild(titleTextbox);
        });
    },

    _initToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        var acronym = null;

        var setAcronymAttributes = function(title) {
            if (!acronym) {
                acronym = self.rangeToAcronym(self.viper.getViperRange(), title);
            } else {
                self.setTitle(acronym, title);
            }
        };

        var self     = this;
        var btnGroup = toolbar.createButtonGroup();

        // Create Acronym button and popup.
        var createAcronymSubContent = document.createElement('div');

        // Title text box.
        var title = toolbar.createTextbox('', 'Acronym', function(value) {
            setAcronymAttributes(value);
        });
        createAcronymSubContent.appendChild(title);

        var createAcronymSubSection = toolbar.createSubSection(createAcronymSubContent, true);
        var acronymTools = toolbar.createToolsPopup('Insert Acronym', null, [createAcronymSubSection], null, function() {
            if (acronym) {
                var range = self.viper.getViperRange();
                range.selectNode(acronym);
                ViperSelection.addRange(range);
            }
        });

        var urlBtn = toolbar.createButton('', false, 'Toggle Acronym Options', false, 'acronym', null, btnGroup, acronymTools);

        // Remove Acronym.
        var removeAcronymBtn = toolbar.createButton('', false, 'Remove Acronym', false, 'acronymRemove', function() {
            if (acronym) {
                self.removeAcronym(acronym);
            }
        }, btnGroup);

        // Update the buttons when the toolbar updates it self.
        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperAcronymPlugin', function(data) {
            var range = data.range;
            acronym      = self.getAcronymFromRange(range);

            if (acronym) {
                toolbar.setButtonActive(urlBtn);
                toolbar.enableButton(removeAcronymBtn);
                (dfx.getTag('input', createAcronymSubContent)[0]).value = acronym.getAttribute('title');
            } else {
                var startNode = data.range.getStartNode();
                var endNode   = data.range.getEndNode();
                toolbar.setButtonInactive(urlBtn);

                if (range.collapsed === true
                    || startNode
                    && endNode
                    && startNode.parentNode !== endNode.parentNode
                ) {
                    toolbar.disableButton(urlBtn);
                    toolbar.closePopup(acronymTools);
                } else {
                    toolbar.enableButton(urlBtn);
                }

                toolbar.disableButton(removeAcronymBtn);

                (dfx.getTag('input', createAcronymSubContent)[0]).value = '';
                (dfx.getTag('input', createAcronymSubContent)[0]).value = '';
            }//end if
        });

    }

};
