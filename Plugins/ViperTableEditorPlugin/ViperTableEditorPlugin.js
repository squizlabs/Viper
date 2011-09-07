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
            document.execCommand("enableInlineTableEditing", false, false);
            document.execCommand("enableObjectResizing", false, false);
        }

        var self = this;
        this.toolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        this.toolbarPlugin.addButton('TableEditor', 'table', 'Insert/Edit Table', function () {
            self.insertTable();
        });

        this.viper.registerCallback('setHtml', 'TablePlugin', function(data) {
            self.hideCellButtons();
        });

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

        this.viper.registerCallback('ViperHistoryManager:undo', 'ViperTableEditor', function() {
            self.hideCellButtons();
        });

        this.viper.registerCallback('ViperHistoryManager:redo', 'ViperTableEditor', function() {
            self.hideCellButtons();
        });

    },

    clicked: function(e, elem)
    {
        if (!elem) {
            elem = dfx.getMouseEventTarget(e);
        }

        var cell = this.isTableCell(elem);
        if (cell !== false) {
            this.showCellButtons(cell);
        } else {
            this.hideCellButtons();
        }

    },

    isTableCell: function(elem)
    {
        if (!elem) {
            return false;
        }

        var node = elem;
        while (node && node !== this.viper.element) {
            if (node.nodeType === dfx.ELEMENT_NODE) {
                var tagName = node.tagName.toLowerCase();
                if (tagName === 'td' || tagName === 'th') {
                    return node;
                }
            }

            node = node.parentNode;
        }

        return false;

    },

    handleDelete: function()
    {
        var range = this.viper.getCurrentRange();
        if (range.startOffset === 0 && range.startContainer.nodeType === dfx.TEXT_NODE) {
            node = range.startContainer.parentNode;
            while (node && node !== this.viper.element) {
                if (node.nodeType === dfx.ELEMENT_NODE && node.tagName.toLowerCase() === 'td') {
                    if (dfx.getNodeTextContent(node).length === 0) {
                        dfx.setHtml(node, '&nbsp;');
                        range.setStart(node.firstChild, 0);
                        range.collapse(true);
                    }

                    return true;
                }

                node = node.parentNode;
            }
        }

    },

    remove: function()
    {
        this.hideCellButtons();
        dfx.removeEvent(document, 'click.TableEditorPlugin');

    },

    caretUpdated: function()
    {
        var range = this.viper.getCurrentRange();
        this._caretUpdated(range.startContainer);

    },

    _caretUpdated: function(cell)
    {
        if (!cell) {
            return;
        }

        var keywordPlugin = this.viper.ViperPluginManager.getPlugin('ViperKeywordPlugin');

        if (keywordPlugin && keywordPlugin.isKeyword(cell) === true) {
            return;
        }

        while (cell && cell !== this.viper.element) {
            if (cell.nodeType === dfx.ELEMENT_NODE) {
                var tagName = cell.tagName.toLowerCase();
                if (tagName === 'td' || tagName === 'th') {
                    this.showCellButtons(cell);
                    return;
                }
            }

            cell = cell.parentNode;
        }

        this.hideCellButtons(cell);

    },

    setActiveCell: function(cell, noUpdate)
    {
        this.activeCell = cell;

        if (noUpdate !== true) {
            this.updateSettings(cell);
        }

    },

    _updatecellButtonPositions: function(cell)
    {
        this.showCellButtons(cell, true);

    },

    hideCellButtons: function(noDisable)
    {
        try {
            var cellTable = this.getCellTable(this.activeCell);
            if (cellTable) {
                // Remove the delHighlight class when cell buttons are removed.
                dfx.removeClass(dfx.getClass('delHighlight', cellTable), 'delHighlight');
            }

            if (noDisable !== true) {
                this.setActiveCell(null);
            }

            dfx.remove(dfx.getClass('ViperTableEditorPlugin-cellButtonsWrapper'));
            this.vCellButtons = null;
            this.hCellButtons = null;

            if (noDisable !== true) {
                this.viper.ViperPluginManager.setActivePlugin(null);
                this.viper.ViperPluginManager.getPlugin('ViperSubToolbarPlugin').hideToolbar('TableEditor');
            }
        } catch (e) {
            // Nodes might have been removed and trying to remove them again
            // will cause an exception. Not important so ignore it.
        }//end try

    },

    showCellButtons: function(cell, noSet)
    {
        if (!cell) {
            return;
        }

        this.hideCellButtons(true);

        this.setActiveCell(cell, noSet);

        var coords = dfx.getBoundingRectangle(cell);

        if (this.vCellButtons === null) {
            this.vCellButtons = this.createVerticalCellButtons();
        }

        if (this.hCellButtons === null) {
            this.hCellButtons = this.createHorizontalCellButtons();
        }

        var wrapper = document.createElement('div');
        dfx.addClass(wrapper, 'ViperTableEditorPlugin-cellButtonsWrapper');
        wrapper.appendChild(this.vCellButtons);
        wrapper.appendChild(this.hCellButtons);

        document.body.appendChild(wrapper);

        if (noSet !== true) {
            this.viper.ViperPluginManager.setActivePlugin('TableEditor');
            // Text can be changed while this plugin is active.
            this.viper.ViperPluginManager.allowTextInput = true;
        }

        this.showVerticalCellButtons(coords);
        this.showHorizontalCellButtons(coords);

    },

    showHorizontalCellButtons: function(coords)
    {
        // Position the vertical buttons.
        dfx.setStyle(this.hCellButtons, 'visibility', 'hidden');
        dfx.setStyle(this.hCellButtons, 'display', 'block');
        var h = 14;
        var w = 42;

        dfx.setStyle(this.hCellButtons, 'top', (coords.y1 - h) + 'px');
        dfx.setStyle(this.hCellButtons, 'left', (coords.x2 - ((coords.x2 - coords.x1) / 2) - (w / 2)) + 'px');
        dfx.setStyle(this.hCellButtons, 'visibility', 'visible');

    },

    showVerticalCellButtons: function(coords)
    {
        // Position the vertical buttons.
        dfx.setStyle(this.vCellButtons, 'visibility', 'hidden');
        dfx.setStyle(this.vCellButtons, 'display', 'block');
        var h = 42;
        var w = 14;

        dfx.setStyle(this.vCellButtons, 'top', (coords.y1 + ((coords.y2 - coords.y1) / 2) - (h / 2)) + 'px');
        dfx.setStyle(this.vCellButtons, 'left', (coords.x1 - w) + 'px');
        dfx.setStyle(this.vCellButtons, 'visibility', 'visible');

    },

    createVerticalCellButtons: function()
    {
        var main = document.createElement('div');
        dfx.addClass(main, 'ViperTableEditorPlugin-v-cellButtons');
        var insertRowAfter = document.createElement('div');
        dfx.attr(insertRowAfter, 'title', 'Insert row below');
        dfx.addClass(insertRowAfter, 'down');
        var insertRowBefore = document.createElement('div');
        dfx.attr(insertRowBefore, 'title', 'Insert row above');
        dfx.addClass(insertRowBefore, 'up');
        var removeRow = document.createElement('div');
        dfx.addClass(removeRow, 'delete');
        dfx.attr(removeRow, 'title', 'Delete row');

        dfx.addClass([insertRowAfter, insertRowBefore, removeRow], 'ViperTableEditorPlugin-cellButton');

        main.appendChild(insertRowBefore);
        main.appendChild(removeRow);
        main.appendChild(insertRowAfter);

        var self = this;
        dfx.addEvent(insertRowAfter, 'click', function() {
            self.insertRowAfter();
        });

        dfx.addEvent(insertRowBefore, 'click', function() {
            self.insertRowBefore();
        });

        dfx.addEvent(removeRow, 'click', function() {
            self.removeRow();
        });

        // Hover events.
        dfx.hover(insertRowAfter, function() {
            dfx.addClass(main, 'after');
        }, function() {
            dfx.removeClass(main, 'after');
        });

        dfx.hover(insertRowBefore, function() {
            dfx.addClass(main, 'before');
        }, function() {
            dfx.removeClass(main, 'before');
        });

        dfx.hover(removeRow, function() {
            dfx.addClass(main, 'delete');
            if (self.activeCell && self.activeCell.parentNode) {
                dfx.addClass(self.activeCell.parentNode, 'delHighlight');
            }
        }, function() {
            dfx.removeClass(main, 'delete');
            if (self.activeCell && self.activeCell.parentNode) {
                dfx.removeClass(self.activeCell.parentNode, 'delHighlight');
            }
        });

        return main;

    },

    createHorizontalCellButtons: function()
    {
        var main = document.createElement('div');
        dfx.addClass(main, 'ViperTableEditorPlugin-h-cellButtons');
        var insertColAfter = document.createElement('div');
        dfx.attr(insertColAfter, 'title', 'Insert column to the right');
        dfx.addClass(insertColAfter, 'right');
        var insertColBefore = document.createElement('div');
        dfx.attr(insertColBefore, 'title', 'Insert column to the left');
        dfx.addClass(insertColBefore, 'left');
        var removeCol = document.createElement('div');
        dfx.addClass(removeCol, 'delete');
        dfx.attr(removeCol, 'title', 'Delete column');

        dfx.addClass([insertColAfter, insertColBefore, removeCol], 'ViperTableEditorPlugin-cellButton');

        main.appendChild(insertColBefore);
        main.appendChild(removeCol);
        main.appendChild(insertColAfter);

        var self = this;
        dfx.addEvent(insertColAfter, 'click', function() {
            self.insertColAfter();
        });

        dfx.addEvent(insertColBefore, 'click', function() {
            self.insertColBefore();
        });

        dfx.addEvent(removeCol, 'click', function() {
            self.removeCol();
        });

        // Hover events.
        dfx.hover(insertColAfter, function() {
            dfx.addClass(main, 'right');
        }, function() {
            dfx.removeClass(main, 'right');
        });

        dfx.hover(insertColBefore, function() {
            dfx.addClass(main, 'left');
        }, function() {
            dfx.removeClass(main, 'left');
        });

        dfx.hover(removeCol, function() {
            dfx.addClass(main, 'delete');
            var table = self.getCellTable(self.activeCell);
            dfx.addClass(self.getColumnCells(table, self._getColNum(self.activeCell)), 'delHighlight');
        }, function() {
            dfx.removeClass(main, 'delete');
            var table = self.getCellTable(self.activeCell);
            dfx.removeClass(self.getColumnCells(table, self._getColNum(self.activeCell)), 'delHighlight');
        });

        return main;

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

    handleTab: function(e)
    {
        if (this.activeCell !== null) {
            var cell = null;
            if (e.shiftKey !== true) {
                cell = this.getNextCell(this.activeCell);
            } else {
                cell = this.getPrevCell(this.activeCell);
            }

            this.moveCaretToCell(cell);
            return true;
        }

    },

    isPluginElement: function(elem)
    {
        if (dfx.hasClass(elem, 'ViperTableEditorPlugin-cellButton') !== true) {
            return false;
        }

        return true;

    },

    _nodesUpdated: function(noFocus)
    {
        this.viper.fireNodesChanged('ViperTableEditorPlugin:update', noFocus);

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

    }


};
