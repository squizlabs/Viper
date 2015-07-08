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

}

ViperReplacementPlugin.prototype = {

    init: function () {
        var self = this;

        this.viper.registerCallback('Viper:editableElementChanged', 'ViperReplacementPlugin', function() {
            self.cloneAttributes();
        });

        this.viper.registerCallback('Viper:getHtml', 'ViperReplacementPlugin', function(data) {
            self.cloneToRealAttributes(data.element);
        });

        this.viper.registerCallback('Viper:setHtml', 'ViperReplacementPlugin', function(data, callback) {
            self.cloneAttributes(data.element, callback);
        });

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

    cloneToRealAttributes: function (parentElem) {
        parentElem = parentElem || this.viper.getViperElement();

        // Find all elements.
        var elems = ViperUtil.getTag('*', parentElem);
        var ln    = elems.length;

        for (var i = 0; i < elems.length; i++) {
            for (var j = (elems[i].attributes.length - 1); j >= 0; j--) {
                var attr    = elems[i].attributes[j];
                if (attr.nodeName.indexOf('data-viper-') !== 0) {
                    // Skip non cloned attributes.
                    continue;
                }

                // Replace real attribute value with the cloned value.
                ViperUtil.attr(elems[i], attr.nodeName.replace('data-viper-', ''), attr.value);

                // Remove the cloned attribute.
                ViperUtil.removeAttr(elems[i], attr.nodeName);
            }
        }

    },

    cloneAttributes: function (parentElem, doneCallback) {
        parentElem = parentElem || this.viper.getViperElement();

        var regex    = this.getReplacementRegex();
        var callback = this.getReplacementsCallback();
        if (!regex || !callback) {
            return;
        }

        // Cache is stores the element and attribute that uses a specific keyword.
        var cache = {};

        // All the keyword matches to be sent to the getReplacements callback.
        var allMatches = [];

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
                        if (!cache[match]) {
                            cache[match] = [];
                            allMatches.push(match);
                        }

                        cache[match].push(
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

        var self = this;
        callback(
            allMatches,
            function(replacements) {
                self._makeReplacements(replacements, cache);

                if (doneCallback) {
                    doneCallback.call(this);
                }
            }
        );

    },

    _makeReplacements: function (replacements, cache) {
        for (var match in replacements) {
            if (cache[match]) {
                var ln = cache[match].length;
                for (var i = 0; i < ln; i++) {
                    var elem = cache[match][i].elem;
                    var name = cache[match][i].attrName;
                    var val  = cache[match][i].attrValue;

                    // Clone the real attribute.
                    ViperUtil.attr(elem, 'data-viper-' + name, val);

                    var realValue = ViperUtil.attr(elem, name);
                    realValue     = realValue.replace(match, replacements[match]);
                    ViperUtil.attr(elem, name, realValue);
                }
            }
        }
    }

};
