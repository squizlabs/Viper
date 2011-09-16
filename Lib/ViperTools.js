var ViperTools = {

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
                titleAttr = '[Disabled] ' + titleAttr;
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

        if (subSection) {
            dfx.addClass(button, 'toggleSubSectionButton');

            // Show/hide subsection if there is one..
            dfx.addEvent(button, 'mousedown.Viper', function(e) {
                dfx.preventDefault(e);
                if (dfx.hasClass(button, 'disabled') === true) {
                    return false;
                }

                var state = ViperTools.toggleSubSection(subSection);
                if (clickAction) {
                    clickAction.call(this, state, button);
                }

                return false;
            });
        } else if (clickAction) {
            dfx.addEvent(button, 'mousedown.Viper', function(e) {
                dfx.preventDefault(e);
                if (dfx.hasClass(button, 'disabled') === true) {
                    return false;
                }

                return clickAction.call(this, button);
            });
        }

        if (isActive === true) {
            dfx.addClass(button, 'active');
        }

        if (subSection && showSubSection === true) {
            if (clickAction) {
                clickAction.call(this, ViperTools.toggleSubSection(subSection), button);
            }
        }

        if (groupElement) {
            // Add this button to the group.
            groupElement.appendChild(button);
        }

        return button;

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

    }

};
