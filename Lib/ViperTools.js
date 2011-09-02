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
     * @param {string}     content      The content of the button.
     * @param {string}     isActive     True if the button is active.
     * @param {string}     customClass  Class to add to the button for extra styling.
     * @param {function}   clickAction  The function to call when the button is clicked.
     * @param {DOMElement} groupElement The group element that was created by createButtonGroup.
     * @param {DOMElement} subSection   The sub section element see createSubSection.
     *
     * @return {DOMElement} The new button element.
     */
    createButton: function(content, isActive, customClass, clickAction, groupElement, subSection)
    {
        if (!content) {
            content = '&nbsp;';
        }

        var button = document.createElement('div');
        dfx.setHtml(button, content);
        dfx.addClass(button, 'Viper-button');

        if (customClass) {
            dfx.addClass(button, customClass);
        }

        if (clickAction) {
            var self = this;
            dfx.addEvent(button, 'mousedown.Viper', function() {
                // Show subsection if there is one..
                if (subSection) {
                    self._showSubSection(subSection);
                }

                return clickAction.call(this);
            });
        }

        if (isActive === true) {
            dfx.addClass(button, 'active');
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
        dfx.addClass(section, 'ViperITP-subSection');

        if (active === true) {
            dfx.addClass(section, 'active');
        }

        if (customClass) {
            dfx.addClass(section, customClass);
        }

        section.appendChild(contentElement);

        return section;
    }

};
