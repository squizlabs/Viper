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

function ViperSourceViewPlugin(viper)
{
    this.viper         = viper;
    this._editor       = null;
    this._textEditor   = null;
    this._resizeHandle = null;
    this._sourceView   = null;
    this._sourceCont   = null;
    this._closeConfirm = null;
    this._isVisible    = false;

    this._originalSource = null;
    this._inNewWindow    = false;

    this._ignoreUpdate       = false;
    this._ignoreSourceUpdate = false;
    this._newWindowContents  = '';
    this._jqueryURL          = null;
}

ViperSourceViewPlugin.prototype = {
    init: function()
    {
        var self = this;
        this.toolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (this.toolbarPlugin) {
            var toggle = this.viper.ViperTools.createButton('sourceEditor', '', _('Toggle Source View'), 'Viper-sourceView', function() {
                self.toggleSourceView();
            }, true);
            this.toolbarPlugin.addButton(toggle);

            this.viper.registerCallback('ViperToolbarPlugin:enabled', 'ViperSourceViewPlugin', function(data) {
                self.viper.ViperTools.enableButton('sourceEditor');
            });

            this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperSourceViewPlugin', function(data) {
                self.viper.ViperTools.enableButton('sourceEditor');
            });
        }

        var updateTimer = null;
        this.viper.registerCallback('Viper:nodesChanged', 'ViperSourceViewPlugin', function(nodes) {
            clearTimeout(updateTimer);
            if (self._ignoreSourceUpdate === true) {
                self._ignoreSourceUpdate = false;
                return;
            }

            updateTimer = setTimeout(function() {
                self.updateSourceContents();
            }, 250);
        });

        this.viper.registerCallback(['Viper:editableElementChanged', 'Viper:disabled'], 'ViperSourceViewPlugin', function(nodes) {
            self.hideSourceView();
        });

    },

    setSettings: function(settings)
    {
        if (settings.jqueryURL) {
            this._jqueryURL = settings.jqueryURL;
        }

    },

    isSourceChanged: function()
    {
        var value = null;
        if (this._editor) {
            value = this._editor.getSession().getValue();
        } else if (this._textEditor) {
            value = this._textEditor.value;
        }

        if (this._originalSource === value) {
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

            if (this._editor) {
                // Set Ace editor content.
                this._editor.getSession().setValue(content);

                // Scroll to the current caret position.
                this.scrollToText('__viper_scrollpos');

                // Remove special scroll attribute from the actual content.
                self._removeScrollAttribute();

                // Remove the special scroll attribute from source view content.
                self._editor.replaceAll('', {needle: ' __viper_scrollpos="true"'});

                // Make sure the original source does not include the scroll attribute.
                self._originalSource = self._editor.getSession().getValue();

                // Show the editor.
                self.viper.ViperTools.openPopup('VSVP:popup', 800, 600);

                setTimeout(function() {
                    self._editor.resize();
                    self._editor.focus();
                    self._isVisible = true;
                }, 50);
            } else {
                this._textEditor.value = content;
                this._originalSource   = this._textEditor.value;
                this.viper.ViperTools.openPopup('VSVP:popup', 800, 600);
                this._textEditor.focus();
                this._isVisible = true;
            }

            if (callback) {
                callback.call(this);
            }
        }//end if

    },

    hideSourceView: function(newWindow)
    {
        if (this._inNewWindow === true && this._childWindow) {
            this._childWindow.close();
            this._inNewWindow = false;
            this._childWindow = false;
            ViperUtil.remove(this._sourceView);
            this._sourceView = null;
            this._editor     = null;
        } else if (this._sourceView) {
            if (newWindow === true) {
                this.viper.ViperTools.closePopup('VSVP:popup', 'discardChanges');
            } else {
                this.viper.ViperTools.closePopup('VSVP:popup');
            }
        }

    },

    toggleSourceView: function()
    {
        if (!this._sourceView || (!this._sourceView.parentNode || this._sourceView.nodeType !== ViperUtil.DOCUMENT_FRAGMENT_NODE)) {
            this.showSourceView();
        } else {
            this.hideSourceView();
        }

    },

    updatePageContents: function(content)
    {
        var value = content;
        if (!value) {
            value = this.getSourceContents();
        }

        if (this._originalSource === value) {
            return;
        }

        this.viper.setHtml(value);
        this.viper.fireSelectionChanged(null, true);

    },

    getSourceContents: function()
    {
        var value = '';
        if (this._editor) {
            value = this._editor.getSession().getValue();
        } else if (this._textEditor) {
            value = this._textEditor.value;
        }

        return value;

    },

    updateSourceContents: function(content)
    {
        if (!this._editor || this._isVisible !== true) {
            return;
        }

        this._ignoreUpdate = true;
        var value = content || this.getContents();

        if (this._editor) {
            this._editor.getSession().setValue(value);
        } else if (this._textEditor) {
            this._textEditor.value = value;
        }

    },

    updateOriginalSourceValue: function(content)
    {
        if (!content) {
            if (this._editor) {
                content = this._editor.getSession().getValue();
            } else if (this._textEditor) {
                content = this._textEditor.value;
            }
        }

        this._originalSource = content;

    },

    revertChanges: function()
    {
        this.viper.setHtml(this._originalSource);

    },

    _createSourceView: function(callback)
    {
        var self  = this;
        var tools = this.viper.ViperTools

        var content      = document.createElement('div');

        // Confirm change panel.
        var popupTop = document.createElement('div');
        ViperUtil.addClass(popupTop, 'VSVP-confirmPanel');
        var discardButton = tools.createButton('VSVP:discard', _('Discard'), _('Discard Changes'), 'VSVP-confirmButton-discard', function() {
            self.viper.ViperTools.closePopup('VSVP:popup', 'discardChanges');
        });
        var applyButton   = tools.createButton('VSVP:apply', _('Apply Changes'), _('Apply Changes'), 'VSVP-confirmButton-apply', function() {
            self.updatePageContents();
            self.viper.ViperTools.closePopup('VSVP:popup', 'applyChanges');
        });
        ViperUtil.setHtml(popupTop, '<div class="VSVP-confirmText">' + _('Would you like to apply your changes?') + '</div>');
        popupTop.appendChild(applyButton);
        popupTop.appendChild(discardButton);
        this._closeConfirm = popupTop;

        var source = document.createElement('div');
        ViperUtil.addClass(source, 'VSVP-source');
        content.appendChild(source);
        this._sourceCont = source;

        // Add the bottom section.
        var popupBottom = document.createElement('div');
        ViperUtil.addClass(popupBottom, 'VSVP-bottomPanel');

        if (ViperUtil.isBrowser('msie', '<10') === false && (this.viper.getViperPath() || this.getViperURL())) {
            var newWindowButton = tools.createButton('VSVP:newWindow', '', _('Open In new window'), 'VSVP-bottomPanel-newWindow Viper-sourceNewWindow', function() {
                self.openInNewWindow();
            });
            popupBottom.appendChild(newWindowButton);
        }

        var applyButtonBottom = tools.createButton('VSVP:apply', _('Apply Changes'), _('Apply Changes'), 'VSVP-bottomPanel-apply', function() {
            self.updatePageContents();
            self.viper.ViperTools.closePopup('VSVP:popup', 'applyChanges');
        });
        popupBottom.appendChild(applyButtonBottom);

        // Create the popup.
        this._sourceView = tools.createPopup(
            'VSVP:popup',
            _('Source Editor'),
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

                self._removeScrollAttribute();

                // Hide the Confirm message.
                self.viper.ViperTools.getItem('VSVP:popup').hideTop();
                self._isVisible = false;
                self.toolbarPlugin.enable();

                setTimeout(function() {
                    self.viper.focus();
                }, 10);
            },
            function() {
                if (self._editor) {
                    // Resize callback.
                    self._editor.resize();
                }
            }
        );

        if (ViperUtil.isBrowser('msie', '<9') === true) {
            this._includeStyleHTML(function() {
                var editor = document.createElement('textarea');
                self._textEditor = editor;
                self._sourceCont.appendChild(editor);
                callback.call(self);
            });
        } else {
            this._includeAce(function() {
                // Setup the Ace editor.
                var editor   = ace.edit(source);
                self._editor = editor;
                editor.$blockScrolling = Infinity;

                self.applyEditorSettings(editor);

                // Init editor events.
                self.initEditorEvents(editor);

                callback.call(self);
            });
        }

    },

    applyEditorSettings: function(editor)
    {
        editor.setTheme("ace/theme/viper");
        editor.getSession().setMode("ace/mode/html");

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

        if (this._editor) {
            this._editor.find(text);
            setTimeout(function() {
                var anchor = self._editor.getSelection().getSelectionAnchor();
                self._editor.clearSelection();
                if (self._editor.isRowVisible(anchor.row) === false) {
                    self._editor.scrollToRow(anchor.row);
                }

            }, 500);
        } else {
            var range = this._textEditor.createTextRange();
            if (range.findText(text) === true) {
                range.select();
                range.scrollIntoView();
            }
        }
    },

    replaceSelection: function(replacement)
    {
        if (this._editor) {
            this._editor.replace(replacement);
        } else {
            var selection = document.selection;
            selection.clear();
        }

    },

    initEditorEvents: function(editor)
    {
        var self = this;
        editor.getSession().addEventListener("change", function() {
            if (self._ignoreUpdate === true) {
                self._ignoreUpdate = false;
                return;
            } else if (self._inNewWindow === true) {
                self._ignoreSourceUpdate = true;
                self.updatePageContents();
            }
        });

        var popup = self.viper.ViperTools.getItem('VSVP:popup');

        // If the ESC key is pressed close the popup.
        editor.keyBinding.addKeyboardHandler({
            handleKeyboard: function(data, hashId, keyString, n, e) {
                if (!e) {
                    return;
                }

                if (keyString === 'esc') {
                    self.viper.ViperTools.closePopup('VSVP:popup');
                } else if (e.metaKey !== true
                    && e.ctrlKey !== true
                    && e.which !== 16
                ) {
                    popup.hideTop();
                }
            }
        });

        var onFocus = editor.onFocus;
        editor.onFocus = function() {
            if (self._inNewWindow !== true) {
                self.toolbarPlugin.disable();
            }

            onFocus.call(editor);
            setTimeout(function() {
                popup.hideTop();
            }, 200);
        }

        editor.onBlur = function() {
            if (self._inNewWindow !== true) {
                self.toolbarPlugin.enable();
            }
        };

    },

    _includeAce: function(callback)
    {
        if (window['ace']) {
            callback.call(this);
            return;
        }

        var path = this.viper.getViperPath();
        if (!path) {
            callback.call(this);
        } else {
            var scripts  = [];

            var acePath =  path + '/Plugins/ViperSourceViewPlugin/Ace';
            scripts.push(acePath + '/ace.js');
            scripts.push(acePath + '/theme-viper.js');
            scripts.push(acePath + '/mode-html.js');

            // Include JSBeautifier.
            scripts.push(path + '/Plugins/ViperSourceViewPlugin/jsbeautifier.js');

            this._includeScripts(scripts, callback);
        }

    },

    _includeStyleHTML: function(callback)
    {
        var path = this.viper.getViperPath();
        if (!path) {
            callback.call(this);
        } else {
            this._includeScripts([path + '/Plugins/ViperSourceViewPlugin/jsbeautifier.js'], callback);
        }

    },

    openInNewWindow: function()
    {
        // Hide current editor.
        this.hideSourceView(true);
        this.toolbarPlugin.enable();

        // Add this Viper plugin object to global var.
        var viperid = 'Viper-' + this.viper.getId() + '-ViperSVP';
        window[viperid] = this;

        var childWindow = window.open('about:blank', _('Viper Source View'), "width=850,height=800,0,status=0,scrollbars=0");
        this._isVisible = true;
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

    getNewWindowContents: function()
    {
        return this._newWindowContents;

    },

    _getFrameContent: function(viperid)
    {
        var path    = this.viper.getViperPath();
        var content = '';

        if (Viper.build === true) {
            path = null;
        }

        this._newWindowContents = this.getSourceContents();

        content += '<!DOCTYPE html><html lang="en"><head>';
        content += '<meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
        content += '<title>' + _('Viper Source View') + '</title>';
        content += '<style type="text/css" media="screen">body {overflow: hidden;}</style>';

        if (!path) {
            var viperPath = this.getViperURL();
            content += '<link href="' + viperPath + 'viper.css" media="screen" rel="stylesheet" />';

            if (this._jqueryURL !== null) {
                content += '<script src="' + this._jqueryURL + '" type="text/javascript" charset="utf-8"></script>';
            }

            content += '<script src="' + viperPath + 'viper.js" type="text/javascript" charset="utf-8"></script>';
        } else {
            content += '<link href="' + path + '/Css/viper_tools.css" media="screen" rel="stylesheet" />';
            content += '<link href="' + path + '/Plugins/ViperSourceViewPlugin/ViperSourceViewPlugin.css" media="screen" rel="stylesheet" />';
            content += '<script src="' + path + '/Plugins/ViperSourceViewPlugin/Ace/ace.js" type="text/javascript" charset="utf-8"></script>';
            content += '<script src="' + path + '/Plugins/ViperSourceViewPlugin/Ace/theme-viper.js" type="text/javascript" charset="utf-8"></script>';
            content += '<script src="' + path + '/Plugins/ViperSourceViewPlugin/Ace/mode-html.js" type="text/javascript" charset="utf-8"></script>';
        }

        content += '</head>';
        content += '<body id="ViperSourceViewPlugin-window" class="ViperSourceViewPlugin-window">';
        content += '<div class="Viper-popup Viper-themeDark VSVP-popup">';
        content += '<div class="VSVP-confirmPanel Viper-popup-top">';
        content += '<div class="VSVP-confirmText">' + _('Source code changes will be reflected in your edit preview window in real time.') + '</div>';
        content += '<div class="Viper-button" title="' + _('Revert Changes') + '" onclick="viperSVP.revertChanges();">' + _('Revert Changes') + '</div>';
        content += '<div class="Viper-button" title="' + _('Close Source View') + '" onclick="window.close();">' + _('Close Window') + '</div></div>';
        content += '<div class="Viper-popup-content"><pre id="editor"></pre></div></div>';
        content += '<script>';
        content += 'var viperid = "' + viperid + '";';
        content += 'var viperSVP = window.opener[viperid];';
        content += 'var editor = ace.edit("editor");';
        content += 'viperSVP.applyEditorSettings(editor);';
        content += 'viperSVP.initEditorEvents(editor);';
        content += 'viperSVP._editor = editor;';
        content += 'viperSVP.updateSourceContents(viperSVP.getNewWindowContents());';
        content += 'var editorWrapper = document.getElementById("editor").parentNode;';
        content += 'window.onresize = function() {editorWrapper.style.height = (window.innerHeight - 55) + "px";};';
        content += 'window.onresize();';
        content += '</script></body></html>';

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
                    return scripts[i].src.replace(/\/viper.js.*/, '/');
                }
            }
        }

        return null;

    },

    getContents: function()
    {
        if (this._editor) {
            // If the Ace editor is enabled then try to scroll the editor to the current caret position. This is done
            // by adding a special attribute to first parent element.
            var range = this.viper.getViperRange();
            var node = range.getStartNode();
            if (node) {
                if (node.nodeType === ViperUtil.TEXT_NODE) {
                    node = node.parentNode;
                }

                ViperUtil.attr(node, '__viper_scrollpos', 'true');
            }
        }

        var html = this.viper.getHtml(null, {emptyTableCellContent:''});

        if (window.StyleHTML) {
            html = StyleHTML(html);
        }

        return html;

    },

    isPluginElement: function(element)
    {
        if (element !== this._sourceView && ViperUtil.isChildOf(element, this._sourceView) === false) {
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
    },

    _removeScrollAttribute: function () {
        // Remove Viper scroll attribute from content.
        var elems = ViperUtil.find(this.viper.getViperElement(), '[__viper_scrollpos]');
        for (var i = 0; i < elems.length; i++) {
            ViperUtil.removeAttr(elems[i], '__viper_scrollpos');
        }

    }

};
