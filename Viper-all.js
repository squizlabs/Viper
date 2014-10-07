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
ViperReadyCallback = null;
(function() {
    if (!window.ViperVersion) {
        ViperVersion = null;
    }

    var scripts = document.getElementsByTagName('script');
    var path       = null;

    // Loop through all the script tags that exist in the document and find the one
    // that has included this file.
    var scriptsLen = scripts.length;
    for (var i = 0; i < scriptsLen; i++) {
        if (scripts[i].src) {
            if (scripts[i].src.match(/Viper-all\.js.*/)) {
                path = scripts[i].src.replace(/Viper-all\.js.*/,'');
                break;
            }
        }
    }

    var _loadScript = function(path, scriptName, callback, scriptNameAsPath) {
        var script = document.createElement('script');

        if (navigator.appName == 'Microsoft Internet Explorer') {
            var rv = -1;
            var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
            if (re.exec(navigator.userAgent) != null) {
                rv = parseFloat(RegExp.$1);
            }

            if (rv <= 8.0) {
                script.onreadystatechange = function() {
                    if (/^(loaded|complete)$/.test(this.readyState) === true) {
                        callback.call(window);
                    }
                };
            }
        }//end if

        script.onload = function() {
            callback.call(window);
        };

        if (scriptNameAsPath === true) {
            script.src = path + scriptName + '/' + scriptName + '.js';
        } else {
            script.src = path + scriptName;
        }

        if (ViperVersion) {
            script.src += '?v=' + ViperVersion;
        }

        if (document.head) {
            document.head.appendChild(script);
        } else {
            document.getElementsByTagName('head')[0].appendChild(script);
        }
    };
    var _loadScripts = function(path, scripts, callback, scriptNameAsPath) {
        if (scripts.length === 0) {
            callback.call(window);
            return;
        }

        var script = scripts.shift();
        _loadScript(path, script, function() {
            _loadScripts(path, scripts, callback, scriptNameAsPath);
        }, scriptNameAsPath);
    };

    // Viper core files.
    var jsFiles = 'ViperUtil.js|Viper.js|ViperTranslation.js|ViperChangeTracker.js|ViperTools.js|ViperDOMRange.js|ViperIERange.js|ViperMozRange.js|ViperSelection.js|ViperPluginManager.js|ViperHistoryManager.js';
    jsFiles     = jsFiles.split('|');

    _loadScripts(path + 'Lib/', jsFiles, function() {
        var plugins    = 'ViperCopyPastePlugin|ViperToolbarPlugin|ViperInlineToolbarPlugin|ViperCoreStylesPlugin|ViperFormatPlugin|ViperKeyboardEditorPlugin|ViperListPlugin|ViperHistoryPlugin|ViperTableEditorPlugin|ViperTrackChangesPlugin|ViperLinkPlugin|ViperAccessibilityPlugin|ViperSourceViewPlugin|ViperImagePlugin|ViperSearchReplacePlugin|ViperLangToolsPlugin|ViperCharMapPlugin|ViperCursorAssistPlugin';
        plugins        = plugins.split('|');

        _loadScripts(path + 'Plugins/', plugins.concat([]), function() {
            if (ViperReadyCallback) {
                ViperReadyCallback.call(window);
            } else {
                var maxTry = 10;
                var interval = setInterval(function() {
                    maxTry--;
                    if (ViperReadyCallback) {
                        ViperReadyCallback.call(window);
                        clearInterval(interval);
                    } else if (maxTry === 0) {
                        clearInterval(interval);
                    }
                }, 500);
            }
        }, true);


        var coreCSS = 'viper|viper_moz'.split('|');
        for (var j = 0; j < coreCSS.length; j++) {
            var link   = document.createElement('link');
            link.rel   = 'stylesheet';
            link.media = 'screen';
            link.href  = path + 'Css/' + coreCSS[j] + '.css';
            if (ViperVersion) {
                link.href += '?v=' + ViperVersion;
            }

            document.getElementsByTagName('head')[0].appendChild(link);
        }

        for (var j = 0; j < plugins.length; j++) {
            var link   = document.createElement('link');
            link.rel   = 'stylesheet';
            link.media = 'screen';
            link.href  = path + 'Plugins/' + plugins[j] + '/' + plugins[j] + '.css';
            if (ViperVersion) {
                link.href += '?v=' + ViperVersion;
            }

            document.getElementsByTagName('head')[0].appendChild(link);
        }
    });
}) ();
