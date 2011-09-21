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

}

ViperSourceViewPlugin.prototype = {
    init: function()
    {
        var self = this;
        this.toolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        this.toolbarPlugin.addButton('ViperSourceViewPlugin', 'sourceView', 'Show Source View', function () {
            self.toggleSourceView();
        });

    },

    showSourceView: function()
    {
        var self = this;
        if (!this._sourceView) {
            this._createSourceView(function() {
                self.showSourceView();
            });
        } else {
            this._originalSource = this.viper.getHtml();
            this._editor.getSession().setValue(this._originalSource);
            dfx.removeClass(this._sourceView, 'hidden');
            this._editor.resize();
        }

    },

    hideSourceView: function()
    {
        dfx.addClass(this._sourceView, 'hidden');

    },

    toggleSourceView: function()
    {
        if (!this._sourceView || dfx.hasClass(this._sourceView, 'hidden') === true) {
            this.showSourceView();
        } else {
            this.hideSourceView();
        }

    },

    updateContents: function(content)
    {
        var value = content || this._editor.getSession().getValue();
        this.viper.setHtml(value);

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

        var updateBtn = document.createElement('button');
        dfx.setHtml(updateBtn, 'Update');
        dfx.addClass(updateBtn, 'ViperSVP-updateBtn');
        bottom.appendChild(updateBtn);
        dfx.addEvent(updateBtn, 'click', function() {
            self.updateContents();
            self.hideSourceView();
        });

        var revertBtn = document.createElement('button');
        dfx.setHtml(revertBtn, 'Revert');
        dfx.addClass(revertBtn, 'ViperSVP-cancelBtn');
        bottom.appendChild(revertBtn);
        dfx.addEvent(revertBtn, 'click', function() {
            // Revert contents.
            self._editor.getSession().setValue(self._originalSource);
            self.updateContents(self._originalSource);
        });

        var cancelBtn = document.createElement('button');
        dfx.setHtml(cancelBtn, 'Cancel');
        dfx.addClass(cancelBtn, 'ViperSVP-cancelBtn');
        bottom.appendChild(cancelBtn);
        dfx.addEvent(cancelBtn, 'click', function() {
            // Revert contents.
            self.updateContents(self._originalSource);
            self.hideSourceView();
        });

        this._sourceView = elem;
        document.body.appendChild(this._sourceView);

        var resizeElements = function(ui) {
            dfx.setStyle(source, 'width', ui.size.width + 'px');
            dfx.setStyle(source, 'height', ui.size.height - dfx.getElementHeight(bottom) + 'px');
            self._editor.resize();
        };

        // Setup resizing.
        jQuery(elem).resizable({
                handles: 'se',
                resize: function(e, ui) {
                    resizeElements(ui);
                },
                stop: function(e, ui) {
                    resizeElements(ui);
                }
        });

        // Setup resizing.
        jQuery(elem).draggable({
        });

        this._includeAce(function() {
            var editor   = ace.edit(source);
            self._editor = editor;
            editor.setTheme("ace/theme/twilight");
            var HTMLMode = require("ace/mode/html").Mode;
            editor.getSession().setMode(new HTMLMode());
            callback.call(this);

            editor.getSession().addEventListener("tokenizerUpdate", function() {
                // Update page content.
                self.updateContents();
            });
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

            dfx.includeScripts(scripts, callback);
        }

    }


};
