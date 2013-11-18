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
    this._tagList = ('p|div|h1|h2|h3|h4|h5|h6|blockquote').split('|');

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

            dfx.remove(node);
        });

        ViperChangeTracker.addChangeType('createContainer', 'Insert', 'insert');
        ViperChangeTracker.setDescriptionCallback('createContainer', function(node) {
            return self._getChangeDescription(node);
        });
        ViperChangeTracker.setApproveCallback('createContainer', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('createContainer', function(clone, node) {
            dfx.remove(node);
        });

    },

    _getChangeDescription: function(node, changeType)
    {
        var pImgURL = this.viper.getStylesURL() + '/icon-p_tag.png';
        var pImg    = Viper.document.createElement('img');
        dfx.attr(pImg, 'src', pImgURL);
        dfx.attr(pImg, 'title', 'Paragraph Break');
        var desc = pImg;

        if (changeType !== 'splitContainer') {
            for (var child = node.firstChild; child; child = child.nextSibling) {
                if (child.nodeType === dfx.TEXT_NODE && dfx.trim(child.nodeValue).length === 0) {
                    continue;
                } else if (ViperChangeTracker.isTrackingNode(child) === true) {
                    var ctnType = ViperChangeTracker.getCTNTypeFromNode(child);
                    if (ViperChangeTracker.isInsertType(ctnType) === true) {
                        var extraDesc = ViperChangeTracker.getDescriptionForNode(child);
                        if (dfx.isObj(extraDesc) === false) {
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
                } else if (range.startContainer.nodeType === dfx.ELEMENT_NODE
                    && !range.startContainer.childNodes[range.startOffset]
                    && range.startContainer.childNodes[(range.startOffset - 1)]
                ) {
                    endNode = range.startContainer.childNodes[(range.startOffset - 1)];
                }
            }

            try {
                if (!startNode && !endNode && range.collapsed === true && dfx.isTag(range.startContainer, 'br') === true) {
                    startNode = range.startContainer;
                    endNode   = startNode;
                }

                if (endNode
                    && endNode.nodeType === dfx.TEXT_NODE
                    && dfx.trim(dfx.trim(endNode.data)).replace(String.fromCharCode(160), '') === ''
                ) {
                    endNode.data = '';
                }
            } catch (e) {
                // IE error catch...
                return;
            }

            var firstBlock = dfx.getFirstBlockParent(endNode);
            if (range.collapsed === true
                && ((endNode.nodeType === dfx.TEXT_NODE && range.endOffset === endNode.data.length)
                || endNode.nodeType === dfx.ELEMENT_NODE && dfx.isTag(endNode, 'br'))
                && !endNode.nextSibling
                && (range._getLastSelectableChild(firstBlock, true) === endNode
                || range._getLastSelectableChild(firstBlock, true) === null && dfx.isTag(endNode, 'br') === true || (endNode.nodeType === dfx.TEXT_NODE && endNode.data.length === 0))
            ) {
                if (firstBlock && !defaultTagName && firstBlock === this.viper.getViperElement()) {
                    var br = document.createElement('br');
                    this.viper.insertNodeAtCaret(br);
                    if (!br.nextSibling) {
                        dfx.insertAfter(br, document.createElement('br'));
                    }

                    range.setStart(br.nextSibling, 0);
                    range.collapse(true);
                    ViperSelection.addRange(range);

                    return false;
                } else if (firstBlock) {
                    var firstBlockTagName = dfx.getTagName(firstBlock);
                    var handleEnter       = false;
                    var removeFirstBlock  = false;
                    if (this._tagList.inArray(firstBlockTagName) === true) {
                        handleEnter = true;
                    } else if (firstBlockTagName === 'li'
                        && (this.viper.isBrowser('chrome') === true || this.viper.isBrowser('safari') === true)
                        && dfx.trim(dfx.getNodeTextContent(firstBlock)) === ''
                    ) {
                        handleEnter = true;
                        removeFirstBlock = true;
                    }

                    if (handleEnter === true) {
                        if (defaultTagName === '') {
                            var br = document.createElement('br');
                            dfx.insertAfter(firstBlock, br);
                            range.setStart(br, 0);
                            range.collapse(true);
                            ViperSelection.addRange(range);
                            return false;
                        }

                        var content = '<br />';
                        if (this.viper.isBrowser('msie') === true) {
                            content = '&nbsp;';
                        }

                        var tagName = defaultTagName;
                        var p = document.createElement(tagName);
                        dfx.setHtml(p, content);

                        // If the firstBlock is a P tag and it's parent is not the
                        // Viper editable element and its the last child then move this
                        // new P tag after its parent element.
                        if (dfx.isTag(firstBlock, 'p') === true
                            && firstBlock.parentNode !== this.viper.getViperElement()
                            && !firstBlock.nextSibling
                            && dfx.trim(dfx.getNodeTextContent(firstBlock)) === ''
                        ) {
                            dfx.insertAfter(firstBlock.parentNode, p);
                            removeFirstBlock = true;
                        } else {
                            if (firstBlockTagName === 'li') {
                                if (this.viper.isBrowser('chrome') === true || this.viper.isBrowser('safari') === true) {
                                    var parentListItem = dfx.getFirstBlockParent(firstBlock.parentNode);
                                    if (parentListItem && dfx.isTag(parentListItem, 'li') === true) {
                                        newList = document.createElement('li');
                                        newList.appendChild(document.createElement('br'));

                                        var subList = null;
                                        while (firstBlock.nextSibling) {
                                            if (dfx.isTag(firstBlock.nextSibling, 'li') === true) {
                                                if (!subList) {
                                                    subList = document.createElement(dfx.getTagName(firstBlock.parentNode));
                                                    newList.appendChild(subList);
                                                }

                                                subList.appendChild(firstBlock.nextSibling);
                                            } else if (subList) {
                                                subList.appendChild(firstBlock.nextSibling);
                                            } else {
                                                newList.appendChild(firstBlock.nextSibling);
                                            }
                                        }

                                        dfx.remove(firstBlock);
                                        dfx.insertAfter(parentListItem, newList);
                                        range.selectNode(newList.firstChild);
                                        range.collapse(true);
                                        ViperSelection.addRange(range);
                                        return false;
                                    }
                                }

                                // Need to move rest of the list items to a new
                                // list.
                                var newList = document.createElement(dfx.getTagName(firstBlock.parentNode));
                                while (firstBlock.nextSibling) {
                                    newList.appendChild(firstBlock.nextSibling);
                                }

                                if (dfx.getTag('li', newList).length > 0) {
                                    dfx.insertAfter(firstBlock.parentNode, newList);
                                }

                                dfx.insertAfter(firstBlock.parentNode, p);
                            } else {
                                dfx.insertAfter(firstBlock, p);
                            }
                        }

                        if (removeFirstBlock === true) {
                            dfx.remove(firstBlock);
                        }

                        if (p.firstChild.nodeType === dfx.TEXT_NODE) {
                            if (this.viper.isBrowser('msie') === true
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

                        if (this.viper.isBrowser('firefox') === false) {
                            this.viper.fireNodesChanged();
                        }

                        this.viper.fireSelectionChanged();

                        return false;
                    }//end if
                }//end if
            }//end if

            var startNode   = range.getStartNode();
            var blockParent = null;
            if (!startNode) {
                startNode = range.startContainer;
                if (dfx.isBlockElement(startNode) === true) {
                    blockParent = startNode;
                }
            } else {
                blockParent = dfx.getFirstBlockParent(startNode);
            }

            if (startNode && dfx.isTag(blockParent, 'pre') === true) {
                if (startNode.parentNode === blockParent
                    && startNode.nodeType === dfx.TEXT_NODE
                    && dfx.trim(startNode.data) === ''
                ) {
                    if (startNode.nextSibling
                        && !startNode.nextSibling.nextSibling
                        && startNode.nextSibling.nodeType === dfx.TEXT_NODE
                        && dfx.trim(startNode.nextSibling.data) === ''
                    ) {
                        dfx.remove(startNode.nextSibling);
                    }

                    dfx.remove(startNode);
                    var p = document.createElement('p');
                    dfx.setHtml(p, '<br />');
                    dfx.insertAfter(blockParent, p);
                    range.selectNode(p.firstChild);
                    range.collapse(true);
                    ViperSelection.addRange(range);
                } else {
                    this.insertTextAtRange(range, "\n");
                }

                return false;
            } else if (blockParent === this.viper.getViperElement() && !defaultTagName) {
                if (startNode.nodeType === dfx.TEXT_NODE
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
            } else if (this.viper.isBrowser('msie') === true
                && range.startOffset === 0
                && range.collapsed === true
                && dfx.isTag(startNode, 'li') === true
            ) {
                if (!startNode.nextSibling || (startNode.nextSibling.nodeType === dfx.TEXT_NODE && !startNode.nextSibling.nextSibling)) {
                    if (startNode.parentNode.parentNode === this.viper.getViperElement()) {
                        var p = document.createElement('p');
                        dfx.setHtml(p, '&nbsp');
                        dfx.insertAfter(startNode.parentNode, p);
                        range.setEnd(p.firstChild, 1);
                        range.moveEnd('character', -1);
                        range.collapse(false);
                        ViperSelection.addRange(range);

                        this.viper.fireSelectionChanged();
                        dfx.remove(startNode);
                        return false;
                    }
                }
            }//end if

            var selectedNode = range.getNodeSelection();
            var viperElem    = this.viper.getViperElement();
            if (selectedNode && selectedNode === viperElem) {
                if (this.viper.isBrowser('msie') === true) {
                    // Let IE do it as there is no way of telling if the caret is
                    // before or after the iframe.
                    return;
                }

                var elem = document.createElement(defaultTagName);
                dfx.setHtml(elem, '<br />');
                if (viperElem.firstChild) {
                    dfx.insertBefore(viperElem.firstChild, elem);
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
                && startNode.nodeType === dfx.ELEMENT_NODE
                && (this.viper.isBrowser('firefox') !== true || !(dfx.isTag(startNode, 'br') === true && (!blockParent || dfx.isTag(blockParent, 'li') === true)))
                && dfx.isStubElement(startNode) === false
            ) {
                var elem = document.createElement(defaultTagName);
                dfx.setHtml(elem, '<br />');
                dfx.insertBefore(startNode, elem);
                range.selectNode(elem.firstChild);
                range.collapse(true);
                ViperSelection.addRange(range);
                this.viper.fireSelectionChanged();
                return false;
            } else if (!selectedNode
                && startNode
                && endNode
                && startNode !== endNode
                && startNode.nodeType === dfx.ELEMENT_NODE
                && endNode.nodeType === dfx.ELEMENT_NODE
            ) {
                var elem = document.createElement(defaultTagName);
                dfx.setHtml(elem, '<br />');

                if (dfx.isStubElement(endNode) === true) {
                    dfx.insertAfter(startNode, elem);
                } else {
                    dfx.insertAfter(endNode, elem);
                }

                range.selectNode(elem.firstChild);
                range.collapse(true);
                ViperSelection.addRange(range);
                this.viper.fireSelectionChanged();
                return false;
            } else if (this.viper.isBrowser('firefox') === true
                && startNode.nodeType === dfx.TEXT_NODE
                && endNode === startNode
                && range.startOffset === startNode.data.length
                && range.collapsed === true
                && dfx.isTag(blockParent, 'li') === true
                && dfx.isChildOf(dfx.getFirstBlockParent(range.getNextContainer(startNode)), blockParent)
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

                dfx.insertAfter(blockParent, li);
                range.selectNode(li.firstChild);
                range.collapse(true);
                ViperSelection.addRange(range);
                return false;
            } else if (selectedNode
                && dfx.isTag(selectedNode, 'li') === true
                && blockParent === selectedNode
                && startNode === endNode
                && dfx.isTag(startNode, 'br') === true
                && range.collapsed === true
                && !startNode.nextSibling
            ) {
                var parentListItem = dfx.getFirstBlockParent(blockParent.parentNode);
                if (parentListItem && dfx.isTag(parentListItem, 'li') === true) {
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
                        if (dfx.isTag(blockParent.nextSibling, 'li') === true) {
                            if (!subList) {
                                subList = document.createElement(dfx.getTagName(blockParent.parentNode));
                                li.appendChild(subList);
                            }

                            subList.appendChild(blockParent.nextSibling);
                        } else if (subList) {
                            subList.appendChild(blockParent.nextSibling);
                        } else {
                            li.appendChild(blockParent.nextSibling);
                        }
                    }

                    dfx.remove(blockParent);
                    dfx.insertAfter(parentListItem, li);
                    range.selectNode(li.firstChild);
                    range.collapse(true);
                    ViperSelection.addRange(range);
                    return false;
                } else if (this.viper.isBrowser('chrome') === true) {
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

                    dfx.insertAfter(blockParent.parentNode, elem);

                    // If the list item is not the last one we need to move
                    // the rest of them to a new list.
                    var listItems = [];
                    for (var node = blockParent; node; node = node.nextSibling) {
                        if (dfx.isTag(node, 'li') === true) {
                            listItems.push(node);
                        }
                    }

                    if (listItems.length > 0) {
                        var newList = document.createElement(dfx.getTagName(blockParent.parentNode));
                        dfx.insertAfter(elem, newList);
                        while (listItems.length > 0) {
                            newList.appendChild(listItems.shift());
                        }
                    }

                    dfx.remove(blockParent);

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
                && startNode.nodeType === dfx.TEXT_NODE
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

        if (this.viper.isBrowser('chrome') === true) {
            // This block of code is a workaround for the delete bug in Chrome.
            // See http://goo.gl/QPB0v
            if (e.keyCode === 46
                && range.collapsed === true
                && range.startContainer.nodeType === dfx.TEXT_NODE
                && range.startOffset === range.startContainer.data.length
                && !range.startContainer.nextSibling
            ) {
                // At the end of an element. Check to see if next available
                // element is a block.
                var nextSelectable = range.getNextContainer(range.startContainer, null, true);
                var currentParent  = dfx.getFirstBlockParent(range.startContainer);
                var nextParent     = dfx.getFirstBlockParent(nextSelectable);
                if (currentParent !== nextParent && this.viper.isOutOfBounds(nextSelectable) === false) {
                    while (nextParent.firstChild) {
                        currentParent.appendChild(nextParent.firstChild);
                    }

                    dfx.remove(nextParent);
                    dfx.preventDefault(e);
                    this.viper.fireNodesChanged();
                    return false;
                }
            } if (e.keyCode === 46
                && range.collapsed === true
                && range.startContainer.nodeType === dfx.ELEMENT_NODE
                && dfx.isTag(range.getStartNode(), 'br') === true
            ) {
                dfx.remove(range.getStartNode());
                dfx.preventDefault(e);
                this.viper.fireNodesChanged();
                return false;
            } else if (e.keyCode === 8
                && range.collapsed === true
                && range.startContainer.nodeType === dfx.TEXT_NODE
                && (range.startOffset === 0 || (range.startOffset === 1 && range.startContainer.data.charAt(0) === ' '))
                && (!range.startContainer.previousSibling || dfx.isTag(range.startContainer.previousSibling, 'br') === true)
            ) {
                // At the start of an element. Check to see if the previous
                // element is a part of another block element. If it is then
                // join these elements.
                var prevSelectable = range.getPreviousContainer(range.startContainer, null, true, true);
                var currentParent  = dfx.getFirstBlockParent(range.startContainer);
                var prevParent     = dfx.getFirstBlockParent(prevSelectable);
                if (currentParent !== prevParent && this.viper.isOutOfBounds(prevSelectable) === false) {
                    // Check if there are any other elements in between.
                    var elemsBetween = dfx.getElementsBetween(prevParent, currentParent);
                    if (elemsBetween.length > 0) {
                        // There is at least one non block element in between.
                        // Remove it.
                        dfx.remove(elemsBetween[(elemsBetween.length - 1)]);
                    } else {
                        while (currentParent.firstChild) {
                            prevParent.appendChild(currentParent.firstChild);
                        }

                        dfx.remove(currentParent);

                        if (prevSelectable.nodeType === dfx.TEXT_NODE) {
                            range.setStart(prevSelectable, prevSelectable.data.length);
                        } else {
                            range.setStartAfter(prevSelectable);
                        }

                        range.collapse(true);
                        ViperSelection.addRange(range);
                    }

                    dfx.preventDefault(e);
                    this.viper.fireNodesChanged();

                    return false;
                } else if (dfx.isTag(prevSelectable, 'br') === true) {
                    dfx.remove(prevSelectable);
                    dfx.preventDefault(e);
                    this.viper.fireNodesChanged();
                    return false;
                }
            } else if (
                range.collapsed === false
                && range.startContainer !== range.endContainer
                && range.startContainer.nodeType === dfx.TEXT_NODE
            ) {
                // This is a selection on different text nodes. Check to see
                // if these nodes are part of two different block elements.
                var nodeSelection = range.getNodeSelection();
                if (nodeSelection) {
                    if (nodeSelection === this.viper.getViperElement()) {
                        var defaultTagName = this.viper.getDefaultBlockTag();
                        if (defaultTagName !== '') {
                            var defTag = document.createElement(defaultTagName);
                            dfx.setHtml(defTag, '&nbsp;');
                            dfx.setHtml(nodeSelection, '');
                            nodeSelection.appendChild(defTag);
                        } else {
                            dfx.setHtml(nodeSelection, '<br />');
                        }
                    } else {
                        dfx.remove(nodeSelection);
                    }
                } else {
                    var startParent = dfx.getFirstBlockParent(range.startContainer);
                    var endParent   = dfx.getFirstBlockParent(range.endContainer);
                    if (startParent !== endParent) {
                        // Two different parents. We need to join these parents.
                        // First remove all elements in between.
                        range.deleteContents();

                        // Now bring the contents of the next selectable to the
                        // start parent.
                        var nextSelectable = range.getNextContainer(range.startContainer, null, true);
                        if (this.viper.isOutOfBounds(nextSelectable) === false) {
                            var nextParent     = dfx.getFirstBlockParent(nextSelectable);

                            while (nextParent.firstChild) {
                                startParent.appendChild(nextParent.firstChild);
                            }

                            dfx.remove(nextParent);
                        }
                    } else {
                        // Same container just remove contents.
                        range.deleteContents();
                    }//end if
                }//end if

                dfx.preventDefault(e);
                range.collapse(true);
                ViperSelection.addRange(range);
                this.viper.fireNodesChanged();
                return false;
            }//end if
        }//end if

        if (range.startOffset !== 0) {
            return;
        }

        var defaultTagName  = this.viper.getDefaultBlockTag();
        var viperElement    = this.viper.getViperElement();
        var firstSelectable = range._getFirstSelectableChild(viperElement);

        if (range.collapsed === true && e.keyCode === 8) {
            var startNode = range.getStartNode();
            if (startNode && startNode.nodeType === dfx.TEXT_NODE) {
                var skippedBlockElem = [];
                var node      = range.getPreviousContainer(startNode, skippedBlockElem, true, true);
                if (this.viper.isOutOfBounds(node) === true) {
                    // Range is at the start of the editable element, nothing to delete except any blank block elements.
                    if (skippedBlockElem.length > 0) {
                        for (var i = 0; i < skippedBlockElem.length; i++) {
                            if (dfx.isTag(skippedBlockElem[i], 'p') === true) {
                                dfx.remove(skippedBlockElem[i]);
                            }
                        }
                    } else if (startNode.nodeType !== dfx.TEXT_NODE || startNode.data.length === 0) {
                        node = range.getNextContainer(startNode, skippedBlockElem, true, true);
                        if (node && this.viper.isOutOfBounds(node) === false) {
                            dfx.remove(dfx.getSurroundingParents(startNode));
                            range.setStart(node, 0);
                            range.collapse(true);
                            ViperSelection.addRange(range);
                        }
                    }

                    return false;
                }
            }
        }

        if (firstSelectable === range.startContainer || viperElement === range.startContainer) {
            var lastSelectable  = range._getLastSelectableChild(viperElement);
            if (range.endContainer === viperElement
                || (range.endContainer === lastSelectable && range.endOffset === lastSelectable.data.length)
            ) {
                // The whole Viper element is selected, remove all of its content
                // and then initialise the Viper element.
                dfx.setHtml(viperElement, '');
                this.viper.initEditableElement();

                if (this.viper.isBrowser('chrome') === true
                    || this.viper.isBrowser('safari') === true
                    || this.viper.isBrowser('msie') === true
                ) {
                    // Chrome, Safari and IE needs to fire nodes changed here as they do
                    // not fire keypress.
                    this.viper.fireNodesChanged();
                }

                return false;
            }
        } else if (this.viper.isBrowser('msie') === true) {
            // Remove HR elements in IE..
            var rangeClone = range.cloneRange();
            rangeClone.moveStart('character', -2);
            if (dfx.trim(rangeClone.getHTMLContents()) === '<HR>') {
                range.moveStart('character', -2);
                range.deleteContents();
            } else {
                if (rangeClone.endContainer.nodeType === dfx.ELEMENT_NODE
                    && rangeClone.endOffset === 0
                    && rangeClone.endContainer.innerHTML === ''
                ) {
                    var nextNode = rangeClone.getNextContainer(rangeClone.startContainer, null, true);
                    dfx.remove(rangeClone.endContainer);
                    rangeClone.setEnd(nextNode, 0);
                    rangeClone.collapse(false);
                    ViperSelection.addRange(rangeClone);

                    return false;
                } else if (range.startContainer
                    && range.startContainer.nodeType === dfx.TEXT_NODE
                    && range.endContainer
                    && range.endContainer.nodeType === dfx.TEXT_NODE
                    && range.startOffset === 0
                    && range.endOffset === range.endContainer.data.length
                ) {
                    // Remove a whle list element. IE seems to remove the list
                    // items but not the UL/OL element...
                    var parentLists = dfx.getParents(range.startContainer, 'ul,ol', this.viper.getViperElement());
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
                                    dfx.remove(parentList);
                                    range.setEnd(newSelectable, newSelectable.data.length);
                                    range.collapse(false);
                                    ViperSelection.addRange(range);
                                }
                            } else {
                                dfx.remove(parentList);
                                range.setEnd(newSelectable, 0);
                                range.collapse(false);
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
            && range.startContainer.nodeType === dfx.TEXT_NODE
            && this.viper.isBrowser('firefox') === true
        ) {
            var firstBlock = dfx.getFirstBlockParent(range.startContainer);
            if (firstBlock
                && range._getFirstSelectableChild(firstBlock) === range.startContainer
                && firstBlock.previousSibling
                && dfx.isStubElement(firstBlock.previousSibling) === true
            ) {
                // Firefox does not handle deletion at the start of a block element
                // very well when the previous sibling is a stub element (e.g. HR).
                dfx.remove(firstBlock.previousSibling);
                return false;
            }
        } else if (range.startOffset === 0
            && range.collapsed === false
            && this.viper.isBrowser('msie') !== true
        ) {
            // Chrome has issues with removing list items from lists.
            var startNode = range.getStartNode();
            var endNode   = range.getEndNode();

            // First issue is, if a whole list item is selected, it removes the li
            // and it adds a span tag in place of it, creating invalid HTML and
            // causing all sorts of issues. It should only remove the list item
            // contents and leave the list item un touched..
            if (startNode === endNode
                && startNode.nodeType === dfx.TEXT_NODE
                && dfx.isTag(startNode.parentNode, 'li') === true
                && startNode.data.length === range.endOffset
            ) {
                dfx.setHtml(startNode.parentNode, '<br />');
                return false;
            } else if ((dfx.isTag(range.commonAncestorContainer, 'ul') || dfx.isTag(range.commonAncestorContainer, 'ol'))) {
                // Second issue is with removing multiple list items.
                if (endNode.data.length === range.endOffset) {
                    var endItem = dfx.getParents(endNode, 'li')[0];
                    if (endNode === range._getLastSelectableChild(endItem)) {
                        // Whole list item is selected.
                        // Get the start list item and all other list items until
                        // the end list item.
                        var startItem = dfx.getParents(startNode, 'li')[0];
                        if (startNode === range._getFirstSelectableChild(startItem)) {
                            var elements = dfx.getElementsBetween(startItem, endItem);
                            elements.push(startItem, endItem);

                            // Find a new node we can put caret in.
                            var newSelContainer = range.getNextContainer(endNode, null, true);
                            dfx.remove(elements);

                            if (newSelContainer) {
                                // Set the caret location.
                                range.setStart(newSelContainer, 0);
                                range.collapse(true);
                                ViperSelection.addRange(range);
                            }

                            if (this.viper.isBrowser('chrome') === true || this.viper.isBrowser('safari') === true) {
                                this.viper.fireNodesChanged();
                            }

                            // Prevent default action.
                            return false;
                        }//end if
                    }//end if
                }//end if
            }//end if
        } else if (range.startOffset === 0
            && range.collapsed === true
            && range.startContainer === range.endContainer
            && e.keyCode === 8
            && (this.viper.elementIsEmpty(range.startContainer) === true || dfx.getHtml(range.startContainer) === '<br>')
        ) {
            var skippedBlockElem = [];
            var endCont = range.endContainer;
            var node    = range.getPreviousContainer(range.startContainer, skippedBlockElem, true, true);

            var startOffset = 0;
            if (!node || dfx.isChildOf(node, this.viper.element) === false) {
                if (skippedBlockElem.length > 0) {
                    for (var i = 0; i < skippedBlockElem.length; i++) {
                        if (dfx.isTag(skippedBlockElem[i], 'p') === true) {
                            dfx.remove(skippedBlockElem[i]);
                        }
                    }
                }

                return false;

                node = range.getNextContainer(endCont, null, true);
                if (this.viper.isOutOfBounds(node) === true) {
                    node = endCont;
                }
            } else if (node.nodeType === dfx.TEXT_NODE) {
                startOffset = node.data.length;
            }

            range.setEnd(node, startOffset);
            range.collapse(false);
            ViperSelection.addRange(range);

            if (endCont
                && endCont.nodeType === dfx.ELEMENT_NODE
                && (dfx.isTag(endCont, 'td') === true || dfx.isTag(endCont, 'th') === true)
            ) {
                return;
            }

            var parent = endCont.parentNode;
            dfx.remove(endCont);
            while (parent.childNodes.length === 0) {
                if (parent === viperElement) {
                    break;
                }

                var remove = parent;
                parent = parent.parentNode;
                dfx.remove(remove);
            }

            return false;
        }//end if

        if (range.startOffset === 0
            && range.collapsed === false
            && this.viper.isBrowser('msie') !== true
            && range.startContainer !== range.endContainer
            && range.startContainer.nodeType === dfx.TEXT_NODE
            && range.endContainer.nodeType === dfx.TEXT_NODE
            && range.endOffset === range.endContainer.data.length
        ) {
            var startParent     = dfx.getFirstBlockParent(range.startContainer);
            var endParent       = dfx.getFirstBlockParent(range.endContainer);
            var firstSelectable = range._getFirstSelectableChild(startParent);
            var lastSelectable  = range._getLastSelectableChild(endParent);

            if (firstSelectable === range.startContainer
                && lastSelectable === range.endContainer
            ) {
                if (defaultTagName !== '') {
                    var p = document.createElement(defaultTagName);
                    dfx.setHtml(p, '<br />');
                    dfx.insertBefore(startParent, p);
                    dfx.remove(dfx.getElementsBetween(startParent, endParent));
                    dfx.remove(startParent);
                    dfx.remove(endParent);
                    range.setStart(p, 0);
                    range.collapse(true);
                } else {
                    var br = document.createElement('br');
                    dfx.insertBefore(startParent, br);
                    dfx.remove(dfx.getElementsBetween(startParent, endParent));
                    dfx.remove(startParent);
                    dfx.remove(endParent);
                    range.setStart(br, 0);
                    range.collapse(true);
                }

                ViperSelection.addRange(range);
                if (this.viper.isBrowser('firefox') !== true) {
                    this.viper.fireNodesChanged();
                }

                return false;
            }
        }

    },

    splitAtRange: function(returnFirstBlock, range)
    {
        range = range || this.viper.getViperRange();

        var selectedNode = range.getNodeSelection();
        if (selectedNode && selectedNode.nodeType === dfx.ELEMENT_NODE) {
            selectedNode.innerHTML = '&nbsp;';
            return selectedNode;
        }

        // If the range is not collapsed then remove the contents of the selection.
        if (range.collapsed !== true) {
            if (this.viper.isBrowser('chrome') === true
                || this.viper.isBrowser('safari') === true
            ) {
                range.deleteContents();
                ViperSelection.addRange(range);
            } else {
                this.viper.deleteContents();
                ViperSelection.addRange(this.viper.getCurrentRange());
                range = this.viper.getViperRange();
            }
        }

        if (range.startContainer.nodeType === dfx.TEXT_NODE) {
            // Find the first parent block element.
            var parent = range.startContainer.parentNode;
            if (parent === this.viper.getViperElement()) {
                // Check if there are any block elements before this node.
                if (range.startContainer.previousSibling
                    && range.startContainer.previousSibling.nodeType !== dfx.TEXT_NODE
                ) {
                    return range.startContainer.previousSibling;
                } else {
                    // Cretae a new paragraph and insert it at range position.
                    var para = document.createElement('p');
                    dfx.setHtml(para, '&nbsp;');
                    dfx.insertAfter(range.startContainer, para);
                    return para;
                }
            }

            var blockQuote = dfx.getParents(range.startContainer, 'blockquote', this.viper.element);

            while (parent) {
                if (dfx.isBlockElement(parent) === true) {
                    if (blockQuote.length === 0 || dfx.isTag(parent, 'blockquote') === true) {
                        break;
                    }
                }

                if (parent.parentNode && parent.parentNode === this.viper.element) {
                    break;
                }

                parent = parent.parentNode;
            }
        } else if (range.startContainer === range.endContainer
            && dfx.isStubElement(range.startContainer)
            && range.startContainer.parentNode.firstChild === range.startContainer
            && range.startContainer.parentNode.lastChild === range.startContainer
        ) {
            parent = range.startContainer.parentNode;
            dfx.setHtml(parent, '&nbsp;');
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
        if (dfx.isChildOf(parent, this.viper.element) === false) {
            // Find the next non block sibling.
            var node = range.endContainer;
            while (dfx.isset(node.nextSibling) === true) {
                if (dfx.isBlockElement(node.nextSibling) === true) {
                    break;
                }

                node = node.nextSibling;
            }

            range.setEndAfter(node);

            var elem    = Viper.document.createElement('p');
            var docFrag = range.extractContents('p');

            this.viper.deleteContents();
            elem.appendChild(docFrag);
            dfx.insertAfter(range.startContainer, elem);
            range.collapse(true);

            // Find the previous non block sibling.
            node = range.startContainer;
            while (dfx.isset(node.previousSibling) === true) {
                if (dfx.isBlockElement(node.previousSibling) === true) {
                    break;
                }

                node = node.previousSibling;
            }

            range.setStartBefore(node);

            var felem = Viper.document.createElement('p');
            docFrag   = range.extractContents('p');
            felem.appendChild(docFrag);
            dfx.insertBefore(elem, felem);

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
        if (range.startContainer.nodeType === dfx.TEXT_NODE
            && range.startOffset === range.startContainer.data.length
        ) {
            if (!range.startContainer.nextSibling) {
                var newTextNode = Viper.document.createTextNode('');
                dfx.insertAfter(range.startContainer.parentNode, newTextNode);
                range.setStart(newTextNode, 0);
                range.collapse(true);
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
        var elemClone = elem.cloneNode(true);
        dfx.remove(dfx.getTag('del', elemClone));

        if (dfx.isBlank(dfx.getNodeTextContent(elemClone)) === true) {
            // Do not need this empty element.
            elem = null;
        }

        if (elem === null || (elem.tagName && elem.tagName.toLowerCase() !== 'li' && dfx.isBlockElement(elem) === false)) {
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
                dfx.setHtml(pelem, '&nbsp;');
            }

            elem = pelem;
            ViperChangeTracker.addChange('createContainer', [elem]);
        } else {
            ViperChangeTracker.removeTrackChanges(elem, true);
            ViperChangeTracker.addChange('splitContainer', [elem]);
        }//end if

        if (this.viper.elementIsEmpty(parent) === true) {
            dfx.setHtml(parent, '&nbsp;');
        }

        // Insert the new element after the current parent.
        dfx.insertAfter(parent, elem);

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
        if (dfx.isBlockElement(parent) === true && dfx.trim(dfx.getHtml(parent)) === '') {
            dfx.setHtml(parent, '&nbsp;');
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
            if (startNode && dfx.isTag(dfx.getFirstBlockParent(startNode), 'pre') === true) {
                this.insertTextAtRange(range, "\n");
                return false;
            }
        }

        var node = Viper.document.createElement('br');
        this.viper.insertNodeAtCaret(node);

        if (dfx.isTag(node.previousSibling, 'br') === true) {
            // The previous sibling is also a br tag and to be able to position
            // caret between these two br tags we need to insert a text node in
            // between them.
            this.viper.insertAfter(node.previousSibling, this.viper.createSpaceNode());
        } else if (!node.nextSibling && dfx.isBlockElement(node.parentNode) === false) {
            dfx.insertAfter(node.parentNode, node);
        }

        return !this.viper.setCaretAfterNode(node);

    },

    insertTextAtRange: function(range, text)
    {
        var node = range.startContainer;
        // Assuming the range is collapsed already.
        if (node.nodeType === dfx.TEXT_NODE) {
            // Split the text node and insert new line char.
            var newNode = node.splitText(range.startOffset);
            dfx.insertBefore(newNode, document.createTextNode(text));
        } else {
            // Element node..
            node = range.startContainer.childNodes[range.startOffset];
            if (node.nodeType === dfx.TEXT_NODE) {
                // Split the text node and insert new line char.
                var newNode = node.splitText(range.startOffset);
                dfx.insertBefore(newNode, document.createTextNode(text));
            } else {
                newNode = document.createTextNode(text);
                dfx.insertAfter(node, newNode);
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
                dfx.insertBefore(sibling, ctNode);
            } else if (newNode.previousSibling) {
                var sibling = newNode.previousSibling;
                ctNode      = ViperChangeTracker.createCTNode('ins', 'textAdd', newNode);
                dfx.insertAfter(sibling, ctNode);
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
        var preTags = dfx.getTag('pre', this.viper.getViperElement());
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

        var elems = dfx.getTag('p,div', pre);
        var c     = elems.length;

        for (var i = 0; i < c; i++) {
            var elem = elems[i];
            while (elem.firstChild) {
                dfx.insertBefore(elem, elem.firstChild);
            }

            dfx.insertBefore(elem, document.createTextNode("\n\n"));
            dfx.remove(elem);
        }

        var elems = dfx.getTag('br', pre);
        var c     = elems.length;

        for (var i = 0; i < c; i++) {
            var elem = elems[i];
            dfx.insertBefore(elem, document.createTextNode("\n"));
            dfx.remove(elem);
        }

    }

};
