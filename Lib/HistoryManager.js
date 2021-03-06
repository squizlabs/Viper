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

(function(ViperUtil, ViperSelection) {
    Viper.HistoryManager = function(viper)
    {
        this.viper = viper;

        this.undoHistory    = [];
        this.redoHistory    = [];
        this.batchCount     = 0;
        this.batchTask      = null;
        this.historyStore   = {};
        this._activeElement = null;
        this.historyLimit   = 30;
        this._ignoreAdd     = false;
        this._maxChars      = 50;
        this._charCount     = 0;
        this._lastAction    = null;

    }

    Viper.HistoryManager.prototype = {

        /**
         * Creates a new undo task.
         *
         * @param string source  The source of the action.
         * @param string action  Type of the action.
         */
        add: function(source, action)
        {
            if (this._ignoreAdd === true) {
                return;
            }

            // If a sub element is active then do not add this change.
            if (this.viper._subElementActive === true) {
                return;
            }

            try {
                var range = this.viper.getCurrentRange();
                if (this.viper.rangeInViperBounds(range) === false) {
                    // Set the range to be the first selectable element of Viper element.
                    var child = range._getFirstSelectableChild(this.viper.getViperElement());
                    if (!child) {
                        range = null;
                    } else {
                        try {
                            range.setStart(child, 0);
                            range.collapse(true);
                        } catch (e) {
                            range = null;
                        }
                    }
                }
            } catch (e) {
                range = null;
            }

            if (!range) {
                var task  = {
                    content: this.viper.getRawHTML(),
                    range: null
                };
            } else {
                var startContainer = range.startContainer;
                if (startContainer.nodeType === ViperUtil.ELEMENT_NODE
                    && startContainer.childNodes[range.startOffset]
                    && startContainer.childNodes[range.startOffset].nodeType === ViperUtil.ELEMENT_NODE
                    && range.collapsed === true
                ) {
                    // When Viper is initialised and the element is empty the range might be set as the
                    // First block element, if it has child text node use that instead.
                    var child = range._getFirstSelectableChild(startContainer.childNodes[range.startOffset]);
                    if (child) {
                        range.setStart(child, 0);
                        range.collapse(true);
                    }
                }

                var task  = {
                    content: this.viper.getRawHTML(),
                    range: {
                        startContainer: ViperUtil.getXPath(range.startContainer),
                        endContainer: ViperUtil.getXPath(range.endContainer),
                        startOffset: range.startOffset,
                        endOffset: range.endOffset,
                        collapsed: range.collapsed
                    }
                };
            }

            var modify = false;
            if (action === 'text_change'
                && this._lastAction
                && this._lastAction.action === action
                && this._lastAction.range
                && this._lastAction.range.startOffset === (range.startOffset - 1)
                && this._lastAction.range.startContainer === range.startContainer
            ) {
                if (this._charCount < this._maxChars) {
                    modify = true;
                } else {
                    this._charCount = 0;
                }

                this._charCount++;
            } else {
                this._charCount = 0;
            }

            this._lastAction = {
                action: action,
                range: range
            };

            // If batching is active then do not add the task to undoHistory.
            if (this.batchTask === null) {
                if (modify === true) {
                    this.undoHistory[(this.undoHistory.length - 1)] = task;
                } else {
                    this.undoHistory.push(task);
                    if (this.undoHistory.length > this.historyLimit) {
                        this.undoHistory.shift();
                    }
                }

                // Reset the redo history.
                this.redoHistory = [];
            } else {
                this.batchTask = task;
            }

            this.viper.fireCallbacks('ViperHistoryManager:add');

        },

        /**
         * Undo the last task and move it from undo history to redo history.
         */
        undo: function()
        {
            if (this.viper._subElementActive === true) {
                return;
            }

            var undoLength = this.undoHistory.length;
            if (undoLength <= 1) {
                return;
            }

            this.viper.fireCallbacks('ViperHistoryManager:beforeUndo');

            // Get the current state of the content and add it to redo list.
            var range        = this.viper.getCurrentRange();

            var startPath = null;
            var endPath   = null;

            try {
                startPath = ViperUtil.getXPath(range.startContainer);
                endPath   = ViperUtil.getXPath(range.endContainer);
            } catch(e) {}

            var currentState = {
                content: this.viper.getRawHTML(),
                range: {
                    startContainer: startPath,
                    endContainer: endPath,
                    startOffset: range.startOffset,
                    endOffset: range.endOffset,
                    collapsed: range.collapsed
                }
            };

            // Add this undo to redo.
            this.redoHistory.push(currentState);

            this.undoHistory.pop();

            if (this.undoHistory.length > 0) {
                task = this.undoHistory[(this.undoHistory.length - 1)];
            }

            // Set the contents.
            this.viper.setRawHTML(task.content);

            this._selectTaskRange(task);
            this.viper.highlightToSelection();

            // Fire nodesChanged event.
            this._ignoreAdd = true;
            this.viper.resetViperRange(null);
            this.viper.fireNodesChanged([this.viper.getViperElement()]);
            this.viper.fireCallbacks('ViperHistoryManager:undo');
            this.viper.fireSelectionChanged();
            this._ignoreAdd  = false;
            this._lastAction = null;

        },

        redo: function()
        {
            if (this.viper._subElementActive === true) {
                return;
            }

            if (this.redoHistory.length === 0) {
                return;
            }

            var task = this.redoHistory.pop();

            // Add this redo to undo.
            this.undoHistory.push(task);

            // Set the contents.
            this.viper.setRawHTML(task.content);

            this._selectTaskRange(task);

            this.viper.highlightToSelection();

            // Fire nodesChanged event.
            this._ignoreAdd = true;
            this.viper.resetViperRange(null);
            this.viper.fireNodesChanged([this.viper.getViperElement()]);
            this.viper.fireCallbacks('ViperHistoryManager:redo');
            this.viper.fireSelectionChanged();
            this._ignoreAdd  = false;
            this._lastAction = null;

            return this.redoHistory.length;

        },

        /**
         * Clear the history.
         */
        clear: function()
        {
            this.undoHistory = [];
            this.redoHistory = [];
            this.batchCount  = 0;
            this.batchTask   = null;
            this._ignoreAdd  = false;
            this._lastAction = null;
            this._charCount  = 0;

            this.viper.fireCallbacks('ViperHistoryManager:clear');

        },

        setActiveElement: function(elem)
        {
            if (this._activeElement) {
                if (this.historyStore[this._activeElement] && this.historyStore[this._activeElement].element !== elem) {
                    // There is an active history alrady, save it.
                    this._saveHistory(this._activeElement);
                }
            }

            var self   = this;
            var loaded = false;
            ViperUtil.foreach(this.historyStore, function(key) {
                if (self.historyStore[key].element === elem) {
                    self._loadHistory(key);
                    loaded = true;
                    return false;
                }
            });

            if (loaded === false) {
                // Need to add a new historyStore.
                var key = ViperUtil.getUniqueId();
                this.historyStore[key] = {
                    undo: [],
                    redo: [],
                    element: elem
                };

                this._loadHistory(key);

                // Add the initial content.
                this.add();
            }

        },

        _selectTaskRange: function(task)
        {
            if (!task || !task.range) {
                return;
            }

            // Select.
            try {
                var startContainer = ViperUtil.getNodeFromXPath(task.range.startContainer);
                var endContainer   = ViperUtil.getNodeFromXPath(task.range.endContainer);
                var range = this.viper.getCurrentRange();
                range.setEnd(endContainer, task.range.endOffset);
                range.setStart(startContainer, task.range.startOffset);
                range.setEnd(endContainer, task.range.endOffset);

                if (task.range.collapsed === true) {
                    range.collapse(true);
                }

                ViperSelection.addRange(range);
            } catch (e) {}

        },

        _loadHistory: function(key)
        {
            if (this.historyStore[key]) {
                this._activeElement   = key;
                this.undoHistory      = this.historyStore[key].undo;
                this.redoHistory      = this.historyStore[key].redo;
                this.batchTask            = null;
                this.batchCount       = 0;
            }

        },

        _saveHistory: function(key)
        {
            if (this.historyStore[key]) {
                this.historyStore[key].undo = this.undoHistory;
                this.historyStore[key].redo = this.redoHistory;
            }

        },

        /**
         * Starts a new batch undo block.
         * All undo tasks added while batch undo process is active will count as a
         * single undo task.
         */
        begin: function()
        {
            this.batchCount++;
            if (this.batchTask === null) {
                 // Set batch to true so that add() will add the task to this.batch.
                this.batchTask = true;
            }

        },

        /**
         * Ends batch undo block.
         */
        end: function()
        {
            this.batchCount--;
            if (this.batchCount === 0 && this.batchTask !== null) {
                this.batchTask = null;
                if (this.batchTask !== true) {
                    this.add();
                }
            }

        },

        getUndoCount: function()
        {
            return this.undoHistory.length;

        },

        getRedoCount: function()
        {
            return this.redoHistory.length;

        }

    };

})(Viper.Util, Viper.Selection);
