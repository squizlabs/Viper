function ViperTableEditorPlugin(viper)
{
    dfx.inherits('ViperTableEditorPlugin', 'ViperInlineToolbarPlugin');
    ViperInlineToolbarPlugin.call(this, viper);

    this.viper             = viper;
    this._tools            = viper.ViperTools;
    this.toolbarPlugin     = null;
    this.activeCell        = null;
    this._highlightElement = null;

    this._buttonClicked = false;
    this._tableRawCells = null;
    this._currentType   = null;
    this._margin        = 15;
    this._headerOptions = [null, [1, 0, 0, 1, 0, 0, 1, 0, 0], [1, 1, 1], [1, 1, 1, 1, 0, 0, 1, 0, 0]];

    this._targetToolbarButton = false;

}

ViperTableEditorPlugin.prototype = {

    init: function()
    {
        var self = this;
        var clickedInToolbar = false;

        this.viper.registerCallback('Viper:editableElementChanged', 'ViperTableEditorPlugin', function() {
            self._initTable();

            if (self.viper.isBrowser('firefox') === true) {
                // Disable Firefox table editing.
                document.execCommand("enableInlineTableEditing", false, false);
                document.execCommand("enableObjectResizing", false, false);
            }

            var tables = dfx.getTag('table', self.viper.getViperElement());
            for (var i = 0; i < tables.length; i++) {
                self.setTableHeaders(tables[i]);
            }
        });

        // Hide the toolbar when user clicks anywhere.
        this.viper.registerCallback(['Viper:mouseDown', 'ViperHistoryManager:undo'], 'ViperTableEditorPlugin', function(data) {
            clickedInToolbar = false;
            if (data && data.target) {
                var target = dfx.getMouseEventTarget(data);
                if (target === self._toolbar || dfx.isChildOf(target, self._toolbar) === true) {
                    clickedInToolbar = true;
                    if (dfx.isTag(target, 'input') === true
                        || dfx.isTag(target, 'textarea') === true
                    ) {
                        // Allow event to bubble so the input element can get focus etc.
                        return true;
                    }

                    return false;
                } else if (dfx.isTag(target, 'caption') === true && dfx.getNodeTextContent(target) === '') {
                    target.innerHTML = '&nbsp;';
                }
            }

            self.hideToolbar();
        });

        dfx.addEvent(window, 'resize', function() {
            var cell = self.getActiveCell();
            if (cell) {
                self._updatePosition(cell);
                self.highlightActiveCell(self._currentType);
            }
        });

        this.viper.registerCallback('Viper:keyDown', 'ViperTableEditorPlugin', function(e) {
            if (e.which === 9) {
                // Handle tab key.
                self.removeHighlights();

                if (e.shiftKey === true && self.activeCell) {
                    self.moveCaretToPreviousCell() === false
                } else {
                    if (self.activeCell && self.moveCaretToNextCell() === false) {
                        // Create a new row.
                        self.insertRowAfter(self.activeCell);
                        self.moveCaretToNextCell();
                    }
                }

                dfx.preventDefault(e);
                return false;
            } else if (e.which === 39) {
                // Right arrow.
                // If the range is at the end of a table (last cell) then move the
                // caret outside even if there is no next sibling.
                var range = self.viper.getCurrentRange();
                if (range.collapsed === true) {
                    var startNode = range.getStartNode();
                    if (startNode && startNode.nodeType === dfx.TEXT_NODE && range.endOffset === startNode.data.length) {
                        var cell     = self.getActiveCell();
                        if (startNode === range._getLastSelectableChild(cell)) {
                            if (!self.getNextRow(cell.parentNode)) {
                                // End of table.
                                var table = self.getCellTable(cell);
                                if (!table.nextSibling || table.nextSibling.data && table.nextSibling.data.match(/^\n\s*$/)) {
                                    var newNode = document.createElement('p');
                                    dfx.setHtml(newNode, '&nbsp;');
                                    dfx.insertAfter(table, newNode);
                                    range.setStart(newNode.firstChild, 0);
                                    range.collapse(true);
                                    ViperSelection.addRange(range);
                                }
                            }
                        }
                    }
                }
            }//end if
        });

        this.toolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (this.toolbarPlugin) {
            var insertTable = true;

            this.viper.registerCallback('ViperToolbarPlugin:positionUpdated', 'ViperTableEditorPlugin', function(data) {
                if (self._targetToolbarButton === true) {
                    var activeCell = self.getActiveCell();
                    if (activeCell) {
                        self.showCellToolsIcon(activeCell, true);
                    }
                }
            });

            this.viper.registerCallback('ViperToolbarPlugin:enabled', 'ViperTableEditorPlugin', function(data) {
                self.viper.ViperTools.enableButton('insertTable');
            });

            var button = this.viper.ViperTools.createButton('insertTable', '', 'Insert Table', 'table', function() {
                var range = self.viper.getViperRange();
                var node  = range.getStartNode();
                if (!node) {
                    node = range.getEndNode();
                    if (!node) {
                        return;
                    }
                }

                insertTable = true;

                // Do not allow table insertion inside another table.
                var parents = dfx.getParents(node, 'table', self.viper.getViperElement());
                if (parents.length > 0) {
                    insertTable = false;
                    // Show cell tools.
                    var cell = self._getCellElement(node);
                    if (cell) {
                        self.showCellToolsIcon(cell, true);
                    }
                } else {
                    self.toolbarPlugin.toggleBubble('VTEP-bubble');
                }
            }, true);
            this.toolbarPlugin.addButton(button);

            // Create the toolbar bubble.
            this._createToolbarEditorBubble();
        }

        if (this._isiPad() === false) {
            var showToolbar = false;
            this.viper.registerCallback('Viper:mouseUp', 'ViperTableEditorPlugin', function(e) {
                var range = self.viper.getViperRange();
                var target = dfx.getMouseEventTarget(e);

                if (!target) {
                    return;
                }

                if (target === self._toolbar || dfx.isChildOf(target, self._toolbar) === true) {
                    self._buttonClicked = false;
                    return false;
                }

                if (range.collapsed === false) {
                    self.removeHighlights();
                    self.hideCellToolsIcon();
                    return true;
                }

                if (self.viper.isOutOfBounds(target) === true) {
                    return;
                }

                var cell = self._getCellElement(target);
                if (cell) {
                    self._initTable(self.getCellTable(cell));

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
                var node = range.getStartNode();
                if (!node) {
                    node = range.getEndNode();
                    if (!node) {
                        return;
                    }
                }

                if (self.viper.isOutOfBounds(node) === true) {
                    return;
                }

                if (self.toolbarPlugin.isDisabled() === true) {
                    self._tools.setButtonInactive('insertTable');
                } else {
                    // Do not allow table insertion inside another table.
                    var parents = dfx.getParents(node, 'table', self.viper.getViperElement());
                    if (parents.length > 0 && self._tools) {
                        // Set the table icon as active.
                        if (self.toolbarPlugin.isDisabled() === false) {
                            self._tools.setButtonActive('insertTable');
                        }
                    } else {
                        if (dfx.getParents(node, 'li', self.viper.getViperElement()).length > 0) {
                            self._tools.disableButton('insertTable');
                        } else {
                            self._tools.setButtonInactive('insertTable');
                        }
                    }
                }

                if (range.collapsed === false) {
                    return;
                }

                if (clickedInToolbar === true || self.viper.rangeInViperBounds(range) === false) {
                    clickedInToolbar = false;
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
                var cell      = self._getCellElement(startNode);
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
        }//end if

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

    _initTable: function(table)
    {
        var cells = [];
        if (!table) {
            cells = dfx.getTag('td, th', this.viper.getViperElement());
        } else {
            cells = dfx.getTag('td,th', table);
        }

        var c = cells.length;
        for (var i = 0; i < c; i++) {
            var html = dfx.getHtml(cells[i]);
            if (html === '') {
                dfx.setHtml(cells[i], '&nbsp;');
            }
        }

    },


    /**
     * Shows the cell tools icon for the given cell element.
     *
     * When the icon is hovered, it will be converted to list of buttons where user
     * can pick between table/row/column/cell properties.
     *
     * @param {DOMNode} cell The table cell (TD/TH) element to point to and edit.
     */
    showCellToolsIcon: function(cell, inTopBar)
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

        // Table, row, col and cell buttons. Initially only the table icon is visible
        // Whent he mouse is moved over the table icon, rest of the buttons become
        // visible where user can pick the tools they want to use.
        var buttonGroup = this.viper.ViperTools.createButtonGroup('VTEP:cellTools:buttons', 'ViperITP-tools');
        var tableBtn    = this._tools.createButton('VTEP:cellTools:table', '', 'Show Table tools', 'table', function() {
            showTools('table');
        });
        var rowBtn = this._tools.createButton('VTEP:cellTools:row', '', 'Show Row tools', 'tableRow viper-hidden', function() {
            showTools('row');
        });
        var colBtn = this._tools.createButton('VTEP:cellTools:col', '', 'Show Column tools', 'tableCol viper-hidden', function() {
            showTools('col');
        });
        var cellBtn = this._tools.createButton('VTEP:cellTools:cell', '', 'Show Cell tools', 'tableCell viper-hidden', function() {
            showTools('cell');
        });
        this._tools.addButtonToGroup('VTEP:cellTools:table', 'VTEP:cellTools:buttons');
        this._tools.addButtonToGroup('VTEP:cellTools:row', 'VTEP:cellTools:buttons');
        this._tools.addButtonToGroup('VTEP:cellTools:col', 'VTEP:cellTools:buttons');
        this._tools.addButtonToGroup('VTEP:cellTools:cell', 'VTEP:cellTools:buttons');

        var btns = [rowBtn, colBtn, cellBtn];

        tools.appendChild(buttonGroup);

        var cellCoords = null;
        var toolsWidth = 42;

        if (inTopBar !== true) {
            this._targetToolbarButton = false;
            cellCoords = dfx.getBoundingRectangle(cell);
        } else {
            var scrollCoords = dfx.getScrollCoords();

            this._targetToolbarButton = true;
            dfx.removeClass(btns, 'viper-hidden');
            dfx.setStyle(tools, 'margin-left', '-45px');
            cellCoords     = dfx.getBoundingRectangle(this._tools.getItem('insertTable').element);

            if (dfx.getStyle(this._tools.getItem('insertTable').element.parentNode, 'position') === 'fixed') {
                cellCoords.y2 += (5 - scrollCoords.y);
                dfx.setStyle(tools, 'position', 'fixed');
            } else {
                dfx.setStyle(tools, 'position', 'absolute');
            }

            dfx.addClass(tools, 'topBar');
        }

        dfx.setStyle(tools, 'top', cellCoords.y2 + 5 + 'px');
        dfx.setStyle(tools, 'left', Math.ceil(cellCoords.x1 + ((cellCoords.x2 - cellCoords.x1) / 2) - (toolsWidth / 2)) + 1 + 'px');

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

            if (this._targetToolbarButton !== true) {
                // On hover show the list of available table properties buttons.
                dfx.hover(tools, function() {
                    self.setActiveCell(cell);
                    self.highlightActiveCell();
                    dfx.removeClass(btns, 'viper-hidden');
                    dfx.setStyle(tools, 'margin-left', '-45px');
                }, function() {
                    self.removeHighlights();
                    dfx.addClass(btns, 'viper-hidden');
                    dfx.setStyle(tools, 'margin-left', '0');
                });
            }
        } else {
            // On iPad just show the tools.
            dfx.addEvent(tools, 'click', function() {
                showTools('cell');
            });
        }//end if

        this.viper.addElement(tools);

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
     * Upudates the toolbar.
     *
     * This method is usually called by the Viper:selectionChanged event.
     *
     * @param {DOMRange} range The DOMRange object.
     */
    updateToolbar: function(cell, type, activeSubSection)
    {
        this._activeSection = null;
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
        this._updateSubSectionArrowPos();

    },

    tableUpdated: function()
    {
        this._tableRawCells = null;
        var table = this.getCellTable(this.activeCell);

        this.setTableHeaders(table);
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
     * Updates the position of the inline toolbar.
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

        var left = 0;
        var top  = 0;
        if (this._targetToolbarButton !== true) {
            if (verticalOnly !== true) {
                left = ((rangeCoords.left + ((rangeCoords.right - rangeCoords.left) / 2) + scrollCoords.x) - (toolbarWidth / 2));
                dfx.setStyle(this._toolbar, 'left', left + 'px');
            }

            top = (rangeCoords.bottom + this._margin + scrollCoords.y);
            dfx.setStyle(this._toolbar, 'position', 'absolute');
        } else {
            var cellCoords = dfx.getBoundingRectangle(this._tools.getItem('insertTable').element);
            top  = cellCoords.y2 + 15 - scrollCoords.y;
            left = ((cellCoords.x1 + ((cellCoords.x2 - cellCoords.x1) / 2) + scrollCoords.x) - (toolbarWidth / 2));

            dfx.setStyle(this._toolbar, 'left', left + 'px');
            dfx.setStyle(this._toolbar, 'position', 'fixed');
        }

        dfx.setStyle(this._toolbar, 'top', top + 'px');
        dfx.addClass(this._toolbar, 'visible');

    },

    _updateLineage: function(type)
    {
        var self = this;

        dfx.empty(this._lineage);

        dfx.removeClass(dfx.getClass('selected', this._lineage), 'selected');

        // Table.
        var table = document.createElement('li');
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
        var row = document.createElement('li');
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
        var col = document.createElement('li');
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
        var cell = document.createElement('li');
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
                var table = this.getCellTable(activeCell);
                var tfoot = dfx.getTag('tfoot', table);
                coords    = dfx.getBoundingRectangle(table);

                if (this.viper.isBrowser('firefox') === true) {
                    // Caption height fix..
                    var caption = dfx.getTag('caption', table);
                    if (caption.length > 0) {
                        caption    = caption[0];
                        coords.y2 += dfx.getElementHeight(caption);
                    }
                }
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
                var table   = this.getCellTable(activeCell);
                var caption = dfx.getTag('caption', table);
                coords      = dfx.getBoundingRectangle(table);

                if (caption.length > 0) {
                    var captionHeight = dfx.getElementHeight(caption[0]);
                    coords.y1        += captionHeight;

                    if (this.viper.isBrowser('firefox') === true) {
                        // Firefox caption height fix.
                        coords.y2 += captionHeight;
                    }
                }

                // Get the width and height of the cell.
                var cellRect = dfx.getBoundingRectangle(activeCell);

                // Modify the table coords so that the width and height only for this col.
                coords.x1 = cellRect.x1;
                coords.x2 = cellRect.x2;
            break;
        }//end switch

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

        this.viper.addElement(hElem);
        this._highlightElement = hElem;

        dfx.addEvent(hElem, 'mousedown', function() {
            dfx.remove(hElem);
        });

    },

    _updateInnerContainer: function(cell, type, activeSubSection)
    {
        dfx.empty(this._toolsContainer);
        dfx.setHtml(this._subSectionContainer, '<span class="subSectionArrow"></span>');

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

            case 'table':
                this._createTableProperties(cell);
            break;
        }

        var callbackData = {
            toolbar: this,
            cell: cell,
            type: type
        };
        this.viper.fireCallbacks('ViperTableEditorPlugin:updateToolbar', callbackData);

    },

    _createCellProperties: function(cell, activeSubSection)
    {
        var self               = this;
        var settingsContent    = document.createElement('div');
        var headingChanged     = false;
        var settingsSubSection = this.makeSubSection('VTEP:cellProps:settingsSubSection', settingsContent);
        var settingsButton     = this._tools.createButton('VTEP:cellProps:settings', '', 'Toggle Settings', 'tableSettings');
        this.addButton(settingsButton);
        this.setSubSectionButton('VTEP:cellProps:settings', 'VTEP:cellProps:settingsSubSection');
        this.toggleSubSection('VTEP:cellProps:settingsSubSection');
        this.setSubSectionAction('VTEP:cellProps:settingsSubSection', function() {
            if (headingChanged === true) {
                var newCell = null;
                if (self._tools.getItem('VTEP:cellProps:heading').getValue() === true) {
                    newCell = self.convertToHeader(cell, 'cell');
                } else {
                    newCell = self.convertToCell(cell, 'cell');
                }

                self.updateToolbar(newCell, 'cell');
            }
        }, ['VTEP:cellProps:heading']);
        var heading = this._tools.createCheckbox('VTEP:cellProps:heading', 'Heading', (dfx.isTag(cell, 'th') === true), function() {
            headingChanged = true;
        });
        settingsContent.appendChild(heading);

        // Split buttons.
        this._tools.createButton('VTEP:cellProps:splitVert', '', 'Split Vertically', 'splitVert', function() {
            self._buttonClicked = true;
            self.splitVertical(cell);
            self.updateToolbar(cell, 'cell', 'merge');
        }, (this.getColspan(cell) <= 1));

        this._tools.createButton('VTEP:cellProps:splitHoriz', '', 'Split Horizontally', 'splitHoriz', function() {
            self._buttonClicked = true;
            self.splitHorizontal(cell);
            self.updateToolbar(cell, 'cell', 'merge');
        }, (this.getRowspan(cell) <= 1));

        var splitBtnGroup = this._tools.createButtonGroup('VTEP:cellProps:splitButtons');
        this._tools.addButtonToGroup('VTEP:cellProps:splitVert', 'VTEP:cellProps:splitButtons');
        this._tools.addButtonToGroup('VTEP:cellProps:splitHoriz', 'VTEP:cellProps:splitButtons');

        // Merge buttons.
        var mergeUp = this._tools.createButton('VTEP:cellProps:mergeUp', '', 'Merge Up', 'mergeUp', function() {
            self._buttonClicked = true;
            self.updateToolbar(self.mergeUp(cell), 'cell', 'merge');
        }, (this.canMergeUp(cell) === false));

        var mergeDown = this._tools.createButton('VTEP:cellProps:mergeDown', '', 'Merge Down', 'mergeDown', function() {
            self._buttonClicked = true;
            self.updateToolbar(self.mergeDown(cell), 'cell', 'merge');
        }, (this.canMergeDown(cell) === false));

        var mergeLeft = this._tools.createButton('VTEP:cellProps:mergeLeft', '', 'Merge Left', 'mergeLeft', function() {
            self._buttonClicked = true;
            self.updateToolbar(self.mergeLeft(cell), 'cell', 'merge');
        }, (this.canMergeLeft(cell) === false));

        var mergeRight = this._tools.createButton('VTEP:cellProps:mergeRight', '', 'Merge Right', 'mergeRight', function() {
            self._buttonClicked = true;
            self.updateToolbar(self.mergeRight(cell), 'cell', 'merge');
        }, (this.canMergeRight(cell) === false));

        var mergeBtnGroup = this._tools.createButtonGroup('VTEP:cellProps:mergeButtons');
        this._tools.addButtonToGroup('VTEP:cellProps:mergeUp', 'VTEP:cellProps:mergeButtons');
        this._tools.addButtonToGroup('VTEP:cellProps:mergeDown', 'VTEP:cellProps:mergeButtons');
        this._tools.addButtonToGroup('VTEP:cellProps:mergeLeft', 'VTEP:cellProps:mergeButtons');
        this._tools.addButtonToGroup('VTEP:cellProps:mergeRight', 'VTEP:cellProps:mergeButtons');

        var mergeSubWrapper = document.createElement('div');
        mergeSubWrapper.appendChild(splitBtnGroup);
        mergeSubWrapper.appendChild(mergeBtnGroup);

        // Create the merge/split sub section toggle button.
        var mergeSubSection = this.makeSubSection('VTEP:cellProps:mergeSplitSubSection', mergeSubWrapper);
        var mergeSplitToggle = this._tools.createButton('VTEP:cellProps:mergeSplitSubSectionToggle', '', 'Toggle Merge/Split Options', 'splitMerge');
        this.addButton(mergeSplitToggle);
        this.setSubSectionButton('VTEP:cellProps:mergeSplitSubSectionToggle', 'VTEP:cellProps:mergeSplitSubSection');

        if (activeSubSection === 'merge') {
            this.toggleSubSection('VTEP:cellProps:mergeSplitSubSection');
        }

    },

    _createColProperties: function(cell)
    {
        var self = this;

        var settingsContent = document.createElement('div');

        // Create the settings sub section.
        var headingChanged     = false;
        var settingsSubSection = this.makeSubSection('VTEP:colProps:settingsSubSection', settingsContent);
        var settingsButton     = this._tools.createButton('VTEP:colProps:settings', '', 'Toggle Settings', 'tableSettings');
        this.addButton(settingsButton);
        this.setSubSectionButton('VTEP:colProps:settings', 'VTEP:colProps:settingsSubSection');
        this.toggleSubSection('VTEP:colProps:settingsSubSection');
        this.setSubSectionAction('VTEP:colProps:settingsSubSection', function() {
            // Set column width.
            var width = self._tools.getItem('VTEP:colProps:width').getValue();
            self.setColumnWidth(cell, width);

            if (headingChanged === true) {
                var headingChecked = self._tools.getItem('VTEP:colProps:heading').getValue();

                // Switch between header and normal cell.
                var newCell = null;
                if (headingChecked !== true) {
                    newCell = self.convertToCell(cell, 'col');
                } else {
                    newCell = self.convertToHeader(cell, 'col');
                }

                self.updateToolbar(newCell, 'col');
            } else {
                self.updateToolbar(self.getActiveCell(), 'col');
            }
        }, ['VTEP:colProps:width', 'VTEP:colProps:heading']);

        // Width.
        var colWidth = this.getColumnWidth(cell);
        var width    = this._tools.createTextbox('VTEP:colProps:width', 'Width', colWidth);
        settingsContent.appendChild(width);

        // Heading.
        var wholeColHeading = true;
        var cells   = this._getCellsExpanded();
        var cellPos = this.getCellPosition(cell);

        for (var i = 0; i < cells.length; i++) {
            var colCell    = cells[i][cellPos.col];
            var colCellPos = this.getCellPosition(colCell);
            if (colCellPos.col === cellPos.col) {
                if (dfx.isTag(colCell, 'td') === true) {
                    wholeColHeading = false;
                    break;
                }
            }
        }

        var heading = this._tools.createCheckbox('VTEP:colProps:heading', 'Heading', wholeColHeading, function() {
            headingChanged = true;
        });
        settingsContent.appendChild(heading);

        this._tools.createButton('VTEP:colProps:insBefore', '', 'Insert Column Before', 'addLeft', function() {
            self._buttonClicked = true;
            self.insertColBefore(cell);
            self.updateToolbar(cell, 'col');
        });
        this._tools.createButton('VTEP:colProps:insAfter', '', 'Insert Column After', 'addRight', function() {
            self._buttonClicked = true;
            self.insertColAfter(cell);
            self.updateToolbar(cell, 'col');
        });

        var btnGroup = this._tools.createButtonGroup('VTEP:insColButtons');
        this._tools.addButtonToGroup('VTEP:colProps:insBefore', 'VTEP:insColButtons');
        this._tools.addButtonToGroup('VTEP:colProps:insAfter', 'VTEP:insColButtons');
        this.addButton(btnGroup);

        this._tools.createButton('VTEP:colProps:moveLeft', '', 'Move Left', 'mergeLeft', function() {
            self._buttonClicked = true;
            self.updateToolbar(self.moveColLeft(cell), 'col');
        }, (this.canMoveColLeft(cell) === false));
        this._tools.createButton('VTEP:colProps:moveRight', '', 'Move Right', 'mergeRight', function() {
            self._buttonClicked = true;
            self.updateToolbar(self.moveColRight(cell), 'col');
        }, (this.canMoveColRight(cell) === false));

        btnGroup = this._tools.createButtonGroup('VTEP:moveColButtons');
        this._tools.addButtonToGroup('VTEP:colProps:moveLeft', 'VTEP:moveColButtons');
        this._tools.addButtonToGroup('VTEP:colProps:moveRight', 'VTEP:moveColButtons');
        this.addButton(btnGroup);

        var removeCol = this._tools.createButton('VTEP:colProps:remove', '', 'Remove Column', 'delete', function() {
            var table = self.getCellTable(cell);
            self._buttonClicked = true;
            self.removeCol(cell);
            self.hideToolbar();
            self.removeHighlights();

            self._setCaretToStart(table);
        });
        this.addButton(removeCol);

        dfx.hover(removeCol, function() {
            dfx.addClass(self._highlightElement, 'delete');
        }, function() {
            dfx.removeClass(self._highlightElement, 'delete');
        });

    },

    _createRowProperties: function(cell)
    {
        var self               = this;
        var settingsContent    = document.createElement('div');
        var headingChanged     = false;
        var settingsSubSection = this.makeSubSection('VTEP:rowProps:settingsSubSection', settingsContent);
        var settingsButton     = this._tools.createButton('VTEP:rowProps:settings', '', 'Toggle Settings', 'tableSettings');
        this.addButton(settingsButton);
        this.setSubSectionButton('VTEP:rowProps:settings', 'VTEP:rowProps:settingsSubSection');
        this.toggleSubSection('VTEP:rowProps:settingsSubSection');
        this.setSubSectionAction('VTEP:rowProps:settingsSubSection', function() {
            if (headingChanged === true) {
                var newCell = null;
                if (self._tools.getItem('VTEP:rowProps:heading').getValue() === true) {
                    newCell = self.convertToHeader(cell, 'row');
                } else {
                    newCell = self.convertToCell(cell, 'row');
                }

                self.updateToolbar(newCell, 'row');
            }
        }, ['VTEP:rowProps:heading']);

        var wholeRowIsHeading = (dfx.getTag('td', cell.parentNode).length === 0);
        var heading = this._tools.createCheckbox('VTEP:rowProps:heading', 'Heading', wholeRowIsHeading, function() {
            headingChanged = true;
        });
        settingsContent.appendChild(heading);

        this._tools.createButton('VTEP:rowProps:insBefore', '', 'Insert Row Before', 'addAbove', function() {
            self._buttonClicked = true;
            self.insertRowBefore(cell);
            self.updateToolbar(cell, 'row');
        });
        this._tools.createButton('VTEP:rowProps:insAfter', '', 'Insert Row After', 'addBelow', function() {
            self.insertRowAfter(cell);
            self.updateToolbar(cell, 'row');
        });
        var btnGroup = this._tools.createButtonGroup('VTEP:insRowButtons');
        this._tools.addButtonToGroup('VTEP:rowProps:insBefore', 'VTEP:insRowButtons');
        this._tools.addButtonToGroup('VTEP:rowProps:insAfter', 'VTEP:insRowButtons');
        this.addButton(btnGroup);

        this._tools.createButton('VTEP:rowProps:moveUp', '', 'Move Up', 'mergeUp', function() {
            self._buttonClicked = true;
            self.updateToolbar(self.moveRowUp(cell), 'row');
        }, (this.canMoveRowUp(cell) === false));
        this._tools.createButton('VTEP:rowProps:moveDown', '', 'Move Down', 'mergeDown', function() {
            self._buttonClicked = true;
            self.updateToolbar(self.moveRowDown(cell), 'row');
        }, (this.canMoveRowDown(cell) === false));
        btnGroup = this._tools.createButtonGroup('VTEP:moveRowButtons');
        this._tools.addButtonToGroup('VTEP:rowProps:moveUp', 'VTEP:moveRowButtons');
        this._tools.addButtonToGroup('VTEP:rowProps:moveDown', 'VTEP:moveRowButtons');
        this.addButton(btnGroup);

        var removeRow = this._tools.createButton('VTEP:rowProps:remove', '', 'Remove Row', 'delete', function() {
            var table = self.getCellTable(cell);
            self._buttonClicked = true;
            self.removeRow(cell);
            self.hideToolbar();
            self.removeHighlights();

            self._setCaretToStart(table);
        });
        this.addButton(removeRow);

        dfx.hover(removeRow, function() {
            dfx.addClass(self._highlightElement, 'delete');
        }, function() {
            dfx.removeClass(self._highlightElement, 'delete');
        });

    },

    _createTableProperties: function(cell)
    {
        var self   = this;
        var table  = this.getCellTable(cell);

        var settingsContent = document.createElement('div');

        // Create the settings sub section.
        var settingsSubSection = this.makeSubSection('VTEP:tableProps:settingsSubSection', settingsContent);
        var settingsButton     = this._tools.createButton('VTEP:tableProps:settings', '', 'Toggle Settings', 'tableSettings');
        this.addButton(settingsButton);
        this.setSubSectionButton('VTEP:tableProps:settings', 'VTEP:tableProps:settingsSubSection');
        this.toggleSubSection('VTEP:tableProps:settingsSubSection');
        this.setSubSectionAction('VTEP:tableProps:settingsSubSection', function() {
            self.setTableWidth(table, self._tools.getItem('VTEP:tableProps:width').getValue());
            self.viper.setAttribute(table, 'summary', self._tools.getItem('VTEP:tableProps:summary').getValue());

            var captionCheckbox = self._tools.getItem('VTEP:tableProps:caption').getValue();
            if (captionCheckbox === true) {
                self.createCaption(table);
            } else {
                self.removeCaption(table);
            }

            self.updateToolbar(self.getActiveCell(), 'table');
        }, ['VTEP:tableProps:width', 'VTEP:tableProps:summary', 'VTEP:tableProps:caption']);

        // Width.
        var tableWidth = this.getTableWidth(this.getCellTable(cell));
        var width      = this._tools.createTextbox('VTEP:tableProps:width', 'Width', tableWidth, null, false, false, '', null, '4.5em');
        settingsContent.appendChild(width);

        // Width.
        var summary     = table.getAttribute('summary') || '';
        var tableSummary = this._tools.createTextarea('VTEP:tableProps:summary', 'Summary', summary, false, '', null, '4.5em');
        settingsContent.appendChild(tableSummary);

        // Caption.
        var caption = this._tools.createCheckbox('VTEP:tableProps:caption', 'Use Caption', (dfx.getTag('caption', table).length > 0));
        settingsContent.appendChild(caption);

        var remove = this._tools.createButton('VTEP:tableProps:remove', '', 'Remove Table', 'delete', function() {
            var table = self.getCellTable(cell);
            self._buttonClicked = true;
            self.removeTable(table);
            self.hideToolbar();
            self.removeHighlights();
        });
        this.addButton(remove);

        dfx.hover(remove, function() {
            dfx.addClass(self._highlightElement, 'delete');
        }, function() {
            dfx.removeClass(self._highlightElement, 'delete');
        });

    },

    setActiveCell: function(cell)
    {
        this.activeCell = cell;

    },

    getActiveCell: function(cell)
    {
        return this.activeCell;

    },

    createCaption: function(table)
    {
        var caption  = null;
        var captions = dfx.getTag('caption', table);
        if (captions.length > 0) {
            caption = captions[0];
        } else {
            caption = document.createElement('caption');
            dfx.setHtml(caption, '&nbsp;');

            dfx.insertBefore(table.firstChild, caption);
        }

        var range      = this.viper.getCurrentRange();
        var selectNode = range._getFirstSelectableChild(caption);
        range.setStart(selectNode, 0);
        range.collapse(true);
        ViperSelection.addRange(range);
        this.viper.fireSelectionChanged();

        this.removeHighlights();
        this.hideCellToolsIcon();

    },

    removeCaption: function(table)
    {
        var caption  = null;
        var captions = dfx.getTag('caption', table);
        if (captions.length > 0) {
            dfx.remove(captions);
        }

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
                // They all have the same colspan.
                return false;
            }

            prevColspan = this.getColspan(prevCell);
        }//end for

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
                // They all have the same colspan.
                return false;
            }

            prevColspan = this.getColspan(nextCell);
        }//end for

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
            row = this.getNextRow(row);
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
            }//end for

            return processedCells;
        }//end if

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
            row = this.getPreviousRow(row);
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
            }//end for

            return processedCells;
        }//end if

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

        var table = this.getCellTable(cell);
        if (dfx.getTag('tr', table).length === 1) {
            this.setColspan(cell, 1);
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

        var table = this.getCellTable(cell);
        if (dfx.getTag('tr', table).length === 1) {
            this.setColspan(cell, 1);
        }

        this.tableUpdated();

        return cell;

    },

    mergeDown: function(cell)
    {
        var mergeCells = this.canMergeDown(cell);
        if (mergeCells.length === 0) {
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
        }//end if

        var table = this.getCellTable(cell);
        if (dfx.getTag('tr', table).length === 1) {
            this.setColspan(cell, 1);
        }

        this.tableUpdated();

        return cell;

    },

    mergeUp: function(cell)
    {
        var mergeCells = this.canMergeUp(cell);
        if (mergeCells.length === 0) {
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

        var table = this.getCellTable(firstCell);
        if (dfx.getTag('tr', table).length === 1) {
            this.setColspan(firstCell, 1);
        }

        this.tableUpdated();

        return firstCell;

    },

    /*
        Moving.
    */
    canMoveColLeft: function(cell)
    {
         var colNum = this.getColNum(cell);
         if (colNum === 0) {
             return false;
         }

         var pos     = this.getCellPosition(cell);
         var cells   = this._getCellsExpanded(true);
         var colspan = this.getColspan(cell);

         for (var i = 0; i < cells.length; i++) {
             var currColspan = this.getColspan(cells[i][pos.col]);
             var prevColspan = this.getColspan(cells[i][(pos.col - 1)]);
             var currRowspan = this.getRowspan(cells[i][pos.col]);
             var prevRowspan = this.getRowspan(cells[i][(pos.col - 1)]);

             if (colspan !== currColspan || currColspan !== prevColspan) {
                 return false;
             } else if (currRowspan !== prevRowspan) {
                 return false;
             }
         }

         return true;

    },

    canMoveColRight: function(cell)
    {
         var pos     = this.getCellPosition(cell);
         var cells   = this._getCellsExpanded(true);
         var colspan = this.getColspan(cell);

         if (!cells[pos.row][(pos.col + 1)]) {
             return false;
         }

         for (var i = 0; i < cells.length; i++) {
             var currColspan = this.getColspan(cells[i][pos.col]);
             var nextColspan = this.getColspan(cells[i][(pos.col + 1)]);
             var currRowspan = this.getRowspan(cells[i][pos.col]);
             var nextRowspan = this.getRowspan(cells[i][(pos.col + 1)]);

             if (colspan !== currColspan || currColspan !== nextColspan) {
                 return false;
             } else if (currRowspan !== nextRowspan) {
                 return false;
             }
         }

         return true;

    },

    canMoveRowUp: function(cell)
    {
        var pos = this.getCellPosition(cell);

        if (pos.row === 0) {
            return false;
        }

        var rowspan = this.getRowspan(cell);
        var cellRow = this.getCellRow(cell);
        var prevRow = this.getPreviousRow(cellRow);

        if (!prevRow) {
            return false;
        }

        var rowCellsCount    = this._getRowCellCount(cellRow);
        var prevRowCellCount = this._getRowCellCount(prevRow);

        if (rowCellsCount !== prevRowCellCount) {
            return false;
        }

        // Also need to make sure the current cell has higher or equal rowspan than
        // the rest of the column on its row and all cells must start from the current
        // row (e.g. a cell cannot be from a previous row with rowspan).
        var cells = this._getCellsExpanded();

        for (var i = 0; i < cells[pos.row].length; i++) {
            var rowCell = cells[pos.row][i];
            if (rowCell === cell) {
                continue;
            }

            var cellPos = this.getCellPosition(rowCell);
            if (cellPos.row !== pos.row || rowspan < this.getRowspan(rowCell)) {
                return false;
            }
        }

        return true;

    },

    canMoveRowDown: function(cell)
    {
        var pos = this.getCellPosition(cell);

        var cellRow = this.getCellRow(cell);
        var rowspan = this.getRowspan(cell);

        var nextRow = cellRow;
        for (var i = 0; i < rowspan; i++) {
            nextRow = this.getNextRow(nextRow);
            if (!nextRow) {
                return false;
            }
        }

        var rowCellsCount    = this._getRowCellCount(cellRow);
        var nextRowCellCount = this._getRowCellCount(nextRow);

        if (rowCellsCount !== nextRowCellCount) {
            return false;
        }

        // Also need to make sure the current cell has higher or equal rowspan than
        // the rest of the column on its row and all cells must start from the current
        // row (e.g. a cell cannot be from a previous row with rowspan).
        var cells = this._getCellsExpanded();

        for (var i = 0; i < cells[pos.row].length; i++) {
            var rowCell = cells[pos.row][i];
            if (rowCell === cell) {
                continue;
            }

            var cellPos = this.getCellPosition(rowCell);
            if (cellPos.row !== pos.row || rowspan < this.getRowspan(rowCell)) {
                return false;
            }
        }

        return true;

    },

    moveColLeft: function(cell)
    {
        if (this.canMoveColLeft(cell) === false) {
            return false;
        }

        var pos   = this.getCellPosition(cell);
        var cells = this._getCellsExpanded(true);

        if (!cells[pos.row][(pos.col - 1)]) {
            return false;
        }

        for (var i = 0; i < cells.length; i++) {
            dfx.insertBefore(cells[i][(pos.col - 1)], cells[i][pos.col]);
        }

        this.tableUpdated();

        return cell;

    },

    moveColRight: function(cell)
    {
        if (this.canMoveColRight(cell) === false) {
            return false;
        }

        var pos   = this.getCellPosition(cell);
        var cells = this._getCellsExpanded(true);

        if (!cells[pos.row][(pos.col + 1)]) {
            return false;
        }

        for (var i = 0; i < cells.length; i++) {
            dfx.insertAfter(cells[i][(pos.col + 1)], cells[i][pos.col]);
        }

        this.tableUpdated();

        return cell;

    },

    moveRowUp: function(cell)
    {
        if (this.canMoveRowUp(cell) === false) {
            return false;
        }

        var cellRow = this.getCellRow(cell);
        var prevRow = this.getPreviousRow(cellRow);
        var rowspan = this.getRowspan(cell);

        for (var i = 0; i < rowspan; i++) {
            cellRow = this.getNextRow(prevRow);
            dfx.insertBefore(prevRow, cellRow);
        }

        this.tableUpdated();

        return cell;

    },

    moveRowDown: function(cell)
    {
        if (this.canMoveRowDown(cell) === false) {
            return false;
        }

        var rowspan = this.getRowspan(cell);
        var cellRow = this.getCellRow(cell);

        var nextRow = cellRow;
        for (var i = 0; i < rowspan; i++) {
            nextRow = this.getNextRow(nextRow);
            if (!nextRow) {
                return false;
            }
        }

        var startRow = nextRow;

        // If the afterRow contains cells with rowspans then we need to move the
        // current row after the rowspans.
        var cells      = this._getRowCells(startRow);
        var maxRowspan = 1;
        for (var i = 0; i < cells.length; i++) {
            var cellRowspan = this.getRowspan(cells[i]);
            if (maxRowspan < cellRowspan) {
                maxRowspan = cellRowspan;
            }
        }

        if (maxRowspan > 1) {
            for (var i = 0; i < (maxRowspan - 1); i++) {
                nextRow = this.getNextRow(nextRow);
            }

            afterRow = nextRow
        } else {
            afterRow = startRow;
        }

        for (var i = 0; i < rowspan; i++) {
            var prevRow = this.getPreviousRow(startRow);
            if (!prevRow) {
                return false;
            }

            dfx.insertAfter(afterRow, prevRow);
        }

        this.tableUpdated();

        return cell;

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

    /**
     * Converts specified cell to header.
     *
     * @param {DOMNode} cell The table cell to convert.
     * @param {string}  type Valid values are 'cell', 'col', 'row'. If col is specified
     *                       then the whole column the cell belongs to will be converted.
     *                       If the row is specifed then the whole row the cell belongs
     *                       to will be converted. Cell is the default value.
     *
     * @return {DOMNode} The new header element.
     */
    convertToHeader: function(cell, type)
    {
        var elem = cell;
        type     = type || 'cell';

        if (type === 'cell' && dfx.isTag(cell, 'td') === false) {
            return elem;
        }

        var activeCell = this.getActiveCell();
        if (type === 'cell') {
            elem = document.createElement('th');
            while (cell.firstChild) {
                elem.appendChild(cell.firstChild);
            }

            for (var i = 0; i < cell.attributes.length; i++) {
                elem.setAttribute(cell.attributes[i].nodeName, cell.attributes[i].nodeValue);
            }

            if (cell === activeCell) {
                this.setActiveCell(elem);
            }

            dfx.insertBefore(cell, elem);
            dfx.remove(cell);
        } else if (type === 'col') {
            // Get all column cells.
            var cells   = this._getCellsExpanded();
            var cellPos = this.getCellPosition(cell);

            for (var i = 0; i < cells.length; i++) {
                var colCell    = cells[i][cellPos.col];
                if (!colCell.parentNode || dfx.isTag(colCell, 'th') === true) {
                    continue;
                }

                var colCellPos = this.getCellPosition(colCell);
                if (colCellPos.col === cellPos.col) {
                    var newElement = this.convertToHeader(colCell);
                    if (cell === colCell) {
                        elem = newElement;
                    }
                }
            }
        } else if (type === 'row') {
            var cellPos = this.getCellPosition(cell);
            var cells   = this._getRowCells(cell.parentNode);
            for (var i = 0; i < cells.length; i++) {
                var rowCell    = cells[i];
                if (!rowCell.parentNode || dfx.isTag(rowCell, 'th') === true) {
                    continue;
                }

                var newElement = this.convertToHeader(rowCell);
                if (cell === rowCell) {
                    elem = newElement;
                }
            }
        }//end if

        this.tableUpdated();

        return elem;

    },

    /**
     * Converts specified header cell to normal cell.
     *
     * @param {DOMNode} cell The table cell to convert.
     * @param {string}  type Valid values are 'cell', 'col', 'row'. If col is specified
     *                       then the whole column the cell belongs to will be converted.
     *                       If the row is specifed then the whole row the cell belongs
     *                       to will be converted. Cell is the default value.
     *
     * @return {DOMNode} The new cell element.
     */
    convertToCell: function(cell, type)
    {
        var elem = cell;
        type     = type || 'cell';

        if (type === 'cell' && dfx.isTag(cell, 'th') === false) {
            return elem;
        }

        var activeCell = this.getActiveCell();
        if (type === 'cell') {
            elem = document.createElement('td');
            while (cell.firstChild) {
                elem.appendChild(cell.firstChild);
            }

            for (var i = 0; i < cell.attributes.length; i++) {
                elem.setAttribute(cell.attributes[i].nodeName, cell.attributes[i].nodeValue);
            }

            if (cell === activeCell) {
                this.setActiveCell(elem);
            }

            dfx.insertBefore(cell, elem);
            dfx.remove(cell);
        } else if (type === 'col') {
            var cells   = this._getCellsExpanded();
            var cellPos = this.getCellPosition(cell);

            for (var i = 0; i < cells.length; i++) {
                var colCell    = cells[i][cellPos.col];
                if (!colCell.parentNode || dfx.isTag(colCell, 'td') === true) {
                    continue;
                }

                var colCellPos = this.getCellPosition(colCell);
                if (colCellPos.col === cellPos.col) {
                    var newElement = this.convertToCell(colCell);
                    if (cell === colCell) {
                        elem = newElement;
                    }
                }
            }
        } else if (type === 'row') {
            var cellPos = this.getCellPosition(cell);
            var cells   = this._getRowCells(cell.parentNode);
            for (var i = 0; i < cells.length; i++) {
                var rowCell    = cells[i];
                if (!rowCell.parentNode || dfx.isTag(rowCell, 'td') === true) {
                    continue;
                }

                var newElement = this.convertToCell(rowCell);
                if (cell === rowCell) {
                    elem = newElement;
                }
            }
        }//end if

        this.tableUpdated();

        return elem;

    },

    setColumnWidth: function (cell, width)
    {
        if (parseInt(width) === width) {
            width = width + 'px';
        }

        var cells   = this._getCellsExpanded();
        var cellPos = this.getCellPosition(cell);

        // Find the first cell that belongs to the same column.
        for (var i = 0; i < cells.length; i++) {
            var colCell    = cells[i][cellPos.col];
            var colCellPos = this.getCellPosition(colCell);
            if (colCellPos.col === cellPos.col) {
                dfx.setStyle(colCell, 'width', width);
                return;
            }
        }

    },

    getColumnWidth: function(cell)
    {
        var cells   = this._getCellsExpanded();
        var cellPos = this.getCellPosition(cell);

        // Find the first cell that belongs to the same column.
        for (var i = 0; i < cells.length; i++) {
            var colCell    = cells[i][cellPos.col];
            var colCellPos = this.getCellPosition(colCell);
            if (colCellPos.col === cellPos.col) {
                return colCell.style.width || '';
            }
        }

        return '';

    },

    setTableWidth: function(table, width)
    {
        if (parseInt(width) === width) {
            width = width + 'px';
        }

        dfx.setStyle(table, 'width', width);

    },

    getTableWidth: function(table)
    {
        var width = table.style.width || '';
        return width;

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
        }//end if

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

            var rowspan = this.getRowspan(rowCell);
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
        }//end for

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
        }//end for

        dfx.insertAfter(cellRow, newRow);

        this.tableUpdated();

    },

    removeRow: function(cell)
    {
        var table   = this.getCellTable(cell);
        var tr      = this.getCellRow(cell);
        var cellPos = this.getCellPosition(cell);
        var cells   = this._getCellsExpanded();
        var rowspan = this.getRowspan(cell);

        var nextRowIndex = (cellPos.row + rowspan);
        var nextRow      = tr;
        for (var i = 0; i < rowspan; i++) {
            var rowToRemove = nextRow;
            nextRow         = this.getNextRow(nextRow);
            rowToRemove.parentNode.removeChild(rowToRemove);
        }

        var rowCells    = cells[cellPos.row];
        var cellsToMove = [];
        for (var i = 0; i < rowCells.length; i++) {
            var rowCell        = rowCells[i];
            var rowCellPos     = this.getCellPosition(rowCell);
            var rowCellRowspan = this.getRowspan(rowCell);
            if (rowCellPos.row !== cellPos.row || rowCellRowspan > rowspan) {
                if (rowCellPos.row === cellPos.row) {
                    cellsToMove.push(rowCell);
                }

                this.setRowspan(rowCell, (rowCellRowspan - rowspan));
            }
        }

        for (var i = 0; i < cellsToMove.length; i++) {
            var rowCell        = cellsToMove[i];
            var rowCellPos     = this.getCellPosition(rowCell);
            var rowCellRowspan = this.getRowspan(rowCell);
            rowCells           = cells[(cellPos.row + rowspan)];

            var index = rowCells.find(rowCell);
            if (index > 0) {
                for (var j = (index - 1); j >= 0; j--) {
                    if (this.getCellPosition(rowCells[j]).row === nextRowIndex) {
                        dfx.insertAfter(rowCells[j], rowCell);
                        break;
                    }
                }
            } else if (index === 0) {
                for (var j = 0; j < rowCells.length; j++) {
                    if (this.getCellPosition(rowCells[j]).row === nextRowIndex) {
                        dfx.insertBefore(rowCells[j], rowCell);
                        break;
                    }
                }
            }
        }//end for

        // If the table is now empty then remove it.
        var rows = dfx.getTag('tr', table);
        if (rows.length === 0) {
            dfx.remove(table);
        }

        this.tableUpdated();

    },

    insertColAfter: function(cell)
    {
        var table  = this.getCellTable(cell);
        var rows   = dfx.getTag('tr', table);
        var rln    = rows.length;
        var colNum = (this.getColNum(cell) + (this.getColspan(cell) - 1));

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
        var table  = this.getCellTable(cell);
        var rows   = dfx.getTag('tr', table);
        var rln    = rows.length;
        var colNum = this.getColNum(cell);

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

        // If the table is now empty then remove it.
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
            this.hideCellToolsIcon();
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
                var nextRow = this.getNextRow(node.parentNode);
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

    moveCaretToPreviousCell: function()
    {
        var range = this.viper.getCurrentRange();
        var cell  = this._getRangeCellElement(range);

        if (!cell) {
            return false;
        }

        this.setActiveCell(cell);

        var node = cell;
        while (node) {
            if (!node.previousSibling) {
                // Get next row.
                var previousRow = this.getPreviousRow(node.parentNode);
                if (!previousRow) {
                    return false;
                } else {
                    node = previousRow.lastChild;
                }
            } else {
                node = node.previousSibling;
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

        this.viper.fireSelectionChanged();
        this.viper.fireNodesChanged(this.viper.getViperElement());

        this.hideCellToolsIcon();

    },

    getCellTable: function(cell)
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
        var rows    = dfx.getTag('tr', this.getCellTable(cell));
        var cellPos = this.getCellPosition(cell);
        return rows[cellPos.row];

    },

    /**
     * Inserts a table to the caret position.
     */
    _createToolbarEditorBubble: function()
    {
        var main = document.createElement('div');

        var maxRows            = 10;
        var maxCols            = 10;
        var selectedRows       = 3;
        var selectedCols       = 4;
        var selectedHeaderType = 2;

        var content    = '';
        var sizePicker = '<p class="VTEP-bubble-label sizeLabel">Size (' + selectedCols + ' x ' + selectedRows + ')</p>';
        sizePicker    += '<table class="VTEP-bubble-table sizePicker"><tbody>';
        for (var i = 0; i < maxRows; i++) {
            sizePicker += '<tr>';
            for (var j = 0; j < maxCols; j++) {
                var classAttr = '';
                if (selectedRows > i && selectedCols > j) {
                    classAttr = ' class="selected"';
                }

                sizePicker += '<td data-viper-rowcol="' + i + ', ' + j + '"' + classAttr + ' ></td>';
            }

            sizePicker += '</tr>';
        }

        sizePicker += '</tbody></table>';
        content    += sizePicker;

        var headerOpts      = this._headerOptions;
        var headerOptTitles = ['None', 'Left', 'Top', 'Both'];
        var headers = '<p class="VTEP-bubble-label headers">Headers</p><div class="VTEP-bubble-headersWrapper">';
        for (var h = 0; h < headerOpts.length; h++) {
            var selected = '';
            if (h === selectedHeaderType) {
                selected = ' selected';
            }

            headers    += '<div class="VTEP-bubble-headersTableWrapper' + selected + '">';
            headers    += '<table class="VTEP-bubble-table headers"><tbody>';
            var c = 0;
            for (var i = 0; i < 3; i++) {
                headers += '<tr>';
                for (var j = 0; j < 3; j++) {
                    if (headerOpts[h] && headerOpts[h][c]) {
                        headers += '<td class="hover"></td>';
                    } else {
                        headers += '<td></td>';
                    }

                    c++;
                }

                headers += '</tr>';
            }

            headers += '</tbody></table>';
            headers += '<span class="VTEP-bubble-headerTitle">' + headerOptTitles[h] + '</span></div>';
        }

        headers += '</div>';
        content += headers;

        dfx.setHtml(main, content);

        var trs = dfx.getTag('tr', dfx.getClass('sizePicker', main)[0]);

        var _setRowColsActive = function(row, col) {
            selectedRows = (parseInt(row) + 1);
            selectedCols = (parseInt(col) + 1);

            dfx.setHtml(dfx.getClass('sizeLabel', main)[0], 'Size (' + selectedRows + ' x ' + selectedCols + ')');

            for (var i = 0; i < maxRows; i++) {
                for (var j = 0; j < maxCols; j++) {
                    if (i <= row && j <= col) {
                        dfx.addClass(trs[i].childNodes[j], 'selected');
                    } else {
                        dfx.removeClass(trs[i].childNodes[j], 'selected');
                    }
                }
            }
        };

        var _setRowColsHover = function(row, col) {

            dfx.setHtml(dfx.getClass('sizeLabel', main)[0], 'Size (' + (parseInt(row) + 1) + ' x ' + (parseInt(col) + 1) + ')');

            for (var i = 0; i < maxRows; i++) {
                for (var j = 0; j < maxCols; j++) {
                    if (i <= row && j <= col) {
                        dfx.addClass(trs[i].childNodes[j], 'hover');
                    } else {
                        dfx.removeClass(trs[i].childNodes[j], 'hover');
                    }
                }
            }
        };

        var tdHover        = null;
        var sizePickerElem = dfx.getClass('sizePicker', main)[0];
        dfx.addEvent(sizePickerElem, 'mousemove', function(e) {
            var td = dfx.getMouseEventTarget(e);
            if (td !== tdHover && dfx.isTag(td, 'td') === true) {
                tdHover = td;
                var rowcol = td.getAttribute('data-viper-rowcol').split(',');
                _setRowColsHover(rowcol[0], rowcol[1]);
            }
        });

        dfx.addEvent(sizePickerElem, 'click', function(e) {
            var td = dfx.getMouseEventTarget(e);
            if (td && dfx.isTag(td, 'td') === true) {
                var rowcol = td.getAttribute('data-viper-rowcol').split(',');
                _setRowColsActive(rowcol[0], rowcol[1]);
            }
        });

        dfx.hover(sizePickerElem, function() {}, function() {
            dfx.removeClass(dfx.getClass('hover', sizePickerElem), 'hover');
            dfx.setHtml(dfx.getClass('sizeLabel', main)[0], 'Size (' + selectedRows + ' x ' + selectedCols + ')');
        })

        var headerTables       = dfx.getClass('VTEP-bubble-headersTableWrapper', main);
        for (var i = 0; i < headerTables.length; i++) {
            (function(type) {
                dfx.addEvent(headerTables[type], 'click', function(e) {
                    selectedHeaderType = type;
                    dfx.removeClass(headerTables, 'selected');
                    dfx.addClass(headerTables[type], 'selected');
                });
            }) (i);
        }

        var self = this;
        var insertTableBtn = this.viper.ViperTools.createButton('VTEP-insertTableButton', 'Insert Table', 'Insert Table', '', function() {
            self.toolbarPlugin.closeBubble('VTEP-bubble');
            self.insertTable(selectedRows, selectedCols, selectedHeaderType);
        });
        main.appendChild(insertTableBtn);

        this.toolbarPlugin.createBubble('VTEP-bubble', 'Insert Table', main);
        this.toolbarPlugin.setBubbleButton('VTEP-bubble', 'insertTable', true);

    },

    insertTable: function(rows, cols, headerType)
    {
        this.viper.ViperHistoryManager.begin();

        rows = rows || 3;
        cols = cols || 3;

        var table = document.createElement('table');
        // First hide the table so we can determine if there are borders etc.
        dfx.setStyle(table, 'display', 'none');

        var tbody      = document.createElement('tbody');
        var firstCol   = null;
        var headerOpts = this._headerOptions;

        for (var i = 0; i < rows; i++) {
            var tr = document.createElement('tr');
            for (var j = 0; j < cols; j++) {
                var cell     = null;
                var isHeader = false;
                if (headerType === 1 && j === 0) {
                    isHeader = true;
                } else if (headerType === 2 && i === 0) {
                    isHeader = true;
                } else if (headerType === 3 && (i === 0 || j === 0)) {
                    isHeader = true;
                }

                if (isHeader) {
                    cell = document.createElement('th');
                } else {
                    cell = document.createElement('td');
                }

                dfx.setHtml(cell, '&nbsp;');

                tr.appendChild(cell);

                if (firstCol === null) {
                    firstCol = cell;
                }
            }//end for

            tbody.appendChild(tr);
        }//end for

        table.appendChild(tbody);

        // Insert table to the bookmarks position.
        var keyboardEditorPlugin = this.viper.ViperPluginManager.getPlugin('ViperKeyboardEditorPlugin');
        var prevNode = keyboardEditorPlugin.splitAtRange(true);
        if (dfx.isTag(prevNode, 'li') === true) {
            prevNode.appendChild(table);
            if (dfx.isBlank(dfx.getNodeTextContent(prevNode.nextSibling)) === true) {
                dfx.remove(prevNode.nextSibling);
            }
        } else {
            dfx.insertAfter(prevNode, table);
        }

        // Now determine if we need to add borders or width to this table.
        // Done over here so that if there are CSS styles applied to tables
        // then we don't override them.
        var width = parseInt(dfx.getComputedStyle(table, 'width'));
        if (!width) {
            dfx.setStyle(table, 'width', '100%');
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
        if (!table.getAttribute('style')) {
            table.removeAttribute('style');
        }

        if (firstCol) {
            var range = this.viper.getCurrentRange();
            range.setStart(firstCol.firstChild, 0);
            range.collapse(true);
            ViperSelection.addRange(range);
            this.setActiveCell(firstCol);
        }

        this.viper.fireSelectionChanged();
        this.viper.fireNodesChanged([table]);

        this.viper.ViperHistoryManager.end();

    },

    setTableHeaders: function(table)
    {
        if (!table) {
            return;
        }

        var headers      = dfx.find(table, '[headers]');
        var headersCount = headers.length;
        if (headersCount > 0) {
            for (var i = 0; i < headersCount; i++) {
                headers[i].removeAttribute('headers');
            }
        }

        var tableId = table.getAttribute('id');

        if (!tableId) {
            while (!tableId) {
                tableId   = dfx.getUniqueId().substr(-5, 5);
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
        var headings = {
            col: [],
            row: []
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

                            headings.row[(rowCount + i)].id     += cellid;
                            headings.row[(rowCount + i)].rowspan = rowspan;

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

                        headers        = headers.split(' ');
                        var headersLen = headers.length;
                        for (var i = 0; i < headersLen; i++) {
                            var header     = headers[i];
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

        var cols = dfx.getTag('td,th', rowElem);
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

    _setCaretToStart: function(table)
    {
        // Set the caret to the first cell of the table.
        var cells = dfx.getTag('td,th', table);
        if (cells.length > 0) {
            if (dfx.getHtml(cells[0]) === '') {
                dfx.setHtml(cells[0], '&nbsp;');
            }

            var range = this.viper.getCurrentRange();
            range.setStart(range._getFirstSelectableChild(cells[0]), 0);
            range.collapse(true);
            ViperSelection.addRange(range);
        }

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
                    colspan: this.getColspan(rowCells[j])
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
        var rows  = cells.length;

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
                var rowCell  = tableCells[rowNum][j].cell;
                var rowspan  = tableCells[rowNum][j].rowspan;
                var colspan  = tableCells[rowNum][j].colspan;
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

    getPreviousRow: function(row)
    {
        while (row = row.previousSibling) {
            if (row.nodeType === dfx.ELEMENT_NODE) {
                var tagName = row.tagName.toLowerCase();
                if (tagName === 'tr') {
                    return row;
                }
            }
        }

    },

    getNextRow: function(row, goPrev)
    {
        while (row = row.nextSibling) {
            if (row.nodeType === dfx.ELEMENT_NODE) {
                var tagName = row.tagName.toLowerCase();
                if (tagName === 'tr') {
                    return row;
                }
            }
        }

        if (goPrev === true) {
            return this.getPreviousRow(row);
        }

    },

    _getRowCells: function(row)
    {
        var tags = dfx.getTag('td,th', row);
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
