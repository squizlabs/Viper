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
    var _plugins = {};

    Viper.PluginManager = function(viper)
    {
        this.viper           = viper;
        this._plugins        = null;
        this._pluginSettings = {};
        this._pluginSets     = {};

    }

    /**
     * Registers the specified plugin object.
     *
     * @param string   pluginName The name of the plugin.
     * @param function pluginObj  The plugin object (function). Plugins must use function prototypes.
     *
     * @return void
     */
    Viper.PluginManager.addPlugin = function(pluginName, pluginObj, inherits)
    {
        // Add the plugin information to private var that is shared by multiple Viper instances.
        // Inheritance of plugins are done when PluginManager is initialised.
        _plugins[pluginName] = {
            obj: pluginObj,
            inherits: inherits
        };

    };

    Viper.PluginManager.getClass = function(pluginName)
    {
        return _plugins[pluginName].obj;

    };

    Viper.PluginManager.prototype = {

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
                if (typeof plugins[i] === 'object') {
                    pluginName     = plugins[i].name;
                    pluginSettings = plugins[i].settings;
                } else {
                    pluginName = plugins[i];
                }

                this._usePlugin(pluginName, pluginSettings, true);
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

        usePlugin: function(pluginName, settings)
        {
            this._usePlugin(pluginName, settings);

        },

        _usePlugin: function(pluginName, settings, batch)
        {
            if (!_plugins[pluginName]) {
                return;
            }

            // If this is the first time the plugin is being initialised apply inheritance if needed.
            if (_plugins[pluginName].inherits && _plugins[pluginName].inherited !== true) {
                ViperUtil.inherits(_plugins[pluginName].obj, _plugins[_plugins[pluginName].inherits].obj);
                _plugins[pluginName].inherited = true;
            }

            var plugin = new _plugins[pluginName].obj(this.viper);
            this._plugins[pluginName] = plugin;

            // Set plugin settings.
            if (ViperUtil.isset(settings) === true) {
                pluginObj.setSettings(settings);
            } else if (this._pluginSettings[pluginName]) {
                pluginObj.setSettings(this._pluginSettings[pluginName]);
            }

            if (batch !== true) {
                pluginObj.init();
            }

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
                if (ViperUtil.isFn(this._plugins[pluginName].remove) === true) {
                    this._plugins[pluginName].remove();
                }

                // Remove registered callbacks.
                this.viper.removeCallback(null, pluginName);

                this.viper.fireCallbacks('PluginManager:pluginRemoved', pluginName);

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

        },

        isSpecialElement: function(element)
        {
            for (var i in this._plugins) {
                if (this._plugins[i].isSpecialElement) {
                    if (this._plugins[i].isSpecialElement(element) === true) {
                        return true;
                    }
                }
            }

            return false;

        },

    };

})(Viper.Util, Viper.Selection);
