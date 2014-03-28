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

function ViperKeyboardEditorPlugin(viper)
{
    this.viper = viper;
    var self   = this;

    // Make sure Viper fires the keyDown event for ENTER.
    this.viper.addSpecialKey(13);

    this.viper.registerCallback('Viper:keyDown', 'ViperKeyboardEditorPlugin', function(e) {
        if (viper.isKey(e, 'ENTER') === true) {
            return self.handleEnter();
        } else if (viper.isKey(e, 'SHIFT+ENTER') === true) {
            return self.handleSoftEnter(e);
        } else if (viper.isKey(e, 'DELETE') === true || viper.isKey(e, 'BACKSPACE') === true) {
            return self.handleDelete(e);
        }
    });

    // When enter key is pressed at the end of these tags, the plugin will handle the
    // enter event instead of the browser.
    this._tagList = ('p|div|h1|h2|h3|h4|h5|h6|blockquote|section|main|article|aside').split('|');

}

ViperKeyboardEditorPlugin.prototype = {
    init: function()
    {
        var self = this;

        this.viper.registerCallback('ViperFormatPlugin:formatChanged', 'ViperKeyboardEditorPlugin', function(type) {
            if (type === 'pre') {
                self.cleanPreTags();
            }
        });

        // Note: Should be a format change since it will be used in the whole
        // container.
        ViperChangeTracker.addChangeType('splitContainer', 'Insert', 'format');
        ViperChangeTracker.setDescriptionCallback('splitContainer', function(node) {
            return self._getChangeDescription(node, 'splitContainer');
        });
        ViperChangeTracker.setApproveCallback('splitContainer', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('splitContainer', function(clone, node) {
            // Get previous sibling.
            var prev = node.previousSibling;
            if (!prev) {
                return;
            }

            while (node.firstChild) {
                prev.appendChild(node.firstChild);
            }

            ViperUtil.remove(node);
        });

        ViperChangeTracker.addChangeType('createContainer', 'Insert', 'insert');
        ViperChangeTracker.setDescriptionCallback('createContainer', function(node) {
            return self._getChangeDescription(node);
        });
        ViperChangeTracker.setApproveCallback('createContainer', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('createContainer', function(clone, node) {
            ViperUtil.remove(node);
        });

    },

    _getChangeDescription: function(node, changeType)
    {
        var pImgURL = this.viper.getStylesURL() + '/icon-p_tag.png';
        var pImg    = Viper.document.createElement('img');
        ViperUtil.attr(pImg, 'src', pImgURL);
        ViperUtil.attr(pImg, 'title', 'Paragraph Break');
        var desc = pImg;

        if (changeType !== 'splitContainer') {
            for (var child = node.firstChild; child; child = child.nextSibling) {
                if (child.nodeType === ViperUtil.TEXT_NODE && ViperUtil.trim(child.nodeValue).length === 0) {
                    continue;
                } else if (ViperChangeTracker.isTrackingNode(child) === true) {
                    var ctnType = ViperChangeTracker.getCTNTypeFromNode(child);
                    if (ViperChangeTracker.isInsertType(ctnType) === true) {
                        var extraDesc = ViperChangeTracker.getDescriptionForNode(child);
                        if (ViperUtil.isObj(extraDesc) === false) {
                            extraDesc = Viper.document.createTextNode(extraDesc);
                        }

                        desc = [desc, extraDesc];
                    }
                }//end if

                break;
            }//end for
        }

        return desc;

    },

    _isKeyword: function()
    {
        var keywordPlugin = this.viper.ViperPluginManager.getPlugin('ViperKeywordPlugin');
        if (!keywordPlugin) {
            return false;
        }

        var range = this.viper.getCurrentRange();
        if (keywordPlugin._isKeyword(range.startContainer) === false && keywordPlugin._isKeyword(range.startContainer) === false) {
            return false;
        }

        return true;

    },

    handleTab: function()
    {
        if (this._isKeyword() === true) {
            return true;
        }

        var numSpaces = 4;
        // Insert.
        var sp = String.fromCharCode(160);
        var c  = '';
        while (numSpaces-- > 0) {
            c += sp;
        }

        this.viper.insertNodeAtCaret(c);

        this.viper.fireNodesChanged('ViperKeyboardEditorPlugin:tab');

        return true;

    },

    handleEnter: function(returnFirstBlock)
    {
        this.viper.fireCallbacks('ViperKeyboardEditorPlugin:beforeEnter');

        var defaultTagName = this.viper.getDefaultBlockTag();
        var self = this;

        if (ViperChangeTracker.isTracking() !== true) {
            var range     = this.viper.getCurrentRange();
            var endNode   = range.getEndNode();
            var startNode = range.getStartNode();

            if (!endNode) {
                if (startNode) {
                    endNode = startNode;
                } else if (range.startContainer.nodeType === ViperUtil.ELEMENT_NODE
                    && !range.startContainer.childNodes[range.startOffset]
                    && range.startContainer.childNodes[(range.startOffset - 1)]
                ) {
                    endNode = range.startContainer.childNodes[(range.startOffset - 1)];
                } else if (range.startContainer.nodeType === ViperUtil.ELEMENT_NODE
                    && range.startContainer.childNodes.length === 0
                    && !endNode
                ) {
                    endNode = range.startContainer;
                }
            }

            try {
                if (!startNode && !endNode && range.collapsed === true && ViperUtil.isTag(range.startContainer, 'br') === true) {
                    startNode = range.startContainer;
                    endNode   = startNode;
                }

                if (endNode
                    && endNode.nodeType === ViperUtil.TEXT_NODE
                    && ViperUtil.trim(ViperUtil.trim(endNode.data)).replace(String.fromCharCode(160), '') === ''
                ) {
                    endNode.data = '';
                }
            } catch (e) {
                // IE error catch...
                return;
            }

            // Break out of blockquote tag when enter is pressed twice at the start, end and middle of a P tag in a
            // blockquote.
            if (range.collapsed === true
                && (startNode && startNode.nodeType === ViperUtil.TEXT_NODE || ViperUtil.isTag(startNode, 'br') === true)
                && !startNode.previousSibling
                && range.startOffset === 0
                && ViperUtil.getParents(startNode, 'blockquote', this.viper.getViperElement()).length > 0
                && ViperUtil.isTag(ViperUtil.getFirstBlockParent(startNode), 'p') === true
            ) {
                // Make sure this is not the first P tag in a blockquote.
                var parentPtag = ViperUtil.getFirstBlockParent(startNode);
                var prevTag    = parentPtag.previousSibling;
                while (prevTag) {
                    if (ViperUtil.isBlockElement(prevTag) === true) {
                        break;
                    }

                    prevTag = prevTag.previousSibling;
                }

                if (prevTag) {
                    var parentBlockquote = ViperUtil.getParents(parentPtag, 'blockquote', this.viper.getViperElement())[0];
                    var newBlockquote    = parentBlockquote.cloneNode(false);

                    // Move the sibliings after the current P tag to the new blockquote element.
                    if (parentPtag.nextSibling) {
                        // Do not move empty block elements.
                        while (parentPtag.nextSibling) {
                            if (this.isEmptyBlockElement(parentPtag.nextSibling) === true) {
                                ViperUtil.remove(parentPtag.nextSibling);
                            } else {
                                newBlockquote.appendChild(parentPtag.nextSibling);
                            }
                        }

                        ViperUtil.insertBefore(newBlockquote.firstChild, parentPtag);
                    } else {
                        newBlockquote.appendChild(parentPtag);
                    }

                    // If the current P tag is empty then remove it. This happens when the caret is at the end of a P
                    // tag and enter is pressed twice.
                    if (this.isEmptyBlockElement(parentPtag) === true) {
                        ViperUtil.remove(parentPtag);
                    }

                    // Final check to make sure that we do not create an empty blockquote element.
                    ViperUtil.removeEmptyNodes(newBlockquote);
                    if (this.isEmptyBlockElement(newBlockquote) === false) {
                        ViperUtil.insertAfter(parentBlockquote, newBlockquote);
                    }

                    // Create a new P tag to be placed between two blockquotes.
                    var midP = document.createElement('p');
                    midP.appendChild(document.createElement('br'));
                    ViperUtil.insertAfter(parentBlockquote, midP);

                    // Set the caret to the newly created P tag.
                    range.selectNode(midP.firstChild);
                    range.collapse(true);
                    ViperSelection.addRange(range);
                    this.viper.fireSelectionChanged();
                    return false;
                }
            }//end if

            var firstBlock = ViperUtil.getFirstBlockParent(endNode);
            if (range.collapsed === true
                && ((endNode.nodeType === ViperUtil.TEXT_NODE && range.endOffset === endNode.data.length)
                || endNode.nodeType === ViperUtil.ELEMENT_NODE && ViperUtil.isTag(endNode, 'br'))
                && (!endNode.nextSibling || ViperUtil.isTag(endNode.nextSibling, 'br') === true && !endNode.nextSibling.nextSibling)
                && (range._getLastSelectableChild(firstBlock, true) === endNode
                || range._getLastSelectableChild(firstBlock, true) === null && ViperUtil.isTag(endNode, 'br') === true || (endNode.nodeType === ViperUtil.TEXT_NODE && endNode.data.length === 0))
            ) {
                if (firstBlock && !defaultTagName && firstBlock === this.viper.getViperElement()) {
                    var br = document.createElement('br');
                    this.viper.insertNodeAtCaret(br);
                    if (!br.nextSibling) {
                        ViperUtil.insertAfter(br, document.createElement('br'));
                    }

                    range.setStart(br.nextSibling, 0);
                    range.collapse(true);
                    ViperSelection.addRange(range);

                    return false;
                } else if (firstBlock) {
                    var firstBlockTagName = ViperUtil.getTagName(firstBlock);
                    var handleEnter       = false;
                    var removeFirstBlock  = false;
                    if (ViperUtil.inArray(firstBlockTagName, this._tagList) === true) {
                        handleEnter = true;
                    } else if (firstBlockTagName === 'li'
                        && (ViperUtil.isBrowser('chrome') === true || ViperUtil.isBrowser('safari') === true)
                        && ViperUtil.trim(ViperUtil.getNodeTextContent(firstBlock)) === ''
                    ) {
                        handleEnter = true;
                        removeFirstBlock = true;
                    }

                    if (handleEnter === true) {
                        if (defaultTagName === '') {
                            var br = document.createElement('br');
                            ViperUtil.insertAfter(firstBlock, br);
                            range.setStart(br, 0);
                            range.collapse(true);
                            ViperSelection.addRange(range);
                            return false;
                        }

                        var content = '<br />';
                        if (ViperUtil.isBrowser('msie') === true) {
                            content = '&nbsp;';
                        }

                        var tagName = defaultTagName;
                        var p = document.createElement(tagName);
                        ViperUtil.setHtml(p, content);

                        // If the firstBlock is a P tag and it's parent is not the
                        // Viper editable element and its the last child then move this
                        // new P tag after its parent element.
                        if (ViperUtil.isTag(firstBlock, 'p') === true
                            && firstBlock.parentNode !== this.viper.getViperElement()
                            && !firstBlock.nextSibling
                            && ViperUtil.trim(ViperUtil.getNodeTextContent(firstBlock)) === ''
                        ) {
                            ViperUtil.insertAfter(firstBlock.parentNode, p);
                            removeFirstBlock = true;
                        } else {
                            if (firstBlockTagName === 'li') {
                                if (ViperUtil.isBrowser('chrome') === true || ViperUtil.isBrowser('safari') === true) {
                                    var parentListItem = ViperUtil.getFirstBlockParent(firstBlock.parentNode);
                                    if (parentListItem && ViperUtil.isTag(parentListItem, 'li') === true) {
                                        newList = document.createElement('li');
                                        newList.appendChild(document.createElement('br'));

                                        var subList = null;
                                        while (firstBlock.nextSibling) {
                                            if (ViperUtil.isTag(firstBlock.nextSibling, 'li') === true) {
                                                if (!subList) {
                                                    subList = document.createElement(ViperUtil.getTagName(firstBlock.parentNode));
                                                    newList.appendChild(subList);
                                                }

                                                subList.appendChild(firstBlock.nextSibling);
                                            } else if (subList) {
                                                subList.appendChild(firstBlock.nextSibling);
                                            } else {
                                                newList.appendChild(firstBlock.nextSibling);
                                            }
                                        }

                                        ViperUtil.remove(firstBlock);
                                        ViperUtil.insertAfter(parentListItem, newList);
                                        range.selectNode(newList.firstChild);
                                        range.collapse(true);
                                        ViperSelection.addRange(range);
                                        return false;
                                    }
                                }

                                // Need to move rest of the list items to a new
                                // list.
                                var newList = document.createElement(ViperUtil.getTagName(firstBlock.parentNode));
                                while (firstBlock.nextSibling) {
                                    newList.appendChild(firstBlock.nextSibling);
                                }

                                if (ViperUtil.getTag('li', newList).length > 0) {
                                    ViperUtil.insertAfter(firstBlock.parentNode, newList);
                                }

                                ViperUtil.insertAfter(firstBlock.parentNode, p);
                            } else {
                                ViperUtil.insertAfter(firstBlock, p);
                            }
                        }

                        if (removeFirstBlock === true) {
                            ViperUtil.remove(firstBlock);
                        }

                        if (p.firstChild.nodeType === ViperUtil.TEXT_NODE) {
                            if (ViperUtil.isBrowser('msie') === true
                                && p.firstChild.data === String.fromCharCode(160)
                            ) {
                                range.setEnd(p.firstChild, 1);
                                range.collapse(false);
                                range.moveEnd('character', -1);
                                range.collapse(false);
                            } else {
                                range.setEnd(p.firstChild, 0);
                                range.collapse(false);
                            }
                        } else {
                            range.selectNode(p.firstChild);
                            range.collapse(true);
                        }


                        ViperSelection.addRange(range);

                        this.viper.fireNodesChanged();
                        this.viper.fireSelectionChanged();
                        return false;
                    }//end if
                }//end if
            }//end if

            var startNode   = range.getStartNode();
            var blockParent = null;
            if (!startNode) {
                startNode = range.startContainer;
                if (ViperUtil.isBlockElement(startNode) === true) {
                    blockParent = startNode;
                }
            } else {
                blockParent = ViperUtil.getFirstBlockParent(startNode);
            }

            if (startNode && ViperUtil.isTag(blockParent, 'pre') === true) {
                if (startNode.parentNode === blockParent
                    && startNode.nodeType === ViperUtil.TEXT_NODE
                    && ViperUtil.trim(startNode.data) === ''
                ) {
                    if (startNode.nextSibling
                        && !startNode.nextSibling.nextSibling
                        && startNode.nextSibling.nodeType === ViperUtil.TEXT_NODE
                        && ViperUtil.trim(startNode.nextSibling.data) === ''
                    ) {
                        ViperUtil.remove(startNode.nextSibling);
                    }

                    ViperUtil.remove(startNode);
                    var p = document.createElement('p');
                    ViperUtil.setHtml(p, '<br />');
                    ViperUtil.insertAfter(blockParent, p);
                    range.selectNode(p.firstChild);
                    range.collapse(true);
                    ViperSelection.addRange(range);
                } else {
                    this.insertTextAtRange(range, "\n");
                }

                return false;
            } else if (blockParent === this.viper.getViperElement() && !defaultTagName) {
                if (startNode.nodeType === ViperUtil.TEXT_NODE
                    && startNode.data.length > (range.startOffset + 1)
                    && startNode.data.charCodeAt(range.startOffset) === 32
                ) {
                    startNode.data = startNode.data.substring(0, range.startOffset) + String.fromCharCode(160) +  startNode.data.substring(range.startOffset + 1);
                    range.setStart(startNode, range.startOffset);
                    range.collapse(true);
                    ViperSelection.addRange(range);
                }

                var br = document.createElement('br');
                this.viper.insertNodeAtCaret(br);

                range.setStart(br.nextSibling, 0);
                range.collapse(true);
                ViperSelection.addRange(range);

                return false;
            } else if (ViperUtil.isBrowser('msie') === true
                && range.startOffset === 0
                && range.collapsed === true
                && ViperUtil.isTag(startNode, 'li') === true
            ) {
                if (!startNode.nextSibling || (startNode.nextSibling.nodeType === ViperUtil.TEXT_NODE && !startNode.nextSibling.nextSibling)) {
                    if (startNode.parentNode.parentNode === this.viper.getViperElement()) {
                        var p = document.createElement('p');
                        ViperUtil.setHtml(p, '&nbsp');
                        ViperUtil.insertAfter(startNode.parentNode, p);
                        range.setEnd(p.firstChild, 1);
                        range.moveEnd('character', -1);
                        range.collapse(false);
                        ViperSelection.addRange(range);

                        this.viper.fireSelectionChanged();
                        ViperUtil.remove(startNode);
                        return false;
                    }
                }
            }//end if

            var selectedNode = range.getNodeSelection();
            var viperElem    = this.viper.getViperElement();
            if (selectedNode && selectedNode === viperElem) {
                if (ViperUtil.isBrowser('msie') === true) {
                    // Let IE do it as there is no way of telling if the caret is
                    // before or after the iframe.
                    return;
                }

                var elem = document.createElement(defaultTagName);
                ViperUtil.setHtml(elem, '<br />');
                if (viperElem.firstChild) {
                    ViperUtil.insertBefore(viperElem.firstChild, elem);
                } else {
                    viperElem.appendChild(elem);
                }

                range.selectNode(elem.firstChild);
                range.collapse(true);
                ViperSelection.addRange(range);
                this.viper.fireSelectionChanged();
                return false;
            } else if (!selectedNode
                && startNode
                && startNode === endNode
                && startNode.nodeType === ViperUtil.ELEMENT_NODE
                && (ViperUtil.isBrowser('firefox') !== true || !(ViperUtil.isTag(startNode, 'br') === true && (!blockParent || ViperUtil.isTag(blockParent, 'li') === true)))
                && ViperUtil.isStubElement(startNode) === false
            ) {
                var elem = document.createElement(defaultTagName);
                ViperUtil.setHtml(elem, '<br />');
                ViperUtil.insertBefore(startNode, elem);
                range.selectNode(elem.firstChild);
                range.collapse(true);
                ViperSelection.addRange(range);
                this.viper.fireSelectionChanged();
                return false;
            } else if (!selectedNode
                && startNode
                && endNode
                && startNode !== endNode
                && startNode.nodeType === ViperUtil.ELEMENT_NODE
                && endNode.nodeType === ViperUtil.ELEMENT_NODE
            ) {
                var elem = document.createElement(defaultTagName);
                ViperUtil.setHtml(elem, '<br />');

                if (ViperUtil.isStubElement(endNode) === true) {
                    ViperUtil.insertAfter(startNode, elem);
                } else {
                    ViperUtil.insertAfter(endNode, elem);
                }

                range.selectNode(elem.firstChild);
                range.collapse(true);
                ViperSelection.addRange(range);
                this.viper.fireSelectionChanged();
                return false;
            } else if (ViperUtil.isBrowser('firefox') === true
                && startNode.nodeType === ViperUtil.TEXT_NODE
                && endNode === startNode
                && range.startOffset === startNode.data.length
                && range.collapsed === true
                && ViperUtil.isTag(blockParent, 'li') === true
                && ViperUtil.isChildOf(ViperUtil.getFirstBlockParent(range.getNextContainer(startNode)), blockParent)
            ) {
                // There is a sublist and the range is at the end of the main list
                // item. When enter is pressed Firefox creates a new main list item
                // but the caret is placed to the start of the sub list items and
                // its not possible to move the caret to the new main list item.
                var li = document.createElement('li');
                li.appendChild(document.createElement('br'));
                while (startNode.nextSibling) {
                    li.appendChild(startNode.nextSibling);
                }

                ViperUtil.insertAfter(blockParent, li);
                range.selectNode(li.firstChild);
                range.collapse(true);
                ViperSelection.addRange(range);
                return false;
            } else if (selectedNode
                && ViperUtil.isTag(selectedNode, 'li') === true
                && blockParent === selectedNode
                && startNode === endNode
                && ViperUtil.isTag(startNode, 'br') === true
                && range.collapsed === true
                && !startNode.nextSibling
            ) {
                var parentListItem = ViperUtil.getFirstBlockParent(blockParent.parentNode);
                if (parentListItem && ViperUtil.isTag(parentListItem, 'li') === true) {
                    // Pressing enter at the start of an empty sub list item should
                    // be creating a new main list item and moving all remaining
                    // sub list items to the new list item.
                    var li = document.createElement('li');
                    li.appendChild(document.createElement('br'));
                    while (startNode.nextSibling) {
                        li.appendChild(startNode.nextSibling);
                    }

                    var subList = null;
                    while (blockParent.nextSibling) {
                        if (ViperUtil.isTag(blockParent.nextSibling, 'li') === true) {
                            if (!subList) {
                                subList = document.createElement(ViperUtil.getTagName(blockParent.parentNode));
                                li.appendChild(subList);
                            }

                            subList.appendChild(blockParent.nextSibling);
                        } else if (subList) {
                            subList.appendChild(blockParent.nextSibling);
                        } else {
                            li.appendChild(blockParent.nextSibling);
                        }
                    }

                    ViperUtil.remove(blockParent);
                    ViperUtil.insertAfter(parentListItem, li);
                    range.selectNode(li.firstChild);
                    range.collapse(true);
                    ViperSelection.addRange(range);
                    return false;
                } else if (ViperUtil.isBrowser('chrome') === true) {
                    // Latest Chrome is creating DIV element with span tag when
                    // exiting a top level list (hitting enter in an empty top level list item).
                    // Create the default tag instead.
                    var elem = null;
                    if (defaultTagName) {
                        elem = document.createElement(defaultTagName);
                        elem.appendChild(document.createElement('br'));
                    } else {
                        elem = document.createElement('br');
                    }

                    ViperUtil.insertAfter(blockParent.parentNode, elem);

                    // If the list item is not the last one we need to move
                    // the rest of them to a new list.
                    var listItems = [];
                    for (var node = blockParent; node; node = node.nextSibling) {
                        if (ViperUtil.isTag(node, 'li') === true) {
                            listItems.push(node);
                        }
                    }

                    if (listItems.length > 0) {
                        var newList = document.createElement(ViperUtil.getTagName(blockParent.parentNode));
                        ViperUtil.insertAfter(elem, newList);
                        while (listItems.length > 0) {
                            newList.appendChild(listItems.shift());
                        }
                    }

                    ViperUtil.remove(blockParent);

                    if (defaultTagName) {
                        range.selectNode(elem.firstChild);
                    } else {
                        range.selectNode(elem);
                    }

                    range.collapse(true);
                    ViperSelection.addRange(range);
                    return false;
                }
            } else if (range.collapsed === true
                && startNode.nodeType === ViperUtil.TEXT_NODE
                && startNode.data.length > (range.startOffset + 1)
                && startNode.data.charCodeAt(range.startOffset) === 32
            ) {
                // If this is a textnode, range is collapsed and the next
                // character is a space then replace it with a non breaking
                // space char to keep it at the beginning of the new container
                // that will be created.
                startNode.data = startNode.data.substring(0, range.startOffset) + String.fromCharCode(160) +  startNode.data.substring(range.startOffset + 1);
                range.setStart(startNode, range.startOffset);
                range.collapse(true);
                ViperSelection.addRange(range);
            } else if (ViperUtil.isBrowser('msie')
                && range.startOffset === 0
                && range.collapsed === true
                && startNode.nodeType === ViperUtil.TEXT_NODE
                && startNode === range._getFirstSelectableChild(ViperUtil.getFirstBlockParent(startNode))
            ) {
                // IE11 seems to have an issue with creating a new paragraph before the caret. If the caret is at the
                // start of a paragraph and enter is pressed a new paragraph is added before the original P tag.
                // However, in IE11, the innerHTML is '<br>' but firstChild of the paragraph is null..
                // We handle the creation here to prevent issues with toolbar button statuses etc.
                var parent = ViperUtil.getFirstBlockParent(startNode);
                var newEl = document.createElement(ViperUtil.getTagName(parent));
                newEl.appendChild(document.createElement('br'));

                if (ViperUtil.isBrowser('msie', '8') === true) {
                    ViperUtil.setStyle(newEl.firstChild, 'display', 'none');
                }

                ViperUtil.insertBefore(parent, newEl);
                return false;
            }//end if

            setTimeout(function() {
                // Fire selection changed here for enter events after a delay so that
                // range object is pointing to the new location. For example,
                // if enter was pressed at the end of a list and a new paragraph is
                // started by browser then getting range without delay would still
                // point to the empty list item. With delay it will be in the new
                // paragraph tag.
                self.viper.fireSelectionChanged(null, true);
            }, 5);

            // Let the browser handle everything else.
            return true;
        }

        // Because track changes is enabled we need to add extra info to elements
        return this._handleEnter(returnFirstBlock);

    },

    _handleEnter: function(returnFirstBlock)
    {
        if (this.viper.inlineMode === true) {
            return this.handleSoftEnter();
        }

        return this.splitAtRange(returnFirstBlock);

    },

    handleDelete: function(e)
    {
        var range = this.viper.getViperRange();

        if (ViperUtil.isBrowser('chrome') === true) {
            // Latest Chrome versions have strange issue with all content deletion, handle it in another method.
            return this._handleDeleteForChrome(e, range);
        }

        if (e.which === 46) {
            // Handle deletion from the right of the caret.
            return this._handleDeleteFromRight(e, range);
        }

        if (range.startOffset !== 0) {
            // No need to handle any case where caret is not at the start of a node.
            return;
        }

        var defaultTagName  = this.viper.getDefaultBlockTag();
        var viperElement    = this.viper.getViperElement();
        var firstSelectable = range._getFirstSelectableChild(viperElement);

        if (range.collapsed === true && e.keyCode === 8) {
            var startNode = range.getStartNode();
            if (startNode && startNode.nodeType === ViperUtil.TEXT_NODE) {
                var skippedBlockElem = [];
                var node      = range.getPreviousContainer(startNode, skippedBlockElem, true, true);
                if (this.viper.isOutOfBounds(node) === true) {
                    // Range is at the start of the editable element, nothing to delete except any blank block elements.
                    if (skippedBlockElem.length > 0) {
                        for (var i = 0; i < skippedBlockElem.length; i++) {
                            if (ViperUtil.isTag(skippedBlockElem[i], 'p') === true) {
                                ViperUtil.remove(skippedBlockElem[i]);
                            }
                        }
                    } else if (startNode.nodeType !== ViperUtil.TEXT_NODE || startNode.data.length === 0) {
                        node = range.getNextContainer(startNode, skippedBlockElem, true, true);
                        if (node && this.viper.isOutOfBounds(node) === false) {
                            ViperUtil.remove(ViperUtil.getSurroundingParents(startNode));
                            range.setStart(node, 0);
                            range.collapse(true);
                            ViperSelection.addRange(range);
                        }
                    } else if (startNode.nodeType === ViperUtil.TEXT_NODE
                        && ViperUtil.isTag(startNode.parentNode, 'li') === true
                        && ViperUtil.getTag('li', startNode.parentNode.parentNode).length === 1
                    ) {
                        // If the list item is the first container in the content and its being removed and its the
                        // only list item then remove the list element.
                        ViperUtil.remove(startNode.parentNode.parentNode);
                    }

                    return false;
                }
            }
        }

        if (this._isWholeViperElementSelected(range) === true) {
            // The whole Viper element is selected, remove all of its content
            // and then initialise the Viper element.
            ViperUtil.setHtml(viperElement, '');
            this.viper.initEditableElement();
            this.viper.fireNodesChanged();
            return false;
        } else if (ViperUtil.isBrowser('msie') === true) {
            var rangeClone = range.cloneRange();

            if (ViperUtil.isBrowser('msie', '>=11') === true) {
                // Check if the previous sibling of a parent is HR element and then remove it if found.
                var startNode = range.getStartNode();
                var foundSib  = false;
                while (startNode) {
                    for (var node = startNode.previousSibling; node; node = node.previousSibling) {
                        if (node.nodeType === ViperUtil.ELEMENT_NODE && ViperUtil.isTag(node, 'hr') === true) {
                            // Found the HR element, remove it.
                            ViperUtil.remove(node);
                            ViperUtil.preventDefault(e);
                            this.viper.fireNodesChanged();
                            return false;
                        } else if (node.nodeType !== ViperUtil.TEXT_NODE || ViperUtil.trim(node.data).length !== 0) {
                            // Not an empty text node or another node type, no need to continue.
                            foundSib = true;
                            break;
                        }
                    }

                    if (foundSib === true) {
                        break;
                    }

                    startNode = startNode.parentNode;
                }
            } else {
                // Remove HR elements in <IE11..
                rangeClone.moveStart('character', -2);
                if (ViperUtil.trim(rangeClone.getHTMLContents()) === '<HR>') {
                    range.moveStart('character', -2);
                    range.deleteContents();
                    return;
                }
            }

            if (rangeClone.endContainer.nodeType === ViperUtil.ELEMENT_NODE
                && rangeClone.endOffset === 0
                && rangeClone.endContainer.innerHTML === ''
            ) {
                var nextNode = rangeClone.getNextContainer(rangeClone.startContainer, null, true);
                ViperUtil.remove(rangeClone.endContainer);
                rangeClone.setEnd(nextNode, 0);
                rangeClone.collapse(false);
                ViperSelection.addRange(rangeClone);

                return false;
            } else if (range.startContainer
                && range.startContainer.nodeType === ViperUtil.TEXT_NODE
                && range.endContainer
                && range.endContainer.nodeType === ViperUtil.TEXT_NODE
                && range.startOffset === 0
                && range.endOffset === range.endContainer.data.length
            ) {
                // Remove a whle list element. IE seems to remove the list
                // items but not the UL/OL element...
                var parentLists = ViperUtil.getParents(range.startContainer, 'ul,ol', this.viper.getViperElement());
                while (parentLists.length > 0) {
                    var parentList = parentLists.shift();
                    var firstSelectable = range._getFirstSelectableChild(parentList);
                    var lastSelectable  = range._getLastSelectableChild(parentList);
                    if (firstSelectable === range.startContainer
                        && lastSelectable === range.endContainer
                    ) {
                        var newSelectable = range.getNextContainer(lastSelectable, null, true);
                        if (!newSelectable || this.viper.isOutOfBounds(newSelectable) === true) {
                            newSelectable = range.getPreviousContainer(firstSelectable, null, true);
                            if (newSelectable) {
                                ViperUtil.remove(parentList);
                                range.setEnd(newSelectable, newSelectable.data.length);
                                range.collapse(false);
                                ViperSelection.addRange(range);
                            }
                        } else {
                            ViperUtil.remove(parentList);
                            range.setEnd(newSelectable, 0);
                            range.collapse(false);
                            ViperSelection.addRange(range);
                        }

                        this.viper.fireNodesChanged();

                        return false;
                    }//end if
                }//end if
            }//end if
        } else if (range.startOffset === 0
            && range.collapsed === true
            && range.startContainer.nodeType === ViperUtil.TEXT_NODE
            && ViperUtil.isBrowser('firefox') === true
        ) {
            var firstBlock = ViperUtil.getFirstBlockParent(range.startContainer);
            if (firstBlock
                && range._getFirstSelectableChild(firstBlock) === range.startContainer
                && firstBlock.previousSibling
                && ViperUtil.isStubElement(firstBlock.previousSibling) === true
            ) {
                // Firefox does not handle deletion at the start of a block element
                // very well when the previous sibling is a stub element (e.g. HR).
                ViperUtil.remove(firstBlock.previousSibling);
                return false;
            } else if (e.keyCode === 8
                && range.collapsed === true
                && range.startContainer.nodeType === ViperUtil.TEXT_NODE
                && (range.startOffset === 0 || (range.startOffset === 1 && range.startContainer.data.charAt(0) === ' '))
                && (!range.startContainer.previousSibling || ViperUtil.isTag(range.startContainer.previousSibling, 'br') === true)
            ) {
                // At the start of an element. Check to see if the previous
                // element is a part of another block element. If it is then
                // join these elements.
                var prevSelectable = range.getPreviousContainer(range.startContainer, null, true, true);
                var currentParent  = ViperUtil.getFirstBlockParent(range.startContainer);
                var prevParent     = ViperUtil.getFirstBlockParent(prevSelectable);
                if (currentParent !== prevParent && this.viper.isOutOfBounds(prevSelectable) === false) {
                    // Check if there are any other elements in between.
                    var elemsBetween = ViperUtil.getElementsBetween(prevParent, currentParent);
                    if (elemsBetween.length > 0) {
                        // There is at least one non block element in between.
                        // Remove it.
                        ViperUtil.remove(elemsBetween[(elemsBetween.length - 1)]);
                    } else {
                        while (currentParent.firstChild) {
                            prevParent.appendChild(currentParent.firstChild);
                        }

                        ViperUtil.remove(currentParent);

                        if (prevSelectable.nodeType === ViperUtil.TEXT_NODE) {
                            range.setStart(prevSelectable, prevSelectable.data.length);
                        } else {
                            range.setStartAfter(prevSelectable);
                        }

                        range.collapse(true);
                        ViperSelection.addRange(range);
                    }

                    ViperUtil.preventDefault(e);
                    this.viper.fireNodesChanged();

                    return false;
                } //end if
            }//end if
        } else if (range.startOffset === 0
            && range.collapsed === false
            && ViperUtil.isBrowser('msie') !== true
        ) {
            // Chrome has issues with removing list items from lists.
            var startNode = range.getStartNode();
            var endNode   = range.getEndNode();

            // First issue is, if a whole list item is selected, it removes the li
            // and it adds a span tag in place of it, creating invalid HTML and
            // causing all sorts of issues. It should only remove the list item
            // contents and leave the list item un touched..
            if (startNode === endNode
                && startNode.nodeType === ViperUtil.TEXT_NODE
                && ViperUtil.isTag(startNode.parentNode, 'li') === true
                && startNode.data.length === range.endOffset
            ) {
                ViperUtil.setHtml(startNode.parentNode, '<br />');
                return false;
            } else if ((ViperUtil.isTag(range.commonAncestorContainer, 'ul') || ViperUtil.isTag(range.commonAncestorContainer, 'ol'))) {
                // Second issue is with removing multiple list items.
                if (endNode.data.length === range.endOffset) {
                    var endItem = ViperUtil.getParents(endNode, 'li')[0];
                    if (endNode === range._getLastSelectableChild(endItem)) {
                        // Whole list item is selected.
                        // Get the start list item and all other list items until
                        // the end list item.
                        var startItem = ViperUtil.getParents(startNode, 'li')[0];
                        if (startNode === range._getFirstSelectableChild(startItem)) {
                            var elements = ViperUtil.getElementsBetween(startItem, endItem);
                            elements.push(startItem, endItem);

                            // Find a new node we can put caret in.
                            var newOffset = 0;
                            var newSelContainer = range.getNextContainer(endNode, null, true);
                            if (!newSelContainer || this.viper.isOutOfBounds(newSelContainer) === true) {
                                // If out of bounds of Viper try getting the previous selectable.
                                newSelContainer = range.getPreviousContainer(startNode, null, true);
                                if (newSelContainer) {
                                    newOffset = newSelContainer.data.length;
                                }
                            }

                            ViperUtil.remove(elements);

                            if (newSelContainer) {
                                // Set the caret location.
                                range.setStart(newSelContainer, newOffset);
                                range.collapse(true);
                                ViperSelection.addRange(range);
                            }

                            this.viper.fireNodesChanged();
                            return false;
                        }//end if
                    }//end if
                }//end if
            }//end if
        } else if (range.startOffset === 0
            && range.collapsed === true
            && range.startContainer === range.endContainer
            && e.keyCode === 8
            && (this.viper.elementIsEmpty(range.startContainer) === true || ViperUtil.getHtml(range.startContainer) === '<br>')
        ) {
            var skippedBlockElem = [];
            var endCont = range.endContainer;
            var node    = range.getPreviousContainer(range.startContainer, skippedBlockElem, true, true);

            var startOffset = 0;
            if (!node || ViperUtil.isChildOf(node, this.viper.element) === false) {
                if (skippedBlockElem.length > 0) {
                    for (var i = 0; i < skippedBlockElem.length; i++) {
                        if (ViperUtil.isTag(skippedBlockElem[i], 'p') === true) {
                            ViperUtil.remove(skippedBlockElem[i]);
                        }
                    }
                }

                return false;

                node = range.getNextContainer(endCont, null, true);
                if (this.viper.isOutOfBounds(node) === true) {
                    node = endCont;
                }
            } else if (node.nodeType === ViperUtil.TEXT_NODE) {
                startOffset = node.data.length;
            }

            range.setEnd(node, startOffset);
            range.collapse(false);
            ViperSelection.addRange(range);

            if (endCont
                && endCont.nodeType === ViperUtil.ELEMENT_NODE
                && (ViperUtil.isTag(endCont, 'td') === true || ViperUtil.isTag(endCont, 'th') === true)
            ) {
                return;
            }

            var parent = endCont.parentNode;
            ViperUtil.remove(endCont);
            while (parent.childNodes.length === 0) {
                if (parent === viperElement) {
                    break;
                }

                var remove = parent;
                parent = parent.parentNode;
                ViperUtil.remove(remove);
            }

            return false;
        }

        if (range.collapsed === false) {
            var nodeSelection = range.getNodeSelection();
            if (nodeSelection) {
                // A whole container is selected at the start of the editable container.
                // Find good container to place the caret.
                var next       = true;
                var selectable = range.getNextContainer(nodeSelection, null, false, true);
                if (!selectable) {
                    next       = false;
                    selectable = range.getPreviousContainer(nodeSelection, null, true, true);
                }

                if (!selectable) {
                    // Create a new default container.
                    var defaultTagName = this.viper.getDefaultBlockTag();
                    var defTag = null;
                    if (defaultTagName !== '') {
                        defTag = document.createElement(defaultTagName);
                        ViperUtil.setHtml(defTag, '<br/>');
                    } else {
                        defTag = document.createTextNode(' ');
                    }

                    ViperUtil.insertAfter(nodeSelection, defTag);
                    ViperUtil.remove(nodeSelection);
                    range.setStart(defTag, 0);
                    range.collapse(true);
                    ViperSelection.addRange(range);
                    return false;
                } else if (next === true) {
                    range.setStart(selectable, 0);
                    range.collapse(true);
                } else {
                    range.setStart(selectable, selectable.data.length);
                    range.collapse(true);
                }

                ViperUtil.remove(nodeSelection);
                ViperSelection.addRange(range);
                return false;
            }
        }//end if

        if (this._handleBackspaceAtStartOfLi(e, range) === false) {
            return false;
        }

        if (this._isStartToEndOfMultiContainerSelection(range) === true) {
            return this._removeContentFromStartToEndOfContainers(range)
        }

    },

    _handleBackspaceAtStartOfLi: function(e, range)
    {
        if (e.which === 46 || range.startOffset !== 0) {
            return;
        }

        // Handle backspace at the start of a list (LI) element.
        if (range.collapsed === true && range.startContainer.nodeType === ViperUtil.TEXT_NODE) {
            var firstBlock      = ViperUtil.getFirstBlockParent(range.startContainer);
            var firstSelectable = range._getFirstSelectableChild(firstBlock);
            if (firstBlock
                && ViperUtil.isTag(firstBlock, 'li') === true
                && firstSelectable === range.startContainer
            ) {
                 // Check if there is a parent element with a selectable.
                var prevSelectable = range.getPreviousContainer(firstSelectable, null, true, true);
                if (prevSelectable) {
                    while (firstBlock.lastChild) {
                        ViperUtil.insertAfter(prevSelectable, firstBlock.lastChild);
                    }

                    var firstBlockParent = firstBlock.parentNode;
                    ViperUtil.remove(firstBlock);
                    if (ViperUtil.getTag('li', firstBlockParent).length === 0) {
                        ViperUtil.remove(firstBlockParent);
                    }

                    range.setStart(firstSelectable, 0);
                    range.collapse(true);
                    ViperSelection.addRange(range);

                    ViperUtil.preventDefault(e);
                    this.viper.fireNodesChanged();
                    return false;
                }
            }//end if
        }//end if

    },

    _handleDeleteFromRight: function(e, range)
    {
        if (range.collapsed !== true) {
            // If range is not collapsed then everything in the selection should be removed which is handled by
            // the browser unless its the whole Viper element selection.
            if (this._isWholeViperElementSelected(range) === true) {
                // The whole Viper element is selected, remove all of its content
                // and then initialise the Viper element.
                ViperUtil.setHtml(this.viper.getViperElement(), '');
                this.viper.initEditableElement();
                this.viper.fireNodesChanged();
                return false;
            } else if (this._isStartToEndOfMultiContainerSelection(range) === true) {
                return this._removeContentFromStartToEndOfContainers(range);
            }

            return;
        }

        var startNode = range.getStartNode();
        if (!startNode) {
            if (!range.startContainer
                || range.startContainer.nodeType !== ViperUtil.ELEMENT_NODE
                || range.startContainer !== range.endContainer
            ) {
                return;
            }

            startNode = range.startContainer;
        }

        if (startNode.nodeType === ViperUtil.TEXT_NODE) {
            // In a text node.
            if (range.startOffset === startNode.data.length) {
                // End of the text node.
                // Check for HR element.
                var foundSib  = false;
                while (startNode) {
                    for (var node = startNode.nextSibling; node; node = node.nextSibling) {
                        if (node.nodeType === ViperUtil.ELEMENT_NODE && ViperUtil.isTag(node, 'hr') === true) {
                            // Found the HR element, remove it.
                            ViperUtil.remove(node);
                            ViperUtil.preventDefault(e);
                            this.viper.fireNodesChanged();
                            return false;
                        } else if (node.nodeType !== ViperUtil.TEXT_NODE || ViperUtil.trim(node.data).length !== 0) {
                            // Not an empty text node or another node type, no need to continue.
                            foundSib = true;
                            break;
                        }
                    }

                    if (foundSib === true) {
                        break;
                    }

                    startNode = startNode.parentNode;
                }//end while
            }//end if
        }//end if

    },

    _handleDeleteForChrome: function(e, range)
    {
        if (this._handleBackspaceAtStartOfLi(e, range) === false) {
            return false;
        }

        // This block of code is a workaround for the delete bug in Chrome.
        // See http://goo.gl/QPB0v
        if (e.keyCode === 46
            && range.collapsed === true
            && range.startContainer.nodeType === ViperUtil.TEXT_NODE
            && range.startOffset === range.startContainer.data.length
            && (!range.startContainer.nextSibling || ViperUtil.isStubElement(range.startContainer.nextSibling) === true)
        ) {
            // At the end of an element. Check to see if next available
            // element is a block.
            var nextSelectable = range.getNextContainer(range.startContainer, null, false, true);
            var currentParent  = ViperUtil.getFirstBlockParent(range.startContainer);
            var nextParent     = ViperUtil.getFirstBlockParent(nextSelectable);
            if (currentParent !== nextParent && this.viper.isOutOfBounds(nextSelectable) === false) {
                while (nextParent.firstChild) {
                    currentParent.appendChild(nextParent.firstChild);
                }

                ViperUtil.remove(nextParent);
                ViperUtil.preventDefault(e);
                this.viper.fireNodesChanged();
                return false;
            }
        } if (e.keyCode === 46
            && range.collapsed === true
            && range.startContainer.nodeType === ViperUtil.ELEMENT_NODE
            && ViperUtil.isTag(range.getStartNode(), 'br') === true
        ) {
            var startNode = range.getStartNode();
            var selectable = range.getNextContainer(startNode, null, true);
            if (!selectable) {
                selectable = range.getPreviousContainer(startNode, null, true);
            }

            var parent = range.getStartNode().parentNode;
            ViperUtil.remove(range.getStartNode().parentNode);

            if (parent.childNodes.length === 0) {
                ViperUtil.remove(parent);
            }

            if (selectable) {
                range.setStart(selectable, 0);
                range.collapse(true);
                ViperSelection.addRange(range);
            }

            ViperUtil.preventDefault(e);
            this.viper.fireNodesChanged();
            return false;
        } else if (e.keyCode === 8
            && range.collapsed === true
            && range.startContainer.nodeType === ViperUtil.TEXT_NODE
            && (range.startOffset === 0 || (range.startOffset === 1 && range.startContainer.data.charAt(0) === ' '))
            && (!range.startContainer.previousSibling || ViperUtil.isTag(range.startContainer.previousSibling, 'br') === true)
        ) {
            // At the start of an element. Check to see if the previous
            // element is a part of another block element. If it is then
            // join these elements.
            var prevSelectable = range.getPreviousContainer(range.startContainer, null, true, true);
            var currentParent  = ViperUtil.getFirstBlockParent(range.startContainer);
            var prevParent     = ViperUtil.getFirstBlockParent(prevSelectable);
            if (currentParent !== prevParent && this.viper.isOutOfBounds(prevSelectable) === false) {
                // Check if there are any other elements in between.
                var elemsBetween = ViperUtil.getElementsBetween(prevParent, currentParent);
                if (elemsBetween.length > 0) {
                    // There is at least one non block element in between.
                    // Remove it.
                    ViperUtil.remove(elemsBetween[(elemsBetween.length - 1)]);
                } else {
                    while (currentParent.firstChild) {
                        prevParent.appendChild(currentParent.firstChild);
                    }

                    ViperUtil.remove(currentParent);

                    if (prevSelectable.nodeType === ViperUtil.TEXT_NODE) {
                        range.setStart(prevSelectable, prevSelectable.data.length);
                    } else {
                        range.setStartAfter(prevSelectable);
                    }

                    range.collapse(true);
                    ViperSelection.addRange(range);
                }

                ViperUtil.preventDefault(e);
                this.viper.fireNodesChanged();

                return false;
            } else if (ViperUtil.isTag(prevSelectable, 'br') === true) {
                ViperUtil.remove(prevSelectable);
                ViperUtil.preventDefault(e);
                this.viper.fireNodesChanged();
                return false;
            }
        } else if (
            range.collapsed === false
            && range.startContainer !== range.endContainer
            && range.startContainer.nodeType === ViperUtil.TEXT_NODE
        ) {
            // This is a selection on different text nodes. Check to see
            // if these nodes are part of two different block elements.
            var nodeSelection = range.getNodeSelection();
            if (nodeSelection) {
                if (nodeSelection === this.viper.getViperElement()) {
                    var defaultTagName = this.viper.getDefaultBlockTag();
                    if (defaultTagName !== '') {
                        var defTag = document.createElement(defaultTagName);
                        ViperUtil.setHtml(defTag, '<br/>');
                        ViperUtil.setHtml(nodeSelection, '');
                        nodeSelection.appendChild(defTag);
                        range.setStart(defTag, 0);
                    } else {
                        ViperUtil.setHtml(nodeSelection, '<br />');
                    }
                } else {
                    var nextSelectable = range.getNextContainer(nodeSelection, null, true);
                    if (this.viper.isOutOfBounds(nextSelectable) === true) {
                        nextSelectable = range.getPreviousContainer(range.startContainer, null, true);
                        if (nextSelectable) {
                            range.setStart(nextSelectable, nextSelectable.data.length);
                        }
                    } else {
                        range.setStart(nextSelectable, 0);
                    }

                    ViperUtil.remove(nodeSelection);
                }//end if
            } else if (this._isStartToEndOfMultiContainerSelection(range) === true) {
                return this._removeContentFromStartToEndOfContainers(range);
            } else {
                var startParent = ViperUtil.getFirstBlockParent(range.startContainer);
                var endParent   = ViperUtil.getFirstBlockParent(range.endContainer);
                if (startParent !== endParent) {
                    // Two different parents. We need to join these parents.
                    // First remove all elements in between.
                    range.deleteContents();

                    // If the startParent is empty remove it if the endParent is the viperElement.
                    if (ViperUtil.isBlank(ViperUtil.trim(ViperUtil.getHtml(startParent))) !== true
                        || endParent != this.viper.getViperElement()
                    ) {
                        // Now bring the contents of the next selectable to the
                        // start parent.
                        var nextSelectable = range.getNextContainer(range.startContainer, null, true);
                        if (this.viper.isOutOfBounds(nextSelectable) === false) {
                            var nextParent = ViperUtil.getFirstBlockParent(nextSelectable);
                            while (nextParent.firstChild) {
                                startParent.appendChild(nextParent.firstChild);
                            }

                            ViperUtil.remove(nextParent);
                        }
                    } else {
                        ViperUtil.remove(startParent);
                    }
                } else {
                    // Same container just remove contents.
                    range.deleteContents();
                }//end if
            }//end if

            ViperUtil.preventDefault(e);
            range.collapse(true);
            ViperSelection.addRange(range);
            this.viper.fireNodesChanged();
            return false;
        } else if (this._isWholeViperElementSelected(range) === true) {
            // The whole Viper element is selected, remove all of its content
            // and then initialise the Viper element.
            ViperUtil.setHtml(this.viper.getViperElement(), '');
            this.viper.initEditableElement();
            this.viper.fireNodesChanged();
            return false;
        } else if (range.startContainer.nodeType === ViperUtil.ELEMENT_NODE
            && range.startContainer === range.endContainer
            && range.startOffset === range.endOffset
            && range.startOffset === 0
        ) {
            if (ViperUtil.isTag(range.startContainer, 'li') === true
                && ViperUtil.getTag('li', range.startContainer.parentNode).length === 1
            ) {
                // Single empty list item being removed. Remove the whole list.
                this._placeCaretToValidPosition(range.startContainer.parentNode, range.startContainer.parentNode);
                ViperUtil.remove(range.startContainer.parentNode);
                this.viper.fireNodesChanged();
                this.viper.fireSelectionChanged(null, true);
                return false;
            }
        }//end if

    },

    _placeCaretToValidPosition: function(startNode, endNode)
    {
        // Find a new node we can put caret in.
        var range     = this.viper.getCurrentRange();
        var newOffset = 0;
        var newSelContainer = range.getNextContainer(endNode, null, true);
        if (!newSelContainer || this.viper.isOutOfBounds(newSelContainer) === true) {
            // If out of bounds of Viper try getting the previous selectable.
            newSelContainer = range.getPreviousContainer(startNode, null, true);
            if (!newSelContainer || this.viper.isOutOfBounds(newSelContainer) === true) {
                // No valid location. Create a new default block tag.
                var defaultTagName = this.viper.getDefaultBlockTag();
                newSelContainer = document.createElement('br');
                if (defaultTagName === '') {
                    ViperUtil.insertAfter(endNode, newSelContainer);
                } else {
                    var newElem = document.createElement(defaultTagName);
                    newElem.appendChild(newSelContainer);
                    ViperUtil.insertAfter(endNode, newElem);
                }
            } else {
                newOffset = newSelContainer.data.length;
            }
        }

        if (newSelContainer) {
            // Set the caret location.
            range.setStart(newSelContainer, newOffset);
            range.collapse(true);
            ViperSelection.addRange(range);
        }

    },

    splitAtRange: function(returnFirstBlock, range)
    {
        range = range || this.viper.getViperRange();

        var selectedNode = range.getNodeSelection();
        if (selectedNode && selectedNode.nodeType === ViperUtil.ELEMENT_NODE) {
            selectedNode.innerHTML = '&nbsp;';
            return selectedNode;
        }

        // If the range is not collapsed then remove the contents of the selection.
        if (range.collapsed !== true) {
            if (ViperUtil.isBrowser('chrome') === true
                || ViperUtil.isBrowser('safari') === true
            ) {
                range.deleteContents();
                ViperSelection.addRange(range);
            } else {
                this.viper.deleteContents();
                ViperSelection.addRange(this.viper.getCurrentRange());
                range = this.viper.getViperRange();
            }
        }

        if (range.startContainer.nodeType === ViperUtil.TEXT_NODE) {
            // Find the first parent block element.
            var parent = range.startContainer.parentNode;
            if (parent === this.viper.getViperElement()) {
                // Check if there are any block elements before this node.
                if (range.startContainer.previousSibling
                    && range.startContainer.previousSibling.nodeType !== ViperUtil.TEXT_NODE
                ) {
                    return range.startContainer.previousSibling;
                } else {
                    // Cretae a new paragraph and insert it at range position.
                    var para = document.createElement('p');
                    ViperUtil.setHtml(para, '&nbsp;');
                    ViperUtil.insertAfter(range.startContainer, para);
                    return para;
                }
            }

            var blockQuote = ViperUtil.getParents(range.startContainer, 'blockquote', this.viper.element);

            while (parent) {
                if (ViperUtil.isBlockElement(parent) === true) {
                    if (blockQuote.length === 0 || ViperUtil.isTag(parent, 'blockquote') === true) {
                        break;
                    }
                }

                if (parent.parentNode && parent.parentNode === this.viper.element) {
                    break;
                }

                parent = parent.parentNode;
            }
        } else if (range.startContainer === range.endContainer
            && ViperUtil.isStubElement(range.startContainer)
            && range.startContainer.parentNode.firstChild === range.startContainer
            && range.startContainer.parentNode.lastChild === range.startContainer
        ) {
            parent = range.startContainer.parentNode;
            ViperUtil.setHtml(parent, '&nbsp;');
            range.setStart(parent.firstChild, 0);
            range.collapse(true);
        } else {
            parent = range.startContainer;
        }//end if

        // Create a new element and a document fragment with the contents of
        // the selection.
        var tag = parent.tagName.toLowerCase();

        // If the parent is not part of the editable element then we need to
        // create two new P tags.
        if (ViperUtil.isChildOf(parent, this.viper.element) === false) {
            // Find the next non block sibling.
            var node = range.endContainer;
            while (ViperUtil.isset(node.nextSibling) === true) {
                if (ViperUtil.isBlockElement(node.nextSibling) === true) {
                    break;
                }

                node = node.nextSibling;
            }

            range.setEndAfter(node);

            var elem    = Viper.document.createElement('p');
            var docFrag = range.extractContents('p');

            this.viper.deleteContents();
            elem.appendChild(docFrag);
            ViperUtil.insertAfter(range.startContainer, elem);
            range.collapse(true);

            // Find the previous non block sibling.
            node = range.startContainer;
            while (ViperUtil.isset(node.previousSibling) === true) {
                if (ViperUtil.isBlockElement(node.previousSibling) === true) {
                    break;
                }

                node = node.previousSibling;
            }

            range.setStartBefore(node);

            var felem = Viper.document.createElement('p');
            docFrag   = range.extractContents('p');
            felem.appendChild(docFrag);
            ViperUtil.insertBefore(elem, felem);

            range.setStart(elem.firstChild, 0);
            range.collapse(true);
            return;
        } else if (tag === 'pre') {
            // If the text is in a PRE tag then we need to insert a new line character.
            this.insertTextAtRange(range, "\n");
            return false;
        } else if (tag === 'td' || tag === 'th') {
            // Cannot create a new TD tag so need the move td contents in to a P tag.
            var bookmark = this.viper.createBookmark(range);
            var p        = Viper.document.createElement('P');
            while (parent.firstChild) {
                p.appendChild(parent.firstChild);
            }

            // Add the new P tag as TD's child node.
            parent.appendChild(p);

            // Update tag name and parent element.
            tag    = 'p';
            parent = p;

            // Update range.
            this.viper.selectBookmark(bookmark);
        }//end if

        // If the selection is at the end of text node and has no next sibling
        // then move the range out of its parent node to prevent empty tags being
        // created by range.extractContents().
        if (range.startContainer.nodeType === ViperUtil.TEXT_NODE
            && range.startOffset === range.startContainer.data.length
        ) {
            if (!range.startContainer.nextSibling) {
                var newTextNode = Viper.document.createTextNode('');
                ViperUtil.insertAfter(range.startContainer.parentNode, newTextNode);
                range.setEnd(newTextNode, 0);
                range.collapse(false);
            }
        }

        try {
            // Select everything from the current position to the end of the parent.
            range.setEndAfter(parent.lastChild);
        } catch (e) {

        }

        ViperSelection.addRange(range);

        // Need to clone the node so that its attributes are also copied.
        // This may cause ID conflicts.
        var elem    = parent.cloneNode(false);
        var docFrag = range.extractContents(tag);

        elem.appendChild(docFrag);

        // Remove DEL tags before getting the text content.
        var elemClone = ViperUtil.cloneNode(elem);
        ViperUtil.remove(ViperUtil.getTag('del', elemClone));

        if (ViperUtil.isBlank(ViperUtil.getNodeTextContent(elemClone)) === true) {
            // Do not need this empty element.
            elem = null;
        }

        if (elem === null || (elem.tagName && elem.tagName.toLowerCase() !== 'li' && ViperUtil.isBlockElement(elem) === false)) {
            // If the newly created element is not a block element then
            // create a P tag and make it the elem's parent.
            var newTag = 'p';

            // If element is in a list block then create a new list item instead of a paragraph.
            if (tag === 'li') {
                newTag = tag;
            }

            var pelem = Viper.document.createElement(newTag);
            if (elem !== null) {
                pelem.appendChild(elem);
            } else {
                ViperUtil.setHtml(pelem, '&nbsp;');
            }

            elem = pelem;
            ViperChangeTracker.addChange('createContainer', [elem]);
        } else {
            ViperChangeTracker.removeTrackChanges(elem, true);
            ViperChangeTracker.addChange('splitContainer', [elem]);
        }//end if

        if (this.viper.elementIsEmpty(parent) === true) {
            ViperUtil.setHtml(parent, '&nbsp;');
        }

        // Insert the new element after the current parent.
        ViperUtil.insertAfter(parent, elem);

        range.setStart(elem, 0);
        range.setStart(elem, 0);
        try {
            range.moveStart('character', 1);
            range.moveStart('character', -1);
        } catch (e) {
            // Handle empty node..
        }

        range.collapse(true);
        ViperSelection.addRange(range);

        // Check the parent element contents.
        // If the parent element is now empty and its a block element
        // then add a space to it.
        if (ViperUtil.isBlockElement(parent) === true && ViperUtil.trim(ViperUtil.getHtml(parent)) === '') {
            ViperUtil.setHtml(parent, '&nbsp;');
        }

        this.viper.fireNodesChanged('ViperKeyboardEditorPlugin:enter');

        if (returnFirstBlock === true) {
            return parent;
        }

        return false;
    },

    /**
     * Handles shift + enter.
     *
     * Creates a new BR tag at the position of the caret. If the caret is inside a
     * PRE tag then it will create a new P tag and move the caret inside the P tag.
     *
     * @return {boolean} False when it modified the content to prevent event bubbling.
     */
    handleSoftEnter: function(e)
    {
        if (this._isKeyword() === true) {
            return false;
        }

        if (e) {
            var range     = this.viper.getCurrentRange();
            var startNode = range.getStartNode();
            if (startNode && ViperUtil.isTag(ViperUtil.getFirstBlockParent(startNode), 'pre') === true) {
                this.insertTextAtRange(range, "\n");
                return false;
            }
        }

        var node = Viper.document.createElement('br');
        this.viper.insertNodeAtCaret(node);

        if (ViperUtil.isTag(node.previousSibling, 'br') === true) {
            // The previous sibling is also a br tag and to be able to position
            // caret between these two br tags we need to insert a text node in
            // between them.
            this.viper.insertAfter(node.previousSibling, this.viper.createSpaceNode());
        } else if (!node.nextSibling && ViperUtil.isBlockElement(node.parentNode) === false) {
            ViperUtil.insertAfter(node.parentNode, node);
        }

        return !this.viper.setCaretAfterNode(node);

    },

    _isWholeViperElementSelected: function(range)
    {
        if (range.collapsed === false) {
            var viperElement    = this.viper.getViperElement();
            var firstSelectable = range._getFirstSelectableChild(viperElement);
            if (firstSelectable === range.startContainer || (viperElement === range.startContainer && range.startOffset === 0)) {
                var lastSelectable  = range._getLastSelectableChild(viperElement);
                if ((range.endContainer === viperElement && range.endOffset >= viperElement.childNodes.length)
                    || (range.endContainer === lastSelectable && range.endOffset === lastSelectable.data.length)
                ) {
                    return true;
                }
            }
        }

        return false;

    },

    _isStartToEndOfMultiContainerSelection: function(range)
    {
        if (range.startOffset === 0
            && range.collapsed === false
            && ViperUtil.isBrowser('msie') !== true
            && range.startContainer !== range.endContainer
            && range.startContainer.nodeType === ViperUtil.TEXT_NODE
            && range.endContainer.nodeType === ViperUtil.TEXT_NODE
            && range.endOffset === range.endContainer.data.length
        ) {
            var startParent     = ViperUtil.getFirstBlockParent(range.startContainer);
            var endParent       = ViperUtil.getFirstBlockParent(range.endContainer);
            var firstSelectable = range._getFirstSelectableChild(startParent);
            var lastSelectable  = range._getLastSelectableChild(endParent);
            if (firstSelectable === range.startContainer
                && lastSelectable === range.endContainer
            ) {
                return true;
            }
        }

        return false;

    },

    _removeContentFromStartToEndOfContainers: function(range)
    {
        // Remove content from beginning of one container to the end of another container.
        var startParent     = ViperUtil.getFirstBlockParent(range.startContainer);
        var endParent       = ViperUtil.getFirstBlockParent(range.endContainer);
        var defaultTagName  = this.viper.getDefaultBlockTag();

        if (defaultTagName !== '') {
            var p = document.createElement(defaultTagName);
            ViperUtil.setHtml(p, '<br />');
            ViperUtil.insertBefore(startParent, p);
            ViperUtil.remove(ViperUtil.getElementsBetween(startParent, endParent));
            ViperUtil.remove(startParent);
            ViperUtil.remove(endParent);
            range.setStart(p, 0);
            range.collapse(true);
        } else {
            var br = document.createElement('br');
            ViperUtil.insertBefore(startParent, br);
            ViperUtil.remove(ViperUtil.getElementsBetween(startParent, endParent));
            ViperUtil.remove(startParent);
            ViperUtil.remove(endParent);
            range.setStart(br, 0);
            range.collapse(true);
        }

        ViperSelection.addRange(range);
        this.viper.fireNodesChanged();

        // Prevent default action.
        return false;

    },

    insertTextAtRange: function(range, text)
    {
        var node = range.startContainer;
        // Assuming the range is collapsed already.
        if (node.nodeType === ViperUtil.TEXT_NODE) {
            // Split the text node and insert new line char.
            var newNode = node.splitText(range.startOffset);
            ViperUtil.insertBefore(newNode, document.createTextNode(text));
        } else {
            // Element node..
            node = range.startContainer.childNodes[range.startOffset];
            if (node.nodeType === ViperUtil.TEXT_NODE) {
                // Split the text node and insert new line char.
                var newNode = node.splitText(range.startOffset);
                ViperUtil.insertBefore(newNode, document.createTextNode(text));
            } else {
                newNode = document.createTextNode(text);
                ViperUtil.insertAfter(node, newNode);
            }
        }

        if (newNode.data.length === 0) {
            newNode.data = ' ';
        }

        range.setStart(newNode, 0);
        range.collapse(true);
        ViperSelection.addRange(range);

        if (ViperChangeTracker.isTracking() === true) {
            var ctNode = null;
            if (newNode.nextSibling) {
                var sibling = newNode.nextSibling;
                ctNode      = ViperChangeTracker.createCTNode('ins', 'textAdd', newNode);
                ViperUtil.insertBefore(sibling, ctNode);
            } else if (newNode.previousSibling) {
                var sibling = newNode.previousSibling;
                ctNode      = ViperChangeTracker.createCTNode('ins', 'textAdd', newNode);
                ViperUtil.insertAfter(sibling, ctNode);
            } else {
                var parent  = newNode.parentNode;
                ctNode      = ViperChangeTracker.createCTNode('ins', 'textAdd', newNode);
                parent.appendChild(ctNode);
            }

            if (ctNode) {
                ViperChangeTracker.addChange('textAdded', [ctNode]);
            }
        }

    },

    cleanPreTags: function()
    {
        var preTags = ViperUtil.getTag('pre', this.viper.getViperElement());
        var c       = preTags.length;

        var bookmark = this.viper.createBookmark();

        for (var i = 0; i < c; i++) {
            this.cleanPreTag(preTags[i]);
        }

        this.viper.selectBookmark(bookmark);

    },

    cleanPreTag: function(pre)
    {
        if (!pre) {
            return;
        }

        var elems = ViperUtil.getTag('p,div', pre);
        var c     = elems.length;

        for (var i = 0; i < c; i++) {
            var elem = elems[i];
            while (elem.firstChild) {
                ViperUtil.insertBefore(elem, elem.firstChild);
            }

            ViperUtil.insertBefore(elem, document.createTextNode("\n\n"));
            ViperUtil.remove(elem);
        }

        var elems = ViperUtil.getTag('br', pre);
        var c     = elems.length;

        for (var i = 0; i < c; i++) {
            var elem = elems[i];
            ViperUtil.insertBefore(elem, document.createTextNode("\n"));
            ViperUtil.remove(elem);
        }

    },

    isEmptyBlockElement: function(element)
    {
        if (ViperUtil.isBlockElement(element) === false) {
            return false;
        }

        if (!element.firstChild) {
            return true;
        }

        var brCount = 0;
        for (var i = 0; i < element.childNodes.length; i++) {
            var el = element.childNodes[i];
            if (el.nodeType === ViperUtil.TEXT_NODE) {
                if (ViperUtil.trim(el.data).length !== 0) {
                    return false;
                } else {
                    // Ignore empty text nodes.
                    continue;
                }
            } else if (ViperUtil.isTag(el, 'br') === false) {
                return false;
            } else if (brCount !== 0) {
                return false;
            } else {
                brCount++;
            }
        }

        return true;

    }

};
