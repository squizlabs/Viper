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
                ViperUtil.insertBefore(node, node.firstChild);
            }

            ViperUtil.remove(node);
        });

        // Change Tracker will ask for the description of the change.
        // For comments display a editable area where user can type comment and
        // read other comments. Comment in change object is updated when the subElement is disabled.
        ViperChangeTracker.setDescriptionCallback('viperComment', function(node, ctnType, changeid) {
            var div = Viper.document.createElement('div');
            ViperUtil.addClass(div, 'viperCommentDiv');

            // Set the changeid of this div so that when subElementDisabled event
            // is fired, we can determine the changeid of active comment.
            div.setAttribute('changeid', changeid);
            div.setAttribute('id', 'viperComment-' + changeid);

            var comment = ViperChangeTracker._comments[changeid] || '&nbsp;';
            ViperUtil.setHtml(div, comment);

            ViperUtil.addEvent(div, 'mousedown', function() {
                self.viper.setSubElementState(div, true);

                ViperUtil.removeEvent(div, 'mouseup.viperSubElem');
                ViperUtil.addEvent(div, 'mouseup.viperSubElem', function(e) {
                    setTimeout(function() {
                        self.viper.mouseUp(e);
                    }, 200);
                });

                // We need to add a new class to top level element so the box
                // stays on top of others.
                var parent = div.parentNode.parentNode.parentNode;
                ViperUtil.addClass(parent, 'active');
            });

            if (self._newCommentid === changeid) {
                self.viper.registerCallback('ViperChangeTracker:infoBoxAdded', 'ViperTrackChangesPlugin', function(chid) {
                    if (chid !== changeid) {
                        return;
                    }

                    var markerElem = ViperChangeTracker.getMarker(changeid);
                    if (markerElem) {
                        ViperUtil.trigger(markerElem, 'click');
                    }

                    self.viper.setSubElementState(div, true);
                    div.focus();

                    // We need to add a new class to top level element so the box
                    // stays on top of others.
                    var parent = div.parentNode.parentNode.parentNode;
                    ViperUtil.addClass(parent, 'active');

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
                ViperUtil.removeClass(parent, 'active');
            }
        });

    },

    toggleTrackChanges: function()
    {
        this._barActive = this.subToolbarPlugin.toggleToolbar('TrackChanges');
        if (this._barActive === true) {
            this.viper.ViperTools.setButtonActive('trackChanges');
        } else {
            this.viper.ViperTools.setButtonInactive('trackChanges');
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
        var elements = ViperUtil.getElementsBetween(bookmark.start, bookmark.end);

        var eln      = elements.length;
        var changeid = ViperChangeTracker.addChange('viperComment');

        this._newCommentid = changeid;

        if (eln === 0) {
            var el = Viper.document.createElement('span');
            ViperUtil.insertBefore(bookmark.start, el);
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

        var tcBtn = tools.createButton('trackChanges', 'TC', 'Toggle Track Changes', '', function() {
            if (tcEnabled === true) {
                tcEnabled = false;
                tools.setButtonInactive('trackChanges');
                self.disableTracking();
            } else {
                tcEnabled = true;
                tools.setButtonActive('trackChanges');
                self.enableTracking();
            }
        });

        toolbar.addButton(tcBtn);

    }

};
