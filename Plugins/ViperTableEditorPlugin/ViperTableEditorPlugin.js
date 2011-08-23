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
    this._subToolbar   = null;
    this._lastNode     = null;

    // Table properties.
    this._currentTablePropView = 'cell';
    this._settingsWidgets      = {};

    this.viper.ViperPluginManager.addKeyPressListener('TAB', this, 'handleTab');
    this.viper.ViperPluginManager.addKeyPressListener('SHIFT+TAB', this, 'handleTab');

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

        this.viper.ViperPluginManager.addKeyPressListener('DELETE', this, 'handleDelete');

        dfx.removeEvent(document, 'click.TableEditorPlugin');
        dfx.addEvent(document, 'click.TableEditorPlugin', function(e) {
            if (self.viper.ViperPluginManager.getActivePlugin() === 'TableEditor') {
                var target = dfx.getMouseEventTarget(e);
                if (dfx.hasClass(target, 'ViperTableEditorPlugin-cellButton') !== true) {
                    if (dfx.isChildOf(target, self._subToolbar) === false) {
                        self.viper.ViperPluginManager.setActivePlugin(null);
                        if (dfx.isChildOf(target, self.viper.element) === false) {
                            self.viper.mouseDown(null, target);
                        }
                    }
                }
            }
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

        this.viper.registerCallback('ViperUndoManager:undo', 'ViperTableEditor', function() {
            self.hideCellButtons();
        });

        this.viper.registerCallback('ViperUndoManager:redo', 'ViperTableEditor', function() {
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

        if (!this._subToolbar) {
            this._setupSubToolbar();
            this.updateSettings(cell);
        } else {
            var subToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperSubToolbarPlugin');
            if (subToolbarPlugin) {
                subToolbarPlugin.showToolbar('TableEditor');
            }
        }

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
            if (dfx.isChildOf(elem, self._subToolbar) === false) {
                return false;
            }
        }

        return true;

    },

    _nodesUpdated: function(noFocus)
    {
        this.viper.fireNodesChanged('ViperTableEditorPlugin:update', noFocus);

    },

    _setupSubToolbar: function()
    {
        var subToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperSubToolbarPlugin');
        if (!subToolbarPlugin) {
            return;
        }

        var toolbar  = subToolbarPlugin.createToolBar('TableEditor');
        var c        = 'ViperTableEditor-stb';
        var contents = '<div class="' + c + '-left"></div>';
        contents    += '<div class="' + c + '-right"></div>';
        dfx.setHtml(toolbar, contents);
        this._subToolbar = toolbar;

        var self = this;
        this.includeWidgets(['Button', 'RadioButton', 'SpinButton', 'TextField', 'Select'], function() {
            var changePropTypeBtn = self.createWidget(c + '-switchToolbar', 'Button');
            changePropTypeBtn.setName('Table Properties');
            changePropTypeBtn.setButtonIconClassName(c + '-switch');
            changePropTypeBtn.create(function(changePropTypeBtnEl) {
                dfx.addClass(changePropTypeBtn.domElem, c + '-tableProperties');
                changePropTypeBtn.setMinWidth('110px');
                dfx.getClass(c + '-right', toolbar)[0].appendChild(changePropTypeBtnEl);
            });

            self._currentTablePropView = 'cell';

            changePropTypeBtn.addClickEvent(function() {
                if (self._currentTablePropView === 'table') {
                    changePropTypeBtn.setName('Table Properties');
                    dfx.removeClass(changePropTypeBtn.domElem, c + '-cellProperties');
                    dfx.addClass(changePropTypeBtn.domElem, c + '-tableProperties');
                    self._showProperties('cell');
                } else {
                    dfx.removeClass(changePropTypeBtn.domElem, c + '-tableProperties');
                    dfx.addClass(changePropTypeBtn.domElem, c + '-cellProperties');
                    changePropTypeBtn.setName('Cell Properties');
                    self._showProperties('table');
                }
            });

            self._setupTableProperties(function(tablePropertiesEl) {
                self._setupCellProperties(function(cellPropertiesEl) {
                    dfx.getClass(c + '-left', toolbar)[0].appendChild(tablePropertiesEl);
                    dfx.getClass(c + '-left', toolbar)[0].appendChild(cellPropertiesEl);
                    self._showProperties(self._currentTablePropView);
                    subToolbarPlugin.showToolbar('TableEditor');
                });
            });
        });

    },

    _setupTableProperties: function(callback)
    {
        var props = {
            tableBorder: 'Table Border',
            cellPadding: 'Cell Padding',
            cellSpacing: 'Cell Spacing'
        };

        this._settingsWidgets.table = {};

        var self = this;
        var c    = 'ViperTableEditor-stb';
        var div  = document.createElement('div');
        dfx.addClass(div, c + '-propertiesWrapper');
        dfx.addClass(div, c + '-tableProps');

        var content = '';
        content    += '<div class="' + c + '-propContainer" id="' + c + '-propContainer-tableWidth"><label>Table Width</label>';
        content    += '<div class="' + c + '-propWrapper ' + c + '-tableWidth-wrapper"></div></div>';

        dfx.foreach(props, function(propid) {
            content += '<div class="' + c + '-propContainer" id="' + c + '-propContainer-' + propid + '"><label>' + props[propid] + '</label>';
            content += '<div class="' + c + '-propWrapper ' + c + '-' + propid + '-wrapper"></div></div>';
        });

        dfx.setHtml(div, content);

        // Table width.
        var tableWidth     = this.createWidget(c + '-tableWidth', 'TextField');
        var tableWidthType = this.createWidget(c + '-tableWidthType', 'Select');
        tableWidthType.addItems({
            px: 'px',
            pc: '%'
        });

        tableWidthType.setSelectedEventValueType('value');
        tableWidthType.addItemSelectedEvent(function(type) {
            self._changeTableSettingValue('widthType', type);
        });

        this._settingsWidgets.table.widthType = tableWidthType;
        this._settingsWidgets.table.width     = tableWidth;

        tableWidth.create(function(tableWidthEl) {
            tableWidth.setWidth(25);
            var t = null;
            dfx.addEvent(tableWidth.domEl, 'keyup', function() {
                if (t) {
                    clearTimeout(t);
                    t = null;
                }

                t = setTimeout(function() {
                    var width = parseInt(tableWidth.getValue());
                    self._changeTableSettingValue('width', width);
                }, 500);
            });

            self._makeOptionEditable(tableWidth.domEl);
            var parent = dfx.getClass(c + '-tableWidth-wrapper', div)[0];
            parent.appendChild(tableWidthEl);
            tableWidthType.create(function(tableWidthTypeEl) {
                dfx.insertAfter(parent, tableWidthTypeEl);
            });
        });

        dfx.foreach(props, function(propid) {
            (function(propid) {
                var widgetid = c + '-' + propid;
                var widget   = self.createWidget(widgetid, 'SpinButton', 0);
                widget.setInitialValue(0);
                widget.allowEmptyValue(true);
                widget.create(function(el) {
                    self._makeOptionEditable(widget.domEl);
                    dfx.getClass(widgetid + '-wrapper', div)[0].appendChild(el);
                });

                widget.addOnChangeEvent(function(val) {
                    self._changeTableSettingValue(propid, val);
                });

                self._settingsWidgets.table[propid] = widget;
            }) (propid);
        });

        callback.call(this, div);

    },

    _makeOptionEditable: function(elem)
    {
        /*
         // Options with textbox needs to call this method so that Viper
         // will ignore keypress events. This also removed the viper caret.
         var self = this;
         dfx.addEvent(elem, 'focus', function() {
            ViperPluginManager.setActivePlugin('TableEditor', false);
         });

         dfx.addEvent(elem, 'blur', function() {
            ViperPluginManager.setActivePlugin(null);
         });
        */

    },

    _setupCellProperties: function(callback)
    {
        this._settingsWidgets.cell = {};

        var self = this;
        var c    = 'ViperTableEditor-stb';
        var div  = document.createElement('div');
        dfx.addClass(div, c + '-propertiesWrapper');
        dfx.addClass(div, c + '-cellProps');

        var content = '<div class="' + c + '-propContainer" id="' + c + '-propContainer-colWidth"><label>Column Width</label>';
        content    += '<div class="' + c + '-propWrapper ' + c + '-columnWidth-wrapper"></div>';
        content    += '<div class="' + c + '-propWrapper ' + c + '-columnWidthSel-wrapper"></div></div>';
        content    += '<div class="' + c + '-optionListWrapper"></div>';
        dfx.setHtml(div, content);

        var colWidthText = this.createWidget(c + '-colWidth-txt', 'TextField');
        colWidthText.create(function(colWidthTextEl) {
            var t = null;
            dfx.addEvent(colWidthText.domEl, 'keyup', function() {
                if (t) {
                    clearTimeout(t);
                    t = null;
                }

                t = setTimeout(function() {
                    var width = parseInt(colWidthText.getValue());
                    self._changeSettingValue('width', width);
                }, 500);
            });

            self._makeOptionEditable(colWidthText.domEl);
            colWidthText.setWidth(25);
            dfx.getClass(c + '-columnWidth-wrapper', div)[0].appendChild(colWidthTextEl);
        });

        var colWidthSel = this.createWidget(c + '-colWidth-sel', 'Select');
        colWidthSel.addItems({
            px: 'px',
            pc: '%'
        });

        colWidthSel.setSelectedEventValueType('value');
        colWidthSel.addItemSelectedEvent(function(type) {
            self._changeSettingValue('widthType', type);
        });

        this._settingsWidgets.cell.widthType = colWidthSel;
        this._settingsWidgets.cell.width     = colWidthText;

        colWidthSel.create(function(colWidthSelEl) {
            dfx.getClass(c + '-columnWidthSel-wrapper', div)[0].appendChild(colWidthSelEl);
        });

        // Cell Appearance props.
        var optsList = this.viper.ViperPluginManager.getPlugin('ViperSubToolbarPlugin').createOptionsList('Appearance');
        dfx.addClass(optsList.main, c + '-optionList');
        (dfx.getClass(c + '-optionListWrapper', div)[0]).appendChild(optsList.main);
        this._createOptionList(optsList.contentEl);

        callback.call(this, div);

    },

    _createOptionList: function(parent)
    {
        var div  = null;
        var self = this;
        var opts = {
            tableHeader: 'Table Header',
            noTextWrap: 'No Text Wrap'
        };

        // Vert Align.
        div       = document.createElement('div');
        var label = document.createElement('label');
        parent.appendChild(div);
        dfx.setHtml(label, 'Align');
        div.appendChild(label);
        dfx.addClass(div, 'ViperTableEditor-stb-optItem');
        div.id = 'ViperTableEditor-opts-vert';
        dfx.addClass(div, 'first');

        var alignType = {
            top: 'Align to top',
            middle: 'Align to middle',
            bottom: 'Align to bottom'
        };

        this._settingsWidgets.cell.valign = div;
        dfx.foreach(alignType, function(i) {
            var alignDiv = document.createElement('div');
            dfx.attr(alignDiv, 'title', alignType[i]);
            dfx.addClass(alignDiv, 'ViperTableEditor-stb-align');
            dfx.addClass(alignDiv, 'ViperTableEditor-stb-align-' + i);
            (function(el, alignType) {
                dfx.addEvent(el, 'click', function() {
                    dfx.removeClass(dfx.getClass('ViperTableEditor-stb-align', el.parentNode), 'active');
                    dfx.addClass(el, 'active');
                    self._changeSettingValue('valign', alignType);
                });
            }) (alignDiv, i);

            div.appendChild(alignDiv);
        });

        dfx.foreach(opts, function(i) {
            div       = document.createElement('div');
            var label = document.createElement('label');
            parent.appendChild(div);
            dfx.setHtml(label, opts[i]);
            div.appendChild(label);
            dfx.addClass(div, 'ViperTableEditor-stb-optItem');
            div.id = 'ViperTableEditor-opts-' + i;

            var radioBtn = self.createWidget(null, 'RadioButton', null, false);
            self._settingsWidgets.cell[i] = radioBtn;

            radioBtn.create(function(radioBtnEl) {
                dfx.attr(label, 'for', radioBtn.id);
                div.appendChild(radioBtnEl);
                radioBtn._addEvents();
            });

            (function(radioBtnWidget, type) {
                radioBtnWidget.addCheckedEvent(function(checked) {
                    self._changeSettingValue(type, checked);
                });
            }) (radioBtn, i);
        });

        if (div) {
            dfx.addClass(div, 'last');
        }

    },

    _showProperties: function(type)
    {
        if (!this._subToolbar) {
            return;
        }

        var c = 'ViperTableEditor-stb';
        dfx.removeClass(dfx.getClass(c + '-propertiesWrapper', this._subToolbar), 'show');
        dfx.addClass(dfx.getClass(c + '-' + type + 'Props', this._subToolbar)[0], 'show');

        this._currentTablePropView = type;

        this.viper.ViperPluginManager.getPlugin('ViperSubToolbarPlugin').showToolbar('TableEditor');

    },

    _changeTableSettingValue: function(type, value)
    {
        if (!this.activeCell || !type) {
            return;
        }

        var table = this.getCellTable(this.activeCell);
        if (!table) {
            return;
        }

        var changed = false;
        switch (type) {
            case 'tableBorder':
                if (parseInt(dfx.attr(table, 'border')) !== parseInt(value)) {
                    dfx.attr(table, 'border', value);
                    changed = true;
                }
            break;

            case 'width':
                if (!value) {
                    value = '';
                } else {
                    var widthType = this._settingsWidgets.table.widthType.getValue();
                    if (widthType === 'pc') {
                        value += '%';
                    } else {
                        value += 'px';
                    }
                }

                if (dfx.setStyle(table, 'width') !== value) {
                    dfx.setStyle(table, 'width', value);
                    changed = true;
                }
            break;

            case 'widthType':
                var width = parseInt(dfx.getStyle(table, 'width'));
                if (width) {
                    if (value === 'pc') {
                        value = '%';
                    }

                    if (dfx.setStyle(table, 'width') !== (width + value)) {
                        dfx.setStyle(table, 'width', width + value);
                        changed = true;
                    }
                }
            break;

            default:
                value = parseInt(value);
                if (isNaN(value) === true) {
                    value = '';
                }

                var currVal = parseInt(dfx.attr(table, type));
                if (isNaN(currVal) === true) {
                    currVal = '';
                }

                if (currVal !== value) {
                    dfx.attr(table, type, value);
                    changed = true;
                }
            break;
        }//end switch

        if (changed === true) {
            // Update button locations.
            this._updatecellButtonPositions(this.activeCell);
            this._nodesUpdated(true);
        }

    },

    _changeSettingValue: function(type, value)
    {
        if (!this.activeCell || !type) {
            return;
        }

        var changed = false;
        if (type === 'tableHeader') {
            var toType = 'th';
            if (value !== true) {
                toType = 'td';
            }

            if (dfx.isTag(this.activeCell, toType) === true) {
                // Nothing to do..
                return;
            }

            var newEl = document.createElement(toType);
            var clone = this.activeCell.cloneNode(true);
            while (clone.firstChild) {
                newEl.appendChild(clone.firstChild);
            }

            // Copy width and white-space styles to the new element.
            var whiteSpace = dfx.getStyle(clone, 'white-space');
            if (whiteSpace === 'nowrap') {
                dfx.setStyle(newEl, 'white-space', 'nowrap');
            }

            // Copy valign.
            var valign = dfx.getStyle(clone, 'vertical-align');
            if (valign) {
                dfx.setStyle(newEl, 'vertical-align', valign);
            }

            var width = dfx.getStyle(clone, 'width');
            if (width) {
                dfx.setStyle(newEl, 'width', width);
            }

            dfx.insertBefore(this.activeCell, newEl);
            dfx.remove(this.activeCell);
            this.setActiveCell(newEl);
            changed = true;
            this.moveCaretToCell(this.activeCell);
        } else if (type === 'noTextWrap') {
            var style = 'normal';
            if (value === true) {
                style = 'nowrap';
            }

            if (dfx.getStyle(this.activeCell, 'white-space') !== style) {
                dfx.setStyle(this.activeCell, 'white-space', style);
                changed = true;
                this.moveCaretToCell(this.activeCell);
            }
        } else if (type === 'width') {
            if (!value) {
                value = '';
            } else {
                var widthType = this._settingsWidgets.cell.widthType.getValue();
                if (widthType === 'pc') {
                    value += '%';
                } else {
                    value += 'px';
                }
            }

            if (dfx.getStyle(this.activeCell, 'width') !== value) {
                dfx.setStyle(this.activeCell, 'width', value);
                changed = true;
            }
        } else if (type === 'widthType') {
            var width = parseInt(dfx.getStyle(this.activeCell, 'width'));
            if (width) {
                if (value === 'pc') {
                    value = '%';
                }

                if (dfx.getStyle(this.activeCell, 'width') !== (width + value)) {
                    dfx.setStyle(this.activeCell, 'width', width + value);
                    changed = true;
                }
            }
        } else if (type === 'valign') {
            if (dfx.getStyle(this.activeCell, 'vertical-align') !== value) {
                dfx.setStyle(this.activeCell, 'vertical-align', value);
                changed = true;
            }
        }//end if

        if (changed === true) {
            // Update button locations.
            this._updatecellButtonPositions(this.activeCell);
            this._nodesUpdated(true);
        }

    },

    // Updates the setting values on sub toolbar when a table cell is picked.
    updateSettings: function(cell)
    {
        if (!cell) {
            cell = this.activeCell;
        }

        if (!cell) {
            return;
        }

        // Turn on/off cell header setting.
        if (this._settingsWidgets.cell && this._settingsWidgets.cell.tableHeader) {
            if (dfx.isTag(cell, 'th') === true) {
                this._settingsWidgets.cell.tableHeader.check();
            } else {
                this._settingsWidgets.cell.tableHeader.uncheck();
            }
        }

        // Turn on/off cell no-text-wrap setting.
        if (this._settingsWidgets.cell && this._settingsWidgets.cell.noTextWrap) {
            if (dfx.getStyle(cell, 'white-space') === 'nowrap') {
                this._settingsWidgets.cell.noTextWrap.check();
            } else {
                this._settingsWidgets.cell.noTextWrap.uncheck();
            }
        }

        if (this._settingsWidgets.cell && this._settingsWidgets.cell.valign) {
            var val  = dfx.getStyle(cell, 'vertical-align');
            var btns = dfx.getClass('ViperTableEditor-stb-align', this._settingsWidgets.cell.valign);
            dfx.removeClass(btns, 'active');

            if (val) {
                dfx.addClass(dfx.getClass('ViperTableEditor-stb-align-' + val, this._settingsWidgets.cell.valign), 'active');
            }
        }

        // Width and withd type.
        if (this._settingsWidgets.cell && this._settingsWidgets.cell.width) {
            // Note: Not using dfx.getStyle since we need the actual CSS style
            // and not the element width even if CSS width is not set.
            var widthStyle = cell.style.width;
            var width      = parseInt(widthStyle);
            this._settingsWidgets.cell.width.setValue(width);

            // Update the width type.
            var widthType = 'px';
            if (this._settingsWidgets.cell.widthType) {
                if (widthStyle.indexOf('%') > 0) {
                    widthType = 'pc';
                }
            }

            this._settingsWidgets.cell.widthType.setValue(widthType, true);
        }//end if

        // Table properties.
        var table = this.getCellTable(cell);
        if (this._settingsWidgets.table && table) {
            if (this._settingsWidgets.table.tableBorder) {
                var val = NaN;
                if (dfx.attr(table, 'border') !== 'undefined') {
                    val = parseInt(dfx.attr(table, 'border'));
                }

                this._settingsWidgets.table.tableBorder.setValue(val);
            }

            if (this._settingsWidgets.table.cellPadding) {
                var val = NaN;
                if (dfx.attr(table, 'cellpadding') !== 'undefined') {
                    val = parseInt(dfx.attr(table, 'cellpadding'));
                }

                this._settingsWidgets.table.cellPadding.setValue(val);
            }

            if (this._settingsWidgets.table.cellSpacing) {
                var val = NaN;
                if (dfx.attr(table, 'cellspacing') !== 'undefined') {
                    val = parseInt(dfx.attr(table, 'cellspacing'));
                }

                this._settingsWidgets.table.cellSpacing.setValue(val);
            }

            if (this._settingsWidgets.table.width) {
                // Note: Not using dfx.getStyle since we need the actual CSS style
                // and not the element width even if CSS width is not set.
                var widthStyle = table.style.width;
                var width      = parseInt(widthStyle);
                this._settingsWidgets.table.width.setValue(width);

                // Update the width type.
                var widthType = 'px';
                if (this._settingsWidgets.table.widthType) {
                    if (widthStyle.indexOf('%') > 0) {
                        widthType = 'pc';
                    }
                }

                this._settingsWidgets.table.widthType.setValue(widthType, true);
            }//end if
        }//end if

    }

};
