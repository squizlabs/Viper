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
        this._initToolbar();

    },

    rangeToAcronym: function(title)
    {
        if (!title) {
            return;
        }

        var range    = this.viper.getViperRange();
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
        this.viper.fireSelectionChanged(range, true);
        this.viper.fireNodesChanged([this.viper.getViperElement()]);

    },

    setTitle: function(elem, title)
    {
        if (!elem) {
            return;
        }

        elem.setAttribute('title', title);

        this.viper.selectElement(elem);

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

    _initToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        var acronym = null;

        var setAcronymAttributes = function(title) {
            if (!acronym) {
                acronym = self.rangeToAcronym(title);
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
