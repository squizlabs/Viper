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

function ViperRedoPlugin(viper)
{
    this.viper = viper;
    var self   = this;
    this.viper.registerCallback('Viper:keyDown', 'ViperRedoPlugin', function(e) {
        if (viper.isKey(e, 'CTRL+Z') === true) {
            return self.handleUndo();
        } else if (viper.isKey(e, 'CTRL+SHIFT+Z') === true) {
            return self.handleRedo();
        }
    });

    this.viper.registerCallback(['ViperUndoManager:add', 'ViperUndoManager:undo', 'ViperUndoManager:redo'], 'ViperRedoPlugin', function(e) {
        self._updateButtonStates();
    });
}

ViperRedoPlugin.prototype = {
    start: function()
    {
        var self           = this;
        this.toolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (dfx.isset(this.toolbarPlugin) === true) {
            var name = 'Redo';

            var ctrlName = 'CTRL';
            if (navigator.platform.toLowerCase().indexOf('mac') !== false) {
                ctrlName = 'CMD';
            }

            this.toolbarPlugin.addButton(name, 'undo', 'Undo (' + ctrlName + ' + Z)', function () {
                return self.handleUndo();
            });
            this.toolbarPlugin.addButton(name, 'redo', 'Redo (' + ctrlName + ' + Y)', function () {
                return self.handleRedo();
            });
            this._updateButtonStates();
        }

    },

    handleUndo: function()
    {
        this.viper.ViperUndoManager.undo();

        return false;

    },

    handleRedo: function()
    {
        this.viper.ViperUndoManager.redo();

        return false;

    },

    _updateButtonStates: function()
    {
        if (!this.toolbarPlugin) {
            return;
        }

        if (this.viper.ViperUndoManager.getUndoCount() > 1) {
            this.toolbarPlugin.setButtonInactive('undo');
        } else {
            this.toolbarPlugin.setButtonDisabled('undo');
        }

        if (this.viper.ViperUndoManager.getRedoCount() > 0) {
            this.toolbarPlugin.setButtonInactive('redo');
        } else {
            this.toolbarPlugin.setButtonDisabled('redo');
        }

    }

};
