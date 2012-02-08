/**
 * JS Class for the Viper Toolbar Plugin.
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

function ViperToolbarPlugin(viper)
{
    this.viper    = viper;
    this._toolbar = null;

    this._activeBubble  = null;
    this._bubbles       = {};
    this._bubbleButtons = {};

    this.createToolbar();

    var self = this;
    this.viper.registerCallback('Viper:selectionChanged', 'ViperToolbarPlugin', function(range) {
        if (self.viper.rangeInViperBounds(range) === false) {
            return;
        }

        self._updateToolbar(range);
    });

    this.viper.registerCallback('Viper:editableElementChanged', 'ViperToolbarPlugin', function() {
        self._updateToolbar();
    });

}

ViperToolbarPlugin.prototype = {
    init: function()
    {
        Viper.document.body.appendChild(this._toolbar);

    },

    setSettings: function(settings)
    {
        if (!settings) {
            return;
        }

        if (settings.parent) {
            var parent = settings.parent;
            if (typeof parent === 'string') {
                parent = dfx.getId(settings.parent);
            }

            this.setParentElement(parent);
        }

    },

    createToolbar: function()
    {
        var elem = document.createElement('div');
        dfx.addClass(elem, 'ViperTP-bar themeDark Viper-scalable');
        this._toolbar = elem;

        dfx.addEvent(elem, 'mousedown', function(e) {
            dfx.preventDefault(e);
            return false;
        });

        if (navigator.userAgent.match(/iPad/i) !== null) {
            dfx.addClass(this._toolbar, 'device-ipad');
            dfx.setStyle(this._toolbar, 'display', 'none');
        }

    },

    setParentElement: function(parent)
    {
        dfx.setStyle(this._toolbar, 'position', 'absolute');
        dfx.setStyle(this._toolbar, 'top', '0px');
        parent.appendChild(this._toolbar);

    },

    /**
     * Adds the specified button or button group element to the tools panel.
     *
     * @param {DOMNode} button The button or the button group element.
     *
     * @return void
     */
    addButton: function(button)
    {
        this._toolbar.appendChild(button);

    },

    createBubble: function(id, title, subSectionElement, toolsElement, openCallback, closeCallback, customClass)
    {
        title = title || '&nbsp;';

        var bubble = document.createElement('div');
        dfx.addClass(bubble, 'ViperITP themeDark visible forTopbar');
        dfx.setHtml(bubble, '<div class="ViperITP-header">' + title + '</div>');

        dfx.addEvent(bubble, 'mousedown', function(e) {
            var target = dfx.getMouseEventTarget(e);
            if (dfx.isTag(target, 'input') !== true) {
                dfx.preventDefault(e);
                return false;
            }
        });

        if (toolsElement) {
            var wrapper = document.createElement('div');
            dfx.addClass(wrapper, 'ViperITP-tools');
            bubble.appendChild(wrapper);
            wrapper.appendChild(toolsElement);
        }

        if (customClass) {
            dfx.addClass(bubble, customClass);
        }

        this._bubbles[id] = bubble;
        var bubbleObj = {
            type: 'VTPBubble',
            element: bubble,
            addSubSection: function(id, element) {
                this._subSections[id] = element;

                var wrapper = dfx.getClass('ViperITP-subSectionWrapper', bubble);
                if (wrapper.length > 0) {
                    wrapper = wrapper[0];
                } else {
                    wrapper = document.createElement('div');
                    dfx.addClass(wrapper, 'ViperITP-subSectionWrapper');
                    bubble.appendChild(wrapper);
                }

                dfx.addClass(element, 'Viper-subSection');
                wrapper.appendChild(element);

                return element;
            },
            showSubSection: function(id) {
                if (this._activeSubSection) {
                    if (this._activeSubSection !== id) {
                        this.hideSubSection(this._activeSubSection);
                    } else {
                        return;
                    }
                }

                dfx.addClass(bubble, 'subSectionVisible');
                dfx.addClass(this._subSections[id], 'active');

                this._activeSubSection = id;

            },
            hideSubSection: function(id) {
                dfx.removeClass(bubble, 'subSectionVisible');
                dfx.removeClass(this._subSections[id], 'active');
                this._activeSubSection = null;
            },
            _subSections: {},
            _activeSubSection: null,
            _openCallback: openCallback,
            _closeCallback: closeCallback
        };

        if (subSectionElement) {
            bubbleObj.addSubSection(id + 'SubSection', subSectionElement);
            if (!toolsElement) {
                bubbleObj.showSubSection(id + 'SubSection');
            }
        }

        this.viper.ViperTools.addItem(id, bubbleObj);

        return bubble;

    },

    getBubble: function(id)
    {
        return this.viper.ViperTools.getItem(id);

    },

    setBubbleButton: function(bubbleid, buttonid)
    {
        if (!this._bubbles[bubbleid]) {
            // Throw exception not a valid bubble id.
            return false;
        }

        var bubble = this.getBubble(bubbleid);
        var button = this.viper.ViperTools.getItem(buttonid).element;
        var self   = this;

        this._bubbleButtons[bubbleid] = buttonid;

        dfx.removeEvent(button, 'mousedown');
        dfx.addEvent(button, 'mousedown', function(e) {
            self.toggleBubble(bubbleid);
            dfx.preventDefault(e);
        });

    },

    toggleBubble: function(bubbleid)
    {
        if (!this._activeBubble || this._activeBubble !== bubbleid) {
            this.showBubble(bubbleid);
            return true;
        } else {
            this.closeBubble(bubbleid);
            return false;
        }

    },

    closeBubble: function(bubbleid)
    {
        dfx.removeClass(this.viper.ViperTools.getItem(this._bubbleButtons[bubbleid]).element, 'selected');
        var bubble     = this.viper.ViperTools.getItem(bubbleid);
        var bubbleElem = bubble.element;
        if (bubbleElem.parentNode) {
            document.body.removeChild(bubbleElem);
        }

        if (bubble._closeCallback) {
            bubble._closeCallback.call(this);
        }

        this._activeBubble = null;

    },

    showBubble: function(bubbleid)
    {
        if (this._activeBubble) {
            if (this._activeBubble === bubbleid) {
                // Already showing.
                return;
            }

            // Hide the current active bubble.
            this.closeBubble(this._activeBubble);
        }

        dfx.addClass(this.viper.ViperTools.getItem(this._bubbleButtons[bubbleid]).element, 'selected');

        var bubble     = this.viper.ViperTools.getItem(bubbleid);
        var bubbleElem = bubble.element;

        if (bubble._openCallback) {
            bubble._openCallback.call(this);
        }

        if (!bubbleElem.parentNode) {
            document.body.appendChild(bubbleElem);
        }

        this.positionBubble(bubbleid);

        this._activeBubble = bubbleid;

    },

    positionBubble: function(bubbleid)
    {
        bubbleid = bubbleid || this._activeBubble;
        if (!bubbleid) {
            return;
        }

        var bubble     = this.viper.ViperTools.getItem(bubbleid).element;
        var button     = this.viper.ViperTools.getItem(this._bubbleButtons[bubbleid]).element;
        var toolsWidth = dfx.getElementWidth(bubble);

        var scrollCoords = dfx.getScrollCoords();
        var windowDim    = dfx.getWindowDimensions();
        var elemDim      = dfx.getBoundingRectangle(button);

        var left = (elemDim.x1 + ((elemDim.x2 - elemDim.x1) / 2) - (toolsWidth / 2) - scrollCoords.x);
        var top  = (elemDim.y2 + 8 - scrollCoords.y);

        if ((left + toolsWidth) >= windowDim.width) {
            left -= (toolsWidth / 2) - 40;
            dfx.addClass(bubble, 'orientationLeft');
        } else {
            dfx.removeClass(bubble, 'orientationLeft');
        }

        dfx.setStyle(bubble, 'left', left + 'px');
        dfx.setStyle(bubble, 'top', top + 'px');
        dfx.setStyle(bubble, 'width', toolsWidth + 'px');

    },

    remove: function()
    {
        dfx.remove(this._toolbar);

    },

    isPluginElement: function(element)
    {
        if (element !== this._toolbar && dfx.isChildOf(element, this._toolbar) === false) {
            return false;
        }

        return true;

    },

    _updateToolbar: function(range)
    {
        if (this._activeBubble) {
            this.closeBubble(this._activeBubble);
        }

        range = range || this.viper.getCurrentRange();

        this.viper.fireCallbacks('ViperToolbarPlugin:updateToolbar', {range: range});

    }

};
