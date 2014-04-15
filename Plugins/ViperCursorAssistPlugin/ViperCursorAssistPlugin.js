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
    this._dist = 30;

}

ViperCursorAssistPlugin.prototype = {

    init: function()
    {
        var self = this;
        var t    = null;
        var validElems      = 'table,hr,img,object,ul,ol,iframe';
        var validElemsArray = validElems.split(',');
        var prevElement = null;
        var prevPos     = null;
        this.viper.registerCallback('Viper:editableElementChanged', 'ViperCursorAssitPlugin', function() {
            ViperUtil.addEvent(self.viper.getViperElement(), 'mousemove', function(e) {
                clearTimeout(t);
                t = setTimeout(function() {
                    var line = ViperUtil.getid(self.viper.getId() + '-cursorAssist');
                    var hoverElem = self.viper.getElementAtCoords(e.clientX, e.clientY);
                    if (hoverElem && hoverElem === line) {
                        return;
                    }

                    if (!hoverElem || self.viper.isOutOfBounds(hoverElem) === true) {
                        if (line) {
                            ViperUtil.remove(line);
                        }

                        prevElement = null;
                        prevPos     = null;

                        return;
                    }

                    if (ViperUtil.inArray(ViperUtil.getTagName(hoverElem), validElemsArray) !== true) {
                        var elems = ViperUtil.getParents(hoverElem, validElems, self.viper.getViperElement());
                        if (elems.length === 0) {
                            if (line) {
                                ViperUtil.remove(line);
                            }

                            prevElement = null;
                            prevPos     = null;

                            return;
                        } else {
                            hoverElem = elems[0];
                        }
                    }

                    var sibling  = '';
                    var scroll   = ViperUtil.getScrollCoords();
                    var mousePos = (e.clientY + scroll.y);
                    var elemRect = ViperUtil.getBoundingRectangle(hoverElem);
                    var dist     = self._dist;

                    if (ViperUtil.isTag(hoverElem, 'table') === true
                        && ViperUtil.isBrowser('firefox') === true
                    ) {
                        // Firefox does not include the caption element's height as part of the table.
                        // Need to add it here.
                        var caption = ViperUtil.getTag('caption', hoverElem);
                        if (caption) {
                            elemRect.y2 += ViperUtil.$(caption[0]).outerHeight(true);
                        }
                    }

                    var height = (elemRect.y2 - elemRect.y1);

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

                        prevElement = null;
                        prevPos = null;

                        return;
                    }

                    if (prevElement === hoverElem && prevPos === sibling) {
                        return;
                    }

                    prevElement = hoverElem;
                    prevPos = sibling;
                    var inBetween = false;

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
                                    inBetween = true;
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
                        ViperUtil.setHtml(line, '<span class="ViperCursorAssistPlugin-cursorText">Insert</span><span class="ViperCursorAssistPlugin-cursorLine"></span>');

                        ViperUtil.addEvent(line, 'click', function() {
                            ViperUtil.remove(line);

                            self.viper.focus();

                            var p = document.createElement('p');
                            ViperUtil.setHtml(p, '<br/>');

                            if (sibling === 'previousSibling') {
                                ViperUtil.insertBefore(hoverElem, p);
                            } else {
                                ViperUtil.insertAfter(hoverElem, p);
                            }

                            var range = self.viper.getCurrentRange();
                            range.setStart(p.firstChild, 0);
                            range.collapse(true);
                            ViperSelection.addRange(range);

                            self.viper.fireNodesChanged();
                            self.viper.fireSelectionChanged(null, true);
                        });
                    }//end if

                    ViperUtil.removeClass(line, 'insertBetween');
                    if (sibling === 'previousSibling') {
                        ViperUtil.setStyle(line, 'top', elemRect.y1 + 'px');
                        ViperUtil.removeClass(line, 'insertAfter');

                        if (inBetween === true) {
                            ViperUtil.addClass(line, 'insertBetween');
                        } else {
                            ViperUtil.addClass(line, 'insertBefore');
                        }
                    } else {
                        ViperUtil.setStyle(line, 'top', elemRect.y2 + 'px');
                        ViperUtil.removeClass(line, 'insertBefore');

                        if (inBetween === true) {
                            ViperUtil.addClass(line, 'insertBetween');
                        } else {
                            ViperUtil.addClass(line, 'insertAfter');
                        }
                    }//end if

                    ViperUtil.setStyle(line, 'left', elemRect.x1 + 'px');
                    ViperUtil.setStyle(line, 'width', (elemRect.x2 - elemRect.x1) + 'px');
                    document.body.appendChild(line);
                }, 200);
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