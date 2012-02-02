/**
 * JS Class for the Viper SourceView Plugin.
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

function ViperSourceViewPlugin(viper)
{
    this.viper         = viper;
    this._editor       = null;
    this._resizeHandle = null;
    this._sourceView   = null;
    this._sourceCont   = null;

    this._originalSource = null;
    this._inNewWindow    = false;

    this._ignoreUpdate = false;
}

ViperSourceViewPlugin.prototype = {
    init: function()
    {
        var self = this;
        this.toolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (this.toolbarPlugin) {
            this.viper.ViperTools.createButton('VSVP:toggle', '', 'Toggle Source View', 'sourceView', function() {
                self.toggleSourceView();
            });
        }

        var updateTimer = null;
        this.viper.registerCallback('Viper:nodesChanged', 'ViperSourceViewPlugin', function(nodes) {
            clearTimeout(updateTimer);
            updateTimer = setTimeout(function() {
                self.updateSourceContents();
            }, 250);
        });

    },

    showSourceView: function(content, callback)
    {
        var self = this;
        if (!this._sourceView) {
            if (!content) {
                content = this.getContents();
            }

            this._originalSource = content;

            this._createSourceView(function() {
                self.showSourceView(content, callback);
            });
        } else {
            if (!content) {
                content = this.getContents();
            }

            this._originalSource = content;

            this._editor.getSession().setValue(content);
            dfx.removeClass(this._sourceView, 'hidden');
            this._editor.resize();

            if (callback) {
                callback.call(this);
            }
        }

    },

    hideSourceView: function()
    {
        if (this._inNewWindow === true && this._childWindow) {
            this._childWindow.close();
            this._inNewWindow = false;
            this._childWindow = false;
            dfx.remove(this._sourceView);
            this._sourceView = null;
            this._editor     = null;
        } else {
            dfx.addClass(this._sourceView, 'hidden');
        }

    },

    toggleSourceView: function()
    {
        if (!this._sourceView || dfx.hasClass(this._sourceView, 'hidden') === true) {
            this.showSourceView();
        } else {
            this.hideSourceView();
        }

    },

    updatePageContents: function(content)
    {
        var value = content || this._editor.getSession().getValue();

        if (this._originalSource === value) {
            return;
        }

        this.viper.setHtml(value);

    },

    updateSourceContents: function(content)
    {
        if (!this._editor) {
            return;
        }

        this._ignoreUpdate = true;
        var value = content || this.viper.getHtml();
        this._editor.getSession().setValue(value);

    },

    _createSourceView: function(callback)
    {
        var self = this;

        var elem = document.createElement('div');
        dfx.addClass(elem, 'ViperSourceViewPlugin hidden');

        var source = document.createElement('div');
        dfx.addClass(source, 'ViperSVP-source');
        elem.appendChild(source);
        this._sourceCont = source;

        var bottom = document.createElement('div');
        dfx.addClass(bottom, 'ViperSVP-bottom');
        elem.appendChild(bottom);

        this.createSourceViewButtons(bottom, false);

        this._sourceView = elem;
        document.body.appendChild(this._sourceView);

        var resizeElements = function(ui) {
            dfx.setStyle(source, 'width', ui.size.width + 'px');
            dfx.setStyle(source, 'height', ui.size.height - dfx.getElementHeight(bottom) + 'px');
            self._editor.resize();
        };

        // Setup resizing.
        dfxjQuery(elem).resizable({
                handles: 'se',
                resize: function(e, ui) {
                    resizeElements(ui);
                },
                stop: function(e, ui) {
                    resizeElements(ui);
                }
        });

        // Setup dragging.
        //dfxjQuery(elem).draggable();

        this._includeAce(function() {
            var editor   = ace.edit(source);
            self._editor = editor;
            editor.setTheme("ace/theme/twilight");
            var HTMLMode = require("ace/mode/html").Mode;
            editor.getSession().setMode(new HTMLMode());
            self.initEditorEvents(editor);

            callback.call(this);
        });

    },

    scrollToText: function(text)
    {
        var self = this;
        this._editor.find(text);
        setTimeout(function() {
            var anchor = self._editor.getSelection().getSelectionAnchor();
            self._editor.navigateTo(anchor.row, anchor.column);
        }, 500);
    },

    replaceSelection: function(replacement)
    {
        this._editor.replace(replacement);

    },

    initEditorEvents: function(editor)
    {
        var self = this;
        editor.getSession().addEventListener("tokenizerUpdate", function() {
            if (self._ignoreUpdate === true) {
                self._ignoreUpdate = false;
                return;
            }

            // Update page content.
            self.updatePageContents();

        });

    },

    _includeAce: function(callback)
    {
        var path = this.viper.getViperPath();
        if (!path) {
            callback.call(this);
        } else {
            var scripts  = [];

            path += '/Plugins/ViperSourceViewPlugin/Ace';
            scripts.push(path + '/src/ace.js');
            scripts.push(path + '/src/theme-twilight.js');
            scripts.push(path + '/src/mode-html.js');

            this._includeScripts(scripts, callback);
        }

    },

    openInNewWindow: function()
    {
        // Hide current editor.
        this.hideSourceView();

        // Add this Viper plugin object to global var.
        var viperid = 'Viper-' + this.viper.getId() + '-ViperSVP';
        window[viperid] = this;

        var path = this.viper.getViperPath();
        path    += '/Plugins/ViperSourceViewPlugin/AceEditor.html' + '?viperid=' + viperid;
        var childWindow   = window.open(path, "Viper Source View", "width=850,height=800,0,status=0,scrollbars=1");
        this._childWindow = childWindow;
        this._inNewWindow = true;

        // Detect if the window is closed and reset SourceView..
        var interval = null;
        var self     = this;
        interval = setInterval(function() {
            if (!childWindow || childWindow.closed === true) {
                clearInterval(interval);
                self.hideSourceView();
            }
        }, 700);

    },

    createSourceViewButtons: function(wrapper, newWindow)
    {
        var self = this;

        var updateBtn = document.createElement('button');
        dfx.setHtml(updateBtn, 'Update');
        dfx.addClass(updateBtn, 'ViperSVP-updateBtn');
        wrapper.appendChild(updateBtn);
        dfx.addEvent(updateBtn, 'click', function() {
            self.updatePageContents();
            self.hideSourceView();
        });

        var revertBtn = document.createElement('button');
        dfx.setHtml(revertBtn, 'Revert');
        dfx.addClass(revertBtn, 'ViperSVP-cancelBtn');
        wrapper.appendChild(revertBtn);
        dfx.addEvent(revertBtn, 'click', function() {
            // Revert contents.
            self._editor.getSession().setValue(self._originalSource);
            self.updatePageContents(self._originalSource);
        });

        var cancelBtn = document.createElement('button');
        dfx.setHtml(cancelBtn, 'Cancel');
        dfx.addClass(cancelBtn, 'ViperSVP-cancelBtn');
        wrapper.appendChild(cancelBtn);
        dfx.addEvent(cancelBtn, 'click', function() {
            // Revert contents.
            self.updatePageContents(self._originalSource);
            self.hideSourceView();
        });

        if (newWindow !== true) {
            var newWindowBtn = document.createElement('button');
            dfx.setHtml(newWindowBtn, 'New Window');
            dfx.addClass(newWindowBtn, 'ViperSVP-cancelBtn');
            wrapper.appendChild(newWindowBtn);
            dfx.addEvent(newWindowBtn, 'click', function() {
                self.openInNewWindow();
            });
        } else {
            var backToNormalBtn = document.createElement('button');
            dfx.setHtml(backToNormalBtn, 'Back to Normal View');
            dfx.addClass(backToNormalBtn, 'ViperSVP-cancelBtn');
            wrapper.appendChild(backToNormalBtn);
            dfx.addEvent(backToNormalBtn, 'click', function() {
                var value = self._editor.getSession().getValue();
                self.hideSourceView();
                self.showSourceView(value);
            });
        }

    },

    getContents: function()
    {
        return this.viper.getHtml();

    },

    _includeScripts: function(scripts, callback)
    {
        var self = this;
        var _includeScripts = function(scripts, callback) {
            if (scripts.length === 0) {
                callback.call(this);
                return;
            }

            var script = scripts.shift();
            self._includeScript(script, function() {
                _includeScripts(scripts, callback);
            });
        };

        _includeScripts(scripts.concat([]), callback);

    },


    /**
     * Includes the specified JS file.
     *
     * @param {string}   src      The URL to the JS file.
     * @param {function} callback The function to call once the script is loaded.
     */
    _includeScript: function(src, callback) {
        var script    = document.createElement('script');
        script.onload = function() {
            script.onload = null;
            script.onreadystatechange = null;
            callback.call(this);
        };

        script.onreadystatechange = function() {
            if (/^(complete|loaded)$/.test(this.readyState) === true) {
                script.onreadystatechange = null;
                script.onload();
            }
        }

        script.src = src;

        if (document.head) {
            document.head.appendChild(script);
        } else {
            document.getElementsByTagName('head')[0].appendChild(script);
        }
    }

};
