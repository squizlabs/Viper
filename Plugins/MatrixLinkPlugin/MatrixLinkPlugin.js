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

        var tools = this.viper.ViperTools;
        var main  = tools.getItem(idPrefix + ':link').element;

        // Create anchor field.
        var self   = this;
        var anchor = tools.createTextbox(idPrefix + ':anchor', 'Anchor', '', function() {
            self.updateLink();
        });

        var anchorRow = tools.createRow(idPrefix + ':anchorRow', 'anchorRow');
        anchorRow.appendChild(anchor);

        // Insert anchor row after URL field.
        var urlField = tools.getItem(idPrefix + ':url').element;
        dfx.insertAfter(urlField, anchorRow);

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

    }

};

dfx.inherits('MatrixLinkPlugin', 'ViperLinkPlugin', true);
