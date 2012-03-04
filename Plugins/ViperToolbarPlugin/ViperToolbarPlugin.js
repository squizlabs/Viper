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

    this._activeBubble   = null;
    this._bubbles        = {};
    this._bubbleButtons  = {};
    this._settingButtons = null;

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

    this.viper.registerCallback('Viper:mouseDown', 'ViperToolbarPlugin', function() {
        if (self._activeBubble) {
            var bubble = self.getBubble(self._activeBubble);
            if (bubble && bubble.getSetting('keepOpen') !== true) {
                self.closeBubble(self._activeBubble);
            }
        }
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

        if (settings.buttons) {
            this.setButtons(settings.buttons);
        }

    },

    setButtons: function(buttons)
    {
        this._settingButtons = buttons;

        // Remove all buttons that were adding by other plugins.
        this._toolbar.innerHTML = '';

        var buttonsLen = buttons.length;
        for (var i = 0; i < buttonsLen; i++) {
            if (typeof buttons[i] === 'string') {
                // Single button.
                var button = this.viper.ViperTools.getItem(buttons[i]);
                if (!button || button.type !== 'button') {
                    throw new Error('Invalid button type: ' + buttons[i]);
                }

                this._toolbar.appendChild(button.element);
            } else if (buttons[i].length) {
                // Create button group.
                var groupid = 'ViperToolbarPlugin:buttons:' + i;
                var group   = this.viper.ViperTools.createButtonGroup(groupid);

                var subButtonsLen = buttons[i].length;
                for (var j = 0; j < subButtonsLen; j++) {
                    var button = this.viper.ViperTools.getItem(buttons[i][j]);
                    if (!button || button.type !== 'button') {
                        throw new Error('Invalid button type: ' + buttons[i][j]);
                    }

                    this.viper.ViperTools.addButtonToGroup(buttons[i][j], groupid);
                }

                this._toolbar.appendChild(group);
            }
        }

    },

    createToolbar: function()
    {
        var elem = document.createElement('div');
        dfx.addClass(elem, 'ViperTP-bar themeDark Viper-scalable');
        this._toolbar = elem;

        dfx.addEvent(elem, 'mousedown', function(e) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isTag(target, 'input') !== true && dfx.isTag(target, 'textarea') !== true) {
                dfx.preventDefault(e);
                return false;
            }
        });

        dfx.addEvent(elem, 'mouseup', function(e) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isTag(target, 'input') !== true  && dfx.isTag(target, 'textarea') !== true) {
                dfx.preventDefault(e);
                return false;
            }
        });

        if (navigator.userAgent.match(/iPad/i) !== null) {
            dfx.addClass(this._toolbar, 'device-ipad');
        }

    },

    setParentElement: function(parent)
    {
        dfx.setStyle(this._toolbar, 'position', 'absolute');
        dfx.setStyle(this._toolbar, 'top', '0px');
        parent.appendChild(this._toolbar);

    },

    /**
     * Adds the specified button or button group element to the tools panel.
     *
     * @param {DOMNode} button The button or the button group element.
     *
     * @return void
     */
    addButton: function(button)
    {
        if (!this._settingButtons) {
            this._toolbar.appendChild(button);
        }

    },

    createBubble: function(id, title, subSectionElement, toolsElement, openCallback, closeCallback, customClass)
    {
        title = title || '&nbsp;';

        var bubble = document.createElement('div');
        dfx.addClass(bubble, 'ViperITP themeDark visible forTopbar');
        dfx.setHtml(bubble, '<div class="ViperITP-header">' + title + '</div>');

        dfx.addEvent(bubble, 'mousedown', function(e) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isTag(target, 'input') !== true  && dfx.isTag(target, 'textarea') !== true) {
                dfx.preventDefault(e);
                return false;
            }
        });

        if (toolsElement) {
            var wrapper = document.createElement('div');
            dfx.addClass(wrapper, 'ViperITP-tools');
            bubble.appendChild(wrapper);
            wrapper.appendChild(toolsElement);
        }

        if (customClass) {
            dfx.addClass(bubble, customClass);
        }

        var self = this;

        this._bubbles[id] = bubble;
        var bubbleObj     = {
            type: 'VTPBubble',
            element: bubble,
            addSubSection: function(id, element) {
                var wrapper = dfx.getClass('ViperITP-subSectionWrapper', bubble);
                if (wrapper.length > 0) {
                    wrapper = wrapper[0];
                } else {
                    wrapper = document.createElement('div');
                    dfx.setHtml(wrapper, '<span class="subSectionArrow"></span>');
                    dfx.addClass(wrapper, 'ViperITP-subSectionWrapper');
                    bubble.appendChild(wrapper);
                }

                var form = document.createElement('form');
                dfx.addClass(form, 'Viper-subSection');
                form.onsubmit = function() {
                    return false;
                };

                var submitBtn  = document.createElement('input');
                submitBtn.type = 'submit';
                dfx.setStyle(submitBtn, 'display', 'none');
                form.appendChild(submitBtn);

                form.appendChild(element);
                wrapper.appendChild(form);

                this._subSections[id] = form;
                self.viper.ViperTools.addItem(id, {
                    type: 'VTPSubSection',
                    element: wrapper,
                    form: form
                });

                return element;
            },
            showSubSection: function(id) {
                if (this._activeSubSection) {
                    if (this._activeSubSection !== id) {
                        this.hideSubSection(this._activeSubSection);
                    } else {
                        return;
                    }
                }

                dfx.addClass(bubble, 'subSectionVisible');
                dfx.addClass(this._subSections[id], 'active');

                if (this._subSectionButtons[id]) {
                    var button = this._subSectionButtons[id].element;
                    dfx.addClass(button, 'selected');

                    // Update the position of the sub section arrow.
                    var subSectionArrow = dfx.getClass('subSectionArrow', bubble)[0];
                    var pos             = dfx.getBoundingRectangle(button);
                    var bubblePos       = dfx.getBoundingRectangle(bubble);
                    dfx.setStyle(subSectionArrow, 'left', (pos.x1 - bubblePos.x1) + ((pos.x2 - pos.x1) / 2) + 'px');
                    dfx.addClass(subSectionArrow, 'visible');
                }

                var inputElements = dfx.getTag('input[type=text], textarea', this._subSections[id]);
                if (inputElements.length > 0) {
                    try {
                        inputElements[0].focus();
                    } catch(e) {}
                }

                this._activeSubSection = id;
            },
            hideSubSection: function(id) {
                id = id || this._activeSubSection;
                dfx.removeClass(bubble, 'subSectionVisible');
                dfx.removeClass(this._subSections[id], 'active');
                this._activeSubSection = null;

                if (this._subSectionButtons[id]) {
                    dfx.removeClass(this._subSectionButtons[id].element, 'selected');
                }
            },
            setSubSectionButton: function(sectionid, buttonid) {
                if (!this._subSections[sectionid]) {
                    return false;
                }

                var button = self.viper.ViperTools.getItem(buttonid);
                if (!button || !button.type === 'button') {
                    return false;
                }

                this._subSectionButtons[sectionid] = button;
            },
            setSubSectionAction: function(subSectionid, action, widgetids) {
                widgetids      = widgetids || [];
                var tools      = self.viper.ViperTools;
                var subSection = tools.getItem(subSectionid);
                if (!subSection) {
                    return;
                }

                subSection.form.onsubmit = function() {
                    tools.disableButton(subSectionid + '-applyButton');
                    self.viper.focus();

                    try {
                        action.call(this);
                    } catch (e) {
                        console.error(e.message);
                    }

                    return false;
                };

                var button = tools.createButton(subSectionid + '-applyButton', 'Update Changes', 'Update Changes', '', subSection.form.onsubmit, true);
                subSection.form.appendChild(button);

                for (var i = 0; i < widgetids.length; i++) {
                    self.viper.registerCallback('ViperTools:changed:' + widgetids[i], 'ViperToolbarPlugin', function() {
                        tools.enableButton(subSectionid + '-applyButton');
                    });
                }

            },
            setSetting: function(setting, value) {
                this._settings[setting] = value;
            },
            getSetting: function(setting) {
                return this._settings[setting];
            },
            _settings: {
                keepOpen: false
            },
            _subSections: {},
            _subSectionButtons: {},
            _activeSubSection: null,
            _openCallback: openCallback,
            _closeCallback: closeCallback
        };

        if (subSectionElement) {
            bubbleObj.addSubSection(id + 'SubSection', subSectionElement);
            if (!toolsElement) {
                bubbleObj.showSubSection(id + 'SubSection');
            }
        }

        this.viper.ViperTools.addItem(id, bubbleObj);

        return bubble;

    },

    getBubble: function(id)
    {
        return this.viper.ViperTools.getItem(id);

    },

    setBubbleButton: function(bubbleid, buttonid, useCustomToggler)
    {
        if (!this._bubbles[bubbleid]) {
            // Throw exception not a valid bubble id.
            return false;
        }

        var bubble = this.getBubble(bubbleid);
        var button = this.viper.ViperTools.getItem(buttonid).element;
        var self   = this;

        this._bubbleButtons[bubbleid] = buttonid;

        if (useCustomToggler !== true) {
            dfx.removeEvent(button, 'mousedown');
            dfx.addEvent(button, 'mousedown', function(e) {
                if (dfx.hasClass(button, 'disabled') === true) {
                    return;
                }

                self.toggleBubble(bubbleid);
                dfx.preventDefault(e);
            });
        }

    },

    toggleBubble: function(bubbleid)
    {
        if (!this._activeBubble || this._activeBubble !== bubbleid) {
            this.showBubble(bubbleid);
            return true;
        } else {
            this.closeBubble(bubbleid);
            return false;
        }

    },

    closeBubble: function(bubbleid)
    {
        dfx.removeClass(this.viper.ViperTools.getItem(this._bubbleButtons[bubbleid]).element, 'selected');
        var bubble     = this.viper.ViperTools.getItem(bubbleid);
        var bubbleElem = bubble.element;
        if (bubbleElem.parentNode) {
            bubbleElem.parentNode.removeChild(bubbleElem);
        }

        if (bubble._closeCallback) {
            bubble._closeCallback.call(this);
        }

        if (this._activeBubble === bubbleid) {
            this._activeBubble = null;
        }

        this.viper.highlightToSelection();

    },

    showBubble: function(bubbleid)
    {
        if (this._activeBubble) {
            if (this._activeBubble === bubbleid) {
                // Already showing.
                return;
            }

            // Hide the current active bubble.
            this.closeBubble(this._activeBubble);
        }

        dfx.addClass(this.viper.ViperTools.getItem(this._bubbleButtons[bubbleid]).element, 'selected');

        var bubble     = this.viper.ViperTools.getItem(bubbleid);
        var bubbleElem = bubble.element;

        if (bubble._openCallback) {
            bubble._openCallback.call(this);
        }

        if (!bubbleElem.parentNode) {
            this._toolbar.appendChild(bubbleElem);
        }

        // Before we show the bubble set all its sub section apply changes button
        // statuses to disabled.
        for (var subSectionid in bubble._subSections) {
            var applyChangesBtn = this.viper.ViperTools.getItem(subSectionid + '-applyButton');
            if (applyChangesBtn) {
                this.viper.ViperTools.disableButton(subSectionid + '-applyButton');
            }
        }

        this.positionBubble(bubbleid);

        this._activeBubble = bubbleid;

        var inputElements = dfx.getTag('input[type=text], textarea', bubbleElem);
        if (inputElements.length > 0) {
            try {
                inputElements[0].focus();
            } catch(e) {}
        }

        var inlineToolbarPlugin = this.viper.getPluginManager().getPlugin('ViperInlineToolbarPlugin');
        if (inlineToolbarPlugin) {
            inlineToolbarPlugin.hideToolbar();
        }

    },

    getActiveBubble: function()
    {
        if (!this._activeBubble) {
            return null;
        }

        return this.getBubble(this._activeBubble);

    },

    positionBubble: function(bubbleid)
    {
        bubbleid = bubbleid || this._activeBubble;
        if (!bubbleid) {
            return;
        }

        var bubble     = this.viper.ViperTools.getItem(bubbleid).element;
        var button     = this.viper.ViperTools.getItem(this._bubbleButtons[bubbleid]).element;
        var toolsWidth = dfx.getElementWidth(bubble);

        var scrollCoords = dfx.getScrollCoords();
        var windowDim    = dfx.getWindowDimensions();
        var elemDim      = dfx.getBoundingRectangle(button);

        var left = (elemDim.x1 + ((elemDim.x2 - elemDim.x1) / 2) - (toolsWidth / 2) - scrollCoords.x);
        var top  = (elemDim.y2 + 8 - scrollCoords.y);

        if ((left + toolsWidth) >= windowDim.width) {
            left -= ((toolsWidth / 2) - 40);
            dfx.addClass(bubble, 'orientationLeft');
        } else {
            dfx.removeClass(bubble, 'orientationLeft');
        }

        dfx.setStyle(bubble, 'left', left + 'px');
        dfx.setStyle(bubble, 'top', top + 'px');
        dfx.setStyle(bubble, 'width', toolsWidth + 'px');

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
