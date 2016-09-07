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
        this._viper           = viper;
        this._undoHistory     = [];
        this._redoHistory     = [];
        this._batchCount      = 0;
        this._batchTask       = null;
        this._historyStore    = {};
        this._activeElement   = null;
        this._historyLimit    = 30;
        this._ignoreAdd       = false;
        this._maxChars        = 30;
        this._charCount       = 0;
        this._lastAction      = null;
        this._prevContent     = null;
        this._originalContent = null;

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
            if (this._viper._subElementActive === true) {
                return;
            }

            try {
                var range = this._viper.getCurrentRange();
                if (this._viper.rangeInViperBounds(range) === false) {
                    // Set the range to be the first selectable element of Viper element.
                    var child = range._getFirstSelectableChild(this._viper.getViperElement());
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

            if (range) {
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
            }

            var rawhtml = this._viper.getRawHTML();

            if (this._prevContent === null) {
                this._originalContent = rawhtml;
                this._prevContent     = rawhtml;
            }

            var diff       = JsDiff.createPatch('content', this._prevContent, rawhtml);
            var startXPath = ViperUtil.getXPath(range.startContainer);
            var task       = {
                patch: diff,
                range: {
                    startContainer: startXPath,
                    endContainer: ViperUtil.getXPath(range.endContainer),
                    startOffset: range.startOffset,
                    endOffset: range.endOffset,
                    collapsed: range.collapsed
                }
            };

            if (action === 'text_change') {
                if (this._charCount === 0) {
                    this._charCount++;
                    this.begin();
                } else if (this._lastAction && this._lastAction.action === 'text_change') {
                    if (this._lastAction.range
                        && this._lastAction.range.startOffset === (range.startOffset - 1)
                        && this._lastAction.range.startContainer === range.startContainer
                        && this._lastAction.startXPath === startXPath
                    ) {
                        if ((this._charCount + 1) >= this._maxChars) {
                            this.end();
                            return;
                        }

                        this._charCount++;
                    } else if (this._batchTask) {
                        // End the batch operation.
                        this.end();
                        return;
                    }
                }
            } else {
                this._resetCharCount();
                if (this._batchTask && this._lastAction && this._lastAction.action === 'text_change') {
                    this.end();
                    return;
                }
            }

            this._lastAction = {
                action: action,
                range: range,
                startXPath: ViperUtil.getXPath(range.startContainer)
            };

            // If batching is active then do not add the task to undoHistory.
            if (this._batchTask === null) {
                // Update the previous content var.
                this._prevContent = rawhtml;

                this._undoHistory.push(task);
                if (this._undoHistory.length > this._historyLimit) {
                    this._undoHistory.shift();
                }

                // Reset the redo history.
                this._redoHistory = [];
            } else {
                this._batchTask = task;
            }

            this._viper.fireCallbacks('ViperHistoryManager:add');
        },

        /**
         * Undo the last task and move it from undo history to redo history.
         */
        undo: function() {
            if (this._batchTask) {
                this.end();
            }

            var undoLength = this._undoHistory.length;
            if (undoLength <= 1) {
                return;
            }

            this._viper.fireCallbacks('ViperHistoryManager:beforeUndo');

            // Get the current state of the content and add it to redo list.
            var range     = this._viper.getCurrentRange();
            var startPath = null;
            var endPath   = null;

            try {
                startPath = ViperUtil.getXPath(range.startContainer);
                endPath   = ViperUtil.getXPath(range.endContainer);
            } catch(e) {}

            this._undoHistory.pop();

            var content = this._originalContent;
            for (var i = 0; i < this._undoHistory.length; i++) {
               content = JsDiff.applyPatch(content, this._undoHistory[i].patch);
            }

            var task = null;
            if (this._undoHistory.length > 0) {
                task = this._undoHistory[(this._undoHistory.length - 1)];
            }

            var diff         = JsDiff.createPatch('content', content, this._viper.getRawHTML());
            var currentState = {
                patch: diff,
                range: {
                    startContainer: startPath,
                    endContainer: endPath,
                    startOffset: range.startOffset,
                    endOffset: range.endOffset,
                    collapsed: range.collapsed
                }
            };

            this._redoHistory.push(currentState);

            this._viper.setRawHTML(content);

            this._selectTaskRange(task);
            this._viper.highlightToSelection();

            // Fire nodesChanged event.
            this._ignoreAdd = true;
            this._viper.resetViperRange(null);
            this._viper.fireNodesChanged([this._viper.getViperElement()]);
            this._viper.fireCallbacks('ViperHistoryManager:undo');
            this._viper.fireSelectionChanged();
            this._ignoreAdd  = false;
            this._lastAction = null;
        },

        redo: function()
        {
            if (this._redoHistory.length === 0) {
                return;
            }

            var task = this._redoHistory.pop();

            // Add this redo to undo.
            this._undoHistory.push(task);

            var content = this._originalContent;
            for (var i = 0; i < this._undoHistory.length; i++) {
               content = JsDiff.applyPatch(content, this._undoHistory[i].patch);
            }

            this._viper.setRawHTML(content);

            this._selectTaskRange(task);
            this._viper.highlightToSelection();

            // Fire nodesChanged event.
            this._ignoreAdd = true;
            this._viper.resetViperRange(null);
            this._viper.fireNodesChanged([this._viper.getViperElement()]);
            this._viper.fireCallbacks('ViperHistoryManager:redo');
            this._viper.fireSelectionChanged();
            this._ignoreAdd  = false;
            this._lastAction = null;

            return this._redoHistory.length;

        },

        /**
         * Clear the history.
         */
        clear: function()
        {
            this._undoHistory = [];
            this._redoHistory = [];
            this._batchCount  = 0;
            this._batchTask   = null;
            this._ignoreAdd  = false;
            this._lastAction = null;
            this._resetCharCount();

            this._viper.fireCallbacks('ViperHistoryManager:clear');

        },

        setActiveElement: function(elem)
        {
            if (this._activeElement) {
                if (this._historyStore[this._activeElement] && this._historyStore[this._activeElement].element !== elem) {
                    // There is an active history alrady, save it.
                    this._saveHistory(this._activeElement);
                }
            }

            var self   = this;
            var loaded = false;
            ViperUtil.foreach(this._historyStore, function(key) {
                if (self._historyStore[key].element === elem) {
                    self._loadHistory(key);
                    loaded = true;
                    return false;
                }
            });

            if (loaded === false) {
                // Need to add a new historyStore.
                var key = ViperUtil.getUniqueId();
                this._historyStore[key] = {
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
                var range = this._viper.getCurrentRange();
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
            if (this._historyStore[key]) {
                this._activeElement   = key;
                this._undoHistory      = this._historyStore[key].undo;
                this._redoHistory      = this._historyStore[key].redo;
                this._batchTask            = null;
                this._batchCount       = 0;
            }

        },

        _saveHistory: function(key)
        {
            if (this._historyStore[key]) {
                this._historyStore[key].undo = this._undoHistory;
                this._historyStore[key].redo = this._redoHistory;
            }

        },

        /**
         * Starts a new batch undo block.
         * All undo tasks added while batch undo process is active will count as a
         * single undo task.
         */
        begin: function()
        {
            if (this._batchTask && this._lastAction && this._lastAction.action === 'text_change') {
                this.end();
            }

            this._batchCount++;
            if (this._batchTask === null) {
                 // Set batch to true so that add() will add the task to this.batch.
                this._batchTask = true;
            }

        },

        /**
         * Ends batch undo block.
         */
        end: function()
        {
            this._resetCharCount();
            this._lastAction = null;
            this._batchCount--;

            if (this._batchCount === 0 && this._batchTask !== null) {
                this._batchTask = null;
                this.add();
            }

        },

        getUndoCount: function()
        {
            return this._undoHistory.length;

        },

        getRedoCount: function()
        {
            return this._redoHistory.length;

        },

        isBatching: function()
        {
            if (this._batchTask) {
                return true;
            }

            return false;

        },

        _resetCharCount: function() {
            this._charCount = 0;
        }

    };

})(Viper.Util, Viper.Selection);
