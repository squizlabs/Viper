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
(function(ViperUtil, ViperSelection, _) {
	function MatrixKeywordsPlugin(viper)
	{
	    this.viper       = viper;
	}

	Viper.PluginManager.addPlugin('MatrixKeywordsPlugin', MatrixKeywordsPlugin);

	MatrixKeywordsPlugin.prototype = {

	    init: function()
	    {
		    this._initToolbar();
	    },

	    _initToolbar: function()
	    {
		var toolbar = this.viper.PluginManager.getPlugin('ViperToolbarPlugin');
		if (!toolbar) {
		    return;
		}

		var prefix = 'MatrixKeywordsPlugin';
		var self  = this;
		var tools = this.viper.Tools;

		var btnGroup = tools.createButtonGroup('MatrixKeywordsPlugin:vtp:btnGroup');
		
		
		// create content
		var insertKeywordContent = document.createElement('div');
		var insertSnippetContent = document.createElement('div');
		
		// create buttons
		tools.createButton('insertKeywords', '', _('Insert Matrix Keywords'), 'Viper-keywords', null, true);
		tools.createButton('insertSnippets', '', _('Insert Matrix Snippet'), 'Viper-snippet', null, true);

		tools.addButtonToGroup('insertKeywords', prefix + ':vtp:btnGroup');
		tools.addButtonToGroup('insertSnippets', prefix + ':vtp:btnGroup');
		toolbar.addButton(btnGroup);
		
		// create bubble for keyword plugin
		toolbar.createBubble(prefix + ':vtp:keywords', _('Insert Matrix Keywords'), insertKeywordContent, null, null);
		
		// create bubble for snippet plugin
		toolbar.createBubble(prefix + ':vtp:snippet', _('Insert Matrix Snippet'), insertSnippetContent, null, null);
		
		// Keyword Insert Selection.
		var keywordSelect = this._createSelection(prefix + ':insertKeywordSelect', prefix + ':insertKeywordSelect', _('Keyword'), null);
		insertKeywordContent.appendChild(keywordSelect);
		
		// Snippet Insert Selection.
		var snippetSelect = this._createSelection(prefix + ':insertSnippetSelect', prefix + ':insertSnippetSelect', _('Snippet'), null);
		insertSnippetContent.appendChild(snippetSelect);

		
		
		
		// insert buttons
		var insertKeywordButton = tools.createButton(prefix + ':insertKeywordButton', _('Insert'), _('Insert'), 'Viper-insertButton', function() {
		    var keywordToInsert = tools.getItem(prefix + ':insertKeywordSelect').getValue();
		    if(typeof keywordToInsert !== 'undefined') {
			self._insertKeyword('%' + keywordToInsert + '%');
		    }
		}, false);
		var insertSnippetButton = tools.createButton(prefix + ':insertSnippetButton', _('Insert'), _('Insert'), 'Viper-insertButton', function() {
		    var keywordToInsert = tools.getItem(prefix + ':insertSnippetSelect').getValue();
		    if(typeof keywordToInsert !== 'undefined') {
			self._insertKeyword('%' + keywordToInsert + '%');
		    }
		}, false);
		
		insertKeywordContent.appendChild(insertKeywordButton);
		insertSnippetContent.appendChild(insertSnippetButton);
		
		
		toolbar.setBubbleButton(prefix + ':vtp:keywords', 'insertKeywords');
		toolbar.setBubbleButton(prefix + ':vtp:snippet', 'insertSnippets');
		
		    // Update the buttons when the toolbar updates it self.
		    // populate option lists for plugins
		    this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', prefix, function() {
				var editableElement = self.viper.getEditableElement();
				
				
				// get the keywords current editting div
				var keywordSelectorElement = ViperUtil.$(editableElement).data('keyword-selector');
				if(typeof keywordSelectorElement !== 'undefined') {
					tools.enableButton('insertKeywords');
					var selectField = tools.getItem(prefix + ':insertKeywordSelect');
					var select = document.getElementById(keywordSelectorElement);
					tools.getItem(prefix + ':insertKeywordSelect').setHtml(select);
				} 
				
				// get snippet for current div
				var datasetSnippets = ViperUtil.$(editableElement).data('snippets');
				var snippetSelectorElement = ViperUtil.$(editableElement).data('snippet-selector');
				if(typeof snippetSelectorElement !== 'undefined') {
					tools.enableButton('insertSnippets');
					var selectField = tools.getItem(prefix + ':insertSnippetSelect');
					var select = document.getElementById(snippetSelectorElement);
					tools.getItem(prefix + ':insertSnippetSelect').setHtml(select);
				} 
			});

			/** Fix for an issue where clicking on the Select2 scrollbar was 
			 * closing the keyword/snippet dropdown */
			Viper.Util.$(document).on("mouseup", function(e){
				if(e.target.id == 'select2-MatrixKeywordsPlugininsertKeywordSelect-results' || 
					e.target.id == 'select2-MatrixKeywordsPlugininsertSnippetSelect-results') {
					e.stopImmediatePropagation();
				}
			});
			
	    },



	/**
	 * Creates a selecton dropdown.
	 *
	 * @parma {string}  id    The id of the selection field
	 * @parma {string}  name    The name of the selection field
	 * @param {string}  label   The label for the selection field
	 * @param {object} options the options assoiciate array (object)
	 *
	 * @return {DOMElement} The selection element.
	 */
	    _createSelection: function(id, name, label, options)
	    {
			var selectionArea = document.createElement('div');
			ViperUtil.addClass(selectionArea, 'Matrix-Viper-selection');
	
			var labelEl = document.createElement('label');
			ViperUtil.addClass(labelEl, 'Matrix-Viper-selection-label');
			selectionArea.appendChild(labelEl);
	
			var main = document.createElement('div');
			ViperUtil.addClass(main, 'Matrix-Viper-selection-main');
			labelEl.appendChild(main);
	
			// add padding-left css property to the title, 
			var width = 0;
			// Wrap the element in a generic class so the width calculation is correct
			// for the font size.
			var tmp = document.createElement('div');
			ViperUtil.addClass(tmp, 'ViperITP');
	
			if (navigator.userAgent.match(/iPad/i) !== null) {
				ViperUtil.addClass(tmp, 'device-ipad');
			}
			ViperUtil.setStyle(tmp, 'display', 'block');
			this.viper.addElement(tmp);
			tmp.parentNode.removeChild(tmp);
			
			var select = document.createElement("select");
			ViperUtil.addClass(select, 'Matrix-Viper-selection-input');
			select.setAttribute("name", name);
			select.setAttribute("id", id);
	
			// add initial options
			if (options !== null) {
			 for( var key in options) {
				if (options.hasOwnProperty(key)) {
				 var option = document.createElement("option");
				 option.setAttribute("value", key);
				 option.innerHTML = options[key];
				 select.appendChild(option);
				}
			 }
			}
	    
		// add the selection input to tool item stack
		this.viper.Tools.addItem(id, {
		    type: 'selection',
		    element: selectionArea,
		    input: select,
		    getValue: function() {
			if(select.length === 0) return null;
			var selected = select.options[select.selectedIndex];
			if(typeof selected === 'undefined') return null;
			return selected.value;
		    },
		    setValue: function(options) {
			var arr = [];
			for (key in options) {
				if (options.hasOwnProperty(key)) {
					arr.push({
						'key': key,
						'value': options[key]
					});
				}
			}

			arr.forEach(function(obj, index) {
				if (options.hasOwnProperty(obj.key)) {
					var option = document.createElement("option");
					option.setAttribute("value", obj.key);
					option.innerHTML = options[obj.key];
					select.appendChild(option);
				}
			});

			},

			setHtml: function(optionArray, type) {
				//create blank element for placeholder
                optionArray.childNodes.forEach(function(node) {
                    select.appendChild(node);
                });

                ViperUtil.addClass(select, 'matrix-select2');
				ViperUtil.setStyle(select, 'width', '600px');

				var elementId = select.getAttribute('id');
				var bugaloo;

				if(elementId == 'MatrixKeywordsPlugin:insertKeywordSelect') {
					//need custom select2 initialisor for keywords
					bugaloo = ViperUtil.$(select).select2({
						allowClear: true,
						placeholder: '-- Insert keywords --',
						templateResult: formatKeyword,
						matcher: matchValueAndText,
						width: 'resolve',
						templateSelection: formatSelection
					});
				}

				if(elementId == 'MatrixKeywordsPlugin:insertSnippetSelect') {
					//need custom select2 initialisor for snippets
					bugaloo = ViperUtil.$(select).select2({
						allowClear: true,
						placeholder: '-- Insert snippet --',
					});
				}

                //formats the option value into the option value string
                function formatKeyword (optionElement) {
                    if (!optionElement.id) {
                        return optionElement.text;
                    }
                    var state = $('<span class="matrix-select-option-container"><span class="matrix-select-key flex-item">' +
									'%' + optionElement.element.value + '%</span> ' +
									'<span class="matrix-select-value flex-item">' + optionElement.text + '</span></span>');
                    return state;
				};
				
				//formats the selected item so it displays the keyword instead of the description
				function formatSelection(item) {
					if(!item.id) {
						return item.text;
					}
					return '%' + item.id + '%';
				}
        
                //search on the value and text of the options
                function matchValueAndText (params, data) {
                    if ($.trim(params.term) === '') { return data; }
        
                    // Do not display the item if there is no 'text' property
                    if (typeof data.text === 'undefined') { return null; }
        
                    var text = data.text.toUpperCase();
                    var value = '';
        
                    if (typeof data.id !== 'undefined') {
                        value = data.id.toUpperCase();
                    }
        
                    var term = params.term.toUpperCase();
        
                    // Check if the text contains the term
                    if (text.indexOf(term) > -1 || (value !== '' && value.indexOf(term) > -1)) {
                     return data;
                    }
        
                    // Do a recursive check for options with children
                    if (data.children && data.children.length > 0) {
                     // Clone the data object if there are children
                     // This is required as we modify the object to remove any non-matches
                     var match = $.extend(true, {}, data);
        
                     // Check each child of the option
                     for (var c = data.children.length - 1; c >= 0; c--) {
                        var child = data.children[c];
        
                        var matches = matchValueAndText(params, child);
        
                        // If there wasn't a match, remove the object in the array
                        if (matches == null) {
                         match.children.splice(c, 1);
                        }
                     }
        
                     // If any children matched, return the new object
                     if (match.children.length > 0) {
                        return match;
                     }
        
                     // If there were no matching children, check just the plain object
                     return matchValueAndText(params, match);
                    }
        
                    // If it doesn't contain the term, don't return anything
                    return null;
                };

			},
			
		});
		
		main.appendChild(select);
		
		return selectionArea;
	    },
	    
	    
	    /**
	 * Insert keyword to current cursor position
	 *
	 * @parma {string}  keyword    The keyword to insert
	 */
	    _insertKeyword: function(keyword)
	    {
		var range = this.viper.getViperRange();
		if (range.collapsed !== true) {
		    this.viper.deleteContents();

		    // Get the updated range.
		    range = this.viper.getViperRange();
		}

		var newNode = document.createTextNode(keyword);

		var startNode = range.getStartNode(); 
		if (ViperUtil.isStubElement(startNode) === true) { 
			ViperUtil.insertBefore(startNode, newNode) 
		}
		else {
			range.insertNode(newNode);
			range.setStart(newNode, keyword.length);
		}

		if (ViperUtil.isBrowser('msie') === true) {
		    range.moveStart('character', keyword.length);
		}

		range.collapse(true);
		ViperSelection.addRange(range);

		this.viper.fireNodesChanged([this.viper.getViperElement()]);
		this.viper.fireSelectionChanged(range);

		}    
		    
	};
})(Viper.Util, Viper.Selection, Viper._);
