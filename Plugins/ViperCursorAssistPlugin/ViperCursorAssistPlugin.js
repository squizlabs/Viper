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
        var validElems      = 'table,hr,img,object,ul,ol,iframe,canvas,audio,embed,figure,pre,blockquote';
        var validElemsArray = validElems.split(',');
        var prevElement = null;
        var prevPos     = null;
        var hover       = false;

        var _removeLine = function(line, clearPrev) {
            if (line) {
                ViperUtil.remove(line);
            }

            hover = false;
            if (clearPrev !== false) {
                prevElement = null;
                prevPos     = null;
            }
        };

        this.viper.registerCallback('Viper:editableElementChanged', 'ViperCursorAssistPlugin', function() {
            ViperUtil.addEvent(ViperUtil.getDocuments(), 'mousemove', function(e) {
                clearTimeout(t);
                t = setTimeout(function() {
                    var line = ViperUtil.getid(self.viper.getId() + '-cursorAssist');

                    if (self.viper.isEnabled() === false) {
                        if (line) {
                            _removeLine(line);
                        }

                        return;
                    }

                    var hoverElem = self.viper.getElementAtCoords(e.clientX, e.clientY);
                    if (hoverElem && (hover === true || hoverElem === line || hoverElem.parentNode.parentNode === line)) {
                        return;
                    }

                    if (!hoverElem || self.viper.isOutOfBounds(hoverElem) === true) {
                        _removeLine(line);
                        return;
                    }

                    if (ViperUtil.inArray(ViperUtil.getTagName(hoverElem), validElemsArray) !== true) {
                        var elems = ViperUtil.getParents(hoverElem, validElems, self.viper.getViperElement());
                        if (elems.length === 0) {
                            _removeLine(line);
                            return;
                        } else {
                            hoverElem = elems.shift();

                            if (elems.length > 0
                                && (ViperUtil.isTag(hoverElem, 'ul') === true || ViperUtil.isTag(hoverElem, 'ol') === true)
                            ) {
                                // Do not show the line if this is a nested list.
                                if (ViperUtil.getParents(hoverElem, 'ul,ol', self.viper.getViperElement()).length > 0) {
                                    _removeLine(line);
                                    return;
                                }
                            }
                        }
                    }

                    var sibling  = '';
                    var scroll   = ViperUtil.getScrollCoords();
                    var mousePos = (e.clientY + scroll.y);
                    var elemRect = ViperUtil.getBoundingRectangle(hoverElem);
                    var dist     = self._dist;
                    var childScrollCoords = {x:0, y:0};

                    if (self.viper.isEditableInIframe() === true) {
                        childScrollCoords = ViperUtil.getScrollCoords(hoverElem.ownerDocument.defaultView);
                        mousePos += childScrollCoords.y;
                    }

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

                    var relYPoint = null;
                    if (elemRect.y1 + dist > mousePos) {
                        sibling = 'previousSibling';
                        relYPoint = elemRect.y1;
                    } else if (elemRect.y2 - dist < mousePos) {
                        sibling = 'nextSibling';
                        relYPoint = elemRect.y2;
                    } else {
                        _removeLine(line);
                        return;
                    }

                    if (prevElement === hoverElem && prevPos === sibling) {
                        return;
                    }

                    if (self.isInToolbarBounds(relYPoint) === true) {
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
                                        _removeLine(line, false);
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

                    if (line) {
                        _removeLine(line, false);
                    }

                    line    = document.createElement('div');
                    line.id = self.viper.getId() + '-cursorAssist';
                    ViperUtil.addClass(line, 'ViperCursorAssistPlugin');
                    ViperUtil.setHtml(line, '<span class="ViperCursorAssistPlugin-cursorText">Insert</span><span class="ViperCursorAssistPlugin-cursorLine"></span>');
                    hover = false;

                    ViperUtil.hover(line, function() {
                        hover = true;
                    }, function() {
                        hover = false;
                    });

                    ViperUtil.addEvent(line, 'mousedown', function() {
                        _removeLine(line, false);

                        var p = document.createElement('p');

                        if (ViperUtil.isBrowser('msie', '<11') === true) {
                            ViperUtil.setHtml(p, '&nbsp;');
                        } else {
                            ViperUtil.setHtml(p, '<br/>');
                        }

                        // Use the block parent element of img, object etc.
                        if (ViperUtil.isBlockElement(hoverElem) === false || ViperUtil.isStubElement(hoverElem) === true) {
                            var blockParent = ViperUtil.getFirstBlockParent(hoverElem, self.viper.getViperElement());
                            if (blockParent) {
                                hoverElem = blockParent;
                            }
                        }

                        if (sibling === 'previousSibling') {
                            ViperUtil.insertBefore(hoverElem, p);
                        } else {
                            ViperUtil.insertAfter(hoverElem, p);
                        }

                        setTimeout(function() {
                            if (ViperUtil.isBrowser('msie') === false) {
                                self.viper.focus();
                            }

                            var range = self.viper.getCurrentRange();
                            var offset = 0;
                            if (ViperUtil.isBrowser('msie', '<11') === true) {
                                offset = 1;
                            }

                            range.setEnd(p.firstChild, offset);
                            range.setStart(p.firstChild, offset);
                            range.collapse(false);
                            ViperSelection.addRange(range);

                            self.viper.fireNodesChanged();
                            self.viper.fireSelectionChanged(null, true);
                        }, 10);
                    });

                    if (self.viper.isEditableInIframe() === true) {
                        childScrollCoords = ViperUtil.getScrollCoords(hoverElem.ownerDocument.defaultView);
                        elemRect.y1 -= childScrollCoords.y;
                        elemRect.y2 -= childScrollCoords.y;

                        var frameOffset = self.viper.getDocumentOffset(hoverElem.ownerDocument);
                        elemRect.y1 += frameOffset.y;
                        elemRect.y2 += frameOffset.y;
                        elemRect.x1 += frameOffset.x;
                        elemRect.x2 += frameOffset.x;

                    }

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
                    self.viper.addElement(line);

                    setTimeout(function() {
                        if (self.isInToolbarBounds(relYPoint) === true) {
                            _removeLine(line);
                            return;
                        }
                    }, 100)
                }, 200);
            });
        });

        this.viper.registerCallback(['Viper:mouseDown', 'Viper:mouseUp'], 'ViperCursorAssistPlugin', function() {
            setTimeout(
                function() {
                    var line = ViperUtil.getid(self.viper.getId() + '-cursorAssist');
                    if (line) {
                        _removeLine(line, false);
                    }
                },
                50
            );
        });

    },

    isInToolbarBounds: function(yPoint)
    {
        var gap             = 30;
        var visibleToolbars = this.viper.ViperTools.getVisibleToolbarRectangles();
        for (var i = 0; i < visibleToolbars.length; i++) {
            if (yPoint >= (visibleToolbars[i].y1 - gap) && yPoint <= (visibleToolbars[i].y2 + gap)) {
                return true;
            }
        }

        return false;

    },

    isPluginElement: function(elem)
    {
        var viperid = this.viper.getId();
        if (elem.id === viperid + '-cursorAssist'
            || (elem.parentNode && elem.parentNode.id === viperid + '-cursorAssist')
        ) {
            return true;
        }

    }

};
