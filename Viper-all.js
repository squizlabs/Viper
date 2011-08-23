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

// Viper core files.
var jsFiles = 'Viper.js|ViperChangeTracker.js|ViperDOMRange.js|ViperElementMetrics.js|ViperIERange.js|ViperMozRange.js|ViperPluginManager.js|ViperSelection.js|ViperTextMetrics.js|ViperUndoManager.js|XPath.js';
jsFiles     = jsFiles.split('|');
for (var j = 0; j < jsFiles.length; j++) {
    document.write('<script type="text/javascript" src="../../' + jsFiles[j] + '"></script>');
}
document.write('<style type="text/css">@import url("../../viper.css");</style>');

// Viper default plugins.
var plugins    = 'ViperCopyPastePlugin|ViperCoreStylesPlugin|ViperFormatPlugin|ViperKeyboardEditorPlugin|ViperListPlugin|ViperRedoPlugin|ViperTableEditorPlugin|ViperToolbarPlugin|ViperTrackChangesPlugin';
plugins        = plugins.split('|');
var pluginCss  = [];
var c = 0;
for (var j = 0; j < plugins.length; j++) {
    document.write('<script type="text/javascript" src="../../Plugins/' + plugins[j] + '/' + plugins[j] + '.js"></script>');
    pluginCss.push(plugins[j] + '/' + plugins[j] + '.css');
    if ((plugins.length - 1) === j || (j !== 0 && (j % 30) === 0)) {
        document.write('<style type="text/css">@import url("../../Plugins/' + pluginCss.join('");\n@import url("../../Plugins/') + '</style>');
        pluginCss = [];
    }
}

