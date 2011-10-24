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
    this.viper                = viper;
    this._issueList           = null;
    this._issueDetailsWrapper = null;
    this._resultsMiddle       = null;
    this._issueCount          = 0;
    this._currentIssue        = 1;
    this._prevIssueBtn        = null;
    this._nextIssueBtn        = null;
    this._toolbar             = null;
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

        this._toolbar = toolbar;
        var self      = this;

        // Create the sub section and set it as active as its always visible.
        var subSectionCont = this._createSubSection();
        var subSection     = toolbar.createSubSection(subSectionCont, false);

        var toolsSection   = document.createElement('div');
        this._toolsSection = toolsSection;
        dfx.addClass(toolsSection, 'ViperAP-toolsWrapper checkTools');

        // Main pannel showing All and rerun buttons.
        var mainPanel = document.createElement('div');
        dfx.addClass(mainPanel, 'ViperAP-tools ViperAP-listTools');

        var aaTools = toolbar.createToolsPopup('Accessibility Auditor', toolsSection, [subSection]);
        dfx.setStyle(aaTools.element, 'width', '320px');

        // Check button panel.
        // Check panel will show a check button which will start checking issues.
        var checkPanel = document.createElement('div');
        dfx.addClass(checkPanel, 'ViperAP-tools ViperAP-checkTools');
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
                dfx.removeClass(toolsSection, 'checkTools');
                dfx.addClass(toolsSection, 'listTools');

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
            self._toolbar.disableButton(checkContentBtn);
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

        toolbar.createButton('', false, 'Accessibility Auditor', false, 'accessAudit', null, null, aaTools);

        // Create the detail tools.
        var detailTools = document.createElement('div');
        dfx.addClass(detailTools, 'ViperAP-tools ViperAP-detailTools issueNav');

        var detailToolsWrapper = document.createElement('div');
        dfx.addClass(detailToolsWrapper, 'ViperAP-issueNav');
        detailTools.appendChild(detailToolsWrapper);

        var listLink = document.createElement('a');
        listLink.setAttribute('title', 'Show Issue List');
        listLink.setAttribute('href', 'javascript:');
        detailToolsWrapper.appendChild(listLink);
        dfx.setHtml(listLink, 'List');

        var divider = document.createElement('span');
        dfx.addClass(divider, 'issueNav-divider');
        dfx.setHtml(divider, ' &gt; ');
        detailToolsWrapper.appendChild(divider);

        this._issueCountContainer = document.createTextNode('Issue 0 of 0');
        detailToolsWrapper.appendChild(this._issueCountContainer);

        toolsSection.appendChild(detailTools);

        // List Link event.
        dfx.addEvent(dfx.getTag('a', detailTools)[0], 'mousedown', function() {
            // Show the list tools.
            dfx.removeClass(toolsSection, 'checkTools');
            dfx.removeClass(toolsSection, 'detailTools');
            dfx.addClass(toolsSection, 'listTools');

            // Show the list.
            dfx.setStyle(self._issueList, 'margin-left', 0);
        });

        // Create detail prev, next button group.
        var prevNextGroup = toolbar.createButtonGroup();
        var prevButton    = toolbar.createButton('', false, 'Previous Issue', false, 'prevIssue', function() {
            self.previousIssue();
        }, prevNextGroup);
        var nextButton    = toolbar.createButton('', false, 'Next Issue', false, 'nextIssue', function() {
            self.nextIssue();
        }, prevNextGroup);
        detailTools.appendChild(prevNextGroup);
        this._prevIssueBtn = prevButton;
        this._nextIssueBtn = nextButton;

    },

    previousIssue: function()
    {
        if (this._currentIssue <= 1) {
            return;
        }

        this._currentIssue--;
        margin = ((this._currentIssue - 1) * 320 * -1);

        dfx.setStyle(this._issueDetailsWrapper.firstChild, 'margin-left', margin + 'px');
        this._updateIssueNumber();
    },

    nextIssue: function()
    {
        if (this._currentIssue >= this._issueCount) {
            return;
        }

        margin = (this._currentIssue * 320 * -1);
        this._currentIssue++;

        dfx.setStyle(this._issueDetailsWrapper.firstChild, 'margin-left', margin + 'px');
        this._updateIssueNumber();

    },

    _updateIssueNumber: function()
    {
        this._issueCountContainer.data = 'Issue ' + this._currentIssue + ' of ' + this._issueCount;

        // Update the issue statuses.
        if (this._currentIssue <= 1) {
            // Disable previous button.
            this._toolbar.disableButton(this._prevIssueBtn);
        } else if (this._currentIssue >= this._issueCount) {
            // Disable next button.
            this._toolbar.disableButton(this._nextIssueBtn);
        } else {
            // Enable both buttons.
            this._toolbar.enableButton(this._nextIssueBtn);
            this._toolbar.enableButton(this._prevIssueBtn);
        }

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

        var middle = document.createElement('div');
        this._resultsMiddle = middle;

        dfx.addClass(middle, 'ViperAP-middle issueList');
        var list = document.createElement('ol');
        dfx.addClass(list, 'ViperAP-issueList');
        results.appendChild(list);
        this._issueList = list;

        // Create the issue details wrapper.
        this._issueDetailsWrapper = document.createElement('div');
        dfx.addClass(this._issueDetailsWrapper, 'ViperAP-issueDetailsWrapper');
        results.appendChild(this._issueDetailsWrapper);

        middle.appendChild(list);
        middle.appendChild(this._issueDetailsWrapper);

        results.appendChild(middle);

        var bottomObv = document.createElement('div');
        dfx.addClass(bottomObv, 'ViperAP-obliv oblivBottom');
        results.appendChild(bottomObv);

        return results;

    },

    _showIssueDetails: function(issue, li)
    {
        // First move the details div to the correct position.
        var index = this._getIssueIndex(li);

        this._currentIssue = index;
        this._updateIssueNumber();

        // Move the detail panel to the start.
        dfx.addClass(this._issueDetailsWrapper.firstChild, 'instant');
        dfx.setStyle(this._issueDetailsWrapper.firstChild, 'margin-left', ((index - 1) * 320 * -1) + 'px');
        var self = this;
        setTimeout(function() {
            dfx.removeClass(self._issueDetailsWrapper.firstChild, 'instant');
        }, 500);

        dfx.setStyle(this._issueList, 'margin-left', '-320px');

        dfx.removeClass(this._resultsMiddle, 'issueList');
        dfx.addClass(this._resultsMiddle, 'issueDetails');

        // Show the details navigation.
        dfx.removeClass(this._toolsSection, 'checkTools');
        dfx.removeClass(this._toolsSection, 'listTools');
        dfx.addClass(this._toolsSection, 'detailTools');

    },

    _getIssueIndex: function(li)
    {
        var index = 0;
        for (var node = li; node; node = node.previousSibling) {
            if (dfx.isTag(node, 'li') === true) {
                index++;
            }
        }

        return index;

    },

    _updateIssues: function(msgs)
    {
        dfx.empty(this._issueList);
        dfx.empty(this._issueDetailsWrapper);

        var c = msgs.length;
        this._issueCount   = c;
        this._currentIssue = 1;

        for (var i = 0; i < c; i++) {
            var msg = msgs[i];
            this._issueList.appendChild(this._createIssue(msg));
        }

        // Update the widths of containers.
        dfx.setStyle(this._resultsMiddle, 'width', ((c * 320) + 320) + 'px');
        dfx.setStyle(this._issueDetailsWrapper, 'width', (c * 320) + 'px');

    },

    _createIssue: function(msg)
    {
        var li = document.createElement('li');
        dfx.addClass(li, 'ViperAP-issueItem');

        var issueType = this._getIssueType(msg);

        var liContent = '<span class="ViperAP-issueType ' + issueType + '"></span>';
        liContent    += '<span class="ViperAP-issueTitle">' + msg.msg + '</span>';

        dfx.setHtml(li, liContent);

        this._createIssueDetail(msg);

        var self = this;
        dfx.addEvent(li, 'mousedown', function(e) {
            self._showIssueDetails(msg, li);
            dfx.preventDefault(e);
            return false;
        });

        return li;

    },

    _createIssueDetail: function(issue)
    {
        var main = document.createElement('div');
        dfx.addClass(main, 'ViperAP-issuePane');

        var issueType = this._getIssueType(issue);

        var content = '<div class="ViperAP-issueDetails">';
        content    += '<span class="ViperAP-issueType ' + issueType + '"></span>';
        content    += '<div class="issueTitle">' + issue.msg + '</div>';
        content    += '<div class="issueWcag">';
        content    += '<strong>WCAG References</strong><br>';
        content    += '<em>Category: </em> <a href="#">Non-text Content</a><br>';
        content    += '<em>Technique: </em> <a href="#">H28</a><br>';
        content    += '</div></div><!-- End References -->';

        dfx.setHtml(main, content);

        this._issueDetailsWrapper.appendChild(main);
    },

    _getIssueType: function(issue)
    {
        var issueType = '';
        switch (issue.type) {
            case HTMLCS.ERROR:
                issueType = 'error';
            break;

            case HTMLCS.WARNING:
                issueType = 'warning';
            break;

            case HTMLCS.NOTICE:
                issueType = 'manual';
            break;
        }

        return issueType;

    }


};
