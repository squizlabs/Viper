/**
 * JS Class for the ViperLinkPlugin.
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
 * @package    Viper
 * @author     Squiz Pty Ltd <products@squiz.net>
 * @copyright  2010 Squiz Pty Ltd (ACN 084 670 600)
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPLv2
 */

function ViperLinkPlugin(viper)
{
    this.viper = viper;

}

ViperLinkPlugin.prototype = {

    init: function()
    {
        this.initInlineToolbar();
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
        return /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(url);

    },


    rangeToLink: function(url, title, subject)
    {
        if (!url) {
            return;
        }

        var range    = this.viper.getViperRange();
        var bookmark = this.viper.createBookmark(range);

        var a = document.createElement('a');

        // Check if its email link.
        var isEmail = this.isEmail(url);

        if (isEmail === true) {
            url = 'mailto:' + url;
            if (subject) {
                url += '?subject=' + subject;
            }
        }

        a.setAttribute('href', url);

        if (title) {
            a.setAttribute('title', title);
        }

        var elems = dfx.getElementsBetween(bookmark.start, bookmark.end);
        for (var i = 0; i < elems.length; i++) {
            a.appendChild(elems[i]);
        }

        dfx.insertBefore(bookmark.start, a);

        this.viper.removeBookmark(bookmark);
        range.selectNode(a);
        ViperSelection.addRange(range);

        this.viper.fireSelectionChanged(range, true);
        this.viper.fireNodesChanged([this.viper.getViperElement()]);

        return a;

    },

    removeLink: function(linkTag)
    {
        if (!linkTag && linkTag.parentNode) {
            return;
        }

        var firstChild = linkTag.firstChild;
        var lastChild  = linkTag.lastChild;

        while (linkTag.firstChild) {
            this.viper.insertBefore(linkTag, linkTag.firstChild);
        }

        dfx.remove(linkTag);

        var range = this.viper.getViperRange();
        range.setStart(firstChild, 0);
        range.setEnd(lastChild, lastChild.data.length);
        ViperSelection.addRange(range);
        this.viper.fireSelectionChanged(range, true);
        this.viper.fireNodesChanged([this.viper.getViperElement()]);

    },

    setLinkTitle: function(link, title)
    {
        if (!link) {
            return;
        }

        link.setAttribute('title', title);

    },

    setLinkURL: function(link, url, subject)
    {
        if (!link) {
            return;
        }

        // Check if its email link.
        var isEmail = this.isEmail(url);

        if (isEmail === true) {
            url = 'mailto:' + url;
            if (subject) {
                url += '?subject=' + subject;
            }
        }

        link.setAttribute('href', url);

    },

    getLinkFromRange: function(range)
    {
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

    initInlineToolbar: function()
    {
        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');
        if (!inlineToolbarPlugin) {
            return;
        }

        var self = this;
        this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperLinkPlugin', function(data) {
            self.updateInlineToolbar(data);
        });
    },

    updateInlineToolbar: function(data)
    {
        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');

        var self          = this;
        var range         = data.range;
        var currentIsLink = false;

        // Check if we need to show the link options.
        if (dfx.isBlockElement(data.lineage[data.current]) === true) {
            return;
        }

        var startNode = data.range.getStartNode();
        var endNode   = data.range.getEndNode();
        if (startNode && endNode && startNode.parentNode !== endNode.parentNode) {
            return;
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
            return;
        }

        // Get the link from lineage.
        var link     = null;
        var linIndex = -1;
        for (var i = data.current; i >= 0; i--) {
            if (dfx.isTag(data.lineage[i], 'a') === true) {
                link     = data.lineage[i];
                linIndex = i;
                break;
            }
        }

        var isLink    = false;
        var url       = '';
        var titleAttr = '';
        var isEmail   = false;
        var subject   = '';
        if (link) {
            // Get the current value from the link tag.
            url       = link.getAttribute('href');
            titleAttr = link.getAttribute('title') || '';
            isLink    = true;

            if (url.indexOf('mailto:') === 0) {
                isEmail = true;
                url     = url.replace('mailto:', '');

                // Get subject from mailto link.
                var subjectIndex = url.indexOf('?subject=');
                if (subjectIndex >= 0) {
                    subject = url.substr(subjectIndex + 9);
                    url     = url.substr(0, subjectIndex);
                }
            }
        }

        var group          = inlineToolbarPlugin.createButtonGroup();
        var subSectionCont = document.createElement('div');
        var subSection     = inlineToolbarPlugin.createSubSection(subSectionCont);

        if (isEmail === true) {
            dfx.addClass(subSectionCont, 'emailLink');
        }

        // Link button.
        if (currentIsLink !== true && link) {
            inlineToolbarPlugin.createButton('', isLink, 'Toggle Link Options', false, 'link', function() {
                // Select the whole link using the lineage.
                inlineToolbarPlugin.selectLineageItem(linIndex);
            }, group);
        } else {
            inlineToolbarPlugin.createButton('', isLink, 'Toggle Link Options', false, 'link', null, group, subSection, false);
        }

        if (isLink === true) {
            // Add the remove link button.
            inlineToolbarPlugin.createButton('', false, 'Remove Link', false, 'linkRemove', function() {
                self.removeLink(link);
            }, group);
        }

        var setLinkAttributes = function(url, title, subject) {
            if (!link) {
                link = self.rangeToLink(url, title, subject);
            } else {
                self.setLinkURL(link, url, subject);

                if (!subject) {
                    self.setLinkTitle(link, title);
                }
            }

            if (link.href.indexOf('mailto:') === 0) {
                // Show subject field and hide title field.
                dfx.addClass(subSectionCont, 'emailLink');
            } else {
                // Show title field, hide subject field.
                dfx.removeClass(subSectionCont, 'emailLink');
            }

        };

        // Link sub section.
        var urlTextbox = inlineToolbarPlugin.createTextbox(null, url, 'URL', function(value) {
            setLinkAttributes(value,
                (dfx.getTag('input', subSectionCont)[1]).value,
                (dfx.getTag('input', subSectionCont)[2]).value
            );
        }, true, true);

        // Subect textbox, this text box only appears if the URL entered in urlTextbox
        // is an email address.
        var subjectTextbox = inlineToolbarPlugin.createTextbox(null, subject, 'Subject', function(value) {
            setLinkAttributes(
                (dfx.getTag('input', subSectionCont)[0]).value,
                (dfx.getTag('input', subSectionCont)[1]).value,
                value
            );
        }, false, true);

        // Title textbox, this textbox is hidden if the URL entered is an email address.
        var titleTextbox = inlineToolbarPlugin.createTextbox(null, titleAttr, 'Title', function(value) {
            setLinkAttributes(
                (dfx.getTag('input', subSectionCont)[0]).value,
                value,
                (dfx.getTag('input', subSectionCont)[2]).value
            );
        }, false, true);

        var urlRow = inlineToolbarPlugin.createSubSectionRow('urlRow');
        urlRow.appendChild(urlTextbox);

        var subjectRow = inlineToolbarPlugin.createSubSectionRow('subjectRow');
        subjectRow.appendChild(subjectTextbox);

        var titleRow = inlineToolbarPlugin.createSubSectionRow('titleRow');
        titleRow.appendChild(titleTextbox);

        subSectionCont.appendChild(urlRow);
        subSectionCont.appendChild(subjectRow);
        subSectionCont.appendChild(titleRow);

        // New window option.
        var newWindowRow = inlineToolbarPlugin.createSubSectionRow();
        dfx.setHtml(newWindowRow, 'New window');
        subSectionCont.appendChild(newWindowRow);

        return subSectionCont;

    },

    initToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        // Link var is updated when the updateToolbar event callback is called.
        var link = null;

        var setLinkAttributes = function(url, title) {
            if (!link) {
                link = self.rangeToLink(url, title);
            } else {
                self.setLinkURL(link, url);
                self.setLinkTitle(link, title);
            }
        };

        var self     = this;
        var btnGroup = toolbar.createButtonGroup();

        // Create Link button and popup.
        var createLinkSubContent = document.createElement('div');

        // URL text box.
        var url = toolbar.createTextbox('', 'URL', function(value) {
            setLinkAttributes(value, (dfx.getTag('input', createLinkSubContent)[1]).value);
        });
        createLinkSubContent.appendChild(url);

        // Title text box.
        var title = toolbar.createTextbox('', 'Title', function(value) {
            setLinkAttributes((dfx.getTag('input', createLinkSubContent)[0]).value, value);
        });
        createLinkSubContent.appendChild(title);

        var createLinkSubSection = toolbar.createSubSection(createLinkSubContent, true);
        var urlTools = toolbar.createToolsPopup('Insert Link', null, [createLinkSubSection], null, function() {
            if (link) {
                var range = self.viper.getViperRange();
                range.selectNode(link);
                ViperSelection.addRange(range);
            }
        });

        var urlBtn = toolbar.createButton('', false, 'Toggle Link Options', false, 'link', null, btnGroup, urlTools);

        // Remove Link.
        var removeLinkBtn = toolbar.createButton('', false, 'Remove Link', false, 'linkRemove', function() {
            if (link) {
                self.removeLink(link);
            }
        }, btnGroup);

        // Update the buttons when the toolbar updates it self.
        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperLinkPlugin', function(data) {
            var range = data.range;
            link      = self.getLinkFromRange(range);

            if (link) {
                toolbar.setButtonActive(urlBtn);
                toolbar.enableButton(removeLinkBtn);

                (dfx.getTag('input', createLinkSubContent)[0]).value = link.getAttribute('href');
                (dfx.getTag('input', createLinkSubContent)[1]).value = link.getAttribute('title');
            } else {
                var startNode = data.range.getStartNode();
                var endNode   = data.range.getEndNode();
                toolbar.setButtonInactive(urlBtn);

                if (range.collapsed === true
                    || startNode
                    && endNode
                    && startNode.parentNode !== endNode.parentNode
                ) {
                    toolbar.disableButton(urlBtn);
                    toolbar.closePopup(urlTools);
                } else {
                    toolbar.enableButton(urlBtn);
                }

                toolbar.disableButton(removeLinkBtn);

                (dfx.getTag('input', createLinkSubContent)[0]).value = '';
                (dfx.getTag('input', createLinkSubContent)[1]).value = '';
            }//end if
        });

    }

};
