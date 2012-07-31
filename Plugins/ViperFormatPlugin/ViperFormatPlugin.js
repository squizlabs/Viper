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

    this.toolbarPlugin  = null;
    this.activeStyles   = [];
    this._range         = null;
    this._inlineToolbar = null;

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
            if (selectedNode === this.viper.getViperElement()) {
                return null;
            }

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

        this._inlineToolbar = this.viper.getPluginManager().getPlugin('ViperInlineToolbarPlugin');

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

        var ignoredTags = ['caption', 'li', 'ul', 'ol', 'img', 'table', 'tr', 'tbody', 'tfoot', 'thead'];

        var formatButtonStatuses = null;
        var currentElement       = data.lineage[data.current];

        if (dfx.isBlockElement(currentElement) === true && ignoredTags.inArray(dfx.getTagName(currentElement)) === false) {
            if (currentElement.nodeType === dfx.TEXT_NODE && data.lineage.length === 1) {
                formatButtonStatuses = this.getFormatButtonStatuses();
            } else {
                formatButtonStatuses = this.getFormatButtonStatuses(data.lineage[data.current]);
            }

            var enableFormatsButton  = false;
            for (var button in formatButtonStatuses) {
                if (button === '_none' || button === '_canChange') {
                    continue;
                }

                if (formatButtonStatuses[button] === true) {
                    enableFormatsButton = true;
                    tools.enableButton(prefix + 'formats:' + formatButtons[button]);
                    tools.setButtonInactive(prefix + 'formats:' + formatButtons[button]);
                } else {
                    tools.setButtonInactive(prefix + 'formats:' + formatButtons[button]);
                    tools.disableButton(prefix + 'formats:' + formatButtons[button]);
                }
            }

            tools.getItem('vitpFormats').setIconClass('Viper-formats');
            if (enableFormatsButton === true) {
                tools.enableButton('vitpFormats');

                if (currentElement.nodeType === dfx.TEXT_NODE && data.lineage.length > 1) {
                    currentElement = data.lineage[(data.current - 1)];
                } else if (dfx.isBlockElement(currentElement) === true) {
                    data.toolbar.showButton('vitpFormats');
                }

                var isBlockQuote = false;
                if (dfx.isTag(currentElement, 'p') === true
                    && dfx.isTag(currentElement.parentNode, 'blockquote') === true
                ) {
                    isBlockQuote = true;
                }

                for (var tag in formatButtons) {
                    if (dfx.isTag(currentElement, tag) === true) {
                        if (formatButtonStatuses[tag] === true) {
                            tools.enableButton(prefix + 'formats:' + formatButtons[tag]);

                            if (isBlockQuote !== true) {
                                tools.setButtonActive(prefix + 'formats:' + formatButtons[tag]);
                            }
                        }

                        tools.setButtonActive('vitpFormats');
                        if (isBlockQuote === true) {
                            tools.setButtonActive(prefix + 'formats:' + formatButtons['blockquote']);
                            tools.getItem('vitpFormats').setIconClass('Viper-formats-blockquote');
                        } else {
                            tools.setButtonActive(prefix + 'formats:' + formatButtons[tag]);
                            tools.getItem('vitpFormats').setIconClass('Viper-formats-' + tag);
                        }
                    }
                }
            } else {
                tools.disableButton('vitpFormats');
            }
        } else {
            tools.disableButton('vitpFormats');
        }

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

        var ignoredTags = ('tr|table|tbody|thead|tfoot|caption|ul|ol|li|img').split('|');

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

            if (!startNode
                && !endNode
                && data.range.startContainer === data.range.endContainer
            ) {
                startNode = data.range.startContainer;
            }

            tools.disableButton('headings');
            tools.disableButton('formats');
            tools.setButtonInactive('headings');
            tools.setButtonInactive('formats');

            var lineage         = self._inlineToolbar.getLineage();
            var currentLinIndex = self._inlineToolbar.getCurrentLineageIndex(true);
            var formatElement   = lineage[currentLinIndex];
            if (formatElement) {
                nodeSelection = formatElement;
            }

            if (self._canEnableFormatButtons(startNode, nodeSelection) === true) {
                if (nodeSelection) {
                    if (nodeSelection.nodeType === dfx.TEXT_NODE) {
                        // Disable the heading tag if the selection is in a blockquote
                        // with multiple paragraph tags.
                        var blockquote = dfx.getParents(nodeSelection, 'blockquote', self.viper.getViperElement());
                        if (blockquote.length > 0 && dfx.getTag('p', blockquote[0]).length > 1) {
                            tools.disableButton('headings');
                        } else {
                            tools.enableButton('headings');
                        }
                    } else if ((dfx.isTag(nodeSelection, 'blockquote') !== true
                        || dfx.getTag('p', nodeSelection).length <= 1)
                        && ((dfx.isTag(nodeSelection, 'p') !== true)
                        || dfx.isTag(nodeSelection.parentNode, 'blockquote') === false)
                    ) {
                        tools.enableButton('headings');
                        tools.enableButton('formats');
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

                // Update the Formats button statuses.
                tools.getItem('formats').setIconClass('Viper-formats');
                var highlightButton = true;
                var blockParent     = self.getTagFromRange(data.range, ['p', 'div', 'pre', 'blockquote']);
                var userParentTag   = false;

                if (!formatElement || formatElement.nodeType === dfx.TEXT_NODE || dfx.isBlockElement(formatElement) === false) {
                    if (data.range.collapsed === true) {
                        formatElement   = blockParent;
                    } else {
                        if (formatElement) {
                            var firstParent  = dfx.getFirstBlockParent(formatElement);
                            var commonParent = data.range.getCommonElement();
                            if (dfx.isBlockElement(commonParent) === false) {
                                commonParent = dfx.getFirstBlockParent(commonParent);
                            }

                            if (firstParent && firstParent === commonParent && formatButtons[dfx.getTagName(firstParent)]) {
                                userParentTag = true;
                                tools.getItem('formats').setIconClass('Viper-formats-' + dfx.getTagName(firstParent));
                            }
                        }

                        highlightButton = false;
                        formatElement = null;
                    }
                }

                var isBlockQuote = false;
                if (dfx.isTag(formatElement, 'p') === true
                    && dfx.isTag(formatElement.parentNode, 'blockquote') === true
                ) {
                    isBlockQuote = true;
                }

                var formatButtonStatuses = self.getFormatButtonStatuses(formatElement);
                if (formatButtonStatuses._canChange === true) {
                    tools.enableButton('formats');
                    for (var tag in formatButtons) {
                        if (formatButtonStatuses[tag] === true) {
                            tools.enableButton(prefix + 'formats:' + formatButtons[tag]);

                            if (tag !== 'blockquote' || isBlockQuote !== true) {
                                tools.setButtonInactive(prefix + 'formats:' + formatButtons[tag]);
                            }
                        } else {
                            tools.setButtonInactive(prefix + 'formats:' + formatButtons[tag]);
                            tools.disableButton(prefix + 'formats:' + formatButtons[tag]);
                        }

                        if (dfx.isTag(formatElement, tag) === true || (!formatElement && dfx.isTag(blockParent, tag) === true)) {
                            tools.setButtonActive('formats');

                            if (highlightButton === true) {
                                if (isBlockQuote === true) {
                                    tools.setButtonActive(prefix + 'formats:' + formatButtons['blockquote']);
                                    tools.getItem('formats').setIconClass('Viper-formats-blockquote');
                                } else {
                                    tools.setButtonActive(prefix + 'formats:' + formatButtons[tag]);
                                    tools.getItem('formats').setIconClass('Viper-formats-' + tag);
                                }
                            }
                        }
                    }
                } else {
                    if (formatElement && (!nodeSelection || dfx.isTag(nodeSelection, 'img') === false)) {
                        tools.getItem('formats').setIconClass('Viper-formats-' + dfx.getTagName(formatElement));
                    } else if (userParentTag === false) {
                        tools.getItem('formats').setIconClass('Viper-formats');
                    }

                    tools.disableButton('formats');
                }
            } else {
                tools.getItem('formats').setIconClass('Viper-formats');
            }//end if

            // Anchor.
            var attrId = self._getAttributeValue('id');
            tools.getItem(prefix + 'anchor:input').setValue(attrId);
            if (attrId) {
                tools.setButtonActive('anchor');
            } else {
                tools.setButtonInactive('anchor');
            }

            // Class.
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
                this.viper.surroundContents('span', attributes, range);

                this.viper.removeBookmarks();
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

                case 'blockquote':
                    if (dfx.getTag('p', node).length > 1) {
                        return false;
                    }
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

    _canEnableFormatButtons: function(startNode, nodeSelection)
    {
        // Direct parent ignore list.
        var ignoredTagsStr = 'tr|table|tbody|thead|tfoot|caption|ul|ol|li|img';
        var ignoredTags    = ignoredTagsStr.split('|');
        var viperElement   = self.viper.getViperElement();

        // If any of the parents of the element is one of these tags then ignore it.
        var parents = dfx.getParents(startNode, 'caption|ul|ol|li|img', viperElement);
        if (parents.length > 0 || dfx.isStubElement(startNode) === true) {
            return false;
        }

        if (nodeSelection) {
            if (ignoredTags.inArray(dfx.getTagName(nodeSelection)) === true) {
                return false;
            } else if (dfx.isBlockElement(nodeSelection) === false
                && ignoredTags.inArray(dfx.getTagName(dfx.getFirstBlockParent(nodeSelection))) === true
            ) {
                return false;
            }
        } else {
            if (ignoredTags.inArray(dfx.getTagName(dfx.getFirstBlockParent(startNode))) === true) {
                return false;
            } else if (ignoredTags.inArray(dfx.getTagName(dfx.getFirstBlockParent(nodeSelection))) === true) {
                return false;
            }
        }

        return true;

    },

    /**
     * Returns the statuses of buttons for the current range.
     *
     * @return {object}
     */
    getFormatButtonStatuses: function(element)
    {
        var statuses = {
            p: false,
            pre: false,
            div: false,
            blockquote: false,
            _none: false,
            _canChange: false
        };

        var range        = this.viper.getViperRange();
        var selectedNode = element || range.getNodeSelection();
        var viperElement = this.viper.getViperElement();

        if (!selectedNode && range.startContainer === range.endContainer && range.collapsed === true) {
            selectedNode = dfx.getFirstBlockParent(range.startContainer);
        }

        if (selectedNode === viperElement) {
            statuses = {
                p: true,
                pre: true,
                div: true,
                blockquote: true,
                _none: false,
                _canChange: true
            };

            return statuses;
        }

        if (selectedNode && dfx.isBlockElement(selectedNode) === true) {
            var isBlockquote = false;
            if (dfx.isTag(selectedNode, 'p') === true && dfx.isTag(selectedNode.parentNode, 'blockquote') === true) {
                selectedNode = selectedNode.parentNode;
                isBlockquote = true;
            }

            for (var tagName in statuses) {
                if (isBlockquote === true) {
                    statuses[tagName] = true;
                    continue;
                }

                var canConvert = this.canConvert(selectedNode, tagName);
                statuses[tagName] = canConvert;
                if (canConvert === true) {
                    statuses._canChange = true;
                }
            }
        } else if (selectedNode && selectedNode.nodeType === dfx.TEXT_NODE) {
            var parent = dfx.getFirstBlockParent(selectedNode);
            if (dfx.isTag(parent, 'div') === true) {
                statuses = {
                    p: true,
                    pre: true,
                    div: true,
                    blockquote: true
                };
            }
        } else {
            var start      = range.getStartNode();
            var end        = range.getEndNode();
            var elements   = dfx.getElementsBetween(start, end);
            var commonElem = range.getCommonElement();

            elements.unshift(start);

            if (start !== end && end) {
                elements.push(end);
            }

            var parents = [];
            for (var i = 0; i < elements.length; i++) {
                var elem = elements[i];
                if (elem.nodeType === dfx.TEXT_NODE && dfx.trim(elem.data) === '') {
                    continue;
                }

                if (dfx.isBlockElement(elem) === true) {
                    parents.push(elem);
                }

                var elemParents = dfx.getParents(elem, null, commonElem);
                for (var j = 0; j < elemParents.length; j++) {
                    if (dfx.isBlockElement(elemParents[j]) === true) {
                        parents.push(elemParents[j]);
                    }
                }
            }

            if (parents.length === 0) {
                // A text node is selected inside the same block parent.
                var parent = dfx.getFirstBlockParent(start);
                if (dfx.isTag(parent, 'div') === true) {
                    statuses = {
                        p: true,
                        pre: true,
                        div: true,
                        blockquote: true,
                        _canChange: true
                    };
                }
            } else {
                statuses.div = true;
                statuses._canChange = true;

                if (parents.length > 0) {
                    // If only P tags then blockquote is allowed.
                    var allowBlockquote = true;
                    for (var i = 0; i < parents.length; i++) {
                        if (dfx.isTag(parents[i], 'p') !== true) {
                            allowBlockquote = false;
                            break;
                        }
                    }

                    statuses.blockquote = allowBlockquote;
                }
            }
        }//end if

        return statuses;

    },

    canConvert: function(element, toTagName)
    {
        var tagName = dfx.getTagName(element);
        if (tagName === 'p') {
            // If the original tag is a P tag and its parent is a blockquote then
            // it cannot be converted or removed.
            if (dfx.isTag(element.parentNode, 'blockquote') === true) {
                return false;
            }
        } else if (toTagName === '_none') {
            // Tag can be removed.
            return true;
        }

        switch (toTagName) {
            case 'p':
                // Any element can be converted to a P unless there are child block
                // elements.
                if (this.hasBlockChildren(element) === true) {
                    return false;
                }

                // Or its in a PRE tag.
                var preTags = dfx.getParents(element, 'pre', this.viper.getViperElement());
                if (preTags.length > 0) {
                    return false;
                }
            break;

            case 'pre':
                if (this.hasBlockChildren(element) === true) {
                    return false;
                }
            break;

            case 'blockquote':
                var tags = dfx.getTag('*', element);
                for (var i = 0; i < tags.length; i++) {
                    if (dfx.isBlockElement(tags[i]) === true && dfx.isTag(tags[i], 'p') === false && dfx.isStubElement(tags[i]) === false) {
                        return false;
                    }
                }
            break;
        }

        return true;

    },

    hasBlockChildren: function(element)
    {
        var isBlockQuote = dfx.isTag(element, 'blockquote');
        var hasBlock     = false;

        var tags = dfx.getTag('*', element);
        for (var i = 0; i < tags.length; i++) {
            if (dfx.isBlockElement(tags[i]) === true && dfx.isStubElement(tags[i]) === false) {
                if (isBlockQuote === true && hasBlock === false && dfx.isTag(tags[i], 'p') === true) {
                    // In blockquote element only return true if there is more than
                    // one block element.
                    hasBlock = true;
                    continue;
                }

                return true;
            }
        }

        return false;

    },

    /**
     * Handles the format change.
     *
     * @param {string} type The type of the element.
     */
    handleFormat: function(type)
    {
        var range         = this.viper.getViperRange();
        var selectedNode  = range.getNodeSelection();
        var nodeSelection = selectedNode;
        var viperElement  = this.viper.getViperElement();

        if (selectedNode === viperElement) {
            selectedNode = null;
        }

        if (selectedNode
            && (selectedNode.nodeType !== dfx.ELEMENT_NODE
            || dfx.isBlockElement(selectedNode) === false
            || dfx.isStubElement(selectedNode) === true
            )
        ) {
            if (dfx.isBlockElement(selectedNode) === false) {
                selectedNode = null;
            } else {
                // Text node, get the first block parent.
                selectedNode = dfx.getFirstBlockParent(selectedNode);
            }
        } else if (!selectedNode && (range.collapsed === true || type.match(/h\d/))) {
            selectedNode = dfx.getFirstBlockParent(range.startContainer);
        }

        if (selectedNode) {
            var ignoreTags = ['li'];
            if (ignoreTags.inArray(dfx.getTagName(selectedNode)) === true) {
                return false;
            }

            if (selectedNode !== viperElement) {
                var bookmark = this.viper.createBookmark();

                if (dfx.isTag(selectedNode, 'td') === true
                    || dfx.isTag(selectedNode, 'th') === true
                    || dfx.isTag(selectedNode, 'caption') === true
                ) {
                    // Do not convert the TD tag.
                    var newElem = document.createElement(type);
                    if (type === 'blockquote' && dfx.getTag(selectedNode, 'p').length === 0) {
                        newElem.appendChild(document.createElement('p'));
                        while (selectedNode.firstChild) {
                            newElem.firstChild.appendChild(selectedNode.firstChild);
                        }
                    } else {
                        while (selectedNode.firstChild) {
                            newElem.appendChild(selectedNode.firstChild);
                        }
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

            if (start !== end && end) {
                if (end.nodeType === dfx.TEXT_NODE && range.endOffset > 0) {
                    elements.push(end);
                } else {
                    var elem = range.getPreviousContainer(end, null, true);
                    range.setEnd(elem, elem.data.length);
                    ViperSelection.addRange(range);
                }
            }

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

            if (parents.length === 1 && range.collapsed === false) {
                // Convert only the selection to specified element.
                // This will create the new element inside the parent element.
                var parent     = parents[0];
                var newElement = document.createElement(type);
                var contents   = range.getHTMLContents();

                if (type === 'blockquote') {
                    contents = '<p>' + contents + '</p>';
                }

                dfx.setHtml(newElement, contents);

                var bookmark = this.viper.createBookmark();
                dfx.remove(dfx.getElementsBetween(bookmark.start, bookmark.end));
                dfx.insertAfter(bookmark.start, newElement);
                this.viper.selectBookmark(bookmark);

                this.viper.fireNodesChanged([parent]);
                this.viper.fireSelectionChanged(null, true);
                this.viper.fireCallbacks('ViperFormatPlugin:formatChanged', type);

                return;
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
                if (parent !== commonElem && parent.parentNode !== commonElem) {
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
        var isBlockQuote = false;
        if (dfx.isTag(element, 'p') === true && dfx.isTag(element.parentNode, 'blockquote') === true) {
            element      = element.parentNode;
            isBlockQuote = true;
        } else if (dfx.isTag(element, 'blockquote') === true) {
            isBlockQuote = true;
        }

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
        } else if (type === 'blockquote') {
            var newElem = document.createElement(type);
            dfx.insertBefore(element, newElem);

            if (dfx.isTag(element, 'p') === true) {
                newElem.appendChild(element);
            } else if (dfx.getTag('p', element).length > 0) {
                while (element.firstChild) {
                    newElem.appendChild(element.firstChild);
                }

                dfx.remove(element);
            } else {
                var p = document.createElement('p');
                newElem.appendChild(p);
                while (element.firstChild) {
                    p.appendChild(element.firstChild);
                }

                dfx.remove(element);
            }

            return newElem;
        } else {
            var newElem = document.createElement(type);

            if (isBlockQuote === true && (type === 'p' || type === 'pre')) {
                for (var childPTag = element.firstChild; childPTag; childPTag = childPTag.nextSibling) {
                    while (childPTag.firstChild) {
                        newElem.appendChild(childPTag.firstChild);
                    }
                }
            } else if (isBlockQuote === true && type.match(/h\d/)) {
                while (element.firstChild) {
                    newElem.appendChild(element.firstChild);
                }

                var pTag = dfx.getTag('p', newElem)[0];
                while (pTag.firstChild) {
                    newElem.appendChild(pTag.firstChild);
                }

                dfx.remove(pTag);
            } else {
                while (element.firstChild) {
                    newElem.appendChild(element.firstChild);
                }
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
