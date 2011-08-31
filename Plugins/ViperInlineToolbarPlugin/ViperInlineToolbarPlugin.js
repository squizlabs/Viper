/**
 * JS Class for the Viper InlineToolbar Plugin.
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
function ViperInlineToolbarPlugin(viper)
{
    this.viper           = viper;
    this._toolbar        = null;
    this._innerContainer = null;
    this._lineage        = null;
    this._lineageClicked = false;
    this._margin         = 10;

    // Create the toolbar.
    this._createToolbar();

    var self = this;

    // Called when the selection is changed.
    this.viper.registerCallback('Viper:selectionChanged', 'ViperInlineToolbarPlugin', function(range) {
        if (self._lineageClicked !== true) {
            // Not selection change due to a lineage click so update the range object.
            self._originalRange = range.cloneRange();
        }

        // Update the toolbar position, contents and lineage for this new selection.
        self.updateToolbar(range);
    });

    // Hide the toolbar when user clicks anywhere.
    this.viper.registerCallback('Viper:mouseDown', 'ViperInlineToolbarPlugin', function(range) {
        self.hideToolbar();
    });

    // During zooming hide the toolbar.
    dfx.addEvent(window, 'gesturestart', function() {
        self.hideToolbar();
    });

    // Update and show the toolbar after zoom.
    dfx.addEvent(window, 'gestureend', function() {
        self.updateToolbar();
    });

}

ViperInlineToolbarPlugin.prototype = {

    /**
     * Creates the inline toolbar.
     *
     * The toolbar is added to the BODY element.
     */
    _createToolbar: function()
    {
        var main      = document.createElement('div');
        this._toolbar = main;

        this._lineage = document.createElement('ul');
        this._toolbar.appendChild(this._lineage);

        this._innerContainer = document.createElement('div');
        this._toolbar.appendChild(this._innerContainer);

        dfx.addClass(this._toolbar, 'ViperInlineToolbarPlugin');
        dfx.addClass(this._lineage, 'ViperInlineToolbarPlugin-lineage');
        dfx.addClass(this._innerContainer, 'ViperInlineToolbarPlugin-inner');

        document.body.appendChild(this._toolbar);

    },

    /**
     * Creates a toolbar button.
     *
     * @param {string}   content     The content of the button.
     * @param {string}   tagName     The tagName that activates the button.
     *                               E.g. Selecting a strong tag will activate the
     *                               button with tagName set to 'strong'.
     * @param {string}   customClass Class to add to the button for extra styling.
     * @param {function} clickAction The function to call when the button is clicked.
     *
     * @return {DOMElement} The new button element.
     */
    createButton: function(content, tagName, customClass, clickAction)
    {
        var button = document.createElement('div');
        dfx.setHtml(button, content);
        dfx.addClass(button, 'ViperInlineToolbarPlugin-button');

        if (customClass) {
            dfx.addClass(button, customClass);
        }

        if (clickAction) {
            var self = this;
            dfx.addEvent(button, 'mousedown.ViperInlineToolbarPlugin', function() {
                self._lineageClicked = false;
                return clickAction.call(this);
            });
        }

        if (tagName) {
            dfx.attr(button, 'data-ViperInlineToolbarPlugin-tag', tagName);
        }

        return button;

    },

    /**
     * Upudates the toolbar.
     *
     * This method is usually called by the Viper:selectionChanged event.
     *
     * @param {DOMRange} range The DOMRange object.
     */
    updateToolbar: function(range)
    {
        if (navigator.userAgent.match(/iPad/i) !== null) {
            this._scaleToolbar();
        }

        range = range || this.viper.getCurrentRange();

        var lineage = this._getSelectionLineage(range);

        this._updateActiveButtons(lineage);

        if (this._lineageClicked === true) {
            this._lineageClicked = false;
            return;
        }

        this._updateInnerContainer(range, lineage);

        if (!dfx.getHtml(this._innerContainer)) {
            this.hideToolbar();
            return;
        }

        this._updateLineage(lineage);
        this._updatePosition(range);

        var lineage = this._getSelectionLineage(range);
        this._updateActiveButtons(lineage);

    },

    /**
     * Hides the inline toolbar.
     */
    hideToolbar: function()
    {
        dfx.removeClass(this._toolbar, 'visible');

    },

    /**
     * Returns a better tag name for the given DOMElement tag name.
     *
     * For example: strong -> Bold, u -> Underline.
     *
     * @param {string} tagName The tag name of a DOMElement.
     *
     * @return {string} The readable name.
     */
    getReadableTagName: function(tagName)
    {
        switch (tagName) {
            case 'strong':
                tagName = 'Bold';
            break;

            case 'u':
                tagName = 'Underline';
            break;

            case 'em':
            case 'i':
                tagName = 'Italic';
            break;

            case 'li':
                tagName = 'List Item';
            break;

            case 'ul':
                tagName = 'Unordered List';
            break;

            case 'ol':
                tagName = 'Ordered List';
            break;

            default:
                tagName = tagName.toUpperCase();
            break;
        }//end switch

        return tagName;

    },

    /**
     * Scales the toolbar using CSS transforms.
     *
     * Used on iPad only to scale the toolbar as user zooms in/out.
     */
    _scaleToolbar: function()
    {
        if (!this._toolbar) {
            return;
        }

        var self  = this;
        var zoom  = (document.documentElement.clientWidth / window.innerWidth);
        var scale = (1.2 / zoom);
        if (scale >= 1.2) {
            scale        = 1.2;
            self._margin = 20;
        } else if (scale <= 0.5) {
            scale        = 0.5;
            self._margin = -12;
        } else {
            self._margin = (-6 * zoom);
        }

        dfx.setStyle(self._toolbar, '-webkit-transform', 'scale(' + scale + ', ' + scale + ')');

    },

    /**
     * Updates the status of the buttons in the toolbar by checking the given lineage.
     *
     * @param {array} lineage The lineage array.
     */
    _updateActiveButtons: function(lineage)
    {
        var buttons = dfx.getClass('ViperInlineToolbarPlugin-button', this._innerContainer);
        var c       = buttons.length;
        var lc      = lineage.length;

        for (var i = 0; i < c; i++) {
            var active = false;
            var tag    = dfx.attr(buttons[i], 'data-ViperInlineToolbarPlugin-tag');
            for (var j = 0; j < lc; j++) {
                if (dfx.isTag(lineage[j], tag) === true) {
                    dfx.addClass(buttons[i], 'active');
                    active = true;
                    break;
                }
            }

            if (active === false) {
                dfx.removeClass(buttons[i], 'active');
            }
        }

    },

    /**
     * Upudates the position of the inline toolbar.
     *
     * @param {DOMRange} range        The DOMRange object.
     * @param {boolean}  verticalOnly If true then only the vertical position will be
     *                                updated.
     */
    _updatePosition: function(range, verticalOnly)
    {
        range = range || this.viper.getCurrentRange();

        var rangeCoords = range.rangeObj.getBoundingClientRect();
        if (!rangeCoords) {
            return;
        }

        var scrollCoords = dfx.getScrollCoords();

        if (verticalOnly !== true) {
            dfx.addClass(this._toolbar, 'calcWidth');
            var toolbarWidth = dfx.getElementWidth(this._toolbar);
            dfx.removeClass(this._toolbar, 'calcWidth');

            var left = ((rangeCoords.left + ((rangeCoords.right - rangeCoords.left) / 2) + scrollCoords.x) - (toolbarWidth / 2));
            dfx.setStyle(this._toolbar, 'left', left + 'px');
        }

        var top = (rangeCoords.bottom + this._margin + scrollCoords.y);

        dfx.setStyle(this._toolbar, 'top', top + 'px');
        dfx.addClass(this._toolbar, 'visible');

    },

    /**
     * Updates the contents of the lineage container.
     *
     * @param {array} lineage The lineage array.
     */
    _updateLineage: function(lineage)
    {
        // Remove the contents of the lineage container.
        dfx.empty(this._lineage);

        var viper = this.viper;
        var c     = lineage.length;
        var self  = this;

        // Create lineage items.
        for (var i = 0; i < c; i++) {
            var tagName = lineage[i].tagName.toLowerCase();
            var parent  = document.createElement('li');
            dfx.setHtml(parent, this.getReadableTagName(tagName));
            this._lineage.appendChild(parent);

            (function(clickElem, selectionElem) {
                // When clicked set the user selection to the selected element.
                dfx.addEvent(clickElem, 'mousedown.ViperInlineToolbarPlugin', function() {
                    // We set the _lineageClicked to true here so that when the
                    // fireSelectionChanged is called we do not update the lineage again.
                    self._lineageClicked = true;

                    // Set the range.
                    var range = viper.getCurrentRange();
                    range.selectNode(selectionElem);
                    ViperSelection.addRange(range);
                    viper.fireSelectionChanged();

                    // Update the position of the toolbar vertically only.
                    self._updatePosition(range, true);

                    return false;
                });
            }) (parent, lineage[i]);
        }//end for

        if (this._originalRange.collapsed === true) {
            // No need to add the 'Selection' item as its collapsed.
            return;
        }

        // Add the original user selection to the lineage.
        var parent = document.createElement('li');
        dfx.setHtml(parent, 'Selection');
        this._lineage.appendChild(parent);

        dfx.addEvent(parent, 'mousedown.ViperInlineToolbarPlugin', function() {
            // When clicked set the selection to the original selection.
            self._lineageClicked = true;
            ViperSelection.addRange(self._originalRange);
            viper.fireSelectionChanged(self._originalRange);
            self._updatePosition(self._originalRange, true);
            return false;
        });

    },

    /**
     * Fires the updateToolbar event so that other plugins can modify the contents of the toolbar.
     *
     * @param {DOMRange} range   The DOMRange object.
     * @param {array}    lineage The lineage array.
     */
    _updateInnerContainer: function(range, lineage)
    {
        dfx.empty(this._innerContainer);
        this.viper.fireCallbacks('ViperInlineToolbarPlugin:updateToolbar', {container: this._innerContainer, range: range, lineage: lineage});

    },

    /**
     * Returns the selection's parent elements.
     *
     * @param {DOMRange} range The DOMRange object.
     *
     * @return {array} Array of DOMElements.
     */
    _getSelectionLineage: function(range)
    {
        var lineage      = [];
        var parent       = range.getCommonElement();
        var viperElement = this.viper.getViperElement();

        var startNode = range.getStartNode();

        if (startNode.nodeType !== dfx.TEXT_NODE) {
            // Add this node selection to the lineage.
            lineage.push(startNode);
        }

        if (parent === viperElement) {
            return lineage;
        }

        lineage.push(parent);

        parent = parent.parentNode;

        while (parent !== viperElement) {
            lineage.push(parent);
            parent = parent.parentNode;
        }

        lineage = lineage.reverse();

        return lineage;

    }

};
