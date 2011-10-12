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
        address: 'Address',
        blockquote: 'Quote'
    };

    this.toolbarPlugin = null;
    this.activeStyles  = [];
    this._range        = null;

    this._inlineToolbarActiveSubSection = null;

}

ViperFormatPlugin.prototype = {

    init: function()
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

        this.toolbarPlugin   = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (this.toolbarPlugin) {
            this._createToolbarContent();
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
        if (!data.lineage || data.range.collapsed === true) {
            return;
        }

        var self                = this;
        var selectedNode        = data.lineage[data.current];
        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');

        var headingsSubSection = null;
        var hasActiveHeading   = false;
        if (this._canShowHeadingOptions(selectedNode) === true) {
            // Headings format section.
            var headingSubSectionContents = document.createElement('div');

            var headingBtnGroup = inlineToolbarPlugin.createButtonGroup();
            for (var i = 1; i <= 6; i++) {
                (function(headingCount) {
                    var active  = false;
                    var tagName = 'h' + headingCount;
                    for (var j = 0; j < data.lineage.length; j++) {
                        if (dfx.isTag(data.lineage[j], tagName) === true) {
                            active           = true;
                            hasActiveHeading = true;
                            break;
                        }
                    }

                    var headingButton = inlineToolbarPlugin.createButton('H' + headingCount, active,  'Convert to Heading ' + headingCount, false, null, function() {
                        self.handleFormat(tagName);
                    }, headingBtnGroup);
                }) (i);
                headingSubSectionContents.appendChild(headingBtnGroup);
            }

            headingsSubSection = inlineToolbarPlugin.createSubSection(headingSubSectionContents);
        }//end if

        var formatsSubSection = null;
        var hasActiveFormat   = false;
        if (this._canShowFormattingOptions(selectedNode) === true) {
            // Formats section.
            var formatsSubSectionContents = document.createElement('div');

            var formatButtons = {
                blockquote: 'Quote',
                pre: 'PRE',
                div: 'DIV',
                p: 'P'
            };

            for (var tag in formatButtons) {
                (function(tagName) {
                    var active = false;
                    for (var j = data.current; j < data.lineage.length; j++) {
                        if (dfx.isTag(data.lineage[j], tagName) === true) {
                            active           = true;
                            hasActiveFormat = true;
                            break;
                        }
                    }

                    var button = inlineToolbarPlugin.createButton(formatButtons[tagName], active,  'Convert to ' + formatButtons[tagName], false, null, function() {
                        self.handleFormat(tagName);
                    });
                    formatsSubSectionContents.appendChild(button);
                })
                (tag);
            }

            formatsSubSection = inlineToolbarPlugin.createSubSection(formatsSubSectionContents);
        }//end if

        var buttonGroup = inlineToolbarPlugin.createButtonGroup();
        if (formatsSubSection) {
            inlineToolbarPlugin.createButton('Aa', hasActiveFormat,  'Toggle Formats', false, 'formats', null, buttonGroup, formatsSubSection, hasActiveFormat);
        }

        if (headingsSubSection) {
            inlineToolbarPlugin.createButton('Hh', hasActiveHeading,  'Toggle Headings', false, 'headings', null, buttonGroup, headingsSubSection, hasActiveHeading);
        }

        // Anchor and Class.
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
            if (this._inlineToolbarActiveSubSection === 'anchor') {
                active = true;
            }

            var attrBtnGroup           = inlineToolbarPlugin.createButtonGroup();
            var anchorIDSubSectionCont = document.createElement('div');
            var anchorIdSubSection     = inlineToolbarPlugin.createSubSection(anchorIDSubSectionCont);

            var id = '';
            var anchorBtnActive = false;
            if (selectedNode.nodeType === dfx.ELEMENT_NODE) {
                id = selectedNode.getAttribute('id');
                if (id) {
                    anchorBtnActive = true;
                }
            }

            inlineToolbarPlugin.createButton('', anchorBtnActive, 'Anchor name (ID)', false, 'anchorID', function(subSectionState) {
                if (subSectionState === true) {
                    self._inlineToolbarActiveSubSection = 'anchor';
                }
            }, attrBtnGroup, anchorIdSubSection, active);

            var idTextBox = inlineToolbarPlugin.createTextbox(selectedNode, id, 'ID', function(value) {
                if (selectedNode.nodeType === dfx.ELEMENT_NODE) {
                    // Set the attribute of this node.
                    selectedNode.setAttribute('id', value);
                    self._inlineToolbarActiveSubSection = 'anchor';
                } else {
                    ViperSelection.addRange(rangeClone);

                    // Wrap the selection with span tag.
                    var bookmark = self.viper.createBookmark();
                    var span     = document.createElement('span');
                    span.setAttribute('id', value);

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
                        if (dfx.hasClass(anchorIdSubSection, 'active') === true) {
                            self._inlineToolbarActiveSubSection = 'anchor';
                        }

                        self.viper.fireCallbacks('Viper:selectionChanged', rangeClone);
                    }
                }//end if
            });
            anchorIDSubSectionCont.appendChild(idTextBox);
            if (active === true) {
                idTextBox.focus();
            }

            // Class.
            var active = false;
            if (this._inlineToolbarActiveSubSection === 'class') {
                active = true;
            }

            var classSubSectionCont = document.createElement('div');
            var classSubSection = inlineToolbarPlugin.createSubSection(classSubSectionCont);

            var className = '';
            var classBtnActive = false;
            if (selectedNode.nodeType === dfx.ELEMENT_NODE) {
                className = selectedNode.getAttribute('class');
                if (className) {
                    classBtnActive = true;
                }
            }

            inlineToolbarPlugin.createButton('', classBtnActive, 'Class name', false, 'cssClass', function(subSectionState) {
                if (subSectionState === true) {
                    self._inlineToolbarActiveSubSection = 'class';
                }
            }, attrBtnGroup, classSubSection, active);

            var classTextBox = inlineToolbarPlugin.createTextbox(selectedNode, className, 'Class', function(value) {
                if (selectedNode.nodeType === dfx.ELEMENT_NODE) {
                    // Set the attribute of this node.
                    selectedNode.setAttribute('class', value);
                    self._inlineToolbarActiveSubSection = 'class';
                } else {
                    ViperSelection.addRange(rangeClone);

                    // Wrap the selection with span tag.
                    var bookmark = self.viper.createBookmark();
                    var span     = document.createElement('span');
                    span.setAttribute('class', value);

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
                        if (dfx.hasClass(classSubSection, 'active') === true) {
                            self._inlineToolbarActiveSubSection = 'class';
                        }

                        self.viper.fireCallbacks('Viper:selectionChanged', rangeClone);
                    }
                }//end if
            });
            classSubSectionCont.appendChild(classTextBox);
            if (active === true) {
                classTextBox.focus();
            }
        }//end if

        this._inlineToolbarActiveSubSection = null;

    },

    _createToolbarContent: function()
    {
        var toolbar  = this.toolbarPlugin;
        var btnGroup = toolbar.createButtonGroup();
        var self     = this;

        var _updateValue = function(textBox, attr) {
            var range   = self.viper.getViperRange();
            var element = range.getNodeSelection();
            var value   = '';
            if (element) {
                value = element.getAttribute(attr);
            }

            textBox.value = value;
            return value;
        };

        // Anchor.
        var anchorSubContent = document.createElement('div');
        var idTextbox = toolbar.createTextbox('', 'ID', function(value) {
            // Apply the ID to the selection.
            self._setAttributeForSelection(self.viper.getCurrentRange(), 'id', value);
        });
        anchorSubContent.appendChild(idTextbox);

        var anchorSubSection = toolbar.createSubSection(anchorSubContent, true);
        var anchorTools   = toolbar.createToolsPopup('Anchor ID', null, [anchorSubSection], null, function() {
            _updateValue(dfx.getTag('input', idTextbox)[0], 'id');
        });

        var idButton = toolbar.createButton('', false, 'Anchor ID', false, 'anchorID', null, btnGroup, anchorTools);

        // Class.
        var classSubContent = document.createElement('div');
        var classTextbox = toolbar.createTextbox('', 'Class', function(value) {
            self._setAttributeForSelection(self.viper.getCurrentRange(), 'class', value);
        });
        classSubContent.appendChild(classTextbox);

        var classSubSection = toolbar.createSubSection(classSubContent, true);
        var classTools   = toolbar.createToolsPopup('Class', null, [classSubSection], null, function() {
            _updateValue(dfx.getTag('input', classTextbox)[0], 'class');
        });

        var classButton = toolbar.createButton('', false, 'CSS Class', false, 'cssClass', null, btnGroup, classTools);

        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperFormatPlugin', function(data) {
            if (data.range.collapsed === true) {
                toolbar.disableButton(idButton);
                toolbar.disableButton(classButton);
            } else {
                toolbar.enableButton(idButton);
                toolbar.enableButton(classButton);
            }

            if (_updateValue(dfx.getTag('input', idTextbox)[0], 'id')) {
                toolbar.setButtonActive(idButton);
            } else {
                toolbar.setButtonInactive(idButton);
            }

            if (_updateValue(dfx.getTag('input', classTextbox)[0], 'class')) {
                toolbar.setButtonActive(classButton);
            } else {
                toolbar.setButtonInactive(classButton);
            }
        });

    },

    _setAttributeForElement: function(element, attr, value)
    {
        if (element.nodeType === dfx.ELEMENT_NODE) {
            // Set the attribute of this element.
            element.setAttribute(attr, value);
            return element;
        }

        return null;

    },

    _setAttributeForSelection: function(range, attr, value)
    {
        // Wrap the selection with span tag.
        var bookmark = self.viper.createBookmark();

        // Move the elements between start and end of bookmark to the new
        // span tag. Then select the new span tag and update selection.
        var span = null;
        if (bookmark.start && bookmark.end) {
            if (bookmark.start.nextSibling
                && bookmark.start.nextSibling.nodeType === dfx.ELEMENT_NODE
                && bookmark.start.nextSibling === bookmark.end.previousSibling
            ) {
                span = bookmark.start.nextSibling;
                self.viper.removeBookmarks();
                this._setAttributeForElement(span, attr, value);
            } else {
                var span     = document.createElement('span');
                span.setAttribute(attr, value);

                var start = bookmark.start.nextSibling;
                while (start !== bookmark.end) {
                    var elem = start;
                    start = start.nextSibling;
                    span.appendChild(elem);
                }

                dfx.insertBefore(bookmark.start, span);
                self.viper.removeBookmark(bookmark);
            }//end if

            range.selectNode(span);
            ViperSelection.addRange(range);
            self.viper.adjustRange();

            self.viper.fireCallbacks('Viper:selectionChanged', range);

            return span;
        }

        return null;

    },

    _canShowHeadingOptions: function(node)
    {
        if (!node) {
            return false;
        }

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

    _canShowFormattingOptions: function(node)
    {
        if (!node) {
            return false;
        }

        if (node.nodeType === dfx.TEXT_NODE) {
            // If this is a text selection then dont show the tools.
            return false;
        } else if (dfx.isBlockElement(node) === false && dfx.isTag(node, 'blockquote') === false) {
            return false;
        } else {
            switch (node.tagName.toLowerCase()) {
                case 'li':
                case 'ul':
                case 'ol':
                case 'table':
                case 'tr':
                case 'td':
                case 'th':
                case 'tbody':
                    return false;
                break;

                default:
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

        if (elemsBetween.length === 1) {
            selectedNode = elemsBetween[0];
            if (bookmark) {
                dfx.remove(bookmark.start);
                dfx.remove(bookmark.end);
                bookmark = null;
            }
        }

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
                        dfx.insertBefore(blockParent, newElem);
                        range.selectNode(newElem);
                        ViperSelection.addRange(range);
                    }
                });
            }//end if
        });

        if (bookmark) {
            this.viper.selectBookmark(bookmark);
        }

        this.viper.fireNodesChanged([this.viper.getViperElement()]);
        this.viper.fireSelectionChanged(null, true);

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
