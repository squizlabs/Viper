ViperAccessibilityPlugin_WCAG2_Principle1_Guideline1_1 = {
    hasCss: false,
    id: 'ViperAccessibilityPlugin_WCAG2_Principle1_Guideline1_1',
    parent: null,

    res_1_1_1: function(element, issue, code, callback, viper)
    {
        var div = document.createElement('div');
        dfx.addClass(div, 'ViperAP-WCAG2_Principle1_Guideline1_1_1');

        var editPanel = null;
        var action    = null;
        var self      = this;
        var technique = code.techniques[0];

        switch(technique) {
            case 'H37':
                var content = this._getImageResContent(element, 'Enter a short text description of the image, or define the image as purely presentational');
                dfx.setHtml(div, content);

                editPanel = dfx.getClass('editing', div)[0];

                var altid = dfx.getUniqueId();
                var alt   = viper.ViperTools.createTextbox(altid, 'Alt', element.getAttribute('alt'));
                editPanel.appendChild(alt);

                var checkboxid = dfx.getUniqueId();
                var checkbox   = viper.ViperTools.createCheckbox(checkboxid, 'Image is presentational', false, function(checked) {
                    if (checked === true) {
                        viper.ViperTools.getItem(altid).disable();
                    } else {
                        viper.ViperTools.getItem(altid).enable();
                    }
                });
                editPanel.appendChild(checkbox);

                action = function() {
                    if (viper.ViperTools.getItem(checkboxid).getValue() !== true) {
                        element.setAttribute('alt', viper.ViperTools.getItem(altid).getValue());
                    } else {
                        element.removeAttribute('alt');
                    }
                };

                editPanel.appendChild(this.parent.createActionButton(action, [checkboxid, altid]));
            break;

            case 'H67.1':
            case 'H67.2':
                var content = this._getImageResContent(element, 'Ensure this image is purely presentational, if not, enter appropriate Alt and Title text');
                dfx.setHtml(div, content);

                editPanel = dfx.getClass('editing', div)[0];

                var altid      = null;
                var titleid    = null;
                var checkboxid = null;
                if (technique === 'H67.2') {
                    checkboxid   = dfx.getUniqueId();
                    var checkbox = viper.ViperTools.createCheckbox(checkboxid, 'Image is presentational', true, function(checked) {
                        if (checked === true) {
                            viper.ViperTools.getItem(altid).disable();
                            viper.ViperTools.getItem(titleid).disable();
                        } else {
                            viper.ViperTools.getItem(altid).enable();
                            viper.ViperTools.getItem(titleid).enable();
                        }
                    });
                    editPanel.appendChild(checkbox);
                }

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
                    if (technique === 'H67.1' || viper.ViperTools.getItem(checkboxid).getValue() !== true) {
                        element.setAttribute('alt', viper.ViperTools.getItem(altid).getValue());
                        element.setAttribute('title', viper.ViperTools.getItem(titleid).getValue());
                    } else {
                        element.removeAttribute('alt');
                        element.removeAttribute('title');
                    }
                };

                editPanel.appendChild(this.parent.createActionButton(action, [checkboxid, titleid, altid]));
            break;

            case 'H2.EG3':
            case 'H30.2':
            case 'G94.Image':
                var msg = '';
                if (technique === 'H2') {
                    msg = 'Update the image\'s alt text to something other than the nearby link "' + element.getAttribute('alt') + '"';
                } else if (technique === 'H30') {
                    msg = 'Make sure the image\'s alt text describes the purpose of the link its being used for.';
                } else if (technique === 'G94') {
                    msg = 'Ensure the image\'s Alt text describes the purpose or content of the image.';
                }

                var content = this._getImageResContent(element, msg);
                dfx.setHtml(div, content);

                editPanel = dfx.getClass('editing', div)[0];

                var altid = dfx.getUniqueId();
                var alt   = viper.ViperTools.createTextbox(altid, 'Alt', element.getAttribute('alt'));
                editPanel.appendChild(alt);
                action = function() {
                    element.setAttribute('alt', viper.ViperTools.getItem(altid).getValue());
                };

                editPanel.appendChild(this.parent.createActionButton(action, [altid]));
            break;

            default:
                // No interface.
            break;
        }//end switch

        callback.call(this, div);

    },

    _getImageResContent: function(element, msg)
    {
        var content = this.parent.getContent('<div class="imagePreview "><img class="thumb" src="' + element.getAttribute('src') + '"></div><p>' + msg + '</p>');
        return content;

    }

};
