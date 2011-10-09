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
    this._margin        = 15;

    // Table properties.
    this._currentTablePropView = 'cell';
    this._settingsWidgets      = {};

}

ViperTableEditorPlugin.prototype = {

    init: function()
    {
        var self = this;
        this.viper.registerCallback('Viper:editableElementChanged', 'ViperTableEditor', function() {
            if (self.viper.isBrowser('firefox') === true) {
                // Disable Firefox table editing.
                document.execCommand("enableInlineTableEditing", false, false);
                document.execCommand("enableObjectResizing", false, false);
            }
        });

        this.viper.registerCallback('Viper:keyDown', 'ViperTableEditor', function(e) {
            if (e.which === 9) {
                // Handle tab key.
                self.removeHighlights();
                if (self.moveCaretToNextCell() === false) {
                    // Create a new row.
                    self.insertRowAfter(self.activeCell);
                    self.moveCaretToNextCell();
                }

                dfx.preventDefault(e);
                return false;
            }

        });

        this.toolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        this.toolbarPlugin.addButton('TableEditor', 'table', 'Insert/Edit Table', function () {
            self.insertTable();
        });

        this.toolbarPlugin.addButton('TableEditor', 'format', 'Set Table Headers', function () {
            var tables = dfx.getTag('table', self.viper.getViperElement());
            for (var i = 0; i < tables.length; i++) {
                self.setTableHeaders(tables[i]);
            }
        });

        if (this._isiPad() === false) {
            var showToolbar = false;
            this.viper.registerCallback('Viper:mouseUp', 'ViperTableEditor', function(e) {
                var range = self.viper.getCurrentRange();
                if (range.collapsed === false) {
                    self.removeHighlights();
                    self.hideCellToolsIcon();
                    return true;
                }

                var target = dfx.getMouseEventTarget(e);
                if (target === self._toolbar || dfx.isChildOf(target, self._toolbar) === true) {
                    self._buttonClicked = false;
                    return false;
                }

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
                if (range.collapsed === false) {
                    return;
                }

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

        if (this._isiPad() === true) {
            // During zooming hide the toolbar.
            dfx.addEvent(window, 'gesturestart', function() {
                self.hideToolbar();
            });

            this.viper.registerCallback('Viper:elementScaled', 'ViperTableEditorPlugin', function(data) {
                if (data.element !== self._toolbar) {
                    return false;
                }

                if (data.scale === 1) {
                    self._margin = 15;
                } else {
                    self._margin = (15 - (((1 - data.scale) / 0.1) * 5));
                }

                self.updateToolbar(self.getActiveCell(), self._currentType);
            });
        }//end if

        this._createToolbar();

    },

    /**
     * Shows the cell tools icon for the given cell element.
     *
     * When the icon is hovered, it will be converted to list of buttons where user
     * can pick between table/row/column/cell properties.
     *
     * @param {DOMNode} cell The table cell (TD/TH) element to point to and edit.
     */
    showCellToolsIcon: function(cell)
    {
        if (!cell) {
            return;
        }

        this.hideToolbar();

        var toolsid = this.viper.getId() + '-ViperTEP';
        var tools   = dfx.getId(toolsid);

        if (tools) {
            dfx.remove(tools);
        }

        this.setActiveCell(cell);

        var self      = this;
        var showTools = function(type) {
            dfx.remove(tools);
            var range = self.viper.getCurrentRange();
            range.collapse(true);
            ViperSelection.addRange(range);
            self.showTableTools(cell, type);
        };

        tools    = document.createElement('div');
        tools.id = toolsid;
        dfx.addClass(tools, 'ViperITP themeDark compact visible');

        var buttonGroup = ViperTools.createButtonGroup('ViperITP-tools');
        var tableBtn = this.createButton('', false, '', false, 'table', function() {
            showTools('table');
        }, buttonGroup);
        var rowBtn   = this.createButton('', false, '', false, 'tableRow hidden', function() {
            showTools('row');
        }, buttonGroup);
        var colBtn   = this.createButton('', false, '', false, 'tableCol hidden', function() {
            showTools('col');
        }, buttonGroup);
        var cellBtn  = this.createButton('', false, '', false, 'tableCell hidden', function() {
            showTools('cell');
        }, buttonGroup);

        var btns = [rowBtn, colBtn, cellBtn];

        tools.appendChild(buttonGroup);

        var cellCoords   = dfx.getBoundingRectangle(cell);
        var toolsWidth = 42;

        dfx.setStyle(tools, 'top', cellCoords.y2 + 5 + 'px');
        dfx.setStyle(tools, 'left', cellCoords.x1 + ((cellCoords.x2 - cellCoords.x1) / 2) - (toolsWidth / 2) + 'px');

        if (this._isiPad() === false) {
            // On Hover of the buttons highlight the table/row/col/cell.
            dfx.hover(tableBtn, function() {
                self.setActiveCell(cell);
                self.highlightActiveCell('table');
            }, function() {
                self.removeHighlights();
            });
            dfx.hover(rowBtn, function() {
                self.setActiveCell(cell);
                self.highlightActiveCell('row');
            }, function() {
                self.removeHighlights();
            });
            dfx.hover(colBtn, function() {
                self.setActiveCell(cell);
                self.highlightActiveCell('col');
            }, function() {
                self.removeHighlights();
            });
            dfx.hover(cellBtn, function() {
                self.setActiveCell(cell);
                self.highlightActiveCell('cell');
            }, function() {
                self.removeHighlights();
            });

            // On hover show the list of available table properties buttons.
            dfx.hover(tools, function() {
                self.setActiveCell(cell);
                self.highlightActiveCell();
                dfx.removeClass(btns, 'hidden');
                dfx.setStyle(tools, 'margin-left', '-45px');
            }, function() {
                self.removeHighlights();
                dfx.addClass(btns, 'hidden');
                dfx.setStyle(tools, 'margin-left', '0');
            });
        } else {
            // On iPad just show the tools.
            dfx.addEvent(tools, 'click', function() {
                showTools('cell');
            });
        }

        document.body.appendChild(tools);

        // TODO: For testing only.
        var cellContent = this.getHeadersContent(cell);
        if (cellContent) {
            console.info(cellContent);
        }

    },

    hideCellToolsIcon: function()
    {
        var toolsid = this.viper.getId() + '-ViperTEP';
        var tools   = dfx.getId(toolsid);

        if (tools) {
            dfx.remove(tools);
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

        dfx.addClass(this._toolbar, 'ViperITP themeDark Viper-scalable');
        dfx.addClass(this._lineage, 'ViperITP-lineage');
        dfx.addClass(this._toolsContainer, 'ViperITP-tools');
        dfx.addClass(this._subSectionContainer, 'ViperITP-subSectionWrapper');

        if (this._isiPad() === true) {
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

        var button = ViperTools.createButton(content, isActive, titleAttr, disabled, customClass, clickAction, groupElement, subSection, showSubSection);

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
    updateToolbar: function(cell, type, activeSubSection)
    {
        this._tableRawCells = null;
        this.setActiveCell(cell);

        this.removeHighlights();
        this.hideToolbar();

        this._currentType = type;

        dfx.removeClass(this._toolbar, 'subSectionVisible');

        // Set highlight to active cell.
        this.highlightActiveCell();

        this._updateLineage(type);
        this._updateInnerContainer(cell, type, activeSubSection);
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
        var table = this.getCellTable(this.activeCell);
        this.viper.fireNodesChanged([table]);

    },

    _isiPad: function()
    {
        if (navigator.userAgent.match(/iPad/i) !== null) {
            return true;
        }

        return false;
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
                if (this.getRowspan(activeCell) > 1) {
                    coords         = dfx.getBoundingRectangle(activeCell.parentNode);
                    var cellCoords = dfx.getBoundingRectangle(activeCell);
                    coords.y2      = cellCoords.y2;
                } else {
                    element = activeCell.parentNode;
                }
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

    _updateInnerContainer: function(cell, type, activeSubSection)
    {
        dfx.empty(this._toolsContainer);
        dfx.empty(this._subSectionContainer);

        switch (type) {
            case 'cell':
            default:
                this._createCellProperties(cell, activeSubSection);
            break;

            case 'col':
                this._createColProperties(cell);
            break;

            case 'row':
                this._createRowProperties(cell);
            break;
        }

    },

    _createCellProperties: function(cell, activeSubSection)
    {
        var isActive = false;
        if (dfx.isTag(cell, 'th') === true) {
            isActive = true;
        }

        var self = this;
        this.createButton('Heading', isActive, 'Toggle Heading', false, '', function() {
            // Switch between header and normal cell.
            if (dfx.isTag(cell, 'th') === true) {
                var newCell = self.convertToCell(cell);
                self.updateToolbar(newCell);
            } else {
                var newCell = self.convertToHeader(cell);
                self.updateToolbar(newCell);
            }
        });

        var splitBtnGroup = this.createButtonGroup();
        this.createButton('', false, 'Split Vertically', (this.getColspan(cell) <= 1), 'splitVert', function() {
            self._buttonClicked = true;
            self.splitVertical(cell);
            self.updateToolbar(cell, 'cell', 'merge');
        }, splitBtnGroup);

        this.createButton('', false, 'Split Horizontally', (this.getRowspan(cell) <= 1), 'splitHoriz', function() {
            self._buttonClicked = true;
            self.splitHorizontal(cell);
            self.updateToolbar(cell, 'cell', 'merge');
        }, splitBtnGroup);

        var mergeSubWrapper = document.createElement('div');
        var mergeBtnGroup   = this.createButtonGroup();
        mergeSubWrapper.appendChild(splitBtnGroup);
        mergeSubWrapper.appendChild(mergeBtnGroup);
        var mergeUp = this.createButton('', false, 'Merge Up', (this.canMergeUp(cell) === false), 'mergeUp', function() {
            self._buttonClicked = true;
            self.updateToolbar(self.mergeUp(cell), 'cell', 'merge');
        }, mergeBtnGroup);

        var mergeDown = this.createButton('', false, 'Merge Down', (this.canMergeDown(cell) === false), 'mergeDown', function() {
            self._buttonClicked = true;
            self.updateToolbar(self.mergeDown(cell), 'cell', 'merge');
        }, mergeBtnGroup);

        var mergeLeft = this.createButton('', false, 'Merge Left', (this.canMergeLeft(cell) === false), 'mergeLeft', function() {
            self._buttonClicked = true;
            self.updateToolbar(self.mergeLeft(cell), 'cell', 'merge');
        }, mergeBtnGroup);

        var mergeRight = this.createButton('', false, 'Merge Right', (this.canMergeRight(cell) === false), 'mergeRight', function() {
            self._buttonClicked = true;
            self.updateToolbar(self.mergeRight(cell), 'cell', 'merge');
        }, mergeBtnGroup);

        var mergeSubActive = false;
        if (activeSubSection === 'merge') {
            mergeSubActive = true;
        }

        var mergeSubSection = this.createSubSection(mergeSubWrapper, false);
        this.createButton('', false, 'Toggle Merge/Split Options', false, 'splitMerge', null, null, mergeSubSection, mergeSubActive);

    },

    _createColProperties: function(cell)
    {
        var self = this;
        var insertLeft = this.createButton('', false, 'Insert Column Before', false, 'addLeft', function() {
            self._buttonClicked = true;
            self.insertColBefore(cell);
            self.updateToolbar(cell, 'col');
        });

        var insertRight = this.createButton('', false, 'Insert Column After', false, 'addRight', function() {
            self._buttonClicked = true;
            self.insertColAfter(cell);
            self.updateToolbar(cell, 'col');
        });

        var removeCol = this.createButton('', false, 'Remove Column', false, 'delete', function() {
            self._buttonClicked = true;
            self.removeCol(cell);
            self.hideToolbar();
            self.removeHighlights();
        });

    },

    _createRowProperties: function(cell)
    {
        var self = this;
        var insertBefore = this.createButton('', false, 'Insert Row Before', false, 'addAbove', function() {
            self._buttonClicked = true;
            self.insertRowBefore(cell);
            self.updateToolbar(cell, 'row');
        });

        var insertAfter = this.createButton('', false, 'Insert Row After', false, 'addBelow', function() {
            self._buttonClicked = true;
            self.insertRowAfter(cell);
            self.updateToolbar(cell, 'row');
        });

        var removeRow = this.createButton('', false, 'Remove Row', false, 'delete', function() {
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
        var cells   = this._getCellsExpanded();
        var cellPos = this.getCellPosition(cell);
        var rowspan = this.getRowspan(cell);

        if (cellPos.col === 0) {
            // First column so cannot merge left.
            return false;
        }

        var processedCells = [];
        var rowspans       = 0;
        var prevColspan    = null;
        for (var i = 0; i < rowspan; i++) {
            // Check each previous cell, make sure:
            // - First one start from current cell's row position
            // - They all have the same colspan
            // - Total rowspan must be the same as current cell's rowspan.
            var prevCell = cells[(cellPos.row + i)][(cellPos.col - 1)];
            if (processedCells.inArray(prevCell) === true) {
                continue;
            }

            processedCells.push(prevCell);

            var pos = this.getCellPosition(prevCell);
            if (i === 0 && pos.row !== cellPos.row) {
                // First previous cell must be at the same level as the current cell.
                return false;
            }

            rowspans += this.getRowspan(prevCell);

            if (rowspans > rowspan) {
                // Total rowspan must be the same as current cell's rowspan.
                return false;
            } else if (prevColspan !== null && prevColspan !== this.getColspan(prevCell)) {
                // - They all have the same colspan.
                return false;
            }

            prevColspan = this.getColspan(prevCell);
        }

        if (rowspans === rowspan) {
            // Total rowspan must be the same as current cell's rowspan.
            return processedCells;
        }

        return false;

    },

    canMergeRight: function(cell)
    {
        var cells   = this._getCellsExpanded();
        var cellPos = this.getCellPosition(cell);
        var rowspan = this.getRowspan(cell);
        var colspan = this.getColspan(cell);

        if (cell === (cells[cellPos.row][(cells[cellPos.row].length - 1)])) {
            // Last column so cannot merge right.
            return false;
        }

        var processedCells = [];
        var rowspans       = 0;
        var prevColspan    = null;
        for (var i = 0; i < rowspan; i++) {
            // Check each next cell, make sure:
            // - First one start from current cell's row position
            // - They all have the same colspan
            // - Total rowspan must be the same as current cell's rowspan.
            var nextCell = cells[(cellPos.row + i)][(cellPos.col + colspan)];
            if (processedCells.inArray(nextCell) === true) {
                continue;
            }

            processedCells.push(nextCell);

            var pos = this.getCellPosition(nextCell);
            if (i === 0 && pos.row !== cellPos.row) {
                // First previous cell must be at the same level as the current cell.
                return false;
            }

            rowspans += this.getRowspan(nextCell);

            if (rowspans > rowspan) {
                // Total rowspan must be the same as current cell's rowspan.
                return false;
            } else if (prevColspan !== null && prevColspan !== this.getColspan(nextCell)) {
                // - They all have the same colspan.
                return false;
            }

            prevColspan = this.getColspan(nextCell);
        }

        if (rowspans === rowspan) {
            // Total rowspan must be the same as current cell's rowspan.
            return processedCells;
        }

        return false;

    },

    canMergeDown: function(cell)
    {
        var rowspan = this.getRowspan(cell);
        var colNum  = this.getColNum(cell);
        var row     = cell.parentNode;
        var colspan = this.getColspan(cell);

        while (rowspan >= 1) {
            row = this._getNextRow(row);
            rowspan--;
        }

        if (row) {
            var cspan          = 0;
            var processedCells = [];
            var prevRowspan    = null;
            for (var i = 0; i < colspan; i++) {
                var newCell = this.getCell(row, (colNum + i));
                if (!newCell) {
                    return false;
                }

                if (processedCells.inArray(newCell) === true) {
                    continue;
                }

                processedCells.push(newCell);

                var newCellRowspan = this.getRowspan(newCell);
                if (prevRowspan !== null && prevRowspan !== newCellRowspan) {
                    return false
                }

                prevRowspan = newCellRowspan;

                cspan += this.getColspan(newCell);
                if (colspan < cspan) {
                    return false;
                }
            }

            return processedCells;
        }

        return false;

    },

    canMergeUp: function(cell)
    {
        var rowspan = this.getRowspan(cell);
        var colNum  = this.getColNum(cell);
        var row     = cell.parentNode;
        var newCell = null;
        var colspan = this.getColspan(cell);

        while (row && !newCell) {
            row     = this._getPreviousRow(row);
            if (!row) {
                return false;
            }

            newCell = this.getCell(row, colNum);
        }

        if (row) {
            var cspan          = 0;
            var processedCells = [];
            var prevRowspan    = null;
            for (var i = 0; i < colspan; i++) {
                var newCell = this.getCell(row, (colNum + i));
                if (!newCell) {
                    return false;
                }

                if (processedCells.inArray(newCell) === true) {
                    continue;
                }

                processedCells.push(newCell);

                var newCellRowspan = this.getRowspan(newCell);
                if (prevRowspan !== null && prevRowspan !== newCellRowspan) {
                    return false
                }

                prevRowspan = newCellRowspan;

                cspan += this.getColspan(newCell);
                if (colspan < cspan) {
                    return false;
                }
            }

            return processedCells;
        }

        return false;

    },

    mergeLeft: function(cell)
    {
        var mergeCells = this.canMergeLeft(cell);
        if (!mergeCells || mergeCells.length === 0) {
            return;
        }

        var newColspan = (this.getColspan(cell) + this.getColspan(mergeCells[0]));
        this.setColspan(cell, newColspan);

        for (var i = 0; i < mergeCells.length; i++) {
            this._moveCellContent(mergeCells[i], cell);
            dfx.remove(mergeCells[i]);
        }

        this.tableUpdated();

        return cell;

    },

    mergeRight: function(cell)
    {
        var mergeCells = this.canMergeRight(cell);
        if (!mergeCells || mergeCells.length === 0) {
            return;
        }

        var newColspan = (this.getColspan(cell) + this.getColspan(mergeCells[0]));
        this.setColspan(cell, newColspan);

        for (var i = 0; i < mergeCells.length; i++) {
            this._moveCellContent(mergeCells[i], cell);
            dfx.remove(mergeCells[i]);
        }

        this.tableUpdated();

        return cell;
    },

    mergeDown: function(cell)
    {
        var mergeCells = this.canMergeDown(cell);
        if (mergeCells.length == 0) {
            return false;
        }

        this.setActiveCell(cell);

        var parent = mergeCells[0].parentNode;

        for (var i = 0; i < mergeCells.length; i++) {
            this._moveCellContent(mergeCells[i], cell);
            dfx.remove(mergeCells[i]);
        }

        var rowspan = this.getRowspan(cell) + this.getRowspan(mergeCells[0]);
        this.setRowspan(cell, rowspan);

        var cells    = this._getCellsExpanded(true);
        var rowCells = this._getRowCells(parent);
        if (rowCells.length === 0) {
            // Find the row index.
            var rows     = dfx.getTag('tr', this.getCellTable(cell));
            var rowIndex = -1;
            for (var i = 0; i < rows.length; i++) {
                if (rows[i] === parent) {
                    rowIndex = i;
                    break;
                }
            }

            if (rowIndex >= 0) {
                var processedCells = [];
                cells = cells[rowIndex];
                for (var i = 0; i < cells.length; i++) {
                    if (processedCells.inArray(cells[i]) === true) {
                        continue;
                    }

                    processedCells.push(cells[i]);

                    var rowspan = (this.getRowspan(cells[i]) - 1);
                    this.setRowspan(cells[i], rowspan);
                }
            }

            dfx.remove(parent);

        }

        this.tableUpdated();

        return cell;

    },

    mergeUp: function(cell)
    {
        var mergeCells = this.canMergeUp(cell);
        if (mergeCells.length == 0) {
            return false;
        }

        this.setActiveCell(cell);

        var cellPos = this.getCellPosition(cell);

        var parent    = cell.parentNode;
        var firstCell = mergeCells[0];

        for (var i = 1; i < mergeCells.length; i++) {
            this.setColspan(firstCell, this.getColspan(firstCell) + this.getColspan(mergeCells[i]));
            this._moveCellContent(mergeCells[i], firstCell);
            dfx.remove(mergeCells[i]);
        }

        this._moveCellContent(cell, firstCell);

        dfx.remove(cell);

        var rowspan = this.getRowspan(firstCell) + this.getRowspan(cell);
        this.setRowspan(firstCell, rowspan);

        this.setActiveCell(firstCell);

        // Check if we need to remove the cell's parent row if empty.
        var cells    = this._getCellsExpanded(true);
        var rowCells = cells[cellPos.row];
        var prevPos  = this.getCellPosition(firstCell).row;
        var remove   = true;

        for (var i = 0; i < rowCells.length; i++) {
            var pos = this.getCellPosition(rowCells[i]);
            if (pos.row !== prevPos || rowspan !== this.getRowspan(rowCells[i])) {
                remove = false;
                break;
            }
        }

        if (remove === true) {
            // Remove row.
            dfx.remove(parent);

            // Reduce rowspan.
            var processedCells = [];
            for (var i = 0; i < rowCells.length; i++) {
                if (processedCells.inArray(rowCells[i]) === true) {
                    continue;
                }

                processedCells.push(rowCells[i]);

                var newRowspan = (this.getRowspan(rowCells[i]) - 1);
                this.setRowspan(rowCells[i], newRowspan);
            }
        }

        this.tableUpdated();


        return firstCell;

    },

    getRowspan: function(cell)
    {
        return parseInt(cell.getAttribute('rowspan') || 1);

    },

    setRowspan: function(cell, rowspan)
    {
        if (rowspan > 1) {
            cell.setAttribute('rowspan', rowspan);
        } else {
            dfx.removeAttr(cell, 'rowspan');
        }

    },

    getColspan: function(cell)
    {
        return parseInt(cell.getAttribute('colspan') || 1);

    },

    setColspan: function(cell, colspan)
    {
        if (colspan > 1) {
            cell.setAttribute('colspan', colspan);
        } else {
            dfx.removeAttr(cell, 'colspan');
        }

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
        dfx.setHtml(elem, '&nbsp;');

        var colspan = (parseInt(cell.getAttribute('colspan')) - 1);
        this.setColspan(cell, colspan);

        var rowspan = cell.getAttribute('rowspan');
        if (rowspan > 1) {
            this.setRowspan(elem, rowspan);
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
        this.setRowspan(cell, (rowspan - 1));

        var colspan = this.getColspan(cell);
        var newCell = document.createElement(dfx.getTagName(cell));
        dfx.setHtml(newCell, '&nbsp;');
        if (colspan > 1) {
            this.setColspan(newCell, colspan);
        }

        // Find the new cell's insertion point.
        // Next row is startRowPosition + originalRowspan - 1 (minus 1 since default rowspan is 1).
        var nextRowIndex = (cellPos.row + rowspan - 1);
        var rowCells     = this._getRowCells(rows[nextRowIndex]);

        if (rowCells.length === 0) {
            rows[nextRowIndex].appendChild(newCell);
        } else if (cellPos.col === 0) {
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
                this.setRowspan(rowCell, (rowspan + 1));
            } else {
                var newCell = document.createElement(dfx.getTagName(rowCell));
                dfx.setHtml(newCell, '&nbsp;');

                var colspan = this.getColspan(rowCell);
                if (colspan > 1) {
                    this.setColspan(newCell, colspan);
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
                this.setRowspan(rowCell, (rowspan + 1));
            } else {
                var newCell = document.createElement(dfx.getTagName(rowCell));
                dfx.setHtml(newCell, '&nbsp;');

                var colspan = this.getColspan(rowCell);
                if (colspan > 1) {
                    this.setColspan(newCell, colspan);
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
                this.setRowspan(rowCell, (rowspan - 1));

                var rowPos = this.getCellPosition(rowCell).row;
                if (rowPos === cellPos.row) {
                    // Move cell down.
                    var nextRowPos = cells[(rowPos + 1)].find(rowCell);
                    if (nextRowPos > 0) {
                        dfx.insertAfter(cells[(rowPos + 1)][(nextRowPos - 1)], rowCell);
                    } else {
                        dfx.insertBefore(cells[(rowPos + 1)][(nextRowPos + this.getColspan(rowCell))], rowCell);
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
                this.setColspan(col, (this.getColspan(col) + 1));
            } else if (cellPos.row < i) {
                if (td) {
                    this.setRowspan(td, (this.getRowspan(td) + 1));
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
                this.setColspan(col, (this.getColspan(col) + 1));
            } else if (cellPos.row < i) {
                if (td) {
                    this.setRowspan(td, (this.getRowspan(td) + 1));
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
                    this.setColspan(rowCell, (rowCellColspan - 1));
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
                dfx.setHtml(cell, '&nbsp;');
                child = cell.firstChild;
            }

            range.setStart(child, 0);
            range.collapse(true);
            ViperSelection.addRange(range);
            return range;
        } else {
            this.hideCellButtons();
        }

    },

    moveCaretToNextCell: function()
    {
        var range = this.viper.getCurrentRange();
        var cell  = this._getRangeCellElement(range);

        if (!cell) {
            return false;
        }

        this.setActiveCell(cell);

        var node = cell;
        while (node) {
            if (!node.nextSibling) {
                // Get next row.
                var nextRow = this._getNextRow(node.parentNode);
                if (!nextRow) {
                    return false;
                } else {
                    node = nextRow.firstChild;
                }
            } else {
                node = node.nextSibling;
            }

            if (dfx.isTag(node, 'th') === true || dfx.isTag(node, 'td') === true) {
                break;
            }
        }

        if (!node) {
            return false;
        }

        this.moveCaretToCell(node);

        return true;

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
        var headers = dfx.find(table, '[headers]');
        if (headers.length > 0) {
            console.info('Cannot set table headers; they are already set.', table);
            return;
        }

        var tableId = table.getAttribute('id');

        if (!tableId) {
            while (!tableId) {
                tableId = dfx.getUniqueId().substr(-5, 5);
                var tElem = dfx.getId(tableId);
                if (tElem) {
                    tableId = null;
                }
            }

            table.setAttribute('id', tableId);
        }

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
                var colspan = this.getColspan(cell);
                var rowspan = this.getRowspan(cell);

                if (dfx.isTag(cell, 'th') === true && dfx.isBlank(dfx.getHtml(cell)) === false) {
                    // This is a table header, so figure out an ID-based representation
                    // of the cell content. We'll use this later as a basis for the ID attribute
                    // although it may be prefixed with the ID of another header to make it unique.

                    var cellid = cell.getAttribute('id');
                    if (!cellid) {
                        cellid = tableId + 'r' + rowCount + 'c' + cellCount;
                    }

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

                            if (dfx.isset(cellHeadings[(rowCount + i)]) === false) {
                                cellHeadings[(rowCount + i)] = [];
                            }

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

                            if (dfx.isset(cellHeadings[(rowCount - 1)]) === true
                                && dfx.isset(cellHeadings[(rowCount - 1)][(cellCount + i)]) === true
                            ) {
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
                            if (dfx.isset(cellHeadings[rowCount]) === false) {
                                cellHeadings[rowCount] = [];
                            }

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
                            if (dfx.isset(cellHeadings[(rowCount + i)]) === false) {
                                cellHeadings[(rowCount + i)] = [];
                            }

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

    _getCellsExpanded: function(forceUpdate)
    {
        if (forceUpdate !== true && this._tableRawCells) {
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
                var modifier = 0;
                for (var i = 0; i < rowspan; i++) {
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
