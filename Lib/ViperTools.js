function ViperTools(viper)
{
    this.viper = viper;

    this._items = {};

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

    getItem: function(id)
    {
        return this._items[id];

    },


    /**
     * If true then the next mouse up event will not fire.
     */
    _preventMouseUp: false,

    createRow: function(id, customClass)
    {
        var elem = document.createElement('div');
        dfx.addClass(elem, 'subSectionRow');

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
    createButton: function(id, content, titleAttr, customClass, clickAction, disabled, isActive)
    {
        if (!content) {
            if (customClass) {
                // Must be an icon button.
                content = '<span class="buttonIcon ' + customClass + '"></span>';
            } else {
                content = '';
            }

            content += '&nbsp;';
        }

        var button = document.createElement('div');

        if (titleAttr) {
            if (disabled === true) {
                titleAttr = titleAttr + ' [Not available]';
            }

            button.setAttribute('title', titleAttr);
        }

        dfx.setHtml(button, content);
        dfx.addClass(button, 'Viper-button');

        if (disabled === true) {
            dfx.addClass(button, 'disabled');
        }

        if (customClass) {
            dfx.addClass(button, customClass);
        }

        var preventMouseUp = false;
        var self           = this;
        if (clickAction) {
            dfx.addEvent(button, 'mousedown.Viper', function(e) {
                self._preventMouseUp = true;
                dfx.preventDefault(e);
                if (dfx.hasClass(button, 'disabled') === true) {
                    return false;
                }

                return clickAction.call(this, button);
            });
        }//end if

        dfx.addEvent(button, 'mouseup.Viper', function(e) {
            dfx.preventDefault(e);
            return false;
        });

        if (isActive === true) {
            dfx.addClass(button, 'active');
        }

        this.addItem(id, {
            type: 'button',
            element: button
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
        dfx.removeClass(this.getItem(buttonid).element, 'active');

    },

    setButtonActive: function(buttonid)
    {
        dfx.addClass(this.getItem(buttonid).element, 'active');
        dfx.removeClass(this.getItem(buttonid).element, 'disabled');

    },

    enableButton: function(buttonid)
    {
        dfx.removeClass(this.getItem(buttonid).element, 'disabled');

    },

    disableButton: function(buttonid)
    {
        dfx.addClass(this.getItem(buttonid).element, 'disabled');

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
    createTextbox: function(id, label, value, action, required, expandable, desc, events)
    {
        label = label || '&nbsp;';
        value = value || '';

        var textBox = document.createElement('div');
        dfx.addClass(textBox, 'Viper-textbox');

        var labelEl = document.createElement('label');
        dfx.addClass(labelEl, 'Viper-textbox-label');
        textBox.appendChild(labelEl);

        var main = document.createElement('div');
        dfx.addClass(main, 'Viper-textbox-main');
        labelEl.appendChild(main);

        var title = document.createElement('span');
        dfx.addClass(title, 'Viper-textbox-title');
        dfx.setHtml(title, label);
        document.body.appendChild(title);
        var width = dfx.getElementWidth(title);
        width     += 10;
        main.appendChild(title);

        var input   = document.createElement('input');
        input.type  = 'text';
        input.value = value;
        dfx.addClass(input, 'Viper-textbox-input');
        dfx.setStyle(input, 'padding-left', width + 'px');
        main.appendChild(input);

        if (desc) {
            // Description.
            var desc = document.createElement('span');
            dfx.addClass(desc, 'Viper-textbox-desc');
            dfx.setHtml(desc, desc);
            textBox.appendChild(desc);
        }

        var self = this;
        dfx.addEvent(input, 'focus', function() {
            self.viper.highlightSelection();
        });

        var _addActionButton = function() {
            var actionIcon = document.createElement('span');
            dfx.addClass(actionIcon, 'Viper-textbox-action revert');
            main.appendChild(actionIcon);
            dfx.addEvent(actionIcon, 'click', function() {
                if (dfx.hasClass(textBox, 'actionRevert') === true) {
                    input.value = value;
                    dfx.removeClass(textBox, 'actionRevert');
                    dfx.addClass(textBox, 'actionClear');
                } else if (dfx.hasClass(textBox, 'actionClear') === true) {
                    input.value = '';
                    dfx.removeClass(textBox, 'actionClear');
                }
            });

            return actionIcon;
        };

        if (value !== '') {
            var actionIcon = _addActionButton();
            actionIcon.setAttribute('title', 'Clear this value');
            dfx.addClass(textBox, 'actionClear');
        }

        dfx.addEvent(input, 'keyup', function(e) {
            var actionIcon = dfx.getClass('Viper-textbox-action', main);
            if (actionIcon.length === 0) {
                actionIcon = _addActionButton();
            } else {
                actionIcon = actionIcon[0];
            }

            dfx.removeClass(textBox, 'actionClear');
            dfx.removeClass(textBox, 'actionRevert');

            if (input.value !== value && value !== '') {
                // Show the revert icon.
                actionIcon.setAttribute('title', 'Revert to original value');
                dfx.addClass(textBox, 'actionRevert');
            } else if (input.value !== '') {
                actionIcon.setAttribute('title', 'Clear this value');
                dfx.addClass(textBox, 'actionClear');
            } else {
                dfx.remove(actionIcon);
            }

            // Action.
            if (action && e.which === 13) {
                self.viper.focus();
                action.call(input, input.value);
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
            getValue: function() {
                return input.value;
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

        // TODO: How can we make this class generic or get type of item, maybe?
        var msgsElement = dfx.getClass(item, 'Viper-textbox-messages');
        if (msgsElement.length === 0) {
            if (errorCount === 0) {
                return;
            }

            msgsElement = document.createElement('div');
            dfx.addClass(msgsElement, 'Viper-textbox-messages');
        } else {
            msgsElement = msgsElement[0];
            if (errorCount === 0) {
                dfx.remove(msgsElement);
                return;
            }

            dfx.empty(msgsElement);
        }

        var content = '';
        for (var i = 0; i < c; i++) {
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
    createCheckbox: function(id, label, checked)
    {
        var labelElem = document.createElement('label');
        dfx.addClass(labelElem, 'Viper-checkbox');

        var checkbox  = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.checked = checked || false;

        var span = document.createElement('span');
        dfx.addClass(span, 'Viper-checkbox-title');
        dfx.setHtml(span, label);

        labelElem.appendChild(span);
        labelElem.appendChild(checkbox);

        this.addItem(id, {
            type: 'checkbox',
            element: labelElem,
            input: checkbox,
            getValue: function() {
                return checkbox.checked;
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
        var section = document.createElement('div');
        dfx.addClass(section, 'Viper-subSection');

        if (active === true) {
            dfx.addClass(section, 'active');
        }

        if (customClass) {
            dfx.addClass(section, customClass);
        }

        if (typeof contentElement === 'string') {
            dfx.setHtml(section, contentElement);
        } else {
            section.appendChild(contentElement);
        }

        return section;

    },

    toggleSubSection: function(subSectionElement)
    {
        // Hide other subsections.
        var activeSubSection = dfx.getClass('Viper-subSection active', subSectionElement.parentNode);
        if (activeSubSection.length > 0) {
            dfx.removeClass(activeSubSection, 'active');
            if (activeSubSection[0] === subSectionElement) {
                return false;
            }
        }

        dfx.addClass(subSectionElement, 'active');

        return true;

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
