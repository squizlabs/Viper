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

function ViperToolbarPlugin(viper)
{
    this.viper    = viper;
    this._toolbar = null;

    this._activeBubble   = null;
    this._bubbles        = {};
    this._bubbleButtons  = {};
    this._settingButtons = null;
    this._enabled        = false;
    this._enabledButtons = [];

    this.createToolbar();

    var self           = this;
    var clickedOutside = true;
    this.viper.registerCallback('Viper:selectionChanged', 'ViperToolbarPlugin', function(range) {
        if (clickedOutside === true || self.viper.rangeInViperBounds(range) === false) {
            return;
        }

        if (self._enabled !== true) {
            self.enable();
        }

        self._updateToolbar(range);
    });

    this.viper.registerCallback('Viper:editableElementChanged', 'ViperToolbarPlugin', function(range) {
            self._updateToolbar();
    });

    this.viper.registerCallback('Viper:enabled', 'ViperToolbarPlugin', function(range) {
        self._updateToolbar();
    });

    this.viper.registerCallback('Viper:disabled', 'ViperToolbarPlugin', function(range) {
            self.disable();
    });

    this.viper.registerCallback('Viper:clickedOutside', 'ViperToolbarPlugin', function(range) {
        clickedOutside = true;

        // Disable all buttons.
        self.disable();
    });

    this.viper.registerCallback('Viper:clickedInside', 'ViperToolbarPlugin', function(range) {
        clickedOutside = false;
    });

    this.viper.registerCallback('Viper:focused', 'ViperToolbarPlugin', function(range) {
        self.enable();
    });

    this.viper.registerCallback('Viper:mouseDown', 'ViperToolbarPlugin', function() {
        if (self._activeBubble) {
            var bubble = self.getBubble(self._activeBubble);
            if (bubble && bubble.getSetting('keepOpen') !== true) {
                self.closeBubble(self._activeBubble);
            }
        }
    });

    this.viper.registerCallback('Viper:destroy', 'ViperToolbarPlugin', function(range) {
        self.remove();
    });

}

ViperToolbarPlugin.prototype = {
    init: function()
    {
        this.viper.addElement(this._toolbar);

    },

    setSettings: function(settings)
    {
        if (!settings) {
            return;
        }

        if (settings.parent) {
            var parent = settings.parent;
            if (typeof parent === 'string') {
                parent = ViperUtil.getid(settings.parent);
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
        if (this.viper.isBrowser('msie') === true) {
            while(this._toolbar.firstChild) {
                this._toolbar.removeChild(this._toolbar.firstChild);
            }
        } else {
            this._toolbar.innerHTML = '';
        }


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

        this._settingButtons = null;

    },

    createToolbar: function()
    {
        var elem = document.createElement('div');


        ViperUtil.addClass(elem, 'ViperTP-bar Viper-themeDark Viper-scalable');
        this._toolbar = elem;
        ViperUtil.addClass(this._toolbar, 'viper-inactive');
        ViperUtil.addClass(this._toolbar, this.viper.getElementHolder().className);

        ViperUtil.addEvent(elem, 'mousedown', function(e) {
            var target = ViperUtil.getMouseEventTarget(e);
            if (ViperUtil.isTag(target, 'input') !== true
                && ViperUtil.isTag(target, 'textarea') !== true
                && ViperUtil.isTag(target, 'select') !== true
            ) {
                ViperUtil.preventDefault(e);
                return false;
            }
        });

        ViperUtil.addEvent(elem, 'mouseup', function(e) {
            var target = ViperUtil.getMouseEventTarget(e);
            if (ViperUtil.isTag(target, 'input') !== true
                && ViperUtil.isTag(target, 'textarea') !== true
                && ViperUtil.isTag(target, 'select') !== true
            ) {
                ViperUtil.preventDefault(e);
                return false;
            }
        });

        if (navigator.userAgent.match(/iPad/i) !== null) {
            ViperUtil.addClass(this._toolbar, 'device-ipad');
        }

    },

    setParentElement: function(parent)
    {
        ViperUtil.setStyle(this._toolbar, 'position', 'absolute');
        ViperUtil.setStyle(this._toolbar, 'top', '0px');
        parent.appendChild(this._toolbar);

        this.positionUpdated();

    },

    positionUpdated: function()
    {
        this.positionBubble();
        this.viper.fireCallbacks('ViperToolbarPlugin:positionUpdated');

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
        ViperUtil.addClass(bubble, 'ViperITP Viper-themeDark Viper-visible Viper-forTopbar');
        ViperUtil.setHtml(bubble, '<div class="ViperITP-header">' + title + '</div>');

        ViperUtil.addEvent(bubble, 'mousedown', function(e) {
            var target = ViperUtil.getMouseEventTarget(e);
            if (ViperUtil.isTag(target, 'input') !== true
                && ViperUtil.isTag(target, 'textarea') !== true
                && ViperUtil.isTag(target, 'select') !== true
            ) {
                ViperUtil.preventDefault(e);
                return false;
            }
        });

        if (toolsElement) {
            var wrapper = document.createElement('div');
            ViperUtil.addClass(wrapper, 'ViperITP-tools');
            bubble.appendChild(wrapper);
            wrapper.appendChild(toolsElement);
        }

        if (customClass) {
            ViperUtil.addClass(bubble, customClass);
        }

        var self = this;

        this._bubbles[id] = bubble;
        var bubbleObj     = {
            type: 'VTPBubble',
            element: bubble,
            addSubSection: function(id, element) {
                var wrapper = ViperUtil.getClass('ViperITP-subSectionWrapper', bubble);
                if (wrapper.length > 0) {
                    wrapper = wrapper[0];
                } else {
                    wrapper = document.createElement('div');
                    ViperUtil.setHtml(wrapper, '<span class="Viper-subSectionArrow"></span>');
                    ViperUtil.addClass(wrapper, 'ViperITP-subSectionWrapper');
                    bubble.appendChild(wrapper);
                }

                var form = document.createElement('form');
                ViperUtil.addClass(form, 'Viper-subSection');
                form.onsubmit = function() {
                    return false;
                };

                var submitBtn  = document.createElement('input');
                submitBtn.type = 'submit';
                ViperUtil.setStyle(submitBtn, 'display', 'none');
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

                ViperUtil.addClass(bubble, 'Viper-subSectionVisible');
                ViperUtil.addClass(this._subSections[id], 'Viper-active');

                if (this._subSectionButtons[id]) {
                    var button = this._subSectionButtons[id].element;
                    ViperUtil.addClass(button, 'Viper-selected');

                    // Update the position of the sub section arrow.
                    var subSectionArrow = ViperUtil.getClass('Viper-subSectionArrow', bubble)[0];
                    var pos             = ViperUtil.getBoundingRectangle(button);
                    var bubblePos       = ViperUtil.getBoundingRectangle(bubble);
                    ViperUtil.setStyle(subSectionArrow, 'left', (pos.x1 - bubblePos.x1) + ((pos.x2 - pos.x1) / 2) + 'px');
                    ViperUtil.addClass(subSectionArrow, 'Viper-visible');
                }

                var inputElements = ViperUtil.getTag('input[type=text], textarea', this._subSections[id]);
                if (inputElements.length > 0 && ViperUtil.getElementHeight(inputElements[0]) > 0) {
                    try {
                        setTimeout(function() {
                            inputElements[0].focus();
                        }, 10);
                    } catch(e) {}
                }

                this._activeSubSection = id;
            },
            hideSubSection: function(id) {
                id = id || this._activeSubSection;
                ViperUtil.removeClass(bubble, 'Viper-subSectionVisible');
                ViperUtil.removeClass(this._subSections[id], 'Viper-active');
                this._activeSubSection = null;

                if (this._subSectionButtons[id]) {
                    ViperUtil.removeClass(this._subSectionButtons[id].element, 'Viper-selected');
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

                subSection.form.onsubmit = function(e) {
                    self.viper.focus();

                    if (e) {
                        ViperUtil.preventDefault(e);
                    }

                    var button = tools.getItem(subSectionid + '-applyButton');
                    if (button.isEnabled() === false) {
                        return false;
                    }

                    tools.disableButton(subSectionid + '-applyButton');

                    // IE needs this timeout so focus works <3..
                    if (self.viper.isBrowser('msie') === false) {
                        try {
                            action.call(this);
                        } catch (e) {
                            console.error(e.message);
                        }

                        // Give focus back to the form field.
                        var inputElements = ViperUtil.getTag('input[type=text], textarea', subSection.form);
                        if (inputElements.length > 0) {
                            try {
                                inputElements[0].focus();
                            } catch(e) {}
                        }
                    } else {
                        setTimeout(function() {
                            try {
                                action.call(this);
                            } catch (e) {
                                console.error(e.message);
                            }

                            // Give focus back to the form field.
                            var inputElements = ViperUtil.getTag('input[type=text], textarea', subSection.form);
                            if (inputElements.length > 0) {
                                try {
                                    inputElements[0].focus();
                                } catch(e) {}
                            }
                        }, 10);
                    }//end if

                    return false;
                };

                var button = tools.createButton(subSectionid + '-applyButton', _('Apply Changes'), _('Apply Changes'), '', subSection.form.onsubmit, true);
                subSection.form.appendChild(button);

                this.addSubSectionActionWidgets(subSectionid, widgetids);

            },
            addSubSectionActionWidgets: function(subSectionid, widgetids)
            {
                if (!this._subSectionActionWidgets[subSectionid]) {
                    this._subSectionActionWidgets[subSectionid] = [];
                }

                var subsec = this;
                var tools  = self.viper.ViperTools;
                for (var i = 0; i < widgetids.length; i++) {
                    this._subSectionActionWidgets[subSectionid].push(widgetids[i]);
                    (function(widgetid) {
                        self.viper.registerCallback('ViperTools:changed:' + widgetid, 'ViperToolbarPlugin', function() {
                            var subSectionWidgets = subsec._subSectionActionWidgets[subSectionid];
                            var c = subSectionWidgets.length;
                            var enable = true;
                            for (var j = 0; j < c; j++) {
                                var widget = tools.getItem(subSectionWidgets[j]);
                                if (widget.required === true && ViperUtil.trim(widget.getValue()) === '') {
                                    enable = false;
                                    break;
                                }
                            }

                            if (enable === true) {
                                tools.enableButton(subSectionid + '-applyButton');
                            } else {
                                tools.disableButton(subSectionid + '-applyButton');
                            }
                        });
                    }) (widgetids[i]);
                }

            },
            setSetting: function(setting, value) {
                this._settings[setting] = value;
            },
            getSetting: function(setting) {
                return this._settings[setting];
            },
            setTitle: function(title) {
                ViperUtil.setHtml(ViperUtil.getClass('ViperITP-header', bubble)[0], title);
            },
            getActiveSubSection: function() {
                return this._subSections[this._activeSubSection];
            },
            _settings: {
                keepOpen: false
            },
            _subSections: {},
            _subSectionButtons: {},
            _activeSubSection: null,
            _openCallback: openCallback,
            _closeCallback: closeCallback,
            _subSectionActionWidgets: {}
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
            ViperUtil.removeEvent(button, 'mousedown');
            ViperUtil.addEvent(button, 'mousedown', function(e) {
                if (self.viper.isBrowser('msie') === true) {
                    // This block of code prevents IE moving user selection to the.
                    // button element when clicked. When the button element is removed
                    // and added back to DOM selection is not moved. Seriously, IE?
                    if (button.previousSibling) {
                        var sibling = button.previousSibling;
                        button.parentNode.removeChild(button);
                        ViperUtil.insertAfter(sibling, button);
                    } else if (button.nextSibling) {
                        var sibling = button.nextSibling;
                        button.parentNode.removeChild(button);
                        ViperUtil.insertBefore(sibling, button);
                    } else {
                        var parent = button.parentNode;
                        button.parentNode.removeChild(button);
                        parent.appendChild(button);
                    }
                }//end if

                if (ViperUtil.hasClass(button, 'Viper-disabled') === true) {
                    return;
                }

                self.toggleBubble(bubbleid);
                ViperUtil.preventDefault(e);
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
        if (!this._activeBubble) {
            return;
        }

        if (this._closeBubble(bubbleid) !== false) {
            this.viper.focus();
            this.viper.highlightToSelection();
        }

    },

    _closeBubble: function(bubbleid)
    {
        ViperUtil.removeClass(this.viper.ViperTools.getItem(this._bubbleButtons[bubbleid]).element, 'Viper-selected');
        var bubble     = this.viper.ViperTools.getItem(bubbleid);
        var bubbleElem = bubble.element;
        if (bubbleElem.parentNode && bubbleElem.parentNode.nodeType !== ViperUtil.DOCUMENT_FRAGMENT_NODE) {
            bubbleElem.parentNode.removeChild(bubbleElem);
        } else {
            return false;
        }

        if (bubble._closeCallback) {
            bubble._closeCallback.call(this);
        }

        if (this._activeBubble === bubbleid) {
            this._activeBubble = null;
        }

        ViperUtil.removeEvent(document, 'keydown.ViperToolbarPluginSubSection');

    },

    showBubble: function(bubbleid)
    {
        if (this._activeBubble) {
            if (this._activeBubble === bubbleid) {
                // Already showing.
                return;
            }

            // Hide the current active bubble.
            this._closeBubble(this._activeBubble);
        }

        ViperUtil.addClass(this.viper.ViperTools.getItem(this._bubbleButtons[bubbleid]).element, 'Viper-selected');

        var bubble     = this.viper.ViperTools.getItem(bubbleid);
        var bubbleElem = bubble.element;

        if (bubble._openCallback) {
            bubble._openCallback.call(this);
        }

        if (!bubbleElem.parentNode || bubbleElem.parentNode.nodeType === ViperUtil.DOCUMENT_FRAGMENT_NODE) {
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

        var inputElements = ViperUtil.getTag('input[type=text], textarea', bubbleElem);
        if (inputElements.length > 0) {
            try {
                inputElements[0].focus();
                if (this.viper.isBrowser('msie') === true) {
                    setTimeout(function() {
                        inputElements[0].focus();
                    }, 10);
                }
            } catch(e) {}
        }

        var inlineToolbarPlugin = this.viper.getPluginManager().getPlugin('ViperInlineToolbarPlugin');
        if (inlineToolbarPlugin) {
            inlineToolbarPlugin.hideToolbar();
        }

        ViperUtil.removeEvent(document, 'keydown.ViperToolbarPluginSubSection');
        ViperUtil.addEvent(document, 'keydown.ViperToolbarPluginSubSection', function(e) {
            if (e.which === 13 && bubble.getActiveSubSection()) {
                return bubble.getActiveSubSection().onsubmit();
            }
        });

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

        var toolsWidth = null;
        var widthStyle = bubble.style.width;

        toolsWidth = ViperUtil.getElementWidth(bubble);

        var scrollCoords = ViperUtil.getScrollCoords();
        var windowDim    = ViperUtil.getWindowDimensions();
        var elemDim      = ViperUtil.getBoundingRectangle(button);
        var toolbarDim   = ViperUtil.getBoundingRectangle(this._toolbar);

        var left = ((elemDim.x1 + ((elemDim.x2 - elemDim.x1) / 2) - (toolsWidth / 2) - scrollCoords.x) - toolbarDim.x1);

        if ((left + toolsWidth) >= windowDim.width) {
            left -= ((toolsWidth / 2) - 40);
            ViperUtil.addClass(bubble, 'Viper-orientationLeft');
        } else {
            ViperUtil.removeClass(bubble, 'Viper-orientationLeft');
        }

        ViperUtil.setStyle(bubble, 'left', left + 'px');
        ViperUtil.setStyle(bubble, 'top', '35px');

        if (!widthStyle) {
            ViperUtil.setStyle(bubble, 'width', toolsWidth + 'px');
        }

    },

    disable: function()
    {
        if (this._enabled === false) {
            return;
        }

        this._enabled = false;

        ViperUtil.removeClass(this._toolbar, 'viper-active');
        ViperUtil.addClass(this._toolbar, 'viper-inactive');

        // Close active bubble.
        if (this._activeBubble) {
            this.closeBubble(this._activeBubble);
        }

        // Get all buttons in the toolbar and disable them.
        var buttons = ViperUtil.getClass('Viper-button', this._toolbar);
        var c       = buttons.length;
        var viperid = this.viper.getId();
        var enabledButtons = [];
        for (var i = 0; i < c; i++) {
            var buttonid = buttons[i].id.replace(viperid + '-', '');
            if (this.viper.ViperTools.getItem(buttonid).isEnabled() === true) {
                enabledButtons.push(buttonid);
            }

            this.viper.ViperTools.disableButton(buttonid);
        }

        this._enabledButtons = enabledButtons;

        this.viper.fireCallbacks('ViperToolbarPlugin:disabled');

    },

    enable: function()
    {
        if (this._enabled === true) {
            return;
        }

        this._enabled = true;
        ViperUtil.removeClass(this._toolbar, 'viper-inactive');
        ViperUtil.addClass(this._toolbar, 'viper-active');

        this.viper.fireCallbacks('ViperToolbarPlugin:enabled');

        while (this._enabledButtons.length) {
            this.viper.ViperTools.enableButton(this._enabledButtons.pop());
        }

    },

    hide: function()
    {
        ViperUtil.setStyle(this._toolbar, 'display', 'none');

    },

    show: function()
    {
        ViperUtil.setStyle(this._toolbar, 'display', 'block');

    },

    isDisabled: function()
    {
        return !this._enabled;

    },

    isVisible: function()
    {
        if (ViperUtil.getStyle(this._toolbar, 'display') === 'none') {
            return false;
        }

        return true;

    },

    exists: function()
    {
        if (this._toolbar) {
            return true;
        }

        return false;

    },

    remove: function()
    {
        ViperUtil.remove(this._toolbar);

    },

    isPluginElement: function(element)
    {
        if (element !== this._toolbar && ViperUtil.isChildOf(element, this._toolbar) === false) {
            return false;
        }

        return true;

    },

    _updateToolbar: function(range)
    {
        if (this.viper.isEnabled() === false) {
            return;
        }

        if (this.viper.isBrowser('msie') === true) {
            // IE fix.. When a toolbar button is clicked IE moves the selection to that
            // button unless the button no longer exists... So we remove the toolbar
            // here to prevent selection changing......
            var parent = this._toolbar.parentNode;
            parent.removeChild(this._toolbar);
        }

        range = range || this.viper.getCurrentRange();

        this.viper.fireCallbacks('ViperToolbarPlugin:updateToolbar', {range: range});

        if (this.viper.isBrowser('msie') === true) {
            parent.appendChild(this._toolbar);
        }

    }

};
