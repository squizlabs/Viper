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

    this._issueList = null;

}

ViperAccessibilityPlugin.prototype = {
    init: function()
    {
        var self = this;
        this._createToolbarItems();

    },

    runChecks: function(callback)
    {
        var self       = this;
        var _runChecks = function() {
            HTMLCS.process('WCAG2AAA', self.viper.getViperElement(), callback);
        };

        if (!window.HTMLCS) {
            var script    = document.createElement('script');
            script.onload = function() {
                _runChecks();
            };

            script.src = 'https://raw.github.com/squizlabs/HTMLCodeSniffer/master/HTMLCS.js';
            document.head.appendChild(script);
            return;
        }

        _runChecks();

    },

    _createToolbarItems: function()
    {
        var toolbar = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        if (!toolbar) {
            return;
        }

        var self = this;

        // Create the sub section and set it as active as its always visible.
        var subSectionCont = this._createSubSection();
        var subSection     = toolbar.createSubSection(subSectionCont, false);

        var toolsSection = document.createElement('div');

        // Main pannel showing All and rerun buttons.
        var mainPanel = document.createElement('div');
        dfx.setStyle(mainPanel, 'display', 'none');

        var aaTools = toolbar.createToolsPopup('Accessibility Auditor', toolsSection, [subSection]);
        dfx.setStyle(aaTools.element, 'width', '320px');

        // Check button panel.
        // Check panel will show a check button which will start checking issues.
        var checkPanel = document.createElement('div');
        toolsSection.appendChild(checkPanel);

        var _updateResults =  function() {
            // Show loading sub section only.
            dfx.setStyle(dfx.getClass('ViperAP-cont', subSection), 'display', 'none');
            dfx.setStyle(dfx.getClass('loadingCont', subSection)[0], 'display', 'block');

            // Set the sub section to be visible.
            dfx.addClass(subSection, 'active');
            dfx.addClass(aaTools.element, 'subSectionVisible');

            // Run the HTMLCS checks.
            self.runChecks(function() {
                // Hide loading sub section and show the main panel and results panel.
                dfx.setStyle(checkPanel, 'display', 'none');
                dfx.setStyle(mainPanel, 'display', 'block');

                // Get the messages from HTMLCS.
                var msgs = HTMLCS.getMessages();

                // Hide the loading container.
                dfx.setStyle(dfx.getClass('loadingCont', subSection)[0], 'display', 'none');

                if (msgs.length === 0) {
                    // No messages, show no results message.
                    dfx.setStyle(dfx.getClass('noResultsCont', subSection)[0], 'display', 'block');
                } else {
                    // There are messages so update the issue list.
                    self._updateIssues(msgs);
                    dfx.setStyle(dfx.getClass('resultsCont', subSection)[0], 'display', 'block');
                }
            });
        };

        var checkContentBtn = toolbar.createButton('Check Content', false, 'Check Content', false, '', function() {
             _updateResults();
        }, null, null, checkPanel);
        checkPanel.appendChild(checkContentBtn);

        toolsSection.appendChild(mainPanel);
        var showAllBtn = toolbar.createButton('All', false, 'Show All', false, '', null, null, null, mainPanel);
        mainPanel.appendChild(showAllBtn);
        var showAllBtn = toolbar.createButton('', false, 'Re-run', false, 'accessRerun', function() {
            _updateResults();
        }, null, null, mainPanel);
        mainPanel.appendChild(showAllBtn);

        toolbar.createButton('', false, 'Accessibility Auditor', false, 'accessRerun', null, null, aaTools);

    },

    _createSubSection: function()
    {
        var main = document.createElement('div');

        // Loading Container.
        var loading = document.createElement('div');
        dfx.addClass(loading, 'loadingCont ViperITP-msgBox ViperAP-cont');
        dfx.setHtml(loading, 'Processing...');
        main.appendChild(loading);

        var noResults = document.createElement('div');
        dfx.addClass(noResults, 'noResultsCont ViperITP-msgBox info  ViperAP-cont');
        dfx.setHtml(noResults, 'No issues found');
        dfx.setStyle(noResults, 'display', 'none');
        main.appendChild(noResults);

        // Results Container.
        main.appendChild(this._createResultsContainer());

        return main;

    },

    _createResultsContainer: function()
    {
        var results = document.createElement('div');
        dfx.addClass(results, 'resultsCont ViperAP-wrapper ViperAP-cont');
        dfx.setStyle(results, 'display', 'none');

        var topObv = document.createElement('div');
        dfx.addClass(topObv, 'ViperAP-obliv oblivTop');
        results.appendChild(topObv);

        var list = document.createElement('ol');
        dfx.addClass(list, 'ViperAP-issueList');
        results.appendChild(list);
        this._issueList = list;

        var bottomObv = document.createElement('div');
        dfx.addClass(bottomObv, 'ViperAP-obliv oblivBottom');
        results.appendChild(bottomObv);

        return results;

    },

    _updateIssues: function(msgs)
    {
        dfx.empty(this._issueList);

        var c = msgs.length;
        for (var i = 0; i < c; i++) {
            var msg = msgs[i];
            this._issueList.appendChild(this._createIssue(msg));
        }

    },

    _createIssue: function(msg)
    {
        var li = document.createElement('li');
        dfx.addClass(li, 'ViperAP-issueItem');

        var issueType = '';
        switch (msg.type) {
            case HTMLCS.ERROR:
                type = 'error';
            break;

            case HTMLCS.WARNING:
                type = 'warning';
            break;

            case HTMLCS.NOTICE:
                type = 'manual';
            break;
        }

        var liContent = '<span class="ViperAP-issueType ' + type + '"></span>';
        liContent    += '<span class="ViperAP-issueTitle">' + msg.msg + '</span>';

        dfx.setHtml(li, liContent);

        return li;

    }


};
