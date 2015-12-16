function ViperInputHandler(viper)
{
    this._viper           = viper;
    this._preventKeyPress = false;
}

ViperInputHandler.prototype = {
    init: function() {
        var self      = this;
        var elem      = this._viper.getViperElement();
        var namespace = this._viper.getEventNamespace();

        // Add key events. Note that there is a known issue with IME keyboard events
        // see https://bugzilla.mozilla.org/show_bug.cgi?id=354358. This effects
        // change tracking while using Korean, Chinese etc.
        ViperUtil.addEvent(elem, 'keypress.' + namespace, function(e) {
            return self.keyPress(e);
        });

        ViperUtil.addEvent(elem, 'keydown.' + namespace, function(e) {
            return self.keyDown(e);
        });

        // This keydown event will make sure that any selection started outside of Viper element and ended inside
        // Viper element is not going to trigger browser's 'back button'.
        ViperUtil.addEvent(Viper.document, 'keydown.' + namespace, function(e) {
            if (e.which === 8 || e.which === 46) {
                var range = self._viper.getCurrentRange();
                if (self._viper.isOutOfBounds(range.startContainer) === true
                    ^ self._viper.isOutOfBounds(range.endContainer) === true
                ) {
                    ViperUtil.preventDefault(e);
                    return false;
                }
            }
        });

        ViperUtil.addEvent(elem, 'keyup.' + namespace, function(e) {
            return self.keyUp(e);
        });
    },

    /**
     * Handle the keyPress event.
     *
     * @param {event} e The event object.
     *
     * return {boolean} Returns false if default event needs to be blocked.
     */
    keyPress: function(e)
    {
        if (this._preventKeyPress === true || this._viper.isEnabled() !== true) {
            this._preventKeyPress = false;
            return true;
        }

        // Check that keyCode is not 0 as Firefox fires keyPress for arrow keys which
        // have key code of 0.
        if (e.which !== 0 && ViperChangeTracker.isTracking() === true) {
            if (e.which === ViperUtil.DOM_VK_BACKSPACE) {
                // Handle delete OP here because some browsers (e.g. Chrome, IE) does not
                // fire keyPress when DELETE is held down.
                this._viper.deleteContents();
                return false;
            }

            // Need to call Viper function to track changes for this keyPress.
            if (e.ctrlKey !== true
                && e.altKey !== true
                && e.shiftKey !== true
                && e.metaKey !== true
            ) {
                return this._viper.insertTextAtCaret(String.fromCharCode(e.which));
            }
        }

        var returnValue = this._viper.fireCallbacks('Viper:keyPress', e);
        if (returnValue === false) {
            ViperUtil.preventDefault(e);
            return false;
        }

        var viperElement = this._viper.getViperElement();

        if (ViperUtil.isInputKey(e) === true) {
            this._viper.fireCallbacks('Viper:charInsert', String.fromCharCode(e.which));

            var resetContent = false;
            var range        = this._viper.getCurrentRange();
            if (range.startOffset === 0
                && range.endContainer === viperElement
                && range.endOffset === (viperElement.childNodes.length - 1)
                && range.startContainer === range._getFirstSelectableChild(viperElement)
            ) {
                resetContent = true;
            } else if (ViperUtil.isBrowser('msie') === true
                && range.endContainer === viperElement
                && range.endOffset === 0
                && range.startOffset === 0
                && range.startContainer === range._getFirstSelectableChild(viperElement)
            ) {
                resetContent = true;
            } else if (range.startOffset === 0
                && range.endContainer === range._getLastSelectableChild(viperElement)
                && range.endOffset === range.endContainer.data.length
                && range.startContainer === range._getFirstSelectableChild(viperElement)
            ) {
                resetContent = true;
            } else if (range.startOffset === 0
                && range.startContainer === range.endContainer
                && range.startContainer === viperElement
                && range.endOffset >= viperElement.childNodes.length
            ) {
                resetContent = true;
            }//end if

            var nodeSelection = null;
            if (resetContent !== true) {
                nodeSelection = range.getNodeSelection(range, true);
                if (nodeSelection && nodeSelection === viperElement) {
                    resetContent = true;
                }
            }

            if (resetContent === true) {
                var tagName = this._viper.getDefaultBlockTag();
                if (viperElement.childNodes.length === 1 && ViperUtil.isBlockElement(viperElement.childNodes[0]) === true) {
                    // There is only one block element in the content so use its tag
                    // name.
                    tagName = ViperUtil.getTagName(viperElement.childNodes[0]);
                }

                // The whole content is selected and a char is being
                // typed. Remove the whole content of the editable element.
                if (!tagName) {
                    ViperUtil.setHtml(viperElement, '');
                } else {
                    ViperUtil.setHtml(viperElement, '<' + tagName + '>&nbsp;</' + tagName + '>');
                    range.setStart(range._getFirstSelectableChild(viperElement), 0);
                }

                range.collapse(true);
                ViperSelection.addRange(range);
            } else {
                if (nodeSelection && ViperUtil.isBlockElement(nodeSelection) === true && String.fromCharCode(e.which) !== '') {
                    switch (ViperUtil.getTagName(nodeSelection)) {
                        case 'table':
                        case 'ul':
                        case 'ol':
                            // Must create a new tag before setting the content.
                            var defaultTagName = this._viper.getDefaultBlockTag();
                            var defTag         = null;
                            if (defaultTagName !== '') {
                                defTag = document.createElement(defaultTagName);
                                ViperUtil.setHtml(defTag, String.fromCharCode(e.which));
                            } else {
                                defTag = document.createTextNode(String.fromCharCode(e.which));
                            }

                            ViperUtil.insertAfter(nodeSelection, defTag);
                            ViperUtil.remove(nodeSelection);
                            range.setStart(defTag, 1);
                            range.collapse(true);
                        break;

                        case 'tfooter':
                        case 'tbody':
                        case 'thead':
                        case 'tr':
                        case 'li':
                            // Tags that can be handled by browser.
                        return true;

                        break;

                        default:
                            var textNode = document.createTextNode(String.fromCharCode(e.which));

                            if (ViperUtil.isStubElement(nodeSelection) === true) {
                                ViperUtil.insertBefore(nodeSelection, textNode);
                                ViperUtil.remove(nodeSelection);
                            } else {
                                // Set the content of the existing tag.
                                ViperUtil.setHtml(nodeSelection, '');

                                if (ViperUtil.isTag(nodeSelection, 'blockquote') === true) {
                                    // Blockquote must have at least one P tag.
                                    var quoteP = document.createElement('p');
                                    nodeSelection.appendChild(quoteP);
                                    nodeSelection = quoteP;
                                }

                                nodeSelection.appendChild(textNode);
                            }

                            range.setStart(textNode, 1);
                            range.collapse(true);
                        break;
                    }//end switch

                    ViperSelection.addRange(range);
                    this._viper.fireNodesChanged([range.getStartNode()]);
                    return false;
                } else if (range.startContainer === range.endContainer
                    && ViperUtil.isTag(range.startContainer, 'br') === true
                    && range.collapsed === true
                    && range.startOffset === 0
                ) {
                    // IE text insert when BR tag is selected.
                    var textNode = document.createTextNode('');
                    ViperUtil.insertBefore(range.startContainer, textNode);
                    ViperUtil.remove(range.startContainer);
                    range.setStart(textNode, 0);
                    range.collapse(true);
                } else if (range.startContainer === range.endContainer
                    && range.startContainer.nodeType === ViperUtil.TEXT_NODE
                    && range.collapsed === true
                    && range.startOffset === range.startContainer.data.length
                ) {
                    if (range.startContainer.data.charAt(range.startOffset - 1) === ' ') {
                        // Inserting text at the end of a text node that ends with a space to prevent browser removing the
                        // space.
                        if (e.which === 32) {
                            range.startContainer.data = range.startContainer.data.substr(0, range.startOffset - 1);
                            range.startContainer.data += String.fromCharCode(160) + String.fromCharCode(160);
                        } else {
                            range.startContainer.data += String.fromCharCode(e.which);
                        }

                        range.setStart(range.startContainer, range.startContainer.data.length);
                        range.collapse(true);
                        ViperSelection.addRange(range);
                        this._viper.fireNodesChanged([range.getStartNode()]);
                        return false;
                    } else if (range.startContainer.data.length === 0) {
                        if (range.startContainer.previousSibling
                            && range.startContainer.previousSibling.nodeType === ViperUtil.TEXT_NODE
                        ) {
                            var prevSib = range.startContainer.previousSibling;
                            if (prevSib.data.charAt(prevSib.data.length - 1) === ' ') {
                                prevSib.data += String.fromCharCode(e.which);
                                range.setStart(prevSib, prevSib.data.length);
                                range.collapse(true);
                                ViperSelection.addRange(range);
                                this._viper.fireNodesChanged([range.getStartNode()]);
                                return false;
                            }
                        } else if (range.startContainer.parentNode
                            && ViperUtil.isBlockElement(range.startContainer.parentNode) === false
                            && ViperUtil.isEmptyElement(range.startContainer.parentNode) === true
                        ) {
                            // Parent node is empty.
                            var parentPrevSib = range.startContainer.parentNode.previousSibling;
                            if (parentPrevSib
                                && parentPrevSib.nodeType === ViperUtil.TEXT_NODE
                                && parentPrevSib.data.charAt(parentPrevSib.data.length - 1) === ' '
                            ) {
                                // Parent's previous sibling has white space at the end.
                                parentPrevSib.data += String.fromCharCode(e.which);
                                range.setStart(parentPrevSib, parentPrevSib.data.length);
                                range.collapse(true);
                                ViperSelection.addRange(range);
                                this._viper.fireNodesChanged([range.getStartNode()]);
                                return false;
                            }
                        }
                    }
                }


                var char = String.fromCharCode(e.which);
                if (range.collapsed === true
                    && char !== ' '
                    && range.startContainer.nodeType === ViperUtil.TEXT_NODE
                    && range.endOffset === range.startContainer.data.length
                    && range.endOffset > 0
                    && range.startContainer.data.lastIndexOf(String.fromCharCode(160)) === (range.startContainer.data.length - 1)
                ) {
                    // If the last character of a text node is nbsp; and a new character is being inserted then replace the nbsp
                    // with normal space.
                    range.startContainer.data = range.startContainer.data.substr(0, range.startContainer.data.length - 1);
                    range.startContainer.data += ' ' + char;
                    range.setStart(range.startContainer, range.startContainer.data.length);
                    range.collapse(true);
                    ViperSelection.addRange(range);
                    this._viper.fireNodesChanged();
                    return false;
                }

                if (ViperUtil.isBrowser('msie', '<11') === true
                    && range.collapsed === true
                    && range.startContainer.nodeType === ViperUtil.TEXT_NODE
                    && range.startOffset === range.startContainer.data.length
                    && !range.startContainer.nextSibling
                ) {
                    // Handle: <p><strong>text</strong>*</p> -> <p><strong>text</strong>new text</p>.
                    // See: KeyboardEditorPlugin.
                    var node      = range.startContainer.parentNode;
                    var foundNode = null;
                    if (ViperUtil.isTag(node, 'span') === true && ViperUtil.hasAttribute(node, 'data-viper-span') === true) {
                        foundNode = node;
                    } else {
                        while (node) {
                            if (node.nextSibling) {
                                var nextSib = node.nextSibling;
                                if (ViperUtil.isTag(nextSib, 'span') === true
                                    && nextSib.firstChild === nextSib.lastChild
                                    && nextSib.firstChild.nodeType === ViperUtil.TEXT_NODE
                                    && nextSib.firstChild.data.length === 0
                                ) {
                                    foundNode = nextSibling;
                                }

                                break;
                            }
                            node = node.parentNode;
                        }
                    }//end if

                    if (foundNode !== null) {
                        ViperUtil.insertBefore(foundNode, foundNode.firstChild);
                        foundNode.previousSibling.data = String.fromCharCode(e.which);
                        range.setEnd(foundNode.previousSibling, 1);
                        range.collapse(false);
                        ViperSelection.addRange(range);
                        ViperUtil.remove(foundNode);
                        return false;
                    }
                }

                var startNode = range.getStartNode();
                if (e.which !== 0
                    && range.startContainer === range.endContainer
                    && range.collapsed === true
                    && range.startOffset === 0
                ) {
                    var textContainer = null;
                    if (range.startContainer.nodeType === ViperUtil.ELEMENT_NODE) {
                        if (range.startContainer.childNodes[range.startOffset]
                            && range.startContainer.childNodes[range.startOffset]
                            && range.startContainer.childNodes[range.startOffset].nodeType === ViperUtil.TEXT_NODE
                        ) {
                            textContainer = range.startContainer.childNodes[range.startOffset];
                        }
                    } else {
                        textContainer = range.startContainer;
                    }

                    if (textContainer && textContainer.nodeType === ViperUtil.TEXT_NODE) {
                        // At the start of a text node with an element sibling. Make sure character is inserted in this
                        // text node.
                        // Also make sure that there is no non breaking space at the start text node followed by a non
                        // space character.
                        if (textContainer.data.length > 1
                            && (textContainer.data.charCodeAt(0) === 160 || textContainer.data.charCodeAt(0) === 32)
                            && textContainer.data[1] !== ' '
                        ) {
                            if (char === ' ') {
                                char = String.fromCharCode(160);
                            } else {
                                textContainer.data = ' ' + textContainer.data.substr(1);
                            }
                        }

                        textContainer.data = char + textContainer.data;
                        range.setStart(textContainer, 1);
                        range.collapse(true);
                        ViperSelection.addRange(range);
                        this._viper.fireNodesChanged([range.getStartNode()]);
                        return false;
                    }
                } else if (ViperUtil.isBrowser('msie', '<11') === true
                    && range.collapsed === true
                    && range.startContainer.nodeType === ViperUtil.TEXT_NODE
                    && range.startOffset > 0
                    && range.startOffset < range.startContainer.data.length
                    && char !== ' '
                ) {
                    var data = range.startContainer.data;

                    // Character being inserted.
                    if (data.charCodeAt(range.startOffset) === 160
                        && (data.charCodeAt(range.startOffset + 1) !== 160 && data.charCodeAt(range.startOffset + 1) !== 32)
                    ) {
                        // Convert non breaking space to normal space.
                        // E.g. <p>t | ext.</p>.
                        var data = range.startContainer.data;

                        if (data.charCodeAt(range.startOffset - 1) === 160
                            && (data.charCodeAt(range.startOffset - 2) !== 160 && data.charCodeAt(range.startOffset - 2) !== 32)
                        ) {
                            // Previous character is nbsp as well, change it.
                            data = data.substr(0, range.startOffset - 1) + ' ';
                        } else {
                            data = data.substr(0, range.startOffset);
                        }

                        data += ' ' + range.startContainer.data.substr(range.startOffset + 1);
                        range.startContainer.data = data;
                        range.setStart(range.startContainer, range.startOffset);
                        range.collapse(true);
                        ViperSelection.addRange(range);
                    }
                } else if (ViperUtil.isBrowser('chrome') === true) {
                    if (ViperUtil.rangeInDiffBlocks(range) === true) {
                        // Chrome adds extra styles and tags like span, font etc when range is in two different block
                        // tags and a character is typed.
                        this._viper.getPluginManager().getPlugin('ViperKeyboardEditorPlugin').handleDelete({which: 8, keyCode: 8, preventDefault:function() {}});
                        return false;
                    }
                }
            }//end if

            this._viper.fireNodesChanged([range.getStartNode()]);
            return true;
        }//end if

        return true;

    },

    keyUp: function(e)
    {
        if (this._viper.fireCallbacks('Viper:keyUp', e) === false) {
            ViperUtil.preventDefault(e);
            return false;
        }

        if (e.which === ViperUtil.DOM_VK_BACKSPACE) {
            // Check if the content is now empty.
            var html = ViperUtil.getHtml(this._viper.element);
            if (!html || html === '<br>') {
                ViperUtil.setHtml(this._viper.element, '');
                this._viper.initEditableElement();
            }
        }

        this._keyDownRangeCollapsed = true;

    },

    /**
     * Keeps track of range status during keydown and keyup event.
     *
     * This var prevents keyUp event firing selectionChanged for each key up event.
     * Its for performance reasons only.
     */
    _keyDownRangeCollapsed: true,

    /**
     * Handle the keyDown event.
     *
     * @param {event} e The event object.
     *
     * return {void|boolean} Returns false if default event needs to be blocked.
     */
    keyDown: function(e)
    {
        this._viper._viperRange = null;
        var range        = this._viper.getCurrentRange();

        if (this._keyDownRangeCollapsed === true) {
            this._keyDownRangeCollapsed = range.collapsed;
        }

        if (e.which === ViperUtil.DOM_VK_BACKSPACE
            && ViperChangeTracker.isTracking() === true
            && ViperUtil.isBrowser('firefox') === false
        ) {
            // Handle delete OP here because some browsers (e.g. Chrome, IE) does not
            // fire keyPress when DELETE is held down.
            this._viper.deleteContents();
            return false;
        }

        var returnValue = this._viper.fireCallbacks('Viper:keyDown', e);
        if (returnValue === false) {
            ViperUtil.preventDefault(e);
            return false;
        }

        if (e.ctrlKey === false
            && e.altKey === false
            && (e.shiftKey === false || e.which !== 16)
            && e.metaKey === false
            && e.which !== 27
        ) {
            // Nothing special about this key let the browser handle it unless
            // the track changes is activated or no plugin is direcly modifying it.
            if (this._viper.isSpecialKey(e) === false) {
                if (ViperUtil.isBrowser('firefox') === true) {
                    this._firefoxKeyDown(e);
                } else if ((ViperUtil.isKey(e, 'backspace') === true || ViperUtil.isKey(e, 'delete') === true)
                    && (ViperUtil.isBrowser('chrome') === true || ViperUtil.isBrowser('safari') === true || ViperUtil.isBrowser('msie') === true)
                ) {
                    // Webkit does not fire keypress event for delete and backspace keys..
                    this._viper.fireNodesChanged();
                } else if (ViperUtil.isBrowser('msie', '10') === true) {
                    // Strange issue with IE10.. If a paragraph has only an anchor tag and caret is at the end
                    // of this anchor tag then typing any chracter removes the whole tag...
                    if (range.startContainer
                        && range.startContainer === range.endContainer
                        && range.startOffset === 0
                        && range.endOffset === range.startOffset
                        && ViperUtil.isBlockElement(range.startContainer) === true
                        && ViperUtil.isTag(range.startContainer.firstChild, 'a') === true
                    ) {
                        var newTextNode = document.createTextNode('');
                        ViperUtil.insertAfter(range.startContainer.firstChild, newTextNode);
                        range.setStart(newTextNode, 0);
                        range.collapse(true);
                        ViperSelection.addRange(range);
                    }
                }

                var self = this;
                setTimeout(function() {
                    self._viper.fireSelectionChanged(null, true);
                }, 10);

                return true;
            }//end if
        } else if ((e.which === 65 && (e.metaKey === true || e.ctrlKey === true))
            || ((e.which >= 37 && e.which <= 40) && (e.metaKey === true || e.ctrlKey === true) && e.shiftKey === true)
        ) {
            // CMD/CTRL + A, CMD + SHIF + <arrow keys> needs to fire selection changed as they do not fire key up event.
            var self = this;
            setTimeout(function() {
                self._viper.fireSelectionChanged();
            }, 10);
            return true;
        }//end if

    },

    _firefoxKeyDown: function(e)
    {
        if (e.which >= 37 && e.which <= 40) {
            // Handle the case where selecting whole content and pressing right arrow key puts the caret outside of the
            // last selected element. E.g. <p>test</p>*.
            var range = this._viper.getCurrentRange();
            if (e.which >= 39
                && range.startContainer === range.endContainer
                && range.startOffset === 0
                && range.endOffset >= range.startContainer.childNodes.length
            ) {
                var lastSelectable = range._getLastSelectableChild(range.startContainer.childNodes[range.endOffset - 1]);
                if (lastSelectable && lastSelectable.nodeType === ViperUtil.TEXT_NODE) {
                    range.setStart(lastSelectable, lastSelectable.data.length);
                    range.collapse(true);
                    ViperSelection.addRange(range);
                }
            }

            // Arrow keys.
            return;
        }

        var range = this._viper.getCurrentRange();
        var elem  = this._viper.getViperElement();
        if (elem.childNodes.length === 0
            || (elem.childNodes.length === 1 && ViperUtil.isTag(elem.childNodes[0], 'br') === true)
            || (elem === range.startContainer && elem === range.endContainer && range.startOffset === 0 && range.endOffset >= range.endContainer.childNodes.length)
        ) {
            var tagName = this._viper.getDefaultBlockTag();
            if (elem.childNodes.length === 1 && ViperUtil.isBlockElement(elem.childNodes[0]) === true) {
                tagName = ViperUtil.getTagName(elem.childNodes[0]);
            }

            var textNode = document.createTextNode('');
            if (!tagName) {
                ViperUtil.setHtml(this._viper.element, '');
                this._viper.element.appendChild(textNode);
            } else {
                ViperUtil.setHtml(this._viper.element, '<' + tagName + '></' + tagName + '>');
                this._viper.element.firstChild.appendChild(textNode);
            }

            range.setStart(textNode, 0);
            range.collapse(true);
            ViperSelection.addRange(range);
        } else {
            var startNode = range.getStartNode();
            var endNode   = range.getEndNode();
            if (startNode
                && startNode === endNode
                && startNode.nodeType === ViperUtil.ELEMENT_NODE
                && startNode.parentNode === this._viper.element
                && range.startOffset === 0
            ) {
                var firstChild = range._getFirstSelectableChild(startNode);
                if (firstChild) {
                    range.setStart(firstChild, 0);
                    range.collapse(true);
                    ViperSelection.addRange(range);
                }
            }
        }


        // When element is empty Firefox puts <br _moz_dirty="" type="_moz">
        // in to the element which stops text typing, so remove the br tag
        // and add an empty text node and set the range to that node.
        if (range.startContainer === range.endContainer
            && ViperUtil.isTag(range.startContainer, 'br') === true) {
            var textNode = document.createTextNode('');
            ViperUtil.insertAfter(range.startContainer, textNode);
            ViperUtil.remove(range.startContainer);
            range.setStart(textNode, 0);
            range.collapse(true);
            ViperSelection.addRange(range);
        }

    }

};
