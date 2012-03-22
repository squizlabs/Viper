ViperAccessibilityPlugin_WCAG2_Principle1_Guideline1_3 = {
    hasCss: false,
    id: 'ViperAccessibilityPlugin_WCAG2_Principle1_Guideline1_3',
    parent: null,

    res_1_3_1: function(contentElement, element, issue, code, viper)
    {
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
                    content  = '<p>This section of content resembles a content list. If this is intentional, it should be converted to the proper list format.</p>';
                    btnTitle = 'Convert to Unordered List';
                } else {
                    content  = '<p>This section of content resembles a numbered list. If this is intentional it should be converted to the proper list format.</p>';
                    btnTitle = 'Convert to Ordered List';
                }

                this.parent.setResolutionInstruction(contentElement, content);

                var editPanel = this.parent.getResolutionActionsContainer(contentElement);

                action = function() {
                    if (technique === 'H48.1') {
                        self._convertToUnorderedList(element);
                    } else {
                        self._convertToOrderedList(element);
                    }
                };

                this.parent.addActionButton(action, contentElement, null, btnTitle, true);
            break;

            case 'H39':
                if (code.techniques[1] === 'H73.4') {
                    this.parent.setResolutionInstruction(contentElement, '<p>Update either the table\'s caption or summary so they are not identical.</p>');

                    var editPanel = this.parent.getResolutionActionsContainer(contentElement);

                    var captionid = dfx.getUniqueId();
                    var caption   = viper.ViperTools.createTextarea(captionid, 'Caption', this._getTableCaption(element));
                    editPanel.appendChild(caption);

                    var summaryid = dfx.getUniqueId();
                    var summary   = viper.ViperTools.createTextarea(summaryid, 'Summary', this._getTableSummary(element));
                    editPanel.appendChild(summary);

                    action = function() {
                        var captionVal = viper.ViperTools.getItem(captionid).getValue();
                        var summaryVal = viper.ViperTools.getItem(summaryid).getValue();

                        self._setTableCaption(element, captionVal);
                        self._setTableSummary(element, summaryVal);
                    };

                    this.parent.addActionButton(action, contentElement, [captionid, summaryid], null, null, function() {
                        var captionVal = viper.ViperTools.getItem(captionid).getValue();
                        var summaryVal = viper.ViperTools.getItem(summaryid).getValue();
                        if (dfx.trim(captionVal) === dfx.trim(summaryVal)) {
                            return false;
                        }
                    });
                }
            break;

            case 'H39.3.NoCaption':
                this.parent.setResolutionInstruction(contentElement, '<p>Enter a caption for the table.</p>');

                var editPanel = this.parent.getResolutionActionsContainer(contentElement);

                var captionid  =  null;
                var checkboxid = dfx.getUniqueId();
                var checkbox   = viper.ViperTools.createCheckbox(checkboxid, 'Use caption', false, function(checked) {
                    if (checked === true) {
                        viper.ViperTools.getItem(captionid).enable();
                    } else {
                        viper.ViperTools.getItem(captionid).disable();
                    }
                });
                editPanel.appendChild(checkbox);

                captionid   = dfx.getUniqueId();
                var caption = viper.ViperTools.createTextarea(captionid, 'Caption', this._getTableCaption(element));
                viper.ViperTools.getItem(captionid).disable();
                editPanel.appendChild(caption);

                action = function() {
                    var captionVal = '';
                    if (viper.ViperTools.getItem(checkboxid).getValue() === true) {
                        captionVal = viper.ViperTools.getItem(captionid).getValue();
                    }

                    self._setTableCaption(element, captionVal);
                };

                this.parent.addActionButton(action, contentElement, [captionid, checkboxid], null, null, function() {
                    var captionVal = viper.ViperTools.getItem(captionid).getValue();
                    if (!captionVal && viper.ViperTools.getItem(checkboxid).getValue() !== false) {
                        return false;
                    }
                });
            break;

            case 'H73.3.NoSummary':
                this.parent.setResolutionInstruction(contentElement, '<p>Enter a summary for the table.</p>');

                var editPanel = this.parent.getResolutionActionsContainer(contentElement);

                var summaryid  =  null;
                var checkboxid = dfx.getUniqueId();
                var checkbox   = viper.ViperTools.createCheckbox(checkboxid, 'Use summary', false, function(checked) {
                    if (checked === true) {
                        viper.ViperTools.getItem(summaryid).enable();
                    } else {
                        viper.ViperTools.getItem(summaryid).disable();
                    }
                });
                editPanel.appendChild(checkbox);

                summaryid   = dfx.getUniqueId();
                var summary = viper.ViperTools.createTextarea(summaryid, 'Summary', this._getTableSummary(element));
                viper.ViperTools.getItem(summaryid).disable();
                editPanel.appendChild(summary);

                action = function() {
                    var summaryVal = '';
                    if (viper.ViperTools.getItem(checkboxid).getValue() === true) {
                        summaryVal = viper.ViperTools.getItem(summaryid).getValue();
                    }

                    self._setTableSummary(element, summaryVal);
                };

                this.parent.addActionButton(action, contentElement, [summaryid, checkboxid], null, null, function() {
                    var summaryVal = dfx.trim(viper.ViperTools.getItem(summaryid).getValue());
                    if (!summaryVal && viper.ViperTools.getItem(checkboxid).getValue() !== false) {
                        return false;
                    }
                });
            break;

            default:
                // No interface.
            break;
        }//end switch

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

    _getTableSummary: function(table)
    {
        return dfx.trim(table.getAttribute('summary') || '');

    },

    _setTableSummary: function(table, summary)
    {
        if (!summary) {
            table.removeAttribute('summary');
        } else {
            table.setAttribute('summary', dfx.trim(summary));
        }

    }

};
