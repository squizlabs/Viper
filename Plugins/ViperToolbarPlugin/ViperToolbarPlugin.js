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

    this._activePopup = null;

    this.createToolbar();

    var self = this;
    this.viper.registerCallback('Viper:selectionChanged', 'ViperToolbarPlugin', function(range) {
        if (self.viper.rangeInViperBounds(range) === false) {
            return;
        }

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

        dfx.addEvent(elem, 'mousedown', function(e) {
            dfx.preventDefault(e);
            return false;
        });

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
     * @param {DOMElement} toolsPopup     The tools popup element see createToolsPopup.
     *
     * @return {DOMElement} The new button element.
     */
    createButton: function(content, isActive, titleAttr, disabled, customClass, clickAction, groupElement, toolsPopup, parentElement)
    {
        var button = ViperTools.createButton(content, isActive, titleAttr, disabled, customClass, clickAction, groupElement);
        if (toolsPopup) {
            var self = this;
            dfx.addEvent(button, 'mousedown', function() {
                dfx.removeClass(dfx.getClass('selected', this._toolbar), 'selected');

                var toolPopups = dfx.getClass('ViperITP forTopbar');
                for (var i = 0; i < toolPopups.length; i++) {
                    if (toolPopups[i] !== toolsPopup.element && toolPopups[i].parentNode) {
                        toolPopups[i].parentNode.removeChild(toolPopups[i]);
                    }
                }

                if (toolsPopup.element.parentNode) {
                    self.closePopup(toolsPopup);
                    self._activePopup = null;
                } else {
                    self._activePopup = toolsPopup;
                    if (toolsPopup.init) {
                        toolsPopup.init();
                    }

                    document.body.appendChild(toolsPopup.element);
                    var toolsWidth = dfx.getElementWidth(toolsPopup.element);
                    dfx.addClass(button, 'selected');

                    var elemDim = dfx.getBoundingRectangle(button);
                    dfx.setStyle(toolsPopup.element, 'left', elemDim.x1 + ((elemDim.x2 - elemDim.x1) / 2) - (toolsWidth / 2)  + 'px');
                    dfx.setStyle(toolsPopup.element, 'top', elemDim.y2 + 8 + 'px');
                }
            });
        }

        if (!groupElement) {
            if (!parentElement) {
                this._toolbar.appendChild(button);
            }
        }

        return button;
    },

    /**
     * Creates a textbox.
     *
     * @param {string}   value      The initial value of the textbox.
     * @param {string}   label      The label of the textbox.
     * @param {function} action     The function to call when the textbox value is updated.
     * @param {boolean}  required   True if this field is required.
     * @param {boolean}  expandable If true then the textbox will expand when focused.
     *
     * @return {DOMNode} If label specified the label element else the textbox element.
     */
    createTextbox: function(value, label, action, required, expandable)
    {
        var textBox = document.createElement('input');
        dfx.addClass(textBox, 'ViperITP-input');
        textBox.type  = 'text';
        textBox.size  = 10;
        textBox.value = value;

        var self  = this;

        var t = null;
        dfx.addEvent(textBox, 'focus', function(e) {
            dfx.addClass(labelElem, 'active');
        });

        dfx.addEvent(textBox, 'blur', function(e) {
            ViperSelection.addRange(self.viper.getViperRange());

            dfx.removeClass(labelElem, 'active');
            clearTimeout(t);
            if (self._activePopup) {
                self.closePopup(self._activePopup);
                self._activePopup = null;
            }
        });

        dfx.addEvent(textBox, 'keyup', function(e) {
            if (e.which === 13) {
                self.viper.focus();
                action.call(textBox, textBox.value);
                return;
            }

            dfx.addClass(labelElem, 'active');

          //  clearTimeout(t);
          //  t = setTimeout(function() {
          //      ViperSelection.addRange(self.viper.getViperRange());
          //
          //      dfx.removeClass(labelElem, 'active');
          //      action.call(textBox, textBox.value);
          //  }, 1500);
        });

        if (label) {
            var labelElem = document.createElement('label');
            dfx.addClass(labelElem, 'ViperITP-label');
            var span = document.createElement('span');
            dfx.addClass(span, 'ViperITP-labelText');
            dfx.setHtml(span, label);

            document.body.appendChild(span);
            var width = dfx.getElementWidth(span);
            dfx.setStyle(labelElem, 'padding-left', width + 'px');
            labelElem.appendChild(span);
            labelElem.appendChild(textBox);

            if (required === true) {
                dfx.addClass(labelElem, 'required');
            }

            if (expandable === true) {
                dfx.addClass(labelElem, 'expandable');
            }

            return labelElem;
        }

        return textBox;

    },

    /**
     * Creates a popup for extra tools for a button.
     *
     * @return {DOMElement} The sub section element.
     */
    createToolsPopup: function(title, toolsContentElement, subContentElements, customClass, popupInitCallback)
    {
        var tools = document.createElement('div');
        dfx.addClass(tools, 'ViperITP themeDark visible forTopbar');
        if (title) {
            dfx.setHtml(tools, '<div class="ViperITP-header">' + title + '</div>');
        }

        dfx.addEvent(tools, 'mousedown', function(e) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isTag(target, 'input') !== true) {
                dfx.preventDefault(e);
                return false;
            }
        });

        if (toolsContentElement) {
            dfx.addClass(toolsContentElement, 'ViperITP-tools');
            tools.appendChild(toolsContentElement);

            if (hideToolsBar === true) {
                dfx.setStyle(toolsContentElement, 'display', 'none');
            }
        }

        if (customClass) {
            dfx.addClass(tools, customClass);
        }

        if (subContentElements && subContentElements.length > 0) {
            var subWrapper = document.createElement('div');
            dfx.addClass(subWrapper, 'ViperITP-subSectionWrapper');
            tools.appendChild(subWrapper);
            for (var i = 0; i < subContentElements.length; i++) {
                subWrapper.appendChild(subContentElements[i]);
                if (dfx.hasClass(subContentElements[i], 'active') === true) {
                    dfx.addClass(tools, 'subSectionVisible');
                }
            }
        }

        var popup = {
            init: popupInitCallback || function() {},
            element: tools
        }

        return popup;

    },

    closePopup: function(popup)
    {
        popup = popup || this._activePopup;

        if (!popup || !popup.element || !popup.element.parentNode) {
            return;
        }

        popup.element.parentNode.removeChild(popup.element);
        dfx.removeClass(dfx.getClass('selected', this._toolbar), 'selected');

    },

    /**
     * Creates a sub section element.
     *
     * @param {DOMElement} contentElement The content element.
     * @param {boolean}    active         True if the subsection is active.
     * @param {string}     customClass    Custom class to apply to the group.
     *
     * @return {DOMElement} The sub section element.
     */
    createSubSection: function(contentElement, active, customClass)
    {
        var subSection = ViperTools.createSubSection(contentElement, active, customClass);
        return subSection;

    },

    /**
     * Creates a new sub section row and returns the new DOMElement.
     *
     * @return {DOMElement} The sub section row element.
     */
    createSubSectionRow: function()
    {
        var elem = document.createElement('div');
        dfx.addClass(elem, 'subSectionRow');
        return elem;

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
