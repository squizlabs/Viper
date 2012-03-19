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

        var startNode = data.range.getStartNode();
        var endNode   = data.range.getEndNode();
        if (!endNode) {
            endNode = startNode;
        }
         // Anchor and Class.
        if (selectedNode.nodeType === dfx.ELEMENT_NODE
            || startNode.parentNode === endNode.parentNode
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
        tools.createButton('formats', 'Aa', 'Formats', '', null, true);
        tools.createButton('headings', 'Hh', 'Headings', '', null, true);
        tools.addButtonToGroup('formats', prefix + 'formatAndHeadingButtons');
        tools.addButtonToGroup('headings', prefix + 'formatAndHeadingButtons');
        toolbar.addButton(buttonGroup);

        var buttonGroup = tools.createButtonGroup(prefix + 'anchorAndClassButtons');
        tools.createButton('anchor', '', 'Anchor ID', 'anchorID', null, true);
        tools.createButton('class', '', 'Class', 'cssClass', null, true);
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

            // Test format change.
            if (self.handleFormat('div', true) === true) {
                tools.enableButton('headings');
                tools.enableButton('formats');
            } else {
                tools.disableButton('headings');
                tools.disableButton('formats');
            }

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
            var prefix      = 'ViperTableEditor-Format:';
            var element     = null;
            var buttonIndex = null;

            switch (data.type) {
                case 'row':
                    element     = data.cell.parentNode;
                    buttonIndex = -1;
                break;

                case 'table':
                    element     = dfx.getParents(data.cell, 'table')[0];
                    buttonIndex = -1;
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
            data.toolbar.addButton(button, buttonIndex);

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
                case 'img':
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
                case 'img':
                    return false;
                break;

                default:
                    return true;
                break;
            }
        }

        return true;

    },

    /**
     * Handles the format change.
     *
     * @param {string}  type     The type of the element.
     * @param {boolean} testOnly If true then method will return true to indicate that
     *                           the change can be made but will not alter the DOM
     *                           structure.
     *
     * @return {boolean} True if the change can be made.
     */
    handleFormat: function(type, testOnly)
    {
        testOnly         = testOnly || false;
        var range        = this.viper.getCurrentRange();
        var selectedNode = range.getNodeSelection();
        var viperElement = this.viper.getViperElement();

        if (!selectedNode) {
            var startNode = range.getStartNode();
            var endNode   = range.getEndNode();
            if (!startNode || !endNode) {
                return;
            }

            var startParent = dfx.getFirstBlockParent(range.getStartNode());
            var endParent   = dfx.getFirstBlockParent(range.getEndNode());
            if (startParent === endParent) {
                selectedNode = startParent;
            }
        }

        if (selectedNode
            && (selectedNode.nodeType !== dfx.ELEMENT_NODE
            || dfx.isBlockElement(selectedNode) === false
            || dfx.isStubElement(selectedNode) === true
            )
        ) {
            // Text node, get the first block parent.
            selectedNode = dfx.getFirstBlockParent(selectedNode);
        }

        if (selectedNode) {
            if (testOnly === true) {
                return true;
            }

            if (selectedNode !== viperElement) {
                var bookmark = this.viper.createBookmark();

                this._convertSingleElement(selectedNode, type);

                this.viper.selectBookmark(bookmark);
                this.viper.fireNodesChanged([viperElement]);
                this.viper.fireSelectionChanged(null, true);
            } else {
                // We cannot convert the Viper element so we need to create a new
                // element from the textnodes that are around the current range.
                this._handleTopLevelFormat(type, range);
            }
        } else {
            var start    = range.getStartNode();
            var end      = range.getEndNode();
            var elements = dfx.getElementsBetween(start, end);
            elements.unshift(start);
            elements.push(end);

            var parents = [];
            var c       = elements.length;
            for (var i = 0; i < c; i++) {
                if (elements[i].nodeType === dfx.TEXT_NODE && dfx.isBlank(dfx.trim(elements[i].data)) === true) {
                    continue;
                } else if (dfx.isBlockElement(elements[i]) === true) {
                    parents.push(elements[i]);
                } else {
                    var parent    = dfx.getFirstBlockParent(elements[i]);
                    if (parent && parents.inArray(parent) === false) {
                        parents.push(parent);
                    }
                }
            }

            // Check if all the parents are siblings. If there is a parent element
            // that is not a sibling see if its the only child of its parent and if
            // that is a sibling.
            var prevParent = null;
            var siblings   = true;
            var commonElem = range.getCommonElement();
            var newParents = [];

            for (var i = 0; i < parents.length; i++) {
                var parent = parents[i];
                if (parent.parentNode !== commonElem) {
                    var parentParents = dfx.getParents(parent, null, commonElem);

                    // Check if any of these parents are already in newParents array.
                    var skip = false;
                    if (newParents.length !== 0) {
                        for (var j = 0; j < parentParents.length; j++) {
                            if (newParents.inArray(parentParents[j]) === true) {
                                skip = true;
                                break;
                            }
                        }
                    }

                    if (skip === true) {
                        continue;
                    }

                    // Check if its the first child of its parent.
                    for (var j = 0; j < parentParents.length; j++) {
                        var parentParent = parentParents[j];
                        for (var node = parent.previousSibling; node; node = node.previousSibling) {
                            if (node && node.nodeType === dfx.ELEMENT_NODE || dfx.trim(node.data) !== '') {
                                return false;
                            }
                        }

                        parent = parentParent;
                    }

                    newParents.push(parent);
                } else {
                    newParents.push(parent);
                }//end if
            }//end for

            if (newParents.length > 0) {
                if (testOnly === true) {
                    return true;
                }

                var removeType = false;

                if (dfx.isTag(commonElem, type) === true && commonElem !== viperElement) {
                    var lastSelectableParent = range._getLastSelectableChild(commonElem).parentNode;
                    var lastParent = newParents[(newParents.length - 1)];
                    while (lastSelectableParent !== commonElem) {
                        if (lastSelectableParent === lastParent) {
                            removeType = true;
                            break;
                        }

                        lastSelectableParent = lastSelectableParent.parentNode;
                    }
                }

                var bookmark = this.viper.createBookmark();

                if (removeType === true) {
                    for (var i = 0; i < newParents.length; i++) {
                        dfx.insertBefore(commonElem, newParents[i]);
                    }

                    dfx.remove(commonElem);
                } else {
                    var newElem = document.createElement(type);
                    dfx.insertBefore(newParents[0], newElem);
                    for (var i = 0; i < newParents.length; i++) {
                        newElem.appendChild(newParents[i]);
                    }
                }

                this.viper.selectBookmark(bookmark);
                this.viper.fireNodesChanged([viperElement]);
                this.viper.fireSelectionChanged(null, true);
            }
        }//end if

    },

    _convertSingleElement: function(element, type)
    {
        if (dfx.isTag(element, type) === true) {
            // This is element is already the specified type remove the element.
            while (element.firstChild) {
                dfx.insertBefore(element, element.firstChild);
            }
        } else {
            var newElem = document.createElement(type);
            while (element.firstChild) {
                newElem.appendChild(element.firstChild);
            }

            dfx.insertBefore(element, newElem);
        }

        dfx.remove(element);

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
            if (dfx.isBlockElement(insideSelection[i]) === true && dfx.isStubElement(insideSelection[i]) === false) {
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

    },

    _addChangeTrackInfo: function(node)
    {
        if (ViperChangeTracker.isTracking() === true) {
            ViperChangeTracker.addChange('textFormatChange', [node]);
        }

    }

};
