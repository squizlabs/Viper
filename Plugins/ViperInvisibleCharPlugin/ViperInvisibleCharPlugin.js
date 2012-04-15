function ViperInvisibleCharPlugin(viper)
{
    this.viper = viper;

    this._showHiddenChars = false;

}

ViperInvisibleCharPlugin.prototype = {

    init: function()
    {
        this._initToolbar();

        var self = this;
        this.viper.registerCallback('Viper:keyPress', 'ViperInvisibleCharPlugin', function(e) {
            if (self._showHiddenChars === false) {
                return;
            } else if (e.which !== 32) {
                // Make sure we are not in a space span.
                var range     = self.viper.getViperRange();
                var startNode = range.getStartNode();
                if (startNode.nodeType === dfx.TEXT_NODE && dfx.isTag(startNode.parentNode, 'span') === true) {
                    var textNode = document.createTextNode(String.fromCharCode(e.which));
                    dfx.insertAfter(startNode.parentNode, textNode);
                    range.setStart(textNode, 1);

                    range.collapse(true);
                    ViperSelection.addRange(range);
                    return false;
                }

                return;
            }

            var range = self.viper.getViperRange();
            if (range.collapsed !== true) {
                return;
            }

            var startNode = range.getStartNode();
            if (!startNode || startNode.nodeType !== dfx.TEXT_NODE) {
                return;
            }

            var text   = startNode.data;
            var offset = range.startOffset;
            if (offset === 0 || (offset === 1 && dfx.isTag(startNode.parentNode, 'span') === true)) {
                if (offset === 0) {
                    if (!startNode.previousSibling || dfx.isTag(startNode.previousSibling, 'span') === false) {
                        return;
                    }

                    var span = document.createElement('span');
                    dfx.addClass(span, 'VICP');
                    dfx.setHtml(span, '&nbsp;');
                    dfx.insertAfter(startNode.previousSibling, span);
                } else {
                    // Chrome..
                    var span = document.createElement('span');
                    dfx.addClass(span, 'VICP');
                    dfx.setHtml(span, '&nbsp;');
                    dfx.insertAfter(startNode.parentNode, span);

                    range.setStart(span.nextSibling, 0);
                    range.collapse(true);
                    ViperSelection.addRange(range);
                }//end if

                return false;
            } else if (text.charCodeAt(offset - 1) === 32 || text.charCodeAt(offset - 1) === 160) {
                var nextNode = startNode.splitText(offset);
                var span     = document.createElement('span');
                dfx.addClass(span, 'VICP');
                dfx.setHtml(span, '&nbsp;');
                dfx.insertBefore(nextNode, span);

                range.setStart(nextNode, 0);
                range.collapse(false);
                ViperSelection.addRange(range);

                return false;
            }//end if
        });

    },

    _initToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        var self  = this;
        var tools = this.viper.ViperTools;

        var btn = tools.createButton('showHiddenChars', '', 'Toggle Hidden Characters', 'Viper-showHiddenChars', function() {
            if (self._showHiddenChars === false) {
                self._showHiddenChars = true;
                self.showHiddenChars();
                tools.setButtonActive('showHiddenChars');
            } else {
                self._showHiddenChars = false;
                self.hideHiddenChars();
                tools.setButtonInactive('showHiddenChars');
            }
        });
        toolbar.addButton(btn);

    },

    showHiddenChars: function()
    {
        var html = this.viper.getHtml();

        html = html.replace(/&nbsp;/mg, '<span class="VICP">&nbsp;</span>');
        html = html.replace(/ <span class="VICP">&nbsp;<\/span>/mg, '<span class="VICP">&nbsp;</span><span class="VICP">&nbsp;</span>');
        this.viper.setHtml(html);

    },

    hideHiddenChars: function()
    {
        var html = this.viper.getHtml();
        html     = html.replace(/<span class="VICP">&nbsp;<\/span>/mg, '&nbsp');
        this.viper.setHtml(html);

    }

};
