function ViperTools(viper)
{
    this.viper = viper;

    var self = this;
    this.viper.registerCallback('Viper:mouseUp', 'ViperTools', function(e) {
        if (self._preventMouseUp === true) {
            self._preventMouseUp = false;
            return false;
        }
    });

}

ViperTools.prototype = {

    /**
     * If true then the next mouse up event will not fire.
     */
    _preventMouseUp: false,

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
        if (subSection) {
            dfx.addClass(button, 'toggleSubSectionButton');

            // Show/hide subsection if there is one..
            dfx.addEvent(button, 'mousedown.Viper', function(e) {
                self._preventMouseUp = true;
                dfx.preventDefault(e);
                if (dfx.hasClass(button, 'disabled') === true) {
                    return false;
                }

                var state = self.viper.ViperTools.toggleSubSection(subSection);
                if (clickAction) {
                    clickAction.call(this, state, button);
                }

                return false;
            });
        } else if (clickAction) {
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

        if (subSection && showSubSection === true) {
            if (clickAction) {
                clickAction.call(this, this.viper.ViperTools.toggleSubSection(subSection), button);
            }
        }

        if (groupElement) {
            // Add this button to the group.
            groupElement.appendChild(button);
        }

        return button;

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
    createTextbox: function(value, label, required, expandable)
    {
        var textBox = document.createElement('input');
        dfx.addClass(textBox, 'Viper-input');
        textBox.type  = 'text';
        textBox.size  = 10;
        textBox.value = value;

        var self  = this;

        var t = null;
        dfx.addEvent(textBox, 'focus', function(e) {
            dfx.addClass(labelElem, 'active');
        });

        dfx.addEvent(textBox, 'blur', function(e) {
            dfx.removeClass(labelElem, 'active');
            clearTimeout(t);
        });

        if (label) {
            var labelElem = document.createElement('label');
            dfx.addClass(labelElem, 'Viper-label');
            var span = document.createElement('span');
            dfx.addClass(span, 'Viper-labelText');
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
     * Creates a checkbox.
     *
     * @param {string}  label   The label for the checkbox.
     * @param {boolean} checked True if checked by default.
     *
     * @return {DOMElement} The checkbox element.
     */
    createCheckbox: function(label, checked)
    {
        var labelElem = document.createElement('label');
        dfx.addClass(labelElem, 'Viper-checkbox-label');

        var checkbox  = document.createElement('input');
        checkbox.type = 'checkbox';
        dfx.addClass(checkbox, 'Viper-checkbox');
        checkbox.checked = checked || false;

        var span = document.createElement('span');
        dfx.addClass(span, 'Viper-checkbox-text');
        dfx.setHtml(span, label);

        labelElem.appendChild(checkbox);
        labelElem.appendChild(span);

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
