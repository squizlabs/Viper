function ViperPluginManager(viper)
{
    this.viper              = viper;
    this.plugins            = {};
    this.pluginConstructors = {};
    this.activePlugin       = null;
    this.allowTextInput     = false;
    this._pluginSettings    = {};

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

    setPlugins: function(plugins)
    {
        var c = plugins.length;
        for (var i = 0; i < c; i++) {
            var plugin = plugins[i];
            if (dfx.isset(window[plugin]) === true) {
                this.addPlugin(plugin, window[plugin]);
            } else {
                throw new Error('Plugin object not loaded: ' + plugin);
            }
        }

        for (var i = 0; i < c; i++) {
            var plugin     = plugins[i];
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
     * @param {string} pluginName Name of the plugin.
     *
     * @return void
     */
    removePlugin: function(pluginName)
    {
        if (this.plugins[pluginName]) {

            // Call the remove fn of the plugin incase it needs to do cleanup.
            if (dfx.isFn(this.plugins[pluginName].remove) === true) {
                this.plugins[pluginName].remove();
            }

            // Remove registered callbacks.
            this.viper.removeCallback(null, pluginName);

            this.viper.fireCallbacks('ViperPluginManager:pluginRemoved', pluginName);

            delete this.plugins[pluginName];
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
            for (var pluginName in this.plugins) {
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
        return this.plugins[name];

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

    getPluginForElement: function(element)
    {
        for (var i in this.plugins) {
            if (this.plugins[i].isPluginElement) {
                if (this.plugins[i].isPluginElement(element) === true) {
                    return i;
                }
            }
        }

        return false;

    }

};
