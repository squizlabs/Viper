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

        this.viper.registerCallback('ViperInlineToolbarPlugin:lineageClicked', 'ViperFormatPlugin', function(data) {
            self._inlineToolbarActiveSubSection = null;
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
        var tools               = this.viper.ViperTools;
        var selectedNode        = data.lineage[data.current];
        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');

        var headingsSubSection = null;
        var hasActiveHeading   = false;
        if (this._canShowHeadingOptions(selectedNode) === true) {
            // Headings format section.
            var headingSubSectionContents = document.createElement('div');

            var headingBtnGroup = tools.createButtonGroup('VFP:vitp:headingFormats');
            headingSubSectionContents.appendChild(headingBtnGroup);
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

                    var headingButton = tools.createButton('VFP:vitp:heading:h' + headingCount, 'H' + headingCount, 'Convert to Heading ' + headingCount, null, function() {
                        self.handleFormat(tagName);
                    }, false, active);
                    tools.addButtonToGroup('VFP:vitp:heading:h' + headingCount, 'VFP:vitp:headingFormats');

                }) (i);
            }//end for

            headingsSubSection = inlineToolbarPlugin.makeSubSection('VFP:vitp:heading:subSection', headingSubSectionContents);
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

                    var button = tools.createButton('VFP:vitp:formatting:' + formatButtons[tagName], formatButtons[tagName], 'Convert to ' + formatButtons[tagName], null, function() {
                        self.handleFormat(tagName);
                    }, false, active);
                    formatsSubSectionContents.appendChild(button);
                })
                (tag);
            }

            formatsSubSection = inlineToolbarPlugin.makeSubSection('VFP:vitp:formatting:subSection', formatsSubSectionContents);
        }//end if

        var buttonGroup = tools.createButtonGroup('VFP:vitp:formats:buttons');
        if (formatsSubSection || headingsSubSection) {
            inlineToolbarPlugin.addButton(buttonGroup);
        }

        if (formatsSubSection) {
            tools.createButton('VFP:vitp:formats:toggleFormats', 'Aa', 'Toggle Formats', 'formats', null, false, hasActiveFormat);
            tools.addButtonToGroup('VFP:vitp:formats:toggleFormats', 'VFP:vitp:formats:buttons');
            inlineToolbarPlugin.setSubSectionButton('VFP:vitp:formats:toggleFormats', 'VFP:vitp:formatting:subSection');
        }

        if (headingsSubSection) {
            tools.createButton('VFP:vitp:formats:toggleHeadings', 'Hh', 'Toggle Headings', 'headings', null, false, hasActiveHeading);
            tools.addButtonToGroup('VFP:vitp:formats:toggleHeadings', 'VFP:vitp:formats:buttons');
            inlineToolbarPlugin.setSubSectionButton('VFP:vitp:formats:toggleHeadings', 'VFP:vitp:heading:subSection');
        }

        // Anchor and Class.
        if (selectedNode.nodeType === dfx.ELEMENT_NODE
            || data.range.startContainer.parentNode === data.range.endContainer.parentNode
        ) {
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

            var attrBtnGroup = tools.createButtonGroup('VFP:vitp:buttons');
            inlineToolbarPlugin.addButton(attrBtnGroup);

            var anchorIDSubSectionCont = document.createElement('div');
            var anchorIdSubSection     = inlineToolbarPlugin.makeSubSection('VFP:vitp:anchor:subSection', anchorIDSubSectionCont);

            var id = '';
            var anchorBtnActive = false;
            if (selectedNode.nodeType === dfx.ELEMENT_NODE) {
                id = selectedNode.getAttribute('id');
                if (id) {
                    anchorBtnActive = true;
                }
            }

            tools.createButton('VFP:vitp:anchor:toggle', '', 'Anchor name (ID)', 'anchorID', function(subSectionState) {
                if (subSectionState === true) {
                    self._inlineToolbarActiveSubSection = 'anchor';
                }
            }, false, anchorBtnActive);
            tools.addButtonToGroup('VFP:vitp:anchor:toggle', 'VFP:vitp:buttons');
            inlineToolbarPlugin.setSubSectionButton('VFP:vitp:anchor:toggle', 'VFP:vitp:anchor:subSection');

            var idTextBox = tools.createTextbox('VFP:vitp:anchor:input', 'ID', id, function(value) {
                if (selectedNode.nodeType === dfx.ELEMENT_NODE) {
                    // Set the attribute of this node.
                    selectedNode.setAttribute('id', value);

                    if (dfx.isBlank(dfx.trim(value)) === true && dfx.isTag(selectedNode, 'span') === true) {
                        var remove = true;
                        for (var i = 0; i < selectedNode.attributes.length; i++) {
                            if (dfx.isBlank(dfx.trim(selectedNode.attributes[i].value)) === false) {
                                remove = false;
                            }
                        }

                        if (remove === true) {
                            // Span tag was most likely created just for the class attribute
                            // remove the span as its no longer needed.
                            var selectionStart = selectedNode.firstChild;
                            var selectionEnd   = selectedNode.lastChild;
                            while (selectedNode.firstChild) {
                                dfx.insertBefore(selectedNode, selectedNode.firstChild);
                            }

                            dfx.remove(selectedNode);
                            self.viper.selectNodeToNode(selectionStart, selectionEnd);
                            self.viper.fireCallbacks('Viper:selectionChanged', self.viper.getViperRange());
                        }
                    }

                    self._inlineToolbarActiveSubSection = 'anchor';
                } else {
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

                        var range = self.viper.getCurrentRange();
                        range.selectNode(span);
                        ViperSelection.addRange(range);
                        self.viper.adjustRange();

                        // We want to keep this textbox open so set this var.
                        if (dfx.hasClass(anchorIdSubSection, 'active') === true) {
                            self._inlineToolbarActiveSubSection = 'anchor';
                        }

                        self.viper.fireCallbacks('Viper:selectionChanged', range);
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
            var classSubSection = inlineToolbarPlugin.makeSubSection('VFP:vitp:class:subSection', classSubSectionCont);

            var className = '';
            var classBtnActive = false;
            if (selectedNode.nodeType === dfx.ELEMENT_NODE) {
                className = selectedNode.getAttribute('class');
                if (className) {
                    classBtnActive = true;
                }
            }

            tools.createButton('VFP:vitp:class:toggle', '', 'Class name', 'cssClass', function(subSectionState) {
                if (subSectionState === true) {
                    self._inlineToolbarActiveSubSection = 'class';
                }
            }, false, classBtnActive);
            tools.addButtonToGroup('VFP:vitp:class:toggle', 'VFP:vitp:buttons');
            inlineToolbarPlugin.setSubSectionButton('VFP:vitp:class:toggle', 'VFP:vitp:class:subSection');

            var classTextBox = tools.createTextbox('VFP:vitp:class:input', 'Class', className, function(value) {
                if (selectedNode.nodeType === dfx.ELEMENT_NODE) {
                    // Set the attribute of this node.
                    selectedNode.setAttribute('class', value);

                    if (dfx.isBlank(dfx.trim(value)) === true && dfx.isTag(selectedNode, 'span') === true) {
                        var remove = true;
                        for (var i = 0; i < selectedNode.attributes.length; i++) {
                            if (dfx.isBlank(dfx.trim(selectedNode.attributes[i].value)) === false) {
                                remove = false;
                            }
                        }

                        if (remove === true) {
                            // Span tag was most likely created just for the class attribute
                            // remove the span as its no longer needed.
                            var selectionStart = selectedNode.firstChild;
                            var selectionEnd   = selectedNode.lastChild;
                            while (selectedNode.firstChild) {
                                dfx.insertBefore(selectedNode, selectedNode.firstChild);
                            }

                            dfx.remove(selectedNode);
                            self.viper.selectNodeToNode(selectionStart, selectionEnd);
                            self.viper.fireCallbacks('Viper:selectionChanged', self.viper.getViperRange());
                        }
                    }

                    self._inlineToolbarActiveSubSection = 'class';
                } else {
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

                        var range = self.viper.getCurrentRange();
                        range.selectNode(span);
                        ViperSelection.addRange(range);
                        self.viper.adjustRange();

                        // We want to keep this textbox open so set this var.
                        if (dfx.hasClass(classSubSection, 'active') === true) {
                            self._inlineToolbarActiveSubSection = 'class';
                        }

                        self.viper.fireCallbacks('Viper:selectionChanged', range);
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
        var tools   = this.viper.ViperTools;
        var toolbar = this.toolbarPlugin;
        var self    = this;

        var _updateValue = function(textBox, attr) {
            var range   = self.viper.getViperRange();
            var element = range.getNodeSelection();
            var value   = '';
            if (element && element.nodeType === dfx.ELEMENT_NODE) {
                value = element.getAttribute(attr);
            }

            textBox.value = value;
            return value;
        };

        // Anchor.
        var anchorSubContent = document.createElement('div');
        var idTextbox = tools.createTextbox('VFP:vtp:anchor:input', 'ID', '', function(value) {
            // Apply the ID to the selection.
            self._setAttributeForSelection('id', value);
        });
        anchorSubContent.appendChild(idTextbox);

        var anchorBubble = toolbar.createBubble('VFP:vtp:anchor:bubble', 'Anchor ID', anchorSubContent, null, function() {
            _updateValue(dfx.getTag('input', idTextbox)[0], 'id');
        });

        var btnGroup = tools.createButtonGroup('VFP:vtp:buttons');

        tools.createButton('anchor', '', 'Anchor ID', 'anchorID');
        tools.addButtonToGroup('anchor', 'VFP:vtp:buttons');
        toolbar.setBubbleButton('VFP:vtp:anchor:bubble', 'anchor');

        // Class.
        var classSubContent = document.createElement('div');
        var classTextbox = tools.createTextbox('VFP:vtp:class:input', 'Class', '', function(value) {
            self._setAttributeForSelection('class', value);
        });
        classSubContent.appendChild(classTextbox);

        var classBubble     = toolbar.createBubble('VFP:vtp:class:bubble', 'Class', classSubContent, null, function() {
            _updateValue(dfx.getTag('input', classTextbox)[0], 'class');
        });

        tools.createButton('class', '', 'CSS Class', 'cssClass');
        tools.addButtonToGroup('class', 'VFP:vtp:buttons');
        toolbar.setBubbleButton('VFP:vtp:class:bubble', 'class');
        toolbar.addButton(btnGroup);


        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperFormatPlugin', function(data) {
            if (data.range.collapsed === true
                || data.range.startContainer.parentNode !== data.range.endContainer.parentNode
            ) {
                tools.disableButton('anchor');
                tools.disableButton('class');
                toolbar.closeBubble('VFP:vtp:class:bubble');
                toolbar.closeBubble('VFP:vtp:anchor:bubble');
            } else {
                tools.enableButton('anchor');
                tools.enableButton('class');
            }

            if (_updateValue(dfx.getTag('input', idTextbox)[0], 'id')) {
                tools.setButtonActive('anchor');
            } else {
                tools.setButtonInactive('anchor');
            }

            if (_updateValue(dfx.getTag('input', classTextbox)[0], 'class')) {
                tools.setButtonActive('class');
            } else {
                tools.setButtonInactive('class');
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

    _setAttributeForSelection: function(attr, value)
    {
        var range = this.viper.getViperRange();

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

                        if (t === 'td' || t == 'th') {
                            blockParent.appendChild(newElem);
                        } else {
                            dfx.insertBefore(blockParent, newElem);
                        }

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
