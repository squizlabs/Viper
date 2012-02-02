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
    init: function()
    {
        var self = this;

        this._setupToolbar();

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
            this.viper.ViperTools.setButtonActive('VTCP:toggle');
        } else {
            this.viper.ViperTools.setButtonInactive('VTCP:toggle');
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

    enableTracking: function()
    {
        ViperChangeTracker.enableChangeTracking();

    },

    disableTracking: function()
    {
        ViperChangeTracker.disableChangeTracking();

    },

    _setupToolbar: function()
    {
        var self      = this;
        var tcEnabled = false;
        var tools     = this.viper.ViperTools;
        var toolbar   = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');

        var tcBtn = tools.createButton('VTCP:toggle', 'TC', 'Toggle Track Changes', '', function() {
            if (tcEnabled === true) {
                tcEnabled = false;
                tools.setButtonInactive('VTCP:toggle');
                self.disableTracking();
            } else {
                tcEnabled = true;
                tools.setButtonActive('VTCP:toggle');
                self.enableTracking();
            }
        });

        toolbar.addButton(tcBtn);

    }

};
