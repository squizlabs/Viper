function MatrixImagePlugin(viper)
{
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

        // Insert asset picker icon next to url field.
        // Insert anchor row after URL field.
        var urlField    = tools.getItem('ViperImagePlugin:urlInput').element;
        var assetPicker = tools.createButton('MatrixImagePlugin:assetPicker', '', 'Pick Asset', 'ees-target', function() {
            self.pickAsset();
        });
        dfx.insertAfter(urlField, assetPicker);

        return contents;

    },

    pickAsset: function()
    {
        console.error('TODO: Show an asset picker.');
        // TODO: Show an asset picker.
        // Once the asset picker is closed populate the url field.
    }

};

dfx.inherits('MatrixImagePlugin', 'ViperImagePlugin', true);
