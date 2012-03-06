ViperAccessibilityPlugin_WCAG2_Principle1_Guideline1_3 = {
    hasCss: false,
    id: 'ViperAccessibilityPlugin_WCAG2_Principle1_Guideline1_3',
    parent: null,

    res_1_3_1: function(element, issue, code, callback, viper)
    {
        var div = document.createElement('div');
        dfx.setHtml(div, this.parent.getContent());
        dfx.addClass(div, 'ViperAP-WCAG2_Principle1_Guideline1_3_1');

        var editPanel = null;
        var action    = null;
        var self      = this;
        var technique = code.techniques[0];

        switch(technique) {
            case 'H48.1':
            case 'H48.2':
                var content  = '';
                var btnTitle = '';
                if (technique === 'H48.1') {
                    content  = '<p>This section of content resembles a content list, if this is intentional it should be converted to the proper list format</p>';
                    btnTitle = 'Convert to Unordered List';
                } else {
                    content  = '<p>This section of content resembles a numbered list, if this is intentional it should be converted to the proper list format</p>';
                    btnTitle = 'Convert to Ordered List';
                }

                dfx.setHtml(dfx.getClass('resolutionInstructions', div)[0], content);

                var editPanel = dfx.getClass('editing', div)[0];

                action = function() {
                    if (technique === 'H48.1') {
                        self._convertToUnorderedList(element);
                    } else {
                        self._convertToOrderedList(element);
                    }
                };

                editPanel.appendChild(this.parent.createActionButton(action, null, btnTitle, true));
            break;

            default:
                // No interface.
            break;
        }//end switch

        callback.call(this, div);

    },

    _convertToOrderedList: function(element)
    {
        var list = document.createElement('ol');

        var li = document.createElement('li');
        while (element.firstChild) {
            var child = element.firstChild;
            if (child.nodeType === dfx.ELEMENT_NODE && dfx.isTag(child, 'br') === true) {
                list.appendChild(li);
                li = document.createElement('li');
                dfx.remove(child);
            } else {
                if (!li.firstChild) {
                    // First child of this list item, remove any numbers at the start
                    // of the its content.
                    child.data = child.data.replace(/^(\d+)[ .\/\-\:]+/, '');
                }

                li.appendChild(child);
            }
        }

        list.appendChild(li);

        dfx.insertBefore(element, list);
        dfx.remove(element);

    },

    _convertToUnorderedList: function(element)
    {
        var list = document.createElement('ul');

        var li = document.createElement('li');
        while (element.firstChild) {
            var child = element.firstChild;
            if (child.nodeType === dfx.ELEMENT_NODE && dfx.isTag(child, 'br') === true) {
                list.appendChild(li);
                li = document.createElement('li');
                dfx.remove(child);
            } else {
                if (!li.firstChild) {
                    // First child of this list item, remove any numbers at the start
                    // of the its content.
                    child.data = dfx.trim(child.data).replace(/^([\*\-+\#~>]+)/, '');
                }

                li.appendChild(child);
            }
        }

        list.appendChild(li);

        dfx.insertBefore(element, list);
        dfx.remove(element);

    }

};
