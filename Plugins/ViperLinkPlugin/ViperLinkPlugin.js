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

    this.initToolbar();
    this.initInlineToolbar();
}

ViperLinkPlugin.prototype = {

    init: function()
    {
        this.enableAutoLink();

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
        if (startNode.nodeType !== dfx.TEXT_NODE) {
            return;
        }

        var mod = 1;
        if (isEnter === true) {
            mod = 0;
        }

        // If the text node content up to the current caret position ends with
        // a URL then convert the text to an A tag.
        var text = startNode.data.substr(0, (range.startOffset - mod));
        var url  = text.match(/ ((http:\/\/|www\.)\S+)$/);
        if (!url) {
            url = text.match(/^((http:\/\/|www\.)\S+)$/);
            if (!url) {
                return;
            }
        }

        url        = url[1];
        var length = url.length;
        var a      = document.createElement('a');

        dfx.setHtml(a, url);

        if (url.match(/^[^:]+(?=:\/\/)/) === null) {
            url = 'http://' + url;
        }

        a.setAttribute('href', url);

        var nextNode = startNode.splitText((range.startOffset - mod - length));
        dfx.insertBefore(nextNode, a);

        nextNode.data = nextNode.data.slice(length);

        range.setStart(nextNode, mod);
        range.collapse(true);
        ViperSelection.addRange(range);

    },

    isEmail: function(url)
    {
        return dfx.validateEmail(url);

    },

    updateLinkAttributes: function(link, idPrefix)
    {
         // Get the current values.
        var url       = this.viper.ViperTools.getItem(idPrefix + ':url').getValue();
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

        if (this.viper.isBrowser('msie') === true) {
            // IE for whatever reason, changed the content of the link to be the href
            // when its a mailto link.....
            var linkContent = dfx.getHtml(link);
            link.setAttribute('href', url);
            dfx.setHtml(link, linkContent);
        } else {
            link.setAttribute('href', url);
        }

        if (title) {
            link.setAttribute('title', title);
        } else {
            link.removeAttribute('title');
        }

        if (newWindow === true) {
            link.setAttribute('target', '_blank');
        } else {
            link.removeAttribute('target');
        }

    },

    updateLink: function(idPrefix)
    {
        var range = this.viper.getViperRange();
        var node  = range.getNodeSelection();

        if (dfx.isTag(node, 'a') === false) {
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

        if (!node && this.viper.isBrowser('msie') === true) {
            // IE fix for Img selections.
            var prevSibling = range.startContainer.previousSibling;
            if (prevSibling
                && dfx.isTag(prevSibling, 'img') === true
                && range.startOffset === 0
                && range.endOffset === 0
                && range.startContainer === range.endContainer
            ) {
                node = prevSibling;
            }
        }

        if (node && node.nodeType === dfx.ELEMENT_NODE) {
            if (dfx.isStubElement(node) === true) {
                dfx.insertBefore(node, a);
                a.appendChild(node);
            } else {
                var prevNode = null;
                while (node.firstChild) {
                    var firstChild = node.firstChild;
                    if (prevNode
                        && prevNode.nodeType === dfx.TEXT_NODE
                        && firstChild.nodeType === dfx.TEXT_NODE
                    ) {
                        prevNode.data += firstChild.data;
                        dfx.remove(firstChild);
                    } else {
                        a.appendChild(firstChild);
                    }

                    prevNode = firstChild;
                }

                if (dfx.isTag(node, 'span') === true && this.viper.isViperHighlightElement(node) === false) {
                    // Replace the span tag with the link tag, make sure its not the
                    // Viper highlight element, if it is dont copy its attributes.
                    for (var i = 0; i < node.attributes.length; i++) {
                        a.setAttribute(node.attributes[i].nodeName, node.attributes[i].nodeValue)
                    }

                    dfx.insertBefore(node, a);
                    dfx.remove(node);
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
            dfx.insertBefore(linkTag, linkTag.firstChild);
        }

        dfx.remove(linkTag);

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
            var links = dfx.getTag('a', nodeSelection);
            var c     = links.length;
            for (var i = 0; i < c; i++) {
                var elem = links[i];
                while (elem.firstChild) {
                    if (elem.firstChild.nodeType == dfx.TEXT_NODE
                        && elem.previousSibling
                        && elem.previousSibling.nodeType === dfx.TEXT_NODE
                    ) {
                        elem.previousSibling.data += elem.firstChild.data;
                        dfx.remove(elem.firstChild);
                    } else {
                        dfx.insertBefore(elem, elem.firstChild);
                    }
                }

                dfx.remove(elem);
            }

            range.selectNode(nodeSelection);
            ViperSelection.addRange(range);
            this.viper.fireSelectionChanged(range, true);
        } else {
            var bookmark = this.viper.createBookmark();
            var elems = dfx.getElementsBetween(bookmark.start, bookmark.end);

            dfx.walk(bookmark.start, function(elem) {
                if (elem.nodeType === dfx.ELEMENT_NODE && dfx.isTag(elem, 'a') === true) {
                    var nextSibling = elem.firstChild;
                    while (elem.lastChild) {
                        dfx.insertAfter(elem, elem.lastChild);
                    }

                    dfx.remove(elem);

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
        var common       = range.getCommonElement();
        if (!selectedNode && this.viper.isBrowser('msie') === true) {
            if (range.startContainer === range.endContainer
                && range.startOffset === 0
                && range.endOffset === 0
                && range.startContainer.nodeType === dfx.TEXT_NODE
                && range.startContainer.previousSibling
                && dfx.isTag(range.startContainer.previousSibling, 'img') === true
            ) {
                startNode = range.startContainer.previousSibling;
                common    = startNode.parentNode;
                range.selectNode(startNode);
                ViperSelection.addRange(range);
            }
        }

        if (selectedNode && dfx.isTag(selectedNode, 'a') === true) {
            return selectedNode;
        }

        var viperElem = this.viper.getViperElement();

        while (common) {
            if (dfx.isTag(common, 'a') === true) {
                return common;
            } else if (common === viperElem || dfx.isBlockElement(common) === true) {
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
        if (nodeSelection && dfx.isTag(nodeSelection, 'a') === true) {
            // Let the getLinkFromRange handle this.
            return false;
        }

        var contents = range.getHTMLContents();
        if (contents.toLowerCase().indexOf('<a ') >= 0) {
            return true;
        }

        return false;

    },

    getToolbarContent: function(idPrefix)
    {
        var self      = this;
        var tools     = this.viper.ViperTools;
        var url       = tools.createTextbox(idPrefix + ':url', 'URL', '', null, true);
        var title     = tools.createTextbox(idPrefix + ':title', 'Title', '');
        var subject   = tools.createTextbox(idPrefix + ':subject', 'Subject', '');
        var newWindow = tools.createCheckbox(idPrefix + ':newWindow', 'Open a New Window');

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
        dfx.addClass(subSectionElem, 'Viper-externalLink');

        // URL field changed event, when the url field is changed if the url is an
        // email address then show the email address related fields.
        this.viper.registerCallback('ViperTools:changed:' + idPrefix + ':url', 'ViperLinkPlugin', function() {
            var urlValue = tools.getItem(idPrefix + ':url').getValue();
            if (urlValue.toLowerCase().indexOf('mailto:') === 0 || self.isEmail(urlValue) === true) {
                // Show the subject field and hide the title field.
                dfx.removeClass(subSectionElem, 'Viper-externalLink');
                dfx.addClass(subSectionElem, 'Viper-emailLink');
            } else {
                dfx.removeClass(subSectionElem, 'Viper-emailLink');
                dfx.addClass(subSectionElem, 'Viper-externalLink');
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

        var insertLinkBtn = this.viper.ViperTools.createButton('vitpInsertLink', '', 'Toggle Link Options', 'Viper-link');
        var removeLinkBtn = this.viper.ViperTools.createButton('vitpRemoveLink', '', 'Remove Link', 'Viper-linkRemove', function() {
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

        // Check if we need to show the link options.
        if ((dfx.isTag(data.lineage[data.current], 'img') !== true
            && dfx.isBlockElement(data.lineage[data.current]) === true)
            || ('thead,tfoot'.split(',')).inArray(dfx.getTagName(data.lineage[data.current])) === true
        ) {
            return false;
        }

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
            && dfx.getFirstBlockParent(startNode) !== dfx.getFirstBlockParent(endNode)
        ) {
            return false;
        }

        if (dfx.isTag(data.lineage[data.current], 'a') === true) {
            // If the selection is a whole A tag then by default show the
            // link sub section.
            currentIsLink    = true;
        }

        if (currentIsLink !== true
            && (data.lineage[data.current].nodeType !== dfx.TEXT_NODE
            || dfx.isTag(data.lineage[data.current].parentNode, 'a') === false)
            && range.collapsed === true
        ) {
            if (range.collapsed === true && data.lineage[data.current].nodeType === dfx.TEXT_NODE) {
                var parents = dfx.getParents(data.lineage[data.current].parentNode, 'a');
                if (parents.length > 0) {
                    return true;
                }
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

        tools.createButton('insertLink', '', 'Toggle Link Options', 'Viper-link', null, disabled);
        tools.createButton('removeLink', '', 'Remove Link', 'Viper-linkRemove', function() {
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
        toolbar.createBubble('ViperLinkPlugin:vtp:link', 'Insert Link', main, null, function() {
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

            var selectionHasLinks = self.selectionHasLinks(range);
            if (selectionHasLinks === true) {
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
                    && dfx.getFirstBlockParent(startNode) !== dfx.getFirstBlockParent(endNode)
                ) {
                    tools.disableButton('insertLink');
                    toolbar.closeBubble('ViperLinkPlugin:vtp:link');
                } else {
                    if (nodeSelection
                        && nodeSelection.nodeType === dfx.ELEMENT_NODE
                        && ('tr,table,thead,tfoot'.split(',')).inArray(dfx.getTagName(nodeSelection))
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
            href  = link.getAttribute('href');
            title = link.getAttribute('title');

            if (link.getAttribute('target') === '_blank') {
                newWindow = true;
            }

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

        var main = this.viper.ViperTools.getItem('ViperLinkPlugin:vtp:link').element;
        if (isEmailLink === true) {
            dfx.addClass(main, 'Viper-emailLink');
            dfx.removeClass(main, 'Viper-externalLink');
        } else {
            dfx.addClass(main, 'Viper-externalLink');
            dfx.removeClass(main, 'Viper-emailLink');
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
            href  = link.getAttribute('href');
            title = link.getAttribute('title');

            if (link.getAttribute('target') === '_blank') {
                newWindow = true;
            }

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

        var main = this.viper.ViperTools.getItem('ViperLinkPlugin:vitp:link').element;
        if (isEmailLink === true) {
            dfx.addClass(main, 'Viper-emailLink');
            dfx.removeClass(main, 'Viper-externalLink');
        } else {
            dfx.addClass(main, 'Viper-externalLink');
            dfx.removeClass(main, 'Viper-emailLink');
        }

        var tools = this.viper.ViperTools;
        tools.getItem('ViperLinkPlugin:vitp:url').setValue(href || '');
        tools.getItem('ViperLinkPlugin:vitp:title').setValue(title || '');
        tools.getItem('ViperLinkPlugin:vitp:subject').setValue(decodeURIComponent(subject) || '');
        tools.getItem('ViperLinkPlugin:vitp:newWindow').setValue(newWindow);

    }

};
