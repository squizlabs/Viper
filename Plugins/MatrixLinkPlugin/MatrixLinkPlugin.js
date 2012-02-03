function MatrixLinkPlugin(viper)
{
    ViperLinkPlugin.call(this, viper);

}

MatrixLinkPlugin.prototype = {

    _isInternalLink: function(url)
    {
        return /^\d+[^@]*$/.test(url);

    },

    getToolbarContent: function(idPrefix)
    {
        // Call the parent method.
        var contents = ViperLinkPlugin.prototype.getToolbarContent.call(this, idPrefix);

        var self  = this;
        var tools = this.viper.ViperTools;
        var main  = tools.getItem(idPrefix + ':link').element;

        // Insert asset picker icon next to url field.
        // Insert anchor row after URL field.
        var urlField    = tools.getItem(idPrefix + ':url').element;
        var assetPicker = tools.createButton(idPrefix + ':assetPicker', '', 'Pick Asset', 'accessSettings', function() {
            self.pickAsset();
        });
        dfx.setStyle(urlField, 'float', 'left');
        dfx.insertAfter(urlField, assetPicker);

        // Create anchor field.
        var anchor = tools.createTextbox(idPrefix + ':anchor', 'Anchor', '', function() {
            self.updateLink();
        });

        var anchorRow = tools.createRow(idPrefix + ':anchorRow', 'anchorRow');
        anchorRow.appendChild(anchor);

        // Insert anchor row after URL field.
        var urlRow = tools.getItem(idPrefix + ':urlRow').element;
        dfx.insertAfter(urlRow, anchorRow);

        // The URL field needs to change the interface to internal URL interface
        // if the value is an internal URL.
        tools.setFieldEvent(idPrefix + ':url', 'keyup', function(e) {
            var urlValue = this.value;
            if (dfx.hasClass(main, 'emailLink') === false) {
                // Not an email, check if its internal URL.
                if (self._isInternalLink(urlValue) === true) {
                    // Internal URL.
                    dfx.removeClass(main, 'emailLink');
                    dfx.addClass(main, 'internalLink');
                } else {
                    dfx.removeClass(main, 'internalLink');
                }
            }
        });

        // The include summary checkbox.
        var includeSummary    = tools.createCheckbox(idPrefix + ':includeSummary', 'Include Summary');
        var includeSummaryRow = tools.createRow(idPrefix + ':includeSummaryRow', 'includeSummaryRow');
        includeSummaryRow.appendChild(includeSummary);

        // Insert it before new window option.
        var newWindowRow = tools.getItem(idPrefix + ':newWindowRow').element;
        dfx.insertBefore(newWindowRow, includeSummaryRow);

        return contents;
    },

    updateLinkAttributes: function(link, idPrefix)
    {
        ViperLinkPlugin.prototype.updateLinkAttributes.call(this, link, idPrefix);

        var href = link.getAttribute('href');

        if (this._isInternalLink(href) === true) {
            href = './?a=' + href;
        }

        // Anchor.
        var anchorVal = this.viper.ViperTools.getItem(idPrefix + ':anchor').getValue();
        if (anchorVal) {
            href += '#' + anchorVal;
        }

        link.setAttribute('href', href);

    },

    pickAsset: function()
    {
        console.error('TODO: Show an asset picker.');
        // TODO: Show an asset picker.
        // Once the asset picker is closed populate the url field.
    }

};

dfx.inherits('MatrixLinkPlugin', 'ViperLinkPlugin', true);
