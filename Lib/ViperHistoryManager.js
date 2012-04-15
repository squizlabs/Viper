function ViperHistoryManager(viper)
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

}

ViperHistoryManager.prototype = {

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

        var range = this.viper.getCurrentRange();
        if (this.viper.rangeInViperBounds(range) === false) {
            // Set the range to be the first selectable element of Viper element.
            var child = range._getFirstSelectableChild(this.viper.getViperElement());
            if (!child) {
                range = null;
            } else {
                range.setStart(child, 0);
                range.collapse(true);
            }
        }

        if (!range) {
            var task  = {
                content: this.viper.getRawHTML(),
                range: null
            };
        } else {
            var task  = {
                content: this.viper.getRawHTML(),
                range: {
                    startContainer: dfx.getPath(range.startContainer),
                    endContainer: dfx.getPath(range.endContainer),
                    startOffset: range.startOffset,
                    endOffset: range.endOffset,
                    collapsed: range.collapsed
                }
            };
        }

        var modify = false;
        if (action === 'text_change' && this._lastAction === action) {
            if (this._charCount < this._maxChars) {
                modify = true;
            } else {
                this._charCount = 0;
            }

            this._charCount++;
        } else {
            this._charCount = 0;
        }

        this._lastAction = action;

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
            startPath = dfx.getPath(range.startContainer);
            endPath   = dfx.getPath(range.endContainer);
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
        this.viper.fireNodesChanged([this.viper.getViperElement()]);
        this.viper.fireCallbacks('ViperHistoryManager:redo');
        this.viper.fireSelectionChanged();
        this._ignoreAdd  = false;
        this._lastAction = null;

        return this.redoHistory.length;

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
        dfx.foreach(this.historyStore, function(key) {
            if (self.historyStore[key].element === elem) {
                self._loadHistory(key);
                loaded = true;
                return false;
            }
        });

        if (loaded === false) {
            // Need to add a new historyStore.
            var key = dfx.getUniqueId();
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
            var startContainer = dfx.getNode(task.range.startContainer);
            var endContainer   = dfx.getNode(task.range.endContainer);
            var range = this.viper.getCurrentRange();
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
