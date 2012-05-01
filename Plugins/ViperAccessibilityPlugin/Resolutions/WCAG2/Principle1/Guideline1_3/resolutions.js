ViperAccessibilityPlugin_WCAG2_Principle1_Guideline1_3 = {
    hasCss: false,
    id: 'ViperAccessibilityPlugin_WCAG2_Principle1_Guideline1_3',
    parent: null,

    res_1_3_1: function(contentElement, element, issue, code, viper, issueid)
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
            case 'H39.3.Check':
                this.parent.setResolutionInstruction(contentElement, '<p>Enter a caption for the table.</p>');

                var editPanel = this.parent.getResolutionActionsContainer(contentElement);

                var captionid  =  null;
                var checkboxid = dfx.getUniqueId();
                var useCaption = false;

                if (technique === 'H39.3.Check') {
                    useCaption = true;
                }

                var checkbox   = viper.ViperTools.createCheckbox(checkboxid, 'Use caption', useCaption, function(checked) {
                    if (checked === true) {
                        viper.ViperTools.getItem(captionid).enable();
                    } else {
                        viper.ViperTools.getItem(captionid).disable();
                    }
                });
                editPanel.appendChild(checkbox);

                captionid = dfx.getUniqueId();
                var tableCaption = this._getTableCaption(element);

                var caption = viper.ViperTools.createTextarea(captionid, 'Caption', tableCaption);

                if (!tableCaption && useCaption === false) {
                    viper.ViperTools.getItem(captionid).disable();
                }

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
            case 'H73.3.Check':
                this.parent.setResolutionInstruction(contentElement, '<p>Enter a summary for the table.</p>');

                var editPanel = this.parent.getResolutionActionsContainer(contentElement);

                var summaryid  =  null;
                var checkboxid = dfx.getUniqueId();
                var useSummary = false;

                if (technique === 'H73.3.Check') {
                    useSummary = true;
                }

                var checkbox   = viper.ViperTools.createCheckbox(checkboxid, 'Use summary', useSummary, function(checked) {
                    if (checked === true) {
                        viper.ViperTools.getItem(summaryid).enable();
                    } else {
                        viper.ViperTools.getItem(summaryid).disable();
                    }
                });
                editPanel.appendChild(checkbox);

                summaryid   = dfx.getUniqueId();
                var tableSummary = this._getTableSummary(element);
                var summary = viper.ViperTools.createTextarea(summaryid, 'Summary', tableSummary);

                if (!tableSummary && useSummary === false) {
                    viper.ViperTools.getItem(summaryid).disable();
                }

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

            case 'H49.B':
                this.parent.setResolutionInstruction(contentElement, '<p>Convert the B tag to the more appropriate STRONG tag.</p>');
                var action = function() {
                    var newTag = document.createElement('strong');
                    element.parentNode.replaceChild(newTag, element);
                    while (element.firstChild) {
                        newTag.appendChild(element.firstChild);
                    }
                };
                this.parent.addActionButton(action, contentElement, null, 'Convert to STRONG tag', true);
            break;

            case 'H49.I':
                this.parent.setResolutionInstruction(contentElement, '<p>Convert the I tag to the more appropriate EM tag.</p>');
                var action = function() {
                    var newTag = document.createElement('em');
                    element.parentNode.replaceChild(newTag, element);
                    while (element.firstChild) {
                        newTag.appendChild(element.firstChild);
                    }
                };
                this.parent.addActionButton(action, contentElement, null, 'Convert to EM tag', true);
            break;

            case 'H49.U':
                this.parent.setResolutionInstruction(contentElement, '<p>The U tag should be removed to reduce confusion with links.</p>');
                var action = function() {
                    while (element.firstChild) {
                        dfx.insertBefore(element, element.firstChild);
                    }

                    dfx.remove(element);
                };
                this.parent.addActionButton(action, contentElement, null, 'Remove U tag', true);
            break;

            case 'H49.S':
                this.parent.setResolutionInstruction(contentElement, '<p>The S tag needs to be replaced with a DEL tag.</p>');
                var action = function() {
                    var newTag = document.createElement('del');
                    element.parentNode.replaceChild(newTag, element);
                    while (element.firstChild) {
                        newTag.appendChild(element.firstChild);
                    }
                };
                this.parent.addActionButton(action, contentElement, null, 'Convert to DEL tag', true);
            break;

            case 'H49.Strike':
                this.parent.setResolutionInstruction(contentElement, '<p>The Strike tag needs to be replaced with a DEL tag.</p>');
                var action = function() {
                    var newTag = document.createElement('del');
                    element.parentNode.replaceChild(newTag, element);
                    while (element.firstChild) {
                        newTag.appendChild(element.firstChild);
                    }
                };
                this.parent.addActionButton(action, contentElement, null, 'Convert to DEL tag', true);
            break;

            case 'H49.Tt':
                this.parent.setResolutionInstruction(contentElement, '<p>The TT tag needs to be replaced with a CODE tag.</p>');
                var action = function() {
                    var newTag = document.createElement('code');
                    element.parentNode.replaceChild(newTag, element);
                    while (element.firstChild) {
                        newTag.appendChild(element.firstChild);
                    }
                };
                this.parent.addActionButton(action, contentElement, null, 'Convert to CODE tag', true);
            break;

            case 'H49.Big':
                this.parent.setResolutionInstruction(contentElement, '<p>The BIG tag needs to be removed.</p>');
                var action = function() {
                    while (element.firstChild) {
                        dfx.insertBefore(element, element.firstChild);
                    }

                    dfx.remove(element);
                };
                this.parent.addActionButton(action, contentElement, null, 'Remove BIG tag', true);
            break;

            case 'H49.Small':
                this.parent.setResolutionInstruction(contentElement, '<p>The SMALL tag needs to be removed.</p>');
                var action = function() {
                    while (element.firstChild) {
                        dfx.insertBefore(element, element.firstChild);
                    }

                    dfx.remove(element);
                };
                this.parent.addActionButton(action, contentElement, null, 'Remove SMALL tag', true);
            break;

            case 'H49.Center':
                this.parent.setResolutionInstruction(contentElement, '<p>The CENTER tag needs to be converted to a CSS based alignment method.</p>');
                var action = function() {
                    var parent = null;
                    while (element.firstChild) {
                        if (dfx.isBlockElement(element.firstChild) === true) {
                            parent = element.firstChild;
                            dfx.insertBefore(element, parent);
                            dfx.setStyle(parent, 'text-align', 'center');
                        } else if (!parent) {
                            parent = document.createElement('p');
                            dfx.insertBefore(element, parent);
                            dfx.setStyle(parent, 'text-align', 'center');
                            parent.appendChild(element.firstChild);
                        } else {
                            parent.appendChild(element.firstChild);
                        }
                    }

                    dfx.remove(element);
                };
                this.parent.addActionButton(action, contentElement, null, 'Convert to CSS alignment', true);
            break;

            case 'H49.Font':
                this.parent.setResolutionInstruction(contentElement, '<p>The FONT tag needs to be removed. Consider using a CSS class on the containing element to achieve variations in fonts/colours/sizes etc.</p>');
                var action = function() {
                    while (element.firstChild) {
                        dfx.insertBefore(element, element.firstChild);
                    }

                    dfx.remove(element);
                };
                this.parent.addActionButton(action, contentElement, null, 'Remove FONT tag', true);
            break;

            case 'H49.AlignAttr':
                this.parent.setResolutionInstruction(contentElement, '<p>The ALIGN attribute needs to be converted to a CSS based alignment method.</p>');
                var action = function() {
                    var align = element.getAttribute('align');
                    switch (align) {
                        case 'left':
                            dfx.setStyle(element, 'float', 'left');
                            dfx.setStyle(element, 'margin', '1em 1em 1em 0');
                            dfx.setStyle(element, 'display', '');
                        break;

                        case 'right':
                            dfx.setStyle(element, 'float', 'right');
                            dfx.setStyle(element, 'margin', '1em 0 1em 1em');
                            dfx.setStyle(element, 'display', '');
                        break;

                        case 'middle':
                            dfx.setStyle(element, 'margin', '1em auto');
                            dfx.setStyle(element, 'float', '');
                            dfx.setStyle(element, 'display', 'block');
                        break;

                        default:
                            dfx.setStyle(element, 'margin', '');
                            dfx.setStyle(element, 'float', '');
                            dfx.setStyle(element, 'display', '');
                        break;
                    }//end switch

                    element.removeAttribute('align');
                };
                this.parent.addActionButton(action, contentElement, null, 'Convert to CSS alignment', true);
            break;

            case 'H42':
                this.parent.setResolutionInstruction(contentElement, '<p>If a paragraph\'s content consists solely of bold or italic text to simulate a heading it should be converted to the appropriate heading level.</p>');
                var updateResolution = function() {
                    // Insert a specific text before the element so that we can find
                    // it in HTML string.
                    var textNode = document.createTextNode('__VAP_ELEM_POS__');
                    dfx.insertBefore(element, textNode);

                    // Get Viper's current content from start to the __VAP_ELEM_POS__.
                    var viperElemContent = viper.getHtml();
                    viperElemContent = viperElemContent.substring(0, viperElemContent.indexOf('__VAP_ELEM_POS__'));

                    // Remove the text node we just created.
                    dfx.remove(textNode);

                    // Find the last heading level.
                    var headings = viperElemContent.match(/.*<h(\d)/i);
                    if (headings) {
                        var lastHeading = parseInt(headings[1]);

                        self.parent.removeActionButtons(contentElement);
                        var actionButtonids = [];

                        for (var i = lastHeading; i <= (lastHeading + 1); i++) {
                            (function(headingLevel) {
                                var action = function() {
                                    for (var j = 0; j < actionButtonids.length; j++) {
                                        viper.ViperTools.disableButton(actionButtonids[j]);
                                    }

                                    var newTag = document.createElement('h' + headingLevel);
                                    element.parentNode.replaceChild(newTag, element);
                                    while (element.firstChild) {
                                        newTag.appendChild(element.firstChild);
                                    }

                                    var tags = dfx.getTag('strong,em', newTag);
                                    for (var j = 0; j < tags.length; j++) {
                                        while (tags[j].firstChild) {
                                            dfx.insertBefore(tags[j], tags[j].firstChild);
                                        }

                                        dfx.remove(tags[j]);
                                    }
                                };

                                actionButtonids.push(self.parent.addActionButton(action, contentElement, null, 'Convert to H' + headingLevel, true));
                            }) (i);
                        }
                    }
                };

                viper.registerCallback('ViperAccessibilityPlugin:showResolution:' + issueid, 'ViperAccessibilityPlugin:resolution', function() {
                    updateResolution();
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

        if (li.firstChild) {
            list.appendChild(li);
        }

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

        if (li.firstChild) {
            list.appendChild(li);
        }

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
