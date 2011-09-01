/**
 * A simple implementation of XPath for converting between a path and a node
 * within the Viper.document.
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

var XPath = {


    /**
     * Returns a unique path for the given node.
     *
     * @param DOMNode node The node to retrieve the path for.
     *
     * @return string the path.
     */
    getPath: function(node)
    {
        var path, step;

        path = '/node()[' + this.getPosition(node, false) + ']';
        node = node.parentNode;

        while (node.parentNode) {
            step = '/';

            switch (node.nodeType) {
                case dfx.ELEMENT_NODE:
                    step += node.nodeName.toLowerCase() + '[' + this.getPosition(node, true) + ']';
                break;

                default:
                    // Ignore.
                break;
            }

            path = step + path;
            node = node.parentNode;
        }

        return path;

    },

    /**
     * Returns the position used to identify a node within its parent.
     *
     * Positions are based on the occurence that a node of an arbitrary type
     * appears in the parent. For example if it is the second div in the parent,
     * this its position is 2.
     *
     * @param DOMNode node      The node to get the position for.
     * @param boolean matchType If true the tagName will be matched with the node
     *                          otherwise it will be treated generically and its
     *                          offset within the parent will be returned.
     */
    getPosition: function(node, matchType)
    {
        var childNodes = node.parentNode.childNodes;
        var pos        = 1;

        var cln = childNodes.length;
        for (var i = 0; i < cln; i++) {
            if (childNodes[i] === node) {
                break;
            }

            if (!matchType) {
                pos++;
                continue;
            }

            switch (node.nodeType) {
                case dfx.ELEMENT_NODE:
                    if (childNodes[i].nodeType === dfx.ELEMENT_NODE && childNodes[i].nodeName === node.nodeName) {
                        pos++;
                    }
                break;

                case dfx.TEXT_NODE:
                    if (childNodes[i].nodeType === dfx.TEXT_NODE) {
                        pos++;
                    }
                break;

                default:
                    // Ignore.
                break;
            }
        }//end for

        return pos;

    },

    /**
     * Returns the node within the document for the specified path.
     *
     * @param string path The path for the wanted node.
     *
     * @return DOMNode
     */
    getNode: function(path)
    {
        if (Viper.document.evaluate) {
            var node = Viper.document.evaluate(path, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null);
            return node.singleNodeValue;
        } else {
            return this._getNodeFromPath(path);
        }

    },

    /**
     * Provides an domtree traversal method for retrieving the node for the
     * specified path.
     *
     * @param string path The path for the wanted node.
     *
     * @return DOMNode
     */
    _getNodeFromPath: function(path)
    {
        var paths  = path.split('/');
        var parent = document;
        var pln    = paths.length;
        for (var i = 0; i < pln; i++) {
            if (dfx.trim(paths[i]) === '') {
                continue;
            }

            parent = this._getNodeFromPathSegment(parent, paths[i]);
        }

        return parent;

    },

    /**
     * Returns the node for the specified path segment under the specified parent.
     *
     * @param DOMElement parent The parent to retreive the child for.
     * @param string     path   The path segment that identifies the child.
     *
     * @return DOMNode
     */
    _getNodeFromPathSegment: function(parent, path)
    {
        var pos = path.match(/\[(\d+)\]/);
        pos     = parseInt(pos[1]);
        if (!pos) {
            pos = 1;
        }

        var brPos = path.indexOf('[') || path.length;
        var type  = path.substr(0, brPos);

        var node, found = 1;
        var cln         = parent.childNodes.length;
        for (var i = 0; i < cln; i++) {
            node = parent.childNodes[i];

            if (type === 'node()') {
                if (found === pos) {
                    return node;
                }

                found++;
            } else if (node.tagName && type === node.tagName.toLowerCase()) {
                if (found === pos) {
                    return node;
                }

                found++;
            }
        }

        throw Error('XPath: node could not be found');

    },

    /**
     * Returns the node previous to the node at the specified path.
     *
     * If the last path segment of the specified path contains a node type, the
     * next previous node of that type will be returned.
     *
     * @param string path The path to the node next to the wanted node.
     *
     * @return DOMNode
     */
    getPreviousNode: function(path)
    {
        var paths    = path.split('/');
        var lastStep = paths.pop();
        var pos      = lastStep.match(/\[(\d+)\]/)[1];
        lastStep     = lastStep.replace(/\[(\d+)\]/, '[' + (parseInt(pos) - 1) + ']');

        path = paths.join('/') + '/' + lastStep;

        return this.getNode(path);

    }

};
