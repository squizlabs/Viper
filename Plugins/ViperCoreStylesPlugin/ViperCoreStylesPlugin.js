/**
 * +--------------------------------------------------------------------+
 * | This Squiz Viper file is Copyright (c) Squiz Australia Pty Ltd     |
 * | ABN 53 131 581 247                                                 |
 * +--------------------------------------------------------------------+
 * | IMPORTANT: Your use of this Software is subject to the terms of    |
 * | the Licence provided in the file licence.txt. If you cannot find   |
 * | this file please contact Squiz (www.squiz.com.au) so we may        |
 * | provide you a copy.                                                |
 * +--------------------------------------------------------------------+
 *
 */

function ViperCoreStylesPlugin(viper)
{
    this.viper = viper;

    this.styleTags         = ['strong', 'em', 'sub', 'sup', 'del'];
    this.toolbarPlugin     = null;
    this._onChangeAddStyle = [];

    this._buttons = {
        strong: 'bold',
        em: 'italic',
        sub: 'subscript',
        sup: 'superscript',
        del: 'strikethrough',
        removeFormat: 'removeFormat',
        hr: 'hr'
    };

}

ViperCoreStylesPlugin.prototype = {

    handleKeyPress: function(e, type)
    {
        if (type) {
            return this.handleStyle(type);
        }

    },

    init: function()
    {
        var self = this;

        var ctrlName = 'CTRL';
        if (navigator.platform.toLowerCase().indexOf('mac') >= 0) {
            ctrlName = 'CMD';
        }

        var tools = this.viper.ViperTools;
        var toolbarPlugin  = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        this.toolbarPlugin = toolbarPlugin;

        var toolbarButtons = {};
        var btnGroup = tools.createButtonGroup('ViperCoreStylesPlugin:vtp:stylesBtns');

        // Main styles and remove format button groups.
        toolbarButtons.styles   = ['strong', 'em', 'sub', 'sup', 'del'];
        toolbarButtons.removeFormat = ['removeFormat'];
        toolbarButtons.justify = ['left', 'center', 'right', 'block'];
        toolbarButtons.other = ['hr'];

        tools.createButton('bold', '', _('Bold'), 'Viper-bold', function() {
            return self.handleStyle('strong');
        }, true);
        tools.createButton('italic', '', _('Italic'), 'Viper-italic', function() {
            return self.handleStyle('em');
        }, true);
        tools.createButton('removeFormat', '', _('Remove Format'), 'Viper-removeFormat', function() {
            self.removeFormat();
        }, true);

        tools.addButtonToGroup('bold', 'ViperCoreStylesPlugin:vtp:stylesBtns');
        tools.addButtonToGroup('italic', 'ViperCoreStylesPlugin:vtp:stylesBtns');
        tools.addButtonToGroup('removeFormat', 'ViperCoreStylesPlugin:vtp:stylesBtns');

        // Extra style buttons, sub, sup and strike.
        var btnGroup2 = tools.createButtonGroup('ViperCoreStylesPlugin:vtp:btnGroup2');
        tools.createButton('subscript', '', _('Subscript'), 'Viper-subscript', function() {
            self.handleStyle('sub');
        }, true);
        tools.createButton('superscript', '', _('Superscript'), 'Viper-superscript', function() {
            self.handleStyle('sup');
        }, true);
        tools.createButton('strikethrough', '', _('Strikethrough'), 'Viper-strikethrough', function() {
            self.handleStyle('del');
        }, true);

        tools.addButtonToGroup('subscript', 'ViperCoreStylesPlugin:vtp:btnGroup2');
        tools.addButtonToGroup('superscript', 'ViperCoreStylesPlugin:vtp:btnGroup2');
        tools.addButtonToGroup('strikethrough', 'ViperCoreStylesPlugin:vtp:btnGroup2');

        // Justify buttons bubble.
        var justifyBubbleContent = document.createElement('div');
        var btnGroup3 = tools.createButtonGroup('ViperCoreStylesPlugin:vtp:btnGroup3');
        tools.createButton('ViperCoreStylesPlugin:vtp:left', '', _('Left Justify'), 'Viper-justifyLeft', function() {
            self.handleJustify('left');
        });
        tools.createButton('ViperCoreStylesPlugin:vtp:center', '', _('Center Justify'), 'Viper-justifyCenter', function() {
            self.handleJustify('center');
        });
        tools.createButton('ViperCoreStylesPlugin:vtp:right', '', _('Right Justify'), 'Viper-justifyRight', function() {
            self.handleJustify('right');
        });
        tools.createButton('ViperCoreStylesPlugin:vtp:block', '', _('Block Justify'), 'Viper-justifyBlock', function() {
            self.handleJustify('justify');
        });

        tools.addButtonToGroup('ViperCoreStylesPlugin:vtp:left', 'ViperCoreStylesPlugin:vtp:btnGroup3');
        tools.addButtonToGroup('ViperCoreStylesPlugin:vtp:center', 'ViperCoreStylesPlugin:vtp:btnGroup3');
        tools.addButtonToGroup('ViperCoreStylesPlugin:vtp:right', 'ViperCoreStylesPlugin:vtp:btnGroup3');
        tools.addButtonToGroup('ViperCoreStylesPlugin:vtp:block', 'ViperCoreStylesPlugin:vtp:btnGroup3');
        justifyBubbleContent.appendChild(btnGroup3);

        var hr = tools.createButton('hr', '', _('Horizontal Rule'), 'Viper-insertHr', function() {
            self.handleHR();
        }, true);

        tools.getItem('bold').setButtonShortcut('CTRL+B');
        tools.getItem('italic').setButtonShortcut('CTRL+I');

        var callbackType = 'Viper:selectionChanged';
        if (toolbarPlugin) {
            toolbarPlugin.addButton(btnGroup);
            toolbarPlugin.addButton(btnGroup2);

            toolbarPlugin.createBubble('ViperCoreStylesPlugin:justifyBubble', _('Justification'), null, justifyBubbleContent);
            var justifyBubbleToggle = tools.createButton('justify', '', _('Toggle Justification'), 'Viper-justifyLeft', null, true);
            toolbarPlugin.addButton(justifyBubbleToggle);
            toolbarPlugin.setBubbleButton('ViperCoreStylesPlugin:justifyBubble', 'justify');

            toolbarPlugin.addButton(hr);

            callbackType = 'ViperToolbarPlugin:updateToolbar';

            this.viper.registerCallback(callbackType, 'ViperCoreStylesPlugin', function(data) {
                var range = data;
                if (data.range) {
                    range = data.range;
                }

                self._updateToolbarButtonStates(toolbarButtons, range);

                if (self._onChangeAddStyle.length > 0) {
                    var style = null;
                    while (style = self._onChangeAddStyle.shift()) {
                        self.viper.ViperTools.setButtonInactive(self._buttons[style]);
                    }
                }
            });
        }//end if

        this.viper.registerCallback('Viper:keyPress', 'ViperCoreStylesPlugin', function(e) {
            if (self._onChangeAddStyle.length > 0 && self.viper.isInputKey(e) === true) {
                var character = String.fromCharCode(e.which);
                return self.viper.insertTextAtCaret(character);
            }
        });

        this.viper.registerCallback('Viper:nodesInserted', 'ViperCoreStylesPlugin', function(data) {
            return self._wrapNodeWithActiveStyle(data.node, data.range);
        });

        this.viper.registerCallback('Viper:charInsert', 'ViperCoreStylesPlugin', function(data) {
            self._onChangeAddStyle = [];
        });

        // Inline toolbar.
        var inlineToolbar = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');
        if (inlineToolbar) {
            if (inlineToolbar.isInitialised() === true) {
                self._createInlineToolbarContent(inlineToolbar.getToolbar());
            } else {
                this.viper.registerCallback('ViperInlineToolbarPlugin:initToolbar', 'ViperCoreStylesPlugin', function(toolbar) {
                    self._createInlineToolbarContent(toolbar);
                });
            }

            this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperCoreStylesPlugin', function(data) {
                self._updateInlineToolbar(data);
            });
        }

        var tagNames = {
            em: _('Italic'),
            strong: _('Bold'),
            sub: _('Subscript'),
            sup: _('Superscript'),
            del: _('Strikethrough')
        };

        this.viper.registerCallback('Viper:mouseDown', 'ViperCoreStylesPlugin', function(e) {
            self._selectedImage = null;
            var target = ViperUtil.getMouseEventTarget(e);
            if (target && ViperUtil.isTag(target, 'hr') !== true) {
                if (ViperUtil.isTag(target, 'img') === true) {
                    self.viper.ViperTools.disableButton('ViperCoreStylesPlugin:vtp:block');
                    self._selectedImage = target;
                    self._updateToolbarButtonStates();
                }

                return;
            }

            if (ViperUtil.isBrowser('msie') === true) {
                // This block of code prevents IE moving user selection to the.
                // button element when clicked. When the button element is removed
                // and added back to DOM selection is not moved. Seriously, IE?
                if (target.previousSibling) {
                    var sibling = target.previousSibling;
                    target.parentNode.removeChild(target);
                    ViperUtil.insertAfter(sibling, target);
                } else if (target.nextSibling) {
                    var sibling = target.nextSibling;
                    target.parentNode.removeChild(target);
                    ViperUtil.insertBefore(sibling, target);
                } else {
                    var parent = target.parentNode;
                    target.parentNode.removeChild(target);
                    parent.appendChild(target);
                }
            }//end if

            // Set the range after the HR element, if there is no element after
            // HR create a new P tag.
            var blockSibling = target.nextSibling;
            while (blockSibling) {
                if (ViperUtil.isBlockElement(blockSibling) === true) {
                    break;
                } else if (blockSibling.nodeType === ViperUtil.TEXT_NODE && ViperUtil.trim(blockSibling.data) !== '') {
                    blockSibling = null;
                    break;
                }

                blockSibling = blockSibling.nextSibling;
            }

            if (!blockSibling) {
                blockSibling = document.createElement('p');
                ViperUtil.setHtml(blockSibling, '&nbsp;');
                ViperUtil.insertAfter(target, blockSibling);
            } else if (ViperUtil.getHtml(blockSibling) === '') {
                ViperUtil.setHtml(blockSibling, '&nbsp;');
            }

            var range      = self.viper.getViperRange();
            var selectable = range._getFirstSelectableChild(blockSibling);
            if (!selectable) {
                selectable = document.createTextNode(' ');
                if (blockSibling.firstChild) {
                    ViperUtil.insertBefore(blockSibling.firstChild, selectable);
                } else {
                    blockSibling.appendChild(selectable);
                }
            }

            range.setStart(selectable, 0);
            range.collapse(true);
            ViperSelection.addRange(range);
            return false;
        });

        this.viper.registerCallback('ViperChangeTracker:modeChange', 'ViperCoreStylesPlugin', function(mode) {
            // First get format change tags.
            var nodes    = ViperChangeTracker.getCTNodes('formatChange');
            var copyAttr = ['class', 'viperchangeid', 'time'];
            if (mode === 'original') {
                // Format changes need to be converted to span/div/etc..
                ViperUtil.foreach(nodes, function(i) {
                    var node = nodes[i];
                    var span = Viper.document.createElement('span');
                    ViperUtil.foreach(copyAttr, function(j) {
                        var attrVal = ViperUtil.attr(node, copyAttr[j]);
                        if (ViperUtil.isset(attrVal) === true) {
                            ViperUtil.attr(span, copyAttr[j], attrVal);
                        }
                    });

                    // Set data attribute.
                    ViperChangeTracker.setCTData(span, 'tagName', node.tagName.toLowerCase());

                    // Move child nodes in to the new element.
                    while (node.firstChild) {
                        span.appendChild(node.firstChild);
                    }

                    var changeid = ViperUtil.attr(span, 'viperchangeid');
                    if (changeid) {
                        ViperChangeTracker.addNodeToChange(changeid, span, node);
                    }

                    ViperUtil.insertBefore(node, span);
                    ViperUtil.remove(node);
                });
            } else {
                // Format changes need to be converted to strong/em/etc..
                ViperUtil.foreach(nodes, function(i) {
                    var node    = nodes[i];
                    var origTag = ViperChangeTracker.getCTData(node, 'tagName');
                    if (!origTag) {
                        // Cannot convert this without the old tag name.
                        return;
                    }

                    var span = Viper.document.createElement(origTag);
                    ViperUtil.foreach(copyAttr, function(j) {
                        var attrVal = ViperUtil.attr(node, copyAttr[j]);
                        if (ViperUtil.isset(attrVal) === true) {
                            ViperUtil.attr(span, copyAttr[j], attrVal);
                        }
                    });

                    // Move child nodes in to the new element.
                    while (node.firstChild) {
                        span.appendChild(node.firstChild);
                    }

                    var changeid = ViperUtil.attr(span, 'viperchangeid');
                    if (changeid) {
                        ViperChangeTracker.addNodeToChange(changeid, span, node);
                    }

                    ViperUtil.insertBefore(node, span);
                    ViperUtil.remove(node);
                });
            }//end if

            var nodes = ViperChangeTracker.getCTNodes('alignmentChange');
            if (nodes) {
                // Change the text alignment.
                if (mode === 'original') {
                    ViperUtil.foreach(nodes, function(i) {
                        var node  = nodes[i];
                        var align = ViperChangeTracker.getCTData(node, 'text-align');
                        if (!align) {
                            align = '';
                        }

                        ViperChangeTracker.setCTData(node, 'fin-text-align', ViperUtil.getStyle(node, 'text-align'));
                        ViperUtil.setStyle(node, 'text-align', align);
                    });
                } else {
                    ViperUtil.foreach(nodes, function(i) {
                        var node  = nodes[i];
                        var align = ViperChangeTracker.getCTData(node, 'fin-text-align');
                        if (!align) {
                            align = '';
                        }

                        ViperUtil.setStyle(node, 'text-align', align);
                    });
                }//end if
            }//end if

            var nodes = ViperChangeTracker.getCTNodes('removedFormat');
            if (nodes) {
                if (mode === 'original') {
                    ViperUtil.foreach(nodes, function(i) {
                        var node    = nodes[i];
                        var origTag = ViperChangeTracker.getCTData(node, 'tagName');
                        if (!origTag) {
                            // Cannot convert this without the old tag name.
                            return;
                        }

                        var span = Viper.document.createElement(origTag);
                        ViperChangeTracker.setCTData(span, 'formatRemoved', origTag);

                        ViperUtil.foreach(copyAttr, function(j) {
                            var attrVal = ViperUtil.attr(node, copyAttr[j]);
                            if (ViperUtil.isset(attrVal) === true) {
                                ViperUtil.attr(span, copyAttr[j], attrVal);
                            }
                        });

                        // Move child nodes in to the new element.
                        while (node.firstChild) {
                            span.appendChild(node.firstChild);
                        }

                        var changeid = ViperUtil.attr(span, 'viperchangeid');
                        if (changeid) {
                            ViperChangeTracker.addNodeToChange(changeid, span, node);
                        }

                        ViperUtil.insertBefore(node, span);
                        ViperUtil.remove(node);
                    });
                } else {
                    ViperUtil.foreach(nodes, function(i) {
                        var node    = nodes[i];
                        var origTag = ViperChangeTracker.getCTData(node, 'formatRemoved');
                        if (!origTag) {
                            // If formatRemoved is not set then dont remove format..
                            return;
                        }

                        var span = Viper.document.createElement('span');
                        ViperChangeTracker.setCTData(span, 'tagName', origTag);

                        ViperUtil.foreach(copyAttr, function(j) {
                            var attrVal = ViperUtil.attr(node, copyAttr[j]);
                            if (ViperUtil.isset(attrVal) === true) {
                                ViperUtil.attr(span, copyAttr[j], attrVal);
                            }
                        });

                        // Move child nodes in to the new element.
                        while (node.firstChild) {
                            span.appendChild(node.firstChild);
                        }

                        var changeid = ViperUtil.attr(span, 'viperchangeid');
                        if (changeid) {
                            ViperChangeTracker.addNodeToChange(changeid, span, node);
                        }

                        ViperUtil.insertBefore(node, span);
                        ViperUtil.remove(node);
                    });
                }//end if
            }//end if
        });

        ViperChangeTracker.addChangeType('formatChange', 'Formatted', 'format');
        ViperChangeTracker.addChangeType('alignmentChange', 'Formatted', 'format');
        ViperChangeTracker.addChangeType('removedFormat', 'Formatted', 'format');

        ViperChangeTracker.setDescriptionCallback('removedFormat', function(node) {
            var changes = [];
            var desc    = '';
            var ctNodes = ViperChangeTracker.getCTNodes('removedFormat', node);
            ctNodes.unshift(node);

            ViperUtil.foreach(ctNodes, function(i) {
                if (ViperUtil.isTag(ctNodes[i], 'span') === true) {
                    var ctdata = ViperChangeTracker.getCTData(ctNodes[i], 'tagName');
                    if (tagNames[ctdata]) {
                        changes.push('Not ' + tagNames[ctdata]);
                    }
                }
            });

            desc += changes.join(', ');

            return desc;
        });

        ViperChangeTracker.setDescriptionCallback('formatChange', function(node) {
            var desc    = '';
            var changes = [];
            var ctNodes = ViperChangeTracker.getCTNodes('formatChange', node);
            ctNodes.unshift(node);
            ViperUtil.foreach(ctNodes, function(i) {
                var tagName = ctNodes[i].tagName.toLowerCase();
                if (tagNames[tagName]) {
                    changes.push(tagNames[tagName]);
                } else {
                    tagName = ViperChangeTracker.getCTData(ctNodes[i], 'tagName');
                    if (tagNames[tagName]) {
                        changes.push(tagNames[tagName]);
                    }
                }
            });

            desc += changes.join(', ');
            return desc;
        });

        ViperChangeTracker.setDescriptionCallback('alignmentChange', function(node) {
            var style = '';
            if (ViperChangeTracker.getCurrentMode() === 'original') {
                style = ViperChangeTracker.getCTData(node, 'fin-text-align') || '';
            } else {
                style = ViperUtil.getStyle(node, 'text-align') || '';
            }

            if (style) {
                style = 'Aligned ' + ViperUtil.ucFirst(style);
            }

            return style;
        });

        ViperChangeTracker.setApproveCallback('formatChange', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });

        ViperChangeTracker.setRejectCallback('formatChange', function(clone, node) {
            // Remove all nodes insede the specified node before it.
            while (node.firstChild) {
                ViperUtil.insertBefore(node, node.firstChild);
            }

            // Remove node.
            ViperUtil.remove(node);
        });

        ViperChangeTracker.setRejectCallback('removedFormat', function(clone, node) {
            var ctNodes = ViperChangeTracker.getCTNodes('removedFormat', node);
            ctNodes.unshift(node);

            var mode = ViperChangeTracker.getCurrentMode();
            ViperUtil.foreach(ctNodes, function(i) {
                var elem = ctNodes[i];
                if (!elem.parentNode) {
                    return;
                }

                var ctdata = '';
                if (mode === 'original') {
                    ctdata = ViperChangeTracker.getCTData(elem, 'removedFormat');
                } else {
                    ctdata = ViperChangeTracker.getCTData(elem, 'tagName');
                }

                if (ctdata) {
                    var newElem = Viper.document.createElement(ctdata);
                    while (elem.firstChild) {
                        newElem.appendChild(elem.firstChild);
                    }

                    ViperUtil.insertBefore(elem, newElem);
                    ViperUtil.remove(elem);
                }
            });
        });

        ViperChangeTracker.setApproveCallback('removedFormat', function(clone, node) {
            var ctNodes = ViperChangeTracker.getCTNodes('removedFormat', node);
            ctNodes.unshift(node);

            var mode = ViperChangeTracker.getCurrentMode();
            ViperUtil.foreach(ctNodes, function(i) {
                var elem = ctNodes[i];
                if (mode === 'original') {
                    var tag = ViperChangeTracker.getCTData(elem, 'formatRemoved');
                    if (tag) {
                        ViperUtil.insertBefore(elem, elem.childNodes);
                        ViperUtil.remove(elem);
                    }
                } else if (ViperUtil.isTag(elem, 'span') === true && elem.getAttribute('ctdata')) {
                    ViperUtil.insertBefore(elem, elem.childNodes);
                    ViperUtil.remove(elem);
                }
            });
        });

        ViperChangeTracker.setApproveCallback('alignmentChange', function(clone, node) {
            if (ViperChangeTracker.getCurrentMode() === 'original') {
                var finAlignment = ViperChangeTracker.getCTData(node, 'fin-text-align') || '';
                ViperUtil.setStyle(node, 'text-align', finAlignment);
            }

            ViperChangeTracker.removeTrackChanges(node);
        });

        ViperChangeTracker.setRejectCallback('alignmentChange', function(clone, node) {
            // Restore old alignment.
            var style = ViperChangeTracker.getCTData(node, 'text-align');
            if (!style) {
                style = 'left';
            }

            ViperUtil.setStyle(node, 'text-align', style);
            ViperChangeTracker.removeTrackChanges(node);
        });

    },

    handleJustify: function(type)
    {
        if (this._selectedImage) {
            this._handleImageJustify(this._selectedImage, type);
            return;
        }

        var range = this.viper.getViperRange();

        var start = range.startContainer;
        var end   = range.endContainer;
        var node  = start;
        var next  = null;

        var common = this.viper.getNodeSelection();
        if (!common) {
            common = range.getCommonElement();
            common = this.getFirstBlockParent(common);
        }

        if (ViperUtil.isBlockElement(common) === true
            && ViperUtil.inArray(ViperUtil.getTagName(common), ['tr', 'table']) === false
            && ViperUtil.isChildOf(common, this.viper.element) === true
        ) {
            this.setJustifyChangeTrackInfo(common);
            this.toggleJustify(common, type);
        } else {
            var parent       = null;
            var bookmark     = null;
            var elemsBetween = [];

            if (range.collapsed !== true || ViperUtil.isStubElement(start) === false) {
                bookmark     = this.viper.createBookmark();
                elemsBetween = ViperUtil.getElementsBetween(bookmark.start, bookmark.end);
            } else {
                elemsBetween = ViperUtil.getElementsBetween(start, end);
                elemsBetween.unshift(start);
                elemsBetween.push(end);
            }

            var toggleAlignment = true;
            var parentElements  = [];
            while (node = elemsBetween.shift()) {
                if (ViperUtil.isBlockElement(node) === true) {
                    if (ViperUtil.getStyle(node, 'text-align') !== type) {
                        toggleAlignment = false;
                    }

                    if (ViperUtil.inArray(node, parentElements) === false) {
                        parentElements.push(node);
                    }

                    parent = null;
                } else if (parent === null && (parent = this.getFirstBlockParent(node))) {
                    // If we havent found a good parent and the node's parent is a block
                    // element then set the style of that parent.
                    if (ViperUtil.getStyle(parent, 'text-align') !== type) {
                        toggleAlignment = false;
                    }

                    if (ViperUtil.inArray(parent, parentElements) === false) {
                        parentElements.push(parent);
                    }

                    parent = null;
                } else if (node.nodeType == ViperUtil.TEXT_NODE && ViperUtil.isBlank(ViperUtil.trim(node.data)) === true) {
                    continue;
                } else {
                    // This is not a block element so we need to insert
                    // this element and all of its non-block siblings to a
                    // new P element.
                    if (parent === null) {
                        parent = Viper.document.createElement('p');

                        // Insert the new P tag before this node.
                        ViperUtil.insertBefore(node, parent);
                    }

                    if (ViperUtil.getStyle(parent, 'text-align') !== type) {
                        toggleAlignment = false;
                    }

                    // Add the node to the new P elem.
                    parent.appendChild(node);

                    if (ViperUtil.inArray(parent, parentElements) === false) {
                        parentElements.push(parent);
                    }
                }//end if

                if (node === end) {
                    break;
                }
            }//end while

            for (var i = 0; i < parentElements.length; i++) {
                this.toggleJustify(parentElements[i], type, !toggleAlignment);
            }

            if (bookmark !== null) {
                this.viper.selectBookmark(bookmark);
            }
        }//end if

        this.viper.focus();
        this.viper.fireSelectionChanged(null, true);
        this.viper.fireNodesChanged();

    },

    toggleJustify: function(node, type, force)
    {
        var current = node.style.textAlign;
        if (force !== true && current === type) {
            ViperUtil.setStyle(node, 'text-align', '');

            if (ViperUtil.hasAttribute(node, 'style') === true
                && node.getAttribute('style') === ''
            ) {
                node.removeAttribute('style');
            }
        } else {
            ViperUtil.setStyle(node, 'text-align', type);
        }

    },

    _handleImageJustify: function(image, type)
    {
        if (!image || type === 'block') {
            return;
        }

        var currentType = this._getImageJustify(image);
        if (currentType === type) {
            type = null;
        }

        this.viper.fireCallbacks('ViperCoreStylesPlugin:beforeImageUpdate', image);

        switch (type) {
            case 'left':
                ViperUtil.setStyle(image, 'float', 'left');
                ViperUtil.setStyle(image, 'margin', '1em 1em 1em 0px');
                ViperUtil.setStyle(image, 'display', '');
            break;

            case 'right':
                ViperUtil.setStyle(image, 'float', 'right');
                ViperUtil.setStyle(image, 'margin', '1em 0px 1em 1em');
                ViperUtil.setStyle(image, 'display', '');
            break;

            case 'center':
                ViperUtil.setStyle(image, 'margin', '1em auto');
                ViperUtil.setStyle(image, 'float', '');
                ViperUtil.setStyle(image, 'display', 'block');
            break;

            default:
                ViperUtil.setStyle(image, 'margin', '');
                ViperUtil.setStyle(image, 'float', '');
                ViperUtil.setStyle(image, 'display', '');
            break;
        }//end switch

        if (image.getAttribute('style') === '') {
            image.removeAttribute('style');
        }

        // Reset button status.
        var types = ['left', 'center', 'right', 'block'];
        var c     = types.length;
        this.viper.ViperTools.getItem('justify').setIconClass('Viper-justifyLeft');
        this.viper.ViperTools.setButtonInactive('justify');
        for (var i = 0; i < c; i++) {
            this.viper.ViperTools.setButtonInactive('ViperCoreStylesPlugin:vtp:' + types[i]);
        }

        this.viper.ViperTools.disableButton('ViperCoreStylesPlugin:vtp:block');

        if (type !== null) {
            this.viper.ViperTools.setButtonActive('ViperCoreStylesPlugin:vtp:' + type);
            this.viper.ViperTools.getItem('justify').setIconClass('Viper-justify' + ViperUtil.ucFirst(type));
        } else {
            this.viper.ViperTools.getItem('justify').setIconClass('Viper-justifyLeft');
        }

        this.viper.ViperTools.setButtonActive('justify');

        this.viper.fireNodesChanged();
        this.viper.fireSelectionChanged(null, true);

        this.viper.fireCallbacks('ViperCoreStylesPlugin:afterImageUpdate', image);

    },

    _getImageJustify: function(image)
    {
        if (!image) {
            return null;
        }

        var type  = '';
        var imgFloat = ViperUtil.getStyle(image, 'float');
        if (imgFloat === 'left') {
            type = 'left';
        } else if (imgFloat === 'right') {
            type = 'right';
        } else if (ViperUtil.getStyle(image, 'display') === 'block') {
            type = 'center';
        }

        return type;

    },

    /**
     * Make sure this method is called before changing the style of the node
     * so that old alignment can be retrieved.
     */
    setJustifyChangeTrackInfo: function(node)
    {
        if (node && ViperChangeTracker.isTrackingNode(node) === false) {
            // Get current style.
            var style = ViperUtil.getStyle(node, 'text-align');
            if (style
                && ( style === 'left'
                || style === 'right'
                || style === 'center'
                || style === 'justify')
            ) {
                if (ViperChangeTracker.isTracking() === true) {
                    ViperChangeTracker.setCTData(node, 'text-align', style);
                }
            }

            ViperChangeTracker.addChange('alignmentChange', [node]);
        }

    },

    handleHR: function()
    {
        var hr = document.createElement('hr');

        this.viper.ViperHistoryManager.begin();

        var range = this.viper.getViperRange();
        if (range.collapsed !== true) {
            range.deleteContents();
            range = this.viper.getViperRange();
        }

        if (ViperUtil.isBrowser('msie') === true
            && range.startContainer
            && range.collapsed === true
            && range.startContainer.nodeType === ViperUtil.TEXT_NODE
            && (ViperUtil.getHtml(range.startContainer.parentNode) === ''
                || ViperUtil.getHtml(range.startContainer.parentNode) === '&nbsp;')
        ) {
            var prev = range.startContainer.parentNode;
        } else {
            var keyboardEditorPlugin = this.viper.ViperPluginManager.getPlugin('ViperKeyboardEditorPlugin');
            var prev = keyboardEditorPlugin.splitAtRange(true, null);
        }

        var nextSibling = prev.nextSibling;

        ViperUtil.insertAfter(prev, hr);

        if (!nextSibling || ViperUtil.isBlockElement(nextSibling) === false) {
            var p = document.createElement('p');
            ViperUtil.setHtml(p, '&nbsp;');
            ViperUtil.insertAfter(hr, p);
            nextSibling = p;
        } else {
            if (ViperUtil.trim(ViperUtil.getNodeTextContent(nextSibling)) === '') {
                if (!nextSibling.nextElementSibling || ViperUtil.isBlockElement(nextSibling.nextElementSibling) === false) {
                    ViperUtil.setHtml(nextSibling, '&nbsp;');

                    var nextEmptyElem = nextSibling.nextSibling;
                    while (nextEmptyElem) {
                        if (ViperUtil.isBlockElement(nextEmptyElem) === true) {
                            var html = ViperUtil.getHtml(nextEmptyElem);
                            if (html === '' || html === '<br>' || html === '&nbsp;') {
                                // This is an empty block element that is after the next sibling.. remove it..
                                nextEmptyElem.parentNode.removeChild(nextEmptyElem);
                            }

                            break;
                        } else if (nextEmptyElem.nodeType === ViperUtil.TEXT_NODE && ViperUtil.trim(nextEmptyElem.data) !== '') {
                            break;
                        }

                        nextEmptyElem = nextEmptyElem.nextSibling;
                    }
                } else if (nextSibling.nextElementSibling) {
                    var delNode = nextSibling;
                    nextSibling = nextSibling.nextElementSibling;
                    ViperUtil.remove(delNode);
                }
            } else if (range.startOffset === 0
                && (ViperUtil.trim(ViperUtil.getNodeTextContent(prev)) === ''
                ||  ViperUtil.getHtml(prev) === '&nbsp;')
            ) {
                ViperUtil.remove(prev);
            }
        }//end if

        var range = this.viper.getViperRange();
        range.setStart(range._getFirstSelectableChild(nextSibling), 0);
        range.collapse(true);
        ViperSelection.addRange(range);

        this.viper.fireNodesChanged('ViperCoreStylesPlugin:hr');
        this.viper.ViperHistoryManager.end();

        this.viper.fireSelectionChanged(null, true);

    },

    getFirstBlockParent: function(elem)
    {
        if (ViperUtil.isBlockElement(elem) === true) {
            return elem;
        }

        // Get the parents of the start node.
        var parents = ViperUtil.getParents(elem);

        var parent = null;
        var pln    = parents.length;
        for (var i = 0; i < pln; i++) {
            parent = parents[i];
            if (parent === this.viper.element) {
                return null;
            }

            if (ViperUtil.isBlockElement(parent) === true) {
                return parent;
            }
        }

    },


    getAlignment: function(element)
    {
        var parent = this.getFirstBlockParent(element);
        if (parent !== null) {
            return ViperUtil.getStyle(parent, 'text-align');
        }

    },

    setAlignment: function(element, type)
    {
        ViperUtil.setStyle(element, 'text-align', type);

    },

    removeFormat: function()
    {
        var range = this.viper.getViperRange().cloneRange();
        range     = this.viper.adjustRange(range);

        var nodeSelection = range.getNodeSelection();
        var startNode     = null;
        var endNode       = null;
        var bookmark      = null;

        if (nodeSelection) {
            var sParents  = ViperUtil.getSurroundingParents(nodeSelection);
            if (sParents.length > 0 && sParents[(sParents.length - 1)] !== this.viper.getViperElement()) {
                nodeSelection = sParents[(sParents.length - 1)];
            }
        }

        if (nodeSelection && nodeSelection === this.viper.getViperElement()) {
            nodeSelection = null;
        }

        if (!nodeSelection) {
            var startNode = range.getStartNode();
            if (ViperUtil.isChildOf(startNode, this.viper.element) === false) {
                range.setStart(this.viper.element, 0);
            }

            var endNode = range.getEndNode();
            if (ViperUtil.isChildOf(endNode, this.viper.element) === false) {
                range.setEnd(this.viper.element, this.viper.element.childNodes.length);
            }

            ViperSelection.addRange(range);
            bookmark = this.viper.createBookmark();

            // Get the parent block element of the bookmark so its styles are removed as well.
            startNode = ViperUtil.getFirstBlockParent(bookmark.start);
            if (ViperUtil.isChildOf(startNode, this.viper.element) === false) {
                startNode = bookmark.start;
            }
        } else {
            bookmark  = this.viper.createBookmark();
            startNode = nodeSelection;
        }

        var stopElem = null
        if (nodeSelection) {
            stopElem = range._getLastSelectableChild(nodeSelection);
        }

        ViperUtil.walk(startNode, function(elem) {
            if (bookmark && elem === bookmark.end) {
                return false;
            }

            var continueElement = null;
            if (!bookmark || elem !== bookmark.start) {
                if (elem.nodeType === ViperUtil.ELEMENT_NODE) {
                    ViperUtil.removeAttr(elem, 'style');
                    ViperUtil.removeAttr(elem, 'class');

                    if (elem.attributes.length === 0 && ViperUtil.isTag(elem, 'span') === true) {
                        // Set the continueElement to be the first child of this element as it will be removed and
                        // we want to continue walking DOM from the first child element.
                        continueElement = elem.firstChild;
                        while (elem.firstChild) {
                            ViperUtil.insertBefore(elem, elem.firstChild);
                        }

                        ViperUtil.remove(elem);
                        if (nodeSelection === elem) {
                            return false;
                        }
                    }
                }
            }

            if (nodeSelection && elem === stopElem) {
                return false;
            }

            return continueElement;
        });

        if (bookmark) {
            this.viper.selectBookmark(bookmark);
        }

        var tags = this.styleTags.concat(['font', 'u', 'strike']);

        // Start batch change for tracking..
        var changeid = ViperChangeTracker.startBatchChange('removedFormat');

        // Remove all formating tags.
        var tmpSpan = null;
        if (nodeSelection) {
            // Bookmark the selection and wrap the node in to a tmp span incase the node it self gets removed.
            bookmark = this.viper.createBookmark();
            tmpSpan = document.createElement('span');
            ViperUtil.insertBefore(nodeSelection, tmpSpan);
            tmpSpan.appendChild(nodeSelection);
        }

        var tln = tags.length;
        for (var i = 0; i < tln; i++) {
            this.viper.removeStyle(tags[i], tmpSpan);
        }

        if (tmpSpan) {
            while (tmpSpan.firstChild) {
                ViperUtil.insertBefore(tmpSpan, tmpSpan.firstChild);
            }

            ViperUtil.remove(tmpSpan);
            this.viper.selectBookmark(bookmark);
        }

        ViperChangeTracker.endBatchChange(changeid);

        if (ViperUtil.isBrowser('msie', '<11') === true && nodeSelection && !bookmark) {
            var self = this;
            setTimeout(function() {
                ViperSelection.addRange(range);
                self.viper.fireNodesChanged();
                self.viper.fireSelectionChanged();
            }, 10);
        } else {
            if (nodeSelection && this.viper.isOutOfBounds(nodeSelection) === false) {
                range.selectNode(nodeSelection);
                ViperSelection.addRange(range);
            }

            this.viper.fireSelectionChanged(null, true);
            this.viper.fireNodesChanged();

            if (nodeSelection
                && ViperUtil.isTag(nodeSelection, 'table') === true
                && (ViperUtil.isBrowser('chrome') === true || ViperUtil.isBrowser('safari') === true)
            ) {
                // Webkit seems to fail to return the correct position for table
                // range. Update position for specific table element and not range.
                var inlineToolbar = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');
                inlineToolbar.getToolbar().updatePosition(null, nodeSelection);
            }
        }

    },

    _wrapNodeWithActiveStyle: function(node, range)
    {
        if (!node || !this._onChangeAddStyle.length || !range) {
            return;
        }

        var origData = node.data;
        var style    = null;
        var removeStyle = false;
        while (style = this._onChangeAddStyle.shift()) {
            var nodes = this.viper.splitNodeAtRange(style, range, true);

            if (removeStyle === true || ViperUtil.isTag(nodes.prevNode, style) === true || ViperUtil.isTag(nodes.nextNode, style) === true) {
                if (this._onChangeAddStyle.length > 0) {
                    removeStyle = true;
                    node.data = '';
                } else {
                    node.data = origData;
                }

                // Removing styles..
                if (nodes.midNode === null) {
                    // Create an empty text node in between two new nodes.
                    ViperUtil.insertAfter(nodes.prevNode, node);
                } else if (nodes.midNode.nodeType === ViperUtil.TEXT_NODE) {
                    nodes.midNode.data = node.data + nodes.midNode.data;
                    node = nodes.midNode;
                } else {
                    // Find the last node and insert the text node there..
                    var tmpnode = nodes.midNode;
                    while (tmpnode.firstChild) {
                        tmpnode = tmpnode.firstChild;
                    }

                    tmpnode.appendChild(node);
                }

                // Make sure nextNode is not empty.
                if (ViperUtil.getNodeTextContent(nodes.nextNode).length === 0) {
                    ViperUtil.remove(nodes.nextNode);
                }

                if ((!nodes.midNode
                    || !nodes.midNode.parentNode)
                    && (nodes.prevNode
                    && nodes.prevNode.parentNode)
                ) {
                    ViperUtil.insertAfter(nodes.prevNode, node);
                }

                var emptyTextNode = null;
                while (emptyTextNode = node.nextSibling) {
                    if (emptyTextNode.nodeType === ViperUtil.TEXT_NODE
                        && emptyTextNode.data.length === 0
                    ) {
                        ViperUtil.remove(emptyTextNode);
                    } else {
                        break;
                    }
                }

                if (!node.nextSibling && node.nodeType === ViperUtil.TEXT_NODE) {
                    ViperUtil.insertAfter(node, document.createElement('br'));
                }

                if (node.data.length > 0) {
                    range.setEnd(node, 1);
                } else {
                    range.setEnd(node, 0);
                }

                range.collapse(false);
                ViperSelection.addRange(range);
            } else {
                // Start a new style tag.
                var styleTag = Viper.document.createElement(style);

                if (nodes.prevNode) {
                    this.viper.insertAfter(nodes.prevNode, styleTag);
                } else if (nodes.nextNode) {
                    this.viper.insertBefore(nodes.nextNode, styleTag);
                }

                styleTag.appendChild(node);

                range.setStart(node, 1);
                range.collapse(true);
                ViperSelection.addRange(range);
            }//end if
        }

        return false;

    },

    handleStyle: function(style)
    {
        // Determine if we need to apply or remove the styles.
        var range = this.viper.getViperRange();

        if (range.collapsed === true) {
            // Range is collapsed. We need to listen for next insertion.
            var index = ViperUtil.arraySearch(style, this._onChangeAddStyle);
            if (index >= 0) {
                ViperUtil.removeArrayIndex(this._onChangeAddStyle, index);
                this.viper.ViperTools.setButtonInactive(this._buttons[style]);
            } else {
                this._onChangeAddStyle.push(style);

                var button = this.viper.ViperTools.getItem(this._buttons[style]);
                if (button) {
                    if (button.isActive() === true) {
                        this.viper.ViperTools.setButtonInactive(this._buttons[style]);
                    } else {
                        this.viper.ViperTools.setButtonActive(this._buttons[style]);
                    }
                }
            }
            return false;
        }

        var selectedNode = range.getNodeSelection(null, true);
        var startNode    = null;
        var endNode      = null;
        var viperElement = this.viper.getViperElement();

        if (!selectedNode) {
            startNode = range.getStartNode();
            endNode   = range.getEndNode();
        } else {
            startNode = selectedNode;
        }

        if (!endNode) {
            endNode = startNode;
        } else if (endNode.nodeType === ViperUtil.ELEMENT_NODE && ViperUtil.isBrowser('msie') === true) {
            endNode = range._getLastSelectableChild(endNode);
            range.setEnd(endNode, endNode.data.length);
            ViperSelection.addRange(range);
        }

        var commonParent = range.getCommonElement();

        if (startNode === endNode
            && ((startNode === viperElement)
            || (startNode.nodeType === ViperUtil.TEXT_NODE
            && ViperUtil.trim(startNode.data) === ''
            && startNode === viperElement.firstChild))
        ) {
            // Whole content is selected.
            startNode = range._getFirstSelectableChild(viperElement);
            endNode   = range._getLastSelectableChild(viperElement);

            if (ViperUtil.getParents(startNode, style, viperElement).length > 0
                && ViperUtil.getParents(endNode, style, viperElement).length > 0
            ) {
                // Selection is inside the style tags. Remove styles.
                var changeid = ViperChangeTracker.startBatchChange('removedFormat');
                this.viper.removeStyle(style);
                ViperChangeTracker.endBatchChange(changeid);

                this.viper.fireNodesChanged();
                this.viper.fireSelectionChanged(this.viper.adjustRange(), true);
                return;
            }
        }

        if (ViperUtil.isTag(commonParent, style) === true
            || ViperUtil.isTag(startNode, style) === true
            || (ViperUtil.getParents(startNode, style).length > 0
            && ViperUtil.getParents(endNode, style).length > 0)
            || (selectedNode && this._getWholeStyleSelections(selectedNode, [style], []).length > 0)
        ) {
            // This selection is already styles, remove it.
            var changeid = ViperChangeTracker.startBatchChange('removedFormat');
            this.viper.removeStyle(style);
            ViperChangeTracker.endBatchChange(changeid);

            this.viper.fireNodesChanged([commonParent]);
            this.viper.fireSelectionChanged(this.viper.adjustRange(), true);
            return false;
        }

        this.viper.ViperHistoryManager.begin();

        // Apply the new tag.
        this.applyTag(style);

        this.viper.fireNodesChanged([commonParent]);
        this.viper.ViperHistoryManager.end();

        this.viper.fireSelectionChanged(this.viper.adjustRange(), true);

        // Prevent event bubbling etc.
        return false;

    },

    getStyleTags: function()
    {
        var range = this.viper.getViperRange();
        var tags  = ViperUtil.getParents(range.startContainer, this.styleTags.join(','));
        return tags;

    },

    applyTag: function(tag)
    {
        this.viper.ViperHistoryManager.begin();
        this.viper.surroundContents(tag);
        this.viper.ViperHistoryManager.end();

    },

    _canStyleNode: function(node, topBar)
    {
        if (topBar === true) {
            if (this._selectedImage || ViperUtil.isTag(node, 'img') === true) {
                return false;
            }

            return true;
        }

        var tagName = ViperUtil.getTagName(node);
        if (ViperUtil.isBlockElement(node) === true) {
            if (ViperUtil.isTag(node, 'li') !== true
                && ViperUtil.isTag(node, 'td') !== true
                && ViperUtil.isTag(node, 'th') !== true
                && ViperUtil.isTag(node, 'img') !== true
            ) {
                return false;
            }
        } else {
            var tagNames = ['thead', 'tfoot'];
            if (ViperUtil.inArray(tagName, tagNames) === true) {
                return false;
            }
        }

        return true;

    },

    _createInlineToolbarContent: function(toolbar)
    {
        var self        = this;
        var tools       = this.viper.ViperTools;
        var buttonGroup = tools.createButtonGroup('ViperCoreStylesPlugin:vitp:btnGroup');

        tools.createButton('vitpBold', '', _('Bold'), 'Viper-bold', function() {
            return self.handleStyle('strong');
        });
        tools.createButton('vitpItalic', '', _('Italic'), 'Viper-italic', function() {
            return self.handleStyle('em');
        });

        tools.addButtonToGroup('vitpBold', 'ViperCoreStylesPlugin:vitp:btnGroup');
        tools.addButtonToGroup('vitpItalic', 'ViperCoreStylesPlugin:vitp:btnGroup');
        tools.getItem('vitpBold').setButtonShortcut('CTRL+B');
        tools.getItem('vitpItalic').setButtonShortcut('CTRL+I');

        toolbar.addButton(buttonGroup);

    },

    _updateInlineToolbar: function(data)
    {
        if (data.range.collapsed === true) {
            return;
        }

        if (this._canStyleNode(data.lineage[data.current]) !== true) {
            return;
        } else if (ViperUtil.isTag(data.lineage[data.current], 'img') === true) {
            return;
        }

        this.viper.ViperTools.setButtonInactive('vitpBold');
        this.viper.ViperTools.setButtonInactive('vitpItalic');

        var selectedNode = data.range.getNodeSelection();

        // List of tags where the bold and italic icons will not be shown if they are part or inside of the selection.
        var ignoredTags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
        if (!selectedNode) {
            ignoredTags.push('a');
        } else {
            switch (ViperUtil.getTagName(selectedNode)) {
                case 'a':
                case 'strong':
                case 'em':
                    // For these cases do not add the A tag.
                break;

                default:
                    ignoredTags.push('a');
                break;
            }
        }

        var activeStates = {};
        for (var i = 0; i < data.lineage.length; i++) {
            var tagName = ViperUtil.getTagName(data.lineage[i]);
            if (ViperUtil.inArray(tagName, ignoredTags) === true) {
                // Dont want to show style buttons for these tags.
                return;
            } else if (tagName === 'strong') {
                this.viper.ViperTools.setButtonActive('vitpBold');
            } else if (tagName === 'em') {
                this.viper.ViperTools.setButtonActive('vitpItalic');
            }
        }

        // If the selection is between multiple elements then find out if the range
        // start and end are in same style tags.
        var tagNames  = ['strong', 'em'];
        var states    = this._getActiveStates(data.range, tagNames);
        for (var i = 0; i < states.length; i++) {
            var tagName = states[i];
            if (tagName === 'strong') {
                this.viper.ViperTools.setButtonActive('vitpBold');
            } else if (tagName === 'em') {
                this.viper.ViperTools.setButtonActive('vitpItalic');
            }
        }

        data.toolbar.showButton('vitpBold');
        data.toolbar.showButton('vitpItalic');

    },

    _updateToolbarButtonStates: function(buttons, range)
    {
        range = range || this.viper.getViperRange();

        var startNode = this.viper.getNodeSelection();
        if (!startNode) {
            startNode = range.getStartNode();
        }

        if (!startNode) {
            startNode = range.startContainer;
        }

        var tools = this.viper.ViperTools;
        if (this._canStyleNode(startNode, true) !== true) {
            for (var btn in buttons) {
                if (btn === 'justify' || btn === 'removeFormat') {
                    continue;
                }

                var c = buttons[btn].length;
                for (var i = 0; i < c; i++) {
                    var buttonName = this._buttons[buttons[btn][i]] || 'ViperCoreStylesPlugin:vtp:' + buttons[btn][i];
                    tools.disableButton(buttonName);
                }
            }

            if (this._selectedImage) {
                // Enable justify icon for selected image.
                var type = this._getImageJustify(this._selectedImage);
                tools.enableButton('justify');

                var types = ['left', 'center', 'right', 'block'];
                var c     = types.length;
                this.viper.ViperTools.getItem('justify').setIconClass('Viper-justifyLeft');
                this.viper.ViperTools.setButtonInactive('justify');
                for (var i = 0; i < c; i++) {
                    this.viper.ViperTools.setButtonInactive('ViperCoreStylesPlugin:vtp:' + types[i]);
                }

                if (type) {
                    tools.setButtonActive('ViperCoreStylesPlugin:vtp:' + type);
                    tools.getItem('justify').setIconClass('Viper-justify' + ViperUtil.ucFirst(type));
                    tools.setButtonActive('justify');
                }
            }

            return;
        }

        var tagNames = [];
        var c        = buttons.styles.length;
        for (var i = 0; i < c; i++) {
            tools.enableButton(this._buttons[buttons.styles[i]]);
            tools.setButtonInactive(this._buttons[buttons.styles[i]]);
            tagNames.push(buttons.styles[i]);
        }

        // Active states.
        var states = this._getActiveStates(range, tagNames);
        for (var i = 0; i < states.length; i++) {
            tools.setButtonActive(this._buttons[states[i]]);
        }

        if (range.collapsed === false) {
            tools.enableButton('removeFormat');
        } else {
            tools.disableButton('removeFormat');
        }

        tools.enableButton('justify');

        if (!states.alignment) {
            states.alignment = 'start';
        }

        if (states.alignment) {
            var justify       = states.alignment;
            var c             = buttons.justify.length;
            var toolbarButton = tools.getItem('justify');
            toolbarButton.setIconClass('Viper-justifyLeft');

            if (justify === 'justify') {
                justify = 'block';
            }

            var setToggleInactive = true;
            for (var i = 0; i < c; i++) {
                tools.enableButton('ViperCoreStylesPlugin:vtp:' + buttons.justify[i]);

                if (buttons.justify[i] === justify) {
                    tools.setButtonActive('ViperCoreStylesPlugin:vtp:' + buttons.justify[i]);
                    toolbarButton.setIconClass('Viper-justify' + ViperUtil.ucFirst(justify));
                    tools.setButtonActive('justify');
                    setToggleInactive = false;
                } else {
                    tools.setButtonInactive('ViperCoreStylesPlugin:vtp:' + buttons.justify[i]);
                }
            }

            if (setToggleInactive === true) {
                tools.setButtonInactive('justify');
            }
        }//end if

        var enableHr     = true;
        var hrIgnoreTags = 'tr,td,th,li,caption,img,ul,ol,table';
        if (ViperUtil.inArray(ViperUtil.getTagName(startNode), hrIgnoreTags.split(',')) === true) {
            enableHr = false;
        }

        if (enableHr === true) {
            var parents = ViperUtil.getParents(startNode, hrIgnoreTags, this.viper.getViperElement());
            if (parents.length > 0) {
                enableHr = false;
            }
        }

        if (enableHr === true) {
            tools.enableButton('hr');
        } else {
            tools.disableButton('hr');
        }

    },

    _getActiveStates: function(range, tagNames)
    {
        var activeStates = [];
        var selectedNode = range.getNodeSelection(null, true);
        var startNode    = null;
        var endNode      = null;

        if (!selectedNode) {
            startNode = range.getStartNode();
            endNode   = range.getEndNode();
        } else if (selectedNode === this.viper.getViperElement()) {
            startNode = range._getFirstSelectableChild(selectedNode);
            endNode   = range._getLastSelectableChild(selectedNode);
        } else {
            startNode = selectedNode;
        }

        if (!endNode) {
            endNode = startNode;
        }

        if (startNode && endNode) {
            var viperElement = this.viper.getViperElement();

            if (startNode === endNode && startNode === viperElement) {
                startNode = range._getFirstSelectableChild(viperElement);
                endNode   = range._getLastSelectableChild(viperElement);
            }

            // Justify state.
            activeStates.alignment = null;

            var startParent = null;
            if (!selectedNode || ViperUtil.isBlockElement(selectedNode) === false) {
                startParent = ViperUtil.getFirstBlockParent(startNode);
            } else {
                startParent = selectedNode;
            }

            if (startNode !== endNode) {
                var endParent = endNode;
                if (endNode !== viperElement) {
                    endParent = ViperUtil.getFirstBlockParent(endNode);
                }

                var elems     = ViperUtil.getElementsBetween(startParent, endParent);
                elems.unshift(startParent);
                elems.push(endParent);
                var c         = elems.length;
                for (var i = 0; i < c; i++) {
                    if (elems[i].nodeType === ViperUtil.ELEMENT_NODE && ViperUtil.isBlockElement(elems[i]) === true) {
                        var alignment = elems[i].style.textAlign;
                        if (activeStates.alignment !== null && alignment !== activeStates.alignment) {
                            activeStates.alignment = null;
                            break;
                        } else {
                            activeStates.alignment = alignment;
                        }
                    }
                }
            } else if (startParent && startParent.style) {
                activeStates.alignment = startParent.style.textAlign;
            }//end if

            if (startNode === endNode
                || (selectedNode && selectedNode !== viperElement)
            ) {
                while (startNode
                    && ViperUtil.isBlockElement(startNode) !== true
                    && startNode !== this.viper.getViperElement()
                ) {
                    var pos = ViperUtil.arraySearch(ViperUtil.getTagName(startNode), tagNames);
                    if (pos >= 0) {
                        activeStates.push(tagNames[pos]);
                    }

                    startNode = startNode.parentNode;
                }

                // Also check first and last selectable child of endNode (nodeSelection).
                activeStates.concat(this._getWholeStyleSelections(endNode, tagNames, activeStates));
            } else {
                var foundTags = [];
                while (startNode
                    && ViperUtil.isBlockElement(startNode) !== true
                    && startNode !== this.viper.getViperElement()
                ) {
                    var pos = ViperUtil.arraySearch(ViperUtil.getTagName(startNode), tagNames);
                    if (pos >= 0) {
                        foundTags.push(tagNames[pos]);
                    }

                    startNode = startNode.parentNode;
                }

                while (endNode
                    && ViperUtil.isBlockElement(endNode) !== true
                    && endNode !== this.viper.getViperElement()
                ) {
                    var tagName = ViperUtil.getTagName(endNode);
                    var pos = ViperUtil.arraySearch(tagName, foundTags);
                    if (pos >= 0) {
                        activeStates.push(tagName);
                    }

                    endNode = endNode.parentNode;
                }
            }//end if
        }//end if

        return activeStates;

    },

    _getWholeStyleSelections: function(parentNode, tagNames, parentStyles)
    {
        var range           = this.viper.getCurrentRange();
        var firstSelectable = range._getFirstSelectableChild(parentNode);
        var lastSelectable  = range._getLastSelectableChild(parentNode);
        var firstSelectableParents = [];
        var styles = parentStyles;
        if (firstSelectable && lastSelectable) {
            while (firstSelectable && firstSelectable.parentNode !== parentNode) {
                var pos = ViperUtil.arraySearch(ViperUtil.getTagName(firstSelectable.parentNode), tagNames);
                if (pos >= 0) {
                    firstSelectableParents.push(tagNames[pos]);
                }

                firstSelectable = firstSelectable.parentNode;
            }

            if (firstSelectableParents.length > 0) {
                while (lastSelectable && lastSelectable.parentNode !== parentNode) {
                    var pos = ViperUtil.arraySearch(ViperUtil.getTagName(lastSelectable.parentNode), tagNames);
                    if (pos >= 0
                        && ViperUtil.inArray(tagNames[pos], firstSelectableParents) === true
                        && ViperUtil.inArray(tagNames[pos], styles) === false
                    ) {
                        styles.push(tagNames[pos]);
                    }

                    lastSelectable = lastSelectable.parentNode;
                }
            }
        }

        return styles;

    },

    remove: function()
    {
        // Remove plugin buttons.
        this.viper.ViperTools.removeItem('ViperCoreStylesPlugin:vtp:stylesBtns');
        this.viper.ViperTools.removeItem('bold');
        this.viper.ViperTools.removeItem('italic');
        this.viper.ViperTools.removeItem('subscript');
        this.viper.ViperTools.removeItem('superscript');
        this.viper.ViperTools.removeItem('strikethrough');
        this.viper.ViperTools.removeItem('vitpBold');
        this.viper.ViperTools.removeItem('vitpItalic');
        this.viper.removeCallback(null, 'ViperCoreStylesPlugin');

    }


};
