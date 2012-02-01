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
        this._initToolbar();

    },

    rangeToAbbr: function(title)
    {
        if (!title) {
            return;
        }

        var range = this.viper.getViperRange();

        var bookmark = this.viper.createBookmark(range);

        var elem = document.createElement('abbr');
        elem.setAttribute('title', title);

        var elems = dfx.getElementsBetween(bookmark.start, bookmark.end);
        var c     = elems.length;
        for (var i = 0; i < c; i++) {
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

        this.viper.selectElement(elem);

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

    _initToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        var abbr     = null;
        var self     = this;
        var tools    = this.viper.ViperTools;

        // Create Abbr button and popup.
        var createAbbrSubContent = document.createElement('div');

        // Title text box.
        var title = tools.createTextbox('ViperAbbrPlugin:abbr', 'Abbr', '', function(value) {
            if (!abbr) {
                abbr = self.rangeToAbbr(value);
            } else {
                self.setTitle(abbr, value);
            }
        });
        createAbbrSubContent.appendChild(title);

        var abbrTools = toolbar.createBubble('ViperAbbrPlugin:bubble', 'Insert Abbr', createAbbrSubContent);

        tools.createButton('ViperAbbrPlugin:toggle', 'Abr', 'Toggle Abbr Options', 'abbr');
        toolbar.setBubbleButton('ViperAbbrPlugin:bubble', 'ViperAbbrPlugin:toggle');

        // Remove Abbr.
        var removeAbbrBtn = tools.createButton('ViperAbbrPlugin:remove', 'RAbr', 'Remove Abbr', 'abbrRemove', function() {
            if (abbr) {
                self.removeAbbr(abbr);
            }
        });

        var btnGroup = tools.createButtonGroup('ViperAbbrPlugin:buttons');
        tools.addButtonToGroup('ViperAbbrPlugin:toggle', 'ViperAbbrPlugin:buttons');
        tools.addButtonToGroup('ViperAbbrPlugin:remove', 'ViperAbbrPlugin:buttons');
        toolbar.addButton(btnGroup);

        // Update the buttons when the toolbar updates it self.
        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperAbbrPlugin', function(data) {
            var range = data.range;
            abbr      = self.getAbbrFromRange(range);

            if (abbr) {
                tools.setButtonActive('ViperAbbrPlugin:toggle');
                tools.enableButton('ViperAbbrPlugin:remove');
                //(dfx.getTag('input', createAbbrSubContent)[0]).value = abbr.getAttribute('title');
            } else {
                var startNode = data.range.getStartNode();
                var endNode   = data.range.getEndNode();
                tools.setButtonInactive('ViperAbbrPlugin:toggle');

                if (range.collapsed === true
                    || startNode
                    && endNode
                    && startNode.parentNode !== endNode.parentNode
                ) {
                    tools.disableButton('ViperAbbrPlugin:toggle');
                    toolbar.closeBubble('ViperAbbrPlugin:bubble');
                } else {
                    tools.enableButton('ViperAbbrPlugin:toggle');
                }

                tools.disableButton('ViperAbbrPlugin:remove');

                //(dfx.getTag('input', createAbbrSubContent)[0]).value = '';
                //(dfx.getTag('input', createAbbrSubContent)[0]).value = '';
            }//end if
        });

    }

};
