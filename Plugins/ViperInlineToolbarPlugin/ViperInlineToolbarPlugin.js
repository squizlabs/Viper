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
    this._margin              = 10;

    // Create the toolbar.
    this._createToolbar();

    var self = this;

    // Called when the selection is changed.
    this.viper.registerCallback('Viper:selectionChanged', 'ViperInlineToolbarPlugin', function(range) {
        if (self._lineageClicked !== true) {
            // Not selection change due to a lineage click so update the range object.

            // Note we can use cloneRange here but for whatever reason Firefox seems
            // to not do the cloning bit of cloneRange...
            self._originalRange = {
                startContainer: range.startContainer,
                endContainer: range.endContainer,
                startOffset: range.startOffset,
                endOffset: range.endOffset,
                collapased: range.collapsed
            }
        }

        // Update the toolbar position, contents and lineage for this new selection.
        self.updateToolbar(range);
    });

    // Hide the toolbar when user clicks anywhere.
    this.viper.registerCallback(['Viper:mouseDown', 'ViperHistoryManager:undo'], 'ViperInlineToolbarPlugin', function(data) {
        if (data.target) {
            var target = dfx.getMouseEventTarget(data);
            if (target === self._toolbar || dfx.isChildOf(target, self._toolbar) === true) {
                return false;
            }
        }

        self.hideToolbar();
    });

    // During zooming hide the toolbar.
    dfx.addEvent(window, 'gesturestart', function() {
        self.hideToolbar();
    });

    // Update and show the toolbar after zoom.
    dfx.addEvent(window, 'gestureend', function() {
        self.updateToolbar();
    });

}

ViperInlineToolbarPlugin.prototype = {

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

        dfx.addClass(this._toolbar, 'ViperITP themeDark');
        dfx.addClass(this._lineage, 'ViperITP-lineage');
        dfx.addClass(this._toolsContainer, 'ViperITP-tools');
        dfx.addClass(this._subSectionContainer, 'ViperITP-subSectionWrapper');

        if (navigator.userAgent.match(/iPad/i) !== null) {
            dfx.addClass(this._toolbar, 'device-ipad');
        }

        document.body.appendChild(this._toolbar);

    },

    /**
     * Creates a button group.
     *
     * @param {string} customClass Custom class to apply to the group.
     *
     * @return {DOMElement} The button group element.
     */
    createButtonGroup: function(customClass)
    {
        return this._toolsContainer.appendChild(ViperTools.createButtonGroup(customClass));

    },

    /**
     * Creates a toolbar button.
     *
     * @param {string}     content        The content of the button.
     * @param {string}     isActive       True if the button is active.
     * @param {string}     titleAttr      The title attribute of the button.
     * @param {boolean}    disabled       True if the button is disabled.
     * @param {string}     customClass    Class to add to the button for extra styling.
     * @param {function}   clickAction    The function to call when the button is clicked.
     * @param {DOMElement} groupElement   The group element that was created by createButtonGroup.
     * @param {DOMElement} subSection     The sub section element see createSubSection.
     * @param {boolean}    showSubSection If true then sub section will be visible.
     *                                    If another button later on also has this set to true
     *                                    then that button's sub section visible.
     *
     * @return {DOMElement} The new button element.
     */
    createButton: function(content, isActive, titleAttr, disabled, customClass, clickAction, groupElement, subSection, showSubSection)
    {
        var self = this;
        if (clickAction) {
            var originalAction = clickAction;
            clickAction = function() {
                self._lineageClicked = false;
                return originalAction.call(this);
            };
        } else if (subSection) {
            clickAction = function(subSectionState, buttonElement) {
                if (subSectionState === true) {
                    dfx.addClass(self._toolbar, 'subSectionVisible');

                    // Remove selected state from other buttons in the toolbar.
                    var mainTools = subSection.parentNode.previousSibling;
                    dfx.removeClass(dfx.getClass('selected', mainTools), 'selected');
                    dfx.addClass(buttonElement, 'selected');
                } else {
                    dfx.removeClass(self._toolbar, 'subSectionVisible');
                    dfx.removeClass(button, 'selected');
                }
            };

            if (showSubSection === true) {
                dfx.addClass(this._toolbar, 'subSectionVisible');
            }
        }

        var button = ViperTools.createButton(content, isActive, titleAttr, disabled, customClass, clickAction, groupElement, subSection, showSubSection);

        if (!groupElement) {
            this._toolsContainer.appendChild(button);
        }

        return button;

    },

    /**
     * Creates a textbox.
     *
     * @param {DOMNode}  node   Element to select.
     * @param {string}   value  The initial value of the textbox.
     * @param {string}   label  The label of the textbox.
     * @param {function} action The function to call when the textbox value is updated.
     *
     * @return {DOMNode} If label specified the label element else the textbox element.
     */
    createTextbox: function(node, value, label, action)
    {
        var textBox = document.createElement('input');
        textBox.type  = 'text';
        textBox.size  = 10;
        textBox.value = value;

        var self  = this;
        dfx.addEvent(textBox, 'mousedown', function(e) {
            textBox.focus();
            dfx.preventDefault(e);
            return false;
        });

        dfx.addEvent(textBox, 'focus', function(e) {
            dfx.preventDefault(e);
            return false;
        });

        dfx.addEvent(textBox, 'mouseup', function(e) {
            dfx.preventDefault(e);
            return false;
        });

        var t = null;
        dfx.addEvent(textBox, 'keyup', function(e) {
            if (e.which === 13) {
                textBox.blur();

                var range = self.viper.getCurrentRange();
                ViperSelection.removeAllRanges();
                range.selectNode(node);
                ViperSelection.addRange(range);

                self.viper.focus();

                action.call(textBox, textBox.value);
                return;
            }

            dfx.addClass(textBox, 'active');

            clearTimeout(t);
            t = setTimeout(function() {
                dfx.removeClass(textBox, 'active');

                action.call(textBox, textBox.value);
            }, 1500);
        });

        if (label) {
            var labelElem = document.createElement('label');
            dfx.setHtml(labelElem, label);
            labelElem.appendChild(textBox);
            return labelElem;
        }

        return textBox;

    },

    /**
     * Creates a sub section element.
     *
     * @param {DOMElement} contentElement The content element.
     * @param {boolean}    active         True if the subsection is active.
     * @param {string}     customClass    Custom class to apply to the group.
     *
     * @return {DOMElement} The sub section element.
     */
    createSubSection: function(contentElement, active, customClass)
    {
        var subSection = ViperTools.createSubSection(contentElement, active, customClass);
        this._subSectionContainer.appendChild(subSection);
        return subSection;

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
        if (range.collapsed === true) {
            this.hideToolbar();
            return;
        }

        if (navigator.userAgent.match(/iPad/i) !== null) {
            this._scaleToolbar();
        }

        dfx.removeClass(this._toolbar, 'subSectionVisible');

        range = range || this.viper.getCurrentRange();

        if (this._lineageClicked !== true) {
            this._setCurrentLineageIndex(null);
        }

        var lineage = this._getSelectionLineage(range);

        this._updateInnerContainer(range, lineage);

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
     * Scales the toolbar using CSS transforms.
     *
     * Used on iPad only to scale the toolbar as user zooms in/out.
     */
    _scaleToolbar: function()
    {
        if (!this._toolbar) {
            return;
        }

        var zoom  = (document.documentElement.clientWidth / window.innerWidth);
        if (zoom === 1) {
            var scale = 1;
            this._margin = 15;
            dfx.setStyle(this._toolbar, '-webkit-transform', 'scale(' + scale + ', ' + scale + ')');
            dfx.setStyle(this._toolbar, '-moz-transform', 'scale(' + scale + ', ' + scale + ')');
            return;
        }

        var scale = (1 / zoom) + 0.2;
        this._margin = (15 - (((1 - scale) / 0.1) * 5));

        dfx.setStyle(this._toolbar, '-webkit-transform', 'scale(' + scale + ', ' + scale + ')');
        dfx.setStyle(this._toolbar, '-moz-transform', 'scale(' + scale + ', ' + scale + ')');

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

        if (!rangeCoords) {
            return;
        }

        var scrollCoords = dfx.getScrollCoords();

        dfx.addClass(this._toolbar, 'calcWidth');
        dfx.setStyle(this._toolbar, 'width', 'auto');
        var toolbarWidth = dfx.getElementWidth(this._toolbar);
        dfx.removeClass(this._toolbar, 'calcWidth');
        dfx.setStyle(this._toolbar, 'width', toolbarWidth + 'px');

        if (verticalOnly !== true) {
            var left = ((rangeCoords.left + ((rangeCoords.right - rangeCoords.left) / 2) + scrollCoords.x) - (toolbarWidth / 2));
            dfx.setStyle(this._toolbar, 'left', left + 'px');
        }

        var top = (rangeCoords.bottom + this._margin + scrollCoords.y);

        dfx.setStyle(this._toolbar, 'top', top + 'px');
        dfx.addClass(this._toolbar, 'visible');

    },

    _getElementCoords: function(element)
    {
        var elemRect     = dfx.getBoundingRectangle(element);
        var scrollCoords = dfx.getScrollCoords();
        return {
            left: elemRect.x1 - scrollCoords.x,
            right: elemRect.x2 - scrollCoords.x,
            top: elemRect.y1 - scrollCoords.y,
            bottom: elemRect.y2 - scrollCoords.y
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
            // When clicked set the selection to the original selection.
            self._lineageClicked     = true;
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
        var range = viper.getCurrentRange();
        range.selectNode(node);
        ViperSelection.addRange(range);
        viper.fireSelectionChanged();

        // Update the position of the toolbar vertically only.
        this._updatePosition(range, true);

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
        dfx.empty(this._subSectionContainer);

        if (this._currentLineageIndex === null) {
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
        var lineage      = [];

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
