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
        this._initInlineToolbar();

        this._initToolbar();

    },

    rangeToLink: function(range, url, title)
    {
        if (!range || !url) {
            return;
        }

        range = range || this.viper.getCurrentRange();

        var bookmark = this.viper.createBookmark();

        var a = document.createElement('a');
        a.setAttribute('href', url);

        if (title) {
            a.setAttribute('title', title);
        }

        var elems = dfx.getElementsBetween(bookmark.start, bookmark.end);
        for (var i = 0; i < elems.length; i++) {
            a.appendChild(elems[i]);
        }

        dfx.insertAfter(bookmark.start, a);

        this.viper.selectBookmark(bookmark);
        this.viper.fireSelectionChanged();
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

        var range = this.viper.getCurrentRange();
        range.setStart(firstChild, 0);
        range.setEnd(lastChild, lastChild.data.length);
        ViperSelection.addRange(range);
        this.viper.fireSelectionChanged(true);
        this.viper.fireNodesChanged([this.viper.getViperElement()]);

    },

    setLinkTitle: function(link, title)
    {
        if (!link) {
            return;
        }

        link.setAttribute('title', title);

    },

    setLinkURL: function(link, url)
    {
        if (!link) {
            return;
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

    _initInlineToolbar: function()
    {
        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');
        if (!inlineToolbarPlugin) {
            return;
        }

        var self = this;
        var subSectionActive = false;
        this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperLinkPlugin', function(data) {
            var rangeClone     = data.range.cloneRange();
            var currentIsLink  = false;

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
                subSectionActive = true;
                currentIsLink    = true;
            } else {
                subSectionActive = false;
            }

            if (currentIsLink !== true
                && (data.lineage[data.current].nodeType !== dfx.TEXT_NODE
                || dfx.isTag(data.lineage[data.current].parentNode, 'a') === false)
                && rangeClone.collapsed === true) {
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
            if (link) {
                // Get the current value from the link tag.
                url       = link.getAttribute('href');
                titleAttr = link.getAttribute('title') || '';
                isLink    = true;
            }

            var group          = inlineToolbarPlugin.createButtonGroup();
            var subSectionCont = document.createElement('div');
            var subSection     = inlineToolbarPlugin.createSubSection(subSectionCont);

            // Link button.
            if (currentIsLink !== true && link) {
                inlineToolbarPlugin.createButton('', isLink, 'Toggle Link Options', false, 'link', function() {
                    // Select the whole link using the lineage.
                    inlineToolbarPlugin.selectLineageItem(linIndex);
                }, group);
            } else {
                inlineToolbarPlugin.createButton('', isLink, 'Toggle Link Options', false, 'link', null, group, subSection, subSectionActive);
            }

            if (isLink === true) {
                // Add the remove link button.
                inlineToolbarPlugin.createButton('', false, 'Remove Link', false, 'linkRemove', function() {
                    self.removeLink(link);
                }, group);
            }

            var setLinkAttributes = function(url, title) {
                subSectionActive = true;
                ViperSelection.addRange(rangeClone);

                if (!link) {
                    link = self.rangeToLink(data.range, url, title);
                } else {
                    self.setLinkURL(link, url);
                    self.setLinkTitle(link, title);
                }
            };

            // Link sub section.
            var urlTextbox = inlineToolbarPlugin.createTextbox(null, url, 'URL', function(value) {
                setLinkAttributes(value, (dfx.getTag('input', subSectionCont)[1]).value);
            }, true, true);

            var newWindowBtnActive = false;
            if (link && link.getAttribute('target') === '_blank') {
                newWindowBtnActive = true;
            }

            var newWindowBtn = inlineToolbarPlugin.createButton('', newWindowBtnActive, 'Toggle Open in New Window', false, 'linkNewWindow', function() {
                if (link.getAttribute('target') === '_blank') {
                    dfx.removeAttr(link, 'target');
                    dfx.removeClass(newWindowBtn, 'active');
                } else {
                    link.setAttribute('target', '_blank');
                    dfx.addClass(newWindowBtn, 'active');
                }
            }, group);

            var titleTextbox = inlineToolbarPlugin.createTextbox(null, titleAttr, 'Title', function(value) {
                setLinkAttributes(urlTextbox.lastChild.value, value);
            }, false, true);

            var urlRow = inlineToolbarPlugin.createSubSectionRow();
            urlRow.appendChild(urlTextbox);
            urlRow.appendChild(newWindowBtn);

            subSectionCont.appendChild(urlRow);
            subSectionCont.appendChild(titleTextbox);
        });
    },

    _initToolbar: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        // Link var is updated when the updateToolbar event callback is called.
        var link = null;

        var setLinkAttributes = function(url, title) {
            if (!link) {
                link = self.rangeToLink(self.viper.getViperRange(), url, title);
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
        var urlTools = toolbar.createToolsPopup('Anchor ID', null, [createLinkSubSection], null, function() {
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
