/**
 * JS Class for the Viper Toolbar Plugin.
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

function ViperToolbarPlugin(viper)
{
    this.viper    = viper;
    this._toolbar = null;

    this.createToolbar();

    var self = this;
    this.viper.registerCallback('Viper:selectionChanged', 'ViperToolbarPlugin', function(range) {
        self._updateToolbar(range);
    });

    this.viper.registerCallback('Viper:editableElementChanged', 'ViperToolbarPlugin', function() {
        self._updateToolbar();
    });

}

ViperToolbarPlugin.prototype = {
    init: function()
    {
        Viper.document.body.appendChild(this._toolbar);

    },

    setSettings: function(settings)
    {
        if (!settings) {
            return;
        }

        if (settings.parent) {
            var parent = settings.parent;
            if (typeof parent === 'string') {
                parent = dfx.getId(settings.parent);
            }

            this.setParentElement(parent);
        }

    },

    createToolbar: function()
    {
        var elem = document.createElement('div');
        dfx.addClass(elem, 'ViperTP-bar themeDark Viper-scalable');
        this._toolbar = elem;

    },

    setParentElement: function(parent)
    {
        dfx.setStyle(this._toolbar, 'position', 'absolute');
        dfx.setStyle(this._toolbar, 'top', '0px');
        parent.appendChild(this._toolbar);

    },

    /**
     * Creates a button group.
     *
     * @param {string} customClass Custom class to apply to the group.
     *
     * @return {DOMElement} The button group element.
     */
    createButtonGroup: function(customClass)
    {
        var group = document.createElement('div');
        dfx.addClass(group, 'Viper-buttonGroup');

        if (customClass) {
            dfx.addClass(group, customClass);
        }

        this._toolbar.appendChild(group);

        return group;

    },

    /**
     * Creates a toolbar button.
     *
     * @param {string}     content        The content of the button.
     * @param {string}     isActive       True if the button is active.
     * @param {string}     titleAttr      The title attribute for the button.
     * @param {boolean}    disabled       True if the button is disabled.
     * @param {string}     customClass    Class to add to the button for extra styling.
     * @param {function}   clickAction    The function to call when the button is clicked.
     *                                    Note that this action is ignored if the
     *                                    subSection param is specified. Clicking will
     *                                    then toggle the sub section visibility.
     * @param {DOMElement} groupElement   The group element that was created by createButtonGroup.
     * @param {DOMElement} subSection     The sub section element see createSubSection.
     * @param {boolean}    showSubSection If true then sub section will be visible.
     *                                    If another button later on also has this set to true
     *                                    then that button's sub section visible.
     *
     * @return {DOMElement} The new button element.
     */
    createButton: function(content, isActive, titleAttr, disabled, customClass, clickAction, groupElement, subSection, showSubSection)
    {
        var button = ViperTools.createButton(content, isActive, titleAttr, disabled, customClass, clickAction, groupElement, subSection, showSubSection);

        if (!groupElement) {
            this._toolbar.appendChild(button);
        }

        return button;
    },

    disableButton: function(buttonElement)
    {
        dfx.addClass(buttonElement, 'disabled');
        dfx.removeClass(buttonElement, 'active');
    },

    enableButton: function(buttonElement)
    {
        dfx.removeClass(buttonElement, 'disabled');

    },

    setButtonInactive: function(buttonElement)
    {
        dfx.removeClass(buttonElement, 'active');
    },

    setButtonActive: function(buttonElement)
    {
        dfx.addClass(buttonElement, 'active');
        dfx.removeClass(buttonElement, 'disabled');
    },

    remove: function()
    {
        dfx.remove(this._toolbar);

    },

    isPluginElement: function(element)
    {
        if (element !== this._toolbar && dfx.isChildOf(element, this._toolbar) === false) {
            return false;
        }

        return true;

    },

    _updateToolbar: function(range)
    {
        range = range || this.viper.getCurrentRange();

        this.viper.fireCallbacks('ViperToolbarPlugin:updateToolbar', {range: range});

    }

};
