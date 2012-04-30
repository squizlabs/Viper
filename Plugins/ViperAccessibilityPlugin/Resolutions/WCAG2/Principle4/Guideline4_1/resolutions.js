ViperAccessibilityPlugin_WCAG2_Principle4_Guideline4_1 = {
    hasCss: false,
    id: 'ViperAccessibilityPlugin_WCAG2_Principle4_Guideline4_1',
    parent: null,

    res_4_1_1: function(contentElement, element, issue, code, viper, issueid)
    {
        var editPanel = null;
        var action    = null;
        var self      = this;
        var technique = code.techniques[0];

        switch(technique) {
            case 'F77':
                this.parent.setResolutionInstruction(contentElement, '<p>Update the ID to be unique.</p>');

                var editPanel = this.parent.getResolutionActionsContainer(contentElement);

                var idAttrid =  null;
                idAttrid     = dfx.getUniqueId();
                var idAttr   = viper.ViperTools.createTextbox(idAttrid, 'ID', element.getAttribute('id') || '');
                editPanel.appendChild(idAttr);

                action = function() {
                    var idAttrVal = viper.ViperTools.getItem(idAttrid).getValue();
                    element.setAttribute('id', idAttrVal);
                };

                this.parent.addActionButton(action, contentElement, [idAttrid], null, null, function() {
                    var idAttrVal = dfx.trim(viper.ViperTools.getItem(idAttrid).getValue());
                    if (!idAttrVal) {
                        return false;
                    } else {
                        var elem = dfx.getId(idAttrVal);
                        if (dfx.getParents(elem).inArray(viper.getViperElement()) === true) {
                            return false;
                        }
                    }
                });
            break;

            default:
                // No interface.
            break;

        }//end switch

    }

};
