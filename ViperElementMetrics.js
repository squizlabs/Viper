/**
 * JS Class for the Viper Element Metrics.
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

function ViperElementMetrics() {}

ViperElementMetrics.getStyles = function(element)
{
    if (element === document) {
        return [];
    }

    if (Viper.document.defaultView && Viper.document.defaultView.getComputedStyle) {
        return Viper.document.defaultView.getComputedStyle(element, '');
    } else if (element.currentStyle) {
        return element.currentStyle;
    }

};

ViperElementMetrics.getBackgroundColor = function(element)
{
    var backgroundColor;
    while (element) {
        var styles = ViperElementMetrics.getStyles(element);
        // The rgba(0, 0, 0, 0) is transparent in Safari.
        if (styles.backgroundColor !== 'transparent' && styles.backgroundColor !== 'rgba(0, 0, 0, 0)') {
            backgroundColor = styles.backgroundColor;
            break;
        }

        element = element.parentNode;
    }

    if (backgroundColor) {
        return backgroundColor;
    }

    return  '#FFFFFF';

};

ViperElementMetrics.getBorderInsets = function(element)
{
    var border = 0;
    while (element) {
        try {
        var styles = ViperElementMetrics.getStyles(element);
        } catch (e) {
            break;
        }

        if (styles.marginTop !== '') {
            border += parseInt(styles.marginTop);
        }

        element = element.parentNode;
    }

    return border;

};


ViperElementMetrics.getInsets = function(element)
{
    var styles = ViperElementMetrics.getStyles(element);

    return {
            'top'    : parseInt(styles.borderTopWidth),
            'left'   : parseInt(styles.marginLeft),
            'bottom' : parseInt(styles.marginBottom),
            'right'  : parseInt(styles.marginRight)
           };

};
