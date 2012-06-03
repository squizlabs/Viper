/**
 * +--------------------------------------------------------------------+
 * | This Squiz Viper file is Copyright (c) Squiz Australia Pty Ltd     |
 * | ABN 53 131 581 247                                                 |
 * +--------------------------------------------------------------------+
 * | IMPORTANT: Your use of this Software is subject to the terms of    |
 * | the Licence provided in the file licence.txt. If you cannot find   |
 * | this file please contact Squiz (www.squiz.com.au) so we may        |
 * | provide you a copy.                                                |
 * +--------------------------------------------------------------------+
 *
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

    this.initInlineToolbar();

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

        this.viper.registerCallback('ViperTableEditorPlugin:initToolbar', 'ViperFormatPlugin', function(data) {
            self._createTableEditorContent(data.toolbar, data.type);
        });

        this.viper.registerCallback('ViperTableEditorPlugin:updateToolbar', 'ViperFormatPlugin', function(data) {
            self._updateTableEditorContent(data);
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
            p: 'P',
            div: 'DIV',
            blockquote: 'Quote',
            pre: 'PRE'
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
            && selectedNode !== this.viper.getViperElement()
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

    initInlineToolbar: function()
    {
        var self = this;
        this.viper.registerCallback('ViperInlineToolbarPlugin:initToolbar', 'ViperFormatPlugin', function(toolbar) {
            self.createInlineToolbar(toolbar);
        });
        this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperFormatPlugin', function(data) {
            self.updateInlineToolbar(data);
        });

    },

    createInlineToolbar: function(toolbar)
    {
        var tools  = this.viper.ViperTools;
        var prefix = 'ViperFormatPlugin:vitp:';
        var self   = this;

        // Headings format section.
        var headingsSubSection = toolbar.makeSubSection(prefix + 'heading:subSection', this._getHeadingsSection(prefix));

        // Formats section.
        var formatsSubSection = toolbar.makeSubSection(prefix + 'formats:subSection', this._getFormatsSection(prefix));

        var buttonGroup = tools.createButtonGroup(prefix + 'formatsAndHeading:buttons');
        toolbar.addButton(buttonGroup);

        tools.createButton('vitpFormats', '', 'Toggle Formats', 'Viper-formats');
        tools.addButtonToGroup('vitpFormats', prefix + 'formatsAndHeading:buttons');
        toolbar.setSubSectionButton('vitpFormats', prefix + 'formats:subSection');

        tools.createButton('vitpHeadings', '', 'Toggle Headings', 'Viper-headings');
        tools.addButtonToGroup('vitpHeadings', prefix + 'formatsAndHeading:buttons');
        toolbar.setSubSectionButton('vitpHeadings', prefix + 'heading:subSection');

        var buttonGroup = tools.createButtonGroup(prefix + 'anchorAndClassButtons');
        toolbar.addButton(buttonGroup);

        // Anchor.
        tools.createButton('vitpAnchor', '', 'Anchor name (ID)', 'Viper-anchorID');
        tools.addButtonToGroup('vitpAnchor', prefix + 'anchorAndClassButtons');

        toolbar.makeSubSection(prefix + 'anchor:subSection', this._getAnchorSection(prefix));
        toolbar.setSubSectionButton('vitpAnchor', prefix + 'anchor:subSection');
        toolbar.setSubSectionAction(prefix + 'anchor:subSection', function() {
            var value = tools.getItem(prefix + 'anchor:input').getValue();
            self._setAttributeForSelection('id', value);
        }, [prefix + 'anchor:input']);

        // Class.
        tools.createButton('vitpClass', '', 'Class name', 'Viper-cssClass');
        tools.addButtonToGroup('vitpClass', prefix + 'anchorAndClassButtons');

        toolbar.makeSubSection(prefix + 'class:subSection', this._getClassSection(prefix));
        toolbar.setSubSectionButton('vitpClass', prefix + 'class:subSection');
        toolbar.setSubSectionAction(prefix + 'class:subSection', function() {
            var value = tools.getItem(prefix + 'class:input').getValue();
            self._setAttributeForSelection('class', value);
        }, [prefix + 'class:input']);

    },

    updateInlineToolbar: function(data, removeLinkOnly)
    {
        if (!data.lineage || data.range.collapsed === true) {
            return;
        }

        var tools           = this.viper.ViperTools;
        var prefix          = 'ViperFormatPlugin:vitp:';
        var selectedNode    = data.lineage[data.current];

        // Heading section.
        if (this._canShowHeadingOptions(selectedNode) === true) {
            data.toolbar.showButton('vitpHeadings');

            for (var i = 1; i <= 6; i++) {
                var tagName = 'h' + i;
                for (var j = 0; j < data.lineage.length; j++) {
                    if (dfx.isTag(data.lineage[j], tagName) === true) {
                        tools.setButtonActive(prefix + 'heading:h' + i);
                        tools.setButtonActive('vitpHeadings');
                    } else {
                        tools.setButtonInactive(prefix + 'heading:h' + i);
                    }
                }
            }
        } else {
            tools.setButtonInactive('vitpHeadings');
            for (var i = 1; i <= 6; i++) {
                tools.setButtonInactive(prefix + 'heading:h' + i);
            }
        }//end if

        // Formats section.
        var formatButtons = {
            p: 'P',
            div: 'DIV',
            blockquote: 'Quote',
            pre: 'PRE'
        };

        if (this._canShowFormattingOptions(selectedNode) === true) {
            tools.getItem('vitpFormats').setIconClass('Viper-formats');
            data.toolbar.showButton('vitpFormats');

            for (var tag in formatButtons) {
                tools.setButtonInactive(prefix + 'formats:' + formatButtons[tag]);
            }

            for (var tag in formatButtons) {
               for (var j = data.current; j < data.lineage.length; j++) {
                    if (dfx.isTag(data.lineage[j], tag) === true) {
                        tools.setButtonActive(prefix + 'formats:' + formatButtons[tag]);
                        tools.setButtonActive('vitpFormats');
                        tools.getItem('vitpFormats').setIconClass('Viper-formats-' + tag);
                    }
                }
            }
        } else {
            tools.setButtonInactive('vitpFormats');
            for (var tag in formatButtons) {
                tools.setButtonInactive(prefix + 'formats:' + formatButtons[tag]);
            }
        }//end if

        buttonsToEnable = [];
        var startNode   = data.range.getStartNode();
        var endNode     = data.range.getEndNode();
        if (!endNode) {
            endNode = startNode;
        }
         // Anchor and Class.
        if (selectedNode.nodeType === dfx.ELEMENT_NODE
            || dfx.getFirstBlockParent(startNode) === dfx.getFirstBlockParent(endNode)
        ) {
            var attrId = this._getAttributeValue('id', selectedNode);
            if (attrId) {
                tools.setButtonActive('vitpAnchor');
            }

            var attrClass = this._getAttributeValue('class', selectedNode);
            if (attrClass) {
                tools.setButtonActive('vitpClass');
            }

            tools.getItem(prefix + 'anchor:input').setValue(attrId);
            tools.getItem(prefix + 'class:input').setValue(attrClass);

            data.toolbar.showButton('vitpAnchor');
            data.toolbar.showButton('vitpClass');
        }//end if

    },


    __createInlineToolbarContent: function(data)
    {

        var self         = this;
        var tools        = this.viper.ViperTools;
        var selectedNode = data.lineage[data.current];
        var toolbar      = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');
        var prefix       = 'ViperFormatPlugin:vitp:';


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
        tools.createButton('formats', '', 'Formats', 'Viper-formats', null, true);
        tools.createButton('headings', '', 'Headings', 'Viper-headings', null, true);
        tools.addButtonToGroup('formats', prefix + 'formatAndHeadingButtons');
        tools.addButtonToGroup('headings', prefix + 'formatAndHeadingButtons');
        toolbar.addButton(buttonGroup);

        var buttonGroup = tools.createButtonGroup(prefix + 'anchorAndClassButtons');
        tools.createButton('anchor', '', 'Anchor ID', 'Viper-anchorID', null, true);
        tools.createButton('class', '', 'Class', 'Viper-cssClass', null, true);
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
            p: 'P',
            div: 'DIV',
            blockquote: 'Quote',
            pre: 'PRE'
        };

        var ignoredTags = ('tr|table|tbody|caption|ul|ol|li|img').split('|');

        // Listen for the main toolbar update and update the statuses of the buttons.
        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperFormatPlugin', function(data) {
            var nodeSelection = data.range.getNodeSelection();
            var startNode = data.range.getStartNode();
            var endNode   = data.range.getEndNode();
            if (!endNode) {
                endNode = startNode;
            }

            if ((!nodeSelection || nodeSelection.nodeType !== dfx.ELEMENT_NODE || nodeSelection === self.viper.getViperElement())
                && (data.range.collapsed === true || dfx.getFirstBlockParent(startNode) !== dfx.getFirstBlockParent(endNode))
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

            if (!startNode
                && !endNode
                && data.range.startContainer === data.range.endContainer
            ) {
                startNode = data.range.startContainer;
            }

            tools.disableButton('headings');
            tools.disableButton('formats');

            if ((nodeSelection && ignoredTags.inArray(dfx.getTagName(nodeSelection)) === false)
                || ((!nodeSelection && dfx.getTagName(dfx.getFirstBlockParent(startNode)) !== 'li')
                && (!nodeSelection && self.handleFormat('div', true) === true))
            ) {
                if (!nodeSelection || dfx.isTag(nodeSelection, 'img') === false) {
                    var parents = dfx.getParents(startNode, 'caption', self.viper.getViperElement());
                    if (parents.length === 0) {
                        tools.enableButton('headings');
                        tools.enableButton('formats');
                    }
                }
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

            tools.getItem('formats').setIconClass('Viper-formats');
            var formatElement = self.getTagFromRange(data.range, ['p', 'div', 'pre', 'blockquote']);
            if (formatElement && (!nodeSelection || dfx.isTag(nodeSelection, 'img') === false)) {
                var tagName = dfx.getTagName(formatElement);
                tools.setButtonActive('formats');
                tools.setButtonActive(prefix + 'formats:' + formatButtons[tagName]);
                tools.getItem('formats').setIconClass('Viper-formats-' + tagName);
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

    _updateTableEditorContent: function(data)
    {
        if (data.type === 'cell'
            || data.type === 'row'
            || data.type === 'table'
        ) {
            var prefix  = 'ViperTableEditor-Format-'+ data.type + ':';
            var element = data.cell;

            switch (data.type) {
                case 'row':
                    element = element.parentNode;
                break;

                case 'table':
                    element = dfx.getParents(element, 'table')[0];
                break;

                default:
                    // Nothing.
                break;
            }

            // Add class button.
            var classBtnActive = false;
            var classAttribute = '';

            if (dfx.hasAttribute(element, 'class') === true) {
                classAttribute = element.getAttribute('class');
                this.viper.ViperTools.setButtonActive(prefix + 'classBtn-' + data.type);
            } else {
                this.viper.ViperTools.setButtonInactive(prefix + 'classBtn-' + data.type);
            }

            this.viper.ViperTools.getItem(prefix + 'class:input').setValue(classAttribute);

            data.toolbar.showButton(prefix + 'classBtn-' + data.type);
        }

    },

    _createTableEditorContent: function(toolbar, type)
    {
        if (type === 'cell'
            || type === 'row'
            || type === 'table'
        ) {
            var prefix      = 'ViperTableEditor-Format-' + type + ':';
            var element     = null;
            var buttonIndex = null;

            switch (type) {
                case 'row':
                    buttonIndex = -1;
                break;

                case 'table':
                    buttonIndex = -1;
                break;

                default:
                    buttonIndex = null;
                break;
            }

            // Add class button.
            var tools = this.viper.ViperTools;

            var button = tools.createButton(prefix + 'classBtn-' + type, '', 'Class name', 'Viper-cssClass', null, false, false);
            toolbar.addButton(button, buttonIndex);

            var self = this;
            var tableEditorPlugin = this.viper.ViperPluginManager.getPlugin('ViperTableEditorPlugin');
            toolbar.makeSubSection(prefix + 'class:subSection-' + type, this._getClassSection(prefix));
            toolbar.setSubSectionAction(prefix + 'class:subSection-' + type, function() {
                var element  = tableEditorPlugin.getActiveCell();
                switch (type) {
                    case 'row':
                        element = element.parentNode;
                    break;

                    case 'table':
                        element = dfx.getParents(element, 'table')[0];
                    break;

                    default:
                        // Nothing.
                    break;
                }

                var value   = tools.getItem(prefix + 'class:input').getValue();
                if (element) {
                    self._setAttributeForElement(element, 'class', value);
                } else {
                    self._setAttributeForSelection('class', value);
                }

                if (value) {
                    tools.setButtonActive(prefix + 'classBtn-' + type);
                } else {
                    tools.setButtonInactive(prefix + 'classBtn-' + type);
                }

                self.viper.fireNodesChanged();
            }, [prefix + 'class:input']);

            toolbar.setSubSectionButton(prefix + 'classBtn-' + type, prefix + 'class:subSection-' + type);
        }//end if

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
            this.viper.fireNodesChanged();
            return;
        }

        // Wrap the selection with span tag.
        var bookmark = this.viper.createBookmark();

        // Move the elements between start and end of bookmark to the new
        // span tag. Then select the new span tag and update selection.
        var span = null;
        if (bookmark.start && bookmark.end) {
            if (bookmark.start.nextSibling
                && bookmark.start.nextSibling.nodeType === dfx.ELEMENT_NODE
                && bookmark.start.nextSibling === bookmark.end.previousSibling
            ) {
                span = bookmark.start.nextSibling;
                this.viper.removeBookmarks();
                this._setAttributeForElement(span, attr, value);
                range.selectNode(span);
            } else {
                var attributes = {attributes: {}};
                attributes.attributes[attr] = value;
                span = this.viper.surroundContents('span', attributes, range);
                if (!span) {
                    this.viper.selectBookmark(bookmark);
                } else {
                    this.viper.removeBookmark(bookmark);
                    range.selectNode(span);
                }
            }//end if

            ViperSelection.addRange(range);
            this.viper.adjustRange();

            this.viper.fireSelectionChanged(range, true);
            this.viper.fireNodesChanged();

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
                case 'th':
                case 'tr':
                case 'td':
                case 'table':
                case 'caption':
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
                case 'caption':
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
        testOnly          = testOnly || false;
        var range         = this.viper.getViperRange();
        var selectedNode  = range.getNodeSelection();
        var nodeSelection = selectedNode;
        var viperElement  = this.viper.getViperElement();

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
            var ignoreTags = ['li'];
            if (ignoreTags.inArray(dfx.getTagName(selectedNode)) === true) {
                return false;
            }

            if (testOnly === true) {
                return true;
            }

            if (selectedNode !== viperElement) {
                var bookmark = this.viper.createBookmark();

                if (dfx.isTag(selectedNode, 'td') === true
                    || dfx.isTag(selectedNode, 'th') === true
                    || dfx.isTag(selectedNode, 'caption') === true
                ) {
                    // Do not convert the TD tag.
                    var newElem = document.createElement(type);
                    while (selectedNode.firstChild) {
                        newElem.appendChild(selectedNode.firstChild);
                    }

                    selectedNode.appendChild(newElem);
                    this.viper.selectBookmark(bookmark);
                } else {
                    var newElem = this._convertSingleElement(selectedNode, type);

                    this.viper.selectBookmark(bookmark);
                    if (nodeSelection && newElem) {
                        range.selectNode(newElem);
                        ViperSelection.addRange(range);
                    }
                }

                this.viper.fireSelectionChanged(null, true);
                this.viper.fireNodesChanged();
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

        this.viper.fireCallbacks('ViperFormatPlugin:formatChanged', type);

    },

    _convertSingleElement: function(element, type)
    {
        if (dfx.isTag(element, type) === true) {
            if (type.indexOf('h') === 0) {
                // Heading to P tag.
                var p = document.createElement('p');
                while (element.firstChild) {
                    p.appendChild(element.firstChild);
                }

                dfx.insertBefore(element, p);
            } else {
                // This is element is already the specified type remove the element.
                while (element.firstChild) {
                    dfx.insertBefore(element, element.firstChild);
                }
            }

            if (type === 'pre') {
                this._convertNewLineToBr(element);
            }

            dfx.remove(element);
        } else {
            var newElem = document.createElement(type);
            while (element.firstChild) {
                newElem.appendChild(element.firstChild);
            }

            if (type === 'pre') {
                this._convertBrToNewLine(newElem);
            } else if (dfx.isTag(element, 'pre') === true) {
                this._convertNewLineToBr(newElem);
            }

            dfx.insertBefore(element, newElem);
            dfx.remove(element);

            return newElem;
        }

        return null;

    },

    _convertBrToNewLine: function(element)
    {
        var brTags = dfx.getTag('br', element);
        for (var i = 0; i < brTags.length; i++) {
            var node = document.createTextNode("\n");
            dfx.insertBefore(brTags[i], node);
            dfx.remove(brTags[i]);
        }

    },

    _convertNewLineToBr: function(element)
    {
        if (element.nodeType === dfx.TEXT_NODE) {
            var nlIndex = -1;

            do {
                nlIndex = element.data.lastIndexOf("\n");
                if (nlIndex >= 0) {
                    var newNode = element.splitText(nlIndex);
                    var br      = document.createElement('br');
                    dfx.insertBefore(newNode, br);

                    if (newNode.data.length === 1) {
                        dfx.remove(newNode);
                    } else {
                        newNode.data = newNode.data.substring(1, newNode.data.length);
                    }
                }
            } while (nlIndex >= 0);
        } else {
            var textNodes = dfx.getTextNodes(element);
            var c         = textNodes.length;
            for (var i = 0; i < c; i++) {
                var textNode = textNodes[i];
                this._convertNewLineToBr(textNode);
            }
        }

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
