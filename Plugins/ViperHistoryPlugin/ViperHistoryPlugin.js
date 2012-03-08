/**
 * JS Class for the Viper Redo Plugin.
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
 * @package    Viper
 * @author     Squiz Pty Ltd <products@squiz.net>
 * @copyright  2010 Squiz Pty Ltd (ACN 084 670 600)
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPLv2
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
            tools.createButton('undo', '', 'Undo', 'historyUndo', function() {
                return self.handleUndo();
            });
            tools.createButton('redo', '', 'Redo', 'historyRedo', function() {
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
