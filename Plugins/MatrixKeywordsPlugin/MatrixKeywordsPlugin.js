/**
 * +--------------------------------------------------------------------+
 * | This Squiz Viper file is Copyright (c) Squiz Australia Pty Ltd     |
 * | ABN 53 131 581 247                                                 |
 * +--------------------------------------------------------------------+
 * | IMPORTANT: Your use of this Software is subject to the terms of    |
 * | the Licence provided in the file licence.txt. If you cannot find   |
 * | this file please contact Squiz (www.squiz.com.au) so we may        |
 * | provide you a copy.                                                |
 * +--------------------------------------------------------------------+
 *
 */

function MatrixKeywordsPlugin(viper)
{
    this.viper       = viper;
    this._matchCount = 0;
    this._finding = false;

}

MatrixKeywordsPlugin.prototype = {

    init: function()
    {
	    this._initToolbar();
    },

    _initToolbar: function()
    {
	var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
	if (!toolbar) {
	    return;
	}

	var self  = this;
	var tools = this.viper.ViperTools;

	var btnGroup = tools.createButtonGroup('ViperLinkPlugin:vtp:btnGroup');
	
	
	// create content
	var main = document.createElement('div');
	
	// create buttons
	tools.createButton('insertKeywords', '', _('Insert Matrix Keywords'), 'Viper-keywords', null, disabled);
	tools.createButton('insertSnippet', '', _('Insert Matrix Snippet'), 'Viper-snippet', function() {
	    if (self.selectionHasLinks() === true) {
		self.removeLinks();
	    } else {
		var link = self.getLinkFromRange();
		self.removeLink(link);
	    }
	}, disabled);

	tools.addButtonToGroup('insertKeywords', 'MatrixKeywordsPlugin:vtp:btnGroup');
	tools.addButtonToGroup('insertSnippet', 'MatrixKeywordsPlugin:vtp:btnGroup');
	toolbar.addButton(btnGroup);
	
	// create bubble
	toolbar.createBubble('MatrixKeywordsPlugin:vtp:keywords', _('Insert Keywords'), main, null, function() {
	    alert(1);
	});
	main.appendChild(this.getToolbarContent('MatrixKeywordsPlugin:vtp'));
	toolbar.setBubbleButton('MatrixKeywordsPlugin:vtp:keywords', 'insertKeywords');

    },

    _updateButtonStates: function(hasResult)
    {
        var self  = this;
        var tools = this.viper.ViperTools;

        var enableReplace = true;
        if (hasResult !== true && this._matchCount === 0) {
            enableReplace = false;
        }

        // These selection during these find calls may jump in to other containers
        // so clone the current selection so that we can select it again.
        var clone = this.viper.getCurrentRange();
        if (enableReplace === true) {
            tools.enableButton('ViperSearchPlugin:replace');
            tools.enableButton('ViperSearchPlugin:replaceAll');
        } else {
            tools.disableButton('ViperSearchPlugin:replace');
            tools.disableButton('ViperSearchPlugin:replaceAll');
        }

        // Fix to remove the selection from textbox.
        var val = tools.getItem('ViperSearchPlugin:searchInput').getValue();
        tools.getItem('ViperSearchPlugin:searchInput').setValue('');
        tools.getItem('ViperSearchPlugin:searchInput').setValue(val);

        // Select the original range.
        ViperSelection.addRange(clone);
        this.viper.focus();

    },

    getNumberOfMatches: function(text)
    {
        this._matchCount = 0;
        var fromStart = true;
        while (this.find(text, false, fromStart) === true) {
            this._matchCount++;
            fromStart = false;
        }

        return this._matchCount;

    },

    find: function(text, backward, fromStart, testOnly)
    {
        var element = this.viper.getViperElement();
        if (!text || !element) {
            return;
        }

        var rangeClone = null;
        if (testOnly) {
            rangeClone = this.viper.getCurrentRange().cloneRange();
        }

        var viperRange = null;
        if (fromStart === true) {
            if (Viper.document.activeElement
                && Viper.document.activeElement !== this.element
                && Viper.document.activeElement.blur
                && Viper.document.activeElement !== document.body
            ) {
                // Call the blur method of the active element incase its an input box etc
                // which causes problems on IE when range is set below.
                // Note that the above activeElement != body check is to prevent the best
                // browser in the world changing focus to another window..
                Viper.document.activeElement.blur();
            }

            viperRange = this.viper.getCurrentRange();
            viperRange.setStart(viperRange._getFirstSelectableChild(element), 0);
            viperRange.collapse(true);
        } else {
            viperRange = this.viper.getCurrentRange();
        }

        if (this.viper.isBrowser('msie') === true) {
            // Range search.
            viperRange.collapse(false);
            this._finding = true;
            var found = viperRange.rangeObj.findText(text);
            if (testOnly !== true && found === true) {
                viperRange.rangeObj.select();
                ViperSelection.addRange(this.viper.getCurrentRange());
                this.viper.fireSelectionChanged();
                setTimeout(function() {
                    this._finding = false;
                }, 300);
            }

            return found;
        } else {
            this.viper.focus();
            ViperSelection.addRange(viperRange);

            var found = this.viper.getDocumentWindow().find(text, false, backward);
            if (found !== true || this.viper.rangeInViperBounds() === false) {
                if (testOnly === true) {
                    ViperSelection.addRange(rangeClone);
                } else {
                    // Not found or not inside Viper element.
                    ViperSelection.addRange(viperRange);
                    this.viper.focus();
                }

                return false;
            } else if (testOnly === true) {
                ViperSelection.addRange(rangeClone);
                return true;
            }
        }//end if

        return true;

    },

    replace: function(replacement)
    {
        var range = null;
        if (this.viper.isBrowser('msie') === true) {
            range = this.viper.getViperRange();
        } else {
            range = this.viper.getCurrentRange();
            if (this.viper.rangeInViperBounds(range) === false) {
                range = this.viper.getViperRange();
            }
        }

        range.deleteContents();

        var newNode = document.createTextNode(replacement);
        range.insertNode(newNode);
        range.selectNode(newNode);
        ViperSelection.addRange(range);

        this._matchCount--;

    }

};
