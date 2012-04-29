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

    this.initInlineToolbar();
}

ViperLinkPlugin.prototype = {

    init: function()
    {
        this.initToolbar();
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

            var range = self.viper.getViperRange();
            if (range.collapsed !== true) {
                return;
            }

            var startNode = range.getStartNode();
            if (startNode.nodeType !== dfx.TEXT_NODE) {
                return;
            }

            // If the text node content up to the current caret position ends with
            // a URL then convert the text to an A tag.
            var text = startNode.data.substr(0, (range.startOffset - 1));
            var url  = text.match(/ ((http:\/\/|www\.)\S+)$/);
            if (!url) {
                return;
            }

            url        = url[1];
            var length = url.length;
            var a      = document.createElement('a');
            a.setAttribute('href', url);
            dfx.setHtml(a, url);

            var nextNode = startNode.splitText((range.startOffset - 1 - length));
            dfx.insertBefore(nextNode, a);

            nextNode.data = nextNode.data.slice(length);

            range.setStart(nextNode, 1);
            range.collapse(true);
            ViperSelection.addRange(range);
        });

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
        if (this.isEmail(url) === true) {
            url = 'mailto:' + url;
            var subject = this.viper.ViperTools.getItem(idPrefix + ':subject').getValue();
            if (subject) {
                url += '?subject=' + subject;
            }
        }

        link.setAttribute('href', url);

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

        if (node && node.nodeType === dfx.ELEMENT_NODE) {
            this.updateLinkAttributes(a, idPrefix);

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

                if (dfx.isTag(node, 'span') === true) {
                    // Replace the span tag with the link tag.
                    for (var i = 0; i < node.attributes.length; i++) {
                        a.setAttribute(node.attributes[i].nodeName, node.attributes[i].nodeValue)
                    }

                    dfx.insertBefore(node, a);
                    dfx.remove(node);
                } else {
                    node.appendChild(a);
                }
            }
        } else {
            var bookmark = this.viper.createBookmark();
            var elems    = dfx.getElementsBetween(bookmark.start, bookmark.end);
            var prevNode = null;
            for (var i = 0; i < elems.length; i++) {
                if (prevNode
                    && prevNode.nodeType === dfx.TEXT_NODE
                    && elems[i].nodeType === dfx.TEXT_NODE
                ) {
                    prevNode.data += elems[i].data;
                    dfx.remove(elems[i]);
                } else {
                    a.appendChild(elems[i]);
                }

                prevNode = elems[i];
            }

            this.updateLinkAttributes(a, idPrefix);

            dfx.insertBefore(bookmark.start, a);

            this.viper.removeBookmark(bookmark);
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
        this.viper.fireSelectionChanged(null, true);
        this.viper.fireNodesChanged();

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
        if (selectedNode && dfx.isTag(selectedNode, 'a') === true) {
            return selectedNode;
        }

        var viperElem = this.viper.getViperElement();
        var common    = range.getCommonElement();
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
        if (contents.toLowerCase().indexOf('<a') >= 0) {
            return true;
        }

        return false;

    },

    getToolbarContent: function(idPrefix)
    {
        var self  = this;
        var tools = this.viper.ViperTools;

        var attrUrl     = '';
        var attrTitle   = '';
        var attrSubj    = '';
        var attrTarget  = false;
        var isEmailLink = false;

        var range = this.viper.getViperRange();
        var link  = range.getNodeSelection();


        if (link && link.nodeType === dfx.ELEMENT_NODE) {
            if (dfx.isTag(link, 'a') !== true) {
                var parents = dfx.getSurroundingParents(link, 'a');
                if (parents.length > 0) {
                    link = parents[0];
                }
            }

            if (dfx.isTag(link, 'a') === true) {
                attrUrl   = link.getAttribute('href') || '';
                attrTitle = link.getAttribute('title') || '';

                if (link.getAttribute('target') === '_blank') {
                    attrTarget = true;
                }

                if (attrUrl.indexOf('mailto:') === 0) {
                    isEmailLink   = true;
                    var subjIndex = attrUrl.indexOf('?subject=');
                    if (subjIndex >= 0) {
                        attrSubj = attrUrl.substr(subjIndex + 9);
                        attrUrl  = attrUrl.substr(0, subjIndex).replace('mailto:', '');
                    }
                }
            }
        }

        var url       = tools.createTextbox(idPrefix + ':url', 'URL', attrUrl, null, true);
        var title     = tools.createTextbox(idPrefix + ':title', 'Title', attrTitle);
        var subject   = tools.createTextbox(idPrefix + ':subject', 'Subject', attrSubj);
        var newWindow = tools.createCheckbox(idPrefix + ':newWindow', 'Open a New Window', attrTarget);

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

        if (isEmailLink === true) {
            dfx.addClass(main, 'Viper-emailLink');
        } else {
            dfx.addClass(main, 'Viper-externalLink');
        }

        // URL field keyup event, when the url field is changed if the url is an
        // email address then show the email address related fields.
        tools.setFieldEvent(idPrefix + ':url', 'keyup', function(e) {
            var urlValue = this.value;
            if (self.isEmail(urlValue) === true) {
                // Show the subject field and hide the title field.
                dfx.removeClass(main, 'Viper-externalLink');
                dfx.addClass(main, 'Viper-emailLink');
            } else {
                dfx.removeClass(main, 'Viper-emailLink');
                dfx.addClass(main, 'Viper-externalLink');
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
            }

            data.toolbar.showButton('vitpInsertLink');
            data.toolbar.showButton('vitpRemoveLink');
        } else {
            data.toolbar.showButton('vitpInsertLink');
        }

    },

    showInlineToolbarIcons: function(data)
    {
        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');

        var self          = this;
        var range         = data.range;
        var currentIsLink = false;

        // Check if we need to show the link options.
        if (dfx.isTag(data.lineage[data.current], 'img') !== true && dfx.isBlockElement(data.lineage[data.current]) === true) {
            return false;
        }

        var startNode = data.range.getStartNode();
        var endNode   = data.range.getEndNode();
        if (startNode && endNode && startNode.parentNode !== endNode.parentNode) {
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
            && range.collapsed === true) {
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

            link = self.getLinkFromRange(range);

            if (link) {
                tools.setButtonActive('insertLink');
                tools.enableButton('removeLink');
                self.updateBubbleFields(link);
            } else {
                var nodeSelection = data.range.getNodeSelection();
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
                    && startNode.parentNode !== endNode.parentNode
                ) {
                    tools.disableButton('insertLink');
                    toolbar.closeBubble('ViperLinkPlugin:vtp:link');
                } else {
                    tools.enableButton('insertLink');
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
                    href    = href.substr(0, subjIndex).replace('mailto:', '');
                }
            }
        }

        var main = this.viper.ViperTools.getItem('ViperLinkPlugin:vtp:link').element;
        if (isEmailLink === true) {
            dfx.addClass(main, 'Viper-emailLink');
        } else {
            dfx.addClass(main, 'Viper-externalLink');
        }

        var tools = this.viper.ViperTools;
        tools.getItem('ViperLinkPlugin:vtp:url').setValue(href || '');
        tools.getItem('ViperLinkPlugin:vtp:title').setValue(title || '');
        tools.getItem('ViperLinkPlugin:vtp:subject').setValue(subject || '');
        tools.getItem('ViperLinkPlugin:vtp:newWindow').setValue(newWindow);
    }

};
