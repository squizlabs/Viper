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

function ViperTableEditorPlugin(viper)
{
    this.viper             = viper;
    this._tools            = viper.ViperTools;
    this._toolbarWidget    = null;
    this.toolbarPlugin     = null;
    this.activeCell        = null;
    this._highlightElement = null;
    this._cellTools        = null;

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

            var vap = self.viper.ViperPluginManager.getPlugin('ViperAccessibilityPlugin');
            if (vap) {
                vap.loadHTMLCS(function() {
                    var tables = dfx.getTag('table', self.viper.getViperElement());
                    for (var i = 0; i < tables.length; i++) {
                        self.setTableHeaders(tables[i]);
                    }
                });
            }
        });

        this.viper.registerCallback('ViperCopyPastePlugin:paste', 'ViperTableEditorPlugin', function() {
            var vap = self.viper.ViperPluginManager.getPlugin('ViperAccessibilityPlugin');
            if (vap) {
                vap.loadHTMLCS(function() {
                    var tables = dfx.getTag('table', self.viper.getViperElement());
                    for (var i = 0; i < tables.length; i++) {
                        self.setTableHeaders(tables[i]);
                    }
                });
            }
        });

        this.viper.registerCallback('setHtml', 'ViperTableEditorPlugin', function(data) {
            var vap = self.viper.ViperPluginManager.getPlugin('ViperAccessibilityPlugin');
            if (vap) {
                vap.loadHTMLCS(function() {
                    var tables = dfx.getTag('table', data.element);
                    for (var i = 0; i < tables.length; i++) {
                        self.setTableHeaders(tables[i]);
                        self._initTable(tables[i]);
                    }
                });
            } else {
                var tables = dfx.getTag('table', data.element);
                for (var i = 0; i < tables.length; i++) {
                    self._initTable(tables[i]);
                }
            }
        });

        this.viper.registerCallback('Viper:enabled', 'ViperTableEditorPlugin', function() {
            var tables = dfx.getTag('table', self.viper.getViperElement());
            for (var i = 0; i < tables.length; i++) {
                self._initTable(tables[i]);
            }
        });

        // Hide the toolbar when user clicks anywhere.
        this.viper.registerCallback(['Viper:mouseDown', 'ViperHistoryManager:undo'], 'ViperTableEditorPlugin', function(data) {
            if (self.viper.isBrowser('firefox') === true) {
                // Disable Firefox table editing.
                document.execCommand("enableInlineTableEditing", false, false);
                document.execCommand("enableObjectResizing", false, false);
            }

            self.setActiveCell(null);
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
            self.hideCellToolsIcon();
            self.removeHighlights();

            var cell = self.getActiveCell();
            if (cell && self._toolbarWidget.isVisible() === true) {
                self._updatePosition(cell);
                self.highlightActiveCell(self._currentType);
            }
        });

        this.viper.registerCallback('Viper:keyDown', 'ViperTableEditorPlugin', function(e) {
            if (e.which === 9) {
                // Handle tab key.
                self.removeHighlights();

                if (e.shiftKey === true && self.activeCell) {
                    self.moveCaretToPreviousCell();
                } else {
                    if (self.activeCell && self.moveCaretToNextCell() === false) {
                        // Create a new row.
                        self.insertRowAfter(self.activeCell);
                        self.moveCaretToNextCell();
                    }
                }

                dfx.preventDefault(e);
                return false;
            } else if (e.which === 39 || e.which === 40) {
                // Right and down arrow.
                // If the range is at the end of a table (last cell) then move the
                // caret outside even if there is no next sibling.
                var range = self.viper.getCurrentRange();
                if (range.collapsed === true) {
                    var startNode = range.getStartNode();
                    if (startNode && (dfx.isTag(startNode, 'br') === true || (startNode.nodeType === dfx.TEXT_NODE && range.endOffset === startNode.data.length))) {
                        var cell           = self.getActiveCell();
                        var lastSelectable = range._getLastSelectableChild(cell);
                        if (startNode === lastSelectable || (!lastSelectable && dfx.isTag(startNode, 'br') === true)) {
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
            } else if (self.viper.isInputKey(e) === true && e.which !== 13) {
                // Not input key or enter key, hide tools.
                self.hideCellToolsIcon();
                self.removeHighlights();
                self.hideToolbar();
            }//end if
        });

        this.viper.registerCallback('Viper:clickedOutside', 'ViperTableEditorPlugin', function(data) {
            self.hideCellToolsIcon();
            self.removeHighlights();
        });

        this.viper.registerCallback('ViperFormatPlugin:elementAttributeSet', 'ViperTableEditorPlugin', function(data) {
            if (data.element && dfx.isTag(data.element, 'th') === true) {
                var table      = self.getCellTable(data.element);
                var headerAttr = dfx.find(table, '[headers~="' + data.oldValue + '"]');
                for (var i = 0; i < headerAttr.length; i++) {
                    var attr = ' ' + headerAttr[i].getAttribute('headers');
                    attr     = attr.replace(' ' + data.oldValue, (data.element.getAttribute('id') || ''));
                    headerAttr[i].setAttribute('headers', dfx.trim(attr));
                }

                self.setTableHeaders(table);
            }
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

            var button = this.viper.ViperTools.createButton('insertTable', '', 'Insert Table', 'Viper-table', function() {
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
                        if (self._cellTools && dfx.hasClass(self._cellTools, 'Viper-topBar') === true) {
                            self.hideCellToolsIcon();
                        } else {
                            self.showCellToolsIcon(cell, true);
                        }
                    }
                } else {
                    if (self.viper.isBrowser('msie') === true) {
                        // This must be in a timeout to be able to calculate the bubbles position correctly.
                        setTimeout(function() {console.info(1);
                            self.toolbarPlugin.toggleBubble('VTEP-bubble');    
                        }, 10);
                    } else {
                        self.toolbarPlugin.toggleBubble('VTEP-bubble');
                    }   
                }
            }, true);
            this.toolbarPlugin.addButton(button);

            // Create the toolbar bubble.
            this._createToolbarEditorBubble();
        }

        if (this._isiPad() === false) {
            var showToolbar = false;
            this.viper.registerCallback('Viper:mouseUp', 'ViperTableEditorPlugin', function(e) {
                var range = self.viper.getCurrentRange();
                var target = dfx.getMouseEventTarget(e);

                if (!target) {
                    return;
                }

                if (target === self._toolbar || dfx.isChildOf(target, self._toolbar) === true) {
                    self._buttonClicked = false;
                    return false;
                }

                if (range.collapsed === false
                    || dfx.isTag(target, 'a') === true
                    || dfx.isTag(target, 'img') === true
                ) {
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
                        if (range.startContainer && dfx.isStubElement(range.startContainer) === true) {
                            node = range.startContainer;
                        } else {
                            return;
                        }
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
                            var nodeSelection = range.getNodeSelection();
                            if (!nodeSelection || dfx.isStubElement(nodeSelection) === false) {
                                self._tools.enableButton('insertTable');
                                self._tools.setButtonInactive('insertTable');
                            } else {
                                self._tools.disableButton('insertTable');
                                self._tools.setButtonInactive('insertTable');
                            }
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

        this._initToolbar();

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
            var html = dfx.trim(dfx.getHtml(cells[i]));
            if (html === '' || html === '&nbsp;') {
                this._initCell(cells[i]);
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
        dfx.addClass(tools, 'ViperITP Viper-themeDark Viper-compact Viper-visible');
        this._cellTools = tools;

        // Table, row, col and cell buttons. Initially only the table icon is visible
        // Whent he mouse is moved over the table icon, rest of the buttons become
        // visible where user can pick the tools they want to use.
        var buttonGroup = this.viper.ViperTools.createButtonGroup('VTEP:cellTools:buttons', 'ViperITP-tools');
        var tableBtn    = this._tools.createButton('VTEP:cellTools:table', '', 'Show Table tools', 'Viper-table', function() {
            showTools('table');
        });
        var rowBtn = this._tools.createButton('VTEP:cellTools:row', '', 'Show Row tools', 'Viper-tableRow Viper-hidden', function() {
            showTools('row');
        });
        var colBtn = this._tools.createButton('VTEP:cellTools:col', '', 'Show Column tools', 'Viper-tableCol Viper-hidden', function() {
            showTools('col');
        });
        var cellBtn = this._tools.createButton('VTEP:cellTools:cell', '', 'Show Cell tools', 'Viper-tableCell Viper-hidden', function() {
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
            dfx.removeClass(btns, 'Viper-hidden');
            dfx.setStyle(tools, 'margin-left', '-45px');
            cellCoords     = dfx.getBoundingRectangle(this._tools.getItem('insertTable').element);

            if (dfx.getStyle(this._tools.getItem('insertTable').element.parentNode, 'position') === 'fixed') {
                cellCoords.y2 += (5 - scrollCoords.y);
                dfx.setStyle(tools, 'position', 'fixed');
            } else {
                dfx.setStyle(tools, 'position', 'absolute');
            }

            dfx.addClass(tools, 'Viper-topBar');
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
                    dfx.removeClass(btns, 'Viper-hidden');
                    dfx.setStyle(tools, 'margin-left', '-45px');
                }, function() {
                    self.removeHighlights();
                    dfx.addClass(btns, 'Viper-hidden');
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
        if (!this._cellTools) {
            return;
        }

        var toolsid = this.viper.getId() + '-ViperTEP';
        var tools   = dfx.getId(toolsid);

        if (tools) {
            dfx.remove(tools);
        }

        this._cellTools = null;

    },

    showTableTools: function(cell, type)
    {
        if (!cell) {
            return;
        }

        this.updateToolbar(cell, type);

    },

    _initToolbar: function()
    {
        var tools       = this.viper.ViperTools;
        var toolbarid   = 'ViperTableEditor-toolbar';
        var self        = this;
        var toolbarElem = tools.createInlineToolbar(toolbarid);
        var toolbar     = tools.getItem(toolbarid);

        this._toolbarWidget = toolbar;

        // Add lineage container to the toolbar.
        var lineage = document.createElement('ul');
        dfx.addClass(lineage, 'ViperITP-lineage');
        dfx.insertBefore(toolbarElem.firstChild, lineage);
        this._lineage = lineage;

        // Add the table buttons.
        this._createCellProperties();
        this.viper.fireCallbacks('ViperTableEditorPlugin:initToolbar', {toolbar: toolbar, type: 'cell'});

        this._createColProperties();
        this.viper.fireCallbacks('ViperTableEditorPlugin:initToolbar', {toolbar: toolbar, type: 'col'});

        this._createRowProperties();
        this.viper.fireCallbacks('ViperTableEditorPlugin:initToolbar', {toolbar: toolbar, type: 'row'});

        this._createTableProperties();
        this.viper.fireCallbacks('ViperTableEditorPlugin:initToolbar', {toolbar: toolbar, type: 'table'});

    },

    hideToolbar: function()
    {
        this._toolbarWidget.hide();

    },

    getCurrentViewType: function()
    {
        return this._type;

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

        dfx.removeClass(this._toolbar, 'Viper-subSectionVisible');

        // Set highlight to active cell.
        this.highlightActiveCell();

        this._toolbarWidget.resetButtons();
        this._updateLineage(type);
        this._updateInnerContainer(cell, type, activeSubSection);
        this._updatePosition(cell, type);
        this.highlightActiveCell(type);
        this._toolbarWidget._updateSubSectionArrowPos();

        this._toolbarWidget.focusSubSection();
        this.viper.removeHighlights();

    },

    _updateInnerContainer: function(cell, type, activeSubSection)
    {
        switch (type) {
            case 'cell':
            default:
                this._showCellProperties(cell, activeSubSection);
            break;

            case 'col':
                this._showColProperties(cell);
            break;

            case 'row':
                this._showRowProperties(cell);
            break;

            case 'table':
                this._showTableProperties(cell);
            break;
        }

        var callbackData = {
            toolbar: this,
            cell: cell,
            type: type,
            toolbar: this._toolbarWidget
        };
        this.viper.fireCallbacks('ViperTableEditorPlugin:updateToolbar', callbackData);

    },

    _showCellProperties: function(cell, activeSubSection)
    {
        this._toolbarWidget.showButton('VTEP:cellProps:mergeSplitSubSectionToggle');
        this._toolbarWidget.showButton('VTEP:cellProps:settings');

        this._tools.getItem('VTEP:cellProps:heading').setValue(dfx.isTag(cell, 'th'));

        if (this.getRowspan(cell) <= 1) {
            this._tools.disableButton('VTEP:cellProps:splitHoriz');
        } else {
            this._tools.enableButton('VTEP:cellProps:splitHoriz');
        }

        if (this.getColspan(cell) <= 1) {
            this._tools.disableButton('VTEP:cellProps:splitVert');
        } else {
            this._tools.enableButton('VTEP:cellProps:splitVert');
        }

        if (this.canMergeUp(cell) !== false) {
            this._tools.enableButton('VTEP:cellProps:mergeUp');
        } else {
            this._tools.disableButton('VTEP:cellProps:mergeUp');
        }

        if (this.canMergeDown(cell) !== false) {
            this._tools.enableButton('VTEP:cellProps:mergeDown');
        } else {
            this._tools.disableButton('VTEP:cellProps:mergeDown');
        }

        if (this.canMergeRight(cell) !== false) {
            this._tools.enableButton('VTEP:cellProps:mergeRight');
        } else {
            this._tools.disableButton('VTEP:cellProps:mergeRight');
        }

        if (this.canMergeLeft(cell) !== false) {
            this._tools.enableButton('VTEP:cellProps:mergeLeft');
        } else {
            this._tools.disableButton('VTEP:cellProps:mergeLeft');
        }

        if (activeSubSection === 'merge') {
            this._toolbarWidget.toggleSubSection('VTEP:cellProps:mergeSplitSubSection');
        } else {
            this._toolbarWidget.toggleSubSection('VTEP:cellProps:settingsSubSection');
        }

    },

    _showColProperties: function(cell)
    {
        this._toolbarWidget.showButton('VTEP:colProps:settings');
        this._toolbarWidget.showButton('VTEP:colProps:insBefore');
        this._toolbarWidget.showButton('VTEP:colProps:insAfter');
        this._toolbarWidget.showButton('VTEP:colProps:moveLeft');
        this._toolbarWidget.showButton('VTEP:colProps:moveRight');
        this._toolbarWidget.showButton('VTEP:colProps:remove');

        var colWidth = this.getColumnWidth(cell);
        this._tools.getItem('VTEP:colProps:width').setValue(colWidth);

        /// Heading.
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

        this._tools.getItem('VTEP:colProps:heading').setValue(wholeColHeading, true);

        // Enable/disable move col icons.
        if (this.canMoveColLeft(cell) === true) {
            this._tools.enableButton('VTEP:colProps:moveLeft');
        } else {
            this._tools.disableButton('VTEP:colProps:moveLeft');
        }

        // Enable/disable move col icons.
        if (this.canMoveColRight(cell) === true) {
            this._tools.enableButton('VTEP:colProps:moveRight');
        } else {
            this._tools.disableButton('VTEP:colProps:moveRight');
        }

        this._toolbarWidget.toggleSubSection('VTEP:colProps:settingsSubSection');

    },

    _showRowProperties: function(cell)
    {
        this._toolbarWidget.showButton('VTEP:rowProps:settings');
        this._toolbarWidget.showButton('VTEP:rowProps:insBefore');
        this._toolbarWidget.showButton('VTEP:rowProps:insAfter');
        this._toolbarWidget.showButton('VTEP:rowProps:moveUp');
        this._toolbarWidget.showButton('VTEP:rowProps:moveDown');
        this._toolbarWidget.showButton('VTEP:rowProps:remove');

        this._tools.getItem('VTEP:rowProps:heading').setValue(dfx.getTag('td', cell.parentNode).length === 0);

        if (this.canMoveRowUp(cell) === false) {
            this._tools.disableButton('VTEP:rowProps:moveUp');
        } else {
            this._tools.enableButton('VTEP:rowProps:moveUp');
        }

        if (this.canMoveRowDown(cell) === false) {
            this._tools.disableButton('VTEP:rowProps:moveDown');
        } else {
            this._tools.enableButton('VTEP:rowProps:moveDown');
        }

        this._toolbarWidget.toggleSubSection('VTEP:rowProps:settingsSubSection');

    },

    _showTableProperties: function(cell)
    {
        var table = this.getCellTable(cell);
        this._toolbarWidget.showButton('VTEP:tableProps:settings');
        this._toolbarWidget.showButton('VTEP:tableProps:remove');

        var tableWidth = this.getTableWidth(table);
        this._tools.getItem('VTEP:tableProps:width').setValue(tableWidth);

        var summary = table.getAttribute('summary') || '';
        this._tools.getItem('VTEP:tableProps:summary').setValue(summary);

        this._tools.getItem('VTEP:tableProps:caption').setValue((dfx.getTag('caption', table).length > 0));

        this._toolbarWidget.toggleSubSection('VTEP:tableProps:settingsSubSection');

    },

    tableUpdated: function(table)
    {
        this._tableRawCells = null;
        table = table || this.getCellTable(this.activeCell);

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
        var rangeCoords = this._toolbarWidget.getElementCoords(cell);

        if (!rangeCoords) {
            return;
        }

        var scrollCoords = dfx.getScrollCoords();

        var toolbar = this._toolbarWidget.element;

        dfx.addClass(toolbar, 'Viper-calcWidth');
        dfx.setStyle(toolbar, 'width', 'auto');
        var toolbarWidth = dfx.getElementWidth(toolbar);
        dfx.removeClass(toolbar, 'Viper-calcWidth');
        dfx.setStyle(toolbar, 'width', toolbarWidth + 'px');

        var left = 0;
        var top  = 0;
        if (this._targetToolbarButton !== true) {
            if (verticalOnly !== true) {
                left = ((rangeCoords.left + ((rangeCoords.right - rangeCoords.left) / 2) + scrollCoords.x) - (toolbarWidth / 2));
                dfx.setStyle(toolbar, 'left', left + 'px');
            }

            top = (rangeCoords.bottom + this._margin + scrollCoords.y);
            dfx.setStyle(toolbar, 'position', 'absolute');
        } else {
            var cellCoords = dfx.getBoundingRectangle(this._tools.getItem('insertTable').element);
            top  = cellCoords.y2 + 15 - scrollCoords.y;
            left = ((cellCoords.x1 + ((cellCoords.x2 - cellCoords.x1) / 2) + scrollCoords.x) - (toolbarWidth / 2));

            dfx.setStyle(toolbar, 'left', left + 'px');
            dfx.setStyle(toolbar, 'position', 'fixed');
        }

        dfx.setStyle(toolbar, 'top', top + 'px');
        dfx.addClass(toolbar, 'Viper-visible');

    },

    _updateLineage: function(type)
    {
        var self = this;

        dfx.empty(this._lineage);

        dfx.removeClass(dfx.getClass('Viper-selected', this._lineage), 'Viper-selected');

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

        if (type === 'table') {
            dfx.addClass(table, 'Viper-selected');
        }

        // Row.
        var row = document.createElement('li');
        dfx.addClass(row, 'ViperITP-lineageItem');
        dfx.setHtml(row, 'Row');
        this._lineage.appendChild(row);
        dfx.addEvent(row, 'mousedown', function(e) {
            dfx.removeClass(dfx.getClass('Viper-selected', self._lineage), 'Viper-selected');
            dfx.addClass(row, 'Viper-selected');
            self._buttonClicked = true;
            self.updateToolbar(self.getActiveCell(), 'row');
            dfx.preventDefault(e);
            return false;
        });

        if (type === 'row') {
            dfx.addClass(row, 'Viper-selected');
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

        if (type === 'col') {
            dfx.addClass(col, 'Viper-selected');
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
        if (!type || type === 'cell') {
            dfx.addClass(cell, 'Viper-selected');
        }

        setTimeout(function() {
            // Add the hover events after a few ms of showing the toolbar so that
            // if the pointer is on top of the lineage item it does not change the
            // highlighted cell.
            dfx.hover(table, function() {
                self.highlightActiveCell('table');
            }, function() {
                self.removeHighlights();
                self.highlightActiveCell(self._currentType);
            });

            dfx.hover(row, function() {
                self.highlightActiveCell('row');
            }, function() {
                self.removeHighlights();
                self.highlightActiveCell(self._currentType);
            });

            dfx.hover(col, function() {
                self.highlightActiveCell('col');
            }, function() {
                self.removeHighlights();
                self.highlightActiveCell(self._currentType);
            });

            dfx.hover(cell, function() {
                self.highlightActiveCell('cell');
            }, function() {
                self.removeHighlights();
                self.highlightActiveCell(self._currentType);
            });
        }, 100);

    },

    removeHighlights: function()
    {
        dfx.remove(this._highlightElement);

    },


    highlightActiveCell: function(parentType)
    {
        parentType     = parentType || 'cell';
        var activeCell = this.getActiveCell();
        var element    = null;
        var coords     = null;

        if (!activeCell) {
            return;
        }

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

        dfx.addEvent(hElem, 'mousedown', function(e) {
            dfx.preventDefault(e);
            dfx.remove(hElem);
            return false;
        });

        // Hide the highlight element when the mouse is over it. Show it again, when
        // the mouse is over the table tools bar.
        var self = this;
        dfx.hover(hElem, function() {
            dfx.hideElement(hElem);
        }, function() {});

        dfx.hover(self._toolbarWidget.element, function() {
            dfx.showElement(hElem);
        }, function() {});

    },

    __updateInnerContainer: function(cell, type, activeSubSection)
    {
        var callbackData = {
            toolbar: this,
            cell: cell,
            type: type
        };
        this.viper.fireCallbacks('ViperTableEditorPlugin:updateToolbar', callbackData);

    },

    _createCellProperties: function()
    {
        var self               = this;
        var settingsContent    = document.createElement('div');
        var headingChanged     = false;
        var settingsSubSection = this._toolbarWidget.makeSubSection('VTEP:cellProps:settingsSubSection', settingsContent);
        var settingsButton     = this._tools.createButton('VTEP:cellProps:settings', '', 'Toggle Settings', 'Viper-tableSettings');
        this._toolbarWidget.addButton(settingsButton);
        this._toolbarWidget.setSubSectionButton('VTEP:cellProps:settings', 'VTEP:cellProps:settingsSubSection');
        this._toolbarWidget.setSubSectionAction('VTEP:cellProps:settingsSubSection', function() {
            var cell = self.getActiveCell();
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
        var heading = this._tools.createCheckbox('VTEP:cellProps:heading', 'Heading', false, function() {
            headingChanged = true;
        });
        settingsContent.appendChild(heading);

        // Split buttons.
        this._tools.createButton('VTEP:cellProps:splitVert', '', 'Split Vertically', 'Viper-splitVert', function() {
            var cell = self.getActiveCell();
            self._buttonClicked = true;
            self.splitVertical(cell);
            self.updateToolbar(cell, 'cell', 'merge');
        });

        this._tools.createButton('VTEP:cellProps:splitHoriz', '', 'Split Horizontally', 'Viper-splitHoriz', function() {
            var cell = self.getActiveCell();
            self._buttonClicked = true;
            self.splitHorizontal(cell);
            self.updateToolbar(cell, 'cell', 'merge');
        });

        var splitBtnGroup = this._tools.createButtonGroup('VTEP:cellProps:splitButtons');
        this._tools.addButtonToGroup('VTEP:cellProps:splitVert', 'VTEP:cellProps:splitButtons');
        this._tools.addButtonToGroup('VTEP:cellProps:splitHoriz', 'VTEP:cellProps:splitButtons');

        // Merge buttons.
        var mergeUp = this._tools.createButton('VTEP:cellProps:mergeUp', '', 'Merge Up', 'Viper-mergeUp', function() {
            var cell = self.getActiveCell();
            self._buttonClicked = true;
            self.updateToolbar(self.mergeUp(cell), 'cell', 'merge');
        });

        var mergeDown = this._tools.createButton('VTEP:cellProps:mergeDown', '', 'Merge Down', 'Viper-mergeDown', function() {
            var cell = self.getActiveCell();
            self._buttonClicked = true;
            self.updateToolbar(self.mergeDown(cell), 'cell', 'merge');
        });

        var mergeLeft = this._tools.createButton('VTEP:cellProps:mergeLeft', '', 'Merge Left', 'Viper-mergeLeft', function() {
            var cell = self.getActiveCell();
            self._buttonClicked = true;
            self.updateToolbar(self.mergeLeft(cell), 'cell', 'merge');
        });

        var mergeRight = this._tools.createButton('VTEP:cellProps:mergeRight', '', 'Merge Right', 'Viper-mergeRight', function() {
            var cell = self.getActiveCell();
            self._buttonClicked = true;
            self.updateToolbar(self.mergeRight(cell), 'cell', 'merge');
        });

        var mergeBtnGroup = this._tools.createButtonGroup('VTEP:cellProps:mergeButtons');
        this._tools.addButtonToGroup('VTEP:cellProps:mergeUp', 'VTEP:cellProps:mergeButtons');
        this._tools.addButtonToGroup('VTEP:cellProps:mergeDown', 'VTEP:cellProps:mergeButtons');
        this._tools.addButtonToGroup('VTEP:cellProps:mergeLeft', 'VTEP:cellProps:mergeButtons');
        this._tools.addButtonToGroup('VTEP:cellProps:mergeRight', 'VTEP:cellProps:mergeButtons');

        var mergeSubWrapper = document.createElement('div');
        mergeSubWrapper.appendChild(splitBtnGroup);
        mergeSubWrapper.appendChild(mergeBtnGroup);

        // Create the merge/split sub section toggle button.
        var mergeSubSection = this._toolbarWidget.makeSubSection('VTEP:cellProps:mergeSplitSubSection', mergeSubWrapper);
        var mergeSplitToggle = this._tools.createButton('VTEP:cellProps:mergeSplitSubSectionToggle', '', 'Toggle Merge/Split Options', 'Viper-splitMerge');
        this._toolbarWidget.addButton(mergeSplitToggle);
        this._toolbarWidget.setSubSectionButton('VTEP:cellProps:mergeSplitSubSectionToggle', 'VTEP:cellProps:mergeSplitSubSection');

    },

    _createColProperties: function()
    {
        var self = this;

        var settingsContent = document.createElement('div');

        // Create the settings sub section.
        var headingChanged     = false;
        var settingsSubSection = this._toolbarWidget.makeSubSection('VTEP:colProps:settingsSubSection', settingsContent);
        var settingsButton     = this._tools.createButton('VTEP:colProps:settings', '', 'Toggle Settings', 'Viper-tableSettings');
        this._toolbarWidget.addButton(settingsButton);
        this._toolbarWidget.setSubSectionButton('VTEP:colProps:settings', 'VTEP:colProps:settingsSubSection');
        this._toolbarWidget.setSubSectionAction('VTEP:colProps:settingsSubSection', function() {
            var cell = self.getActiveCell();
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
        var width = this._tools.createTextbox('VTEP:colProps:width', 'Width');
        settingsContent.appendChild(width);

        var heading = this._tools.createCheckbox('VTEP:colProps:heading', 'Heading', false, function() {
            headingChanged = true;
        });
        settingsContent.appendChild(heading);

        this._tools.createButton('VTEP:colProps:insBefore', '', 'Insert Column Before', 'Viper-addLeft', function() {
            var cell = self.getActiveCell();
            self._buttonClicked = true;
            self.insertColBefore(cell);
            self.updateToolbar(cell, 'col');
        });
        this._tools.createButton('VTEP:colProps:insAfter', '', 'Insert Column After', 'Viper-addRight', function() {
            var cell = self.getActiveCell();
            self._buttonClicked = true;
            self.insertColAfter(cell);
            self.updateToolbar(cell, 'col');
        });

        var btnGroup = this._tools.createButtonGroup('VTEP:insColButtons');
        this._tools.addButtonToGroup('VTEP:colProps:insBefore', 'VTEP:insColButtons');
        this._tools.addButtonToGroup('VTEP:colProps:insAfter', 'VTEP:insColButtons');
        this._toolbarWidget.addButton(btnGroup);

        this._tools.createButton('VTEP:colProps:moveLeft', '', 'Move Left', 'Viper-mergeLeft', function() {
            var cell = self.getActiveCell();
            self._buttonClicked = true;
            self.updateToolbar(self.moveColLeft(cell), 'col');
        });
        this._tools.createButton('VTEP:colProps:moveRight', '', 'Move Right', 'Viper-mergeRight', function() {
            var cell = self.getActiveCell();
            self._buttonClicked = true;
            self.updateToolbar(self.moveColRight(cell), 'col');
        });

        btnGroup = this._tools.createButtonGroup('VTEP:moveColButtons');
        this._tools.addButtonToGroup('VTEP:colProps:moveLeft', 'VTEP:moveColButtons');
        this._tools.addButtonToGroup('VTEP:colProps:moveRight', 'VTEP:moveColButtons');
        this._toolbarWidget.addButton(btnGroup);

        var removeCol = this._tools.createButton('VTEP:colProps:remove', '', 'Remove Column', 'Viper-delete', function() {
            var cell  = self.getActiveCell();
            var table = self.getCellTable(cell);
            self._buttonClicked = true;
            self.removeCol(cell);
            self.hideToolbar();
            self.removeHighlights();

            self._setCaretToStart(table);
        });
        this._toolbarWidget.addButton(removeCol);

        dfx.hover(removeCol, function() {
            dfx.addClass(self._highlightElement, 'Viper-deleteOverlay');
        }, function() {
            dfx.removeClass(self._highlightElement, 'Viper-deleteOverlay');
        });

    },

    _createRowProperties: function()
    {
        var self               = this;
        var settingsContent    = document.createElement('div');
        var headingChanged     = false;
        var settingsSubSection = this._toolbarWidget.makeSubSection('VTEP:rowProps:settingsSubSection', settingsContent);
        var settingsButton     = this._tools.createButton('VTEP:rowProps:settings', '', 'Toggle Settings', 'Viper-tableSettings');
        this._toolbarWidget.addButton(settingsButton);
        this._toolbarWidget.setSubSectionButton('VTEP:rowProps:settings', 'VTEP:rowProps:settingsSubSection');
        this._toolbarWidget.setSubSectionAction('VTEP:rowProps:settingsSubSection', function() {
            if (headingChanged === true) {
                var cell    = self.getActiveCell();
                var newCell = null;
                if (self._tools.getItem('VTEP:rowProps:heading').getValue() === true) {
                    newCell = self.convertToHeader(cell, 'row');
                } else {
                    newCell = self.convertToCell(cell, 'row');
                }

                self.updateToolbar(newCell, 'row');
            }
        }, ['VTEP:rowProps:heading']);

        var heading = this._tools.createCheckbox('VTEP:rowProps:heading', 'Heading', false, function() {
            headingChanged = true;
        });
        settingsContent.appendChild(heading);

        this._tools.createButton('VTEP:rowProps:insBefore', '', 'Insert Row Before', 'Viper-addAbove', function() {
            var cell = self.getActiveCell();
            self._buttonClicked = true;
            self.insertRowBefore(cell);
            self.updateToolbar(cell, 'row');
        });
        this._tools.createButton('VTEP:rowProps:insAfter', '', 'Insert Row After', 'Viper-addBelow', function() {
            var cell = self.getActiveCell();
            self.insertRowAfter(cell);
            self.updateToolbar(cell, 'row');
        });
        var btnGroup = this._tools.createButtonGroup('VTEP:insRowButtons');
        this._tools.addButtonToGroup('VTEP:rowProps:insBefore', 'VTEP:insRowButtons');
        this._tools.addButtonToGroup('VTEP:rowProps:insAfter', 'VTEP:insRowButtons');
        this._toolbarWidget.addButton(btnGroup);

        this._tools.createButton('VTEP:rowProps:moveUp', '', 'Move Up', 'Viper-mergeUp', function() {
            var cell = self.getActiveCell();
            self._buttonClicked = true;
            self.updateToolbar(self.moveRowUp(cell), 'row');
        });
        this._tools.createButton('VTEP:rowProps:moveDown', '', 'Move Down', 'Viper-mergeDown', function() {
            var cell = self.getActiveCell();
            self._buttonClicked = true;
            self.updateToolbar(self.moveRowDown(cell), 'row');
        });
        btnGroup = this._tools.createButtonGroup('VTEP:moveRowButtons');
        this._tools.addButtonToGroup('VTEP:rowProps:moveUp', 'VTEP:moveRowButtons');
        this._tools.addButtonToGroup('VTEP:rowProps:moveDown', 'VTEP:moveRowButtons');
        this._toolbarWidget.addButton(btnGroup);

        var removeRow = this._tools.createButton('VTEP:rowProps:remove', '', 'Remove Row', 'Viper-delete', function() {
            var cell  = self.getActiveCell();
            var table = self.getCellTable(cell);
            self._buttonClicked = true;
            self.removeRow(cell);
            self.hideToolbar();
            self.removeHighlights();

            self._setCaretToStart(table);
        });
        this._toolbarWidget.addButton(removeRow);

        dfx.hover(removeRow, function() {
            dfx.addClass(self._highlightElement, 'Viper-deleteOverlay');
        }, function() {
            dfx.removeClass(self._highlightElement, 'Viper-deleteOverlay');
        });

    },

    _createTableProperties: function(cell)
    {
        var self = this;

        var settingsContent = document.createElement('div');

        // Create the settings sub section.
        var settingsSubSection = this._toolbarWidget.makeSubSection('VTEP:tableProps:settingsSubSection', settingsContent);
        var settingsButton     = this._tools.createButton('VTEP:tableProps:settings', '', 'Toggle Settings', 'Viper-tableSettings');
        this._toolbarWidget.addButton(settingsButton);
        this._toolbarWidget.setSubSectionButton('VTEP:tableProps:settings', 'VTEP:tableProps:settingsSubSection');
        this._toolbarWidget.setSubSectionAction('VTEP:tableProps:settingsSubSection', function() {
            var table = self.getCellTable(self.getActiveCell());
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
        var width = this._tools.createTextbox('VTEP:tableProps:width', 'Width', '', null, false, false, '', null, '4.5em');
        settingsContent.appendChild(width);

        // Summary.
        var tableSummary = this._tools.createTextarea('VTEP:tableProps:summary', 'Summary', '', false, '', null, '4.5em');
        settingsContent.appendChild(tableSummary);

        // Caption.
        var caption = this._tools.createCheckbox('VTEP:tableProps:caption', 'Use Caption');
        settingsContent.appendChild(caption);

        var remove = this._tools.createButton('VTEP:tableProps:remove', '', 'Remove Table', 'Viper-delete', function() {
            var table = self.getCellTable(self.getActiveCell());
            self._buttonClicked = true;
            self.removeTable(table);
            self.hideToolbar();
            self.removeHighlights();
        });
        this._toolbarWidget.addButton(remove);

        dfx.hover(remove, function() {
            dfx.addClass(self._highlightElement, 'Viper-deleteOverlay');
        }, function() {
            dfx.removeClass(self._highlightElement, 'Viper-deleteOverlay');
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

    createTableHeader: function(table)
    {
        if (dfx.getTag('thead', table).length > 0) {
            return null;
        }

        var header = document.createElement('thead');
        var tfoot  = dfx.getTag('tfoot', table);
        if (tfoot.length === 0) {
            var tbody = dfx.getTag('tbody', table);
            if (tbody.length === 0) {
                table.appendChild(header);
            } else {
                dfx.insertBefore(tbody[0], header);
            }
        } else {
            dfx.insertBefore(tfoot[0], header);
        }

        return header;

    },

    getTableHeader: function(table)
    {
        var header = dfx.getTag('thead', table);
        if (header.length === 0) {
            return null;
        }

        return header[0];

    },

    createTableBody: function(table)
    {
        if (dfx.getTag('tbody', table).length > 0) {
            return null;
        }

        var tbody = document.createElement('tbody');
        table.appendChild(tbody);

        return tbody;

    },

    getTableBody: function(table)
    {
        var tbody = dfx.getTag('tbody', table);
        if (tbody.length === 0) {
            return null;
        }

        return tbody[0];

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
            row = this.getNextRow(row, true);
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
            row = this.getPreviousRow(row, true);
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

        var cells = dfx.getTag('td,th', table);
        if (cells.length === 1) {
            this.setColspan(cells[0], 1);
            this.setRowspan(cells[0], 1);

            // Remove empty rows.
            var rows = dfx.getTag('tr', table);
            for (var i = 0; i < rows.length; i++) {
                if (dfx.getTag('td,th', rows[i]).length === 0) {
                    dfx.remove(rows[i]);
                }
            }
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
    convertToHeader: function(cell, type, actualType)
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

            if (!actualType || actualType === 'cell') {
                this.tableUpdated();
            }
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
                    var newElement = this.convertToHeader(colCell, 'cell', 'col');
                    if (cell === colCell) {
                        elem = newElement;
                    }
                }
            }

            this.tableUpdated();
        } else if (type === 'row') {
            var cellPos = this.getCellPosition(cell);
            var row     = cell.parentNode;
            var cells   = this._getRowCells(row);

            // Check if row needs to move in to a THEAD tag.
            if (dfx.isTag(row.parentNode, 'thead') === false
                && !this.getPreviousRow(row, true)
            ) {
                var moveToThead = true;
                var prevRowspan = null;
                for (var i = 0; i < cells.length; i++) {
                    var rowspan = this.getRowspan(cells[i]);
                    if (prevRowspan !== null && rowspan !== prevRowspan) {
                        moveToThead = false;
                        break;
                    }

                    prevRowspan = rowspan;
                }

                if (moveToThead === true) {
                    var table = this.getRowTable(row);
                    // The row is not in thead and its the first row in tbody or tfoot.
                    var thead = this.getTableHeader(table);
                    if (!thead) {
                        thead = this.createTableHeader(table);
                    }

                    thead.appendChild(row);
                }
            }

            for (var i = 0; i < cells.length; i++) {
                var rowCell    = cells[i];
                if (!rowCell.parentNode || dfx.isTag(rowCell, 'th') === true) {
                    continue;
                }

                var newElement = this.convertToHeader(rowCell, 'cell', 'row');
                if (cell === rowCell) {
                    elem = newElement;
                }
            }

            this.tableUpdated();
        }//end if

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
    convertToCell: function(cell, type, actualType)
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

            var tableid = this.getCellTable(elem).id;
            var cellid  = elem.id;
            if (cellid && cellid.indexOf(tableid) === 0) {
                cellid = cellid.replace(tableid, '');
                if (cellid.match(/r\d+c\d+/)) {
                    elem.removeAttribute('id');
                }
            }

            dfx.remove(cell);

            if (!actualType || actualType === 'cell') {
                this.tableUpdated();
            }
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
                    var newElement = this.convertToCell(colCell, 'cell', 'col');
                    if (cell === colCell) {
                        elem = newElement;
                    }
                }
            }

            this.tableUpdated();
        } else if (type === 'row') {
            var cellPos = this.getCellPosition(cell);
            var cells   = this._getRowCells(cell.parentNode);
            var row     = cell.parentNode;

            // Check if row needs to move in to a TBODY tag.
            if (dfx.isTag(row.parentNode, 'thead') === true
                && !this.getNextRow(row, true)
            ) {
                var table = this.getRowTable(row);

                // Its the last row in thead, move it down to tbody.
                var tbody = this.getTableBody(table);
                if (!tbody) {
                    tbody = this.createTableBody(table);
                    tbody.appendChild(row);
                } else {
                    var rows = dfx.getTag('tr', tbody);
                    if (rows.length === 0) {
                        tbody.appendChild(row);
                    } else {
                        dfx.insertBefore(rows[0], row);
                    }
                }
            }

            for (var i = 0; i < cells.length; i++) {
                var rowCell    = cells[i];
                if (!rowCell.parentNode || dfx.isTag(rowCell, 'td') === true) {
                    continue;
                }

                var newElement = this.convertToCell(rowCell, 'cell', 'row');
                if (cell === rowCell) {
                    elem = newElement;
                }
            }

            this.tableUpdated();
        }//end if

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

        if (table.getAttribute('style') === '') {
            table.removeAttribute('style');
        }

        this.tableUpdated(table);

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
        this._initCell(elem);

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
        this._initCell(newCell);
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
                this._initCell(newCell);

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
                this._initCell(newCell);

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

        this.tableUpdated(table);

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
                this._initCell(td);

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
                this._initCell(td);

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

        this.tableUpdated(table);

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
                this._initCell(cell);
                child = cell.firstChild;
            }

            // IE cannot jump between cells, so select the node first and then adjust
            // its location.
            range.selectNode(child);
            range.setEnd(child, 0);
            range.collapse(false);
            ViperSelection.addRange(range);

            this.setActiveCell(cell);
            this.showCellToolsIcon(cell);

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

        var maxRows            = 6;
        var maxCols            = 8;
        var selectedRows       = 3;
        var selectedCols       = 4;
        var selectedHeaderType = 2;

        var content    = '';
        var sizePicker = '<p class="VTEP-bubble-label Viper-sizeLabel">Size (' + selectedCols + ' x ' + selectedRows + ')</p>';
        sizePicker    += '<table class="VTEP-bubble-table Viper-sizePicker"><tbody>';
        for (var i = 0; i < maxRows; i++) {
            sizePicker += '<tr>';
            for (var j = 0; j < maxCols; j++) {
                var classAttr = '';
                if (selectedRows > i && selectedCols > j) {
                    classAttr = ' class="Viper-selected"';
                }

                sizePicker += '<td data-viper-rowcol="' + i + ', ' + j + '"' + classAttr + ' ></td>';
            }

            sizePicker += '</tr>';
        }

        sizePicker += '</tbody></table>';
        content    += sizePicker;

        var headerOpts      = this._headerOptions;
        var headerOptTitles = ['None', 'Left', 'Top', 'Both'];
        var headers = '<p class="VTEP-bubble-label Viper-headers">Headers</p><div class="VTEP-bubble-headersWrapper">';
        for (var h = 0; h < headerOpts.length; h++) {
            var selected = '';
            if (h === selectedHeaderType) {
                selected = ' Viper-selected';
            }

            headers    += '<div class="VTEP-bubble-headersTableWrapper' + selected + '">';
            headers    += '<table class="VTEP-bubble-table Viper-headers"><tbody>';
            var c = 0;
            for (var i = 0; i < 3; i++) {
                headers += '<tr>';
                for (var j = 0; j < 3; j++) {
                    if (headerOpts[h] && headerOpts[h][c]) {
                        headers += '<td class="Viper-hover"></td>';
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

        var trs = dfx.getTag('tr', dfx.getClass('Viper-sizePicker', main)[0]);

        var _setRowColsActive = function(row, col) {
            selectedRows = (parseInt(row) + 1);
            selectedCols = (parseInt(col) + 1);

            dfx.setHtml(dfx.getClass('Viper-sizeLabel', main)[0], 'Size (' + selectedCols + ' x ' + selectedRows + ')');

            for (var i = 0; i < maxRows; i++) {
                for (var j = 0; j < maxCols; j++) {
                    if (i <= row && j <= col) {
                        dfx.addClass(trs[i].childNodes[j], 'Viper-selected');
                    } else {
                        dfx.removeClass(trs[i].childNodes[j], 'Viper-selected');
                    }
                }
            }
        };

        var _setRowColsHover = function(row, col) {

            dfx.setHtml(dfx.getClass('Viper-sizeLabel', main)[0], 'Size (' + (parseInt(col) + 1) + ' x ' + (parseInt(row) + 1) + ')');

            for (var i = 0; i < maxRows; i++) {
                for (var j = 0; j < maxCols; j++) {
                    if (i <= row && j <= col) {
                        dfx.addClass(trs[i].childNodes[j], 'Viper-hover');
                    } else {
                        dfx.removeClass(trs[i].childNodes[j], 'Viper-hover');
                    }
                }
            }
        };

        var tdHover        = null;
        var sizePickerElem = dfx.getClass('Viper-sizePicker', main)[0];
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
            dfx.removeClass(dfx.getClass('Viper-hover', sizePickerElem), 'Viper-hover');
            dfx.setHtml(dfx.getClass('Viper-sizeLabel', main)[0], 'Size (' + selectedRows + ' x ' + selectedCols + ')');
        })

        var headerTables       = dfx.getClass('VTEP-bubble-headersTableWrapper', main);
        for (var i = 0; i < headerTables.length; i++) {
            (function(type) {
                dfx.addEvent(headerTables[type], 'click', function(e) {
                    selectedHeaderType = type;
                    dfx.removeClass(headerTables, 'Viper-selected');
                    dfx.addClass(headerTables[type], 'Viper-selected');
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

    insertTable: function(rows, cols, headerType, tableid)
    {
        this.viper.ViperHistoryManager.begin();

        rows = rows || 3;
        cols = cols || 3;

        var table = document.createElement('table');
        // First hide the table so we can determine if there are borders etc.
        dfx.setStyle(table, 'display', 'none');

        // Create a table id.
        if (!tableid) {
            while (!tableid) {
                tableid   = 'table' + dfx.getUniqueId().substr(-5, 5);
                var tElem = dfx.getId(tableid);
                if (tElem) {
                    tableid = null;
                }
            }
        }

        table.setAttribute('id', tableid);

        var tbody      = document.createElement('tbody');
        var firstCol   = null;
        var headerOpts = this._headerOptions;
        var thead      = null;

        if (headerType === 2 || headerType === 3) {
            thead = document.createElement('thead');
        }

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

                this._initCell(cell);

                tr.appendChild(cell);

                if (firstCol === null) {
                    firstCol = cell;
                }
            }//end for

            if (thead) {
                table.appendChild(thead);
                thead.appendChild(tr);
                thead = null;
            } else {
                tbody.appendChild(tr);
            }
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

        var col         = dfx.getTag('td,th', table)[0];
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

        this.setTableHeaders(table);

        this.viper.ViperHistoryManager.end();

        return table;

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
                var headersAttr = headers[i].getAttribute('headers');
                if (headersAttr) {
                    headersAttr = ' ' + headersAttr;
                    if (headersAttr.match(/\s[\w\d]+r\d+c\d+/)) {
                        // If this is a Viper type headers attribute then remove it.
                        headers[i].removeAttribute('headers');
                    }
                }
            }
        }

        headers = null;

        var thElements = dfx.getTag('th', table);
        if (thElements.length === 0) {
            return;
        }

        var tableId = table.getAttribute('id');

        if (!tableId) {
            while (!tableId) {
                tableId   = 'table' + dfx.getUniqueId().substr(-5, 5);
                var tElem = dfx.getId(tableId);
                if (tElem) {
                    tableId = null;
                }
            }

            table.setAttribute('id', tableId);
        }

        var tableRows = dfx.getTag('tr', table);
        for (var k = 0; k < tableRows.length; k++) {
            var row = tableRows[k];

            var cellCount = 0;
            for (var j = 0; j < row.childNodes.length; j++) {
                var cell = row.childNodes[j];

                // Skip text nodes.
                if (cell.nodeType === dfx.TEXT_NODE) {
                    continue;
                }

                if (dfx.isTag(cell, 'th') === true) {
                    // This is a table header, so figure out an ID-based representation
                    // of the cell content. We'll use this later as a basis for the ID attribute
                    // although it may be prefixed with the ID of another header to make it unique.
                    var cellid = cell.getAttribute('id');
                    if (!cellid || cellid.match(/r\d+c\d+/)) {
                        cellid = tableId + 'r' + (k + 1) + 'c' + (cellCount + 1);
                        var existingElem = dfx.getId(cellid);
                        if (existingElem) {
                            existingElem.removeAttribute('id');
                        }

                        cell.setAttribute('id', cellid);
                    }
                }

                cellCount++;
            }//end for
        }//end for

        // Get HTMLCS to give us the correct table headers...
        if (window['HTMLCS']) {
            var headers = HTMLCS.util.getCellHeaders(table);
            var c       = headers.length;
            for (var i = 0; i < c; i++) {
                var header      = headers[i];
                var headersAttr = header.cell.getAttribute('headers');
                if (!headersAttr || (' ' + headersAttr).match(/\stable\d+r\d+c\d+/)) {
                    header.cell.setAttribute('headers', header.headers);
                }
            }
        }

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

            var cell  = cells[0];
            var range = this.viper.getCurrentRange();
            var child = range._getFirstSelectableChild(cell);
            if (!child && cell.childNodes.length === 1) {
                child = cell.childNodes[0];
            }

            range.setStart(child, 0);
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

    getPreviousRow: function(row, ignorePrevParent)
    {
        var sourceRow = row;
        while (row = row.previousSibling) {
            if (row.nodeType === dfx.ELEMENT_NODE) {
                var tagName = row.tagName.toLowerCase();
                if (tagName === 'tr') {
                    return row;
                }
            }
        }

        if (ignorePrevParent !== true && dfx.isTag(sourceRow.parentNode, 'tbody') === true) {
            var rows = dfx.getTag('tr', dfx.getTag('thead', this.getRowTable(sourceRow)));
            if (rows.length > 0) {
                return rows[(rows.length - 1)];
            }
        }

    },

    getNextRow: function(row, ignoreNextParent)
    {
        var sourceRow = row;
        while (row = row.nextSibling) {
            if (row.nodeType === dfx.ELEMENT_NODE) {
                var tagName = row.tagName.toLowerCase();
                if (tagName === 'tr') {
                    return row;
                }
            }
        }

        if (ignoreNextParent !== true && dfx.isTag(sourceRow.parentNode, 'thead') === true) {
            var rows = dfx.getTag('tr', dfx.getTag('tbody', this.getRowTable(sourceRow)));
            if (rows.length > 0) {
                return rows[0];
            }
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

        if (toCell.lastChild && dfx.isTag(toCell.lastChild, 'br') === true) {
            dfx.remove(toCell.lastChild);
        }

        while (fromCell.firstChild) {
            if (dfx.isTag(fromCell.firstChild, 'br') === true) {
                dfx.remove(fromCell.firstChild);
            } else {
                toCell.appendChild(fromCell.firstChild);
            }
        }

        if (!toCell.lastChild) {
            this._initCell(toCell);
        }

    },

    isPluginElement: function(element)
    {
        if (element === this._highlightElement) {
            return true;
        }

        return false;

    },

    _initCell: function(cell)
    {
        if (this.viper.isBrowser('msie') === true) {
            dfx.setHtml(cell, '&nbsp;');
        } else {
            dfx.setHtml(cell, '<br />');
        }

    }

};
