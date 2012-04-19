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
    this._onChangeAddStyle = null;

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
        var name = 'CoreStylesKBS';
        var self = this;

        var ctrlName = 'CTRL';
        if (navigator.platform.toLowerCase().indexOf('mac') >= 0) {
            ctrlName = 'CMD';
        }

        var tools = this.viper.ViperTools;
        var toolbarPlugin  = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        this.toolbarPlugin = toolbarPlugin;
        if (toolbarPlugin) {
            var toolbarButtons = {};
            var btnGroup = tools.createButtonGroup('ViperCoreStylesPlugin:vtp:stylesBtns');

            // Main styles and remove format button groups.
            toolbarButtons.styles   = ['strong', 'em', 'sub', 'sup', 'del'];
            toolbarButtons.removeFormat = ['removeFormat'];
            toolbarButtons.justify = ['left', 'center', 'right', 'block'];
            toolbarButtons.other = ['hr'];

            tools.createButton('bold', '', 'Bold', 'Viper-bold', function() {
                return self.handleStyle('strong');
            }, true);
            tools.createButton('italic', '', 'Italic', 'Viper-italic', function() {
                return self.handleStyle('em');
            }, true);
            tools.createButton('removeFormat', '', 'Remove Format', 'Viper-removeFormat', function() {
                self.removeFormat();
            }, true);

            tools.addButtonToGroup('bold', 'ViperCoreStylesPlugin:vtp:stylesBtns');
            tools.addButtonToGroup('italic', 'ViperCoreStylesPlugin:vtp:stylesBtns');
            tools.addButtonToGroup('removeFormat', 'ViperCoreStylesPlugin:vtp:stylesBtns');
            toolbarPlugin.addButton(btnGroup);

            // Extra style buttons, sub, sup and strike.
            var btnGroup2 = tools.createButtonGroup('ViperCoreStylesPlugin:vtp:btnGroup2');
            tools.createButton('subscript', '', 'Subscript', 'Viper-subscript', function() {
                self.handleStyle('sub');
            }, true);
            tools.createButton('superscript', '', 'Superscript', 'Viper-superscript', function() {
                self.handleStyle('sup');
            }, true);
            tools.createButton('strikethrough', '', 'Strikethrough', 'Viper-strikethrough', function() {
                self.handleStyle('del');
            }, true);

            tools.addButtonToGroup('subscript', 'ViperCoreStylesPlugin:vtp:btnGroup2');
            tools.addButtonToGroup('superscript', 'ViperCoreStylesPlugin:vtp:btnGroup2');
            tools.addButtonToGroup('strikethrough', 'ViperCoreStylesPlugin:vtp:btnGroup2');
            toolbarPlugin.addButton(btnGroup2);

            // Justify buttons bubble.
            var justifyBubbleContent = document.createElement('div');
            var btnGroup3 = tools.createButtonGroup('ViperCoreStylesPlugin:vtp:btnGroup3');
            tools.createButton('ViperCoreStylesPlugin:vtp:left', '', 'Left Justify', 'Viper-justifyLeft', function() {
                self.handleJustify('left');
            });
            tools.createButton('ViperCoreStylesPlugin:vtp:center', '', 'Center Justify', 'Viper-justifyCenter', function() {
                self.handleJustify('center');
            });
            tools.createButton('ViperCoreStylesPlugin:vtp:right', '', 'Right Justify', 'Viper-justifyRight', function() {
                self.handleJustify('right');
            });
            tools.createButton('ViperCoreStylesPlugin:vtp:block', '', 'Block Justify', 'Viper-justifyBlock', function() {
                self.handleJustify('justify');
            });

            tools.addButtonToGroup('ViperCoreStylesPlugin:vtp:left', 'ViperCoreStylesPlugin:vtp:btnGroup3');
            tools.addButtonToGroup('ViperCoreStylesPlugin:vtp:center', 'ViperCoreStylesPlugin:vtp:btnGroup3');
            tools.addButtonToGroup('ViperCoreStylesPlugin:vtp:right', 'ViperCoreStylesPlugin:vtp:btnGroup3');
            tools.addButtonToGroup('ViperCoreStylesPlugin:vtp:block', 'ViperCoreStylesPlugin:vtp:btnGroup3');
            justifyBubbleContent.appendChild(btnGroup3);

            toolbarPlugin.createBubble('ViperCoreStylesPlugin:justifyBubble', 'Justification', null, justifyBubbleContent);
            var justifyBubbleToggle = tools.createButton('justify', '', 'Toggle Justification', 'Viper-justifyLeft', null, true);
            toolbarPlugin.addButton(justifyBubbleToggle);
            toolbarPlugin.setBubbleButton('ViperCoreStylesPlugin:justifyBubble', 'justify');

            var hr = tools.createButton('hr', '', 'Horizontal Rule', 'Viper-insertHr', function() {
                self.handleHR();
            }, true);
            toolbarPlugin.addButton(hr);

            this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperCoreStylesPlugin', function(data) {
                self._updateToolbarButtonStates(toolbarButtons, data.range);
            });

            var shortcuts = {
                strong: 'CTRL+B',
                em: 'CTRL+I'
            };

            tools.getItem('bold').setButtonShortcut('CTRL+B');
            tools.getItem('italic').setButtonShortcut('CTRL+I');
        }//end if

        this.viper.registerCallback('Viper:keyPress', 'ViperCoreStylesPlugin', function(e) {
            if (self._onChangeAddStyle && self.viper.isInputKey(e) === true) {
                var character = String.fromCharCode(e.which);
                return self.viper.insertTextAtCaret(character);
            }
        });

        this.viper.registerCallback('Viper:nodesInserted', 'ViperCoreStylesPlugin', function(data) {
            return self._wrapNodeWithActiveStyle(data.node, data.range);
        });

        this.viper.registerCallback('Viper:charInsert', 'ViperCoreStylesPlugin', function(data) {
            self._onChangeAddStyle = null;
        });

        // Inline toolbar.
        this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperCoreStylesPlugin', function(data) {
            self._createInlineToolbarContent(data);
        });

        var tagNames = {
            em: 'Italic',
            strong: 'Bold',
            sub: 'Subscript',
            sup: 'Superscript',
            del: 'Strikethrough'
        };

        // Inline toolbar.
        this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperCoreStylesPlugin', function(data) {
            self._createInlineToolbarContent(data);
        });

        this.viper.registerCallback('Viper:mouseDown', 'ViperCoreStylesPlugin', function(e) {
            self._selectedImage = null;
            var target = dfx.getMouseEventTarget(e);
            if (target && dfx.isTag(target, 'hr') !== true) {
                if (dfx.isTag(target, 'img') === true) {
                    self.viper.ViperTools.disableButton('ViperCoreStylesPlugin:vtp:block');
                    self._selectedImage = target;
                    self._updateToolbarButtonStates();
                }

                return;
            }

            if (self.viper.isBrowser('msie') === true) {
                // This block of code prevents IE moving user selection to the.
                // button element when clicked. When the button element is removed
                // and added back to DOM selection is not moved. Seriously, IE?
                if (target.previousSibling) {
                    var sibling = target.previousSibling;
                    target.parentNode.removeChild(target);
                    dfx.insertAfter(sibling, target);
                } else if (target.nextSibling) {
                    var sibling = target.nextSibling;
                    target.parentNode.removeChild(target);
                    dfx.insertBefore(sibling, target);
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
                if (dfx.isBlockElement(blockSibling) === true) {
                    break;
                } else if (blockSibling.nodeType === dfx.TEXT_NODE && dfx.trim(blockSibling.data) !== '') {
                    blockSibling = null;
                    break;
                }

                blockSibling = blockSibling.nextSibling;
            }

            if (!blockSibling) {
                blockSibling = document.createElement('p');
                dfx.setHtml(blockSibling, '&nbsp;');
                dfx.insertAfter(target, blockSibling);
            } else if (dfx.getHtml(blockSibling) === '') {
                dfx.setHtml(blockSibling, '&nbsp;');
            }

            var range      = self.viper.getViperRange();
            var selectable = range._getFirstSelectableChild(blockSibling);
            if (!selectable) {
                selectable = document.createTextNode(' ');
                if (blockSibling.firstChild) {
                    dfx.insertBefore(blockSibling.firstChild, selectable);
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
                dfx.foreach(nodes, function(i) {
                    var node = nodes[i];
                    var span = Viper.document.createElement('span');
                    dfx.foreach(copyAttr, function(j) {
                        var attrVal = dfx.attr(node, copyAttr[j]);
                        if (dfx.isset(attrVal) === true) {
                            dfx.attr(span, copyAttr[j], attrVal);
                        }
                    });

                    // Set data attribute.
                    ViperChangeTracker.setCTData(span, 'tagName', node.tagName.toLowerCase());

                    // Move child nodes in to the new element.
                    while (node.firstChild) {
                        span.appendChild(node.firstChild);
                    }

                    var changeid = dfx.attr(span, 'viperchangeid');
                    if (changeid) {
                        ViperChangeTracker.addNodeToChange(changeid, span, node);
                    }

                    dfx.insertBefore(node, span);
                    dfx.remove(node);
                });
            } else {
                // Format changes need to be converted to strong/em/etc..
                dfx.foreach(nodes, function(i) {
                    var node    = nodes[i];
                    var origTag = ViperChangeTracker.getCTData(node, 'tagName');
                    if (!origTag) {
                        // Cannot convert this without the old tag name.
                        return;
                    }

                    var span = Viper.document.createElement(origTag);
                    dfx.foreach(copyAttr, function(j) {
                        var attrVal = dfx.attr(node, copyAttr[j]);
                        if (dfx.isset(attrVal) === true) {
                            dfx.attr(span, copyAttr[j], attrVal);
                        }
                    });

                    // Move child nodes in to the new element.
                    while (node.firstChild) {
                        span.appendChild(node.firstChild);
                    }

                    var changeid = dfx.attr(span, 'viperchangeid');
                    if (changeid) {
                        ViperChangeTracker.addNodeToChange(changeid, span, node);
                    }

                    dfx.insertBefore(node, span);
                    dfx.remove(node);
                });
            }//end if

            var nodes = ViperChangeTracker.getCTNodes('alignmentChange');
            if (nodes) {
                // Change the text alignment.
                if (mode === 'original') {
                    dfx.foreach(nodes, function(i) {
                        var node  = nodes[i];
                        var align = ViperChangeTracker.getCTData(node, 'text-align');
                        if (!align) {
                            align = '';
                        }

                        ViperChangeTracker.setCTData(node, 'fin-text-align', dfx.getStyle(node, 'text-align'));
                        dfx.setStyle(node, 'text-align', align);
                    });
                } else {
                    dfx.foreach(nodes, function(i) {
                        var node  = nodes[i];
                        var align = ViperChangeTracker.getCTData(node, 'fin-text-align');
                        if (!align) {
                            align = '';
                        }

                        dfx.setStyle(node, 'text-align', align);
                    });
                }//end if
            }//end if

            var nodes = ViperChangeTracker.getCTNodes('removedFormat');
            if (nodes) {
                if (mode === 'original') {
                    dfx.foreach(nodes, function(i) {
                        var node    = nodes[i];
                        var origTag = ViperChangeTracker.getCTData(node, 'tagName');
                        if (!origTag) {
                            // Cannot convert this without the old tag name.
                            return;
                        }

                        var span = Viper.document.createElement(origTag);
                        ViperChangeTracker.setCTData(span, 'formatRemoved', origTag);

                        dfx.foreach(copyAttr, function(j) {
                            var attrVal = dfx.attr(node, copyAttr[j]);
                            if (dfx.isset(attrVal) === true) {
                                dfx.attr(span, copyAttr[j], attrVal);
                            }
                        });

                        // Move child nodes in to the new element.
                        while (node.firstChild) {
                            span.appendChild(node.firstChild);
                        }

                        var changeid = dfx.attr(span, 'viperchangeid');
                        if (changeid) {
                            ViperChangeTracker.addNodeToChange(changeid, span, node);
                        }

                        dfx.insertBefore(node, span);
                        dfx.remove(node);
                    });
                } else {
                    dfx.foreach(nodes, function(i) {
                        var node    = nodes[i];
                        var origTag = ViperChangeTracker.getCTData(node, 'formatRemoved');
                        if (!origTag) {
                            // If formatRemoved is not set then dont remove format..
                            return;
                        }

                        var span = Viper.document.createElement('span');
                        ViperChangeTracker.setCTData(span, 'tagName', origTag);

                        dfx.foreach(copyAttr, function(j) {
                            var attrVal = dfx.attr(node, copyAttr[j]);
                            if (dfx.isset(attrVal) === true) {
                                dfx.attr(span, copyAttr[j], attrVal);
                            }
                        });

                        // Move child nodes in to the new element.
                        while (node.firstChild) {
                            span.appendChild(node.firstChild);
                        }

                        var changeid = dfx.attr(span, 'viperchangeid');
                        if (changeid) {
                            ViperChangeTracker.addNodeToChange(changeid, span, node);
                        }

                        dfx.insertBefore(node, span);
                        dfx.remove(node);
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

            dfx.foreach(ctNodes, function(i) {
                if (dfx.isTag(ctNodes[i], 'span') === true) {
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
            dfx.foreach(ctNodes, function(i) {
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
                style = dfx.getStyle(node, 'text-align') || '';
            }

            if (style) {
                style = 'Aligned ' + dfx.ucFirst(style);
            }

            return style;
        });

        ViperChangeTracker.setApproveCallback('formatChange', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });

        ViperChangeTracker.setRejectCallback('formatChange', function(clone, node) {
            // Remove all nodes insede the specified node before it.
            while (node.firstChild) {
                dfx.insertBefore(node, node.firstChild);
            }

            // Remove node.
            dfx.remove(node);
        });

        ViperChangeTracker.setRejectCallback('removedFormat', function(clone, node) {
            var ctNodes = ViperChangeTracker.getCTNodes('removedFormat', node);
            ctNodes.unshift(node);

            var mode = ViperChangeTracker.getCurrentMode();
            dfx.foreach(ctNodes, function(i) {
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

                    dfx.insertBefore(elem, newElem);
                    dfx.remove(elem);
                }
            });
        });

        ViperChangeTracker.setApproveCallback('removedFormat', function(clone, node) {
            var ctNodes = ViperChangeTracker.getCTNodes('removedFormat', node);
            ctNodes.unshift(node);

            var mode = ViperChangeTracker.getCurrentMode();
            dfx.foreach(ctNodes, function(i) {
                var elem = ctNodes[i];
                if (mode === 'original') {
                    var tag = ViperChangeTracker.getCTData(elem, 'formatRemoved');
                    if (tag) {
                        dfx.insertBefore(elem, elem.childNodes);
                        dfx.remove(elem);
                    }
                } else if (dfx.isTag(elem, 'span') === true && elem.getAttribute('ctdata')) {
                    dfx.insertBefore(elem, elem.childNodes);
                    dfx.remove(elem);
                }
            });
        });

        ViperChangeTracker.setApproveCallback('alignmentChange', function(clone, node) {
            if (ViperChangeTracker.getCurrentMode() === 'original') {
                var finAlignment = ViperChangeTracker.getCTData(node, 'fin-text-align') || '';
                dfx.setStyle(node, 'text-align', finAlignment);
            }

            ViperChangeTracker.removeTrackChanges(node);
        });

        ViperChangeTracker.setRejectCallback('alignmentChange', function(clone, node) {
            // Restore old alignment.
            var style = ViperChangeTracker.getCTData(node, 'text-align');
            if (!style) {
                style = 'left';
            }

            dfx.setStyle(node, 'text-align', style);
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

        var common = range.getNodeSelection();
        if (!common) {
            common = range.getCommonElement();
            common = this.getFirstBlockParent(common);
        }

        if (dfx.isBlockElement(common) === true && dfx.isChildOf(common, this.viper.element) === true) {
            this.setJustifyChangeTrackInfo(common);
            this.toggleJustify(common, type);
        } else {
            var parent       = null;
            var bookmark     = null;
            var elemsBetween = [];

            if (range.collapsed !== true || dfx.isStubElement(start) === false) {
                bookmark     = this.viper.createBookmark();
                elemsBetween = dfx.getElementsBetween(bookmark.start, bookmark.end);
            } else {
                elemsBetween = dfx.getElementsBetween(start, end);
                elemsBetween.unshift(start);
                elemsBetween.push(end);
            }

            var toggleAlignment = true;
            var parentElements  = [];
            while (node = elemsBetween.shift()) {
                if (dfx.isBlockElement(node) === true) {
                    if (dfx.getStyle(node, 'text-align') !== type) {
                        toggleAlignment = false;
                    }

                    parentElements.push(node);
                    parent = null;
                } else if (parent === null && (parent = this.getFirstBlockParent(node))) {
                    // If we havent found a good parent and the node's parent is a block
                    // element then set the style of that parent.
                    if (dfx.getStyle(parent, 'text-align') !== type) {
                        toggleAlignment = false;
                    }

                    parentElements.push(parent);
                    parent = null;
                } else if (node.nodeType == dfx.TEXT_NODE && dfx.isBlank(dfx.trim(node.data)) === true) {
                    continue;
                } else {
                    // This is not a block element so we need to insert
                    // this element and all of its non-block siblings to a
                    // new P element.
                    if (parent === null) {
                        parent = Viper.document.createElement('p');

                        // Insert the new P tag before this node.
                        dfx.insertBefore(node, parent);
                    }

                    if (dfx.getStyle(parent, 'text-align') !== type) {
                        toggleAlignment = false;
                    }

                    // Add the node to the new P elem.
                    parent.appendChild(node);

                    parentElements.push(parent);
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

        this.viper.fireNodesChanged();
        this.viper.fireSelectionChanged(null, true);
        this.viper.focus();

    },

    toggleJustify: function(node, type, force)
    {
        var current = dfx.getStyle(node, 'text-align');
        if (force !== true && current === type) {
            dfx.setStyle(node, 'text-align', '');

            if (dfx.hasAttribute(node, 'style') === true
                && node.getAttribute('style') === ''
            ) {
                node.removeAttribute('style');
            }
        } else {
            dfx.setStyle(node, 'text-align', type);
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
                dfx.setStyle(image, 'float', 'left');
                dfx.setStyle(image, 'margin', '1em 1em 1em 0');
            break;

            case 'right':
                dfx.setStyle(image, 'float', 'right');
                dfx.setStyle(image, 'margin', '1em 0 1em 1em');
            break;

            case 'center':
                dfx.setStyle(image, 'margin', '1em auto');
                dfx.setStyle(image, 'float', '');
                dfx.setStyle(image, 'display', 'block');
            break;

            default:
                dfx.setStyle(image, 'margin', '');
                dfx.setStyle(image, 'float', '');
                dfx.setStyle(image, 'display', '');
            break;
        }//end switch

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
            this.viper.ViperTools.getItem('justify').setIconClass('Viper-justify' + dfx.ucFirst(type));
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
        var imgFloat = dfx.getStyle(image, 'float');
        if (imgFloat === 'left') {
            type = 'left';
        } else if (imgFloat === 'right') {
            type = 'right';
        } else if (dfx.getStyle(image, 'display') === 'block') {
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
            var style = dfx.getStyle(node, 'text-align');
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

        var keyboardEditorPlugin = this.viper.ViperPluginManager.getPlugin('ViperKeyboardEditorPlugin');
        var prev = keyboardEditorPlugin.splitAtRange(true, null);
        var nextSibling = prev.nextSibling;

        dfx.insertAfter(prev, hr);

        if (!nextSibling || dfx.isBlockElement(nextSibling) === false) {
            var p = document.createElement('p');
            dfx.setHtml(p, '&nbsp;');
            dfx.insertAfter(hr, p);
            nextSibling = p;
        } else {
            if (dfx.trim(dfx.getNodeTextContent(nextSibling)) === '') {
                dfx.setHtml(nextSibling, '&nbsp;');

                var nextEmptyElem = nextSibling.nextSibling;
                while (nextEmptyElem) {
                    if (dfx.isBlockElement(nextEmptyElem) === true) {
                        var html = dfx.getHtml(nextEmptyElem);
                        if (html === '' || html === '<br>' || html === '&nbsp;') {
                            // This is an empty block element that is after the next sibling.. remove it..
                            nextEmptyElem.parentNode.removeChild(nextEmptyElem);
                        }

                        break;
                    } else if (nextEmptyElem.nodeType === dfx.TEXT_NODE && dfx.trim(nextEmptyElem.data) !== '') {
                        break;
                    }

                    nextEmptyElem = nextEmptyElem.nextSibling;
                }
            } else if (range.startOffset === 0 && dfx.trim(dfx.getNodeTextContent(prev)) === '') {
                dfx.remove(prev);
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
        if (dfx.isBlockElement(elem) === true) {
            return elem;
        }

        // Get the parents of the start node.
        var parents = dfx.getParents(elem);

        var parent = null;
        var pln    = parents.length;
        for (var i = 0; i < pln; i++) {
            parent = parents[i];
            if (parent === this.viper.element) {
                return null;
            }

            if (dfx.isBlockElement(parent) === true) {
                return parent;
            }
        }

    },


    getAlignment: function(element)
    {
        var parent = this.getFirstBlockParent(element);
        if (parent !== null) {
            return dfx.getStyle(parent, 'text-align');
        }

    },

    setAlignment: function(element, type)
    {
        dfx.setStyle(element, 'text-align', type);

    },

    removeFormat: function()
    {
        var range = this.viper.getViperRange().cloneRange();
        range     = this.viper.adjustRange(range);

        var nodeSelection = range.getNodeSelection();
        var startNode     = null;
        var endNode       = null;
        var bookmark      = null;

        if (!nodeSelection) {
            var startNode = range.getStartNode();
            if (dfx.isChildOf(startNode, this.viper.element) === false) {
                range.setStart(this.viper.element, 0);
            }

            var endNode = range.getEndNode();
            if (dfx.isChildOf(endNode, this.viper.element) === false) {
                range.setEnd(this.viper.element, this.viper.element.childNodes.length);
            }

            ViperSelection.addRange(range);
            bookmark = this.viper.createBookmark();

            // Get the parent block element of the bookmark so its styles are removed as well.
            startNode = dfx.getFirstBlockParent(bookmark.start);
            if (dfx.isChildOf(startNode, this.viper.element) === false) {
                startNode = bookmark.start;
            }
        } else {
            startNode = nodeSelection;
        }

        dfx.walk(startNode, function(elem) {
            if (bookmark && elem === bookmark.end) {
                return false;
            }

            if (!bookmark || elem !== bookmark.start) {
                if (elem.nodeType === dfx.ELEMENT_NODE) {
                    dfx.removeAttr(elem, 'style');
                    dfx.removeAttr(elem, 'class');

                    if (elem.attributes.length === 0 && dfx.isTag(elem, 'span') === true) {
                        while (elem.firstChild) {
                            dfx.insertBefore(elem, elem.firstChild);
                        }

                        dfx.remove(elem);
                    }
                }
            }

            if (nodeSelection && elem === nodeSelection.lastChild) {
                return false;
            }
        });

        if (bookmark) {
            this.viper.selectBookmark(bookmark);
        }

        var tags = this.styleTags.concat(['font', 'u', 'strike']);

        // Start batch change for tracking..
        var changeid = ViperChangeTracker.startBatchChange('removedFormat');

        // Remove all formating tags.
        var tln = tags.length;
        for (var i = 0; i < tln; i++) {
            this.viper.removeStyle(tags[i]);
        }

        ViperChangeTracker.endBatchChange(changeid);

        if (this.viper.isBrowser('msie') === true && nodeSelection && !bookmark) {
            setTimeout(function() {
                ViperSelection.addRange(range);
                self.viper.fireNodesChanged();
                self.viper.fireSelectionChanged();
            }, 10);
        } else {
            this.viper.fireNodesChanged();
            this.viper.fireSelectionChanged();
        }

    },

    _wrapNodeWithActiveStyle: function(node, range)
    {
        if (!node || !this._onChangeAddStyle || !range) {
            return;
        }

        var style = this._onChangeAddStyle;
        var nodes = this.viper.splitNodeAtRange(style, range, true);
        this._onChangeAddStyle = null;

        if (dfx.isTag(nodes.prevNode, style) === true || dfx.isTag(nodes.nextNode, style) === true) {
            // Removing styles..
            if (nodes.midNode === null) {
                // Create an empty text node in between two new nodes.
                dfx.insertAfter(nodes.prevNode, node);
            } else {
                // Find the last node and insert the text node there..
                var tmpnode = nodes.midNode;
                while (tmpnode.firstChild) {
                    tmpnode = tmpnode.firstChild;
                }

                tmpnode.appendChild(node);
            }

            // Make sure nextNode is not empty.
            if (dfx.getNodeTextContent(nodes.nextNode).length === 0) {
                dfx.remove(nodes.nextNode);
            }

            range.setStart(node, 1);
            range.collapse(true);
            ViperSelection.addRange(range);
        } else {
            // Start a new style tag.
            var styleTag = Viper.document.createElement(style);
            styleTag.appendChild(node);

            if (nodes.prevNode) {
                this.viper.insertAfter(nodes.prevNode, styleTag);
            } else if (nodes.nextNode) {
                this.viper.insertBefore(nodes.nextNode, styleTag);
            }

            range.setStart(node, 1);
            range.collapse(true);
            ViperSelection.addRange(range);
        }//end if

        return false;

    },

    handleStyle: function(style)
    {
        // Determine if we need to apply or remove the styles.
        var range = this.viper.getViperRange();

        if (range.collapsed === true) {
            // Range is collapsed. We need to listen for next insertion.
            this._onChangeAddStyle = style;
            return false;
        }

        var selectedNode = range.getNodeSelection();
        var startNode    = null;
        var endNode      = null;

        if (!selectedNode) {
            var startNode = range.getStartNode();
            var endNode   = range.getEndNode();
        } else {
            startNode = selectedNode;
        }

        if (!endNode) {
            endNode = startNode;
        }

        var commonParent = range.getCommonElement();

        if (dfx.isTag(commonParent, style) === true
            || dfx.isTag(startNode, style) === true
            || (dfx.getParents(startNode, style).length > 0
            && dfx.getParents(endNode, style).length > 0)
        ) {
            // This selection is already bold, remove its styles.
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
        var tags  = dfx.getParents(range.startContainer, this.styleTags.join(','));
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
            if (this._selectedImage) {
                return false;
            }

            return true;
        }

        if (dfx.isBlockElement(node) === true) {
            if (dfx.isTag(node, 'li') !== true
                && dfx.isTag(node, 'td') !== true
                && dfx.isTag(node, 'th') !== true
                && dfx.isTag(node, 'img') !== true
            ) {
                return false;
            }
        }

        return true;

    },

    _createInlineToolbarContent: function(data)
    {
        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');

        if (data.range.collapsed === true) {
            return;
        }

        if (this._canStyleNode(data.lineage[data.current]) !== true) {
            return;
        }

        var activeStates = {};
        for (var i = 0; i < data.lineage.length; i++) {
            if (dfx.isTag(data.lineage[i], 'a') === true) {
                // Dont want to show style buttons for links.
                return;
            } else if (dfx.isTag(data.lineage[i], 'strong') === true) {
                activeStates.strong = true;
            } else if (dfx.isTag(data.lineage[i], 'em') === true) {
                activeStates.em = true;
            }
        }

        // If the selection is between multiple elements then find out if the range
        // start and end are in same style tags.
        var tagNames  = ['strong', 'em'];
        var states    = this._getActiveStates(data.range, tagNames);
        for (var i = 0; i < states.length; i++) {
            var tagName = states[i];
            if (tagName === 'strong') {
                activeStates.strong = true;
            } else if (tagName === 'em') {
                activeStates.em = true;
            }
        }

        // Add the inline toolbar buttons.
        var self        = this;
        var tools       = this.viper.ViperTools;
        var buttonGroup = tools.createButtonGroup('ViperCoreStylesPlugin:vitp:btnGroup');

        tools.createButton('vitpBold', '', 'Bold', 'Viper-bold', function() {
            return self.handleStyle('strong');
        }, false, activeStates.strong);
        tools.createButton('vitpItalic', '', 'Italic', 'Viper-italic', function() {
            return self.handleStyle('em');
        }, false, activeStates.em);

        tools.addButtonToGroup('vitpBold', 'ViperCoreStylesPlugin:vitp:btnGroup');
        tools.addButtonToGroup('vitpItalic', 'ViperCoreStylesPlugin:vitp:btnGroup');
        tools.getItem('vitpBold').setButtonShortcut('CTRL+B');
        tools.getItem('vitpItalic').setButtonShortcut('CTRL+I');

        inlineToolbarPlugin.addButton(buttonGroup);

    },

    _updateToolbarButtonStates: function(buttons, range)
    {
        range = range || this.viper.getViperRange();

        var startNode = range.getNodeSelection();
        if (!startNode) {
            startNode = range.getStartNode();
        }

        var tools     = this.viper.ViperTools;
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
                    tools.getItem('justify').setIconClass('Viper-justify' + dfx.ucFirst(type));
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
                    toolbarButton.setIconClass('Viper-justify' + dfx.ucFirst(justify));
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

        tools.enableButton('hr');

    },

    _getActiveStates: function(range, tagNames)
    {
        var activeStates = [];
        var selectedNode = range.getNodeSelection();
        var startNode    = null;
        var endNode      = null;

        if (!selectedNode) {
            startNode = range.getStartNode();
            endNode   = range.getEndNode();
        } else {
            startNode = selectedNode;
        }

        if (!endNode) {
            endNode = startNode;
        }

        if (startNode && endNode) {
            // Justify state.
            activeStates.alignment = null;

            var startParent = null;
            if (!selectedNode || dfx.isBlockElement(selectedNode) === false) {
                startParent = dfx.getFirstBlockParent(startNode);
            } else {
                startParent = selectedNode;
            }

            if (startNode !== endNode) {
                var endParent = dfx.getFirstBlockParent(endNode);
                var elems     = dfx.getElementsBetween(startParent, endParent);
                elems.unshift(startParent);
                elems.push(endParent);
                var c         = elems.length;
                for (var i = 0; i < c; i++) {
                    if (elems[i].nodeType === dfx.ELEMENT_NODE && dfx.isBlockElement(elems[i]) === true) {
                        var alignment = dfx.getStyle(elems[i], 'text-align');
                        if (activeStates.alignment !== null && alignment !== activeStates.alignment) {
                            activeStates.alignment = null;
                            break;
                        } else {
                            activeStates.alignment = alignment;
                        }
                    }
                }
            } else {
                activeStates.alignment = dfx.getStyle(startParent, 'text-align');
            }

            if (startNode === endNode
                || range.getNodeSelection()
            ) {
                while (startNode
                    && dfx.isBlockElement(startNode) !== true
                    && startNode !== this.viper.getViperElement()
                ) {
                    var pos = tagNames.find(dfx.getTagName(startNode));
                    if (pos >= 0) {
                        activeStates.push(tagNames[pos]);
                    }

                    startNode = startNode.parentNode;
                }
            } else {
                var foundTags = [];
                while (startNode
                    && dfx.isBlockElement(startNode) !== true
                    && startNode !== this.viper.getViperElement()
                ) {
                    var pos = tagNames.find(dfx.getTagName(startNode));
                    if (pos >= 0) {
                        foundTags.push(tagNames[pos]);
                    }

                    startNode = startNode.parentNode;
                }

                while (endNode
                    && dfx.isBlockElement(endNode) !== true
                    && endNode !== this.viper.getViperElement()
                ) {
                    var tagName = dfx.getTagName(endNode);
                    var pos = foundTags.find(tagName);
                    if (pos >= 0) {
                        activeStates.push(tagName);
                    }

                    endNode = endNode.parentNode;
                }
            }//end if
        }//end if

        return activeStates;

    }


};
