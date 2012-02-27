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
        var self = this;

        // Main toolbar.
        this.toolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (this.toolbarPlugin) {
            this._createToolbarContent();
        }

        // Inline toolbar.
        this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperFormatPlugin', function(data) {
            self._createInlineToolbarContent(data);
        });

        this.viper.registerCallback('ViperTableEditorPlugin:updateToolbar', 'ViperFormatPlugin', function(data) {
            self._createTableEditorContent(data);
        });

        ViperChangeTracker.addChangeType('textFormatChange', 'Formatted', 'format');
        ViperChangeTracker.setDescriptionCallback('textFormatChange', function(node) {
            var format = self._getFormat(node);
            return self.styleTags[format];
        });

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

    _getHeadingsSection: function(prefix)
    {
        var self   = this;
        var tools  = this.viper.ViperTools;

        // Headings format section.
        var headingsSubSection = document.createElement('div');

        var headingBtnGroup = tools.createButtonGroup(prefix + 'headingFormats');
        headingsSubSection.appendChild(headingBtnGroup);

        for (var i = 1; i <= 6; i++) {
            (function(headingCount) {
                tools.createButton(prefix + 'heading:h' + headingCount, 'H' + headingCount, 'Convert to Heading ' + headingCount, null, function() {
                    self.handleFormat('h' + headingCount);
                });
                tools.addButtonToGroup(prefix + 'heading:h' + headingCount, prefix + 'headingFormats');
            }) (i);
        }//end for

        return headingsSubSection;

    },

    _getFormatsSection: function(prefix)
    {
        var self   = this;
        var tools  = this.viper.ViperTools;

        var formatsSubSection = document.createElement('div');
        var formatButtons = {
            blockquote: 'Quote',
            pre: 'PRE',
            div: 'DIV',
            p: 'P'
        };

        for (var tag in formatButtons) {
            (function(tagName) {
                var button = tools.createButton(prefix + 'formats:' + formatButtons[tagName], formatButtons[tagName], 'Convert to ' + formatButtons[tagName], null, function() {
                    self.handleFormat(tagName);
                });
                formatsSubSection.appendChild(button);
            })
            (tag);
        }

        return formatsSubSection;

    },

    _getAnchorSection: function(prefix)
    {
        var self  = this;
        var tools = this.viper.ViperTools;

        var anchorSubContent = document.createElement('div');
        var idTextbox = tools.createTextbox(prefix + 'anchor:input', 'ID', '');
        anchorSubContent.appendChild(idTextbox);

        return anchorSubContent;

    },

    _getClassSection: function(prefix, element)
    {
        var self  = this;
        var tools = this.viper.ViperTools;

        var classSubContent = document.createElement('div');
        var classTextbox = tools.createTextbox(prefix + 'class:input', 'Class', '');
        classSubContent.appendChild(classTextbox);

        return classSubContent;

    },

    _getToolbarContents: function(toolbarType)
    {
        var prefix = 'ViperFormatPlugin:' + toolbarType + ':';

        return {
            headings: this._getHeadingsSection(prefix),
            formats: this._getFormatsSection(prefix),
            anchor: this._getAnchorSection(prefix),
            cssClass: this._getClassSection(prefix)
        }

    },

    getNodeWithAttributeFromRange: function(attributeName, node)
    {
        if (!attributeName) {
            return null;
        }

        var range        = this.viper.getViperRange();
        var selectedNode = node || range.getNodeSelection();
        if (selectedNode
            && selectedNode.nodeType === dfx.ELEMENT_NODE
            && dfx.hasAttribute(selectedNode, attributeName) === true
        ) {
            return selectedNode;
        }

        return null;

    },

    _getAttributeValue: function(attribute, node)
    {
        node = this.getNodeWithAttributeFromRange(attribute, node);
        if (node) {
            return node.getAttribute(attribute);
        }

        return '';

    },

    getTagFromRange: function(range, tagNames)
    {
        var c = tagNames.length;

        var selectedNode = range.getNodeSelection();
        if (selectedNode && selectedNode.nodeType === dfx.ELEMENT_NODE) {
            for (var i = 0; i < c; i++) {
                if (dfx.isTag(selectedNode, tagNames[i]) === true) {
                    return selectedNode;
                }
            }
        }

        var viperElem = this.viper.getViperElement();
        var common    = range.getCommonElement();
        while (common) {
            if (common === viperElem) {
                return null;
            }

            for (var i = 0; i < c; i++) {
                if (dfx.isTag(common, tagNames[i]) === true) {
                    return common;
                }
            }

            if (dfx.isBlockElement(common) === true) {
                break;
            }

            common = common.parentNode;
        }

        return null;

    },

    _createInlineToolbarContent: function(data)
    {
        if (!data.lineage || data.range.collapsed === true) {
            return;
        }

        var self         = this;
        var tools        = this.viper.ViperTools;
        var selectedNode = data.lineage[data.current];
        var toolbar      = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');
        var prefix       = 'ViperFormatPlugin:vitp:';

        // Check heading.
        var headingsSubSection = null;
        var hasActiveHeading   = false;

        if (this._canShowHeadingOptions(selectedNode) === true) {
            // Headings format section.
            headingsSubSection = toolbar.makeSubSection(prefix + 'heading:subSection', this._getHeadingsSection(prefix));

            for (var i = 1; i <= 6; i++) {
                var tagName = 'h' + i;
                for (var j = 0; j < data.lineage.length; j++) {
                    if (dfx.isTag(data.lineage[j], tagName) === true) {
                        tools.setButtonActive(prefix + 'heading:h' + i);
                        hasActiveHeading = true;
                        break;
                    }
                }
            }//end for
        }//end if

        var formatsSubSection = null;
        var hasActiveFormat   = false;

        if (this._canShowFormattingOptions(selectedNode) === true) {
            // Formats section.
            formatsSubSection = toolbar.makeSubSection(prefix + 'formats:subSection', this._getFormatsSection(prefix));

            var formatButtons = {
                blockquote: 'Quote',
                pre: 'PRE',
                div: 'DIV',
                p: 'P'
            };

            for (var tag in formatButtons) {
               for (var j = data.current; j < data.lineage.length; j++) {
                    if (dfx.isTag(data.lineage[j], tag) === true) {
                        tools.setButtonActive(prefix + 'formats:' + formatButtons[tag]);
                        hasActiveFormat = true;
                        break;
                    }
                }
            }
        }//end if

        var buttonGroup = tools.createButtonGroup(prefix + 'formatsAndHeading:buttons');
        if (formatsSubSection || headingsSubSection) {
            toolbar.addButton(buttonGroup);
        }

        if (formatsSubSection) {
            tools.createButton('vitpFormats', 'Aa', 'Toggle Formats', 'formats', null, false, hasActiveFormat);
            tools.addButtonToGroup('vitpFormats', prefix + 'formatsAndHeading:buttons');
            toolbar.setSubSectionButton('vitpFormats', prefix + 'formats:subSection');
        }

        if (headingsSubSection) {
            tools.createButton('vitpHeadings', 'Hh', 'Toggle Headings', 'headings', null, false, hasActiveHeading);
            tools.addButtonToGroup('vitpHeadings', prefix + 'formatsAndHeading:buttons');
            toolbar.setSubSectionButton('vitpHeadings', prefix + 'heading:subSection');
        }

         // Anchor and Class.
        if (selectedNode.nodeType === dfx.ELEMENT_NODE
            || data.range.startContainer.parentNode === data.range.endContainer.parentNode
        ) {
            var anchorBtnActive = false;
            var attrId = this._getAttributeValue('id', selectedNode);
            if (attrId) {
                anchorBtnActive = true;
            }

            var classBtnActive = false;
            var attrClass      = this._getAttributeValue('class', selectedNode);
            if (attrClass) {
                classBtnActive = true;
            }

            var buttonGroup = tools.createButtonGroup(prefix + 'anchorAndClassButtons');
            toolbar.addButton(buttonGroup);

            // Anchor.
            tools.createButton('vitpAnchor', '', 'Anchor name (ID)', 'anchorID', null, false, anchorBtnActive);
            tools.addButtonToGroup('vitpAnchor', prefix + 'anchorAndClassButtons');

            toolbar.makeSubSection(prefix + 'anchor:subSection', this._getAnchorSection(prefix));
            toolbar.setSubSectionButton('vitpAnchor', prefix + 'anchor:subSection');
            toolbar.setSubSectionAction(prefix + 'anchor:subSection', function() {
                var value = tools.getItem(prefix + 'anchor:input').getValue();
                self._setAttributeForSelection('id', value);
            }, [prefix + 'anchor:input']);
            tools.getItem(prefix + 'anchor:input').setValue(attrId);

            // Class.
            tools.createButton('vitpClass', '', 'Class name', 'cssClass', null, false, classBtnActive);
            tools.addButtonToGroup('vitpClass', prefix + 'anchorAndClassButtons');

            toolbar.makeSubSection(prefix + 'class:subSection', this._getClassSection(prefix));
            toolbar.setSubSectionButton('vitpClass', prefix + 'class:subSection');
            toolbar.setSubSectionAction(prefix + 'class:subSection', function() {
                var value = tools.getItem(prefix + 'class:input').getValue();
                self._setAttributeForSelection('class', value);
            }, [prefix + 'class:input']);
            tools.getItem(prefix + 'class:input').setValue(attrClass);
        }//end if

    },

    _createToolbarContent: function()
    {
        var self    = this;
        var tools   = this.viper.ViperTools;
        var toolbar = this.toolbarPlugin;
        var prefix  = 'ViperFormatPlugin:vtp:';

        var content = this._getToolbarContents('vtp');

        // Toolbar buttons.
        var buttonGroup = tools.createButtonGroup(prefix + 'formatAndHeadingButtons');
        tools.createButton('formats', 'Aa', 'Formats', '');
        tools.createButton('headings', 'Hh', 'Headings', '');
        tools.addButtonToGroup('formats', prefix + 'formatAndHeadingButtons');
        tools.addButtonToGroup('headings', prefix + 'formatAndHeadingButtons');
        toolbar.addButton(buttonGroup);

        var buttonGroup = tools.createButtonGroup(prefix + 'anchorAndClassButtons');
        tools.createButton('anchor', '', 'Anchor ID', 'anchorID');
        tools.createButton('class', '', 'Class', 'cssClass');
        tools.addButtonToGroup('anchor', prefix + 'anchorAndClassButtons');
        tools.addButtonToGroup('class', prefix + 'anchorAndClassButtons');
        toolbar.addButton(buttonGroup);

        // Create the bubbles.
        toolbar.createBubble(prefix + 'formatsBubble', 'Formats', null, content.formats);
        toolbar.setBubbleButton(prefix + 'formatsBubble', 'formats');

        toolbar.createBubble(prefix + 'headingsBubble', 'Headings', null, content.headings);
        toolbar.setBubbleButton(prefix + 'headingsBubble', 'headings');

        toolbar.createBubble(prefix + 'anchorBubble', 'Anchor ID', content.anchor);
        toolbar.setBubbleButton(prefix + 'anchorBubble', 'anchor');
        tools.getItem(prefix + 'anchorBubble').setSubSectionAction(prefix + 'anchorBubbleSubSection', function() {
            var value = tools.getItem(prefix + 'anchor:input').getValue();
            self._setAttributeForSelection('id', value);
        }, [prefix + 'anchor:input']);

        toolbar.createBubble(prefix + 'classBubble', 'Class', content.cssClass);
        toolbar.setBubbleButton(prefix + 'classBubble', 'class');
        tools.getItem(prefix + 'classBubble').setSubSectionAction(prefix + 'classBubbleSubSection', function() {
            var value = tools.getItem(prefix + 'class:input').getValue();
            self._setAttributeForSelection('class', value);
        }, [prefix + 'class:input']);

        var headingTags   = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
        var formatButtons = {
            blockquote: 'Quote',
            pre: 'PRE',
            div: 'DIV',
            p: 'P'
        };

        // Listen for the main toolbar update and update the statuses of the buttons.
        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperFormatPlugin', function(data) {
            if (data.range.collapsed === true
                || data.range.startContainer.parentNode !== data.range.endContainer.parentNode
            ) {
                tools.disableButton('anchor');
                tools.disableButton('class');
                tools.setButtonInactive('anchor');
                tools.setButtonInactive('class');
            } else {
                tools.enableButton('anchor');
                tools.enableButton('class');

            }

            tools.enableButton('headings');
            tools.enableButton('formats');
            tools.setButtonInactive('headings');
            tools.setButtonInactive('formats');

            for (var i = 0; i < headingTags.length; i++) {
                tools.setButtonInactive(prefix + 'heading:' + headingTags[i]);
            }

            var headingElement = self.getTagFromRange(data.range, headingTags);
            if (headingElement) {
                var tagName = dfx.getTagName(headingElement);
                tools.setButtonActive('headings');
                tools.setButtonActive(prefix + 'heading:' + tagName);
            }

            for (var tagName in formatButtons) {
                tools.setButtonInactive(prefix + 'formats:' + formatButtons[tagName]);
            }

            var formatElement = self.getTagFromRange(data.range, ['p', 'div', 'pre', 'blockquote']);
            if (formatElement) {
                var tagName = dfx.getTagName(formatElement);
                tools.setButtonActive('formats');
                tools.setButtonActive(prefix + 'formats:' + formatButtons[tagName]);
            }

            var attrId = self._getAttributeValue('id');
            tools.getItem(prefix + 'anchor:input').setValue(attrId);
            if (attrId) {
                tools.setButtonActive('anchor');
            } else {
                tools.setButtonInactive('anchor');
            }

            var attrClass = self._getAttributeValue('class');
            tools.getItem(prefix + 'class:input').setValue(attrClass);
            if (attrClass) {
                tools.setButtonActive('class');
            } else {
                tools.setButtonInactive('class');
            }
        });

    },

    _createTableEditorContent: function(data)
    {
        if (data.type === 'cell'
            || data.type === 'row'
            || data.type === 'table'
        ) {
            var prefix  = 'ViperTableEditor-Format:';
            var element = null;

            switch (data.type) {
                case 'row':
                    element = data.cell.parentNode;
                break;

                case 'table':
                    element = dfx.getParents(data.cell, 'table')[0];
                break;

                case 'cell':
                default:
                    element = data.cell;
                break;
            }

            // Add class button.
            var tools          = this.viper.ViperTools;
            var classBtnActive = false;
            var classAttribute = '';

            if (dfx.hasAttribute(element, 'class') === true) {
                classAttribute = element.getAttribute('class');
                classBtnActive = true;
            }

            var button = tools.createButton(prefix + 'classBtn', '', 'Class name', 'cssClass', null, false, classBtnActive);
            data.toolbar.addButton(button);

            var self = this;
            data.toolbar.makeSubSection(prefix + 'class:subSection', this._getClassSection(prefix));
            data.toolbar.setSubSectionAction(prefix + 'class:subSection', function() {
                var value = tools.getItem(prefix + 'class:input').getValue();
                if (element) {
                    self._setAttributeForElement(element, 'class', value);
                } else {
                    self._setAttributeForSelection('class', value);
                }

                if (value) {
                    tools.setButtonActive(prefix + 'classBtn');
                } else {
                    tools.setButtonInactive(prefix + 'classBtn');
                }
            }, [prefix + 'class:input']);

            data.toolbar.setSubSectionButton(prefix + 'classBtn', prefix + 'class:subSection');
            tools.getItem(prefix + 'class:input').setValue(classAttribute);
        }

    },

    _setAttributeForElement: function(element, attr, value)
    {
        if (element.nodeType === dfx.ELEMENT_NODE) {
            // Set the attribute of this element.
            this.viper.setAttribute(element, attr, value);
            return element;
        }

        return null;

    },

    _setAttributeForSelection: function(attr, value)
    {
        var range = this.viper.getViperRange();
        var selectedNode = range.getNodeSelection();
        if (selectedNode) {
            this.viper.setAttribute(selectedNode, attr, value);
            this.viper.fireSelectionChanged(null, true);
            this.viper.fireNodesChanged([this.viper.getViperElement()]);
            return;
        }

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
        var range        = this.viper.getViperRange();
        var selectedNode = range.getNodeSelection();
        var elemsBetween = [];
        if (selectedNode === null) {
            var startNode   = range.getStartNode();
            var blockParent = this.getFirstBlockParent(startNode);
            if (!blockParent) {
                // Top level content. Create a new element.
                return this._handleTopLevelFormat(type, range);
            }

            if (dfx.isChildOf(startNode, this.viper.element) === false) {
                // TODO: Should we handle this case in createBookmark?
                range.setStart(this.viper.element, 0);
                range.setEnd(this.viper.element, this.viper.element.childNodes.length);
                ViperSelection.addRange(range);
                startNode = range.getStartNode();
                blockParent = this.getFirstBlockParent(startNode);
            }

            var bookmark = this.viper.createBookmark();

            // Handle Collapsed range.
            if (startNode && range.collapsed === true) {
                var newElem = document.createElement(type);
                this._addChangeTrackInfo(newElem);
                this._moveChildElements(blockParent, newElem);
                dfx.insertBefore(blockParent, newElem);
                dfx.remove(blockParent);

                this.viper.selectBookmark(bookmark);

                this.viper.fireNodesChanged([this.viper.getViperElement()]);
                this.viper.fireSelectionChanged(null, true);
                return;
            }

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

    _handleTopLevelFormat: function(type, range)
    {
        var bookmark = this.viper.createBookmark();

        // Find the block parent before and after the bookmarks.
        var elements = [];

        // Elements before..
        var node     = bookmark.start;
        while (node && dfx.isBlockElement(node) === false) {
            elements.unshift(node);
            node = node.previousSibling;
        }

        var insideSelection = dfx.getElementsBetween(bookmark.start, bookmark.end);
        var count = insideSelection.length;
        for (var i = 0; i < count; i++) {
            if (dfx.isBlockElement(insideSelection[i]) === true) {
                var group = [];
                for (var j = 0; j < insideSelection[i].childNodes.length; j++) {
                    group.push(insideSelection[i].childNodes[j]);
                }
                elements.push(group);
            } else {
                elements.push(insideSelection[i]);
            }
        }

        // Elements after..
        node = bookmark.end;
        while (node && dfx.isBlockElement(node) === false) {
            elements.push(node);
            node = node.nextSibling;
        }

        if (elements.length === 0) {
            return;
        }

        var newBlock    = document.createElement(type);
        var prevBlock   = newBlock;
        dfx.insertBefore(elements[0], newBlock);

        var c = elements.length;
        for (var i = 0; i < c; i++) {
            if (elements[i] instanceof Array) {
                newBlock = document.createElement(type);
                for (var j = 0; j < elements[i].length; j++) {
                    newBlock.appendChild(elements[i][j]);
                }

                dfx.insertAfter(prevBlock, newBlock);
                prevBlock = newBlock;
                newBlock = null;
            } else {
                if (!newBlock) {
                    newBlock = document.createElement(type);
                    dfx.insertAfter(prevBlock, newBlock);
                    prevBlock = newBlock;
                }

                newBlock.appendChild(elements[i]);
            }
        }

        this.viper.selectBookmark(bookmark);

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
