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

function ViperPluginManager(viper)
{
    this.viper           = viper;
    this._plugins        = null;
    this._pluginSettings = {};
    this._pluginSets     = {};

}

ViperPluginManager.prototype = {

    getPluginNames: function()
    {
        var plugins = [];
        for (var name in this._plugins) {
            plugins.push(name);
        }

        return plugins;

    },

    setPlugins: function(plugins, pluginSetName)
    {
        if (this._plugins) {
            for (var plugin in this._plugins) {
                this.removePlugin(plugin);
            }
        }

        if (!pluginSetName) {
            pluginSetName = '*';
        }

        this._pluginSets[pluginSetName] = plugins;
        this._pluginSettings = {};
        this._plugins        = {};

        var c = plugins.length;
        for (var i = 0; i < c; i++) {
            var pluginName     = '';
            var pluginSettings = null;
            if (typeof plugin === 'object') {
                pluginName     = plugins[i].name;
                pluginSettings = plugins[i].settings;
            } else {
                pluginName = plugins[i];
            }

            this.addPlugin(pluginName, pluginSettings, true);
        }//end for

        // Call the start method of the plugins.
        for (var pluginName in this._plugins) {
            if (this._plugins[pluginName].init) {
                this._plugins[pluginName].init();
            }
        }

    },

    createPluginSet: function(pluginSetName, plugins)
    {
        this._pluginSets[pluginSetName] = plugins;

    },

    usePluginSet: function(pluginSetName)
    {
        if (!this._pluginSets[pluginSetName]) {
            console.error('Invalid plugin set: ' + pluginSetName);
            return;
        }

        this.setPlugins(this._pluginSets[pluginSetName], pluginSetName);

    },

    addPlugin: function(pluginName, settings, batch)
    {
        var pluginConstructor = window[pluginName];
        if (dfx.isset(pluginConstructor) === true) {
            if (typeof pluginConstructor !== 'function') {
                console.error('Plugin ' + pluginName + 'must be a constructor function');
            }
        } else {
            console.error('Plugin object not loaded: ' + pluginName);
        }

        if (pluginConstructor) {
            var pluginObj            = new pluginConstructor(this.viper);
            this._plugins[pluginName] = pluginObj;

            // Set plugin settings.
            if (dfx.isset(settings) === true) {
                pluginObj.setSettings(settings);
            } else if (this._pluginSettings[pluginName]) {
                pluginObj.setSettings(this._pluginSettings[pluginName]);
            }

            if (batch !== true) {
                pluginObj.init();
            }
        }

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
     * @param {string} pluginName Name of the plugin.
     *
     * @return void
     */
    removePlugin: function(pluginName)
    {
        if (this._plugins[pluginName]) {

            // Call the remove fn of the plugin incase it needs to do cleanup.
            if (dfx.isFn(this._plugins[pluginName].remove) === true) {
                this._plugins[pluginName].remove();
            }

            // Remove registered callbacks.
            this.viper.removeCallback(null, pluginName);

            this.viper.fireCallbacks('ViperPluginManager:pluginRemoved', pluginName);

            delete this._plugins[pluginName];
        }

    },

    /**
     * Removes the specified plugins or all plugins if nothing specified.
     *
     * @param {array} pluginNames Array of plugin names. If not specified then all
     *                            plugins will be removed.
     */
    removePlugins: function(pluginNames)
    {
        if (!pluginNames) {
            for (var pluginName in this._plugins) {
                this.removePlugin(pluginName);
            }
        } else {
            var c = pluginNames.length;
            for (var i = 0; i < c; i++) {
                this.removePlugin(pluginNames[i]);
            }
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
        return this._plugins[name];

    },

    getPlugins: function()
    {
        return this._plugins;

    },

    setPluginSettings: function(pluginName, settings)
    {
        if (this._plugins[pluginName]) {
            this._plugins[pluginName].setSettings(settings);
        }

        this._pluginSettings[pluginName] = settings;

    },

    disablePlugin: function(name)
    {
        if (this._plugins[name].disable) {
            this._plugins[name].disable();
        }

    },

    getPluginForElement: function(element)
    {
        for (var i in this._plugins) {
            if (this._plugins[i].isPluginElement) {
                if (this._plugins[i].isPluginElement(element) === true) {
                    return i;
                }
            }
        }

        return false;

    }

};
