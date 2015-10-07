var ViperUtil = {
    $: window.$ || window.jQuery || window.dfxjQuery || (function() {throw new Error('jQuery not found!')})(),
    ELEMENT_NODE: 1,
    ATTRIBUTE_NODE: 2,
    TEXT_NODE: 3,
    CDATA_SECTION_NODE: 4,
    ENTITY_REFERENCE_NODE: 5,
    ENTITY_NODE: 6,
    PROCESSING_INSTRUCTION_NODE : 7,
    COMMENT_NODE: 8,
    DOCUMENT_NODE: 9,
    DOCUMENT_TYPE_NODE: 10,
    DOCUMENT_FRAGMENT_NODE: 11,
    NOTATION_NODE: 12,
    DOM_VK_DELETE: 46,
    DOM_VK_LEFT: 37,
    DOM_VK_UP: 38,
    DOM_VK_RIGHT: 39,
    DOM_VK_DOWN: 40,
    DOM_VK_ENTER: 13,
    DOM_VK_BACKSPACE: 8,
    _browserType: null,
    _browserVersion: null,

    isTag: function(node, tag)
    {
        if (typeof tag !== 'object') {
            if (node && node.tagName && node.tagName.toLowerCase() === tag.toLowerCase()) {
                return true;
            }
        } else if (node && node.tagName) {
            var tagName = node.tagName.toLowerCase();
            var ln      = tag.length;
            for (var i = 0; i < ln; i++) {
                if (tagName === tag[i].toLowerCase()) {
                    return true;
                }
            }
        }

        return false;

    },

    getTagName: function(node)
    {
        if (node && node.tagName) {
            return node.tagName.toLowerCase();
        }

        return null;

    },

    /**
     * Removes the element from the document.
     *
     * The element is removed by telling the element's parent node to remove the
     * element we want.
     *
     * @param {DomElement} element The element to remove from the document.
     *
     * @return TRUE if the element is removed successfully.
     * @type   bool
     */
    remove: function(element)
    {
        if (element) {
            return ViperUtil.$(element).remove();
        }

    },

    /**
     * Inserts a new element directly before another element in the DOM tree.
     *
     * @param {DomElement} before The element that is to be inserted before.
     * @param {DomElement} elem   The element to insert.
     *
     * @return TRUE if the element is inserted correctly.
     * @type   bool
     */
    insertBefore: function(before, elem)
    {
        ViperUtil.$(before).before(elem);

    },

    /**
     * Inserts an element in the DOM tree before another element.
     *
     * @param {DomElement} after The element to insert after.
     * @param {DomElement} elem  The element to insert.
     *
     * @return TRUE If the element is inserted correctly.
     * @type   bool
     */
    insertAfter: function(after, elem)
    {
        ViperUtil.$(after).after(elem);

    },

    /**
     * Applies the passed class to the element.
     *
     * @param {DomElement} element   The element to apply the class to.
     * @param {String}     classNames The classes to apply (separated by spaces).
     *
     * @return void
     * @type   void
     */
    addClass: function(element, classNames)
    {
        ViperUtil.$(element).addClass(classNames);

    },

    /**
     * Removes the passed class from the element.
     *
     * @param {DomElement} element   The element to remove the class from.
     * @param {String}     classNames The classes to remove (separated by spaces).
     *
     * @return void
     * @type   void
     */
    removeClass: function(element, classNames)
    {
        ViperUtil.$(element).removeClass(classNames);

    },

    /**
     * Adds/removes specified class name from given elements.
     *
     * @param {DomElements} elems     The elements to add/remove the class from.
     * @param {String}      className The class to add/remove.
     *
     * @return void
     */
    toggleClass: function(elems, className)
    {
        ViperUtil.$(elems).toggleClass(className);

    },

    /**
     * Sets a CSS style property on an element.
     *
     * The property name can be passed in as either javascript style notation
     * (fontHeight) or CSS notation (font-height).
     *
     * @param {DomElement} element  The element to apply the style to.
     * @param {String}     property The name of the property to set
     *                              eg. backgroundColor, borderWidth etc.
     * @param {String}     value    The value to set the property to.
     *
     * @type void
     */
    setStyle: function(element, property, value)
    {
        if (element) {
            ViperUtil.$(element).css(property, value);
        }

    },

    /**
     * Returns objects with the passed tag name, beneath the optional start element.
     *
     * @param {String}     tagName      The type of tag to find.
     * @param {DomElement} startElement The element to search under (if omitted
     *                                  defaults to document).
     * @param {Boolean}    onlyChildren If true, only the immediate children
     *                                  of the startElement will be searched.
     *
     * @return Array(DomElement).
     */
    getTag: function(tagName, startElement, onlyChildren)
    {
        var ret;

        if (!startElement) {
            startElement = document;
        }

        if (onlyChildren === true) {
            ret = ViperUtil.$.makeArray(ViperUtil.$(startElement).children(tagName));
        } else {
            ret = ViperUtil.$.makeArray(ViperUtil.$(startElement).find(tagName));
        }

        return ret;

    },

    /**
     * Sets the content of an element.
     *
     * If the element doesn't have an innerHTML property, then the value or other
     * equivalent property will be set instead, so this method can and should be
     * used for all elements.
     *
     * @param {DomElement} element The element to set content for.
     * @param {String}     content The content to apply to the element.
     *
     * @return TRUE if the content is correctly set.
     * @type   bool
     */
    setHtml: function(element, content)
    {
        if (element) {
            ViperUtil.$(element).html(content);
        }

    },

    /**
     * Get the content of an element.
     *
     * If the element is a textbox or another element that doesn't have HTML then
     * its' value will be returned, which allows this method to be used to retrieve
     * the content of any element.
     *
     * @param {DomElement} element The element to retrieve the content from.
     *
     * @return The content of the element.
     * @type   String
     */
    getHtml: function(element)
    {
        return ViperUtil.$(element).html();

    },

    /**
     * Retrurns TRUE if the specified element is a block element.
     *
     * @param {DOMElement} element The element to check.
     *
     * @return {boolean}
     */
    isBlockElement: function(element)
    {
        if (!element) {
            return false;
        }

        switch (element.nodeName.toLowerCase()) {
            case 'p':
            case 'div':
            case 'pre':
            case 'ul':
            case 'ol':
            case 'li':
            case 'table':
            case 'tbody':
            case 'td':
            case 'th':
            case 'tr':
            case 'caption':
            case 'fieldset':
            case 'form':
            case 'blockquote':
            case 'dl':
            case 'dir':
            case 'center':
            case 'address':
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
            case 'h5':
            case 'h6':
            case 'img':
            case 'header':
            case 'nav':
            case 'section':
            case 'main':
            case 'article':
            case 'aside':
            case 'footer':
            case 'details':
            case 'figure':
            case 'dialog':
            case 'canvas':
            case 'audio':
            case 'video':
                return true;
            break;

            default:
                return false;
            break;
        }//end switch

        return false;

    },

    /**
     * Returns true if the specified element does not have any children.
     *
     * @param {DOMElement} element The element to check.
     *
     * @return {boolean}
     */
    isStubElement: function(element)
    {
        if (element) {
            switch (element.nodeName.toLowerCase()) {
                case 'img':
                case 'br':
                case 'hr':
                case 'iframe':
                case 'param':
                case 'link':
                case 'meta':
                case 'input':
                case 'frame':
                case 'col':
                case 'base':
                case 'area':
                case 'embed':
                case 'canvas':
                case 'source':
                case 'track':
                    return true;

                break;

                default:
                    return false;

                break;
            }//end switch
        }//end if

        return false;

    },

    isEmptyElement: function (element) {
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

    },

    /**
     * returns a left trimmed string.
     *
     * @param {String} value The string to trim.
     * @param {String} trimChars The different chars to trim off the left.
     *
     * @return {String}
     */
    ltrim: function (str, trimChars)
    {
        trimChars = trimChars || '\\s';
        return str.replace(new RegExp('^[' + trimChars + ']+', 'g'), '');

    },

    /**
     * returns a right trimmed string.
     *
     * @param {String} value The string to trim.
     * @param {String} trimChars The different chars to trim off the right.
     *
     * @return {String}
     */
    rtrim: function (str, trimChars)
    {
        trimChars = trimChars || '\\s';
        return str.replace(new RegExp('[' + trimChars + ']+$', 'g'), '');

    },


    /**
     * returns a trimmed string.
     *
     * @param {String} value The string to trim.
     * @param {String} trimChars The different chars to trim off both sides.
     *
     * @return {String}
     */
    trim: function(value, trimChars)
    {
        return ViperUtil.ltrim(ViperUtil.rtrim(value, trimChars), trimChars);

    },

    ucFirst: function(str)
    {
        return str.substr(0,1).toUpperCase() + str.substr(1, str.length);

    },

    replaceAll: function(search, replace, subject)
    {
        // Escape search.
        search = search.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");

        var r = new RegExp(search, 'g');
        return subject.replace(r, replace);

    },

    /**
     * returns true if specified string is blank.
     *
     * @param {String} value The string to test.
     *
     * @return {String}
     */
    isBlank: function(value)
    {
        if (!value || /^\s*$/.test(value)) {
            return true;
        }

        return false;

    },

    isset: function(v)
    {
        if (typeof v !== 'undefined' && v !== null) {
            return true;
        }

        return false;

    },

    isObj: function(v)
    {
        if (v !== null && typeof v === 'object') {
            return true;
        }

        return false;

    },

    isEmpty: function(value)
    {
        if (value) {
            if (value instanceof Array) {
                if (value.length > 0) {
                    return false;
                }
            } else {
                for (var id in value) {
                    if (value.hasOwnProperty(id) === true) {
                        return false;
                    }
                }
            }
        }

        return true;

    },

    /**
     * Binds event type to specified elements.
     */
    addEvent: function(elements, type, callback, data)
    {
        if (elements) {
            if (type === 'safedblclick') {
                ViperUtil.safedblclick(elements, callback, data);
            } else if (type === 'mousewheel') {
                ViperUtil.$(elements).mousewheel(callback);
            } else {
                ViperUtil.$(elements).bind(type, data, callback);
            }
        }

    },

    /**
     * Removes bound event type from specified elements.
     */
    removeEvent: function(elements, type, func)
    {
        if (elements) {
            ViperUtil.$(elements).unbind(type, func);
        }

    },

    safedblclick: function(elements, clickCallback, dblClickCallback, data)
    {
        var t = null;
        ViperUtil.$(elements).bind('click', data, function(e) {
            clearTimeout(t);
            t = setTimeout(function() {
                clickCallback.call(this, e, data);
            }, 250);
        });

        ViperUtil.$(elements).bind('dblclick', data, function(e) {
            clearTimeout(t);
            dblClickCallback.call(this, e, data);
        });

    },

    /**
     * Trigger a type of event on all specified elements.
     */
    trigger: function(elements, type, data)
    {
        if (elements) {
            ViperUtil.$(elements).trigger(type, data);
        }

    },

    hover: function(elements, over, out)
    {
        if (elements) {
            ViperUtil.$(elements).hover(over, out);
        }

    },

    /**
     * Prevents default action and event bubbling.
     *
     * @param Event evt The event object.
     */
    preventDefault: function(e)
    {
        e.preventDefault();
        e.stopPropagation();

    },

    /**
     * Returns the target that a mouse event occured on.
     *
     * @param Event evt The event object.
     *
     * @return The element that the event occured on.
     * @type   DomElement
     */
    getMouseEventTarget: function(evt)
    {
       var ret = null;
        if (evt.target) {
            ret = evt.target;
        } else if (evt.srcElement) {
            ret = evt.srcElement;
        }

        return ret;

    },

    /**
     * Retrieves all elements underneath the parent element that contain the class.
     *
     * @param {String}     className    Space seperated string of classes
     *                                  to search on.
     * @param {DomElement} startElement The element to start from.
     *                                  If null, will search the whole document.
     * @param {String}     tagName      The elements to restrict the
     *                                  search to. Eg. 'div span'.
     * @param {Boolean}    onlyChildren If true, only the immediate children of the
     *                                  startElement will be searched.
     *
     * @return An array of elements that have the passed class applied.
     * @type   Array(DomElement)
     */
    getClass: function(className, startElement, tagName, onlyChildren)
    {
        var ret;

        if (!startElement) {
            startElement = document.body;
        }

        className = '.' + className.split(' ').join('.');

        if (tagName) {
            className = tagName + className;
        }

        if (onlyChildren === true) {
            ret = ViperUtil.$.makeArray(ViperUtil.$(startElement).children(className));
        } else {
            ret = ViperUtil.$.makeArray(ViperUtil.$(startElement).find(className));
        }

        return ret;

    },

    /**
     * Determines if the element has the passed class applied to it.
     *
     * @param {DomElement} element   The element to check.
     * @param {String}     className The class to check for.
     *
     * @return TRUE if the element has the class applied.
     * @type   bool
     */
    hasClass: function(element, className)
    {
        return ViperUtil.$(element).hasClass(className);

    },

    /**
     * Gets a CSS style property of an element.
     *
     * @param {DomElement} element  The element to retrieve the style from.
     * @param {String}     property The name of the property to get in CSS notation
     *                              eg. background-color, border-width etc.
     *
     * @return The value of the passed style for the passed element.
     * @type   string
     */
    getStyle: function(element, property)
    {
        return ViperUtil.$(element).css(property);

    },

    /**
     * Returns the computed styles for given element.
     */
    getComputedStyle: function (el, styleName)
    {
        if (styleName) {
            styleName = ViperUtil.camelCase(styleName);
        }

        if (document.defaultView && document.defaultView.getComputedStyle) {
            var styles = document.defaultView.getComputedStyle(el, null);
            if (styleName) {
                return styles[styleName];
            }

            return styles;
        } else if (el.currentStyle) {
            if (styleName) {
                return el.currentStyle[styleName];
            }

            return el.currentStyle;
        }

    },

    getFirstBlockParent: function(elem, stopEl)
    {
        while (elem.parentNode) {
            elem = elem.parentNode;
            if (stopEl && elem === stopEl) {
                return null;
            }

            if (ViperUtil.isBlockElement(elem) === true) {
                return elem;
            }
        }

        return null;

    },

    getParents: function(elements, filter, stopEl, blockElementsOnly)
    {
        var res = ViperUtil.$(elements).parents(filter);
        var ln  = res.length;
        var ar  = [];
        for (var i = 0; i < ln; i++) {
            if (stopEl && (res[i] === stopEl || ViperUtil.isChildOf(res[i], stopEl) === false)) {
                break;
            }

            if (blockElementsOnly !== true || ViperUtil.isBlockElement(res[i]) === true) {
                ar.push(res[i]);
            }
        }

        return ar;

    },

    /**
     * Returns list of parent elements that have only one child.
     *
     * @param node        {DOMNode} The child element to get parents of.
     * @param tagName     {string}  The tag name filter.
     * @param elementType {boolean} Can be one of block|inline|stub.
     *                              If the tagName filter is set then this param is ignored.
     *
     * @return {array} Parent elements.
     */
    getSurroundingParents: function(node, tagName, elementType, stopElem)
    {
        var parents = [];
        if (!node) {
            return parents;
        }

        var parent  = node.parentNode;
        while (parent) {
            if (stopElem && parent === stopElem) {
                break;
            }

            var c = parent.childNodes.length;
            for (var i = 0; i < c; i++) {
                var child = parent.childNodes[i];
                if (child.nodeType == ViperUtil.ELEMENT_NODE) {
                    if (child !== node) {
                        return parents;
                    }
                } else if (ViperUtil.isBlank(ViperUtil.trim(child.data)) !== true) {
                    return parents;
                }
            }

            if (!tagName) {
                var isOfType = false;
                if (elementType) {
                    switch (elementType) {
                        case 'block':
                            isOfType = ViperUtil.isBlockElement(parent);
                        break;

                        case 'stub':
                            isOfType = ViperUtil.isStubElement(parent);
                        break;

                        default:
                            if (parent.nodeType === ViperUtil.ELEMENT_NODE && ViperUtil.isBlockElement(parent) === false) {
                                // Inline
                                isOfType = true;
                            }
                        break;
                    }
                } else {
                    isOfType = true;
                }

                if (isOfType) {
                    parents.push(parent);
                }
            } else if (ViperUtil.isTag(parent, tagName) === true) {
                parents.push(parent);
            }

            node   = parent;
            parent = parent.parentNode;
        }

        return parents;

    },

    getTopSurroundingParent: function(node, tagName, elementType, stopElem)
    {
        var parents = this.getSurroundingParents(node, tagName, elementType, stopElem);
        if (parents.length > 0) {
            return parents.pop();
        }

    },

    hasSurroundingParent: function(element, parentTagName, stopEl)
    {
        var parents = this.getSurroundingParents(element, parentTagName, null, stopEl);
        if (parents.length > 0) {
            return true;
        }

        return false;

    },

    /**
     * Returns true if the specified element(s) is a child of parent.
     */
    isChildOf: function(el, parent, stopElem)
    {
        try {
            if (parent instanceof Array) {
                var c = parent.length;
                while (el && el !== stopElem && el.parentNode) {
                    for (var i = 0; i < c; i++) {
                        if (el.parentNode === parent[i]) {
                            return true;
                        }
                    }

                    el = el.parentNode;
                }
            } else {
                while (el && el !== stopElem && el.parentNode) {
                    if (el.parentNode === parent) {
                        return true;
                    }

                    el = el.parentNode;
                }
            }
        } catch (e) {
            // Sometimes elements have "Invalid argument" as parentNode in IE
            // which causes exception..
        }

        return false;

    },

    /**
     * Returns elements between fromElem and toElem.
     * Example:
     * <div>text
     *    <span id="x">SPAN</span>
     *    <br />
     *    <p>
     *          <strong>text</strong>
     *    </p>
     * </div>
     *  <div>
     *    <div id="a">AAAA</div>
     *    <div id="y">xxxxx</div>
     *  </div>
     * Calling getElementsFromTo(x, y);
     * Result: [br, p, div(id=a)]
     */
    getElementsBetween: function(fromElem, toElem, range)
    {
        var elements = [];

        if (!fromElem || !toElem) {
            return elements;
        }

        if (fromElem === toElem) {
            return elements;
        }

        // The toElem could be a child of fromElem.
        if (ViperUtil.isChildOf(toElem, fromElem) === true) {
            var fElemLen = fromElem.childNodes.length;
            for (var i = 0; i < fElemLen; i++) {
                if (fromElem.childNodes[i] === toElem) {
                    break;
                } else if (ViperUtil.isChildOf(toElem, fromElem.childNodes[i]) === true) {
                    return ViperUtil.arrayMerge(elements, ViperUtil.getElementsBetween(fromElem.childNodes[i], toElem));
                } else {
                    elements.push(fromElem.childNodes[i]);
                }
            }

            return elements;
        }

        // Get the next siblings of the fromElem.
        var startEl = fromElem.nextSibling;
        while (startEl) {
            if (ViperUtil.isChildOf(toElem, startEl) === true) {
                // If the toElem is a child of this element then
                // we have to get the elements from this node to target node.
                elements = ViperUtil.arrayMerge(elements, ViperUtil.getElementsBetween(startEl, toElem));
                return elements;
            } else if (startEl === toElem) {
                return elements;
            } else {
                elements.push(startEl);
                startEl = startEl.nextSibling;
            }
        }

        var fromParents = ViperUtil.getParents(fromElem);
        var toParents   = ViperUtil.getParents(toElem);

        // Find the parents of fromElem that are not parent of toElem.
        var parentElems = ViperUtil.arrayDiff(fromParents, toParents, true);
        var pElemLen    = parentElems.length;
        for (var j = 0; j < (pElemLen - 1); j++) {
            elements = ViperUtil.arrayMerge(elements, ViperUtil.getSiblings(parentElems[j], 'next'));
        }

        var lastParent = parentElems[(parentElems.length - 1)];
        if (lastParent) {
            elements = ViperUtil.arrayMerge(elements, ViperUtil.getElementsBetween(lastParent, toElem));

            if (lastParent.firstChild === lastParent.lastChild
                && lastParent.firstChild === fromElem
                && lastParent !== toElem
                && (!range || range.startOffset === 0)
            ) {
               elements.push(lastParent);
            }
        }

        return elements;

    },

    /**
     * Returns the siblings of the element.
     *
     * @param DomNode element          The element.
     * @param string  dir              Direction of the siblings. (values: prev, next).
     * @param boolean elementNodesOnly If true then only the ELEMENT_NODEs will be returned.
     *                                 Other nodes like TEXT_NODE will be ignored.
     * @param DomNode stopElem         If specified any sibling from stopElem will not be returned.
     */
    getSiblings: function(element, dir, elementNodesOnly, stopElem)
    {
        if (elementNodesOnly === true) {
            if (dir === 'prev') {
                return ViperUtil.$(element).prevAll();
            } else {
                return ViperUtil.$(element).nextAll();
            }
        } else {
            var elems = [];
            if (dir === 'prev') {
                while (element.previousSibling) {
                    element = element.previousSibling;
                    if (element === stopElem) {
                        break;
                    }

                    elems.push(element);
                }
            } else {
                while (element.nextSibling) {
                    element = element.nextSibling;
                    if (element === stopElem) {
                        break;
                    }

                    elems.push(element);
                }
            }

            return elems;
        }//end if

    },

    /**
     * Merges an array of any type similiar to PHP.
     *
     * If array1 is a JS array the elements will simply be added to the end of array1.
     * If array1 is an object the arrays will be merged maintaining keys and if a key
     * for an element exists in array2 which is the same as array 1 the value in array2
     * will overwrite in array1.
     *
     * @param {array|object} array1 First array to merge into.
     * @param {array|object} array2 Second array to merge in.
     *
     * @return {array|object}
     */
    arrayMerge: function (array1, array2)
    {
        // We won't maintain the index if array1 is a JS array because if it tries to
        // merge with a string index it would fail.
        if (array1 instanceof Array) {
            var maintainIndex = false;
        } else {
            var maintainIndex = true;
        }

        // Do the merging.
        ViperUtil.foreach(array2, function(idx) {
            var value = array2[idx];
            if (maintainIndex === true) {
                array1[idx] = value;
            } else {
                array1.push(value);
            }
        });

        return array1;

    },

    /**
     * Loop through object or array.
     */
    foreach: function(value, cb)
    {
        if (value instanceof Array) {
            var len = value.length;
            for (var i = 0; i < len; i++) {
                var res = cb.call(this, i);
                if (res === false) {
                    break;
                }
            }
        } else {
            for (var id in value) {
                if (value.hasOwnProperty(id) === true) {
                    var res = cb.call(this, id);
                    if (res === false) {
                        break;
                    }
                }
            }
        }

    },

    /**
     * Sets/Gets the attribute for specified element(s).
     *
     * @param mixed element Element(s) to modify.
     * @param mixed key     Key can the the attribute name or key/value object.
     * @param mixed value   Value can be string, number, function.
     *                      Ignored when key param is an object.
     */
    attr: function(elements, key, val)
    {
        if (ViperUtil.isset(val) === true) {
            return ViperUtil.$(elements).attr(key, val);
        } else {
            return ViperUtil.$(elements).attr(key);
        }

    },

    removeAttr: function(elements, name)
    {
        ViperUtil.$(elements).removeAttr(name);

    },

    /**
     * Returns the coordinates of a rectangle that will cover the element.
     *
     * Returns the coordinates of the top left corner (x1, y1) as well as the
     * bottom-right corner (x2, y2).
     *
     * @param {DomElement} element The element which we want the dimensions for.
     *
     * @return The 2 x and 2 y coordinates of the element's bounding rectangle.
     * @type   Object
     */
    getBoundingRectangle: function(element)
    {
        // Retrieve the coordinates and dimensions of the element.
        var coords     = ViperUtil.getElementCoords(element);
        var width      = ViperUtil.getElementWidth(element);
        var height     = ViperUtil.getElementHeight(element);

        // Create an array by using the elements dimensions.
        var result = {
            x1: parseInt(coords.x),
            y1: parseInt(coords.y),
            x2: parseInt(coords.x + width),
            y2: parseInt(coords.y + height)
        };
        return result;

    },

    /**
     * Returns the textual information within a text node.
     *
     * @param {Text} The node to reteive the text for.
     *
     * @return string
     * @type void
     */
    getNodeTextContent: function(node)
    {
       return ViperUtil.$(node).text();

    },

    getUniqueId: function()
    {
        var id  = Math.ceil((1 + Math.random()) * 100000).toString();
        id     += Math.ceil((1 + Math.random()) * 100000).toString();
        return id;

    },

    /**
     * Returns the object with the passed ID.
     *
     * @param {String}     id           The ID of the element to find.
     * @param {DomElement} startElement The element to search under (if omitted
     *                                  defaults to document).
     *
     * @return DomElement
     */
    getid: function(id, startElement)
    {
        if (!startElement) {
            startElement = document;
        }

        element = startElement.getElementById(id);
        return element;

    },

    /**
     * Completely removes all content that is contained within the passed element.
     *
     * If the element was the following: <p id="mypara"><span>Content</span></p>,
     * when called with dom.empty(ViperUtil.getid('mypara')) the paragraph would become
     * <p id="mypara"></p>.
     *
     * @param {DomElement} element The element to empty.
     *
     * @return TRUE if the element is successfully emptied.
     * @type   boolean
     */
    empty: function(element)
    {
        if (element) {
            return ViperUtil.$(element).empty();
        }

    },

    find: function(parent, exp)
    {
        // Note: For valid selectors for exp go to http://docs.jquery.com/Selectors.
        return ViperUtil.$(parent).find(exp);

    },

    getFirstChildTextNode: function(node)
    {
        if (node.firstChild) {
            if (node.firstChild.nodeType === ViperUtil.ELEMENT_NODE) {
                return ViperUtil.getFirstChildTextNode(node.firstChild);
            } else {
                return node.firstChild;
            }
        }

        return node;

    },

    getLastChildTextNode: function(node)
    {
        if (node.lastChild) {
            if (node.lastChild.nodeType === ViperUtil.ELEMENT_NODE) {
                return ViperUtil.getLastChildTextNode(node.lastChild);
            } else {
                return node.lastChild;
            }
        }

        return node;

    },

    hasAttribute: function(element, attribute)
    {
        if (element.hasAttribute) {
            return element.hasAttribute(attribute);
        } else if (element.getAttribute) {
            if (element.getAttribute(attribute) === null) {
                return false;
            } else {
                return true;
            }
        }

        return false;

    },

    /**
     * Returns true if the given element has valid content.
     *
     * E.g. <p><br /></p> will not return true but <p><img /></p> will return true.
     *
     */
    hasContent: function (element)
    {
        if (ViperUtil.isBlank(ViperUtil.getNodeTextContent(element)) === true) {
            // Might have stub elements.
            var tags = ViperUtil.getTag('*', element);
            var ln   = tags.length;
            for (var i = 0; i < ln; i++) {
                if (ViperUtil.isStubElement(tags[i]) === true && ViperUtil.isTag(tags[i], 'br') === false) {
                    return true;
                }
            }

            return false;
        }

        return true;

    },

    /**
     * Returns the height of the element.
     *
     * By default, returns the "outer" dimensions, including padding and borders. If the
     * "inner" parameter is passed as true, the dimensions returned will exclude these.
     *
     * @param {DomElement} element The element which we want the height for.
     * @param {Boolean}    inner   true indicates inner dimensions wanted.
     *
     * @return integer
     */
    getElementHeight: function(element, inner)
    {
        if (inner === true) {
            return element.clientHeight;
        } else {
            return element.offsetHeight;
        }

    },

    /**
     * Returns the width of the element.
     *
     * By default, returns the "outer" dimensions, including padding and borders. If the
     * "inner" parameter is passed as true, the dimensions returned will exclude these.
     *
     * @param {DomElement} element The element which we want the width for.
     * @param {Boolean}    inner   true indicates inner dimensions wanted.
     *
     * @return integer
     */
    getElementWidth: function(element, inner)
    {
        if (inner === true) {
            return element.clientWidth;
        } else {
            return element.offsetWidth;
        }

    },

    isFn: function(f)
    {
        if (typeof f === 'function') {
            return true;
        }

        return false;

    },

    /**
     * Returns the dimensions of the viewable window.
     *
     * @return The 2 x and 2 y coordinates of the viewable window.
     * @type   Object
     */
    getWindowDimensions: function(win)
    {
        win = win || window;
        var windowWidth  = 0;
        var windowHeight = 0;
        if (win.innerWidth) {
            // Will work on Mozilla, Opera and Safari etc.
            windowWidth  = win.innerWidth;
            windowHeight = win.innerHeight;
            // If the scrollbar is showing (it is always showing in IE) then its'
            // width needs to be subtracted from the height and/or width.
            var scrollWidth = ViperUtil.getScrollbarWidth();
            // The documentElement.scrollHeight.
            if (win.document.documentElement.scrollHeight > windowHeight) {
                // Scrollbar is shown.
                if (typeof scrollWidth === 'number') {
                    windowWidth -= scrollWidth;
                }
            }

            if (win.document.body.scrollWidth > windowWidth) {
                // Scrollbar is shown.
                if (typeof scrollWidth === 'number') {
                    windowHeight -= scrollWidth;
                }
            }
        } else if (win.document.documentElement && (win.document.documentElement.clientWidth || win.document.documentElement.clientHeight)) {
            // Internet Explorer.
            windowWidth  = win.document.documentElement.clientWidth;
            windowHeight = win.document.documentElement.clientHeight;
        } else if (win.document.body && (win.document.body.clientWidth || win.document.body.clientHeight)) {
            // Browsers that are in quirks mode or weird examples fall through here.
            windowWidth  = win.document.body.clientWidth;
            windowHeight = win.document.body.clientHeight;
        }//end if

        var result = {
            'width'  : windowWidth,
            'height' : windowHeight
        };
        return result;

    },

    /**
     * Returns the current scroll position of the screen.
     *
     * @return Object
     * @type   Object
     */
    getScrollCoords: function(win)
    {
        win = win || window;
        var scrollX = 0;
        var scrollY = 0;
        if (win.pageYOffset) {
            // Mozilla, Firefox, Safari and Opera will fall into here.
            scrollX = win.pageXOffset;
            scrollY = win.pageYOffset;
        } else if (win.document.body && (win.document.body.scrollLeft || win.document.body.scrollTop)) {
            // This is the DOM compliant method of retrieving the scroll position.
            // Safari and OmniWeb supply this, but report wrongly when the window
            // is not scrolled. They are caught by the first condition however, so
            // this is not a problem.
            scrollX = win.document.body.scrollLeft;
            scrollY = win.document.body.scrollTop;
        } else {
            // Internet Explorer will get into here when in strict mode.
            scrollX = win.document.documentElement.scrollLeft;
            scrollY = win.document.documentElement.scrollTop;
        }

        var coords = {
            x: scrollX,
            y: scrollY
        };
        return coords;

    },

    getElementScrollCoords: function(element)
    {
        var scrollX = 0;
        var scrollY = 0;

        if (ViperUtil.isset(element.scrollLeft) === true) {
            scrollX = element.scrollLeft;
            scrollY = element.scrollTop;
        }

        var coords = {
            x: scrollX,
            y: scrollY
        };
        return coords;

    },

    /**
     * Returns the width of the scrollbar programmatically.
     *
     * This is necessary to determine the viewable browser window, as Firefox and
     * Opera only display the scrollbars when necessary and report their window
     * dimensions without the scrollbar. This method will create a div out of the
     * viewable range, and measure it with and without a scrollbar. The difference
     * is returned.
     * NB: This will only be run once, as the value is stored after execution.
     *
     * @return integer
     */
    getScrollbarWidth: function()
    {
        if (ViperUtil._scrollBarWidth) {
            return ViperUtil._scrollBarWidth;
        }

        var wrapDiv            = null;
        var childDiv           = null;
        var widthNoScrollBar   = 0;
        var widthWithScrollBar = 0;
        // Outer scrolling div.
        wrapDiv                = document.createElement('div');
        wrapDiv.style.position = 'absolute';
        wrapDiv.style.top      = '-1000px';
        wrapDiv.style.left     = '-1000px';
        wrapDiv.style.width    = '100px';
        wrapDiv.style.height   = '50px';
        // Start with no scrollbar.
        wrapDiv.style.overflow = 'hidden';

        // Inner content div.
        childDiv              = document.createElement('div');
        childDiv.style.width  = '100%';
        childDiv.style.height = '200px';

        // Put the inner div in the scrolling div.
        wrapDiv.appendChild(childDiv);
        // Append the scrolling div to the doc.
        document.body.appendChild(wrapDiv);

        // Width of the inner div sans scrollbar.
        widthNoScrollBar = childDiv.offsetWidth;
        // Add the scrollbar.
        wrapDiv.style.overflow = 'auto';
        // Width of the inner div width scrollbar.
        widthWithScrollBar = childDiv.offsetWidth;

        // Remove the scrolling div from the doc.
        document.body.removeChild(document.body.lastChild);

        // Pixel width of the scroller.
        var scrollBarWidth = (widthNoScrollBar - widthWithScrollBar);
        // Set the DOM variable so we don't have to run this again.
        ViperUtil._scrollBarWidth = scrollBarWidth;
        return scrollBarWidth;

    },

    /**
     * Retrieves the coordinate of the element relative to the page.
     *
     * @param {DomElement} el  The element which we want the coordinates for.
     *
     * @return Object
     */
    getElementCoords: function(element, relative)
    {
        var offset = ViperUtil.$(element).offset();
        return {
            x: offset.left,
            y: offset.top
        };

    },

    getElementFrameElement: function(element)
    {
        if (element.ownerDocument.defaultView) {
            return element.ownerDocument.defaultView.frameElement;
        } else {
            return element.ownerDocument.frames.frameElement;
        }

        return null;

    },

    /**
     * Determines the position of the bubble given a target element.
     *
     * @param {DOMNode} element       The Bubble element.
     * @param {DOMNode} targetElement The element to point to.
     */
    determinePosition: function(element, settings)
    {
        settings         = settings || {};
        targetElement    = settings.targetElement;
        alignClassPrefix = settings.alignClassPrefix || 'ViperUtil-align';
        arrowClassPrefix = settings.arrowClassPrefix || 'ViperUtil-arrow';
        var validPositions = {
            left: ['right.middle', 'right.top', 'right.bottom'],
            right: ['left.middle', 'left.top', 'left.bottom'],
            bottom:['top.left', 'top.middle', 'top.right'],
            top: ['bottom.left', 'bottom.middle', 'bottom.right']
        };

        var classNames = ['top', 'left', 'right', 'bottom', 'middle', 'center'];
        ViperUtil.foreach(
            classNames,
            function(i) {
                ViperUtil.removeClass(element, alignClassPrefix + classNames[i]);
                ViperUtil.removeClass(element, arrowClassPrefix + classNames[i]);
            }
        );

        // Check if the target element is off screen.
        if (this.isElementOffScreen(targetElement) === true) {
            // Set position to the top left of the window.
            var relPos = ViperUtil.getRelativeWindowPosition(
                targetElement.ownerDocument.defaultView.frameElement,
                element.ownerDocument.defaultView.frameElement
            );

            ViperUtil.setStyle(element, 'left', relPos.x + 'px');
            ViperUtil.setStyle(element, 'top', relPos.y + 'px');

            return;
        }

        // Get target elements position.
        var relPos     = ViperUtil.getRelativeWindowPosition(targetElement, this.getElementFrameElement(element));
        var targetRect = {};
        targetRect.x1  = relPos.x;
        targetRect.y1  = relPos.y;
        targetRect.x2  = relPos.x + ViperUtil.getElementWidth(targetElement);
        targetRect.y2  = relPos.y + ViperUtil.getElementHeight(targetElement);

        // Get the rectangle of the element that will be moved.
        var elemRect = ViperUtil.getBoundingRectangle(element);
        var elemH    = (elemRect.y2 - elemRect.y1);
        var elemW    = (elemRect.x2 - elemRect.x1);

        // Get window dimensions.
        var winDim     = ViperUtil.getWindowDimensions(element.ownerDocument.defaultView);
        var targetMidX = 0;
        var targetMidY = 0;
        var self       = this;

        var _positionElement = function(position, arrowPositions) {
            switch (position) {
                case 'top':
                    targetMidX = targetRect.x1 + ((targetRect.x2 - targetRect.x1) / 2);
                    targetMidY = targetRect.y1;
                break;

                case 'bottom':
                    targetMidX = targetRect.x1 + ((targetRect.x2 - targetRect.x1) / 2);
                    targetMidY = targetRect.y2;
                break;

                case 'left':
                    targetMidX = targetRect.x1;
                    targetMidY = targetRect.y1 + ((targetRect.y2 - targetRect.y1) / 2);
                break;

                case 'right':
                    targetMidX = targetRect.x2;
                    targetMidY = targetRect.y1 + ((targetRect.y2 - targetRect.y1) / 2);
                break;

                default:
                return false;
            }//end switch

            // Using the default position top left (of the intervention box) determine
            // the correct position.
            var oln            = arrowPositions.length;
            var arrowElemWidth = 19;
            var arrowElemHeight = 31;
            var arrowPadding    = 15;
            for (var o = 0; o < oln; o++) {
                var posX  = 0;
                var posY  = 0;
                var classParts = arrowPositions[o].split('.');
                switch (classParts[0]) {
                    case 'top':
                        posY = targetMidY;
                    break;

                    case 'bottom':
                        posY = (targetMidY - elemH);
                    break;

                    case 'right':
                        posX = (targetMidX - elemW - arrowElemWidth);
                    break;

                    case 'left':
                        posX = targetMidX;
                    break;

                    default:
                        // Unknown type.
                    break;
                }//end switch

                switch (classParts[1]) {
                    case 'left':
                        posX = targetMidX;
                    break;

                    case 'right':
                        posX = (targetMidX - elemW);
                    break;

                    case 'middle':
                        if (classParts[0] === 'top' || classParts[0] === 'bottom') {
                            classParts[1] = 'center';
                            posX     = (targetMidX - (elemW / 2));
                        } else {
                            posY = (targetMidY - (elemH / 2));
                        }
                    break;

                    case 'top':
                        posY = (targetMidY - (arrowElemHeight / 2) - arrowPadding);
                    break;

                    case 'bottom':
                        posY = (targetMidY - (elemH - (arrowElemHeight / 2) - arrowPadding));
                    break;

                    default:
                        // Unknown type.
                    break;
                }//end switch

                var scrollCoords = ViperUtil.getScrollCoords(element.ownerDocument.defaultView);

                if (settings.fixedPositioning === true) {
                    posX  = Math.abs(posX);
                    posY  = Math.abs(posY);
                } else {
                    posX += scrollCoords.x;
                    posY += scrollCoords.y;
                }

                ViperUtil.addClass(element, arrowClassPrefix + classParts[0]);
                ViperUtil.addClass(element, alignClassPrefix + classParts[1]);
                ViperUtil.setStyle(element, 'left', posX + 'px');
                ViperUtil.setStyle(element, 'top', posY + 'px');

                // Check if the element is on the screen.
                if (self.isElementCutOff(element) === false) {
                    // Its on the screen so set styles and stop looping.
                    // Or last in loop (keep the last arrow style).
                    return true;
                } else {
                    ViperUtil.removeClass(element, arrowClassPrefix + classParts[0]);
                    ViperUtil.removeClass(element, alignClassPrefix + classParts[1]);
                }
            }//end for

            return false;
        };

        var positioned = false;
        if (settings.position) {
            positioned = _positionElement(settings.position, settings.arrowPositions)
        }

        if (positioned === false) {
            // Auto position.
            for (var pos in validPositions) {
                if (_positionElement(pos, validPositions[pos]) === true) {
                    return;
                }
            }
        }

    },

    isElementOffScreen: function(element)
    {
        var coords       = ViperUtil.getElementCoords(element);
        var dims         = ViperUtil.getElementDimensions(element);
        var scrollCoords = ViperUtil.getScrollCoords(element.ownerDocument.defaultView);
        var windowDims   = ViperUtil.getWindowDimensions(element.ownerDocument.defaultView);

        coords.x -= scrollCoords.x;
        coords.y -= scrollCoords.y;
        if (coords.y + dims.height < 0
            || coords.y > windowDims.height
            || coords.x + dims.width < 0
            || coords.x > windowDims.width
        ) {
            return true;
        }

        return false;

    },

    /**
     * Returns true if the element is cut off due to its position in window or iframe.
     */
    isElementCutOff: function(element)
    {
        // Get the actual view size.
        var win          = element.ownerDocument.defaultView || window;
        var scrollCoords = ViperUtil.getScrollCoords(win);
        var winHeight    = ViperUtil.$(win).height();
        var winWidth     = ViperUtil.$(win).width();
        var relPos       = ViperUtil.getRelativeWindowPosition(element);
        var elDim        = ViperUtil.getElementDimensions(element);
        var coords       = ViperUtil.getElementCoords(element, true);

        coords.x -= scrollCoords.x;
        coords.y -= scrollCoords.y;

        // Check position in current document.
        if (coords.y < 0
            || coords.y + elDim.height > winHeight
            || coords.x < 0
            || coords.x + elDim.width > winWidth
        ) {
            return true;
        }

        while (win.frameElement) {
            win = win.frameElement.ownerDocument.defaultView;
            var parentHeight = ViperUtil.$(win).height();
            var parentWidth  = ViperUtil.$(win).width();
            if (parentHeight < winHeight) {
                winHeight = parentHeight;
            }

            if (parentWidth < winWidth) {
                winWidth = parentWidth;
            }
        }

        // Check position in parent documents.
        if (relPos.y < 0
            || relPos.y + elDim.height > winHeight
            || relPos.x < 0
            || relPos.x + elDim.width > winWidth
        ) {
            return true;
        }

        return false;

    },


    /**
     * Returns the absolute dimensions of the passed element.
     *
     * By default, returns the "outer" dimensions, including padding and borders. If the
     * "inner" parameter is passed as true, the dimensions returned will exclude these.
     *
     * @param {DomElement} element The element which we want the dimensions for.
     * @param {Boolean}    inner   true indicates inner dimensions wanted.
     *
     * @return Object
     */
    getElementDimensions: function(element, inner)
    {
        // Default to outer dimensions by default.
        if (inner === undefined) {
            inner = false;
        }

        var result = {
            width: ViperUtil.getElementWidth(element, inner),
            height: ViperUtil.getElementHeight(element, inner)
        };

        return result;

    },


    /**
     * Returns the position of the element relative to the specified top frame.
     *
     * @param {DomElement} elem     The element.
     * @param {DomElement} topFrame The most outer frame or null for main frame.
     *
     * @return void
     */
    getRelativeWindowPosition: function(elem, topFrame)
    {
        var offset       = null;
        var frameElement = this.getElementFrameElement(elem);
        if (frameElement) {
            offset = ViperUtil.getElementCoords(elem);
            if (frameElement !== topFrame) {
                var frameOffset = ViperUtil.getRelativeWindowPosition(frameElement, topFrame);
                offset.x       += frameOffset.x;
                offset.y       += frameOffset.y;
            }
        } else {
            offset = ViperUtil.getElementCoords(elem);
        }

        var scrollCoords = ViperUtil.getScrollCoords(elem.ownerDocument.defaultView);
        offset.y        -= scrollCoords.y;
        offset.x        -= scrollCoords.x;

        return offset;

    },

    removeEmptyNodes: function(parent, callback)
    {
        var elems   = ViperUtil.$(parent).find(':empty');
        var i       = elems.length;
        var removed = false;
        while (i > 0) {
            i--;
            if (ViperUtil.isStubElement(elems[i]) === false) {
                if (!callback || callback.call(this, elems[i]) !== false) {
                    ViperUtil.remove(elems[i]);
                    removed = true;
                }
            }
        }

        if (removed === true) {
            this.removeEmptyNodes(parent, callback);
        }

    },

    /**
     * Returns a unique path for the given node.
     *
     * @param DOMNode node The node to retrieve the path for.
     *
     * @return string the path.
     */
    getXPath: function(node)
    {
        var path = '';

        while (node && node.parentNode) {
            if (node.nodeType === ViperUtil.TEXT_NODE) {
                var sibling = node.previousSibling;
                var pos     = 1;
                while (sibling) {
                    pos++;
                    sibling = sibling.previousSibling;
                }

                if (pos <= 1) {
                    path = '/node()';
                } else {
                    path = '/node()[' + pos + ']';
                }
            } else {
                var nodeName = node.nodeName.toLowerCase();
                var sibling = node.previousSibling;
                var pos     = 1;
                while (sibling) {
                    if (sibling.nodeType === ViperUtil.ELEMENT_NODE &&
                        nodeName === sibling.nodeName.toLowerCase()
                    ) {
                        pos++;
                    }

                    sibling = sibling.previousSibling;
                }

                if (pos <= 1) {
                    path = '/' + nodeName + path;
                } else {
                    path = '/' + nodeName + '[' + pos + ']' + path;
                }
            }//end if

            node = node.parentNode;
        }//end while

        return path;

    },

    /**
     * Returns the node within the document for the specified path.
     *
     * @param string path The path for the wanted node.
     *
     * @return DOMNode
     */
    getNodeFromXPath: function(path)
    {
        if (document.evaluate) {
            var node = document.evaluate(path, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null);
            return node.singleNodeValue;
        } else {
            return ViperUtil.getNodeFromPath(path);
        }

    },


    /**
     * Provides an domtree traversal method for retrieving the node for the
     * specified path.
     *
     * @param string path The path for the wanted node.
     *
     * @return DOMNode
     */
    getNodeFromPath: function(path)
    {
        var paths  = path.split('/');
        var parent = document;
        var pln    = paths.length;
        for (var i = 0; i < pln; i++) {
            if (ViperUtil.trim(paths[i]) === '') {
                continue;
            }

            parent = ViperUtil.getNodeFromPathSegment(parent, paths[i]);
        }

        return parent;

    },

    /**
     * Returns the node for the specified path segment under the specified parent.
     *
     * @param DOMElement parent The parent to retreive the child for.
     * @param string     path   The path segment that identifies the child.
     *
     * @return DOMNode
     */
    getNodeFromPathSegment: function(parent, path)
    {
        var pos = path.match(/\[(\d+)\]/);

        if (!pos) {
            pos = 1;
        } else {
            pos = parseInt(pos[1]);
            if (!pos) {
                pos = 1;
            }
        }

        var brPos = path.indexOf('[') || path.length;
        var type  = path.substr(0, brPos);

        if (!type) {
            type = path;
        }

        var node, found = 1;
        var cln         = parent.childNodes.length;
        for (var i = 0; i < cln; i++) {
            node = parent.childNodes[i];

            if (node.nodeType === ViperUtil.DOCUMENT_TYPE_NODE) {
                continue;
            }

            if (type === 'node()') {
                if (found === pos) {
                    return node;
                }

                found++;
            } else if (node.nodeName && type === node.nodeName.toLowerCase()) {
                if (found === pos) {
                    return node;
                }

                found++;
            }
        }

        throw Error('XPath: node could not be found');

    },

    getFrames: function(doc)
    {
        doc = doc || document;
        if (doc.frames) {
            return doc.frames;
        } else if (doc.defaultView.frames) {
            return doc.defaultView.frames;
        }

        return [];
    },


    /**
     * Returns the loaded DOM Documents (main window, iframes, etc).
     *
     * @return {array}
     */
     getDocuments: function(nested, parentDoc)
     {
         parentDoc  = parentDoc || document;
         var docs   = [parentDoc];
         var frames = this.getFrames(parentDoc);
         var c      = frames.length;
         for (var i = 0; i < c; i++) {
             var doc = this.getIFrameDocument(frames[i]);
             if (doc !== null) {
                 if (nested === true) {
                     docs = docs.concat(dfx.getDocuments(nested, doc))
                 } else {
                     docs.push(doc);
                 }
             }
         }

         return docs;

    },

    /**
     * Returns the document element for the specified iframe.
     *
     * @param {IFrameElement} iframe The iframe to retreive the document for.
     *
     * @return {DocumentElement}
     */
    getIFrameDocument: function(iframe)
    {
        var doc = null;
        try {
            if (iframe.contentDocument) {
                doc = iframe.contentDocument;
            } else if (iframe.contentWindow) {
                doc = iframe.contentWindow.document;
            } else if (iframe.document) {
                doc = iframe.document;
            }
        } catch (e) {
            doc = null;
        }

        return doc;

    },

    /**
     * Very basic implementation of sprintf.
     *
     * Currently only supports replacement of %s in the specified string.
     * Usage: ViperUtil.sprintf('Very %s implementation of %s.', 'basic', 'sprintf');
     */
    sprintf: function(str)
    {
        var c = arguments.length;
        if (c <= 1) {
            return str;
        }

        for (var i = 1; i < c; i++) {
            str = str.replace(/%s/, arguments[i]);
        }

        return str;

    },

    walk: function(elem, callback, stopElem, lvl)
    {
        if (!elem || elem === stopElem) {
            return false;
        }

        if (!lvl) {
            lvl = 0;
        }

        var nextSibling = elem.nextSibling;
        var parentNode  = elem.parentNode;

        var retVal = callback.call(this, elem, lvl);
        if (retVal === false) {
            // Stop.
            return false;
        } else if (retVal instanceof Object) {
            nextSibling = retVal;
        }

        if (elem.childNodes && elem.childNodes.length > 0) {
            if (ViperUtil.walk(elem.firstChild, callback, stopElem, (lvl + 1)) === false) {
                return false;
            }
        } else if (nextSibling) {
            if (ViperUtil.walk(nextSibling, callback, stopElem, lvl) === false) {
                return false;
            }
        } else {
            while (parentNode && !parentNode.nextSibling) {
                parentNode = parentNode.parentNode;
                lvl--
            }

            if (!parentNode) {
                return false;
            }

            if (ViperUtil.walk(parentNode.nextSibling, callback, stopElem, (lvl - 1)) === false) {
                return false;
            }
        }//end if

    },

    /**
     * Set the textual information within a text node.
     *
     * @param {Text} The node to manipulate.
     * @param {String} Text value of the node.
     *
     * @return void
     * @type void
     */
    setNodeTextContent: function(node, txt)
    {
       return ViperUtil.$(node).text(txt);

    },

    /**
     * Implements inheritance for two classes.
     *
     * @param {funcPtr} child  The class that is inheriting the parent methods.
     * @param {funcPtr} parent The parent that is being implemented.
     *
     * @return void
     * @type   void
     */
    _inherited: {},
    inherits: function(child, parent)
    {
        if (ViperUtil._inherited[child + parent]) {
            return;
        }

        ViperUtil._inherited[child + parent] = true;

        if (parent instanceof String || typeof parent === 'string') {
            parent = window[parent];

        }

        if (child instanceof String || typeof child === 'string') {
            child = window[child];
        }

        var above = function(){};
        if (ViperUtil.isset(parent) === true) {
            for (value in parent.prototype) {
                // If the child method already exists, move this method to the parent
                // so it can be called using super.method().
                if (child.prototype[value]) {
                    above.prototype[value] = parent.prototype[value];
                    continue;
                }

                child.prototype[value] = parent.prototype[value];
            }
        }

        if (child.prototype) {
            above.prototype.constructor = parent;
            child.prototype['super']    = new above();
        }

    },

    isArray: function(v)
    {
        return ViperUtil.$.isArray(v);

    },

    /**
     * Return TRUE if the value exists in an array..
     *
     * @param {String}  needle        The item you are looking for.
     * @param {array}   haystack      The array to look through.
     * @param {boolean} typeSensitive Type sensitive comparison - default is true.
     *
     * @return {String}
     */
    inArray: function(needle, haystack, typeSensitive)
    {
        if (ViperUtil.isset(typeSensitive) === false) {
            typeSensitive = true;
        }

        var hln = haystack.length;
        for (var i = 0; i < hln; i++) {
            if ((typeSensitive === true && needle === haystack[i]) ||
                (typeSensitive === false && needle == haystack[i])
            ) {
                return true;
            }
        }

        return false;

    },

    /*
     * Searches the array for the given item.
     *
     * Returns the item index if found, else false.
     *
     * @param mixed needle   Item to search in the specified array.
     * @param array haystack The array.
     *
     * @return int
     */
    arraySearch: function(needle, haystack)
    {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] === needle) {
                return i;
            }
        }

        return -1;

    },

    removeArrayIndex: function(array, index)
    {
        if (!array || ViperUtil.isset(array[index]) === false) {
            return null;
        }

        return array.splice(index, 1);

    },

    /**
     * Computes the difference of two arrays.
     * If firstOnly is set to TRUE then only the elements that are in first array
     * but not in the second array will be returned.
     */
    arrayDiff: function(array1, array2, firstOnly)
    {
        var al  = array1.length;
        var res = [];
        for (var i = 0; i < al; i++) {
            if (ViperUtil.inArray(array1[i], array2) === false) {
                res.push(array1[i]);
            }
        }

        if (firstOnly !== true) {
            al = array2.length;
            for (var i = 0; i < al; i++) {
                if (ViperUtil.inArray(array2[i], array1) === false) {
                    res.push(array2[i]);
                }
            }
        }

        return res;

    },

    arrayIntersect: function(array1, array2)
    {
        var newArray = [];
        var n1c = array1.length;
        var n2c = array2.length;
        for (var i = 0; i < n1c; i++) {
            if (newArray.length === n2c) {
                break;
            }

            for (var j = 0; j < n2c; j++) {
                if (array1[i] === array2[j]) {
                    newArray.push(array1[i]);
                    break;
                }
            }
        }

        return newArray;

    },

    arrayUnique: function(array) {
        var tmp      = {};
        var newArray = [];
        var ln  = array.length;
        for (var i = 0; i < ln; i++) {
            if (tmp[array[i]] === true) {
                continue;
            }

            tmp[array[i]] = true;
            newArray.push(array[i]);
        }

        return newArray;

    },

    /**
     * returns an ellipsized string.
     *
     * @param {String} value The string to trim.
     *
     * @return {String}
     */
    ellipsize: function(value, length)
    {
        // Type validation.
        if (typeof value !== 'string' || typeof length !== 'number') {
            return '';
        }

        // Length needs to be at least zero.
        if (length < 0) {
            return '';
        }

        // If the string is not long enough, don't change it.
        if (value.length <= length) {
            return value;
        }

        value = value.substr(0, length);
        value = value.replace(/\s$/, '');

        // Figure out how many dots are on the end of the
        // string so we don't add too many.
        var end       = value.substr((length - 3), 3);
        var endNoDots = end.replace(/\.$/, '');
        var numDots   = (end.length - endNoDots.length);

        value = value + ViperUtil.strRepeat('.', (3 - numDots));
        return value;

    },

    strRepeat: function(str, multiplier)
    {
        var rstr = '';
        for (var i = 0; i < multiplier; i++) {
            rstr += str;
        }

        return rstr;

    },

    stripTags: function(content, allowedTags)
    {
        var match;
        var re      = new RegExp(/<\/?(\w+)((\s+\w+(\s*=\s*(?:".*?"|'.*?'|[^'">\s]+))?)+\s*|\s*)\/?>/gim);
        var resCont = content;
        while ((match = re.exec(content)) != null) {
            if (ViperUtil.isset(allowedTags) === false || ViperUtil.inArray(match[1], allowedTags) !== true) {
                resCont = resCont.replace(match[0], '');
            }
        }

        return resCont;

    },

    commonEntitiesArray: {
        160: '&nbsp;',     // space
        168: '&uml;',      //  ¨
        169: '&copy;',     //  ©
        170: '&ordf;',     //  ª
        171: '&laquo;',    //  «
        172: '&not;',      //  ¬
        173: '&shy;',      //  ­
        174: '&reg;',      //  ®
        175: '&macr;',     //  ¯
        176: '&deg;',      //  °
        177: '&plusmn;',   //  ±
        178: '&sup2;',     //  ²
        179: '&sup3;',     //  ³
        180: '&acute;',    //  ´
        181: '&micro;',    //  µ
        182: '&para;',     //  ¶
        183: '&middot;',   //  ·
        184: '&cedil;',    //  ¸
        185: '&sup1;',     //  ¹
        186: '&ordm;',     //  º
        187: '&raquo;',    //  »
        188: '&frac14;',   //  ¼
        189: '&frac12;',   //  ½
        190: '&frac34;',   //  ¾
        191: '&iquest;',   //  ¿
        215: '&times;',    //  ×
        247: '&divide;',   //  ÷
        977: '&thetasym;', //  ϑ
        978: '&upsih;',    //  ϒ
        982: '&piv;',      //  ϖ
        8216: '&lsquo;',   //  ‘
        8217: '&rsquo;',   //  ’
        8218: '&sbquo;',   //  ‚
        8220: '&ldquo;',   //  “
        8221: '&rdquo;',   //  ”
        8222: '&bdquo;',   //  „
        8223: '&ldquo;',   //  “
        8226: '&bull;',    //  *
        8230: '&hellip;',  //  …
        8242: '&prime;',   //  ′
        8243: '&Prime;',   //  ″
        8254: '&oline;',   //  ‾
        8260: '&frasl;',   //  ⁄
        8472: '&weierp;',  //  ℘
        8465: '&image;',   //  ℑ
        8476: '&real;',    //  ℜ
        8482: '&trade;',   //  ™
        8501: '&alefsym;', //  ℵ
        8592: '&larr;',    //  ←
        8593: '&uarr;',    //  ↑
        8594: '&rarr;',    //  →
        8595: '&darr;',    //  ↓
        8596: '&harr;',    //  ↔
        8629: '&crarr;',   //  ↵
        8656: '&lArr;',    //  ⇐
        8657: '&uArr;',    //  ⇑
        8658: '&rArr;',    //  ⇒
        8659: '&dArr;',    //  ⇓
        8660: '&hArr;',    //  ⇔
        8704: '&forall;',  //  ∀
        8706: '&part;',    //  ∂
        8707: '&exist;',   //  ∃
        8709: '&empty;',   //  ∅
        8711: '&nabla;',   //  ∇
        8712: '&isin;',    //  ∈
        8713: '&notin;',   //  ∉
        8715: '&ni;',      //  ∋
        8719: '&prod;',    //  ∏
        8721: '&sum;',     //  ∑
        8722: '&minus;',   //  −
        8727: '&lowast;',  //  ∗
        8730: '&radic;',   //  √
        8733: '&prop;',    //  ∝
        8734: '&infin;',   //  ∞
        8736: '&ang;',     //  ∠
        8743: '&and;',     //  ∧
        8744: '&or;',      //  ∨
        8745: '&cap;',     //  ∩
        8746: '&cup;',     //  ∪
        8747: '&int;',     //  ∫
        8756: '&there4;',  //  ∴
        8764: '&sim;',     //  ∼
        8773: '&cong;',    //  ≅
        8776: '&asymp;',   //  ≈
        8800: '&ne;',      //  ≠
        8801: '&equiv;',   //  ≡
        8804: '&le;',      //  ≤
        8805: '&ge;',      //  ≥
        8834: '&sub;',     //  ⊂
        8835: '&sup;',     //  ⊃
        8836: '&nsub;',    //  ⊄
        8838: '&sube;',    //  ⊆
        8839: '&supe;',    //  ⊇
        8853: '&oplus;',   //  ⊕
        8855: '&otimes;',  //  ⊗
        8869: '&perp;',    //  ⊥
        8901: '&sdot;',    //  ⋅
        8968: '&lceil;',   //  ⌈
        8969: '&rceil;',   //  ⌉
        8970: '&lfloor;',  //  ⌊
        8971: '&rfloor;',  //  ⌋
        9001: '&lang;',    //  ⟨
        9002: '&rang;',    //  ⟩
        9674: '&loz;',     //  ◊
        9824: '&spades;',  //  ♠
        9827: '&clubs;',   //  ♣
        9829: '&hearts;',  //  ♥
        9830: '&diams;'    //  ♦
    },

    alphabetEntitiesArray: {
        161: '&iexcl;',    //  ¡
        162: '&cent;',     //  ¢
        163: '&pound;',    //  £
        164: '&curren;',   //  ¤
        165: '&yen;',      //  ¥
        166: '&brvbar;',   //  ¦
        167: '&sect;',     //  §
        192: '&Agrave;',   //  À
        193: '&Aacute;',   //  Á
        194: '&Acirc;',    //  Â
        195: '&Atilde;',   //  Ã
        196: '&Auml;',     //  Ä
        197: '&Aring;',    //  Å
        198: '&AElig;',    //  Æ
        199: '&Ccedil;',   //  Ç
        200: '&Egrave;',   //  È
        201: '&Eacute;',   //  É
        202: '&Ecirc;',    //  Ê
        203: '&Euml;',     //  Ë
        204: '&Igrave;',   //  Ì
        205: '&Iacute;',   //  Í
        206: '&Icirc;',    //  Î
        207: '&Iuml;',     //  Ï
        208: '&ETH;',      //  Ð
        209: '&Ntilde;',   //  Ñ
        210: '&Ograve;',   //  Ò
        211: '&Oacute;',   //  Ó
        212: '&Ocirc;',    //  Ô
        213: '&Otilde;',   //  Õ
        214: '&Ouml;',     //  Ö
        216: '&Oslash;',   //  Ø
        217: '&Ugrave;',   //  Ù
        218: '&Uacute;',   //  Ú
        219: '&Ucirc;',    //  Û
        220: '&Uuml;',     //  Ü
        221: '&Yacute;',   //  Ý
        222: '&THORN;',    //  Þ
        223: '&szlig;',    //  ß
        224: '&agrave;',   //  à
        225: '&aacute;',   //  á
        226: '&acirc;',    //  â
        227: '&atilde;',   //  ã
        228: '&auml;',     //  ä
        229: '&aring;',    //  å
        230: '&aelig;',    //  æ
        231: '&ccedil;',   //  ç
        232: '&egrave;',   //  è
        233: '&eacute;',   //  é
        234: '&ecirc;',    //  ê
        235: '&euml;',     //  ë
        236: '&igrave;',   //  ì
        237: '&iacute;',   //  í
        238: '&icirc;',    //  î
        239: '&iuml;',     //  ï
        240: '&eth;',      //  ð
        241: '&ntilde;',   //  ñ
        242: '&ograve;',   //  ò
        243: '&oacute;',   //  ó
        244: '&ocirc;',    //  ô
        245: '&otilde;',   //  õ
        246: '&ouml;',     //  ö
        248: '&oslash;',   //  ø
        249: '&ugrave;',   //  ù
        250: '&uacute;',   //  ú
        251: '&ucirc;',    //  û
        252: '&uuml;',     //  ü
        253: '&yacute;',   //  ý
        254: '&thorn;',    //  þ
        255: '&yuml;',     //  ÿ
        402: '&fnof;',     //  ƒ
        913: '&Alpha;',    //  Α
        914: '&Beta;',     //  Β
        915: '&Gamma;',    //  Γ
        916: '&Delta;',    //  Δ
        917: '&Epsilon;',  //  Ε
        918: '&Zeta;',     //  Ζ
        919: '&Eta;',      //  Η
        920: '&Theta;',    //  Θ
        921: '&Iota;',     //  Ι
        922: '&Kappa;',    //  Κ
        923: '&Lambda;',   //  Λ
        924: '&Mu;',       //  Μ
        925: '&Nu;',       //  Ν
        926: '&Xi;',       //  Ξ
        927: '&Omicron;',  //  Ο
        928: '&Pi;',       //  Π
        929: '&Rho;',      //  Ρ
        931: '&Sigma;',    //  Σ
        932: '&Tau;',      //  Τ
        933: '&Upsilon;',  //  Υ
        934: '&Phi;',      //  Φ
        935: '&Chi;',      //  Χ
        936: '&Psi;',      //  Ψ
        937: '&Omega;',    //  Ω
        945: '&alpha;',    //  α
        946: '&beta;',     //  β
        947: '&gamma;',    //  γ
        948: '&delta;',    //  δ
        949: '&epsilon;',  //  ε
        950: '&zeta;',     //  ζ
        951: '&eta;',      //  η
        952: '&theta;',    //  θ
        953: '&iota;',     //  ι
        954: '&kappa;',    //  κ
        955: '&lambda;',   //  λ
        956: '&mu;',       //  μ
        957: '&nu;',       //  ν
        958: '&xi;',       //  ξ
        959: '&omicron;',  //  ο
        960: '&pi;',       //  π
        961: '&rho;',      //  ρ
        962: '&sigmaf;',   //  ς
        963: '&sigma;',    //  σ
        964: '&tau;',      //  τ
        965: '&upsilon;',  //  υ
        966: '&phi;',      //  φ
        967: '&chi;',      //  χ
        968: '&psi;',      //  ψ
        969: '&omega;'    //  ω
    },

    replaceNamedEntities: function(html)
    {
        var newHtml = '';
        var ln      = html.length;
        for (i = 0; i < ln; i++) {
            code = html.charCodeAt(i);
            if (code > 127) {
                var entity = ViperUtil.commonEntitiesArray[code];
                if (!entity) {
                    entity = ViperUtil.alphabetEntitiesArray[code];
                }

                if (entity) {
                    newHtml += entity;
                } else {
                    newHtml += html.charAt(i);
                }
            } else {
                newHtml += html.charAt(i);
            }
        }

        return newHtml;

    },

    /**
     * Does not replace currency symbols, and alphabet symbols.
     */
    replaceCommonNamedEntities: function(html)
    {
        var newHtml = '';
        var ln      = html.length;
        for (i = 0; i < ln; i++) {
            code = html.charCodeAt(i);
            if (code > 127) {
                var entity = ViperUtil.commonEntitiesArray[code];
                if (entity) {
                    newHtml += entity;
                } else {
                    newHtml += html.charAt(i);
                }
            } else {
                newHtml += html.charAt(i);
            }
        }

        return newHtml;

    },

    getTextNodes: function(parent, removeEmpty)
    {
        var nodes = [];

        if (ViperUtil.isBrowser('msie') === false) {
            var walk  = document.createTreeWalker(parent, NodeFilter.SHOW_TEXT)
            while (node = walk.nextNode()) {
                nodes.push(node);
            }
        } else {
            if (parent && parent.childNodes) {
                var ln = parent.childNodes.length;
                for (var i = 0; i < ln; i++) {
                    var child = parent.childNodes[i];
                    if (child.nodeType === ViperUtil.TEXT_NODE) {
                        if (removeEmpty === true && /^\s*$/.test(child.data) === true) {
                            ViperUtil.remove(child);
                        } else {
                            nodes.push(child);
                        }
                    } else if (child.childNodes && child.childNodes.length > 0) {
                        nodes = nodes.concat(ViperUtil.getTextNodes(child));
                    }
                }
            }
        }

        return nodes;

    },

    getCommonAncestor: function(a, b)
    {
        var node = a;
        while (node) {
            if (ViperUtil.isChildOf(b, node) === true) {
                return node;
            }

            node = node.parentNode;
        }

        return null;

    },

    clone: function(value, shallow)
    {
        if (typeof value !== 'object') {
            return value;
        }

        if (value === null) {
            var valueClone = null;
        } else {
            var valueClone = new value.constructor();
            for (var property in value) {
                if (shallow) {
                    valueClone[property] = value[property];
                }

                if (value[property] === null) {
                    valueClone[property] = null;
                } else if (typeof value[property] === 'object') {
                    valueClone[property] = ViperUtil.clone(value[property], shallow);
                } else {
                    valueClone[property] = value[property];
                }
            }
        }

        return valueClone;

    },

    /**
     * Adds given (var => value) list to the given URLs query string.
     */
    addToQueryString: function(url, addQueries)
    {
        var mergedUrl        = '';
        var baseUrl          = ViperUtil.baseUrl(url);
        var queryStringArray = ViperUtil.queryString(url);
        mergedQry = ViperUtil.objectMerge(queryStringArray, addQueries);

        var queryStr = '?';
        ViperUtil.foreach(mergedQry, function(key) {
                queryStr = queryStr + key + '=' + mergedQry[key] + '&';
            });

        // More than just a ? to add to the URL?
        if (queryStr.length > 1) {
            // Put the URL together with qry str and take off the trailing &.
            mergedUrl = baseUrl + queryStr.substr(0, (queryStr.length - 1));
        } else {
            mergedUrl = url;
        }

        var anchorPartURL = ViperUtil.getURLAnchor(url);
        if (anchorPartURL.length > 0) {
            mergedUrl = mergedUrl + anchorPartURL;
        }

        return mergedUrl;

    },

    /**
     * Return key value pairs from the given query string.
     */
    queryString: function(url)
    {
        var result    = {};
        var qStartIdx = url.search(/\?/);
        if (qStartIdx === -1) {
            return result;
        } else {
            var aStartIdx = url.search(/\#/);
            if (aStartIdx === -1) {
                var anchorPartAdj = 0;
            } else {
                var anchorPartAdj = (url.length - aStartIdx + 1);
            }

            // QryStr part is between ? and # in the URL.
            var queryStr = url.substr((qStartIdx + 1), (url.length - qStartIdx - anchorPartAdj));
            if (queryStr.length > 0) {
                var pairs = queryStr.split('&');
                var len   = pairs.length;
                var pair  = [];
                for (var i = 0; i < len; i++) {
                    // Is it a valid key value pair?
                    if (pairs[i].search('=') !== -1) {
                        pair            = pairs[i].split('=');
                        result[pair[0]] = pair[1];
                    }
                }

                return result;
            } else {
                return result;
            }
        }//end if

    },

    /**
     * Returns the anchor part of the URL.  Blank if no # or
     * hash followed by the actual anchor name
     */
    getURLAnchor: function(url)
    {
        if (typeof url === 'string') {
            var aStartIdx = url.search(/\#/);
            if (aStartIdx === -1) {
                url = '';
            } else {
                url = url.substr(aStartIdx, (url.length - aStartIdx));
            }
        }

        return url;

    },

    baseUrl: function(fullUrl)
    {
        var qStartIdx = fullUrl.search(/\?|#/);
        if (qStartIdx === -1) {
            return fullUrl;
        } else {
            var baseUrl = fullUrl.substr(0, qStartIdx);
            return baseUrl;
        }

    },

    objectMerge: function (ob1, ob2)
    {
        ViperUtil.foreach(ob2, function(key) {
            ob1[key] = ob2[key];
            return true;
        });

        return ob1;

    },

    /**
     * Converts a property like background-color to backgroundColor.
     *
     * @param {String} property The string to convert.
     *
     * @return The converted string.
     * @type   string
     */
    camelCase: function(property)
    {
        // Regular expression to find the next hyphen followed by a letter and to
        // seperate the letter in the results.
        var hyphenTest = /-([a-z])/;
        // While there is a hyphen in the string (reg.test == true) replace it with
        // its' trailing letter uppercased.
        while (hyphenTest.test(property) == true) {
            property = property.replace(hyphenTest, RegExp.$1.toUpperCase());
        }

        return property;

    },

    /**
     * Returns the current browser type.
     *
     * @return {string}
     */
    getBrowserType: function()
    {
        if (ViperUtil._browserType === null) {
            var tests = ['trident', 'msie', 'firefox', 'chrome', 'safari'];
            var tln   = tests.length;
            for (var i = 0; i < tln; i++) {
                var r = new RegExp(tests[i], 'i');
                if (r.test(navigator.userAgent) === true) {
                    if (tests[i] === 'trident') {
                        // No MSIE token for IE11+.
                        ViperUtil._browserType = 'msie';
                    } else {
                        ViperUtil._browserType = tests[i];
                    }
                    return ViperUtil._browserType;
                }
            }

            ViperUtil._browserType = 'other';
        }

        return ViperUtil._browserType;

    },

    /**
     * Returns the version of the current browser.
     *
     * @return {integer}
     */
    getBrowserVersion: function()
    {
        if (ViperUtil._browserVersion !== null) {
            return ViperUtil._browserVersion;
        }

        var browsers = ['MSIE', 'Trident', 'Chrome', 'Safari', 'Firefox'];
        var c        = browsers.length;
        var uAgent   = navigator.userAgent;

        var browserName = null;
        for (var i = 0; i < c; i++) {
            var nameIndex = uAgent.indexOf(browsers[i]);
            if (nameIndex >= 0) {
                browserName = browsers[i];
                break;
            }
        }

        if (!browserName) {
            return null;
        }

        if (browserName === 'Safari') {
            browserName = 'Version';
        }

        var re = null;
        if (browserName === 'MSIE') {
            re = new RegExp('MSIE (\\d+)');
        } else if (browserName === 'Trident') {
            re = new RegExp('rv:(\\d+)');
        } else {
            re = new RegExp(browserName + '/(\\d+)');
        }

        var matches = re.exec(uAgent);
        if (!matches) {
            return null;
        }

        ViperUtil._browserVersion = parseInt(matches[1]);
        return ViperUtil._browserVersion;

    },

    /**
     * Checks if specified browser type is the current browser.
     *
     * @param {string}  browser The browser type to test.
     * @param {string}  version The version of the browser. Example formats: 23, <10, >=11.
     *
     * @return {boolean}
     */
    isBrowser: function(browser, version)
    {
        if (ViperUtil.getBrowserType() !== browser) {
            return false;
        } else if (!version) {
            return true;
        }

        version        = version.toString();
        var currentVer = ViperUtil.getBrowserVersion().toString();
        if (version === currentVer) {
            return true;
        }

        var match = version.match(/^(<=|>=|<|>)([\d\.]+$)/);
        if (!match) {
            return false;
        }

        version = parseFloat(match[2]);
        switch (match[1]) {
            case '<=':
                return (currentVer <= version);

            case '>=':
                return (currentVer >= version);

            case '<':
                return (currentVer < version);

            case '>':
                return (currentVer > version);

            default:
                return false;
        }

        return false;

    },

    getOS: function()
    {
        var platform = navigator.platform.toLowerCase();
        if (platform.indexOf('win') === 0) {
            return 'windows';
        } else if (platform.indexOf('mac') === 0) {
            return 'mac';
        } else if (platform.indexOf('linux') === 0) {
            return 'linux';
        }

        return platform;

    },

    isOS: function(os)
    {
        if (this.getOS() === os) {
            return true;
        }

        return false;

    },

    /**
     * Clones given node and its children.
     */
    cloneNode: function(node)
    {
        // Clone the element so we dont modify the actual contents.
        var clone = null;
        if (ViperUtil.isBrowser('msie', '8') === true && node.nodeType !== ViperUtil.TEXT_NODE) {
            // This is to resolve the HTML5 element cloning issue in IE8.
            var clone = document.createElement('div');
            ViperUtil.setHtml(clone, ViperUtil.trim(node.outerHTML));
            clone = clone.firstChild;
        } else {
            clone = node.cloneNode(true);
        }

        return clone;

    },

    /**
     * Starts debugging after specified calls to this method.
     */
    dcall: function(c)
    {
        if (!ViperUtil._dcall) {
            ViperUtil._dcall = 0;
        }

        ViperUtil._dcall++;

        if (c === ViperUtil._dcall) {
            debugger;
        }

        console.info(ViperUtil._dcall);
    }

};

if (!window.console) {
    window.console = {
        info: function(){},
        error: function(){}
    }
};

/*
 HTML5 Shiv v3.7.0 | @afarkas @jdalton @jon_neal @rem | MIT/GPL2 Licensed
*/
(function(j,f){function s(a,b){var c=a.createElement("p"),m=a.getElementsByTagName("head")[0]||a.documentElement;c.innerHTML="x<style>"+b+"</style>";return m.insertBefore(c.lastChild,m.firstChild)}function o(){var a=d.elements;return"string"==typeof a?a.split(" "):a}function n(a){var b=t[a[u]];b||(b={},p++,a[u]=p,t[p]=b);return b}function v(a,b,c){b||(b=f);if(e)return b.createElement(a);c||(c=n(b));b=c.cache[a]?c.cache[a].cloneNode():y.test(a)?(c.cache[a]=c.createElem(a)).cloneNode():c.createElem(a);
return b.canHaveChildren&&!z.test(a)?c.frag.appendChild(b):b}function A(a,b){if(!b.cache)b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag();a.createElement=function(c){return!d.shivMethods?b.createElem(c):v(c,a,b)};a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+o().join().replace(/\w+/g,function(a){b.createElem(a);b.frag.createElement(a);return'c("'+a+'")'})+");return n}")(d,b.frag)}
function w(a){a||(a=f);var b=n(a);if(d.shivCSS&&!q&&!b.hasCSS)b.hasCSS=!!s(a,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}");e||A(a,b);return a}function B(a){for(var b,c=a.attributes,m=c.length,f=a.ownerDocument.createElement(l+":"+a.nodeName);m--;)b=c[m],b.specified&&f.setAttribute(b.nodeName,b.nodeValue);f.style.cssText=a.style.cssText;return f}function x(a){function b(){clearTimeout(d._removeSheetTimer);
c&&c.removeNode(!0);c=null}var c,f,d=n(a),e=a.namespaces,j=a.parentWindow;if(!C||a.printShived)return a;"undefined"==typeof e[l]&&e.add(l);j.attachEvent("onbeforeprint",function(){b();var g,i,d;d=a.styleSheets;for(var e=[],h=d.length,k=Array(h);h--;)k[h]=d[h];for(;d=k.pop();)if(!d.disabled&&D.test(d.media)){try{g=d.imports,i=g.length}catch(j){i=0}for(h=0;h<i;h++)k.push(g[h]);try{e.push(d.cssText)}catch(n){}}g=e.reverse().join("").split("{");i=g.length;h=RegExp("(^|[\\s,>+~])("+o().join("|")+")(?=[[\\s,>+~#.:]|$)",
"gi");for(k="$1"+l+"\\:$2";i--;)e=g[i]=g[i].split("}"),e[e.length-1]=e[e.length-1].replace(h,k),g[i]=e.join("}");e=g.join("{");i=a.getElementsByTagName("*");h=i.length;k=RegExp("^(?:"+o().join("|")+")$","i");for(d=[];h--;)g=i[h],k.test(g.nodeName)&&d.push(g.applyElement(B(g)));f=d;c=s(a,e)});j.attachEvent("onafterprint",function(){for(var a=f,c=a.length;c--;)a[c].removeNode();clearTimeout(d._removeSheetTimer);d._removeSheetTimer=setTimeout(b,500)});a.printShived=!0;return a}var r=j.html5||{},z=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,
y=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,q,u="_html5shiv",p=0,t={},e;(function(){try{var a=f.createElement("a");a.innerHTML="<xyz></xyz>";q="hidden"in a;var b;if(!(b=1==a.childNodes.length)){f.createElement("a");var c=f.createDocumentFragment();b="undefined"==typeof c.cloneNode||"undefined"==typeof c.createDocumentFragment||"undefined"==typeof c.createElement}e=b}catch(d){e=q=!0}})();var d={elements:r.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video",
version:"3.7.0",shivCSS:!1!==r.shivCSS,supportsUnknownElements:e,shivMethods:!1!==r.shivMethods,type:"default",shivDocument:w,createElement:v,createDocumentFragment:function(a,b){a||(a=f);if(e)return a.createDocumentFragment();for(var b=b||n(a),c=b.frag.cloneNode(),d=0,j=o(),l=j.length;d<l;d++)c.createElement(j[d]);return c}};j.html5=d;w(f);var D=/^$|\b(?:all|print)\b/,l="html5shiv",C=!e&&function(){var a=f.documentElement;return!("undefined"==typeof f.namespaces||"undefined"==typeof f.parentWindow||
"undefined"==typeof a.applyElement||"undefined"==typeof a.removeNode||"undefined"==typeof j.attachEvent)}();d.type+=" print";d.shivPrint=x;x(f)})(this,document);
