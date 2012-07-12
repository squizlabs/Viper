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

function ViperCharMapPlugin(viper)
{
    this.viper = viper;

}

ViperCharMapPlugin.prototype = {

    init: function()
    {
        this._initToolbar();

    },

    _initToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperCharMapPlugin', function(data) {
            if (data.range) {
                var nodeSelection = data.range.getNodeSelection();
                if (nodeSelection && dfx.isStubElement(nodeSelection) === true) {
                    self.viper.ViperTools.disableButton('insertCharacter');
                    return;
                }
            }

            self.viper.ViperTools.enableButton('insertCharacter');
        });

        this.viper.registerCallback('ViperToolbarPlugin:enabled', 'ViperCharMapPlugin', function(data) {
            self.viper.ViperTools.enableButton('insertCharacter');
        });

        var self = this;

        var subContent = document.createElement('div');

        var categories = this.getCharacters('currency');
        var count      = categories.length;

        var catTable = '';
        var list     = '<ul class="VCMP-list">';

        for (var i = 0; i < count; i++) {
            var category = categories[i];

            list += '<li>' + category.name + '</li>';

            var tableClass = 'VCMP-table';
            if (i === 0) {
                tableClass += ' Viper-visible';
            }

            catTable     += '<table class="' + tableClass + '" border="0" cellspacing="0" cellpadding="0"><tbody>';
            var charCount = category.chars.length;
            for (var j = 0; j < charCount; j++) {
                if ((j % 7) === 0) {
                    if (j !== 0) {
                        catTable += '</tr>';
                    }

                    catTable += '<tr>';
                }

                catTable += '<td data_viper_char="' + category.chars[j].replace('&', '') + '">' + category.chars[j] + '</td>';
            }

            catTable += '</tbody></table>';
        }//end for

        list += '</ul>';

        var wrapper = '<div class="VCMP-wrapper">' + list + '<div class="VCMP-tablesWrapper">' + catTable + '</div></div>';

        dfx.setHtml(subContent, wrapper);

        var tools = this.viper.ViperTools;

        var map = toolbar.createBubble('ViperCMP:bubble', 'Insert Character', subContent, null, null, null, 'VCMP-main');

        var toggle = tools.createButton('insertCharacter', '', 'Insert Character', 'Viper-charMap', null, true);
        toolbar.setBubbleButton('ViperCMP:bubble', 'insertCharacter');
        toolbar.addButton(toggle);

        // Table cell click event.
        var listItems = dfx.getTag('li', subContent);
        var tables    = dfx.getTag('table', subContent);

        // Select the initial item.
        dfx.addClass(listItems[0], 'Viper-selected');

        dfx.addEvent(listItems, 'click', function(e) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isTag(target, 'li') === false) {
                target = target.parentNode;
            }

            dfx.removeClass(listItems, 'Viper-selected');
            dfx.addClass(target, 'Viper-selected');

            var index = 0;
            while (target.previousSibling) {
                if (dfx.isTag(target.previousSibling, 'li') === true) {
                    index++;
                }

                target = target.previousSibling;
            }

            // Show the table at this index.
            dfx.removeClass(tables, 'Viper-visible');
            dfx.addClass(tables[index], 'Viper-visible');
        });

        var btn = document.createElement('div');
        dfx.addClass(btn, 'VCMP-hoverBtn Viper-button');
        subContent.appendChild(btn);

        dfx.addEvent(btn, 'click', function() {
             var charCode = btn.firstChild.data.charCodeAt(0);
             self.insertCharacter(charCode);
        });

        dfx.hover(dfx.getTag('td', subContent), function(e) {
            dfx.setHtml(btn, dfx.getHtml(e.target));
            var coords       = dfx.getElementCoords(e.target);
            var scrollCoords = dfx.getScrollCoords();

            dfx.setStyle(btn, 'left', (coords.x - scrollCoords.x) + 'px');
            dfx.setStyle(btn, 'top', (coords.y - scrollCoords.y) + 'px');
            dfx.setStyle(btn, 'display', 'block');
        }, function(e) {});

        dfx.hover(btn, function() {}, function() {
            dfx.setStyle(btn, 'display', 'none');
        });

    },

    insertCharacter: function(charCode)
    {
        var range = this.viper.getViperRange();
        if (range.collapsed !== true) {
            this.viper.deleteContents();

            // Get the updated range.
            range = this.viper.getViperRange();
        }

        var newNode = document.createTextNode(String.fromCharCode(charCode));

        range.insertNode(newNode);
        range.setStart(newNode, 1);

        if (this.viper.isBrowser('msie') === true) {
            range.moveStart('character', 1);
        }

        range.collapse(true);
        ViperSelection.addRange(range);

        this.viper.fireNodesChanged([this.viper.getViperElement()]);
        this.viper.fireSelectionChanged(range);

    },

    getCharacters: function()
    {
        var categories = [];

        var _getRange = function(start, stop) {
            var str = '';
            for (var i = start; i <= stop; i++) {
                str += '|' + i;
            }

            return str;
        };

        var chars    = '$|&cent;|&pound;|&curren;|&yen';
        var htmlEnt  = '|1547|2546|2547|2801|3065|3647|6107';
        htmlEnt     += _getRange(8352, 8375);
        htmlEnt     += '|65020|65129|65284|65504|65505|65509|65510';
        chars       += htmlEnt.replace(/\|/g, ';|&#') + ';';
        chars        = chars.split('|');
        var currency = chars;

        chars     = '&Agrave;|&agrave;|&Aacute;|&aacute;|&Acirc;|&acirc;|&Atilde;|&atilde;|&Auml;|&auml;|&Aring;|&aring;|&#256;|&#257;|&AElig;|&aelig;|&Ccedil;|&ccedil;|&ETH;|&eth;|&Egrave;|&egrave;|&Eacute;|&eacute;|&Ecirc;|&ecirc;|&Euml;|&euml;|&#274;|&#275;|&Igrave;|&igrave;|&Iacute;|&iacute;';
        chars    += '|&Icirc;|&icirc;|&Iuml;|&iuml;|&#298;|&#299;|&micro;|&Ntilde;|&ntilde;|&Ograve;|&ograve;|&Oacute;|&oacute;|&Ocirc;|&ocirc;|&Otilde;|&otilde;|&Ouml;|&ouml;|&#332;|&#333;|&Oslash;|&oslash;|&OElig;|&oelig;|&Scaron;|&scaron;|&szlig;|&THORN;|&thorn;|&Ugrave;|&ugrave;|&Uacute;|&uacute;|&Ucirc;|&ucirc;|&Uuml;|&uuml;|&#362;|&#363;|&Yacute;|&yacute;|&yuml;|&Yuml;';
        chars     = chars.split('|');
        var latin = chars;

        chars     = '&sup1;|&sup2;|&sup3;|&times;|&divide;|&frac14;|&frac12;|&frac34;|&ordf;|&ordm;|&not;|&deg;|&plusmn;|&Delta;|&fnof;|&Omega;|&circ;|&tilde;|&dagger;|&Dagger;|&bull;|&hellip;|&radic;|&infin;|&int;|&part;|&ne;|&le;|&ge;|&sum;|&permil;|&prod;|&pi;|&loz;';
        chars     = chars.split('|');
        var maths = chars;

        chars       = '&uml;|&macr;|&acute;|&cedil;|&iexcl;|&iquest;|&middot;|&brvbar;|&laquo;|&raquo;|&para;|&sect;|&copy;|&reg;|&trade;';
        chars       = chars.split('|');
        var symbols = chars;

        categories.push({
            name: 'Symbols',
            chars: symbols
        });

        categories.push({
            name: 'Latin',
            chars: latin
        });

        categories.push({
            name: 'Mathematics',
            chars: maths
        });

        categories.push({
            name: 'Currency',
            chars: currency
        });

        return categories;

    }

};
