function MatrixCopyPastePlugin(viper)
{
    this.viper = viper;

}

MatrixCopyPastePlugin.prototype = {
    init: function()
    {
        var tags = {
            'a': ['href'],
            'img': ['src']
        }

        var self = this;
        this.viper.registerCallback('ViperCopyPastePlugin:cleanPaste', 'MatrixCopyPastePlugin', function(data) {
            if (data.html) {
                var tmp = document.createElement('div');
                ViperUtil.setHtml(tmp, data.html);
                var found    = false;

                for (tag in tags) {
                    var attrs = tags[tag];

                    var hrefTags = ViperUtil.getTag(tag, tmp);
                    var c        = hrefTags.length;

                    for (var i = 0; i < c; i++) {
                        var hrefTag = hrefTags[i];
                        for (var atr = 0; atr < attrs.length; atr++) {
                            try {
                                var matches = hrefTag.getAttribute(attrs[atr]).match(/\/\?a=\d+.*/);
                                if (!matches) {
                                    continue;
                                }

                                hrefTag.setAttribute(attrs[atr], '.' + matches[0]);
                                found        = true;
                            } catch (ex) {
                                // Ignore any exceptions due to lack of attribute
                            }//end try
                        }//end for
                    }//end for
                }//end for

                if (found === true) {
                    return ViperUtil.getHtml(tmp);
                }
            }
        });
    }

};
