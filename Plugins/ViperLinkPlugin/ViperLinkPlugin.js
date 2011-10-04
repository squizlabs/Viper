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

    },

    rangeToLink: function(range, url)
    {
        if (!range || !url) {
            return;
        }

        range = range || this.viper.getCurrentRange();

        var bookmark = this.viper.createBookmark();

        var a = document.createElement('a');
        a.setAttribute('href', url);

        for (var node = bookmark.start.nextSibling; node && node !== bookmark.end; node = node.nextSibling) {
            a.appendChild(node);
        }

        dfx.insertAfter(bookmark.start, a);

        this.viper.selectBookmark(bookmark);
        this.viper.fireSelectionChanged();
        this.viper.fireNodesChanged([this.viper.getViperElement()]);

        return a;

    },

    removeLink: function(linkTag)
    {
        if (!linkTag) {
            return;
        }

        var firstChild = linkTag.firstChild;
        var lastChild  = linkTag.lastChild;

        while (linkTag.firstChild) {
            this.viper.insertBefore(linkTag, linkTag.firstChild);
        }

        var range = this.viper.getCurrentRange();
        range.setStart(firstChild, 0);
        range.setEnd(lastChild, lastChild.data.length);
        ViperSelection.addRange(range);
        this.viper.fireSelectionChanged();

    },

    setLinkTitle: function(link, title)
    {
        if (!link) {
            return;
        }

        link.setAttribute('title', title);

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
            var group          = inlineToolbarPlugin.createButtonGroup();
            var subSectionCont = document.createElement('div');
            var subSection     = inlineToolbarPlugin.createSubSection(subSectionCont);
            var rangeClone     = data.range.cloneRange();
            var currentIsLink  = false;

            if (dfx.isBlockElement(data.lineage[data.current]) === true) {
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

            var isLink = false;
            var url    = '';
            if (link) {
                // Get the current value from the link tag.
                url    = link.getAttribute('href');
                isLink = true;
            }

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

            // Link sub section.
            var urlTextbox = inlineToolbarPlugin.createTextbox(null, url, 'URL', function(value) {
                subSectionActive = true;
                ViperSelection.addRange(rangeClone);
                if (!link) {
                    link = self.rangeToLink(data.range, value);
                } else {
                    link.setAttribute('href', value);
                }
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

            var titleTextbox = inlineToolbarPlugin.createTextbox(null, '', 'Title', function(value) {
                self.setLinkTitle(link, value);
                subSectionActive = true;
                ViperSelection.addRange(rangeClone);
            }, false, true);

            var urlRow = inlineToolbarPlugin.createSubSectionRow();
            urlRow.appendChild(urlTextbox);
            urlRow.appendChild(newWindowBtn);

            subSectionCont.appendChild(urlRow);
            subSectionCont.appendChild(titleTextbox);
        });

    }

};
