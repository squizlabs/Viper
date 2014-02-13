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

	var btnGroup = tools.createButtonGroup('MatrixKeywordsPlugin:vtp:btnGroup');
	
	
	// create content
	var insertKeywordContent = document.createElement('div');
	var insertSnippetContent = document.createElement('div');
	
	// create buttons
	tools.createButton('insertKeywords', '', _('Insert Matrix Keywords'), 'Viper-keywords', null, false);
	tools.createButton('insertSnippet', '', _('Insert Matrix Snippet'), 'Viper-snippet', null, false);

	tools.addButtonToGroup('insertKeywords', 'MatrixKeywordsPlugin:vtp:btnGroup');
	tools.addButtonToGroup('insertSnippet', 'MatrixKeywordsPlugin:vtp:btnGroup');
	toolbar.addButton(btnGroup);
	
	// create bubble 1
	toolbar.createBubble('MatrixKeywordsPlugin:vtp:keywords', _('Insert Keywords'), insertKeywordContent, null, function() {
	    alert(1);
	});
	
	// create bubble 2
	toolbar.createBubble('MatrixKeywordsPlugin:vtp:snippet', _('Insert Snippet'), insertSnippetContent, null, function() {
	    alert(2);
	});
	
	// Keyword Insert Selection.
	var keywordSelection = tools.createTextbox('MatrixKeywordsPlugin:insertKeywordSelection', _('Keyword'), '', function(value) {
	    alert(value);
	});
	// Snippet Insert Selection.
	var snippetSelection = tools.createTextbox('MatrixKeywordsPlugin:insertSnippetSelection', _('Snippet'), '', function(value) {
	    alert(value);
	});
	// insert buttons
	var insertKeywordButton = tools.createButton('MatrixKeywordsPlugin:insertKeywordButton', _('Insert'), _('Insert'), 'Viper-insertButton', function() {
	alert('insert keyword');
	}, true);
	var insertSnippetButton = tools.createButton('MatrixKeywordsPlugin:insertSnippetButton', _('Insert'), _('Insert'), 'Viper-insertButton', function() {
	alert('insert snippet');
	}, true);
	
	insertKeywordContent.appendChild(keywordSelection);
	insertKeywordContent.appendChild(insertKeywordButton);
	insertSnippetContent.appendChild(snippetSelection);
	insertKeywordContent.appendChild(insertSnippetButton);
	
	toolbar.setBubbleButton('MatrixKeywordsPlugin:vtp:keywords', 'insertKeywords');
	toolbar.setBubbleButton('MatrixKeywordsPlugin:vtp:snippet', 'insertSnippet');
	
	    // Update the buttons when the toolbar updates it self.
	    this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'MatrixKeywordsPlugin', function() {
		tools.enableButton('insertKeywords');
		tools.enableButton('insertSnippet');
	    });
    }

};
