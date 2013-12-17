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

var ViperChangeTracker = {

    _className: '_viper-CT',
    _nodeClassName: '_viper-CTNode',
    _tracking: false,
    _nodeTypeVisibility: {},
    _viper: null,
    _updateTimer: null,
    _updateDelay: 600,
    _infoBoxHolder: null,
    _markerHolder: null,
    _processingMarkers: false,
    _changes: {},
    _changeSeq: 0,
    _users: {},
    _descCallbacks: {},
    _changeTypes: {},
    _colours: ['green', 'blue', 'red', 'yellow', 'orange', 'purple', 'pink'],
    _userColours: {},
    _rejectCallbacks: {},
    _approveCallbacks: {},
    _comments: {},
    _batchChangeid: null,
    _actionTypes: {
        remove: 'Deletes',
        insert: 'Inserts',
        format: 'Format',
        comment: 'Comments'
    },
    _actionTypeDisplayStates: {
        insert: false,
        remove: true,
        format: true,
        comment: true
    },
    _currentMode: null,
    _orientation: 'right',
    _tmpData: {},
    _currentUserid: null,

    /**
     * Initialise the Change Tracker.
     *
     * @param {Viper}   The Viper object.
     * @param {boolean} If true then changes will be tracked.
     *
     * @returns {void}
     */
    init: function(viper, trackChanges)
    {
        var self       = this;
        this._viper    = viper;
        this._tracking = trackChanges || false;
        this.cleanUp();

        this._viper.registerCallback('nodesChanged', 'ViperChangeTracker', function() {
            if (self._viper._subElementActive === true) {
                var commentElemId = self._viper.element.id;
                var changeid      = commentElemId.replace('viperComment-', '');

                self._comments[changeid] = self._viper.getHtml(self._viper.element);
            }
        });

        // Find the comment node (nodeType=8) and get the change info.
        this._viper.registerCallback('viperEnabled', 'ViperChangeTracker', function() {
            self._processingMarkers = false;

            var childNodes = self._viper.element.childNodes;
            for (var node = self._viper.element.lastChild; node; node = node.previousSibling) {
                if (node.nodeType === 8 && node.data.indexOf('viperTrackInfo=') === 0) {
                    var loadedData = node.data.replace('viperTrackInfo=', '');
                    try {
                        loadedData = JSON.parse(loadedData);
                    } catch (e) {
                        // Failed to parse..
                        loadedData = [];
                    }

                    ViperUtil.foreach(loadedData, function(changeid) {
                        if (ViperUtil.isset(loadedData[changeid].comment) === true) {
                            self._comments[changeid] = loadedData[changeid].comment;
                        }
                    });

                    // Remove the node.
                    ViperUtil.remove(node);

                    // No need to coninue.
                    break;
                }//end if
            }//end for

            // Load CTNodes.
            var changes      = self.loadCTNodes(self._viper.getViperElement());
            var foundChanges = false;
            ViperUtil.foreach(changes, function(changeid) {
                self._changes[changeid] = changes[changeid];
                foundChanges = true;
            });

            ViperChangeTracker.activateFinalMode();
            if (foundChanges === true) {
                self.updatePositionMarkers(false);

                ViperChangeTracker._enableChangeTracking();
            }
        });

        this._viper.registerCallback('ViperHistoryManager:undo', 'ViperChangeTracker', function() {
            // We have to reload the changes because undo will remove all DOM
            // node references.
           self.reLoad();
        });

        this._viper.registerCallback('ViperHistoryManager:redo', 'ViperChangeTracker', function() {
            self.reLoad();
        });

        ViperUtil.$(window).resize(function() {
          self.updatePositionMarkers(true);
        });

    },

    /**
     * Reload the changes in the current content.
     *
     * @returns void
     */
    reLoad: function()
    {
        this.cleanUp();

        var self         = this;
        var changes      = this.loadCTNodes(this._viper.getViperElement());
        var foundChanges = false;
        ViperUtil.foreach(changes, function(changeid) {
            self._changes[changeid] = changes[changeid];
            foundChanges = true;
        });

        if (foundChanges === true) {
            // Force change mode here. Reason:
            // - Make multiple changes in final mode then switch to original.
            // - Undo once. The content will be in "final" mode but Viper is in
            // original mode.
            var currMode = self.getCurrentMode();
            if (currMode === 'original') {
                self.activateOriginalMode();
            } else {
                self.activateFinalMode();
            }

            self.updatePositionMarkers(false);
        }

    },

    /**
     * Cleans up vars and removes element containers.
     *
     * @returns {void}
     */
    cleanUp: function()
    {
        this._changes     = {};
        this._changeSeq   = 0;
        this._userColours = [];
        this._tmpData     = {};
        this._orientation = 'right';

        if (this._infoBoxHolder) {
            ViperUtil.remove(this._infoBoxHolder);
            this._infoBoxHolder = null;
        }

        if (this._markerHolder) {
            ViperUtil.remove(this._markerHolder);
            this._markerHolder = null;
        }

    },

    /**
     * Returns true of the content has changes.
     *
     * @returns {boolean}
     */
    hasChanges: function()
    {
        return (ViperUtil.isEmpty(this._changes) !== true);

    },

    /**
     * Returns true if the changes are being tracked.
     *
     * @returns {boolean}
     */
    isTracking: function()
    {
        var tracking = (this._viper._subElementActive !== true && this._tracking === true);
        return tracking;

    },

    /**
     * Returns true if the specified node is a tracked node.
     *
     * @param {DomNode} node       DOM element to check.
     * @param {string}  ctNodeType The change type filter.
     *
     * @returns {boolean}
     */
    isTrackingNode: function(node, ctNodeType)
    {
        if (node && node.nodeType === ViperUtil.ELEMENT_NODE && ViperUtil.hasClass(node, this._nodeClassName) === true) {
            if (!ctNodeType
                || ViperUtil.hasClass(node, 'CT-' + ctNodeType) === true
                || node.tagName.toLowerCase() === 'ins'
                || node.tagName.toLowerCase() === 'del'
                || this.isInsertType(this.getCTNTypeFromNode(node)) === true
            ) {
                return true;
            }
        }

        return false;

    },

    _enableChangeTracking: function()
    {
        this._tracking = true;
        this._viper.fireCallbacks('ViperChangeTracker:tracking', true);

    },

    enableChangeTracking: function()
    {
        return;

        // Create infobox holder which will contain all the infoboxes.
        this._infoBoxHolder = this._createInfoboxHolder();
        this._markerHolder  = this._createMarkerHolder();

        // Load the changes for the current active element.
        if (this._viper.getViperElement()) {
            this._enableChangeTracking();
            this.loadChanges(this._viper.getViperElement());
            this.updatePositionMarkers(false);
        }

    },

    disableChangeTracking: function()
    {
        this._tracking = false;
        this._viper.fireCallbacks('ViperChangeTracker:tracking', false);

    },

    loadChanges: function(elem)
    {
        var changes = this.loadCTNodes(this._viper.getViperElement());

    },

    setNodeTypeVisibility: function(nodeType, visible)
    {
        this._nodeTypeVisibility[nodeType] = visible;

        var elems = ViperUtil.getClass('CT-' + nodeType, this._viper.getViperElement());
        if (visible === false) {
            ViperUtil.addClass(elems, 'CT-disabled');
        } else {
            ViperUtil.removeClass(elems, 'CT-disabled');
        }

    },

    activateFinalMode: function()
    {
        this.setNodeTypeVisibility('textRemoved', false);
        this.setNodeTypeVisibility('textAdd', true);
        this.setNodeTypeVisibility('textAdded', true);
        this.setActionDisplayState('insert', false);
        this.setActionDisplayState('remove', true);

        if (this._currentMode !== 'final') {
            this._viper.fireCallbacks('ViperChangeTracker:modeChange', 'final');
        }

        this._currentMode = 'final';

    },

    activateOriginalMode: function()
    {
        this.setNodeTypeVisibility('textRemoved', true);
        this.setNodeTypeVisibility('textAdd', false);
        this.setNodeTypeVisibility('textAdded', false);
        this.setActionDisplayState('insert', true);
        this.setActionDisplayState('remove', false);

        if (this._currentMode !== 'original') {
            this._viper.fireCallbacks('ViperChangeTracker:modeChange', 'original');
        }

        this._currentMode = 'original';

    },

    getCurrentMode: function()
    {
        return this._currentMode;

    },

    /**
     * If a CT nodeType is not visible then it will not be shown to the user.
     * This effects Viper ranges, because range can still extend in to a hidden
     * container. So Viper uses this method to determine if caret can move in to
     * specified CT nodeType.
     */
    isNodeTypeVisible: function(ctNodeType)
    {
        if (ViperUtil.isset(this._nodeTypeVisibility[ctNodeType]) === true && this._nodeTypeVisibility[ctNodeType] !== true) {
            return false;
        }

        return true;

    },

    isNodeVisible: function(ctNode)
    {
        if (ctNode) {
            for (var ctType in this._nodeTypeVisibility) {
                if (this._nodeTypeVisibility.hasOwnProperty(ctType) === false) {
                    continue;
                }

                if (ViperUtil.hasClass(ctNode, 'CT-' + ctType) === true) {
                    return this._nodeTypeVisibility[ctType];
                }
            }
        }

        return true;

    },

    isInsertType: function(ctnType)
    {
        if (this._changeTypes[ctnType] && this._changeTypes[ctnType].actionType === 'insert') {
            return true;
        }

        return false;

    },

    canShowType: function(ctnType)
    {
        var actionType = null;
        if (this._changeTypes[ctnType]) {
            actionType = this._changeTypes[ctnType].actionType;
        }

        return (this._actionTypeDisplayStates[actionType] === true);

    },

    setActionDisplayState: function(actionType, display, nodelay, forceUpdate)
    {
        nodelay = nodelay || false;

        this._actionTypeDisplayStates[actionType] = display;
        this.updatePositionMarkers(!nodelay, forceUpdate);

    },

    getActionDisplayStates: function()
    {
        return this._actionTypeDisplayStates;

    },

    addChangeType: function(typeName, title, actionType)
    {
        if (!this._actionTypes[actionType]) {
            return;
        }

        this._changeTypes[typeName] = {
            title: title,
            actionType: actionType
        };

    },

    getActionTypes: function()
    {
        return this._actionTypes;

    },

    getTypeTitle: function(typeName)
    {
        var title = '';
        if (this._changeTypes[typeName] && this._changeTypes[typeName].title) {
            title = this._changeTypes[typeName].title;
        }

        return title;

    },

    getCTNode: function(node, ctnType)
    {
        while (node && node !== this._viper.getViperElement()) {
            if (ViperUtil.hasClass(node, '_viper-CTNode') === true) {
                if (ctnType) {
                    if (ViperUtil.hasClass(node, 'CT-' + ctnType) === true) {
                        return node;
                    }
                } else {
                    return node;
                }
            }

            node = node.parentNode;
        }

        return null;

    },

    getCTNTypeFromNode: function(node)
    {
        var ctnType = '';
        ViperUtil.foreach(this._changeTypes, function(type) {
            if (ViperUtil.hasClass(node, 'CT-' + type) === true) {
                ctnType = type;
                return false;
            }
        });

        return ctnType;

    },

    createCTNode: function(nodeType, ctnType, childNode)
    {
        if (ViperChangeTracker.isTracking() !== true) {
            return childNode;
        }

        var node = Viper.document.createElement(nodeType);
        ViperUtil.addClass(node, this._nodeClassName + ' CT-' + ctnType);

        if (!childNode) {
            var textNode = Viper.document.createTextNode('');
            node.appendChild(textNode);
        } else {
            node.appendChild(childNode);
        }

        // If this CTN type is disabled then add 'disabled' class to the element.
        if (this.isNodeTypeVisible(ctnType) === false) {
            ViperUtil.addClass(node, 'CT-disabled');
        }

        return node;

    },

    trackNodes: function(nodes, ctnType)
    {
        var ctnClass = this.getCTNodeClass(ctnType);
        ViperUtil.foreach(nodes, function(i) {
            ViperUtil.addClass(nodes[i], ctnClass);
        });

    },

    getCTNodeClass: function(ctnType)
    {
        var className = this._nodeClassName + ' CT-' + ctnType;
        if (this.isNodeTypeVisible(ctnType) === false) {
            className += ' CT-disabled';
        }

        return className;

    },

    getCTNodes: function(ctnType, parentElement)
    {
        parentElement = parentElement || this._viper.getViperElement();
        var className = this._nodeClassName;
        if (ctnType) {
            className = 'CT-' + ctnType;
        }

        var nodes = ViperUtil.getClass(className, parentElement);
        return nodes;

    },

    getPreviousVisibleContainer: function(range, node)
    {
        while (node) {
            var ctNode = this.getCTNode(node);
            if (ctNode && this.isNodeVisible(ctNode) === false) {
                node = range.getPreviousContainer(ctNode);
            } else {
                break;
            }
        }

        return node;

    },

    getNextVisibleContainer: function(range, node)
    {
        while (node) {
            var ctNode = this.getCTNode(node);
            if (ctNode && this.isNodeVisible(ctNode) === false) {
                node = range.getNextContainer(ctNode);
            } else {
                break;
            }
        }

        return node;

    },

    getColour: function(colourIndex)
    {
        return this._colours[colourIndex];

    },

    getMarker: function(changeid)
    {
        if (!changeid) {
            return;
        }

        var elemid = this._className + '-marker-' + changeid;
        var marker = ViperUtil.getid(elemid);

        if (!marker) {
            return null;
        }

        return marker;

    },

    _createMarker: function(ctnType, posX, posY, colourIndex, show, changeid)
    {
        var colour = this._colours[colourIndex];

        var rect = null;
        if (!this._tmpData.viperElemRect) {
            rect = ViperUtil.getBoundingRectangle(this._viper.getViperElement());
            this._tmpData.viperElemRect = rect;
        } else {
            rect = this._tmpData.viperElemRect;
        }

        var elem = Viper.document.createElement('div');
        var c    = this._className + '-marker';
        elem.id  = this._className + '-marker-' + changeid;
        ViperUtil.addClass(elem, c + ' CT-' + ctnType + ' CT-' + colour);

        if (this._orientation === 'left') {
            ViperUtil.setStyle(elem, 'left', parseInt(rect.x1 - 26) + 'px');
        } else {
            ViperUtil.setStyle(elem, 'left', parseInt(posX) + 'px');
        }

        ViperUtil.setStyle(elem, 'top', parseInt(posY) + 'px');

        if (show !== true) {
            ViperUtil.addClass(elem, 'CT-ins');
        }

        var orientation = '';
        if (this._orientation === 'left') {
            orientation = ' orientationLeft';
        }

        var content = '<div class="' + c + '-teardrop' + orientation + '"></div>';
        ViperUtil.setHtml(elem, content);

        // Marker's width will change depending on the editable area and the
        // position of the marker relative to the editable area.
        var width = 0;
        if (this._orientation === 'left') {
            // Callouts are on the left.
            width = parseInt(posX - (rect.x1 - 30));
        } else {
            width = parseInt((rect.x2 + 30) - posX);
        }

        ViperUtil.setStyle(elem, 'width', width + 'px');

        return elem;

    },

    getParentCTNode: function(node, type)
    {
        while (node && node !== this._viper.getViperElement()) {
            node = node.parentNode;
            if (this.isTrackingNode(node, type) === true) {
                return node;
            }
        }

        return false;

    },

    addPositionMarkers: function(ctNodes, index, displayed, callback)
    {
        if (!ctNodes && !index) {
            if (this._processingMarkers === true) {
                return;
            }

            this._processingMarkers = true;
            // First remove markers.
            this.removePositionMarkers();
            this.removeInfoBoxPosition();

            this._createMarkerHolder();

            // Update the infobox holder position for the active editable element.
            this.updateInfoBoxPosition();

            ctNodes   = this.getCTNodes();
            index     = 0;
            displayed = {};
        }

        var self = this;
        var node = ctNodes[index];
        if (!node) {
            if (callback) {
                callback.call(this);
            }

            // No more ctNodes.
            this._processingMarkers = false;
            return;
        }

        // Check if node has a parent.
        if (!node.parentNode) {
            self.addPositionMarkers(ctNodes, (index + 1), displayed, callback);
            return;
        }

        var ctNodeType   = this.getCTNTypeFromNode(node);
        var parentCTNode = this.getParentCTNode(node, ctNodeType);
        if (parentCTNode) {
            self.addPositionMarkers(ctNodes, (index + 1), displayed, callback);
            return;
        }

        var changeid = node.getAttribute('viperChangeid');
        if (displayed[changeid] === true) {
            // Call self to process the next marker.
            self.addPositionMarkers(ctNodes, (index + 1), displayed, callback);
            return;
        }

        displayed[changeid] = true;

        var change = self.getChange(changeid);
        if (change) {
            var idParts = changeid.split('-');
            colourIndex = parseInt(idParts[2]);
            this.setUserColour(parseInt(idParts[0]), idParts[2]);

            // Create a marker node.
            var isInsertType = this.isInsertType(change.type);
            var canShowType  = this.canShowType(change.type);

            var tmp = Viper.document.createElement('span');
            ViperUtil.setHtml(tmp, '&nbsp;');

            if (ViperUtil.isBlockElement(node) === true && ViperUtil.isStubElement(node) !== true) {
                if (node.firstChild) {
                    ViperUtil.insertBefore(node.firstChild, tmp);
                } else {
                    node.appendChild(tmp);
                }
            } else {
                ViperUtil.insertBefore(node, tmp);
            }

            var tmpPos = ViperUtil.getBoundingRectangle(tmp);
            var marker = self._createMarker(change.type, tmpPos.x1, tmpPos.y2, colourIndex, canShowType, changeid);
            ViperUtil.remove(tmp);
            this._markerHolder.appendChild(marker);

            // Set infobox information for this change.
            this.getChangeInfo(changeid, function(changeInfo) {
                if (!self._infoBoxHolder) {
                    // Most likely the editable element was disabled..
                    self._processingMarkers = false;
                    return;
                }

                var infoBox = self._createInfoBox(changeInfo, colourIndex);
                self._setMouseEvents(infoBox, marker, node, isInsertType, changeid);
                self._infoBoxHolder.appendChild(infoBox);

                try {
                    self._positionInfoBox(infoBox, tmpPos, canShowType);
                } catch (e) {
                    // Some DOM operations may cause exceptions for hidden elems.
                }

                self._viper.fireCallbacks('ViperChangeTracker:infoBoxAdded', changeid);

                // Call self to process the next marker.
                self.addPositionMarkers(ctNodes, (index + 1), displayed, callback);
            });
        }//end if

    },

    removePositionMarkers: function()
    {
        ViperUtil.remove(ViperUtil.getClass(this._className + '-marker'));

    },

    updatePositionMarkers: function(delayed, force, callback)
    {
        if (force !== true && this._viper._subElementActive === true) {
            return;
        }

        if (this._updateTimer) {
            clearTimeout(this._updateTimer);
            this._updateTimer = null;
        }

        if (delayed !== true) {
            this.addPositionMarkers(null, null, null, callback);
        } else {
            var self = this;
            this._updateTimer = setTimeout(function() {
                try {
                    self.addPositionMarkers(null, null, null, callback);
                } catch (e) {
                };
            }, this._updateDelay);
        }

    },

    _createMarkerHolder: function()
    {
        return;

        if (this._markerHolder) {
            ViperUtil.remove(this._markerHolder);
        }

        var holder = Viper.document.createElement('div');
        ViperUtil.addClass(holder, this._className + '-markerHolder');
        Viper.document.body.appendChild(holder);
        this._markerHolder = holder;

        return holder;

    },

    _createInfoBox: function(data, colourIndex)
    {
        if (!data) {
            return;
        }

        var colour = this._colours[colourIndex];

        // Setup line box. This is the box that shows the L shaped lines which
        // connect marker to info box.
        var lineBox = Viper.document.createElement('div');
        ViperUtil.addClass(lineBox, this._className + '-lineBox CT-' + colour);

        // Setup infobox.
        var c       = this._className + '-infoBox';
        var infoBox = Viper.document.createElement('div');
        ViperUtil.addClass(infoBox, c);

        var description = '';
        if (ViperUtil.isObj(data.desc) !== true) {
            description = data.desc;
        }

        var isComment = '';
        if (data.typeid === 'viperComment') {
            isComment = ' isComment';
        }

        var content = '<div class="' + c + '-top">';

        if (data.typeid === 'viperComment') {
            content += '<div class="clickToReject">Click to remove comment</div>';
        } else {
            content += '<div class="clickToAccept">Click to accept change</div>';
            content += '<div class="clickToReject">Click to reject change</div>';
        }

        content += '<div class="changeBoxTitle"><strong>' + data.ownerName + '</strong> <span>' + data.time + '</span></div>';
        content += '<div class="' + c + '-actionBtns' + isComment + '">';

        if (data.typeid !== 'viperComment') {
            // Do not show approve button for comments.
            content += '<div class="' + c + '-actionBtns-approve"></div>';
        }

        content += '<div class="' + c + '-actionBtns-reject"></div>';
        content += '</div></div>';
        content += '<div class="' + c + '-bottom"><strong>' + data.typeName + ':</strong> ';
        content += description;
        content += '</div>';
        ViperUtil.setHtml(infoBox, content);

        if (ViperUtil.isObj(data.desc) === true) {
            if (ViperUtil.isArray(data.desc) !== true) {
                data.desc = [data.desc];
            }

            ViperUtil.foreach(data.desc, function(i) {
                ViperUtil.getClass(c + '-bottom', infoBox)[0].appendChild(data.desc[i]);
            });
        }

        lineBox.appendChild(infoBox);

        return lineBox;

    },

    removeInfoBoxPosition: function()
    {
        ViperUtil.empty(this._infoBoxHolder);

    },


    /**
     * Positions the infobox so that it points to the specified point+dimension.
     */
    _positionInfoBox: function(infoBox, dim, show)
    {
        var height  = 0;
        var offset  = 35;
        var prevBox = infoBox;

        // Calculate the total height.
        while (prevBox = prevBox.previousSibling) {
            // Offset is the distance between the new box and the previous box.
            var prevRect = ViperUtil.getBoundingRectangle(prevBox.firstChild);
            if (parseInt(prevRect.y2 - prevRect.y1) > 0) {
                height = parseInt(prevRect.y2 - dim.y2) + offset;
                break;
            }
        }

        if (show !== true) {
            ViperUtil.addClass(infoBox, 'CT-ins');
        }

        if (this._orientation === 'left') {
            ViperUtil.setStyle(infoBox, 'left', 'auto');
            ViperUtil.setStyle(infoBox, 'right', 0);
        } else {
            ViperUtil.setStyle(infoBox, 'right', 'auto');
            ViperUtil.setStyle(infoBox, 'left', 0);
        }

        ViperUtil.setStyle(infoBox, 'top', parseInt(dim.y2) + 'px');
        if (height > 0) {
            ViperUtil.setStyle(infoBox, 'height', height + 'px');
        }

        ViperUtil.addClass(infoBox, 'visible');

    },

    _createInfoboxHolder: function()
    {
        return;

        var id     = this._className + '-infoBoxHolder';
        var holder = ViperUtil.getid(id);
        if (holder) {
            ViperUtil.remove(holder);
        }

        holder    = Viper.document.createElement('div');
        holder.id = id;
        ViperUtil.addClass(holder, this._className + '-infoBoxHolder');
        Viper.document.body.appendChild(holder);

        return holder;

    },

    updateInfoBoxPosition: function()
    {
        return;

        if (!this._infoBoxHolder) {
            this._infoBoxHolder = this._createInfoboxHolder();
        }

        var rect      = ViperUtil.getBoundingRectangle(this._viper.getViperElement());
        var windowDim = ViperUtil.getWindowDimensions();
        var leftPos   = rect.x2;
        if (windowDim) {
            var infoWidth = parseInt(ViperUtil.getStyle(this._infoBoxHolder, 'width'));
            if ((windowDim.width < (rect.x2 + infoWidth))
                && (rect.x1 > infoWidth)
            ) {
                // Need to display the callout boxes on left.
                leftPos = (rect.x1 - infoWidth - 26);
                ViperUtil.addClass(this._infoBoxHolder, 'orientationLeft');
                this._orientation = 'left';
            } else {
                this._orientation = 'right';
                ViperUtil.removeClass(this._infoBoxHolder, 'orientationLeft');
            }
        } else {
            this._orientation = 'right';
            ViperUtil.removeClass(this._infoBoxHolder, 'orientationLeft');
        }

        ViperUtil.setStyle(this._infoBoxHolder, 'left', leftPos + 'px');

    },

    getUserAsset: function(userid, callback)
    {
        if (!userid) {
            if (!this.getCurrentUserid()) {
                callback.call(this, null);
                return null;
            }

            userid = this.getCurrentUserid();
        }

        if (this._users[userid]) {
            callback.call(this, this._users[userid]);
        } else if (!window['AssetManager']) {
            // Incase AssetManager does not exist.
            callback.call(this, null);
        } else {
            var self = this;
            AssetManager.getAsset(userid, function(asset) {
                self._users[userid] = asset;
                callback.call(self, asset);
            });
        }

    },

    getUserColour: function(userid)
    {
        var colourIndex = null;
        if (ViperUtil.isset(this._userColours[userid]) === true) {
            colourIndex = this._userColours[userid];
        } else {
            colourIndex = this.getAvailableColour();
            this.setUserColour(userid, colourIndex);
        }

        return colourIndex;

    },

    setUserColour: function(userid, colourIndex)
    {
        this._userColours[userid] = colourIndex;

    },

    getAvailableColour: function()
    {
        var self = this;
        var cln  = this._colours.length;
        for (var i = 0; i < cln; i++) {
            var found = false;
            ViperUtil.foreach(this._userColours, function(userid) {
                if (parseInt(self._userColours[userid]) === i) {
                    found = true;
                    return false;
                }
            });

            if (found === false) {
                return i;
            }
        }

        return -1;

    },

    getChangeId: function()
    {
        var id = this.getCurrentUserid() + '-' + (++this._changeSeq) + '-';
        id    += this.getUserColour(this.getCurrentUserid()) + '-' + Math.ceil(Math.random() * 999);
        if (this._changes[id]) {
            // Dupe.. create another..
            id = this.getChangeId();
        }

        return id;

    },

    addChange: function(ctnType, ctNodes, desc)
    {
        if (ViperChangeTracker.isTracking() !== true) {
            return null;
        }

        var changeid = this._batchChangeid;
        if (changeid === null) {
            // Generate an id.
            if (!this._changes) {
                this._changes = {};
            }

            changeid = this.getChangeId();

            // Create the change object.
            this._changes[changeid] = {
                type: ctnType,
                nodes: [],
                time: (new Date()).getTime(),
                userid: this.getCurrentUserid(),
                desc: desc
            };
        }//end if

        var self = this;
        ViperUtil.foreach(ctNodes, function(i) {
            self.addNodeToChange(changeid, ctNodes[i]);
        });

        return changeid;

    },

    /**
     * Adds a new DOMNode to specified change.
     *
     * @param {string}  changeid    Id of an existing change.
     * @param {DOMNode} ctNode      The element to add for the change.
     * @param {DOMNode} replaceNode If specified then the node will be removed
     *                              from specified change's nodes list.
     *
     * @type void
     */
    addNodeToChange: function(changeid, ctNode, replaceNode)
    {
        if (this._batchChangeid !== null) {
            changeid = this._batchChangeid;
        }

        var change = this.getChange(changeid);
        if (!change) {
            return;
        }

        if (!ctNode.getAttribute('viperChangeid')) {
            ctNode.setAttribute('viperChangeid', changeid);
        }

        if (!ctNode.getAttribute('time')) {
            ctNode.setAttribute('time', parseInt(change.time));
        }

        if (ViperUtil.hasClass(ctNode, ViperChangeTracker.getCTNodeClass(change.type)) === false) {
            ViperUtil.addClass(ctNode, ViperChangeTracker.getCTNodeClass(change.type));
        }

        var colourIndex = ViperChangeTracker.getUserColour(change.userid);
        var colour      = ViperChangeTracker.getColour(colourIndex);
        if (ViperUtil.hasClass(ctNode, 'CT-' + colour) === false) {
            ViperUtil.addClass(ctNode, 'CT-' + colour);
        }

        if (replaceNode) {
            var nl = change.nodes.length;
            for (var i = 0; i < nl; i++) {
                if (change.nodes[i] === replaceNode) {
                    ViperUtil.removeArrayIndex(change.nodes, i);
                    break;
                }
            }
        }

        change.nodes.push(ctNode);

    },

    getChange: function(changeid)
    {
        var change = null;
        if (this._changes[changeid]) {
            change = this._changes[changeid];
        }

        return change;

    },

    startBatchChange: function(ctnType)
    {
        if (this.isTracking() !== true) {
            return null;
        }

        this._batchChangeid = this.addChange(ctnType);
        return this._batchChangeid;

    },

    endBatchChange: function(changeid)
    {
        if (this.isTracking() === true) {
            if (changeid !== this._batchChangeid) {
                return;
            }

            this._batchChangeid = null;
        }

    },

    getChangeInfo: function(changeid, callback)
    {
        var change = this.getChange(changeid);
        if (!change) {
            callback.call(this, null);
            return;
        }

        var userid = change.userid;

        if (this._users[userid]) {
            var userAsset = this._users[userid];
            var info      = {
                ownerName: ViperUtil.ellipsize(userAsset.name, 13),
                ownerid: userAsset.id,
                time: '',
                typeName: ViperChangeTracker.getTypeTitle(change.type),
                typeid: change.type,
                desc: ViperChangeTracker.getDescription(change.type, change.nodes[0], changeid)
            };

            callback.call(this, info);
            return;
        } else {
            var self = this;
            ViperChangeTracker.getUserAsset(userid, function(asset) {
                if (asset) {
                    this._users[userid] = asset;
                } else {
                    // Set default values.
                    this._users[userid] = {
                        ownerName: 'N/A',
                        ownerid: 'N/A'
                    };
                }

                self.getChangeInfo(changeid, callback);
                return;
            });
        }//end if

    },

    /**
     * Viper use a function to retrieve the description of specified change.
     */
    setDescriptionCallback: function(ctnType, callback)
    {
        this._descCallbacks[ctnType] = callback;

    },

    getDescription: function(ctnType, node, changeid)
    {
        var desc = '';
        if (ViperUtil.isFn(this._descCallbacks[ctnType]) === true) {
            desc = this._descCallbacks[ctnType].call(this, node, ctnType, changeid);
        } else {
            var change = this.getChange(changeid);
            if (change && change.desc) {
                desc = change.desc;
            } else {
                var cnode = node.cloneNode(true);
                ViperUtil.remove(ViperUtil.getTag('del', cnode));

                var textContent = '';
                if (node.innerText) {
                    textContent = cnode.innerText;
                } else if (node.textContent) {
                    textContent = cnode.textContent;
                } else {
                    textContent = ViperUtil.getHtml(cnode);
                }

                desc  = ViperUtil.ellipsize(textContent, 30);
                cnode = null;
            }//end if
        }//end if

        return desc;

    },

    getDescriptionForNode: function(node)
    {
        var changeid = node.getAttribute('viperchangeid');
        if (!changeid) {
            return '';
        }

        var ctnType = this.getCTNTypeFromNode(node);
        if (!ctnType) {
            return;
        }

        return this.getDescription(ctnType, node, changeid);

    },

    setApproveCallback: function(ctnType, callback)
    {
        this._approveCallbacks[ctnType] = callback;

    },

    approveChanges: function(changeid, node)
    {
        if (!changeid && !node) {
            return;
        } else if (!node) {
            // Get the nodes and loop.
            var change = this.getChange(changeid);
            if (!change) {
                return;
            }

            var nodes = change.nodes;
            var ln    = nodes.length;
            for (var i = 0; i < ln; i++) {
                this.approveChanges(changeid, nodes[i]);
            }

            this.updatePositionMarkers(false);

            return;
        }

        var ctnType = this.getCTNTypeFromNode(node);
        if (!ctnType || !this._approveCallbacks[ctnType]) {
            return;
        }

        // Clone the node and its children then append it to a tmp div
        // where the processing can modify.
        var clone = node.cloneNode(true);
        var tmp   = Viper.document.createElement('div');
        tmp.appendChild(clone);

        // If this was a insert change then we need to approve all changes in it.
        if (this.isInsertType(ctnType) === true) {
            var self    = this;
            var ctNodes = this.getCTNodes(null, node);
            ViperUtil.foreach(ctNodes, function(i) {
                self.approveChanges(ctNodes[i].getAttribute('changeid'), ctNodes[i]);
            });
        }

        this._approveCallbacks[ctnType].call(this, tmp, node);

        this._viper.fireNodesChanged('ViperChangeTracker:approve');

    },

    setRejectCallback: function(ctnType, callback)
    {
        this._rejectCallbacks[ctnType] = callback;

    },

    rejectChanges: function(changeid, node)
    {
        if (!changeid && !node) {
            return;
        } else if (!node) {
            // Get the nodes and loop.
            var change = this.getChange(changeid);
            if (!change) {
                return;
            }

            var nodes = change.nodes;
            var ln    = nodes.length;
            for (var i = 0; i < ln; i++) {
                this.rejectChanges(changeid, nodes[i]);
            }

            this.updatePositionMarkers(false, true);
            return;
        }

        var ctnType = this.getCTNTypeFromNode(node);
        if (!ctnType || !this._rejectCallbacks[ctnType]) {
            return;
        }

        // Clone the node and its children then append it to a tmp div
        // where the processing can modify.
        var clone = node.cloneNode(true);
        var tmp   = Viper.document.createElement('div');
        tmp.appendChild(clone);

        this._rejectCallbacks[ctnType].call(this, tmp, node);

        this._viper.fireNodesChanged('ViperChangeTracker:reject');

    },

    showInfoBox: function(marker, infoBox)
    {
        // Hide other info boxes.
        var elems = ViperUtil.getClass('_viper-CT-lineBox', this._infoBoxHolder);
        ViperUtil.removeClass(elems, 'visible');
        ViperUtil.removeClass(elems, 'show');

        var melems = ViperUtil.getClass('_viper-CT-marker', this._markerHolder);
        ViperUtil.addClass(melems, 'CT-hidden');
        ViperUtil.removeClass(melems, 'show');

        ViperUtil.addClass(infoBox, 'visible');
        ViperUtil.removeClass(marker, 'CT-hidden');

        var dim = ViperUtil.getBoundingRectangle(marker);
        ViperUtil.addClass([marker, infoBox], 'show');
        this._positionInfoBox(infoBox, dim, true);

        var self = this;
        ViperUtil.addEvent(document, 'click.ViperChangeTracker', function() {
            ViperUtil.removeEvent(document, 'click.ViperChangeTracker');
            self.updatePositionMarkers(false);
        });

    },

    _positionInfoBoxes: function()
    {
        var elems = ViperUtil.getClass(this._className + '-lineBox', this._infoBoxHolder);
        var eln   = elems.length;

        if (elems.length === 0) {
            return;
        }

        var offset  = 35;
        var prevBox = null;
        for (var i = 0; i < eln; i++) {
            var box     = elems[i];
            var height  = 0;
            var boxRect = ViperUtil.getBoundingRectangle(box);
            if ((boxRect.y2 - boxRect.y1) <= 0) {
                continue;
            } else if (prevBox === null) {
                prevBox = box;
                continue;
            }

            var prevRect = ViperUtil.getBoundingRectangle(prevBox.firstChild);
            if (parseInt(prevRect.y2 - prevRect.y1) > 0) {
                height = parseInt(prevRect.y2 - boxRect.y1) + offset;

                ViperUtil.setStyle(box, 'height', height + 'px');
            }

            prevBox = box;
        }//end for

    },

    _setMouseEvents: function(infoBox, marker, node, isInsertType, changeid)
    {
        var self = this;
        ViperUtil.addEvent([infoBox, marker, node], 'mouseover', function() {
            ViperUtil.addClass([infoBox, marker], 'selected');
        });

        ViperUtil.addEvent(marker, 'click', function(e) {
            self.showInfoBox(marker, infoBox);
            self._positionInfoBoxes();

            ViperUtil.preventDefault(e);
            return false;
        });

        var c          = this._className + '-infoBox-actionBtns';
        var rejectBtn  = ViperUtil.getClass(c + '-reject', infoBox)[0];
        var approveBtn = ViperUtil.getClass(c + '-approve', infoBox)[0];
        var parentNode = null;

        if (!approveBtn && !rejectBtn) {
            return;
        }

        if (rejectBtn) {
            parentNode = rejectBtn.parentNode.parentNode;
        } else {
            parentNode = approveBtn.parentNode.parentNode;
        }

        ViperUtil.addEvent([infoBox, marker, node], 'mouseout', function() {
            ViperUtil.removeClass([infoBox, marker], 'selected');
            ViperUtil.removeClass(parentNode, 'approve');
            ViperUtil.removeClass(parentNode, 'reject');
        });

        // Action button events.
        if (rejectBtn) {
            ViperUtil.addEvent(rejectBtn, 'mouseover', function() {
                ViperUtil.addClass(parentNode, 'reject');
                ViperUtil.removeClass(parentNode, 'approve');
            });

            ViperUtil.addEvent(rejectBtn, 'click', function(e) {
                self.rejectChanges(changeid);
                ViperUtil.preventDefault(e);
                return false;
            });
        }

        if (approveBtn) {
            ViperUtil.addEvent(approveBtn, 'mouseover', function() {
                ViperUtil.addClass(parentNode, 'approve');
                ViperUtil.removeClass(parentNode, 'reject');
            });

            ViperUtil.addEvent(approveBtn, 'click', function(e) {
                self.approveChanges(changeid);
                ViperUtil.preventDefault(e);
                return false;
            });
        }

    },

    /**
     * Removes the styles for change tracking from specified node.
     */
    removeTrackChanges: function(node, nodeOnly)
    {
        if (ViperChangeTracker.isTracking() !== true) {
            return;
        }

        var elems = [];
        if (nodeOnly !== true) {
            elems = ViperUtil.getClass(this._nodeClassName, node);
        }

        elems.push(node);

        var r = new RegExp('_viper-|\\s*CTN?[a-zA-Z-]*', 'g');

        var self = this;
        ViperUtil.foreach(elems, function(i) {
            if (!elems[i].parentNode) {
                return;
            }

            var classAttr = ViperUtil.attr(elems[i], 'class');
            classAttr     = classAttr.replace(r, '');
            ViperUtil.attr(elems[i], 'class', classAttr);

            if (ViperUtil.attr(elems[i], 'class') === '') {
                ViperUtil.removeAttr(elems[i], 'class');
            }

            ViperUtil.removeAttr(elems[i], 'viperchangeid');
            ViperUtil.removeAttr(elems[i], 'time');

            // If element is a del tag then move contents inside to before it
            // and remove node.
            if (ViperUtil.isTag(elems[i], 'del') === true || ViperUtil.isTag(elems[i], 'ins') === true) {
                ViperUtil.insertBefore(elems[i], elems[i].childNodes);
                ViperUtil.remove(elems[i]);
            } else if (ViperChangeTracker.getCurrentMode() === 'original') {
                // If the tag has a ctdata then convert its tag.
                var ctdata = self.getCTData(elems[i], 'tagName');
                if (ctdata) {
                    var newTag = Viper.document.createElement(ctdata);
                    while (elems[i].firstChild) {
                        newTag.appendChild(elems[i].firstChild);
                    }

                    ViperUtil.insertBefore(elems[i], newTag);
                    ViperUtil.remove(elems[i]);
                }
            }

            ViperUtil.removeAttr(elems[i], 'ctdata');
        });

    },

    /**
     * Sets the ctdata attribute of specified node. Ctdata is a JSON string.
     */
    setCTData: function(node, type, value)
    {
        if (!node || !type) {
            return false;
        }

        if (this.isTracking() !== true) {
            return false;
        }

        var ctdata = this.getCTData(node);
        if (!ctdata) {
            if (value === null) {
                // If ctdata is not set and value is null don't do anything.
                return true;
            }

            // Initialise the ctdata attr.
            ctdata       = {};
            ctdata[type] = value;
        } else if (value === null) {
            if (ViperUtil.isset(ctdata[type]) === true) {
                // If the value is null and the ctdata for type is set then remove it.
                delete ctdata[type];
            } else {
                // No need to update anything sinde the value is null and
                // the data type is not set.
                return true;
            }
        } else {
            ctdata[type] = value;
        }//end if

        ctdata = JSON.stringify(ctdata);
        if (ctdata === '{}') {
            // Data is empty so no reason to keep the attribute.
            ViperUtil.removeAttr(node, 'ctdata');
            return true;
        }

        ViperUtil.attr(node, 'ctdata', ctdata);
        return true;

    },

    getCTData: function(node, type)
    {
        if (!node) {
            return null;
        }

        var ctdata = ViperUtil.attr(node, 'ctdata');
        if (!ctdata) {
            return null;
        }

        ctdata = JSON.parse(ctdata);
        if (!type) {
            return ctdata;
        }

        return ctdata[type];

    },

    removeCTData: function(node, type)
    {
        if (node) {
            if (!type) {
                // Remove the whole attr.
                ViperUtil.removeAttr(node, 'ctdata');
            } else {
                this.setCTData(node, type, null);
            }
        }

    },

     /**
     * Returns the change info.
     */
    getTrackingInfo: function(elem)
    {
        var info    = null;
        var changes = this.loadCTNodes(elem);
        ViperUtil.foreach(changes, function(changeid) {
            if (info === null) {
                info = {};
            }

            if (ViperUtil.isset(changes[changeid].comment) === true) {
                info[changeid] = {
                    comment: changes[changeid].comment
                };
            }
        });

        return info;

    },

    loadCTNodes: function(elem)
    {
        var ctNodes = this.getCTNodes(null, elem);
        var changes = {};
        var self    = this;

        ViperUtil.foreach(ctNodes, function(i) {
            var node = ctNodes[i];

            // Get information from the node.
            var changeid = node.getAttribute('viperchangeid');
            if (changes[changeid]) {
                changes[changeid].nodes.push(node);
            } else {
                var type = self.getCTNTypeFromNode(node);
                changes[changeid] = {
                    type: type,
                    time: node.getAttribute('time'),
                    nodes: [node],
                    userid: (changeid.split('-')).shift()
                };

                if (type === 'viperComment') {
                    // A comment node. Get its comment.
                    changes[changeid].comment = (self._comments[changeid] || '');
                }
            }//end if
        });

        return changes;

    },

    setCurrentUserid: function(userid)
    {
        this._currentUserid = userid;

    },

    getCurrentUserid: function()
    {
        return this._currentUserid;

    }


};
