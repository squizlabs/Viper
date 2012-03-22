function ViperInlineToolbarPlugin(viper)
{
    this.viper                = viper;
    this._toolbar             = null;
    this._toolsContainer      = null;
    this._lineage             = null;
    this._lineageClicked      = false;
    this._currentLineageIndex = null;
    this._lineageItemSelected = false;
    this._margin              = 15;

    this._subSections             = {};
    this._subSectionButtons       = {};
    this._subSectionActionWidgets = {};
    this._activeSection           = null;

    this._topToolbar = null;
    this._buttons    = null;

    this._autoFocusTextbox = true;
    this._keepOpenTagList  = [];

    // Create the toolbar.
    this._createToolbar();

}

ViperInlineToolbarPlugin.prototype = {

    init: function()
    {
        var self = this;

        this._topToolbar = this.viper.getPluginManager().getPlugin('ViperToolbarPlugin');

        // Called when the selection is changed.
        var clickedInToolbar = false;
        this.viper.registerCallback('Viper:clickedOutside', 'ViperInlineToolbarPlugin', function(range) {
            self.hideToolbar();
        });

        this.viper.registerCallback('Viper:selectionChanged', 'ViperInlineToolbarPlugin', function(range) {
            if (clickedInToolbar === true || self.viper.rangeInViperBounds(range) === false) {
                clickedInToolbar = false;
                return;
            }

            if (self._lineageClicked !== true) {
                // Not selection change due to a lineage click so update the range object.
                // Note we can use cloneRange here but for whatever reason Firefox seems
                // to not do the cloning bit of cloneRange...
                self._originalRange = {
                    startContainer: range.startContainer,
                    endContainer: range.endContainer,
                    startOffset: range.startOffset,
                    endOffset: range.endOffset,
                    collapsed: range.collapsed
                }
            }

            // Update the toolbar position, contents and lineage for this new selection.
            self.updateToolbar(range);
        });

        this.viper.registerCallback('ViperTools:textbox:actionTiggered', 'ViperInlineToolbarPlugin', function() {
            self._autoFocusTextbox = false;
        });

        // Hide the toolbar when user clicks anywhere.
        this.viper.registerCallback(['Viper:mouseDown', 'ViperHistoryManager:undo'], 'ViperInlineToolbarPlugin', function(data) {
            clickedInToolbar = false;
            if (data && data.target) {
                var target = dfx.getMouseEventTarget(data);
                if (target === self._toolbar || dfx.isChildOf(target, self._toolbar) === true) {
                    clickedInToolbar = true;
                    if (dfx.isTag(target, 'input') === true
                        || dfx.isTag(target, 'textarea') === true
                    ) {
                        // Allow event to bubble so the input element can get focus etc.
                        return true;
                    }

                    return false;
                } else if (self._keepOpenTagList.inArray(dfx.getTagName(target)) === true) {
                    return;
                }
            }

            self.hideToolbar();
        });

        this.viper.registerCallback('Viper:elementScaled', 'ViperInlineToolbarPlugin', function(data) {
           if (data.element !== self._toolbar) {
               return false;
           }

           if (data.scale === 1) {
               self._margin = 15;
           } else {
               self._margin = (15 - (((1 - data.scale) / 0.1) * 5));
           }

           self.updateToolbar();
        });

        dfx.addEvent(window, 'resize', function() {
            if (dfx.hasClass(self._toolbar, 'visible') === true) {
                self._updatePosition();
            }
        });

    },

    setSettings: function(settings)
    {
        if (!settings) {
            return;
        }

        if (settings.buttons) {
            this._buttons = settings.buttons;
        }

    },

    applyButtonsSetting: function()
    {
        // Get all the buttons from the container.
        var buttons = dfx.getClass('Viper-button', this._toolsContainer);
        var c       = buttons.length;

        if (c === 0) {
            return;
        }

        // Clear the buttons container contents.
        if (this.viper.isBrowser('msie') === true) {
            while(this._toolsContainer.firstChild) {
                this._toolsContainer.removeChild(this._toolsContainer.firstChild);
            }
        } else {
            this._toolsContainer.innerHTML = '';
        }

        // Get the button ids and their elements.
        var addedButtons = {};
        for (var i = 0; i < c; i++) {
            var button = buttons[i];
            var id     = button.id.toLowerCase().replace(this.viper.getId() + '-vitp', '');
            addedButtons[id] = button;
        }

        var bc = this._buttons.length;
        for (var i = 0; i < bc; i++) {
            var button = this._buttons[i];
            if (typeof button === 'string') {
                button = button.toLowerCase();
                if (addedButtons[button]) {
                    // Button is included in the setting, add it to the toolbar.
                    this.addButton(addedButtons[button]);
                }
            } else {
                var gc           = button.length;
                var groupid      = null;
                for (var j = 0; j < gc; j++) {
                    if (addedButtons[button[j].toLowerCase()]) {
                        if (groupid === null) {
                            // Create the group.
                            groupid      = 'ViperInlineToolbarPlugin:buttons:' + i;
                            groupElement = this.viper.ViperTools.createButtonGroup(groupid);
                            this.addButton(groupElement);
                        }

                        // Button is included in the setting, add it to group.
                        this.viper.ViperTools.addButtonToGroup('vitp' + dfx.ucFirst(button[j]), groupid);
                    }
                }
            }
        }

    },

    /**
     * Adds the given element as a sub section of the toolbar.
     *
     * @param {string} id       The id of the new sub section.
     * @param {DOMNode} element The DOMNode to convert to sub section.
     *
     * @return {DOMNode} The element that was passed in.
     */
    makeSubSection: function(id, element, onOpenCallback, onCloseCallback)
    {
        if (!element) {
            return false;
        }

        var subSection = document.createElement('div');
        var form       = document.createElement('form');

        subSection.appendChild(form);
        form.appendChild(element);
        form.onsubmit = function() {
            return false;
        };

        var submitBtn = document.createElement('input');
        submitBtn.type = 'submit';
        dfx.setStyle(submitBtn, 'display', 'none');
        form.appendChild(submitBtn);

        dfx.addClass(subSection, 'Viper-subSection');

        this._subSections[id] = subSection;

        this._subSectionContainer.appendChild(subSection);

        this.viper.ViperTools.addItem(id, {
            type: 'VITPSubSection',
            element: subSection,
            form: form,
            _onOpenCallback: onOpenCallback,
            _onCloseCallback: onCloseCallback
        });

        return subSection;

    },

    /**
     * Sets the specified button to toggle the given sub section.
     *
     * @param {string} buttonid     Id of the button.
     * @param {string} subSectionid Id of the sub section.
     */
    setSubSectionButton: function(buttonid, subSectionid)
    {
        if (!this._subSections[subSectionid]) {
            // Throw exception not a valid sub section id.
            throw new Error('Invalid sub section id: ' + subSectionid);
            return false;
        }

        var button = this.viper.ViperTools.getItem(buttonid).element;
        var self   = this;

        this._subSectionButtons[subSectionid] = buttonid;

        dfx.removeEvent(button, 'mousedown');
        dfx.addEvent(button, 'mousedown', function(e) {
            // Set the subSection to visible and hide rest of the sub sections.
            self.toggleSubSection(subSectionid);

            dfx.preventDefault(e);
        });

    },

    /**
     * Toggles the visibility of the specified sub section.
     *
     * @param {string} subSectionid The if of the sub section.
     */
    toggleSubSection: function(subSectionid, ignoreCallbacks)
    {
        var subSection = this._subSections[subSectionid];
        if (!subSection) {
            return false;
        }

        if (this._activeSection) {
            var prevSubSection = this._subSections[this._activeSection];
            if (prevSubSection) {
                dfx.removeClass(prevSubSection, 'active');
                dfx.removeClass(this.viper.ViperTools.getItem(this._subSectionButtons[this._activeSection]).element, 'selected');

                if (ignoreCallbacks !== true) {
                    var closeCallback = this.viper.ViperTools.getItem(this._activeSection)._onCloseCallback;
                    if (closeCallback) {
                        closeCallback.call(this);
                    }
                }

                if (this._activeSection === subSectionid) {
                    dfx.removeClass(this._toolbar, 'subSectionVisible');
                    this._activeSection = null;

                    dfx.removeEvent(document, 'keydown.ViperInlineToolbarPlugin');
                    return;
                }
            }
        }

        if (ignoreCallbacks !== true) {
            var openCallback = this.viper.ViperTools.getItem(subSectionid)._onOpenCallback;
            if (openCallback) {
                openCallback.call(this);
            }
        }

        var subSectionButton = this.viper.ViperTools.getItem(this._subSectionButtons[subSectionid]).element;
        // Make the button selected.
        dfx.addClass(subSectionButton, 'selected');

        dfx.addClass(subSection, 'active');
        dfx.addClass(this._toolbar, 'subSectionVisible');
        this._activeSection = subSectionid;
        this._updateSubSectionArrowPos();

        var inputElements = dfx.getTag('input[type=text], textarea', subSection);
        if (inputElements.length > 0) {
            inputElements[0].focus();
            if (this._autoFocusTextbox === false) {
                this._autoFocusTextbox = true;
                dfx.removeClass(inputElements[0].parentNode.parentNode.parentNode, 'active');
            }
        }

        var subSectionForm = this.viper.ViperTools.getItem(subSectionid).form;
        dfx.removeEvent(document, 'keydown.ViperInlineToolbarPlugin');
        dfx.addEvent(document, 'keydown.ViperInlineToolbarPlugin', function(e) {
            if (subSectionForm && e.which === 13 && e.target === document.body) {
                return subSectionForm.onsubmit();
            }
        });

    },

    /**
     *
     *
     * @param {string}   subSectionid The id of the sub section.
     * @param {function} action       The function to call when the sub section action
     *                                is triggered.
     * @param {array}    widgetids    The id of widgets that will cause the action
     *                                button to be activated when they are changed.
     *
     * @return void
     */
    setSubSectionAction: function(subSectionid, action, widgetids)
    {
        widgetids      = widgetids || [];
        var tools      = this.viper.ViperTools;
        var subSection = tools.getItem(subSectionid);
        if (!subSection) {
            return;
        }

        var viper = this.viper;
        subSection.form.onsubmit = function(e) {
            if (e) {
                dfx.preventDefault(e);
            }

            viper.focus();

            try {
                action.call(this);
            } catch (e) {
                console.error(e.message);
            }

            viper.ViperTools.disableButton(subSectionid + '-applyButton');

            return false;
        };

        var button = tools.createButton(subSectionid + '-applyButton', 'Update Changes', 'Update Changes', '', subSection.form.onsubmit, true);
        subSection.element.appendChild(button);

        this.addSubSectionActionWidgets(subSectionid, widgetids);

    },

    addSubSectionActionWidgets: function(subSectionid, widgetids)
    {
        if (!this._subSectionActionWidgets[subSectionid]) {
            this._subSectionActionWidgets[subSectionid] = [];
        }

        var self  = this;
        var tools = this.viper.ViperTools;
        for (var i = 0; i < widgetids.length; i++) {
            this._subSectionActionWidgets[subSectionid].push(widgetids[i]);

            (function(widgetid) {
                self.viper.registerCallback('ViperTools:changed:' + widgetid, 'ViperToolbarPlugin', function() {
                    var subSectionWidgets = self._subSectionActionWidgets[subSectionid];
                    var c = subSectionWidgets.length;
                    var enable = true;
                    for (var j = 0; j < c; j++) {
                        var widget = tools.getItem(subSectionWidgets[j]);
                        if (widget.required === true && dfx.trim(widget.getValue()) === '') {
                            enable = false;
                            break;
                        }
                    }

                    if (enable === true) {
                        tools.enableButton(subSectionid + '-applyButton');
                    } else {
                        tools.disableButton(subSectionid + '-applyButton');
                    }
                });
            }) (widgetids[i]);
        }

    },

    /**
     * Adds the specified button or button group element to the tools panel.
     *
     * @param {DOMNode} button The button or the button group element.
     * @param {integer} index  The index to insert to. Should be used by other plugins
     *                         to insert buttons at specific positions.
     */
    addButton: function(button, index)
    {
        if (dfx.isset(index) === true && this._toolsContainer.childNodes.length > index) {
            if (index < 0) {
                index = this._toolsContainer.childNodes.length + index;
                if (index < 0) {
                    index = 0;
                }
            }

            dfx.insertBefore(this._toolsContainer.childNodes[index], button);
        } else {
            this._toolsContainer.appendChild(button);
        }

    },

    /**
     * Upudates the toolbar.
     *
     * This method is usually called by the Viper:selectionChanged event.
     *
     * @param {DOMRange} range The DOMRange object.
     */
    updateToolbar: function(range)
    {
        if (this._topToolbar) {
            var bubble = this._topToolbar.getActiveBubble();
            if (bubble && bubble.getSetting('keepOpen') !== true) {
                return;
            }
        }

        this._lineageItemSelected = false;

        var activeSection   = this._activeSection;
        this._activeSection = null;

        range = range || this.viper.getViperRange();

        dfx.removeClass(this._toolbar, 'subSectionVisible');

        if (this._lineageClicked !== true) {
            this._setCurrentLineageIndex(null);
        }

        var lineage = this._getSelectionLineage(range);
        if (!lineage || lineage.length === 0) {
            return;
        }

        dfx.addClass(this._toolbar, 'calcWidth');
        this._updateInnerContainer(range, lineage);
        dfx.removeClass(this._toolbar, 'calcWidth');

        if (!dfx.getHtml(this._toolsContainer)) {
            this.hideToolbar();
            this._lineageClicked = false;
            return;
        }

        if (this._lineageClicked === true) {
            this._lineageClicked = false;
            return;
        }

        this._updateLineage(lineage);
        this._updatePosition(range);
        this._updateSubSectionArrowPos();

        if (activeSection) {
            this.toggleSubSection(activeSection);
        }

    },

    /**
     * Hides the inline toolbar.
     */
    hideToolbar: function()
    {
        dfx.removeEvent(document, 'keydown.ViperInlineToolbarPlugin');

        this._activeSection = null;
        dfx.removeClass(this._toolbar, 'visible');

    },

    addKeepOpenTag: function(tagName)
    {
        this._keepOpenTagList.push(tagName);

    },

    /**
     * Returns a better tag name for the given DOMElement tag name.
     *
     * For example: strong -> Bold, u -> Underline.
     *
     * @param {string} tagName The tag name of a DOMElement.
     *
     * @return {string} The readable name.
     */
    getReadableTagName: function(tagName)
    {
        switch (tagName) {
            case 'strong':
                tagName = 'Bold';
            break;

            case 'u':
                tagName = 'Underline';
            break;

            case 'em':
            case 'i':
                tagName = 'Italic';
            break;

            case 'li':
                tagName = 'Item';
            break;

            case 'ul':
                tagName = 'List';
            break;

            case 'ol':
                tagName = 'List';
            break;

            case 'td':
                tagName = 'Cell';
            break;

            case 'tr':
                tagName = 'Row';
            break;

            case 'th':
                tagName = 'Header';
            break;

            case 'a':
                tagName = 'Link';
            break;

            case 'blockquote':
                tagName = 'Quote';
            break;

            default:
                tagName = tagName.toUpperCase();
            break;
        }//end switch

        return tagName;

    },

    /**
     * Selects the specified lineage index.
     *
     * @param {integer} index The lineage index to select.
     */
    selectLineageItem: function(index)
    {
        var tags = dfx.getTag('li', this._lineage);
        if (tags[index]) {
            dfx.trigger(tags[index], 'mousedown');
        }

    },

    /**
     * Creates the inline toolbar.
     *
     * The toolbar is added to the BODY element.
     */
    _createToolbar: function()
    {
        var main      = document.createElement('div');
        this._toolbar = main;

        this._lineage = document.createElement('ul');
        this._toolbar.appendChild(this._lineage);

        this._toolsContainer = document.createElement('div');
        this._toolbar.appendChild(this._toolsContainer);

        this._subSectionContainer = document.createElement('div');
        this._toolbar.appendChild(this._subSectionContainer);

        dfx.addClass(this._toolbar, 'ViperITP themeDark Viper-scalable');
        dfx.addClass(this._lineage, 'ViperITP-lineage');
        dfx.addClass(this._toolsContainer, 'ViperITP-tools');
        dfx.addClass(this._subSectionContainer, 'ViperITP-subSectionWrapper');

        if (navigator.userAgent.match(/iPad/i) !== null) {
            dfx.addClass(this._toolbar, 'device-ipad');
        }

        dfx.addEvent(main, 'mousedown', function(e) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isTag(target, 'input') !== true && dfx.isTag(target, 'textarea') !== true) {
                dfx.preventDefault(e);
                return false;
            }
        });

        dfx.addEvent(main, 'mouseup', function(e) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isTag(target, 'input') !== true  && dfx.isTag(target, 'textarea') !== true) {
                dfx.preventDefault(e);
                return false;
            }
        });

        document.body.appendChild(this._toolbar);

    },

    /**
     * Upudates the position of the inline toolbar.
     *
     * @param {DOMRange} range        The DOMRange object.
     * @param {boolean}  verticalOnly If true then only the vertical position will be
     *                                updated.
     */
    _updatePosition: function(range, verticalOnly)
    {
        range = range || this.viper.getViperRange();

        var rangeCoords  = null;
        var selectedNode = range.getNodeSelection(range);
        if (selectedNode !== null) {
            rangeCoords = this._getElementCoords(selectedNode);
        } else {
            rangeCoords = range.rangeObj.getBoundingClientRect();
        }

        if (!rangeCoords || (rangeCoords.left === 0 && rangeCoords.top === 0 && this.viper.isBrowser('firefox') === true)) {
            var startNode = range.getStartNode();
            var endNode   = range.getEndNode();
            if (!startNode || !endNode) {
                return;
            }

            if (startNode.nodeType === dfx.TEXT_NODE
                && startNode.data.indexOf("\n") === 0
                && endNode.nodeType === dfx.TEXT_NODE
                && range.endOffset === endNode.data.length
            ) {
                range.setStart(endNode, endNode.data.length);
                range.collapse(true);
                rangeCoords = range.rangeObj.getBoundingClientRect();
            }
        }

        if (!rangeCoords || (rangeCoords.bottom === 0 && rangeCoords.height === 0 && rangeCoords.left === 0)) {
            if (this.viper.isBrowser('chrome') === true || this.viper.isBrowser('safari') === true) {
                // Webkit bug workaround. https://bugs.webkit.org/show_bug.cgi?id=65324.
                // OK.. Yet another fix. With the latest Google Chrome (17.0.963.46)
                // the !rangeCoords check started to fail because its no longer
                // returning null for a collapsed range, instead all values are set to 0.

                var startNode = range.getStartNode();
                if (startNode.nodeType === dfx.TEXT_NODE) {
                    if (range.startOffset <= startNode.data.length) {
                        range.setEnd(startNode, (range.startOffset + 1));
                        rangeCoords = range.rangeObj.getBoundingClientRect();
                        range.collapse(true);
                        if (rangeCoords) {
                            rangeCoords.right = rangeCoords.left;
                        }
                    } else if (range.startOffset > 0) {
                        range.setStart(startNode, (range.startOffset - 1));
                        rangeCoords = range.rangeObj.getBoundingClientRect();
                        range.collapse(false);
                        if (rangeCoords) {
                            rangeCoords.right = rangeCoords.left;
                        }
                    }
                }
            } else {
                return;
            }//end if
        }//end if

        var scrollCoords = dfx.getScrollCoords();

        dfx.addClass(this._toolbar, 'calcWidth');
        dfx.setStyle(this._toolbar, 'width', 'auto');
        var toolbarWidth = dfx.getElementWidth(this._toolbar);
        dfx.removeClass(this._toolbar, 'calcWidth');
        dfx.setStyle(this._toolbar, 'width', toolbarWidth + 'px');

        var windowDim = dfx.getWindowDimensions();

        if (verticalOnly !== true) {
            var left = ((rangeCoords.left + ((rangeCoords.right - rangeCoords.left) / 2) + scrollCoords.x) - (toolbarWidth / 2));
            dfx.removeClass(this._toolbar, 'orientationLeft orientationRight');
            if (left < 0) {
                left += (toolbarWidth / 2);
                dfx.addClass(this._toolbar, 'orientationLeft');
            } else if (left + toolbarWidth > windowDim.width) {
                left -= (toolbarWidth / 2);
                dfx.addClass(this._toolbar, 'orientationRight');
            }

            dfx.setStyle(this._toolbar, 'left', left + 'px');
        }

        var top = (rangeCoords.bottom + this._margin + scrollCoords.y);

        dfx.setStyle(this._toolbar, 'top', top + 'px');
        dfx.addClass(this._toolbar, 'visible');

    },

    _updateSubSectionArrowPos: function()
    {
        if (!this._activeSection) {
            return;
        }

        var button = this._subSectionButtons[this._activeSection];
        if (!button) {
            return;
        }

        button = this.viper.ViperTools.getItem(button).element;
        if (!button) {
            return;
        }

        var buttonRect = dfx.getBoundingRectangle(button);
        var toolbarPos = dfx.getBoundingRectangle(this._toolbar);
        var xPos       = (buttonRect.x1 - toolbarPos.x1 + ((buttonRect.x2 - buttonRect.x1) / 2));
        dfx.setStyle(this._subSectionContainer.firstChild, 'left', xPos + 'px');

    },

    _getElementCoords: function(element)
    {
        var elemRect     = dfx.getBoundingRectangle(element);
        var scrollCoords = dfx.getScrollCoords();
        return {
            left: (elemRect.x1 - scrollCoords.x),
            right: (elemRect.x2 - scrollCoords.x),
            top: (elemRect.y1 - scrollCoords.y),
            bottom: (elemRect.y2 - scrollCoords.y)
        };

    },

    /**
     * Updates the contents of the lineage container.
     *
     * @param {array} lineage The lineage array.
     */
    _updateLineage: function(lineage)
    {
        // Remove the contents of the lineage container.
        dfx.empty(this._lineage);

        var viper    = this.viper;
        var c        = lineage.length;
        var self     = this;
        var linElems = [];

        // Create lineage items.
        for (var i = 0; i < c; i++) {
            if (!lineage[i].tagName) {
                continue;
            }

            var tagName = lineage[i].tagName.toLowerCase();
            var parent  = document.createElement('li');
            dfx.addClass(parent, 'ViperITP-lineageItem');

            if (i === (c - 1)) {
                dfx.addClass(parent, 'selected');
            }

            dfx.setHtml(parent, this.getReadableTagName(tagName));
            this._lineage.appendChild(parent);
            linElems.push(parent);

            (function(clickElem, selectionElem, index) {
                // When clicked set the user selection to the selected element.
                dfx.addEvent(clickElem, 'mousedown.ViperInlineToolbarPlugin', function(e) {
                    self.viper.fireCallbacks('ViperInlineToolbarPlugin:lineageClicked');

                    // We set the _lineageClicked to true here so that when the
                    // fireSelectionChanged is called we do not update the lineage again.
                    self._lineageClicked = true;
                    self._setCurrentLineageIndex(index);

                    dfx.removeClass(linElems, 'selected');
                    dfx.addClass(clickElem, 'selected');

                    if (self.viper.isBrowser('msie') === true) {
                        // IE changes the range when the mouse is released on an element
                        // that is not part of viper causing Viper to lose focus..
                        // Use time out to set the range back in to Viper..
                        setTimeout(function() {
                            self._selectNode(selectionElem);
                        }, 50);
                    } else {
                        self._selectNode(selectionElem);
                    }

                    dfx.preventDefault(e);

                    return false;
                });
            }) (parent, lineage[i], i);
        }//end for

        if (this._originalRange.collapsed === true
            || (lineage[(lineage.length - 1)].nodeType !== dfx.TEXT_NODE)
        ) {
            // No need to add the 'Selection' item as its collapsed or a node is selected.
            return;
        }

        // Add the original user selection to the lineage.
        var parent = document.createElement('li');
        dfx.addClass(parent, 'ViperITP-lineageItem selected');
        dfx.setHtml(parent, 'Selection');
        linElems.push(parent);
        this._lineage.appendChild(parent);

        dfx.addEvent(parent, 'mousedown.ViperInlineToolbarPlugin', function(e) {
            self.viper.fireCallbacks('ViperInlineToolbarPlugin:lineageClicked');

            // When clicked set the selection to the original selection.
            self._lineageClicked = true;
            self._setCurrentLineageIndex(lineage.length - 1);

            dfx.removeClass(linElems, 'selected');
            dfx.addClass(parent, 'selected');

            if (self.viper.isBrowser('msie') === true) {
                // IE changes the range when the mouse is released on an element
                // that is not part of viper causing Viper to lose focus..
                // Use time out to set the range back in to Viper..
                setTimeout(function() {
                    self._selectPreviousRange();
                }, 50);
            } else {
                self._selectPreviousRange();
            }

            dfx.preventDefault(e);
            return false;
        });

    },

    _selectNode: function(node)
    {
        this.viper.focus();

        var range = this.viper.getCurrentRange();

        if (this._lineageItemSelected === false) {
            // Update original selection. We update it here incase the selectionHighlight
            // method changed the DOM structure (e.g. normalised textnodes), when
            // Viper is focused update the 'selection' range.
            this._originalRange = {
                startContainer: range.startContainer,
                endContainer: range.endContainer,
                startOffset: range.startOffset,
                endOffset: range.endOffset,
                collapsed: range.collapsed
            };
        }

        // Set the range.
        ViperSelection.removeAllRanges();
        range = this.viper.getViperRange();

        var first = range._getFirstSelectableChild(node);
        var last  = range._getLastSelectableChild(node);
        range.setStart(first, 0);
        range.setEnd(last, last.data.length);

        ViperSelection.addRange(range);
        this.viper.fireSelectionChanged(range, true);

        // Update the position of the toolbar vertically only.
        this._updatePosition(range, true);
        this._updateSubSectionArrowPos();

        this._lineageItemSelected = true;

    },

    _selectPreviousRange: function()
    {
        this.viper.focus();

        ViperSelection.removeAllRanges();
        var range = this.viper.getCurrentRange();

        range.setStart(this._originalRange.startContainer, this._originalRange.startOffset);
        range.setEnd(this._originalRange.endContainer, this._originalRange.endOffset);
        ViperSelection.addRange(range);
        this.viper.fireSelectionChanged(range);
        this._updatePosition(range, true);
        this._updateSubSectionArrowPos();

    },

    /**
     * Fires the updateToolbar event so that other plugins can modify the contents of the toolbar.
     *
     * @param {DOMRange} range   The DOMRange object.
     * @param {array}    lineage The lineage array.
     */
    _updateInnerContainer: function(range, lineage)
    {
        if (!lineage || lineage.length === 0) {
            return;
        }

        dfx.empty(this._toolsContainer);
        dfx.setHtml(this._subSectionContainer, '<span class="subSectionArrow"></span>');

        if (this._currentLineageIndex === null || this._currentLineageIndex > lineage.length) {
            this._setCurrentLineageIndex(lineage.length - 1);
        }

        var data = {
            range: range,
            lineage: lineage,
            current: this._currentLineageIndex
        };

        this.viper.fireCallbacks('ViperInlineToolbarPlugin:updateToolbar', data);

        if (this._buttons) {
            this.applyButtonsSetting();
        }

    },

    _setCurrentLineageIndex: function(index)
    {
        this._currentLineageIndex = index;

    },

    /**
     * Returns the selection's parent elements.
     *
     * @param {DOMRange} range The DOMRange object.
     *
     * @return {array} Array of DOMElements.
     */
    _getSelectionLineage: function(range)
    {
        var lineage       = [];
        var parent        = null;
        var nodeSelection = range.getNodeSelection(range);

        if (nodeSelection) {
            parent = nodeSelection;
        } else {
            parent        = range.getCommonElement();
            var startNode = range.getStartNode();
            if (!startNode) {
                return lineage;
            } else if (startNode.nodeType == dfx.TEXT_NODE
                && (startNode.data.length === 0 || dfx.isBlank(dfx.trim(startNode.data)) === true)
                && startNode.nextSibling
                && startNode.nextSibling.nodeType === dfx.TEXT_NODE
            ) {
                // The startNode is an empty textnode, most likely due to node splitting
                // if the next node is a text node use that instead.
                startNode = startNode.nextSibling;
            }

            if (startNode.nodeType !== dfx.TEXT_NODE || dfx.isBlank(startNode.data) !== true) {
                lineage.push(startNode);
            }
        }

        var viperElement = this.viper.getViperElement();

        if (parent === viperElement) {
            return lineage;
        }

        if (parent) {
            lineage.push(parent);

            parent = parent.parentNode;

            while (parent && parent !== viperElement) {
                lineage.push(parent);
                parent = parent.parentNode;
            }
        }

        lineage = lineage.reverse();

        return lineage;

    },

    isPluginElement: function(element)
    {
        if (element !== this._toolbar && dfx.isChildOf(element, this._toolbar) === false) {
            return false;
        }

        return true;

    }

};
