/**
 * JS Class for the ViperAbbrPlugin.
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
function ViperAbbrPlugin(viper)
{
    this.viper = viper;

}

ViperAbbrPlugin.prototype = {

    init: function()
    {
        this._initInlineToolbar();
        this._initToolbar();

    },

    rangeToAbbr: function(range, title)
    {
        if (!range || !title) {
            return;
        }

        range = range || this.viper.getViperRange();

        var bookmark = this.viper.createBookmark(range);

        var elem = document.createElement('abbr');
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

    removeAbbr: function(elem)
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

    },

    getAbbrFromRange: function(range)
    {
        var selectedNode = range.getNodeSelection();
        if (selectedNode && dfx.isTag(selectedNode, 'abbr') === true) {
            return selectedNode;
        }

        var viperElem = this.viper.getViperElement();
        var common    = range.getCommonElement();
        while (common) {
            if (dfx.isTag(common, 'abbr') === true) {
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
        this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperAbbrPlugin', function(data) {
            var rangeClone       = data.range.cloneRange();
            var currentIsAbbr = false;

            // Check if we need to show the abbr options.
            if (rangeClone.collapsed === true || dfx.isBlockElement(data.lineage[data.current]) === true) {
                return;
            }

            var startNode = data.range.getStartNode();
            var endNode   = data.range.getEndNode();
            if (startNode && endNode && startNode.parentNode !== endNode.parentNode) {
                return;
            }

            if (dfx.isTag(data.lineage[data.current], 'acronym') === true) {
                return;
            } else if (dfx.isTag(data.lineage[data.current], 'abbr') === true) {
                // If the selection is a whole A tag then by default show the
                // abbr sub section.
                subSectionActive = true;
                currentIsAbbr = true;
            } else {
                subSectionActive = false;
            }

            if (currentIsAbbr !== true
                && (data.lineage[data.current].nodeType !== dfx.TEXT_NODE
                || dfx.isTag(data.lineage[data.current].parentNode, 'abbr') === false)
                && rangeClone.collapsed === true) {
                return;
            } else if (data.lineage[data.current].nodeType === dfx.TEXT_NODE) {
                var rangeText = data.range.toString();
                if (rangeText.length > 6
                    || rangeText.length < 2
                    || rangeText.match(/\s/)
                ) {
                    return;
                }
            }

            // Get the abbr from lineage.
            var abbr     = null;
            var linIndex = -1;
            for (var i = data.current; i >= 0; i--) {
                if (dfx.isTag(data.lineage[i], 'abbr') === true) {
                    abbr     = data.lineage[i];
                    linIndex = i;
                    break;
                }
            }

            var isAbbr = false;
            var titleAttr = '';
            if (abbr) {
                // Get the current value from the abbr tag.
                titleAttr = abbr.getAttribute('title') || '';
                isAbbr = true;
            }

            var group          = inlineToolbarPlugin.createButtonGroup();
            var subSectionCont = document.createElement('div');
            var subSection     = inlineToolbarPlugin.createSubSection(subSectionCont);

            // Abbr button.
            if (currentIsAbbr !== true && abbr) {
                inlineToolbarPlugin.createButton('Abbr', isAbbr, 'Toggle Abbr Options', false, 'abbr', function() {
                    // Select the whole abbr using the lineage.
                    inlineToolbarPlugin.selectLineageItem(linIndex);
                }, group);
            } else {
                inlineToolbarPlugin.createButton('Abbr', isAbbr, 'Toggle Abbr Options', false, 'abbr', null, group, subSection, subSectionActive);
            }

            if (isAbbr === true) {
                // Add the remove abbr button.
                inlineToolbarPlugin.createButton('RAbbr', false, 'Remove Abbr', false, 'abbrRemove', function() {
                    self.removeAbbr(abbr);
                }, group);
            }

            var setAbbrAttributes = function(title) {
                subSectionActive = true;
                ViperSelection.addRange(rangeClone);

                if (!abbr) {
                    abbr = self.rangeToAbbr(data.range, title);
                } else {
                    self.setTitle(abbr, title);
                }
            };

            // Sub section.
            var titleTextbox = inlineToolbarPlugin.createTextbox(null, titleAttr, 'Title', function(value) {
                setAbbrAttributes(value);
            }, false, false);

            subSectionCont.appendChild(titleTextbox);
        });
    },

    _initToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        var abbr = null;

        var setAbbrAttributes = function(title) {
            if (!abbr) {
                abbr = self.rangeToAbbr(self.viper.getViperRange(), title);
            } else {
                self.setTitle(abbr, title);
            }
        };

        var self     = this;
        var btnGroup = toolbar.createButtonGroup();

        // Create Abbr button and popup.
        var createAbbrSubContent = document.createElement('div');

        // Title text box.
        var title = toolbar.createTextbox('', 'Abbr', function(value) {
            setAbbrAttributes(value);
        });
        createAbbrSubContent.appendChild(title);

        var createAbbrSubSection = toolbar.createSubSection(createAbbrSubContent, true);
        var abbrTools = toolbar.createToolsPopup('Insert Abbr', null, [createAbbrSubSection], null, function() {
            if (abbr) {
                var range = self.viper.getViperRange();
                range.selectNode(abbr);
                ViperSelection.addRange(range);
            }
        });

        var urlBtn = toolbar.createButton('', false, 'Toggle Abbr Options', false, 'abbr', null, btnGroup, abbrTools);

        // Remove Abbr.
        var removeAbbrBtn = toolbar.createButton('', false, 'Remove Abbr', false, 'abbrRemove', function() {
            if (abbr) {
                self.removeAbbr(abbr);
            }
        }, btnGroup);

        // Update the buttons when the toolbar updates it self.
        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperAbbrPlugin', function(data) {
            var range = data.range;
            abbr      = self.getAbbrFromRange(range);

            if (abbr) {
                toolbar.setButtonActive(urlBtn);
                toolbar.enableButton(removeAbbrBtn);
                (dfx.getTag('input', createAbbrSubContent)[0]).value = abbr.getAttribute('title');
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
                    toolbar.closePopup(abbrTools);
                } else {
                    toolbar.enableButton(urlBtn);
                }

                toolbar.disableButton(removeAbbrBtn);

                (dfx.getTag('input', createAbbrSubContent)[0]).value = '';
                (dfx.getTag('input', createAbbrSubContent)[0]).value = '';
            }//end if
        });

    }

};
