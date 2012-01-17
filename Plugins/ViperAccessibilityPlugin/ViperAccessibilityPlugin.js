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
    this._includeNotices      = false;
    this._loadedScripts       = [];
    this._loadCallbacks       = {};
    this._includedCSS         = [];
    this._standard            = 'WCAG2AAA';
    this._standards           = {
        WCAG2AAA: 'WCAG 2.0 AAA',
        WCAG2AA: 'WCAG 2.0 AA',
        WCAG2A: 'WCAG 2.0 A'
    }

    this._htmlCSsrc = '../../../HTML_CodeSniffer/HTMLCS.js';

}

ViperAccessibilityPlugin.prototype = {
    init: function()
    {
        var self = this;
        this._createToolbarItems();

    },

    setSettings: function(settings)
    {
        if (!settings) {
            return;
        }

        if (settings.standards) {
            this._standards = standards;
        }

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
        aaTools.element.id = this.viper.getId() + '-VAP';
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
        var includeNoticesChbox = this.viper.ViperTools.createCheckbox('Always include Notices', this._includeNotices);
        listFilters.appendChild(includeNoticesChbox);
        div.appendChild(listFilters);

        // Accessibility Standard.
        var standards = document.createElement('div');
        dfx.addClass(standards, 'accessStandard');
        dfx.setHtml(standards, '<h1>Accessibility Standard</h1><p>Choose which standard you would like to check your content against.</p>');
        div.appendChild(standards);

        for (var standardId in this._standards) {
            var selected = false;
            if (standardId === this._standard) {
                selected = true;
            }

            standards.appendChild(this.viper.ViperTools.createRadiobutton('standard', standardId, this._standards[standardId], selected));
        }

        // Re check button.
        var self       = this;
        var reCheckSec = document.createElement('div');
        dfx.addClass(reCheckSec, 'reCheckSec');
        var reCheck = this.viper.ViperTools.createButton('Re-check Content', false, 'Re-check Content', false, '', function() {
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
                dfx.setHtml(pageCounter, self._currentList + ' of ' + self._pageCount);
            });

            dfx.addClass(pageCounter, 'ViperAP-listNav-pageCounter');
            dfx.setHtml(pageCounter, '1 of ' + self._pageCount);
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
                dfx.setHtml(pageCounter, self._currentList + ' of ' + self._pageCount);
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

        dfx.setHtml(this._listPageCounter, this._currentList + ' of ' + listCount);

    },

    /**
     * Marks current issue as done.
     */
    toggleIssueCompleteState: function()
    {
        var issueElement = this.getIssueElement(this._currentIssue);
        dfx.toggleClass(issueElement, 'issueDone');

        var listItem = dfx.getClass('ViperAP-issueItem')[(this._currentIssue - 1)];
        dfx.toggleClass(listItem, 'issueDone');

        if (dfx.hasClass(issueElement, 'issueDone') === true) {
            var self = this;
            setTimeout(function() {
                if (self._currentIssue > self._issueCount) {
                    self.previousIssue();
                } else {
                    self.nextIssue();
                }
            }, 500);
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
        liContent    += '<span class="ViperAP-issueTitle">' + dfx.ellipsize(msg.msg, 130) + '</span>';

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
        this._issueDetailsWrapper.appendChild(main);

        var self = this;
        this._loadStandard(issue.code, function(standardObj) {
            var issueType = this._getIssueType(issue);

            standardObj.getReferenceContent(issue, function(refContent) {
                var references = document.createElement('div');
                dfx.addClass(references, 'ViperAP-issueDetails');

                var content = '<span class="ViperAP-issueType ' + issueType + '"></span>';
                content    += '<div class="issueTitle">' + issue.msg + '</div>';

                dfx.setHtml(references, content);
                references.appendChild(refContent);

                var issueDoneDiv = document.createElement('div');
                dfx.addClass(issueDoneDiv, 'issueDoneDiv');
                references.appendChild(issueDoneDiv);

                main.appendChild(references);
            }, self);

            standardObj.getResolutionContent(issue, function(resContent) {
                var resolutionCont = document.createElement('div');
                dfx.addClass(resolutionCont, 'ViperAP-issueResolution');
                dfx.setHtml(resolutionCont, '<div class="resolutionHeader"><strong>Resolution</strong></div>');
                main.appendChild(resolutionCont);

                var resolutionHeader = dfx.getClass('resolutionHeader', resolutionCont)[0];

                // Create resolution tools.
                var locateBtn     = self._toolbar.createButton('', false, 'Locate Element', false, 'locate', function() {
                    self.pointToElement(issue.element);
                }, null, null, resolutionHeader);
                var sourceViewBtn = self._toolbar.createButton('', false, 'Show in Source View', false, 'sourceView', function() {
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
                var doneBtn = self._toolbar.createButton('Done', false, 'Mark as done', false, '', function() {
                    self.toggleIssueCompleteState();
                }, null, null, resolutionHeader);

                resolutionHeader.appendChild(locateBtn);
                resolutionHeader.appendChild(sourceViewBtn);
                resolutionHeader.appendChild(doneBtn);

                if (resContent) {
                    resolutionCont.appendChild(resContent);
                }
            }, self);
        });

    },

    pointToElement: function(element)
    {
        this.pointer.container = this._aaTools.element;
        this.pointer.pointTo(null, null, element);

    },

    _loadStandard: function(issueCode, callback)
    {
        // Load the standard's file.
        var url = this.viper.getViperPath();
        url    += 'Plugins/ViperAccessibilityPlugin/Resolutions/';

        // First part of the issueCode must the standard name.
        var parts    = issueCode.split('.');
        var standard = parts[0];
        if (standard.indexOf('WCAG2') === 0) {
            standard = 'WCAG2';
        }

        var standardScriptUrl = url + standard + '/' + standard + '.js';

        this.loadObject(standardScriptUrl, 'ViperAccessibilityPlugin_' + standard, callback);

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

    loadObject: function(src, objName, callback)
    {
        if (this._loadedScripts.find(src) >= 0) {
            callback.call(this, window[objName]);
            return;
        }

        // Load the script file only once. Any multiple requests to load the same
        // script file will be added to the loadCallbacks, once the file is available
        // all the callbacks will be executed.
        if (!this._loadCallbacks[src]) {
            this._loadCallbacks[src] = [callback];

            var self = this;
            this.includeScript(src, function() {
                for (var i = 0; i < self._loadCallbacks[src].length; i++) {
                    self._loadCallbacks[src][i].call(self, window[objName]);
                }

                delete self._loadCallbacks[src];
            });

        } else {
            this._loadCallbacks[src].push(callback);
        }//end if

    },

    /**
     * Includes the specified JS file.
     *
     * @param {string}   src      The URL to the JS file.
     * @param {function} callback The function to call once the script is loaded.
     */
    includeScript: function(src, callback) {
        //if (this._loadedScripts.find(src) >= 0) {
        //    callback.call(this);
        //    return;
        //}

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
    includeCss: function(href) {
        if (this._includedCSS.find(href) >= 0) {
            return;
        }

        this._includedCSS.push(href);

        var link    = document.createElement('link');
        link.rel    = 'stylesheet';
        link.media  = 'screen';
        link.onload = function() {
            link.onload = null;
            link.onreadystatechange = null;
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
    },

    pointer:
    {
        pointer: null,
        pointerDim: {},
        container: null,

        pointTo: function(elemid, elemClass, elem) {
            if (!elem) {
                if (!elemid || elemid === '') {
                    if (!elemClass || elemClass === '') {
                        return;
                    }

                    // Get the first element that has the elemClass.
                    var celems = dfx.getClass(elemClass);
                    var cln    = celems.length;
                    for (var i = 0; i < cln; i++) {
                        if (dfx.getElementWidth(celems[i]) > 0) {
                            elem = celems[i];
                            break;
                        }
                    }
                } else if (elemClass && elemClass !== '*') {
                    elem = dfx.getClass(elemClass, dfx.getId(elemid))[0];
                } else {
                    // Get the elem element using the DOM element id.
                    elem = dfx.getId(elemid);
                }
            }//end if

            // If the specified elem is not in the DOM then we cannot point to it.
            if (!elem) {
                return;
            }

            // Do not point to elem if its hidden.
            if (dfx.getStyle(elem, 'visibility', 'hidden') === true) {
                return;
            }

            // Get element coords.
            var rect = dfx.getBoundingRectangle(elem);

            // If we cannot get the position then dont do anything,
            // most likely element is hidden.
            if (rect.x1 === 0
                && rect.x2 === 0
                || rect.x1 === rect.x2
                || rect.y1 === rect.y2
            ) {
                return;
            }

            // Determine where to show the arrow.
            var winDim = dfx.getWindowDimensions();

            var pointer = this.getPointer();

            dfx.setStyle(pointer, 'display', 'block');
            if (dfxjQuery.support.opacity === true) {
                dfx.setOpacity(pointer, 1);
            }

            var pointerRect = dfx.getBoundingRectangle(pointer);
            var pointerH    = (pointerRect.y2 - pointerRect.y1);
            var pointerW    = (pointerRect.x2 - pointerRect.x1);

            this.pointerDim.height = pointerH;
            this.pointerDim.width  = pointerW;

            var bounceHeight = 20;
            var scroll       = dfx.getScrollCoords();

            // Scroll in to view if not visible.
            if (elem.scrollIntoView && (rect.y1 < scroll.y || rect.y1 > scroll.y + winDim.height)) {
                elem.scrollIntoView(false);
            }

            // Try to position the pointer.
            if ((rect.y1 - pointerH - bounceHeight) > scroll.y) {
                // Arrow direction down.
                this.showPointer(elem, 'down');
            } else if ((rect.y2 + pointerH) < (winDim.height - scroll.y)) {
                // Up.
                this.showPointer(elem, 'up');
            } else if ((rect.y2 + pointerW) < winDim.width) {
                // Left.
                this.showPointer(elem, 'left');
            } else if ((rect.y1 - pointerW) > 0) {
                // Right.
                this.showPointer(elem, 'right');
            }
        },

        getPointer: function() {
            if (!this.pointer) {
                this.pointer = document.createElement('div');
                var c        = 'ViperAP';
                dfx.addClass(this.pointer, c + '-pointer');
                dfx.addClass(this.pointer, c + '-pointer-hidden');
                document.body.appendChild(this.pointer);
            }

            return this.pointer;
        },

        showPointer: function(elem, direction) {
            var c = 'ViperAP';

            this._removeDirectionClasses();
            dfx.addClass(this.pointer, c + '-pointer-' + direction);
            dfx.removeClass(this.pointer, c + '-pointer-hidden');

            var rect         = dfx.getBoundingRectangle(elem);
            var top          = 0;
            var left         = 0;
            var bounceHeight = 20;
            switch (direction) {
                case 'up':
                    bounceHeight = (-bounceHeight);
                    top          = rect.y2;
                    if ((rect.x2 - rect.x1) < 250) {
                        left = (this.getRectMidPnt(rect) - (this.pointerDim.width / 2));
                    } else {
                        left = rect.x1;
                    }
                break;

                case 'left':
                    left = rect.x2;
                    top  = this.getRectMidPnt(rect, true);
                break;

                case 'right':
                    left = (rect.x1 - this.pointerDim.width);
                    top  = this.getRectMidPnt(rect, true);
                break;

                case 'down':
                default:
                    top = (rect.y1 - this.pointerDim.height);
                    if ((rect.x2 - rect.x1) < 250) {
                        left = (this.getRectMidPnt(rect) - (this.pointerDim.width / 2));
                    } else {
                        left = rect.x1;
                    }
                break;
            }//end switch

            dfx.setStyle(this.pointer, 'top', top + 'px');
            dfx.setStyle(this.pointer, 'left', left + 'px');

            // Check if the help window is under the pointer then re-position it.
            // Unless it is an element within the ViperAP pop-up.
            var coords    = dfx.getBoundingRectangle(this.container);
            rect          = dfx.getBoundingRectangle(this.pointer);
            var posOffset = 20;
            var newPos    = null;
            var midX      = (rect.x1 + ((rect.x2 - rect.x1) / 2));
            var midY      = (rect.y1 + ((rect.y2 - rect.y1) / 2));
            if (coords.x1 <= midX
                && coords.x2 >= midX
                && coords.y1 <= midY
                && coords.y2 >= midY
            ) {
                var self = this;
                dfx.setStyle(this.container, 'opacity', 0.5);
                setTimeout(function() {
                    dfx.setStyle(self.container, 'opacity', 1);
                }, 4000);
            }

            // Stop all pointer animations.
            dfx.stop(this.pointer);

            clearTimeout(this._fadeTimer);
            var self = this;
            dfx.bounce(this.pointer, 4, bounceHeight, function() {
                self._fadeTimer = setTimeout(function() {
                    if (dfxjQuery.support.opacity === true) {
                        dfx.fadeOut(self.pointer, 600);
                    } else {
                        dfx.setStyle(self.pointer, 'display', 'none');
                    }
                }, 1000);
            });
        },

        hidePointer: function() {
            if (this.pointer) {
                // Stop all animations.
                dfx.stop(this.pointer);
                // Fade out.
                dfx.fadeOut(this.pointer, 200);
            }
        },

        getRectMidPnt: function(rect, height) {
            var midPnt = 0;
            if (height === true) {
                midPnt = (rect.y1 + ((rect.y2 - rect.y1) / 2));
            } else {
                midPnt = (rect.x1 + ((rect.x2 - rect.x1) / 2));
            }

            return midPnt;
        },

        _removeDirectionClasses: function() {
            var c = 'ViperAP';
            var d = ['down', 'up', 'left', 'right'];
            var l = d.length;
            for (var i = 0; i < l; i++) {
                dfx.removeClass(this.pointer, c + '-pointer-' + d[i]);
            }
        }

    }

};
