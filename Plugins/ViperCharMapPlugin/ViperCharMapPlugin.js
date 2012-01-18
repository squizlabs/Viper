/**
 * JS Class for the ViperCharMapPlugin.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program as the file license.txt. If not, see
 * <http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt>
 *
 * @package   Viper
 * @author    Squiz Pty Ltd <products@squiz.net>
 * @copyright 2010 Squiz Pty Ltd (ACN 084 670 600)
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPLv2
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

        var self = this;

        var subContent = document.createElement('div');

        var categories = this.getCharacters('currency');
        var count      = categories.length;

        var catTable = '';
        var list     = '<ul class="VCMP-list">';

        for (var i = 0; i < count; i++) {
            var category = categories[i];

            list += '<li>' + category.name + '<div></div></li>';

            var tableClass = 'VCMP-table';
            if (i === 0) {
                tableClass += ' visible';
            }

            catTable     += '<table class="' + tableClass + '" border="1" cellspacing="2" cellpadding="2"><tbody>';
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

        var subSectionWrapper = toolbar.createSubSection(subContent, true, 'VCMP-main');

        var map = toolbar.createToolsPopup('Insert Character', null, [subSectionWrapper], null, function() {});

        toolbar.createButton('', false, 'Insert Character', false, 'charMap', null, null, map);

        // Table cell click event.
        var listItems = dfx.getTag('li', subContent);
        var tables    = dfx.getTag('table', subContent);

        // Select the initial item.
        dfx.addClass(listItems[0], 'selected');

        dfx.addEvent(listItems, 'click', function(e) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isTag(target, 'li') === false) {
                target = target.parentNode;
            }

            dfx.removeClass(listItems, 'selected');
            dfx.addClass(target, 'selected');

            var index = 0;
            while (target.previousSibling) {
                if (dfx.isTag(target.previousSibling, 'li') === true) {
                    index++;
                }

                target = target.previousSibling;
            }

            // Show the table at this index.
            dfx.removeClass(tables, 'visible');
            dfx.addClass(tables[index], 'visible');
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
        var range = self.viper.getViperRange();
        if (range.collapsed !== true) {
            self.viper.deleteContents();

            // Get the updated range.
            range = self.viper.getViperRange();
        }

        var newNode = document.createTextNode(String.fromCharCode(charCode));

        range.insertNode(newNode);
        range.setStart(newNode, 1);
        range.collapse(true);
        ViperSelection.addRange(range);

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

        // Currency.
        var chars   = '$|&cent;|&pound;|&curren;|&yen';
        var htmlEnt = '|1547|2546|2547|2555|2801|3065|3647|6107';
        htmlEnt    += _getRange(8352, 8377);
        htmlEnt    += '43064|65020|65129|65284|65504|65505|65509|65510';
        chars      += htmlEnt.replace(/\|/g, ';|&#') + ';';
        chars       = chars.split('|');
        categories.push({
            name: 'Currency',
            chars: chars
        });

        chars  = '&Agrave;|&agrave;|&Aacute;|&aacute;|&Acirc;|&acirc;|&Atilde;|&atilde;|&Auml;|&auml;|&Aring;|&aring;|&#256;|&#257;|&AElig;|&aelig;|&Ccedil;|&ccedil;|&ETH;|&eth;|&Egrave;|&egrave;|&Eacute;|&eacute;|&Ecirc;|&ecirc;|&Euml;|&euml;|&#274;|&#275;|&Igrave;|&igrave;|&Iacute;|&iacute;';
        chars += '|&Icirc;|&icirc;|&Iuml;|&iuml;|&#298;|&#299;|&micro;|&Ntilde;|&ntilde;|&Ograve;|&ograve;|&Oacute;|&oacute;|&Ocirc;|&ocirc;|&Otilde;|&otilde;|&Ouml;|&ouml;|&#332;|&#333;|&Oslash;|&oslash;|&OElig;|&oelig;|&Scaron;|&scaron;|&szlig;|&THORN;|&thorn;|&Ugrave;|&ugrave;|&Uacute;|&uacute;|&Ucirc;|&ucirc;|&Uuml;|&uuml;|&#362;|&#363;|&Yacute;|&yacute;|&yuml;|&Yuml;';
        chars  = chars.split('|');

        categories.push({
            name: 'Latin',
            chars: chars
        });

        chars = '&sup1;|&sup2;|&sup3;|&times;|&divide;|&frac14;|&frac12;|&frac34;|&ordf;|&ordm;|&not;|&deg;|&plusmn;|&Delta;|&fnof;|&Omega;|&circ;|&tilde;|&ndash;|&mdash;|&dagger;|&Dagger;|&bull;|&hellip;|&lsquo;|&rsquo;|&ldquo;|&rdquo;|&lsaquo;|&rsaquo;|&radic;|&infin;|&int;|&part;|&ne;|&le;|&ge;|&sum;|&permil;|&prod;|&pi;|&loz;';
        chars = chars.split('|');
        categories.push({
            name: 'Mathematics',
            chars: chars
        });

        chars = '&uml;|&macr;|&acute;|&cedil;|&iexcl;|&iquest;|&middot;|&brvbar;|&laquo;|&raquo;|&para;|&sect;|&copy;|&reg;|&trade;';
        chars = chars.split('|');
        categories.push({
            name: 'Symbols',
            chars: chars
        });

        return categories;

    }

};
