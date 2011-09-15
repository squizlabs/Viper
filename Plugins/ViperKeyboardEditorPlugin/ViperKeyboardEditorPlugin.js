/**
 * ViperKeyboardEditorPlugin. Handles auxillery content editing via keyboard
 * commands. For example, inserting p tags when the ENTER key is pressed.
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

function ViperKeyboardEditorPlugin(viper)
{
    this.viper = viper;
    var self   = this;

    // Make sure Viper fires the keyDown event for ENTER.
    this.viper.addSpecialKey(13);

    this.viper.registerCallback('Viper:keyDown', 'ViperKeyboardEditorPlugin', function(e) {
        if (viper.isKey(e, 'ENTER') === true) {
            return self.handleEnter();
        } else if (viper.isKey(e, 'SHIFT+ENTER') === true) {
            return self.handleSoftEnter(e);
        }
    });

}

ViperKeyboardEditorPlugin.prototype = {
    init: function()
    {
        var self = this;

        // Note: Should be a format change since it will be used in the whole
        // container.
        ViperChangeTracker.addChangeType('splitContainer', 'Insert', 'format');
        ViperChangeTracker.setDescriptionCallback('splitContainer', function(node) {
            return self._getChangeDescription(node, 'splitContainer');
        });
        ViperChangeTracker.setApproveCallback('splitContainer', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('splitContainer', function(clone, node) {
            // Get previous sibling.
            var prev = node.previousSibling;
            if (!prev) {
                return;
            }

            while (node.firstChild) {
                prev.appendChild(node.firstChild);
            }

            dfx.remove(node);
        });

        ViperChangeTracker.addChangeType('createContainer', 'Insert', 'insert');
        ViperChangeTracker.setDescriptionCallback('createContainer', function(node) {
            return self._getChangeDescription(node);
        });
        ViperChangeTracker.setApproveCallback('createContainer', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('createContainer', function(clone, node) {
            dfx.remove(node);
        });

    },

    _getChangeDescription: function(node, changeType)
    {
        var pImgURL = this.viper.getStylesURL() + '/icon-p_tag.png';
        var pImg    = Viper.document.createElement('img');
        dfx.attr(pImg, 'src', pImgURL);
        dfx.attr(pImg, 'title', 'Paragraph Break');
        var desc = pImg;

        if (changeType !== 'splitContainer') {
            for (var child = node.firstChild; child; child = child.nextSibling) {
                if (child.nodeType === dfx.TEXT_NODE && dfx.trim(child.nodeValue).length === 0) {
                    continue;
                } else if (ViperChangeTracker.isTrackingNode(child) === true) {
                    var ctnType = ViperChangeTracker.getCTNTypeFromNode(child);
                    if (ViperChangeTracker.isInsertType(ctnType) === true) {
                        var extraDesc = ViperChangeTracker.getDescriptionForNode(child);
                        if (dfx.isObj(extraDesc) === false) {
                            extraDesc = Viper.document.createTextNode(extraDesc);
                        }

                        desc = [desc, extraDesc];
                    }
                }//end if

                break;
            }//end for
        }

        return desc;

    },

    _isKeyword: function()
    {
        var keywordPlugin = this.viper.ViperPluginManager.getPlugin('ViperKeywordPlugin');
        if (!keywordPlugin) {
            return false;
        }

        var range = this.viper.getCurrentRange();
        if (keywordPlugin._isKeyword(range.startContainer) === false && keywordPlugin._isKeyword(range.startContainer) === false) {
            return false;
        }

        return true;

    },

    handleTab: function()
    {
        if (this._isKeyword() === true) {
            return true;
        }

        var numSpaces = 4;
        // Insert.
        var sp = String.fromCharCode(160);
        var c  = '';
        while (numSpaces-- > 0) {
            c += sp;
        }

        this.viper.insertNodeAtCaret(c);

        this.viper.fireNodesChanged('ViperKeyboardEditorPlugin:tab');

        return true;

    },

    handleEnter: function(returnFirstBlock)
    {
        if (this.viper.inlineMode === true) {
            return this.handleSoftEnter();
        }

        if (ViperChangeTracker.isTracking() !== true) {
            // Track changes is not turned on.. Let the browser do everything.
            return true;
        }

        // Because track changes is enabled we need to add extra info to elements
        return this._handleEnter(returnFirstBlock);

    },

    _handleEnter: function(returnFirstBlock)
    {
        if (this.viper.inlineMode === true) {
            return this.handleSoftEnter();
        }

        return this.splitAtRange(returnFirstBlock);

    },

    splitAtRange: function(returnFirstBlock)
    {
        var range = this.viper.getCurrentRange();

        // If the range is not collapsed then remove the contents of the selection.
        if (range.collapsed !== true) {
            this.viper.deleteContents();
        }

        if (range.startContainer.nodeType === dfx.TEXT_NODE) {
            // Find the first parent block element.
            var parent = range.startContainer.parentNode;

            var blockQuote = dfx.getParents(range.startContainer, 'blockquote', this.viper.element);

            while (parent) {
                if (parent.tagName.toLowerCase() === 'li') {
                    // Lists are special they are handled by the ViperListPlugin.
                    var listPlugin = this.viper.ViperPluginManager.getPlugin('ViperListPlugin');
                    if (listPlugin && listPlugin.handleEnter(parent) === false) {
                        return false;
                    }

                    break;
                } else if (dfx.isBlockElement(parent) === true) {
                    if (blockQuote.length === 0 || dfx.isTag(parent, 'blockquote') === true) {
                        break;
                    }
                }

                if (parent.parentNode && parent.parentNode === this.viper.element) {
                    break;
                }

                parent = parent.parentNode;
            }
        } else {
            parent = range.startContainer;
        }//end if

        // Create a new element and a document fragment with the contents of
        // the selection.
        var tag = parent.tagName.toLowerCase();

        // If the parent is not part of the editable element then we need to
        // create two new P tags.
        if (dfx.isChildOf(parent, this.viper.element) === false) {
            // Find the next non block sibling.
            var node = range.endContainer;
            while (dfx.isset(node.nextSibling) === true) {
                if (dfx.isBlockElement(node.nextSibling) === true) {
                    break;
                }

                node = node.nextSibling;
            }

            range.setEndAfter(node);

            var elem    = Viper.document.createElement('p');
            var docFrag = range.extractContents('p');

            this.viper.deleteContents();
            elem.appendChild(docFrag);
            dfx.insertAfter(range.startContainer, elem);
            range.collapse(true);

            // Find the previous non block sibling.
            node = range.startContainer;
            while (dfx.isset(node.previousSibling) === true) {
                if (dfx.isBlockElement(node.previousSibling) === true) {
                    break;
                }

                node = node.previousSibling;
            }

            range.setStartBefore(node);

            var felem = Viper.document.createElement('p');
            docFrag   = range.extractContents('p');
            felem.appendChild(docFrag);
            dfx.insertBefore(elem, felem);

            range.setStart(elem.firstChild, 0);
            range.collapse(true);
            return;
        } else if (tag === 'pre') {
            // If the text is in a PRE tag then we need to insert a new line character.
            this.insertTextAtRange(range, "\n");
            return false;
        } else if (tag === 'td' || tag === 'th') {
            // Cannot create a new TD tag so need the move td contents in to a P tag.
            var bookmark = this.viper.createBookmark(range);
            var p        = Viper.document.createElement('P');
            while (parent.firstChild) {
                p.appendChild(parent.firstChild);
            }

            // Add the new P tag as TD's child node.
            parent.appendChild(p);

            // Update tag name and parent element.
            tag    = 'p';
            parent = p;

            // Update range.
            this.viper.selectBookmark(bookmark);
        }//end if

        // If the selection is at the end of text node and has no next sibling
        // then move the range out of its parent node to prevent empty tags being
        // created by range.extractContents().
        if (range.startContainer.nodeType === dfx.TEXT_NODE
            && range.startOffset === range.startContainer.data.length
        ) {
            if (!range.startContainer.nextSibling) {
                var newTextNode = Viper.document.createTextNode('');
                dfx.insertAfter(range.startContainer.parentNode, newTextNode);
                range.setStart(newTextNode, 0);
                range.collapse(true);
            }
        }

        try {
            // Select everything from the current position to the end of the parent.
            range.setEndAfter(parent.lastChild);
        } catch (e) {

        }

        ViperSelection.addRange(range);

        // Need to clone the node so that its attributes are also copied.
        // This may cause ID conflicts.
        var elem    = parent.cloneNode(false);
        var docFrag = range.extractContents(tag);

        elem.appendChild(docFrag);

        // Remove DEL tags before getting the text content.
        var elemClone = elem.cloneNode(true);
        dfx.remove(dfx.getTag('del', elemClone));

        if (dfx.isBlank(dfx.getNodeTextContent(elemClone)) === true) {
            // Do not need this empty element.
            elem = null;
        }

        if (elem === null || (elem.tagName && elem.tagName.toLowerCase() !== 'li' && dfx.isBlockElement(elem) === false)) {
            // If the newly created element is not a block element then
            // create a P tag and make it the elem's parent.
            var newTag = 'p';

            // If element is in a list block then create a new list item instead of a paragraph.
            if (tag === 'li') {
                newTag = tag;
            }

            var pelem = Viper.document.createElement(newTag);
            if (elem !== null) {
                pelem.appendChild(elem);
            } else {
                dfx.setHtml(pelem, '&nbsp;');
            }

            elem = pelem;
            ViperChangeTracker.addChange('createContainer', [elem]);
        } else {
            ViperChangeTracker.removeTrackChanges(elem, true);
            ViperChangeTracker.addChange('splitContainer', [elem]);
        }//end if

        if (this.viper.elementIsEmpty(parent) === true) {
            dfx.setHtml(parent, '&nbsp;');
        }

        // Insert the new element after the current parent.
        dfx.insertAfter(parent, elem);

        range.setStart(elem, 0);
        range.setStart(elem, 0);
        try {
            range.moveStart('character', 1);
            range.moveStart('character', -1);
        } catch (e) {
            // Handle empty node..
        }

        range.collapse(true);
        ViperSelection.addRange(range);

        // Check the parent element contents.
        // If the parent element is now empty and its a block element
        // then add a space to it.
        if (dfx.isBlockElement(parent) === true && dfx.trim(dfx.getHtml(parent)) === '') {
            dfx.setHtml(parent, '&nbsp;');
        }

        this.viper.fireNodesChanged('ViperKeyboardEditorPlugin:enter');

        if (returnFirstBlock === true) {
            return parent;
        }

        return false;
    },

    /**
     * Handles shift + enter.
     *
     * Creates a new BR tag at the position of the caret. If the caret is inside a
     * PRE tag then it will create a new P tag and move the caret inside the P tag.
     *
     * @return {boolean} False when it modified the content to prevent event bubbling.
     */
    handleSoftEnter: function(e)
    {
        if (this._isKeyword() === true) {
            return false;
        }

        if (e) {
            var range     = this.viper.getCurrentRange();
            var startNode = range.getStartNode();
            if (startNode && dfx.isTag(startNode.parentNode, 'pre') === true) {
                // Break out from PRE tag.
                var p = Viper.document.createElement('p');
                dfx.setHtml(p, '&nbsp;');
                this.viper.insertAfter(startNode.parentNode, p);
                this.viper.setCaretAtStart(p);
                return false;
            }
        }

        var node = Viper.document.createElement('br');
        this.viper.insertNodeAtCaret(node);

        if (dfx.isTag(node.previousSibling, 'br') === true) {
            // The previous sibling is also a br tag and to be able to position
            // caret between these two br tags we need to insert a text node in
            // between them.
            this.viper.insertAfter(node.previousSibling, this.viper.createSpaceNode());
        }

        return !this.viper.setCaretAfterNode(node);

    },

    insertTextAtRange: function(range, text)
    {
        var node = range.startContainer;
        // Assuming the range is collapsed already.
        if (node.nodeType === dfx.TEXT_NODE) {
            // Split the text node and insert new line char.
            var newNode = node.splitText(range.startOffset);
            dfx.insertBefore(newNode, document.createTextNode(text));
        } else {
            // Element node..
            node = range.startContainer.childNodes[range.startOffset];
            if (node.nodeType === dfx.TEXT_NODE) {
                // Split the text node and insert new line char.
                var newNode = node.splitText(range.startOffset);
                dfx.insertBefore(newNode, document.createTextNode(text));
            } else {
                newNode = document.createTextNode(text);
                dfx.insertAfter(node, newNode);
            }
        }

        range.setStart(newNode, 0);
        range.collapse(true);
        ViperSelection.addRange(range);

        if (ViperChangeTracker.isTracking() === true) {
            var ctNode = null;
            if (newNode.nextSibling) {
                var sibling = newNode.nextSibling;
                ctNode      = ViperChangeTracker.createCTNode('ins', 'textAdd', newNode);
                dfx.insertBefore(sibling, ctNode);
            } else if (newNode.previousSibling) {
                var sibling = newNode.previousSibling;
                ctNode      = ViperChangeTracker.createCTNode('ins', 'textAdd', newNode);
                dfx.insertAfter(sibling, ctNode);
            } else {
                var parent  = newNode.parentNode;
                ctNode      = ViperChangeTracker.createCTNode('ins', 'textAdd', newNode);
                parent.appendChild(ctNode);
            }

            if (ctNode) {
                ViperChangeTracker.addChange('textAdded', [ctNode]);
            }
        }

    }

};
