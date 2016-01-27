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
                idAttrid     = Viper.Util.getUniqueId();
                var idAttr   = viper.Tools.createTextbox(idAttrid, 'ID', element.getAttribute('id') || '');
                editPanel.appendChild(idAttr);

                action = function() {
                    var idAttrVal = viper.Tools.getItem(idAttrid).getValue();
                    element.setAttribute('id', idAttrVal);
                };

                this.parent.addActionButton(action, contentElement, [idAttrid], null, null, function() {
                    var idAttrVal = Viper.Util.trim(viper.Tools.getItem(idAttrid).getValue());
                    if (!idAttrVal) {
                        return false;
                    } else {
                        var elem = Viper.Util.getid(idAttrVal);
                        if (Viper.Util.inArray(viper.getViperElement(), Viper.Util.getParents(elem)) === true) {
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
