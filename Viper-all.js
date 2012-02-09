/**
 * JS code to include all Viper JS files.
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
 * @package    Viper
 * @author     Squiz Pty Ltd <products@squiz.net>
 * @copyright  2010 Squiz Pty Ltd (ACN 084 670 600)
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPLv2
 */
ViperReadyCallback = null;
(function() {
    dfxLoadedCallback = function() {
        var dfxScripts = document.getElementsByTagName('script');
        var path       = null;

        // Loop through all the script tags that exist in the document and find the one
        // that has included this file.
        var dfxScriptsLen = dfxScripts.length;
        for (var i = 0; i < dfxScriptsLen; i++) {
            if (dfxScripts[i].src) {
                if (dfxScripts[i].src.match(/Viper-all\.js/)) {
                    // We have found our appropriate <script> tag that includes the
                    // DfxJSLib library, so we can extract the path and include the rest.
                    path = dfxScripts[i].src.replace(/Viper-all\.js/,'');
                    break;
                }
            }
        }

        var _loadScript = function(path, scriptName, callback, scriptNameAsPath) {
            var script = document.createElement('script');
            script.onreadystatechange = function() {
                if (/^(loaded|complete)$/.test(this.readyState) === true) {
                    callback.call(window);
                }
            };

            script.onload = function() {
                callback.call(window);
            };

            if (scriptNameAsPath === true) {
                script.src = path + scriptName + '/' + scriptName + '.js';
            } else {
                script.src = path + scriptName;
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
        var jsFiles = 'Viper.js|ViperChangeTracker.js|ViperTools.js|ViperDOMRange.js|ViperIERange.js|ViperMozRange.js|ViperSelection.js|ViperPluginManager.js|ViperHistoryManager.js|XPath.js';
        jsFiles     = jsFiles.split('|');

        _loadScripts(path + '/Lib/', jsFiles, function() {
            var plugins    = 'ViperCopyPastePlugin|ViperToolbarPlugin|ViperInlineToolbarPlugin|ViperCoreStylesPlugin|ViperFormatPlugin|ViperKeyboardEditorPlugin|ViperListPlugin|ViperHistoryPlugin|ViperTableEditorPlugin|ViperTrackChangesPlugin|ViperLinkPlugin|ViperAccessibilityPlugin|ViperSourceViewPlugin|ViperImagePlugin|ViperSearchReplacePlugin|ViperLangToolsPlugin|ViperCharMapPlugin|ViperInvisibleCharPlugin';
            plugins        = plugins.split('|');

            _loadScripts(path + 'Plugins/', plugins, function() {
                if (ViperReadyCallback) {
                    ViperReadyCallback.call(window);
                }
            }, true);


            var coreCSS = 'viper|viper_moz'.split('|');
            for (var j = 0; j < coreCSS.length; j++) {
                var link   = document.createElement('link');
                link.rel   = 'stylesheet';
                link.media = 'screen';
                link.href  = path + 'Css/' + coreCSS[j] + '.css';
                document.getElementsByTagName('head')[0].appendChild(link);
            }

            for (var j = 0; j < plugins.length; j++) {
                var link   = document.createElement('link');
                link.rel   = 'stylesheet';
                link.media = 'screen';
                link.href  = path + 'Plugins/' + plugins[j] + '/' + plugins[j] + '.css';
                document.getElementsByTagName('head')[0].appendChild(link);
            }
        });
    };
}) ();
