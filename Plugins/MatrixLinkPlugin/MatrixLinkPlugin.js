function MatrixLinkPlugin(viper)
{
    dfx.inherits('MatrixLinkPlugin', 'ViperLinkPlugin');
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
        var assetPicker = tools.createButton(idPrefix + ':assetPicker', '', 'Pick Asset', 'Viper-ees-target', function() {
            self.pickAsset(idPrefix);
        });
        dfx.insertAfter(urlField, assetPicker);

        // Url value may need to be updated if the link is internal.
        var urlValue = tools.getItem(idPrefix + ':url').getValue();
        if (urlValue.indexOf('./?a=') === 0) {
            // Remove the ./?a= prefix.
            urlValue = urlValue.replace('./?a=', '');

            // Internal URL.
            dfx.removeClass(main, 'Viper-emailLink');
            dfx.addClass(main, 'Viper-internalLink');

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

        var anchorRow = tools.createRow(idPrefix + ':anchorRow', 'Viper-anchorRow');
        anchorRow.appendChild(anchor);

        // Insert anchor row after URL field.
        var urlRow = tools.getItem(idPrefix + ':urlRow').element;
        dfx.insertAfter(urlRow, anchorRow);

        // The URL field needs to change the interface to internal URL interface
        // if the value is an internal URL.
        this.viper.registerCallback('ViperTools:changed:' + idPrefix + ':url', 'MatrixLinkPlugin', function() {
            var urlValue = self.viper.ViperTools.getItem(idPrefix + ':url').getValue();
            if (dfx.hasClass(main, 'Viper-emailLink') === false) {
                // Not an email, check if its internal URL.
                if (self._isInternalLink(urlValue) === true) {
                    // Internal URL.
                    dfx.removeClass(main, 'Viper-emailLink');
                    dfx.addClass(main, 'Viper-internalLink');
                } else {
                    dfx.removeClass(main, 'Viper-internalLink');
                }
            }
        });

        // The include summary checkbox.
        var includeSummary = tools.createCheckbox(idPrefix + ':includeSummary', 'Include Summary', incSummary);
        var includeSummaryRow = tools.createRow(idPrefix + ':includeSummaryRow', 'Viper-includeSummaryRow');
        includeSummaryRow.appendChild(includeSummary);

        // Insert it before new window option.
        var newWindowRow = tools.getItem(idPrefix + ':newWindowRow').element;
        dfx.insertBefore(newWindowRow, includeSummaryRow);

        tools.getItem('ViperLinkPlugin:vtp:link').addSubSectionActionWidgets('ViperLinkPlugin:vtp:linkSubSection', ['ViperLinkPlugin:vtp:anchor', 'ViperLinkPlugin:vtp:includeSummary']);

        return contents;

    },

    updateInlineToolbar: function(data)
    {
        ViperLinkPlugin.prototype.updateInlineToolbar.call(this, data);

        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');
        inlineToolbarPlugin.getToolbar().addSubSectionActionWidgets(
            'ViperLinkPlugin:vitp:link',
            ['ViperLinkPlugin:vitp:anchor', 'ViperLinkPlugin:vitp:includeSummary']
        );

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
        dfx.setHtml(link, dfx.getHtml(link).replace(/[ ]*%asset_summary_\d+%/, ''));

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
            dfx.removeClass(main, 'Viper-emailLink');
            dfx.addClass(main, 'Viper-internalLink');

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
            tools.getItem('ViperLinkPlugin:vtp:anchor').setValue('');
            tools.getItem('ViperLinkPlugin:vtp:includeSummary').setValue(false);
            dfx.removeClass(main, 'Viper-internalLink');
        }//end if

    },

    updateInlineToolbarFields: function(link)
    {
        ViperLinkPlugin.prototype.updateInlineToolbarFields.call(this, link);

        var tools = this.viper.ViperTools;
        var main  = tools.getItem('ViperLinkPlugin:vitp:link').element;

        // Url value may need to be updated if the link is internal.
        var urlValue = tools.getItem('ViperLinkPlugin:vitp:url').getValue();
        if (urlValue.indexOf('./?a=') === 0) {
            // Remove the ./?a= prefix.
            urlValue = urlValue.replace('./?a=', '');

            // Internal URL.
            dfx.removeClass(main, 'Viper-emailLink');
            dfx.addClass(main, 'Viper-internalLink');

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

            tools.getItem('ViperLinkPlugin:vitp:anchor').setValue(anchorValue);
            tools.getItem('ViperLinkPlugin:vitp:url').setValue(urlValue);
            tools.getItem('ViperLinkPlugin:vitp:includeSummary').setValue(incSummary);
        } else {
            tools.getItem('ViperLinkPlugin:vitp:anchor').setValue('');
            tools.getItem('ViperLinkPlugin:vitp:includeSummary').setValue(false);
            dfx.removeClass(main, 'Viper-internalLink');
        }//end if

    },

    /**
     * Pick an asset from the asset finder
     * @param {string} idPrefix         The prefix assigned to the plugin
     */
    pickAsset: function(idPrefix)
    {
	var tools       = this.viper.ViperTools;
	var urlField    = tools.getItem(idPrefix + ':url').element;

	// if in Matrix backend mode
	if(typeof EasyEditAssetManager === 'undefined') {
	    var jsMap = parent.frames.sq_sidenav.JS_Asset_Map;
	    var name =idPrefix;
	    var safeName = idPrefix;
	    if (jsMap.isInUseMeMode(name) === true) {
		    alert('Asset Finder In Use');
	    } else if (jsMap.isInUseMeMode() === true) {
		    jsMap.cancelUseMeMode();
	    } else {
		    jsMap.setUseMeMode(name, safeName, undefined, function(data) {
			if(typeof data.assetid !== 'undefined') {
			    tools.getItem(idPrefix + ':url').setValue(assetid,false);
			}
		    });
	    }
	}
	else {
	    // in EES mode
	    EasyEditAssetManager.getCurrentAsset(function(asset){

		var initialValue = tools.getItem(idPrefix + ':url').getValue(),
		    focusId = asset.id;
		if (/^[0-9]+$/.test(initialValue)) {
		    focusId = initialValue;
		}// End if

		EasyEditAssetFinder.init({
		    focusAssetId: focusId,
		    callback: function(selectedAsset){
			tools.getItem(idPrefix + ':url').setValue(selectedAsset.id,false);
		    }
		});
	    });
	}
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
