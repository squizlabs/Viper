/**
 * JS Class for the Viper Undo Manager.
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

function ViperUndoManager(viper)
{
    this.viper = viper;
    this.undoHistory = [];
    this.redoHistory = [];
    this.undoHandlers = {};
    this.redoHandlers = {};
    this.batchCount = 0;
    this.batch = null;
    this._textChangeCount = 0;
    this.historyStore = {};
    this._activeElement = null;
    this.historyLimit = 30;

    this.handles      = {};
    this.undoHistory  = [];
    this.redoHisotory = [];
    this.historyStore = {};

    var self = this;
    this.registerUndoHandler('viper', function(action, data) {
        self.handleUndo(action, data);
    });

     this.registerRedoHandler('viper', function(action, data) {
        self.handleRedo(action, data);
    });

}

ViperUndoManager.prototype = {

    registerUndoHandler: function(source, callback)
    {
        this.undoHandlers[source] = callback;

    },

    registerRedoHandler: function(source, callback)
    {
        this.redoHandlers[source] = callback;

    },

    setActiveElement: function(elem)
    {
        if (this._activeElement) {
            if (this.historyStore[this._activeElement] && this.historyStore[this._activeElement].element !== elem) {
                // There is an active history alrady, save it.
                this._saveHistory(this._activeElement);
            } else {
                this.viper.fireCallbacks('ViperUndoManager:newUndoTask');
                return;
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

            // Add the initital undo task (the original content).
            this.add('viper', 'change_node');
        } else {
            this.viper.fireCallbacks('ViperUndoManager:newUndoTask');
        }

    },

    _loadHistory: function(key)
    {
        if (this.historyStore[key]) {
            this._activeElement   = key;
            this.undoHistory      = this.historyStore[key].undo;
            this.redoHistory      = this.historyStore[key].redo;
            this._textChangeCount = 0;
            this.batch            = null;
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

    getUndoHistory: function()
    {
        return this.undoHistory;

    },

    /**
     * Replaces the specified undo task with a new task.
     */
    modify: function(undoIndex, task)
    {
        this.undoHistory[undoIndex] = task;

    },

    /**
     * Starts a new batch undo block.
     * All undo tasks added while batch undo process is active will count as a
     * single undo task.
     */
    begin: function()
    {
        this.batchCount++;
        if (this.batch === null) {
             // Set batch to true so that add() will add the task to this.batch.
            this.batch = true;
        }

    },

    /**
     * Ends batch undo block.
     */
    end: function()
    {
        this.batchCount--;
        if (this.batchCount === 0 && this.batch !== null) {
            if (this.batch !== true) {
                this.undoHistory.push(this.batch);
            }

            this.batch = null;
        }

    },

    /**
     * Creates a new undo task with the specified information.
     *
     * @param string source  The source of the action.
     * @param string action  Type of the action.
     */
    add: function(source, action)
    {
        if (this.viper._subElementActive === true) {
            return;
        }

        var modify = false;
        if (action === 'text_change') {
            // This is a text node change (e.g. new char)
            // Only add a new task after 30 changes.
            this._textChangeCount++;
            if (this._textChangeCount > 1) {
                if (this._textChangeCount < 30) {
                    modify = true;
                } else {
                    this._textChangeCount = 1;
                }
            }
        } else {
            this._textChangeCount = 0;
        }

        var data = {
            content: dfx.getHtml(this.viper.element),
            range: this._getRangeInfo()
        };

        var task = {
            source: source,
            action: action,
            data: data
        };

        // If batching is active then do not add the task to undoHistory.
        if (this.batch === null) {
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
            this.batch = task;
        }

        this.viper.fireCallbacks('ViperUndoManager:newUndoTask');

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
        if (undoLength === 1) {
            return;
        }

        this._textChangeCount = 0;

        var task = this.undoHistory.pop();

        // Add this undo to redo.
        this.redoHistory.push(task);

        undoLength   = this.undoHistory.length;
        var undoTask = this.undoHistory[(undoLength - 1)];
        if (undoTask) {
            this.undoHandlers[undoTask.source].call(this, undoTask);
        }

        // Fire nodesChanged event.
        this.viper.fireCallbacks('nodesChanged');
        this.viper.fireCallbacks('ViperUndoManager:undo');

        return undoLength;

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

        this.redoHandlers[task.source].call(this, task);

        // Fire nodesChanged event.
        this.viper.fireCallbacks('nodesChanged');
        this.viper.fireCallbacks('ViperUndoManager:redo');

        return this.redoHistory.length;

    },

    getUndoCount: function()
    {
        return this.undoHistory.length;

    },

    getRedoCount: function()
    {
        return this.redoHistory.length;

    },

    handleUndo: function(task)
    {
        this.handleUndoChange(task);

    },

    handleRedo: function(task)
    {
        this.handleRedoChange(task);

    },

    /*
        Viper Core undo handlers
    */
    handleUndoChange: function(task)
    {
        if (task.data.content) {
            dfx.setHtml(this.viper.element, task.data.content);
            this._setCaretPositon(task);
        }

    },

    /*
        Viper Core redo handlers
    */

    handleRedoChange: function(task)
    {
        if (task.data.content) {
            dfx.setHtml(this.viper.element, task.data.content);
            this._setCaretPositon(task);
        }

    },

    _setCaretPositon: function(task)
    {
        if (task && task.data && task.data.range) {
            var taskRange = task.data.range;
            if (taskRange.startCont && taskRange.endCont) {
                var range = this.viper.getCurrentRange();
                try {
                    var startNode = XPath.getNode(taskRange.startCont);
                    var endNode   = XPath.getNode(taskRange.endCont);
                    if (startNode && endNode) {
                        range.setStart(startNode, taskRange.startOffset);
                        range.setEnd(endNode, taskRange.endOffset);
                        ViperSelection.addRange(range);
                        this.viper.focus();
                    }
                } catch (e) {
                }
            }
        }

    },

    createNodeChangeInfo: function(node, range)
    {
        if (!range) {
            range = this.viper.getCurrentRange();
        }

        var info = {
            before: dfx.getHtml(node),
            path: XPath.getPath(node)
        };

        try {
            if (range) {
                info.startContainer = XPath.getPath(range.startContainer);
                info.startOffset    = range.startOffset;
                info.endContainer   = XPath.getPath(range.endContainer);
                info.endOffset      = range.endOffset;
            }
        } catch(e) {};

        return info;

    },

    _getRangeInfo: function()
    {
        var rangeInfo = {};

        try {
            var range     = this.viper.getCurrentRange();
            var rangeInfo = {
                startCont: XPath.getPath(range.startContainer),
                startOffset: range.startOffset,
                endCont: XPath.getPath(range.endContainer),
                endOffset: range.endOffset
            };
        } catch(e) {};

        return rangeInfo;

    }

};
