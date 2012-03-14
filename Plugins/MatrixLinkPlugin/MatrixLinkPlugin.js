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

        var self        = this;
        var tools       = this.viper.ViperTools;
        var main        = tools.getItem(idPrefix + ':link').element;
        var incSummary  = false;
        var anchorValue = '';

        // Insert asset picker icon next to url field.
        // Insert anchor row after URL field.
        var urlField    = tools.getItem(idPrefix + ':url').element;
        var assetPicker = tools.createButton(idPrefix + ':assetPicker', '', 'Pick Asset', 'ees-target', function() {
            self.pickAsset(idPrefix);
        });
        dfx.insertAfter(urlField, assetPicker);

        // Url value may need to be updated if the link is internal.
        var urlValue = tools.getItem(idPrefix + ':url').getValue();
        if (urlValue.indexOf('./?a=') === 0) {
            // Remove the ./?a= prefix.
            urlValue = urlValue.replace('./?a=', '');

            // Internal URL.
            dfx.removeClass(main, 'emailLink');
            dfx.addClass(main, 'internalLink');

            // If the link content has %asset_summary_xx% keyword then check the summary
            // checkbox.
            var link = this.getLinkFromRange();
            if (link && dfx.getHtml(link).match(/%asset_summary_\d+%/)) {
                incSummary = true;
            }

            // Anchor value.
            var anchorIndex = urlValue.indexOf('#');
            if (anchorIndex >= 0) {
                anchorValue = urlValue.substr((anchorIndex + 1));
                urlValue    = urlValue.substr(0, anchorIndex);
            }

            tools.getItem(idPrefix + ':url').setValue(urlValue);
        }//end if

        // Create anchor field.
        var anchor = tools.createTextbox(idPrefix + ':anchor', 'Anchor', anchorValue, function() {
            self.updateLink(idPrefix);
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
        var includeSummary = tools.createCheckbox(idPrefix + ':includeSummary', 'Include Summary', incSummary, function() {
            self.updateLink(idPrefix);
        });
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

        var assetid = null;
        if (this._isInternalLink(href) === true) {
            assetid = href;
            href    = './?a=' + href;
        }

        // Anchor.
        var anchorVal = this.viper.ViperTools.getItem(idPrefix + ':anchor').getValue();
        if (anchorVal) {
            href += '#' + anchorVal;
        }

        link.setAttribute('href', href);

        // Remove summary keyword.
        dfx.setHtml(link, dfx.getHtml(link).replace(/%asset_summary_\d+%/, ''));

        // Content of the link may need to change due to the summary keyword.
        var includeSummary = this.viper.ViperTools.getItem(idPrefix + ':includeSummary').getValue();
        if (includeSummary === true && assetid) {
            link.appendChild(document.createTextNode(' %asset_summary_' + assetid + '%'));
        }

    },

    updateBubbleFields: function(link)
    {
        ViperLinkPlugin.prototype.updateBubbleFields.call(this, link);

        var tools = this.viper.ViperTools;
        var main  = tools.getItem('ViperLinkPlugin:vtp:link').element;

        // Url value may need to be updated if the link is internal.
        var urlValue = tools.getItem('ViperLinkPlugin:vtp:url').getValue();
        if (urlValue.indexOf('./?a=') === 0) {
            // Remove the ./?a= prefix.
            urlValue = urlValue.replace('./?a=', '');

            // Internal URL.
            dfx.removeClass(main, 'emailLink');
            dfx.addClass(main, 'internalLink');

            // If the link content has %asset_summary_xx% keyword then check the summary
            // checkbox.
            var link       = this.getLinkFromRange();
            var incSummary = false;
            if (link && dfx.getHtml(link).match(/%asset_summary_\d+%/)) {
                incSummary = true;
            }

            // Anchor value.
            var anchorValue = '';
            var anchorIndex = urlValue.indexOf('#');
            if (anchorIndex >= 0) {
                anchorValue = urlValue.substr((anchorIndex + 1));
                urlValue    = urlValue.substr(0, anchorIndex);
            }

            tools.getItem('ViperLinkPlugin:vtp:anchor').setValue(anchorValue);
            tools.getItem('ViperLinkPlugin:vtp:url').setValue(urlValue);
            tools.getItem('ViperLinkPlugin:vtp:includeSummary').setValue(incSummary);
        } else {
            dfx.removeClass(main, 'internalLink');
        }//end if

    },

    /**
     * Pick an asset from the asset finder
     * @param {string} idPrefix         The prefix assigned to the plugin
     */
    pickAsset: function(idPrefix)
    {
        var tools    = this.viper.ViperTools;
        var urlField = tools.getItem(idPrefix + ':url').element;
        EasyEditAssetManager.getCurrentAsset(function(asset){
            EasyEditAssetFinder.init({
                focusAssetId: asset.id,
                callback: function(selectedAsset){
                    tools.getItem(idPrefix + ':url').setValue(selectedAsset.id, false);
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

dfx.inherits('MatrixLinkPlugin', 'ViperLinkPlugin', true);
