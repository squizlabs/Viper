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

function ViperHistoryPlugin(viper)
{
    this.viper = viper;

}

ViperHistoryPlugin.prototype = {
    init: function()
    {
        var toolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (toolbarPlugin) {
            var self            = this;
            this._toolbarPlugin = toolbarPlugin;
            var tools = this.viper.ViperTools;

            var toolbarButtons = {
                undo: 'undo',
                redo: 'redo'
            };

            var btnGroup = tools.createButtonGroup('ViperHistoryPlugin:buttons');
            tools.createButton('undo', '', 'Undo', 'Viper-historyUndo', function() {
                return self.handleUndo();
            });
            tools.createButton('redo', '', 'Redo', 'Viper-historyRedo', function() {
                return self.handleRedo();
            });
            tools.addButtonToGroup('undo', 'ViperHistoryPlugin:buttons');
            tools.addButtonToGroup('redo', 'ViperHistoryPlugin:buttons');
            toolbarPlugin.addButton(btnGroup);

            tools.getItem('undo').setButtonShortcut('CTRL+Z');
            tools.getItem('redo').setButtonShortcut('CTRL+SHIFT+Z');

            this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperHistoryPlugin', function(data) {
                self._updateToolbarButtonStates(toolbarButtons);
            });

            this._updateToolbarButtonStates(toolbarButtons);

            this.viper.registerCallback(['ViperHistoryManager:add', 'ViperHistoryManager:undo', 'ViperHistoryManager:redo'], 'ViperHistoryPlugin', function(e) {
                self._updateToolbarButtonStates(toolbarButtons);
            });
        }

    },

    handleUndo: function()
    {
        this.viper.ViperHistoryManager.undo();

        return false;

    },

    handleRedo: function()
    {
        this.viper.ViperHistoryManager.redo();

        return false;

    },

    _updateToolbarButtonStates: function(toolbarButtons)
    {
        if (!this._toolbarPlugin) {
            return;
        }

        var tools = this.viper.ViperTools;
        if (this.viper.ViperHistoryManager.getUndoCount() > 1) {
            tools.enableButton(toolbarButtons.undo);
        } else {
            tools.disableButton(toolbarButtons.undo);
        }

        if (this.viper.ViperHistoryManager.getRedoCount() > 0) {
            tools.enableButton(toolbarButtons.redo);
        } else {
            tools.disableButton(toolbarButtons.redo);
        }

    }

};
