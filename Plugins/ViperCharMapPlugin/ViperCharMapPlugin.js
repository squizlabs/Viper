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

        var chars = this.getCharacters().split('|');
        var count = chars.length;

        var content = '<table class="ViperCharMapPlugin" border="1" cellspacing="2" cellpadding="2"><tbody>';
        for (var i = 0; i < count; i++) {
            if ((i % 10) === 0) {
                if (i !== 0) {
                    content += '</tr>';
                }

                content += '<tr>';
            }

            content += '<td data_viper_char="' + chars[i].replace('&', '') + '">' + chars[i] + '</td>';
        }

        content += '</tbody></table>';

        dfx.setHtml(subContent, content);

        dfx.addEvent(subContent, 'click', function(e) {
            var target   = dfx.getMouseEventTarget(e);
            var charCode = target.firstChild.data.charCodeAt(0);

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
        });

        var subSectionWrapper = toolbar.createSubSection(subContent, true);

        var map = toolbar.createToolsPopup('Insert Character', null, [subSectionWrapper], null, function() {});

        toolbar.createButton('', false, 'Insert Character', false, 'charMap', null, null, map);

    },

    getCharacters: function()
    {
        var chars = '&Agrave;|&agrave;|&Aacute;|&aacute;|&Acirc;|&acirc;|&Atilde;|&atilde;|&Auml;|&auml;|&Aring;|&aring;|&AElig;|&aelig;|&Ccedil;|&ccedil;|&ETH;|&eth;|&Egrave;|&egrave;|&Eacute;|&eacute;|&Ecirc;|&ecirc;|&Euml;|&euml;|&Igrave;|&igrave;|&Iacute;|&iacute;';
        chars    += '|&Icirc;|&icirc;|&Iuml;|&iuml;|&micro;|&Ntilde;|&ntilde;|&Ograve;|&ograve;|&Oacute;|&oacute;|&Ocirc;|&ocirc;|&Otilde;|&otilde;|&Ouml;|&ouml;|&Oslash;|&oslash;|&szlig;|&THORN;|&thorn;|&Ugrave;|&ugrave;|&Uacute;|&uacute;|&Ucirc;|&ucirc;|&Uuml;|&uuml;|&Yacute;|&yacute;|&yuml;|&uml;|&macr;|&acute;|&cedil;|&iexcl;|&iquest;|&middot;|&brvbar;|&laquo;|&raquo;|&para;|&sect;|&copy;|&reg;|&sup1;|&sup2;|&sup3;|&times;|&divide;|&frac14;|&frac12;|&frac34;|&ordf;|&ordm;|&not;|&deg;|&plusmn;|&curren;|&cent;|&pound;|&yen;|&Delta;|&fnof;|&Omega;|&OElig;|&oelig;|&Scaron;|&scaron;|&Yuml;|&circ;|&tilde;|&ndash;|&mdash;|&dagger;|&Dagger;|&bull;|&hellip;|&lsquo;|&rsquo;|&ldquo;|&rdquo;|&lsaquo;|&rsaquo;|&trade;|&radic;|&infin;|&int;|&part;|&ne;|&le;|&ge;|&sum;|&permil;|&prod;|&pi;|&loz;|&shy;';
        chars    += '|&#256;|&#257;|&#274;|&#275;|&#298;|&#299;|&#332;|&#333;|&#362;|&#363;';

        return chars;

    }

};
