ViperAccessibilityPlugin_WCAG2_Principle1_Guideline1_1 = {
    hasCss: false,
    id: 'ViperAccessibilityPlugin_WCAG2_Principle1_Guideline1_1',
    parent: null,

    res_1_1_1: function(contentElement, element, issue, code, viper)
    {
        var editPanel = null;
        var action    = null;
        var self      = this;
        var technique = code.techniques[0];

        switch (technique) {
            case 'H37':
            case 'H67.1':
            case 'H67.2':
                if (technique === 'H37') {
                    this._getImageResContent(contentElement, element, 'Enter a short text description of the image, or define the image as purely decorative.');
                } else {
                    this._getImageResContent(contentElement, element, 'Ensure this image is purely decorative. If not, enter appropriate alt and title text.');
                }

                editPanel = this.parent.getResolutionActionsContainer(contentElement);

                var altid      = null;
                var titleid    = null;
                var checkboxid = null;
                checkboxid   = dfx.getUniqueId();
                var checkbox = viper.ViperTools.createCheckbox(checkboxid, 'Image is decorative', (technique === 'H67.2'), function(checked) {
                    if (checked === true) {
                        viper.ViperTools.getItem(altid).disable();
                        viper.ViperTools.getItem(titleid).disable();
                    } else {
                        viper.ViperTools.getItem(altid).enable();
                        viper.ViperTools.getItem(titleid).enable();
                    }
                });
                editPanel.appendChild(checkbox);

                altid   = dfx.getUniqueId();
                var alt = viper.ViperTools.createTextbox(altid, 'Alt', element.getAttribute('alt'));
                editPanel.appendChild(alt);

                titleid   = dfx.getUniqueId();
                var title = viper.ViperTools.createTextbox(titleid, 'Title', element.getAttribute('title'));
                editPanel.appendChild(title);

                if (technique === 'H67.2') {
                    viper.ViperTools.getItem(altid).disable();
                    viper.ViperTools.getItem(titleid).disable();
                }

                action = function() {
                    if (viper.ViperTools.getItem(checkboxid).getValue() !== true) {
                        element.setAttribute('alt', viper.ViperTools.getItem(altid).getValue());
                        element.setAttribute('title', viper.ViperTools.getItem(titleid).getValue());
                    } else {
                        element.setAttribute('alt', '');
                        element.removeAttribute('title');
                    }
                };

                this.parent.addActionButton(action, contentElement, [checkboxid, titleid, altid], null, null, function() {
                    if (viper.ViperTools.getItem(checkboxid).getValue() !== true
                        && viper.ViperTools.getItem(altid).getValue() === ''
                    ) {
                        return false;
                    }
                });
            break;

            case 'H2.EG3':
            case 'H2.EG5':
            case 'H30.2':
            case 'G94.Image':
                var msg = '';
                if (technique === 'H2.EG3') {
                    msg = 'Update the image\'s alt text to something other than the nearby link "' + element.getAttribute('alt') + '".';
                } else if (technique === 'H30.2') {
                    msg = 'Make sure the image\'s alt text describes the purpose of the link it\'s being used for.';
                } else if (technique === 'G94') {
                    msg = 'Ensure the image\'s alt text describes the purpose or content of the image.';
                }

                if (dfx.isTag(element, 'a') === true) {
                    element = dfx.getTag('img', element)[0];
                }

                this._getImageResContent(contentElement, element, msg);

                editPanel = this.parent.getResolutionActionsContainer(contentElement);

                var altid = dfx.getUniqueId();
                var alt   = viper.ViperTools.createTextbox(altid, 'Alt', element.getAttribute('alt'));
                editPanel.appendChild(alt);
                action = function() {
                    element.setAttribute('alt', viper.ViperTools.getItem(altid).getValue());
                };

                this.parent.addActionButton(action, contentElement, [altid]);
            break;

            default:
                // No interface.
            break;
        }//end switch

    },

    _getImageResContent: function(contentElement, element, msg)
    {
        this.parent.setResolutionInstruction(contentElement, '<div class="Viper-imagePreview "><img class="Viper-thumb" src="' + element.getAttribute('src') + '"></div><p>' + msg + '</p>');

    }

};
