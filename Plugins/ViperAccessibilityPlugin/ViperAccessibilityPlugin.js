/**
 * +--------------------------------------------------------------------+
 * | This Squiz Viper file is Copyright (c) Squiz Australia Pty Ltd     |
 * | ABN 53 131 581 247                                                 |
 * +--------------------------------------------------------------------+
 * | IMPORTANT: Your use of this Software is subject to the terms of    |
 * | the Licence provided in the file licence.txt. If you cannot find   |
 * | this file please contact Squiz (www.squiz.com.au) so we may        |
 * | provide you a copy.                                                |
 * +--------------------------------------------------------------------+
 *
 */

function ViperAccessibilityPlugin(viper)
{
    this.viper            = viper;
    this._toolbar         = null;
    this._loadedScripts   = [];
    this._loadCallbacks   = {};
    this._includedCSS     = [];
    this._standard        = 'WCAG2AAA';
    this._dismissedIssues = {};
    this._htmlcsWrapper   = document.createElement('div');

    var url = this.viper.getViperPath();
    url    += '/Plugins/ViperAccessibilityPlugin/HTML_CodeSniffer/';
    this._htmlCSsrc = url;

}

ViperAccessibilityPlugin.prototype = {
    init: function()
    {
        var self = this;
        this._createToolbarItems();

        this.viper.registerCallback('Viper:clickedOutside', 'ViperAccessibilityPlugin', function() {
            dfx.remove(dfx.getClass('HTMLCS-pointer'));
        });

        this.viper.registerCallback('ViperToolbarPlugin:updateToolbar', 'ViperAccessibilityPlugin', function(data) {
            self.viper.ViperTools.enableButton('accessibility');
        });

    },

    setSettings: function(settings)
    {
        if (!settings) {
            return;
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
        HTMLCSAuditor.pointerContainer = this._toolbar.getBubble('VAP:bubble').element;
        HTMLCSAuditor.run(this._standard, this.viper.getViperElement(), {
            noHeader: true,
            includeCss: false,
            parentElement: self._htmlcsWrapper,
            customIssueSource: function(id, issue, standard, resolutionElem, detailsElem) {
                self._createIssueDetail(id, issue, resolutionElem, detailsElem);
            },
            listUpdateCallback: function(issues) {
                // Re mark the issues that were dismissed as done.
                self._remarkDismissedIssues(issues);
            },
            runCallback: function(issues) {
                self.viper.removeCallback(null, 'ViperAccessibilityPlugin:resolution');
                self._updateStandard();
                return self._moveDismissedIssuesToEnd(issues);
            },
            showIssueCallback: function(issueid) {
                self.viper.fireCallbacks('ViperAccessibilityPlugin:showResolution:' + issueid);
            },
            ignoreMsgCodes: [
                /Guideline1_4\.1_4_3/,
                /Guideline1_4\.1_4_6/
            ]
        });

    },

    loadHTMLCS: function(callback)
    {
        if (window.HTMLCS) {
            callback.call(this);
        } else {
            this.includeScript(this._htmlCSsrc + '/HTMLCS.js', callback);
        }

    },

    _createIssueDetail: function(id, issue, resolutionElem, detailsElem)
    {
        var issueDoneElem = document.createElement('div');
        dfx.addClass(issueDoneElem, 'Viper-issueDoneCont');
        detailsElem.appendChild(issueDoneElem);

        var main = resolutionElem;
        dfx.addClass(main, 'ViperAP-issuePane');

        var issueType = this._getIssueType(issue);

        var self = this;
        this._loadStandard(issue.code, function(standardObj) {
            var resolutionCont = document.createElement('div');
            dfx.addClass(resolutionCont, 'ViperAP-issueResolution');

            var resHtml = '<div class="Viper-resolutionHeader"><strong>Resolution</strong></div>';

            dfx.setHtml(resolutionCont, resHtml);
            main.appendChild(resolutionCont);

            var resolutionHeader = dfx.getClass('Viper-resolutionHeader', resolutionCont)[0];

            // Create resolution tools.
            var tools = self.viper.ViperTools;
            var locateBtn     = tools.createButton('VAP:locateElem', '', _('Locate Element'), 'Viper-locate', function() {
                HTMLCSAuditor.pointToElement(issue.element);
            });
            resolutionHeader.appendChild(locateBtn);
            var sourceViewBtn = tools.createButton('VAP:showInSource', '', _('Show in Source View'), 'Viper-sourceView', function() {
                var tmpText = document.createTextNode('__STH__');
                dfx.insertAfter(issue.element, tmpText);
                var sourceViewPlugin = self.viper.getPluginManager().getPlugin('ViperSourceViewPlugin');
                var contents = sourceViewPlugin.getContents();
                dfx.remove(tmpText);
                sourceViewPlugin.showSourceView(contents, function() {
                    if (self.viper.isBrowser('msie') === true) {
                        sourceViewPlugin.scrollToText('__STH__');
                        sourceViewPlugin.replaceSelection('');
                        sourceViewPlugin.updateOriginalSourceValue();
                    } else {
                        sourceViewPlugin.scrollToText('__STH__');
                        setTimeout(function() {
                            sourceViewPlugin.replaceSelection('');
                            sourceViewPlugin.updateOriginalSourceValue();
                        }, 500);
                    }
                });
            });
            resolutionHeader.appendChild(sourceViewBtn);

            var refreshIssueBtn = tools.createButton('VAP:toggleIssueDone', '', _('Refresh Issue'), 'Viper-accessRerun', function() {
                self.refreshIssue(id, issue, detailsElem, detailsElem);
            });
            resolutionHeader.appendChild(refreshIssueBtn);

            var defaultContent = standardObj.getDefaultContent(id, issue, null, self);
            resolutionCont.appendChild(defaultContent);
            standardObj.getResolutionContent(issue, defaultContent, self, id);
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
        var aaTools = toolbar.createBubble('VAP:bubble', _('Accessibility Auditor') + ' - ' + this._standard, null, null, function() {
            self.getIssues();
        }, function() {
        }, 'ViperAccessibilityPlugin');
        aaTools.id = this.viper.getId() + '-VAP';

        // Create the sub section.
        var bubble       = toolbar.getBubble('VAP:bubble');
        var subSection   = bubble.addSubSection('VAP:subSection', this._htmlcsWrapper);
        bubble.setSetting('keepOpen', true);
        toolbar.getBubble('VAP:bubble').showSubSection('VAP:subSection');

        // The main toolbar button to toggle the toolbar bubble on and off.
        var vapButton = tools.createButton('accessibility', '', 'Accessibility Auditor', 'Viper-accessAudit', null, true);
        toolbar.setBubbleButton('VAP:bubble', 'accessibility');
        toolbar.addButton(vapButton);

    },

    refreshIssue: function(issueNum, issue, issueElem, issueDetails)
    {
        dfx.addClass(issueElem, 'Viper-rechecking');

        // Add the re-checking issue overlay.
        var issueRecheck = document.createElement('div');
        dfx.addClass(issueRecheck, 'ViperAP-issueRecheck');
        issueDetails.appendChild(issueRecheck);

        dfx.setHtml(issueRecheck, '<div class="Viper-issueChecking">' + _('Re-checking issue') + ' …</div>');

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
                dfx.removeClass(issueElem, 'Viper-rechecking');

                // Mark issue as done.
                self.fixIssue(issueNum, true);
            } else {
                dfx.empty(issueRecheck);
                var issueRemains = document.createElement('div');
                dfx.addClass(issueRemains, 'Viper-issueRemains');
                dfx.setHtml(issueRemains, '<span class="Viper-recheckMessage">' + _('This issue has not been resolved') + '</span>');
                issueRemains.appendChild(self.viper.ViperTools.createButton('VAP-issues:notResolvedBtn', _('OK'), '', '', function() {
                    dfx.setHtml(issueRecheck, '');
                    dfx.removeClass(issueElem, 'Viper-rechecking');
                }));
                issueRecheck.appendChild(issueRemains);
            }
        });

    },

    dismissIssue: function(issueid)
    {
        this._markAsDone(issueid);

        var issue = HTMLCSAuditor.getIssue(issueid);
        if (!this._dismissedIssues[issue.code]) {
            this._dismissedIssues[issue.code] = [];
        }

        this._dismissedIssues[issue.code].push(issue.element);

        var self = this;
        setTimeout(function() {
            self.nextIssue();
        }, 800);

    },

    fixIssue: function(issueNum, goNext)
    {
        if (!issueNum && issueNum !== 00) {
            issueNum = this.getCurrentIssueNumber();
        }

        this._markAsDone(issueNum);

        if (goNext === true) {
            var self = this;
            setTimeout(function() {
                self.nextIssue();
            }, 800);
        }

    },

    _updateStandard: function()
    {
        // Updates the standard info from HTMLCSAuditor.
        this._standard = HTMLCSAuditor.getCurrentStandard();

        this.viper.ViperTools.getItem('VAP:bubble').setTitle(_('Accessibility Auditor') + ' - ' + this._standard);
    },

    _markAsDone: function(issueNum)
    {
        var issueElement = this.getIssueElement(issueNum, 'details');
        dfx.addClass(issueElement, 'Viper-issueDone');

        var listItem = this.getIssueElement(issueNum, 'listItem');
        dfx.addClass(listItem, 'Viper-issueDone');

    },

    _moveDismissedIssuesToEnd: function(issues)
    {
        if (dfx.isEmpty(this._dismissedIssues) === true) {
            return issues;
        }

        // Copy issues..
        var toMoveIndexes = [];
        var toMoveElements = []
        var c = issues.length;
        for (var i = 0; i < c; i++) {
            var issue = issues[i];
            if (!this._dismissedIssues[issue.code]) {
                continue;
            }

            if (this._dismissedIssues[issue.code].inArray(issue.element) === true) {
                toMoveIndexes.push(i);
                toMoveElements.push(issue);
            }
        }

        toMoveIndexes  = toMoveIndexes.reverse();
        toMoveElements = toMoveElements.reverse();

        for (var i = 0; i < toMoveIndexes.length; i++) {
            issues.splice(toMoveIndexes[i], 1);
            issues.push(toMoveElements[i]);
        }

        return issues;

    },

    _remarkDismissedIssues: function(issues)
    {
        if (dfx.isEmpty(this._dismissedIssues) === true) {
            return;
        }

        var c = issues.length;
        for (var i = 0; i < c; i++) {
            var issue = issues[i];
            if (!this._dismissedIssues[issue.code]) {
                continue;
            }

            if (this._dismissedIssues[issue.code].inArray(issue.element) === true) {
                this._markAsDone(i);
            }
        }

    },

    nextIssue: function()
    {
        dfx.trigger(dfx.getId('HTMLCS-button-next-issue'), 'click');

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

    getCurrentIssueNumber: function()
    {
        var currentIssueElem = dfx.getClass('HTMLCS-current', this._htmlcsWrapper)[0];
        var id = Number(currentIssueElem.id.split('-').pop());
        return id;

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

        if (navigator.appName == 'Microsoft Internet Explorer') {
            var rv = -1;
            var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
            if (re.exec(navigator.userAgent) != null) {
                rv = parseFloat(RegExp.$1);
            }

            if (rv <= 8.0) {
                script.onreadystatechange = function() {
                    if (/^(complete|loaded)$/.test(this.readyState) === true) {
                        script.onreadystatechange = null;
                        script.onload();
                    }
                }
            }
        }//end if

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
