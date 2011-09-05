/**
 * JS Class for the Viper Track Changes Plugin.
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

function ViperTrackChangesPlugin(viper)
{
    this.viper = viper;
    this.toolbarPlugin    = null;
    this.subToolbarPlugin = null;
    this.optionCheckboxes = {};
    this._barActive       = false;
    this._newCommentid    = null;
    this._initialising    = false;
    this.viewSettings     = {
        finalMode: {},
        originalMode: {}
    };

}

ViperTrackChangesPlugin.prototype = {
    start: function()
    {
        var self = this;

        this.toolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        this.toolbarPlugin.addButton('TrackChanges', 'track-changes', 'Track Changes', function () {
            if (!self.subToolbarPlugin) {
                self._setupSubToolbar(function() {
                    self.toggleTrackChanges();
                });
            } else {
                self.toggleTrackChanges();
            }
        });

        // Setup sub toolbar.
        if (ViperChangeTracker.isTracking() === true) {
            this._setupSubToolbar(function() {
                // Check again incase there was a long delay.
                if (ViperChangeTracker.isTracking() === true) {
                    self._barActive = true;
                    self.subToolbarPlugin.showToolbar('TrackChanges');
                    self.toolbarPlugin.setButtonActive('track-changes');
                }
            });
        }

        this.viper.registerCallback('ViperChangeTracker:tracking', 'ViperTrackChangesPlugin', function(isTracking) {
            if (isTracking === true) {
                self._setupSubToolbar(function() {
                    // Check again incase there was a long delay.
                    if (ViperChangeTracker.isTracking() === true) {
                        self._barActive = true;
                        self.subToolbarPlugin.showToolbar('TrackChanges');
                        self.toolbarPlugin.setButtonActive('track-changes');
                    }
                });
            }
        });

        this.viper.registerCallback('ViperSubToolbar:hideToolbar', 'ViperTrackChangesPlugin', function(barid) {
            if (barid !== 'TrackChanges'
                && self._barActive === true
                && ViperChangeTracker.isTracking() === true
            ) {
                self.subToolbarPlugin.showToolbar('TrackChanges');
                self.toolbarPlugin.setButtonActive('track-changes');
            }
        });

        ViperChangeTracker.addChangeType('viperComment', 'Comment', 'comment');

        ViperChangeTracker.setRejectCallback('viperComment', function(clone, node) {
            while (node.firstChild) {
                dfx.insertBefore(node, node.firstChild);
            }

            dfx.remove(node);
        });

        // Change Tracker will ask for the description of the change.
        // For comments display a editable area where user can type comment and
        // read other comments. Comment in change object is updated when the subElement is disabled.
        ViperChangeTracker.setDescriptionCallback('viperComment', function(node, ctnType, changeid) {
            var div = Viper.document.createElement('div');
            dfx.addClass(div, 'viperCommentDiv');

            // Set the changeid of this div so that when subElementDisabled event
            // is fired, we can determine the changeid of active comment.
            div.setAttribute('changeid', changeid);
            div.setAttribute('id', 'viperComment-' + changeid);

            var comment = ViperChangeTracker._comments[changeid] || '&nbsp;';
            dfx.setHtml(div, comment);

            dfx.addEvent(div, 'mousedown', function() {
                self.viper.setSubElementState(div, true);

                dfx.removeEvent(div, 'mouseup.viperSubElem');
                dfx.addEvent(div, 'mouseup.viperSubElem', function(e) {
                    setTimeout(function() {
                        self.viper.mouseUp(e);
                    }, 200);
                });

                // We need to add a new class to top level element so the box
                // stays on top of others.
                var parent = div.parentNode.parentNode.parentNode;
                dfx.addClass(parent, 'active');
            });

            if (self._newCommentid === changeid) {
                self.viper.registerCallback('ViperChangeTracker:infoBoxAdded', 'ViperTrackChangesPlugin', function(chid) {
                    if (chid !== changeid) {
                        return;
                    }

                    var markerElem = ViperChangeTracker.getMarker(changeid);
                    if (markerElem) {
                        dfx.trigger(markerElem, 'click');
                    }

                    self.viper.setSubElementState(div, true);
                    div.focus();

                    // We need to add a new class to top level element so the box
                    // stays on top of others.
                    var parent = div.parentNode.parentNode.parentNode;
                    dfx.addClass(parent, 'active');

                    var range = self.viper.getCurrentRange();
                    range.setStart(div.firstChild, 0);
                    range.collapse(true);

                    self.viper.removeCallback('ViperChangeTracker:infoBoxAdded', 'ViperTrackChangesPlugin');
                });

                self._newCommentid = null;
            }//end if

            return div;
        });

        this.viper.registerCallback('subElementDisabled', 'ViperTrackChangesPlugin', function(elem) {
            if (elem && elem.parentNode && elem.parentNode.parentNode) {
                var parent = elem.parentNode.parentNode.parentNode;
                dfx.removeClass(parent, 'active');
            }
        });

    },

    toggleTrackChanges: function()
    {
        this._barActive = this.subToolbarPlugin.toggleToolbar('TrackChanges');
        if (this._barActive === true) {
            this.toolbarPlugin.setButtonActive('track-changes');
        } else {
            this.toolbarPlugin.setButtonInactive('track-changes');
        }

        if (ViperChangeTracker.isTracking() === false
            && ViperChangeTracker.hasChanges() === false
        ) {
            ViperChangeTracker.enableChangeTracking();
        }

    },

    /**
     * Adds a comment tag around the selection.
     */
    addComment: function()
    {
        this.viper.focus();
        var info     = ViperHistoryManager.createNodeChangeInfo(this.viper.element);
        var bookmark = this.viper.createBookmark();
        var elements = dfx.getElementsBetween(bookmark.start, bookmark.end);

        var eln      = elements.length;
        var changeid = ViperChangeTracker.addChange('viperComment');

        this._newCommentid = changeid;

        if (eln === 0) {
            var el = Viper.document.createElement('span');
            dfx.insertBefore(bookmark.start, el);
            ViperChangeTracker.addNodeToChange(changeid, el);
        } else {
            for (var i = 0; i < eln; i++) {
                if (ViperChangeTracker.getCTNode(elements[i], 'viperComment') === null) {
                    this.viper._wrapElement(elements[i], 'span', function(newElem) {
                        // Add new class to wrap element to mark it as "deleted".
                        ViperChangeTracker.addNodeToChange(changeid, newElem);
                    });
                }
            }
        }

        this.viper.selectBookmark(bookmark);
        this.viper.fireNodesChanged('ViperTrackChangesPlugin:update');

    },

    _setupSubToolbar: function(callback)
    {
        this._initialising = true;
        ViperChangeTracker.setActionDisplayState('format', true);
        ViperChangeTracker.setActionDisplayState('comment', true);

        var subToolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperSubToolbarPlugin');
        if (!subToolbarPlugin) {
            return;
        }

        var toolbar = subToolbarPlugin.createToolBar('TrackChanges');

        var c        = 'ViperTrackChanges-stb';
        var contents = '<div class="' + c + '-left"></div>';
        contents    += '<div class="' + c + '-mid"></div>';
        contents    += '<div class="' + c + '-right"></div>';
        dfx.setHtml(toolbar, contents);

        var self = this;

        this.includeWidgets(['Button', 'RadioButton'], function() {
            var switchToOriginal = self.createWidget('ViperTrackChanges-switchMode', 'Button');
            switchToOriginal.setName('Switch to Original');
            switchToOriginal.setButtonIconClassName(c + '-switch');
            switchToOriginal.create(function(el) {
                switchToOriginal.setMinWidth('120px');
                dfx.addClass(switchToOriginal.domElem, 'ViperTrackChanges-switchMode-original');
                (dfx.getClass(c + '-left', toolbar)[0]).appendChild(el);
            });

            switchToOriginal.addClickEvent(function() {
                if (ViperChangeTracker.getCurrentMode() === 'final') {
                    ViperChangeTracker.activateOriginalMode();
                    switchToOriginal.setName('Switch to Final');
                    dfx.removeClass(switchToOriginal.domElem, 'ViperTrackChanges-switchMode-original');
                    dfx.addClass(switchToOriginal.domElem, 'ViperTrackChanges-switchMode-final');
                    self.changeViewSettings('original');
                } else {
                    ViperChangeTracker.activateFinalMode();
                    switchToOriginal.setName('Switch to Original');
                    dfx.removeClass(switchToOriginal.domElem, 'ViperTrackChanges-switchMode-final');
                    dfx.addClass(switchToOriginal.domElem, 'ViperTrackChanges-switchMode-original');
                    self.changeViewSettings('final');
                }
            });

            var addComment = self.createWidget('ViperTrackChanges-addComment', 'Button');
            addComment.setName('Add Comment');
            addComment.setButtonIconClassName(c + '-comment');
            addComment.create(function(el) {
                addComment.setMinWidth('105px');
                (dfx.getClass(c + '-right', toolbar)[0]).appendChild(el);
            });

            addComment.addClickEvent(function() {
                // Call blur() because we can not have focus on the button.
                // If button has focus while user is typing a comment it will
                // fire events for that button when space/enter is pressed.
                if (addComment.buttonParts.content) {
                    addComment.buttonParts.content.blur();
                }

                self.addComment();
            });

            var toggleTracking = self.createWidget('ViperTrackChanges-toggleTracking', 'Button', 'ButtonWidgetType-black');
            toggleTracking.setName('Disable Tracking');

            toggleTracking.create(function(el) {
                toggleTracking.setMinWidth('101px');
                dfx.addClass(el, 'ViperTrackChanges-toggleTracking-disable');
                (dfx.getClass(c + '-right', toolbar)[0]).appendChild(el);
            });

            toggleTracking.addClickEvent(function() {
                if (ViperChangeTracker.isTracking() === true) {
                    toggleTracking.setName('Enable Tracking');
                    dfx.removeClass(toggleTracking.domElem, 'ViperTrackChanges-toggleTracking-disable');
                    dfx.addClass(toggleTracking.domElem, 'ViperTrackChanges-toggleTracking-enable');
                    ViperChangeTracker.disableChangeTracking();
                    addComment.disable();
                } else {
                    toggleTracking.setName('Disable Tracking');
                    dfx.removeClass(toggleTracking.domElem, 'ViperTrackChanges-toggleTracking-enable');
                    dfx.addClass(toggleTracking.domElem, 'ViperTrackChanges-toggleTracking-disable');
                    ViperChangeTracker.enableChangeTracking();
                    addComment.enable();
                }
            });

            var optsList = subToolbarPlugin.createOptionsList('Display');
            (dfx.getClass(c + '-mid', toolbar)[0]).appendChild(optsList.main);
            self._createOptionList(optsList.contentEl);
            self.changeViewSettings('final');

            this._initialising    = false;
            self.subToolbarPlugin = subToolbarPlugin;
            callback.call(self, subToolbarPlugin);
            return;
        });

    },

    changeViewSettings: function(mode)
    {
        mode += 'Mode';
        if (!this.viewSettings[mode]) {
            return;
        }

        var self = this;
        dfx.foreach(this.optionCheckboxes, function(i) {
            if (self.viewSettings[mode][i]) {
                self.optionCheckboxes[i].check();
            } else {
                self.optionCheckboxes[i].uncheck();
            }
        });

    },

    updateViewSetting: function(type, display)
    {
        var mode = ViperChangeTracker.getCurrentMode() + 'Mode';
        this.viewSettings[mode][type] = display;

    },

    _createOptionList: function(parent)
    {
        var div           = null;
        var self          = this;
        var opts          = ViperChangeTracker.getActionTypes();
        var displayStates = ViperChangeTracker.getActionDisplayStates();

        dfx.foreach(opts, function(i) {
            self.viewSettings.finalMode[i]    = displayStates[i];
            self.viewSettings.originalMode[i] = displayStates[i];

            div       = Viper.document.createElement('div');
            var label = Viper.document.createElement('label');
            parent.appendChild(div);
            dfx.setHtml(label, opts[i]);
            div.appendChild(label);
            dfx.addClass(div, 'ViperTrackChanges-stb-optItem');
            div.id = 'ViperTrackChanges-opts-' + i;

            var radioBtn = self.createWidget(null, 'RadioButton', null, displayStates[i]);

            self.optionCheckboxes[i] = radioBtn;
            radioBtn.create(function(radioBtnEl) {
                dfx.attr(label, 'for', radioBtn.id);
                div.appendChild(radioBtnEl);
                radioBtn._addEvents();
            });

            (function(radioBtnWidget, type) {
                radioBtnWidget.addCheckedEvent(function(checked) {
                    self.toggleChangeTypeDisplayState(type, checked);
                });
            }) (radioBtn, i);

            if (i === 'Inserts') {
                dfx.addClass(div, 'first');
            }
        });

        self.viewSettings.originalMode.insert = true;
        self.viewSettings.originalMode.remove = false;

        if (div) {
            dfx.addClass(div, 'last');
        }

    },

    toggleChangeTypeDisplayState: function(type, display)
    {
        this.updateViewSetting(type, display);
        ViperChangeTracker.setActionDisplayState(type, display, !this._initialising, true);

    }


};
