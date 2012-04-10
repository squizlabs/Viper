function ViperAccessibilityPlugin(viper)
{
    this.viper                = viper;
    this._tools               = viper.ViperTools;
    this._issueList           = null;
    this._autoRunInterval     = 30000;
    this._issues              = [];
    this._dismissedIssues     = {};
    this._autoRunTimer        = null;
    this._subSection          = null;
    this._toolbar             = null;
    this._loadedScripts       = [];
    this._loadCallbacks       = {};
    this._includedCSS         = [];
    this._standard            = 'WCAG2AAA';
    this._standards           = {
        WCAG2AAA: 'WCAG 2.0 AAA',
        WCAG2AA: 'WCAG 2.0 AA',
        WCAG2A: 'WCAG 2.0 A'
    };

    this._htmlcsWrapper = document.createElement('div');
    this._htmlCSsrc     = '../../../sdanis_HTML_CodeSniffer/';

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
            this._standards = settings.standards;
        }

        if (settings.standard) {
            this._standard = settings.standard;
        }

    },

    getIssues: function()
    {
        var self = this;
        if (!window.HTMLCSAuditor) {
            this.includeScript(this._htmlCSsrc + '/HTMLCS.js', function() {
                self.includeScript(self._htmlCSsrc + 'Auditor/HTMLCSAuditor.js', function() {
                    var link   = document.createElement('link');
                    link.rel   = 'stylesheet';
                    link.media = 'screen';
                    link.href  = self._htmlCSsrc + 'Auditor/HTMLCSAuditor.css';
                    document.getElementsByTagName('head')[0].appendChild(link);

                    self.getIssues();
                });
            });

            return;
        }//end if

        dfx.setHtml(this._htmlcsWrapper, '');
        HTMLCSAuditor.run(this._standard, this.viper.getViperElement(), {
            noHeader: true,
            parentElement: self._htmlcsWrapper,
            customIssueSource: function(id, issue, standard, resolutionElem, detailsElem) {
                self._createIssueDetail(id, issue, resolutionElem, detailsElem);
            }
        });

    },

    _createIssueDetail: function(id, issue, resolutionElem, detailsElem)
    {
        var issueDoneElem = document.createElement('div');
        dfx.addClass(issueDoneElem, 'issueDoneCont');
        detailsElem.appendChild(issueDoneElem);

        var main = resolutionElem;
        dfx.addClass(main, 'ViperAP-issuePane');

        var issueType = this._getIssueType(issue);

        var self = this;
        this._loadStandard(issue.code, function(standardObj) {
            var resolutionCont = document.createElement('div');
            dfx.addClass(resolutionCont, 'ViperAP-issueResolution');

            var resHtml = '<div class="resolutionHeader"><strong>Resolution</strong></div>';

            dfx.setHtml(resolutionCont, resHtml);
            main.appendChild(resolutionCont);

            var resolutionHeader = dfx.getClass('resolutionHeader', resolutionCont)[0];

            // Create resolution tools.
            var tools = self.viper.ViperTools;
            var locateBtn     = tools.createButton('VAP:locateElem', '', 'Locate Element', 'locate', function() {
                HTMLCSAuditor.pointToElement(issue.element);
            });
            resolutionHeader.appendChild(locateBtn);
            var sourceViewBtn = tools.createButton('VAP:showInSource', '', 'Show in Source View', 'sourceView', function() {
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
            });
            resolutionHeader.appendChild(sourceViewBtn);

            var refreshIssueBtn = tools.createButton('VAP:toggleIssueDone', '', 'Refresh Issue', 'accessRerun', function() {
                self.refreshIssue(id, issue, detailsElem, detailsElem);
            });
            resolutionHeader.appendChild(refreshIssueBtn);

            var defaultContent = standardObj.getDefaultContent(issue);
            resolutionCont.appendChild(defaultContent);
            standardObj.getResolutionContent(issue, defaultContent, self);
        });

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

            if (document.head) {
                document.head.appendChild(script);
            } else {
                document.getElementsByTagName('head')[0].appendChild(script);
            }

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
        var tools     = this.viper.ViperTools;

        this.viper.registerCallback('ViperToolbarPlugin:enabled', 'ViperAccessibilityPlugin', function(data) {
            self.viper.ViperTools.enableButton('accessibility');
        });

        // Create the Toolbar Bubble for the plugin interface. The bubble's main content
        // is the tools section.
        var aaTools = toolbar.createBubble('VAP:bubble', 'Accessibility Auditor - ' + this._standard, null, null, function() {
            self.getIssues();
        }, function() {
        }, 'ViperAccessibilityPlugin');
        aaTools.id = this.viper.getId() + '-VAP';

        // Create the sub section.
        var bubble       = toolbar.getBubble('VAP:bubble');
        var subSection   = bubble.addSubSection('VAP:subSection', this._htmlcsWrapper);
        this._subSection = subSection;
        bubble.setSetting('keepOpen', true);
        toolbar.getBubble('VAP:bubble').showSubSection('VAP:subSection');

        // The main toolbar button to toggle the toolbar bubble on and off.
        var vapButton = tools.createButton('accessibility', '', 'Accessibility Auditor', 'accessAudit', null, true);
        toolbar.setBubbleButton('VAP:bubble', 'accessibility');
        toolbar.addButton(vapButton);

    },

    showIssueList: function(instant)
    {
        // Show the list tools.
        dfx.removeClass(this._toolsSection, 'checkTools');
        dfx.removeClass(this._toolsSection, 'detailTools');
        dfx.addClass(this._toolsSection, 'listTools');

        // Show the list.
        dfx.removeClass(this._resultsMiddle, 'issueDetails');
        dfx.addClass(this._resultsMiddle, 'issueList');

        if (instant === true) {
            dfx.addClass(this._issueList, 'instant');
        }

        dfx.setStyle(this._issueList, 'margin-left', 0);
        dfx.removeClass(this._issueList, 'instant');

    },

    updateResults: function(checkOnly)
    {
        var self = this;

        this.stopAutoRun();

        if (checkOnly !== true) {
            // Show loading sub section only.
            dfx.setStyle(dfx.getClass('ViperAP-cont', this._subSection), 'display', 'none');
            dfx.setStyle(dfx.getClass('loadingCont', this._subSection)[0], 'display', 'block');

            // Set the sub section to be visible.
            this._toolbar.getBubble('VAP:bubble').showSubSection('VAP:subSection');
        }

        // Run the HTMLCS checks.
        this.runChecks(function() {
            // Get the messages from HTMLCS.
            var msgs = HTMLCS.getMessages();

            if (checkOnly === true) {
                if (msgs.length === 0) {
                    dfx.removeClass(toggleButton, 'issues');
                    dfx.addClass(toggleButton, 'noIssues');
                } else {
                    dfx.removeClass(toggleButton, 'noIssues');
                    dfx.addClass(toggleButton, 'issues');
                }

                return;
            }

            // Hide loading sub section and show the main panel and results panel.
            self.showIssueList(true);

            // Hide the loading container.
            dfx.setStyle(dfx.getClass('loadingCont', self._subSection)[0], 'display', 'none');

            // Main toolbar buttons.
            var toggleButton = self.viper.ViperTools.getItem('accessibility').element;

            if (msgs.length === 0) {
                // No messages, show no results message.
                dfx.setStyle(dfx.getClass('noResultsCont', self._subSection)[0], 'display', 'block');
                dfx.removeClass(toggleButton, 'issues');
                dfx.addClass(toggleButton, 'noIssues');
            } else {
                // There are messages so update the issue list.
                self._updateIssues(msgs);
                dfx.setStyle(dfx.getClass('resultsCont', self._subSection)[0], 'display', 'block');
                dfx.removeClass(toggleButton, 'noIssues');
                dfx.addClass(toggleButton, 'issues');
            }
        });

    },

    refreshIssue: function(issueNum, issue, issueElem, issueDetails)
    {
        dfx.addClass(issueElem, 'rechecking');

        // Add the re-checking issue overlay.
        var issueRecheck = document.createElement('div');
        dfx.addClass(issueRecheck, 'ViperAP-issueRecheck');
        issueDetails.appendChild(issueRecheck);

        dfx.setHtml(issueRecheck, '<div class="issueChecking">Re-checking issue …</div>');

        var self     = this;
        this.runChecks(function() {
            var msgs  = HTMLCS.getMessages();
            var found = false;
            for (var i in msgs) {
                if (msgs[i].code === issue.code && msgs[i].element === issue.element) {
                    found = true;
                    break;
                }
            }

            if (found === false) {
                dfx.setHtml(issueRecheck, '');
                dfx.removeClass(issueElem, 'rechecking');

                // Mark issue as done.
                self.fixIssue(issueNum, true);
            } else {
                dfx.empty(issueRecheck);
                var issueRemains = document.createElement('div');
                dfx.addClass(issueRemains, 'issueRemains');
                dfx.setHtml(issueRemains, '<span class="recheckMessage">This issue has not been resolved</span>');
                issueRemains.appendChild(self.viper.ViperTools.createButton('VAP-issues:notResolvedBtn', 'OK', '', '', function() {
                    dfx.setHtml(issueRecheck, '');
                    dfx.removeClass(issueElem, 'rechecking');
                }));
                issueRecheck.appendChild(issueRemains);
            }
        });

    },

    startAutoRun: function()
    {
        var self = this;
        this._autoRunTimer = setInterval(function() {
            self.updateResults(true);
        }, this._autoRunInterval);

    },

    stopAutoRun: function()
    {
        clearInterval(this._autoRunTimer);

    },

    dismissIssue: function(issueNum)
    {
        issueNum  = issueNum || (this._currentIssue - 1);
        var issue = this._issues[issueNum];

        if (!this._dismissedIssues[issue.code]) {
            this._dismissedIssues[issue.code] = [];
        }

        if (this._dismissedIssues[issue.code].inArray(issue.element) !== true) {
            this._dismissedIssues[issue.code].push(issue.element);
            this._markAsDone(issueNum);
        }

        var self = this;
        setTimeout(function() {
            if (issueNum > self._issueCount) {
                self.previousIssue();
            } else {
                self.nextIssue();
            }
        }, 800);

    },

    fixIssue: function(issueNum, goNext)
    {
        var issueElement = this.getIssueElement(issueNum, 'details');
        dfx.addClass(issueElement, 'issueDone');

        var listItem = this.getIssueElement(issueNum, 'listItem');
        dfx.addClass(listItem, 'issueDone');

        if (goNext === true) {
            var self = this;
            setTimeout(function() {
                dfx.trigger(dfx.getId('HTMLCS-button-next-issue'), 'click');
            }, 800);
        }

    },

    _markAsDone: function(issueNum)
    {
        issueNum  = issueNum || (this._currentIssue - 1);

        var issueElement = this.getIssueElement(issueNum + 1);
        dfx.addClass(issueElement, 'issueDone');

        var listItem = dfx.getClass('ViperAP-issueItem')[issueNum];
        dfx.addClass(listItem, 'issueDone');

    },

    getIssueElement: function(issueNum, section)
    {
        if (section === 'listItem') {
            return dfx.getId('HTMLCS-msg-' + issueNum);
        }

        var issueElement = dfx.getId('HTMLCS-msg-detail-' + issueNum);
        if (section === 'details') {
            issueElement = dfx.getClass('HTMLCS-issue-details', issueElement)[0];
        }

        return issueElement;

    },

    _loadStandard: function(issueCode, callback)
    {
        // Load the standard's file.
        var url = this.viper.getViperPath();
        url    += '/Plugins/ViperAccessibilityPlugin/Resolutions/';

        // First part of the issueCode must the standard name.
        var parts    = issueCode.split('.');
        var standard = parts[0];
        if (standard.indexOf('WCAG2') === 0) {
            standard = 'WCAG2';
        }

        var standardScriptUrl = url + standard + '/' + standard + '.js';

        this.loadObject(standardScriptUrl, 'ViperAccessibilityPlugin_' + standard, callback);

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
        if (window[objName] || this._loadedScripts.find(src) >= 0) {
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
    }

};
