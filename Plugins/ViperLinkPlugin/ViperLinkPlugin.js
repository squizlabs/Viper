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

    start: function()
    {
        var inlineToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperInlineToolbarPlugin');
        if (inlineToolbarPlugin) {
            var self = this;
            this.viper.registerCallback('ViperInlineToolbarPlugin:updateToolbar', 'ViperLinkPlugin', function(data) {
                for (var i = 0; i < data.lineage.length; i++) {
                    if (dfx.isTag(data.lineage[i], 'a') === true) {
                        var removeLink = inlineToolbarPlugin.createButton('Remove Link', 'a', 'Remove Link', false, 'removeLink', function() {
                            self.removeLink(data.lineage[i]);
                        });

                        var group = document.createElement('div');
                        group.appendChild(removeLink);

                        data.container.appendChild(group);

                        var range = self.viper.getCurrentRange();
                        range.selectNode(data.lineage[i]);
                        ViperSelection.addRange(range);
                        self.viper.fireSelectionChanged();
                        break;
                    }
                }
            });
        }
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
    }

};
