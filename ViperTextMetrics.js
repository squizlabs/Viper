/**
 * The Text Metrics class can be used to determine metrical information about
 * text within a node. The Text metrics class is a session based API. That is,
 * you must first supply a node to work with before any API methods can be called.
 * This is to reduce the number of dom operations and to improve performance.
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
 * @package    CMS
 * @subpackage Editing
 * @author     Squiz Pty Ltd <products@squiz.net>
 * @copyright  2010 Squiz Pty Ltd (ACN 084 670 600)
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPLv2
 */

/**
 * You can start a session with Text metrics by issuing a call to:
 * <code>
 *  ViperTextMetrics.workWith(element);
 * </code>
 *
 * You can now use the api methods.
 *
 * A call to:
 * <code>ViperTextMetrics.finish();</code>
 * Will terminate the work with the class.
 */

function ViperTextMetrics() {}

ViperTextMetrics.appendToBody = function(element)
{
    Viper.document.getElementsByTagName('body')[0].appendChild(element);

};

ViperTextMetrics.getCharWidth = function(chr)
{
    var clone = ViperTextMetrics.workNode;
    var text  = clone.innerHTML;

    // All leters take up the same space, so choose an arbitrary letter.
    clone.innerHTML = chr;

    var insets = ViperElementMetrics.getInsets(clone);

    // The height of the character is the height of the element minus it's insets.
    var width = (clone.offsetWidth - insets.left - insets.right);

    clone.innerHTML = text;

    return width;

};

var isInteger = function(num)
{
            return (!isNaN(parseInt(num)) && parseInt(num).toString() == num);

};


ViperTextMetrics.getCharHeight = function(element)
{
    var styles = ViperElementMetrics.getStyles(element);
    var size   = styles.fontSize;

    var bodyStyles = ViperElementMetrics.getStyles(Viper.document.body);
    if (bodyStyles.fontSize) {
        var bodyFontSize = parseInt(bodyStyles.fontSize);
    }

    if (size !== '') {
        if (!isInteger(size)) {
            var idx = 0;
            if ((idx = size.indexOf('em')) > 0) {
                size = size.substring(0, idx);
                size = (size * bodyFontSize * 1.3333);
            } else if ((idx = size.indexOf('pt')) > 0) {
                size = size.substring(0, idx);
                size = (size * 1.3333);
            } else if ((idx = size.indexOf('%')) > 0) {
                size = parseInt(size.substring(0, idx));
                // Convert % to px.
                size = ((size / 7) - 1);
                if (size > 174) {
                    size = (size - 1);
                }
            }
        }
    }

    return parseInt(size);

};

ViperTextMetrics.getWordsBeforeOffset = function(offset)
{
    return ViperTextMetrics.workNode.innerHTML.substr(0, offset).split(/\s+/);

};


ViperTextMetrics.getFirstWordOnLine = function(offset)
{
    var clone = ViperTextMetrics.workNode;

    var words = ViperTextMetrics.getWordsBeforeOffset(offset);

    // Loop through each of the words and append them to the clone container. When
    // the height of the container changes, we have a new line. We are recording
    // the word that causes the text to wrap to the newline. The last word that
    // causes a newline is the first word on the line where our offset is.
    var firstWord  = 0;
    var currHeight = 0;

    var text        = clone.innerHTML;
    clone.innerHTML = '';

    var wLen = words.length;
    for (var i = 0; i < wLen; i++) {
        clone.innerHTML = clone.innerHTML + words[i] + ' ';

        if (clone.offsetHeight > currHeight) {
            currHeight = clone.offsetHeight;
            firstWord  = i;
        }
    }

    clone.innerHTML = text;

    return firstWord;

};

ViperTextMetrics.getLineCount = function(offset)
{
    var clone = ViperTextMetrics.workNode;
    var words = ViperTextMetrics.getWordsBeforeOffset(offset);

    var lines       = 0;
    var currHeight  = 0;
    var text        = clone.innerHTML;
    clone.innerHTML = '';

    var wLen = words.length;
    for (var i = 0; i < wLen; i++) {
        clone.innerHTML = clone.innerHTML + words[i] + ' ';

        if (clone.offsetHeight > currHeight) {
            currHeight = clone.offsetHeight;
            lines++;
        }
    }

    clone.innerHTML = text;

    return lines;

};


ViperTextMetrics.getLineWidth = function(offset)
{
    var clone = ViperTextMetrics.element.cloneNode(true);
    ViperTextMetrics.appendToBody(clone);

    var words     = ViperTextMetrics.getWordsBeforeOffset(offset);
    var firstWord = ViperTextMetrics.getFirstWordOnLine(offset);

    // Now that we have our word, we set the contents of the clone container to
    // the words on the same line as our offset, which we can then use to determine
    // the x location of the offset, by getting the container's width.
    clone.innerHTML = words.slice(firstWord).join(' ');

    clone.style.display = 'inline';

    var insets = ViperElementMetrics.getInsets(clone);
    var coords = dom.getElementCoords(ViperTextMetrics.element);
    var left   = (insets.left - coords.x);

    // If we don't have a last word, then it was a space, so we need to add
    // a non breaking space so that the width reflects that space, since we are
    // now inline.
    if (words[(words.length - 1)] === '') {
        width = (clone.offsetWidth - left) + ViperTextMetrics.getCharWidth('&nbsp;');
    } else {
        width = (clone.offsetWidth - left);
    }

    return width;

};


ViperTextMetrics.getCharacterCoords = function(offset)
{
    var clone  = ViperTextMetrics.workNode;
    var coords = dom.getElementCoords(ViperTextMetrics.element);
    var insets = ViperElementMetrics.getInsets(clone);

    // Set the width of the cloned container to the same width of the element,
    // so that we can determine the y location of the text.
    clone.style.width = (clone.offsetWidth - insets.left - insets.right) + 'px';

    var x = ViperTextMetrics.getLineWidth(offset);

    var y = (coords.y + insets.top - ViperTextMetrics.getCharHeight());
    y     = y + (ViperTextMetrics.getCharHeight() * (ViperTextMetrics.getLineCount(offset) - 1));

    return {'x': x, 'y': y};

};
