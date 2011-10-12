/**
 * JS Class for the Viper Core Styles Plugin.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program as the file license.txt. If not, see
 * <http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt>
 *
 * @package    CMS
 * @subpackage Editing
 * @author     Squiz Pty Ltd <products@squiz.net>
 * @copyright  2010 Squiz Pty Ltd (ACN 084 670 600)
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPLv2
 */

function ViperCoreStylesPlugin(viper)
{
    this.viper = viper;

    this.styleTags     = ['strong', 'em', 'u', 'sub', 'sup', 'strike'];
    this.buttons       = ['strong', 'emphasise', 'underline', 'subscript', 'superscript', 'strikethrough'];
    this.toolbarPlugin = null;
    this.activeStyles  = [];

    this._caretUpdatedTimeout = null;
    this._onChangeAddStyle    = null;

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

        var toolbarPlugin  = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        this.toolbarPlugin = toolbarPlugin;
        if (toolbarPlugin) {
            var toolbarButtons = {};
            var btnGroup = toolbarPlugin.createButtonGroup();
            toolbarButtons.styles = {};
            toolbarButtons.styles.strong = toolbarPlugin.createButton('B', false, 'Bold', false, 'bold', function() {
                self.handleStyle('strong');
            }, btnGroup);
            toolbarButtons.styles.em = toolbarPlugin.createButton('I', false, 'Icalic', false, 'italic', function() {
                self.handleStyle('em');
            }, btnGroup);
            toolbarButtons.styles.u = toolbarPlugin.createButton('U', false, 'Underline', false, 'underline', function() {
                self.handleStyle('u');
            }, btnGroup);
            toolbarButtons.rmFormat = toolbarPlugin.createButton('RF', false, 'Remove Format', false, 'removeFormat', function() {
                self.removeFormat();
            }, btnGroup);

            var btnGroup2 = toolbarPlugin.createButtonGroup();
            toolbarButtons.styles.sub = toolbarPlugin.createButton('Sub', false, 'Subscript', false, 'subscript', function() {
                self.handleStyle('sub');
            }, btnGroup2);
            toolbarButtons.styles.sup = toolbarPlugin.createButton('Sup', false, 'Superscript', false, 'superscript', function() {
                self.handleStyle('sup');
            }, btnGroup2);
            toolbarButtons.styles.strike = toolbarPlugin.createButton('St', false, 'Strikethrough', false, 'strikethrough', function() {
                self.handleStyle('strike');
            }, btnGroup2);

            var btnGroup3 = toolbarPlugin.createButtonGroup();
            toolbarButtons.justify = {};
            toolbarButtons.justify.left = toolbarPlugin.createButton('JL', false, 'Left Justify', false, 'justifyLeft', function() {
                self.handleJustfy('left');
            }, btnGroup3);
            toolbarButtons.justify.center = toolbarPlugin.createButton('JC', false, 'Center Justify', false, 'justifyCenter', function() {
                self.handleJustfy('center');
            }, btnGroup3);
            toolbarButtons.justify.right = toolbarPlugin.createButton('JR', false, 'Right Justify', false, 'justifyRight', function() {
                self.handleJustfy('right');
            }, btnGroup3);
            toolbarButtons.justify.justify = toolbarPlugin.createButton('JB', false, 'Block Justify', false, 'justifyBlock', function() {
                self.handleJustfy('justify');
            }, btnGroup3);

            this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperCoreStylesPlugin', function(data) {
                self._updateToolbarButtonStates(toolbarButtons, data.range);
            });
        }//end if

        var shortcuts = {
            strong: 'CTRL+B',
            em: 'CTRL+I',
            u: 'CTRL+U'
        };

        dfx.foreach(shortcuts, function(type) {
            var keys = shortcuts[type];
            self.viper.registerCallback('Viper:keyDown', 'ViperCoreStylesPlugin', function(e) {
                if (self.viper.isKey(e, 'CTRL+B') === true) {
                    return self.handleStyle('strong');
                } else if (self.viper.isKey(e, 'CTRL+I') === true) {
                    return self.handleStyle('em');
                } else if (self.viper.isKey(e, 'CTRL+U') === true) {
                    return self.handleStyle('u');
                }
            });
        });

        this.viper.registerCallback('Viper:keyPress', 'ViperCoreStylesPlugin', function(e) {
            if (self._onChangeAddStyle && self.viper.isInputKey(e) === true) {
                var char = String.fromCharCode(e.which);
                return self.viper.insertTextAtCaret(char);
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
            u: 'Underline',
            sub: 'Subscript',
            sup: 'Superscript',
            strike: 'Strikethrough'
        };

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

    handleJustfy: function(type)
    {
        var range = this.viper.getCurrentRange();

        var start = range.startContainer;
        var end   = range.endContainer;
        var node  = start;
        var next  = null;

        var common = range.getCommonElement();
        common     = this.getFirstBlockParent(common);
        if (dfx.isChildOf(common, this.viper.element) === true) {
            this.setJustfyChangeTrackInfo(common);
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

            while (node = elemsBetween.shift()) {
                if (dfx.isBlockElement(node) === true) {
                    this.setJustfyChangeTrackInfo(node);
                    this.toggleJustify(parent, type);
                    // Reset the parent var to crate a new P tag if there
                    // are more siblings.
                    parent = null;
                } else if (parent === null && (parent = this.getFirstBlockParent(node))) {
                    // If we havent found a good parent and the node's parent is a block
                    // element then set the style of that parent.
                    this.setJustfyChangeTrackInfo(parent);
                    this.toggleJustify(parent, type);
                    parent = null;
                } else {
                    // This is not a block element so we need to insert
                    // this element and all of its non-block siblings to a
                    // new P element.
                    if (parent === null) {
                        parent = Viper.document.createElement('p');
                        this.setJustfyChangeTrackInfo(parent);
                        this.toggleJustify(parent, type);

                        // Insert the new P tag before this node.
                        dfx.insertBefore(node, parent);
                    }

                    // Add the node to the new P elem.
                    parent.appendChild(node);
                }//end if

                if (node === end) {
                    break;
                }
            }//end while

            if (bookmark !== null) {
                this.viper.selectBookmark(bookmark);
            }
        }//end if

        this.viper.fireNodesChanged('ViperCoreStylesPlugin:justify');
        this.viper.fireSelectionChanged(null, true);

    },

    toggleJustify: function(node, type)
    {
        var current = dfx.getStyle(node, 'text-align');
        if (current === type) {
            dfx.setStyle(node, 'text-align', '');
        } else {
            dfx.setStyle(node, 'text-align', type);
        }
    },

    /**
     * Make sure this method is called before changing the style of the node
     * so that old alignment can be retrieved.
     */
    setJustfyChangeTrackInfo: function(node)
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

    removeFormat: function()
    {
        var range = this.viper.getCurrentRange().cloneRange();

        var keywordPlugin = this.viper.ViperPluginManager.getPlugin('ViperKeywordPlugin');

        var startNode = range.getStartNode();
        if (dfx.isChildOf(startNode, this.viper.element) === false) {
            range.setStart(this.viper.element, 0);
        }

        var endNode = range.getEndNode();
        if (dfx.isChildOf(endNode, this.viper.element) === false) {
            range.setEnd(this.viper.element, this.viper.element.childNodes.length);
        }

        ViperSelection.addRange(range);

        var bookmark = this.viper.createBookmark();

        // Get the parent block element of the bookmark so its styles are removed as well.
        startNode = dfx.getFirstBlockParent(bookmark.start);
        if (dfx.isChildOf(startNode, this.viper.element) === false) {
            startNode = bookmark.start;
        }

        dfx.walk(startNode, function(elem) {
            if (elem === bookmark.end) {
                return false;
            }

            if (elem !== bookmark.start) {
                if (elem.nodeType === dfx.ELEMENT_NODE && (!keywordPlugin || keywordPlugin.isKeyword(elem) !== true)) {
                    dfx.removeAttr(elem, 'style');
                    dfx.removeAttr(elem, 'class');
                }
            }
        });

        this.viper.selectBookmark(bookmark);

        var tags = this.styleTags.concat(['font']);

        // Start batch change for tracking..
        var changeid = ViperChangeTracker.startBatchChange('removedFormat');

        // Remove all formating tags.
        var tln = tags.length;
        for (var i = 0; i < tln; i++) {
            this.viper.removeStyle(tags[i]);
        }

        ViperChangeTracker.endBatchChange(changeid);

        this.caretUpdated();
        this.viper.fireNodesChanged('ViperCoreStylesPlugin:removeFormat');

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
        var range = this.viper.getCurrentRange();

        if (range.collapsed === true) {
            // Range is collapsed. We need to listen for next insertion.
            this._onChangeAddStyle = style;
            return false;
        }

        var startNode = range.getStartNode();
        var endNode   = range.getEndNode();

        var commonParent = range.getCommonElement();

        if (dfx.isTag(startNode, style) === true
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

        // Apply the new tag.
        this.applyTag(style);

        this.viper.fireNodesChanged([commonParent]);
        this.viper.fireSelectionChanged(this.viper.adjustRange(), true);

        // Prevent event bubbling etc.
        return false;

    },

    getStyleTags: function()
    {
        var range = this.viper.getCurrentRange();
        var tags  = dfx.getParents(range.startContainer, this.styleTags.join(','));
        return tags;

    },

    applyTag: function(tag)
    {
        this.viper.ViperHistoryManager.begin();
        this.viper.surroundContents(tag);
        this.viper.ViperHistoryManager.end();

    },

    caretUpdated: function()
    {
        var self = this;

        // Use a timeout to prevent this method doing lots of work while the
        // caret is being updated constantly (e.g. typing..).
        // TODO: There might be a delay, to prevent this we may need to pass extra info
        // from caretUpdated event, might need to send info about why it was updated.
        // If it was updated becaue of right arrow key then update instantly etc.
        clearTimeout(this._caretUpdatedTimeout);
        this._caretUpdatedTimeout = setTimeout(function() {
            var tags = self.getStyleTags();
            var asln = self.activeStyles.length;
            for (var i = 0; i < asln; i++) {
                self.setStyleButtonState(self.activeStyles[i], 'inactive');
            }

            var tln = tags.length;
            for (var i = 0; i < tln; i++) {
                var tag   = tags[i].tagName.toLowerCase();
                var index = self.styleTags.find(tag);
                if (index !== -1) {
                    self.setStyleButtonState(self.buttons[index], 'active');
                }
            }

            // Text-alignment.
            var range = self.viper.getCurrentRange();
            var style = self.getAlignment(range.startContainer);
            if (style) {
                if (style === 'start') {
                    style = 'left';
                }

                self.setStyleButtonState('align-' + style, 'active');
            }
        }, 200);

    },

    setStyleButtonState: function(style, state)
    {
        if (!this.toolbarPlugin) {
            return;
        }

        if (state === 'active') {
            this.toolbarPlugin.setButtonActive(style);
            this.activeStyles.push(style);
        } else {
            this.toolbarPlugin.setButtonInactive(style);
        }

    },

    _canStyleNode: function(node)
    {
        if (dfx.isBlockElement(node) === true) {
            if (dfx.isTag(node, 'li') !== true) {
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
            } else if (dfx.isTag(data.lineage[i], 'u') === true) {
                activeStates.u = true;
            }
        }

        // If the selection is between multiple elements then find out if the range
        // start and end are in same style tags.
        var tagNames  = ['strong', 'em', 'u'];
        var states    = this._getActiveStates(data.range, tagNames);
        for (var i = 0; i < states.length; i++) {
            var tagName = states[i];
            if (tagName === 'strong') {
                activeStates.strong = true;
            } else if (tagName === 'em') {
                activeStates.em = true;
            } else if (tagName === 'u') {
                activeStates.u = true;
            }
        }

        var self = this;

        var buttonGroup = inlineToolbarPlugin.createButtonGroup();

        var bold = inlineToolbarPlugin.createButton('B', activeStates.strong, 'Bold', false, 'bold', function() {
            return self.handleStyle('strong');
        }, buttonGroup);
        var em = inlineToolbarPlugin.createButton('I', activeStates.em, 'Italic', false, 'italic', function() {
            return self.handleStyle('em');
        }, buttonGroup);
        var u = inlineToolbarPlugin.createButton('U', activeStates.u, 'Underline', false, 'underline', function() {
            return self.handleStyle('u');
        }, buttonGroup);

    },

    _updateToolbarButtonStates: function(buttons, range)
    {
        var startNode = range.getStartNode();

        if (this._canStyleNode(startNode) !== true) {
            for (var btn in buttons) {
                this.toolbarPlugin.disableButton(buttons[btn]);
            }

            return;
        }

        var tagNames = [];
        for (var btn in buttons.styles) {
            this.toolbarPlugin.enableButton(buttons.styles[btn]);
            this.toolbarPlugin.setButtonInactive(buttons.styles[btn]);
            tagNames.push(btn);
        }

        // Active states.
        var states = this._getActiveStates(range, tagNames);
        for (var i = 0; i < states.length; i++) {
            this.toolbarPlugin.setButtonActive(buttons.styles[states[i]]);
        }

        if (range.collapsed === false) {
            this.toolbarPlugin.enableButton(buttons.rmFormat);
        } else {
            this.toolbarPlugin.disableButton(buttons.rmFormat);
        }

        if (states.alignment) {
            var justify = states.alignment;
            for (var j in buttons.justify) {
                if (j === justify) {
                    this.toolbarPlugin.setButtonActive(buttons.justify[j]);
                } else {
                    this.toolbarPlugin.setButtonInactive(buttons.justify[j]);
                }
            }
        }

    },

    _getActiveStates: function(range, tagNames)
    {
        var activeStates = [];
        var startNode    = range.getStartNode();
        var endNode      = range.getEndNode();
        if (!endNode) {
            endNode = startNode;
        }

        if (startNode && endNode) {
            // Justify.
            var parent = startNode;
            if (dfx.isBlockElement(startNode) !== true) {
                parent = dfx.getFirstBlockParent(startNode);
            }

            if (endNode === parent
                || parent === dfx.getFirstBlockParent(endNode)
            ) {
                var alignment = dfx.getStyle(parent, 'text-align');
                if (alignment) {
                    activeStates.alignment = alignment;
                }
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
