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
 * @package    CMS
 * @subpackage Editing
 * @author     Squiz Pty Ltd <products@squiz.net>
 * @copyright  2010 Squiz Pty Ltd (ACN 084 670 600)
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPLv2
 */
function ViperInlineToolbarPlugin(viper)
{
    this.viper           = viper;
    this.toolbar         = null;
    this._innerContainer = null;
    this._lineage        = null;
    this._lineageClicked = false;

    this._createToolbar();

    var self = this;
    this.viper.registerCallback('Viper:selectionChanged', 'ViperInlineToolbarPlugin', function(range) {
        self.updateToolbar(range);
    });

    this.viper.registerCallback('Viper:mouseDown', 'ViperInlineToolbarPlugin', function(range) {
        self.hideToolbar();
    });

}

ViperInlineToolbarPlugin.prototype = {

    _createToolbar: function()
    {
        var main     = document.createElement('div');
        this.toolbar = main;

        this._lineage = document.createElement('ul');
        this.toolbar.appendChild(this._lineage);

        this._innerContainer = document.createElement('div');
        this.toolbar.appendChild(this._innerContainer);

        dfx.addClass(this.toolbar, 'ViperInlineToolbarPlugin');
        dfx.addClass(this._lineage, 'ViperInlineToolbarPlugin-lineage');
        dfx.addClass(this._innerContainer, 'ViperInlineToolbarPlugin-inner');

        document.body.appendChild(this.toolbar);

    },

    createButton: function(content, parentTag, customClass, clickAction)
    {
        var button = document.createElement('div');
        dfx.setHtml(button, content);
        dfx.addClass(button, 'ViperInlineToolbarPlugin-button');

        if (customClass) {
            dfx.addClass(button, customClass);
        }

        if (clickAction) {
            dfx.addEvent(button, 'mousedown.ViperInlineToolbarPlugin', clickAction);
        }

        return button;

    },

    updateToolbar: function(range)
    {
        if (this._lineageClicked === true) {
            this._lineageClicked = false;
            return;
        }

        // Determine what type of selection this is..
        if (range.collapsed === true) {
            // Hide the toolbar.
            // TODO: What about images, links etc?
            this.hideToolbar();
            return;
        }

        var lineage = this._getSelectionLineage(range);
        this._updateLineage(lineage);
        this._updateInnerContainer(range, lineage);
        this._updatePosition(range);

    },

    _updatePosition: function(range, verticalOnly)
    {
        var rangeCoords  = range.rangeObj.getBoundingClientRect();
        var scrollCoords = dfx.getScrollCoords();

        if (verticalOnly !== true) {
            dfx.addClass(this.toolbar, 'calcWidth');
            var toolbarWidth = dfx.getElementWidth(this.toolbar);
            dfx.removeClass(this.toolbar, 'calcWidth');

            var left = (rangeCoords.left + ((rangeCoords.right - rangeCoords.left) / 2) + scrollCoords.x) - (toolbarWidth / 2);
            dfx.setStyle(this.toolbar, 'left', left + 'px');
        }

        var top = (rangeCoords.bottom + 10 + scrollCoords.y);

        dfx.setStyle(this.toolbar, 'top', top + 'px');
        dfx.addClass(this.toolbar, 'visible');

    },

    _updateLineage: function(lineage)
    {
        dfx.empty(this._lineage);

        var viper = this.viper;
        var c     = lineage.length;

        var originalRange = viper.getCurrentRange().cloneRange();

        var self = this;
        for (var i = 0; i < c; i++) {
            var tagName = lineage[i].tagName.toLowerCase();
            var parent  = document.createElement('li');
            dfx.setHtml(parent, this.getReadableTagName(tagName));
            this._lineage.appendChild(parent);

            (function(clickElem, selectionElem) {
                dfx.addEvent(clickElem, 'mousedown.ViperInlineToolbarPlugin', function() {
                    self._lineageClicked = true;
                    var range = viper.getCurrentRange();
                    range.selectNode(selectionElem);
                    ViperSelection.addRange(range);
                    viper.fireSelectionChanged();
                    self._updatePosition(range, true);
                    return false;
                });
            }) (parent, lineage[i]);
        }

        var parent  = document.createElement('li');
        dfx.setHtml(parent, 'Selection');
        this._lineage.appendChild(parent);
        dfx.addEvent(parent, 'mousedown.ViperInlineToolbarPlugin', function() {
            self._lineageClicked = true;
            ViperSelection.addRange(originalRange);
            viper.fireSelectionChanged(originalRange);
            self._updatePosition(originalRange, true);
            return false;
        });

    },

    _updateInnerContainer: function(range, lineage)
    {
        dfx.empty(this._innerContainer);
        this.viper.fireCallbacks('ViperInlineToolbarPlugin:updateToolbar', {container: this._innerContainer, range: range, lineage: lineage});

    },

    hideToolbar: function()
    {
        dfx.removeClass(this.toolbar, 'visible');

    },

    _getSelectionLineage: function(range)
    {
        var lineage      = [];
        var parent       = range.getCommonElement();
        var viperElement = this.viper.getViperElement();

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

    },

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
        }

        return tagName;
    }

};
