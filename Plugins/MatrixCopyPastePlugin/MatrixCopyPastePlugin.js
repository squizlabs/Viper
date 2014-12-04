function MatrixCopyPastePlugin(viper)
{
    ViperUtil.inherits('MatrixCopyPastePlugin', 'ViperCopyPastePlugin');
    ViperCopyPastePlugin.call(this, viper);
    this.viper = viper;

}

MatrixCopyPastePlugin.prototype = {
    init: function()
    {
        ViperCopyPastePlugin.prototype.init.call(this);

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
    },



    readPastedImage: function(file, callback)
    {
        var reader = new FileReader();
        var self = this;
        reader.onload = function (event) {
            var image = new Image();
            image.src = event.target.result;

            var matrixImagePlugin = self.viper.ViperPluginManager.getPlugin('MatrixImagePlugin');
            // store the image in temp array
            var newLength = matrixImagePlugin.storeDroppedImageToUpload(image);

            // create a preview image
            var preview_img = new Image();
            preview_img.src = matrixImagePlugin.imageToDataUri(image, image.width, image.height, 10);
            preview_img.width = image.width;
            preview_img.height = image.height;
            preview_img.className = 'Viper-imagePaste';
            preview_img.id = 'Viper-imagePaster-' + (newLength - 1);
            preview_img.setAttribute('data-filename', '');
            preview_img.setAttribute('data-id', newLength - 1);

            // insert a preview
            var range = self.viper.getViperRange();
            matrixImagePlugin._rangeToImage(range, preview_img);
        };

        reader.readAsDataURL(file);

    },

};
