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
    this.viper   = viper;
    this.toolbar = null;
    this._innerContainer = null;

    this.createToolbar();

    var self = this;
    this.viper.registerCallback('Viper:selectionChanged', 'ViperInlineToolbarPlugin', function(range) {
        self.updateToolbar(range);
    });

    this.viper.registerCallback('Viper:mouseDown', 'ViperInlineToolbarPlugin', function(range) {
        self.hideToolbar();
    });

}

ViperInlineToolbarPlugin.prototype = {

    createToolbar: function()
    {
        var main     = document.createElement('div');
        this.toolbar = main;

        this._innerContainer = document.createElement('div');
        this.toolbar.appendChild(this._innerContainer);

        dfx.addClass(this.toolbar, 'ViperInlineToolbarPlugin');
        dfx.addClass(this._innerContainer, 'ViperInlineToolbarPlugin-inner');

        document.body.appendChild(this.toolbar);

    },

    updateToolbar: function(range)
    {
        // Determine what type of selection this is..
        if (range.collapsed === true) {
            // Hide the toolbar.
            // TODO: What about images, links etc?
            this.hideToolbar();
            return;
        }

        dfx.empty(this._innerContainer);
        this.viper.fireCallbacks('ViperInlineToolbarPlugin:updateToolbar', {container: this._innerContainer, range: range});

        var rangeCoords  = range.rangeObj.getBoundingClientRect();
        var scrollCoords = dfx.getScrollCoords();

        var left = (rangeCoords.left + ((rangeCoords.right - rangeCoords.left) / 2) + scrollCoords.x);
        var top  = (rangeCoords.bottom + 10 + scrollCoords.y);

        dfx.setStyle(this.toolbar, 'left', left + 'px');
        dfx.setStyle(this.toolbar, 'top', top + 'px');
        dfx.addClass(this.toolbar, 'visible');
    },

    hideToolbar: function()
    {
        dfx.removeClass(this.toolbar, 'visible');

    }

};
