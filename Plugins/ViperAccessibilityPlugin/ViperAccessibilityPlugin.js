/**
 * JS Class for the Viper Toolbar Plugin.
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

function ViperAccessibilityPlugin(viper)
{
    this.viper = viper;

    this._elemContainer = document.createElement('div');

}

ViperAccessibilityPlugin.prototype = {
    init: function()
    {
        var self = this;
        this.toolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (this.toolbarPlugin) {
            this.toolbarPlugin.addButton('ViperVAP', 'format', 'Show Accessibility', function () {
                var violations = self.check();
                if (!violations || violations.length === 0) {
                    return;
                }

                self.showViolations(violations);
            });
        }

        document.body.appendChild(this._elemContainer);

    },

    check: function()
    {
        var violations = dfx.accessibility.runChecks(this.viper.getViperElement(), 'WCAG1AAA');
        return violations;

    },

    showViolations: function(violations)
    {
        dfx.empty(this._elemContainer);

        var eln = violations.length;
        for (var i = 0; i < eln; i++) {
            var violation = violations[i];
            var info      = dfx.accessibility.getViolationInfo(violation.standard, violation.section, violation.technique);
            if (!info) {
                continue;
            }

            this._showViolation(info, violation.element);

        }

    },

    _showViolation: function(info, element)
    {
        var elem = document.createElement('div');
        var rect = dfx.getBoundingRectangle(element);
        dfx.addClass(elem, 'ViperVAP-violation');
        dfx.setStyle(elem, 'left', rect.x2 + 'px');
        dfx.setStyle(elem, 'top', rect.y2 + 'px');

        var titleAttr = info.standard + ' ' + info.section;
        if (info.technique) {
            titleAttr += ' [' + info.technique.id + ']: ' + info.technique.title
        } else {
            titleAttr += ': ' + info.summary;
        }

        elem.setAttribute('title', titleAttr);

        this._elemContainer.appendChild(elem);

    }


};
