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

function ViperIERange(rangeObj)
{
    ViperUtil.inherits('ViperIERange', 'ViperDOMRange');
    ViperDOMRange.call(this, rangeObj);

    this._initContainerInfo();
    this._setCollapsed();

  //  this.shy            = Viper.document.createElement('span');
  //  this.shy.innerHTML  = '&nbsp;';
    this._prevHeight    = null;
    this._prevContainer = null;

    /*
     * Compares the start of a range with the start of another range.
     *
     * @type Integer
     * @see compareBoundaryPoints()
     */
    ViperDOMRange.START_TO_START = 'StartToStart';

    /*
     * Compares the start of a range with the end of another range.
     *
     * @type Integer
     * @see compareBoundaryPoints()
     */
    ViperDOMRange.START_TO_END = 'StartToEnd';

    /*
     * Compares the end of a range with the end of another range.
     *
     * @type Integer
     * @see compareBoundaryPoints()
     */
    ViperDOMRange.END_TO_END = 'EndToEnd';

    /*
     * Compares the end of a range with the start of another range.
     *
     * @type Integer
     * @see compareBoundaryPoints()
     */
    ViperDOMRange.END_TO_START = 'EndToStart';

}

ViperIERange._prevRange = {
    range: null,
    startContainer: null,
    endContainer: null,
    startOffset: 0,
    endOffset: 0
};


ViperIERange.prototype = {


    /**
     * Sets up the startContainer, endContainer, startOffset and endOffset
     * properties.
     *
     * @return void
     */
    _initContainerInfo: function()
    {
        var clone  = this.rangeObj.duplicate();

        if (ViperIERange._prevRange.range !== null) {
            if (clone.isEqual(ViperIERange._prevRange.range) === true) {
                this.startContainer = ViperIERange._prevRange.startContainer;
                this.endContainer   = ViperIERange._prevRange.endContainer;
                this.startOffset    = ViperIERange._prevRange.startOffset;
                this.endOffset      = ViperIERange._prevRange.endOffset;
                return;
            }
        }

        ViperIERange._prevRange.range = clone;

        var eclone = this.rangeObj.duplicate();

        clone.collapse(true);

        var info = this._getContainerInfo(clone);

        this.startContainer = info.container;
        this.startOffset    = info.offset;

        if (eclone.text.length > 0
            && eclone.htmlText.charAt(0) === '<'
            && eclone.htmlText.charAt(eclone.htmlText.length - 1) === '>'
        ) {
            var startParentElement = clone.parentElement();
            if (startParentElement !== eclone.parentElement() || ViperUtil.isBlockElement(startParentElement) === true) {
                var pElemB = eclone.parentElement();
                eclone.moveEnd('character', -1);
                var pElemA = eclone.parentElement();
                if (ViperUtil.isBlockElement(pElemB) === true
                    && ViperUtil.isBlockElement(pElemA) === false
                    && !pElemA.nextSibling
                ) {
                    // eclone.moveEnd('character', -1);
                } else {
                    eclone.moveEnd('character', 1);
                }
            }
        }

        eclone.collapse(false);

        if (eclone.isEqual(clone) !== true) {
            var einfo = this._getContainerInfo(eclone);
            this.endContainer = einfo.container;
            this.endOffset    = einfo.offset;
        } else {
            this.endContainer = info.container;
            this.endOffset    = info.offset;
        }

        ViperIERange._prevRange.startContainer = this.startContainer;
        ViperIERange._prevRange.endContainer   = this.endContainer;
        ViperIERange._prevRange.startOffset    = this.startOffset;
        ViperIERange._prevRange.endOffset      = this.endOffset;

    },

    // Range Select Modifiers.
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
        if (document.activeElement && ViperUtil.isTag(document.activeElement, 'input')) {
            document.activeElement.blur();
        }

        var moveTo = node;
        if (moveTo.nodeType === ViperUtil.TEXT_NODE) {
            moveTo = moveTo.parentNode;
        }

        var clone = this.rangeObj.duplicate();

        clone.moveToElementText(moveTo);
        clone.collapse(true);
        var charOffset = this._getCharOffsetWithinParent(node, offset);
        clone.move(ViperDOMRange.CHARACTER_UNIT, charOffset);

        this.rangeObj.setEndPoint('StartToStart', clone);

        this.startContainer = node;
        this.startOffset    = offset;
        if (this.endContainer === null && this.endOffset === null) {
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
        if (document.activeElement && ViperUtil.isTag(document.activeElement, 'input')) {
            document.activeElement.blur();
        }

        var moveTo = node;
        if (moveTo.nodeType === ViperUtil.TEXT_NODE) {
            moveTo = moveTo.parentNode;
        }

        var clone = this.rangeObj.duplicate();
        clone.moveToElementText(moveTo);
        clone.collapse(true);

        var charOffset = this._getCharOffsetWithinParent(node, offset);
        clone.move(ViperDOMRange.CHARACTER_UNIT, charOffset);

        this.rangeObj.setEndPoint('EndToEnd', clone);

        this.endContainer = node;
        this.endOffset    = offset;

        if (this.startContainer === null && this.startOffset === null) {
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
        // Looks like Firefox setStartBefore() method sets the range to
        // the specified node and offset to 0. I can't see how this is
        // different from setStart(node, 0)...
        this.setStart(node, 0);

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
        var next = this.getNextContainer(node);
        this.setStart(next, 0);
        /*if (next.nodeType != ViperUtil.ELEMENT_NODE) {
            next = next.parentNode;
        }

        var clone = this.rangeObj.duplicate();
        clone.moveToElementText(next);
        clone.collapse(true);
        this.rangeObj.moveEndPoint('StartToStart', clone);
*/
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
        var previous = this.getPreviousContainer(node);
        if (previous.nodeType === ViperUtil.TEXT_NODE) {
            this.setEnd(previous, previous.length);
        } else {
            var clone = this.rangeObj.duplicate();
            clone.moveToElementText(previous);
            clone.collapse(false);
            this.rangeObj.setEndPoint('EndToEnd', clone);

            this._setCollapsed();
            this._setCommonAncestorContainer();
        }

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
        this.setEnd(node.parentNode, this.getNodeIndex(node) + 1);

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
        if (node.nodeType === ViperUtil.TEXT_NODE) {
            this.setStart(node, 0);
            this.setEnd(node, node.length);
        } else {
            // Seems like moveToElementText does not select the node
            // if the node is empty.
            // So if it is empty then insert a single space.
            if (node.innerHTML && node.innerHTML.length === 0) {
                node.innerText = ' ';
            }

            this.rangeObj.moveToElementText(node);

            this.endContainer   = node.parentNode;
            this.startContainer = node.parentNode;

            this.startOffset = this._findElementNodeOffset(node);
            this.endOffset   = this.startOffset + 1;

            this._setCollapsed();
            this._setCommonAncestorContainer();
        }//end if

    },

    _findElementNodeOffset: function(node)
    {
        if (node.nodeType !== ViperUtil.ELEMENT_NODE) {
            return;
        }

        var parent = node.parentNode;
        var l      = parent.childNodes.length;
        for (var i = 0; i < l; i++) {
            if (parent.childNodes[i] === node) {
                return i;
            }
        }

        return -1;

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
        if (node.nodeType === ViperUtil.TEXT_NODE) {
            this.setStart(node, 0);
            this.setEnd(node, node.length);
        } else {
            this.rangeObj.moveToElementText(node);
            this.rangeObj.moveStart('character', 1);
            this.rangeObj.moveStart('character', -1);
            this.rangeObj.moveEnd('character', -1);
            this.rangeObj.moveEnd('character', 1);
        }

    },

    /**
     * Selects the node, excluding its element.
     *
     * @param Node node The node who's contents should be selected.
     *
     * @return void
     * @throws RangeException, DomException
     */
    surroundContents: function(node)
    {
        var contents = this.extractContents();
        node.appendChild(contents);
        this.insertNode(node);

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
     * @param DomRange sourceRange The source range to compare to this range.
     *
     * @return integer
     * @see ViperDOMRange.START_TO_START
     * @see ViperDOMRange.START_TO_END
     * @see ViperDOMRange.END_TO_END
     * @see ViperDOMRange.END_TO_START
     * @thows DOMException
     */
    compareBoundaryPoints: function(how, sourceRange)
    {
        return this.rangeObj.compareEndPoints(how, sourceRange.rangeObj);

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
        if (this.startContainer === this.endContainer
            && this.startContainer.nodeType === ViperUtil.TEXT_NODE
        ) {
            // Do not use execCommand in this case. Because if the node is at the end
            // of a paragraph then the execCommand will join the next paragraph to
            // the current one..
            var before = this.startContainer.data.substring(0, this.startOffset);
            var after  = this.startContainer.data.substring(this.endOffset);
            this.startContainer.data = before + after;
            this.setStart(this.startContainer, this.startOffset);
            this.collapse(true);
        } else {
            this.rangeObj.execCommand('Delete');
            this._initContainerInfo();
        }

    },

    comparePoint: function(node, offset)
    {
        var clone = this.cloneRange();
        clone.setStart(node, offset);
        clone.collapse();

        return this.rangeObj.compareEndPoints('StartToStart', clone.rangeObj);

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
        var fragment = Viper.document.createDocumentFragment();
        var div      = Viper.document.createElement('div');
        ViperUtil.setHtml(div, this.rangeObj.htmlText);
        // Add the children of the div to fragment.
        var c = div.childNodes.length;
        for (var i = 0; i < c; i++) {
            var child = div.childNodes[i].cloneNode(true);
            fragment.appendChild(child);
        }

        // Remove the contents.
        this.rangeObj.text = '';

        return fragment;

    },

    createDocumentFragment: function(str)
    {
        var fragment  = Viper.document.createDocumentFragment();
        var div       = Viper.document.createElement('div');
        div.innerHTML = str;

        // Add the children of the div to fragment.
        var c = div.childNodes.length;
        for (var i = 0; i < c; i++) {
            var child = div.childNodes[i].cloneNode(true);
            fragment.appendChild(child);
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
        var fragment = this.createDocumentFragment(this.rangeObj.htmlText);
        return fragment;

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
        var before = null;
        if (this.startContainer.nodeType === ViperUtil.ELEMENT_NODE) {
            if (this.startContainer.childNodes.length === this.startOffset) {
                this.startContainer.appendChild(node);
            } else {
                this.startContainer.insertBefore(node, this.startContainer.childNodes[this.startOffset]);
                this.setStart(this.startContainer, this.startOffset + 1);
            }

            return;
        } else if (this.startContainer.nodeType === ViperUtil.TEXT_NODE) {
            if (this.startOffset === 0) {
                before = this.startContainer;
            } else {
                var length = this.startContainer.data.length;
                if (length > this.startOffset) {
                    before = this.startContainer.splitText(this.startOffset);
                } else if (this.startContainer.nextSibling) {
                    before = this.startContainer.nextSibling;
                } else {
                    // If there is no next sibling then should we insert it as
                    // the last child of the parent or find the next text container?
                    // before = this.getNextContainer(this.startContainer);.
                    this.startContainer.parentNode.appendChild(node);
                }
            }
        }//end if

        if (before !== null) {
            ViperUtil.insertBefore(before, node);
        }

        this.setStart(node, 0);
        this.collapse(true);
        this._setCommonAncestorContainer();

    },

    // Misc.
    /**
     * Clones this range object and returns an exact copy.
     *
     * @return ViperDOMRange.
     */
    cloneRange: function()
    {
        var range = new ViperIERange(this.rangeObj.duplicate());
        range.startContainer          = this.startContainer;
        range.startOffset             = this.startOffset;
        range.endContainer            = this.endContainer;
        range.endOffset               = this.endOffset;
        range.commonAncestorContainer = this.commonAncestorContainer;
        range.collapsed               = this.collapsed;

        return range;

    },

    /**
     * Detaches the range from the document releasing any resources used.
     *
     * @return void
     * @throws DOMException
     */
    detach: function()
    {
        this.rangeObj = null;
        this.commonAncestorContainer = null;

    },

    getStartNode: function()
    {
        if (!this.startContainer) {
            return null;
        }

        if (this.startContainer.nodeType === ViperUtil.ELEMENT_NODE) {
            var node = this.startContainer.childNodes[this.startOffset];
            if (node) {
                return node;
            }
        }

        return this.startContainer;

    },

    /**
     * Sets the collapsed property on the range. This method should be called
     * when any modifications are made to the range.
     *
     * @return void
     */
    _setCollapsed: function()
    {
        if (this.startContainer === this.endContainer && this.startOffset === this.endOffset) {
            this.collapsed = true;
        } else {
            this.collapsed = false;
        }

    },

    /**
     * Sets the commonAncestorContainer property on the range. This method
     * should be called when any modifications are made to the range.
     *
     * @return void
     */
    _setCommonAncestorContainer: function()
    {
        if (this.startContainer === this.endContainer) {
            this.commonAncestorContainer = this.startContainer;
        } else {
            this.commonAncestorContainer = ViperUtil.getCommonAncestor(this.startContainer, this.endContainer);
        }

    },

    /**
     * From mozile.
     */
    _getContainerInfo: function(textRange)
    {
        var element = textRange.parentElement();
        var range   = element.ownerDocument.body.createTextRange();
        range.moveToElementText(element);
        try {
            range.setEndPoint("EndToStart", textRange);
        } catch (e) {
        }

        var rangeLength = range.text.length;
        var nodeLength  = 0;

        // Choose Direction.
        if (rangeLength < (element.innerText.length / 2)) {
            var direction = 1;
            var node      = element.firstChild;
        } else {
            direction = -1;
            node      = element.lastChild;
            range.moveToElementText(element);
            try {
                range.setEndPoint("StartToStart", textRange);
            } catch (e) {
            }

            rangeLength = range.text.length;
        }

        // Loop through child nodes.
        while (node) {
            switch (node.nodeType) {
                case ViperUtil.TEXT_NODE:
                    nodeLength = node.data.length;
                    if (nodeLength < rangeLength) {
                        var difference = (rangeLength - nodeLength);
                        if (direction === 1) {
                            range.moveStart("character", difference);
                        } else {
                            range.moveEnd("character", -difference);
                        }

                        rangeLength = difference;
                    } else {
                        if (direction === 1) {
                            return {
                                container: node,
                                offset: rangeLength
                            };
                        } else {
                            return {
                                container: node,
                                offset: (nodeLength - rangeLength)
                            };
                        }
                    }//end if
                break;

                case ViperUtil.ELEMENT_NODE:
                    if (ViperUtil.isStubElement(node) === true) {
                        // Note: |<BR>|
                        // Len:  1    2.
                        nodeLength = 2;
                    } else {
                        nodeLength = node.innerText.length;
                    }

                    if (direction === 1) {
                        range.moveStart("character", nodeLength);
                    } else {
                        range.moveEnd("character", -nodeLength);
                    }

                    rangeLength = (rangeLength - nodeLength);

                    // Note: rangeLength might go in to negative due to
                    // stub elements. If a there is "t</strong><br/>Test"
                    // then there will be another loop to get to the "Test"
                    // however, because BR.length = 2, then some times
                    // rangeLength becomes -2...
                    if (rangeLength < 0) {
                        rangeLength = 0;
                    }
                break;

                default:
                    // Not supported.
                break;
            }//end switch

            if (direction === 1) {
                node = node.nextSibling;
            } else {
                node = node.previousSibling;
            }
        }//end while

        // The TextRange was not found. Return a reasonable value instead.
        return {
            container: element,
            offset: 0
        };

    },

    getStartOffset: function(incSpaces)
    {
        return this.startOffset;

    },

    /**
     * Returns the char offset within the parent node that the offset is.
     * This method is to be used with move() when the unit is 'character', when
     * converting setStart and setEnd arguments.
     *
     * @param DOMNode node   The node to retrieve offset for.
     * @param integer offset The offset given for setStart/setEnd.
     *
     * @return integer
     */
    _getCharOffsetWithinParent: function(node, offset)
    {
        // NEW Version: 08-01-09 (Thanks to Mozile).
        var move    = null;
        var tmpNode = null;
        if (node.nodeType === ViperUtil.TEXT_NODE) {
            move    = offset;
            tmpNode = node.previousSibling;
        } else if (node.nodeType === ViperUtil.ELEMENT_NODE) {
            move = 0;
            if (offset > 0) {
                tmpNode = node.childNodes[(offset - 1)];
            } else {
                return 0;
            }
        }

        while (tmpNode) {
            var nodeLength = 0;
            if (tmpNode.nodeType === ViperUtil.ELEMENT_NODE) {
                nodeLength = tmpNode.innerText.length;
                if (ViperUtil.isStubElement(tmpNode) === true) {
                    nodeLength = 1;
                } else if (ViperUtil.isBlockElement(tmpNode) === true) {
                    nodeLength++;
                }
            } else if (tmpNode.nodeType === ViperUtil.TEXT_NODE) {
                nodeLength = tmpNode.data.length;
            }

            move   += nodeLength;
            tmpNode = tmpNode.previousSibling;
        }

        return move;

    },


    /**
     * Moves the start of the range using the specified unitType, by the specified
     * number of units. Defaults to ViperDOMRange.CHARACTER_UNIT and units of 1.
     *
     * @param string unitType The unitType to move, which should be one of
     *                        ViperDOMRange.CHARACTER_UNIT, ViperDOMRange.WORD_UNIT or ViperDOMRange.LINE_UNIT.
     * @param int units       The number of units to move. If positive the range will
     *                        be moved RIGHT for LTR languages, or LEFT or RTL languages.
     *
     * @return void
     */
    moveStart: function(unitType, units, updateInfo)
    {
        switch (unitType) {
            case ViperDOMRange.CHARACTER_UNIT:
            case ViperDOMRange.WORD_UNIT:
                this.rangeObj.moveStart(unitType, units);
                var text = this.rangeObj.text;

                // Remove char(13)char(10) (\r\n).
                var match = text.match(/\r\n/g, '');
                if (match !== null && match.length > 0) {
                    // Count all the new line characters.
                    var u = match.length;
                    if (units < 0) {
                        u = (u * -1);
                    }

                    this.rangeObj.moveStart(ViperDOMRange.CHARACTER_UNIT, u);
                }
            break;

            case ViperDOMRange.LINE_UNIT:
                this._moveLine(true, units);
            break;

            default:
                throw Error('InvalidArgumentException: unitType "' + unitType + '" not valid.');
            break;
        }//end switch

        if (updateInfo !== false) {
            this._initContainerInfo();
        }

    },

    /**
     * Moves the end of the range using the specified unitType, by the specified
     * number of units. Defaults to ViperDOMRange.CHARACTER_UNIT and units of 1.
     *
     * @param int unitType The unitType to move, which should be one of
     *                     ViperDOMRange.CHARACTER_UNIT, ViperDOMRange.WORD_UNIT or ViperDOMRange.LINE_UNIT.
     * @param int units    The number of units to move. If positive the range will
     *                     be moved RIGHT for LTR languages, or LEFT or RTL languages.
     *
     * @return void
     */
    moveEnd: function(unitType, units)
    {
        switch (unitType) {
            case ViperDOMRange.CHARACTER_UNIT:
            case ViperDOMRange.WORD_UNIT:
                this.rangeObj.moveEnd(unitType, units);
                var text = this.rangeObj.text;
                // Remove char(13)char(10) (\r\n).
                var match = text.match(/\r\n/g, '');
                if (match !== null && match.length > 0) {
                    // Count all the new line characters.
                    this.rangeObj.moveEnd(ViperDOMRange.CHARACTER_UNIT, match.length);
                }
            break;

            case ViperDOMRange.LINE_UNIT:
                this._moveLine(false, units);
            break;

            default:
                throw Error('InvalidArgumentException: unitType "' + unitType + '" not valid.');
            break;
        }//end switch

        this._initContainerInfo();

    },

    /**
     * Moves the start or end of a range up or down by one or more lines.
     *
     * @param boolean moveStart If TRUE the start of the range will be moved.
     * @param int     units     The number of units to move. Negative units will
     *                          move the range up, positive units will move
     *                          the range down.
     *
     * @return void
     */
    _moveLine: function(moveStart, units)
    {
        // Clone the range and work with cloned range.
        var clone = this.cloneRange();

        // Collapse the range.
        clone.collapse(moveStart);

        var startCoords = clone.getRangeCoords(moveStart);
        var coords      = null;
        var prevXCoord  = 0;
        var passed      = false;
        var unitType    = ViperDOMRange.WORD_UNIT;

        // Move 2 words at a time..
        units *= 2;

        if (units < 0) {
            // Move Up.
            while (true) {
                clone.moveStart(unitType, units);
                coords = clone.getRangeCoords(true);
                if (passed === false) {
                    if (coords.y < startCoords.y && coords.x <= startCoords.x) {
                        // We have found the next line and passed the start X
                        // position. Now move BACK char by char to determine
                        // a good position.
                        passed   = true;
                        units    = 1;
                        unitType = ViperDOMRange.CHARACTER_UNIT
                    }
                } else if (coords.x >= startCoords.x) {
                    // Found the corrext X position, make little adjustment
                    // if needed.
                    if (Math.abs(coords.x - startCoords.x) > Math.abs(startCoords.x - prevXCoord)) {
                        clone.moveStart(ViperDOMRange.CHARACTER_UNIT, -1);
                    }

                    break;
                } else {
                    // Update the previous X position to deterime the best
                    // spot later on.
                    prevXCoord = coords.x;
                }//end if
            }//end while
        } else {
            // Move Down.
            while (true) {
                clone.moveStart(unitType, units);
                coords = clone.getRangeCoords(true);
                if (passed === false) {
                    if (coords.y > startCoords.y && coords.x >= startCoords.x) {
                        // We have found the next line and passed the start X
                        // position. Now move BACK char by char to determine
                        // a good position.
                        passed   = true;
                        units    = -1;
                        unitType = ViperDOMRange.CHARACTER_UNIT
                    }
                } else if (coords.x <= startCoords.x) {
                    // Found the corrext X position, make little adjustment
                    // if needed.
                    if (Math.abs(coords.x - startCoords.x) > Math.abs(startCoords.x - prevXCoord)) {
                        clone.moveStart(ViperDOMRange.CHARACTER_UNIT, 1);
                    }

                    break;
                } else {
                    // Update the previous X position to deterime the best
                    // spot later on.
                    prevXCoord = coords.x;
                }//end if
            }//end while
        }//end if

        // Collapse to the start.
        clone.collapse(true);

        if (moveStart === true) {
            // Set the start of this range to the cloned range and update the
            // start container.
            this.rangeObj.setEndPoint(ViperDOMRange.START_TO_START, clone.rangeObj);
            this.startContainer = clone.startContainer;
            this.startOffset    = clone.startOffset;
        } else {
            // Set the end of this range to the start of the cloned range and
            // update the end container.
            this.rangeObj.setEndPoint(ViperDOMRange.END_TO_START, clone.rangeObj);
            this.endContainer = clone.endContainer;
            this.endOffset    = clone.endOffset;
        }

        this._setCommonAncestorContainer();
        this._setCollapsed();

    },

    /**
     * Returns the element that is common to the start and end of the range.
     *
     * @return DOMElement.
     */
    getCommonElement: function()
    {
        return this.rangeObj.parentElement();

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
        var clone = this.cloneRange();
        clone.collapse(toStart);

        var normalize = true;
        if (clone.startContainer.nodeType === ViperUtil.TEXT_NODE) {
            if (clone.startOffset === 0) {
                normalize = false;
            } else if (clone.endOffset === clone.startContainer.data.length) {
                normalize = false;
            }
        } else {
            normalize = false;
        }

        var shy = this.shy;
        clone.insertNode(shy);

        var previous = shy.previousSibling;
        var next     = shy.nextSibling;
        var c        = ViperUtil.$(shy).position();
        var coords   = {
            x: c.left,
            y: c.top
        };

        // This block of code is a fix for yet another stupid IE bug.
        // When a span tag wraps to next line then its offsetTop is reported
        // as its parent's offsetTop. So, if we are in the same block of text
        // and the height of the span changes then we adjust the Y coord.
        if (this.startContainer === this._prevContainer) {
            var height = ViperUtil.getElementHeight(shy);
            if (this._prevHeight === null) {
                this._prevHeight = height;
            } else if (height !== this._prevHeight) {
                coords.y = (coords.y + height - this._prevHeight);
            }
        } else {
            this._prevHeight    = null;
            this._prevContainer = this.startContainer;
        }

        // We're done with the shy.
        ViperUtil.remove(shy);

        // We need to restore the text back to the way it was.
        if (normalize && previous) {
            if (next && next.nodeType === ViperUtil.TEXT_NODE) {
                if (next === this.endContainer) {
                    this.endContainer = previous;
                }

                ViperUtil.remove(next);
                previous.data += next.data;
            }

            this.setEnd(this.endContainer, this.endOffset);
            this.setStart(this.startContainer, this.startOffset);
        }

        return coords;

    },



    /**
     * Returns the bounding rectangle for the range.
     *
     * @return Object[left, top, right, bottom]
     */
    getBoundingClientRect: function()
    {
        return this.rangeObj.getBoundingClientRect();

    },

    getHTMLContents: function()
    {
        return this.rangeObj.htmlText.replace(/\r\n/g, '');

    },

    getHTMLContentsObj: function()
    {
        var div = Viper.document.createElement('div');
        ViperUtil.setHtml(div, this.rangeObj.htmlText);
        return div;

    },

    /**
     * Returns the string contents of the selected text within the range. The contents
     * will not contain any markup.
     *
     * @return string
     */
    toString: function()
    {
        var text = this.rangeObj.text;

        // Remove char(13)char(10) (\r\n).
        text = text.replace(/\r\n/g, '');
        return text;

    }

};
