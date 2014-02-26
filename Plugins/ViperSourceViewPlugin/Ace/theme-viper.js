ace.define('ace/theme/viper', ['require', 'exports', 'module' , 'ace/lib/dom'], function(require, exports, module) {
    exports.isDark = true;
    exports.cssClass = "ace-viper";
    exports.cssText = "";
    var dom = require("../lib/dom");
    dom.importCssString(exports.cssText, exports.cssClass);
});