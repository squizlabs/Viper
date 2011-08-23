/**
 * A cross browser implementation for working with selections and ranges.
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

var ViperSelection = {
    _lastRange: null,
    _lastTextRange: null,
    _selection: null,

    /**
     * Returns the selection object for the current browser.
     *
     * @return {ViperSelection}
     */
    _getSelection: function()
    {
        if (Viper.window.getSelection) {
            return Viper.window.getSelection();
        } else if (Viper.document.getSelection) {
            return Viper.document.getSelection();
        } else if (Viper.document.selection) {
            return Viper.document.selection;
        } else {
            return null;
        }

    },

    /**
     * Creates a range object.
     *
     * @return {ViperDOMRange}
     */
    createRange: function()
    {
         var rangeObj = null;
         if (Viper.document.body.createTextRange) {
             rangeObj = Viper.document.body.createTextRange();
             return new ViperIERange(rangeObj);
         } else if (Viper.document.createRange) {
             rangeObj = Viper.document.createRange();
             return new ViperMozRange(rangeObj);
         } else {
             throw Error('UnsupportedOperationException: createRange() not supported.');
         }

    },

    /**
     * Returns the range object at the specified position. The current range object
     * is at position 0.
     *
     * @param int pos The position of the wanted range.
     *
     * @return {ViperDOMRange}
     */
    getRangeAt: function(pos)
    {
        this._selection = ViperSelection._getSelection();

        var selection = this._selection;

        if (selection.getRangeAt) {
            // Moz/Safari.
            try {
                if (selection.rangeCount > 0) {
                    var range    = selection.getRangeAt(pos);
                    var mozRange = new ViperMozRange(range);
                } else {
                    var mozRange = this.createRange();
                }

                return mozRange;
            } catch (e) {
                return null;
            }
        } else {
            // IE.
            var rangeObj = selection.createRange();
            if (!rangeObj.duplicate) {
                rangeObj = Viper.document.body.createTextRange();
            }

            var range       = new ViperIERange(rangeObj);
            this._lastRange = range;

            return this._lastRange;
        }//end if

    },

    /**
     * Adds the specified range to the current selection.
     *
     * @param {ViperDOMRange} range The range to add.
     */
    addRange: function(range)
    {
        this._selection = ViperSelection._getSelection();

        if (this._selection.addRange) {
            // Moz/Safari.
            if (this._selection.rangeCount > 0) {
                this._selection.removeAllRanges();
            }

            this._selection.addRange(range.rangeObj);
        } else if (range.rangeObj.select) {
            // IE.
            try {
                range.rangeObj.select();
            } catch (e) {
                // Stop the stupid error: Could not complete the operation due to error 800a025e.
                // This happens when range is not selectable, e.g. element is hidden.
                // Still happens in IE8.. sigh..
            }
        }

    },

    removeRange: function(range)
    {
        var selection = ViperSelection._getSelection();
        if (selection) {
            if (selection.removeRange) {
                selection.removeRange(range.rangeObj);
            } else if (selection.empty) {
                selection.empty();
            }
        }

    }

};
