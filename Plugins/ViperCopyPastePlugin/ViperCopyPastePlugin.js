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

function ViperCopyPastePlugin(viper)
{
    this.viper = viper;

    this.pasteElement  = null;
    this.pasteValue    = null;
    this.rangeObj      = null;
    this.pasteType     = 'formatted';
    this.cutType       = 'formatted';
    this.allowedTags   = 'table|tr|td|th|ul|li|ol|br|p|a|img|form|input|select|option';
    this.convertTags   = null;
    this._tmpNode      = null;
    this._isFirefox    = viper.isBrowser('firefox');
    this._isMSIE       = viper.isBrowser('msie');
    this._isSafari     = viper.isBrowser('safari');

}

ViperCopyPastePlugin.prototype = {
    init: function()
    {
        var self = this;
        this.viper.registerCallback('Viper:editableElementChanged', 'ViperCopyPastePlugin', function() {
            self._init();
        });

        this.viper.registerCallback('Viper:keyDown', 'ViperCopyPastePlugin', function(e) {
            return self.keyDown(e);
        });

        this.pasteElement = this._createPasteDiv();

    },

    setSettings: function(settings)
    {
        if (dfx.isset(settings.pasteType) === true) {
            this.pasteType = settings.pasteType;
        }

        if (dfx.isset(settings.cutType) === true) {
            this.cutType = settings.cutType;
        }

        if (dfx.isset(settings.allowedTags) === true) {
            this.allowedTags = settings.allowedTags;
        }

        if (dfx.isset(settings.convertTags) === true) {
            this.convertTags = settings.convertTags;
        }

    },

    _init: function()
    {
        var elem = this.viper.getViperElement();

        if (!elem) {
            return;
        }

        var self = this;
        if (this._isMSIE !== true && this._isFirefox !== true && this._isSafari !== true) {
            elem.onpaste = function(e) {
                if (!e.clipboardData || self._canPaste() === false) {
                    return;
                }

                var dataType = null;
                if (e.clipboardData.types) {
                    if (e.clipboardData.types.inArray('text/html') === true) {
                        dataType = 'text/html';
                    } else if (e.clipboardData.types.inArray('text/plain') === true) {
                        dataType = 'text/plain';
                    }
                }

                self._beforePaste();
                if (self.pasteType === 'formatted' || self.pasteType === 'formattedClean') {
                    if (dataType === null) {
                        dataType = 'text/html';
                    }

                    self.pasteElement = self._createPasteDiv();
                    dfx.setHtml(self.pasteElement, e.clipboardData.getData(dataType));
                    self._handleFormattedPasteValue((self.pasteType === 'formattedClean'));
                } else {
                    if (dataType === null) {
                        dataType = 'text';
                    } else {
                        dataType = 'text/plain';
                    }

                    self._handleRawPasteValue(e.clipboardData.getData(dataType));
                }

                self._afterPaste();

                dfx.preventDefault(e);
                return false;
            };

        } else {
            elem.onpaste = function(e) {
                if (self._isFirefox === true) {
                    self._beforePaste();
                    var div = self._createPasteDiv();
                    div.focus();
                    setTimeout(function() {console.info(dfx.getHtml(div));
                        self._handleFormattedPasteValue(false, div);
                        self._afterPaste();

                        dfx.remove(div);

                    }, 30);
                }
            };
        }//end if

        elem.oncut = function(e) {
            self.viper.fireNodesChanged();
        };
    },

    _canPaste: function()
    {
        if (this.viper.pluginActive() === true && this.viper.ViperPluginManager.allowTextInput !== true) {
            return false;
        }

        return true;

    },

    keyDown: function (e)
    {
        if (this._isMSIE === true || this._isFirefox === true || this._isSafari === true) {
            if (e.metaKey === true || e.ctrlKey === true) {
                if (e.keyCode === 86) {
                    return this._fakePaste(e);
                }
            }
        }

        return true;

    },

    handleCut: function(e)
    {
        if (this.cutType === 'formatted') {
            return this.handleFormattedCut();
        }

        var range = this.viper.getCurrentRange();
        if (range.collapsed === true) {
            return false;
        }

        var startCont   = range.startContainer;
        var startOffset = range.startOffset;

        // Bookmark current range position.
        var bookmark = this.viper.createBookmark();

        // Create a text box then put the range contents in there.
        var textInput = document.createElement('input');
        dfx.setStyle(textInput, 'top', '100px');
        dfx.setStyle(textInput, 'left', '100px');
        dfx.setStyle(textInput, 'position', 'fixed');
        dfx.setStyle(textInput, 'width', '0px');
        dfx.setStyle(textInput, 'height', '0px');
        dfx.setStyle(textInput, 'border', '0px');

        // Set the value of the textbox to range contents.
        textInput.value = range.toString();

        // Delete the contents of the range.
        this.viper.deleteContents();
        this.viper.addElement(textInput);

        // Set the focus to textbox.
        textInput.focus();

        // Select the contents of the text box.
        textInput.select();

        // Select the bookmark and update caret position.
        this.viper.selectBookmark(bookmark);
        this.viper.fireNodesChanged();

        // Important: Bubble up so that browser can cut the contents of the selection.
        return false;

    },


    handleFormattedCut: function()
    {
        var range = this.viper.getCurrentRange();
        if (range.collapsed === true) {
            return false;
        }

        var contents = range.getHTMLContents();
        this.viper.deleteContents();

        // Bookmark position.
        var bookmark = this.viper.createBookmark();

        var div = document.createElement('div');
        div.setAttribute('class', 'editable_attribute');
        div.setAttribute('contentEditable', true);
        dfx.setStyle(div, 'width', '0px');
        dfx.setStyle(div, 'height', '0px');
        dfx.setStyle(div, 'overflow', 'hidden');

        // Use position fixed to prevent page scrolling
        // when the div is appended to body.
        dfx.setStyle(div, 'position', 'fixed');
        dfx.setStyle(div, 'top', '90px');
        dfx.setStyle(div, 'left', '50px');
        this.viper.addElement(div);

        dfx.setHtml(div, contents);

        // Let the div have the focus.
        div.focus();

        // Select the div contents.
        range.selectNode(div);

        // Add range so that it can be copied by browser.
        ViperSelection.addRange(range);

        // Select the bookmark and update caret position.
        this.viper.selectBookmark(bookmark);

        setTimeout(function() {
            dfx.remove(div);
        }, 100);

        this.viper.fireNodesChanged();

        return false;

    },

    _beforePaste: function()
    {
        this.viper.setAllowCleanDOM(false);
        var range     = this.viper.getCurrentRange();
        this.rangeObj = range.cloneRange();

        this._tmpNode = document.createTextNode('');
        this.viper.insertNodeAtCaret(this._tmpNode);

    },

    _afterPaste: function()
    {
        this.viper.setAllowCleanDOM(true);
    },

    _fakePaste: function(e)
    {
        this._beforePaste();
        switch (this.pasteType) {
            case 'formatted':
                this._handleFormattedPaste(false, e);
            break;

            case 'formattedClean':
                this._handleFormattedPaste(true, e);
            break;

            default:
                this._handleRawPaste(e);
            break;
        }

        this._afterPaste();
        return true;

    },

    _handleRawPaste: function(e)
    {
        var textInput     = document.createElement('input');
        this.pasteElement = textInput;

        dfx.setStyle(textInput, 'top', '0px');
        dfx.setStyle(textInput, 'left', '0px');
        dfx.setStyle(textInput, 'position', 'fixed');
        dfx.setStyle(textInput, 'width', '0px');
        dfx.setStyle(textInput, 'height', '0px');
        dfx.setStyle(textInput, 'border', '0px');

        this.viper.addElement(textInput);
        textInput.focus();

        var self          = this;
        textInput.onpaste = function() {
            setTimeout(function() {
                self._handleRawPasteValue(textInput.value);
                self.viper.fireNodesChanged();
            }, 100);
        };

        return true;

    },

    _handleRawPasteValue: function(content)
    {
        if (!content) {
            content = '';
        }

        this._tmpNode.data = content;
        var range = this.viper.getCurrentRange();
        range.setStart(this._tmpNode, this._tmpNode.data.length);
        range.collapse(true);
        ViperSelection.addRange(range);

        if (this.pasteElement) {
            dfx.remove(this.pasteElement);
            this.pasteElement = null;
        }

    },

    _createPasteDiv: function()
    {
        // If the old exists then get rid of it as a bit of an IE8 hack to address
        // pasting positioning problems as well as range non object issues.
        var oldEl = dfx.getId('ViperPasteDiv');
        if (oldEl) {
            dfx.remove(oldEl);
        }

        var div = document.createElement('div');
        div.setAttribute('id', 'ViperPasteDiv');
        div.setAttribute('contentEditable', true);
        this.viper.addElement(div);

        return div;

    },

    _handleFormattedPaste: function(stripTags, e)
    {
        if (!this.pasteElement) {
            this.pasteElement = this._createPasteDiv();
        } else {
            dfx.empty(this.pasteElement);
        }

        if (this._isSafari === true) {
            var scrollCoords = dfx.getScrollCoords();
            this.pasteElement.innerHTML = '&nbsp;';
            this.pasteElement.focus();
            Viper.window.scrollTo(scrollCoords.x, scrollCoords.y);
        } else {
            this.pasteElement.focus();
        }

        var self = this;
        this.pasteElement.onpaste = function(e) {
            setTimeout(function() {
               self._handleFormattedPasteValue(stripTags);
               self.viper.focus();
            }, 100);
        };

        return true;

    },

    _handleFormattedPasteValue: function(stripTags, pasteElement)
    {
        pasteElement = pasteElement || this.pasteElement;
        this._removeEditableAttrs(pasteElement);

        // Clean paste from word document.
        var html = dfx.getHtml(pasteElement);
        html     = this._cleanWordPaste(html);
        html     = this._removeAttributes(html);

        if (stripTags === true) {
            html = dfx.stripTags(html, this.allowedTags.split('|'));
        }

        if (html) {
            html = dfx.trim(html);
        }

        if (!html) {
            this._updateSelection();
            return;
        }

        var range    = this.rangeObj || this.viper.getCurrentRange();
        var fragment = range.createDocumentFragment(html);

        var convertTags = this.convertTags;
        if (stripTags === true && this.convertTags !== null) {
            dfx.foreach(convertTags, function(tag) {
                var elems = dfx.getTag(tag, fragment.firstChild);
                var ln    = elems.length;
                for (var i = 0; i < ln; i++) {
                    var cElem = document.createElement(convertTags[tag]);
                    while (elems[i].firstChild) {
                        cElem.appendChild(elems[i].firstChild);
                    }

                    dfx.insertBefore(elems[i], cElem);
                    dfx.remove(elems[i]);
                }
            });
        }

        // If fragment contains block level elements most likely we will need to
        // do some spliting so we do not have P tags in P tags etc.. Split the
        // container from current selection and then insert paste contents after it.
        if (this.viper.hasBlockChildren(fragment) === true) {
            // TODO: We should move handleEnter function to somewhere else and make it
            // a little bit more generic.
            var keyboardEditor = this.viper.ViperPluginManager.getPlugin('ViperKeyboardEditorPlugin');
            var range = this.viper.getCurrentRange();
            range.setStart(this._tmpNode, 0);
            range.collapse(true);

            var prevBlock = keyboardEditor.splitAtRange(true, range);
            if (!prevBlock) {
                prevBlock = this._tmpNode;
            } else {
                try {
                    if (!this._tmpNode.parentNode) {
                        this._tmpNode = prevBlock;
                    }
                } catch (e) {
                    // Guess which browser this try/catch block is for....
                }
            }

            if (dfx.trim(dfx.getNodeTextContent(prevBlock)) !== '') {
                prevBlock     = prevBlock.nextSibling;
            }

            if (prevBlock.nextSibling && dfx.trim(dfx.getNodeTextContent(prevBlock.nextSibling)) === '') {
                dfx.remove(prevBlock.nextSibling);
            }

            var convertBrTags = false;
            if (dfx.getParents(prevBlock, 'pre', this.viper.getViperElement()).length > 0) {
                convertBrTags = true;
            }

            var changeid  = ViperChangeTracker.startBatchChange('textAdded');
            var prevChild = null;
            while (fragment.firstChild) {
                if (prevChild === fragment.firstChild) {
                    break;
                }

                prevChild = fragment.firstChild;
                var ctNode = null;
                if (dfx.isBlockElement(fragment.firstChild) === true) {
                    ctNode = fragment.firstChild;
                    ViperChangeTracker.addChange('textAdd', [ctNode]);

                    if (convertBrTags === true) {
                        var brTags = dfx.getTag('br', ctNode);
                        for (var i = 0; i < brTags.length; i++) {
                            var textNode = document.createTextNode("\n");
                            dfx.insertBefore(brTags[i], textNode);
                            dfx.remove(brTags[i]);
                        }
                    }
                } else {
                    ctNode = ViperChangeTracker.createCTNode('ins', 'textAdd', fragment.firstChild);
                    ViperChangeTracker.addNodeToChange(changeid, ctNode);
                }

                dfx.insertBefore(prevBlock, ctNode);
            }

            ViperChangeTracker.endBatchChange(changeid);
        } else {
            var convertBrTags = false;
            if (dfx.getParents(this._tmpNode, 'pre', this.viper.getViperElement()).length > 0) {
                convertBrTags = true;
            }

            var changeid = ViperChangeTracker.startBatchChange('textAdded');
            var ctNode   = null;
            while (fragment.firstChild) {
                if (fragment.firstChild === ctNode) {
                    GUI.message('developer', 'Failed to move nodes', 'error');
                    break;
                }

                var child = fragment.firstChild;
                if (convertBrTags === true && dfx.isTag(child, 'br') === true) {
                    // Convert this BR tag to a new line character.
                    child = document.createTextNode("\n");
                    dfx.remove(fragment.firstChild);
                }

                ctNode = ViperChangeTracker.createCTNode('ins', 'textAdd', child);
                ViperChangeTracker.addNodeToChange(changeid, ctNode);
                dfx.insertBefore(this._tmpNode, ctNode);
            }

            ViperChangeTracker.endBatchChange(changeid);
        }//end if

        this._updateSelection();
        this.viper.cleanDOM();

        this.viper.fireNodesChanged();

    },

    _cleanWordPaste: function(content)
    {
        // Meta and link tags.
        if (!content) {
            return content;
        }

        content = dfx.trim(content);
        content = content.replace(/<(meta|link)[^>]+>/gi, "");

        // Comments.
        content = content.replace(/<!--(.|\s)*?-->/gi, '');

        // Remove style tags.
        content = content.replace(/<style>[\s\S]*?<\/style>/gi, '');

        // Remove span and o:p etc. tags.
        content = content.replace(/<\/?span[^>]*>/gi, "");
        content = content.replace(/<\/?\w+:[^>]*>/gi, '' );

        // Remove XML tags.
        content = content.replace(/<\\?\?xml[^>]*>/gi, '');

        // Generic cleanup.
        content = this._cleanPaste(content);

        // Convert Words orsm "lists"..
        content = this._convertWordPasteList(content);

        // Remove class, lang and style attributes.
        content = content.replace(/<(\w[^>]*) (class|lang)=([^ |>]*)([^>]*)/gi, "<$1$4");
        content = content.replace(/<(\w[^>]*) (align)=([^ |>]*)([^>]*)/gi, "<$1$4");
        content = content.replace(/<(\w[^>]*) (dir)=([^ |>]*)([^>]*)/gi, "<$1$4");

        var self = this;
        content  = content.replace(new RegExp('<(\\w[^>]*) style="([^"]*)"([^>]*)', 'gi'), function() {
            var styles      = arguments[2];
            var stylesList  = styles.split(';');
            var validStyles = [];
            var replacement = '';
            for (var i = 0; i < stylesList.length; i++) {
                var style = dfx.trim(stylesList[i].replace("\n", ''));
                if (self.isAllowedStyle(style) === true) {
                    validStyles.push(style);
                }
            }

            if (validStyles.length > 0) {
                styles      = validStyles.join(';');
                replacement = '<' + arguments[1] + ' style="' + styles + '"' + arguments[3];
            } else {
                replacement = '<' + arguments[1] + arguments[3];
            }

            return replacement;
        });

        // Convert viperListst attributes to style attributes.
        // This is required for the list-style-type CSS.
        content = content.replace(new RegExp('<(\\w[^>]*) _viperlistst="([^"]*)"([^>]*)', 'gi'), "<$1 style=\"$2\"$3");

        // Page breaks?
        content = content.replace('<br clear="all">', '');

        content = this._removeWordTags(content);

        content = this._convertTags(content);

        return content;

    },

    isAllowedStyle: function(style)
    {
        if (style.indexOf('mso-') === 0) {
            return false;
        }

        var styleName     = style.split(':');
        var allowedStyles = ['height', 'width', 'padding', 'text-align', 'text-indent', 'border-collapse', 'border', 'border-top', 'border-bottom', 'border-right', 'border-left'];
        if (allowedStyles.find(styleName[0]) >= 0) {
            return true;
        }

        return false;

    },

    _convertTags: function(content)
    {
        var tmp = document.createElement('div');
        dfx.setHtml(tmp, content);

        // Remove the INS tags.
        var insTags = dfx.getTag('ins', tmp);
        var ins     = null;
        while (ins = insTags.shift()) {
            while (ins.firstChild) {
                dfx.insertBefore(ins, ins.firstChild);
            }

            dfx.remove(ins);
        }

        // Remove the CENTER tags.
        var centerTags = dfx.getTag('center', tmp);
        var center     = null;
        while (center = centerTags.shift()) {
            var parent    = null;
            var childTags = dfx.getTag('*', center);
            if (childTags.length === 0) {
                parent = document.createElement('p');
            }

            while (center.firstChild) {
                if (parent) {
                    parent.appendChild(center.firstChild);
                } else {
                    dfx.insertBefore(center, center.firstChild);
                }
            }

            if (parent) {
                dfx.insertBefore(center, parent);
            }

            dfx.remove(center);
        }

        content = dfx.getHtml(tmp);

        return content;

    },

    _removeAttributes: function(content)
    {
        var tmp = document.createElement('div');
        dfx.setHtml(tmp, content);

        dfxjQuery(tmp).find('[class]').removeAttr('class');
        dfxjQuery(tmp).find('[style]').removeAttr('style');

        content = dfx.getHtml(tmp);
        return content;

    },

    _removeWordTags: function(content)
    {
        var tmp = document.createElement('div');
        dfx.setHtml(tmp, content);

        // Remove the link tags with no href attributes. Usualy for the footnotes.
        var aTags = dfx.getTag('a', tmp);
        var c     = aTags.length;
        for (var i = 0; i < c; i++) {
            var aTag = aTags[i];
            if (!aTag.getAttribute('href')) {
                if (dfx.isBlank(dfx.getHtml(aTag)) === false) {
                    while (aTag.firstChild) {
                        dfx.insertBefore(aTag, aTag.firstChild);
                    }
                }

                var parent = aTag.parentNode;
                dfx.remove(aTag);
                if (dfx.isBlank(dfx.getHtml(parent)) === true) {
                    dfx.remove(parent);
                }
            }
        }

        // Remove divs with ids starting with ftn (Footnotes).
        var tags = dfx.getTag('div', tmp);
        var c    = tags.length;
        for (var i = 0; i < c; i++) {
            var id = tags[i].getAttribute('id');
            if (id && id.indexOf('ftn') === 0) {
                var parent = tags[i].parentNode;
                dfx.remove(tags[i]);
                if (dfx.isBlank(dfx.getHtml(parent)) === true) {
                    dfx.remove(parent);
                }
            }
        }

        // Remove retarded P tags in between list elements...
        var lists = dfx.getTag('ol,ul', tmp);
        for (var i = 0; i < lists.length; i++) {
            var node = lists[i].firstChild;
            while (node) {
                if (dfx.isTag(node, 'li') === false) {
                    // Not a list item, remove it..
                    var removeNode = node;
                    node = node.nextSibling;
                    dfx.remove(removeNode);
                } else {
                    node = node.nextSibling;
                }
            }
        }

        // Remove any font tag with multiple children.
        var tags = dfx.find(tmp, 'font');
        for (var i = 0; i < tags.length; i++) {
            if (dfx.getTag('*', tags[i]).length > 1) {
                while (tags[i].firstChild) {
                    dfx.insertBefore(tags[i], tags[i].firstChild);
                }

                dfx.remove(tags[i]);
            }
        }

        // If the first element is a P tag and the next element is an empty font tag
        // then it must be a heading element.
        if (tmp.firstChild && dfx.isTag(tmp.firstChild, 'p') === true) {
            var firstChild = tmp.firstChild;
            var nextSibling = firstChild.nextSibling;
            while (nextSibling) {
                if (nextSibling.nodeType === dfx.TEXT_NODE && dfx.isBlank(dfx.trim(nextSibling.data)) === true) {
                    nextSibling = nextSibling.nextSibling;
                } else if (nextSibling && dfx.isTag(nextSibling, 'font') === true) {
                    if (dfx.getNodeTextContent(nextSibling) === '') {
                        // Conver this P tag to a H1 tag.
                        var newElement = document.createElement('h1');
                        while (firstChild.firstChild) {
                            newElement.appendChild(firstChild.firstChild);
                        }

                        dfx.insertBefore(firstChild, newElement);
                        dfx.remove(firstChild);
                    }

                    break;
                } else {
                    break;
                }
            }
        }//end if

        // Convert [strong + em ] + font + p tags to heading tags.
        var tags = dfx.find(tmp, 'font > p');
        var c    = tags.length;
        for (var i = 0; i < c; i++) {
            var parent      = tags[i].parentNode;
            var fontCount   = 0;
            var strongCount = 0;
            var emCount     = 0;
            var headingType = 0;
            var fontSize    = 0;
            var lastParent  = null;
            while (parent) {
                var tagName = dfx.getTagName(parent);
                if (tagName === 'font') {
                    lastParent = parent;
                    fontCount++;
                    if (parent.getAttribute('size')) {
                        fontSize = parseInt(parent.getAttribute('size'));
                    }
                } else if (tagName === 'em') {
                    lastParent = parent;
                    emCount++;
                } else if (tagName === 'strong') {
                    lastParent = parent;
                    strongCount++;
                    break;
                } else {
                    break;
                }

                if (!parent.parentNode) {
                    break;
                }

                parent = parent.parentNode;
            }

            if (strongCount >= 1) {
                if (fontCount >= 3 && fontSize >= 5) {
                    // H1.
                    headingType = 1;
                } else if (fontCount >= 3 && fontSize >= 4) {
                    headingType = 2;
                } else if (fontCount === 2 && emCount === 0) {
                    headingType = 3;
                } else if (fontCount === 2 && emCount >= 1) {
                    headingType = 4;
                }
            } else if (emCount === 0 && fontCount === 2) {
                headingType = 5;
            } else if (emCount === 1 && fontCount === 2) {
                headingType = 6;
            }

            if (headingType > 0) {
                var heading = document.createElement('h' + headingType);
                while (tags[i].firstChild) {
                    heading.appendChild(tags[i].firstChild);
                }

                dfx.insertBefore(lastParent, heading);
                dfx.remove(tags[i]);
            }
        }//end for

        if (this.viper.isBrowser('msie') === true) {
            var tags = dfx.find(tmp, 'strong > font > p');
            var c    = tags.length;
            for (var i = 0; i < c; i++) {
                var heading = document.createElement('h1');
                while (tags[i].firstChild) {
                    heading.appendChild(tags[i].firstChild);
                }

                dfx.insertBefore(tags[i].parentNode.parentNode, heading);
                dfx.remove(tags[i].parentNode.parentNode);
            }

            tags = dfx.find(tmp, 'strong > p');
            c    = tags.length;
            for (var i = 0; i < c; i++) {
                var heading = document.createElement('h1');
                while (tags[i].firstChild) {
                    heading.appendChild(tags[i].firstChild);
                }

                dfx.insertBefore(tags[i].parentNode, heading);
                dfx.remove(tags[i].parentNode);
            }

            tags = dfx.find(tmp, 'strong > em > p');
            c    = tags.length;
            for (var i = 0; i < c; i++) {
                var heading = document.createElement('h1');
                while (tags[i].firstChild) {
                    heading.appendChild(tags[i].firstChild);
                }

                dfx.insertBefore(tags[i].parentNode.parentNode, heading);
                dfx.remove(tags[i].parentNode.parentNode);
            }
        }

        // Remove font tags.
        // Must use regex here as IE8 has a bug with empty nodes and multiple parents
        // for DOM elemnts it seems like font tag is a major issue:
        // https://roadmap.squiz.net/viper/2288.
        content = dfx.getHtml(tmp);
        content = content.replace(/<(font)((\s+\w+(\s*=\s*(?:".*?"|\'.*?\'|[^\'">\s]+))?)+)?\s*>\s*/ig, '');
        content = content.replace(/\s*<\/(font)((\s+\w+(\s*=\s*(?:".*?"|\'.*?\'|[^\'">\s]+))?)+)?\s*>/ig, '');
        dfx.setHtml(tmp, content);

        // Remove empty tags.
        var tags = dfx.getTag('*', tmp);
        var c    = tags.length;
        for (var i = 0; i < c; i++) {
            this.removeEmptyNodes(tags[i]);
        }

        // Remove empty P tags.
        tags = dfx.getTag('p', tmp);
        var c    = tags.length;
        for (var i = 0; i < c; i++) {
            var tagContent = dfx.getHtml(tags[i]);
            if (tagContent === '&nbsp;' || dfx.isBlank(tagContent) === true) {
                dfx.remove(tags[i]);
            }
        }

        // Clean up list tags.
        tags = dfx.getTag('ol,ul', tmp);
        var c    = tags.length;
        for (var i = 0; i < c; i++) {
            dfx.removeAttr(tags[i], 'type');
            dfx.removeAttr(tags[i], 'start');
        }

        if (this.viper.isBrowser('msie') === true) {
            // Move any content that is not inside a paragraph in to a previous paragraph..
            var steps = 2;
            for (var i = 0; i < steps; i++) {
                // Do this twice to make sure IE8 has the correct DOM structure in the
                // second loop..
                var node      = tmp.firstChild;
                var prevBlock = null;

                while (node) {
                    if (dfx.isBlockElement(node) !== true) {
                        if (node.nodeType === dfx.TEXT_NODE) {
                            if (dfx.isBlank(dfx.trim(node.data)) === true) {
                                var currentNode = node;
                                node = node.nextSibling;
                                dfx.remove(currentNode);
                                continue;
                            }
                        }

                        if (!prevBlock) {
                            prevBlock = document.createElement('p');
                        }

                        if (node.nodeType !== dfx.TEXT_NODE && dfx.isStubElement(node) === false) {
                            prevBlock.appendChild(document.createTextNode(' '));
                        }

                        var currentNode = node;
                        node = node.nextSibling;
                        prevBlock.appendChild(currentNode);
                    } else {
                        if (dfx.trim(dfx.getHtml(node)).match(/^[^\w]$/)) {
                            // Only a single non-word character in this paragraph, move it
                            // to the previous one in the next loop.
                            var currentNode = node;
                            node = currentNode.firstChild;
                            dfx.insertBefore(currentNode, node);
                            dfx.remove(currentNode);
                        } else {
                            prevBlock = node;
                            node      = node.nextSibling;
                        }
                    }
                }

                content = dfx.getHtml(tmp);
                dfx.setHtml(tmp, content);
            }//end for
        }

        return content;

    },

    _getListType: function(elem, listTypes)
    {
        var elContent = dfx.getHtml(elem);
        elContent     = elContent.replace(/^(&nbsp;)+/m, '');
        elContent     = dfx.trim(elContent);

        var info      = null;
        dfx.foreach(listTypes, function(k) {
            dfx.foreach(listTypes[k], function(j) {
                dfx.foreach(listTypes[k][j], function(m) {
                    if ((new RegExp(listTypes[k][j][m])).test(elContent) === true) {
                        info = {
                            html: elContent.replace(new RegExp(listTypes[k][j][m]), ''),
                            listType: k,
                            listStyle: j
                        };

                        // Break from loop.
                        return false;
                    }
                });

                if (info !== null) {
                    // Break from loop.
                    return false;
                }
            });

            if (info !== null) {
                // Break from loop.
                return false;
            }
        });

        return info;

    },

    _convertWordPasteList: function(content)
    {
        var div        = document.createElement('div');
        var ul         = null;
        var prevLevel  = null;
        var indentLvl  = {};
        var li         = null;
        var newList    = true;

        var listTypes = {
            ul: {
                circle: ['^o(\s|&nbsp;)+'],
                disc: ['^' + String.fromCharCode(183) + '(\\s|&nbsp;)+'],
                square: ['^' + String.fromCharCode(167) + '(\\s|&nbsp;)+'],
                auto: ['^' + String.fromCharCode(8226) + '(\\s|&nbsp;)+']
            },
            ol: {
                decimal: ['^\\d+\\.(\s|&nbsp;)+'],
                'lower-roman': ['^[ivxlcdm]+\\.(\\s|&nbsp;)+'],
                'upper-roman': ['^[IVXLCDM]+\\.(\\s|&nbsp;)+'],
                'lower-alpha': ['^[a-z]+\\.(\\s|&nbsp;)+'],
                'upper-alpha': ['^[A-Z]+\\.(\\s|&nbsp;)+']
            }
        };

        dfx.setHtml(div, content);

        var pElems = dfx.getTag('p', div);
        var pln    = pElems.length;
        for (var i = 0; i < pln; i++) {
            var pEl          = pElems[i];
            var listTypeInfo = this._getListType(pEl, listTypes);

            if (listTypeInfo === null) {
                // Next list item will be the start of a new list.
                newList = true;
                continue;
            }

            var listType   = listTypeInfo.listType;
            var listStyle  = listTypeInfo.listStyle;
            var level      = pEl.getAttribute('style').match(/level([\d])+/mi);
            dfx.setHtml(pEl, listTypeInfo.html);

            if (!level) {
                level = 1;
            } else {
                level = level[1];
            }

            if (!listType) {
                listType = 'ol';
            }

            if (newList === true) {
                // Start a new list.
                ul        = document.createElement(listType);
                indentLvl = {};

                indentLvl[level] = ul;
                dfx.insertBefore(pEl, ul);
            } else {
                if (level !== prevLevel) {
                    if (dfx.isset(indentLvl[level]) === true) {
                        // Going back up.
                        ul = indentLvl[level];
                        for (var lv in indentLvl) {
                            if (lv > level) {
                                delete indentLvl[lv];
                            }
                        }
                    } else if (level > prevLevel) {
                        // Sub list, create a new list.
                        ul = document.createElement(listType);
                        //dfx.attr(ul, '_viperlistst', 'list-style-type:' + listStyle);
                        li.appendChild(ul);

                        indentLvl[level] = ul;
                    }
                }
            }

            // Create a new list item.
            li = this._createListItemFromElement(pEl);
            ul.appendChild(li);

            prevLevel = level;
            dfx.remove(pEl);
            newList = false;
        }//end for

        // Make sure the sub lists are inside list items.
        var lists = dfx.getTag('ul,ol', div);
        var lc    = lists.length;
        for (var i = 0; i < lc; i++) {
            var list = lists[i];
            if (dfx.isTag(list.parentNode, 'ul') === true
                || dfx.isTag(list.parentNode, 'ol') === true
            ) {
                // This sub list is sitting outside of an LI tag.
                // Find the previous list item and add this list to that item.
                var prevSibling = list.previousSibling;
                while (prevSibling) {
                    if (dfx.isTag(prevSibling, 'li') === true) {
                        prevSibling.appendChild(list);
                        break;
                    }

                    prevSibling = prevSibling.previousSibling;
                }
            }
        }

        // Make sure each list item is inside a list element.
        var listItems = dfx.getTag('li', div);
        var c         = listItems.length;
        for (var i = 0; i < c; i++) {
            var li = listItems[i];
            if (!li.parentNode || (dfx.isTag(li.parentNode, 'ul') !== true  && dfx.isTag(li.parentNode, 'ol') !== true)) {
                // This list item is not inside a list element.
                // If there is a list before this item join to it, if not create a
                // new list.

                var list = null;
                var sibling = li.previousSibling;
                while (sibling) {
                    if (sibling.nodeType === dfx.TEXT_NODE && dfx.trim(sibling.data) !== '') {
                        break;
                    } else if (dfx.isTag(sibling, 'ol') === true || dfx.isTag(sibling, 'ul') === true) {
                        list = sibling;
                        break;
                    } else if (sibling.nodeType === dfx.ELEMENT_NODE) {
                        break;
                    }

                    sibling = sibling.previousSibling;

                }

                if (list) {
                    list.appendChild(li);
                } else {
                    list = document.createElement('ul');
                    dfx.insertBefore(li, list);
                    list.appendChild(li);
                }
            }
        }

        content = dfx.getHtml(div);

        return content;

    },

    removeEmptyNodes: function(node)
    {
        if (node && node.nodeType === dfx.ELEMENT_NODE) {
            if ((!node.firstChild || dfx.isBlank(dfx.getHtml(node)) === true) && dfx.isStubElement(node) === false) {
                var parent = node.parentNode;
                parent.removeChild(node);
                this.removeEmptyNodes(parent);
            }
        }

    },

    _createListItemFromElement: function(elem)
    {
        var li = document.createElement('li');
        while (elem.firstChild) {
            li.appendChild(elem.firstChild);
        }

        return li;

    },

    _cleanPaste: function(content)
    {
        // Some generic content cleanup. Change all b/i tags to strong/em.
        content = content.replace(/<b(\s+|>)/gi, "<strong$1");
        content = content.replace(/<\/b(\s+|>)/gi, "</strong$1");
        content = content.replace(/<i(\s+|>)/gi, "<em$1");
        content = content.replace(/<\/i(\s+|>)/gi, "</em$1");
        content = content.replace(/<s(\s+|>)/gi, "<del$1");
        content = content.replace(/<\/s(\s+|>)/gi, "</del$1");
        content = content.replace(/<strike(\s+|>)/gi, "<del$1");
        content = content.replace(/<\/strike(\s+|>)/gi, "</del$1");
        return content;

    },

    _removeEditableAttrs: function(container)
    {
        // Copying content from an editable attribute is wrapped in editable
        // attribute. Not cool, so move the contents inside the editables out
        // and remove the empty editable attribute node.
        var editables = dfx.getClass('editable_attribute', container);

        var el = editables.length;
        for (var i = 0; i < el; i++) {
            this._moveChildren(editables[i]);
            dfx.remove(editables[i]);
        }

    },

    _moveChildren: function(cont)
    {
        // Moves the child nodes of cont before the cont.
        while (dfx.isset(cont.firstChild) === true) {
            dfx.insertBefore(cont, cont.firstChild);
        }

    },

    _updateSelection: function()
    {
        try {
            var range = this.viper.getCurrentRange();
            range.setStart(this._tmpNode, 0);
            range.collapse(true);
            ViperSelection.addRange(range);
        } catch (e) {}

        // Remove tmp nodes.
        dfx.remove(this.pasteElement);
        this._tmpNode     = null;
        this.pasteElement = null;

    }

};
