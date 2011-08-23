/**
 * Viper is a WYSIWYG that does not require the use of editable regions. Instead
 * it utilises the browser's range API to edit the content directly in the browser.
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

function Viper(id, options, callback)
{
    this.scripts = ['ViperSelection', 'ViperDOMRange', 'ViperElementMetrics', 'ViperTextMetrics',
    'ViperIERange', 'ViperMozRange', 'XPath', 'ViperPlugin', 'ViperPluginManager', 'ViperUndoManager', 'ViperChangeTracker'];

    this.id             = id;
    this.caretInterval  = null;
    this.caret          = null;
    this.CARET_LEFT     = 1;
    this.CARET_RIGHT    = 2;
    this.currRange      = null;
    this.enabled        = false;
    this.caretContainer = null;
    this.caretHeight    = 0;
    this.caretAtStart   = true;
    this.caretInterval  = null;
    this.inlineMode     = false;
    this._caretColour   = '#000';
    this._browserType   = null;
    this._document      = document;
    this._canCleanDom   = true;

    this._isTextChange     = false;
    this._fireNodesChanged = false;

    this.ViperUndoManager   = null;
    this.ViperPluginManager = null;

    this._settings = {
        changeTracking: false
    };

    this._subElementActive = false;
    this._mainElem         = null;

    // Callback methods which are added by external objects.
    this.callbacks = {};
    this.stylesURL = '';
    this.viperURL  = '';

    if (!options) {
        options = {};
    }

    // First load the required scripts.
    var viperURL = options.viperURL || './viper';

    this.init();

    if (options) {
        var self = this;
        this._processOptions(options, function() {
            if (callback) {
                callback.call(self, self);
            }
        });
    }

}

Viper.document = document;
Viper.window   = window;

Viper.prototype = {

    getId: function()
    {
        return this.id;
    },

    _processOptions: function(options, callback)
    {
        var self = this;
        for (var op in options) {
            var fn = 'set' + dfx.ucFirst(op);
            if (fn === 'setSetting') {
                delete options[op];
                // Reserved.
                continue;
            }

            if (dfx.isFn(this[fn]) === true) {
                this[fn](options[op], function() {
                    delete options[op];
                    self._processOptions(options, callback);
                });
                return;
            } else {
                this.setSetting(op, options[op]);
                delete options[op];
                self._processOptions(options, callback);
                return;
            }
        }//end for

        callback.call(this);

    },

    setPluginSets: function(sets, callback)
    {
        var self = this;
        for (var setName in sets) {
            var set = sets[setName];
            this.ViperPluginManager.addPluginSet(setName, set.plugins, true, function() {
                delete sets[setName];
                self.setPluginSets(sets, callback);
            });
            return;
        }

        if (callback) {
            callback.call(this);
        }

    },

    setSetting: function(setting, value)
    {
        this._settings[setting] = value;

    },

    getSetting: function(setting)
    {
        return this._settings[setting];

    },

    /**
     * Initialise Viper.
     *
     * @return {void}
     */
    init: function()
    {
        this.ViperUndoManager   = new ViperUndoManager(this);
        this.ViperPluginManager = new ViperPluginManager(this);

        ViperChangeTracker.init(this, false);
        this._setupCoreTrackChangeActions();
        ViperChangeTracker.addChangeType('textRemoved', 'Deleted', 'remove');
        ViperChangeTracker.addChangeType('textAdded', 'Inserted', 'insert');
        ViperChangeTracker.addChangeType('merged', 'Merged', 'remove');

    },

    /**
     * Set Viper mode.
     *
     * If Viper is using "inline" mode then some of the actions will be disabled
     *
     * @param {string} mode The Viper mode (inline or block).
     *
     * @return {void}
     */
    setMode: function(mode)
    {
        if (mode === 'inline') {
            this.inlineMode = true;
        } else {
            this.inlineMode = false;
        }

    },

    /**
     * Returns the current browser type.
     *
     * @return {string}
     */
    getBrowserType: function()
    {
        if (this._browserType === null) {
            var tests = ['msie', 'firefox', 'chrome', 'safari'];
            var tln   = tests.length;
            for (var i = 0; i < tln; i++) {
                var r = new RegExp(tests[i], 'i');
                if (r.test(navigator.userAgent) === true) {
                    this._browserType = tests[i];
                    return this._browserType;
                }
            }

            this._browserType = 'other';
        }

        return this._browserType;

    },

    /**
     * Checks if specified browser type is the current browser.
     *
     * @param {string} browser The browser type to test.
     *
     * @return {boolean}
     */
    isBrowser: function(browser)
    {
        return (this.getBrowserType() === browser);

    },

    /**
     * Adds the events required for mouse navigating and key navigating/typing.
     *
     * @return {void}
     */
    _addEvents: function(elem)
    {
        if (!elem) {
            elem = this.element;
        }

        this._document = elem.ownerDocument;
        Viper.document = this._document;
        if (this._document.defaultView) {
            Viper.window = this._document.defaultView;
        } else {
            Viper.window = window;
        }

        this._removeEvents(elem);
        var self = this;
        dfx.addEvent(elem, 'mouseup.viper', function(e) {
            setTimeout(function() {
                self.mouseUp(e);
            }, 200);
        });

        dfx.addEvent(this._document, 'mousedown.viper', function(e) {
            return self.mouseDown(e);
        });

        // Add key events. Note that there is a known issue with IME keyboard events
        // see https://bugzilla.mozilla.org/show_bug.cgi?id=354358. This effects
        // change tracking while using Korean, Chinese etc.
        dfx.addEvent(elem, 'keypress.viper', function(e) {
            return self.keyPress(e);
        });

        dfx.addEvent(elem, 'keydown.viper', function(e) {
            return self.keyDown(e);
        });

        dfx.addEvent(elem, 'keyup.viper', function(e) {
            self.fireCallbacks('Viper:keyup');
            self.fireCaretUpdated();
            if (self._fireNodesChanged) {
                if (self.isBrowser('firefox') === true) {
                    // I <3 _moz_dirty.....
                    var range = self.getCurrentRange();
                    if (range.startContainer && range.startContainer.parentNode) {
                         if (range.startContainer.nodeType === dfx.TEXT_NODE
                             && range.startContainer.data.length < 2
                         ) {
                             self.cleanDOM(range.startContainer.parentNode, 'br');
                         }
                    }

                    if (range.endContainer
                        && range.startContainer !== range.endContainer
                        && range.endContainer.parentNode
                    ) {
                        self.cleanDOM(range.endContainer.parentNode, 'br');
                    }
                }//end if

                self._fireNodesChanged = false;
                self.fireNodesChanged('Viper:insertNode', null, self._isTextChange);
            }//end if
        });

        dfx.addEvent(elem, 'blur.viper', function(e) {
            self.cleanDOM();

            var range          = self.getCurrentRange();
            var lastSelectable = range._getLastSelectableChild(elem);
            if (lastSelectable && lastSelectable.nodeType === dfx.TEXT_NODE) {
                lastSelectable.data = dfx.rtrim(lastSelectable.data);
            }
        });

    },

    /**
     * Removes the events required for mouse navigating and key navigating/typing.
     *
     * @return void
     */
    _removeEvents: function(elem)
    {
        if (!elem) {
            elem = this.element;
        }

        dfx.removeEvent(this._document, '.viper');
        dfx.removeEvent(elem, '.viper');

    },

    /**
     * Enables or disables Viper.
     *
     * @param boolean enabled If true viper will be enabled, otherwise it will be
     *                        disabled.
     */
     setEnabled: function(enabled)
     {
        if (enabled === true && this.enabled === false) {
            this._addEvents();
            var range = this.getCurrentRange();
            this.element.focus();
            this.setRange(range._getFirstSelectableChild(this.element), 0);
            this.enabled = true;
            this.fireCallbacks('viperEnabled');
            this.element.setAttribute('contentEditable', true);
            dfx.setStyle(this.element, 'outline', 'none');
        } else if (enabled === false && this.enabled === true) {
            // Back to final mode.
            ViperChangeTracker.activateFinalMode();
            this.cleanDOM(this.element);

            if (dfx.trim(dfx.getNodeTextContent(this.element)) === '') {
                this.initEditableElement();
            }

            this.element.setAttribute('contentEditable', false);
            dfx.setStyle(this.element, 'outline', 'invert');
            this._removeEvents();
            this.enabled = false;
            this.fireCallbacks('viperDisabled');
            ViperChangeTracker.disableChangeTracking();
            ViperChangeTracker.cleanUp();
        }//end if

    },

    isEnabled: function()
    {
        return this.enabled;

    },

    /**
     * Sets the element that should be editable. The current element that is
     * editable will become non-editable.
     *
     * If you wish to have two elements that are editable simutaneously, then
     * construct to viper instances.
     *
     * @param DomElement elem The element to become editable.
     *
     * @return void
     */
    setEditableElement: function(elem)
    {
        if (this.element) {
            this.element.setAttribute('contentEditable', false);
            dfx.setStyle(this.element, 'outline', 'invert');
        }

        // Turn off tracking.
        ViperChangeTracker.cleanUp();
        this.setSubElementState(null, false);
        ViperChangeTracker.init(this, false);

        this.setEnabled(false);
        this.element = elem;
        this.initEditableElement();
        this.setEnabled(true);
        this.ViperUndoManager.setActiveElement(elem);
        this.inlineMode = false;
        elem.setAttribute('contentEditable', true);
        dfx.setStyle(elem, 'outline', 'none');

        if (this.getSetting('changeTracking') === true) {
            ViperChangeTracker.enableChangeTracking();
        }

        this.focus();

    },

    initEditableElement: function()
    {
        var elem = this.element;
        if (!elem) {
            return;
        }

        var tmp = Viper.document.createElement('div');
        dfx.setHtml(tmp, this.getContents());
        if (dfx.trim(dfx.getNodeTextContent(tmp)).length === 0 || dfx.getHtml(tmp) === '&nbsp;') {
            // Check for stub elements.
            var tags         = dfx.getTag('*', tmp);
            var hasStubElems = false;
            dfx.foreach(tags, function(i) {
                if (dfx.isStubElement(tags[i]) === true) {
                    hasStubElems = true;
                    return false;
                }
            });

            if (hasStubElems !== true) {
                // Insert initial P tags.
                var range = this.getCurrentRange();
                if (this.inlineMode !== true && dfx.getStyle(this.element, 'display') === 'block') {
                    dfx.setHtml(this.element, '<p>&nbsp;</p>');
                    range.setStart(this.element.firstChild.firstChild);
                } else {
                    dfx.setHtml(this.element, '&nbsp;');
                    range.setStart(this.element.firstChild);
                }
            }
        }//end if

    },

    getEditableElement: function()
    {
        return this.element;

    },

    setSubElementState: function(elem, active)
    {
        if (active === true) {
            if (this._subElementActive === true && this.element !== elem) {
                this.setSubElementState(this.element, false);
            }

            if (this._subElementActive !== true) {
                this._mainElem = this.element;
                this.element = elem;
                this._subElementActive = true;
                this.element.setAttribute('contentEditable', true);
                dfx.setStyle(this.element, 'outline', 'none');
                this._addEvents();
                this.fireCallbacks('subElementEnabled', elem);
            }
        } else if (this.element && this._subElementActive === true) {
            this.element.setAttribute('contentEditable', false);
            dfx.setStyle(this.element, 'outline', 'invert');
            this._removeEvents();
            var pelem              = this.element;
            this.element           = this._mainElem;
            this._subElementActive = false;
            this._mainElem         = null;
            this.fireCallbacks('subElementDisabled', pelem);
        }//end if

    },

    getViperElement: function()
    {
        if (this._subElementActive === true) {
            return this._mainElem;
        }

        return this.element;

    },

    getViperSubElement: function()
    {
        if (this._subElementActive === true) {
            return this.element;
        }

        return null;

    },

    getViperActiveElement: function()
    {
        return this.element;

    },

    getCurrentRange: function()
    {
        return ViperSelection.getRangeAt(0);

    },

    getCaretCoords: function()
    {
        var coords = {};
        try {
            var bookmark = this.createBookmark();
            dfx.setStyle(bookmark.end, 'display', 'inline');
            coords = dfx.getElementCoords(bookmark.end);
            dfx.remove(bookmark.start);
            dfx.remove(bookmark.end);
        } catch (e) {
            coords = {
                x: -1,
                y: -1
            };
        }

        return coords;

    },

    rangeInViperBounds: function()
    {
        var range = this.getCurrentRange();
        if (range === null || this.isOutOfBounds(range.startContainer) || this.isOutOfBounds(range.endContainer)) {
            return false;
        }

        return true;

    },

    isOutOfBounds: function(element)
    {
        if (element === this.element || dfx.isChildOf(element, this.element) === true) {
            return false;
        } else if (this._subElementActive === true && (element === this._mainElem || dfx.isChildOf(element, this._mainElem) === true)) {
            return false;
        }

        return true;

    },

    /**
     * Inserts a node after the current caret position.
     *
     * If the current selection is not collapsed, then the contents currently
     * selected will be deleted before inserting the specified node The new caret
     * position will exist after the inserted node.
     *
     * @param DOMNode node The node to insert.
     *
     * @return void
     */
    insertNodeAtCaret: function(node)
    {
        var range = this.getCurrentRange();

        // If we have any nodes highlighted, then we want to delete them before
        // inserting the new text.
        if (range.collapsed !== true) {
            this.deleteContents();
            this.initEditableElement();

            // Update the range var.
            range = this.getCurrentRange();
            if (range.startContainer === range.endContainer && this.element === range.startContainer) {
                // The whole editable element is selected. Need to remove everything
                // and init its contents.
                dfx.empty(this.element);
                this.initEditableElement();

                // Update the range.
                var firstSelectable = range._getFirstSelectableChild(this.element);
                range.setStart(firstSelectable, 0);
                range.collapse(true);
            }
        } else if (dfx.isStubElement(range.startContainer.parentNode) === true) {
            var newNode = Viper.document.createTextNode('');
            dfx.insertBefore(range.startContainer.parentNode, newNode);
            dfx.remove(range.startContainer.parentNode);
            range.setStart(newNode, 0);
            range.collapse(true);
            ViperSelection.addRange(range);
        }//end if

        if (typeof node === 'string') {
            if (node === '\r') {
                return;
            }

            var newNode  = Viper.document.createTextNode(node);
            var noBlock  = true;
            var newRange = this.ctmInsertNodeAtCaret(range, newNode);
            if (newRange !== false) {
                noBlock = false;
            } else {
                newRange = range;

                 if (newRange.collapsed === true
                     && newRange.startContainer.parentNode
                     && newRange.startContainer.parentNode.firstChild.nodeType === dfx.TEXT_NODE
                     && newRange.startContainer.parentNode.firstChild === newRange.startContainer.parentNode.lastChild
                     && dfx.trim(newRange.startContainer.parentNode.firstChild.data) === ''
                 ) {
                     newRange.setStart(newRange.startContainer.parentNode.firstChild, 0);
                     newRange.collapse(true);
                     newRange.startContainer.parentNode.firstChild.data = '';
                 } else if (newRange.collapsed === true
                     && dfx.isStubElement(newRange.startContainer) === true
                 ) {
                     var tmpTextNode = Viper.document.createTextNode('');
                     dfx.insertBefore(newRange.startContainer, tmpTextNode);
                     dfx.remove(newRange.startContainer);
                     newRange.setStart(tmpTextNode, 0);
                     newRange.collapse(true);
                 }
            }//end if

            if (this.ViperPluginManager.fireNodeInserted(newNode, newRange) === false) {
                noBlock = false;
            }

            if (noBlock === false) {
                return false;
            }

            // Let the browser handle character insertion.
            //this.fireNodesChanged('Viper:insertNode', true, true);
            this._fireNodesChanged = true;
            this._isTextChange     = true;
            return;
        } else {
            // We need to import nodes from a document fragment into the current
            // this._document, so that we don't have document fragments within our this._document,
            // as they don't have parentNodes and are hard to work with.
            if (node.nodeType === dfx.DOCUMENT_FRAGMENT_NODE) {
                if (this.isBrowser('msie') === true) {
                    // Insert a marker span tag to the caret positioon.
                    range.rangeObj.pasteHTML('<span id="__viperMarker"></span>');
                    var marker = dfx.getId('__viperMarker');

                    // Put the node contents after the marker.
                    dfx.insertAfter(marker, node);

                    // Remove the marker.
                    dfx.remove(marker);
                    range.collapse(false);
                    return;
                } else {
                    var newNode = null;
                    var clen    = node.childNodes.length;
                    for (var i = 0; i < clen; i++) {
                        var child = node.childNodes[i];

                        // We need to skip text nodes that don't represent any content
                        // as if they exist as the last node in the fragment, we won't
                        // be able to set the end of the range to that node.
                        if (child.nodeType === dfx.TEXT_NODE) {
                            if (dfx.trim(child.data) === '') {
                                continue;
                            }
                        }

                        newNode = Viper.document.importNode(child, true);
                        range.insertNode(newNode);

                        // We need to move to the end of the new node after insertion.
                        // Otherwise next node will be inserted before this one.
                        range.selectNode(newNode);
                        range.collapse(false);
                    }//end for

                    node = newNode;
                    range.moveEnd('character', -1);
                    range.moveEnd('character', 1);
                    range.collapse(false);
                    return;
                }//end if
            } else if (dfx.isStubElement(range.startContainer) === true) {
                dfx.insertBefore(range.startContainer, node);
            } else {
                range.insertNode(node);
            }//end if

            range.setEndAfter(node, (this._getNodeOffset(node) + 1));
            range.collapse(false);
        }//end if

    },

    /**
     * Change Tracking Mode: InsertNodeAtCaret.
     */
    ctmInsertNodeAtCaret: function(range, node)
    {
        if (ViperChangeTracker.isTracking() === true) {
            if (range.collapsed === false) {
                // Range should be collapsed by the time this method is called.
                return range;
            }

            var offset    = range.startOffset;
            var ctNode    = null;
            var startNode = range.getStartNode();

            // Make sure startNode is not inside a textRemoved CTNode.
            if (ViperChangeTracker.getCTNode(startNode, 'textRemoved') !== null) {
                return false;
            }

            // Determine if a new CTNode needs to be created.
            ctNode = ViperChangeTracker.getCTNode(startNode, 'textAdd');

            if (ctNode === null) {
                if (offset === 0) {
                    // Look at the previous sibling to see if its a CTNode.
                    while (startNode) {
                        startNode = startNode.previousSibling;
                        if (startNode && (startNode.nodeType !== dfx.TEXT_NODE || startNode.data.length !== 0)) {
                            break;
                        }
                    }

                    ctNode = ViperChangeTracker.getCTNode(startNode, 'textAdd');
                    if (ctNode !== null) {
                        var newNode = Viper.document.createTextNode('');
                        ctNode.appendChild(newNode);
                        range.setStart(newNode, 0);
                        range.collapse(true);
                    }
                } else if (offset === startNode.data.length) {
                    // Look at the next sibling to see if its a CTNode.
                    while (startNode) {
                        startNode = startNode.nextSibling;
                        if (startNode && (startNode.nodeType !== dfx.TEXT_NODE || startNode.data.length !== 0)) {
                            break;
                        }
                    }

                    ctNode = ViperChangeTracker.getCTNode(startNode, 'textAdd');
                    if (ctNode !== null) {
                        var newNode = Viper.document.createTextNode('');
                        dfx.insertBefore(ctNode.firstChild, newNode);
                        range.setStart(newNode, 0);
                        range.collapse(true);
                    }
                }//end if
            }//end if

            if (ctNode === null) {
                // Create a new CTNode.
                ctNode = ViperChangeTracker.createCTNode('ins', 'textAdd', node);
                ViperChangeTracker.addChange('textAdded', [ctNode]);
                range.insertNode(ctNode);
                range.setEnd(node, 1);
                range.collapse(false);
                ViperSelection.addRange(range);
            } else {
                return false;
            }
        } else {
            return false;
        }//end if

        return range;

    },

    /**
     * Inserts the specified text after the current caret location.
     *
     * If the current selection is not collapsed, then the contents currently
     * selected will be deleted before inserting the specified node The new caret
     * position will exist after the inserted node.
     *
     * @param string text The text to insert.
     *
     * @return void
     */
    insertTextAtCaret: function(text)
    {
        if (typeof text !== 'string') {
            throw('InvalidArgumentException: text must be a string');
        }

        return this.insertNodeAtCaret(text);

    },

    /**
     * Returns the offset where the node exists in the parent's childNodes property.
     *
     * @param DomNode node The node to obtain the offset for.
     *
     * @return integer
     */
    _getNodeOffset: function(node)
    {
        var nodes = node.parentNode.childNodes;
        var ln    = nodes.length;
        for (var i = 0; i < ln; i++) {
            if (nodes[i] === node) {
                return i;
            }
        }

    },

    _parentWillBeDeleted: function(node)
    {
        // Check to see if the container that we are deleting from will have
        // any content in it after the delete operation. If not, then it should
        // be removed to avoid having empty elements.
        if (node.parentNode) {
            var parentContent = dfx.trim(dfx.getNodeTextContent(node.parentNode));
            if (parentContent === '' || parentContent === '&nbsp;') {
                return true;
            } else {
                return false;
            }
        }

        return false;

    },

    getBlockParent: function(node)
    {
        if (node) {
            while (node.parentNode) {
                node = node.parentNode;
                if (node === this.element) {
                    return null;
                }

                if (dfx.isBlockElement(node) === true) {
                    return node;
                }
            }
        }

        return null;

    },

    /**
     * Returns the text contents of specified elements as an array.
     */
    getTextContentFromElements: function(elements)
    {
        var text = [];
        dfx.foreach(elements, function(i) {
            if (elements[i].nodeType === dfx.TEXT_NODE) {
                text.push(elements[i].data);
            } else {
                text.push(dfx.getNodeTextContent(elements[i]));
            }
        });

        return text;

    },

    deleteContents: function(right)
    {
        var range = this.getCurrentRange();
        if (range.collapsed === false) {
            // Delete multiple elements.
            this._deleteFromSelection(range);
        } else {
            // Range is collapsed.
            var container = range.startContainer;
            if (container.nodeType === dfx.ELEMENT_NODE) {
                // Delete an element node.
                this._deleteNode(range);
            } else if (container.nodeType === dfx.TEXT_NODE) {
                if (right === true) {
                    // Remove content from the right of the caret (delete).
                    this._deleteFromRight(range);
                } else {
                    // Remove content from the left of the caret (backspace).
                    this._deleteFromLeft(range);
                }
            }
        }//end if

        ViperSelection.addRange(range);

        this.fireNodesChanged(null, true);

    },

    _deleteNode: function(range)
    {
        var container = range.startContainer;

        // If the selection is a stub element (e.g. br, img)
        // then just remove the node.
        if (dfx.isStubElement(container) === true) {
            this.removeElem(container);
            return;
        } else if (container === this.element && range.startOffset === 0) {
            // The whole editable element is selected then clear its contents.
            if (this.inlineMode !== true && dfx.getStyle(this.element, 'display') === 'block') {
                dfx.setHtml(this.element, '<p>&nbsp;</p>');
            } else {
                dfx.setHtml(this.element, '&nbsp;');
            }

            range.setStart(this.element.firstChild.firstChild, 0);
            range.collapse(true);
            return;
        }

    },

    _deleteFromSelection: function(range)
    {
        // Book mark the range.
        var bookmark = this.createBookmark();

        // Remove all elements in between.
        var elements = dfx.getElementsBetween(bookmark.start, bookmark.end);

        // Tracking Mode.
        // Intead of removing nodes just wrap them with a span tag.
        if (ViperChangeTracker.isTracking() === true) {
            var removedText = (this.getTextContentFromElements(elements)).join('');

            var changeid = ViperChangeTracker.addChange('textRemoved');
            var eln      = elements.length;
            for (var i = 0; i < eln; i++) {
                var elem = elements[i];
                if (ViperChangeTracker.getCTNode(elem, 'textRemoved') === null) {
                    if (dfx.isBlockElement(elem) === true) {
                        var del = Viper.document.createElement('del');
                        dfx.insertBefore(elem, del);
                        del.appendChild(elem);
                        ViperChangeTracker.addNodeToChange(changeid, del);
                    } else {
                        this._wrapElement(elem, 'del', function(newElem) {
                            // Add new class to wrap element to mark it as "deleted".
                            ViperChangeTracker.addNodeToChange(changeid, newElem);
                        });
                    }
                }
            }

            var startEl = bookmark.start.previousSibling;
            if (!startEl) {
                startEl = Viper.document.createTextNode('');
                dfx.insertBefore(bookmark.start, startEl);
                this.selectBookmark(bookmark);
                range = this.getCurrentRange();
                range.setStart(startEl, 0);
            } else {
                this.selectBookmark(bookmark);
                range = this.getCurrentRange();
                // Move left and then right to position the start of range
                // just before the CTNode.
                range.moveStart(ViperDOMRange.CHARACTER_UNIT, -1);
                range.moveStart(ViperDOMRange.CHARACTER_UNIT, 1);
            }

            range.collapse(true);
            return;
        }//end if

        // Remove all the elements in between.
        this.removeElem(elements);

        var parent    = bookmark.start.parentNode;
        var endParent = bookmark.end.parentNode;

        // Select Bookmark.
        this.selectBookmark(bookmark);

        if (parent && dfx.getHtml(parent) === '') {
            dfx.setHtml(parent, '&nbsp;');
            range.setStart(parent.firstChild, 0);
        }

        // Remove the parent node of the end range if its empty.
        if (endParent && parent !== endParent && dfx.getHtml(endParent) === '') {
            dfx.remove(endParent);
        }

        // Collapse range to the start.
        range.collapse(true);

    },

    _deleteFromRight: function(range)
    {
        var container = range.startContainer;

        // Remove content from the right of caret (i.e. delete key).
        // First check if caret is at the end of a container.
        if (range.endOffset === container.data.length) {
            // Check if need to merge containers.
            var cRange = range.cloneRange();
            cRange.moveEnd(ViperDOMRange.CHARACTER_UNIT, 1);
            var eParent = this.getBlockParent(cRange.endContainer);
            if (eParent) {
                if (dfx.isChildOf(eParent, this.element) === false) {
                    return;
                }

                var sParent = this.getBlockParent(cRange.startContainer);

                // If the start of the cloned range has moved to a new block
                // parent then merge these nodes.
                if (eParent !== sParent) {
                    this.mergeContainers(eParent, sParent);
                    range.setStart(cRange.startContainer, cRange.startContainer.data.length);
                    range.collapse(true);
                    return;
                }
            }

            // Caret is at the end of a container so it needs to
            // move to the next container.
            var nextContainer = range.getNextContainer(container);

            // If range is at the end of the container and the
            // next container is out side of Viper then do nothing.
            if (dfx.isChildOf(nextContainer, this.element) === false) {
                return false;
            }

            var firstSelectable = range._getFirstSelectableChild(nextContainer);
            range.setStart(firstSelectable, 0);

            if (ViperChangeTracker.isTracking() === true) {
                // Tracking Mode.
                // Instead of removing nodes wrap them around new
                // span tags.
                this._addTextNodeTracking(firstSelectable, range);
            } else {
                range.collapse(true);
                range.moveEnd(ViperDOMRange.CHARACTER_UNIT, 1);
                range.deleteContents();
                range.collapse(true);

                // If the parent container is going to be empty then it
                // should be removed.
                if (this._parentWillBeDeleted(container) === true) {
                    dfx.remove(container.parentNode);
                }
            }
        } else {
            var textNode    = range.getStartNode();
            var isTracking  = ViperChangeTracker.isTracking();
            var textAddNode = null;
            if (isTracking === true) {
                textAddNode = ViperChangeTracker.getCTNode(textNode, 'textAdd');
            }

            if (isTracking === true && textAddNode === null) {
                // Tracking Mode
                // Instead of removing contents, wrap them in a new
                // "delete" span tag.
                this._addTextNodeTracking(textNode, range, true);
            } else {
                range.moveEnd(ViperDOMRange.CHARACTER_UNIT, 1);
                range.deleteContents();

                // The textAddNode is a tracked inserted content, its contents
                // are deleted and it may be empty.
                if (textAddNode !== null && dfx.isBlank(dfx.getNodeTextContent(textAddNode)) === true) {
                    // Content is now empty, so remove the node.
                    var prevSibling = textAddNode.previousSibling;
                    if (!prevSibling || prevSibling.nodeType !== dfx.TEXT_NODE) {
                        prevSibling = Viper.document.createTextNode('');
                        dfx.insertBefore(textAddNode, prevSibling);
                    }

                    range.setStart(prevSibling, prevSibling.data.length);

                    dfx.remove(textAddNode);
                }
            }//end if
        }//end if

    },

    _deleteFromLeft: function(range)
    {
        var container = range.startContainer;

        // First check if caret is at the start of a container.
        if (range.startOffset === 0) {
            // Check if need to merge containers.
            var cRange = range.cloneRange();
            cRange.moveStart(ViperDOMRange.CHARACTER_UNIT, -1);

            var sParent = this.getBlockParent(cRange.startContainer);
            if (sParent) {
                if (dfx.isChildOf(sParent, this.element) === false) {
                    // If the endContainer is inside the editable text region then
                    // move the start of the range to the beginning.
                    var firstChild = dfx.getFirstChild(this.element);
                    if (!firstChild) {
                        return false;
                    } else {
                        cRange.setStart(firstChild, 0);
                        sParent = this.getBlockParent(cRange.startContainer);
                    }
                }

                var eParent = this.getBlockParent(cRange.endContainer);

                // If the start of the cloned range has moved to a new block
                // parent then merge these nodes.
                if (eParent !== sParent) {
                    this.mergeContainers(eParent, sParent);

                    range.setStart(cRange.startContainer, cRange.startContainer.data.length);
                    range.collapse(true);

                    // Two block containers merged, clean empty containers.
                    this.removeEmptyNodes();
                    return;
                }
            }//end if

            // Caret is at the start of a container so it needs to
            // move to the previous container.
            var previousContainer = range.getPreviousContainer(container);

            // If range is at the beginning of the container and the
            // previous container is out side of Viper then do nothing.
            if (dfx.isChildOf(previousContainer, this.element) === false) {
                return false;
            }

            if (dfx.isStubElement(previousContainer) === true) {
                if (ViperChangeTracker.isTracking() === true) {
                    // Tracking Mode
                    // Mark the stub element as "deleted".
                    range.moveStart(ViperDOMRange.CHARACTER_UNIT, -1);
                    dfx.addClass(previousContainer, ViperChangeTracker.getCTNodeClass('textRemoved'));
                    dfx.attr(previousContainer, 'title', 'Content removed');
                } else {
                    dfx.remove(previousContainer);
                }

                range.collapse(true);
            } else {
                var lastSelectable = range._getLastSelectableChild(previousContainer);
                range.setStart(lastSelectable, lastSelectable.data.length);

                if (ViperChangeTracker.isTracking() === true) {
                    // Tracking Mode.
                    // Instead of removing nodes wrap them around new
                    // span tags.
                    this._addTextNodeTracking(lastSelectable, range);
                } else {
                    range.collapse(true);
                    range.moveStart(ViperDOMRange.CHARACTER_UNIT, -1);
                    range.deleteContents();

                    // If the parent container is going to be empty then it
                    // should be removed.
                    if (this._parentWillBeDeleted(container) === true) {
                        dfx.remove(container.parentNode);
                    }
                }
            }//end if
        } else {
            var textNode    = range.getStartNode();
            var isTracking  = ViperChangeTracker.isTracking();
            var textAddNode = null;
            if (isTracking === true) {
                textAddNode = ViperChangeTracker.getCTNode(textNode, 'textAdd');
            }

            if (isTracking === true && textAddNode === null) {
                // Tracking Mode
                // Instead of removing contents, wrap them in a new
                // "delete" span tag.
                this._addTextNodeTracking(textNode, range);
            } else {
                range.moveStart(ViperDOMRange.CHARACTER_UNIT, -1);
                range.deleteContents();

                // The textAddNode is a tracked inserted content, its contents
                // are deleted and it may be empty.
                if (textAddNode !== null && dfx.isBlank(dfx.getNodeTextContent(textAddNode)) === true) {
                    // Content is now empty, so remove the node.
                    var prevSibling = textAddNode.previousSibling;
                    if (!prevSibling || prevSibling.nodeType !== dfx.TEXT_NODE) {
                        prevSibling = Viper.document.createTextNode('');
                        dfx.insertBefore(textAddNode, prevSibling);
                    }

                    range.setStart(prevSibling, prevSibling.data.length);

                    dfx.remove(textAddNode);
                }
            }//end if
        }//end if

    },

    _addTextNodeTracking: function(textNode, range, del)
    {
        if ((del !== true && range.startOffset === 0) || ViperChangeTracker.getCTNode(textNode, 'textRemoved') !== null) {
            return;
        }

        var beforeText  = '';
        var removedChar = '';
        var afterText   = '';

        if (del !== true) {
            beforeText  = textNode.nodeValue.substring(0, (range.startOffset - 1));
            removedChar = textNode.nodeValue.substr((range.startOffset - 1), 1);
            afterText   = textNode.nodeValue.substring(range.startOffset);
        } else {
            beforeText  = textNode.nodeValue.substring(0, range.endOffset);
            removedChar = textNode.nodeValue.substr(range.endOffset, 1);
            afterText   = textNode.nodeValue.substring((range.endOffset + 1));
        }

        if ((range.startOffset === 1 && del !== true) || (del === true && range.startOffset === 0)) {
            // Check if we can merge to an existing previous CTNode.
            var ctNode = ViperChangeTracker.getCTNode(textNode.previousSibling, 'textRemoved');
            if (ctNode) {
                // Can add the removed char to previous sibling.
                if (del !== true) {
                    if (ctNode.lastChild && ctNode.lastChild.nodeType === dfx.TEXT_NODE) {
                        ctNode.lastChild.nodeValue += removedChar;
                        range.setStart(ctNode.lastChild, (ctNode.lastChild.nodeValue.length - 1));
                    } else {
                        var charNode = Viper.document.createTextNode(removedChar);
                        ctNode.appendChild(charNode);
                        range.setStart(charNode, 0);
                    }

                    // Update textNode.
                    textNode.nodeValue = beforeText + afterText;
                    // Update textNode.
                    textNode.nodeValue = beforeText + afterText;
                    if (textNode.nodeValue.length === 0) {
                        // Move the range to the right until there is valid sibling.
                        var found           = false;
                        var previousSibling = textNode.previousSibling;
                        while (found !== true) {
                            ctNode = ViperChangeTracker.getCTNode(previousSibling, 'textRemoved');
                            if (!ctNode) {
                                found = true;
                            } else {
                                previousSibling = previousSibling.previousSibling;
                            }
                        }

                        if (previousSibling) {
                            previousSibling = range._getLastSelectableChild(previousSibling);
                            range.setStart(previousSibling, previousSibling.nodeValue.length);
                            range.collapse(true);
                        }
                    } else {
                        range.collapse(true);
                    }//end if
                } else {
                    if (ctNode.lastChild && ctNode.lastChild.nodeType === dfx.TEXT_NODE) {
                        ctNode.lastChild.nodeValue += removedChar;
                    } else {
                        var charNode = Viper.document.createTextNode(removedChar);
                        ctNode.appendChild(charNode);
                    }

                    // Update textNode.
                    textNode.nodeValue = beforeText + afterText;
                    if (textNode.nodeValue.length === 0) {
                        // Move the range to the right until there is valid sibling.
                        var found       = false;
                        var nextSibling = textNode.nextSibling;
                        while (found !== true) {
                            ctNode = ViperChangeTracker.getCTNode(nextSibling, 'textRemoved');
                            if (!ctNode) {
                                found = true;
                            } else {
                                nextSibling = nextSibling.nextSibling;
                            }
                        }

                        if (nextSibling) {
                            range.setStart(nextSibling, 0);
                            range.collapse(true);
                        }
                    } else {
                        range.setStart(textNode, 0);
                        range.collapse(true);
                    }//end if
                }//end if

                // TODO: Check if textNode is blank then check next and previous siblings.
                // If they are both textRemove tracking nodes and same user
                // then join them together.
                return;
            }//end if
        }//end if

        if (range.startOffset === textNode.nodeValue.length) {
            // Range is at the end of the text node. Check if next sibling
            // is a CTNode that we can join to.
            var ctNode = ViperChangeTracker.getCTNode(textNode.nextSibling, 'textRemoved');
            if (ctNode) {
                if (ctNode.firstChild && ctNode.firstChild.nodeType === dfx.TEXT_NODE) {
                    ctNode.firstChild.nodeValue = removedChar + ctNode.firstChild.nodeValue;
                } else {
                    var charNode = Viper.document.createTextNode(removedChar);
                    dfx.insertBefore(ctNode.firstChild, charNode);
                }

                // Update textNode.
                textNode.nodeValue = beforeText;
                range.setStart(textNode, textNode.nodeValue.length);
                range.collapse(true);
                return;
            }
        }

        var ctNode  = ViperChangeTracker.createCTNode('del', 'textRemoved');
        var newNode = null;
        if (del !== true) {
            newNode           = textNode.splitText(range.startOffset - 1);
            newNode.nodeValue = newNode.nodeValue.substring(1);
            ViperChangeTracker.addChange('textRemoved', [ctNode]);

            dfx.insertAfter(textNode, newNode);
            ctNode.firstChild.nodeValue = removedChar;
            dfx.insertAfter(textNode, ctNode);
            range.setStart(textNode, textNode.nodeValue.length);
            range.collapse(true);
        } else {
            newNode           = textNode.splitText(range.endOffset);
            newNode.nodeValue = newNode.nodeValue.substring(1);
            ViperChangeTracker.addChange('textRemoved', [ctNode]);

            dfx.insertAfter(textNode, newNode);
            ctNode.firstChild.nodeValue = removedChar;
            dfx.insertAfter(textNode, ctNode);
            range.setStart(newNode, 0);
            range.collapse(true);
        }//end if

    },

    mergeContainers: function(node, mergeToNode)
    {
        if (!node || !mergeToNode) {
            return false;
        }

        if (ViperChangeTracker.isTracking() === true) {
            var del = Viper.document.createElement('del');
            mergeToNode.appendChild(del);
            ViperChangeTracker.addChange('merged', [del]);
        }

        if (node.nodeType === dfx.TEXT_NODE || dfx.isStubElement(node) === true) {
            // Move only this node.
            mergeToNode.appendChild(node);
        } else if (node.nodeType === dfx.ELEMENT_NODE) {
            // Move all the child nodes to the new parent.
            while (node.firstChild) {
                mergeToNode.appendChild(node.firstChild);
            }

            // Remove the node.
            dfx.remove(node);
        }

        return true;

    },

    /**
     * This is not as simple as wrapping a selection with the specified node.
     * For example, if the specified node is a STRONG tag, which is an inline
     * ELEMENT_NODE then it cannot be a parent to block element (i.e. P, DIV).
     */
    surroundContents: function(tag)
    {
        var range = this.getCurrentRange();
        var otag  = tag;

        if (this.rangeInViperBounds() !== true) {
            return;
        }

        if (ViperChangeTracker.isTracking() === true
            && ViperChangeTracker.getCurrentMode() === 'original'
        ) {
            // If the original mode is active then new style tags should not be
            // shown, but when final mode is activated they should be.
            tag = 'span';
        }

        if (range.collapsed !== true) {
            var startContainer = range.getStartNode();
            var endContainer   = range.getEndNode();
            if (startContainer === endContainer) {
                // Selected contents from same node.
                if (startContainer.nodeType === dfx.TEXT_NODE) {
                    // Selection is a text node.
                    // Just wrap the contents with the specified node.
                    var node         = Viper.document.createElement(tag);
                    var rangeContent = range.toString();
                    dfx.setNodeTextContent(node, rangeContent);

                    if (ViperChangeTracker.isTracking() === true) {
                        if (ViperChangeTracker.getCurrentMode() === 'original') {
                            ViperChangeTracker.setCTData(node, 'tagName', otag);
                        }

                        ViperChangeTracker.addChange('formatChange', [node]);
                    }

                    range.deleteContents();
                    range.insertNode(node);

                    range.setStart(node.firstChild, 0);
                    range.setEnd(node.firstChild, node.firstChild.length);
                    ViperSelection.addRange(range);
                } else {
                    var self     = this;
                    var changeid = null;
                    if (ViperChangeTracker.isTracking() === true) {
                        changeid = ViperChangeTracker.addChange('formatChange', [newElem]);
                    }

                    this._wrapElement(startContainer.childNodes[range.startOffset], tag, function(newElem) {
                        if (changeid !== null) {
                            if (ViperChangeTracker.getCurrentMode() === 'original') {
                                ViperChangeTracker.setCTData(newElem, 'tagName', otag);
                            }

                            // Add new class to wrap element to mark it as "changed".
                            ViperChangeTracker.addNodeToChange(changeid, newElem);
                        }
                    });
                }//end if
            } else {
                var bookmark       = this.createBookmark();
                var startContainer = null;
                var endContainer   = null;
                startContainer     = bookmark.start.previousSibling;
                endContainer       = bookmark.end.nextSibling;
                if (!endContainer) {
                    // TODO: When the bookmark is moved to its own class
                    // need to handle these type of cases (e.g. use getAdjNode() etc.).
                    endContainer = Viper.document.createTextNode('');
                    dfx.insertAfter(bookmark.end, endContainer);
                }

                if (!startContainer) {
                    // TODO: When the bookmark is moved to its own class
                    // need to handle these type of cases (e.g. use getAdjNode() etc.).
                    startContainer = Viper.document.createTextNode('');
                    dfx.insertBefore(bookmark.start, startContainer);
                }

                var elements = dfx.getElementsBetween(startContainer, endContainer);
                var c        = elements.length;
                var self     = this;
                var changeid = null;
                if (ViperChangeTracker.isTracking() === true) {
                    changeid = ViperChangeTracker.addChange('formatChange');
                }

                for (var i = 0; i < c; i++) {
                    this._wrapElement(elements[i], tag, function(newElem) {
                        if (changeid !== null) {
                            if (ViperChangeTracker.getCurrentMode() === 'original') {
                                ViperChangeTracker.setCTData(newElem, 'tagName', otag);
                            }

                            ViperChangeTracker.addNodeToChange(changeid, newElem);
                        }
                    });
                }

                this.selectBookmark(bookmark);
            }//end if
        }//end if

    },

    /**
     * Wraps specified tag name around parent node.
     *
     * @param DomNode  parent   A domNode that needs to be wrapped by new tag.
     * @param string   tag      Name of the tag to create.
     * @param function callback A callback function that will be called when a
     *                          new tag is created.
     */
    _wrapElement: function(parent, tag, callback)
    {
        if (!parent) {
            return;
        } else if (dfx.attr(parent, 'viperbookmark')) {
            return;
        }

        if (parent.nodeType === dfx.TEXT_NODE) {
            if (dfx.isBlank(parent.data) !== true) {
                // If the previous sibling is type of tag then append this text
                // node to that.
                if (parent.previousSibling && parent.previousSibling.nodeType === dfx.TEXT_NODE) {
                    if (parent.previousSibling.nodeValue === '') {
                        dfx.remove(parent.previousSibling);
                    }
                }

                if (parent.previousSibling
                    && parent.previousSibling.tagName
                    && parent.previousSibling.tagName.toLowerCase() === tag
                    && !dfx.attr(parent.previousSibling, 'viperbookmark')) {
                    parent.previousSibling.appendChild(parent);
                } else {
                    var elem = Viper.document.createElement(tag);
                    dfx.setNodeTextContent(elem, parent.nodeValue);
                    dfx.insertBefore(parent, elem);
                    dfx.remove(parent);

                    if (callback) {
                        callback.call(this, elem);
                    }
                }
            }//end if
        } else if (dfx.isStubElement(parent) === false) {
            if (dfx.isBlockElement(parent) === false && this.hasBlockChildren(parent) === false) {
                if (parent.tagName.toLowerCase() !== tag) {
                    // Does not have any block elements, so we can
                    // wrap the content inside the specified tag.
                    if (parent.previousSibling
                        && parent.previousSibling.tagName
                        && parent.previousSibling.tagName.toLowerCase() === tag
                        && dfx.isBlockElement(parent) === false
                        && !dfx.attr(parent.previousSibling, 'viperbookmark')) {
                        parent.previousSibling.appendChild(parent);
                    } else {
                        var elem = Viper.document.createElement(tag);
                        dfx.insertBefore(parent, elem);
                        elem.appendChild(parent);
                        this.removeTagFromChildren(elem, tag);

                        if (callback) {
                            callback.call(this, elem);
                        }
                    }
                }
            } else {
                // Because the node contains block level elements
                // we have to find the non block elements and wrap content around them.
                var c = parent.childNodes.length;
                for (var i = 0; i < c; i++) {
                    this._wrapElement(parent.childNodes[i], tag, callback);
                }
            }//end if
        }//end if

    },


    /**
     * Removes all matching tags from the parent element.
     * Note: This does not remove the contents of the matching elements,
     * it joins them to sibling elements.
     */
    removeTagFromChildren: function(parent, tag, incParent)
    {
        // TODO: We need to move this somewhere else...
        // Viper shouldn't know about keywords etc.
        if (parent.tagName && parent.tagName.toLowerCase() === 'span' && dfx.hasClass(parent, '_my4_keyword') === true) {
            return;
        }

        var c          = parent.childNodes.length;
        var childNodes = [];
        for (var i = 0; i < c; i++) {
            childNodes.push(parent.childNodes[i]);
        }

        for (var i = 0; i < c; i++) {
            var child = childNodes[i];
            if (child.nodeType === dfx.ELEMENT_NODE) {
                this.removeTagFromChildren(child, tag, true);
            }
        }

        if (incParent === true) {
            this.removeTag(parent, tag);
        }

    },

    removeTag: function(elem, tag)
    {
        if (elem.parentNode && elem.parentNode.nodeType === dfx.ELEMENT_NODE) {
            if (elem.nodeType === dfx.ELEMENT_NODE) {
                if (elem.tagName.toLowerCase() === tag) {
                    var span = null;
                    if (ViperChangeTracker.isTracking() === true) {
                        span = Viper.document.createElement('span');
                        ViperChangeTracker.setCTData(span, 'tagName', tag);
                        dfx.insertBefore(elem, span);
                        ViperChangeTracker.addChange('removedFormat', [span]);
                    }

                    while (elem.firstChild) {
                        if (span !== null) {
                            span.appendChild(elem.firstChild);
                        } else {
                            dfx.insertBefore(elem, elem.firstChild);
                        }
                    }

                    dfx.remove(elem);
                }
            }//end if
        }//end if

    },

    removeStylesBetweenElems: function(start, end, style)
    {
        var elems = dfx.getElementsBetween(start, end);
        elems.unshift(start);
        var len = elems.length;
        for (var i = 0; i < len; i++) {
            this.removeTagFromChildren(elems[i], style, true);
        }

    },

    removeStyle: function(style)
    {
        var range        = this.getCurrentRange();
        var startNode    = range.getStartNode();
        var endNode      = range.getEndNode();
        var startParents = dfx.getParents(startNode, style, this.element);
        var endParents   = dfx.getParents(endNode, style, this.element);

        this.removeStylesBetweenElems(startNode, endNode, style);

        if (startParents.length === 0 && endParents.length === 0) {
            // Start and End is not inside of style tag, so we are done.
            ViperSelection.addRange(range);
            return;
        }

        // Bookmark and get the top style parents.
        var bookmark       = this.createBookmark(range);
        var startTopParent = startParents.pop();
        var endTopParent   = endParents.pop();

        if (startTopParent === endTopParent) {
            var start     = startTopParent.cloneNode(true);
            var selection = startTopParent.cloneNode(true);
            var end       = startTopParent.cloneNode(true);

            // First remove everything from start bookmark to last child.
            var lastChild    = dfx.getLastChild(start);
            var elemsBetween = dfx.getElementsBetween(this.getBookmark(start, 'start'), lastChild);
            elemsBetween.push(this.getBookmark(start, 'start'));
            elemsBetween.push(this.getBookmark(start, 'end'));
            elemsBetween.push(lastChild);
            dfx.remove(elemsBetween);

            // Remove everything from first child to end bookmark.
            var firstChild   = dfx.getFirstChild(end);
            var elemsBetween = dfx.getElementsBetween(firstChild, this.getBookmark(end, 'end'));
            elemsBetween.push(this.getBookmark(end, 'end'));
            elemsBetween.push(this.getBookmark(end, 'start'));
            elemsBetween.push(firstChild);
            dfx.remove(elemsBetween);

            // Remove everything before and after bookmark start and end.
            var firstChild   = dfx.getFirstChild(selection);
            var elemsBetween = dfx.getElementsBetween(firstChild, this.getBookmark(selection, 'start'));
            elemsBetween.push(firstChild);
            dfx.remove(elemsBetween);
            var lastChild    = dfx.getLastChild(selection);
            var elemsBetween = dfx.getElementsBetween(this.getBookmark(selection, 'end'), lastChild);
            elemsBetween.push(lastChild);
            dfx.remove(elemsBetween);

            var div = Viper.document.createElement('div');
            div.appendChild(selection);
            this.removeTagFromChildren(div, style, true);

            dfx.removeEmptyNodes(start);
            dfx.removeEmptyNodes(end);

            dfx.removeEmptyNodes(div, function(elToDel) {
                if (dfx.isTag(elToDel, 'span') === true
                    && dfx.hasClass(elToDel, 'viperBookmark') === true
                ) {
                    // Do not remove bookmark.
                    return false;
                }
            });

            if (start.firstChild) {
                dfx.insertBefore(startTopParent, start);
            }

            dfx.insertBefore(startTopParent, div.childNodes);

            if (end.firstChild) {
                dfx.insertBefore(startTopParent, end);
            }

            dfx.remove(startTopParent);

            var originalBookmark = {
                start: this.getBookmark(this.element, 'start'),
                end: this.getBookmark(this.element, 'end')
            };

            this.selectBookmark(originalBookmark);
            return;
        }//end if

        // Start of selection is in the style tag.
        if (startTopParent) {
            var clone = startTopParent.cloneNode(true);

            // Remove everything from bookmark to lastChild (inclusive).
            var lastChild    = dfx.getLastChild(startTopParent);
            var elemsBetween = dfx.getElementsBetween(bookmark.start, lastChild);
            elemsBetween.push(bookmark.start);
            elemsBetween.push(lastChild);
            dfx.remove(elemsBetween);

            // From the cloned node, remove everything from firstChild to start bookmark.
            var firstChild = dfx.getFirstChild(clone);
            elemsBetween   = dfx.getElementsBetween(firstChild, this.getBookmark(clone, 'start'));
            elemsBetween.push(firstChild);
            dfx.remove(elemsBetween);

            // Wrap the clone in to a div then remove its style tag.
            var div = Viper.document.createElement('div');
            div.appendChild(clone);
            this.removeTagFromChildren(div, style);
            dfx.insertAfter(startTopParent, div.childNodes);
        }//end if

        // End of selection is in the style tag.
        if (endTopParent) {
            var clone = endTopParent.cloneNode(true);

            // Remove everything from firstChild to bookmark (inclusive).
            var firstChild   = dfx.getFirstChild(endTopParent);
            var elemsBetween = dfx.getElementsBetween(firstChild, bookmark.end);
            elemsBetween.push(bookmark.end);
            elemsBetween.push(firstChild);
            dfx.remove(elemsBetween);

            // From the cloned node, remove everything from end bookmark to lastChild.
            var lastChild = dfx.getLastChild(clone);
            elemsBetween  = dfx.getElementsBetween(this.getBookmark(clone, 'end'), lastChild);
            elemsBetween.push(lastChild);
            dfx.remove(elemsBetween);

            // Wrap the clone in to a div then remove its style tag.
            var div = Viper.document.createElement('div');
            div.appendChild(clone);
            this.removeTagFromChildren(div, style);
            dfx.insertBefore(endTopParent, div.childNodes);
        }//end if

        var originalBookmark = {
            start: this.getBookmark(this.element, 'start'),
            end: this.getBookmark(this.element, 'end')
        };

        this.selectBookmark(originalBookmark);

    },

    selectBookmark: function(bookmark)
    {
        if (this.element) {
            this.element.focus();
        }

        var range       = this.getCurrentRange();
        var startPos    = null;
        var endPos      = null;
        var startOffset = 0;
        var endOffset   = null;
        if (bookmark.start.nextSibling === bookmark.end
            || dfx.getElementsBetween(bookmark.start, bookmark.end).length === 0
        ) {
            // Bookmark is collapsed.
            if (bookmark.end.nextSibling) {
                startPos = dfx.getFirstChild(bookmark.end.nextSibling);
            } else if (bookmark.start.previousSibling) {
                startPos = dfx.getFirstChild(bookmark.start.previousSibling);
                if (startPos.nodeType === dfx.TEXT_NODE) {
                    startOffset = startPos.length;
                }
            } else {
                // Create a text node in parent.
                bookmark.end.parentNode.appendChild(Viper.document.createTextNode(''));
                startPos = dfx.getFirstChild(bookmark.end.nextSibling);
            }
        } else {
            if (bookmark.start.nextSibling) {
                startPos = dfx.getFirstChild(bookmark.start.nextSibling);
            } else {
                if (!bookmark.start.previousSibling) {
                    var tmp = Viper.document.createTextNode('');
                    dfx.insertBefore(bookmark.start, tmp);
                }

                startPos    = dfx.getLastChild(bookmark.start.previousSibling);
                startOffset = startPos.length;
            }

            if (bookmark.end.previousSibling) {
                endPos = dfx.getLastChild(bookmark.end.previousSibling);
            } else {
                endPos    = dfx.getFirstChild(bookmark.end.nextSibling);
                endOffset = 0;
            }
        }//end if

        dfx.remove([bookmark.start, bookmark.end]);

        if (endPos === null) {
            range.setEnd(startPos, startOffset);
            range.collapse(false);
        } else {
            range.setStart(startPos, startOffset);
            if (endOffset === null) {
                endOffset = (endPos.length || 0);
            }

            range.setEnd(endPos, endOffset);
        }

        try {
            ViperSelection.addRange(range);
        } catch (e) {
            // IE may throw exception for hidden elements..
        }

    },

    /*
        TODO: WE need to have id for each bookmark so that we can use
        dfx.getId() to retrieve a specific bookmark on a page. However,
        this will not work if the bookmark is not a part of the DOM tree.
     */
    getBookmark: function(parent, type)
    {
        var elem = dfx.getClass('viperBookmark_' + type, parent)[0];
        return elem;

    },

    removeBookmarks: function(elem)
    {
        dfx.remove(dfx.getClass('viperBookmark', elem, 'span'));

    },

    /**
     * Removes the specified bookmark and the contents in it.
     */
    removeBookmark: function(bookmark)
    {
        if (!bookmark.start || !bookmark.end) {
            return false;
        }

        var elems = dfx.getElementsBetween(bookmark.start, bookmark.end);
        elems.push(bookmark.start, bookmark.end);
        dfx.remove(elems);

    },

    createBookmark: function(range, keepOldBookmarks)
    {
        // Remove all bookmarks?
        if (keepOldBookmarks !== true) {
            this.removeBookmarks(this.element);
        }

        var currRange      = range || this.getCurrentRange();
        var range          = currRange.cloneRange();
        var startContainer = range.startContainer;
        var endContainer   = range.endContainer;
        var startOffset    = range.startOffset;
        var endOffset      = range.endOffset;

        // Collapse to the end of range.
        range.collapse(false);

        var endBookmark           = Viper.document.createElement('span');
        endBookmark.style.display = 'none';
        dfx.setHtml(endBookmark, '&nbsp;');
        dfx.addClass(endBookmark, 'viperBookmark viperBookmark_end');
        endBookmark.setAttribute('viperBookmark', 'end');
        range.insertNode(endBookmark);
        if (dfx.isChildOf(endBookmark, this.element) === false) {
            this.element.appendChild(endBookmark);
        }

        // Move the range to where it was before.
        range.setStart(startContainer, startOffset);
        range.collapse(true);

        // Create the start bookmark.
        var startBookmark           = Viper.document.createElement('span');
        startBookmark.style.display = 'none';
        dfx.addClass(startBookmark, 'viperBookmark viperBookmark_start');
        dfx.setHtml(startBookmark, '&nbsp;');
        startBookmark.setAttribute('viperBookmark', 'start');
        try {
            range.insertNode(startBookmark);

            // Make sure start and end are in correct position.
            if (startBookmark.previousSibling === endBookmark) {
                // Reverse..
                var tmp       = startBookmark;
                startBookmark = endBookmark;
                endBookmark   = tmp;
            }
        } catch (e) {
            // NS_ERROR_UNEXPECTED: I believe this is a Firefox bug.
            // It seems like if the range is collapsed and the text node is empty
            // (i.e. length = 0) then Firefox tries to split the node for no reason and fails...
            dfx.insertBefore(endBookmark, startBookmark);
        }

        if (dfx.isChildOf(startBookmark, this.element) === false) {
            if (this.element.firstChild) {
                dfx.insertBefore(this.element.firstChild, startBookmark);
            } else {
                // Should not happen...
                this.element.appendChild(startBookmark);
            }
        }

        if (!endBookmark.previousSibling) {
            var tmp = Viper.document.createTextNode('');
            dfx.insertBefore(endBookmark, tmp);
        }

        // The original range object must be changed.
        if (!startBookmark.nextSibling) {
            var tmp = Viper.document.createTextNode('');
            dfx.insertAfter(startBookmark, tmp);
        }

        currRange.setStart(startBookmark.nextSibling, 0);
        currRange.setEnd(endBookmark.previousSibling, (endBookmark.previousSibling.length || 0));

        var bookmark = {
            start: startBookmark,
            end: endBookmark
        };

        return bookmark;

    },

    insertNodeAtBookmark: function(node, bookmark, noSelect)
    {
        if (!bookmark || !node) {
            return;
        }

        dfx.insertBefore(bookmark.start, node);

        if (noSelect !== true) {
            // Select the bookmark.
            this.selectBookmark(bookmark);
        }

    },

    splitNodeAtRange: function(tag, range, copyMidTags)
    {
        range = range || this.getCurrentRange();

        var bookmark = this.createBookmark(range);
        return this.splitNodeAtBookmark(tag, bookmark, copyMidTags);

    },

    /**
        <p>
            sdfsdfsdf <em><strong>ddd<strong><em>sdfkj*sdhf</em>sdfsdfsdf</strong>xxxx</strong></em>
        </p>

        =>
        <p>
            sdfsdfsdf <em><strong>ddd<strong><em>sdfkj</em></strong></strong>
            *<strong>ddd<strong><em>sdhf</em>sdfsdfsdf</strong>xxxx</strong></em>
    */
    splitNodeAtBookmark: function(tag, bookmark, copyMidTags)
    {
        if (!bookmark) {
            return;
        }

        // Get the parent node with specified tag.
        var node      = bookmark.start.parentNode;
        var foundNode = null;
        while (node && node !== this.element) {
            if (dfx.isTag(node, tag) === true) {
                // Note, we do not want to break out of the loop yet..
                // Need to find the most outer parent with specified tag.
                foundNode = node;
            }

            node = node.parentNode;
        }

        var prevNode = null;
        var nextNode = null;
        var midNode  = null;

        if (foundNode === null) {
            // Parent with specified tag was not found.
            prevNode = bookmark.start.previousSibling;
            nextNode = bookmark.end.nextSibling;

            if (!prevNode && !nextNode) {
                prevNode = Viper.document.createTextNode('');
                dfx.insertBefore(bookmark.start, prevNode);
                nextNode = prevNode;
            } else if (!prevNode && nextNode) {
                prevNode = nextNode;
            } else if (!nextNode && prevNode) {
                nextNode = prevNode;
            }
        } else {
            var prevElem = null;
            var newElem  = null;
            var midElem  = null;
            var toRemove = [];
            var parents  = [];
            var prevLvl  = null;
            dfx.walk(foundNode, function(elem, lvl) {
                if (elem === bookmark.start) {
                    return false;
                }

                if (elem.nodeType === dfx.TEXT_NODE) {
                    // Move element to new parent.
                    toRemove.push(elem);
                    parents[(lvl - 1)].appendChild(elem.cloneNode(false));
                } else {
                    // Clone node.
                    var clone = elem.cloneNode(false);
                    if (prevLvl === null) {
                        newElem = clone;
                        parents.push(clone);
                    } else if (lvl === prevLvl) {
                        parents[(lvl - 1)].appendChild(clone);
                        parents.push(clone);
                    } else if (lvl > prevLvl) {
                        parents[prevLvl] = prevElem;
                    } else if (lvl < prevLvl) {
                        parents.pop();
                        parents.push(clone);
                        parents[(lvl - 1)].appendChild(clone);
                    }

                    if (copyMidTags === true) {
                        // If there are other tags between start point and end point
                        // then copy them between prevElem and nextElem.
                        if (dfx.isTag(elem, tag) === false) {
                            if (midElem === null) {
                                midElem = elem.cloneNode(false);
                            } else {
                                midElem.appendChild(elem.cloneNode(false));
                            }
                        }
                    }

                    prevElem = clone;
                }//end if

                prevLvl = lvl;
            });

            dfx.remove(toRemove);
            toRemove = null;

            if (this.elementIsEmpty(newElem) === false) {
                dfx.insertBefore(foundNode, newElem);
            } else {
                newElem = null;
            }

            if (midElem !== null) {
                dfx.insertBefore(foundNode, midElem);
            }

            prevNode = newElem;
            nextNode = foundNode;
            midNode  = midElem;
        }//end if

        this.selectBookmark(bookmark);

        return {
            prevNode: prevNode,
            nextNode: nextNode,
            midNode: midNode
        };

    },

    hasBlockChildren: function(parent)
    {
        var c = parent.childNodes.length;
        for (var i = 0; i < c; i++) {
            if (parent.childNodes[i].nodeType === dfx.ELEMENT_NODE) {
                if (dfx.isBlockElement(parent.childNodes[i]) === true) {
                    return true;
                }
            }
        }

        return false;

    },

    elementIsEmpty: function(elem)
    {
        if (dfx.isBlank(dfx.getNodeTextContent(elem)) === true) {
            // Might have stub elements.
            var tags = dfx.getTag('*', elem);
            var ln   = tags.length;
            for (var i = 0; i < ln; i++) {
                if (dfx.isStubElement(tags[i]) === true) {
                    return false;
                }
            }

            return true;
        }

        return false;

    },

    /**
     * Handles arrow, delete key events.
     *
     * @param {event} e The event object.
     *
     * return {void|boolean} Returns false if default event needs to be blocked.
     */
    _handleAncillaryKey: function(e)
    {
        var key            = e.keyCode;
        var preventDefault = true;
        var shiftKey       = e.shiftKey;

        switch (key) {
            case dfx.DOM_VK_DELETE:
                if (ViperChangeTracker.isTracking() !== true && this.isBrowser('firefox') !== true) {
                    preventDefault = false;
                } else {
                    var ret = this.deleteContents();
                    if (ret === false) {
                        preventDefault = false;
                    }
                }

                this.ViperPluginManager.fireKeyPressed(e);
            break;

            case 46:
                if (this.isBrowser('firefox') && e.type === 'keypress' || !this.isBrowser('firefox') && e.type === 'keydown') {
                    // Key 46 type keydown is the DELETE key unless you are FF in which case it is keypress.
                    this.deleteContents(true);
                    this.ViperPluginManager.fireKeyPressed(e);
                } else {
                    preventDefault = false;
                }
            break;

            case dfx.DOM_VK_DOWN:
            case dfx.DOM_VK_UP:
            case dfx.DOM_VK_LEFT:
            case dfx.DOM_VK_RIGHT:
                this.ViperPluginManager.fireCaretPositioned();
                preventDefault = false;
            break;

            default:
                // Ignore key.
                preventDefault = false;
            break;
        }//end switch

        if (preventDefault === true) {
            dfx.preventDefault(e);
            return false;
        }

        if (key === 46 && (this.isBrowser('firefox') && e.type === 'keypress' || !this.isBrowser('firefox') && e.type === 'keydown')) {
            this._fireNodesChanged = true;
        }

        return true;

    },

    /**
     * Handle the keyDown event.
     *
     * @param {event} e The event object.
     *
     * return {void|boolean} Returns false if default event needs to be blocked.
     */
    keyDown: function(e)
    {
        if (this.pluginActive() === true && this.ViperPluginManager.allowTextInput !== true) {
            return;
        }

        //if (!this.ViperPluginManager.fireKeyDown(e)) {
        //    return false;
        //}

        var preventDefaul = false;

        if (this._handleSpecialKey(e) === false) {
            if (this.isBrowser('msie') !== true) {
                this._preventKeyPress = true;
            }

            return false;
        } else if ((e.ctrlKey === true || e.metaKey === true)
            && (this.isBrowser('msie') === true || this.isBrowser('chrome') === true)
        ) {
            // IE does not fire keyPress event if ctrl is also pressed.
            // E.g. CTRL + B (Bold) will not fire keyPress so ViperPluginManager
            // needs to be notified here for IE.
            if (!this.ViperPluginManager.fireKeyPressed(e)) {
                return false;
            }
        }

        switch (e.keyCode) {
            case 27:
                // ESC: Disable Viper.
                this.fireClickedOutside();
            break;

            default:
                // If not Firefox then check if event is special arrow key etc.
                // Firefox will handle this in keyPress event.
                if (/Firefox/.test(navigator.userAgent) !== true) {
                    preventDefaul = !(this._handleAncillaryKey(e));
                }
            break;
        }//end switch

        if (preventDefaul === true) {
            dfx.preventDefault(e);
            return false;
        }

        return true;

    },


    /**
     * Handle the keyPress event.
     *
     * @param {event} e The event object.
     *
     * return {void|boolean} Returns false if default event needs to be blocked.
     */
    keyPress: function(e)
    {
        if (this._preventKeyPress === true) {
            this._preventKeyPress = false;
            return;
        }

        if (this.enabled !== true) {
            return;
        }

        if (this.pluginActive() === true && this.ViperPluginManager.allowTextInput !== true) {
            return;
        }

        if (!this.rangeInViperBounds()) {
            // If Range includes whole editable element then adjust it so
            // that only the editable element is selected.
            var range = this.getCurrentRange();
            if (range === null) {
                return true;
            }

            var commEl = range.getCommonElement();
            if (dfx.isChildOf(this.element, commEl) === true) {
                // Editable element is inside of the range.
                // Move the range inside of the Editable element.
                var startNode = range.getStartNode();
                var endNode   = range.getEndNode();

                // Move start range only if current range is out side of editable element.
                if (dfx.isChildOf(startNode, this.element) !== true) {
                    range.setStart(range._getFirstSelectableChild(this.element), 0);
                }

                // Move end range only if current range is out side of editable element.
                if (dfx.isChildOf(endNode, this.element) !== true) {
                    var lastSelectable = range._getLastSelectableChild(this.element);
                    range.setEnd(lastSelectable, lastSelectable.length);
                }

                ViperSelection.addRange(range);
            } else {
                if (e.keyCode === 8) {
                    // Backspace then stop propagation.
                    return false;
                }

                return true;
            }//end if
        }//end if

        if (!this.ViperPluginManager.fireKeyPressed(e)) {
            return false;
        }

        var char = null;
        if (e.which === null) {
            // IE.
            char = String.fromCharCode(e.keyCode);
        } else if (e.which > 0) {
            char = String.fromCharCode(e.which);
        }

        // Viper will ignore the keyPress event if CMD or CTRL key is also pressed
        // For example (CMD/CTRL + R). Bold etc. is handled by plugins or the
        // Viper._handleSpecialKey().
        if (char !== null && e.ctrlKey !== true && e.metaKey !== true) {
            switch (e.keyCode) {
                case dfx.DOM_VK_DELETE:
                     // Handle delete key for Firefox.
                    return this._handleAncillaryKey(e);
                break;

                default:
                    if (this.insertTextAtCaret(char) === false) {
                        return false;
                    }
                break;
            }
        }

        return this._handleAncillaryKey(e);

    },

    _handleSpecialKey: function(e)
    {
        var keyCode = e.which;
        if (keyCode === null) {
            // IE.
            keyCode = e.keyCode;
        }

        var preventDefault = false;
        switch (keyCode) {
            case 65:
                // Check for CTRL/CMD + A (select all).
                if (e.ctrlKey === true || e.metaKey === true) {
                    preventDefault = true;
                    var range      = this.getCurrentRange();

                    if (this.isBrowser('msie') === true) {
                        var selStart = Viper.document.createTextNode('');
                        var selEnd   = Viper.document.createTextNode('');

                        if (this.element.firstChild) {
                            dfx.insertBefore(this.element.firstChild, selStart);
                        } else {
                            this.element.appendChild(selStart);
                        }

                        this.element.appendChild(selEnd);

                        range.setStart(selStart, 0);
                        range.setEnd(selEnd, 0);
                    } else {
                        range.setStart(range._getFirstSelectableChild(this.element), 0);
                        var lastSelectable = range._getLastSelectableChild(this.element);
                        range.setEnd(lastSelectable, lastSelectable.length);
                    }//end if

                    ViperSelection.addRange(range);
                }//end if
            break;

            default:
                // Not a special key.
            break;
        }//end switch

        if (preventDefault === true) {
            dfx.preventDefault(e);
            return false;
        }

        return true;

    },

    focus: function()
    {
        if (this.element) {
            try {
                this.element.focus();
                this.fireCaretUpdated();
            } catch (e) {
                // Catch the IE error: Can't move focus to control because its invisible.
            }
        }

    },

    setRange: function(elem, pos)
    {
        var range = this.getCurrentRange();
        range.setStart(elem, pos);
        range.collapse(true);
        return range;

    },

    mouseUp: function(e, target)
    {
        if (this.ViperPluginManager.fireClicked(e) === false) {
            return false;
        }

        var range = this.getCurrentRange();

        if (!range) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isStubElement(target) === true) {
                var range = ViperSelection.createRange();
                range.selectNodeContents(target);
                ViperSelection.addRange(range);
            }
        } else if (range.collapsed === true) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isStubElement(target) === true) {
                range.selectNodeContents(target);
            } else if (range.startContainer.nodeType !== dfx.TEXT_NODE) {
                var startCont = range.startContainer;
                var elem      = startCont.childNodes[range.startOffset];
                var selNode   = null;
                if (elem) {
                    if (elem.firstChild) {
                        selNode = range._getFirstSelectableChild(elem);
                        if (selNode && dfx.isBlank(selNode.data) === true) {
                            selNode.data = '';
                        }
                    } else if (dfx.isStubElement(elem) === false) {
                        dfx.setHtml(elem, '&nbsp;');
                        selNode = elem.firstChild;
                    }

                    if (selNode) {
                        range.setStart(selNode, 0);
                        range.collapse(true);
                    }
                }
            } else if (range.startOffset === 1 && range.startContainer.data === String.fromCharCode(160)) {
                // If the node is just a space (i.e. &nbsp) then set the range before it.
                // that way space will be removed when a new character is inserted (see Viper.insertNodeAtCaret()).
                range.setStart(range.startContainer, 0);
                range.collapse(true);
            }//end if
        }//end if

        ViperSelection._lastRange = null;

        if (this.caret) {
            this.caret.style.visibility = 'hidden';
        }

        this.ViperPluginManager.fireSelectionChanged(range);
        this.fireCaretUpdated(range);

    },

    fireCaretUpdated: function(range)
    {
        range = range || this.getCurrentRange();
        this.fireCallbacks('caretPositioned', {range: range});

        //this.ViperPluginManager.fireCaretUpdated();

    },

    fireNodesChanged: function(type, noFocus, isTextChange)
    {
        type = type || 'text_change';

        if (isTextChange === true) {
            type = 'text_change';
        }

        this._isTextChange = false;

        this.fireCallbacks('nodesChanged');

        // Add the changes to undo history.
        this.ViperUndoManager.add('viper', type);

        // Update the markers.
        ViperChangeTracker.updatePositionMarkers(true);

        if (noFocus !== true) {
            this.focus();
        }

    },

    isChildOfElems: function(el, parents)
    {
        while (el && el.parentNode) {
            if (parents.inArray(el.parentNode) === true) {
                return true;
            }

            el = el.parentNode;
        }

        return false;

    },

    isChildOfClass: function(el, className, checkSelf)
    {
        if (checkSelf === true
            && el
            && dfx.hasClass(el.parentNode, className) === true
        ) {
            return true;
        }

        while (el && el.parentNode) {
            if (dfx.hasClass(el.parentNode, className) === true) {
                return true;
            }

            el = el.parentNode;
        }

        return false;

    },

    mouseDown: function(e, target)
    {
        if (e) {
            if (this.ViperPluginManager.fireMouseDown(e) === false) {
                return false;
            }
        }

        if (!target) {
            target = dfx.getMouseEventTarget(e);
        }

        if (target !== this.element) {
            if (dfx.isTag(target, 'html') === true) {
                // Scroll bars..
                return;
            }

            var elems = [this.element, dfx.getId('Help'), dfx.getId('HelpEditingToolbarIcon')];
            if (this._subElementActive === true) {
                if (target === this._mainElem || dfx.isChildOf(target, this._mainElem) === true) {
                    // Restore main element.
                    this.setSubElementState(null, false);
                    return;
                }
            }

            if (this.isChildOfElems(target, elems) === false) {
                if (this.isChildOfClass(target, '_viper-CT-marker', true) === false
                    && this.isChildOfClass(target, '_viper-CT-infoBoxHolder', true) === false
                ) {
                    this.fireClickedOutside(target);
                }
            } else {
                this.fireCaretUpdated();
            }
        }//end if

    },

    _setupCoreTrackChangeActions: function()
    {
        var self = this;
        ViperChangeTracker.setApproveCallback('textRemoved', function(clone, node) {
            // If removed text is approved then just remove the actual node.
            self.removeElem(node);
        });

        ViperChangeTracker.setRejectCallback('textRemoved', function(clone, node) {
            // Move all the content inside the node to outside.
            while (node.firstChild) {
                if (node.firstChild.nodeType === dfx.ELEMENT_NODE
                    && ViperChangeTracker.isTrackingNode(node.firstChild)
                ) {
                    dfx.remove(node.firstChild);
                } else {
                    dfx.insertBefore(node, node.firstChild);
                }
            }

            self.removeElem(node);
        });

        ViperChangeTracker.setApproveCallback('textAdded', function(clone, node) {
            // Move all the content inside the node to outside.
            while (node.firstChild) {
                dfx.insertBefore(node, node.firstChild);
            }

            self.removeElem(node);
        });

        ViperChangeTracker.setRejectCallback('textAdded', function(clone, node) {
            // Just remove the INS node.
            self.removeElem(node);
        });

        ViperChangeTracker.setApproveCallback('merged', function(clone, node) {
            self.removeElem(node);
        });

        ViperChangeTracker.setDescriptionCallback('merged', function(node) {
            return 'Text';
        });

        ViperChangeTracker.setRejectCallback('merged', function(clone, node) {
            var newParent = node.parentNode.cloneNode(false);
            dfx.insertAfter(node.parentNode, newParent);

            var elems = dfx.getElementsBetween(node, newParent);
            var elem  = null;
            while (elem = elems.shift()) {
                newParent.appendChild(elem);
            }

            self.removeElem(node);
        });

        ViperChangeTracker.setApproveCallback('viperComment', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node, false);
        });

    },

 //   fireClickedOutside: function(clickedElement)
 //   {
 //       // Check if the clicked element is part of a plugin (e.g. ViperToolbar).
 //       if (this.isPluginElement(clickedElement) === true) {
 //           return;
 //       }
 //
 //       // If a plugin is active (e.g has a popup window open) then do not disable Viper.
 //       if (this.pluginActive() === true) {
 //           // A plugin is active.
 //           return;
 //       }
 //
 //       if (this.getSetting('disableOnBlur') !== false) {
 //           this.setEnabled(false);
 //       }
 //
 //       this.fireCallbacks('clickedOutside');
 //
 //   },

    pluginActive: function()
    {
        return (this.ViperPluginManager.getActivePlugin() !== null);

    },

    isPluginElement: function(element)
    {
        return this.ViperPluginManager.isPluginElement(element);

    },

    registerCallback: function(type, namespace, callback)
    {
        if (dfx.isFn(callback) === false) {
            return;
        }

        if (!this.callbacks[type]) {
            this.callbacks[type] = {
                namespaces: {},
                others: []
            };
        }

        if (namespace) {
            if (!this.callbacks[type].namespaces[namespace]) {
                this.callbacks[type].namespaces[namespace] = [];
            }

            this.callbacks[type].namespaces[namespace] = callback;
        } else {
            this.callbacks[type].others.push(callback);
        }

    },

    fireCallbacks: function(type, data, doneCallback)
    {
        var callbackList = [];
        if (this.callbacks[type]) {
            // Put the callbacks in an array.
            for (var namespace in this.callbacks[type].namespaces) {
                if (this.callbacks[type].namespaces.hasOwnProperty(namespace) === true) {
                    var callback = this.callbacks[type].namespaces[namespace];
                    if (callback) {
                        callbackList.push(callback);
                    }
                }
            }

            var len = this.callbacks[type].others.length;
            for (var i = 0; i < len; i++) {
                callbackList.push(this.callbacks[type].others[i]);
            }
        }

        this._fireCallbacks(callbackList, data, doneCallback);

    },

    _fireCallbacks: function(callbacks, data, doneCallback)
    {
        if (callbacks.length === 0) {
            if (doneCallback) {
                doneCallback.call(this, data);
            }

            return;
        }

        var callback = callbacks.shift();
        if (dfx.isFn(callback) === true) {
            var self   = this;
            var retVal = callback.call(this, data, function(retVal) {
                if (retVal !== false) {
                    // If the function does use callback method then call self.
                    self._fireCallbacks(callbacks, data, doneCallback);
                }
            });

            if (retVal !== false) {
                this._fireCallbacks(callbacks, data, doneCallback);
            }
        }

    },

    removeCallback: function(type, namespace)
    {
        if (!type) {
            if (namespace) {
                // Remove all events for specified namespace.
                for (var type in this.callbacks) {
                    if (this.callbacks.hasOwnProperty(type) === true) {
                        this.removeCallback(type, namespace);
                    }
                }
            }
        } else if (this.callbacks[type]) {
            if (namespace) {
                if (this.callbacks[type].namespaces[namespace]) {
                    this.callbacks[type].namespaces[namespace] = [];
                }
            } else {
                // Remove all.
                delete this.callbacks[type];
            }
        }

    },


    /**
     * Gets the clean source code of the element.
     *
     * @return string.
     */
    getHtml: function(elem)
    {
        elem = elem || this.element;

        if (typeof elem === 'string') {
            var tmp = elem;
            elem    = Viper.document.createElement('div');
            dfx.setHtml(elem, tmp);
        }

        // Clone the element so we dont modify the actual contents.
        var clone = elem.cloneNode(true);

        this.removeEmptyNodes(clone);

        // Remove special Viper elements.
        this._removeViperElements(clone);

        // TODO: What if some of the plugins need to run after plugin X, Y, Z
        // e.g. Keyword plugin?
        // Plugins can hookin to this method to modify the HTML
        // before Viper returns its HTML contents.
        this.fireCallbacks('getHtml', {element: clone});
        var html = dfx.getHtml(clone);
        html     = this._fixHtml(html);

        return html;

    },

    getSaveContent: function(elem)
    {
        if (this.element === elem) {
            // Change to the final before saving.
            ViperChangeTracker.activateFinalMode();
        }

        var html = this.getHtml(elem);

        // If track changes active then add its info to the end of the content
        // to be saved.
        var info = ViperChangeTracker.getTrackingInfo(elem);
        if (info) {
            html += '<!--viperTrackInfo=' + dfx.jsonEncode(info) + '-->';
        }

        return html;

    },

    /**
     * Gets the HTML (not source) contents of the editable element.
     * Returned value contains Viper specific elements.
     *
     * @return string.
     */
    getContents: function(elem)
    {
        elem = elem || this.element;

        // Clone the element so we dont modify the actual contents.
        var clone = elem.cloneNode(true);

        // Remove special Viper elements.
        this._removeViperElements(clone);

        // Plugins can hookin to this method to modify the HTML
        // before Viper returns its HTML contents.
        this.fireCallbacks('getContents', {element: clone});
        var html = dfx.getHtml(clone);

        return html;

    },

    _removeViperElements: function(elem)
    {
        var bookmarks = dfx.getClass('viperBookmark', elem);
        if (bookmarks) {
            dfx.remove(bookmarks);
        }

        // Viper needs to remove the caret.
        var caret = dfx.getClass('viper_caret', elem);
        if (caret) {
            dfx.remove(caret);
        }

        caret = dfx.getId('caret');
        dfx.remove(caret);

    },

    /**
     * Sets the Viper content that may contain Viper specified elements.
     */
    setContents: function(contents)
    {
        if (typeof contents === 'string') {
            this.element.innerHTML = contents;
        } else if (contents) {
            this.element.appendChild(contents);
        }

        this.fireCallbacks('setContents', {element: this.element});

        this.initEditableElement();

    },

    /**
     * Sets the Viper content, content cannot contain Viper specific elements.
     */
    setHtml: function(contents, callback)
    {
        var clone = Viper.document.createElement('div');

        if (typeof contents === 'string') {
            dfx.setHtml(clone, contents);
        } else if (contents) {
            clone.appendChild(contents);
        }

        var range          = this.getCurrentRange();
        var lastSelectable = range._getLastSelectableChild(clone);
        if (lastSelectable && lastSelectable.nodeType === dfx.TEXT_NODE) {
            lastSelectable.data = dfx.rtrim(lastSelectable.data);
        }

        this.removeEmptyNodes(clone);

        var self = this;
        this.fireCallbacks('setHtml', {element: clone}, function() {
            dfx.setHtml(self.element, dfx.getHtml(clone));
            self.initEditableElement();
            if (callback) {
                callback.call(this);
            }
        });

    },

    /**
     * If set to true then cleanDOM method will not run.
     *
     * Should be used by plugins that change the focus to prevent special nodes being
     * removed.
     */
    setAllowCleanDOM: function(allow)
    {
        this._canCleanDom = allow;

    },

    canCleanDOM: function()
    {
        return this._canCleanDom;
    },

    cleanDOM: function(elem, tag)
    {
        if (this.canCleanDOM() === false) {
            return;
        }

        if (!elem) {
            elem = this.element;
        }

        this._cleanDOM(elem, tag);

        return elem;

    },

    _cleanDOM: function(elem, tag)
    {
        if (!elem) {
            return;
        }

        if (elem.firstChild && dfx.isTag(elem, 'pre') !== true) {
            this._cleanDOM(elem.firstChild, tag);
        }

        if (elem === this.element) {
            return;
        }

        var nextSibling = elem.nextSibling;
        this._cleanNode(elem, tag);

        if (nextSibling) {
            this._cleanDOM(nextSibling, tag);
        }

    },

    _cleanNode: function(node, tag)
    {
        if (node === this.element) {
            return;
        }

        if (node.nodeType === dfx.ELEMENT_NODE) {
            var tagName = node.tagName.toLowerCase();
            if (tag && tag != tagName) {
                return;
            }

            switch (tagName) {
                case 'br':
                    if (!node.nextSibling
                        || (node.hasAttribute && node.hasAttribute('_moz_dirty'))
                    ) {
                        if (tag) {
                            var newNode = Viper.document.createTextNode(' ');
                            dfx.insertBefore(node, newNode);
                        }

                        dfx.remove(node);
                    } else {
                        // Also remove the br tags that are at the end of an element.
                        // They are usually added to give the empty element height/width.
                        var next   = node.nextSibling;
                        var brLast = true;
                        while (next) {
                            if (next.nodeType !== dfx.TEXT_NODE || dfx.trim(next.nodeValue) !== '') {
                                brLast = false;
                                break;
                            }

                            next = next.nextSibling;
                        }

                        if (brLast === true) {
                            dfx.remove(node);
                        }
                    }//end if
                break;

                case 'a':
                    if (!node.getAttribute('name') && !node.firstChild) {
                        dfx.remove(node);
                    }
                break;

                case 'td':
                    // Nothing to see here PHPCS.
                break;

                default:
                    if (dfx.isStubElement(node) === false && !node.firstChild) {
                        // Any span with no content and class _my4_keyword is a keyword replacing with nothing.
                        // We don't want to get rid of those keywords.
                        if (tagName === 'span' && (node.getAttribute('viperchangeid') || dfx.hasClass(node, '_my4_keyword'))) {
                            return;
                        }

                        dfx.remove(node);
                    }
                break;
            }//end switch
        } else if (node.nodeType === dfx.TEXT_NODE && !tag) {
            if (dfx.trim(node.data, "\f\n\r\t\v\u2028\u2029") === '' && dfx.isTag(node.parentNode, 'td') === false) {
                dfx.remove(node);
            }
        }//end if

    },

    removeEmptyNodes: function(element, content)
    {
        if (content && !element) {
            element = document.createElement('div');
            dfx.setHtml(element, content);
        } else if (!content) {
            if (!element) {
                element = this.element;
            }
        } else {
            return;
        }

        this._cleanDOM(element);

        return element;

    },

    _fixHtml: function(html)
    {
        return dfx.fixHtml(html);

    },

    removeElem: function(elem)
    {
        if (dfx.isArray(elem) === true) {
            var eln = elem.length;
            for (var i = 0; i < eln; i++) {
                this.removeElem(elem[i]);
            }
        } else if (elem) {
            var parent = elem.parentNode;
            dfx.remove(elem);
            if (parent) {
                for (var node = parent.firstChild; node; node = node.nextSibling) {
                    if (node.nodeType !== dfx.TEXT_NODE || node.nodeValue.length !== 0) {
                        // Not empty.
                        return;
                    }
                }

                // If parent is now empty then remove it.
                dfx.remove(parent);
            }
        }

    }

};
