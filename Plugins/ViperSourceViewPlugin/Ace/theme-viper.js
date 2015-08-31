ace.define('ace/theme/viper', ['require', 'exports', 'module' , 'ace/lib/dom'], function(require, exports, module) {
    exports.isDark = false;
    exports.cssClass = "ace-chrome";
    exports.cssText = "";
    var dom = require("../lib/dom");
    dom.importCssString(exports.cssText, exports.cssClass);
});
