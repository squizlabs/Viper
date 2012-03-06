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

            case 'H39':
                if (code.techniques[1] === 'H73.4') {
                    dfx.setHtml(dfx.getClass('resolutionInstructions', div)[0], '<p>Update either the Table\'s Caption or Summary so they are not identical text</p>');

                    var editPanel = dfx.getClass('editing', div)[0];

                    var captionid = dfx.getUniqueId();
                    var caption   = viper.ViperTools.createTextarea(captionid, 'Caption', this._getTableCaption(element));
                    editPanel.appendChild(caption);

                    var summaryid = dfx.getUniqueId();
                    var summary   = viper.ViperTools.createTextarea(summaryid, 'Summary', element.getAttribute('summary'));
                    editPanel.appendChild(summary);

                    action = function() {
                        var captionVal = viper.ViperTools.getItem(captionid).getValue();
                        var summaryVal = viper.ViperTools.getItem(summaryid).getValue();

                        self._setTableCaption(element, captionVal);
                        self._setTableSummary(element, summaryVal);
                    };

                    editPanel.appendChild(this.parent.createActionButton(action, [captionid, summaryid], null, null, function() {
                        var captionVal = viper.ViperTools.getItem(captionid).getValue();
                        var summaryVal = viper.ViperTools.getItem(summaryid).getValue();
                        if (captionVal === summaryVal) {
                            return false;
                        }
                    }));
                }
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
                    child.data = dfx.ltrim(child.data).replace(/^(\d+)[ .\/\-\:]+/, '');
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
                    child.data = dfx.ltrim(child.data).replace(/^([\*\-+\#~>]+)/, '');
                }

                li.appendChild(child);
            }
        }

        list.appendChild(li);

        dfx.insertBefore(element, list);
        dfx.remove(element);

    },

    _getTableCaption: function(table)
    {
        var caption  = '';
        var captions = dfx.getTag('caption', table);
        if (captions.length > 0) {
            caption = dfx.getNodeTextContent(captions[0]);
        }

        return caption;

    },

    _setTableCaption: function(table, caption)
    {
        if (!caption) {
            var captionTags = dfx.getTag('caption', table);
            if (captionTags.length > 0) {
                dfx.remove(captionTags);
            }
        } else {
            var captionTags = dfx.getTag('caption', table);
            if (captionTags.length > 0) {
                dfx.remove(captionTags);
            }

            var captionTag = document.createElement('caption');
            dfx.setHtml(captionTag, caption);
            dfx.insertBefore(table.firstChild, captionTag);
        }

    },

    _setTableSummary: function(table, summary)
    {
        if (!summary) {
            table.removeAttribute('summary');
        } else {
            table.setAttribute('summary', summary);
        }

    }

};
