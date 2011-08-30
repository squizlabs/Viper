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
 * @package    Viper
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
    this._margin = 10;

    this._createToolbar();

    var self = this;
    this.viper.registerCallback('Viper:selectionChanged', 'ViperInlineToolbarPlugin', function(range) {
        self.updateToolbar(range);
    });

    this.viper.registerCallback('Viper:mouseDown', 'ViperInlineToolbarPlugin', function(range) {
        self.hideToolbar();
    });

    dfx.addEvent(window, 'gesturestart', function() {
        self.hideToolbar();
    });

    dfx.addEvent(window, 'gestureend', function() {
        self.updateToolbar();
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

    createButton: function(content, tagName, customClass, clickAction)
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

        if (tagName) {
            dfx.attr(button, 'data-ViperInlineToolbarPlugin-tag', tagName);
        }

        return button;

    },

    updateToolbar: function(range)
    {
        this._scaleToolbar();

        range = range || this.viper.getCurrentRange();

        var lineage = this._getSelectionLineage(range);
        if (this._lineageClicked === true) {
            this._lineageClicked = false;
            this._updateActiveButtons(lineage);
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

     hideToolbar: function()
    {
        dfx.removeClass(this.toolbar, 'visible');

    },

    _scaleToolbar: function()
    {
        if (!this.toolbar) {
            return;
        }

        var self = this;
        var zoom   = (document.documentElement.clientWidth / window.innerWidth);
        var scale  = 1.2 / zoom;
        if (scale >= 1.2) {
            scale = 1.2;
            self._margin = 20;
        } else if (scale <= 0.5) {
            scale = 0.5;
            self._margin = -12;
        } else {
            self._margin = (-6 * zoom);
        }

        dfx.setStyle(self.toolbar, '-webkit-transform', 'scale(' + scale + ', ' + scale + ')');

    },

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

    _updatePosition: function(range, verticalOnly)
    {
        range = range || this.viper.getCurrentRange();

        var rangeCoords  = range.rangeObj.getBoundingClientRect();
        if (!rangeCoords) {
            return;
        }

        var scrollCoords = dfx.getScrollCoords();

        if (verticalOnly !== true) {
            dfx.addClass(this.toolbar, 'calcWidth');
            var toolbarWidth = dfx.getElementWidth(this.toolbar);
            dfx.removeClass(this.toolbar, 'calcWidth');

            var left = (rangeCoords.left + ((rangeCoords.right - rangeCoords.left) / 2) + scrollCoords.x) - (toolbarWidth / 2);
            dfx.setStyle(this.toolbar, 'left', left + 'px');
        }

        var top = (rangeCoords.bottom + this._margin + scrollCoords.y);

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

        if (originalRange.collapsed === true) {
            return;
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
