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

    createBubble: function(id, title, element, customClass)
    {
        title = title || '&nbsp;';

        if (!element) {
            return false;
        }

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

        var wrapper = document.createElement('div');
        dfx.addClass(wrapper, 'ViperITP-subSectionWrapper');
        bubble.appendChild(wrapper);

        dfx.addClass(element, 'Viper-subSection');
        wrapper.appendChild(element);

        if (customClass) {
            dfx.addClass(bubble, customClass);
        }

        this._bubbles[id] = bubble;
        this.viper.ViperTools.addItem(id, {
            type: 'VTPBubble',
            element: bubble,
            addSubSection: function(id, element) {
                this._subSections[id] = element;

                var wrapper = dfx.getClass('ViperTP-subSections', bubble);
                if (wrapper.length > 0) {
                    wrapper = wrapper[0];
                } else {
                    wrapper = document.createElement('div');
                    dfx.addClass(wrapper, 'ViperTP-subSections');
                    bubble.appendChild(wrapper);
                }

                dfx.setStyle(element, 'display', 'none');
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
                dfx.setStyle(this._subSections[id], 'display', 'block');

                this._activeSubSection = id;

            },
            hideSubSection: function(id) {
                dfx.removeClass(bubble, 'subSectionVisible');
                dfx.setStyle(this._subSections[id], 'display', 'none');
                this._activeSubSection = null;
            },
            _subSections: {},
            _activeSubSection: null
        });

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
        } else {
            this.closeBubble(bubbleid);
        }

    },

    closeBubble: function(bubbleid)
    {
        dfx.removeClass(this.viper.ViperTools.getItem(this._bubbleButtons[bubbleid]).element, 'selected');
        var bubble = this.viper.ViperTools.getItem(bubbleid).element;
        if (bubble.parentNode) {
            document.body.removeChild(bubble);
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

        var bubble = this.viper.ViperTools.getItem(bubbleid).element;
        if (!bubble.parentNode) {
            document.body.appendChild(bubble);
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

    },


  //  /**
  //   * Creates a textbox.
  //   *
  //   * @param {string}   value      The initial value of the textbox.
  //   * @param {string}   label      The label of the textbox.
  //   * @param {function} action     The function to call when the textbox value is updated.
  //   * @param {boolean}  required   True if this field is required.
  //   * @param {boolean}  expandable If true then the textbox will expand when focused.
  //   *
  //   * @return {DOMNode} If label specified the label element else the textbox element.
  //   */
  //  createTextbox: function(value, label, action, required, expandable)
  //  {
  //      var textBox = document.createElement('input');
  //      dfx.addClass(textBox, 'ViperITP-input');
  //      textBox.type  = 'text';
  //      textBox.size  = 10;
  //      textBox.value = value;
  //
  //      var self  = this;
  //
  //      var t = null;
  //      dfx.addEvent(textBox, 'focus', function(e) {
  //          self.viper.highlightSelection();
  //          dfx.addClass(labelElem, 'active');
  //      });
  //
  //      dfx.addEvent(textBox, 'blur', function(e) {
  //          dfx.removeClass(labelElem, 'active');
  //          clearTimeout(t);
  //      });
  //
  //      dfx.addEvent(textBox, 'keyup', function(e) {
  //          if (e.which === 13) {
  //              self.viper.focus();
  //              action.call(textBox, textBox.value);
  //              return;
  //          }
  //
  //          dfx.addClass(labelElem, 'active');
  //      });
  //
  //      if (label) {
  //          var labelElem = document.createElement('label');
  //          dfx.addClass(labelElem, 'ViperITP-label');
  //          var span = document.createElement('span');
  //          dfx.addClass(span, 'ViperITP-labelText');
  //          dfx.setHtml(span, label);
  //
  //          document.body.appendChild(span);
  //          var width = dfx.getElementWidth(span);
  //          dfx.setStyle(labelElem, 'padding-left', width + 'px');
  //          labelElem.appendChild(span);
  //          labelElem.appendChild(textBox);
  //
  //          if (required === true) {
  //              dfx.addClass(labelElem, 'required');
  //          }
  //
  //          if (expandable === true) {
  //              dfx.addClass(labelElem, 'expandable');
  //          }
  //
  //          return labelElem;
  //      }
  //
  //      return textBox;
  //
  //  },

    /**
     * Creates a sub section element.
     *
     * @param {DOMElement} contentElement The content element.
     * @param {boolean}    active         True if the subsection is active.
     * @param {string}     customClass    Custom class to apply to the group.
     *
     * @return {DOMElement} The sub section element.
     */
    createSubSection: function(contentElement, active, customClass)
    {
        var subSection = this.viper.ViperTools.createSubSection(contentElement, active, customClass);
        return subSection;

    },

    /**
     * Creates a new sub section row and returns the new DOMElement.
     *
     * @return {DOMElement} The sub section row element.
     */
    createSubSectionRow: function()
    {
        var elem = document.createElement('div');
        dfx.addClass(elem, 'subSectionRow');
        return elem;

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
        range = range || this.viper.getCurrentRange();

        this.viper.fireCallbacks('ViperToolbarPlugin:updateToolbar', {range: range});

    }

};
