/**
 * JS Class for the Viper InlineToolbar Plugin.
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
 * @package   Viper
 * @author    Squiz Pty Ltd <products@squiz.net>
 * @copyright 2010 Squiz Pty Ltd (ACN 084 670 600)
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPLv2
 */
function ViperInlineToolbarPlugin(viper)
{
    this.viper                = viper;
    this._toolbar             = null;
    this._toolsContainer      = null;
    this._lineage             = null;
    this._lineageClicked      = false;
    this._currentLineageIndex = null;
    this._margin              = 15;

    this._subSections       = {};
    this._subSectionButtons = {};
    this._activeSection     = null;

    // Create the toolbar.
    this._createToolbar();

}

ViperInlineToolbarPlugin.prototype = {

    init: function()
    {
        var self = this;

        // Called when the selection is changed.
        var clickedInToolbar = false;
        this.viper.registerCallback('Viper:selectionChanged', 'ViperInlineToolbarPlugin', function(range) {
            if (clickedInToolbar === true || self.viper.rangeInViperBounds(range) === false) {
                clickedInToolbar = false;
                return;
            }

            if (self._lineageClicked !== true) {
                // Not selection change due to a lineage click so update the range object.
                // Note we can use cloneRange here but for whatever reason Firefox seems
                // to not do the cloning bit of cloneRange...
                self._originalRange = {
                    startContainer: range.startContainer,
                    endContainer: range.endContainer,
                    startOffset: range.startOffset,
                    endOffset: range.endOffset,
                    collapsed: range.collapsed
                }
            }

            // Update the toolbar position, contents and lineage for this new selection.
            self.updateToolbar(range);
        });

        // Hide the toolbar when user clicks anywhere.
        this.viper.registerCallback(['Viper:mouseDown', 'ViperHistoryManager:undo'], 'ViperInlineToolbarPlugin', function(data) {
            clickedInToolbar = false;
            if (data && data.target) {
                var target = dfx.getMouseEventTarget(data);
                if (target === self._toolbar || dfx.isChildOf(target, self._toolbar) === true) {
                    clickedInToolbar = true;
                    if (dfx.isTag(target, 'input') === true) {
                        // Allow event to bubble so the input element can get focus etc.
                        return true;
                    }

                    return false;
                }
            }

            self.hideToolbar();
        });

        this.viper.registerCallback('Viper:elementScaled', 'ViperInlineToolbarPlugin', function(data) {
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
            if (dfx.hasClass(self._toolbar, 'visible') === true) {
                self._updatePosition();
            }
        });

    },

    /**
     * Adds the given element as a sub section of the toolbar.
     *
     * @param {string} id       The id of the new sub section.
     * @param {DOMNode} element The DOMNode to convert to sub section.
     *
     * @return {DOMNode} The element that was passed in.
     */
    makeSubSection: function(id, element)
    {
        if (!element) {
            return false;
        }

        dfx.addClass(element, 'Viper-subSection');

        this._subSections[id] = element;

        this._subSectionContainer.appendChild(element);

        this.viper.ViperTools.addItem(id, {
            type: 'VITPSubSection',
            element: element
        });

        return element;

    },

    /**
     * Sets the specified button to toggle the given sub section.
     *
     * @param {string} buttonid     Id of the button.
     * @param {string} subSectionid Id of the sub section.
     */
    setSubSectionButton: function(buttonid, subSectionid)
    {
        if (!this._subSections[subSectionid]) {
            // Throw exception not a valid sub section id.
            throw new Error('Invalid sub section id: ' + subSectionid);
            return false;
        }

        var button = this.viper.ViperTools.getItem(buttonid).element;
        var self   = this;

        this._subSectionButtons[subSectionid] = buttonid;

        dfx.removeEvent(button, 'mousedown');
        dfx.addEvent(button, 'mousedown', function(e) {
            // Set the subSection to visible and hide rest of the sub sections.
            self.toggleSubSection(subSectionid);

            dfx.preventDefault(e);
        });

    },

    /**
     * Toggles the visibility of the specified sub section.
     *
     * @param {string} subSectionid The if of the sub section.
     */
    toggleSubSection: function(subSectionid)
    {
        var subSection = this._subSections[subSectionid];
        if (!subSection) {
            return false;
        }

        if (this._activeSection) {
            var prevSubSection = this._subSections[this._activeSection];
            if (prevSubSection) {
                dfx.removeClass(prevSubSection, 'active');
                dfx.removeClass(this.viper.ViperTools.getItem(this._subSectionButtons[this._activeSection]).element, 'selected');

                if (this._activeSection === subSectionid) {
                    dfx.removeClass(this._toolbar, 'subSectionVisible');
                    this._activeSection = null;
                    return;
                }
            }
        }

        var subSectionButton = this.viper.ViperTools.getItem(this._subSectionButtons[subSectionid]).element;
        // Make the button selected.
        dfx.addClass(subSectionButton, 'selected');

        dfx.addClass(subSection, 'active');
        dfx.addClass(this._toolbar, 'subSectionVisible');
        this._activeSection = subSectionid;
        this._updateSubSectionArrowPos();

    },

    /**
     * Adds the specified button or button group element to the tools panel.
     *
     * @param {DOMNode} button The button or the button group element.
     *
     * @return void
     */
    addButton: function(button)
    {
        this._toolsContainer.appendChild(button);

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
        this._activeSection = null;

        range = range || this.viper.getCurrentRange();

        dfx.removeClass(this._toolbar, 'subSectionVisible');

        if (this._lineageClicked !== true) {
            this._setCurrentLineageIndex(null);
        }

        var lineage = this._getSelectionLineage(range);
        if (!lineage || lineage.length === 0) {
            return;
        }

        dfx.addClass(this._toolbar, 'calcWidth');
        this._updateInnerContainer(range, lineage);
        dfx.removeClass(this._toolbar, 'calcWidth');

        if (!dfx.getHtml(this._toolsContainer)) {
            this.hideToolbar();
            this._lineageClicked = false;
            return;
        }

        if (this._lineageClicked === true) {
            this._lineageClicked = false;
            return;
        }

        this._updateLineage(lineage);
        this._updatePosition(range);
        this._updateSubSectionArrowPos();

    },

    /**
     * Hides the inline toolbar.
     */
    hideToolbar: function()
    {
        dfx.removeClass(this._toolbar, 'visible');

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
     * Creates the inline toolbar.
     *
     * The toolbar is added to the BODY element.
     */
    _createToolbar: function()
    {
        var main      = document.createElement('div');
        this._toolbar = main;

        this._lineage = document.createElement('ul');
        this._toolbar.appendChild(this._lineage);

        this._toolsContainer = document.createElement('div');
        this._toolbar.appendChild(this._toolsContainer);

        this._subSectionContainer = document.createElement('div');
        this._toolbar.appendChild(this._subSectionContainer);

        dfx.addClass(this._toolbar, 'ViperITP themeDark Viper-scalable');
        dfx.addClass(this._lineage, 'ViperITP-lineage');
        dfx.addClass(this._toolsContainer, 'ViperITP-tools');
        dfx.addClass(this._subSectionContainer, 'ViperITP-subSectionWrapper');

        if (navigator.userAgent.match(/iPad/i) !== null) {
            dfx.addClass(this._toolbar, 'device-ipad');
        }

        document.body.appendChild(this._toolbar);

    },

    /**
     * Upudates the position of the inline toolbar.
     *
     * @param {DOMRange} range        The DOMRange object.
     * @param {boolean}  verticalOnly If true then only the vertical position will be
     *                                updated.
     */
    _updatePosition: function(range, verticalOnly)
    {
        range = range || this.viper.getCurrentRange();

        var rangeCoords  = null;
        var selectedNode = range.getNodeSelection(range);
        if (selectedNode !== null) {
            rangeCoords = this._getElementCoords(selectedNode);
        } else {
            rangeCoords = range.rangeObj.getBoundingClientRect();
        }

        if (!rangeCoords || (rangeCoords.left === 0 && rangeCoords.top === 0 && this.viper.isBrowser('firefox') === true)) {
            var startNode = range.getStartNode();
            var endNode   = range.getEndNode();
            if (!startNode || !endNode) {
                return;
            }

            if (startNode.nodeType === dfx.TEXT_NODE
                && startNode.data.indexOf("\n") === 0
                && endNode.nodeType === dfx.TEXT_NODE
                && range.endOffset === endNode.data.length
            ) {
                range.setStart(endNode, endNode.data.length);
                range.collapse(true);
                rangeCoords = range.rangeObj.getBoundingClientRect();
            }
        }

        if (!rangeCoords) {
            if (this.viper.isBrowser('chrome') === true || this.viper.isBrowser('safari') === true) {
                // Webkit bug workaround. https://bugs.webkit.org/show_bug.cgi?id=65324.
                var startNode = range.getStartNode();
                if (startNode.nodeType === dfx.TEXT_NODE) {
                    if (range.startOffset < startNode.data.length) {
                        range.setEnd(startNode, (range.startOffset + 1));
                        rangeCoords = range.rangeObj.getBoundingClientRect();
                        range.collapse(true);
                        if (rangeCoords) {
                            rangeCoords.right = rangeCoords.left;
                        }
                    } else if (range.startOffset > 0) {
                        range.setStart(startNode, (range.startOffset - 1));
                        rangeCoords = range.rangeObj.getBoundingClientRect();
                        range.collapse(false);
                        if (rangeCoords) {
                            rangeCoords.right = rangeCoords.left;
                        }
                    }
                }
            } else {
                return;
            }//end if
        }//end if

        var scrollCoords = dfx.getScrollCoords();

        dfx.addClass(this._toolbar, 'calcWidth');
        dfx.setStyle(this._toolbar, 'width', 'auto');
        var toolbarWidth = dfx.getElementWidth(this._toolbar);
        dfx.removeClass(this._toolbar, 'calcWidth');
        dfx.setStyle(this._toolbar, 'width', toolbarWidth + 'px');

        var windowDim = dfx.getWindowDimensions();

        if (verticalOnly !== true) {
            var left = ((rangeCoords.left + ((rangeCoords.right - rangeCoords.left) / 2) + scrollCoords.x) - (toolbarWidth / 2));
            dfx.removeClass(this._toolbar, 'orientationLeft orientationRight');
            if (left < 0) {
                left += (toolbarWidth / 2);
                dfx.addClass(this._toolbar, 'orientationLeft');
            } else if (left + toolbarWidth > windowDim.width) {
                left -= (toolbarWidth / 2);
                dfx.addClass(this._toolbar, 'orientationRight');
            }

            dfx.setStyle(this._toolbar, 'left', left + 'px');
        }

        var top = (rangeCoords.bottom + this._margin + scrollCoords.y);

        dfx.setStyle(this._toolbar, 'top', top + 'px');
        dfx.addClass(this._toolbar, 'visible');

    },

    _updateSubSectionArrowPos: function()
    {
        if (!this._activeSection) {
            return;
        }

        var button = this._subSectionButtons[this._activeSection];
        if (!button) {
            return;
        }

        button = this.viper.ViperTools.getItem(button).element;
        if (!button) {
            return;
        }

        var buttonRect = dfx.getBoundingRectangle(button);
        var toolbarPos = dfx.getBoundingRectangle(this._toolbar);
        var xPos       = (buttonRect.x1 - toolbarPos.x1 + ((buttonRect.x2 - buttonRect.x1) / 2));
        dfx.setStyle(this._subSectionContainer.firstChild, 'left', xPos + 'px');

    },

    _getElementCoords: function(element)
    {
        var elemRect     = dfx.getBoundingRectangle(element);
        var scrollCoords = dfx.getScrollCoords();
        return {
            left: (elemRect.x1 - scrollCoords.x),
            right: (elemRect.x2 - scrollCoords.x),
            top: (elemRect.y1 - scrollCoords.y),
            bottom: (elemRect.y2 - scrollCoords.y)
        };

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
                dfx.addClass(parent, 'selected');
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

                    dfx.removeClass(linElems, 'selected');
                    dfx.addClass(clickElem, 'selected');

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
        dfx.addClass(parent, 'ViperITP-lineageItem selected');
        dfx.setHtml(parent, 'Selection');
        linElems.push(parent);
        this._lineage.appendChild(parent);

        dfx.addEvent(parent, 'mousedown.ViperInlineToolbarPlugin', function(e) {
            self.viper.fireCallbacks('ViperInlineToolbarPlugin:lineageClicked');

            // When clicked set the selection to the original selection.
            self._lineageClicked = true;
            self._setCurrentLineageIndex(lineage.length - 1);

            dfx.removeClass(linElems, 'selected');
            dfx.addClass(parent, 'selected');

            if (self.viper.isBrowser('msie') === true) {
                // IE changes the range when the mouse is released on an element
                // that is not part of viper causing Viper to lose focus..
                // Use time out to set the range back in to Viper..
                setTimeout(function() {
                    self._selectPreviousRange();
                }, 50);
            } else {
                self._selectPreviousRange();
            }

            dfx.preventDefault(e);
            return false;
        });

    },

    _selectNode: function(node)
    {
        // Set the range.
        ViperSelection.removeAllRanges();
        var range = this.viper.getCurrentRange();

        var first = range._getFirstSelectableChild(node);
        var last  = range._getLastSelectableChild(node);
        range.setStart(first, 0);
        range.setEnd(last, last.data.length);

        ViperSelection.addRange(range);
        viper.fireSelectionChanged(range, true);

        // Update the position of the toolbar vertically only.
        this._updatePosition(range, true);
        this._updateSubSectionArrowPos();

    },

    _selectPreviousRange: function()
    {
        ViperSelection.removeAllRanges();
        var range = this.viper.getCurrentRange();
        range.setStart(this._originalRange.startContainer, this._originalRange.startOffset);
        range.setEnd(this._originalRange.endContainer, this._originalRange.endOffset);
        ViperSelection.addRange(range);
        viper.fireSelectionChanged(range);
        this._updatePosition(range, true);
        this._updateSubSectionArrowPos();

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

        dfx.empty(this._toolsContainer);
        dfx.setHtml(this._subSectionContainer, '<span class="subSectionArrow"></span>');

        if (this._currentLineageIndex === null || this._currentLineageIndex > lineage.length) {
            this._setCurrentLineageIndex(lineage.length - 1);
        }

        var data = {
            range: range,
            lineage: lineage,
            current: this._currentLineageIndex
        };

        this.viper.fireCallbacks('ViperInlineToolbarPlugin:updateToolbar', data);

    },

    _setCurrentLineageIndex: function(index)
    {
        this._currentLineageIndex = index;

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
