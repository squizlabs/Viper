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

function ViperTools(viper)
{
    this.viper = viper;

    this._items = {};
    this._preventMouseUp = false;

    var self = this;
    this.viper.registerCallback('Viper:mouseUp', 'ViperTools', function(e) {
        if (self._preventMouseUp === true) {
            self._preventMouseUp = false;
            return false;
        }
    });

}

ViperTools.prototype = {

    addItem: function(id, item)
    {
        this._items[id] = item;

    },

    removeItem: function(id)
    {
        var item = this.getItem(id);
        if (!item) {
            return;
        }

        delete this._items[id];

        if (item.element) {
            dfx.remove(item.element);
        }

        this.viper.removeCallback(null, 'ViperTools-' + id);
        this.viper.removeCallback(null, id);

        this.viper.fireCallbacks('ViperTools:itemRemoved', id);
    },

    getItem: function(id)
    {
        return this._items[id];

    },

    createRow: function(id, customClass)
    {
        var elem = document.createElement('div');
        dfx.addClass(elem, 'Viper-subSectionRow');

        if (customClass) {
            dfx.addClass(elem, customClass);
        }

        this.addItem(id, {
            type: 'row',
            element: elem
        });

        return elem;

    },

    /**
     * Creates a button group.
     *
     * @param {string} customClass Custom class to apply to the group.
     *
     * @return {DOMElement} The button group element.
     */
    createButtonGroup: function(id, customClass)
    {
        var group = document.createElement('div');
        dfx.addClass(group, 'Viper-buttonGroup');

        if (customClass) {
            dfx.addClass(group, customClass);
        }

        this.addItem(id, {
            type: 'buttonGroup',
            element: group,
            buttons: []
        });

        return group;

    },


    /**
     * Creates a toolbar button.
     *
     * @param {string}     content        The content of the button.
     * @param {string}     titleAttr      The title attribute for the button.
     * @param {string}     customClass    Class to add to the button for extra styling.
     * @param {function}   clickAction    The function to call when the button is clicked.
     *                                    Note that this action is ignored if the
     *                                    subSection param is specified. Clicking will
     *                                    then toggle the sub section visibility.
     * @param {boolean}    disabled       True if the button is disabled.
     * @param {string}     isActive       True if the button is active.
     *
     * @return {DOMElement} The new button element.
     */
    createButton: function(id, content, titleAttr, customClass, clickAction, disabled, isActive)
    {
        if (!content) {
            if (customClass) {
                // Must be an icon button.
                content = '<span class="Viper-buttonIcon ' + customClass + '"></span>';
            } else {
                content = '';
            }

            content += '&nbsp;';
        }

        var button = document.createElement('div');
        button.setAttribute('id', this.viper.getId() + '-' + id);

        if (titleAttr) {
            if (disabled === true) {
                titleAttr = titleAttr + ' [Not available]';
            }

            button.setAttribute('title', titleAttr);
        }

        dfx.setHtml(button, content);
        dfx.addClass(button, 'Viper-button');

        if (disabled === true) {
            dfx.addClass(button, 'Viper-disabled');
        }

        if (customClass) {
            dfx.addClass(button, customClass);
        }

        var mouseUpAction  = function() {};
        var preventMouseUp = false;
        var self           = this;
        if (clickAction) {
            dfx.addEvent(button, 'mousedown.' + this.viper.getEventNamespace(), function(e) {
                if (self.viper.isBrowser('msie') === true) {
                    // This block of code prevents IE moving user selection to the.
                    // button element when clicked. When the button element is removed
                    // and added back to DOM selection is not moved. Seriously, IE?
                    if (button.previousSibling) {
                        var sibling = button.previousSibling;
                        button.parentNode.removeChild(button);
                        setTimeout(function() {
                            dfx.insertAfter(sibling, button);
                        }, 1);
                    } else if (button.nextSibling) {
                        var sibling = button.nextSibling;
                        button.parentNode.removeChild(button);
                        setTimeout(function() {
                            dfx.insertBefore(sibling, button);
                        }, 1);

                    } else {
                        var parent = button.parentNode;
                        button.parentNode.removeChild(button);
                        setTimeout(function() {
                            parent.appendChild(button);
                        }, 1);
                    }
                }//end if

                self._preventMouseUp = true;
                dfx.preventDefault(e);
                if (dfx.hasClass(button, 'Viper-disabled') === true) {
                    return false;
                }

                setTimeout(function() {
                    // Incase button is moved/removed during the click action.
                    self._preventMouseUp = false;
                }, 200);

                self.viper.fireCallbacks('ViperTools:buttonClicked', id);
                return clickAction.call(this, e);
            });
        }//end if

        dfx.addEvent(button, 'mouseup.' + this.viper.getEventNamespace(), function(e) {
            mouseUpAction.call(this, e);
            self._preventMouseUp = false;
            dfx.preventDefault(e);
            return false;
        });

        if (isActive === true) {
            dfx.addClass(button, 'Viper-active');
        }

        this.addItem(id, {
            type: 'button',
            element: button,
            setIconClass: function(iconClass)
            {
                var btnIconElem = dfx.getClass('Viper-buttonIcon', button);
                if (btnIconElem.length === 0) {
                    btnIconElem = document.createElement('span');
                    dfx.addClass(btnIconElem, 'Viper-buttonIcon');
                    dfx.insertBefore(button.firstChild, btnIconElem);
                } else {
                    btnIconElem = btnIconElem[0];
                    btnIconElem.className = 'Viper-buttonIcon';
                }

                dfx.addClass(btnIconElem, iconClass);
            },
            setButtonShortcut: function(key)
            {
                var extraTitleAttr = ' (' + key + ')';
                if (extraTitleAttr.indexOf('CTRL') >= 0) {
                    if (navigator.platform.indexOf('Mac') >= 0) {
                        extraTitleAttr = extraTitleAttr.replace('CTRL', 'CMD');
                    }
                }

                button.setAttribute('title', titleAttr + extraTitleAttr);

                self.viper.registerCallback('Viper:keyDown', 'ViperTools-' + id, function(e) {
                    if (self.viper.isKey(e, key) === true) {
                        if (dfx.hasClass(button, 'Viper-disabled') !== true) {
                            clickAction.call(e, button);
                        }

                        return false;
                    }
                });
            },
            setMouseUpAction: function(callback)
            {
                mouseUpAction = callback;
            },
            isEnabled: function()
            {
                return !this._disabled;
            },
            isActive: function()
            {
                return dfx.hasClass(button, 'Viper-active');
            },
            _disabled: disabled
        });

        return button;

    },

    addButtonToGroup: function(buttonid, groupid)
    {
        var button = this.getItem(buttonid);
        var group  = this.getItem(groupid);
        if (!button || !group || button.type !== 'button' || group.type !== 'buttonGroup') {
            throw new Error('Invalid argument for ViperTools.addButtonToGroup(\'' + buttonid + '\', \'' + groupid + '\')');
            return;
        }

        group.element.appendChild(button.element);
        group.buttons.push(buttonid);

    },

    setButtonInactive: function(buttonid)
    {
        dfx.removeClass(this.getItem(buttonid).element, 'Viper-active');

    },

    setButtonActive: function(buttonid)
    {
        var button = this.getItem(buttonid);

        dfx.addClass(button.element, 'Viper-active');
        this.enableButton(buttonid);

    },

    enableButton: function(buttonid)
    {
        var buttonObj = this.getItem(buttonid);
        if (buttonObj.isEnabled() === true) {
            return;
        }

        var button = buttonObj.element;

        var title = button.getAttribute('title');
        if (title) {
            button.setAttribute('title', title.replace(' [Not available]', ''));
        }

        dfx.removeClass(button, 'Viper-disabled');
        buttonObj._disabled = false;

    },

    disableButton: function(buttonid)
    {
        var buttonObj = this.getItem(buttonid);
        if (buttonObj.isEnabled() !== true) {
            return;
        }

        var button = buttonObj.element;
        var title  = button.getAttribute('title');
        if (title) {
            title = title.replace(' [Not available]', '');
            button.setAttribute('title', title + ' [Not available]');
        }

        dfx.addClass(button, 'Viper-disabled');
        buttonObj._disabled = true;

    },

    /**
     * Creates a textbox.
     *
     * @param {string}   value      The initial value of the textbox.
     * @param {string}   label      The label of the textbox.
     * @param {boolean}  required   True if this field is required.
     * @param {boolean}  expandable If true then the textbox will expand when focused.
     *
     * @return {DOMNode} If label specified the label element else the textbox element.
     */
    createTextbox: function(id, label, value, action, required, expandable, desc, events, labelWidth)
    {
        return this._createTextbox(id, label, value, action, required, expandable, desc, events, labelWidth);
    },

    createTextarea: function(id, label, value, required, desc, events, labelWidth, rows, cols)
    {
        return this._createTextbox(id, label, value, null, required, false, desc, events, labelWidth, true, rows, cols);

    },

    _createTextbox: function(id, label, value, action, required, expandable, desc, events, labelWidth, isTextArea, rows, cols)
    {
        label = label || '&nbsp;';
        value = value || '';

        var textBox = document.createElement('div');
        dfx.addClass(textBox, 'Viper-textbox');

        if (required === true && !value) {
            dfx.addClass(textBox, 'Viper-required');
        }

        var labelEl = document.createElement('label');
        dfx.addClass(labelEl, 'Viper-textbox-label');
        textBox.appendChild(labelEl);

        var main = document.createElement('div');
        dfx.addClass(main, 'Viper-textbox-main');
        labelEl.appendChild(main);

        var title = document.createElement('span');
        dfx.addClass(title, 'Viper-textbox-title');
        dfx.setHtml(title, label);

        if (labelWidth) {
            dfx.setStyle(title, 'width', labelWidth);
        }

        var width = 0;
        // Wrap the element in a generic class so the width calculation is correct
        // for the font size.
        var tmp = document.createElement('div');
        dfx.addClass(tmp, 'ViperITP');

        if (navigator.userAgent.match(/iPad/i) !== null) {
            dfx.addClass(tmp, 'device-ipad');
        }

        dfx.setStyle(tmp, 'display', 'block');
        tmp.appendChild(title);
        this.viper.addElement(tmp);
        width = (dfx.getElementWidth(title) + 10) + 'px';
        tmp.parentNode.removeChild(tmp);

        main.appendChild(title);

        var inputType = 'input';
        if (isTextArea === true) {
            inputType = 'textarea';
        }

        var input   = document.createElement(inputType);
        input.value = value;

        if (isTextArea === true) {
            dfx.addClass(input, 'Viper-textbox-textArea');
        } else {
            input.type = 'text';
            dfx.addClass(input, 'Viper-textbox-input');
        }

        dfx.setStyle(main, 'padding-left', width);
        main.appendChild(input);

        if (required === true) {
            input.setAttribute('placeholder', 'required');
        }

        if (desc) {
            // Description.
            var descEl = document.createElement('span');
            dfx.addClass(descEl, 'Viper-textbox-desc');
            dfx.setHtml(descEl, desc);
            textBox.appendChild(descEl);
        }

        var moveCaretToEnd = true;
        if (this.viper.isBrowser('msie') === true) {
            // Need to add this mouseDown event for IE to disable the caret moving
            // to the end of the text in the input field. When the mouse is clicked
            // the caret is placed to the start of the field instead of the end,
            // so when the mouse is used to focus in to the field we do not move it
            // to the end of the textbox.
            dfx.addEvent(input, 'mousedown', function(e) {
                moveCaretToEnd = false;
            });
        }

        var self = this;
        dfx.addEvent(input, 'focus', function(e) {
            dfx.addClass(textBox, 'Viper-focused');
            self.viper.highlightSelection();

            if (self.viper.isBrowser('msie') === true) {
                if (moveCaretToEnd === true) {
                    setTimeout(function() {
                        input.focus();
                        // Set the caret to the end of the textfield.
                        input.value = input.value;
                    }, 10);
                }

                moveCaretToEnd = true;
            } else {
                // Set the caret to the end of the textfield.
                input.value = input.value;
            }

            if (self.viper.isBrowser('firefox') === true) {
                if (dfx.isTag(e.originalEvent.explicitOriginalTarget, 'input') === false) {
                    setTimeout(function() {
                        input.selectionStart = input.value.length;
                    }, 2);
                }
            }
        });

        dfx.addEvent(input, 'blur', function() {
            dfx.removeClass(textBox, 'Viper-active');
        });

        var changed = false;
        var _addActionButton = function() {
            var actionIcon = document.createElement('span');
            dfx.addClass(actionIcon, 'Viper-textbox-action');
            main.appendChild(actionIcon);
            dfx.addEvent(actionIcon, 'click', function() {
                if (dfx.hasClass(textBox, 'Viper-actionRevert') === true) {
                    input.value = value;
                    dfx.removeClass(textBox, 'Viper-actionRevert');
                    dfx.addClass(textBox, 'Viper-actionClear');
                    actionIcon.setAttribute('title', 'Clear this value');
                } else if (dfx.hasClass(textBox, 'Viper-actionClear') === true) {
                    input.value = '';
                    dfx.removeClass(textBox, 'Viper-actionClear');
                    dfx.addClass(textBox, 'Viper-actionRevert');
                    actionIcon.setAttribute('title', 'Revert to original value');
                    if (required === true) {
                        dfx.addClass(textBox, 'Viper-required');
                    }
                }

                self.viper.fireCallbacks('ViperTools:changed:' + id);
            });

            return actionIcon;
        };

        if (value !== '' && isTextArea !== true) {
            var actionIcon = _addActionButton();
            actionIcon.setAttribute('title', 'Clear this value');
            dfx.addClass(textBox, 'Viper-actionClear');
        }

        dfx.addEvent(input, 'keyup', function(e) {
            dfx.addClass(textBox, 'Viper-focused');

            if (isTextArea !== true) {
                var actionIcon = dfx.getClass('Viper-textbox-action', main);
                if (actionIcon.length === 0) {
                    actionIcon = _addActionButton();
                } else {
                    actionIcon = actionIcon[0];
                }
            }

            dfx.showElement(actionIcon);

            dfx.removeClass(textBox, 'Viper-actionClear');
            dfx.removeClass(textBox, 'Viper-actionRevert');

            if (input.value !== value && value !== '') {
                // Show the revert icon.
                if (isTextArea !== true) {
                    actionIcon.setAttribute('title', 'Revert to original value');
                    dfx.addClass(textBox, 'Viper-actionRevert');
                }

                dfx.removeClass(textBox, 'Viper-required');
            } else if (input.value !== '') {
                if (isTextArea !== true) {
                    actionIcon.setAttribute('title', 'Clear this value');
                    dfx.addClass(textBox, 'Viper-actionClear');
                }

                dfx.removeClass(textBox, 'Viper-required');
            } else {
                if (isTextArea !== true) {
                    dfx.hideElement(actionIcon);
                }

                if (required === true) {
                    dfx.addClass(textBox, 'Viper-required');
                }
            }

            if ((e.which !== 13 || isTextArea === true) && (input.value !== value)) {
                self.viper.fireCallbacks('ViperTools:changed:' + id);
            }

            // Action.
            if (action && e.which === 13) {
                self.viper.focus();
                action.call(input, input.value);
            } else if (!action && e.which === 13 && isTextArea !== true && (self.viper.isBrowser('chrome') || self.viper.isBrowser('safari'))) {
                var forms = dfx.getParents(main, 'form', self.viper.getViperElement());
                if (forms.length > 0 && dfx.getTag('input', forms[0]).length > 2) {
                    return forms[0].onsubmit();
                }
            }
        });

        if (events) {
            for (var eventType in events) {
                dfx.addEvent(input, eventType, events[eventType]);
            }
        }

        this.addItem(id, {
            type: 'textbox',
            element: textBox,
            input: input,
            label: labelEl,
            required: required,
            getValue: function() {
                return input.value;
            },
            setValue: function(newValue, isInitialValue) {
                input.value = newValue;
                value       = newValue;

                if (isTextArea !== true) {
                    var actionIcon = dfx.getClass('Viper-textbox-action', main);
                    if (actionIcon.length === 0) {
                        actionIcon = _addActionButton();
                    } else {
                        actionIcon = actionIcon[0];
                    }

                    dfx.showElement(actionIcon);
                }

                dfx.removeClass(textBox, 'Viper-actionClear');
                dfx.removeClass(textBox, 'Viper-actionRevert');

                if (isTextArea !== true) {
                    if (input.value !== value && value !== '') {
                        // Show the revert icon.
                        actionIcon.setAttribute('title', 'Revert to original value');
                        dfx.addClass(textBox, 'Viper-actionRevert');
                        dfx.removeClass(textBox, 'Viper-required');
                    } else if (input.value !== '') {
                        actionIcon.setAttribute('title', 'Clear this value');
                        dfx.addClass(textBox, 'Viper-actionClear');
                        dfx.removeClass(textBox, 'Viper-required');
                    } else {
                        dfx.hideElement(actionIcon);
                        if (required === true) {
                            dfx.addClass(textBox, 'Viper-required');
                        }
                    }
                }

                if (isInitialValue === false) {
                    self.viper.fireCallbacks('ViperTools:changed:' + id);
                }
            },
            disable: function()
            {
                dfx.addClass(textBox, 'Viper-disabled');
                input.setAttribute('disabled', true);
                input.blur();
            },
            enable: function()
            {
                dfx.removeClass(textBox, 'Viper-disabled');
                input.removeAttribute('disabled');
            },
            setRequired: function(required)
            {
                if (required === true) {
                    input.setAttribute('placeholder', 'required');

                    if (dfx.trim(input.value) === '') {
                        dfx.addClass(textBox, 'Viper-required');
                    }
                } else {
                    dfx.removeClass(textBox, 'Viper-required');
                    input.removeAttribute('placeholder');
                }

                this.required = required;
            }
        });

        return textBox;

    },

    setFieldEvent: function(itemid, eventType, event)
    {
        var item = this.getItem(itemid);
        if (!item || !item.input) {
            return;
        }

        dfx.addEvent(item.input, eventType, event);

    },

    /**
     * Sets the list of errors of the specified item.
     *
     * If no errors specified then all exisiting errors will be cleared.
     *
     * @param {string} itemid The item id.
     * @param {array}  errors List of errors.
     */
    setFieldErrors: function(itemid, errors)
    {
        var item = this.getItem(itemid);
        if (!item || !item.input) {
            return;
        }

        errors = errors || [];

        var errorCount = errors.length;

        var msgsElement = dfx.getClass('Viper-' + item.type + '-messages', item.element);
        if (msgsElement.length === 0) {
            if (errorCount === 0) {
                return;
            }

            msgsElement = document.createElement('div');
            dfx.addClass(msgsElement, 'Viper-textbox-messages');
            item.label.appendChild(msgsElement);
        } else {
            msgsElement = msgsElement[0];
            if (errorCount === 0) {
                dfx.remove(msgsElement);
                return;
            }

            dfx.empty(msgsElement);
        }

        var content = '';
        for (var i = 0; i < errorCount; i++) {
            content += '<span class="Viper-textbox-error">' + errors[i] + '</span>';
        }

        dfx.setHtml(msgsElement, content);

    },

    /**
     * Creates a checkbox.
     *
     * @param {string}  id      The id of the item.
     * @param {string}  label   The label for the checkbox.
     * @param {boolean} checked True if checked by default.
     *
     * @return {DOMElement} The checkbox element.
     */
    createCheckbox: function(id, label, checked, changeCallback)
    {
        var labelElem = document.createElement('label');
        dfx.addClass(labelElem, 'Viper-checkbox');

        if (checked === true) {
            dfx.addClass(labelElem, 'Viper-active');
        }

        var checkbox  = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.checked = checked || false;

        var checkboxSwitch = document.createElement('span');
        dfx.addClass(checkboxSwitch, 'Viper-checkbox-switch');

        var checkboxSlider = document.createElement('span');
        dfx.addClass(checkboxSlider, 'Viper-checkbox-slider');

        checkboxSwitch.appendChild(checkboxSlider);
        checkboxSwitch.appendChild(checkbox);

        var text = document.createElement('span');
        dfx.addClass(text, 'Viper-checkbox-title');
        dfx.setHtml(text, label);

        labelElem.appendChild(text);
        labelElem.appendChild(checkboxSwitch);

        var self = this;

        if (this.viper.isBrowser('msie') === true) {
            // IE does not trigger the click event for input when the label
            // element is clicked, so add the click event to label element and change
            // the checkbox state.
            dfx.addEvent(labelElem, 'click', function() {
                checkbox.checked = !checkbox.checked;

                if (checkbox.checked === true) {
                    dfx.addClass(labelElem, 'Viper-active');
                } else {
                    dfx.removeClass(labelElem, 'Viper-active');
                }

                if (changeCallback) {
                    changeCallback.call(this, checkbox.checked);
                }

                self.viper.fireCallbacks('ViperTools:changed:' + id);
                self.viper.highlightSelection();
            });
        } else {
            dfx.addEvent(checkbox, 'click', function() {
                if (checkbox.checked === true) {
                    dfx.addClass(labelElem, 'Viper-active');
                } else {
                    dfx.removeClass(labelElem, 'Viper-active');
                }

                if (changeCallback) {
                    changeCallback.call(this, checkbox.checked);
                }

                self.viper.fireCallbacks('ViperTools:changed:' + id);
            });
        }

        this.addItem(id, {
            type: 'checkbox',
            element: labelElem,
            input: checkbox,
            getValue: function() {
                return checkbox.checked;
            },
            setValue: function(checked, isInitialValue) {
                checkbox.checked = checked;

                if (checked === true) {
                    dfx.addClass(labelElem, 'Viper-active');
                } else {
                    dfx.removeClass(labelElem, 'Viper-active');
                }

                if (changeCallback && isInitialValue !== true) {
                    changeCallback.call(this, checked, true);
                }
            }
        });

        return labelElem;

    },


    /**
     * Creates a radio button.
     *
     * @parma {string}  name    The name of the group the radio button belongs to.
     * @param {string}  value   The value of the radio button.
     * @param {string}  label   The label for the radio button.
     * @param {boolean} checked True if checked by default.
     *
     * @return {DOMElement} The checkbox element.
     */
    createRadiobutton: function(name, value, label, checked)
    {
        var labelElem = document.createElement('label');
        dfx.addClass(labelElem, 'Viper-radiobtn-label');

        var radio     = document.createElement('input');
        radio.type    = 'radio';
        radio.name    = name;
        radio.value   = value;
        radio.checked = checked || false;

        dfx.addClass(radio, 'Viper-radiobtn');

        var span = document.createElement('span');
        dfx.addClass(span, 'Viper-radio-text');
        dfx.setHtml(span, label);

        labelElem.appendChild(radio);
        labelElem.appendChild(span);

        return labelElem;

    },

    createPopup: function(id, title, topContent, midContent, bottomContent, customClass, draggable, resizable, openCallback, closeCallback, resizeCallback)
    {
        title = title || '&nbsp;';

        var self = this;

        var main = document.createElement('div');
        dfx.addClass(main, 'Viper-popup Viper-themeDark');

        if (customClass) {
            dfx.addClass(main, customClass);
        }

        var header = document.createElement('div');
        dfx.addClass(header, 'Viper-popup-header');

        if (draggable !== false) {
            var dragIcon = document.createElement('div');
            dfx.addClass(dragIcon, 'Viper-popup-dragIcon');
            header.appendChild(dragIcon);

            dfxjQuery(main).draggable({
                handle: header
            });
        }

        header.appendChild(document.createTextNode(title));

        var closeIcon = document.createElement('div');
        dfx.addClass(closeIcon, 'Viper-popup-closeIcon');
        header.appendChild(closeIcon);
        dfx.addEvent(closeIcon, 'mousedown', function() {
            self.closePopup(id, 'closeIcon');
        });

        var fullScreen  = false;

        var originalOpenCallback = openCallback;
        openCallback = function() {
            fullScreen = false;
            if (originalOpenCallback) {
                return originalOpenCallback.call(this);
            }
        }

        // Close popup when ESC key is pressed.
        this.viper.registerCallback('Viper:keyUp', 'ViperTools', function(e) {
            if (e.which === 27 && main.parentNode) {
                self.closePopup(id);
            }
        });

        var showfullScreen = function() {
            dfx.getElementDimensions(midContent);
            var headerHeight  = dfx.getElementHeight(header);
            var topHeight     = dfx.getElementHeight(topContent);
            var bottomHeight  = dfx.getElementHeight(bottomContent);
            var toolbarHeight = 35;

            var windowDim = dfx.getWindowDimensions();
            dfx.setStyle(main, 'left', 0);
            dfx.setStyle(main, 'top', toolbarHeight + 'px');
            dfx.setStyle(main, 'margin-left', 0);
            dfx.setStyle(main, 'margin-top', 0);
            dfx.setStyle(midContent, 'width', windowDim.width - 20 + 'px');
            dfx.setStyle(midContent, 'height', windowDim.height - toolbarHeight - bottomHeight - headerHeight - topHeight - 10 + 'px');
            if (resizeCallback) {
                resizeCallback.call(this);
            }
        };

        var currentSize = null;
        dfx.addEvent(header, 'safedblclick', function() {}, function() {
            if (fullScreen !== true) {
                fullScreen = true;
                var mainCoords = dfx.getElementCoords(main);
                currentSize = {
                    width: dfx.getElementWidth(midContent),
                    height: dfx.getElementHeight(midContent),
                    left: mainCoords.x,
                    top: mainCoords.y
                };

                showfullScreen();

                dfx.removeEvent(window, 'resize.ViperTools-popup-' + id);
                dfx.addEvent(window, 'resize.ViperTools-popup-' + id, function() {
                    // Update the popup size since its in full screen.
                    showfullScreen();
                });
            } else {
                dfx.removeEvent(window, 'resize.ViperTools-popup-' + id);

                fullScreen = false;
                dfx.setStyle(main, 'left', currentSize.left + 'px');
                dfx.setStyle(main, 'top', currentSize.top + 'px');
                dfx.setStyle(midContent, 'width', currentSize.width + 'px');
                dfx.setStyle(midContent, 'height', currentSize.height + 'px');
                if (resizeCallback) {
                    resizeCallback.call(this);
                }
            }//end if
        });

        main.appendChild(header);

        if (topContent) {
            dfx.addClass(topContent, 'Viper-popup-top');
            main.appendChild(topContent);
        }

        dfx.addClass(midContent, 'Viper-popup-content');
        main.appendChild(midContent);

        if (bottomContent) {
            dfx.addClass(bottomContent, 'Viper-popup-bottom');
            main.appendChild(bottomContent);
        }

        if (resizable !== false) {
            var resizeElements = function(ui) {
                dfx.setStyle(midContent, 'width', ui.size.width + 'px');
                dfx.setStyle(midContent, 'height', ui.size.height + 'px');
            };

            dfxjQuery(midContent).resizable({
                handles: 'se',
                resize: function(e, ui) {
                    if (resizeCallback) {
                        resizeCallback.call(this, e, ui);
                    }
                },
                stop: function(e, ui) {
                    if (resizeCallback) {
                        resizeCallback.call(this, e, ui);
                    }
                }
            });

        }

        this.addItem(id, {
            type: 'popup',
            element: main,
            topContent: topContent,
            midContent: midContent,
            bottomContent: bottomContent,
            openCallback: openCallback,
            closeCallback: closeCallback,
            showTop: function() {
                dfx.blindDown(topContent, function() {
                    if (fullScreen === true) {
                        showfullScreen();
                    }
                });
            },
            hideTop: function() {
                dfx.blindUp(topContent, function() {
                    if (fullScreen === true) {
                        showfullScreen();
                    }
                });
            }
        });

        return main;

    },

    openPopup: function(id, width, height, minWidth)
    {
        var popup        = this.getItem(id);
        var contentElem  = popup.midContent;
        var popupElement = popup.element;

        if (minWidth) {
            dfx.setStyle(contentElem, 'min-width', minWidth);
        }

        if (width) {
            dfx.setStyle(contentElem, 'width', width + 'px');
        }

        if (height) {
            dfx.setStyle(contentElem, 'height', height + 'px');
        }

        dfx.setStyle(popupElement, 'left', '-9999px');
        dfx.setStyle(popupElement, 'top', '-9999px');
        dfx.setStyle(popupElement, 'visibility', 'hidden');
        this.viper.addElement(popupElement);

        // Set the pos to be the middle of the screen
        //var windowDim  = dfx.getWindowDimensions();
        var elementDim = dfx.getBoundingRectangle(popupElement);
        var window     = dfx.getWindowDimensions();

        var toolbarHieght = 36;

        var marginTop = (((elementDim.y2 - elementDim.y1) / 2) * -1);

        // If the popup is off the top of the screen then move it back down.
        var offScreenTop = (window.height / 2) + marginTop
        if (offScreenTop < toolbarHieght) {
            marginTop -= offScreenTop - toolbarHieght;
        }

        if ((elementDim.y2 - elementDim.y1) > (window.height - toolbarHieght)) {
            dfx.setStyle(contentElem, 'height', (height - (elementDim.y2 - elementDim.y1 - window.height) - toolbarHieght) + 'px');
        }

        dfx.setStyle(popupElement, 'margin-left', (((elementDim.x2 - elementDim.x1) / 2) * -1) + 'px');
        dfx.setStyle(popupElement, 'margin-top', marginTop + 'px');

        dfx.setStyle(popupElement, 'left', '50%');
        dfx.setStyle(popupElement, 'top', '50%');

        if (popup.openCallback) {
            if (popup.openCallback.call(this) === false) {
                // Do not open.
                popupElement.parentNode.removeChild(popupElement);
                return;
            }
        }

        dfxjQuery(popup.element).draggable('enable');

        dfx.setStyle(popupElement, 'visibility', 'visible');

    },

    closePopup: function(id, closer)
    {
        var popup = this.getItem(id);
        if (popup.closeCallback) {
            if (popup.closeCallback.call(this, closer) === false) {
                // Do not close.
                return;
            }
        }

        dfxjQuery(popup.element).draggable('disable');

        if (popup.element.parentNode) {
            popup.element.parentNode.removeChild(popup.element);
        }

    },

    createInlineToolbar: function(id, compact, elementTypes, updateCallback)
    {
        var self    = this;
        var margin  = 15;
        var toolbar = document.createElement('div');
        var viper   = this.viper;

        var toolsContainer = document.createElement('div');
        toolbar.appendChild(toolsContainer);

        var subSectionContainer = document.createElement('div');
        dfx.setHtml(subSectionContainer, '<span class="Viper-subSectionArrow"></span>');
        toolbar.appendChild(subSectionContainer);

        dfx.addClass(toolbar, 'ViperITP Viper-themeDark Viper-scalable');
        dfx.addClass(toolsContainer, 'ViperITP-tools');
        dfx.addClass(subSectionContainer, 'ViperITP-subSectionWrapper');

        if (navigator.userAgent.match(/iPad/i) !== null) {
            dfx.addClass(toolbar, 'device-ipad');
        }

        if (compact === true) {
            dfx.addClass(toolbar, 'Viper-compact');
        }

        dfx.addEvent(toolbar, 'mousedown', function(e) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isTag(target, 'input') !== true && dfx.isTag(target, 'textarea') !== true) {
                dfx.preventDefault(e);
                return false;
            }
        });

        dfx.addEvent(toolbar, 'mouseup', function(e) {
                dfx.preventDefault(e);
                return false;
        });

        var _update = false;
        this.viper.registerCallback('Viper:selectionChanged', id, function(range) {
            if (self.viper.rangeInViperBounds(range) === false) {
                return;
            }

            if (range.collapsed === true && _update !== true) {
                self.getItem(id).hide();
                return;
            }

            // Update the toolbar position, contents and lineage for this new selection.
            self.getItem(id).update(range);
        });

        // Add scroll event to iframes so that the toolbar is closed when the
        // scroll is happening.
        this.viper.registerCallback('Viper:editableElementChanged', id, function() {
            var elemDoc = self.viper.getViperElementDocument();
            if (elemDoc !== document) {
                var t = null;
                var toolbar = self.getItem(id);
                dfx.removeEvent(elemDoc.defaultView, 'scroll.' + id);
                dfx.addEvent(elemDoc.defaultView, 'scroll.' + id, function(e) {
                    if (toolbar.isVisible() === true) {
                        toolbar.hide();
                    }

                    clearTimeout(t);
                    t = setTimeout(function() {
                        dfx.removeClass(toolbar.element, 'scrolling');
                        self.getItem(id).update();
                    }, 300);
                });
            }
        });

        this.viper.registerCallback('Viper:clickedOutside', id, function(range) {
            self.getItem(id).hide();
        });

        this.viper.registerCallback(['Viper:mouseDown', 'ViperHistoryManager:undo'], id, function(data) {
            _update = false;
            if (data && data.target) {
                var target = dfx.getMouseEventTarget(data);
                if (target === toolbar || dfx.isChildOf(target, toolbar) === true) {
                    if (dfx.isTag(target, 'input') === true
                        || dfx.isTag(target, 'textarea') === true
                    ) {
                        // Allow event to bubble so the input element can get focus etc.
                        return true;
                    }

                    return false;
                } else if (elementTypes
                    && elementTypes.inArray(dfx.getTagName(target)) === true
                ) {
                    self.getItem(id).update(null, target);
                    return;
                } else if (self.getItem(id)._keepOpenTagList.inArray(dfx.getTagName(target)) === true) {
                    _update = true;
                    return;
                } else {
                    var allParents = dfx.getParents(target, null, self.viper.getViperElement());
                    for (var i = 0; i < allParents.length; i++) {
                        if (self.getItem(id)._keepOpenTagList.inArray(dfx.getTagName(allParents[i])) === true) {
                            _update = true;
                            return;
                        }
                    }

                    var parents = dfx.getSurroundingParents(target);
                    for (var i = 0; i < parents.length; i++) {
                        if (self.getItem(id)._keepOpenTagList.inArray(dfx.getTagName(parents[i])) === true) {
                            _update = true;
                            return;
                        }
                    }
                }
            }

            self.getItem(id).hide();
        });

        var tools = this;
        var buttonElements = null;
        this.addItem(id, {
            type: 'toolbar',
            element: toolbar,
            addButton: function(button, index) {
                if (dfx.isset(index) === true && toolsContainer.childNodes.length > index) {
                    if (index < 0) {
                        index = toolsContainer.childNodes.length + index;
                        if (index < 0) {
                            index = 0;
                        }
                    }

                    dfx.insertBefore(toolsContainer.childNodes[index], button);
                } else {
                    toolsContainer.appendChild(button);
                }

            },
            showButton: function(buttonid, disabled) {
                if (tools.getItem(buttonid).type !== 'button') {
                    throw new Error('Invalid button for showButton(): ' + buttonid);
                }

                this._buttonShown = true;

                var button = self.getItem(buttonid);
                dfx.removeClass(button.element, 'ViperITP-button-hidden');
                dfx.removeClass(button.element.parentNode, 'ViperITP-button-hidden');

                if (disabled === true) {
                    self.disableButton(buttonid);
                } else {
                    self.enableButton(buttonid);
                }
            },
            update: function(range, element) {
                if (!updateCallback || self.viper.isEnabled() === false) {
                    return;
                }

                var selectedNode = element || null;
                range = range || self.viper.getViperRange();

                if (!selectedNode) {
                    if (elementTypes && elementTypes.length > 0) {
                        return;
                    }
                }

                var activeSection   = this._activeSection;
                if (range.collapsed === true) {
                    // Clicking inside a link element etc should not activate the
                    // sub section again.
                    activeSection = null;
                }

                this.closeActiveSubsection(true);

                this._buttonShown     = false;
                this._subSectionShown = false;
                this.resetButtons();

                if (buttonElements === null) {
                    // Store the original button structure in to buttonElements
                    // so that we can re construct it here in the next update call.
                    // This must be done as the updateCallback may remove buttons
                    // from the toolbar using showButton, showButtonGroup methods.
                    buttonElements = [];
                    for (var node = toolsContainer.firstChild; node; node = node.nextSibling) {
                        if (dfx.hasClass(node, 'Viper-buttonGroup') === true) {
                            var groupButtons = [node];
                            for (var button = node.firstChild; button; button = button.nextSibling) {
                                groupButtons.push(button);
                            }

                            buttonElements.push(groupButtons);
                        } else if (dfx.hasClass('Viper-button') === true) {
                          buttonElements.push(node);
                        }
                    }
                } else {
                    if (self.viper.isBrowser('msie') === true) {
                        while(toolsContainer.firstChild) {
                            toolsContainer.removeChild(toolsContainer.firstChild);
                        }
                    } else {
                        toolsContainer.innerHTML = '';
                    }

                    for (var i = 0; i < buttonElements.length; i++) {
                        if (buttonElements[i].length) {
                            for (var j = 1; j < buttonElements[i].length; j++) {
                                buttonElements[i][0].appendChild(buttonElements[i][j]);
                            }

                            toolsContainer.appendChild(buttonElements[i][0]);
                        } else {
                            toolsContainer.appendChild(buttonElements[i]);
                        }
                    }
                }

                updateCallback.call(this, range, selectedNode);

                var buttonsToRemove = dfx.getClass('ViperITP-button-hidden', toolsContainer);
                for (var i = 0; i < buttonsToRemove.length; i++) {
                    buttonsToRemove[i].parentNode.removeChild(buttonsToRemove[i]);
                }

                if (this._buttonShown === true || this._subSectionShown === true) {
                    this.updatePosition(range, selectedNode);
                } else {
                    this.hide();
                }

                if (activeSection) {
                    this.toggleSubSection(activeSection);
                }

            },

            resetButtons: function() {
                dfx.removeClass(toolbar, 'Viper-subSectionVisible');
                dfx.addClass(dfx.getClass('Viper-buttonGroup', toolsContainer), 'ViperITP-button-hidden');

                var buttons = dfx.getClass('Viper-button', toolsContainer);
                dfx.addClass(buttons, 'ViperITP-button-hidden');
                dfx.removeClass(buttons, 'Viper-selected');
                dfx.removeClass(buttons, 'Viper-active');
            },

            hide: function() {
                if (this._onHideCallback) {
                    if (this._onHideCallback.call(this) === false) {
                        return false;
                    }
                }

                this.closeActiveSubsection(true);
                this._activeSection = null;
                dfx.removeClass(toolbar, 'Viper-visible');
                return true;

            },

            isVisible: function() {
                return dfx.hasClass(toolbar, 'Viper-visible');
            },

            /**
             * Adds the given element as a sub section of the toolbar.
             *
             * @param {string} id       The id of the new sub section.
             * @param {DOMNode} element The DOMNode to convert to sub section.
             *
             * @return {DOMNode} The element that was passed in.
             */
            makeSubSection: function(id, element, onOpenCallback, onCloseCallback) {
                if (!element) {
                    return false;
                }

                var subSection = document.createElement('div');
                var form       = document.createElement('form');

                subSection.appendChild(form);
                form.appendChild(element);
                form.onsubmit = function() {
                    return false;
                };

                var submitBtn = document.createElement('input');
                submitBtn.type = 'submit';
                dfx.setStyle(submitBtn, 'display', 'none');
                form.appendChild(submitBtn);

                dfx.addClass(subSection, 'Viper-subSection');

                this._subSections[id] = subSection;

                subSectionContainer.appendChild(subSection);

                tools.addItem(id, {
                    type: 'VITPSubSection',
                    element: subSection,
                    form: form,
                    _onOpenCallback: onOpenCallback,
                    _onCloseCallback: onCloseCallback
                });

                return subSection;

            },

            /**
             * Sets the specified button to toggle the given sub section.
             *
             * @param {string} buttonid     Id of the button.
             * @param {string} subSectionid Id of the sub section.
             */
            setSubSectionButton: function(buttonid, subSectionid) {
                if (!this._subSections[subSectionid]) {
                    // Throw exception not a valid sub section id.
                    throw new Error('Invalid sub section id: ' + subSectionid);
                    return false;
                }

                var button = tools.getItem(buttonid).element;
                var self   = this;

                this._subSectionButtons[subSectionid] = buttonid;

                dfx.removeEvent(button, 'mousedown');
                dfx.addEvent(button, 'mousedown', function(e) {
                    if (viper.isBrowser('msie') === true) {
                        // This block of code prevents IE moving user selection to the.
                        // button element when clicked. When the button element is removed
                        // and added back to DOM selection is not moved. Seriously, IE?
                        if (button.previousSibling) {
                            var sibling = button.previousSibling;
                            button.parentNode.removeChild(button);
                            dfx.insertAfter(sibling, button);
                        } else if (button.nextSibling) {
                            var sibling = button.nextSibling;
                            button.parentNode.removeChild(button);
                            dfx.insertBefore(sibling, button);
                        } else {
                            var parent = button.parentNode;
                            button.parentNode.removeChild(button);
                            parent.appendChild(button);
                        }
                    }//end if

                    // Set the subSection to visible and hide rest of the sub sections.
                    self.toggleSubSection(subSectionid);

                    dfx.preventDefault(e);
                });

            },

            /**
             * Toggles the visibility of the specified sub section.
             *
             * @param {string} subSectionid The if of the sub section.
             */
            toggleSubSection: function(subSectionid, ignoreCallbacks)
            {
                var subSection = this._subSections[subSectionid];
                if (!subSection) {
                    return false;
                }

                if (this._activeSection) {
                    var activeSubSection = this._activeSection;
                    this.closeActiveSubsection(ignoreCallbacks);
                    if (subSectionid === activeSubSection) {
                        return;
                    }
                }

                // Make sure all Viper-active has been removed from all sub sections
                // at this point.
                dfx.removeClass(dfx.getClass('Viper-subSection Viper-active', subSectionContainer), 'Viper-active');

                if (this._subSectionButtons[subSectionid]) {
                    var subSectionButton = tools.getItem(this._subSectionButtons[subSectionid]).element;
                    if (dfx.hasClass(subSectionButton, 'ViperITP-button-hidden') === true) {
                        this._activeSection = null;
                        return;
                    }
                }

                if (ignoreCallbacks !== true) {
                    var openCallback = tools.getItem(subSectionid)._onOpenCallback;
                    if (openCallback) {
                        openCallback.call(this);
                    }
                }

                // Make the button selected.
                dfx.addClass(subSectionButton, 'Viper-selected');

                dfx.addClass(subSection, 'Viper-active');
                dfx.addClass(toolbar, 'Viper-subSectionVisible');
                this._activeSection = subSectionid;
                this._updateSubSectionArrowPos();

                this.focusSubSection();

                this._subSectionShown = true;

                var subSectionForm = tools.getItem(subSectionid).form;
                dfx.removeEvent(document, 'keydown.' + id);
                dfx.addEvent(document, 'keydown.' + id, function(e) {
                    if (subSectionForm && e.which === 13 && dfx.isTag(e.target, 'textarea') === false) {
                        return subSectionForm.onsubmit();
                    }
                });

            },

            focusSubSection: function()
            {
                try {
                    var subSection    = this._subSections[this._activeSection];
                    var inputElements = dfx.getTag('input[type=text], textarea', subSection);
                    if (inputElements.length > 0) {
                        inputElements[0].focus();
                        dfx.removeClass(inputElements[0].parentNode.parentNode.parentNode, 'Viper-active');

                        if (self.viper.isBrowser('msie') === false) {
                            tools.viper.highlightSelection();
                        } else {
                            setTimeout(function() {
                                inputElements[0].focus();
                            }, 10);
                        }
                    }
                } catch (e) {}

            },

            closeActiveSubsection: function(ignoreCallbacks)
            {
                if (this._activeSection) {
                    var prevSubSection = this._subSections[this._activeSection];
                    if (prevSubSection) {
                        dfx.removeClass(prevSubSection, 'Viper-active');

                        if (this._subSectionButtons[this._activeSection]) {
                            dfx.removeClass(tools.getItem(this._subSectionButtons[this._activeSection]).element, 'Viper-selected');
                        }

                        if (ignoreCallbacks !== true) {
                            var closeCallback = tools.getItem(this._activeSection)._onCloseCallback;
                            if (closeCallback) {
                                closeCallback.call(this);
                            }
                        }

                        dfx.removeClass(toolbar, 'Viper-subSectionVisible');
                        this._activeSection = null;

                        dfx.removeEvent(document, 'keydown.' + id);
                        return;
                    }
                }
            },

            /**
             *
             *
             * @param {string}   subSectionid The id of the sub section.
             * @param {function} action       The function to call when the sub section action
             *                                is triggered.
             * @param {array}    widgetids    The id of widgets that will cause the action
             *                                button to be activated when they are changed.
             *
             * @return void
             */
            setSubSectionAction: function(subSectionid, action, widgetids)
            {
                widgetids      = widgetids || [];
                var subSection = tools.getItem(subSectionid);
                if (!subSection) {
                    return;
                }

                subSection.form.onsubmit = function(e) {
                    if (e) {
                        dfx.preventDefault(e);
                    }

                    var button = tools.getItem(subSectionid + '-applyButton');
                    if (button.isEnabled() === false) {
                        return false;
                    }

                    tools.viper.focus();

                    if (tools.viper.isBrowser('msie') === false) {
                        try {
                            action.call(this);
                        } catch (e) {
                            console.error('Sub Section Action threw exception:' + e.message);
                        }
                    } else {
                        // IE needs this timeout so focus works <3..
                        setTimeout(function() {
                            try {
                                action.call(this);
                            } catch (e) {
                                console.error('Sub Section Action threw exception:' + e.message);
                            }
                        }, 2);
                    }

                    tools.disableButton(subSectionid + '-applyButton');

                    return false;
                };

                var button = tools.createButton(subSectionid + '-applyButton', 'Update Changes', 'Update Changes', '', subSection.form.onsubmit, true);
                subSection.element.appendChild(button);

                this.addSubSectionActionWidgets(subSectionid, widgetids);

            },

            addSubSectionActionWidgets: function(subSectionid, widgetids)
            {
                if (!this._subSectionActionWidgets[subSectionid]) {
                    this._subSectionActionWidgets[subSectionid] = [];
                }

                var self  = this;
                for (var i = 0; i < widgetids.length; i++) {
                    this._subSectionActionWidgets[subSectionid].push(widgetids[i]);

                    (function(widgetid) {
                        tools.viper.registerCallback('ViperTools:changed:' + widgetid, 'ViperToolbarPlugin', function() {
                            var subSectionWidgets = self._subSectionActionWidgets[subSectionid];
                            var c = subSectionWidgets.length;
                            var enable = true;
                            for (var j = 0; j < c; j++) {
                                var widget = tools.getItem(subSectionWidgets[j]);
                                if (widget.required === true && dfx.trim(widget.getValue()) === '') {
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
                }//end for

            },

            addKeepOpenTag: function(tagName) {
                this._keepOpenTagList.push(tagName);

            },

            orderButtons: function(buttonOrder) {
                // Get all the buttons from the container.
                var buttons = dfx.getClass('Viper-button', toolsContainer);
                var c       = buttons.length;

                if (c === 0) {
                    return;
                }

                // Clear the buttons container contents.
                if (self.viper.isBrowser('msie') === true) {
                    while(toolsContainer.firstChild) {
                        toolsContainer.removeChild(toolsContainer.firstChild);
                    }
                } else {
                    toolsContainer.innerHTML = '';
                }

                // Get the button ids and their elements.
                var addedButtons = {};
                for (var i = 0; i < c; i++) {
                    var button = buttons[i];
                    var id     = button.id.toLowerCase().replace(self.viper.getId().toLowerCase() + '-vitp', '');
                    addedButtons[id] = button;
                }

                var bc = buttonOrder.length;
                for (var i = 0; i < bc; i++) {
                    var button = buttonOrder[i];
                    if (typeof button === 'string') {
                        button = button.toLowerCase();
                        if (addedButtons[button]) {
                            // Button is included in the setting, add it to the toolbar.
                            this.addButton(addedButtons[button]);
                        }
                    } else {
                        var gc           = button.length;
                        var groupid      = null;
                        for (var j = 0; j < gc; j++) {
                            if (addedButtons[button[j].toLowerCase()]) {
                                if (groupid === null) {
                                    // Create the group.
                                    groupid      = 'ViperInlineToolbarPlugin:buttons:' + i;
                                    groupElement = self.createButtonGroup(groupid);
                                    this.addButton(groupElement);
                                }

                                // Button is included in the setting, add it to group.
                                self.addButtonToGroup('vitp' + dfx.ucFirst(button[j]), groupid);
                            }
                        }
                    }
                }

            },
            hideToolsSection: function() {
                dfx.hideElement(toolsContainer);
                dfx.addClass(toolbar, 'Viper-noTools');
            },
            setOnHideCallback: function(callback) {
                this._onHideCallback = callback;
            },
            _subSections: {},
            _activeSection: null,
            _subSectionButtons: {},
            _subSectionActionWidgets: {},
            _buttonShown: false,
            _subSectionShown: false,
            _verticalPosUpdateOnly: false,
            _keepOpenTagList: [],
            _onHideCallback: null,
            updatePosition: function(range, selectedNode) {
                range = range || tools.viper.getViperRange();

                var rangeCoords  = null;
                var selectedNode = selectedNode || range.getNodeSelection(range);
                if (selectedNode !== null) {
                    rangeCoords = this.getElementCoords(selectedNode);
                } else {
                    rangeCoords = range.rangeObj.getBoundingClientRect();
                }

                if (!rangeCoords || (rangeCoords.left === 0 && rangeCoords.top === 0 && tools.viper.isBrowser('firefox') === true)) {
                    if (range.collapsed === true) {
                        var span = document.createElement('span');
                        tools.viper.insertNodeAtCaret(span);
                        rangeCoords = this.getElementCoords(span);
                        dfx.remove(span);

                        if (!rangeCoords) {
                            return;
                        }
                    } else {
                        var startNode = range.getStartNode();
                        var endNode   = range.getEndNode();
                        if (!startNode || !endNode) {
                            return;
                        }

                        if (startNode.nodeType === dfx.TEXT_NODE
                            && startNode.data.indexOf("\n") === 0
                            && endNode.nodeType === dfx.TEXT_NODE
                            && range.endOffset === endNode.data.length
                        ) {
                            range.setStart(endNode, endNode.data.length);
                            range.collapse(true);
                            rangeCoords = range.rangeObj.getBoundingClientRect();
                        }
                    }
                }

                if (!rangeCoords || (rangeCoords.bottom === 0 && rangeCoords.height === 0 && rangeCoords.left === 0)) {
                    if (tools.viper.isBrowser('chrome') === true || tools.viper.isBrowser('safari') === true) {
                        // Webkit bug workaround. https://bugs.webkit.org/show_bug.cgi?id=65324.
                        // OK.. Yet another fix. With the latest Google Chrome (17.0.963.46)
                        // the !rangeCoords check started to fail because its no longer
                        // returning null for a collapsed range, instead all values are set to 0.

                        var startNode = range.getStartNode();
                        if (startNode.nodeType === dfx.TEXT_NODE) {
                            if (range.startOffset <= startNode.data.length) {
                                range.setEnd(startNode, (range.startOffset + 1));
                                rangeCoords = range.rangeObj.getBoundingClientRect();
                                range.collapse(true);
                                if (rangeCoords) {
                                    rangeCoords.right = rangeCoords.left;
                                }
                            } else if (range.startOffset > 0) {
                                range.setStart(startNode, (range.startOffset - 1));
                                rangeCoords = range.rangeObj.getBoundingClientRect();
                                range.collapse(false);
                                if (rangeCoords) {
                                    rangeCoords.right = rangeCoords.left;
                                }
                            }
                        }
                    } else {
                        // Point to top of Viper element.
                        rangeCoords        = this.getElementCoords(tools.viper.getViperElement());
                        rangeCoords.bottom = (rangeCoords.top + 10);
                    }//end if
                }//end if

                var frameOffset = {x: 0, y: 0};
                if (Viper.document !== document && Viper.document.defaultView.frameElement) {
                    // Viper element is inside an iframe, need to adjust the position.
                    frameOffset      = tools.viper.getDocumentOffset();
                    var newCoords    = {};
                    newCoords.bottom = (rangeCoords.bottom + frameOffset.y);
                    newCoords.top    = (rangeCoords.top + frameOffset.y);
                    newCoords.bottom = (rangeCoords.bottom + frameOffset.y);
                    newCoords.left   = (rangeCoords.left + frameOffset.x);
                    newCoords.right  = (rangeCoords.right + frameOffset.x);
                    newCoords.height = rangeCoords.height;
                    newCoords.width  = rangeCoords.width;
                    rangeCoords      = newCoords;
                }

                var scrollCoords = dfx.getScrollCoords();

                dfx.addClass(toolbar, 'Viper-calcWidth');
                dfx.setStyle(toolbar, 'width', 'auto');
                var toolbarWidth  = dfx.getElementWidth(toolbar);
                dfx.removeClass(toolbar, 'Viper-calcWidth');
                dfx.setStyle(toolbar, 'width', toolbarWidth + 'px');

                var viperElemCoords = this.getElementCoords(tools.viper.getViperElement());
                var windowDim       = dfx.getWindowDimensions(Viper.document.defaultView);

                if (this._verticalPosUpdateOnly !== true) {
                    var left = ((rangeCoords.left + ((rangeCoords.right - rangeCoords.left) / 2) + scrollCoords.x) - (toolbarWidth / 2));
                    dfx.removeClass(toolbar, 'Viper-orientationLeft Viper-orientationRight');

                    if (left > (windowDim.width + frameOffset.x)) {
                        // Dont go off screen, point to the editable element.
                        left = viperElemCoords.left;
                    }

                    if (left < 0) {
                        left += (toolbarWidth / 2);
                        dfx.addClass(toolbar, 'Viper-orientationLeft');
                    } else if (left + toolbarWidth > (windowDim.width + frameOffset.x)) {
                        left -= (toolbarWidth / 2);
                        dfx.addClass(toolbar, 'Viper-orientationRight');
                    }

                    dfx.setStyle(toolbar, 'left', left + 'px');
                }

                var top = (rangeCoords.bottom + margin + scrollCoords.y);

                if (top === 0) {
                    this.hide();
                    return;
                } else if (top > windowDim.height + scrollCoords.y) {
                    this.hide();
                    return;
                } else if (top < viperElemCoords.top && Viper.document === document) {
                    top = (viperElemCoords.top + 50);
                    if (left < viperElemCoords.left && this._verticalPosUpdateOnly !== true) {
                        dfx.setStyle(toolbar, 'left', viperElemCoords.left  + 50 + 'px');
                    }
                } else if (Viper.document !== document && top < tools.viper.getDocumentOffset().y) {
                    this.hide();
                    return;
                }

                dfx.setStyle(toolbar, 'top', top + 'px');
                dfx.addClass(toolbar, 'Viper-visible');

            },
            setVerticalUpdateOnly: function(verticalOnly) {
                this._verticalPosUpdateOnly = verticalOnly;
            },
            _updateSubSectionArrowPos: function() {
                if (!this._activeSection) {
                    return;
                }

                var button = this._subSectionButtons[this._activeSection];
                if (!button) {
                    return;
                }

                button = tools.getItem(button).element;
                if (!button) {
                    return;
                }

                var buttonRect = dfx.getBoundingRectangle(button);
                var toolbarPos = dfx.getBoundingRectangle(toolbar);
                var xPos       = (buttonRect.x1 - toolbarPos.x1 + ((buttonRect.x2 - buttonRect.x1) / 2));
                dfx.setStyle(subSectionContainer.firstChild, 'left', xPos + 'px');

            },
            getElementCoords: function(element) {
                var elemRect     = dfx.getBoundingRectangle(element);
                var scrollCoords = dfx.getScrollCoords(element.ownerDocument.defaultView);
                return {
                    left: (elemRect.x1 - scrollCoords.x),
                    right: (elemRect.x2 - scrollCoords.x),
                    top: (elemRect.y1 - scrollCoords.y),
                    bottom: (elemRect.y2 - scrollCoords.y)
                };

            }
        });

        this.viper.addElement(toolbar);

        return toolbar;

    },

    createToolTip: function(id, content, element)
    {
        var self    = this;
        var tooltip = document.createElement('div');
        dfx.addClass(tooltip, 'Viper-tooltip');
        dfx.setHtml(tooltip, content);

        var visible = false;
        var mouseX  = 0;
        var mouseY  = 0;

        if (element && element !== 'mouse') {
            // Show tooltip on hover.
            var timer = null;
            dfx.hover(element, function() {
                timer = setTimeout(function() {
                    self.getItem(id).show(element);
                }, 500);
            }, function() {
                clearTimeout(timer);
                self.getItem(id).hide();
            });
        } else if (element === 'mouse') {
            dfx.addEvent(document, 'mousemove', function(e) {
                mouseX = e.pageX;
                mouseY = e.pageY;

                if (visible !== true) {
                    return;
                }

                dfx.setStyle(tooltip, 'left', mouseX + 'px');
                dfx.setStyle(tooltip, 'top', mouseY + 'px');
            });
        }


        this.addItem(id, {
            type: 'tooltip',
            element: tooltip,
            show: function(elem) {
                if (elem && elem.nodeType) {
                    // Show tooltip on this element.
                    var rect = dfx.getBoundingRectangle(elem);

                    dfx.setStyle(tooltip, 'left', rect.x2 + 'px');
                    dfx.setStyle(tooltip, 'top', rect.y2 + 'px');

                    self.viper.addElement(tooltip);
                    visible = true;
                } else if (elem === 'mouse' || element === 'mouse') {
                    // Follow the mouse pointer.
                    dfx.setStyle(tooltip, 'left', mouseX + 'px');
                    dfx.setStyle(tooltip, 'top', mouseY + 'px');
                    self.viper.addElement(tooltip);
                    visible = true;
                }
            },
            hide: function() {
                visible = false;
                if (tooltip.parentNode) {
                    tooltip.parentNode.removeChild(tooltip);
                }
            }
        });

        return tooltip;

    },

    scaleElement: function(element)
    {
        var zoom = (document.documentElement.clientWidth / window.innerWidth);
        if (zoom === 1) {
            var scale = 1;
            dfx.setStyle(element, '-webkit-transform', 'scale(' + scale + ', ' + scale + ')');
            dfx.setStyle(element, '-moz-transform', 'scale(' + scale + ', ' + scale + ')');
            return;
        }

        var scale = ((1 / zoom) + 0.2);

        dfx.setStyle(element, '-webkit-transform', 'scale(' + scale + ', ' + scale + ')');
        dfx.setStyle(element, '-moz-transform', 'scale(' + scale + ', ' + scale + ')');

        return scale;

    }

};
