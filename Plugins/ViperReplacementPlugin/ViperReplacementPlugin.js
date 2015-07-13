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

    init: function () {
        var self = this;

        this.viper.registerCallback('Viper:editableElementChanged', 'ViperReplacementPlugin', function() {
            self.showReplacements();
        });

        this.viper.registerCallback('Viper:getHtml', 'ViperReplacementPlugin', function(data) {
            self.showKeywords(data.element);
        });

        this.viper.registerCallback('Viper:setHtml', 'ViperReplacementPlugin', function(data, callback) {
            self.showReplacements(data.element, callback);
            return function() {};
        });

        if (ViperUtil.isBrowser('msie') === true) {
            // IE, "surprisingly" ignores "contenteditable=false" so when a keyword is selected adjust the selection...
            this.viper.registerCallback('Viper:selectionChanged', 'ViperReplacementPlugin', function(range) {
                var start = range.getStartNode();
                var end   = range.getEndNode();

                var startKeyword = self._getKeywordElement(start);
                var endKeyword   = self._getKeywordElement(end);

                if (startKeyword !== false && startKeyword === endKeyword) {
                    // Just remove the range.
                    ViperSelection.removeAllRanges();
                } else if (startKeyword) {
                    range = self._fixRange(range, startKeyword, true);
                    ViperSelection.addRange(range);
                } else if (endKeyword) {
                    range = self._fixRange(range, endKeyword, false);
                    ViperSelection.addRange(range);
                }
            });
        }

        this.viper.addAttributeGetModifier(
            function (element, attribute, value) {
                // Check if the element has a keyword attribute.
                value = element.getAttribute('data-viper-' + attribute) || value;
                return value;
            }
        );

        this.viper.addAttributeSetModifier(
            function (element, attribute, value) {
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
                            for (var keyword in replacements) {
                                self._replaceAttributeKeyword(element, attribute, keyword, replacements[keyword], value, true);
                            }
                        }
                    );
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

    _fixRange: function (range, keywordElem, start) {
        if (start === true) {
            // Start of range is in keyword.. Move it after keyword.
            var cont = range.getNextContainer(keywordElem);
            range.setStart(cont, 0);
        } else {
            var cont = range.getPreviousContainer(keywordElem);
            range.setEnd(cont, cont.data.length);
        }

        return range;

    },

    _getKeywordElement: function (elem) {
        if (ViperUtil.isTag(elem, 'keyword') === true) {
            return true;
        }

        var viperElement = this.viper.getViperElement();
        while (elem.parentNode && elem.parentNode !== viperElement) {
            elem = elem.parentNode;
            if (ViperUtil.isTag(elem, 'keyword') === true
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
        // Get all the keywords in the element.
        var keywords = this.scanKeywords(element);
        if (!keywords) {
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
                self._convertAttributeKeywords(replacements);

                if (callback) {
                    callback.call(self);
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
            var keyword  = ViperUtil.attr(keywordElements[i], 'data-viper-keyword');
            var textNode = document.createTextNode(keyword);
            ViperUtil.insertAfter(keywordElements[i], textNode);
            ViperUtil.remove(keywordElements[i]);
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
                    ViperUtil.attr(elems[i], attr.nodeName.replace('data-viper-', ''), attr.value);

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
        var cache    = {};

        this._scanAttributeKeywords(parentElem, keywords);
        this._scanContentKeywords(parentElem, keywords);

        return keywords;

    },

    _scanAttributeKeywords: function (parentElem, keywords) {
        parentElem = parentElem || this.viper.getViperElement();

        var regex      = this.getReplacementRegex();
        if (!regex) {
            return keywords;
        }

        this._cache.attributes = {};

        // Find keywords in element attributes.
        // Find all elements.
        var elems = ViperUtil.getTag('*', parentElem);
        var ln    = elems.length;
        regex     = new RegExp(regex, 'gi');

        for (var i = 0; i < ln; i++) {
            // For each attribute check if the value has the replacement regex.
            for (var j = 0; j < elems[i].attributes.length; j++) {
                var attr    = elems[i].attributes[j];
                if (attr.nodeName.indexOf('data-viper-') === 0) {
                    // Skip cloned attributes.
                    continue;
                }

                var matches = attr.value.match(regex);
                if (matches !== null) {
                    var match = null;
                    while (match = matches.pop()) {
                        if (!this._cache.attributes[match]) {
                            this._cache.attributes[match] = [];
                        }

                        if (ViperUtil.isset(keywords[match]) === false) {
                            keywords[match] = '';
                        }

                        this._cache.attributes[match].push(
                            {
                                elem: elems[i],
                                attrName: attr.nodeName,
                                attrValue: attr.value
                            }
                        )
                    }
                }//end if
            }//end for
        }//end for

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
                var keywordHolder = this.viper.createUneditableElement(
                    {
                        tagName: 'keyword',
                        attributes: {
                            'data-viper-keyword': keyword,
                            title: keyword
                        },
                        content: replacements[keyword]
                    }
                );

                // If the keyword holder has block elements then set display style to block.
                if (this.viper.hasBlockChildren(keywordHolder) === true) {
                    ViperUtil.setStyle(keywordHolder, 'display', 'block');
                }

                // Add it after the original textNode.
                ViperUtil.insertAfter(textNode, keywordHolder);
            }
        }

    },

    _convertAttributeKeywords: function (replacements) {
        for (var keyword in replacements) {
            if (this._cache.attributes[keyword]) {
                var ln = this._cache.attributes[keyword].length;
                for (var i = 0; i < ln; i++) {
                    var info = this._cache.attributes[keyword][i];

                    this._replaceAttributeKeyword(info.elem, info.attrName, keyword, replacements[keyword], info.attrValue);
                }
            }
        }

    },

    _replaceAttributeKeyword: function(element, attribute, keyword, replacement, value, forceUpdate) {
        // Copy the real attribute into a new data attribute so that it can be recovered.
        var cloneName = 'data-viper-' + attribute;
        if (forceUpdate === true || ViperUtil.hasAttribute(element, cloneName) === false) {
            ViperUtil.attr(element, cloneName, value);
        }

        // Replace the keyword with its value in the real attribute.
        var realValue = ViperUtil.attr(element, attribute);
        realValue     = realValue.replace(keyword, replacement);
        ViperUtil.attr(element, attribute, realValue);

        //this.viper.makeElementUneditable(element);

        ViperUtil.attr(element, 'data-viper-attribite-keywords', 'true');

        return realValue;

    }

};
