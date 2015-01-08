function MatrixLinkPlugin(viper)
{
    ViperUtil.inherits('MatrixLinkPlugin', 'ViperLinkPlugin');
    ViperLinkPlugin.call(this, viper);
    this._assetTypeCode    = null;
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
        ViperUtil.insertAfter(urlField, assetPicker);

        // Url value may need to be updated if the link is internal.
        var urlValue = tools.getItem(idPrefix + ':url').getValue();
        if (urlValue.indexOf('./?a=') === 0) {
            // Remove the ./?a= prefix.
            urlValue = urlValue.replace('./?a=', '');

            // Internal URL.
            ViperUtil.removeClass(main, 'Viper-emailLink');
            ViperUtil.addClass(main, 'Viper-internalLink');

            // If the link content has %asset_summary_xx% keyword then check the summary
            // checkbox.
            var link = this.getLinkFromRange();
            if (link && ViperUtil.getHtml(link).match(/%asset_summary_\d+%/)) {
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
        ViperUtil.insertAfter(urlRow, anchorRow);

        // The URL field needs to change the interface to internal URL interface
        // if the value is an internal URL.
        this.viper.registerCallback('ViperTools:changed:' + idPrefix + ':url', 'MatrixLinkPlugin', function() {
            var urlValue = self.viper.ViperTools.getItem(idPrefix + ':url').getValue();
            if (ViperUtil.hasClass(main, 'Viper-emailLink') === false) {
                // Not an email, check if its internal URL.
                if (self._isInternalLink(urlValue) === true) {
                    // Internal URL.
                    ViperUtil.removeClass(main, 'Viper-emailLink');
                    ViperUtil.addClass(main, 'Viper-internalLink');
                } else {
                    ViperUtil.removeClass(main, 'Viper-internalLink');
                }
            }
        });

        // The include summary checkbox.
        var includeSummary = tools.createCheckbox(idPrefix + ':includeSummary', 'Include Summary', incSummary);
        var includeSummaryRow = tools.createRow(idPrefix + ':includeSummaryRow', 'Viper-includeSummaryRow');
        includeSummaryRow.appendChild(includeSummary);

        // Insert it before new window option.
        var newWindowRow = tools.getItem(idPrefix + ':newWindowRow').element;
        ViperUtil.insertBefore(newWindowRow, includeSummaryRow);


        // The link to destination checkbox.
        var useDestination = tools.createCheckbox(idPrefix + ':useDestination', 'Use Link Destination', false);
        var useDestinationRow = tools.createRow(idPrefix + ':useDestinationRow', 'Viper-useDestinationRow');
        useDestinationRow.appendChild(useDestination);

        // Insert it after URL option
        ViperUtil.insertAfter(urlRow, useDestinationRow);

        tools.getItem('ViperLinkPlugin:vtp:link').addSubSectionActionWidgets('ViperLinkPlugin:vtp:linkSubSection', ['ViperLinkPlugin:vtp:anchor', 'ViperLinkPlugin:vtp:includeSummary', 'ViperLinkPlugin:vtp:useDestination']);

        return contents;

    },

    updateInlineToolbar: function(data)
    {
        ViperLinkPlugin.prototype.updateInlineToolbar.call(this, data);

        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');
        inlineToolbarPlugin.getToolbar().addSubSectionActionWidgets(
            'ViperLinkPlugin:vitp:link',
            ['ViperLinkPlugin:vitp:anchor', 'ViperLinkPlugin:vitp:includeSummary', 'ViperLinkPlugin:vitp:useDestination']
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



        // Use Destination keyword if required
        var useDestination = this.viper.ViperTools.getItem(idPrefix + ':useDestination').getValue();
        if(this._assetTypeCode && useDestination) {
            if(this._assetTypeCode == 'link') {
                var href = '%globals_asset_attribute_link_url:' + assetid + '%';
            }
            else if (this._assetTypeCode == 'page_redirect') {
                var href = '%globals_asset_attribute_redirect_url:' + assetid + '%';
            }
        }

        // Mark this link as special link
        if(this._assetTypeCode && (this._assetTypeCode === 'link' || this._assetTypeCode === 'page_redirect')) {
            link.setAttribute('data-linktype', this._assetTypeCode);
        }


        // Anchor.
        var anchorVal = this.viper.ViperTools.getItem(idPrefix + ':anchor').getValue();
        if (anchorVal) {
            href += '#' + anchorVal;
        }


        link.setAttribute('href', href);

        // Remove summary keyword.
        ViperUtil.setHtml(link, ViperUtil.getHtml(link).replace(/[ ]*%asset_summary_\d+%/, ''));

        // Content of the link may need to change due to the summary keyword.
        var includeSummary = this.viper.ViperTools.getItem(idPrefix + ':includeSummary').getValue();
        if (includeSummary === true && assetid) {
            link.appendChild(document.createTextNode(' %asset_summary_' + assetid + '%'));
        }


    },

    updateBubbleFields: function(link)
    {
        ViperLinkPlugin.prototype.updateBubbleFields.call(this, link);

        if(!link) return;

        var tools = this.viper.ViperTools;
        var main  = tools.getItem('ViperLinkPlugin:vtp:link').element;
        var urlValue = tools.getItem('ViperLinkPlugin:vtp:url').getValue();

        // if this link is marked as special type link, we have to enable t he Use Destination box
        if(link.dataset.linktype) {
            this._assetTypeCode = link.dataset.linktype;
        }
        else {
            this._assetTypeCode = null;
        }
        this.enableUseDestinationCheckbox(this._assetTypeCode, false);

        // Url value may need to be updated if the link is internal.
        if (urlValue.indexOf('./?a=') === 0 || urlValue.indexOf('%globals_') === 0) {
            // Remove the ./?a= prefix.
            urlValue = urlValue.replace('./?a=', '');


            // Internal URL.
            ViperUtil.removeClass(main, 'Viper-emailLink');
            ViperUtil.addClass(main, 'Viper-internalLink');

            // If the link content has %asset_summary_xx% keyword then check the summary
            // checkbox.
            var link       = this.getLinkFromRange();
            var incSummary = false;
            if (link && ViperUtil.getHtml(link).match(/%asset_summary_\d+%/)) {
                incSummary = true;
            }

            // Anchor value.
            var anchorValue = '';
            var anchorIndex = urlValue.indexOf('#');
            if (anchorIndex >= 0) {
                anchorValue = urlValue.substr((anchorIndex + 1));
                urlValue    = urlValue.substr(0, anchorIndex);
            }

            // Redirect link keyword
            var assetid = this.isURLLinkKeyword(urlValue);
            if(assetid) {
                urlValue = assetid;
                // enable the Use Destination Link check box
                this.enableUseDestinationCheckbox(this._assetTypeCode, true);
            }


            tools.getItem('ViperLinkPlugin:vtp:anchor').setValue(anchorValue);
            tools.getItem('ViperLinkPlugin:vtp:url').setValue(urlValue);
            tools.getItem('ViperLinkPlugin:vtp:includeSummary').setValue(incSummary);
        } else {
            tools.getItem('ViperLinkPlugin:vtp:anchor').setValue('');
            tools.getItem('ViperLinkPlugin:vtp:includeSummary').setValue(false);
            ViperUtil.removeClass(main, 'Viper-internalLink');
        }//end if



    },

    updateInlineToolbarFields: function(link)
    {
        ViperLinkPlugin.prototype.updateInlineToolbarFields.call(this, link);

        var tools = this.viper.ViperTools;
        var main  = tools.getItem('ViperLinkPlugin:vitp:link').element;
        var urlValue = tools.getItem('ViperLinkPlugin:vitp:url').getValue();


        // if this link is marked as special type link, we have to enable t he Use Destination box
        if(link && link.dataset && link.dataset.linktype) {
            this._assetTypeCode = link.dataset.linktype;
        }
        else {
            this._assetTypeCode = null;
        }
        this.enableUseDestinationCheckbox(this._assetTypeCode, false);

        // Url value may need to be updated if the link is internal.
        if (urlValue.indexOf('./?a=') === 0 || urlValue.indexOf('%globals_') === 0) {
            // Remove the ./?a= prefix.
            urlValue = urlValue.replace('./?a=', '');

            // Internal URL.
            ViperUtil.removeClass(main, 'Viper-emailLink');
            ViperUtil.addClass(main, 'Viper-internalLink');

            // If the link content has %asset_summary_xx% keyword then check the summary
            // checkbox.
            var link       = this.getLinkFromRange();
            var incSummary = false;
            if (link && ViperUtil.getHtml(link).match(/%asset_summary_\d+%/)) {
                incSummary = true;
            }

            // Anchor value.
            var anchorValue = '';
            var anchorIndex = urlValue.indexOf('#');
            if (anchorIndex >= 0) {
                anchorValue = urlValue.substr((anchorIndex + 1));
                urlValue    = urlValue.substr(0, anchorIndex);
            }

            // Redirect link keyword
            var assetid = this.isURLLinkKeyword(urlValue);
            if(assetid) {
                urlValue = assetid;
                // enable the Use Destination Link check box
                this.enableUseDestinationCheckbox(this._assetTypeCode, true);
            }


            tools.getItem('ViperLinkPlugin:vitp:anchor').setValue(anchorValue);
            tools.getItem('ViperLinkPlugin:vitp:url').setValue(urlValue);
            tools.getItem('ViperLinkPlugin:vitp:includeSummary').setValue(incSummary);
        } else {
            tools.getItem('ViperLinkPlugin:vitp:anchor').setValue('');
            tools.getItem('ViperLinkPlugin:vitp:includeSummary').setValue(false);
            ViperUtil.removeClass(main, 'Viper-internalLink');
        }//end if

    },

    /**
     * If the href is a Link/Redirect page keyword, return the tagret asset id
     * @param {string} urlValue         The href of the link to check
     */
    isURLLinkKeyword: function(urlValue)
    {
        if(urlValue.indexOf('%globals_asset_attribute_link_url:') === 0) {
            // set type code
            this._assetTypeCode = 'link';
            var re = /\%globals_asset_attribute_link_url:([0-9]+)\%/;
            var matches = urlValue.match(re);
            if(matches[1]) {
                return matches[1];
            }
        }
        else if (urlValue.indexOf('%globals_asset_attribute_redirect_url:') === 0) {
            this._assetTypeCode = 'page_redirect';
            var re = /\%globals_asset_attribute_redirect_url:([0-9]+)\%/;
            var matches = urlValue.match(re);
            if(matches[1]) {
                return matches[1];
            }

        }

        return null;
    },

    /**
     * Pick an asset from the asset finder
     * @param {string} idPrefix         The prefix assigned to the plugin
     */
    pickAsset: function(idPrefix)
    {
	var tools       = this.viper.ViperTools;
	var urlField    = tools.getItem(idPrefix + ':url').element;
    var self = this;

	// if in Matrix backend mode
	if(typeof EasyEditAssetManager === 'undefined') {
	    var jsMap = parent.frames.sq_sidenav.JS_Asset_Map;
	    var name =idPrefix;
	    var safeName = idPrefix;
	    var closeOnExit = function() {
		    if (document.body.getAttribute('data-use-me-close-on-exit') === '1') {
			    document.body.removeAttribute('data-use-me-close-on-exit');
			    var resizer_frame = window.top.frames['sq_resizer'];
			    if (resizer_frame && !resizer_frame.hidden) {
				    resizer_frame.toggleFrame();
			    }
		    }
	    };
	    var toggleResizerFrame = function() {
		    var resizer_frame = window.top.frames['sq_resizer'];
		    if (resizer_frame && resizer_frame.hidden) {
			    document.body.setAttribute('data-use-me-close-on-exit', '1');
			    resizer_frame.toggleFrame();
		    }
	    };
	    if (jsMap.isInUseMeMode(name) === true) {
		    alert('Asset Finder In Use');
	    } else if (jsMap.isInUseMeMode() === true) {
		    closeOnExit();
		    jsMap.cancelUseMeMode();
	    } else {
		    toggleResizerFrame();
		    jsMap.setUseMeMode(name, safeName, undefined, false, function(data) {
			if(typeof data.assetid !== 'undefined') {
			    closeOnExit();
			    tools.getItem(idPrefix + ':url').setValue(data.assetid,false);
                // enable the use destination option if required
                if(data.typecode) {
                    self._assetTypeCode = data.typecode;
                    self.enableUseDestinationCheckbox(self._assetTypeCode, true);
                }
			}
		    });
		    // close use me mode if user clicks anywhere
                    this.viper.registerCallback(['Viper:mouseDown', 'ViperToolbarPlugin:disabled'], 'MatrixLinkPlugin', function(data) {
                        if (jsMap.isInUseMeMode() === true) {
                                jsMap.cancelUseMeMode();
                        }
                    });	
	    }
	}
	else {
	    // in EES mode
	    EasyEditAssetManager.getCurrentAsset(function(asset){

		var initialValue = tools.getItem(idPrefix + ':url').getValue(),
		    focusId = asset.id;
		if (/^[0-9]+([:].*)?$/.test(initialValue)) {
		    focusId = initialValue;
		}// End if

		EasyEditAssetFinder.init({
		    focusAssetId: focusId,
		    callback: function(selectedAsset){
    			tools.getItem(idPrefix + ':url').setValue(selectedAsset.id,false);
                // enable the use destination option if required
                self._assetTypeCode = selectedAsset.attr.type_code;
                self.enableUseDestinationCheckbox(self._assetTypeCode, true);
		    }
		});
	    });
	}
    },

    /**
     * Show the Use Destination checkbox if required (for Link and Redirect Page asset)
     * @param {string} type_code      The type code of selected asset
     * @param {boolean} value       Set the value
     */
    enableUseDestinationCheckbox: function(type_code, value)
    {
        var tools = this.viper.ViperTools;
        if(type_code == 'link' || type_code == 'page_redirect') {
           // $('.Viper-useDestinationRow').show();
            var label = _('Use Link Destination');
            if(type_code == 'page_redirect') {
                label = _('Use Redirect Link Destination');
            }

            
            $(tools.getItem('ViperLinkPlugin:vitp:useDestination').element).find('.Viper-checkbox-title').html(label);
            $(tools.getItem('ViperLinkPlugin:vitp:useDestinationRow').element).show();
            
            $(tools.getItem('ViperLinkPlugin:vtp:useDestination').element).find('.Viper-checkbox-title').html(label);
            $(tools.getItem('ViperLinkPlugin:vtp:useDestinationRow').element).show();

            
            tools.getItem('ViperLinkPlugin:vitp:useDestination').setValue(value);
            tools.getItem('ViperLinkPlugin:vtp:useDestination').setValue(value);
        }
        else {
            $(tools.getItem('ViperLinkPlugin:vtp:useDestinationRow').element).hide();
            $(tools.getItem('ViperLinkPlugin:vitp:useDestinationRow').element).hide();
            tools.getItem('ViperLinkPlugin:vitp:useDestination').setValue(false);
            tools.getItem('ViperLinkPlugin:vtp:useDestination').setValue(false);
        }
    },



    /**
     * Check to see if the element clicked is a part of the plugin. Here we need to
     * let Viper know that anything in the asset finder launched is a part of the plugin
     * @param {object} element      The clicked element
     */
    isPluginElement: function(element)
    {
        var assetFinderOverlay = ViperUtil.getid('ees_assetFinderOverlay');
        if (element !== this._toolbar
            && ViperUtil.isChildOf(element, this._toolbar) === false
            && ViperUtil.isChildOf(element, assetFinderOverlay) === false
        ) {
            return false;
        }

        return true;

    }

};
