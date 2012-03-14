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

    initToolbar: function()
    {
        // Call the parent method.
        var contents = ViperImagePlugin.prototype.initToolbar.call(this);

        var self  = this;
        var tools = this.viper.ViperTools;

        var urlRow = tools.createRow('MatrixImagePlugin:urlRow', 'urlRow');

        // Insert asset picker icon next to url field.
        // Insert anchor row after URL field.
        var urlField    = tools.getItem('ViperImagePlugin:urlInput').element;
        var assetPicker = tools.createButton('MatrixImagePlugin:assetPicker', '', 'Pick Asset', 'ees-target', function() {
            self.pickAsset();
        });

        dfx.insertAfter(urlField, urlRow);
        urlRow.appendChild(urlField);
        urlRow.appendChild(assetPicker);

        return contents;

    },

    /**
     * Pick an asset from the asset finder
     * @param {string} idPrefix         The prefix assigned to the plugin
     */
    pickAsset: function()
    {
        var tools    = this.viper.ViperTools;
        var urlField = tools.getItem('ViperImagePlugin:urlInput');
        EasyEditAssetManager.getCurrentAsset(function(asset){
            EasyEditAssetFinder.init({
                focusAssetId: asset.id,
                callback: function(selectedAsset){
                    urlField.setValue('./?a=' + selectedAsset.id,false);
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
