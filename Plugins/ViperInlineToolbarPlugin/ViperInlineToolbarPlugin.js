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

        /*this.viper.registerCallback('Viper:elementScaled', 'ViperInlineToolbarPlugin', function(data) {
           if (data.element !== self._toolbar) {
               return false;
           }

           if (data.scale === 1) {
               self._margin = 15;
           } else {
               self._margin = (15 - (((1 - data.scale) / 0.1) * 5));
           }

           self.updateToolbar();
        });

        dfx.addEvent(window, 'resize', function() {
            if (dfx.hasClass(self._toolbar, 'Viper-visible') === true) {
                self._updatePosition();
            }
        });*/

    },

    setSettings: function(settings)
    {
        if (!settings) {
            return;
        }

        if (settings.buttons) {
            this._buttons = settings.buttons;
        }

    },

    _initToolbar: function()
    {
        var tools       = this.viper.ViperTools;
        var toolbarid   = 'ViperInlineToolbar';
        var self        = this;
        var toolbarElem = tools.createInlineToolbar(toolbarid, false, null, function(range) {
            self.updateToolbar(range);
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
    updateToolbar: function(range)
    {
        if (this._lineageClicked !== true) {
            // Not selection change due to a lineage click so update the range object.
            // Note we can use cloneRange here but for whatever reason Firefox seems
            // to not do the cloning bit of cloneRange...
            this._updateOriginalSelection(range);
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

        var lineage = this._getSelectionLineage(range);
        if (!lineage || lineage.length === 0) {
            return false;
        }

        this._updateInnerContainer(range, lineage);

        if (this._lineageClicked === true) {
            this._lineageClicked = false;
            return false;
        }

        this._updateLineage(lineage);
    },

    /**
     * Fires the updateToolbar event so that other plugins can modify the contents of the toolbar.
     *
     * @param {DOMRange} range   The DOMRange object.
     * @param {array}    lineage The lineage array.
     */
    _updateInnerContainer: function(range, lineage)
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
            toolbar: this._toolbarWidget
        };

        this.viper.fireCallbacks('ViperInlineToolbarPlugin:updateToolbar', data);

    },


    applyButtonsSetting: function()
    {
        // Get all the buttons from the container.
        var buttons = dfx.getClass('Viper-button', this._toolsContainer);
        var c       = buttons.length;

        if (c === 0) {
            return;
        }

        // Clear the buttons container contents.
        if (this.viper.isBrowser('msie') === true) {
            while(this._toolsContainer.firstChild) {
                this._toolsContainer.removeChild(this._toolsContainer.firstChild);
            }
        } else {
            this._toolsContainer.innerHTML = '';
        }

        // Get the button ids and their elements.
        var addedButtons = {};
        for (var i = 0; i < c; i++) {
            var button = buttons[i];
            var id     = button.id.toLowerCase().replace(this.viper.getId() + '-vitp', '');
            addedButtons[id] = button;
        }

        var bc = this._buttons.length;
        for (var i = 0; i < bc; i++) {
            var button = this._buttons[i];
            if (typeof button === 'string') {
                button = button.toLowerCase();
                if (addedButtons[button]) {
                    // Button is included in the setting, add it to the toolbar.
                    this.addButton(addedButtons[button]);
                }
            } else {
                var gc           = button.length;
                var groupid      = null;
                for (var j = 0; j < gc; j++) {
                    if (addedButtons[button[j].toLowerCase()]) {
                        if (groupid === null) {
                            // Create the group.
                            groupid      = 'ViperInlineToolbarPlugin:buttons:' + i;
                            groupElement = this.viper.ViperTools.createButtonGroup(groupid);
                            this.addButton(groupElement);
                        }

                        // Button is included in the setting, add it to group.
                        this.viper.ViperTools.addButtonToGroup('vitp' + dfx.ucFirst(button[j]), groupid);
                    }
                }
            }
        }

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
                        setTimeout(function() {
                            self._selectNode(selectionElem);
                        }, 50);
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
        range.setStart(first, 0);
        range.setEnd(last, last.data.length);

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

        range.setStart(this._originalRange.startContainer, this._originalRange.startOffset);
        range.setEnd(this._originalRange.endContainer, this._originalRange.endOffset);
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

    _updateOriginalSelection: function(range)
    {
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
    _getSelectionLineage: function(range)
    {
        var lineage       = [];
        var parent        = null;
        var nodeSelection = range.getNodeSelection(range);

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
                lineage.push(startNode);
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
