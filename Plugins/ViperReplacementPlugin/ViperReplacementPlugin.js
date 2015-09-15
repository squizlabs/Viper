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
function ViperReplacementPlugin(viper)
{
    this.viper = viper;

    this._searchPattern       = null;
    this._replacementsCallback = null;

    this._cache = {};

}

ViperReplacementPlugin.prototype = {

    setSettings: function (settings) {
        if (settings.callback) {
            this.setReplacementsCallback(settings.callback);
        }

        if (settings.pattern) {
            this.setSearchPattern(settings.pattern);
        }

        var self = this;
        this.showReplacements(
            null,
            function () {
                self.viper.getHistoryManager().clear();
                self.viper.getHistoryManager().add();
            }
        );
    },

    isSpecialElement: function(element) {
        if (ViperUtil.hasAttribute(element, 'data-viper-keyword') === true) {
            return true;
        }

        return false;
    },

    init: function () {
        var self = this;

        this.viper.registerCallback('Viper:editableElementChanged', 'ViperReplacementPlugin', function() {
            self.viper.getHistoryManager().clear();
            self.showReplacements(
                null,
                function () {
                    self.viper.getHistoryManager().add();
                }
            );
        });

        this.viper.registerCallback('Viper:getHtml', 'ViperReplacementPlugin', function(data) {
            self.showKeywords(data.element);
        });

        this.viper.registerCallback('Viper:setHtml', 'ViperReplacementPlugin', function(data, callback) {
            self.showReplacements(data.element, callback);
            return function() {};
        });

        this.viper.registerCallback('Viper:setHtmlContent', 'ViperReplacementPlugin', function(content, callback) {
            self.showAttributeReplacements(content, function(cont) {
                callback.call(this, cont);
            });

            return function() {};
        });

        // Shift, Control, Alt, Caps lock, esc, L-CMD, R-CMD, arrow keys.
        var ignoredKeys = [16, 17, 18, 20, 27, 91, 93, 37, 38, 39, 40, 224];
        this.viper.registerCallback('Viper:keyDown', 'ViperReplacementPlugin', function(e) {
            switch (e.which) {
                default:
                    if (ViperUtil.inArray(e.which, ignoredKeys) === true) {
                        return;
                    } else if ((e.which === 88 || e.which === 67) && (e.metaKey === true || e.ctrlKey === true)) {
                        // Copy/Cut operation.
                        return;
                    }

                    var range     = self.viper.getViperRange();
                    var startNode = range.getStartNode();
                    var selNode   = range.getNodeSelection();

                    if (startNode && startNode.nodeType === ViperUtil.TEXT_NODE) {
                        // Check if the caret is inside a keyword element.
                        var rep = self._getKeywordElement(startNode);
                        if (!rep) {
                            if (range.startOffset === 0) {
                                // Range is at the start of a text node so check if the previous container is a keyword
                                // element.
                                rep = self._getKeywordElement(range.getPreviousContainer(startNode, null, false, false, true));
                                if (rep) {
                                    if (e.which === ViperUtil.DOM_VK_BACKSPACE || e.which === ViperUtil.DOM_VK_DELETE) {
                                        // This is a backspace. Need to remove the keyword element and prevent default
                                        // action so mo.
                                        var elem = ViperUtil.getTopSurroundingParent(rep) || rep;
                                        ViperUtil.remove(elem);
                                        self.viper.fireSelectionChanged(null, true);
                                        self.viper.fireNodesChanged();
                                        return false;
                                    }

                                    // Add a space between the keyword element and the caret container.
                                    if (startNode.data[0] === ' ') {
                                        // The first character of this text node is a space so we need to add non breaking
                                        // space.
                                        startNode.data = String.fromCharCode(160) + startNode.data;
                                    } else if (startNode.data.length === 0) {
                                        startNode.data = String.fromCharCode(160);
                                    } else {
                                        startNode.data = ' ' + startNode.data;
                                    }

                                    // When the keyDown executes insert the character after the first space character.
                                    range.setStart(startNode, 1);
                                    range.collapse(true);
                                    ViperSelection.addRange(range);
                                } else {
                                    rep = self._getKeywordElement(range.getNextContainer(startNode, null, false, false, true));
                                    if (rep) {
                                        if (e.which === ViperUtil.DOM_VK_BACKSPACE || e.which === ViperUtil.DOM_VK_DELETE) {
                                            // This is a backspace. Need to remove the keyword element and prevent default
                                            // action so mo.
                                            var elem = ViperUtil.getTopSurroundingParent(rep) || rep;
                                            ViperUtil.remove(elem);
                                            self.viper.fireSelectionChanged(null, true);
                                            return false;
                                        }

                                        if (startNode.data[0] === ' ') {
                                            // The first character of this text node is a space so we need to add non breaking
                                            // space.
                                            startNode.data = String.fromCharCode(160) + startNode.data;
                                        } else if (startNode.data.length === 0) {
                                            startNode.data = String.fromCharCode(160);
                                        } else {
                                            startNode.data = ' ' + startNode.data;
                                        }

                                        range.setStart(startNode, 0);
                                        range.collapse(true);
                                        ViperSelection.addRange(range);

                                        setTimeout(
                                            function () {
                                                startNode.data = ViperUtil.rtrim(startNode.data);
                                                range.setStart(startNode, 1);
                                                range.collapse(true);
                                                ViperSelection.addRange(range);
                                            },
                                            2
                                        )
                                    }
                                }
                                return;
                            }//end if

                            if (!rep) {
                                return;
                            }
                        }
                    } else {
                        rep = self._getKeywordElement(selNode);
                    }

                    if (selNode === rep) {
                        // Whole keyword element is selected. Remove it and its surrounding parents.
                        var parents  = ViperUtil.getSurroundingParents(selNode);
                        if (parents.length > 0) {
                            selNode = parents.pop();
                        }

                        // When there are text siblings its better to join them.
                        var info = self._normaliseTextNodeSiblings(selNode);
                        if (info) {
                            range.setStart(info.textNode, info.splitOffset);
                        } else {
                            var cont = range.getPreviousContainer(selNode, null, false, false, true);
                            if (!cont) {
                                cont = range.getNextContainer(selNode, null, false, false, true);
                                if (!cont) {
                                    cont = document.createTextNode('');
                                    ViperUtil.insertBefore(selNode, cont);
                                } else {
                                    self._trimExtraSpaceFromStart(cont, true);
                                }

                                range.setStart(cont, 0);
                            } else {
                                self._trimExtraSpaceFromEnd(cont, true);
                                range.setStart(cont, cont.data.length);
                            }
                        }

                        range.collapse(true);
                        ViperSelection.addRange(range);
                        ViperUtil.remove(selNode);
                        return;
                    }

                break;
            }
        });

        this.viper.registerCallback('Viper:selectionChanged', 'ViperReplacementPlugin', function(range) {
            var start        = range.getStartNode();
            var end          = range.getEndNode();
            var startKeyword = self._getKeywordElement(start);
            var endKeyword   = self._getKeywordElement(end);

            if (startKeyword !== false && startKeyword === endKeyword) {
                // Now check if the range is at the start or end of the keyword.
                if (range.collapsed === true && start.nodeType === ViperUtil.TEXT_NODE) {
                    if (range.startOffset === start.data.length) {
                        // At the end.
                        var textNode = document.createTextNode('');
                        ViperUtil.insertAfter(startKeyword, textNode);
                        range.setStart(textNode, 0);
                        range.collapse(true);
                        ViperSelection.addRange(range);
                        return;

                    } else if (range.startOffset === 0) {
                        // At the start.
                        // TODO: Check surrounding parents?
                        var textNode = document.createTextNode('');
                        ViperUtil.insertBefore(startKeyword, textNode);
                        range.setStart(textNode, 0);
                        range.collapse(true);
                        ViperSelection.addRange(range);
                        return;
                    }
                }

                range.selectNode(startKeyword);
                ViperSelection.addRange(range);
            }

        });

        this.viper.registerCallback('Viper:attributeRemoved', 'ViperReplacementPlugin', function(data) {
            // If the removed attribute has a replacement backup attribute remove that too.
            var cloneName = 'data-viper-' + data.attribute;
            if (ViperUtil.hasAttribute(data.element, cloneName) === true) {
                ViperUtil.removeAttr(data.element, cloneName);
            }
        });

        this.viper.addAttributeGetModifier(
            function (element, attribute, value) {
                // Check if the element has a keyword attribute.
                value = element.getAttribute('data-viper-' + attribute) || value;
                return value;
            }
        );

        this.viper.addAttributeSetModifier(
            function (element, attribute, value, callback) {
                // If the value has keyword it needs to be handled.
                var regex = new RegExp(self.getReplacementRegex(), 'gi');
                var matches = value.match(regex);
                if (matches !== null) {
                    var keywords = {};
                    var match    = null;
                    while (match = matches.pop()) {
                        keywords[match] = '';
                    }

                    self.getKeywordReplacements(
                        keywords,
                        function(replacements) {
                            for (var keyword in keywords) {
                                self._replaceAttributeKeyword(element, attribute, keyword, replacements[keyword], value, true);
                            }

                            callback.call(this);
                        }
                    );

                    return false;
                } else {
                    // No keywords.. If there is a attribute backup, remove it.
                    var cloneName = 'data-viper-' + attribute;
                    if (ViperUtil.hasAttribute(element, cloneName) === true) {
                        ViperUtil.removeAttr(element, cloneName);
                    }
                }

                return value;
            }
        );

    },

    _trimExtraSpaceFromStart: function(textNode, useNbsp)
    {
        var fromIdx = -1;
        for (var i = 0; i < textNode.data.length; i++) {
            if (textNode.data[i] === ' ') {
                fromIdx = i;
            } else {
                break;
            }
        }

        if (useNbsp === true && fromIdx >= 0) {
            textNode.data = String.fromCharCode(160) + textNode.data.substr(fromIdx + 1);
        } else if (fromIdx > 0) {
            textNode.data = textNode.data.substr(fromIdx);
        }

    },

    _trimExtraSpaceFromEnd: function(textNode, useNbsp)
    {
        var fromIdx = -1;
        for (var i = (textNode.data.length - 1); i >= 0 ; i--) {
            var c = textNode.data[i];
            if (c === ' ') {
                fromIdx = i;
            } else {
                break;
            }
        }

        if (useNbsp === true && fromIdx >= 0) {
            textNode.data = textNode.data.substr(0, fromIdx) + String.fromCharCode(160);
        } else if (fromIdx > 0) {
            textNode.data = textNode.data.substr(0, fromIdx);
        }

    },

    _normaliseTextNodeSiblings: function (element)
    {
        var prevCont = element.previousSibling;
        var nextCont = element.nextSibling;
        var info     = null;

        if (prevCont
            && nextCont
            && prevCont.nodeType === ViperUtil.TEXT_NODE
            && nextCont.nodeType === ViperUtil.TEXT_NODE
        ) {
            // Both siblings
            info = {
                splitOffset: prevCont.data.length,
                textNode: prevCont
            };

            if (nextCont.data[0] === ' ' && prevCont.data[(prevCont.data.length - 1)] === ' ') {
                nextCont.data = String.fromCharCode(160) + nextCont.data.substr(1);
            }

            prevCont.data += nextCont.data;
        }

        return info;

    },

    _fixRange: function (range, keywordElem, start) {
        if (start === true) {
            // Start of range is in keyword.. Move it after keyword.
            var cont = range.getPreviousContainer(keywordElem);
            range.setEnd(cont, cont.data.length);
        } else {
            var cont = range.getNextContainer(keywordElem);
            range.setStart(cont, 0);
            range.collapse(true);
        }

        return range;

    },

    _getKeywordElement: function (elem) {
        if (!elem) {
            return false;
        }

        if (ViperUtil.hasAttribute(elem, 'data-viper-keyword') === true) {
            return elem;
        }

        var viperElement = this.viper.getViperElement();
        while (elem.parentNode && elem.parentNode !== viperElement) {
            elem = elem.parentNode;
            if (ViperUtil.hasAttribute(elem, 'data-viper-keyword') === true
                || ViperUtil.attr(elem, 'data-viper-attribite-keywords') === 'true'
            ) {
                return elem;
            }
        }

        return false;

    },

    setReplacementsCallback: function (callback) {
        this._replacementsCallback = callback;

    },

    setSearchPattern: function (regexStr) {
        this._searchPattern = regexStr;

    },

    getReplacementRegex: function() {
        return this._searchPattern;

    },

    getReplacementsCallback: function () {
        return this._replacementsCallback;
    },

    /**
     * Replaceses all the keywords in the content with their replacements.
     */
    showReplacements: function (element, callback) {
        element = element || this.viper.getViperElement();

        // Get all the keywords in the element.
        var keywords = this.scanKeywords(element);
        if (!keywords || ViperUtil.isEmpty(keywords) === true) {
            if (callback) {
                callback.call(self);
            }

            return;
        }

        // Get the keyword replacements.
        var self = this;
        this.getKeywordReplacements(
            keywords,
            function(replacements) {
                // Convert the keywords inside the text nodes.
                self._convertContentKeywords(replacements);

                // Convert the keywords inside the attributes.
                var content = ViperUtil.getHtml(element);
                content     = self._convertAttributeKeywords(content, replacements);
                ViperUtil.setHtml(element, content);

                if (callback) {
                    callback.call(self);
                }
            }
        );

    },

    showAttributeReplacements: function(content, callback) {
        var keywords = {};
        this._scanAttributeKeywords(content, keywords);

        // Get the keyword replacements.
        var self = this;
        this.getKeywordReplacements(
            keywords,
            function(replacements) {
                // Convert the keywords inside the attributes.
                content = self._convertAttributeKeywords(content, replacements);

                if (callback) {
                    callback.call(self, content);
                }
            }
        );

    },

    /**
     * Shows the keywords instead of their replacements.
     */
    showKeywords: function (elem) {
        this._convertContentReplacementsToKeywords(elem)
        this._convertAttributeReplacementsToKeywords(elem);

    },

    _convertContentReplacementsToKeywords: function (parentElem) {
        var keywordElements = ViperUtil.find(parentElem, '[data-viper-keyword]');
        var ln              = keywordElements.length;
        for (var i = 0; i < ln; i++) {
            var keywordElem = keywordElements[i];
            var keyword  = ViperUtil.attr(keywordElem, 'data-viper-keyword');
            if (keywordElem.attributes.length > 2) {
                // Need to keep this span tag as it has extra attributes applied to it but remove the keyword attributes.
                ViperUtil.removeAttr(keywordElem, 'data-viper-keyword')
                ViperUtil.removeAttr(keywordElem, 'title');

                // Also set the content of the keyword to be the keyword.
                ViperUtil.setHtml(keywordElem, keyword);
            } else {
                var textNode = document.createTextNode(keyword);
                ViperUtil.insertAfter(keywordElem, textNode);
                ViperUtil.remove(keywordElem);
            }
        }

    },

    _convertAttributeReplacementsToKeywords: function (parentElem) {
        parentElem = parentElem || this.viper.getViperElement();

        // Find all elements.
        var elems = ViperUtil.getTag('*', parentElem);
        var ln    = elems.length;

        for (var i = 0; i < elems.length; i++) {
            for (var j = (elems[i].attributes.length - 1); j >= 0; j--) {
                var attr = elems[i].attributes[j];
                if (attr.nodeName === 'data-viper-attribite-keywords') {
                    // Remove the cloned attribute.
                    ViperUtil.removeAttr(elems[i], attr.nodeName);
                } else if (attr.nodeName.indexOf('data-viper-') === 0) {
                    // Replace real attribute value with the cloned value.
                    var attrName = attr.nodeName.replace('data-viper-', '');
                    if (attrName === 'src') {
                        // Do not set the src value as the keyword. This causes 404 requests.
                        attrName = '__viper_attr_src';
                        // Remove the actual src attribute.
                        ViperUtil.removeAttr(elems[i], 'src');
                    }

                    ViperUtil.attr(elems[i], attrName, attr.value);

                    // Remove the cloned attribute.
                    ViperUtil.removeAttr(elems[i], attr.nodeName);
                }
            }
        }
    },

    getKeywordReplacements: function (keywords, callback) {
        // The function that is going to retrieve all the replacements.
        var repCallback = this.getReplacementsCallback();
        if (!repCallback) {
            callback.call(this, keywords);
            return;
        }

        var self = this;
        repCallback(
            keywords,
            function(replacements) {
                callback.call(self, replacements);
            }
        );

    },

    /**
     * Scands the text nodes and element attributes for keywords.
     *
     * @param {DOMNode} parentElem The element to scan.
     *
     * @return {array}
     */
    scanKeywords: function (parentElem) {
        if (!this.getReplacementRegex()) {
            return;
        }

        var keywords = {};
        parentElem   = parentElem || this.viper.getViperElement();
        var content  = ViperUtil.getHtml(parentElem);

        this._scanAttributeKeywords(content, keywords);
        this._scanContentKeywords(parentElem, keywords);

        return keywords;

    },

    _scanAttributeKeywords: function(content, keywords) {
        var self = this;

        // Regex to get list of HTML tags.
        var subRegex = '\\s+([:\\w]+)(?:\\s*=\\s*("(?:[^"]+)?"|\'(?:[^\']+)?\'|[^\'">\\s]+))?';

        // Regex to get list of attributes in an HTML tag.
        var tagRegex  = new RegExp('(<[\\w:]+)(?:' + subRegex + ')+\\s*(\/?>)', 'g');
        var attrRegex = new RegExp(subRegex, 'g');

        var regex      = self.getReplacementRegex();
        if (!regex) {
            return keywords;
        }

        // Find keywords in element attributes.
        // Find all elements.
        regex = new RegExp(regex, 'gi');

        this._cache.attributes = {};

        content = content.replace(/__viper_attr_/g, '');

        content = content.replace(tagRegex, function(match, tagStart, a, tagEnd) {
            match = match.replace(attrRegex, function(a, attrName, attrValue) {
                // All attribute names must be lowercase.
                attrName = attrName.toLowerCase();
                var res  = ' ' + attrName + '=' + attrValue + '';

                if (!self._cache.attributes[res]) {
                    var matches = attrValue.match(regex);
                    if (matches !== null) {
                        self._cache.attributes[res] = [];
                        var match  = null;
                        while (match = matches.pop()) {
                            self._cache.attributes[res].push(match);
                            keywords[match] = '';
                        }
                    }
                }

                return res;
            });

            return match;
        });

        return keywords;
    },

    _scanContentKeywords: function (parentElem, keywords) {
        parentElem = parentElem || this.viper.getViperElement();

        var regex = this.getReplacementRegex();
        if (!regex) {
            return keywords;
        }

        regex = new RegExp(regex, 'gi');

        this._cache.textNodes = [];

        var textNodes = ViperUtil.getTextNodes(parentElem);
        var ln        = textNodes.length;
        var prevNode  = null;
        var nodeData  = null;
        for (var i = 0; i < ln; i++) {
            var matches = textNodes[i].data.match(regex);
            if (matches !== null) {
                var match = null;
                while (match = matches.shift()) {
                    if (prevNode !== textNodes[i]) {
                        // New node. Each node might have more than one keyword.
                        nodeData = {
                            elem: textNodes[i],
                            keywords: []
                        };

                        this._cache.textNodes.push(nodeData);
                    }

                    if (ViperUtil.isset(keywords[match]) === false) {
                        keywords[match] = '';
                    }

                    nodeData.keywords.push(match);
                    prevNode = textNodes[i];
                }
            }
        }

        return keywords;

    },

    /**
     * Converts keywords inside conent (not attributes).
     */
    _convertContentKeywords: function (replacements) {
        var ln = this._cache.textNodes.length;
        for (var i = 0; i < ln; i++) {
            // For each element replcace its keywords from end to beginning.
            var kc = this._cache.textNodes[i].keywords.length;
            for (var j = (kc - 1); j >= 0; j--) {
                var textNode = this._cache.textNodes[i].elem;
                var keyword  = this._cache.textNodes[i].keywords[j];

                if (textNode.data === keyword && ViperUtil.isTag(textNode.parentNode, 'span') === true) {
                    // No need to create a new element.
                    var parent = textNode.parentNode;
                    ViperUtil.attr(parent, 'data-viper-keyword', keyword);
                    ViperUtil.attr(parent, 'title', keyword);
                    ViperUtil.setHtml(parent, replacements[keyword]);
                } else {
                    // Need to split the text node at the start of keyword and create a new text node to put the
                    // rest of the content. For this reason we have to start replacing from the end of the string.
                    var startIndex = textNode.data.lastIndexOf(keyword);
                    if (startIndex < 0) {
                        // Could not find the keyword.
                        continue;
                    }

                    var startText = textNode.data.substr(0, startIndex);
                    var endText   = textNode.data.substr(startIndex + keyword.length);

                    var newTextNode = document.createTextNode(endText);
                    textNode.data   = startText;
                    ViperUtil.insertAfter(textNode, newTextNode);

                    // Now create the new un editable element.
                    var keywordHolder = this._createUneditableElement(
                        {
                            attributes: {
                                'data-viper-keyword': keyword,
                                title: keyword
                            },
                            content: replacements[keyword]
                        }
                    );

                    // Add it after the original textNode.
                    ViperUtil.insertAfter(textNode, keywordHolder);
                }//end if
            }
        }

    },

    /**
     * Creates an element that cannot be edited.
     */
    _createUneditableElement: function (options) {
        if (!options) {
            options = {};
        }

        var tagName = options.tagName || 'div';
        var content = options.content || '';

        var elem = document.createElement(tagName);

        ViperUtil.setHtml(elem, content);

        if (!options.tagName && this.viper.hasBlockChildren(elem) !== true) {
            // There are no block elements so use a span instead.
            elem = document.createElement('span');
            ViperUtil.setHtml(elem, content);
        }

        if (options.attributes) {
            for (var attrName in options.attributes) {
                ViperUtil.attr(elem, attrName, options.attributes[attrName]);
            }
        }

        return elem;

    },

    _convertAttributeKeywords: function (content, replacements) {
        if (typeof content !== 'string') {
            content = ViperUtil.getHtml(content);
        }

        content = content.replace(/__viper_attr_/g, '');

        for (var attr in this._cache.attributes) {
            var attrRep = attr;
            for (var i = 0; i < this._cache.attributes[attr].length; i++) {
                var keyword = this._cache.attributes[attr][i];
                attrRep     = attrRep.replace(keyword, replacements[keyword]) + ' data-viper-' + ViperUtil.ltrim(attr);
            }

            content = ViperUtil.replaceAll(attr, attrRep, content);
        }

        return content;

    },

    _replaceAttributeKeyword: function(element, attribute, keyword, replacement, value, forceUpdate) {
        // Copy the real attribute into a new data attribute so that it can be recovered.
        var cloneName = 'data-viper-' + attribute;
        if (forceUpdate === true || ViperUtil.hasAttribute(element, cloneName) === false) {
            ViperUtil.attr(element, cloneName, value);
        }

        // Replace the keyword with its value in the real attribute.
        var realValue = value;
        realValue     = realValue.replace(keyword, replacement);
        ViperUtil.attr(element, attribute, realValue);

        ViperUtil.attr(element, 'data-viper-attribite-keywords', 'true');

        return realValue;

    }

};
