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

function ViperLinkPlugin(viper)
{
    this.viper = viper;
    this._autoLinkOpensInNewWindow = false;

    this.initToolbar();
    this.initInlineToolbar();
}

ViperLinkPlugin.prototype = {

    init: function()
    {
        this.enableAutoLink();

    },

    setSettings: function(settings)
    {
        if (!settings) {
            return;
        }

        if (settings.autoLinkOpensInNewWindow === true) {
            this._autoLinkOpensInNewWindow = true;
        } else {
            this._autoLinkOpensInNewWindow = false;
        }

    },


    enableAutoLink: function()
    {
        var self = this;
        this.viper.registerCallback('Viper:keyUp', 'ViperLinkPlugin', function(e) {
            // Listening for the space character.
            if (e.which !== 32) {
                return;
            }

            self._autoLink(false);

        });

        this.viper.registerCallback('ViperKeyboardEditorPlugin:beforeEnter', 'ViperLinkPlugin', function() {
            self._autoLink(true);
        });

    },

    _autoLink: function(isEnter)
    {
        var range = this.viper.getViperRange();
        if (range.collapsed !== true) {
            return;
        }

        var startNode = range.getStartNode();
        if (!startNode || startNode.nodeType !== ViperUtil.TEXT_NODE) {
            return;
        }

        var mod = 1;
        if (isEnter === true) {
            mod = 0;
        }

        // If the text node content up to the current caret position ends with
        // a URL then convert the text to an A tag.
        var text = startNode.data.substr(0, (range.startOffset - mod));
        var url  = text.match(/ ((http[s]?:\/\/|www\.)\S+)$/);
        if (!url) {
            url = text.match(/^((http[s]?:\/\/|www\.)\S+)$/);
            if (!url) {
                return;
            }
        }

        url        = url[1];
        var length = url.length;
        var a      = document.createElement('a');

        ViperUtil.setHtml(a, url);

        if (url.match(/^[^:]+(?=:\/\/)/) === null) {
            url = 'http://' + url;
        }

        a.setAttribute('href', url);

        if (this._autoLinkOpensInNewWindow === true) {
            a.setAttribute('target', '_blank');
        }

        var nextNode = startNode.splitText((range.startOffset - mod - length));
        ViperUtil.insertBefore(nextNode, a);

        nextNode.data = nextNode.data.slice(length);

        range.setStart(nextNode, mod);
        range.collapse(true);
        ViperSelection.addRange(range);

    },

    isEmail: function(url)
    {
        return this.validateEmail(url);

    },

    /**
     * Validates an email.
     *
     * Chose not to use a domain white list given .anything is on the way.  A feature
     * this regex currently does not support is <Name Part> of an email so add if
     * needed.
     *
     * @return boolean
     */
    validateEmail: function(email)
    {
        // add a simple check here to avoid heavy check below
        if(email.match(/@/g) === null)
            return false;

        var regExStr = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return regExStr.test(email);
    },

    updateLinkAttributes: function(link, idPrefix)
    {
         // Get the current values.
        var url       = ViperUtil.trim(this.viper.ViperTools.getItem(idPrefix + ':url').getValue());
        var title     = this.viper.ViperTools.getItem(idPrefix + ':title').getValue();
        var newWindow = this.viper.ViperTools.getItem(idPrefix + ':newWindow').getValue();

        // Check if its email link.
        if (this.isEmail(url.replace(/\s*mailto:\s*/i, '')) === true) {
            url = 'mailto:' + url.replace(/\s*mailto:\s*/i, '');
            var subject = this.viper.ViperTools.getItem(idPrefix + ':subject').getValue();
            if (subject) {
                url += '?subject=' + encodeURIComponent(subject);
            }
        }

        if (ViperUtil.isBrowser('msie') === true) {
            // IE for whatever reason, changed the content of the link to be the href
            // when its a mailto link.....
            var linkContent = ViperUtil.getHtml(link);
            this.viper.setAttribute(link, 'href', url);
            ViperUtil.setHtml(link, linkContent);
        } else {
            this.viper.setAttribute(link, 'href', url);
        }

        if (title) {
            this.viper.setAttribute(link, 'title', title);
        } else {
            link.removeAttribute('title');
        }

        if (newWindow === true) {
            this.viper.setAttribute(link, 'target', '_blank');
        } else {
            link.removeAttribute('target');
        }

    },

    updateLink: function(idPrefix)
    {
        var range = this.viper.getViperRange();
        var node  = range.getNodeSelection();

        if (ViperUtil.isTag(node, 'a') === false) {
            node = this.getLinkFromRange(range);
            if (!node) {
                return this.rangeToLink(idPrefix);
            } else {
                this.updateLinkAttributes(node, idPrefix);
            }
        } else {
            this.updateLinkAttributes(node, idPrefix);
        }

        range.selectNode(node);
        ViperSelection.addRange(range);

        this.viper.fireSelectionChanged(range, true);
        this.viper.fireNodesChanged([node]);

    },

    rangeToLink: function(idPrefix)
    {
        // Get the current values.
        var url = this.viper.ViperTools.getItem(idPrefix + ':url').getValue();
        if (!url) {
            return;
        }

        var range = this.viper.getViperRange();
        var node  = range.getNodeSelection();
        var a     = document.createElement('a');

        if (!node && ViperUtil.isBrowser('msie') === true) {
            // IE fix for Img selections.
            var prevSibling = range.startContainer.previousSibling;
            if (prevSibling
                && ViperUtil.isTag(prevSibling, 'img') === true
                && range.startOffset === 0
                && range.endOffset === 0
                && range.startContainer === range.endContainer
            ) {
                node = prevSibling;
            }
        }

        if (node && node.nodeType === ViperUtil.ELEMENT_NODE) {
            if (ViperUtil.isStubElement(node) === true
                || ViperUtil.isTag(node, 'ul') === true
                || ViperUtil.isTag(node, 'ol') === true
            ) {
                ViperUtil.insertBefore(node, a);
                a.appendChild(node);
            } else if (this.viper.isSpecialElement(node) === true) {
                ViperUtil.insertBefore(node, a);
                a.appendChild(node);
            } else {
                var prevNode = null;
                while (node.firstChild) {
                    var firstChild = node.firstChild;
                    if (prevNode
                        && prevNode.nodeType === ViperUtil.TEXT_NODE
                        && firstChild.nodeType === ViperUtil.TEXT_NODE
                    ) {
                        prevNode.data += firstChild.data;
                        ViperUtil.remove(firstChild);
                    } else {
                        a.appendChild(firstChild);
                    }

                    prevNode = firstChild;
                }

                if (ViperUtil.isTag(node, 'span') === true && this.viper.isViperHighlightElement(node) === false) {
                    // Replace the span tag with the link tag, make sure its not the
                    // Viper highlight element, if it is dont copy its attributes.
                    for (var i = 0; i < node.attributes.length; i++) {
                        a.setAttribute(node.attributes[i].nodeName, node.attributes[i].nodeValue)
                    }

                    ViperUtil.insertBefore(node, a);
                    ViperUtil.remove(node);
                } else {
                    node.appendChild(a);
                }
            }

            this.updateLinkAttributes(a, idPrefix);
        } else {
            a = this.viper.surroundContents('a', null, range);
            this.updateLinkAttributes(a, idPrefix);
        }

        range.selectNode(a);
        ViperSelection.addRange(range);

        this.viper.fireSelectionChanged(range, true);
        this.viper.fireNodesChanged([this.viper.getViperElement()]);

        return a;

    },

    removeLink: function(linkTag)
    {
        if (!linkTag || !linkTag.parentNode) {
            return;
        }

        var bookmark = this.viper.createBookmark();

        var firstChild = linkTag.firstChild;
        var lastChild  = linkTag.lastChild;

        while (linkTag.firstChild) {
            ViperUtil.insertBefore(linkTag, linkTag.firstChild);
        }

        ViperUtil.remove(linkTag);

        this.viper.selectBookmark(bookmark);

        var self = this;
        setTimeout(function() {
            self.viper.fireSelectionChanged(null, true);
            self.viper.fireNodesChanged();
        }, 10);


    },

    removeLinks: function()
    {
        var range    = this.viper.getViperRange();
        var nodeSelection = range.getNodeSelection();
        if (nodeSelection) {
            var links = ViperUtil.getTag('a', nodeSelection);
            var c     = links.length;
            for (var i = 0; i < c; i++) {
                var elem = links[i];
                while (elem.firstChild) {
                    if (elem.firstChild.nodeType == ViperUtil.TEXT_NODE
                        && elem.previousSibling
                        && elem.previousSibling.nodeType === ViperUtil.TEXT_NODE
                    ) {
                        elem.previousSibling.data += elem.firstChild.data;
                        ViperUtil.remove(elem.firstChild);
                    } else {
                        ViperUtil.insertBefore(elem, elem.firstChild);
                    }
                }

                ViperUtil.remove(elem);
            }

            range.selectNode(nodeSelection);
            ViperSelection.addRange(range);
            this.viper.fireSelectionChanged(range, true);
        } else {
            var bookmark = this.viper.createBookmark();
            var elems = ViperUtil.getElementsBetween(bookmark.start, bookmark.end);

            ViperUtil.walk(bookmark.start, function(elem) {
                if (elem.nodeType === ViperUtil.ELEMENT_NODE && ViperUtil.isTag(elem, 'a') === true) {
                    var nextSibling = elem.firstChild;
                    while (elem.lastChild) {
                        ViperUtil.insertAfter(elem, elem.lastChild);
                    }

                    ViperUtil.remove(elem);

                    return nextSibling;
                }
            }, bookmark.end);

            this.viper.selectBookmark(bookmark);
            this.viper.fireSelectionChanged(null, true);
        }//end if

        this.viper.fireNodesChanged([this.viper.getViperElement()]);

    },

    getLinkFromRange: function(range)
    {
        range = range || this.viper.getViperRange();

        var selectedNode = range.getNodeSelection();
        var startNode    = range.getStartNode();
        var common       = range.getCommonElement();
        if (!selectedNode && ViperUtil.isBrowser('msie') === true) {
            var startNode = range.getStartNode();
            if (range.startContainer === range.endContainer
                && range.startOffset === 0
                && range.endOffset === 0
                && range.startContainer.nodeType === ViperUtil.TEXT_NODE
                && range.startContainer.previousSibling
                && ViperUtil.isTag(range.startContainer.previousSibling, 'img') === true
            ) {
                startNode = range.startContainer.previousSibling;
                common    = startNode.parentNode;
                range.selectNode(startNode);
                ViperSelection.addRange(range);
            } else if (startNode
                && startNode.nodeType === ViperUtil.TEXT_NODE
                && !range.getEndNode()
                && range.endContainer.nodeType === ViperUtil.ELEMENT_NODE
                && range.endOffset >= range.endContainer.childNodes.length
            ) {
                // When the A tag is the last element in a P tag and only last few characters of the link is selected
                // IE thinks this is not inside the link tag.
                var lastChild = range.endContainer.childNodes[(range.endContainer.childNodes.length - 1)];
                if (lastChild
                    && ViperUtil.isTag(lastChild, 'a') === true
                    && ViperUtil.isChildOf(startNode, lastChild) === true
                ) {
                    return lastChild;
                }
            } else if (range.collapsed === true
                && range.startOffset === 0
                && range.startContainer.previousSibling
                && (ViperUtil.isTag(range.startContainer.previousSibling, 'a') === true
                || ViperUtil.inArray('a', ViperUtil.getSurroundedChildren(range.startContainer.previousSibling, true)) === true)
            ) {
                return range.startContainer.previousSibling;
            } else if (range.startContainer.nodeType === ViperUtil.ELEMENT_NODE
                && range.startOffset >= range.startContainer.childNodes.length
                && ViperUtil.isTag(range.startContainer.childNodes[range.startOffset - 1], 'a') === true
            ) {
                return range.startContainer.childNodes[range.startOffset - 1];
            }
        }

        if (selectedNode && ViperUtil.isTag(selectedNode, 'a') === true) {
            return selectedNode;
        }

        var viperElem = this.viper.getViperElement();

        while (common) {
            if (ViperUtil.isTag(common, 'a') === true) {
                return common;
            } else if (common === viperElem || ViperUtil.isBlockElement(common) === true) {
                break;
            }

            common = common.parentNode;
        }

        return null;

    },

    selectionHasLinks: function(range)
    {
        range = range || this.viper.getViperRange();

        if (range.collapsed === true) {
            return false;
        }

        var nodeSelection = range.getNodeSelection();
        if (nodeSelection && ViperUtil.isTag(nodeSelection, 'a') === true) {
            // Let the getLinkFromRange handle this.
            return false;
        }

        var contents = range.getHTMLContents();
        if (contents.toLowerCase().indexOf('<a ') >= 0) {
            if (ViperUtil.isBrowser('msie') === true) {
                var startNode = range.getStartNode();
                var endNode   = range.getEndNode();
                if (startNode
                    && !endNode
                    && startNode.nodeType === ViperUtil.TEXT_NODE
                    && range.endContainer.nodeType === ViperUtil.ELEMENT_NODE
                    && range.endOffset >= range.endContainer.childNodes.length
                    && ViperUtil.isChildOf(startNode, range.endContainer.childNodes[(range.endContainer.childNodes.length - 1)]) === true
                ) {
                    // When the A tag is the last element in a P tag and only last few characters of the link is selected
                    // IE thinks this is not inside the link tag.
                    return false;
                }
            }

            return true;
        }

        return false;

    },

    getToolbarContent: function(idPrefix)
    {
        var self      = this;
        var tools     = this.viper.ViperTools;
        var url       = tools.createTextbox(idPrefix + ':url', _('URL'), '', null, true);
        var title     = tools.createTextbox(idPrefix + ':title', _('Title'), '');
        var subject   = tools.createTextbox(idPrefix + ':subject', _('Subject'), '');
        var newWindow = tools.createCheckbox(idPrefix + ':newWindow', _('Open a New Window'));

        var urlRow = tools.createRow(idPrefix + ':urlRow', 'Viper-urlRow');
        urlRow.appendChild(url);

        var titleRow = tools.createRow(idPrefix + ':titleRow', 'Viper-titleRow');
        titleRow.appendChild(title);

        var subjectRow = tools.createRow(idPrefix + ':subjectRow', 'Viper-subjectRow');
        subjectRow.appendChild(subject);

        var newWindowRow = tools.createRow(idPrefix + ':newWindowRow', 'Viper-newWindowRow');
        newWindowRow.appendChild(newWindow);

        var main = document.createElement('div');
        main.appendChild(urlRow);
        main.appendChild(titleRow);
        main.appendChild(subjectRow);
        main.appendChild(newWindowRow);

        var subSectionElem = this.viper.ViperTools.getItem(idPrefix + ':link').element;
        ViperUtil.addClass(subSectionElem, 'Viper-externalLink');

        // URL field changed event, when the url field is changed if the url is an
        // email address then show the email address related fields.
        this.viper.registerCallback('ViperTools:changed:' + idPrefix + ':url', 'ViperLinkPlugin', function() {
            var urlValue = ViperUtil.trim(tools.getItem(idPrefix + ':url').getValue());
            if (urlValue.toLowerCase().indexOf('mailto:') === 0 || self.isEmail(urlValue) === true) {
                // Show the subject field and hide the title field.
                ViperUtil.removeClass(subSectionElem, 'Viper-externalLink');
                ViperUtil.addClass(subSectionElem, 'Viper-emailLink');
            } else {
                ViperUtil.removeClass(subSectionElem, 'Viper-emailLink');
                ViperUtil.addClass(subSectionElem, 'Viper-externalLink');
            }
        });

        return main;

    },

    initInlineToolbar: function()
    {
        var self = this;
        this.viper.registerCallback('ViperInlineToolbarPlugin:initToolbar', 'ViperLinkPlugin', function(toolbar) {
            self.createInlineToolbar(toolbar);
        });
        this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperLinkPlugin', function(data) {
            var selectionHasLinks = self.selectionHasLinks(data.range);
            if (selectionHasLinks !== true && self.showInlineToolbarIcons(data) === true) {
                self.updateInlineToolbar(data);
            } else if (selectionHasLinks === true) {
                self.updateInlineToolbar(data, true);
            }
        });

    },

    createInlineToolbar: function(toolbar)
    {
        var self = this;
        var main = document.createElement('div');

        toolbar.addKeepOpenTag('a');

        toolbar.makeSubSection('ViperLinkPlugin:vitp:link', main, function() {
            var range = self.viper.getViperRange();
            var node  = self.getLinkFromRange(range);
            if (node) {
                range.selectNode(node);
                ViperSelection.addRange(range);
                self.viper.fireSelectionChanged(range);
            }
        });

        var insertLinkBtn = this.viper.ViperTools.createButton('vitpInsertLink', '', _('Toggle Link Options'), 'Viper-link');
        var removeLinkBtn = this.viper.ViperTools.createButton('vitpRemoveLink', '', _('Remove Link'), 'Viper-linkRemove', function() {
            var range = self.viper.getViperRange();
            var link  = self.getLinkFromRange(range);
            if (!link) {
                self.removeLinks();
            } else {
                self.removeLink(link);
            }
        });

        var btnGroup = this.viper.ViperTools.createButtonGroup('ViperLinkPlugin:vitpButtons');
        this.viper.ViperTools.addButtonToGroup('vitpInsertLink', 'ViperLinkPlugin:vitpButtons');
        this.viper.ViperTools.addButtonToGroup('vitpRemoveLink', 'ViperLinkPlugin:vitpButtons');
        toolbar.addButton(btnGroup);

        toolbar.setSubSectionButton('vitpInsertLink', 'ViperLinkPlugin:vitp:link');

        main.appendChild(this.getToolbarContent('ViperLinkPlugin:vitp'));

        toolbar.setSubSectionAction('ViperLinkPlugin:vitp:link', function() {
            self.updateLink('ViperLinkPlugin:vitp');
        }, ['ViperLinkPlugin:vitp:url', 'ViperLinkPlugin:vitp:title', 'ViperLinkPlugin:vitp:newWindow', 'ViperLinkPlugin:vitp:subject']);

    },

    updateInlineToolbar: function(data, removeLinkOnly)
    {
        if (removeLinkOnly === true) {
            data.toolbar.showButton('vitpRemoveLink');
            return;
        }

        var link = this.getLinkFromRange(data.range);
        if (link || this.selectionHasLinks(data.range) === true) {
            if (link) {
                this.viper.ViperTools.setButtonActive('vitpInsertLink');
                this.updateInlineToolbarFields(link);
            } else {
                this.updateInlineToolbarFields();
            }

            data.toolbar.showButton('vitpInsertLink');
            data.toolbar.showButton('vitpRemoveLink');
        } else {
            data.toolbar.showButton('vitpInsertLink');
            this.updateInlineToolbarFields(link);
        }

    },

    showInlineToolbarIcons: function(data)
    {
        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');

        var self          = this;
        var range         = data.range;
        var currentIsLink = false;
        var startNode     = null;
        var endNode       = null;
        var nodeSelection = range.getNodeSelection();

        if (nodeSelection) {
            startNode = nodeSelection;
            endNode   = startNode;
        } else {
            startNode = data.range.getStartNode();
            endNode   = data.range.getEndNode();
        }

        if (startNode
            && endNode
            && ViperUtil.getFirstBlockParent(startNode) !== ViperUtil.getFirstBlockParent(endNode)
        ) {
            return false;
        }

        if (ViperUtil.isTag(data.lineage[data.current], 'a') === true) {
            // If the selection is a whole A tag then by default show the
            // link sub section.
            currentIsLink    = true;
        }

        if (currentIsLink !== true
            && (data.lineage[data.current].nodeType !== ViperUtil.TEXT_NODE
            || ViperUtil.isTag(data.lineage[data.current].parentNode, 'a') === false)
            && range.collapsed === true
        ) {
            if (range.collapsed === true && data.lineage[data.current].nodeType === ViperUtil.TEXT_NODE) {
                var parents = ViperUtil.getParents(data.lineage[data.current].parentNode, 'a', this.viper.getViperElement());
                if (parents.length > 0
                    || (range.startOffset === 0 && range.startContainer.previousSibling && ViperUtil.isTag(range.startContainer.previousSibling, 'a') === true)
                ) {
                    return true;
                } else if (range.collapsed === true
                    && range.startOffset === 0
                    && range.startContainer.previousSibling
                    && (ViperUtil.isTag(range.startContainer.previousSibling, 'a') === true
                    || ViperUtil.inArray('a', ViperUtil.getSurroundedChildren(range.startContainer.previousSibling, true)) === true)
                ) {
                    return true;
                } else {
                    debugger;
                }
            } else if (range.collapsed === true
                && range.startContainer.nodeType === ViperUtil.ELEMENT_NODE
                && range.startOffset >= range.startContainer.childNodes.length
                && ViperUtil.isTag(range.startContainer.childNodes[range.startOffset - 1], 'a') === true
            ) {
                return true;
            }

            return false;
        }

        return true;

    },

    initToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        // Add the Insert Link and Remove Link buttons to the toolbar.
        var tools    = this.viper.ViperTools;
        var btnGroup = tools.createButtonGroup('ViperLinkPlugin:vtp:btnGroup');
        var disabled = true;
        var self     = this;

        tools.createButton('insertLink', '', _('Toggle Link Options'), 'Viper-link', null, disabled);
        tools.createButton('removeLink', '', _('Remove Link'), 'Viper-linkRemove', function() {
            if (self.selectionHasLinks() === true) {
                self.removeLinks();
            } else {
                var link = self.getLinkFromRange();
                self.removeLink(link);
            }
        }, disabled);

        tools.addButtonToGroup('insertLink', 'ViperLinkPlugin:vtp:btnGroup');
        tools.addButtonToGroup('removeLink', 'ViperLinkPlugin:vtp:btnGroup');
        toolbar.addButton(btnGroup);

        var main = document.createElement('div');
        toolbar.createBubble('ViperLinkPlugin:vtp:link', _('Insert Link'), main, null, function() {
            var range = self.viper.getViperRange();
            var node  = self.getLinkFromRange(range);
            if (node) {
                range.selectNode(node);
                ViperSelection.addRange(range);
                self.viper.fireSelectionChanged(range);
            }
        });
        main.appendChild(this.getToolbarContent('ViperLinkPlugin:vtp'));
        toolbar.setBubbleButton('ViperLinkPlugin:vtp:link', 'insertLink');
        tools.getItem('ViperLinkPlugin:vtp:link').setSubSectionAction('ViperLinkPlugin:vtp:linkSubSection', function() {
            self.updateLink('ViperLinkPlugin:vtp');
        }, ['ViperLinkPlugin:vtp:url', 'ViperLinkPlugin:vtp:title', 'ViperLinkPlugin:vtp:newWindow', 'ViperLinkPlugin:vtp:subject']);

        // Update the buttons when the toolbar updates it self.
        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperLinkPlugin', function(data) {
            var range = data.range;

            if (self.viper.rangeInViperBounds(range) === false) {
                return;
            }

            var selectionHasLinks = self.selectionHasLinks(range);

            if (selectionHasLinks === true) {
                tools.setButtonInactive('insertLink');
                tools.disableButton('insertLink');
                tools.enableButton('removeLink');
                return;
            }

            var link = self.getLinkFromRange(range);

            if (link) {
                tools.setButtonActive('insertLink');
                tools.enableButton('removeLink');
                self.updateBubbleFields(link);
            } else {
                var nodeSelection = self.viper.getNodeSelection();
                var startNode     = null;
                var endNode       = null;

                if (nodeSelection) {
                    startNode = nodeSelection;
                    endNode   = nodeSelection;
                } else {
                    startNode = data.range.getStartNode();
                    endNode   = data.range.getEndNode();
                }

                tools.setButtonInactive('insertLink');

                if (range.collapsed === true
                    || startNode
                    && endNode
                    && ViperUtil.getFirstBlockParent(startNode) !== ViperUtil.getFirstBlockParent(endNode)
                ) {
                    tools.disableButton('insertLink');
                    toolbar.closeBubble('ViperLinkPlugin:vtp:link');
                } else {
                    if (nodeSelection
                        && nodeSelection.nodeType === ViperUtil.ELEMENT_NODE
                        && ViperUtil.inArray(ViperUtil.getTagName(nodeSelection), ('tr,table,thead,tfoot'.split(',')))
                    ) {
                        tools.disableButton('insertLink');
                    } else {
                        tools.enableButton('insertLink');
                    }
                }

                tools.disableButton('removeLink');
                self.updateBubbleFields();
            }//end if
        });

    },

    updateBubbleFields: function(link)
    {
        var href        = '';
        var title       = '';
        var subject     = '';
        var newWindow   = false;
        var isEmailLink = false;

        if (link) {
            href  = this.viper.getAttribute(link, 'href');
            title = this.viper.getAttribute(link, 'title');

            if (link.getAttribute('target') === '_blank') {
                newWindow = true;
            }

            if (href) {
                if (href.indexOf('mailto:') === 0) {
                    isEmailLink   = true;
                    var subjIndex = href.indexOf('?subject=');
                    if (subjIndex >= 0) {
                        subject = href.substr(subjIndex + 9);
                        href    = href.substr(0, subjIndex);
                    }

                    href = href.replace(/\s*mailto:\s*/i, '');
                }
            }
        }

        var main = this.viper.ViperTools.getItem('ViperLinkPlugin:vtp:link').element;
        if (isEmailLink === true) {
            ViperUtil.addClass(main, 'Viper-emailLink');
            ViperUtil.removeClass(main, 'Viper-externalLink');
        } else {
            ViperUtil.addClass(main, 'Viper-externalLink');
            ViperUtil.removeClass(main, 'Viper-emailLink');
        }

        var tools = this.viper.ViperTools;
        tools.getItem('ViperLinkPlugin:vtp:url').setValue(href || '');
        tools.getItem('ViperLinkPlugin:vtp:title').setValue(title || '');
        tools.getItem('ViperLinkPlugin:vtp:subject').setValue(decodeURIComponent(subject) || '');
        tools.getItem('ViperLinkPlugin:vtp:newWindow').setValue(newWindow);
    },

    updateInlineToolbarFields: function(link)
    {
        var href        = '';
        var title       = '';
        var subject     = '';
        var newWindow   = false;
        var isEmailLink = false;

        if (link) {
            href  = this.viper.getAttribute(link, 'href');
            title = this.viper.getAttribute(link, 'title');

            if (link.getAttribute('target') === '_blank') {
                newWindow = true;
            }

            if (href) {
                if (href.indexOf('mailto:') === 0) {
                    isEmailLink   = true;
                    var subjIndex = href.indexOf('?subject=');
                    if (subjIndex >= 0) {
                        subject = href.substr(subjIndex + 9);
                        href    = href.substr(0, subjIndex);
                    }

                    href = href.replace(/\s*mailto:\s*/i, '');
                }
            }
        }

        var main = this.viper.ViperTools.getItem('ViperLinkPlugin:vitp:link').element;
        if (isEmailLink === true) {
            ViperUtil.addClass(main, 'Viper-emailLink');
            ViperUtil.removeClass(main, 'Viper-externalLink');
        } else {
            ViperUtil.addClass(main, 'Viper-externalLink');
            ViperUtil.removeClass(main, 'Viper-emailLink');
        }

        var tools = this.viper.ViperTools;
        tools.getItem('ViperLinkPlugin:vitp:url').setValue(href || '');
        tools.getItem('ViperLinkPlugin:vitp:title').setValue(title || '');
        tools.getItem('ViperLinkPlugin:vitp:subject').setValue(decodeURIComponent(subject) || '');
        tools.getItem('ViperLinkPlugin:vitp:newWindow').setValue(newWindow);

    }

};
