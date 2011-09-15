/**
 * JS Class for the Viper Plugin Manager.
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

function ViperPluginManager(viper)
{
    this.plugins = {};
    this.pluginConstructors = {};
    this.keyPressListeners = {};
    this.activePlugin = null;
    this.pluginSets = {};
    this.activePluginSet = null;
    this.pluginsURL = '';
    this.callbacks = {};
    this.allowTextInput = false;
    this._pluginSettings = {};
    this.viper = viper;

}

ViperPluginManager.prototype = {

    getPluginNames: function()
    {
        var plugins = [];
        for (var name in this.plugins) {
            plugins.push(name);
        }

        return plugins;

    },

    /*addPluginObject: function(pluginName, pluginObj)
    {
        this.plugins[pluginName] = pluginObj;

    },*/

    addPlugin: function(name, pluginConstructor)
    {
        if (typeof pluginConstructor !== 'function') {
            throw Error('ViperPluginException: plugin must be a constructor function');
        }

        if (dfx.isset(this.pluginConstructors[name]) === false) {
            this.pluginConstructors[name] = pluginConstructor;
        }

    },

    setActivePlugin: function(name, allowTextInput)
    {
        allowTextInput      = allowTextInput || false;
        this.activePlugin   = name;
        this.allowTextInput = allowTextInput;

    },

    getActivePlugin: function()
    {
        return this.activePlugin;

    },

    _getPluginName: function(pluginConstructor)
    {
        var fn    = pluginConstructor.toString();
        var start = 'function '.length;
        var name  = fn.substr(start, (fn.indexOf('(') - start));
        return name;

    },

    /**
     * Removes specified plugin.
     *
     * @param {string} plugin Name of the plugin.
     *
     * @return void
     */
    removePlugin: function(plugin)
    {
        if (this.plugins[plugin]) {
            // Call the remove fn of the plugin incase it needs to do cleanup.
            this.plugins[plugin].remove();

            // Remove the keyPress listeners for this plugin.
            this.removeKeyPressListener(this.plugins[plugin]);
            this.fireCallbacks('pluginRemoved', plugin);
        }

    },

    /**
     * Returns the plugin object for specified plugin name.
     *
     * @param {string} name Name of the plugin.
     *
     * @return The Viper plugin object.
     * @type {ViperPlugin}
     */
    getPlugin: function(name)
    {
        return this.plugins[name];

    },

    /**
     * Add a new set of plugins.
     *
     * @param {string} name     Name of the plugin set (e.g. "simpleEditing").
     * @param {array}  plugins  List of plugin names that are in the set.
     *
     * @return void
     */
    addPluginSet: function(name, plugins)
    {
        if (dfx.isset(plugins) === true) {
            this.pluginSets[name] = plugins;
        } else {
            this.pluginSets[name] = [];
        }

        var c = plugins.length;
        for (var i = 0; i < c; i++) {
            var plugin = plugins[i];
            if (dfx.isset(window[plugin]) === true) {
                this.addPlugin(plugin, window[plugin]);
            } else {
                throw 'Plugin object not loaded: ' + plugin;
            }
        }

    },

    /**
     * Remove a set of plugins.
     */
    removePluginSet: function(name)
    {
        if (this.pluginSetExists(name) === true) {
            delete this.pluginSets[name];
        }

    },

    /**
     * Returns true if specified set name is valid set.
     */
    pluginSetExists: function(name)
    {
        return dfx.isset(this.pluginSets[name]);

    },

    /**
     * Enables only the plugins that are in the specified set.
     * All other plugin sets are disabled.
     *
     * @param {string} setName Name of the plugin set.
     */
    usePluginSet: function(setName)
    {
        if (this.pluginSetExists(setName) === true) {
            // Load the scripts.
            var self  = this;
            // Plugin files are loaded.
            // If there is an active plugin set then remove/disable them.
            if (self.activePluginSet !== null) {
                self._disableSet(self.activePluginSet);
            }

            // Enable the plugins in the new set.
            self._enableSet(setName);
        } else if (this.activePluginSet !== null) {
            this._disableSet(this.activePluginSet);
        }

    },

    _disableSet: function(name)
    {
        var pSetLen = this.pluginSets[name].length;
        for (var i = 0; i < pSetLen; i++) {
            var plugin = this.pluginSets[name][i];
            if (typeof plugin === 'object') {
                plugin = plugin.name;
            }

            this.disablePlugin(plugin);
        }

        this.activePluginSet = null;

    },

    _enableSet: function(name)
    {
        this.activePluginSet = name;
        var pSetLen = this.pluginSets[name].length;
        for (var i = 0; i < pSetLen; i++) {
            var plugin     = this.pluginSets[name][i];
            var pluginName = '';
            if (typeof plugin === 'object') {
                pluginName = plugin.name;
            } else {
                pluginName = plugin;
            }

            var pluginConstructor = this.pluginConstructors[pluginName];
            if (pluginConstructor) {
                var pluginObj            = new pluginConstructor(this.viper);
                this.plugins[pluginName] = pluginObj;

                // Set plugin settings.
                if (dfx.isset(plugin.settings) === true) {
                    pluginObj.setSettings(plugin.settings);
                } else if (this._pluginSettings[pluginName]) {
                    pluginObj.setSettings(this._pluginSettings[pluginName]);
                }
            }
        }//end for

        // Call the start method of the plugins.
        for (var pluginName in this.plugins) {
            if (this.plugins[pluginName].init) {
                this.plugins[pluginName].init();
            }
        }

    },

    setPluginSettings: function(pluginName, settings)
    {
        if (this.plugins[pluginName]) {
            this.plugins[pluginName].setSettings(settings);
        }

        this._pluginSettings[pluginName] = settings;

    },

    disablePlugin: function(name)
    {
        if (this.plugins[name].disable) {
            this.plugins[name].disable();
        }

    },

    isPluginElement: function(element)
    {
        for (var i in this.plugins) {
            if (this.plugins[i].isPluginElement) {
                if (this.plugins[i].isPluginElement(element) === true) {
                    return true;
                }
            }
        }

        return false;

    }

};
