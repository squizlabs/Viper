function MatrixLinkPlugin(viper)
{
    ViperLinkPlugin.call(this, viper);

}

MatrixLinkPlugin.prototype = {

    updateInlineToolbar: function(data)
    {
        var contents = ViperLinkPlugin.prototype.updateInlineToolbar.call(this, data);
        if (!contents) {
            return;
        }

        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');

        // Add the asset finder icon to the right side of the URL text box.
        var findAssetBtn = toolbar.createButton('X', false, 'Pick Asset', false, 'matrixAssetPicker', function() {
            // Show asset picker.
        });

        // Find the first textbox and add the asset finder button after it.
        var urlLabel = dfx.getTag('label', contents)[0];
        dfx.setStyle(urlLabel, 'float', 'left');
        dfx.insertAfter(urlLabel, findAssetBtn);

    }

};

dfx.inherits('MatrixLinkPlugin', 'ViperLinkPlugin', true);
