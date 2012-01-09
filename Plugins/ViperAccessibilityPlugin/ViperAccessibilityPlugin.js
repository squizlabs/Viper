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
    this._errorCount          = 0;
    this._warningCount        = 0;
    this._noticeCount         = 0;
    this._currentIssue        = 1;
    this._currentList         = 1;
    this._pageCount           = 1;
    this._issuesPerPage       = 5;
    this._containerWidth      = 320;
    this._subSection          = null;
    this._prevIssueBtn        = null;
    this._nextIssueBtn        = null;
    this._checkContentBtn     = null;
    this._aaTools             = null;
    this._toolbar             = null;
    this._listPageCounter     = null;
    this._mainPanelLeft       = null;
    this._htmlCSsrc           = 'https://raw.github.com/squizlabs/HTML_CodeSniffer/master/HTMLCS.js';
    this._standard            = 'WCAG2AAA';
    this._includeNotices      = false;
    this._loadedScripts       = [];
    this._loadCallbacks       = {};

    this._htmlCSsrc = 'file:///Users/sdanis/Sites/HTML_CodeSniffer/HTMLCS.js';

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
            HTMLCS.process(self._standard, self.viper.getViperElement(), callback);
        };

        if (!window.HTMLCS) {
            var script    = document.createElement('script');
            script.onload = function() {
                _runChecks();
            };

            script.src = this._htmlCSsrc;
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
        this._subSection   = subSection;

        var toolsSection   = document.createElement('div');
        this._toolsSection = toolsSection;
        dfx.addClass(toolsSection, 'ViperAP-toolsWrapper checkTools');

        // Main pannel showing All and rerun buttons.
        var mainPanel = document.createElement('div');
        dfx.addClass(mainPanel, 'ViperAP-tools ViperAP-listTools');

        var aaTools = toolbar.createToolsPopup('Accessibility Auditor - ' + this._standard, toolsSection, [subSection]);
        dfx.setStyle(aaTools.element, 'width', this._containerWidth + 'px');
        this._aaTools = aaTools;

        // Check button panel.
        // Check panel will show a check button which will start checking issues.
        var checkPanel = document.createElement('div');
        dfx.addClass(checkPanel, 'ViperAP-tools ViperAP-checkTools');
        toolsSection.appendChild(checkPanel);

        var checkContentBtn = toolbar.createButton('Check Content', false, 'Check Content', false, '', function() {
            self._toolbar.disableButton(checkContentBtn);
             self.updateResults();
        }, null, null, checkPanel);
        checkPanel.appendChild(checkContentBtn);
        this._checkContentBtn = checkContentBtn;

        // Error info, settings and rerun button.
        toolsSection.appendChild(mainPanel);

        var mainPanelLeft   = document.createElement('div');
        this._mainPanelLeft = mainPanelLeft;
        dfx.addClass(mainPanelLeft, 'ViperAP-listTools-left');
        mainPanel.appendChild(mainPanelLeft);
        var mainPanelRight = document.createElement('div');
        dfx.addClass(mainPanelRight, 'ViperAP-listTools-right');
        mainPanel.appendChild(mainPanelRight);

        var settingsBtn = toolbar.createButton('St', false, 'Settings', false, '', function() {
            var resultsCont = dfx.getClass('resultsCont', subSection)[0];
            if (dfx.getStyle(resultsCont, 'display') === 'none') {
                dfx.setStyle(dfx.getClass('settingsCont', subSection)[0], 'display', 'none');
                dfx.setStyle(dfx.getClass('resultsCont', subSection)[0], 'display', 'block');
            } else {
                dfx.setStyle(dfx.getClass('resultsCont', subSection)[0], 'display', 'none');
                dfx.setStyle(dfx.getClass('settingsCont', subSection)[0], 'display', 'block');
            }

        }, null, null, mainPanel);
        mainPanelRight.appendChild(settingsBtn);
        var reRunBtn = toolbar.createButton('', false, 'Re-run', false, 'accessRerun', function() {
            self.updateResults();
        }, null, null, mainPanel);
        mainPanelRight.appendChild(reRunBtn);

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
        dfx.addEvent(listLink, 'mousedown', function() {
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
        var nextButton = toolbar.createButton('', false, 'Next Issue', false, 'nextIssue', function() {
            self.nextIssue();
        }, prevNextGroup);
        detailTools.appendChild(prevNextGroup);
        this._prevIssueBtn = prevButton;
        this._nextIssueBtn = nextButton;

    },

    updateResults: function()
    {
        var self = this;

        // Show loading sub section only.
        dfx.setStyle(dfx.getClass('ViperAP-cont', this._subSection), 'display', 'none');
        dfx.setStyle(dfx.getClass('loadingCont', this._subSection)[0], 'display', 'block');

        // Set the sub section to be visible.
        dfx.addClass(this._subSection, 'active');
        dfx.addClass(this._aaTools.element, 'subSectionVisible');

        // Run the HTMLCS checks.
        this.runChecks(function() {
            // Hide loading sub section and show the main panel and results panel.
            dfx.removeClass(self._toolsSection, 'checkTools');
            dfx.addClass(self._toolsSection, 'listTools');

            // Get the messages from HTMLCS.
            var msgs = HTMLCS.getMessages();

            // Hide the loading container.
            dfx.setStyle(dfx.getClass('loadingCont', self._subSection)[0], 'display', 'none');

            if (msgs.length === 0) {
                // No messages, show no results message.
                dfx.setStyle(dfx.getClass('noResultsCont', self._subSection)[0], 'display', 'block');
            } else {
                // There are messages so update the issue list.
                self._updateIssues(msgs);
                dfx.setStyle(dfx.getClass('resultsCont', self._subSection)[0], 'display', 'block');
            }
        });

    },

    previousIssue: function()
    {
        if (this._currentIssue <= 1) {
            return;
        }

        this._currentIssue--;
        margin = ((this._currentIssue - 1) * this._containerWidth * -1);

        dfx.setStyle(this._issueDetailsWrapper.firstChild, 'margin-left', margin + 'px');
        this._updateIssueNumber();

    },

    nextIssue: function()
    {
        if (this._currentIssue >= this._issueCount) {
            return;
        }

        margin = (this._currentIssue * this._containerWidth * -1);
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

        // Update the issues list index so that its on the page that the current
        // issue is at.
        this.setCurrentListIndex(Math.ceil(this._currentIssue / this._issuesPerPage));

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

        // The settings container.
        main.appendChild(this._createSettingsContainer());

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

        var lists = document.createElement('div');
        dfx.addClass(lists, 'ViperAP-issueListWrapper');
        results.appendChild(lists);
        this._issueList = lists;

        // Create the issue details wrapper.
        this._issueDetailsWrapper = document.createElement('div');
        dfx.addClass(this._issueDetailsWrapper, 'ViperAP-issueDetailsWrapper');
        results.appendChild(this._issueDetailsWrapper);

        middle.appendChild(lists);
        middle.appendChild(this._issueDetailsWrapper);

        results.appendChild(middle);

        var bottomObv = document.createElement('div');
        dfx.addClass(bottomObv, 'ViperAP-obliv oblivBottom');
        results.appendChild(bottomObv);

        return results;

    },

    _createSettingsContainer: function()
    {
        var div = document.createElement('div');
        dfx.addClass(div, 'settingsCont ViperAP-wrapper ViperAP-cont');
        dfx.setStyle(div, 'display', 'none');

        // List Filters.
        var listFilters = document.createElement('div');
        dfx.addClass(listFilters, 'listFilters');
        dfx.setHtml(listFilters, '<h1>List Filters</h1><p>Errors and Warnings are always shown and cannot be hidden. Notices will be automatically shown if there are not other issues.</p>');
        var includeNoticesChbox = ViperTools.createCheckbox('Always include Notices', this._includeNotices);
        listFilters.appendChild(includeNoticesChbox);
        div.appendChild(listFilters);

        // Accessibility Standard.
        var standards = document.createElement('div');
        dfx.addClass(standards, 'accessStandard');
        dfx.setHtml(standards, '<h1>Accessibility Standard</h1><p>Choose which standard you would like to check your content against.</p>');
        div.appendChild(standards);

        var trippleA = ViperTools.createRadiobutton('standard', 'WCAG2AAA', 'Tripple A (WCAG 2.0 AAA)', true);
        var doubleA  = ViperTools.createRadiobutton('standard', 'WCAG2AA', 'Double A (WCAG 2.0 AA)');
        var singleA  = ViperTools.createRadiobutton('standard', 'WCAG2A', 'Single A (WCAG 2.0 A)');
        var sec508   = ViperTools.createRadiobutton('standard', 'Section508', 'Section 508 (U.S. Federal Agencies 1998)');

        standards.appendChild(trippleA);
        standards.appendChild(doubleA);
        standards.appendChild(singleA);
        standards.appendChild(sec508);

        // Re check button.
        var self       = this;
        var reCheckSec = document.createElement('div');
        dfx.addClass(reCheckSec, 'reCheckSec');
        var reCheck = ViperTools.createButton('Re-check Content', false, 'Re-check Content', false, '', function() {
            var radioBtns = document.getElementsByName('standard');
            var value     = null;
            for (var i = 0; i < radioBtns.length; i++) {
                if (radioBtns[i].checked === true) {
                    value = radioBtns[i].value;
                    break;
                }
            }

            if (value !== null) {
                self._standard       = value;
                self._includeNotices = includeNoticesChbox.firstChild.checked;
                self.updateResults();
            }
        });
        reCheckSec.appendChild(reCheck);

        div.appendChild(reCheckSec);

        return div;
    },

    _showIssueDetails: function(issue, li)
    {
        // First move the details div to the correct position.
        var index = this._getIssueIndex(li);

        this._currentIssue = index;
        this._updateIssueNumber();

        // Move the detail panel to the start.
        dfx.addClass(this._issueDetailsWrapper.firstChild, 'instant');
        dfx.setStyle(this._issueDetailsWrapper.firstChild, 'margin-left', ((index - 1) * this._containerWidth * -1) + 'px');
        var self = this;
        setTimeout(function() {
            dfx.removeClass(self._issueDetailsWrapper.firstChild, 'instant');
        }, 500);

        dfx.setStyle(this._issueList, 'margin-left', (this._containerWidth * -1) + 'px');

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

        index = (index + (this._issuesPerPage * (this._currentList - 1)));

        return index;

    },

    _updateIssues: function(msgs)
    {
        dfx.empty(this._issueList);
        dfx.empty(this._issueDetailsWrapper);

        var self           = this;
        var c              = msgs.length;
        var list           = null;
        var firstList      = null;
        var pages          = 0;
        this._currentIssue = 1;
        this._currentList  = 1;
        this._errorCount   = 0;
        this._warningCount = 0;
        this._noticeCount  = 0;
        this._pageCount    = 0;

        // Create list inner wrapper.
        var listsInner = document.createElement('div');
        dfx.addClass(listsInner, 'ViperAP-issueListInner');
        this._issueList.appendChild(listsInner);

        // Filter msgs.
        if (this._includeNotices !== true) {
            var newMsgs = [];
            for (var i = 0; i < c; i++) {
                var msg = msgs[i];
                if (msg.type !== HTMLCS.NOTICE) {
                    newMsgs.push(msg);
                }
            }

            if (newMsgs.length > 0) {
                // There are errors and/or warnings. If no errors or warnings then
                // the notices will be displayed even if includeNotices settings
                // is disabled.
                msgs = newMsgs;
                c    = msgs.length;
            }
        }

        this._issueCount = c;

        // Create multiple issue lists for pagination.
        for (var i = 0; i < c; i++) {
            if ((i % this._issuesPerPage) === 0) {
                list = document.createElement('ol');
                dfx.addClass(list, 'ViperAP-issueList');
                listsInner.appendChild(list);
                this._pageCount++;

                if (this._pageCount === 1) {
                    firstList = list;
                }
            }

            var msg = msgs[i];
            list.appendChild(this._createIssue(msg));
        }

        // Set the width to the width of panel x number of pages so they are placed
        // side by side for the sliding effect.
        dfx.setStyle(listsInner, 'width', (this._pageCount * this._containerWidth) + 'px');

        // Create the list navigation buttons.
        if (this._pageCount > 1) {
            var listNav = document.createElement('div');
            dfx.addClass(listNav, 'ViperAP-listNav');

            var pageCounter       = document.createElement('span');
            this._listPageCounter = pageCounter;

            // Show previous list of issues.
            var prev = document.createElement('span');
            dfx.addClass(prev, 'ViperAP-listNav-prev');
            listNav.appendChild(prev);
            dfx.addEvent(prev, 'click', function() {
                if (self._currentList === 1) {
                    return;
                }

                self._currentList--;
                dfx.setStyle(firstList, 'margin-left', (-1 * self._containerWidth * (self._currentList - 1)) + 'px');

                // Update page counter.
                dfx.setHtml(pageCounter, 'Pg ' + self._currentList + ' of ' + self._pageCount);
            });

            dfx.addClass(pageCounter, 'ViperAP-listNav-pageCounter');
            dfx.setHtml(pageCounter, 'Pg 1 of ' + self._pageCount);
            listNav.appendChild(pageCounter);

            // Show next list of issues.
            var next = document.createElement('span');
            dfx.addClass(next, 'ViperAP-listNav-next');
            listNav.appendChild(next);
            dfx.addEvent(next, 'click', function() {
                if (self._currentList >= self._pageCount) {
                    return;
                }

                self._currentList++;
                dfx.setStyle(firstList, 'margin-left', (-1 * self._containerWidth * (self._currentList - 1)) + 'px');

                // Update page counter.
                dfx.setHtml(pageCounter, 'Pg ' + self._currentList + ' of ' + self._pageCount);
            });

            this._issueList.appendChild(listNav);
        }//end if

        // Update the widths of containers.
        dfx.setStyle(this._resultsMiddle, 'width', ((c * this._containerWidth) + this._containerWidth) + 'px');
        dfx.setStyle(this._issueDetailsWrapper, 'width', (c * this._containerWidth) + 'px');

        // Update the number of issues.
        this._updateNumberOfIssuesContainer();

    },

    _updateNumberOfIssuesContainer: function()
    {
        var content = '';

        if (this._errorCount > 0) {
            content += '<strong>' + this._errorCount + '</strong> Errors <span class="ViperAP-divider"></span>';
        }

        if (this._warningCount > 0) {
            content += '<strong>' + this._warningCount + '</strong> Warnings <span class="ViperAP-divider"></span>';
        }

        if (this._noticeCount > 0) {
            content += '<strong>' + this._noticeCount + '</strong> Notices';
        }

        dfx.setHtml(this._mainPanelLeft, content);

    },

    setCurrentListIndex: function(index)
    {
        this._currentList = index;

        dfx.setStyle(this._issueList.firstChild.firstChild, 'margin-left', (-1 * this._containerWidth * (this._currentList - 1)) + 'px');
        this.updatePageCount();

    },

    updatePageCount: function()
    {
        var listCount = this._issueList.firstChild.childNodes.length;
        if (listCount < this._currentList) {
            this._currentList = listCount;
        }

        this._pageCount = listCount;

        dfx.setHtml(this._listPageCounter, 'Pg ' + this._currentList + ' of ' + listCount);

    },

    /**
     * Marks current issue as done.
     */
    markAsDone: function()
    {
        var issueElement = this.getIssueElement(this._currentIssue);
        dfx.addClass(issueElement, 'issueDone');

        this._issueCount--;

        var issueType = this._getIssueTypeFromElement(issueElement);
        switch (issueType) {
            case HTMLCS.ERROR:
                this._errorCount--;
            break;

            case HTMLCS.WARNING:
                this._warningCount--;
            break;

            case HTMLCS.NOTICE:
                this._noticeCount--;
            break;

            default:
                // Unknown type.
            break;
        }//end switch

        this._updateNumberOfIssuesContainer();

        var self = this;
        setTimeout(function() {
            if (self._currentIssue > self._issueCount) {
                self.previousIssue();
            }

            dfx.remove(issueElement);
            self._updateIssueNumber();
        }, 500);

        // Remove it from the list.
        var listItem    = dfx.getClass('ViperAP-issueItem')[(this._currentIssue - 1)];
        var currentList = listItem.parentNode;
        var prevList    = currentList;
        if (listItem) {
            dfx.remove(listItem);
        }

        // Move the first issue from each list after the current one to the previous
        // list.
        for (var list = currentList.nextSibling; list; list = list.nextSibling) {
            if (!list.firstChild) {
                dfx.remove(list);
                break;
            }

            prevList.appendChild(list.firstChild);
            prevList = list;
            if (!list.firstChild) {
                // This list has no items, remove it and update the page count.
                dfx.remove(list);
                self.updatePageCount();
                break;
            }
        }

    },

    getIssueElement: function(issueNum)
    {
        var issueElement = dfx.getClass('ViperAP-issuePane')[(issueNum - 1)];
        return issueElement;

    },

    _createIssue: function(msg)
    {
        var li = document.createElement('li');
        dfx.addClass(li, 'ViperAP-issueItem');

        var issueType = this._getIssueType(msg);

        switch (msg.type) {
            case HTMLCS.ERROR:
                this._errorCount++;
            break;

            case HTMLCS.WARNING:
                this._warningCount++;
            break;

            case HTMLCS.NOTICE:
                this._noticeCount++;
            break;

            default:
                // Unknown type.
            break;
        }//end switch

        var liContent = '<span class="ViperAP-issueType ' + issueType + '"></span>';
        liContent    += '<span class="ViperAP-issueTitle">' + dfx.ellipsize(msg.msg, 140) + '</span>';

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

        var code = this._parseCode(issue.code);

        var content = '<div class="ViperAP-issueDetails">';
        content    += '<span class="ViperAP-issueType ' + issueType + '"></span>';
        content    += '<div class="issueTitle">' + issue.msg + '</div>';
        content    += '<div class="issueWcag">';
        content    += '<strong>' + code.standard + ' References</strong><br>';
        content    += '<em>Principle: </em> <a target="_blank" href="http://www.w3.org/TR/2008/REC-WCAG20-20081211/#' + code.principleName + '">' + dfx.ucFirst(code.principleName) + '</a><br>';
        content    += '<em>Techniques: </em> ';

        var techStrs = [];
        for (var i = 0; i < code.techniques.length; i++) {
            techStrs.push('<a target="_blank" href="http://www.w3.org/TR/2010/NOTE-WCAG20-TECHS-20101014/' + code.techniques[i] + '">' + code.techniques[i] + '</a>');
        }

        content += techStrs.join(', ');
        content += '<br>';
        content += '</div></div><div class="issueDoneDiv"></div><!-- End References -->';
        dfx.setHtml(main, content);

        var resolutionCont = document.createElement('div');

        content  = '<div class="ViperAP-issueResolution">';
        content += '<div class="resolutionHeader"><strong>Resolution</strong>';
        dfx.setHtml(resolutionCont, content);

        main.appendChild(resolutionCont);

        var resolutionHeader = dfx.getClass('resolutionHeader', resolutionCont)[0];

        // Create resolution tools.
        var self          = this;
        var locateBtn     = this._toolbar.createButton('', false, 'Locate Element', false, 'locate', function() {
            self.pointToElement(issue.element);
        }, null, null, resolutionHeader);
        var sourceViewBtn = this._toolbar.createButton('', false, 'Show in Source View', false, 'sourceView', function() {
            var tmpText = document.createTextNode('__SCROLL_TO_HERE__');
            dfx.insertAfter(issue.element, tmpText);
            var sourceViewPlugin = self.viper.getPluginManager().getPlugin('ViperSourceViewPlugin');
            var contents = sourceViewPlugin.getContents();
            dfx.remove(tmpText);
            sourceViewPlugin.showSourceView(contents, function() {
                sourceViewPlugin.scrollToText('__SCROLL_TO_HERE__');
                setTimeout(function() {
                    sourceViewPlugin.replaceSelection('');
                }, 500);
            });
        }, null, null, resolutionHeader);
        var doneBtn = this._toolbar.createButton('Done', false, 'Mark as done', false, '', function() {
            self.markAsDone();
        }, null, null, resolutionHeader);

        resolutionHeader.appendChild(locateBtn);
        resolutionHeader.appendChild(sourceViewBtn);
        resolutionHeader.appendChild(doneBtn);

        this._addResolutionContent(issue, main);

        this._issueDetailsWrapper.appendChild(main);

    },

    pointToElement: function(element)
    {
        if (!element) {
            return;
        }

        var rect = dfx.getBoundingRectangle(element);

        var highlight = document.createElement('div');
        dfx.addClass(highlight, 'ViperAP-highlight');
        dfx.setStyle(highlight, 'left', rect.x1 + 'px');
        dfx.setStyle(highlight, 'width', (rect.x2 - rect.x1) + 'px');
        dfx.setStyle(highlight, 'top', rect.y1 + 'px');
        dfx.setStyle(highlight, 'height', (rect.y2 - rect.y1) + 'px');

        document.body.appendChild(highlight);
        setTimeout(function() {
            dfx.remove(highlight);
        }, 2000);
    },

    _parseCode: function(code)
    {
        var sections = code.split('.');
        var parsed   = {};
        parsed.standard = sections[0];

        if (sections[1].indexOf('Principle') === 0) {
            var principle = sections[1].replace('Principle', '');
            var principleName = '';
            switch (principle) {
                case '1':
                    principleName = 'perceivable';
                break;

                case '2':
                    principleName = 'operable';
                break;

                case '3':
                    principleName = 'understandable';
                break;

                case '4':
                    principleName = 'robust';
                break;
            }

            parsed.principle     = principle;
            parsed.principleName = principleName;
        }

        if (sections[2].indexOf('Guideline') === 0) {
            parsed.guideline = sections[2].replace('Guideline', '').replace('_', '.');
        }

        parsed.section = sections[3].replace('_', '.');

        parsed.techniques = [];

        var techniques = sections[4].split(',');
        for (var i = 0; i < techniques.length; i++) {
            parsed.techniques.push(techniques[i]);
        }

        return parsed;

    },

    _addResolutionContent: function(issue, detailsElement)
    {
        // Load resolution content.
        var code = this._parseCode(issue.code);
        var self = this;

        this._loadCodeScript(code, function() {
            var content = self._getCodeContent(code, issue);
            if (!content) {
                return;
            }

            dfx.addClass(content, 'resolutionContent');
            detailsElement.appendChild(content);
        });

    },

    _loadCodeScript: function(code, callback)
    {
        var url = this.viper.getViperPath();
        url    += 'Plugins/ViperAccessibilityPlugin/Resolutions/';
        url    += code.standard + '/Principle' + code.principle;
        url    += '/Guideline' + code.guideline.replace('.', '_');

        var scriptUrl = url + '/resolutions.js';
        var cssUrl    = url + '/resolutions.css';

        if (this._loadedScripts.find(scriptUrl) >= 0) {
            callback.call(this);
            return;
        }

        // Load the script file only once. Any multiple requests to load the same
        // script file will be added to the loadCallbacks, once the file is available
        // all the callbacks will be executed.
        if (!this._loadCallbacks[scriptUrl]) {
            this._loadCallbacks[scriptUrl] = [callback];

            var self = this;
            this._includeCss(cssUrl, function() {});
            this._includeScript(scriptUrl, function() {
                for (var i = 0; i < self._loadCallbacks[scriptUrl].length; i++) {
                    self._loadCallbacks[scriptUrl][i].call(self);
                }

                delete self._loadCallbacks[scriptUrl];
            });

        } else {
            this._loadCallbacks[scriptUrl].push(callback);
        }

    },

    _getCodeContent: function(code, issue)
    {
        var propStr = 'ViperAccessibilityPlugin_' + code.standard + '_Principle' + code.principle + '_Guideline' + code.guideline.replace('.', '_');
        var prop = window[propStr];
        if (!prop) {
            return null;
        }

        var fn = prop['res_' + code.section.replace('.', '_')];
        if (!fn) {
            return null;
        }

        var content = fn.call(prop, issue.element, code);
        return content;

    },

    _getIssueTypeFromElement: function(issueElement)
    {
        var typeElement = dfx.getClass('ViperAP-issueType', issueElement)[0];
        if (dfx.hasClass(typeElement, 'error') === true) {
            return HTMLCS.ERROR;
        } else if (dfx.hasClass(typeElement, 'warning') === true) {
            return HTMLCS.WARNING;
        } else if (dfx.hasClass(typeElement, 'manual') === true) {
            return HTMLCS.NOTICE;
        }

        return null;

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

            default:
                issueType = '';
            break;
        }

        return issueType;

    },

    /**
     * Includes the specified JS file.
     *
     * @param {string}   src      The URL to the JS file.
     * @param {function} callback The function to call once the script is loaded.
     */
    _includeScript: function(src, callback) {
        var script    = document.createElement('script');
        script.onload = function() {
            script.onload = null;
            script.onreadystatechange = null;
            callback.call(this);
        };

        script.onreadystatechange = function() {
            if (/^(complete|loaded)$/.test(this.readyState) === true) {
                script.onreadystatechange = null;
                script.onload();
            }
        }

        script.src = src;

        if (document.head) {
            document.head.appendChild(script);
        } else {
            document.getElementsByTagName('head')[0].appendChild(script);
        }
    },

    /**
     * Includes the specified JS file.
     *
     * @param {string}   src      The URL to the JS file.
     * @param {function} callback The function to call once the script is loaded.
     */
    _includeCss: function(href, callback) {
        var link    = document.createElement('link');
        link.rel    = 'stylesheet';
        link.media  = 'screen';
        link.onload = function() {
            link.onload = null;
            link.onreadystatechange = null;
            callback.call(this);
        };

        link.onreadystatechange = function() {
            if (/^(complete|loaded)$/.test(this.readyState) === true) {
                link.onreadystatechange = null;
                link.onload();
            }
        }

        link.href = href;

        if (document.head) {
            document.head.appendChild(link);
        } else {
            document.getElementsByTagName('head')[0].appendChild(link);
        }
    }

};
