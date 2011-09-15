/**
 * JS Class for the Viper Toolbar Plugin.
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

function ViperToolbarPlugin(viper)
{
    this.viper = viper;
    this.toolbar       = null;
    this.buttons       = {};
    this.buttonTitles  = {};
    this.buttonEvents  = {};
    this.pluginButtons = {};
    this.createToolbar();

    var self = this;

    // During zooming hide the toolbar.
    dfx.addEvent(window, 'gesturestart', function() {
        dfx.setStyle(self.toolbar, 'display', 'none');
    });

    // Update and show the toolbar after zoom.
    dfx.addEvent(window, 'gestureend', function() {
        dfx.setStyle(self.toolbar, 'display', 'block');
    });

}

ViperToolbarPlugin.prototype = {

    setSettings: function(settings)
    {
        if (!settings) {
            return;
        }

        if (settings.parent) {
            var parent = settings.parent;
            if (typeof parent === 'string') {
                parent = dfx.getId(settings.parent);
            }

            this.setParentElement(parent);
        }

    },

    createToolbar: function()
    {
        if (this.toolbar === null) {
            var id       = this.viper.id + '-ViperToolbarPlugin';
            this.toolbar = dfx.getId(id);
            if (!this.toolbar) {
                this.toolbar    = Viper.document.createElement('div');
                this.toolbar.id = id;
                dfx.setUnselectable(this.toolbar, true);
                dfx.addClass(this.toolbar, 'ViperToolbarPlugin');

                var span = Viper.document.createElement('span');
                this.toolbar.appendChild(span);

                this._append();
            }
        } else if (dfx.getId(this.toolbar.id)) {
            this._append();
            // Apply button events again.
            for (var name in this.buttons) {
                dfx.addEvent(this.buttons[name], 'mousedown', this.buttonEvents[name]);
            }
        }//end if

    },

    setParentElement: function(parent)
    {
        dfx.setStyle(this.toolbar, 'position', 'absolute');
        dfx.setStyle(this.toolbar, 'top', '0px');
        parent.appendChild(this.toolbar);

    },

    _append: function()
    {
        if (dfx.getId('EditingContents')) {
            dfx.insertBefore(dfx.getId('EditingContents'), this.toolbar);
        } else {
            Viper.document.body.appendChild(this.toolbar);
        }

    },

    _setBgPosY: function(buttonEl, pos)
    {
        // Set the background Y dimension. Setting bg-pos-y works for IE/Safari
        // but not Firefox. Setting bg-pos works for Firefox but not IE. So both
        // are needed.
        var bgPosY = dfx.getStyle(buttonEl, 'background-position-y');
        var bgPos  = dfx.getStyle(buttonEl, 'background-position');

        if (bgPosY) {
            dfx.setStyle(buttonEl, 'background-position-y', (pos + 'px'));
        } else if (bgPos) {
            bgPos    = bgPos.split(' ');
            bgPos[1] = pos + 'px';
            dfx.setStyle(buttonEl, 'background-position', bgPos.join(' '));
        }

    },

    setButtonActive: function(button)
    {
        if (this.buttons[button]) {
            var buttonEl = this.buttons[button];
            dfx.addClass(buttonEl, 'active');
            dfx.removeClass(buttonEl, 'disabled');

            this._setBgPosY(buttonEl, -38);

            if (this.buttonTitles[button]) {
                this.buttons[button].title = this.buttonTitles[button][1];
            }
        }

    },

    setButtonInactive: function(button)
    {
        if (this.buttons[button]) {
            var buttonEl = this.buttons[button];
            dfx.removeClass(buttonEl, 'active');
            dfx.removeClass(buttonEl, 'disabled');
            this._setBgPosY(buttonEl, 0);

            if (this.buttonTitles[button]) {
                this.buttons[button].title = this.buttonTitles[button][0];
            }
        }

    },

    setButtonDisabled: function(button)
    {
        if (this.buttons[button]) {
            var buttonEl = this.buttons[button];
            dfx.addClass(buttonEl, 'disabled');
            dfx.removeClass(buttonEl, 'active');
            if (this.buttonTitles[button]) {
                this.buttons[button].title = '';
            }
        }

    },

    getIconURL: function(plugin, buttonName)
    {
        var url = '../../Plugins/ViperToolbarPlugin/transparent.png';
        return url;

    },

    /**
     * Adds a button to the toolbar.
     */
    addButton: function(plugin, name, title, actionFn)
    {
        var icon = Viper.document.createElement('img');
        dfx.setUnselectable(icon, true);
        icon.id    = 'ViperToolbarPlugin-' + name;
        icon.src   = this.getIconURL('ViperToolbarPlugin', 'transparent');
        icon.title = title;
        dfx.addClass(icon, 'ViperToolbarPlugin-button');

        var iconUrl = this.getIconURL(plugin, name);
        dfx.addClass(icon, name);

        var self = this;
        dfx.hover(icon, function() {
            self._setBgPosY(icon, -19);
        }, function() {
            if (dfx.hasClass(icon, 'active') === true) {
                self._setBgPosY(icon, -38);
            } else {
                self._setBgPosY(icon, 0);
            }
        });

        this.buttonEvents[name] = actionFn;
        dfx.addEvent(icon, 'mousedown', function(e) {
            if (dfx.hasClass(icon, 'disabled') === false && self.viper.isEnabled() !== false) {
                self.viper.fireCallbacks('toolbarButtonClicked');
                actionFn(e);
                dfx.preventDefault(e);
                return false;
            }
        });

        if (!this.pluginButtons[plugin]) {
            this.pluginButtons[plugin] = [];
        }

        this.pluginButtons[plugin].push(name);
        this.buttons[name] = icon;

        var wrapper = Viper.document.createElement('span');
        wrapper.appendChild(icon);

        this.toolbar.firstChild.appendChild(wrapper);
        this.buttonTitles[name] = [title, title];

        return wrapper;

    },

    /*setButtonShortcut: function(plugin, buttonName, keys, fn, data)
    {
        var self = this;
        this.viper.ViperPluginManager.addKeyPressListener(keys, this, function(e, evtData) {
            self.viper.fireCallbacks('toolbarButtonClicked');
            return plugin[fn].call(plugin, e, evtData);
        }, data);

    },*/

    setActiveButtonTitle: function(buttonName, title)
    {
        this.buttonTitles[name][1] = title;

    },

    remove: function()
    {
        dfx.remove(this.toolbar);

    },

    isPluginElement: function(element)
    {
        if (element !== this.toolbar && dfx.isChildOf(element, this.toolbar) === false) {
            return false;
        }

        return true;

    }

};
