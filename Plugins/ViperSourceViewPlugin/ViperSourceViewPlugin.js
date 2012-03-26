function ViperSourceViewPlugin(viper)
{
    this.viper         = viper;
    this._editor       = null;
    this._resizeHandle = null;
    this._sourceView   = null;
    this._sourceCont   = null;
    this._closeConfirm = null;

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
            var toggle = this.viper.ViperTools.createButton('sourceEditor', '', 'Toggle Source View', 'sourceView', function() {
                self.toggleSourceView();
            }, true);
            this.toolbarPlugin.addButton(toggle);

            this.viper.registerCallback('ViperToolbarPlugin:enabled', 'ViperSourceViewPlugin', function(data) {
                self.viper.ViperTools.enableButton('sourceEditor');
            });
        }

        var updateTimer = null;
        this.viper.registerCallback('Viper:nodesChanged', 'ViperSourceViewPlugin', function(nodes) {
            clearTimeout(updateTimer);
            updateTimer = setTimeout(function() {
                self.updateSourceContents();
            }, 250);
        });

        this.viper.registerCallback(['Viper:editableElementChanged', 'Viper:disabled'], 'ViperSourceViewPlugin', function(nodes) {
            self.hideSourceView();
        });

    },

    isSourceChanged: function()
    {
        if (this._originalSource === this._editor.getSession().getValue()) {
            return false;
        }

        return true;

    },

    showSourceView: function(content, callback)
    {
        var self = this;
        if (!this._sourceView) {
            this._createSourceView(function() {
                if (!content) {
                    content = self.getContents();
                }

                self._originalSource = content;
                self.showSourceView(content, callback);
            });
        } else {
            if (!content) {
                content = this.getContents();
            } else {
                content = StyleHTML(content);
            }

            this._originalSource = content;

            this._editor.getSession().setValue(content);

            this.viper.ViperTools.openPopup('VSVP:popup', 800, 600);
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
        } else if (this._sourceView) {
            this.viper.ViperTools.closePopup('VSVP:popup');
        }

    },

    toggleSourceView: function()
    {
        if (!this._sourceView || !this._sourceView.parentNode) {
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
        var value = content || this.getContents();
        this._editor.getSession().setValue(value);

    },

    _createSourceView: function(callback)
    {
        var self  = this;
        var tools = this.viper.ViperTools

        var content      = document.createElement('div');

        // Confirm change panel.
        var popupTop = document.createElement('div');
        dfx.addClass(popupTop, 'VSVP-confirmPanel');
        var discardButton = tools.createButton('VSVP:discard', 'Discard', 'Discard Changes', 'VSVP-confirmButton-discard', function() {
            self.viper.ViperTools.closePopup('VSVP:popup', 'discardChanges');
        });
        var applyButton   = tools.createButton('VSVP:apply', 'Apply Changes', 'Apply Changes', 'VSVP-confirmButton-apply', function() {
            self.updatePageContents();
            self.viper.ViperTools.closePopup('VSVP:popup', 'applyChanges');
        });
        dfx.setHtml(popupTop, '<div class="VSVP-confirmText">Would you like to apply your changes?</div>');
        popupTop.appendChild(applyButton);
        popupTop.appendChild(discardButton);
        this._closeConfirm = popupTop;

        var source = document.createElement('div');
        dfx.addClass(source, 'VSVP-source');
        content.appendChild(source);
        this._sourceCont = source;

        // Add the bottom section.
        var popupBottom = document.createElement('div');
        dfx.addClass(popupBottom, 'VSVP-bottomPanel');
        var newWindowButton   = tools.createButton('VSVP:newWindow', '', 'Open In new window', 'VSVP-bottomPanel-newWindow sourceNewWindow', function() {
            self.openInNewWindow();
        });
        var applyButtonBottom = tools.createButton('VSVP:apply', 'Apply Changes', 'Apply Changes', 'VSVP-bottomPanel-apply', function() {
            self.updatePageContents();
            self.viper.ViperTools.closePopup('VSVP:popup', 'applyChanges');
        });
        popupBottom.appendChild(newWindowButton);
        popupBottom.appendChild(applyButtonBottom);

        // Create the popup.
        this._sourceView = tools.createPopup(
            'VSVP:popup',
            'Source Editor',
            popupTop,
            content,
            popupBottom,
            'VSVP-popup',
            true,
            true,
            null,
            function(closer) {
                // Close callback.
                if (closer !== 'discardChanges' && closer !== 'applyChanges') {
                    // If there are changes prevent popup from closing.
                    if (self.isSourceChanged() === true) {
                        self.showCloseConfirm();
                        return false;
                    }
                }

                // Hide the Confirm message.
                self.viper.ViperTools.getItem('VSVP:popup').hideTop();
            },
            function() {
                // Resize callback.
                self._editor.resize();
            }
        );

        this._includeAce(function() {
            // Setup the Ace editor.
            var editor   = ace.edit(source);
            self._editor = editor;

            self.applyEditorSettings(editor);

            // Init editor events.
            self.initEditorEvents(editor);

            callback.call(this);
        });

    },

    applyEditorSettings: function(editor)
    {
        editor.setTheme("ace/theme/viper");
        var HTMLMode = require("ace/mode/html").Mode;
        editor.getSession().setMode(new HTMLMode());

        // Use wrapping.
        editor.getSession().setUseWrapMode(true);

        // Do not show the print margin.
        editor.renderer.setShowPrintMargin(false);

        // Highlight the active line.
        editor.setHighlightActiveLine(true);

        // Show invisible characters
        editor.setShowInvisibles(true);
        editor.renderer.$textLayer.EOL_CHAR = String.fromCharCode(8629);

        // Set the selection style to be line (other option is 'text').
        editor.setSelectionStyle('line');

        // Always show the horizontal scrollbar.
        editor.renderer.setHScrollBarAlwaysVisible(true);

        // Use spaces instead of tabs.
        editor.getSession().setUseSoftTabs(true);

    },

    showCloseConfirm: function()
    {
        this.viper.ViperTools.getItem('VSVP:popup').showTop();

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
            } else if (self._inNewWindow === true) {
                self.updatePageContents();
            }
        });

        var popup = self.viper.ViperTools.getItem('VSVP:popup');
        // If the ESC key is pressed close the popup.
        editor.getKeyboardHandler().addKeyboardHandler({
            handleKeyboard: function(data, hashId, keyString) {
                if (keyString === 'esc') {
                    self.viper.ViperTools.closePopup('VSVP:popup');
                } else {
                    popup.hideTop();
                }
            }
        });

        var onFocus = editor.onFocus;
        editor.onFocus = function() {
            onFocus.call(editor);
            setTimeout(function() {
                popup.hideTop();
            }, 200);
        }

    },

    _includeAce: function(callback)
    {
        var path = this.viper.getViperPath();
        if (!path) {
            callback.call(this);
        } else {
            var scripts  = [];

            var acePath =  path + '/Plugins/ViperSourceViewPlugin/Ace';
            scripts.push(acePath + '/src/ace.js');
            scripts.push(acePath + '/src/theme-viper.js');
            scripts.push(acePath + '/src/mode-html.js');

            // Include JSBeautifier.
            scripts.push(path + '/Plugins/ViperSourceViewPlugin/jsbeautifier.js');

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

        var childWindow = window.open('about:blank', "Viper Source View", "width=850,height=800,0,status=0,scrollbars=0");
        childWindow.document.write(this._getFrameContent(viperid));
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

    _getFrameContent: function(viperid)
    {
        var path    = this.viper.getViperPath();
        var content = '';

        content += '<!DOCTYPE html><html lang="en"><head>';
        content += '<meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
        content += '<title>Viper Source View</title>';
        content += '<style type="text/css" media="screen">body {overflow: hidden;}</style>';

        if (!path) {
            var viperPath = this.getViperURL();
            content += '<link href="' + viperPath + 'viper.css" media="screen" rel="stylesheet" />';
            content += '<script src="' + viperPath + 'viper.js" type="text/javascript" charset="utf-8"></script></head>';
        } else {
            content += '<link href="' + path + '/Css/viper_tools.css" media="screen" rel="stylesheet" />';
            content += '<link href="' + path + '/Plugins/ViperSourceViewPlugin/ViperSourceViewPlugin.css" media="screen" rel="stylesheet" />';
            content += '<script src="' + path + '/Plugins/ViperSourceViewPlugin/Ace/src/ace.js" type="text/javascript" charset="utf-8"></script>';
            content += '<script src="' + path + '/Plugins/ViperSourceViewPlugin/Ace/src/theme-viper.js" type="text/javascript" charset="utf-8"></script>';
            content += '<script src="' + path + '/Plugins/ViperSourceViewPlugin/Ace/src/mode-html.js" type="text/javascript" charset="utf-8"></script>';
        }

        content += '<body id="ViperSourceViewPlugin-window" class="ViperSourceViewPlugin-window">';
        content += '<div class="Viper-popup themeDark VSVP-popup">';
        content += '<div class="VSVP-confirmPanel Viper-popup-top">';
        content += '<div class="VSVP-confirmText">Changes you make to the source code will be reflected in your edit preview window in real time.</div>';
        content += '<div class="Viper-button" title="Close Changes" onclick="window.close();">Close Window</div></div>';
        content += '<div class="Viper-popup-content"><pre id="editor"></pre></div></div>';
        content += '<script>';
        content += 'var viperid = "' + viperid + '";';
        content += 'var viperSVP = window.opener[viperid];';
        content += 'var editor = ace.edit("editor");';
        content += 'viperSVP.applyEditorSettings(editor);';
        content += 'viperSVP.initEditorEvents(editor);';
        content += 'viperSVP._editor = editor;';
        content += 'viperSVP.updateSourceContents();</script></body></html>';

        return content;

    },

    getViperURL: function()
    {
        var scripts = document.getElementsByTagName('script');
        var path    = null;
        var c       = scripts.length;
        for (var i = 0; i < c; i++) {
            if (scripts[i].src) {
                if (scripts[i].src.match(/\/viper\.js/)) {
                    return scripts[i].src.replace('/viper.js', '/');
                }
            }
        }

        return null;

    },

    getContents: function()
    {
        var html = this.viper.getHtml();

        if (window.StyleHTML) {
            html = StyleHTML(html);
        }

        return html;

    },

    isPluginElement: function(element)
    {
        if (element !== this._sourceView && dfx.isChildOf(element, this._sourceView) === false) {
            return false;
        }

        return true;

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
