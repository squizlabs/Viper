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

function ViperInlineToolbarPlugin(viper)
{
    this.viper                = viper;
    this._lineage             = null;
    this._lineageClicked      = false;
    this._currentLineageIndex = null;
    this._lineageItemSelected = false;
    this._margin              = 15;
    this._toolbarWidget       = null;
    this._selectionLineage    = [];

    this._subSections             = {};
    this._subSectionButtons       = {};
    this._subSectionActionWidgets = {};

    this._topToolbar = null;
    this._buttons    = null;

}

ViperInlineToolbarPlugin.prototype = {

    init: function()
    {
        var self = this;

        this._topToolbar = this.viper.getPluginManager().getPlugin('ViperToolbarPlugin');
        this._initToolbar();

        this.viper.registerCallback('Viper:selectionChanged', 'ViperInlineToolbarPlugin', function() {
            if (self._toolbarWidget.isVisible() === false) {
                self._setCurrentLineageIndex(null);
            }

        });

        this.viper.registerCallback('Viper:getNodeSelection', 'ViperInlineToolbarPlugin', function(data) {
            var lineage         = self.getLineage();
            var currentLinIndex = self.getCurrentLineageIndex();

            var element = lineage[currentLinIndex];
            if (element && element.nodeType !== dfx.TEXT_NODE) {
                return element;
            }

            return null;
        });

    },

    setSettings: function(settings)
    {
        if (!settings) {
            return;
        }

        if (settings.buttons) {
            this._buttons = settings.buttons;

            if (this._toolbarWidget) {
                this._toolbarWidget.orderButtons(this._buttons);
            }
        }

    },

    getToolbar: function()
    {
        return this._toolbarWidget;

    },

    _initToolbar: function()
    {
        var tools       = this.viper.ViperTools;
        var toolbarid   = 'ViperInlineToolbar';
        var self        = this;
        var toolbarElem = tools.createInlineToolbar(toolbarid, false, null, function(range, nodeSelection) {
            self.updateToolbar(range, nodeSelection);
        });

        this._toolbarWidget = tools.getItem(toolbarid);

        // Add lineage container to the toolbar.
        var lineage = document.createElement('ul');
        dfx.addClass(lineage, 'ViperITP-lineage');
        dfx.insertBefore(toolbarElem.firstChild, lineage);
        this._lineage = lineage;

        var toolbar = tools.getItem(toolbarid);
        this.viper.fireCallbacks('ViperInlineToolbarPlugin:initToolbar', toolbar);

    },

    /**
     * Upudates the toolbar.
     *
     * This method is usually called by the Viper:selectionChanged event.
     *
     * @param {DOMRange} range The DOMRange object.
     */
    updateToolbar: function(range, nodeSelection)
    {
        if (this._lineageClicked !== true) {
            // Not selection change due to a lineage click so update the range object.
            // Note we can use cloneRange here but for whatever reason Firefox seems
            // to not do the cloning bit of cloneRange...
            this._updateOriginalSelection(range, nodeSelection);
        }

        if (this._topToolbar) {
            var bubble = this._topToolbar.getActiveBubble();
            if (bubble && bubble.getSetting('keepOpen') !== true) {
                return false;
            }
        }

        this._lineageItemSelected = false;

        if (this._lineageClicked !== true) {
            this._setCurrentLineageIndex(null);
        }

        var lineage = this._getSelectionLineage(range, nodeSelection);
        this._selectionLineage = lineage;
        if (!lineage || lineage.length === 0) {
            return false;
        }

        if (this.viper.isBrowser('firefox') === true
            && dfx.isTag(lineage[(lineage.length - 1)], 'br') === true
        ) {
            this.hideToolbar();
            return false;
        }

        this._updateInnerContainer(range, lineage, nodeSelection);

        if (this._lineageClicked === true) {
            this._lineageClicked = false;
            return false;
        }

        this._updateLineage(lineage);
    },

    hideToolbar: function()
    {
        this._toolbarWidget.hide();

    },

    /**
     * Fires the updateToolbar event so that other plugins can modify the contents of the toolbar.
     *
     * @param {DOMRange} range   The DOMRange object.
     * @param {array}    lineage The lineage array.
     */
    _updateInnerContainer: function(range, lineage, nodeSelection)
    {
        if (!lineage || lineage.length === 0) {
            return;
        }

        if (this._currentLineageIndex === null || this._currentLineageIndex > lineage.length) {
            this._setCurrentLineageIndex(lineage.length - 1);
        }

        var data = {
            range: range,
            lineage: lineage,
            current: this._currentLineageIndex,
            toolbar: this._toolbarWidget,
            nodeSelection: nodeSelection
        };

        this.viper.fireCallbacks('ViperInlineToolbarPlugin:updateToolbar', data);

    },

    /**
     * Returns a better tag name for the given DOMElement tag name.
     *
     * For example: strong -> Bold, u -> Underline.
     *
     * @param {string} tagName The tag name of a DOMElement.
     *
     * @return {string} The readable name.
     */
    getReadableTagName: function(tagName)
    {
        switch (tagName) {
            case 'strong':
                tagName = 'Bold';
            break;

            case 'u':
                tagName = 'Underline';
            break;

            case 'em':
            case 'i':
                tagName = 'Italic';
            break;

            case 'li':
                tagName = 'Item';
            break;

            case 'ul':
                tagName = 'List';
            break;

            case 'ol':
                tagName = 'List';
            break;

            case 'td':
                tagName = 'Cell';
            break;

            case 'tr':
                tagName = 'Row';
            break;

            case 'th':
                tagName = 'Header';
            break;

            case 'a':
                tagName = 'Link';
            break;

            case 'blockquote':
                tagName = 'Quote';
            break;

            case 'img':
                tagName = 'Image';
            break;

            default:
                tagName = tagName.toUpperCase();
            break;
        }//end switch

        return tagName;

    },

    /**
     * Selects the specified lineage index.
     *
     * @param {integer} index The lineage index to select.
     */
    selectLineageItem: function(index)
    {
        var tags = dfx.getTag('li', this._lineage);
        if (tags[index]) {
            dfx.trigger(tags[index], 'mousedown');
        }

    },

    getLineage: function()
    {
        this._selectionLineage = this._getSelectionLineage();
        return this._selectionLineage;

    },

    getCurrentLineageIndex: function()
    {
        if (this._currentLineageIndex !== null && this.viper.getViperRange().collapsed === false) {
            return this._currentLineageIndex;
        } else if (this._selectionLineage.length === 0) {
             return 0;
        } else {
            return (this._selectionLineage.length - 1)
        }

    },

    /**
     * Updates the contents of the lineage container.
     *
     * @param {array} lineage The lineage array.
     */
    _updateLineage: function(lineage)
    {
        // Remove the contents of the lineage container.
        dfx.empty(this._lineage);

        var viper    = this.viper;
        var c        = lineage.length;
        var self     = this;
        var linElems = [];

        // Create lineage items.
        for (var i = 0; i < c; i++) {
            if (!lineage[i].tagName) {
                continue;
            }

            var tagName = lineage[i].tagName.toLowerCase();
            var parent  = document.createElement('li');
            dfx.addClass(parent, 'ViperITP-lineageItem');

            if (i === (c - 1)) {
                dfx.addClass(parent, 'Viper-selected');
            }

            dfx.setHtml(parent, this.getReadableTagName(tagName));
            this._lineage.appendChild(parent);
            linElems.push(parent);

            (function(clickElem, selectionElem, index) {
                // When clicked set the user selection to the selected element.
                dfx.addEvent(clickElem, 'mousedown.ViperInlineToolbarPlugin', function(e) {
                    self.viper.fireCallbacks('ViperInlineToolbarPlugin:lineageClicked');

                    // We set the _lineageClicked to true here so that when the
                    // fireSelectionChanged is called we do not update the lineage again.
                    self._lineageClicked = true;
                    self._setCurrentLineageIndex(index);

                    dfx.removeClass(linElems, 'Viper-selected');
                    dfx.addClass(clickElem, 'Viper-selected');

                    if (self.viper.isBrowser('msie') === true) {
                        // IE changes the range when the mouse is released on an element
                        // that is not part of viper causing Viper to lose focus..
                        // Use time out to set the range back in to Viper..
                        self.viper.focus();
                        setTimeout(function() {
                            self._selectNode(selectionElem);
                        }, 30);
                    } else {
                        self._selectNode(selectionElem);
                    }

                    dfx.preventDefault(e);

                    return false;
                });
            }) (parent, lineage[i], i);
        }//end for

        if (this._originalRange.collapsed === true
            || (lineage[(lineage.length - 1)].nodeType !== dfx.TEXT_NODE)
        ) {
            // No need to add the 'Selection' item as its collapsed or a node is selected.
            return;
        }

        // Add the original user selection to the lineage.
        var parent = document.createElement('li');
        dfx.addClass(parent, 'ViperITP-lineageItem Viper-selected');
        dfx.setHtml(parent, 'Selection');
        linElems.push(parent);
        this._lineage.appendChild(parent);

        dfx.addEvent(parent, 'mousedown.ViperInlineToolbarPlugin', function(e) {
            self.viper.fireCallbacks('ViperInlineToolbarPlugin:lineageClicked');

            // When clicked set the selection to the original selection.
            self._lineageClicked = true;

            var prevIndex = self._currentLineageIndex;
            self._setCurrentLineageIndex(lineage.length - 1);

            dfx.removeClass(linElems, 'Viper-selected');
            dfx.addClass(parent, 'Viper-selected');

            if (self.viper.isBrowser('msie') === true) {
                // IE changes the range when the mouse is released on an element
                // that is not part of viper causing Viper to lose focus..
                // Use time out to set the range back in to Viper..
                setTimeout(function() {
                    self._selectPreviousRange(lineage, prevIndex);
                }, 50);
            } else {
                self._selectPreviousRange(lineage, prevIndex);
            }

            dfx.preventDefault(e);
            return false;
        });

    },

    _selectNode: function(node)
    {
        this.viper.focus();

        var range = this.viper.getViperRange();

        if (this._lineageItemSelected === false) {
            // Update original selection. We update it here incase the selectionHighlight
            // method changed the DOM structure (e.g. normalised textnodes), when
            // Viper is focused update the 'selection' range.
            this._updateOriginalSelection(range);
        }

        // Set the range.
        ViperSelection.removeAllRanges();
        range = this.viper.getViperRange();

        var first = range._getFirstSelectableChild(node);
        var last  = range._getLastSelectableChild(node);
        if (!first || !last) {
            range.selectNode(node);
        } else {
            range.setStart(first, 0);
            range.setEnd(last, last.data.length);
        }

        ViperSelection.addRange(range);

        this._toolbarWidget.closeActiveSubsection(true);
        this._toolbarWidget.setVerticalUpdateOnly(true);
        this.viper.fireSelectionChanged(range, true);
        this._toolbarWidget.setVerticalUpdateOnly(false);
        this._lineageItemSelected = true;

    },

    _selectPreviousRange: function(lineage, prevIndex)
    {
        this.viper.focus();

        ViperSelection.removeAllRanges();
        var range = this.viper.getViperRange();

        if (this._originalRange.nodeType) {
            range.selectNode(this._originalRange);
        } else {
            range.setStart(this._originalRange.startContainer, this._originalRange.startOffset);
            range.setEnd(this._originalRange.endContainer, this._originalRange.endOffset);
        }

        ViperSelection.addRange(range);


        this._toolbarWidget.closeActiveSubsection(true);
        this._toolbarWidget.setVerticalUpdateOnly(true);
        this.viper.fireSelectionChanged(range, true);
        this._toolbarWidget.setVerticalUpdateOnly(false);
        this._updateOriginalSelection(range);

    },

    _setCurrentLineageIndex: function(index)
    {
        this._currentLineageIndex = index;

    },

    _updateOriginalSelection: function(range, nodeSelection)
    {
        if (nodeSelection) {
            this._originalRange = nodeSelection;
            return;
        }

        this._originalRange = {
            startContainer: range.startContainer,
            endContainer: range.endContainer,
            startOffset: range.startOffset,
            endOffset: range.endOffset,
            collapsed: range.collapsed
        };

    },

    /**
     * Returns the selection's parent elements.
     *
     * @param {DOMRange} range The DOMRange object.
     *
     * @return {array} Array of DOMElements.
     */
    _getSelectionLineage: function(range, nodeSelection)
    {
        range             = range || this.viper.getViperRange();
        var lineage       = [];
        var parent        = null;
        var nodeSelection = nodeSelection || range.getNodeSelection(range, true);

        if (nodeSelection) {
            parent = nodeSelection;
        } else {
            parent        = range.getCommonElement();
            var startNode = range.getStartNode();
            if (!startNode) {
                return lineage;
            } else if (startNode.nodeType == dfx.TEXT_NODE
                && (startNode.data.length === 0 || dfx.isBlank(dfx.trim(startNode.data)) === true)
                && startNode.nextSibling
                && startNode.nextSibling.nodeType === dfx.TEXT_NODE
            ) {
                // The startNode is an empty textnode, most likely due to node splitting
                // if the next node is a text node use that instead.
                startNode = startNode.nextSibling;
            }

            if (startNode.nodeType !== dfx.TEXT_NODE || dfx.isBlank(startNode.data) !== true) {
                if (startNode !== dfx.TEXT_NODE && startNode !== range.getEndNode()) {
                    lineage.push(range.getEndNode());
                } else {
                    lineage.push(startNode);
                }
            }
        }

        var viperElement = this.viper.getViperElement();

        if (parent === viperElement) {
            return lineage;
        }

        if (parent) {
            lineage.push(parent);

            parent = parent.parentNode;

            while (parent && parent !== viperElement) {
                lineage.push(parent);
                parent = parent.parentNode;
            }
        }

        lineage = lineage.reverse();

        return lineage;

    }

};
