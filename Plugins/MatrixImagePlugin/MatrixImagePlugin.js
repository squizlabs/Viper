function MatrixImagePlugin(viper)
{
    dfx.inherits('MatrixImagePlugin', 'ViperImagePlugin');
    ViperImagePlugin.call(this, viper);

}

MatrixImagePlugin.prototype = {

    _isInternalLink: function(url)
    {
        return /^\d+[^@]*$/.test(url);

    },

    initTopToolbar: function()
    {
        // Call the parent method.
        var contents = ViperImagePlugin.prototype.initTopToolbar.call(this);

        var self  = this;
        var tools = this.viper.ViperTools;

        var urlRow = tools.createRow('MatrixImagePlugin:urlRow', 'Viper-urlRow');

        // Insert asset picker icon next to url field.
        // Insert anchor row after URL field.
        var urlField    = tools.getItem('ViperImagePlugin:urlInput').element;
        var assetPicker = tools.createButton('MatrixImagePlugin:assetPicker', '', 'Pick Asset', 'Viper-ees-target', function() {
            self.pickAsset('ViperImagePlugin');
        });

        dfx.insertAfter(urlField, urlRow);
        urlRow.appendChild(urlField);
        urlRow.appendChild(assetPicker);

        return contents;

    },

    createInlineToolbar: function(toolbar)
    {
        // Call the parent method.
        ViperImagePlugin.prototype.createInlineToolbar.call(this, toolbar);

        var self  = this;
        var tools = this.viper.ViperTools;

        var urlRow = tools.createRow('MatrixImagePlugin:urlRow-vitp', 'Viper-urlRow');

        // Insert asset picker icon next to url field.
        // Insert anchor row after URL field.
        var urlField    = tools.getItem('vitpImagePlugin:urlInput').element;

        var assetPicker = tools.createButton('MatrixImagePlugin:assetPicker-vitp', '', 'Pick Asset', 'Viper-ees-target', function() {
            self.pickAsset('vitpImagePlugin');
        });

        dfx.insertAfter(urlField, urlRow);
        urlRow.appendChild(urlField);
        urlRow.appendChild(assetPicker);

    },

    updateImagePreview: function(url)
    {
        if (url.match(/^\.\/\?a=/)) {
            url = url.replace(/^\.\/\?a=/, '');
        }

        if (this._isInternalLink(url) === true) {
            var currentUrl = dfx.baseUrl(window.location.href);
            currentUrl     = currentUrl.replace('/_edit', '');
            currentUrl += '?a=' + url;

            url = currentUrl;
        }

        this.setPreviewContent(false, true);
        var self = this;
        dfx.getImage(url, function(img) {
            self.setPreviewContent(img);
        });
    },

    setUrlFieldValue: function(url)
    {
        url = url.replace(/^\.\/\?a=/, '');
        ViperImagePlugin.prototype.setUrlFieldValue.call(this, url);

    },

    getImageUrl: function(url)
    {
        url = ViperImagePlugin.prototype.getImageUrl.call(this, url);

        if (this._isInternalLink(url) === true) {
            url = './?a=' + url;
        }

        return url;

    },

    /**
     * Pick an asset from the asset finder
     * @param {string} idPrefix         The prefix assigned to the plugin
     */
    pickAsset: function(idPrefix)
    {
        var tools       = this.viper.ViperTools;
        var urlField    = tools.getItem(idPrefix + ':urlInput'),
            altField    = tools.getItem(idPrefix + ':altInput');
        EasyEditAssetManager.getCurrentAsset(function(asset){

            var initialValue = urlField.getValue(),
                focusId = asset.id;
            if (/^[0-9]+$/.test(initialValue)) {
                focusId = initialValue;
            }// End if

            EasyEditAssetFinder.init({
                focusAssetId: focusId,
                types: ['image','thumbnail'],
                callback: function(selectedAsset){
                    if (selectedAsset.attribute('type_code') === 'image') {
                        urlField.setValue('./?a=' + selectedAsset.id,false);
                        altField.setValue(selectedAsset.attribute('alt'),false);
                    } else {
                        alert(EasyEditLocalise.translate('You have selected a %1 asset. Only image assets can be selected.',selectedAsset.attribute('type_code')));
                    }// End if
                }
            });
        });

    },

    /**
     * Check to see if the element clicked is a part of the plugin. Here we need to
     * let Viper know that anything in the asset finder launched is a part of the plugin
     * @param {object} element      The clicked element
     */
    isPluginElement: function(element)
    {
        var assetFinderOverlay = dfx.getId('ees_assetFinderOverlay');
        if (element !== this._toolbar
            && dfx.isChildOf(element, this._toolbar) === false
            && dfx.isChildOf(element, assetFinderOverlay) === false
        ) {
            return false;
        }

        return true;

    }

};