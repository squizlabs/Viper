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
function ViperCursorAssistPlugin(viper)
{
    this.viper = viper;

}

ViperCursorAssistPlugin.prototype = {

    init: function()
    {
        var self = this;
        var t    = null;
        var validElems      = 'table,hr,img,object,ul,ol';
        var validElemsArray = validElems.split(',');
        this.viper.registerCallback('Viper:editableElementChanged', 'ViperCursorAssitPlugin', function() {
            ViperUtil.addEvent(self.viper.getViperElement(), 'mousemove', function(e) {
                clearTimeout(t);
                t = setTimeout(function() {
                    var line = ViperUtil.getid(self.viper.getId() + '-cursorAssist');
                    var hoverElem = self.viper.getElementAtCoords(e.clientX, e.clientY);
                    if (!hoverElem || self.viper.isOutOfBounds(hoverElem) === true) {
                        if (line) {
                            ViperUtil.remove(line);
                        }

                        return;
                    }

                    if (ViperUtil.inArray(ViperUtil.getTagName(hoverElem), validElemsArray) !== true) {
                        var elems = ViperUtil.getParents(hoverElem, validElems, self.viper.getViperElement());
                        if (elems.length === 0) {
                            if (line) {
                                ViperUtil.remove(line);
                            }

                            return;
                        } else {
                            hoverElem = elems[0];
                        }
                    }

                    var scroll   = ViperUtil.getScrollCoords();
                    var mousePos = (e.clientY + scroll.y);
                    var elemRect = ViperUtil.getBoundingRectangle(hoverElem);
                    var sibling  = '';
                    var height   = (elemRect.y2 - elemRect.y1);
                    var dist     = 10;
                    if (height < 40) {
                        dist = (height / 2);
                    }

                    if (elemRect.y1 + dist > mousePos) {
                        sibling = 'previousSibling';
                    } else if (elemRect.y2 - dist < mousePos) {
                        sibling = 'nextSibling';
                    } else {
                        if (line) {
                            ViperUtil.remove(line);
                        }

                        return;
                    }

                    var canShowLine = function(siblingType) {
                        // Check if the element after hoverElem is one of the valid elements or no next sibling.
                        var siblingElem = hoverElem[siblingType];
                        while (siblingElem) {
                            if (siblingElem.nodeType !== ViperUtil.TEXT_NODE) {
                                if (ViperUtil.inArray(ViperUtil.getTagName(siblingElem), validElemsArray) !== true) {
                                    if (line) {
                                        ViperUtil.remove(line);
                                    }

                                    return false;
                                } else {
                                    return true;
                                }
                            }

                            siblingElem = siblingElem[siblingType];
                        }

                        // No sibling found
                        return true;
                    }

                    if (canShowLine(sibling) !== true) {
                        return;
                    }

                    if (!line) {
                        line    = document.createElement('div');
                        line.id = self.viper.getId() + '-cursorAssist';
                        ViperUtil.addClass(line, 'ViperCursorAssistPlugin');
                        ViperUtil.setHtml(line, '<span class="ViperCursorAssistPlugin-cursorText"></span><span class="ViperCursorAssistPlugin-cursorLine"></span>');

                        ViperUtil.addEvent(line, 'click', function() {
                            ViperUtil.remove(line);

                            self.viper.focus();

                            var p = document.createElement('p');
                            ViperUtil.setHtml(p, '&nbsp;');

                            if (sibling === 'previousSibling') {
                                ViperUtil.insertBefore(hoverElem, p);
                            } else {
                                ViperUtil.insertAfter(hoverElem, p);
                            }

                            var range = self.viper.getCurrentRange();
                            range.setStart(p.firstChild, 0);
                            range.collapse(true);
                            ViperSelection.addRange(range);
                        });
                    }//end if

                    /*if (sibling === 'previousSibling') {
                        ViperUtil.setStyle(line, 'margin-top', '0px');
                        ViperUtil.setStyle(line, 'border-top', '1px dotted red');
                        ViperUtil.setStyle(line, 'border-bottom', 'none');
                    } else {
                        ViperUtil.setStyle(line, 'margin-top', '-15px');
                        ViperUtil.setStyle(line, 'border-bottom', '1px dotted red');
                        ViperUtil.setStyle(line, 'border-top', 'none');
                    }*/

                    if (sibling === 'previousSibling') {
                        ViperUtil.setStyle(line, 'top', elemRect.y1 - 5 + 'px');
                    } else {
                        ViperUtil.setStyle(line, 'top', elemRect.y2 + 'px');
                    }

                    ViperUtil.setStyle(line, 'left', elemRect.x1 + 'px');
                    ViperUtil.setStyle(line, 'width', (elemRect.x2 - elemRect.x1) + 'px');
                    document.body.appendChild(line);

                    self.viper.fireSelectionChanged();
                    self.viper.fireNodesChanged();
                }, 250);
            });
        });
    },

    isPluginElement: function(elem)
    {
        if (elem.id === this.viper.getId() + '-cursorAssist') {
            return true;
        }

    }

};