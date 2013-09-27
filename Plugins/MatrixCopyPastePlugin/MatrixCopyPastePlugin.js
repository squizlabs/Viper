function MatrixCopyPastePlugin(viper)
{
    this.viper = viper;

}

MatrixCopyPastePlugin.prototype = {
    init: function()
    {
        var self = this;
        this.viper.registerCallback('ViperCopyPastePlugin:cleanPaste', 'MatrixCopyPastePlugin', function(data) {
            if (data.html) {
                var tmp = document.createElement('div');
                dfx.setHtml(tmp, data.html);

                var aTags = dfx.getTag('a', tmp);
                var c     = aTags.length;
                var found = false;

                for (var i = 0; i < c; i++) {
                    var aTag    = aTags[i];
                    var matches = aTag.href.match(/\/\?a=\d+.*/);
                    if (!matches) {
                        continue;
                    }

                    aTag.href = '.' + matches[0];
                    found     = true;
                }//end for

                if (found === true) {
                    return dfx.getHtml(tmp);
                }
            }
        });
    }

};
