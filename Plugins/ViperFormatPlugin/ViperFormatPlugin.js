/**
 * JS Class for the Viper Format Plugin.
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
 * @package    CMS
 * @subpackage Editing
 * @author     Squiz Pty Ltd <products@squiz.net>
 * @copyright  2010 Squiz Pty Ltd (ACN 084 670 600)
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPLv2
 */

function ViperFormatPlugin(viper)
{
    this.viper = viper;

    this.styleTags = {
        h1: 'Heading 1',
        h2: 'Heading 2',
        h3: 'Heading 3',
        h4: 'Heading 4',
        h5: 'Heading 5',
        h6: 'Heading 6',
        p: 'Paragraph',
        pre: 'Preformatted',
        address: 'Address'
    };

    this.toolbarPlugin = null;
    this.activeStyles  = [];
    this._range        = null;

}

ViperFormatPlugin.prototype = {

    start: function()
    {
        var name = 'Format';
        var self = this;

        // Inline toolbar.
        this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperFormatPlugin', function(data) {
            self._createInlineToolbarContent(data);
        });

        ViperChangeTracker.addChangeType('textFormatChange', 'Formatted', 'format');
        ViperChangeTracker.setDescriptionCallback('textFormatChange', function(node) {
            var format = self._getFormat(node);
            return self.styleTags[format];
        });

        var menu = document.createElement('div');
        dfx.addClass(menu, 'ViperFormatPlugin-menu');
        this.toolbarPlugin   = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (this.toolbarPlugin) {
            var subToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperSubToolbarPlugin');
            var button = this.toolbarPlugin.addButton(name, 'format', 'Format', function (e) {
                // Add document mousedown event for hiding the menu.
                dfx.addEvent(document, 'mousedown.ViperFormatPlugin', function() {
                    dfx.setStyle(menu, 'display', 'none');
                    self._range = null;
                    dfx.removeEvent(document, 'mousedown.ViperFormatPlugin');
                });

                if (subToolbarPlugin && subToolbarPlugin.isActive() === true) {
                    dfx.setStyle(menu, 'margin-top', '30px');
                } else {
                    dfx.setStyle(menu, 'margin-top', '0px');
                }

                dfx.setStyle(menu, 'display', 'block');
                self._range       = self.viper.getCurrentRange();
                var currentFormat = self._getFormat(self._range.startContainer);
                if (currentFormat !== null) {
                    dfx.removeClass(dfx.getClass('ViperFormatPlugin-menu-item', menu), 'active');
                    dfx.addClass(dfx.getClass('ViperFormatPlugin-menu-' + currentFormat, menu)[0], 'active');
                }

                dfx.preventDefault(e);
                dfx.stopPropagation(e);
                return false;
            });

            dfx.setStyle(menu, 'display', 'none');
            button.appendChild(menu);

            var shadow = document.createElement('div');
            menu.appendChild(shadow);
            dfx.addClass(shadow, 'ViperFormatPlugin-menu-shadow');

            var fsize = 24;
            for (var tag in this.styleTags) {
                if (this.styleTags.hasOwnProperty(tag) === false) {
                    continue;
                }

                var item = document.createElement('div');
                dfx.addClass(item, 'ViperFormatPlugin-menu-item ViperFormatPlugin-menu-' + tag);
                menu.appendChild(item);
                dfx.setHtml(item, this.styleTags[tag]);
                dfx.setStyle(item, 'font', fsize + 'px arial');
                if (fsize > 12) {
                    fsize -= 2;
                }

                (function(el, tagName) {
                    dfx.addEvent(el, 'mousedown', function() {
                        self.handleFormat(tagName);
                    });
                }) (item, tag);
            }

            dfx.hover(menu.childNodes, function(e) {
                var target = dfx.getMouseEventTarget(e);
                dfx.addClass(target, 'hover');
            }, function(e) {
                dfx.removeClass(menu.childNodes, 'hover');
            });
        }

        ViperChangeTracker.setApproveCallback('textFormatChange', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });

        ViperChangeTracker.setRejectCallback('textFormatChange', function(clone, node) {
            // Remove all nodes insede the specified node before it
            // or to a new P tag if the parent is the top element.
            if (node.parentNode === self.viper.element) {
                var elem = document.createElement('p');
                while (node.firstChild) {
                    elem.appendChild(node.firstChild);
                }

                dfx.insertBefore(node, elem);
            } else {
                while (node.firstChild) {
                    dfx.insertBefore(node, node.firstChild);
                }
            }

            // Remove node.
            dfx.remove(node);
        });

    },

    _createInlineToolbarContent: function(data)
    {
        if (!data.lineage) {
            return;
        }

        var selectedNode = data.lineage[data.current];
        if (this._canFormatTag(selectedNode) !== true) {
            return;
        }

        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');

        if (data.range.collapsed === true) {
            return;
        }

        var self = this;

        var headingSubSectionContents = document.createElement('div');
        for (var i = 1; i <= 6; i++) {
            (function(headingCount) {
                var headingButton = inlineToolbarPlugin.createButton('H' + headingCount, false, null, function() {
                    self.handleFormat('h' + headingCount);
                });
                headingSubSectionContents.appendChild(headingButton);
            }) (i);
        }

        var headingsSubSection = inlineToolbarPlugin.createSubSection(headingSubSectionContents);
        var formatsSubSection = inlineToolbarPlugin.createSubSection('');

        var buttonGroup = inlineToolbarPlugin.createButtonGroup();
        var formats  = inlineToolbarPlugin.createButton('Aa', false, 'formats', null, buttonGroup, formatsSubSection);

        // If Any heading is active on the current selection activate the button.
        var headingActive = false;

        //var parents       = dfx.getParents();

        var headings = inlineToolbarPlugin.createButton('Hh', false, 'headings', null, buttonGroup, headingsSubSection);

    },

    _canFormatTag: function(node)
    {
        if (node.nodeType === dfx.TEXT_NODE) {
            // If this is a text selection then dont show the tools.
            return false;
        } else if (dfx.isBlockElement(node) === false) {
            return false;
        } else {
            switch (node.tagName.toLowerCase()) {
                case 'li':
                case 'ul':
                case 'ol':
                    return false;
                break;

                default:
                    // Check the selection length if the length is too long then
                    // dont show the tools.
                    var textContent = dfx.getNodeTextContent(node);
                    if (textContent && textContent.length > 80) {
                        return false;
                    }

                    return true;
                break;
            }
        }

        return true;

    },

    _addChangeTrackInfo: function(node)
    {
        if (ViperChangeTracker.isTracking() === true) {
            ViperChangeTracker.addChange('textFormatChange', [node]);
        }

    },

    handleFormat: function(type)
    {
        var range = this.viper.getCurrentRange();
        if (this._range) {
            this.viper.focus();
            range = this.viper.getCurrentRange();

            // Range could be starting from a DOMText and ending on a DOMNode. Handle it.
            if (this.viper.isChildOfElems(this._range.startContainer, [this._range.endContainer]) === true) {
                var child = range._getFirstSelectableChild(this._range.endContainer);
                range.setStart(child, 0);
            }

            // Set the range again.
            range.setStart(this._range.startContainer, this._range.startOffset);
            range.setEnd(this._range.endContainer, this._range.endOffset);
        }

        var selectedNode = range.getNodeSelection();
        var elemsBetween = [];
        if (selectedNode === null) {
            var startNode = range.getStartNode();
            if (dfx.isChildOf(startNode, this.viper.element) === false) {
                // TODO: Should we handle this case in createBookmark?
                range.setStart(this.viper.element, 0);
                range.setEnd(this.viper.element, this.viper.element.childNodes.length);
            }

            ViperSelection.addRange(range);

            var bookmark     = this.viper.createBookmark();
            var elemsBetween = dfx.getElementsBetween(bookmark.start, bookmark.end);
            if (range.collapsed === true) {
                elemsBetween.unshift(bookmark.start);
            }
        } else {
            elemsBetween.push(selectedNode);
        }

        var s = this.styleTags;
        s.div = 1;

        var self = this;
        dfx.foreach(elemsBetween, function(i) {
            var elem    = elemsBetween[i];
            var tagName = dfx.getTagName(elem);
            if (s[tagName]) {
                // Convert this element to specified tag.
                var newElem = self._createNewNode(elem, type);
                if (selectedNode !== null && newElem) {
                    // This is a single node selection so select the new node.
                    range.selectNode(newElem);
                    ViperSelection.addRange(range);
                }
            } else {
                var textNodes = null;
                if (elem.nodeType === dfx.TEXT_NODE) {
                    textNodes = [elem];
                } else {
                    textNodes = dfx.getTextNodes(elem);
                }

                dfx.foreach(textNodes, function(k) {
                    var textNode    = textNodes[k];
                    var blockParent = self.getFirstBlockParent(textNode);
                    if (blockParent === null) {
                        return;
                    }

                    var t = dfx.getTagName(blockParent);
                    if (s[t]) {
                        // Convert this element to specified tag.
                        self._createNewNode(blockParent, type);
                    } else if (type !== t) {
                        var newElem = document.createElement(type);
                        self._addChangeTrackInfo(newElem);
                        self._moveChildElements(blockParent, newElem);
                        blockParent.appendChild(newElem);
                    }
                });
            }//end if
        });

        if (bookmark) {
            this.viper.selectBookmark(bookmark);
        }

        this.viper.fireNodesChanged([this.viper.getViperElement()]);

    },

    _createNewNode: function(node, type)
    {
         // We need to create a new element.
        var newElem = document.createElement(type);
        this._addChangeTrackInfo(newElem);

        // Move the child nodes of this node to the new one.
        this._moveChildElements(node, newElem);

        // Insert new node after the current node.
        dfx.insertAfter(node, newElem);

        // Remove old node.
        dfx.remove(node);

        return newElem;

    },


    _moveChildElements: function(source, dest)
    {
        while (source.firstChild) {
            dest.appendChild(source.firstChild);
        }

    },


    getFirstBlockParent: function(elem)
    {
        if (dfx.isBlockElement(elem) === true) {
            return elem;
        }

        // Get the parents of the start node.
        var parents = dfx.getParents(elem);

        var parent = null;
        var ln     = parents.length;
        for (var i = 0; i < ln; i++) {
            parent = parents[i];
            if (parent === this.viper.element) {
                return null;
            }

            if (dfx.isBlockElement(parent) === true) {
                return parent;
            }
        }

    },

    selectionChanged: function()
    {
        var range     = this.viper.getCurrentRange();
        var startNode = range.startContainer;
        var endNode   = range.endContainer;
        var boldFound = false;
        var emFound   = false;

        startNode = startNode.parentNode;
        this.toolbarPlugin.setButtonInactive('format');

        var tagName = this._getFormat(startNode);
        if (tagName !== null && tagName !== 'p') {
            this.toolbarPlugin.setButtonActive('format');
        }

    },

    _getFormat: function(startNode)
    {
        while (startNode.parentNode) {
            if (startNode === document) {
                return null;
            }

            if (startNode.tagName) {
                var tagName = startNode.tagName.toLowerCase();
                if (this.styleTags[tagName]) {
                    return tagName;
                }
            }

            startNode = startNode.parentNode;
        }

        return null;

    }

};
