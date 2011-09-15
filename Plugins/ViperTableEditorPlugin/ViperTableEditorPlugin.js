/**
 * JS Class for the Viper Table Editor Plugin.
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

function ViperTableEditorPlugin(viper)
{
    this.viper = viper;
    this.toolbarPlugin = null;
    this.activeCell    = null;
    this.vCellButtons  = null;
    this.hCellButtons  = null;
    this._lastNode     = null;

    this._buttonClicked = false;
    this._tableRawCells = null;
    this._currentType   = null;
    this._margin        = 10;

    // Table properties.
    this._currentTablePropView = 'cell';
    this._settingsWidgets      = {};

}

ViperTableEditorPlugin.prototype = {

    start: function()
    {
        if (this.viper.isBrowser('firefox') === true) {
            // Disable table editing.
            setTimeout(function() {
                document.execCommand("enableInlineTableEditing", false, false);
                document.execCommand("enableObjectResizing", false, false);
            }, 500);

        }

        var self = this;
        this.toolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        this.toolbarPlugin.addButton('TableEditor', 'table', 'Insert/Edit Table', function () {
            self.insertTable();
        });

        if (navigator.userAgent.match(/iPad/i) === null) {
            var showToolbar = false;
            this.viper.registerCallback('Viper:mouseUp', 'ViperTableEditor', function(e) {
                if (self._buttonClicked === true) {
                    self._buttonClicked = false;
                    return false;
                }

                var target = dfx.getMouseEventTarget(e);
                if (!target) {
                    return;
                }

                var cell = self._getCellElement(target);
                if (cell) {
                    self.hideCellToolsIcon();
                    self.removeHighlights();

                    showToolbar = true;
                    // Show cell Tools.
                    return self.showCellToolsIcon(cell);
                }

                self.hideCellToolsIcon();
                self.removeHighlights();

                return true;
            });


            this.viper.registerCallback('Viper:selectionChanged', 'ViperTableEditorPlugin', function(range) {
                if (showToolbar === false) {
                    self.hideCellToolsIcon();
                    self.hideToolbar();
                } else {
                    showToolbar = false;
                }
            });
        } else {
            // For iPad.
            this.viper.registerCallback('Viper:selectionChanged', 'ViperTableEditorPlugin', function(range) {
                var startNode = range.getStartNode();
                var cell = self._getCellElement(startNode);
                if (cell) {
                    self.hideCellToolsIcon();
                    self.removeHighlights();

                    showToolbar = true;
                    // Show cell Tools.
                    return self.showCellToolsIcon(cell);
                }


                self.hideCellToolsIcon();
                //self.removeHighlights();

                return true;
            });
        }

        // During zooming hide the toolbar.
        dfx.addEvent(window, 'gesturestart', function() {
            self.hideToolbar();
        });

        // Update and show the toolbar after zoom.
        dfx.addEvent(window, 'gestureend', function() {
            self.updateToolbar(self.getActiveCell(), self._currentType);
        });

        this._createToolbar();

    },

    showCellToolsIcon: function(cell)
    {
        if (!cell) {
            return;
        }

        this.hideToolbar();

        var overlayid = this.viper.getId() + '-ViperTEP';
        var overlay   = dfx.getId(overlayid);

        if (overlay) {
            dfx.remove(overlay);
        }

        overlay    = document.createElement('div');
        overlay.id = overlayid;
        dfx.addClass(overlay, 'ViperTEP-cellToolsIcon');

        var cellCoords   = dfx.getBoundingRectangle(cell);
        var overlayWidth = 42;

        dfx.setStyle(overlay, 'top', cellCoords.y2 + 5 + 'px');
        dfx.setStyle(overlay, 'left', cellCoords.x1 + ((cellCoords.x2 - cellCoords.x1) / 2) - (overlayWidth / 2) + 'px');

        dfx.hover(overlay, function() {
            self.setActiveCell(cell);
            self.highlightActiveCell();
        }, function() {
            self.removeHighlights();
        });

        document.body.appendChild(overlay);

        var self = this;
        dfx.addEvent(overlay, 'click', function() {
            dfx.remove(overlay);
            var range = self.viper.getCurrentRange();
            range.collapse(true);
            ViperSelection.addRange(range);
            self.showTableTools(cell);
        });

    },

    hideCellToolsIcon: function()
    {
        var overlayid = this.viper.getId() + '-ViperTEP';
        var overlay   = dfx.getId(overlayid);

        if (overlay) {
            dfx.remove(overlay);
        }
    },

    showTableTools: function(cell, type)
    {
        if (!cell) {
            return;
        }

        this.updateToolbar(cell, type);

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
    createButton: function(content, isActive, customClass, clickAction, groupElement, subSection, showSubSection)
    {
        var self = this;
        if (subSection) {
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

        var button = ViperTools.createButton(content, isActive, customClass, clickAction, groupElement, subSection, showSubSection);

        if (!groupElement) {
            this._toolsContainer.appendChild(button);
        }

        return button;

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
    updateToolbar: function(cell, type)
    {
        this._tableRawCells = null;
        this.setActiveCell(cell);

        this.removeHighlights();
        this.hideToolbar();

        if (navigator.userAgent.match(/iPad/i) !== null) {
            this._scaleToolbar();
        }

        this._currentType = type;

        dfx.removeClass(this._toolbar, 'subSectionVisible');

        // Set highlight to active cell.
        this.highlightActiveCell();

        this._updateLineage(type);
        this._updateInnerContainer(cell, type);
        this._updatePosition(cell, type);
        this.highlightActiveCell(type);

    },

    showActiveSubSection: function()
    {
        dfx.addClass(this._toolbar, 'subSectionVisible');
    },

    hideActiveSubSection: function()
    {
        dfx.removeClass(this._toolbar, 'subSectionVisible');
    },

    tableUpdated: function()
    {
        this._tableRawCells = null;
        this.viper.fireNodesChanged([this.getCellTable(this.activeCell)]);

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
     */
    _updatePosition: function(cell, verticalOnly)
    {
        var rangeCoords = this._getElementCoords(cell);

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

    _updateLineage: function(type)
    {
        var self = this;

        dfx.empty(this._lineage);

        dfx.removeClass(dfx.getClass('selected', this._lineage), 'selected');

        // Table.
        var table  = document.createElement('li');
        dfx.addClass(table, 'ViperITP-lineageItem');
        dfx.setHtml(table, 'Table');
        this._lineage.appendChild(table);
        dfx.addEvent(table, 'mousedown', function(e) {
            self._buttonClicked = true;
            self.updateToolbar(self.getActiveCell(), 'table');
            dfx.preventDefault(e);
            return false;
        });
        dfx.hover(table, function() {
            self.highlightActiveCell('table');
        }, function() {
            self.removeHighlights();
            self.highlightActiveCell(self._currentType);
        });
        if (type === 'table') {
            dfx.addClass(table, 'selected');
        }

        // Row.
        var row  = document.createElement('li');
        dfx.addClass(row, 'ViperITP-lineageItem');
        dfx.setHtml(row, 'Row');
        this._lineage.appendChild(row);
        dfx.addEvent(row, 'mousedown', function(e) {
            dfx.removeClass(dfx.getClass('selected', self._lineage), 'selected');
            dfx.addClass(row, 'selected');
            self._buttonClicked = true;
            self.updateToolbar(self.getActiveCell(), 'row');
            dfx.preventDefault(e);
            return false;
        });
        dfx.hover(row, function() {
            self.highlightActiveCell('row');
        }, function() {
            self.removeHighlights();
            self.highlightActiveCell(self._currentType);
        });
        if (type === 'row') {
            dfx.addClass(row, 'selected');
        }

        // Col.
        var col  = document.createElement('li');
        dfx.addClass(col, 'ViperITP-lineageItem');
        dfx.setHtml(col, 'Column');
        this._lineage.appendChild(col);
        dfx.addEvent(col, 'mousedown', function(e) {
            self._buttonClicked = true;
            self.updateToolbar(self.getActiveCell(), 'col');
            dfx.preventDefault(e);
            return false;
        });
        dfx.hover(col, function() {
            self.highlightActiveCell('col');
        }, function() {
            self.removeHighlights();
            self.highlightActiveCell(self._currentType);
        });
        if (type === 'col') {
            dfx.addClass(col, 'selected');
        }

        // Cell.
        var cell  = document.createElement('li');
        dfx.addClass(cell, 'ViperITP-lineageItem');
        dfx.setHtml(cell, 'Cell');
        this._lineage.appendChild(cell);
        dfx.addEvent(cell, 'mousedown', function(e) {
            self._buttonClicked = true;
            self.updateToolbar(self.getActiveCell(), 'cell');
            dfx.preventDefault(e);
            return false;
        });
        dfx.hover(cell, function() {
            self.highlightActiveCell('cell');
        }, function() {
            self.removeHighlights();
            self.highlightActiveCell(self._currentType);
        });
        if (!type || type === 'cell') {
            dfx.addClass(cell, 'selected');
        }

    },

    removeHighlights: function()
    {
        dfx.remove(dfx.getClass('ViperITP-highlight'));
    },


    highlightActiveCell: function(parentType)
    {
        parentType     = parentType || 'cell';
        var activeCell = this.getActiveCell();
        var element    = null;
        var coords     = null;

        switch (parentType) {
            case 'cell':
            default:
                element = activeCell;
            break;

            case 'table':
                element = this.getCellTable(activeCell, true);
            break;

            case 'row':
                element = activeCell.parentNode;
            break;

            case 'col':
                // Column is a bit harder to calculate.
                // Get the tables rectangle.
                coords = dfx.getBoundingRectangle(this.getCellTable(activeCell, true));

                // Get the width and height of the cell.
                var cellRect = dfx.getBoundingRectangle(activeCell);

                // Modify the table coords so that the width and height only for this col.
                coords.x1 = cellRect.x1;
                coords.x2 = cellRect.x2;
            break;
        }

        this.removeHighlights();

        if (element && !coords) {
            coords = dfx.getBoundingRectangle(element);
        }

        var hElem = document.createElement('div');
        dfx.addClass(hElem, 'ViperITP-highlight Viper-tableHighlight');

        dfx.setStyle(hElem, 'width', (coords.x2 - coords.x1) + 'px');
        dfx.setStyle(hElem, 'height', (coords.y2 - coords.y1) + 'px');
        dfx.setStyle(hElem, 'top', coords.y1 + 'px');
        dfx.setStyle(hElem, 'left', coords.x1 + 'px');

        document.body.appendChild(hElem);

        dfx.addEvent(hElem, 'mousedown', function() {
            dfx.remove(hElem);
        });

    },

    _updateInnerContainer: function(cell, type)
    {
        dfx.empty(this._toolsContainer);
        dfx.empty(this._subSectionContainer);

        switch (type) {
            case 'cell':
            default:
                this._createCellProperties(cell);
            break;

            case 'col':
                this._createColProperties(cell);
            break;

            case 'row':
                this._createRowProperties(cell);
            break;
        }

    },

    _createCellProperties: function(cell)
    {
        var isActive = false;
        if (dfx.isTag(cell, 'th') === true) {
            isActive = true;
        }

        var self = this;
        this.createButton('Heading', isActive, '', function() {
            // Switch between header and normal cell.
            if (dfx.isTag(cell, 'th') === true) {
                var newCell = self.convertToCell(cell);
                self.updateToolbar(newCell);
            } else {
                var newCell = self.convertToHeader(cell);
                self.updateToolbar(newCell);
            }
        });

        var subSection = document.createElement('div');
        var wrapper    = document.createElement('div');
        var canMerge   = false;

        if (this.canMergeUp(cell) !== false) {
            var mergeUp = this.createButton('', false, 'icon-arrowUp', function() {
                self._buttonClicked = true;
                self.updateToolbar(self.mergeUp(cell));
            });
            wrapper.appendChild(mergeUp);
            canMerge = true;
        }

        if (this.canMergeDown(cell) !== false) {
            var mergeDown = this.createButton('', false, 'icon-arrowDown', function() {
                self._buttonClicked = true;
                self.updateToolbar(self.mergeDown(cell));
            });
            wrapper.appendChild(mergeDown);
            canMerge = true;
        }

        if (canMerge === true) {
            var span = document.createElement('span');
            dfx.setHtml(span, 'Merge');
            wrapper.appendChild(span);
        }

        if (this.canMergeLeft(cell) !== false) {
            var mergeLeft = this.createButton('', false, 'icon-arrowLeft', function() {
                self._buttonClicked = true;
                self.updateToolbar(self.mergeLeft(cell));
            });
            wrapper.appendChild(mergeLeft);
        }

        if (this.canMergeRight(cell) !== false) {
            var mergeRight = this.createButton('', false, 'icon-arrowRight', function() {
                self._buttonClicked = true;
                self.updateToolbar(self.mergeRight(cell));
            });
            wrapper.appendChild(mergeRight);
        }

        var canSplit     = false;
        var splitWrapper = document.createElement('div');

        if (this.getColspan(cell) > 1) {
            canSplit = true;
            var splitVert = this.createButton('', false, 'icon-splitVert', function() {
                self._buttonClicked = true;
                self.splitVertical(cell);
                self.updateToolbar(cell);
            });
            splitWrapper.appendChild(splitVert);
        }

        var span = document.createElement('span');
        dfx.setHtml(span, 'Split');
        splitWrapper.appendChild(span);

        if (this.getRowspan(cell) > 1) {
            canSplit = true;
            var splitHor = this.createButton('', false, 'icon-splitHoriz', function() {
                self._buttonClicked = true;
                self.splitHorizontal(cell);
                self.updateToolbar(cell);
            });
            splitWrapper.appendChild(splitHor);
        }

        subSection.appendChild(wrapper);
        if (canSplit === true) {
            subSection.appendChild(splitWrapper);
        }

        this.createSubSection(subSection, true);
        this.showActiveSubSection();

    },

    _createColProperties: function(cell)
    {
        var self = this;
        var insertLeft = this.createButton('', false, 'icon-addLeft', function() {
            self._buttonClicked = true;
            self.insertColBefore(cell);
            self.updateToolbar(cell, 'col');
        });

        var insertRight = this.createButton('', false, 'icon-addRight', function() {
            self._buttonClicked = true;
            self.insertColAfter(cell);
            self.updateToolbar(cell, 'col');
        });

        var removeCol = this.createButton('', false, 'icon-delete', function() {
            self._buttonClicked = true;
            self.removeCol(cell);
            self.hideToolbar();
            self.removeHighlights();
        });

    },

    _createRowProperties: function(cell)
    {
        var self = this;
        var insertBefore = this.createButton('', false, 'icon-addUp', function() {
            self._buttonClicked = true;
            self.insertRowBefore(cell);
            self.updateToolbar(cell, 'row');
        });

        var insertAfter = this.createButton('', false, 'icon-addDown', function() {
            self._buttonClicked = true;
            self.insertRowAfter(cell);
            self.updateToolbar(cell, 'row');
        });

        var removeRow = this.createButton('', false, 'icon-delete', function() {
            self._buttonClicked = true;
            self.removeRow(cell);
            self.hideToolbar();
            self.removeHighlights();
        });

    },

    /**
     * Hides the inline toolbar.
     */
    hideToolbar: function()
    {
        dfx.removeClass(this._toolbar, 'visible');
        this.hideActiveSubSection();
        //this.removeHighlights();

    },


    setActiveCell: function(cell)
    {
        this.activeCell = cell;

    },

    getActiveCell: function(cell)
    {
        return this.activeCell;

    },

    /*
        Merging.
    */
    canMergeLeft: function(cell)
    {
        var prevCell = this.getPreviousCell(cell);
        if (prevCell) {
            if (this.getRowspan(prevCell) === this.getRowspan(cell)) {
                return prevCell;
            }
        }

        return false;

    },

    canMergeRight: function(cell)
    {
        var nextCell = this.getNextCell(cell);
        if (nextCell) {
            if (this.getRowspan(nextCell) === this.getRowspan(cell)) {
                return nextCell;
            }
        }

        return false;

    },

    canMergeDown: function(cell)
    {
        var rowspan = this.getRowspan(cell);
        var colNum  = this.getColNum(cell);
        var row     = cell.parentNode;

        while (rowspan >= 1) {
            row = this._getNextRow(row);
            rowspan--;
        }

        if (row) {
            var newCell = this.getCell(row, colNum);
            if (!newCell) {
                return false;
            }

            if (this.getColspan(cell) === this.getColspan(newCell)) {
                return newCell;
            }
        }

        return false;

    },

    canMergeUp: function(cell)
    {
        var rowspan = this.getRowspan(cell);
        var colNum  = this.getColNum(cell);
        var row     = cell.parentNode;
        var newCell = null;

        while (row && !newCell) {
            row     = this._getPreviousRow(row);
            if (!row) {
                return false;
            }

            newCell = this.getCell(row, colNum);
        }

        if (row) {
            if (!newCell) {
                return false;
            }

            if (this.getColspan(cell) === this.getColspan(newCell)) {
                return newCell;
            }
        }

        return false;

    },

    mergeLeft: function(cell)
    {
        var mergeCell = this.canMergeLeft(cell);
        if (!mergeCell) {
            return;
        }

        var colspan = this.getColspan(cell) + this.getColspan(mergeCell);
        this._moveCellContent(mergeCell, cell);
        cell.setAttribute('colspan', colspan);
        dfx.remove(mergeCell);

        this.tableUpdated();

        return cell;

    },

    mergeRight: function(cell)
    {
        var mergeCell = this.canMergeRight(cell);
        if (!mergeCell) {
            return;
        }

        var colspan = this.getColspan(cell) + this.getColspan(mergeCell);
        this._moveCellContent(mergeCell, cell);
        cell.setAttribute('colspan', colspan);
        dfx.remove(mergeCell);

        this.tableUpdated();

        return cell;
    },

    mergeDown: function(cell)
    {
        var mergeCell = this.canMergeDown(cell);

        var rowspan = this.getRowspan(cell) + this.getRowspan(mergeCell);
        this._moveCellContent(mergeCell, cell);
        cell.setAttribute('rowspan', rowspan);
        dfx.remove(mergeCell);

        this.tableUpdated();

        return cell;

    },

    mergeUp: function(cell)
    {
        var mergeCell = this.canMergeUp(cell);

        var rowspan = this.getRowspan(cell) + this.getRowspan(mergeCell);
        this._moveCellContent(cell, mergeCell);
        mergeCell.setAttribute('rowspan', rowspan);
        dfx.remove(cell);

        this.tableUpdated();

        return mergeCell;

    },

    getRowspan: function(cell)
    {
        return parseInt(cell.getAttribute('rowspan') || 1);

    },

    getColspan: function(cell)
    {
        return parseInt(cell.getAttribute('colspan') || 1);

    },

    convertToHeader: function(cell)
    {
        if (dfx.isTag(cell, 'td') === false) {
            return false;
        }

        var elem = document.createElement('th');
        while (cell.firstChild) {
            elem.appendChild(cell.firstChild);
        }

        for (var i = 0; i < cell.attributes.length; i++) {
            elem.setAttribute(cell.attributes[i].nodeName, cell.attributes[i].nodeValue);
        }

        dfx.insertBefore(cell, elem);
        dfx.remove(cell);

        this.tableUpdated();

        return elem;

    },

    convertToCell: function(cell)
    {
        if (dfx.isTag(cell, 'th') === false) {
            return false;
        }

        var elem = document.createElement('td');
        while (cell.firstChild) {
            elem.appendChild(cell.firstChild);
        }

        for (var i = 0; i < cell.attributes.length; i++) {
            elem.setAttribute(cell.attributes[i].nodeName, cell.attributes[i].nodeValue);
        }

        dfx.insertBefore(cell, elem);
        dfx.remove(cell);

        this.tableUpdated();

        return elem;

    },

    /**
     * Splits specified cell vertically only if it has rowspan > 1.
     *
     * @param {DOMNode} cell The table cell to split.
     *
     * @return {DOMNode} The new row that was created.
     */
    splitVertical: function(cell)
    {
        if (!cell || !cell.getAttribute('colspan')) {
            return;
        }

        var tagName = dfx.getTagName(cell);
        var elem    = document.createElement(tagName);

        var colspan = (parseInt(cell.getAttribute('colspan')) - 1);
        if (colspan > 1) {
            cell.setAttribute('colspan', colspan);
        } else {
            dfx.removeAttr(cell, 'colspan');
        }

        var rowspan = cell.getAttribute('rowspan');
        if (rowspan > 1) {
            elem.setAttribute('rowspan', rowspan);
        }

        dfx.insertAfter(cell, elem);

        this.tableUpdated();

        return elem;

    },

    /**
     * Splits specified cell horizontally only if it has colspan > 1.
     *
     * @param {DOMNode} cell The table cell to split.
     *
     * @return {DOMNode} The new column that was created.
     */
    splitHorizontal: function(cell)
    {
        var rowspan = this.getRowspan(cell);
        if (!cell || rowspan <= 1) {
            return false;
        }

        var rows    = dfx.getTag('tr', this.getCellTable(cell));
        var cellPos = this.getCellPosition(cell);
        var cells   = this._getCellsExpanded();

        // Decrease the rowspan of this cell by 1.
        if (rowspan > 2) {
            cell.setAttribute('rowspan', (rowspan - 1));
        } else {
            dfx.removeAttr(cell, 'rowspan');
        }

        var colspan = this.getColspan(cell);
        var newCell = document.createElement(dfx.getTagName(cell));
        if (colspan > 1) {
            newCell.setAttribute('colspan', colspan);
        }

        // Find the new cell's insertion point.
        // Next row is startRowPosition + originalRowspan - 1 (minus 1 since default rowspan is 1).
        var nextRowIndex = (cellPos.row + rowspan - 1);
        var rowCells     = this._getRowCells(rows[nextRowIndex]);

        if (cellPos.col === 0) {
            dfx.insertBefore(rowCells[0], newCell);
        } else {
            var cellIndex = cellPos.col;

            // Look behind to see if there is a real column.
            var inserted = false;
            while (cells[nextRowIndex][--cellIndex]) {
                if (this.getCellPosition(cells[nextRowIndex][cellIndex]).row === nextRowIndex) {
                    inserted = true;
                    dfx.insertAfter(cells[nextRowIndex][cellIndex], newCell);
                    break;
                }
            }

            if (inserted === false) {
                // Look forward.
                cellIndex = cellPos.col;
                while (cells[nextRowIndex][++cellIndex]) {
                    if (this.getCellPosition(cells[nextRowIndex][cellIndex]).row === nextRowIndex) {
                        dfx.insertBefore(cells[nextRowIndex][cellIndex], newCell);
                        break;
                    }
                }
            }
        }

        this.tableUpdated();

        return newCell;

    },

    insertRowBefore: function(cell)
    {
        var cellRow  = cell.parentNode;
        var cellPos  = this.getCellPosition(cell);
        var cells    = this._getCellsExpanded();
        var rowCells = cells[cellPos.row];
        var rlen     = rowCells.length;

        var newRow = document.createElement('tr');

        var processedCells = [];
        for (var i = 0; i < rlen; i++) {
            var rowCell = rowCells[i];
            if (processedCells.inArray(rowCell) === true) {
                continue;
            }

            var rowspan    = this.getRowspan(rowCell);
            if (rowspan > 1 && this.getCellPosition(rowCell).row < cellPos.row) {
                // Increase the rowspan instead of creating a new cell.
                rowCell.setAttribute('rowspan', (rowspan + 1));
            } else {
                var newCell = document.createElement(dfx.getTagName(rowCell));

                var colspan = this.getColspan(rowCell);
                if (colspan > 1) {
                    newCell.setAttribute('colspan', colspan);
                }

                newRow.appendChild(newCell);
            }

            processedCells.push(rowCell);
        }

        dfx.insertBefore(cellRow, newRow);

        this.tableUpdated();

    },

    insertRowAfter: function(cell)
    {
        var rows     = dfx.getTag('tr', this.getCellTable(cell));
        var cellPos  = this.getCellPosition(cell);
        var cells    = this._getCellsExpanded();
        var rowCells = cells[cellPos.row + (this.getRowspan(cell) - 1)];
        var rlen     = rowCells.length;
        var cellRow  = rows[cellPos.row + (this.getRowspan(cell) - 1)];

        var newRow = document.createElement('tr');

        var processedCells = [];
        for (var i = 0; i < rlen; i++) {
            var rowCell = rowCells[i];
            if (processedCells.inArray(rowCell) === true) {
                continue;
            }

            var rowspan = this.getRowspan(rowCell);
            if (rowspan > 1 && rowCell !== cell && (this.getCellPosition(rowCell).row + this.getRowspan(rowCell) - 1) > cellPos.row) {
                // Increase the rowspan instead of creating a new cell.
                rowCell.setAttribute('rowspan', (rowspan + 1));
            } else {
                var newCell = document.createElement(dfx.getTagName(rowCell));

                var colspan = this.getColspan(rowCell);
                if (colspan > 1) {
                    newCell.setAttribute('colspan', colspan);
                }

                newRow.appendChild(newCell);
            }

            processedCells.push(rowCell);
        }

        dfx.insertAfter(cellRow, newRow);

        this.tableUpdated();

    },

    removeRow: function(cell)
    {
        var table    = this.getCellTable(cell);
        var tr       = this.getCellRow(cell);
        var cellPos  = this.getCellPosition(cell);
        var cells    = this._getCellsExpanded();
        var rowCells = cells[cellPos.row];
        var rlen     = rowCells.length;

        var nextRowCells = this._getRowCells(this._getNextRow(tr));

        var processedCells = [];
        for (var i = 0; i < rlen; i++) {
            var rowCell = rowCells[i];
            if (processedCells.inArray(rowCell) === true) {
                continue;
            }

            processedCells.push(rowCell);

            var rowspan = this.getRowspan(rowCell);
            if (rowspan > 1) {
                rowCell.setAttribute('rowspan', (rowspan - 1));

                var rowPos = this.getCellPosition(rowCell).row;
                if (rowPos === cellPos.row) {
                    // Move cell down.
                    if (cells[(rowPos + 1)].find(rowCell) < cells[(rowPos + 1)].find(nextRowCells[0])) {
                        dfx.insertBefore(nextRowCells[0], rowCell);
                    } else {
                        dfx.insertAfter(nextRowCells[0], rowCell);
                    }
                }

                continue;
            }

            dfx.remove(rowCell);
        }

        dfx.remove(tr);

        // if the table is now empty then remove it.
        var rows = dfx.getTag('tr', table);
        if (rows.length === 0) {
            dfx.remove(table);
        }

        this.tableUpdated();

    },

    insertColAfter: function(cell)
    {
        var table    = this.getCellTable(cell);
        var rows     = dfx.getTag('tr', table);
        var rln      = rows.length;
        var colNum   = (this.getColNum(cell) + (this.getColspan(cell) - 1));

        var td = null;
        for (var i = 0; i < rln; i++) {
            var col     = this.getCell(i, colNum);
            var cellPos = this.getCellPosition(col);

            if ((cellPos.col !== colNum && col !== cell) || (col !== cell && this.getColspan(col) > 1)) {
                col.setAttribute('colspan', (this.getColspan(col) + 1));
            } else if (cellPos.row < i) {
                if (td) {
                    td.setAttribute('rowspan', (this.getRowspan(td) + 1));
                }
                continue;
            } else {
                td = document.createElement(col.tagName);
                dfx.setHtml(td, '&nbsp;');

                dfx.insertAfter(col, td);
            }
        }

        this.tableUpdated();

    },

    insertColBefore: function(cell)
    {
        var table    = this.getCellTable(cell);
        var rows     = dfx.getTag('tr', table);
        var rln      = rows.length;
        var colNum   = this.getColNum(cell);

        var td = null;
        for (var i = 0; i < rln; i++) {
            var col     = this.getCell(i, colNum);
            var cellPos = this.getCellPosition(col);

            if (cellPos.col !== colNum && col !== cell) {
                col.setAttribute('colspan', (this.getColspan(col) + 1));
            } else if (cellPos.row < i) {
                if (td) {
                    td.setAttribute('rowspan', (this.getRowspan(td) + 1));
                }
                continue;
            } else {
                td = document.createElement(col.tagName);
                dfx.setHtml(td, '&nbsp;');

                dfx.insertBefore(col, td);
            }
        }

        this.tableUpdated();

    },

    getColumnCells: function(table, colNum)
    {
        if (!table) {
            return;
        }

        var cols = [];
        var rows = dfx.getTag('tr', table);
        var rln  = rows.length;
        for (var i = 0; i < rln; i++) {
            cols.push(this.getCell(rows[i], colNum));
        }

        return cols;

    },

    removeCol: function(cell)
    {
        var table    = this.getCellTable(cell);
        var cellPos  = this.getCellPosition(cell);
        var cells    = this._getCellsExpanded();
        var rowCount = cells.length;
        var colspan  = this.getColspan(cell);

        var processedCells = [];
        for (var i = 0; i < rowCount; i++) {
            for (var j = cellPos.col; j < (cellPos.col + colspan); j++) {
                var rowCell = cells[i][j];
                if (processedCells.inArray(rowCell) === true) {
                    continue;
                }

                var rowCellColspan = this.getColspan(rowCell);
                if (rowCellColspan > colspan || (rowCellColspan > 1 && this.getCellPosition(rowCell).col !== cellPos.col)) {
                    // Reduce colspan.
                    rowCell.setAttribute('colspan', (rowCellColspan - 1));
                } else {
                    // Remove cell.
                    dfx.remove(rowCell);
                }

                processedCells.push(rowCell);
            }
        }

        // if the table is now empty then remove it.
        var rows = dfx.getTag('td', table);
        if (rows.length === 0) {
            dfx.remove(table);
        }

        this.tableUpdated();
    },

    getNextCell: function(cell)
    {
        var pos = this.getCellPosition(cell);
        if (!pos) {
            return null;
        }

        var nextCell = this.getCell(pos.row, (pos.col + this.getColspan(cell)));
        return nextCell;

    },

    getPreviousCell: function(cell)
    {
        var pos = this.getCellPosition(cell);
        if (!pos) {
            return null;
        }

        var prevCell = this.getCell(pos.row, (pos.col - 1));
        return prevCell;

    },

    moveCaretToCell: function(cell)
    {
        if (cell) {
            var range = this.viper.getCurrentRange();
            var child = range._getFirstSelectableChild(cell);
            if (!child) {
                cell = document.createTextNode(' ');
                child.appendChild(cell);
            }

            range.setStart(child, 0);
            range.collapse(true);
            return range;
        } else {
            this.hideCellButtons();
        }

    },

    removeTable: function(table, emptyOnly)
    {
        if (emptyOnly === true) {
            // Check if the table is empty (no cols);.
            if (dfx.find(table, 'tr > td').length > 0 || dfx.find(table, 'tr > th').length > 0) {
                return;
            }
        }

        dfx.remove(table);

        this.hideCellButtons();
    },

    getCellTable: function(cell, tbody)
    {
        if (!cell) {
            return null;
        }

        var node = cell;
        while (node) {
            if (node.nodeType === dfx.ELEMENT_NODE) {
                var tagName = node.tagName.toLowerCase();
                if (tagName === 'table') {
                    return node;
                } else if (tbody === true && tagName === 'tbody') {
                    return node;
                }
            }

            node = node.parentNode;
        }

    },

    getRowTable: function(row, tbody)
    {
        return this.getCellTable(row);

    },

    getCellRow: function(cell)
    {
        var rows     = dfx.getTag('tr', this.getCellTable(cell));
        var cellPos  = this.getCellPosition(cell);
        return rows[cellPos.row];

    },

    /**
     * Inserts a table to the caret position.
     */
    insertTable: function(rows, cols)
    {
        rows = rows || 2;
        cols = cols || 3;

        var table = document.createElement('table');
        // First hide the table so we can determine if there are borders etc.
        dfx.setStyle(table, 'display', 'none');

        var tbody    = document.createElement('tbody');
        var firstCol = null;

        for (var i = 0; i < rows; i++) {
            var tr = document.createElement('tr');
            for (var j = 0; j < cols; j++) {
                var td = document.createElement('td');
                if (i === 0) {
                    dfx.setStyle(td, 'width', '100px');
                }

                dfx.setHtml(td, '&nbsp;');
                tr.appendChild(td);

                if (firstCol === null) {
                    firstCol = td;
                }
            }

            tbody.appendChild(tr);
        }

        table.appendChild(tbody);
        var bookmark = this.viper.createBookmark();

        // Insert table to the bookmarks position.
        var splitInfo = this.viper.splitNodeAtBookmark('p', bookmark);
        if (splitInfo) {
            if (splitInfo.prevNode) {
                dfx.insertAfter(splitInfo.prevNode, table);
            } else if (splitInfo.nextNode) {
                dfx.insertBefore(splitInfo.nextNode, table);
                if (this.viper.elementIsEmpty(splitInfo.nextNode) === true) {
                    dfx.remove(splitInfo.nextNode);
                }
            }
        }

        // Now determine if we need to add borders or width to this table.
        // Done over here so that if there are CSS styles applied to tables
        // then we don't override them.
        var width = parseInt(dfx.getComputedStyle(table, 'width'));
        if (!width) {
            dfx.setStyle(table, 'width', '300px');
        }

        var col = dfx.getTag('td', table)[0];
        var rightWidth  = parseInt(dfx.getComputedStyle(col, 'border-right-width'));
        var bottomWidth = parseInt(dfx.getComputedStyle(col, 'border-bottom-width'));

        if (bottomWidth === 0
            || rightWidth === 0
            || isNaN(bottomWidth) === true
            || isNaN(rightWidth) === true
        ) {
            dfx.attr(table, 'border', 1);
        }

        dfx.setStyle(table, 'display', '');

        if (firstCol) {
            var range = this.viper.getCurrentRange();
            range.setStart(firstCol.firstChild, 0);
            range.collapse(true);
            ViperSelection.addRange(range);
        }

    },

    isPluginElement: function(elem)
    {
        return false;

    },

    setTableHeaders: function(table)
    {
        var cellHeadings  = [];
        var usedHeaderids = [];
        var rowCount      = 1
        var headings      = {
            col: [],
            row: [],
        };

        var tableRows = dfx.getTag('tr', table);
        for (var k = 0; k < tableRows.length; k++) {
            var cellCount = 1;
            var row       = tableRows[k];

            for (var j = 0; j < row.childNodes.length; j++) {
                var cell = row.childNodes[j];

                // Skip text nodes.
                if (cell.nodeType === dfx.TEXT_NODE) {
                    continue;
                }

                // Find the real cell number, taking rowspans into account.
                while (dfx.isset(cellHeadings[rowCount]) === true
                    && dfx.isset(cellHeadings[rowCount][cellCount]) === true
                ) {
                    cellCount++;
                }

                // Determine colspan and rowspan for the cell. If nothing is set,
                // assume a value of 1. These come out as string values but we turn them
                // into integers for easier comparison and addition.
                var colspan = cell.getAttribute('colspan') || 1;
                var rowspan = cell.getAttribute('rowspan') || 1;

                if (dfx.isTag(cell, 'th') === true && dfx.isBlank(dfx.getHtml(cell)) === false) {
                    // This is a table header, so figure out an ID-based representation
                    // of the cell content. We'll use this later as a basis for the ID attribute
                    // although it may be prefixed with the ID of another header to make it unique.

                    var cellid = 'r' + rowCount + 'c' + cellCount;

                    if (rowspan > 1) {
                        if (dfx.isset(headings.row[rowCount]) === true
                            && headings.row[rowCount].rowspan <= rowspan
                        ) {
                            // This heading is replacing a heading set higher up
                            // so we need to remove the higher heading from the IDs so
                            // we can replace it with our own later on.
                            var oldidLen = headings.row[rowCount].id.length;
                            for (var i = 1; i < rowspan; i++) {
                                var oldid = headings.row[(rowCount + i)].id;
                                oldid     = oldid.substr(0, ((oldidLen + 1) * -1));
                                headings.row[(rowCount + i)].id = dfx.trim(oldid);
                            }

                            headings.row[rowCount].id = '';
                        }//end if

                        for (var i = 0; i < rowspan; i++) {
                            if (dfx.isset(headings.row[(rowCount + i)]) === false) {
                                headings.row[(rowCount + i)] = {
                                    id: '',
                                    rowspan: rowspan
                                };
                            } else if (headings.row[(rowCount + i)].id !== '') {
                                headings.row[(rowCount + i)].id += '-';
                            }

                            headings.row[(rowCount + i)].id      += cellid;
                            headings.row[(rowCount + i)].rowspan  = rowspan;

                            cellHeadings[(rowCount + i)][cellCount] = {
                                id: headings.row[(rowCount + i)].id,
                                row: (rowCount + i)
                            };
                        }//end for

                        cellid = headings.row[rowCount].id;
                    } else {
                        if (dfx.isset(headings.row[rowCount]) === true
                            && dfx.isset(headings.row[rowCount].id) === true
                        ) {
                            cellid = headings.row[rowCount].id + '-' + cellid;
                        }
                    }//end if

                    if (colspan > 1) {
                        if (dfx.isset(headings.col[cellCount]) === true
                            && headings.col[cellCount].colspan <= colspan
                        ) {
                            // This heading is replacing a heading set higher up
                            // so we need to remove the higher heading from the IDs so
                            // we can replace it with our own later on.
                            var oldidLen = headings.col[cellCount].id.length;
                            for (var i = 1; i < colspan; i++) {
                                var oldid = headings.col[(cellCount + i)].id
                                var newid = oldid.substr(0, ((oldidLen + 1) * -1));
                                headings.col[(cellCount + i)].id = dfx.trim(newid);

                                var oldHeading = cellHeadings[(rowCount - 1)][(cellCount + i)].id;
                                var newHeading = oldHeading.replace(oldid, '');
                                cellHeadings[(rowCount - 1)][(cellCount + i)].id = newHeading;
                            }

                            headings.col[cellCount].id = '';
                        }//end if

                        for (var i = 0; i < colspan; i++) {
                            if (dfx.isset(headings.col[(cellCount + i)]) === false) {
                                headings.col[(cellCount + i)] = {
                                    id: '',
                                    colspan: colspan
                                };
                            } else if (headings.col[(cellCount + i)].id !== '') {
                                headings.col[(cellCount + i)].id += '-';
                            }

                            headings.col[(cellCount + i)].id     += cellid;
                            headings.col[(cellCount + i)].colspan = colspan;

                            if (dfx.isset(cellHeadings[rowCount]) === false) {
                                cellHeadings[rowCount] = [];
                            }

                            cellHeadings[rowCount][(cellCount + i)] = {
                                id: headings.col[(cellCount + i)].id,
                                row: rowCount
                            };

                            if (dfx.isset(cellHeadings[(rowCount - 1)][(cellCount + i)]) === true) {
                                cellHeadings[rowCount][(cellCount + i)].id = cellHeadings[(rowCount - 1)][(cellCount + i)].id + ' ' + cellHeadings[rowCount][(cellCount + i)].id;
                            }
                        }//end for

                        cellid = headings.col[cellCount].id;
                    } else {
                        if (dfx.isset(headings.col[cellCount]) === true
                            && dfx.isset(headings.col[cellCount].id) === true
                        ) {
                            cellid = headings.col[cellCount].id + '-' + cellid;
                        }

                        if (dfx.isset(cellHeadings[rowCount]) === false) {
                            cellHeadings[rowCount] = [];
                        }

                        if (dfx.isset(cellHeadings[rowCount][cellCount]) === false) {
                            cellHeadings[rowCount][cellCount] = {
                                id: cellid,
                                row: rowCount
                            };
                        }
                    }//end if

                    cell.setAttribute('id', cellid);
                    usedHeaderids.push(cellid);
                } else {
                    // Copy the headings down from the column above.
                    if (rowCount > 1) {
                        for (var i = 0; i < colspan; i++) {
                            cellHeadings[rowCount][(cellCount + i)] = cellHeadings[(rowCount - 1)][(cellCount + i)];
                        }
                    } else {
                        for (var i = 0; i < colspan; i++) {
                            if (dfx.isset(cellHeadings[rowCount]) === false) {
                                cellHeadings[rowCount] = [];
                            }

                            cellHeadings[rowCount][(cellCount + i)] = {
                                id: '#td',
                                row: rowCount
                            };
                        }
                    }

                    // TODO: Dont do this if it has headers attribute.
                    if (dfx.isBlank(dfx.getHtml(cell)) === false) {
                        var headers = cellHeadings[rowCount][cellCount].id;
                        for (var i = 1; i < cellCount; i++) {
                            // Skip column headers. We only want to use our own column header.
                            if (cellHeadings[rowCount][i].row !== rowCount) {
                                continue;
                            }

                            headers += ' ' + cellHeadings[rowCount][i].id;
                        }

                        var headerids = [];

                        headers = headers.split(' ');
                        var headersLen = headers.length;
                        for (var i = 0; i < headersLen; i++) {
                            var header = headers[i];
                            var subHeaders = header.split('-');
                            var numHeaders = subHeaders.length;
                            var lastHeader = '';
                            for (var m = 0; m < numHeaders; m++) {
                                var subHeader = subHeaders.shift();
                                if (lastHeader === '') {
                                    lastHeader = subHeader;
                                } else {
                                    lastHeader += '-' + subHeader;
                                }

                                headerids.push(lastHeader);
                            }
                        }

                        headerids = this.arrayUnique(headerids);
                        headerids = this.arrayIntersect(headerids, usedHeaderids);
                        cell.setAttribute('headers', headerids.join(' '));
                    }//end if

                    for (var i = 0; i < rowspan; i++) {
                        for (var m = 0; m < colspan; m++) {
                            cellHeadings[(rowCount + i)][(cellCount + m)] = cellHeadings[rowCount][(cellCount + m)];
                        }
                    }
                }//end if

                cellCount += colspan;
            }//end for

            rowCount++;
        }//end for
    },

    getHeadersContent: function(element)
    {
        var headers = element.getAttribute('headers');
        if (!headers) {
            return '';
        }

        var parts   = headers.split(' ');
        var content = [];
        for (var i = 0; i < parts.length; i++) {
            var part = parts[i];

            content.push(dfx.getHtml(dfx.getId(part)));
        }

        content.push(dfx.getHtml(element));
        content = content.join(' ');

        return content;

    },

    getCellContent: function (table, row, column)
    {
        var rows = dfx.getTag('tr', table);
        if (!rows[row]) {
            return null;
        }

        var rowElem = rows[row];

        var cols = dfx.getTag(['td', 'th'], rowElem);
        if (!cols[column]) {
            return null;
        }

        return dfx.getHtml(cols[column]);

    },

    arrayUnique: function(array)
    {
        var tmp    = {};
        var unique = [];
        var count  = array.length;

        for (var i = 0; i < count; i++) {
            tmp[array[i]] = array[i];
        }

        for (var item in tmp) {
            unique.push(tmp[item]);
        }

        return unique;

    },

    arrayIntersect: function(array1, array2)
    {
        var tmp    = {};
        var unique = [];
        var count  = array2.length;

        for (var i = 0; i < count; i++) {
            tmp[array2[i]] = array2[i];
        }

        count = array1.length;
        for (var i = count; i >= 0; i--) {
            if (dfx.isset(tmp[array1[i]]) === false) {
                dfx.unset(array1, i);
            }
        }

        return array1;

    },

    _getRangeCellElement: function(range)
    {
        return this._getCellElement(range.getCommonElement());

    },

    _getCellElement: function(element)
    {
        var cellElement = null;
        if (dfx.isTag(element, 'td') === false
            && dfx.isTag(element, 'th') === false
        ) {
            // Check if any of the parents td or th.
            var parents = dfx.getParents(element, null, this.viper.getViperElement());
            var plen    = parents.length;
            for (var i = 0; i < plen; i++) {
                if (dfx.isTag(parents[i], 'td') === true
                    || dfx.isTag(parents[i], 'th') === true
                ) {
                    cellElement = parents[i];
                    break;
                }
            }
        } else {
            cellElement = element;
        }

        if (!cellElement) {
            return false;
        }

        return cellElement;

    },

    _getTableCells: function(table, stopCell)
    {
        if (!table) {
            table = this.getCellTable(this.getActiveCell());
        }

        var cells = {};
        var rows  = dfx.getTag('tr', table);
        var rlen  = rows.length;
        for (var i = 0; i < rlen; i++) {
            var rowCells      = this._getRowCells(rows[i]);
            var rowCellsCount = rowCells.length;
            cells[i]          = [];
            for (var j = 0; j < rowCellsCount; j++) {
                cells[i].push({
                    cell: rowCells[j],
                    rowspan: this.getRowspan(rowCells[j]),
                    colspan: this.getColspan(rowCells[j]),
                });

                if (stopCell === rowCells[j]) {
                    return cells;
                }
            }
        }

        return cells;

    },

    _getRowNum: function(row)
    {
        var table = this.getRowTable(row, true);
        var rows  = dfx.getTag('tr', table);
        var rlen  = rows.length;
        for (var i = 0; i < rlen; i++) {
            if (rows[i] === row) {
                return i;
            }
        }

        return null;

    },

    getColNum: function(cell)
    {
        if (!cell) {
            return null;
        }

        var cellNum = null;
        var cells   = this._getCellsExpanded();
        var rows    = cells.length;

        for (var i = 0; i < rows; i++) {
            var cellCount = cells[i].length;
            for (var j = 0; j < cellCount; j++) {
                if (cells[i][j] === cell) {
                    return j;
                }
            }
        }

        return null;

    },

    /**
     * Returns the specified cell element.
     *
     * @param {integer} row  The row number.
     * @param {integer} cell The cell number.
     *
     * @return {DOMElement} The cell (td/th) element.
     */
    getCell: function(row, cell)
    {
        if (dfx.isset(cell) === false) {
            return null;
        }

        if (typeof row !== 'number') {
            row = this._getRowNum(row);
        }

        var cells = this._getCellsExpanded();

        return cells[row][cell];

    },

    getCellPosition: function(cell)
    {
        var cells = this._getCellsExpanded();
        var rows    = cells.length;

        for (var i = 0; i < rows; i++) {
            var cellCount = cells[i].length;
            for (var j = 0; j < cellCount; j++) {
                if (cells[i][j] === cell) {
                    return {
                        row: i,
                        col: j
                    };
                }
            }
        }

        return null;
    },

    _getCellsExpanded: function()
    {
        if (this._tableRawCells) {
            return this._tableRawCells;
        }

        var tableCells = this._getTableCells();
        var rawCells   = [];
        dfx.foreach(tableCells, function(rowNum) {
            rowNum = parseInt(rowNum);
            if (!rawCells[rowNum]) {
                rawCells[rowNum] = [];
            }

            dfx.foreach(tableCells[rowNum], function(j) {
                var rowCell = tableCells[rowNum][j].cell;
                var rowspan = tableCells[rowNum][j].rowspan;
                var colspan = tableCells[rowNum][j].colspan;

                for (var i = 0; i < rowspan; i++) {
                    var modifier = 0;
                    for (var k = 0; k < colspan; k++) {
                        if (!rawCells[(rowNum + i)]) {
                            rawCells[(rowNum + i)] = [];
                        }

                        while (rawCells[(rowNum + i)][(j + k + modifier)]) {
                            modifier++;
                        }

                        rawCells[(rowNum + i)][(j + k + modifier)] = rowCell;
                    }
                }
            });
        });

        this._tableRawCells = rawCells;

        return rawCells;

    },

    _getPreviousRow: function(row)
    {
        while (row = row.previousSibling) {
            if (row.nodeType === dfx.ELEMENT_NODE) {
                var tagName = row.tagName.toLowerCase();
                if (tagName === 'tr' || tagName === 'th') {
                    return row;
                }
            }
        }

    },

    _getNextRow: function(row, goPrev)
    {
        while (row = row.nextSibling) {
            if (row.nodeType === dfx.ELEMENT_NODE) {
                var tagName = row.tagName.toLowerCase();
                if (tagName === 'tr' || tagName === 'th') {
                    return row;
                }
            }
        }

        if (goPrev === true) {
            return this._getPreviousRow(row);
        }

    },

    _getRowCells: function(row)
    {
        var tags = dfx.getTag(['td', 'th'], row);
        return tags;

    },

    _getRowCellCount: function(row)
    {
        var cellCount = 0;
        for (var node = row.firstChild; node; node = node.nextSibling) {
            if (dfx.isTag(node, 'th') === true || dfx.isTag(node, 'td') === true) {
                cellCount += this.getColspan(node);
            }
        }

        return cellCount;

    },

    _moveCellContent: function(fromCell, toCell)
    {
        if (!fromCell || !toCell) {
            return false;
        }

        while (fromCell.firstChild) {
            toCell.appendChild(fromCell.firstChild);
        }

    }

};
