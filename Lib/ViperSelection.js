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

var ViperSelection = {
    _lastTextRange: null,
    _selection: null,


    _viper: null,

    /**
     * Returns the selection object for the current browser.
     *
     * @return {ViperSelection}
     */
    _getSelection: function()
    {
        if (Viper.window.getSelection) {
            return Viper.window.getSelection();
        } else if (Viper.document.selection) {
            return Viper.document.selection;
        } else if (Viper.document.getSelection) {
            return Viper.document.getSelection();
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
         if (Viper.document.createRange) {
             rangeObj = Viper.document.createRange();
             return new ViperMozRange(rangeObj);
         } else if (Viper.document.body.createTextRange) {
             rangeObj = Viper.document.body.createTextRange();
             return new ViperIERange(rangeObj);
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

            var range = new ViperIERange(rangeObj);
            return range;
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

        if (ViperUtil.isBrowser('msie', '<9') === true) {
            // IE.
            try {
                range.rangeObj.select();
            } catch (e) {
                // Stop the stupid error: Could not complete the operation due to error 800a025e.
                // This happens when range is not selectable, e.g. element is hidden.
                // Still happens in IE8.. sigh..
            }
        } else if (this._selection.addRange) {
            // Moz/Safari.
            if (this._selection.rangeCount > 0) {
                this._selection.removeAllRanges();
            }

            this._selection.addRange(range.rangeObj);
        }

        if (this._viper) {
            this._viper._viperRange = range;
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

    },

    removeAllRanges: function()
    {
        var selection = ViperSelection._getSelection();
        if (selection.removeAllRanges) {
            selection.removeAllRanges();
        }

    }

};
