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
 */

function ViperTools(viper)
{
    this.viper = viper;

    this._items          = {};
    this._preventMouseUp = false;

    var self = this;
    this.viper.registerCallback(
        'Viper:mouseUp',
        'ViperTools',
        function(e) {
            if (self._preventMouseUp === true) {
                self._preventMouseUp = false;
                return false;
            }
        }
    );

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
            ViperUtil.remove(item.element);
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
        ViperUtil.addClass(elem, 'Viper-subSectionRow');

        if (customClass) {
            ViperUtil.addClass(elem, customClass);
        }

        this.addItem(
            id,
            {
                type: 'row',
                element: elem
            }
        );

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
        ViperUtil.addClass(group, 'Viper-buttonGroup');

        if (customClass) {
            ViperUtil.addClass(group, customClass);
        }

        this.addItem(
            id,
            {
                type: 'buttonGroup',
                element: group,
                buttons: []
            }
        );

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
                titleAttr = titleAttr + ' [' + _('Not available') + ']';
            }

            button.setAttribute('title', titleAttr);
        }

        ViperUtil.setHtml(button, content);
        ViperUtil.addClass(button, 'Viper-button');

        if (disabled === true) {
            ViperUtil.addClass(button, 'Viper-disabled');
        }

        if (customClass) {
            ViperUtil.addClass(button, customClass);
        }

        var mouseUpAction  = function() {};
        var preventMouseUp = false;
        var self           = this;
        if (clickAction) {
            ViperUtil.addEvent(
                button,
                'mousedown.' + this.viper.getEventNamespace(),
                function(e) {
                    if (ViperUtil.isBrowser('msie', '<11') === true) {
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

                    self._preventMouseUp = true;
                    ViperUtil.preventDefault(e);
                    if (ViperUtil.hasClass(button, 'Viper-disabled') === true) {
                        return false;
                    }

                    setTimeout(
                        function() {
                            // Incase button is moved/removed during the click action.
                            self._preventMouseUp = false;
                        },
                        200
                    );

                    self.viper.fireCallbacks('ViperTools:buttonClicked', id);
                    return clickAction.call(this, e);
                }
            );
        }//end if

        ViperUtil.addEvent(
            button,
            'mouseup.' + this.viper.getEventNamespace(),
            function(e) {
                mouseUpAction.call(this, e);
                self._preventMouseUp = false;
                ViperUtil.preventDefault(e);
                return false;
            }
        );

        if (isActive === true) {
            ViperUtil.addClass(button, 'Viper-active');
        }

        this.addItem(
            id,
            {
                type: 'button',
                element: button,
                setIconClass: function(iconClass) {
                    var btnIconElem = ViperUtil.getClass('Viper-buttonIcon', button);
                    if (btnIconElem.length === 0) {
                        btnIconElem = document.createElement('span');
                        ViperUtil.addClass(btnIconElem, 'Viper-buttonIcon');
                        ViperUtil.insertBefore(button.firstChild, btnIconElem);
                    } else {
                        btnIconElem           = btnIconElem[0];
                        btnIconElem.className = 'Viper-buttonIcon';
                    }

                    ViperUtil.addClass(btnIconElem, iconClass);
                },
                setButtonShortcut: function(key) {
                    var extraTitleAttr = ' (' + key + ')';
                    if (extraTitleAttr.indexOf('CTRL') >= 0) {
                        if (navigator.platform.indexOf('Mac') >= 0) {
                            extraTitleAttr = extraTitleAttr.replace('CTRL', 'CMD');
                        }
                    }

                    button.setAttribute('title', titleAttr + extraTitleAttr);

                    self.viper.registerCallback(
                        'Viper:keyDown',
                        'ViperTools-' + id,
                        function(e) {
                            if (self.viper.isKey(e, key) === true) {
                                if (ViperUtil.hasClass(button, 'Viper-disabled') !== true) {
                                    clickAction.call(e, button);
                                }

                                return false;
                            }
                        }
                    );
                },
                setMouseUpAction: function(callback) {
                    mouseUpAction = callback;
                },
                isEnabled: function() {
                    return !this._disabled;
                },
                isActive: function() {
                    return ViperUtil.hasClass(button, 'Viper-active');
                },
                _disabled: disabled
            }
        );

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
        var button = this.getItem(buttonid);
        if (!button) {
            return;
        }

        ViperUtil.removeClass(button.element, 'Viper-active');

    },

    setButtonActive: function(buttonid)
    {
        var button = this.getItem(buttonid);
        if (!button) {
            return;
        }

        ViperUtil.addClass(button.element, 'Viper-active');
        this.enableButton(buttonid);

    },

    enableButton: function(buttonid)
    {
        var buttonObj = this.getItem(buttonid);
        if (!buttonObj || buttonObj.isEnabled() === true) {
            return;
        }

        var button = buttonObj.element;

        var title = button.getAttribute('title');
        if (title) {
            button.setAttribute('title', title.replace(' [' + _('Not available') + ']', ''));
        }

        ViperUtil.removeClass(button, 'Viper-disabled');
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
            title = title.replace(' [' + _('Not available') + ']', '');
            button.setAttribute('title', title + ' [' + _('Not available') + ']');
        }

        ViperUtil.addClass(button, 'Viper-disabled');
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
        ViperUtil.addClass(textBox, 'Viper-textbox');

        if (required === true && !value) {
            ViperUtil.addClass(textBox, 'Viper-required');
        }

        var labelEl = document.createElement('label');
        ViperUtil.addClass(labelEl, 'Viper-textbox-label');
        textBox.appendChild(labelEl);

        var main = document.createElement('div');
        ViperUtil.addClass(main, 'Viper-textbox-main');
        labelEl.appendChild(main);

        var title = document.createElement('span');
        ViperUtil.addClass(title, 'Viper-textbox-title');
        ViperUtil.setHtml(title, label);

        if (labelWidth) {
            ViperUtil.setStyle(title, 'width', labelWidth);
        }

        var width = 0;
        // Wrap the element in a generic class so the width calculation is correct
        // for the font size.
        var tmp = document.createElement('div');
        ViperUtil.addClass(tmp, 'ViperITP');

        if (navigator.userAgent.match(/iPad/i) !== null) {
            ViperUtil.addClass(tmp, 'device-ipad');
        }

        ViperUtil.setStyle(tmp, 'display', 'block');
        tmp.appendChild(title);
        this.viper.addElement(tmp);
        width = (ViperUtil.getElementWidth(title) + 10) + 'px';
        tmp.parentNode.removeChild(tmp);

        main.appendChild(title);

        var inputType = 'input';
        if (isTextArea === true) {
            inputType = 'textarea';
        }

        var input   = document.createElement(inputType);
        input.value = value;

        if (isTextArea === true) {
            ViperUtil.addClass(input, 'Viper-textbox-textArea');
        } else {
            input.type = 'text';
            ViperUtil.addClass(input, 'Viper-textbox-input');
        }

        ViperUtil.setStyle(main, 'padding-left', width);
        main.appendChild(input);

        if (required === true) {
            input.setAttribute('placeholder', _('required'));
        }

        if (desc) {
            // Description.
            var descEl = document.createElement('span');
            ViperUtil.addClass(descEl, 'Viper-textbox-desc');
            ViperUtil.setHtml(descEl, desc);
            textBox.appendChild(descEl);
        }

        var moveCaretToEnd = true;
        if (ViperUtil.isBrowser('msie') === true) {
            // Need to add this mouseDown event for IE to disable the caret moving
            // to the end of the text in the input field. When the mouse is clicked
            // the caret is placed to the start of the field instead of the end,
            // so when the mouse is used to focus in to the field we do not move it
            // to the end of the textbox.
            ViperUtil.addEvent(
                input,
                'mousedown',
                function(e) {
                    moveCaretToEnd = false;
                }
            );
        }

        // IE paste fix.
        input.onpaste = function(e) {
            if (ViperUtil.isBrowser('msie') === true) {
                // Because Viper does the copy/cut in HTML format IE failed to paste it in to textboxes. So we prevent
                // the default action and set the value of the input field using the clipboardData.
                input.value = window.clipboardData.getData("Text");
                return false;
            }
        };

        var self = this;
        ViperUtil.addEvent(
            input,
            'focus',
            function(e) {
                ViperUtil.addClass(textBox, 'Viper-focused');
                self.viper.highlightSelection();

                if (ViperUtil.isBrowser('msie') === true) {
                    if (moveCaretToEnd === true) {
                        setTimeout(
                            function() {
                                if (ViperUtil.isBrowser('msie', '>=11') === true) {
                                    var textRange = input.createTextRange();
                                    textRange.move('character', input.value.length)
                                    textRange.select();
                                } else {
                                    input.focus();
                                    // Set the caret to the end of the textfield.
                                    input.value = input.value;
                                }
                            },
                            10
                        );
                    }

                    moveCaretToEnd = true;
                } else {
                    // Set the caret to the end of the textfield.
                    input.value = input.value;
                }//end if

                if (ViperUtil.isBrowser('firefox') === true) {
                    setTimeout(
                        function() {
                            input.selectionStart = input.value.length;
                        },
                        2
                    );
                }
            }
        );

        ViperUtil.addEvent(
            input,
            'blur',
            function() {
                ViperUtil.removeClass(textBox, 'Viper-active');
            }
        );

        var changed          = false;
        var _addActionButton = function() {
            var actionIcon = document.createElement('span');
            ViperUtil.addClass(actionIcon, 'Viper-textbox-action');
            main.appendChild(actionIcon);
            ViperUtil.addEvent(
                actionIcon,
                'click',
                function() {
                    if (ViperUtil.hasClass(textBox, 'Viper-actionRevert') === true) {
                        input.value = value;
                        ViperUtil.removeClass(textBox, 'Viper-actionRevert');
                        ViperUtil.addClass(textBox, 'Viper-actionClear');
                        actionIcon.setAttribute('title', 'Clear this value');
                    } else if (ViperUtil.hasClass(textBox, 'Viper-actionClear') === true) {
                        value       = input.value;
                        input.value = '';
                        ViperUtil.removeClass(textBox, 'Viper-actionClear');

                        if (value) {
                            ViperUtil.addClass(textBox, 'Viper-actionRevert');
                            actionIcon.setAttribute('title', 'Revert to original value');
                            if (required === true) {
                                ViperUtil.addClass(textBox, 'Viper-required');
                            }
                        } else if (required === true) {
                            ViperUtil.addClass(textBox, 'Viper-required');
                            ViperUtil.setStyle(actionIcon, 'display', 'none');
                        }
                    }//end if

                    self.viper.fireCallbacks('ViperTools:changed:' + id);
                }
            );

            return actionIcon;
        };

        if (value !== '' && isTextArea !== true) {
            var actionIcon = _addActionButton();
            actionIcon.setAttribute('title', 'Clear this value');
            ViperUtil.addClass(textBox, 'Viper-actionClear');
        }

        ViperUtil.addEvent(
            input,
            'keyup',
            function(e) {
                ViperUtil.addClass(textBox, 'Viper-focused');

                if (isTextArea !== true) {
                    var actionIcon = ViperUtil.getClass('Viper-textbox-action', main);
                    if (actionIcon.length === 0) {
                        actionIcon = _addActionButton();
                    } else {
                        actionIcon = actionIcon[0];
                    }
                }

                ViperUtil.setStyle(actionIcon, 'display', 'block');
                ViperUtil.setStyle(actionIcon, 'visibility', 'visible');

                ViperUtil.removeClass(textBox, 'Viper-actionClear');
                ViperUtil.removeClass(textBox, 'Viper-actionRevert');

                if (input.value !== value && value !== '') {
                    // Show the revert icon.
                    if (isTextArea !== true) {
                        actionIcon.setAttribute('title', 'Revert to original value');
                        ViperUtil.addClass(textBox, 'Viper-actionRevert');
                    }

                    ViperUtil.removeClass(textBox, 'Viper-required');
                } else if (input.value !== '') {
                    if (isTextArea !== true) {
                        actionIcon.setAttribute('title', 'Clear this value');
                        ViperUtil.addClass(textBox, 'Viper-actionClear');
                    }

                    ViperUtil.removeClass(textBox, 'Viper-required');
                } else {
                    if (isTextArea !== true) {
                        ViperUtil.setStyle(actionIcon, 'display', 'none');
                    }

                    if (required === true) {
                        ViperUtil.addClass(textBox, 'Viper-required');
                    }
                }//end if

                if ((e.which !== 13 || isTextArea === true) && (input.value !== value)) {
                    self.viper.fireCallbacks('ViperTools:changed:' + id);
                }

                // Action.
                if (action && e.which === 13) {
                    self.viper.focus();
                    action.call(input, input.value);
                } else if (!action && e.which === 13 && isTextArea !== true && (ViperUtil.isBrowser('chrome') || ViperUtil.isBrowser('safari'))) {
                    var forms = ViperUtil.getParents(main, 'form', self.viper.getViperElement());
                    if (forms.length > 0 && ViperUtil.getTag('input', forms[0]).length > 2) {
                        return forms[0].onsubmit();
                    }
                }
            }
        );

        if (events) {
            for (var eventType in events) {
                ViperUtil.addEvent(input, eventType, events[eventType]);
            }
        }

        this.addItem(
            id,
            {
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
                        var actionIcon = ViperUtil.getClass('Viper-textbox-action', main);
                        if (actionIcon.length === 0) {
                            actionIcon = _addActionButton();
                        } else {
                            actionIcon = actionIcon[0];
                        }

                        ViperUtil.setStyle(actionIcon, 'display', 'block');
                    }

                    ViperUtil.removeClass(textBox, 'Viper-actionClear');
                    ViperUtil.removeClass(textBox, 'Viper-actionRevert');

                    if (isTextArea !== true) {
                        if (input.value !== value && value !== '') {
                            // Show the revert icon.
                            actionIcon.setAttribute('title', 'Revert to original value');
                            ViperUtil.addClass(textBox, 'Viper-actionRevert');
                            ViperUtil.removeClass(textBox, 'Viper-required');
                        } else if (input.value !== '') {
                            actionIcon.setAttribute('title', 'Clear this value');
                            ViperUtil.addClass(textBox, 'Viper-actionClear');
                            ViperUtil.removeClass(textBox, 'Viper-required');
                        } else {
                            ViperUtil.setStyle(actionIcon, 'display', 'none');
                            if (required === true) {
                                ViperUtil.addClass(textBox, 'Viper-required');
                            }
                        }
                    }

                    if (isInitialValue === false) {
                        self.viper.fireCallbacks('ViperTools:changed:' + id);
                    }
                },
                disable: function() {
                    ViperUtil.addClass(textBox, 'Viper-disabled');
                    input.setAttribute('disabled', true);
                    input.blur();
                },
                enable: function() {
                    ViperUtil.removeClass(textBox, 'Viper-disabled');
                    input.removeAttribute('disabled');
                },
                setRequired: function(required) {
                    if (required === true) {
                        input.setAttribute('placeholder', _('required'));

                        if (ViperUtil.trim(input.value) === '') {
                            ViperUtil.addClass(textBox, 'Viper-required');
                        }
                    } else {
                        ViperUtil.removeClass(textBox, 'Viper-required');
                        input.removeAttribute('placeholder');
                    }

                    this.required = required;
                }
            }
        );

        return textBox;

    },

    setFieldEvent: function(itemid, eventType, event)
    {
        var item = this.getItem(itemid);
        if (!item || !item.input) {
            return;
        }

        ViperUtil.addEvent(item.input, eventType, event);

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

        var msgsElement = ViperUtil.getClass('Viper-' + item.type + '-messages', item.element);
        if (msgsElement.length === 0) {
            if (errorCount === 0) {
                return;
            }

            msgsElement = document.createElement('div');
            ViperUtil.addClass(msgsElement, 'Viper-textbox-messages');
            item.label.appendChild(msgsElement);
        } else {
            msgsElement = msgsElement[0];
            if (errorCount === 0) {
                ViperUtil.remove(msgsElement);
                return;
            }

            ViperUtil.empty(msgsElement);
        }

        var content = '';
        for (var i = 0; i < errorCount; i++) {
            content += '<span class="Viper-textbox-error">' + errors[i] + '</span>';
        }

        ViperUtil.setHtml(msgsElement, content);

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
        ViperUtil.addClass(labelElem, 'Viper-checkbox');

        if (checked === true) {
            ViperUtil.addClass(labelElem, 'Viper-active');
        }

        var checkbox     = document.createElement('input');
        checkbox.type    = 'checkbox';
        checkbox.checked = checked || false;

        var checkboxSwitch = document.createElement('span');
        ViperUtil.addClass(checkboxSwitch, 'Viper-checkbox-switch');

        var checkboxSlider = document.createElement('span');
        ViperUtil.addClass(checkboxSlider, 'Viper-checkbox-slider');

        checkboxSwitch.appendChild(checkboxSlider);
        checkboxSwitch.appendChild(checkbox);

        var text = document.createElement('span');
        ViperUtil.addClass(text, 'Viper-checkbox-title');
        ViperUtil.setHtml(text, label);

        labelElem.appendChild(text);
        labelElem.appendChild(checkboxSwitch);

        var self = this;

        if (ViperUtil.isBrowser('msie', '<11') === true) {
            // IE does not trigger the click event for input when the label
            // element is clicked, so add the click event to label element and change
            // the checkbox state.
            ViperUtil.addEvent(
                labelElem,
                'click',
                function() {
                    checkbox.checked = !checkbox.checked;

                    if (checkbox.checked === true) {
                        ViperUtil.addClass(labelElem, 'Viper-active');
                    } else {
                        ViperUtil.removeClass(labelElem, 'Viper-active');
                    }

                    if (changeCallback) {
                        changeCallback.call(this, checkbox.checked);
                    }

                    self.viper.fireCallbacks('ViperTools:changed:' + id);
                    self.viper.highlightSelection();
                }
            );
        } else {
            ViperUtil.addEvent(
                checkbox,
                'click',
                function() {
                    if (checkbox.checked === true) {
                        ViperUtil.addClass(labelElem, 'Viper-active');
                    } else {
                        ViperUtil.removeClass(labelElem, 'Viper-active');
                    }

                    if (changeCallback) {
                        changeCallback.call(this, checkbox.checked);
                    }

                    self.viper.fireCallbacks('ViperTools:changed:' + id);
                }
            );
        }//end if

        this.addItem(
            id,
            {
                type: 'checkbox',
                element: labelElem,
                input: checkbox,
                getValue: function() {
                    return checkbox.checked;
                },
                setValue: function(checked, isInitialValue) {
                    checkbox.checked = checked;

                    if (checked === true) {
                        ViperUtil.addClass(labelElem, 'Viper-active');
                    } else {
                        ViperUtil.removeClass(labelElem, 'Viper-active');
                    }

                    if (changeCallback && isInitialValue !== true) {
                        changeCallback.call(this, checked, true);
                    }
                }
            }
        );

        return labelElem;

    },


    /**
     * Creates a radio button.
     *
     * @param {string}  name    The name of the group the radio button belongs to.
     * @param {string}  value   The value of the radio button.
     * @param {string}  label   The label for the radio button.
     * @param {boolean} checked True if checked by default.
     *
     * @return {DOMElement} The checkbox element.
     */
    createRadiobutton: function(name, value, label, checked)
    {
        var labelElem = document.createElement('label');
        ViperUtil.addClass(labelElem, 'Viper-radiobtn-label');

        var radio     = document.createElement('input');
        radio.type    = 'radio';
        radio.name    = name;
        radio.value   = value;
        radio.checked = checked || false;

        ViperUtil.addClass(radio, 'Viper-radiobtn');

        var span = document.createElement('span');
        ViperUtil.addClass(span, 'Viper-radio-text');
        ViperUtil.setHtml(span, label);

        labelElem.appendChild(radio);
        labelElem.appendChild(span);

        return labelElem;

    },

    createPopup: function(id, title, topContent, midContent, bottomContent, customClass, draggable, resizable, openCallback, closeCallback, resizeCallback)
    {
        title = title || '&nbsp;';

        var self = this;

        var main = document.createElement('div');
        ViperUtil.addClass(main, 'Viper-popup Viper-themeDark');

        if (customClass) {
            ViperUtil.addClass(main, customClass);
        }

        var header = document.createElement('div');
        ViperUtil.addClass(header, 'Viper-popup-header');

        if (draggable !== false) {
            var dragIcon = document.createElement('div');
            ViperUtil.addClass(dragIcon, 'Viper-popup-dragIcon');
            header.appendChild(dragIcon);

            ViperUtil.$(main).draggable(
                {
                    handle: header
                }
            );
        }

        header.appendChild(document.createTextNode(title));

        var closeIcon = document.createElement('div');
        ViperUtil.addClass(closeIcon, 'Viper-popup-closeIcon');
        header.appendChild(closeIcon);
        ViperUtil.addEvent(
            closeIcon,
            'mousedown',
            function() {
                self.closePopup(id, 'closeIcon');
            }
        );

        var fullScreen = false;

        var originalOpenCallback = openCallback;
        openCallback = function() {
            fullScreen = false;
            if (originalOpenCallback) {
                return originalOpenCallback.call(this);
            }
        }

        // Close popup when ESC key is pressed.
        this.viper.registerCallback(
            'Viper:keyUp',
            'ViperTools',
            function(e) {
                if (e.which === 27 && main.parentNode) {
                    self.closePopup(id);
                }
            }
        );

        var showfullScreen = function() {
            var headerHeight  = ViperUtil.getElementHeight(header);
            var topHeight     = ViperUtil.getElementHeight(topContent);
            var bottomHeight  = ViperUtil.getElementHeight(bottomContent);
            var toolbarHeight = 35;

            var windowDim = ViperUtil.getWindowDimensions();
            ViperUtil.setStyle(main, 'left', 0);
            ViperUtil.setStyle(main, 'top', toolbarHeight + 'px');
            ViperUtil.setStyle(main, 'margin-left', 0);
            ViperUtil.setStyle(main, 'margin-top', 0);
            ViperUtil.setStyle(midContent, 'width', (windowDim.width - 20) + 'px');
            ViperUtil.setStyle(midContent, 'height', (windowDim.height - toolbarHeight - bottomHeight - headerHeight - topHeight - 10) + 'px');
            if (resizeCallback) {
                resizeCallback.call(this);
            }
        };

        var currentSize = null;
        ViperUtil.addEvent(
            header,
            'safedblclick',
            function() {},
            function() {
                if (fullScreen !== true) {
                    fullScreen     = true;
                    var mainCoords = ViperUtil.getElementCoords(main);
                    currentSize    = {
                        width: ViperUtil.getElementWidth(midContent),
                        height: ViperUtil.getElementHeight(midContent),
                        left: mainCoords.x,
                        top: mainCoords.y
                    };

                    showfullScreen();

                    ViperUtil.removeEvent(window, 'resize.ViperTools-popup-' + id);
                    ViperUtil.addEvent(
                        window,
                        'resize.ViperTools-popup-' + id,
                        function() {
                            // Update the popup size since its in full screen.
                            showfullScreen();
                        }
                    );
                } else {
                    ViperUtil.removeEvent(window, 'resize.ViperTools-popup-' + id);

                    fullScreen = false;
                    ViperUtil.setStyle(main, 'left', currentSize.left + 'px');
                    ViperUtil.setStyle(main, 'top', currentSize.top + 'px');
                    ViperUtil.setStyle(midContent, 'width', currentSize.width + 'px');
                    ViperUtil.setStyle(midContent, 'height', currentSize.height + 'px');
                    if (resizeCallback) {
                        resizeCallback.call(this);
                    }
                }//end if
            }
        );

        main.appendChild(header);

        if (topContent) {
            ViperUtil.addClass(topContent, 'Viper-popup-top');
            main.appendChild(topContent);
        }

        ViperUtil.addClass(midContent, 'Viper-popup-content');
        main.appendChild(midContent);

        if (bottomContent) {
            ViperUtil.addClass(bottomContent, 'Viper-popup-bottom');
            main.appendChild(bottomContent);
        }

        if (resizable !== false) {
            var resizeElements = function(ui) {
                ViperUtil.setStyle(midContent, 'width', ui.size.width + 'px');
                ViperUtil.setStyle(midContent, 'height', ui.size.height + 'px');
            };

            ViperUtil.$(midContent).resizable(
                {
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
                }
            );
        }//end if

        this.addItem(
            id,
            {
                type: 'popup',
                element: main,
                topContent: topContent,
                midContent: midContent,
                bottomContent: bottomContent,
                openCallback: openCallback,
                closeCallback: closeCallback,
                showTop: function() {
                    ViperUtil.$(topContent).slideDown(
                        null,
                        function() {
                            if (fullScreen === true) {
                                showfullScreen();
                            }
                        }
                    );
                },
                hideTop: function() {
                    ViperUtil.$(topContent).slideUp(
                        null,
                        function() {
                            if (fullScreen === true) {
                                showfullScreen();
                            }
                        }
                    );
                }
            }
        );

        return main;

    },

    openPopup: function(id, width, height, minWidth)
    {
        var popup        = this.getItem(id);
        var contentElem  = popup.midContent;
        var popupElement = popup.element;

        if (minWidth) {
            ViperUtil.setStyle(contentElem, 'min-width', minWidth);
        }

        if (width) {
            ViperUtil.setStyle(contentElem, 'width', width + 'px');
        }

        if (height) {
            ViperUtil.setStyle(contentElem, 'height', height + 'px');
        }

        ViperUtil.setStyle(popupElement, 'left', '-9999px');
        ViperUtil.setStyle(popupElement, 'top', '-9999px');
        ViperUtil.setStyle(popupElement, 'visibility', 'hidden');
        this.viper.addElement(popupElement);

        // Set the pos to be the middle of the screen.
        var elementDim = ViperUtil.getBoundingRectangle(popupElement);
        var windowDim  = ViperUtil.getWindowDimensions();

        var toolbarHieght = 36;

        var marginTop = (((elementDim.y2 - elementDim.y1) / 2) * -1);

        // If the popup is off the top of the screen then move it back down.
        var offScreenTop = (windowDim.height / 2) + marginTop
        if (offScreenTop < toolbarHieght) {
            marginTop -= (offScreenTop - toolbarHieght);
        }

        if ((elementDim.y2 - elementDim.y1) > (windowDim.height - toolbarHieght)) {
            ViperUtil.setStyle(contentElem, 'height', (height - (elementDim.y2 - elementDim.y1 - windowDim.height) - toolbarHieght) + 'px');
        }

        ViperUtil.setStyle(popupElement, 'margin-left', (((elementDim.x2 - elementDim.x1) / 2) * -1) + 'px');
        ViperUtil.setStyle(popupElement, 'margin-top', marginTop + 'px');

        ViperUtil.setStyle(popupElement, 'left', '50%');
        ViperUtil.setStyle(popupElement, 'top', '50%');

        if (popup.openCallback) {
            if (popup.openCallback.call(this) === false) {
                // Do not open.
                popupElement.parentNode.removeChild(popupElement);
                return;
            }
        }

        this.viper.fireCallbacks('ViperTools:popup:open', id);

        ViperUtil.$(popup.element).draggable('enable');

        ViperUtil.setStyle(popupElement, 'visibility', 'visible');

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

        ViperUtil.$(popup.element).draggable('disable');

        if (popup.element.parentNode) {
            popup.element.parentNode.removeChild(popup.element);
        }

        this.viper.fireCallbacks('ViperTools:popup:close', id);

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
        ViperUtil.setHtml(subSectionContainer, '<span class="Viper-subSectionArrow"></span>');
        toolbar.appendChild(subSectionContainer);

        ViperUtil.addClass(toolbar, 'ViperITP Viper-themeDark Viper-scalable');
        ViperUtil.addClass(toolsContainer, 'ViperITP-tools');
        ViperUtil.addClass(subSectionContainer, 'ViperITP-subSectionWrapper');

        if (navigator.userAgent.match(/iPad/i) !== null) {
            ViperUtil.addClass(toolbar, 'device-ipad');
        }

        if (compact === true) {
            ViperUtil.addClass(toolbar, 'Viper-compact');
        }

        ViperUtil.addEvent(
            toolbar,
            'mousedown',
            function(e) {
                var target = ViperUtil.getMouseEventTarget(e);
                if (ViperUtil.isTag(target, 'input') !== true && ViperUtil.isTag(target, 'textarea') !== true) {
                    ViperUtil.preventDefault(e);
                    return false;
                }
            }
        );

        ViperUtil.addEvent(
            toolbar,
            'mouseup',
            function(e) {
                ViperUtil.preventDefault(e);
                return false;
            }
        );

        var _update = false;
        this.viper.registerCallback(
            'Viper:selectionChanged',
            id,
            function(range) {
                if (self.viper.rangeInViperBounds(range) === false) {
                    return;
                }

                if (range.collapsed === true && _update !== true) {
                    self.getItem(id).hide();
                    return;
                }

                // Update the toolbar position, contents and lineage for this new selection.
                self.getItem(id).update(range);
            }
        );

        // Add scroll event to iframes so that the toolbar is closed when the
        // scroll is happening.
        this.viper.registerCallback(
            'Viper:editableElementChanged',
            id,
            function() {
                var elemDoc = self.viper.getViperElementDocument();
                if (elemDoc !== document) {
                    var t       = null;
                    var toolbar = self.getItem(id);
                    ViperUtil.removeEvent(elemDoc.defaultView, 'scroll.' + id);
                    ViperUtil.addEvent(
                        elemDoc.defaultView,
                        'scroll.' + id,
                        function(e) {
                            if (toolbar.isVisible() === true) {
                                toolbar.hide();
                            }

                            clearTimeout(t);
                            t = setTimeout(
                                function() {
                                    ViperUtil.removeClass(toolbar.element, 'scrolling');
                                    self.getItem(id).update();
                                },
                                300
                            );
                        }
                    );
                }//end if
            }
        );

        this.viper.registerCallback(
            'Viper:clickedOutside',
            id,
            function(range) {
                self.getItem(id).hide();
            }
        );

        this.viper.registerCallback(
            ['Viper:mouseDown',
            'ViperHistoryManager:undo'],
            id,
            function(data) {
                _update = false;
                if (data && data.target) {
                    var target = ViperUtil.getMouseEventTarget(data);
                    if (target === toolbar || ViperUtil.isChildOf(target, toolbar) === true) {
                        if (ViperUtil.isTag(target, 'input') === true
                            || ViperUtil.isTag(target, 'textarea') === true
                        ) {
                            // Allow event to bubble so the input element can get focus etc.
                            return true;
                        }

                        return false;
                    } else if (elementTypes
                        && ViperUtil.inArray(ViperUtil.getTagName(target), elementTypes) === true
                    ) {
                        self.getItem(id).update(null, target);
                        return;
                    } else if (ViperUtil.inArray(ViperUtil.getTagName(target), self.getItem(id)._keepOpenTagList) === true) {
                        _update = true;
                        return;
                    } else {
                        var allParents = ViperUtil.getParents(target, null, self.viper.getViperElement());
                        for (var i = 0; i < allParents.length; i++) {
                            if (ViperUtil.inArray(ViperUtil.getTagName(allParents[i]), self.getItem(id)._keepOpenTagList) === true) {
                                _update = true;
                                return;
                            }
                        }

                        var parents = ViperUtil.getSurroundingParents(target);
                        for (var i = 0; i < parents.length; i++) {
                            if (ViperUtil.inArray(ViperUtil.getTagName(parents[i]), self.getItem(id)._keepOpenTagList) === true) {
                                _update = true;
                                return;
                            }
                        }
                    }//end if
                }//end if

                self.getItem(id).hide();
            }
        );

        var tools          = this;
        var buttonElements = null;
        this.addItem(
            id,
            {
                type: 'toolbar',
                element: toolbar,
                addButton: function(button, index) {
                    if (ViperUtil.isset(index) === true && toolsContainer.childNodes.length > index) {
                        if (index < 0) {
                            index = toolsContainer.childNodes.length + index;
                            if (index < 0) {
                                index = 0;
                            }
                        }

                        ViperUtil.insertBefore(toolsContainer.childNodes[index], button);
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
                    ViperUtil.removeClass(button.element, 'ViperITP-button-hidden');
                    ViperUtil.removeClass(button.element.parentNode, 'ViperITP-button-hidden');

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
                    range            = range || self.viper.getViperRange();

                    if (!selectedNode) {
                        if (elementTypes && elementTypes.length > 0) {
                            return;
                        }
                    }

                    var activeSection = this._activeSection;
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
                            if (ViperUtil.hasClass(node, 'Viper-buttonGroup') === true) {
                                var groupButtons = [node];
                                for (var button = node.firstChild; button; button = button.nextSibling) {
                                    groupButtons.push(button);
                                }

                                buttonElements.push(groupButtons);
                            } else if (ViperUtil.hasClass('Viper-button') === true) {
                                buttonElements.push(node);
                            }
                        }
                    } else {
                        while (toolsContainer.firstChild) {
                            toolsContainer.removeChild(toolsContainer.firstChild);
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
                    }//end if

                    updateCallback.call(this, range, selectedNode, activeSection !== null);

                    var buttonsToRemove = ViperUtil.getClass('ViperITP-button-hidden', toolsContainer);
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
                    ViperUtil.removeClass(toolbar, 'Viper-subSectionVisible');
                    ViperUtil.addClass(ViperUtil.getClass('Viper-buttonGroup', toolsContainer), 'ViperITP-button-hidden');

                    var buttons = ViperUtil.getClass('Viper-button', toolsContainer);
                    ViperUtil.addClass(buttons, 'ViperITP-button-hidden');
                    ViperUtil.removeClass(buttons, 'Viper-selected');
                    ViperUtil.removeClass(buttons, 'Viper-active');
                },

                hide: function() {
                    if (this._onHideCallback) {
                        if (this._onHideCallback.call(this) === false) {
                            return false;
                        }
                    }

                    this.closeActiveSubsection(true);
                    this._activeSection = null;
                    ViperUtil.removeClass(toolbar, 'Viper-visible');

                    // Disable all subsection action buttons.
                    for (subsectionid in this._subSectionActionWidgets) {
                        tools.disableButton(subsectionid + '-applyButton');
                    }

                    return true;
                },

                isVisible: function() {
                    return ViperUtil.hasClass(toolbar, 'Viper-visible');
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

                    var submitBtn  = document.createElement('input');
                    submitBtn.type = 'submit';
                    ViperUtil.setStyle(submitBtn, 'display', 'none');
                    form.appendChild(submitBtn);

                    ViperUtil.addClass(subSection, 'Viper-subSection');

                    this._subSections[id] = subSection;

                    subSectionContainer.appendChild(subSection);

                    tools.addItem(
                        id,
                        {
                            type: 'VITPSubSection',
                            element: subSection,
                            form: form,
                            _onOpenCallback: onOpenCallback,
                            _onCloseCallback: onCloseCallback
                        }
                    );

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

                    ViperUtil.removeEvent(button, 'mousedown');
                    ViperUtil.addEvent(
                        button,
                        'mousedown',
                        function(e) {
                            if (ViperUtil.isBrowser('msie', '<11') === true) {
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

                            // Set the subSection to visible and hide rest of the sub sections.
                            self.toggleSubSection(subSectionid);

                            ViperUtil.preventDefault(e);
                        }
                    );
                },

                /**
                 * Toggles the visibility of the specified sub section.
                 *
                 * @param {string} subSectionid The if of the sub section.
                 */
                toggleSubSection: function(subSectionid, ignoreCallbacks) {
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
                    ViperUtil.removeClass(ViperUtil.getClass('Viper-subSection Viper-active', subSectionContainer), 'Viper-active');

                    if (this._subSectionButtons[subSectionid]) {
                        var subSectionButton = tools.getItem(this._subSectionButtons[subSectionid]).element;
                        if (ViperUtil.hasClass(subSectionButton, 'ViperITP-button-hidden') === true) {
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
                    ViperUtil.addClass(subSectionButton, 'Viper-selected');

                    ViperUtil.addClass(subSection, 'Viper-active');
                    ViperUtil.addClass(toolbar, 'Viper-subSectionVisible');
                    this._activeSection = subSectionid;
                    this._updateSubSectionArrowPos();

                    var self = this;
                    setTimeout(
                        function() {
                            self.focusSubSection();
                        },
                        50
                    );

                    this._subSectionShown = true;

                    var subSectionForm = tools.getItem(subSectionid).form;
                    ViperUtil.removeEvent(document, 'keydown.' + id);
                    ViperUtil.addEvent(
                        document,
                        'keydown.' + id,
                        function(e) {
                            if (subSectionForm && e.which === 13 && ViperUtil.isTag(e.target, 'textarea') === false) {
                                return subSectionForm.onsubmit();
                            }
                        }
                    );
                },

                focusSubSection: function() {
                    try {
                        var subSection    = this._subSections[this._activeSection];
                        var inputElements = ViperUtil.getTag('input[type=text], textarea', subSection);
                        if (inputElements.length > 0) {
                            inputElements[0].focus();
                            ViperUtil.removeClass(inputElements[0].parentNode.parentNode.parentNode, 'Viper-active');

                            if (ViperUtil.isBrowser('msie') === false) {
                                tools.viper.highlightSelection();
                            } else {
                                setTimeout(
                                    function() {
                                        inputElements[0].focus();
                                    },
                                    10
                                );
                            }
                        }
                    } catch (e) {
                    }
                },

                closeActiveSubsection: function(ignoreCallbacks) {
                    if (this._activeSection) {
                        var prevSubSection = this._subSections[this._activeSection];
                        if (prevSubSection) {
                            ViperUtil.removeClass(prevSubSection, 'Viper-active');

                            tools.viper.fireCallbacks('ViperToolbar:subsectionClosed', this._activeSection);

                            if (this._subSectionButtons[this._activeSection]) {
                                ViperUtil.removeClass(tools.getItem(this._subSectionButtons[this._activeSection]).element, 'Viper-selected');
                            }

                            if (ignoreCallbacks !== true) {
                                var closeCallback = tools.getItem(this._activeSection)._onCloseCallback;
                                if (closeCallback) {
                                    closeCallback.call(this);
                                }
                            }

                            ViperUtil.removeClass(toolbar, 'Viper-subSectionVisible');
                            this._activeSection = null;

                            ViperUtil.removeEvent(document, 'keydown.' + id);
                            return;
                        }
                    }//end if
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
                setSubSectionAction: function(subSectionid, action, widgetids) {
                    widgetids      = widgetids || [];
                    var subSection = tools.getItem(subSectionid);
                    if (!subSection) {
                        return;
                    }

                    subSection.form.onsubmit = function(e) {
                        if (e) {
                            ViperUtil.preventDefault(e);
                        }

                        var button = tools.getItem(subSectionid + '-applyButton');
                        if (button.isEnabled() === false) {
                            return false;
                        }

                        tools.viper.focus();

                        if (ViperUtil.isBrowser('msie') === false) {
                            try {
                                action.call(this);
                            } catch (e) {
                                console.error('Sub Section Action threw exception:' + e.message);
                            }
                        } else {
                            // IE needs this timeout so focus works <3..
                            setTimeout(
                                function() {
                                    try {
                                        action.call(this);
                                    } catch (e) {
                                        console.error('Sub Section Action threw exception:' + e.message);
                                    }
                                },
                                2
                            );
                        }

                        tools.disableButton(subSectionid + '-applyButton');

                        return false;
                    };

                    var button = tools.createButton(subSectionid + '-applyButton', _('Apply Changes'), _('Apply Changes'), '', subSection.form.onsubmit, true);
                    subSection.element.appendChild(button);

                    this.addSubSectionActionWidgets(subSectionid, widgetids);
                },

                addSubSectionActionWidgets: function(subSectionid, widgetids) {
                    if (!this._subSectionActionWidgets[subSectionid]) {
                        this._subSectionActionWidgets[subSectionid] = [];
                    }

                    var self = this;
                    for (var i = 0; i < widgetids.length; i++) {
                        this._subSectionActionWidgets[subSectionid].push(widgetids[i]);

                        (function(widgetid) {
                            tools.viper.registerCallback(
                                'ViperTools:changed:' + widgetid,
                                'ViperToolbarPlugin:' + id,
                                function() {
                                    var subSectionWidgets = self._subSectionActionWidgets[subSectionid];
                                    var c      = subSectionWidgets.length;
                                    var enable = true;
                                    for (var j = 0; j < c; j++) {
                                        var widget = tools.getItem(subSectionWidgets[j]);
                                        if (widget && widget.required === true && ViperUtil.trim(widget.getValue()) === '') {
                                            enable = false;
                                            break;
                                        }
                                    }

                                    if (enable === true) {
                                        tools.enableButton(subSectionid + '-applyButton');
                                    } else {
                                        tools.disableButton(subSectionid + '-applyButton');
                                    }
                                }
                            );
                        }) (widgetids[i]);
                    }//end for
                },

                addKeepOpenTag: function(tagName) {
                    this._keepOpenTagList.push(tagName);
                },

                orderButtons: function(buttonOrder) {
                    // Get all the buttons from the container.
                    var buttons = ViperUtil.getClass('Viper-button', toolsContainer);
                    var c       = buttons.length;

                    if (c === 0) {
                        return;
                    }

                    // Clear the buttons container contents.
                    while (toolsContainer.firstChild) {
                        toolsContainer.removeChild(toolsContainer.firstChild);
                    }

                    // Get the button ids and their elements.
                    var addedButtons = {};
                    for (var i = 0; i < c; i++) {
                        var button       = buttons[i];
                        var id           = button.id.toLowerCase().replace(self.viper.getId().toLowerCase() + '-vitp', '');
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
                            var gc      = button.length;
                            var groupid = null;
                            for (var j = 0; j < gc; j++) {
                                if (addedButtons[button[j].toLowerCase()]) {
                                    if (groupid === null) {
                                        // Create the group.
                                        groupid      = 'ViperInlineToolbarPlugin:buttons:' + i;
                                        groupElement = self.createButtonGroup(groupid);
                                        this.addButton(groupElement);
                                    }

                                    // Button is included in the setting, add it to group.
                                    self.addButtonToGroup('vitp' + ViperUtil.ucFirst(button[j]), groupid);
                                }
                            }
                        }//end if
                    }//end for
                },
                hideToolsSection: function() {
                    ViperUtil.setStyle(toolsContainer, 'display', 'none');
                    ViperUtil.addClass(toolbar, 'Viper-noTools');
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

                    if (!rangeCoords || (rangeCoords.left === 0 && rangeCoords.top === 0 && ViperUtil.isBrowser('firefox') === true)) {
                        if (range.collapsed === true) {
                            var span = document.createElement('span');
                            tools.viper.insertNodeAtCaret(span);
                            rangeCoords = this.getElementCoords(span);
                            ViperUtil.remove(span);

                            if (!rangeCoords) {
                                return;
                            }
                        } else {
                            var startNode = range.getStartNode();
                            var endNode   = range.getEndNode();
                            if (!startNode || !endNode) {
                                return;
                            }

                            if (startNode.nodeType === ViperUtil.TEXT_NODE
                                && startNode.data.indexOf("\n") === 0
                                && endNode.nodeType === ViperUtil.TEXT_NODE
                                && range.endOffset === endNode.data.length
                            ) {
                                range.setStart(endNode, endNode.data.length);
                                range.collapse(true);
                                rangeCoords = range.rangeObj.getBoundingClientRect();
                            }
                        }//end if
                    }//end if

                    if (!rangeCoords || (rangeCoords.bottom === 0 && rangeCoords.height === 0 && rangeCoords.left === 0)) {
                        if (ViperUtil.isBrowser('chrome') === true || ViperUtil.isBrowser('safari') === true) {
                            // Webkit bug workaround. https://bugs.webkit.org/show_bug.cgi?id=65324.
                            // OK.. Yet another fix. With the latest Google Chrome (17.0.963.46)
                            // the !rangeCoords check started to fail because its no longer
                            // returning null for a collapsed range, instead all values are set to 0.
                            var startNode = range.getStartNode();
                            if (startNode.nodeType === ViperUtil.TEXT_NODE) {
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

                    var scrollCoords = ViperUtil.getScrollCoords();

                    ViperUtil.addClass(toolbar, 'Viper-calcWidth');
                    ViperUtil.setStyle(toolbar, 'width', 'auto');
                    var toolbarWidth = ViperUtil.getElementWidth(toolbar);
                    ViperUtil.removeClass(toolbar, 'Viper-calcWidth');
                    ViperUtil.setStyle(toolbar, 'width', toolbarWidth + 'px');

                    var viperElemCoords = this.getElementCoords(tools.viper.getViperElement());
                    var elemWindowDim   = ViperUtil.getWindowDimensions(Viper.document.defaultView);
                    var mainWindowDim   = ViperUtil.getWindowDimensions();

                    if (this._verticalPosUpdateOnly !== true) {
                        var left = ((rangeCoords.left + ((rangeCoords.right - rangeCoords.left) / 2) + scrollCoords.x) - (toolbarWidth / 2));
                        ViperUtil.removeClass(toolbar, 'Viper-orientationLeft Viper-orientationRight');

                        if (left > (elemWindowDim.width + frameOffset.x)) {
                            // Dont go off screen, point to the editable element.
                            left = viperElemCoords.left;
                        }

                        if (left < 0) {
                            left += (toolbarWidth / 2);
                            ViperUtil.addClass(toolbar, 'Viper-orientationLeft');
                        } else if (left + toolbarWidth > mainWindowDim.width) {
                            left -= (toolbarWidth / 2);
                            ViperUtil.addClass(toolbar, 'Viper-orientationRight');
                        }

                        ViperUtil.setStyle(toolbar, 'left', left + 'px');
                    }

                    var top = (rangeCoords.bottom + margin + scrollCoords.y);

                    if (top === 0) {
                        this.hide();
                        return;
                    } else if (((top + 50) > (mainWindowDim.height + scrollCoords.y)) || (top > elemWindowDim.height + scrollCoords.y + frameOffset.y)) {
                        this.hide();
                        return;
                    } else if (top < viperElemCoords.top && Viper.document === document) {
                        top = (viperElemCoords.top + 50);
                        if (left < viperElemCoords.left && this._verticalPosUpdateOnly !== true) {
                            ViperUtil.setStyle(toolbar, 'left', viperElemCoords.left + 50 + 'px');
                        }
                    } else if (Viper.document !== document && top < tools.viper.getDocumentOffset().y) {
                        this.hide();
                        return;
                    }

                    ViperUtil.setStyle(toolbar, 'top', top + 'px');
                    ViperUtil.addClass(toolbar, 'Viper-visible');
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

                    var buttonRect = ViperUtil.getBoundingRectangle(button);
                    var toolbarPos = ViperUtil.getBoundingRectangle(toolbar);
                    var xPos       = (buttonRect.x1 - toolbarPos.x1 + ((buttonRect.x2 - buttonRect.x1) / 2));
                    ViperUtil.setStyle(subSectionContainer.firstChild, 'left', xPos + 'px');
                },
                getElementCoords: function(element) {
                    var elemRect     = ViperUtil.getBoundingRectangle(element);
                    var scrollCoords = ViperUtil.getScrollCoords(element.ownerDocument.defaultView);
                    return {
                        left: (elemRect.x1 - scrollCoords.x),
                        right: (elemRect.x2 - scrollCoords.x),
                        top: (elemRect.y1 - scrollCoords.y),
                        bottom: (elemRect.y2 - scrollCoords.y)
                    };
                }
            }
        );

        this.viper.addElement(toolbar);

        return toolbar;

    },

    getVisibleToolbarRectangles: function()
    {
        var rects           = [];
        var visibleToolbars = ViperUtil.getClass('ViperITP Viper-visible', this.viper.getElementHolder());
        if (visibleToolbars.length === 0) {
            return rects;
        }

        for (var i = 0; i < visibleToolbars.length; i++) {
            rects.push(ViperUtil.getBoundingRectangle(visibleToolbars[i]));
        }

        return rects;

    },

    createToolTip: function(id, content, element)
    {
        var self    = this;
        var tooltip = document.createElement('div');
        ViperUtil.addClass(tooltip, 'Viper-tooltip');
        ViperUtil.setHtml(tooltip, content);

        var visible = false;
        var mouseX  = 0;
        var mouseY  = 0;

        if (element && element !== 'mouse') {
            // Show tooltip on hover.
            var timer = null;
            ViperUtil.hover(
                element,
                function() {
                    timer = setTimeout(
                        function() {
                            self.getItem(id).show(element);
                        },
                        500
                    );
                },
                function() {
                    clearTimeout(timer);
                    self.getItem(id).hide();
                }
            );
        } else if (element === 'mouse') {
            ViperUtil.addEvent(
                document,
                'mousemove',
                function(e) {
                    mouseX = e.pageX;
                    mouseY = e.pageY;

                    if (visible !== true) {
                        return;
                    }

                    ViperUtil.setStyle(tooltip, 'left', mouseX + 'px');
                    ViperUtil.setStyle(tooltip, 'top', mouseY + 'px');
                }
            );
        }//end if


        this.addItem(
            id,
            {
                type: 'tooltip',
                element: tooltip,
                show: function(elem) {
                    if (elem && elem.nodeType) {
                        // Show tooltip on this element.
                        var rect = ViperUtil.getBoundingRectangle(elem);

                        ViperUtil.setStyle(tooltip, 'left', rect.x2 + 'px');
                        ViperUtil.setStyle(tooltip, 'top', rect.y2 + 'px');

                        self.viper.addElement(tooltip);
                        visible = true;
                    } else if (elem === 'mouse' || element === 'mouse') {
                        // Follow the mouse pointer.
                        ViperUtil.setStyle(tooltip, 'left', mouseX + 'px');
                        ViperUtil.setStyle(tooltip, 'top', mouseY + 'px');
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
            }
        );

        return tooltip;

    },

    createPopoutPanel: function(id, contentElement) {
        var panel = document.createElement('div');
        ViperUtil.addClass(panel, 'Viper-popoutPanel ViperUtil-hidden');

        if (contentElement) {
            panel.appendChild(contentElement);
        }

        this.viper.addElement(panel);

        // Positioning.
        this.addItem(
            id,
            {
                type: 'popoutPanel',
                element: panel,
                show: function(target) {
                    ViperUtil.removeClass(panel, 'ViperUtil-hidden');
                    ViperUtil.determinePosition(
                        panel,
                        {
                            targetElement: target,
                            position: 'right',
                            arrowPositions: ['left.middle', 'left.top', 'left.bottom']
                        }
                    );
                },
                hide: function() {
                    ViperUtil.addClass(panel, 'ViperUtil-hidden');
                },
                isOpen: function() {
                    return !ViperUtil.hasClass(panel, 'ViperUtil-hidden');
                }
            }
        );

        return panel;

    },

    createSelectionList: function(id, listItems, itemClickedCallback) {
        var self = this;
        var list = document.createElement('ol');
        ViperUtil.addClass(list, 'Viper-selectionList');

        for (var itemid in listItems) {
            var li = document.createElement('li');
            ViperUtil.attr(li, 'data-id', itemid);

            if (typeof listItems[itemid] === 'string') {
                ViperUtil.setHtml(li, listItems[itemid]);
            } else {
                ViperUtil.setHtml(li, listItems[itemid].content);

                if (listItems[itemid].selected === true) {
                    ViperUtil.addClass(li, 'ViperUtil-selectionList-selected');
                }
            }

            list.appendChild(li);
        }

        ViperUtil.addEvent(
            list,
            'click',
            function (e) {
                if (ViperUtil.isTag(e.target, 'li') === true) {
                    ViperUtil.toggleClass(e.target, 'selected');
                    self.viper.fireCallbacks('ViperTools:changed:' + id);
                    if (itemClickedCallback) {
                        itemClickedCallback.call(
                            this,
                            ViperUtil.attr(e.target, 'data-id'),
                            ViperUtil.hasClass(e.target, 'selected'),
                            e.target
                        );
                    }
                }
            }
        );

        ViperUtil.addEvent(
            list,
            'click',
            function(e) {
            }
        );

        this.addItem(
            id,
            {
                type: 'selectionList',
                element: list,
                setSelectedItems: function(itemids, isInitialValue) {
                    var items = ViperUtil.getTag('li', list);
                    var ln = items.length;
                    for (var i = 0; i < ln; i++) {
                        if (ViperUtil.inArray(ViperUtil.attr(items[i], 'data-id'), itemids) === true) {
                            ViperUtil.addClass(items[i], 'selected');
                        } else {
                            ViperUtil.removeClass(items[i], 'selected');
                        }
                    }

                    if (isInitialValue !== true) {
                        self.viper.fireCallbacks('ViperTools:changed:' + id);
                    }
                },
                getSelectedItems: function() {
                    var selectedItems = ViperUtil.getClass('selected', list);
                    var items         = [];
                    for (var i = 0; i < selectedItems.length; i++) {
                        items.push(ViperUtil.attr(selectedItems[i], 'data-id'));
                    }

                    return items;
                },
                removeFromSelection: function(itemid) {
                    var items = ViperUtil.getClass('selected', list);
                    var ln = items.length;
                    for (var i = 0; i < ln; i++) {
                        if (ViperUtil.attr(items[i], 'data-id') === itemid) {
                            ViperUtil.removeClass(items[i], 'selected');
                            self.viper.fireCallbacks('ViperTools:changed:' + id);
                            break;
                        }
                    }
                }
            }
        );

        return list;

    },

    scaleElement: function(element)
    {
        var zoom = (document.documentElement.clientWidth / window.innerWidth);
        if (zoom === 1) {
            var scale = 1;
            ViperUtil.setStyle(element, '-webkit-transform', 'scale(' + scale + ', ' + scale + ')');
            ViperUtil.setStyle(element, '-moz-transform', 'scale(' + scale + ', ' + scale + ')');
            return;
        }

        var scale = ((1 / zoom) + 0.2);

        ViperUtil.setStyle(element, '-webkit-transform', 'scale(' + scale + ', ' + scale + ')');
        ViperUtil.setStyle(element, '-moz-transform', 'scale(' + scale + ', ' + scale + ')');

        return scale;

    }

};
