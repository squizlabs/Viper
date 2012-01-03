/**
 * JS Class for the Viper Copy and Paste Plugin.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program as the file license.txt. If not, see
 * <http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt>
 *
 * @package    CMS
 * @subpackage Editing
 * @author     Squiz Pty Ltd <products@squiz.net>
 * @copyright  2010 Squiz Pty Ltd (ACN 084 670 600)
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPLv2
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
        if (this._isMSIE !== true && this._isFirefox !== true) {
            elem.onpaste = function(e) {
                if (!e.clipboardData || self._canPaste() === false) {
                    return;
                }

                self._beforePaste();
                if (self.pasteType === 'formatted' || self.pasteType === 'formattedClean') {
                    self.pasteElement = self._createPasteDiv();
                    dfx.setHtml(self.pasteElement, e.clipboardData.getData('text/html'));
                    self._handleFormattedPasteValue((self.pasteType === 'formattedClean'));
                } else {
                    self._handleRawPasteValue(e.clipboardData.getData('text'));
                }

                self._afterPaste();

                dfx.preventDefault(e);
                return false;
            };
        }//end if

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
        if (this._isMSIE === true ||this._isFirefox === true) {
            return this._fakePaste(e);
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
        document.body.appendChild(textInput);

        // Set the focus to textbox.
        textInput.focus();

        // Select the contents of the text box.
        textInput.select();

        // Select the bookmark and update caret position.
        this.viper.selectBookmark(bookmark);
        this.viper.fireNodesChanged('ViperCopyPastePlugin:cut');

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
        document.body.appendChild(div);

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

        this.viper.fireNodesChanged('ViperCopyPastePlugin:cut');

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
        if ((e.metaKey !== true && e.ctrlKey !== true) || e.keyCode !== 86) {
            return true;
        }

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

        document.body.appendChild(textInput);
        textInput.focus();

        var self          = this;
        textInput.onpaste = function() {
            setTimeout(function() {
                self._handleRawPasteValue(textInput.value);
                self.viper.fireNodesChanged('ViperCopyPastePlugin:paste');
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
        document.body.appendChild(div);

        return div;

    },

    _handleFormattedPaste: function(stripTags, e)
    {
        if (!this.pasteElement) {
            this.pasteElement = this._createPasteDiv();
        } else {
            dfx.empty(this.pasteElement);
        }

        this.pasteElement.focus();

        var self = this;
        this.pasteElement.onpaste = function(e) {
            setTimeout(function() {
               self._handleFormattedPasteValue(stripTags);
               self.viper.focus();
            }, 100);
        };

        return true;

    },

    _handleFormattedPasteValue: function(stripTags)
    {
        if (stripTags === true) {
            dfxjQuery(this.pasteElement).find('[style]').removeAttr('style');
            dfxjQuery(this.pasteElement).find('[class]').removeAttr('class');
        }

        this._removeEditableAttrs(this.pasteElement);

        // Clean paste from word document.
        var html = dfx.getHtml(this.pasteElement);
        html     = this._cleanWordPaste(html);

        if (stripTags === true) {
            html = dfx.stripTags(html, this.allowedTags.split('|'));
        }

        html = dfx.trim(html);

        if (!html) {
            this._updateSelection();
            return;
        }

        var fragment = this.rangeObj.createDocumentFragment(html);

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
            prevBlock     = prevBlock.nextSibling;

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
                } else {
                    ctNode = ViperChangeTracker.createCTNode('ins', 'textAdd', fragment.firstChild);
                    ViperChangeTracker.addNodeToChange(changeid, ctNode);
                }

                dfx.insertBefore(prevBlock, ctNode);
            }

            ViperChangeTracker.endBatchChange(changeid);
        } else {
            var changeid = ViperChangeTracker.startBatchChange('textAdded');
            var ctNode   = null;
            while (fragment.firstChild) {
                if (fragment.firstChild === ctNode) {
                    GUI.message('developer', 'Failed to move nodes', 'error');
                    break;
                }

                ctNode = ViperChangeTracker.createCTNode('ins', 'textAdd', fragment.firstChild);
                ViperChangeTracker.addNodeToChange(changeid, ctNode);
                dfx.insertBefore(this._tmpNode, ctNode);
            }

            ViperChangeTracker.endBatchChange(changeid);
        }//end if

        this._updateSelection();
        this.viper.cleanDOM();

        this.viper.fireNodesChanged('ViperCopyPastePlugin:paste');

    },

    _cleanWordPaste: function(content)
    {
        // Meta and link tags.
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

        content = this._convertDelNInsTags(content);

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

    _convertDelNInsTags: function(content)
    {
        var tmp = document.createElement('div');
        dfx.setHtml(tmp, content);

        var delTags = dfx.getTag('del', tmp);
        dfx.remove(delTags);

        var insTags = dfx.getTag('ins', tmp);
        var ins     = null;
        while (ins = insTags.shift()) {
            while (ins.firstChild) {
                dfx.insertBefore(ins, ins.firstChild);
            }

            dfx.remove(ins);
        }

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
                        fontSize = parent.getAttribute('size');
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

        // Remove font tags.
        var moreFontTags = true;
        while (moreFontTags === true) {
            var tags = dfx.getTag('font', tmp);
            if (tags.length === 0) {
                moreFontTags = false;
                break;
            }

            var c    = tags.length;
            for (var i = 0; i < c; i++) {
                // Find first none font parent and move the content up.
                var parent = tags[i];
                while (parent.parentNode) {
                    if (dfx.isTag(parent.parentNode, 'font') !== true) {
                        break;
                    }

                    parent = parent.parentNode;
                }

                while (tags[i].firstChild) {
                    dfx.insertBefore(parent, tags[i].firstChild);
                }

                dfx.remove(tags[i]);
            }
        }

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

        content = dfx.getHtml(tmp);

        return content;

    },

    _getListType: function(elem, listTypes)
    {
        var elContent = dfx.getHtml(elem);
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
        var prevMargin = null;
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
            if (listTypeInfo !== null) {
                var marginLeft = parseInt(dfx.getStyle(pEl, 'margin-left'));
                var listType   = listTypeInfo.listType;
                var listStyle  = listTypeInfo.listStyle;
                dfx.setHtml(pEl, listTypeInfo.html);

                if (!listType) {
                    listType = 'ol';
                }

                if (newList === true) {
                    // Start a new list.
                    ul        = document.createElement(listType);
                    indentLvl = {};
                    //dfx.attr(ul, '_viperlistst', 'list-style-type:' + listStyle);

                    indentLvl[marginLeft] = ul;
                    dfx.insertBefore(pEl, ul);
                } else {
                    // We determine start of sub lists by checking indentation.
                    // If previous margin and current margin is not the same
                    // then this is a sub-list or part of a parent list.
                    if (marginLeft !== prevMargin) {
                        if (dfx.isset(indentLvl[marginLeft]) === true) {
                            // Going back up.
                            ul = indentLvl[marginLeft];
                        } else if (marginLeft > prevMargin) {
                            // Sub list, create a new list.
                            ul = document.createElement(listType);
                            //dfx.attr(ul, '_viperlistst', 'list-style-type:' + listStyle);
                            li.appendChild(ul);

                            // Indent list.
                            indentLvl[marginLeft] = ul;
                        }
                    }
                }//end if

                // Create a new list item.
                li = this._createListItemFromElement(pEl);
                ul.appendChild(li);

                prevMargin = marginLeft;
                dfx.remove(pEl);
                newList = false;
            } else {
                // Next list item will be the start of a new list.
                newList = true;
            }//end if
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
        var range = this.viper.getCurrentRange();
        range.setStart(this._tmpNode, 0);
        range.collapse(true);
        ViperSelection.addRange(range);

        // Remove tmp nodes.
        dfx.remove(this.pasteElement);
        this._tmpNode     = null;
        this.pasteElement = null;

    }

};
