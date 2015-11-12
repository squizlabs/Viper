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

    this.pasteElement    = null;
    this.pasteValue      = null;
    this.rangeObj        = null;
    this.pasteType       = 'formatted';
    this.cutType         = 'formatted';
    this.allowedTags     = 'table|tr|td|th|ul|li|ol|br|p|a|img|form|input|select|option';
    this.convertTags     = null;
    this._tmpNode        = null;
    this._tmpNodeOffset  = 0;
    this._iframe         = null;
    this._isMSIE         = ViperUtil.isBrowser('msie');
    this._toolbarElement = null;
    this._selectedRows   = null;
    this._pasteProcess   = 0;
    this._isRightClick   = false;
    this._aggressiveMode = true;

}

ViperCopyPastePlugin.prototype = {
    init: function()
    {
        var self = this;
        this.viper.registerCallback('Viper:editableElementChanged', 'ViperCopyPastePlugin', function() {
            self._init();
        });

        this.viper.registerCallback(['Viper:dropped:text/html', 'Viper:dropped:Text'], 'ViperCopyPastePlugin', function(data) {
            if (!data.data) {
                return;
            }

            // Bookmark the current selection so that it can be deleted.
            var bookmark = null;
            if (data.origRange.collapsed === false) {
                bookmark = self.viper.createBookmark(data.origRange);
            }

            ViperSelection.addRange(data.range);
            var div = document.createElement('div');
            ViperUtil.setHtml(div, data.data);
            self._beforePaste(data.range);

            if (self._bookmark) {
                self._insertTmpNodeBeforeBookmark(self._bookmark);
            }

            self._handleFormattedPasteValue(false, div);

            if (bookmark) {
                self.viper.removeBookmark(bookmark);
            }

            return false;
        });

        this.viper.registerCallback(['Viper:rightMouseDown', 'Viper:mouseDown'], 'ViperCopyPastePlugin', function(data) {
            if (data.which === 3) {
                self._isRightClick = true;
            } else {
                self._isRightClick = false;
            }

            self._pasteProcess = 0;
        });

    },

    setSettings: function(settings)
    {
        if (ViperUtil.isset(settings.pasteType) === true) {
            this.pasteType = settings.pasteType;
        }

        if (ViperUtil.isset(settings.cutType) === true) {
            this.cutType = settings.cutType;
        }

        if (ViperUtil.isset(settings.allowedTags) === true) {
            this.allowedTags = settings.allowedTags;
        }

        if (ViperUtil.isset(settings.convertTags) === true) {
            this.convertTags = settings.convertTags;
        }

        if (ViperUtil.isset(settings.aggressiveMode) === true) {
            this._aggressiveMode = settings.aggressiveMode;
        }

    },

    _init: function()
    {
        var elem = this.viper.getViperElement();

        if (!elem) {
            return;
        }

        var self = this;
        if (this._isMSIE !== true) {
            elem.onpaste = function(e) {
                if (!e.clipboardData) {
                    return;
                }

                var dataType = null;
                if (e.clipboardData.types) {
                    if (ViperUtil.inArray('text/html', e.clipboardData.types) === true
                        && e.clipboardData.getData('text/html').length !== 0
                    ) {
                        dataType = 'text/html';
                    } else if (ViperUtil.inArray('text/plain', e.clipboardData.types) === true
                        && e.clipboardData.getData('text/plain').length !== 0
                    ) {
                        dataType = 'text/plain';
                    }
                }

                self._beforePaste();
                if (self.pasteType === 'formatted' || self.pasteType === 'formattedClean') {
                    if (dataType === null) {
                        dataType = 'text/html';
                    }

                    var files = ViperUtil.arraySearch('Files', e.clipboardData.types);

                    self.pasteElement = self._createPasteDiv();
                    var pasteContent  = e.clipboardData.getData(dataType);
                    if (dataType === 'text/plain') {
                        pasteContent = pasteContent.replace(/\r\n/g, '<br />');
                        pasteContent = pasteContent.replace(/\n/g, '<br />');
                    } else if (files === 0) {
                        var file = e.clipboardData.items[files];
                        var blob  = file.getAsFile();
                        self.readPastedImage(blob, function() {
                            var base64   = event.target.result;
                            pasteContent = '<img src="' + base64 + '"/>';
                            ViperUtil.setHtml(self.pasteElement, pasteContent);
                            self._handleFormattedPasteValue((self.pasteType === 'formattedClean'));
                        });

                        ViperUtil.preventDefault(e);
                        return false;
                    }

                    ViperUtil.setHtml(self.pasteElement, pasteContent);
                    self._handleFormattedPasteValue((self.pasteType === 'formattedClean'));
                } else {
                    if (dataType === null) {
                        dataType = 'text';
                    } else {
                        dataType = 'text/plain';
                    }

                    self._handleRawPasteValue(e.clipboardData.getData(dataType));
                }

                ViperUtil.preventDefault(e);
                return false;
            };

        } else {
            self._pasteProcess = 0;

            if (ViperUtil.isBrowser('msie', '<11') === true) {
                var cutPasteDiv    = null;
                elem.onbeforepaste = function() {
                    if (self._pasteProcess === 0) {
                        // This is the 2nd time the onbeforepaste is called when the right click menu is opened.
                        // Get the contents of the current selection and add Viper element so that it can be cleaned up in paste.
                        var range           = self.viper.getCurrentRange();
                        var selectedContent = '';
                        if (range.collapsed !== true) {
                            var selectedNode    = range.getNodeSelection();
                            var viperElem       = self.viper.getViperElement();
                            if (selectedNode && selectedNode !== viperElem) {
                                var surroundingParents = ViperUtil.getSurroundingParents(selectedNode, null, false, viperElem);
                                if (surroundingParents.length > 0) {
                                    selectedNode = surroundingParents.pop();
                                }

                                var tmp = document.createElement('div');
                                tmp.appendChild(selectedNode.cloneNode(true));
                                selectedContent = ViperUtil.getHtml(tmp);
                            } else {
                                selectedContent = range.getHTMLContents()
                            }

                            selectedContent = self._fixPartialSelection(selectedContent, range);
                        }

                        // Save the position where the paste needs to happen.
                        self._beforePaste();

                        // Remove the existing paste div.
                        cutPasteDiv = ViperUtil.getid('ViperPasteDivNew');
                        ViperUtil.remove(cutPasteDiv);

                        // Create the new tmp div with the currently selected content.  This content is used by cut and
                        // copy operations.
                        cutPasteDiv = document.createElement('div');
                        cutPasteDiv.innerHTML = selectedContent;
                        cutPasteDiv.id = 'ViperPasteDivNew';
                        elem.appendChild(cutPasteDiv);

                        if (selectedContent !== '') {
                            // Select all the contents of the temp element.
                            var firstChild = range._getFirstSelectableChild(cutPasteDiv);
                            var lastChild = range._getLastSelectableChild(cutPasteDiv);
                            if (cutPasteDiv.lastChild.nodeType === ViperUtil.ELEMENT_NODE) {
                                // Last child could be an image etc.
                                cutPasteDiv.appendChild(document.createTextNode(''));
                                range.setEnd(cutPasteDiv.lastChild, 0);
                            } else if (ViperUtil.isBrowser('msie', '<11') === true) {
                                range.setEnd(lastChild, lastChild.data.length);
                            } else {
                                range.setEnd(lastChild, lastChild.data.length);
                            }

                            // WORKING ON IE8
                            //if (ViperUtil.isBrowser('msie', '<11') === true) {
                              //  range.setStart(firstChild, 1);
                            //} else {
                                range.setStart(firstChild, 0);
                            //}

                            //range.setEnd(range._getLastSelectableChild(x), range._getLastSelectableChild(x).data.length);
                            //range.setStart(range._getFirstSelectableChild(x), 0);
                            ViperSelection.addRange(range);
                        }

                        // Give the focus to cut/paste temp div so that its contents are properly selected. When the user
                        // clicks the cut/copy/paste action in the right click menu, browser will use the cutPasteDiv
                        // as the source element.
                        cutPasteDiv.focus();

                        cutPasteDiv.onpaste = function() {
                            // Insert the tmpNode where the content is inserted before the bookmark that was created.
                            var bookmark = self._bookmark;
                            if (!bookmark.start.previousSibling) {
                                if (bookmark.start.parentNode !== self.viper.getViperElement()) {
                                    ViperUtil.insertBefore(bookmark.start.parentNode, self._tmpNode);
                                } else {
                                    ViperUtil.insertBefore(bookmark.start, self._tmpNode);
                                }
                            } else {
                                ViperUtil.insertBefore(bookmark.start, self._tmpNode);
                            }

                            // Since this is a paste remove the selected contents.
                            self.viper.removeBookmark(bookmark, true);

                            setTimeout(function() {
                                // Remove the temp div.
                                ViperUtil.remove(cutPasteDiv);

                                range.setStart(self._tmpNode, 0);
                                range.collapse(true);
                                ViperSelection.addRange(range);

                                // Use the cutPasteDiv to get the pasted content and inserted where the tmpNode is located.
                                self._handleFormattedPasteValue(null, cutPasteDiv);
                            }, 100);
                        };

                        if (selectedContent !== '') {
                            // Only add oncut and onpaste if there is something selected, if range is collapsed then
                            // there is no point of adding these events.
                            cutPasteDiv.oncut = function(e) {
                                var bookmark = self._bookmark;
                                if (!bookmark.start.previousSibling) {
                                    if (bookmark.start.parentNode !== self.viper.getViperElement()) {
                                        ViperUtil.insertBefore(bookmark.start.parentNode, self._tmpNode);
                                    } else {
                                        ViperUtil.insertBefore(bookmark.start, self._tmpNode);
                                    }
                                } else {
                                    ViperUtil.insertBefore(bookmark.start, self._tmpNode);
                                }

                                self.viper.removeBookmark(self._bookmark);

                                setTimeout(function() {
                                    ViperUtil.remove(cutPasteDiv);

                                    range.setStart(self._tmpNode, 0);
                                    range.collapse(true);
                                    ViperSelection.addRange(range);

                                    self.viper.fireCallbacks('Viper:cut');
                                    self.viper.fireNodesChanged();
                                    self.viper.fireSelectionChanged(range, true);
                                }, 5);
                            }

                            cutPasteDiv.oncopy = function(e) {
                                ViperUtil.remove(cutPasteDiv);
                                self.viper.selectBookmark(self._bookmark);

                                self.viper.fireCallbacks('Viper:copy');
                                self.viper.fireNodesChanged();
                                self.viper.fireSelectionChanged(null, true);
                            }
                        }//end if
                    }//end if

                    self._pasteProcess++;
                }//end if
            } else {
                var pasteDiv       = null;
                elem.onbeforepaste = function (e) {
                    if (self._pasteProcess === 0) {
                        // Initial call to onbeforepaste, happens when right click menu opens.
                        // Create the paste div.
                        pasteDiv = self._createPasteDiv(true);
                    } else if (self._pasteProcess === 2 || (self._pasteProcess === 1 && self._isRightClick === false)) {
                        // Third call to onbeforepaste, happens when paste option is clicked.
                        self._beforePaste();

                        // Give paste div the focus.
                        pasteDiv.focus();
                        var max = 0;
                        var t   = setInterval(function () {
                            if (pasteDiv.innerHTML !== '') {
                                pasteDiv.onpaste();
                                self._pasteProcess = 0;
                                clearInterval(t);
                            } else if (max > 10) {
                                self._pasteProcess = 0;
                                clearInterval(t);
                            }

                            max++;
                        }, 20);
                    }

                    self._pasteProcess++;
                };
            }//end if

        }//end if

        var onCopy = function(e) {
            var yCoord = null;
            if (ViperUtil.isBrowser('msie', '<11') === true) {
                yCoord = self.viper.getCaretCoords().y;
            }

            var range  = self.viper.getViperRange();

            // Create a clone of the current range as we are going to modify it.
            var rangeClone = range.cloneRange();

            // Get the contents of the current selection and add Viper element so that it can be cleaned up in paste.
            var selectedContent = '';
            var selectedNode    = range.getNodeSelection();
            var viperElem       = self.viper.getViperElement();
            if (selectedNode && selectedNode !== viperElem) {
                var surroundingParents = ViperUtil.getSurroundingParents(selectedNode, null, false, viperElem);
                if (surroundingParents.length > 0) {
                    selectedNode = surroundingParents.pop();
                }

                var tmp = document.createElement('div');
                tmp.appendChild(selectedNode.cloneNode(true));
                selectedContent = ViperUtil.getHtml(tmp);
            } else {
                selectedContent = range.getHTMLContents()
            }

            selectedContent = self._fixPartialSelection(selectedContent, range);
            selectedContent = '<b class="__viper_copy"> </b>' + selectedContent;

            // IE needs space before B tag otherwise it gets stripped out..
            if (ViperUtil.isBrowser('msie', '<9') === true) {
                selectedContent = '&nbsp;' + selectedContent + '&nbsp;';
            } else if (ViperUtil.isBrowser('msie', '>=11') === true) {
                selectedContent = '&nbsp;' + selectedContent;
            }

            // Chrome adds style information for the copied selection -.- To prevent this, use clipboardData.setData
            // method to set the modified content and prevent the default copy action.
            if (ViperUtil.isBrowser('chrome') === true || ViperUtil.isBrowser('safari') === true) {
                e.clipboardData.setData('text', range.rangeObj.toString());
                e.clipboardData.setData('text/html', selectedContent);
                ViperUtil.preventDefault(e);
                return false;
            }

            // Create a temp element and set the content as the selection content.
            var tmp = document.createElement('div');
            tmp.setAttribute('contenteditable', 'true');
            ViperUtil.addClass(tmp, 'Viper-copyDiv');
            document.body.appendChild(tmp);
            ViperUtil.setHtml(tmp, selectedContent);

            // Set the coords of the tmp element to be same as the current window scroll position so that when we move
            // the focus to the tmp element the page does not 'jump'.
            if (yCoord !== null) {
                ViperUtil.setStyle(tmp, 'top', yCoord + 'px');
            }

            if (ViperUtil.isBrowser('msie', '8') === true) {
                tmp.focus();
            }

            // Select the contents of the temp element.
            var firstChild = range._getFirstSelectableChild(tmp);
            var lastChild = range._getLastSelectableChild(tmp);
            if (tmp.lastChild.nodeType === ViperUtil.ELEMENT_NODE) {
                // Last child could be an image etc.
                tmp.appendChild(document.createTextNode(''));
                range.setEnd(tmp.lastChild, 0);
            } else if (ViperUtil.isBrowser('msie', '<11') === true) {
                range.setEnd(lastChild, lastChild.data.length - 1);
            } else {
                range.setEnd(lastChild, lastChild.data.length);
            }

            // WORKING ON IE8
            if (ViperUtil.isBrowser('msie', '<11') === true) {
                range.setStart(firstChild, 1);
            } else {
                range.setStart(firstChild, 0);
            }

            ViperSelection.addRange(range);

            // Browser's copy action will kick in and copy the selected contents in temp element.
            // After a time out remove the temp element and put the range back to original selection.
            setTimeout(function() {
                ViperUtil.remove(tmp);
                ViperSelection.addRange(rangeClone);
            }, 0);
        };

        elem.oncopy = onCopy;

        // Handle cut event for Chrome/FF/Safari.
        if (ViperUtil.isBrowser('msie', '<11') !== true) {
            elem.oncut = function(e) {
                onCopy(e);

                setTimeout(function() {
                    var keyboardEditor = self.viper.ViperPluginManager.getPlugin('ViperKeyboardEditorPlugin');
                    var fakeEvent      = self._getFakeKeyboardEvent();

                    if (keyboardEditor.handleDelete(fakeEvent) !== false || fakeEvent.prevent !== true) {
                        // Update the range object as it might have changed by handleDelete().
                        range = self.viper.getCurrentRange();
                        range.deleteContents(self.viper.getViperElement(), self.viper.getDefaultBlockTag());
                        ViperSelection.addRange(range);
                    }

                    self.viper.fireCallbacks('Viper:cut');

                    self.viper.fireNodesChanged();
                    self.viper.fireSelectionChanged();
                }, 5);
            }
       } else {
           /*elem.oncut = function(e) {
               return self._beforeCut(e, true);
           }*/
       }//end if

        // Handle drag/drop text in Webkit to prevent extra 'span' tags.
        if (ViperUtil.isBrowser('chrome') === true || ViperUtil.isBrowser('safari') === true) {
            ViperUtil.addEvent(elem, 'drop.' + self.viper.getEventNamespace(), function(e) {
                // Determine the selected content.
                var selectedContent = '';
                var rangeClone      = self.viper.getCurrentRange().cloneRange();
                var selectedNode    = rangeClone.getNodeSelection();
                if (selectedNode && selectedNode !== elem) {
                    var surroundingParents = ViperUtil.getSurroundingParents(selectedNode, null, false, elem);
                    if (surroundingParents.length > 0) {
                        selectedNode = surroundingParents.pop();
                    }

                    var tmp = document.createElement('div');
                    tmp.appendChild(selectedNode.cloneNode(true));
                    selectedContent = ViperUtil.getHtml(tmp);
                } else {
                    selectedContent = rangeClone.getHTMLContents()
                }

                if (!selectedContent) {
                    return;
                }

                // Make sure partially selected lists, tables etc dont have broken HTML.
                selectedContent = self._fixPartialSelection(selectedContent, rangeClone);

                // Create a bookmark if a node was not selected so that we can remove it later on.
                var bookmark = null;
                if (!selectedNode) {
                    bookmark = self.viper.createBookmark(rangeClone);
                }

                // Get the range from the mouse pointer (drop location).
                var rangeObj  = document.caretRangeFromPoint(e.originalEvent.clientX, e.originalEvent.clientY);
                var range     = new ViperMozRange(rangeObj);

                // Create the tmpNode that is used for pasting content.
                self._tmpNode = document.createTextNode(' ');
                range.insertNode(self._tmpNode);
                range.setStart(self._tmpNode, 0);
                range.collapse(true);
                ViperSelection.addRange(range);

                // Use the pasteContent method to simulate pasting.
                self._pasteContent(selectedContent, false, true);

                // Remove the original selected content. Note that we must use bookmark instead of range as the content
                // gets updated by pasteContent method. Also this content deletion cannot be done before inserting it to
                // new location as it moves the content and changes the drop location.
                if (selectedNode && selectedNode !== self.viper.getViperElement()) {
                    ViperUtil.remove(selectedNode);
                } else if (bookmark) {
                    self.viper.removeBookmark(bookmark);
                }

                ViperUtil.preventDefault(e);
            });
        }

    },

    readPastedImage: function(file, callback)
    {
        var reader = new FileReader();
        reader.onload = function (event) {
            var image = new Image();
            image.src = event.target.result;
            callback.call(this, image, file);
        };

        reader.readAsDataURL(file);

    },

    _getFakeKeyboardEvent: function()
    {
        var fakeEvent = {
            prevent: false,
            keyCode: 8,
            which: 8,
            preventDefault: function() {this.prevent = true;},
            stopPropagation: function() {}
        };

        return fakeEvent;
    },

    _beforeCut: function(e, rightClickCut)
    {
        // Get the coordinates of the caret. The temp div needs to be placed at same Y coords as the caret so that
        // when the focus is moved to this element there is no 'screen jump'.
        var yCoord = null;
        if (ViperUtil.isBrowser('msie', '<11') === true) {
            yCoord = this.viper.getCaretCoords().y;
        }

        var self       = this;
        var range      = self.viper.getViperRange();
        var rangeClone = range.cloneRange();

        if (ViperUtil.isBrowser('msie', '>=11') === true) {
            yCoord = window.pageYOffset;
        }

        // Get the contents of the current selection and add Viper element so that it can be cleaned up in paste.
        var selectedContent = '';
        var selectedNode    = range.getNodeSelection();
        var viperElem       = self.viper.getViperElement();
        if (selectedNode && selectedNode !== viperElem) {
            var surroundingParents = ViperUtil.getSurroundingParents(selectedNode, null, false, viperElem);
            if (surroundingParents.length > 0) {
                selectedNode = surroundingParents.pop();
            }

            var tmp = document.createElement('div');
            tmp.appendChild(selectedNode.cloneNode(true));
            selectedContent = ViperUtil.getHtml(tmp);
        } else {
            selectedContent = range.getHTMLContents()
        }

        // Need to make the temp element content editable so that cut event works.
        var tmp = document.createElement('div');
        tmp.setAttribute('contenteditable', 'true');
        ViperUtil.addClass(tmp, 'Viper-copyDiv');

        if (yCoord !== null) {
            ViperUtil.setStyle(tmp, 'top', yCoord + 'px');
        }

        tmp.oncut = function(e) {
            setTimeout(function() {
                // Remove the temp element.
                ViperUtil.remove(tmp);

                // Move the range back to original selection.
                ViperSelection.addRange(rangeClone);

                // Use the ViperKeyboardEditorPlugin to remove the selected contents, if it did not prevent default
                // use browsers deleteContents() method.
                var keyboardEditor = self.viper.ViperPluginManager.getPlugin('ViperKeyboardEditorPlugin');
                if (keyboardEditor.handleDelete({keyCode: 8, which: 8}) !== false) {
                    rangeClone = self.viper.getViperRange();
                    rangeClone.deleteContents(self.viper.getViperElement(), self.viper.getDefaultBlockTag());
                    ViperSelection.addRange(rangeClone);
                    self.viper.fireSelectionChanged();
                    self.viper.fireNodesChanged();
                } else {
                    ViperSelection.addRange(rangeClone);
                    self.viper.fireNodesChanged();
                    self.viper.fireSelectionChanged();
                }
            }, 0);
        }

        // Add the temp element to Viper element so that we do not need to change focus.
        this.viper.element.appendChild(tmp);

        if (ViperUtil.isBrowser('msie', '8') === true) {
            tmp.focus();
        }

        ViperUtil.setHtml(tmp, selectedContent);

        // Select the contents of the temp element.
        var firstChild = range._getFirstSelectableChild(tmp);
        var lastChild = range._getLastSelectableChild(tmp);
        if (!firstChild) {
            firstChild = document.createTextNode('');
            if (tmp.firstChild.childNodes.length > 0) {
                ViperUtil.insertBefore(tmp.firstChild.firstChild, firstChild);
            } else {
                ViperUtil.insertBefore(tmp.firstChild);
            }
        }

        if (!lastChild) {
            lastChild = document.createTextNode('');
            if (tmp.lastChild.childNodes.length > 0) {
                tmp.lastChild.appendChild(lastChild);
            } else {
                tmp.appendChild(lastChild);
            }
        }

        range.setEnd(lastChild, lastChild.data.length);
        range.setStart(firstChild, 0);
        ViperSelection.addRange(range);

        // When right click menu cut is used oncut event is not fired.
        if (rightClickCut === true) {
            tmp.oncut();
        }

    },

    _fixPartialSelection: function(selectedContent, range)
    {
        if (selectedContent.toLowerCase().indexOf('<li>') === 0) {
            // Selection is inside a list.
            // Get list type from selection.
            var parents = ViperUtil.getParents(range.startContainer, 'ul,ol');
            if (parents.length > 0) {
                var listType = ViperUtil.getTagName(parents[0]);
                selectedContent = '<' + listType + '>' + selectedContent + '</' + listType + '>';
            }
        } else {
            // Check for partial table selection.
            var tableMatch = selectedContent.match(/^<(caption|tr|td|tbody|th|tfoot|thead)/i);
            if (tableMatch) {
                // Add required wrapping table tags for the selected section.
                switch (tableMatch[1]) {
                    case 'td':
                        var re      = new RegExp(/<\/?(\w+)((\s+\w+(\s*=\s*(?:".*?"|'.*?'|[^'">\s]+))?)+\s*|\s*)\/?>/gim);
                        var resCont = selectedContent;
                        var count   = 0;
                        while ((match = re.exec(selectedContent)) != null) {
                            var rep = false;
                            if (match[0].indexOf('<td') === 0) {
                                count++;
                                rep = true;
                            } else if (match[0].indexOf('</td>') === 0) {
                                rep = true;
                            }

                            if (rep === true) {
                                resCont = resCont.replace(match[0], '');
                            }
                        }

                        if (count === 1) {
                            selectedContent = resCont;
                            break;
                        }


                        selectedContent = '<tr>' + selectedContent + '</tr>';

                    default:
                        selectedContent = '<table border="1" style="width: 100%;">' + selectedContent + '</table>';
                    break;
                }
            }
        }

        return selectedContent;

    },

    _beforePaste: function(range)
    {
        range         = range || this.viper.getCurrentRange();
        this.rangeObj = range.cloneRange();

        if (this._isTableSelection(range) === true) {
            return;
        }

        this._tmpNode = document.createTextNode('');
        this._tmpNodeOffset = 0;

        if (this._isMSIE === true) {
            this.rangeObj  = null;
            if (range.collapsed === true) {
                this._bookmark = this.viper.createBookmark();
                ViperUtil.insertBefore(this._bookmark.start, this._tmpNode);
            } else {
                this.viper.highlightSelection();
                this._bookmark = this.viper.createBookmarkFromHighlight();
                ViperUtil.insertBefore(this._bookmark.start, this._tmpNode);
            }
        } else {
            try {
                this.viper.insertNodeAtCaret(this._tmpNode);
            } catch (e) {
                this.viper.initEditableElement();
                this.viper.insertNodeAtCaret(this._tmpNode);
            }
        }

    },

    _isTableSelection: function(range)
    {
        this._selectedRows = null;
        var rows = [];
        if (ViperUtil.isBrowser('firefox') === true) {
            // Firefox has multiple range objects for each selected table cell.
            var ffRange = null;
            var i       = 0;
            while (ffRange = ViperSelection.getRangeAt(i)) {
                i++;
                var elem = ffRange.getStartNode();
                if (ViperUtil.isTag(elem, 'td') === false) {
                    // Not a table selection using Firefox range object. Try the generic way.
                    rows = [];
                    continue;
                }

                if (ViperUtil.inArray(elem.parentNode, rows) === false) {
                    rows.push(elem.parentNode);
                }
            }

            if (rows.length > 0) {
                this._selectedRows = rows;
                return true;
            }
        }

        var startNode = range.getStartNode();
        var endNode   = range.getEndNode();
        var elements  = ViperUtil.getElementsBetween(startNode, endNode);
        for (var i = 0; i < elements.length; i++) {
            var row = null;
            if (elements[i].nodeType === ViperUtil.TEXT_NODE) {
                continue;
            } else if (ViperUtil.isTag(elements[i], 'td') === false) {
                if (ViperUtil.isTag(elements[i], 'tr') === false) {
                    return false;
                } else {
                    row = elements[i];
                }
            } else {
                row = elements[i].parentNode;
            }

            if (ViperUtil.inArray(row, rows) === false) {
                rows.push(row);
            }
        }

        if (rows.length > 0) {
            this._selectedRows = rows;
            return true;
        }

        return false;
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
            ViperUtil.remove(this.pasteElement);
            this.pasteElement = null;
        }

    },

    _createPasteDiv: function(noIframe)
    {
        // If the old exists then get rid of it as a bit of an IE8 hack to address
        // pasting positioning problems as well as range non object issues.
        var oldEl = ViperUtil.getid('ViperPasteDiv');
        if (oldEl) {
            ViperUtil.remove(oldEl);
        }

        if (noIframe !== true) {
            var iframe   = this._createPasteIframe();
            iframe.id    = 'ViperPasteDivIframe';
            var frameDoc = ViperUtil.getIFrameDocument(iframe);
            this._iframe = iframe;
            return frameDoc.getElementById('ViperPasteIframeDiv');
        } else {
            var div = document.createElement('div');
            div.setAttribute('id', 'ViperPasteDiv');
            div.setAttribute('contentEditable', true);
            this.viper.addElement(div);

            var self = this;
            div.onpaste = function(e) {
                var bookmark = self._bookmark;
                self._insertTmpNodeBeforeBookmark(bookmark);

                self.viper.removeBookmark(bookmark);
                setTimeout(function() {
                    self._handleFormattedPasteValue(null, div);
                    self.viper.focus();
                }, 100);
            };

            return div;
        }

    },

    _insertTmpNodeBeforeBookmark: function (bookmark) {
        if (!bookmark.start.previousSibling) {
            if (bookmark.start.parentNode !== this.viper.getViperElement()) {
                ViperUtil.insertBefore(bookmark.start.parentNode, this._tmpNode);
            } else {
                ViperUtil.insertBefore(bookmark.start, this._tmpNode);
            }
        } else {
            ViperUtil.insertBefore(bookmark.start, this._tmpNode);
        }
    },

    _createPasteIframe: function(parent)
    {
        var iframe = document.createElement('iframe');
        iframe.src = 'about:blank';
        ViperUtil.addClass(iframe, 'ViperCopyPastePlugin-iframe');

        if (parent) {
            parent.appendChild(iframe);
        } else {
            this.viper.addElement(iframe);
        }

        var content = '<!DOCTYPE html><head>';
        content    += '</head><body style="overflow:hidden;margin:0;"><div id="ViperPasteIframeDiv" contentEditable="true" ';
        content    += 'style="-moz-box-sizing: border-box; box-sizing: border-box; width: 100%; height: 2.1em;outline:none;';
        content    += 'background: none repeat scroll 0 0 #2B2B2B;border-bottom: 1px solid #777777;border-radius: 0.4em 0.4em 0.4em 0.4em;'
        content    += 'border-top: 1px solid #000000;box-shadow: 0 0 3px #000000 inset;color: #999;';
        content    += 'display: block;padding: 4px 0.5em;position: relative;text-align: center;font-style:italic;font-family:arial;font-size:0.9em;';
        content    += 'overflow:hidden;';
        content    += '"></div></body></html>';

        var doc = ViperUtil.getIFrameDocument(iframe);
        doc.open();
        doc.write(content);
        doc.close();

        return iframe;

    },

    _handleFormattedPasteValue: function(stripTags, pasteElement)
    {
        pasteElement = pasteElement || this.pasteElement;

        // Check if the content was copied from Viper element.
        var isViperContent = false;
        var viperCopyElems = ViperUtil.getClass('__viper_copy', pasteElement);

        if (viperCopyElems.length === 0 && ViperUtil.isBrowser('msie', '<11') === true) {
            if (pasteElement.innerHTML.indexOf('<STRONG>&nbsp;</STRONG>') === 0
                || pasteElement.innerHTML.indexOf('<strong>&nbsp;</strong>') === 0
            ) {
                viperCopyElems = [pasteElement.firstChild];
            }
        }

        if (viperCopyElems.length === 1) {
            isViperContent = true;
            if (viperCopyElems[0].previousSibling) {
                // Remove white space before the B tag.
                ViperUtil.remove(viperCopyElems[0].previousSibling);
            }

            // Remove the B tag that was added by Viper during copy/cut.
            ViperUtil.remove(viperCopyElems[0]);
        }

        this.viper.removeNotAllowedAttributes(pasteElement);

        var html = ViperUtil.getHtml(pasteElement);
        if (isViperContent === true) {
            html = html.replace(/&nbsp;$/, '');
        }

        // Generic cleanup.
        html        = this._cleanPaste(html);
        var preHtml = html;

        if (isViperContent === true) {
            // Content copied from Viper.
            html = this._cleanViperPaste(html);
        } else if (this._isGoogleDocs(pasteElement) === true) {
            // Google Docs.
            html = this._cleanGoogleDocsPaste(html);
        } else {
            // Word etc..
            html    = this._cleanWordPaste(html);
            html    = this._removeAttributes(html);
            preHtml = html;
            html    = this._updateElements(html);
        }

        var tmp = document.createElement('div');
        ViperUtil.setHtml(tmp, html);
        this.viper.cleanDOM(tmp);
        html = ViperUtil.getHtml(tmp);

        var self = this;
        this.viper.fireCallbacks('ViperCopyPastePlugin:cleanPaste', {html: html, stripTags: stripTags}, function(obj, newHTML) {
            if (newHTML) {
                html = newHTML;
            }

            self._pasteContent(html, stripTags, isViperContent, preHtml);
        });

    },

    _pasteContent: function(html, stripTags, isViperContent, preHtml)
    {
        if (this._iframe) {
            ViperUtil.remove(this._iframe);
            this._iframe = null;
        }

        if (stripTags === true) {
            html = ViperUtil.stripTags(html, this.allowedTags.split('|'));
        }

        if (html) {
            html = ViperUtil.trim(html);

            if (isViperContent !== true) {
                html = this.viper.cleanHTML(html, ['dir', 'class', 'lang', 'align']);
            }
        }

        if (!html) {
            this._updateSelection();
            return;
        }

        var fragment = null;
        var range    = this.rangeObj || this.viper.getCurrentRange();
        if (ViperUtil.isBrowser('chrome') === true
            && range.startContainer === range.endContainer
            && ViperUtil.isTag(range.startContainer, 'br') === true
        ) {
            // Workaround for Chrome not being able to create fragment "in br".
            var tmpTextNode = document.createTextNode('');
            var rangeClone  = range.cloneRange();
            rangeClone.setStart(tmpTextNode);
            rangeClone.collapse(true);
            fragment = rangeClone.createDocumentFragment(html);
        } else {
            fragment = range.createDocumentFragment(html);
        }

        var convertTags = this.convertTags;
        if (stripTags === true && this.convertTags !== null) {
            ViperUtil.foreach(convertTags, function(tag) {
                var elems = ViperUtil.getTag(tag, fragment.firstChild);
                var ln    = elems.length;
                for (var i = 0; i < ln; i++) {
                    var cElem = document.createElement(convertTags[tag]);
                    while (elems[i].firstChild) {
                        cElem.appendChild(elems[i].firstChild);
                    }

                    ViperUtil.insertBefore(elems[i], cElem);
                    ViperUtil.remove(elems[i]);
                }
            });
        }

        if (this._selectedRows !== null) {
            // Table selection paste..
            var pastedRows = [];
            if (fragment.firstChild && ViperUtil.isTag(fragment.firstChild, 'table') === true
                && fragment.firstChild === fragment.lastChild
            ) {
                // Chrome.
                pastedRows = ViperUtil.getTag('tr', fragment.firstChild);
            } else if (fragment.firstElementChild && ViperUtil.isTag(fragment.firstElementChild, 'td') === true) {
                // Firefox only has the TD elements need to split them in to rows.
                var cellCount = ViperUtil.getTag('td', this._selectedRows[0]).length;
                var tr = null;
                var i  = 0;
                var node = null;
                while (node = fragment.firstElementChild) {
                    if (i % cellCount === 0) {
                        tr = document.createElement('tr');
                        pastedRows.push(tr);
                    }
                    tr.appendChild(node);
                    i++;
                }
            }

            if (pastedRows.length > 0) {
                // Replace selected rows with pasted rows.
                for (var i = 0; i < pastedRows.length; i++) {
                    ViperUtil.insertBefore(this._selectedRows[0], pastedRows[i]);
                }

                ViperUtil.remove(this._selectedRows);
                this._updateSelection();
                this.viper.cleanDOM();

                this.viper.fireNodesChanged();
                this.viper.fireCallbacks('ViperCopyPastePlugin:paste');
                return;
            } else {
                var td = ViperUtil.getTag('td', this._selectedRows[0])[0];
                ViperUtil.setHtml(td, ' ');
                this._tmpNode = td.firstChild;
            }

        }

        // If fragment contains block level elements most likely we will need to
        // do some spliting so we do not have P tags in P tags etc.. Split the
        // container from current selection and then insert paste contents after it.
        if (this.viper.hasBlockChildren(fragment) === true) {
            // TODO: We should move handleEnter function to somewhere else and make it
            // a little bit more generic.
            var keyboardEditor = this.viper.ViperPluginManager.getPlugin('ViperKeyboardEditorPlugin');
            var range = this.viper.getViperRange();
            range.setEnd(this._tmpNode, 0);
            range.collapse(false);
            var viperElem = this.viper.getViperElement();
            var prevBlock = null;
            if (viperElem.firstChild === viperElem.lastChild
                && (viperElem.firstChild === null || ViperUtil.isTag(viperElem.firstChild, 'br') === true)
            ) {
                if (viperElem.firstChild === null) {
                    viperElem.appendChild(this._tmpNode);
                } else {
                    ViperUtil.insertBefore(this._tmpNode, viperElem.firstChild);
                }
            } else {
                prevBlock = keyboardEditor.splitAtRange(true, range);
            }

            if (!prevBlock) {
                prevBlock = this._tmpNode;
            } else {
                try {
                    if (!this._tmpNode.parentNode) {
                        if (prevBlock.lastChild) {
                            this._tmpNode = prevBlock.lastChild;
                        } else {
                            this._tmpNode = prevBlock;
                        }
                    }
                } catch (e) {
                    // Guess which browser this try/catch block is for....
                    this._tmpNode = document.createTextNode('');
                    if (prevBlock.lastChild) {
                        ViperUtil.insertAfter(prevBlock.lastChild, this._tmpNode);
                    } else {
                        prevBlock.appendChild(this._tmpNode);
                    }
                }
            }

            var prevCheckCont = ViperUtil.trim(ViperUtil.getNodeTextContent(prevBlock));
            if (prevCheckCont !== '') {
                // Lets do another check for IE..
                if (prevCheckCont.length === 1 && prevCheckCont.charCodeAt(0) !== 160) {
                    prevBlock = prevBlock.nextSibling;
                }
            }

            if (prevBlock.nextSibling) {
                prevCheckCont = ViperUtil.trim(ViperUtil.getNodeTextContent(prevBlock.nextSibling));
                if (prevCheckCont === '' || (prevCheckCont.length === 1 && prevCheckCont.charCodeAt(0) === 160)) {
                    ViperUtil.remove(prevBlock.nextSibling);

                    if (prevBlock.lastChild) {
                        // Also remove the last child of prevBlock if its empty. This is to prevent things like:
                        // <blockquote><p>text</p><p>*</p></blockquote> where * is the paste location.
                        prevCheckCont = ViperUtil.trim(ViperUtil.getNodeTextContent(prevBlock.lastChild));
                        if (prevCheckCont === '' || (prevCheckCont.length === 1 && prevCheckCont.charCodeAt(0) === 160)) {
                            ViperUtil.remove(prevBlock.lastChild);
                        }
                    }
                }
            }

            if (ViperUtil.getParents(prevBlock, 'pre', this.viper.getViperElement()).length > 0) {
                var textNode = document.createTextNode(preHtml);
                ViperUtil.insertBefore(this._tmpNode, textNode);
            } else {
                var changeid    = ViperChangeTracker.startBatchChange('textAdded');
                var prevChild   = null;
                var lastChild   = null;
                var prevWrapper = null;
                while (fragment.lastChild) {
                    if (prevChild === fragment.lastChild) {
                        break;
                    }

                    if (ViperUtil.isTag(fragment.lastChild, 'img') === true) {
                        if (fragment.lastChild.src.match('%7E') !== null) {
                            fragment.lastChild.src = fragment.lastChild.src.replace('%7E', '~');
                        }
                    }

                    // Check child elements.
                    var images = ViperUtil.getTag('img', fragment.lastChild);
                    for (var i = 0; i < images.length; i++) {
                        if (images[i].src.match('%7E') !== null) {
                            images[i].src = images[i].src.replace('%7E', '~');
                        }
                    }

                    prevChild = fragment.lastChild;
                    var ctNode = null;
                    if (ViperUtil.isBlockElement(fragment.lastChild) === true && ViperUtil.isStubElement(fragment.lastChild) === false) {
                        prevWrapper = null;
                        ctNode = fragment.lastChild;
                        ViperChangeTracker.addChange('textAdd', [ctNode]);

                        if ((ViperUtil.isTag(ctNode, 'ul') === true
                            || ViperUtil.isTag(ctNode, 'ol') === true)
                            && ViperUtil.isTag(prevBlock, 'li') === true
                        ) {
                            // If this list is being pasted inside another list use its items instead.
                            var insAfter = prevBlock;
                            while (ctNode.firstChild) {
                                var firstChild = ctNode.firstChild;
                                ViperUtil.insertAfter(insAfter, firstChild);
                                insAfter = firstChild;
                            }
                        } else if (ViperUtil.isTag(ctNode, 'table') === true
                            && ViperUtil.getParents(prevBlock, 'table', this.viper.getViperElement()).length > 0
                        ) {
                            // Pasting table inside a table is not allowed. Just paste the tables content.
                            var tableContentTags = 'td,th,caption';
                            var contentNodes = ViperUtil.getTag(tableContentTags, ctNode);
                            while (contentNodes.length > 0) {
                                var contentNode = contentNodes.pop();
                                while (contentNode.childNodes.length > 0) {
                                    ViperUtil.insertAfter(prevBlock, contentNode.lastChild);
                                }
                            }
                        } else {
                            ViperUtil.insertAfter(prevBlock, ctNode);
                        }
                    } else {
                        // Text or stub element. If defaultTag is set then add wrap this node with the default tag.
                        var defaultTag = this.viper.getDefaultBlockTag();
                        ctNode         = fragment.lastChild;
                        if (defaultTag && prevWrapper === null) {
                            // No default tag was created before this so create a new one now.
                            ctNode = document.createElement(defaultTag);
                            ctNode.appendChild(fragment.lastChild);
                            prevWrapper = ctNode;
                        } else if (prevWrapper !== null) {
                            // Use the previous sibling default tag which was created by above code.
                            ViperUtil.insertBefore(prevWrapper.firstChild, fragment.lastChild);
                            continue;
                        }

                        ctNode = ViperChangeTracker.createCTNode('ins', 'textAdd', ctNode);
                        ViperChangeTracker.addNodeToChange(changeid, ctNode);
                        ViperUtil.insertAfter(prevBlock, ctNode);
                    }

                    if (lastChild === null) {
                        lastChild = ctNode;
                    }
                }

                // Check that previous container is not empty.
                if (prevBlock) {
                    prevCheckCont = ViperUtil.trim(ViperUtil.getNodeTextContent(prevBlock));
                    if (prevCheckCont === '' || (prevCheckCont.length === 1 && prevCheckCont.charCodeAt(0) === 160)) {
                        if (ViperUtil.isChildOf(this._tmpNode, prevBlock) === true) {
                            // Tmp node could be the child of this element (when paste is made in a new P tag for exammple).
                            this._tmpNode = range._getLastSelectableChild(prevBlock.nextSibling);
                            if (this._tmpNode) {
                                this._tmpNodeOffset = this._tmpNode.data.length;
                            } else {
                                this._tmpNodeOffset = 0;
                            }
                        }

                        ViperUtil.remove(prevBlock);
                    }
                }
            }//end if

            if (lastChild) {
                // Move the caret to the end of the last pasted content.
                var lastSelectable = range._getLastSelectableChild(lastChild);
                if (lastSelectable) {
                    this._tmpNode = lastSelectable;
                    this._tmpNodeOffset = this._tmpNode.data.length;
                }
            }

            ViperChangeTracker.endBatchChange(changeid);
        } else {
            if (ViperUtil.getParents(this._tmpNode, 'pre', this.viper.getViperElement()).length > 0) {
                var changeid = ViperChangeTracker.startBatchChange('textAdded');
                var ctNode   = null;
                var textNode = document.createTextNode(preHtml);
                var ctNode = ViperChangeTracker.createCTNode('ins', 'textAdd', textNode);
                ViperChangeTracker.addNodeToChange(changeid, ctNode);
                ViperUtil.insertBefore(this._tmpNode, ctNode);
            } else {
                if (this._tmpNode.parentNode === this.viper.getViperElement()) {
                    var defaultTag = this.viper.getDefaultBlockTag();
                    if (defaultTag) {
                        defaultTag = document.createElement(defaultTag);
                        ViperUtil.insertBefore(this._tmpNode, defaultTag);
                        defaultTag.appendChild(this._tmpNode);
                    }
                }

                while (fragment.firstChild) {
                    ViperUtil.insertBefore(this._tmpNode, fragment.firstChild);
                }
            }
        }//end if

        this._updateSelection();

        this.viper.fireNodesChanged();
        this.viper.fireSelectionChanged();
        this.viper.fireCallbacks('ViperCopyPastePlugin:paste');

    },

    _cleanWordPaste: function(content)
    {
        if (!content) {
            return content;
        }

        // Convert span.Apple-converted-space to normal space (Chrome only).
        if (ViperUtil.isBrowser('chrome') === true) {
            content = content.replace(/<span class="Apple-converted-space">&nbsp;<\/span>/g, ' ');
        }

        var tmp = document.createElement('div');
        ViperUtil.setHtml(tmp, content);
        this._convertSpansToStyleTags(tmp);

        // Clean Word track changes comments.
        var msocomanchor = ViperUtil.find(tmp, 'a[class="msocomanchor"]');
        ViperUtil.remove(msocomanchor);

        // Remove everything after this element.
        var msocomoff = ViperUtil.find(tmp, 'hr[class="msocomoff"]');
        if (msocomoff.length > 0) {
            msocomoff = msocomoff[0];
            while (msocomoff.nextSibling) {
                ViperUtil.remove(msocomoff.nextSibling);
            }

            ViperUtil.remove(msocomoff);
        }

        content = ViperUtil.getHtml(tmp);

        // Remove span and o:p etc. tags.
        content = content.replace(/<\/?span[^>]*>/gi, "");
        content = content.replace(/<\/?\w+:[^>]*>/gi, '' );

        // Remove XML tags.
        content = content.replace(/<\\?\?xml[^>]*>/gi, '');

        if (this._isMSIE === true) {
            // Remove the font tags here before putting the contents in to a
            // DOM object. In IE8 font tags are not in correct DOM strucutre,
            // there are cases similar to this: <font><p>invalid dom</font></p>.
            // This causes problems with spacing, and when the content is set as
            // the html attribute of DOM elements IE tries to fix it by creating
            // more paragraphs...
            content = content.replace(/<\/?font[^>]*>/gi, "");
        }

        // Convert Words orsm "lists"..
        content = this._convertWordPasteList(content);

        content = this._cleanStyleAttributes(content);

        // Page breaks?
        content = content.replace('<br clear="all">', '');
        content = this._removeWordTags(content);
        content = this._convertTags(content);

        return content;

    },

    _cleanViperPaste: function(content)
    {
        content = content.replace(/<(font)((\s+\w+(\s*=\s*(?:".*?"|\'.*?\'|[^\'">\s]+))?)+)?\s*>\s*/ig, '');
        content = content.replace(/\s*<\/(font)((\s+\w+(\s*=\s*(?:".*?"|\'.*?\'|[^\'">\s]+))?)+)?\s*>/ig, '');

        if (ViperUtil.isBrowser('msie') === true) {
            var tmp = document.createElement('div');
            ViperUtil.setHtml(tmp, content);

            // Remove all child tags inside links.
            var aTags = ViperUtil.find(tmp, 'a');
            for (var i = 0; i < aTags.length; i++) {
                var surrChildren = ViperUtil.getSurroundedChildren(aTags[i]);
                this._moveChildren(surrChildren[surrChildren.length - 1], surrChildren[0]);
                ViperUtil.remove(surrChildren);
            }

            content = ViperUtil.getHtml(tmp);
        }

        return content;

    },

    _cleanGoogleDocsPaste: function(content)
    {
        var tmp = document.createElement('div');
        ViperUtil.setHtml(tmp, content);

        var docParent = null;
        if (ViperUtil.isBlockElement(tmp.firstChild) === true) {
            docParent = tmp;
        } else {
            docParent = tmp.firstChild;
        }

        tmp = docParent;

        // Remove Google Doc id.
        var docIdElem = ViperUtil.find(tmp, '[id^="docs-internal-guid-"]');
        if (docIdElem.length > 0) {
            ViperUtil.removeAttr(docIdElem, 'id');
        }

        // Remove the wrapping b tag.
        var bTag = ViperUtil.getTag('b', tmp);
        if (bTag.length > 0) {
            ViperUtil.setHtml(tmp, ViperUtil.getHtml(bTag[0]));
        }

        content = ViperUtil.getHtml(tmp);
        content = this._cleanStyleAttributes(content, 'google_docs');

        // Convert span tags with styles to the proper tags.
        ViperUtil.setHtml(tmp, content);
        this._convertSpansToStyleTags(tmp);

        // Remove all p tags inside LI elements.
        var pInLI = ViperUtil.find(tmp, 'li > p');
        for (var i = 0; i < pInLI.length; i++) {
            while (pInLI[i].firstChild) {
                ViperUtil.insertBefore(pInLI[i], pInLI[i].firstChild);
            }

            ViperUtil.remove(pInLI[i]);
        }

        // Find all ol/ul tags inside other ol/ul tags.
        var nestedLists = ViperUtil.find(tmp, 'ol > ol,ol > ul, ul > ul, ul > ol');
        for (var i = 0; i < nestedLists.length; i++) {
            var list = nestedLists[i];
            // Get the previous list item.
            for (var prevSib = list.previousSibling; prevSib; prevSib = prevSib.previousSibling) {
                if (ViperUtil.isTag(prevSib, 'li') === false) {
                    continue;
                }

                // Found the previous list item, append this list to this list item.
                prevSib.appendChild(list);
                break;
            }
        }

        this._joinSplitLists(tmp);

        // Remove BR tags from main element.
        var brTags = ViperUtil.find(tmp, ' > br');
        if (brTags.length > 0) {
            ViperUtil.remove(brTags);
        }

        // Remove strong/em tags from H1..H6 elements.
        var strongAndEmTags = ViperUtil.find(tmp, 'h1 > strong,h2 > strong,h3 > strong,h4 > strong,h5 > strong,h6 > strong,h1 > em,h2 > em,h3 > em,h4 > em,h5 > em,h6 > em');
        for (var i = 0; i < strongAndEmTags.length; i++) {
            while (strongAndEmTags[i].firstChild) {
                ViperUtil.insertBefore(strongAndEmTags[i], strongAndEmTags[i].firstChild);
            }

            ViperUtil.remove(strongAndEmTags[i]);
        }

        content = ViperUtil.getHtml(tmp);

        // Remove all remaining span tags.
        content = content.replace(/<\/?span[^>]*>/gi, "");

        // Clean all font-weight etc.
        content = this._cleanStyleAttributes(content);

        return content;
    },

    _isGoogleDocs: function(elem)
    {
        if (elem.firstChild) {
            if (ViperUtil.isTag(elem.firstChild, 'b') === true
                || ViperUtil.isTag(elem.firstChild.nextSibling, 'b') === true
                || (elem.firstChild.id && elem.firstChild.id.indexOf('docs-internal-guid-') === 0)
            ) {
                // Firefox, IE.
                return true;
            } else if (ViperUtil.isTag(elem.firstChild, 'meta') === true
                && ViperUtil.isTag(elem.lastChild, 'b') === true
                || (elem.lastChild.id && elem.lastChild.id.indexOf('docs-internal-guid-') === 0)
            ) {
                // Chrome.
                return true;
            } else if (ViperUtil.find(elem, '[id^="docs-internal-guid-"]').length === 1) {
                // IE8.
                return true;
            }
        }

        return false;

    },

    _joinSplitLists: function(parentElement)
    {
        // If there are lists like <ol></ol><ol start="2"></ol><ol start="3"></ol> convert it to a single list.
        var lists = ViperUtil.find(parentElement, 'ol');
        for (var i = lists.length - 1; i >= 0; i--) {
            var list  = lists[i];
            var start = parseInt(ViperUtil.attr(list, 'start')) || 1;
            if (start > 1 && i > 0) {
                // The start attribute is set. Check if the list before this has (start - 1).
                var prevList  = lists[(i - 1)];
                var prevStart = parseInt(ViperUtil.attr(prevList, 'start')) || 1;
                if (prevStart === (start - 1)) {
                    var elemsBetween = ViperUtil.getElementsBetween(prevList, list);

                    // Move elements in between to the prevList last child.
                    var lastLi = ViperUtil.find(prevList, ' > li')[0];
                    for (var j = 0; j < elemsBetween.length; j++) {
                        lastLi.appendChild(elemsBetween[j]);
                    }

                    // Move the child list items of the current list to previous list.
                    while (list.firstChild) {
                        prevList.appendChild(list.firstChild)
                    }

                    ViperUtil.remove(list);
                }
            }
        }

    },

    _convertSpansToStyleTags: function(elem)
    {
        var validStyles = {
            'font-weight:\\s*bold': 'strong',
            'font-weight:\\s*(\\d+)': 'strong',
            'font-style:\\s*italic': 'em',
            'text-decoration:\\s*line-through': 'del',
            'vertical-align:\\s*sub': 'sub',
            'vertical-align:\\s*super': 'sup'
        };

        var spanTags = ViperUtil.getTag('span', elem);
        var regexs   = {};
        for (var i = 0; i < spanTags.length; i++) {
            var span     = spanTags[i];
            var newTag   = null;
            var outerTag = null;
            if (ViperUtil.hasAttribute(span, 'style') === true) {
                for (var style in validStyles) {
                    if (!regexs[style]) {
                        regexs[style] = new RegExp(style);
                    }

                    var match = ViperUtil.attr(span, 'style').match(regexs[style]);
                    if (match !== null) {
                        if (validStyles[style] === 'strong') {
                            // Incase the font-weight is a numeric value check if its 400+.
                            if (style === 'font-weight:\\s*(\\d+)' && match[1] <= 400) {
                                continue;
                            }
                        }

                        // Create a new tag for this style.
                        var t = document.createElement(validStyles[style]);

                        if (newTag) {
                            newTag.appendChild(t);
                        } else {
                            outerTag = t;
                        }

                        newTag = t;
                    }
                }
            }//end if

            if (newTag) {
                // A new tag was created insert the contents of the span to this new tag.
                while (span.firstChild) {
                    newTag.appendChild(span.firstChild);
                }

                ViperUtil.insertBefore(span, outerTag);
            } else {
                while (span.firstChild) {
                    ViperUtil.insertBefore(span, span.firstChild);
                }

            }

            // Remove this span tag.
            ViperUtil.remove(span);
        }//end for

    },

    _removeSpansWithNoAttributes: function(content)
    {
        var tmp = document.createElement('div');
        ViperUtil.setHtml(tmp, content);

        var spans = ViperUtil.getTag('span', tmp);
        for (var i = 0; i < spans.length; i++) {
            if (ViperUtil.hasAttribute(spans[i], 'lang') === false
                && ViperUtil.hasAttribute(spans[i], 'dir') === false
                && ViperUtil.hasAttribute(spans[i], 'style') === false
            ) {
                this._moveChildren(spans[i]);
                ViperUtil.remove(spans[i]);
            }
        }

        content = ViperUtil.getHtml(tmp);
        return content;

    },

    _cleanStyleAttributes: function(content, contentType)
    {
        var self  = this;
        var quote = '"';
        var replaceCallback = function() {
            var styles      = arguments[2];
            var stylesList  = styles.split(';');
            var validStyles = [];
            var replacement = '';
            for (var i = 0; i < stylesList.length; i++) {
                var style = ViperUtil.trim(stylesList[i].replace("\n", ''));
                if (self.isAllowedStyle(style, contentType) === true) {
                    validStyles.push(style);
                }
            }

            if (validStyles.length > 0) {
                styles    = validStyles.join(';');
                replacement = '<' + arguments[1] + ' style=' + quote + styles + quote + arguments[3];
            } else {
                replacement = '<' + arguments[1] + arguments[3];
            }

            return replacement;
        };

        content = content.replace(new RegExp('<(\\w[^>]*) style="([^"]*)"([^>]*)', 'gi'), replaceCallback);

        quote   = "'";
        content = content.replace(new RegExp('<(\\w[^>]*) style=\'([^\']*)\'([^>]*)', 'gi'), replaceCallback);

        return content;

    },

    isAllowedStyle: function(style, contentType)
    {
        if (style.indexOf('mso-') === 0) {
            return false;
        }

        var styleName     = style.split(':');
        var allowedStyles = ['height', 'width', 'list-style-type'];

        if (this._aggressiveMode === false) {
            // Aggressive mode is turned off, allow these styles.
            allowedStyles = allowedStyles.concat(['padding', 'text-align', 'text-indent', 'border-collapse', 'border', 'border-top', 'border-bottom', 'border-right', 'border-left']);
        }

        if (contentType === 'google_docs') {
            allowedStyles = allowedStyles.concat(['font-weight', 'font-style', 'vertical-align', 'text-decoration']);
        }

        if (ViperUtil.inArray(styleName[0], allowedStyles) === true) {
            // Style is allowed but its value might not be.
            var invalidStyleValues = {
                'text-indent': ['0px'],
                'text-align': ['start', 'left', 'initial'],
                'padding': ['0px'],
                'text-indent': ['0px']
            };

            if (!invalidStyleValues[styleName[0]]
                || ViperUtil.inArray(ViperUtil.trim(styleName[1]), invalidStyleValues[styleName[0]]) === false
            ) {
                return true;
            }
        }

        return false;

    },

    _convertTags: function(content)
    {
        var tmp = document.createElement('div');
        ViperUtil.setHtml(tmp, content);

        // Remove the INS tags.
        var insTags = ViperUtil.getTag('ins', tmp);
        var ins     = null;
        while (ins = insTags.shift()) {
            while (ins.firstChild) {
                ViperUtil.insertBefore(ins, ins.firstChild);
            }

            ViperUtil.remove(ins);
        }

        // Remove the CENTER tags.
        var centerTags = ViperUtil.getTag('center', tmp);
        var center     = null;
        while (center = centerTags.shift()) {
            var parent    = null;
            var childTags = ViperUtil.getTag('*', center);
            if (childTags.length === 0) {
                parent = document.createElement('p');
            }

            while (center.firstChild) {
                if (parent) {
                    parent.appendChild(center.firstChild);
                } else {
                    ViperUtil.insertBefore(center, center.firstChild);
                }
            }

            if (parent) {
                ViperUtil.insertBefore(center, parent);
            }

            ViperUtil.remove(center);
        }

        content = ViperUtil.getHtml(tmp);

        return content;

    },

    _removeAttributes: function(content)
    {
        var tmp = document.createElement('div');
        ViperUtil.setHtml(tmp, content);

        ViperUtil.$(tmp).find('[class]').removeAttr('class');
        ViperUtil.$(tmp).find('br[clear]').removeAttr('clear');

        // Remove all attributes from table related elements.
        var tableElements = ViperUtil.$(tmp).find('td,tr,table,tbody,tfoot,thead');
        var c = tableElements.length;
        for (var i = 0; i < c; i++) {
            var attributes = tableElements[i].attributes;

            if (ViperUtil.isTag(tableElements[i], 'td') === true
                || ViperUtil.isTag(tableElements[i], 'th') === true
            ) {
                if (!ViperUtil.trim(ViperUtil.getHtml(tableElements[i]))) {
                    if (this._isMSIE === true) {
                        ViperUtil.setHtml(tableElements[i], '&nbsp;');
                    } else {
                        ViperUtil.setHtml(tableElements[i], '<br />');
                    }
                }
            }

            for (var j = (attributes.length - 1); j >= 0; j--) {
                var attrName = attributes[j].name.toLowerCase();
                if (attrName === 'colspan' || attrName === 'rowspan') {
                    continue;
                }

                tableElements[i].removeAttribute(attrName);
            }
        }

        // Remove colgroup from tables.
        ViperUtil.remove(ViperUtil.$(tmp).find('colgroup'));

        content = ViperUtil.getHtml(tmp);
        return content;

    },

    _updateElements: function(content)
    {
        var tmp = document.createElement('div');
        ViperUtil.setHtml(tmp, content);

        // Set all table elements to have width=100%.
        var tables = ViperUtil.getTag('table', tmp);
        var c      = tables.length;

        for (var i = 0; i < c; i++) {
            var table = tables[i];

            ViperUtil.setStyle(tmp, 'display', 'none');
            this.viper.getViperElement().appendChild(tmp);

            ViperUtil.setStyle(table, 'width', '100%');

            // Determine if we need to add borders.
            var col         = ViperUtil.getTag('td,th', table)[0];
            var rightWidth  = parseInt(ViperUtil.getComputedStyle(col, 'border-right-width'));
            var bottomWidth = parseInt(ViperUtil.getComputedStyle(col, 'border-bottom-width'));
            if (bottomWidth === 0
                || rightWidth === 0
                || isNaN(bottomWidth) === true
                || isNaN(rightWidth) === true
            ) {
                ViperUtil.attr(table, 'border', 1);
            }

            // Convert TDs that are inside thead elements to THs.
            var thead = ViperUtil.getTag('thead', table);
            for (var j = 0; j < thead.length; j++) {
                var tds = ViperUtil.getTag('td', thead);
                for (var k = 0; k < tds.length; k++) {
                    var td = tds[k];
                    var th = document.createElement('th');
                    while (td.firstChild) {
                        th.appendChild(td.firstChild);
                    }

                    var colspan = ViperUtil.attr(td, 'colspan');
                    if (colspan) {
                        th.setAttribute('colspan', colspan);
                    }

                    var rowspan = ViperUtil.attr(td, 'rowspan');
                    if (rowspan) {
                        th.setAttribute('rowspan', rowspan);
                    }

                    ViperUtil.insertBefore(td, th);
                    ViperUtil.remove(td);
                }
            }

            ViperUtil.remove(tmp);
            ViperUtil.setStyle(tmp, 'display', 'auto');
        }//end for

        var defaultTag = this.viper.getDefaultBlockTag();
        if (defaultTag !== '') {
            var brs = ViperUtil.getTag('br', tmp);
            if (brs.length !== 0) {
                var br    = null;
                var first = true;
                while (br = brs.shift()) {
                    if (br.parentNode
                        && br.parentNode.firstChild === br
                        && ViperUtil.isBlockElement(br.parentNode) === true
                    ) {
                        ViperUtil.remove(br);
                        continue;
                    }

                    // Find the next double BR tag and replace them with a new
                    // block element (p, div, etc.).
                    if (ViperUtil.isTag(br.nextSibling, 'br') === true) {
                        while (ViperUtil.isTag(br.nextSibling, 'br') === true) {
                            // Remove the next BR.
                            ViperUtil.remove(brs.shift());
                        }

                        // Create the new wrapper element and insert it after the
                        // BR tag.
                        var wrapper = document.createElement(defaultTag);
                        ViperUtil.insertAfter(br, wrapper);

                        // We no longer need this BR.
                        ViperUtil.remove(br);

                        // If this is the first double BR found then move any
                        // content before them until a block tag is found or
                        // to the beginning of content in to a new block element.
                        var node = null;
                        if (first === true) {
                            first = false;
                            var preWrapper = document.createElement(defaultTag);
                            while (node = wrapper.previousSibling) {
                                if (ViperUtil.isBlockElement(node) === true) {
                                    break;
                                }

                                if (preWrapper.firstChild) {
                                    ViperUtil.insertBefore(preWrapper.firstChild, node);
                                } else {
                                    preWrapper.appendChild(node);
                                }
                            }

                            if (preWrapper.childNodes.length !== 0) {
                                ViperUtil.insertBefore(wrapper, preWrapper);
                            }
                        }

                        // Move all content after the new wrapper tag till next
                        // block element or double BR.
                        node = null;
                        while (node = wrapper.nextSibling) {
                            if (ViperUtil.isBlockElement(node) === true
                                || (ViperUtil.isTag(node, 'br') === true && ViperUtil.isTag(node.nextSibling, 'br') === true)
                            ) {
                                break;
                            } else if (node.nodeType !== ViperUtil.TEXT_NODE || node.data.length !== 0) {
                                wrapper.appendChild(node);
                            }
                        }

                        if (wrapper.childNodes.length === 0) {
                            ViperUtil.remove(wrapper);
                        }
                    }//end if
                }//end while
            }//end if
        }//end if

        content = ViperUtil.getHtml(tmp);
        return content;

    },

    _removeWordTags: function(content)
    {
        var tmp = document.createElement('div');
        ViperUtil.setHtml(tmp, content);

        // Remove the link tags with no href attributes. Usualy for the footnotes.
        var aTags = ViperUtil.getTag('a', tmp);
        var c     = aTags.length;
        for (var i = 0; i < c; i++) {
            var aTag = aTags[i];
            if (!aTag.getAttribute('href')) {
                if (ViperUtil.isBlank(ViperUtil.getHtml(aTag)) === false) {
                    while (aTag.firstChild) {
                        ViperUtil.insertBefore(aTag, aTag.firstChild);
                    }
                }

                var parent = aTag.parentNode;
                ViperUtil.remove(aTag);
                if (ViperUtil.isBlank(ViperUtil.getHtml(parent)) === true) {
                    ViperUtil.remove(parent);
                }
            } else {
                // Chrome adds slash at the end of the urls, trim them..
                aTag.setAttribute('href', aTag.getAttribute('href').replace(/\/$/, ''));

                // Outlook adds blocked:: prefix to hrefs. Remove it.
                aTag.setAttribute('href', aTag.getAttribute('href').replace(/^blocked::/i, ''));
            }
        }

        // Remove divs with ids starting with ftn (Footnotes).
        var tags = ViperUtil.getTag('div', tmp);
        var c    = tags.length;
        for (var i = 0; i < c; i++) {
            var id = tags[i].getAttribute('id');
            if (id && id.indexOf('ftn') === 0) {
                var parent = tags[i].parentNode;
                ViperUtil.remove(tags[i]);
                if (ViperUtil.isBlank(ViperUtil.getHtml(parent)) === true) {
                    ViperUtil.remove(parent);
                }
            }
        }

        // Remove retarded P tags in between list elements...
        var lists = ViperUtil.getTag('ol,ul', tmp);
        for (var i = 0; i < lists.length; i++) {
            var node = lists[i].firstChild;
            while (node) {
                if (ViperUtil.isTag(node, 'li') === false) {
                    while (node.firstChild) {
                        ViperUtil.insertBefore(node, node.firstChild);
                    }
                    ViperUtil.remove(node);
                    node = lists[i].firstChild;
                } else {
                    node = node.nextSibling;
                }
            }
        }

        // Remove the src attribute of images pointing to local path.
        var tags = ViperUtil.find(tmp, 'img');
        for (var i = 0; i < tags.length; i++) {
            var img = tags[i];
            if (img.getAttribute('src').indexOf('file://') === 0) {
                img.setAttribute('src', '');
            }
        }

        // Remove any font tag with multiple children.
        var tags = ViperUtil.find(tmp, 'font');
        for (var i = 0; i < tags.length; i++) {
            if (ViperUtil.getTag('*', tags[i]).length > 1) {
                while (tags[i].firstChild) {
                    ViperUtil.insertBefore(tags[i], tags[i].firstChild);
                }

                ViperUtil.remove(tags[i]);
            }
        }

        // If the first element is a P tag and the next element is an empty font tag
        // then it must be a heading element.
        if (tmp.firstChild && ViperUtil.isTag(tmp.firstChild, 'p') === true) {
            var firstChild = tmp.firstChild;
            var nextSibling = firstChild.nextSibling;
            while (nextSibling) {
                if (nextSibling.nodeType === ViperUtil.TEXT_NODE && ViperUtil.isBlank(ViperUtil.trim(nextSibling.data)) === true) {
                    nextSibling = nextSibling.nextSibling;
                } else if (nextSibling && ViperUtil.isTag(nextSibling, 'font') === true) {
                    if (ViperUtil.getNodeTextContent(nextSibling) === '') {
                        // Conver this P tag to a H1 tag.
                        var newElement = document.createElement('h1');
                        while (firstChild.firstChild) {
                            newElement.appendChild(firstChild.firstChild);
                        }

                        ViperUtil.insertBefore(firstChild, newElement);
                        ViperUtil.remove(firstChild);
                    }

                    break;
                } else {
                    break;
                }
            }
        }//end if

        // Convert [strong + em ] + font + p tags to heading tags.
        var tags = ViperUtil.find(tmp, 'font > p');
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
                var tagName = ViperUtil.getTagName(parent);
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

                ViperUtil.insertBefore(lastParent, heading);
                ViperUtil.remove(tags[i]);
            }
        }//end for

        if (ViperUtil.isBrowser('msie') === true) {
            var tags = ViperUtil.find(tmp, 'strong > font > p');
            var c    = tags.length;
            for (var i = 0; i < c; i++) {
                var heading = document.createElement('h1');
                while (tags[i].firstChild) {
                    heading.appendChild(tags[i].firstChild);
                }

                ViperUtil.insertBefore(tags[i].parentNode.parentNode, heading);
                ViperUtil.remove(tags[i].parentNode.parentNode);
            }

            tags = ViperUtil.find(tmp, 'strong > p');
            c    = tags.length;
            for (var i = 0; i < c; i++) {
                var heading = document.createElement('h1');
                while (tags[i].firstChild) {
                    heading.appendChild(tags[i].firstChild);
                }

                ViperUtil.insertBefore(tags[i].parentNode, heading);
                ViperUtil.remove(tags[i].parentNode);
            }

            tags = ViperUtil.find(tmp, 'strong > em > p');
            c    = tags.length;
            for (var i = 0; i < c; i++) {
                var heading = document.createElement('h1');
                while (tags[i].firstChild) {
                    heading.appendChild(tags[i].firstChild);
                }

                ViperUtil.insertBefore(tags[i].parentNode.parentNode, heading);
                ViperUtil.remove(tags[i].parentNode.parentNode);
            }
        }

        // Remove font tags.
        // Must use regex here as IE8 has a bug with empty nodes and multiple parents
        // for DOM elemnts it seems like font tag is a major issue:
        // https://roadmap.squiz.net/viper/2288.
        content = ViperUtil.getHtml(tmp);
        content = content.replace(/<(font)((\s+\w+(\s*=\s*(?:".*?"|\'.*?\'|[^\'">\s]+))?)+)?\s*>\s*/ig, '');
        content = content.replace(/\s*<\/(font)((\s+\w+(\s*=\s*(?:".*?"|\'.*?\'|[^\'">\s]+))?)+)?\s*>/ig, '');
        ViperUtil.setHtml(tmp, content);

        // Remove empty tags.
        var tags = ViperUtil.getTag('*', tmp);
        var c    = tags.length;
        for (var i = 0; i < c; i++) {
            this.removeEmptyNodes(tags[i]);
        }

        // Remove empty P tags.
        tags = ViperUtil.getTag('p', tmp);
        var c    = tags.length;
        for (var i = 0; i < c; i++) {
            var tagContent = ViperUtil.getHtml(tags[i]);
            if (tagContent === '&nbsp;' || ViperUtil.isBlank(tagContent) === true) {
                ViperUtil.remove(tags[i]);
            }
        }

        if (ViperUtil.isBrowser('msie') === true && ViperUtil.getTag('p', tmp).length > 0) {
            // Move any content that is not inside a paragraph in to a previous paragraph..
            var steps = 2;
            for (var i = 0; i < steps; i++) {
                // Do this twice to make sure IE8 has the correct DOM structure in the
                // second loop..
                var node      = tmp.firstChild;
                var prevBlock = null;

                while (node) {
                    if (ViperUtil.isBlockElement(node) !== true) {
                        if (node.nodeType === ViperUtil.TEXT_NODE) {
                            if (ViperUtil.isBlank(ViperUtil.trim(node.data)) === true) {
                                var currentNode = node;
                                node = node.nextSibling;
                                ViperUtil.remove(currentNode);
                                continue;
                            }
                        }

                        if (!prevBlock) {
                            prevBlock = document.createElement('p');
                        }

                        if (node.nodeType !== ViperUtil.TEXT_NODE && ViperUtil.isStubElement(node) === false) {
                            prevBlock.appendChild(document.createTextNode(' '));
                        }

                        var currentNode = node;
                        node = node.nextSibling;
                        prevBlock.appendChild(currentNode);
                    } else {
                        if (ViperUtil.trim(ViperUtil.getHtml(node)).match(/^[^\w]$/)) {
                            // Only a single non-word character in this paragraph, move it
                            // to the previous one in the next loop.
                            var currentNode = node;
                            node = currentNode.firstChild;
                            ViperUtil.insertBefore(currentNode, node);
                            ViperUtil.remove(currentNode);
                        } else {
                            prevBlock = node;
                            node      = node.nextSibling;
                        }
                    }
                }

                content = ViperUtil.getHtml(tmp);
                ViperUtil.setHtml(tmp, content);
            }//end for
        }

        // Convert MsoQuote to blockquote.
        var prevBlockquote = null;
        var quotes         = ViperUtil.find(tmp, '[class="MsoQuote"]');
        for (var i = 0; i < quotes.length; i++) {
            var quote = quotes[i];
            if (prevBlockquote === null || quote.previousElementSibling !== prevBlockquote) {
                prevBlockquote = document.createElement('blockquote');
                ViperUtil.insertBefore(quote, prevBlockquote);
            }

            prevBlockquote.appendChild(quote);

        }

        content = ViperUtil.getHtml(tmp);
        ViperUtil.setHtml(tmp, content);

        return content;

    },

    _getListType: function(elem, listTypes)
    {
        var style     = elem.getAttribute('style');
        var className = elem.getAttribute('class') || '';
        if (!style || (style.indexOf('mso-list') === -1 && className.indexOf('MsoList') === -1)) {
            return null;
        }

        var tmp   = document.createElement('div');
        var range = this.viper.getViperRange();

        var elContent = ViperUtil.getNodeTextContent(elem);
        elContent     = elContent.replace(/\n/, '');
        elContent     = elContent.replace(/^(&nbsp;)+/m, '');
        elContent     = ViperUtil.trim(elContent);
        var info      = null;
        ViperUtil.foreach(listTypes, function(k) {
            ViperUtil.foreach(listTypes[k], function(j) {
                ViperUtil.foreach(listTypes[k][j], function(m) {
                    var r = new RegExp(listTypes[k][j][m]);
                    if (r.test(elContent) === true) {
                        var origHtml = ViperUtil.getHtml(elem);
                        var html = origHtml.replace(/\n/mg, ' ');
                        html     = ViperUtil.trim(html);
                        html     = html.replace(/^(&nbsp;)+/m, '');
                        html     = html.replace(/(&nbsp;)+$/m, '');
                        html     = ViperUtil.trim(html);

                        var start = 1;
                        if (k === 'ol') {
                            var match = elContent.match(r);
                            if (match && match.length === 2) {
                                match = match[1].match(/\d+/);
                                if (match && parseInt(match[0])) {
                                    start = parseInt(match[0]);
                                }
                            }
                        }

                        var replacedHTML = html.replace(r, '');
                        if (replacedHTML === html) {
                            // The content must be in an inline tag. E.g. <strong>1.   </strong>.
                            ViperUtil.setHtml(tmp, html);
                            var firstChild  = range._getFirstSelectableChild(tmp);
                            firstChild.data = firstChild.data.replace(r, '');
                            replacedHTML    = ViperUtil.getHtml(tmp);
                        }

                        info = {
                            html: replacedHTML,
                            listType: k,
                            listStyle: j,
                            listStart: start,
                            origHtml: origHtml
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
        var prevType   = null;
        var styleToLvl = {};
        var prevCssStyle = null;

        var circleCharsArray = [111, 167, 183, 216, 222, 223, 252, 8721, 8226];
        var circleChars      = [];
        for (var i = 0; i < circleCharsArray.length; i++) {
            circleChars.push(String.fromCharCode(circleCharsArray[i]));
        }

        circleChars = circleChars.join('|');

        var listTypes = {
            ul: {
                circle: ['^(?:' + circleChars + ')(?:\\s|&nbsp;)+']
            },
            ol: {
                'i': ['^[ivxlcdm]+[\\.\\)](\\s|&nbsp;)+'],
                'I': ['^[IVXLCDM]+[\\.\\)](\\s|&nbsp;)+'],
                'a': ['^[a-z]+[\\.\\)](\\s|&nbsp;)+'],
                'A': ['^[A-Z]+[\\.\\)](\\s|&nbsp;)+'],
                decimal: ['^((?:\\d+|[a-z]+)[\\.\\)]?)+(?:\\s|&nbsp;)+']
            }
        };

        ViperUtil.setHtml(div, content);

        var pElems = ViperUtil.getTag('p', div);
        var pln    = pElems.length;
        for (var i = 0; i < pln; i++) {
            var pEl          = pElems[i];
            var listTypeInfo = this._getListType(pEl, listTypes);
            if (listTypeInfo === null) {
                // Next list item will be the start of a new list.
                newList = true;
                styleToLvl = {};
                prevLevel = null;
                continue;
            }

            var listType  = listTypeInfo.listType;
            var listStyle = listTypeInfo.listStyle;
            var level     = (pEl.getAttribute('style') || '').match(/level([\d])+/mi);
            var cssStyle  = pEl.getAttribute('style');
            ViperUtil.setHtml(pEl, listTypeInfo.html);

            if (listType === 'ol' && listTypeInfo.origHtml.indexOf('v') === 0) {
                // Change the list type to ul.
                // TODO: Might have to check font-family here incase this is part of a OL list a -> z.
                listType = 'ul';
            }

            if (!level) {
                level = prevLevel || 1;
            } else {
                level = level[1];
            }

            if (prevType !== listType && level === prevLevel) {
                newList = true;
            }

            prevType = listType;

            if (!listType) {
                listType = 'ol';
            }

            if (newList === true) {
                // Start a new list.
                ul        = document.createElement(listType);
                indentLvl = {};

                if (listTypeInfo.listStart > 1) {
                    ViperUtil.attr(ul, 'start', listTypeInfo.listStart);
                }

                if (listStyle !== 'decimal' && listStyle !== 'circle') {
                    ul.setAttribute('type', listStyle);
                }

                indentLvl[level] = ul;
                ViperUtil.insertBefore(pEl, ul);
            } else {
                if (level !== prevLevel) {
                    if (ViperUtil.isset(indentLvl[level]) === true) {
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

                        if (listStyle !== 'decimal' && listStyle !== 'circle') {
                            ul.setAttribute('type', listStyle);
                        }

                        li.appendChild(ul);

                        indentLvl[level] = ul;
                    }
                }
            }

            // Create a new list item.
            li = this._createListItemFromElement(pEl);
            ul.appendChild(li);

            prevLevel = level;
            ViperUtil.remove(pEl);
            newList = false;
        }//end for

        // Make sure the sub lists are inside list items.
        var lists = ViperUtil.getTag('ul,ol', div);
        var lc    = lists.length;
        for (var i = 0; i < lc; i++) {
            var list = lists[i];
            ViperUtil.removeAttr(list, 'style');
            if (ViperUtil.isTag(list.parentNode, 'ul') === true
                || ViperUtil.isTag(list.parentNode, 'ol') === true
            ) {
                // This sub list is sitting outside of an LI tag.
                // Find the previous list item and add this list to that item.
                var prevSibling = list.previousSibling;
                while (prevSibling) {
                    if (ViperUtil.isTag(prevSibling, 'li') === true) {
                        prevSibling.appendChild(list);
                        break;
                    }

                    prevSibling = prevSibling.previousSibling;
                }
            }
        }

        // Make sure each list item is inside a list element.
        var listItems = ViperUtil.getTag('li', div);
        var c         = listItems.length;
        for (var i = 0; i < c; i++) {
            var li = listItems[i];
            ViperUtil.removeAttr(li, 'style');
            if (!li.parentNode || (ViperUtil.isTag(li.parentNode, 'ul') !== true  && ViperUtil.isTag(li.parentNode, 'ol') !== true)) {
                // This list item is not inside a list element.
                // If there is a list before this item join to it, if not create a
                // new list.

                var list = null;
                var sibling = li.previousSibling;
                while (sibling) {
                    if (sibling.nodeType === ViperUtil.TEXT_NODE && ViperUtil.trim(sibling.data) !== '') {
                        break;
                    } else if (ViperUtil.isTag(sibling, 'ol') === true || ViperUtil.isTag(sibling, 'ul') === true) {
                        list = sibling;
                        break;
                    } else if (sibling.nodeType === ViperUtil.ELEMENT_NODE) {
                        break;
                    }

                    sibling = sibling.previousSibling;

                }

                if (list) {
                    list.appendChild(li);
                } else {
                    list = document.createElement('ul');
                    ViperUtil.insertBefore(li, list);
                    list.appendChild(li);
                }
            }
        }

        // Remove all p tags inside LI elements.
        var pInLI = ViperUtil.find(div, 'li > p');
        for (var i = 0; i < pInLI.length; i++) {
            while (pInLI[i].firstChild) {
                ViperUtil.insertBefore(pInLI[i], pInLI[i].firstChild);
            }

            ViperUtil.remove(pInLI[i]);
        }

        this._joinSplitLists(div);

        content = ViperUtil.getHtml(div);

        return content;

    },

    removeEmptyNodes: function(node)
    {
        if (node && node.nodeType === ViperUtil.ELEMENT_NODE) {
            if ((!node.firstChild || ViperUtil.isBlank(ViperUtil.getHtml(node)) === true) && ViperUtil.isStubElement(node) === false) {
                if (ViperUtil.isTag(node, 'td') !== true && ViperUtil.isTag(node, 'th') !== true) {
                    var parent = node.parentNode;
                    parent.removeChild(node);
                    this.removeEmptyNodes(parent);
                }
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
        content = ViperUtil.trim(content);

        // Clean head tags.
        content = content.replace(/<(meta|link|base)[^>]+>/gi, "");
        content = content.replace(/<title[\s\S]*?<\/title>/gi, '');
        content = content.replace(/<style[\s\S]*?<\/style>/gi, '');

        // Remove everything after <!--EndFragment--> on Chrome.
        var pos = content.indexOf('<!--EndFragment-->');
        if (pos > 0) {
            content = content.substr(0, pos);
        }

        // Comments.
        content = content.replace(/<!--(.|\s)*?-->/gi, '');

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

    _moveChildren: function(cont, beforeElem)
    {
        beforeElem = beforeElem || cont;

        // Moves the child nodes of cont before the cont.
        while (ViperUtil.isset(cont.firstChild) === true) {
            ViperUtil.insertBefore(beforeElem, cont.firstChild);
        }

    },

    _updateSelection: function()
    {
        try {
            if (this._tmpNode !== null) {
                var range = this.viper.getCurrentRange();
                range.setEnd(this._tmpNode, this._tmpNodeOffset);
                range.setStart(this._tmpNode, this._tmpNodeOffset);
                range.collapse(true);
                ViperSelection.addRange(range);
            }

            if (this._bookmark) {
                this.viper.removeBookmark(this._bookmark);
            }

            // Remove tmp nodes.
            ViperUtil.remove(this.pasteElement);
            this._tmpNode     = null;
            this.pasteElement = null;
        } catch (e) {
        }

    }

};
