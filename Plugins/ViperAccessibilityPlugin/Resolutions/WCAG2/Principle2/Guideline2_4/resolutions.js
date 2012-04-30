ViperAccessibilityPlugin_WCAG2_Principle2_Guideline2_4 = {
    hasCss: false,
    id: 'ViperAccessibilityPlugin_WCAG2_Principle2_Guideline2_4',
    parent: null,

    res_2_4_1: function(contentElement, element, issue, code, viper, issueid)
    {
        var editPanel = null;
        var action    = null;
        var self      = this;
        var technique = code.techniques[0];

        switch(technique) {
            case 'H64.1':
            case 'H64.2':
                this.parent.setResolutionInstruction(contentElement, '<p>Enter an appropriate title for the iframe to describe it\'s purpose.</p>');

                var editPanel = this.parent.getResolutionActionsContainer(contentElement);

                var titleid =  null;
                titleid     = dfx.getUniqueId();
                var title   = viper.ViperTools.createTextbox(titleid, 'Title', element.getAttribute('title') || '');
                editPanel.appendChild(title);

                action = function() {
                    var titleVal = viper.ViperTools.getItem(titleid).getValue();
                    element.setAttribute('title', titleVal);
                };

                this.parent.addActionButton(action, contentElement, [titleid], null, null, function() {
                    var titleVal = dfx.trim(viper.ViperTools.getItem(titleid).getValue());
                    if (!titleVal) {
                        return false;
                    }
                });
            break;

            default:
                // No interface.
            break;

        }//end switch

    }

};
