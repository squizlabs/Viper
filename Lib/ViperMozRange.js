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

function ViperMozRange(rangeObj)
{
    ViperUtil.inherits('ViperMozRange', 'ViperDOMRange');
    ViperDOMRange.call(this, rangeObj);

    this.startContainer          = rangeObj.startContainer;
    this.startOffset             = rangeObj.startOffset;
    this.endContainer            = rangeObj.endContainer;
    this.endOffset               = rangeObj.endOffset;
    this.collapsed               = rangeObj.collapsed;
    this.commonAncestorContainer = rangeObj.commonAncestorContainer;

    this.posSpan = Viper.document.createElement('span');

    /*
     * Compares the start of a range with the start of another range.
     *
     * @type Integer
     * @see compareBoundaryPoints()
     */
    ViperDOMRange.START_TO_START = Range.START_TO_START;

    /*
     * Compares the start of a range with the end of another range.
     *
     * @type Integer
     * @see compareBoundaryPoints()
     */
    ViperDOMRange.START_TO_END = Range.END_TO_START;

    /*
     * Compares the end of a range with the end of another range.
     *
     * @type Integer
     * @see compareBoundaryPoints()
     */
    ViperDOMRange.END_TO_END = Range.END_TO_END;

    /*
     * Compares the end of a range with the start of another range.
     *
     * @type Integer
     * @see compareBoundaryPoints()
     */
    ViperDOMRange.END_TO_START = Range.START_TO_END;

}

ViperMozRange.prototype = {

    /**
     * Moves the start point of the range to the offset within the specified node.
     *
     * @param Node    node   The node where the range should start.
     * @param Integer offset The offset within the node where the range should start.
     *
     * @return void
     * @throws RangeException, DomException
     */
    setStart: function(node, offset)
    {
        this.rangeObj.setStart(node, offset);

        this.startContainer = node;
        this.startOffset    = offset;

        if (this.endContainer === null) {
            this.endContainer = node;
            this.endOffset    = offset;
        }

        this._setCommonAncestorContainer();
        this._setCollapsed();

    },

    /**
     * Moves the end point of the range to the offset within the specified node.
     *
     * @param Node    node   The node where the range should end.
     * @param Integer offset The offset within the node where the range should end.
     *
     * @return void
     * @throws RangeException, DomException
     */
    setEnd: function(node, offset)
    {
        this.rangeObj.setEnd(node, offset);
        this.endContainer = node;
        this.endOffset    = offset;

        if (this.startContainer === null) {
            this.startContainer = node;
            this.startOffset    = offset;
        }

        this._setCommonAncestorContainer();
        this._setCollapsed();

    },

    /**
     * Moves the start point of the range to before the specified node.
     *
     * @param Node node The node where the range should start before.
     *
     * @return void
     * @throws RangeException, DomException
     */
    setStartBefore: function(node)
    {
        this.rangeObj.setStartBefore(node);
        this.endContainer   = this.rangeObj.endContainer;
        this.endOffset      = this.rangeObj.endOffset;
        this.startContainer = this.rangeObj.startContainer;
        this.startOffset    = this.rangeObj.startOffset;

        this._setCollapsed();
        this._setCommonAncestorContainer();

    },

    /**
     * Moves the start point of the range to after the specified node.
     *
     * @param Node node The node where the range should start after.
     *
     * @return void
     * @throws RangeException, DomException
     */
    setStartAfter: function(node)
    {
        this.rangeObj.setStartAfter(node);
        this.endContainer   = this.rangeObj.endContainer;
        this.endOffset      = this.rangeObj.endOffset;
        this.startContainer = this.rangeObj.startContainer;
        this.startOffset    = this.rangeObj.startOffset;

        this._setCollapsed();
        this._setCommonAncestorContainer();

    },

    /**
     * Moves the end point of the range to before the specified node.
     *
     * @param Node node The node where the range should end before.
     *
     * @return void
     * @throws RangeException, DomException
     */
    setEndBefore: function(node)
    {
        this.rangeObj.setEndBefore(node);
        this.endContainer   = this.rangeObj.endContainer;
        this.endOffset      = this.rangeObj.endOffset;
        this.startContainer = this.rangeObj.startContainer;
        this.startOffset    = this.rangeObj.startOffset;

        this._setCollapsed();
        this._setCommonAncestorContainer();

    },

    /**
     * Moves the end point of the range to after the specified node.
     *
     * @param Node node The node where the range should end after.
     *
     * @return void
     * @throws RangeException, DomException
     */
    setEndAfter: function(node)
    {
        this.rangeObj.setEndAfter(node);
        this.endContainer   = this.rangeObj.endContainer;
        this.endOffset      = this.rangeObj.endOffset;
        this.startContainer = this.rangeObj.startContainer;
        this.startOffset    = this.rangeObj.startOffset;

        this._setCollapsed();
        this._setCommonAncestorContainer();

    },

    /**
     * Selects the node, including its element.
     *
     * @param Node node The node to be selected.
     *
     * @return void
     * @throws RangeException, DomException
     */
    selectNode: function(node)
    {
        this.rangeObj.selectNode(node);

        this.startContainer = this.rangeObj.startContainer;
        this.startOffset    = this.rangeObj.startOffset;
        this.endContainer   = this.rangeObj.endContainer;
        this.endOffset      = this.rangeObj.endOffset;

        this._setCollapsed();
        this._setCommonAncestorContainer();

    },

    /**
     * Selects the node, excluding its element.
     *
     * @param Node node The node who's contents should be selected.
     *
     * @return void
     * @throws RangeException, DomException
     */
    selectNodeContents: function(node)
    {
        this.rangeObj.selectNodeContents(node);
        this.startContainer = this.rangeObj.startContainer;
        this.startOffset    = this.rangeObj.startOffset;
        this.endContainer   = this.rangeObj.endContainer;
        this.endOffset      = this.rangeObj.endOffset;

        this._setCollapsed();
        this._setCommonAncestorContainer();

    },

    /**
     *
     * @param Node node The node who's contents should be selected.
     *
     * @return void
     * @throws RangeException, DomException
     */
    surroundContents: function(node)
    {
        this.rangeObj.surroundContents(node);

        this.startContainer = this.rangeObj.startContainer;
        this.startOffset    = this.rangeObj.startOffset;
        this.endContainer   = this.rangeObj.endContainer;
        this.endOffset      = this.rangeObj.endtOffset;

        this._setCollapsed();
        this._setCommonAncestorContainer();

    },

    /**
     * Collapses the range to the start or end of the current boundary points.
     *
     * @param boolean toStart If TRUE the range will be collapsed the the start of
     *                        the range, otherwise it will be collapsed to the end
     *                        of the range.
     *
     * @return void
     * @throws DOMException
     */
    collapse: function(toStart)
    {
        this.rangeObj.collapse(toStart);
        this.collapsed = true;

        if (toStart) {
            this.endContainer = this.startContainer;
            this.endOffset    = this.startOffset;
        } else {
            this.startContainer = this.endContainer;
            this.startOffset    = this.endOffset;
        }

    },

    // Range Comparisons.
    /**
     * Compare the boundary-points of two Ranges in a document and returns
     * -1, 0 or 1 depending on whether the corresponding boundary-point of the
     * Range is respectively before, equal to, or after the corresponding
     * boundary-point of sourceRange.
     *
     * @param integer  how         A flag as to how to compare the boundary points
     *                             of the range, which should be one of
     *                             START_TO_START, END_TO_END, START_TO_END and
     *                             END_TO_START.
     * @param ViperMozRange sourceRange The source range to compare to this range.
     *
     * @return integer
     * @see W3CRange.START_TO_START
     * @see W3CRange.START_TO_END
     * @see W3CRange.END_TO_END
     * @see W3CRange.END_TO_START
     * @throws DOMException
     */
    compareBoundaryPoints: function(how, sourceRange)
    {
        return this.rangeObj.compareBoundaryPoints(how, sourceRange.rangeObj);

    },

    // Extract Content.
    /**
     * Deletes the contents within the current range.
     *
     * @return void
     * @throws DOMException
     */
    deleteContents: function()
    {
        var startContainer = this.startContainer;
        var startOffset    = this.startOffset;

        if (!startContainer) {
            startContainer = this.rangeObj.startContainer;
        }

        this.rangeObj.deleteContents();

        // Because we rely on normalisation when we get call getRangeCoords()
        // we have to explicitly set the start container and offset, as using
        // then from the rangeObj will reference an element and childNode offset.
        // Normalise.
        var nextSibling = startContainer.nextSibling;
        while (nextSibling) {
            if (nextSibling && nextSibling.nodeType === ViperUtil.TEXT_NODE) {
                startContainer.data += nextSibling.data;
                ViperUtil.remove(nextSibling);
                nextSibling = startContainer.nextSibling;
            } else {
                break;
            }
        }

        this.setStart(startContainer, startOffset);
        this.collapse(true);

        this._setCommonAncestorContainer();

    },

    /**
     * Extracts the contents from the current document, returning the contents in
     * a document fragment.
     *
     * @return DocumentFragment
     * @throws DOMException
     */
    extractContents: function()
    {
        return this.rangeObj.extractContents();

    },

    createDocumentFragment: function(str)
    {
        var fragment = null;
        if (!this.rangeObj.createContextualFragment) {
            var fragment  = document.createDocumentFragment();
            var div       = document.createElement('div');
            div.innerHTML = str;

            // Add the children of the div to fragment.
            var c = div.childNodes.length;
            for (var i = 0; i < c; i++) {
                var child = div.childNodes[i].cloneNode(true);
                fragment.appendChild(child);
            }
        } else {
            fragment = this.rangeObj.createContextualFragment(str);
        }

        return fragment;

    },

    /**
     * Clones the contents of the range, returning the content in a DocumentFragment
     * without modifying the current Viper.document.
     *
     * @return DocumentFragment.
     * @throws DOMException
     */
    cloneContents: function()
    {
        return this.rangeObj.cloneContents();

    },

    // Inserting.
    /**
     * Inserts a node into the Document or DocumentFragment at the start of the Range.
     * If the container is a Text node, this will be split at the start of the Range
     * (as if the Text node's splitText method was performed at the insertion point)
     * and the insertion will occur between the two resulting Text nodes. Adjacent Text
     * nodes will not be automatically merged. If the node to be inserted is a
     * DocumentFragment node, the children will be inserted rather than the
     * DocumentFragment node itself.
     *
     * @param Node node The node to be inserted.
     *
     * @return void
     * @throws DOMException, RangeException
     */
    insertNode: function(node)
    {
        if (this.startContainer.nodeType === ViperUtil.ELEMENT_NODE) {
            if (ViperUtil.isStubElement(this.startContainer) === true) {
                // HIERARCHY_REQUEST_ERR: Raised if the container of the start
                // of the Range is of a type that does not allow children of the
                // type of node.
                throw Error('HIERARCHY_REQUEST_ERR');
            }
        }

        this.rangeObj.insertNode(node);

        if (node.previousSibling && node.previousSibling.nodeType === ViperUtil.TEXT_NODE) {
            if (node.previousSibling.data === '') {
                ViperUtil.remove(node.previousSibling);
            }
        }

        if (node.nextSibling && node.nextSibling.nodeType === ViperUtil.TEXT_NODE) {
            if (node.nextSibling.data === '') {
                ViperUtil.remove(node.nextSibling);
            }
        }

        this.startContainer = this.rangeObj.startContaier;
        this.startOffset    = this.rangeObj.startOffset;
        this.endContainer   = this.rangeObj.endContainer;
        this.endOffset      = this.rangeObj.endOffset;

        this._setCollapsed();
        this._setCommonAncestorContainer();

    },

    // Misc.
    /**
     * Clones this range object and returns an exact copy.
     *
     * @return W3CRange.
     */
    cloneRange: function()
    {
        var clone = this.rangeObj.cloneRange();
        return new ViperMozRange(clone);

    },

    /**
     * Returns the string contents of the selected text within the range. The contents
     * will not contain any markup.
     *
     * @return string
     */
    toString: function()
    {
        return this.rangeObj.toString();

    },

    /**
     * Detaches the range from the document releasing any resources used.
     *
     * @return void
     * @throws DOMException
     */
    detach: function()
    {
        this.rangeObj.detach();

    },

    comparePoint: function(node, offset)
    {
        return this.rangeObj.comparePoint(node, offset);

    },


    // Private helper methods for W3CRange Standard.
    _setCommonAncestorContainer: function()
    {
        this.commonAncestorContainer = this.rangeObj.commonAncestorContainer;

    },

    _setCollapsed: function()
    {
        if (this.startContainer === this.endContainer
            && this.startOffset === this.endOffset
        ) {
            this.collapsed = true;
        } else {
            this.collapsed = false;
        }

    },

    // Extensions to the W3CRange standard.
    getCommonElement: function()
    {
        if (this.commonAncestorContainer.nodeType === ViperUtil.ELEMENT_NODE) {
            return this.commonAncestorContainer;
        }

        return this.commonAncestorContainer.parentNode;

    },

    /**
     * Returns the range coordinates (x, y) where the range begins or ends.
     *
     * @param boolean toStart If TRUE the coordinates of the start of the range will
     *                        be returned, else the end range coordinates will be
     *                        returned.
     *
     * @return Object {x, y}
     */
    getRangeCoords: function(toStart)
    {
        var clone = this.rangeObj.cloneRange();
        clone.collapse(toStart);

        var normalize = true;
        if (clone.startContainer.nodeType === ViperUtil.TEXT_NODE) {
            if (clone.startOffset === 0) {
                if (clone.startContainer.previousSibling && clone.startContainer.previousSibling.nodeType !== ViperUtil.TEXT_NODE) {
                    normalize = false;
                }
            }
        } else {
            normalize = false;
        }

        var posSpan = this.posSpan;
        clone.insertNode(posSpan);

        var previous = posSpan.previousSibling;
        var next     = posSpan.nextSibling;
        var c        = ViperUtil.$(posSpan).position();
        var coords   = {
            x: c.left,
            y: c.top
        };

        // We're done with the posSpan.
        ViperUtil.remove(posSpan);

        // We need to restore the text back to the way it was.
        if (normalize) {
            previous.data += next.data;
            ViperUtil.remove(next);

            this.setEnd(this.endContainer, this.endOffset);
            this.setStart(this.startContainer, this.startOffset);
        }

        return coords;

    },

    moveStart: function(unitType, units)
    {
        if (units === 0) {
            throw Error('InvalidArgumentException: units cannot be 0');
        }

        switch (unitType) {
            case ViperDOMRange.CHARACTER_UNIT:
                if (units > 0) {
                    this._moveCharRight(true, units);
                } else {
                    this._moveCharLeft(true, units);
                }
            break;

            case ViperDOMRange.LINE_UNIT:
                if (units > 0) {
                    this._moveLineDown(true);
                } else {
                    this._moveLineUp(true);
                }
            break;

            case ViperDOMRange.WORD_UNIT:
            default:
                // Do nothing.
            break;
        }//end switch

        this._setCommonAncestorContainer();
        this._setCollapsed();

    },

    moveEnd: function(unitType, units)
    {
        if (units === 0) {
            throw Error('InvalidArgumentException: units cannot be 0');
        }

        switch (unitType) {
            case ViperDOMRange.CHARACTER_UNIT:
                if (units > 0) {
                    this._moveCharRight(false, units);
                } else {
                    this._moveCharLeft(false, units);
                }
            break;

            case ViperDOMRange.LINE_UNIT:
                if (units > 0) {
                    this._moveLineDown(false);
                } else {
                    this._moveLineUp(false);
                }
            break;

            case ViperDOMRange.WORD_UNIT:
            default:
                // Do nothing.
            break;
        }//end switch

        this._setCommonAncestorContainer();
        this._setCollapsed();

    },

    _setRange: function(start, container, offset)
    {
        if (start) {
            this.setStart(container, offset);
        } else {
            this.setEnd(container, offset);
        }

    },

    _moveCharLeft: function(moveStart, units)
    {
        var container, offset;

        if (moveStart) {
            container = this.startContainer;
            offset    = this.startOffset;
        } else {
            container = this.endContainer;
            offset    = this.endOffset;
        }

        offset += units;

        if (container.nodeType === ViperUtil.ELEMENT_NODE) {
            if (container.hasChildNodes()) {
                // If the start or end container is an element then we are referencing
                // a node within the element. So we want to force the selection of
                // the last char in the previous container, so set offset to 0.
                container = container.childNodes[offset];
                offset    = 0;
            }
        }

        if (offset < 0) {
            // We need to move to a previous selectable container.
            while (offset < 0) {
                var skippedBlockElem = [];
                container = this.getPreviousContainer(container, skippedBlockElem);
                if (container.nodeType === ViperUtil.ELEMENT_NODE) {
                    continue;
                }

                offset = container.data.length;

                // If the new container is inside a non-block element then we
                // need to position the caret before the last character.
                // E.g. <strong>Tes|t</strong>*ing, where * is the original pos
                // and | is after moving to left. This is not the case for block
                // elements (e.g. P tag), caret needs to be positioned after the
                // last char.
                if (container.nodeType === ViperUtil.TEXT_NODE
                    && skippedBlockElem.length === 0
                ) {
                    offset--;
                }
            }//end while
        }//end if

        this._setRange(moveStart, container, offset);

    },

    /**
     * If incSpaces is false then any space at the beginning of a line will
     * be ignored.
     */
    getStartOffset: function(incSpaces)
    {
        if (incSpaces === true) {
            return this.startOffset;
        }

        var spaces    = 0;
        var container = this.startContainer;
        var cc        = container.data.charCodeAt(0);
        while (cc === 10 || cc === 32) {
            spaces++;
            cc = container.data.charCodeAt(spaces);
        }

        var offset = (this.startOffset - spaces);

        return offset;

    },

    _getNextTextNode: function(container)
    {
        if (container.nodeType === ViperUtil.ELEMENT_NODE) {
            if (container.childNodes.length !== 0) {
                return this._getFirstSelectableChild(container);
            }
        }

        container = this.getNextContainer(container);
        if (container.nodeType === ViperUtil.TEXT_NODE) {
            return container;
        }

        return this._getNextTextNode(container);

    },

    _moveCharRight: function(moveStart, units)
    {
        var container, offset;

        if (moveStart) {
            container = this.startContainer;
            offset    = this.startOffset;
        } else {
            container = this.endContainer;
            offset    = this.endOffset;
        }

        if (container.nodeType === ViperUtil.ELEMENT_NODE) {
            container = container.childNodes[offset];
            if (container.nodeType !== ViperUtil.TEXT_NODE) {
                container = this._getNextTextNode(container);
            }

            offset = units;
        } else {
            offset += units;
        }

        var diff = (offset - container.data.length);
        if (diff > 0) {
            var skippedBlockElem = [];
            // We need to move to the next selectable container.
            while (diff > 0) {
                container = this.getNextContainer(container, skippedBlockElem);
                if (container.nodeType === ViperUtil.ELEMENT_NODE) {
                    continue;
                }

                if (container.data.length >= diff) {
                    // We found a container with enough content to select.
                    break;
                } else if (container.data.length > 0) {
                    // Container does not have enough content,
                    // find the next one.
                    diff -= container.data.length;
                }
            }

            offset = 0;

            // If the new container is inside a non-block element then we
            // need to position the caret before the last character.
            // E.g. <strong>Tes|t</strong>*ing, where * is the original pos
            // and | is after moving to left. This is not the case for block
            // elements (e.g. P tag), caret needs to be positioned after the
            // last char.
            if (container.nodeType === ViperUtil.TEXT_NODE
                && skippedBlockElem.length === 0
            ) {
                offset++;
            }
        }//end if

        this._setRange(moveStart, container, offset);

    },

    _filterWords: function(words)
    {
        var wc     = words.length;
        var fwords = [];
        for (var i = 0; i < wc; i++) {
            if (words[i].length > 0) {
                fwords.push(words[i]);
            }
        }

        return fwords;

    },

    _moveLineUp: function(moveStart)
    {
        var container = null;
        var offset    = null;
        if (moveStart) {
            container = this.startContainer;
            offset    = this.startOffset;
        } else {
            container = this.endContainer;
            offset    = this.endOffset;
        }

        if (container.nodeType === ViperUtil.ELEMENT_NODE) {
            container = this.getPreviousContainer(container);
        }

        var words       = container.data.substr(offset).split(/\s+/);
        var startCoords = this.getRangeCoords(moveStart);
        var coords      = null;
        var prevXCoord  = 0;
        var nextLine    = 0;
        var wordLen     = 0;
        var prevYCoord  = 0;
        var prevCont    = null;
        var prevOffset  = 0;

        while (true) {
            prevOffset = offset;
            prevCont   = container;
            if (nextLine === 0 && words.length > 0) {
                // Before we hit the next line we can jump to the end of
                // each word instead of going char by char.
                offset -= words.pop().length;
            } else {
                offset--;
            }

            if (offset <= 0) {
                // We will need to look at the previous container.
                var found = false;
                // Found the next non empty container.
                while (found === false) {
                    container = this.getPreviousContainer(container);
                    if (container !== null && container.nodeType === ViperUtil.TEXT_NODE && container.data.length !== 0) {
                        found = true;
                    }
                }

                offset = container.data.length;
            }

            if (moveStart) {
                this.setStart(container, offset);
            } else {
                this.setEnd(container, offset);
            }

            coords = this.getRangeCoords(moveStart);

            if (startCoords.y !== coords.y) {
                if (prevYCoord !== coords.y) {
                    prevYCoord = coords.y;
                    nextLine++;
                    if (nextLine > 1) {
                        if (prevCont !== container) {
                            // If previous container is different then move
                            // to the end of it.
                            prevOffset = prevCont.data.length;
                        }

                        // Go back to the last offset.
                        if (moveStart) {
                            this.setStart(prevCont, prevOffset);
                        } else {
                            this.setEnd(prevCont, prevOffset);
                        }

                        break;
                    }
                }

                if (coords.x <= startCoords.x) {
                    // Found the position now do a little adjustment if required.
                    if (offset < container.data.length && Math.abs(coords.x - startCoords.x) > Math.abs(prevXCoord - startCoords.x)) {
                        // Go back one offset.
                        offset++;
                        if (moveStart) {
                            this.setStart(container, offset);
                        } else {
                            this.setEnd(container, offset);
                        }
                    }

                    break;
                } else {
                    prevXCoord = coords.x;
                }
            }//end if
        }//end while

    },

    _moveLineDown: function(moveStart)
    {
        var container = null;
        var offset    = null;
        if (moveStart) {
            container = this.startContainer;
            offset    = this.startOffset;
        } else {
            container = this.endContainer;
            offset    = this.endOffset;
        }

        if (container.nodeType === ViperUtil.ELEMENT_NODE) {
            container = this.getNextContainer(container);
        }

        var words       = container.data.substr(offset).split(/\s+/);
        var startCoords = this.getRangeCoords(moveStart);
        var coords      = null;
        var prevXCoord  = 0;
        var nextLine    = 0;
        var wordLen     = 0;
        var prevYCoord  = 0;
        var prevCont    = null;
        var prevOffset  = 0;
        while (true) {
            prevOffset = offset;
            prevCont   = container;
            if (nextLine === 0 && words.length > 0) {
                // Before we hit the next line we can jump to the end of
                // each word instead of going char by char.
                offset += words.shift().length;
            } else {
                offset++;
            }

            if (offset >= container.data.length) {
                // We will need to look at the next container.
                var found = false;
                // Found the next non empty container.
                while (found === false) {
                    container = this.getNextContainer(container);
                    if (container.data.length !== 0) {
                        found = true;
                    }
                }

                offset = 0;
            }

            if (moveStart) {
                this.setStart(container, offset);
            } else {
                this.setEnd(container, offset);
            }

            coords = this.getRangeCoords(moveStart);

            if (startCoords.y !== coords.y) {
                if (prevYCoord !== coords.y) {
                    prevYCoord = coords.y;
                    nextLine++;
                    if (nextLine > 1) {
                        if (prevCont !== container) {
                            // If previous container is different then move
                            // to the end of it.
                            prevOffset = prevCont.data.length;
                        }

                        // Go back to the last offset.
                        if (moveStart) {
                            this.setStart(prevCont, prevOffset);
                        } else {
                            this.setEnd(prevCont, prevOffset);
                        }

                        break;
                    }
                }

                if (coords.x >= startCoords.x) {
                    // Found the position now do a little adjustment
                    // if required.
                    if (offset > 1 && Math.abs(coords.x - startCoords.x) > Math.abs(prevXCoord - startCoords.x)) {
                        // Go back one offset.
                        offset--;
                        if (moveStart) {
                            this.setStart(container, offset);
                        } else {
                            this.setEnd(container, offset);
                        }
                    }

                    break;
                } else {
                    prevXCoord = coords.x;
                }
            }//end if
        }//end while

    },

    getHTMLContents: function(clonedSelection)
    {
        if (!clonedSelection) {
            clonedSelection = this.rangeObj.cloneContents();
        }

        var div = Viper.document.createElement('div');
        div.appendChild(clonedSelection.cloneNode(true));
        return div.innerHTML;

    },

    getHTMLContentsObj: function()
    {
        return this.rangeObj.cloneContents();

    }
};
