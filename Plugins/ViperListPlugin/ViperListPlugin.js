/**
 * JS Class for the Viper List Plugin.
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

function ViperListPlugin(viper)
{
    this.viper = viper;
    this.toolbarPlugin = null;

}

ViperListPlugin.prototype = {

    start: function()
    {
        var self = this;
        this.toolbarPlugin = this.viper.ViperPluginManager.getPlugin('ViperToolbarPlugin');
        this.toolbarPlugin.addButton('List', 'list-ordered', 'Insert/Remove Ordered List', function () {
            self.oderedList();
        });
        this.toolbarPlugin.addButton('List', 'list-unordered', 'Insert/Remove Un-ordered List', function () {
            self.unoderedList();
        });

        // Change Tracker.
        ViperChangeTracker.addChangeType('makeList', 'Formatted', 'insert');
        ViperChangeTracker.addChangeType('removedList-ol', 'Formatted', 'format');
        ViperChangeTracker.addChangeType('removedList-ul', 'Formatted', 'format');
        ViperChangeTracker.addChangeType('makeList-change', 'Formatted', 'format');
        ViperChangeTracker.addChangeType('addedListItem', 'Inserted', 'insert');
        ViperChangeTracker.addChangeType('breakListUP', 'Formatted', 'format');
        ViperChangeTracker.addChangeType('breakListUPDown', 'Formatted', 'format');
        ViperChangeTracker.addChangeType('breakListDown', 'Formatted', 'format');

        ViperChangeTracker.setDescriptionCallback('makeList', function(node) {
            var listType = 'ordered';
            if (dfx.isTag(node, 'ul') === true) {
                listType = 'un-ordered';
            }

            return 'Changed to ' + listType + ' list';
        });
        ViperChangeTracker.setApproveCallback('makeList', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('makeList', function(clone, node) {
            var children = [];
            dfx.foreach(node.childNodes, function(i) {
                children.push(node.childNodes[i]);
            });

            while (child = children.shift()) {
                self.removeListItem(child, true);
            }

            dfx.remove(node);
        });

        ViperChangeTracker.setDescriptionCallback('removedList-ol', function(node) {
            return 'Removed from ordered list';
        });
        ViperChangeTracker.setApproveCallback('removedList-ol', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('removedList-ol', function(clone, node) {
            // Just create a new list.
            var list = document.createElement('ol');
            dfx.insertBefore(node, list);
            list.appendChild(self._createListItem(node));
        });

        ViperChangeTracker.setDescriptionCallback('removedList-ul', function(node) {
            return 'Removed from un-ordered list';
        });
        ViperChangeTracker.setApproveCallback('removedList-ul', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('removedList-ul', function(clone, node) {
            // Just create a new list.
            var list = document.createElement('ul');
            dfx.insertBefore(node, list);
            list.appendChild(self._createListItem(node));
        });

        ViperChangeTracker.setDescriptionCallback('makeList-change', function(node) {
            var listType = 'unordered';
            if (dfx.isTag(node, 'ol') === true) {
                listType = 'ordered';
            }

            return 'Changed to ' + listType + ' list';
        });
        ViperChangeTracker.setApproveCallback('makeList-change', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('makeList-change', function(clone, node) {
            var newTag = 'ol'
            if (dfx.isTag(node, 'ol') === true) {
                newTag = 'ul';
            }

            var newList = document.createElement(newTag);
            while (node.firstChild) {
                newList.appendChild(node.firstChild);
            }

            dfx.insertBefore(node, newList);
            dfx.remove(node);
        });

        // List break.
        ViperChangeTracker.setDescriptionCallback('breakListUP', function(node) {
            return 'Removed from list';
        });
        ViperChangeTracker.setApproveCallback('breakListUP', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('breakListUP', function(clone, node) {
            var prevList = node.previousSibling;
            if (dfx.isTag(prevList, 'ul') === true || dfx.isTag(prevList, 'ol') === true) {
                if (self.isListNode(node) === true) {
                    // Import children.
                    while (node.firstChild) {
                        prevList.appendChild(node.firstChild);
                    }

                    dfx.remove(node);
                } else {
                    var li = node;
                    if (dfx.isTag(li, 'li') === false) {
                        li = self._createListItem(node)
                    }

                    prevList.appendChild(li);
                }
            }
        });

        // List break.
        ViperChangeTracker.setDescriptionCallback('breakListUPDown', function(node) {
            return 'Removed from list';
        });
        ViperChangeTracker.setApproveCallback('breakListUPDown', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('breakListUPDown', function(clone, node) {
            var prevList = node.previousSibling;
            var nextList = node.nextSibling;
            if (dfx.isTag(prevList, 'ul') === true || dfx.isTag(prevList, 'ol') === true) {
                if (self.isListNode(node) === true) {
                    // Import children.
                    while (node.firstChild) {
                        prevList.appendChild(node.firstChild);
                    }

                    dfx.remove(node);
                } else {
                    var li = node;
                    if (dfx.isTag(li, 'li') === false) {
                        li = self._createListItem(node)
                    }

                    prevList.appendChild(li);
                }

                if (nextList) {
                    // Join lists...
                    while (nextList.firstChild) {
                        var li = nextList.firstChild;
                        if (dfx.isTag(nextList.firstChild, 'li') === false) {
                            li = self._createListItem(nextList.firstChild);
                        }

                        prevList.appendChild(li);
                    }

                    dfx.remove(nextList);
                }
            } else if (dfx.isTag(nextList, 'ul') === true || dfx.isTag(nextList, 'ol') === true) {
                if (self.isListNode(node) === true) {
                    // Import children.
                    if (nextList.firstChild) {
                        dfx.insertBefore(nextList.firstChild, node.childNodes);
                    } else {
                        while (node.firstChild) {
                            nextList.appendChild(node.firstChild);
                        }
                    }

                    dfx.remove(node);
                } else {
                    var li = node;
                    if (dfx.isTag(li, 'li') === false) {
                        li = self._createListItem(node)
                    }

                    // Join to this list..
                    if (nextList.firstChild) {
                        dfx.insertBefore(nextList.firstChild, li);
                    } else {
                        nextList.appendChild(li);
                    }
                }//end if
            }//end if
        });

         // List break.
        ViperChangeTracker.setDescriptionCallback('breakListDown', function(node) {
            return 'Removed from list';
        });
        ViperChangeTracker.setApproveCallback('breakListDown', function(clone, node) {
            ViperChangeTracker.removeTrackChanges(node);
        });
        ViperChangeTracker.setRejectCallback('breakListDown', function(clone, node) {
            var nextList = node.nextSibling;
            if (dfx.isTag(nextList, 'ul') === true || dfx.isTag(nextList, 'ol') === true) {
                if (self.isListNode(node) === true) {
                    // Import children.
                    if (nextList.firstChild) {
                        dfx.insertBefore(nextList.firstChild, node.childNodes);
                    } else {
                        while (node.firstChild) {
                            nextList.appendChild(node.firstChild);
                        }
                    }

                    dfx.remove(node);
                } else {
                    var li = node;
                    if (dfx.isTag(li, 'li') === false) {
                        li = self._createListItem(node)
                    }

                    if (nextList.firstChild) {
                        dfx.insertBefore(nextList.firstChild, li);
                    } else {
                        nextList.appendChild(li);
                    }
                }//end if
            }//end if
        });

    },

    unoderedList: function()
    {
        this._changeType = 'makeList';
        this.makeList(false);
        this.viper.fireNodesChanged('ViperListPlugin:unordered');
        this.viper.element.focus();

    },

    oderedList: function()
    {
        this._changeType = 'makeList';
        this.makeList(true);
        this.viper.fireNodesChanged('ViperListPlugin:ordered');
        this.viper.element.focus();

    },

    removeListItem: function(li, sameList)
    {
        if (!li || !li.parentNode) {
            return false;
        }

        var list = this._getListElement(li);
        if (!list) {
            return;
        }

        var nextLevelList = this._getListElement(list);
        if (!nextLevelList) {
            var newElem = document.createElement('p');
            while (li.firstChild) {
                newElem.appendChild(li.firstChild);
            }
        }

        var changeType = null;
        // Check if the list item we are removing is at the end of the list or
        // not. If not then we need to break the list in to two parts with the
        // removed list item (as P tag) between those lists.
        if (li.nextSibling) {
            // Create a new list for rest of the list items.
            var clone = list.cloneNode(false);
            for (var node = li.nextSibling; node; node = li.nextSibling) {
                clone.appendChild(node);
            }

            dfx.insertAfter(list, clone);

            if (li.previousSibling) {
                changeType = 'breakListUPDown';
            } else {
                changeType = 'breakListDown';
            }
        } else {
            changeType = 'breakListUP';
        }

        dfx.remove(li);

        if (!nextLevelList) {
            dfx.insertAfter(list, newElem);
        } else {
            var newElem = document.createElement('br');
            dfx.insertAfter(list, newElem);
            dfx.insertAfter(newElem, li.childNodes);
        }

        if (dfx.getNodeTextContent(list) === '') {
            dfx.remove(list);
        }

        if (sameList !== true) {
            this._changeType = changeType;
            ViperChangeTracker.addChange(changeType, [newElem]);
        }

        return newElem;

    },

    makeList: function(ordered, force)
    {
        var tag = 'ul';
        if (ordered === true) {
            tag = 'ol';
        }

        var range    = this.viper.getCurrentRange().cloneRange();
        var bookmark = this.viper.createBookmark(range);

        if (bookmark.start.parentNode === bookmark.end.parentNode) {
            // The range is collapsed or is inside the same parent/element.
            var li = this._getListItem(range.startContainer);
            if (li !== null) {
                var br = this._getLineBreak(bookmark.start);
                if (br) {
                    var tmpDiv = document.createElement('div');
                    dfx.insertBefore(br, tmpDiv);
                    var node = null;
                    while (node = br.nextSibling) {
                        if (node.nodeType === dfx.ELEMENT_NODE && node.tagName.toLowerCase() === 'br') {
                            tmpDiv = document.createElement('div');
                            dfx.insertBefore(node, tmpDiv);
                            dfx.remove(br);
                            br = node;
                            continue;
                        }

                        tmpDiv.appendChild(node);
                    }

                    if (br.parentNode) {
                        dfx.remove(br);
                    }

                    this.viper.selectBookmark(bookmark);
                    this.makeList(ordered, true);
                    return;
                }//end if
            }//end if

            if (li === null || force === true) {
                // Create a new list.
                var list = null;
                var elem = this._getBlockParent(range.startContainer);

                if (elem === null) {
                    elem = [range.startContainer];
                } else {
                    elem = [elem];
                }

                var removeInsAfter = false;
                var insertAfter    = elem[0].previousSibling;
                if (!insertAfter) {
                    insertAfter = document.createTextNode('');
                    dfx.insertBefore(elem[0], insertAfter);
                    removeInsAfter = true;
                }

                list = this._makeList(tag, elem);
                dfx.insertAfter(insertAfter, list);
                if (removeInsAfter === true) {
                }

                this.viper.selectBookmark(bookmark);
            } else {
                // Remove item from its list.
                var listElement = this._getListElement(li);
                var convert     = (listElement && listElement.tagName.toLowerCase() !== tag);

                var newElem = this.removeListItem(li);

                // Select bookmark.
                this.viper.selectBookmark(bookmark);

                if (convert === true) {
                    // Need to create a new list with the specified tag.
                    if (this._changeType === 'makeList') {
                        this._changeType += '-change';
                    }

                    this.makeList(ordered);
                }
            }//end if
        } else {
            // Range is not collapsed.
            var elements   = dfx.getElementsBetween(bookmark.start, bookmark.end);
            var comParents = this._getCommonParents(elements);
            if (!comParents) {
                return false;
            }

            var isWholeList = this._isWholeList(comParents);

            // Determine what to do with the selected elements.
            if (dfx.isTag(comParents[0], 'li') === true) {
                // If the array contains only list items and they are all the same
                // list type then remove them from their lists.
                var sameType = true;
                dfx.foreach(comParents, function(i) {
                    if (dfx.isTag(comParents[i], 'li') !== true
                        || dfx.isTag(comParents[i].parentNode, tag) !== true) {
                        sameType = false;
                        // Break.
                        return false;
                    }
                });

                if (sameType === true) {
                    var self = this;
                    dfx.foreach(comParents, function(i) {
                        var newElem = self.removeListItem(comParents[i], isWholeList);
                        ViperChangeTracker.addChange('removedList-' + tag, [newElem]);
                    });

                    // Select the range and update caret.
                    this.viper.selectBookmark(bookmark);
                    return;
                } else {
                    // If the specified list type is same as the first selected items list type
                    // then join the rest of the elements to that list.
                    if (dfx.isTag(comParents[0].parentNode, tag) === true) {
                        var firstItem = comParents.shift();
                        this._joinToList(firstItem.parentNode, comParents, firstItem);
                        // Select the range and update caret.
                        this.viper.selectBookmark(bookmark);
                        return;
                    } else {
                        var self = this;
                        // Remove the list items and then create a new list.
                        dfx.foreach(comParents, function(i) {
                            self.removeListItem(comParents[i], isWholeList);
                        });

                        // Select the range and update caret.
                        this.viper.selectBookmark(bookmark);

                        // Create the new list.
                        if (this._changeType === 'makeList') {
                            this._changeType += '-change'
                        }

                        return this.makeList(ordered);
                    }//end if
                }//end if
            }//end if

            // Get insertion point of the new list.
            var removeInsAfter = false;
            var insertAfter    = comParents[0].previousSibling;
            if (!insertAfter) {
                insertAfter = document.createTextNode('');
                dfx.insertBefore(comParents[0], insertAfter);
                removeInsAfter = true;
            }

            var list = this._makeList(tag, comParents);
            dfx.insertAfter(insertAfter, list);
            if (removeInsAfter === true) {
                dfx.remove(insertAfter);
            }

            this.viper.selectBookmark(bookmark);
        }//end if

    },

    _joinToList: function(listElem, elements, refNode)
    {
        var self = this;
        dfx.foreach(elements, function(i) {
            var elem = elements[i];
            if (elem.parentNode !== listElem) {
                // If elem is not a list item then create a new list item.
                if (dfx.isTag(elem, 'li') === false) {
                    elem = self._createListItem(elem);
                }

                if (elem) {
                    if (refNode) {
                        dfx.insertAfter(refNode, elem);
                        refNode = elem;
                    } else {
                        listElem.appendChild(elem);
                    }
                }
            }
        });

    },

    _getLineBreak: function(ref)
    {
        while (ref = ref.previousSibling) {
            if (ref.nodeType === dfx.ELEMENT_NODE && ref.tagName.toLowerCase() === 'br') {
                return ref;
            }
        }

        return null;

    },

    _getBlockParent: function(element, tag)
    {
        while (element && element !== this.viper.element) {
            if (dfx.isBlockElement(element) === true) {
                if (!tag || element.tagName.toLowerCase() === tag) {
                    return element;
                }
            }

            element = element.parentNode;
        }

        return null;

    },

    _getCommonParents: function(elems)
    {
        // Clone array since it will be modified.
        elems = elems.concat([]);

        var parents = [];

        var eLen = elems.length;
        while (eLen > 0) {
            var elem = elems.shift();
            if (dfx.isBlockElement(elem) === true) {
                if (elem.tagName.toLowerCase() === 'ol' || elem.tagName.toLowerCase() === 'ul') {
                    // Add this list items as parents.
                    for (var listChild = elem.firstChild; listChild; listChild = listChild.nextSibling) {
                        parents.push(listChild);
                    }
                } else {
                    parents.push(elem);
                }
            } else {
                while (elem) {
                    elem = elem.parentNode;
                    if (elem) {
                        if (elem === this.viper.element) {
                            break;
                        } else if (dfx.isBlockElement(elem) === true) {
                            if (parents.inArray(elem) === false) {
                                parents.push(elem);
                            }

                            break;
                        }
                    }
                }
            }//end if

            eLen = elems.length;
        }//end while

        return parents;

    },

    _makeList: function(tag, elements)
    {
        if (!elements) {
            return;
        }

        tag     = tag || 'ul';
        var eln = elements.length;

        if (eln <= 0) {
            return;
        }

        var list = document.createElement(tag);

        if (ViperChangeTracker.isTracking() === true) {
            ViperChangeTracker.addChange(this._changeType, [list]);
        }

        if (eln === 1) {
            // Check for BR tags to create list items out of those.
            // Note that the selection is ignored in this case. All BR tags
            // inside this single element will be used.
            var listItems = [];
            var listLen   = listItems.length;

            // First child might be null but we may have listItems to process.
            while (elements[0].firstChild || listLen > 0) {
                var child = elements[0].firstChild;
                if (child && dfx.isTag(child, 'br') === false) {
                    listItems.push(child);
                } else if (listItems.length > 0) {
                    var listItem = this._createListItem(listItems.shift());
                    list.appendChild(listItem);
                    while (listElem = listItems.shift()) {
                        listItem.appendChild(listElem);
                    }
                }

                if (child) {
                    dfx.remove(child);
                }

                listLen = listItems.length;
            }

            dfx.remove(elements[0]);
        } else {
            for (var i = 0; i < eln; i++) {
                var listItem = this._createListItem(elements[i]);
                if (listItem !== null) {
                    list.appendChild(listItem);
                }
            }
        }//end if

        return list;

    },

    _createListItem: function(element)
    {
        if (!element) {
            return null;
        }

        var li = document.createElement('li');

        // If the element is a block element then insert its children.
        if (dfx.isBlockElement(element) === true) {
            if (element.childNodes && element.childNodes.length > 0) {
                while (element.firstChild) {
                    if (element.firstChild.nodeType === dfx.TEXT_NODE) {
                        if (dfx.trim(element.firstChild.data).length <= 0) {
                            // Don't need empty text nodes.
                            dfx.remove(element.firstChild);
                            continue;
                        }
                    }

                    li.appendChild(element.firstChild);
                }
            }

            // Remove the empty element.
            dfx.remove(element);

            // If the list element is still empty then dont return it.
            if (li.childNodes.length === 0) {
                return null;
            }
        } else {
            li.appendChild(element);
        }//end if

        return li;

    },

    _getList: function(element)
    {
        return this._isListElement(element, null, true);

    },

    _isListElement: function(element, type, returnNode)
    {
        while (element && element !== this.viper.element) {
            if (element.nodeType === dfx.ELEMENT_NODE) {
                var tagName = element.tagName.toLowerCase();
                if (type) {
                    if (tagName === type) {
                        if (returnNode === true) {
                            return element;
                        }

                        return true;
                    }
                } else if (tagName === 'ul' || tagName === 'ol' || tagName === 'li') {
                    if (returnNode === true) {
                        return element;
                    }

                    return true;
                }
            }

            element = element.parentNode;
        }//end while

        return false;

    },

    isListNode: function(node)
    {
        if (dfx.isTag(node, 'ul') === true || dfx.isTag(node, 'ol') === true) {
            return true;
        }

        return false;

    },

    /**
     * Given an element it will return its list item (li) node.
     */
    _getListItem: function(element)
    {
        while (element && element !== this.viper.element) {
            if (element.tagName && element.tagName.toLowerCase() === 'li') {
                return element;
            }

            element = element.parentNode;
        }

        return null;

    },

    _getListElement: function(element)
    {
        element = element.parentNode;
        while (element && element !== this.viper.element) {
            if (element.tagName) {
                var tag = element.tagName.toLowerCase();
                if (tag === 'ol' || tag === 'ul') {
                    return element;
                }
            }

            element = element.parentNode;
        }

        return null;

    },

    _isWholeList: function(elems)
    {
        var sameParent = false;
        // If only 1 item is selected then it is under same parent.
        // If first item and last item are belong to the same list element
        // then they are under same parent.
        var parentList = null;
        if (elems.length > 1) {
            var first = elems[0];
            var last  = elems[(elems.length - 1)];

            var firstParent = first.parentNode;
            var lastParent  = last.parentNode;

            if (firstParent === lastParent) {
                parentList = firstParent;
                sameParent = true;
            }
        } else {
            sameParent = true;
        }

        if (sameParent === true) {
            var count = 0;
            var child = null;
            var last  = null;
            for (child = parentList.firstChild; child; child = child.nextSibling) {
                if (dfx.isTag(child, 'li') === true) {
                    if (count === 0 && child !== elems[0]) {
                        // Not the first LI of the list.
                        return false;
                    }

                    last = child;
                    count++;
                }
            }

            if (last === elems[(elems.length - 1)]) {
                return true;
            }
        }

        return false;

    },

    /*
        This method will be called from ViperKeyboardEditPlugin.
    */
    handleEnter: function(li)
    {
        var content = dfx.getNodeTextContent(li);
        if (dfx.trim(content).length === 0 || dfx.getHtml(li) === '&nbsp;') {
            // End the list.
            var parents = dfx.getParents(li, 'ul,ol');
            if (parents.length > 0) {
                var listEl = parents[0];

                if (parents.length > 1) {
                    // If this is a nested list then move this item to one level up.
                    // List element should be inside an li tag.
                    var parentLi = parents[(parents.length - 1)].parentNode;
                    while (parentLi && dfx.isTag(parentLi, 'li') === false) {
                        parentLi = parentLi.parentNode;
                    }

                    if (parentLi) {
                        dfx.insertAfter(parentLi, li);
                        var range = this.viper.getCurrentRange();
                        range.setStart(li.firstChild, 0);
                        range.collapse(true);
                        return false;
                    }
                }

                // Insert a new paragrap after the list.
                var p = document.createElement('p');
                dfx.setHtml(p, '&nbsp;');

                // Clone the list elem.
                var listClone = listEl.cloneNode(false);
                dfx.removeAttr(listClone, 'id');

                // Move all elements after current li to the new one.
                var c  = 0;
                var el = li.nextSibling;
                while (el) {
                    var elem = el;
                    el       = el.nextSibling;
                    c++;
                    dfx.remove(elem);
                    listClone.appendChild(elem);
                }

                dfx.remove(li);

                dfx.insertAfter(listEl, p);

                if (c > 0) {
                    dfx.insertAfter(p, listClone);
                }

                var range = this.viper.getCurrentRange();
                range.setStart(p.firstChild, 0);
                range.collapse(true);

                return false;
            }//end if
        } else if (this._isKeyword() === true) {
            // The content is a keyword insert empty list element after this one.
            var newLi = li.cloneNode(false);
            dfx.setHtml(newLi, '&nbsp;');
            dfx.insertAfter(li, newLi);
            var range = this.viper.getCurrentRange();
            range.setStart(newLi.firstChild, 0);
            range.collapse(true);
            return false;
        }//end if

        return true;

    },

    _isKeyword: function()
    {
        var keywordPlugin = this.viper.ViperPluginManager.getPlugin('ViperKeywordPlugin');
        if (keywordPlugin) {
            var range         = this.viper.getCurrentRange();
            if (keywordPlugin._isKeyword(range.startContainer) === false && keywordPlugin._isKeyword(range.startContainer) === false) {
                return false;
            }
        }

        return true;

    }

};
