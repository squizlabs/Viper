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

        this.viper.registerCallback('ViperHistoryManager:undo', 'ViperTableEditor', function() {
            self.hideCellButtons();
        });

        this.viper.registerCallback('ViperHistoryManager:redo', 'ViperTableEditor', function() {
            self.hideCellButtons();
        });

        this.viper.registerCallback('Viper:selectionChanged', 'ViperTableEditorPlugin', function(range) {
            self.hideToolbar();
            var cell = self._getRangeCellElement(range);
            if (cell) {
                // Show cell Tools.
                return self.showCellToolsIcon(cell);
            }
        });

        this._initChangeTrackerCallbacks();

        this._createToolbar();

    },

    showCellToolsIcon: function(cell)
    {
        if (!cell) {
            return;
        }

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

        document.body.appendChild(overlay);

        var self = this;
        dfx.addEvent(overlay, 'click', function() {
            dfx.remove(overlay);
            var range = self.viper.getCurrentRange();
            range.collapse(true);
            ViperSelection.addRange(range);
            self.showTableTools(cell);
            //self.viper.fireSelectionChanged();
        });

    },

    showTableTools: function(cell)
    {
        this.setActiveCell(cell);
        this.updateToolbar(cell);

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
        this.hideToolbar();

        if (navigator.userAgent.match(/iPad/i) !== null) {
            this._scaleToolbar();
        }

        dfx.removeClass(this._toolbar, 'subSectionVisible');

        this._updateLineage();
        this._updateInnerContainer(cell, type);
        this._updatePosition(cell, type);

    },

    showActiveSubSection: function()
    {
        dfx.addClass(this._toolbar, 'subSectionVisible');
    },

    hideActiveSubSection: function()
    {
        dfx.removeClass(this._toolbar, 'subSectionVisible');
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
        var scale = (1.2 / zoom);
        if (scale >= 1.2) {
            scale        = 1.2;
            this._margin = 20;
        } else if (scale <= 0.5) {
            scale        = 0.5;
            this._margin = -12;
        } else {
            this._margin = (-6 * zoom);
        }

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

        var top = (rangeCoords.bottom + scrollCoords.y + 10);

        dfx.setStyle(this._toolbar, 'top', top + 'px');
        dfx.addClass(this._toolbar, 'visible');

    },

    _getElementCoords: function(element)
    {
        var elemRect     = dfx.getBoundingRectangle(element);
        var scrollCoords = dfx.getScrollCoords();
        return {
            left: elemRect.x1,
            right: elemRect.x2,
            top: elemRect.y1 - scrollCoords.y,
            bottom: elemRect.y2 - scrollCoords.y
        };

    },

    _updateLineage: function()
    {
        var self = this;

        dfx.empty(this._lineage);

        var table  = document.createElement('li');
        dfx.addClass(table, 'ViperITP-lineageItem');
        dfx.setHtml(table, 'Table');
        this._lineage.appendChild(table);
        dfx.addEvent(table, 'mousedown', function() {
            self.updateToolbar(self.getActiveCell(), 'table');
        });

        var row  = document.createElement('li');
        dfx.addClass(row, 'ViperITP-lineageItem');
        dfx.setHtml(row, 'Row');
        this._lineage.appendChild(row);
        dfx.addEvent(row, 'mousedown', function() {
            self.updateToolbar(self.getActiveCell(), 'row');
        });

        var col  = document.createElement('li');
        dfx.addClass(col, 'ViperITP-lineageItem');
        dfx.setHtml(col, 'Column');
        this._lineage.appendChild(col);
        dfx.addEvent(col, 'mousedown', function() {
            self.updateToolbar(self.getActiveCell(), 'col');
        });

        var cell  = document.createElement('li');
        dfx.addClass(cell, 'ViperITP-lineageItem');
        dfx.setHtml(cell, 'Cell');
        this._lineage.appendChild(cell);
        dfx.addEvent(cell, 'mousedown', function() {
            self.updateToolbar(self.getActiveCell(), 'cell');
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
        }

    },

    _createCellProperties: function(cell)
    {
        var isActive = false;
        if (dfx.isTag(cell, 'th') === true) {
            isActive = true;
        }

        var button = null;
        var self   = this;
        button = this.createButton('Heading', isActive, '', function() {
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
        var mergeUp = this.createButton('U', false, '', function() {
        });
        var mergeDown = this.createButton('D', false, '', function() {
        });
        var span = document.createElement('span');
        dfx.setHtml(span, 'Merge');

        var mergeLeft = this.createButton('L', false, '', function() {
        });
        var mergeRight = this.createButton('R', false, '', function() {
        });

        wrapper.appendChild(mergeUp);
        wrapper.appendChild(mergeDown);
        wrapper.appendChild(span);
        wrapper.appendChild(mergeLeft);
        wrapper.appendChild(mergeRight);

        var splitWrapper = document.createElement('div');

        var splitVert = this.createButton('V', false, '', function() {
            self.splitVertical(cell);
            self.updateToolbar(cell);
            return false;
        });
        var span = document.createElement('span');
        dfx.setHtml(span, 'Split');

        var splitHor = this.createButton('H', false, '', function() {
            self.splitHorizontal(cell);
            self.updateToolbar(cell);
        });

        splitWrapper.appendChild(splitVert);
        splitWrapper.appendChild(span);
        splitWrapper.appendChild(splitHor);

        subSection.appendChild(wrapper);
        subSection.appendChild(splitWrapper);
        this.createSubSection(subSection, true);
        this.showActiveSubSection();

    },

    /**
     * Hides the inline toolbar.
     */
    hideToolbar: function()
    {
        dfx.removeClass(this._toolbar, 'visible');
        this.hideActiveSubSection();

    },


    setActiveCell: function(cell)
    {
        this.activeCell = cell;

    },

    getActiveCell: function(cell)
    {
        return this.activeCell;

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

        // TODO: Copy, attributes etc.
        dfx.insertBefore(cell, elem);
        dfx.remove(cell);

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

        // TODO: Copy, attributes etc.
        dfx.insertBefore(cell, elem);
        dfx.remove(cell);

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
        if (!cell || !cell.getAttribute('rowspan')) {
            return false;
        }

        var row     = cell.parentNode;
        var rowspan = (parseInt(cell.getAttribute('rowspan')) - 1);
        var i       = rowspan;
        var nextRow = row;

        while (i > 0) {
            nextRow = this._getNextRow(nextRow);
            if (!nextRow) {
                return false;
            }

            i--;
        }

        var tagName        = dfx.getTagName(cell);
        var colNum         = this._getColNum(cell);
        var nextRowColumns = this._getRowColumns(nextRow);

        var elem       = document.createElement(tagName);
        if (rowspan > 1) {
            cell.setAttribute('rowspan', rowspan);
        } else {
            dfx.removeAttr(cell, 'rowspan');
        }

        var colspan = cell.getAttribute('colspan');
        if (colspan > 1) {
            elem.setAttribute('colspan', colspan);
        }

        if (colNum < nextRowColumns.length) {
            var nextRowCol = this._getColumn(nextRow, colNum);
            dfx.insertBefore(nextRowCol, elem);
        } else {
            var nextRowCol = this._getColumn(nextRow, (nextRowColumns.length - 1));
            dfx.insertAfter(nextRowCol, elem);
        }

        return elem;

    },

    insertRowBefore: function()
    {
        this.insertRow(true);

    },

    insertRowAfter: function()
    {
        this.insertRow();

    },

    insertRow: function(before)
    {
        if (!this.activeCell) {
            return;
        }

        // Insert a new table row after the selected row.
        var tr = this.activeCell.parentNode;

        var clone = tr.cloneNode(true);
        var cln   = clone.childNodes.length;
        for (var i = 0; i < cln; i++) {
            var el = clone.childNodes[i];
            if (el.nodeType === dfx.ELEMENT_NODE) {
                dfx.setStyle(el, 'width', '');
                dfx.setHtml(el, '&nbsp;');
            }
        }

        if (before === true) {
            dfx.insertBefore(tr, clone);
        } else {
            dfx.insertAfter(tr, clone);
        }

        ViperChangeTracker.addChange('insertedTableRow', [clone]);

        var cellNum = 0;
        var trcln   = tr.childNodes.length;
        for (cellNum = 0; cellNum < trcln; cellNum++) {
            if (this.activeCell === tr.childNodes[cellNum]) {
                break;
            }
        }

        // Set the range to the new row cell.
        this.moveCaretToCell(clone.childNodes[cellNum]);

        this._nodesUpdated();

    },

    removeRow: function(tr)
    {
        if (!tr) {
            tr = this.activeCell.parentNode;
        }

        var elem = this._getNextRow(tr);
        var pos  = 'parent';
        if (!elem) {
            elem = this._getPreviousRow(tr);
            if (!elem) {
                elem = null;
            } else {
                pos = 'after';
            }
        } else {
            pos = 'before';
        }

        if (ViperChangeTracker.isTracking() === true && ViperChangeTracker.isTrackingNode(tr) !== true) {
            var del = document.createElement('del');
            dfx.insertBefore(tr, del);
            del.appendChild(tr);
            dfx.removeClass(tr, 'delHighlight');
            ViperChangeTracker.addChange('removedTableRow', [del]);
        } else {
            dfx.remove(tr);
        }

        if (elem) {
            var colNum = this._getColNum(this.activeCell);
            var column = this._getColumn(elem, colNum);

            this.moveCaretToCell(column);
        } else {
            var table = this.getCellTable(this.activeCell);
            this.removeTable(table);
        }

        this._nodesUpdated();

    },

    insertColAfter: function()
    {
        this.insertCol();

    },

    insertColBefore: function()
    {
        this.insertCol(true);

    },

    insertCol: function(before)
    {
        var table         = this.activeCell.parentNode.parentNode;
        var rows          = dfx.getTag('tr', table);
        var activeCellRow = this.activeCell.parentNode;
        var colNum        = this._getColNum(this.activeCell);

        var changeid = ViperChangeTracker.startBatchChange('insertedTableCol');

        var td;
        var rln = rows.length;
        for (var i = 0; i < rln; i++) {
            var col = this._getColumn(rows[i], colNum);
            td      = document.createElement(col.tagName);
            dfx.setHtml(td, '&nbsp;');
            if (i === 0) {
                dfx.setStyle(td, 'width', '100px');
            }

            if (before === true) {
                dfx.insertBefore(col, td);
            } else {
                dfx.insertAfter(col, td);
            }

            if (changeid !== null) {
                ViperChangeTracker.addNodeToChange(changeid, td);
            }
        }

        if (changeid) {
            ViperChangeTracker.endBatchChange(changeid);
        }

        if (activeCellRow) {
            if (before !== true) {
                colNum++;
            }

            var column = this._getColumn(activeCellRow, colNum);

            this.moveCaretToCell(column);
        }

        this._nodesUpdated();

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
            cols.push(this._getColumn(rows[i], colNum));
        }

        return cols;

    },

    removeCol: function(col)
    {
        if (!col) {
            col = this.activeCell;
        }

        var colNum = this._getColNum(col);
        if (colNum === null) {
            return;
        }

        var row      = col.parentNode;
        var table    = this.getRowTable(row);
        var rows     = dfx.getTag('tr', table);
        var changeid = null;

        if (ViperChangeTracker.isTrackingNode(col) !== true) {
            changeid = ViperChangeTracker.startBatchChange('removedTableCol');
        }

        var rln = rows.length;
        for (var i = 0; i < rln; i++) {
            col = this._getColumn(rows[i], colNum);
            if (changeid) {
                var del = document.createElement('del');
                dfx.insertBefore(col, del);
                del.appendChild(col);
                dfx.removeClass(col, 'delHighlight');
                ViperChangeTracker.addNodeToChange(changeid, del);
            } else {
                dfx.remove(col);
            }
        }

        ViperChangeTracker.endBatchChange(changeid);

        if (colNum > 0) {
            colNum--;
        }

        var nextCell = this._getColumn(row, colNum);
        if (!nextCell) {
            this.removeTable(table, true);
        } else {
            this.moveCaretToCell(nextCell);
        }

        this._nodesUpdated();

    },

    getNextCell: function(cell, goPrev)
    {
        while (cell.nextSibling) {
            cell = cell.nextSibling;
            if (cell.nodeType === dfx.ELEMENT_NODE) {
                var tagName = cell.tagName.toLowerCase();
                if (tagName === 'td' || tagName === 'th') {
                    return cell;
                }
            }
        }

        if (goPrev === true) {
            return this.getPrevCell(cell);
        } else {
            var nextRow = this._getNextRow(cell.parentNode);
            if (nextRow) {
                return this._getColumn(nextRow, 0);
            }
        }

    },

    getPrevCell: function(cell)
    {
        while (cell.previousSibling) {
            cell = cell.previousSibling;
            if (cell.nodeType === dfx.ELEMENT_NODE) {
                var tagName = cell.tagName.toLowerCase();
                if (tagName === 'td' || tagName === 'th') {
                    return cell;
                }
            }
        }

        var prevRow = this._getPreviousRow(cell.parentNode);
        if (prevRow) {
            var col = (dfx.getTag('td,th', prevRow).length - 1);
            return this._getColumn(prevRow, col);
        }

    },

    moveCaretToCell: function(cell)
    {
        if (cell) {
            var range = this.viper.getCurrentRange();
            range.setStart(cell, 0);
            range.moveStart('character', 1);
            range.moveStart('character', -1);
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

        if (ViperChangeTracker.isTracking() === true) {
            var del = document.createElement('del');
            dfx.insertBefore(table, del);
            del.appendChild(table);
            ViperChangeTracker.addChange('removedTable', [del]);
        } else {
            dfx.remove(table);
        }

        this.hideCellButtons();
        this._nodesUpdated();

    },

    getCellTable: function(cell)
    {
        if (!cell) {
            return null;
        }

        var node = cell;
        while (node) {
            if (node.nodeType === dfx.ELEMENT_NODE) {
                if (node.tagName.toLowerCase() === 'table') {
                    return node;
                }
            }

            node = node.parentNode;
        }

    },

    getRowTable: function(row)
    {
        return this.getCellTable(row);

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

        ViperChangeTracker.addChange('insertedTable', [table]);

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

        this._nodesUpdated();

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
        var commonElement = range.getCommonElement();
        var cellElement   = null;

        if (dfx.isTag(commonElement, 'td') === false
            && dfx.isTag(commonElement, 'th') === false
        ) {
            // Check if any of the parents td or th.
            var parents = dfx.getParents(commonElement, null, this.viper.getViperElement());
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
            cellElement = commonElement;
        }

        if (!cellElement) {
            return false;
        }

        return cellElement;

    },

    _getColNum: function(cell)
    {
        if (!cell) {
            return null;
        }

        var tr = cell.parentNode;
        if (!tr) {
            return null;
        }

        var ln = tr.childNodes.length;
        var c  = 0;
        for (var i = 0; i < ln; i++) {
            var node = tr.childNodes[i];
            if (node.nodeType === dfx.ELEMENT_NODE) {
                var tagName = node.tagName.toLowerCase();
                if (tagName === 'td' || tagName === 'th') {
                    if (node === cell) {
                        break;
                    }

                    c++;
                }
            }
        }

        return c;

    },

    _getColumn: function(row, colNum)
    {
        var ln = row.childNodes.length;
        for (var i = 0; i < ln; i++) {
            var node = row.childNodes[i];
            if (node.nodeType === dfx.ELEMENT_NODE) {
                var tagName = node.tagName.toLowerCase();
                if (tagName === 'td' || tagName === 'th') {
                    if (colNum === 0) {
                        return node;
                    }

                    colNum--;
                }
            }
        }

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

    _getRowColumns: function(row)
    {
        var tags = dfx.getTag(['td', 'th'], row);
        return tags;

    },

    _initChangeTrackerCallbacks: function()
    {
        // Tracking Inserts.
        ViperChangeTracker.addChangeType('insertedTable', 'Inserted', 'insert');
        ViperChangeTracker.addChangeType('insertedTableRow', 'Inserted', 'insert');
        ViperChangeTracker.addChangeType('insertedTableCol', 'Inserted', 'insert');
        ViperChangeTracker.setDescriptionCallback('insertedTable', function(node) {
            return 'Table';
        });
        ViperChangeTracker.setDescriptionCallback('insertedTableRow', function(node) {
            return 'Table row';
        });
        ViperChangeTracker.setDescriptionCallback('insertedTableCol', function(node) {
            return 'Table column';
        });

        ViperChangeTracker.setApproveCallback('insertedTable', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setApproveCallback('insertedTableRow', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setApproveCallback('insertedTableCol', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });

        ViperChangeTracker.setRejectCallback('insertedTable', function(clone, node) {
            self.removeTable(node);
        });
        ViperChangeTracker.setRejectCallback('insertedTableRow', function(clone, node) {
            self.removeRow(node);
        });
        ViperChangeTracker.setRejectCallback('insertedTableCol', function(clone, node) {
            self.removeCol(node);
        });

        // Tracking Deletes.
        ViperChangeTracker.addChangeType('removedTable', 'Deleted', 'remove');
        ViperChangeTracker.addChangeType('removedTableRow', 'Deleted', 'remove');
        ViperChangeTracker.addChangeType('removedTableCol', 'Deleted', 'remove');
        ViperChangeTracker.setDescriptionCallback('removedTable', function(node) {
            return 'Table';
        });
        ViperChangeTracker.setDescriptionCallback('removedTableRow', function(node) {
            return 'Table row';
        });
        ViperChangeTracker.setDescriptionCallback('removedTableCol', function(node) {
            return 'Table column';
        });

        ViperChangeTracker.setApproveCallback('removedTable', function(clone, node) {
            dfx.remove(node);
        });
        ViperChangeTracker.setApproveCallback('removedTableRow', function(clone, node) {
            dfx.remove(node);
        });
        ViperChangeTracker.setApproveCallback('removedTableCol', function(clone, node) {
            dfx.remove(node);
        });

        ViperChangeTracker.setRejectCallback('removedTable', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('removedTableRow', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('removedTableCol', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });

        this.viper.registerCallback('ViperChangeTracker:modeChange', 'ViperTableEditor', function(changedTo) {
            var showInserted = true;
            var showRemoved  = false;
            if (changedTo === 'original') {
                showInserted = false;
                showRemoved  = true;
            }

            ViperChangeTracker.setNodeTypeVisibility('insertedTable', showInserted);
            ViperChangeTracker.setNodeTypeVisibility('insertedTableRow', showInserted);
            ViperChangeTracker.setNodeTypeVisibility('insertedTableCol', showInserted);
            ViperChangeTracker.setNodeTypeVisibility('removedTable', showRemoved);
            ViperChangeTracker.setNodeTypeVisibility('removedTableRow', showRemoved);
            ViperChangeTracker.setNodeTypeVisibility('removedTableCol', showRemoved);
        });

    }

};
