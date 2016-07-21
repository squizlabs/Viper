var viperTest = {
    _data: {},
    _readyCallbacks: [],
    set: function(key, data) {
        this._data[key] = data;
    },
    get: function(key) {
        return this._data[key];
    },
    addReadyCallback: function(callback) {
        this._readyCallbacks.push(callback);
    },
    getReadyCallbacks: function() {
        return this._readyCallbacks;
    },
    getWindow: function() {
        if (window.opener) {
            return window.opener;
        } else {
            return window;
        }
    }
};

function sendResult(result)
{
    result = JSON.stringify(result);
    Viper.Util.$.post(PHPSikuliBrowser.getScriptURL(), {res: result, _t:(new Date().getTime())}, function() {
        PHPSikuliBrowser.startPolling();
    });

}

function getCodeCoverage()
{
    var coverage = '';
    if (window['jscoverage_serializeCoverageToJSON']) {
        coverage = jscoverage_serializeCoverageToJSON();
    }

    return coverage;

}


/**
 * Returns the HTML contents of the specified element.
 */
function gHtml(selector, index, removeTableHeaders)
{
    if (removeTableHeaders) {
        rmTableHeaders(null, true);
    }

    var html = '';
    index = index || 0;
    if (selector) {
        html = viperTest.getWindow().Viper.Util.getHtml(viperTest.getWindow().Viper.Util.$(selector)[index]).replace("\n", '');
        html = viperTest.getWindow().viper.getHtml(html);
    } else {
        html = viperTest.getWindow().viper.getHtml();
    }

    return html;

}

function getRawHTML(selector, index)
{
    var html = '';
    index    = index || 0;
    if (selector) {
        html = Viper.Util.getHtml(Viper.Util.$(selector)[index]).replace("\n", '');
    } else {
        html = Viper.Util.getHtml(viper.getViperElement());
    }

    var tmp = document.createElement('div');
    Viper.Util.setHtml(tmp, html);
    viper.cleanDOM(tmp);
    html = Viper.Util.getHtml(tmp);

    if (html) {
        html = html.replace(/<\/?\s*([A-Z\d:]+)/g, function(str) {
            return str.toLowerCase();
        });
    }

    html = viper.cleanHTML(html);

    return html;

}

function gText()
{
    var selection    = '';
    var selHighlights = viperTest.getWindow().Viper.Util.getClass('__viper_selHighlight');
    if (selHighlights.length > 0) {
        for (var i = 0; i < selHighlights.length; i++) {
            selection += viperTest.getWindow().Viper.Util.getNodeTextContent(selHighlights[i]);
        }
    } else {
        selection = viperTest.getWindow().viper.getViperRange().toString();
    }

    // Remove extra spaces from the end of the string (Chrome likes to add new line
    // character for block element selections).
    selection = viperTest.getWindow().Viper.Util.rtrim(selection);

    return selection;

}

function gITPBtn(text, state)
{
    var rect = false;

    rect = gBtn(text, state, '.ViperITP.Viper-visible .Viper-subSection.Viper-active ');

    if (!rect) {
        rect = gBtn(text, state, '.ViperITP.Viper-visible .ViperITP-tools ');
    }

    return rect;

}

function gTPBtn(text, state)
{
    var rect = false;
    rect = gBtn(text, state, '.Viper-forTopbar .Viper-subSection.Viper-active ');

    if (!rect) {
        rect = gBtn(text, state, '.Viper-forTopbar .ViperITP-tools ');
    }

    return rect;

}

function gBtn(text, state, selectorPrefix)
{
    var selector = '';

    if (selectorPrefix) {
        selector += selectorPrefix;
    }

    selector += '.Viper-button';

    if (state) {
        selector += '.Viper-' + state;
    }

    selector += ':contains(' + text + ')';

    var buttons = viperTest.getWindow().Viper.Util.$.find(selector);
    if (buttons.length === 0) {
        return false;
    }

    var button = null;
    for (var i = 0; i < buttons.length; i++) {
        if (viperTest.getWindow().Viper.Util.getHtml(buttons[i]) !== text) {
            continue;
        }

        if (viperTest.getWindow().Viper.Util.getElementHeight(buttons[i]) !== 0) {
            button = buttons[i];
            break;
        }
    }

    if (!state
        && (viperTest.getWindow().Viper.Util.hasClass(button, 'Viper-active') === true || viperTest.getWindow().Viper.Util.hasClass(button, 'Viper-disabled') === true)
    ) {
        return false;
    }

    var rect = null;
    if (button) {
        rect = viperTest.getWindow().Viper.Util.getBoundingRectangle(button);
        if (rect) {
            rect.x1 = (parseInt(rect.x1) + 3);
            rect.x2 = (parseInt(rect.x2) - 1);
            rect.y1 = (parseInt(rect.y1) + 3);
            rect.y2 = (parseInt(rect.y2) - 1);
        }
    }

    return rect;

}

function gField(label)
{
    var selector = '.Viper-subSection.Viper-active label span';
    selector    += ':contains(' + label + ')';

    var field = viperTest.getWindow().Viper.Util.$.find(selector)[0];
    if (!field) {
        return false;
    }

    var rect = viperTest.getWindow().Viper.Util.getBoundingRectangle(field);
    if (rect) {
        rect.x1 = parseInt(rect.x1);
        rect.x2 = parseInt(rect.x2);
        rect.y1 = parseInt(rect.y1);
        rect.y2 = parseInt(rect.y2);
    }

    return rect;

}

function gFieldValue(label)
{
    var selector = '.Viper-subSection.Viper-active label span';
    selector    += ':contains(' + label + ')';

    var field = viperTest.getWindow().Viper.Util.$.find(selector)[0];
    if (!field) {
        return false;
    }

    var value = field.nextSibling.value;
    return value;

}


/**
 * Executes the JS string set as the value of jsExec textarea.
 */
function execJS()
{
    var val = viperTest.getWindow().Viper.Util.getid('jsExec').value;
    viperTest.getWindow().Viper.Util.getid('jsRes').value  = '';
    viperTest.getWindow().Viper.Util.getid('jsExec').value = '';

    val  = 'var jsResult = ' + val + ';';
    val += 'Viper.Util.getid("jsRes").value = JSON.stringify(jsResult);';

    // Execute JS.
    eval(val);

}

/**
 * Returns the bounding rectangle values of the specified element.
 */
function gBRec(selector, index)
{
    var elem = Viper.Util.$(selector)[index];
    var rect = viperTest.getWindow().Viper.Util.getBoundingRectangle(elem);
    rect.x1  = parseInt(rect.x1);
    rect.x2  = parseInt(rect.x2);
    rect.y1  = parseInt(rect.y1);
    rect.y2  = parseInt(rect.y2);

    return rect;

}

function gVITPArrow()
{
    var toolbar = Viper.Util.getClass('ViperITP Viper-visible')[0];
    if (!toolbar) {
        return  null;
    }

    var rect  = viperTest.getWindow().Viper.Util.getBoundingRectangle(toolbar);
    var arrow = {
        x1: rect.x1 + (((rect.x2 - rect.x1) / 2) - 10),
        x2: rect.x1 + (((rect.x2 - rect.x1) / 2) + 10),
        y1: (rect.y1 - 10),
        y2: rect.y1
    }

    if (arrow.x1 <= 0 || arrow.y1 <= 0) {
        arrow = null;
    }

    return arrow;

}

function gTagCounts(tagNames)
{
    tagNames = tagNames || '*';
    var tagCounts = {};
    var tags = viperTest.getWindow().Viper.Util.getTag(tagNames, viperTest.getWindow().Viper.Util.getid('content'));
    for (var i = 0; i < tags.length; i++) {
        var tagName = viperTest.getWindow().Viper.Util.getTagName(tags[i]);
        if (!tagCounts[tagName]) {
            tagCounts[tagName] = 1;
        } else {
            tagCounts[tagName]++;
        }
    }

    tagNames = tagNames.split(',');

    for (var i = 0; i < tagNames.length; i++) {
        if (!tagCounts[tagNames[i]]) {
            tagCounts[tagNames[i]] = 0;
        }
    }

    return tagCounts;

}

function gActBubble()
{
    var activeBubble = viperTest.getWindow().viper.getPluginManager().getPlugin('ViperToolbarPlugin').getActiveBubble();
    if (!activeBubble) {
        return null;
    }

    var rect = viperTest.getWindow().Viper.Util.getBoundingRectangle(activeBubble.element);
    return rect;

}

function gStringLoc(str)
{
    var range          = viper.getCurrentRange();
    var clone          = range.cloneRange();
    var loc            = null;
    var contentElement = document.getElementById('content');
    if (Viper.Util.isBrowser('msie') === true) {
        // Range search.
        var viperRange = null;
        var textRange  = new Viper.IERange(document.body.createTextRange());
        var selectable = range._getFirstSelectableChild(contentElement);
        textRange.setStart(selectable, 0);
        textRange.setEnd(selectable, 0);
        viperRange = textRange;

        var found = viperRange.rangeObj.findText(str);
        loc = viperRange.rangeObj.getBoundingClientRect();
        loc = {
                x1: loc.left,
                x2: loc.right,
                y1: loc.top,
                y2: loc.bottom
            };

    } else if (Viper.Util.isBrowser('edge') === true) {
        var plugin = viper.getPluginManager().getPlugin('ViperSearchReplacePlugin');
        if (plugin.find(str, false, true, false, Viper.Util.getid('content')) === true) {
            range = viper.getCurrentRange();
            loc = range.rangeObj.getBoundingClientRect();
            loc = {
                    x1: loc.left,
                    x2: loc.right,
                    y1: loc.top,
                    y2: loc.bottom
                };
        }
    } else {
        range.setStart(range._getFirstSelectableChild(contentElement), 0);
        range.collapse(true);
        Viper.Selection.addRange(range);
        if (window.find(str, true, false, true, true, true) === true) {
            loc = viper.getCurrentRange().rangeObj.getBoundingClientRect();
            loc = {
                x1: loc.left,
                x2: loc.right,
                y1: loc.top,
                y2: loc.bottom
            };
        }
    }

    // Reset selection.
    Viper.Selection.addRange(clone);

    return loc;

}

function hideToolbarsAtLocation(loc)
{
    var toolbars = Viper.Util.find(document.body, '.ViperITP.Viper-visible');
    for (var i = 0; i < toolbars.length; i++) {
        var toolbarLoc = Viper.Util.getBoundingRectangle(toolbars[i]);
        if (Viper.Util.isIntersectingRect(loc, toolbarLoc) === true) {
            Viper.Util.setStyle(toolbars[i], 'left', '-1000px');
        }
    }

}

/**
 * Inserts a new table.
 */
function insTable(rows, cols, header, id)
{
    var table = viperTest.getWindow().viper.getPluginManager().getPlugin('ViperTableEditorPlugin').insertTable(rows, cols, header, id);

    return table;

}//end insTable()

function rmTableHeaders(tblIndex, removeid)
{
    var tables = viperTest.getWindow().Viper.Util.getTag('table');

    if (tblIndex === null) {
        for (var i = 0; i < tables.length; i++) {
            rmTableHeaders(i, removeid);
        }

        return;
    }

    table = tables[tblIndex];
    if (!table) {
        return;
    }

    if (removeid === true) {
        table.removeAttribute('id');
    }

    var cells = viperTest.getWindow().Viper.Util.getTag('td,th');
    for (var i = 0; i < cells.length; i++) {
        cells[i].removeAttribute('id');
    }

    var headers      = viperTest.getWindow().Viper.Util.find(table, '[headers]');
    var headersCount = headers.length;
    if (headersCount > 0) {
        for (var i = 0; i < headersCount; i++) {
            headers[i].removeAttribute('headers');
        }
    }

}

function useTest(id)
{
    var testCases = viperTest.get('testCases');
    if (!testCases || !testCases[id]) {
        return;
    }

    var win = viperTest.getWindow();

    viper.fireCallbacks('Viper:clickedOutside');

    var contentElement = viperTest.get('contentElement');
    Viper.Util.setHtml(contentElement, testCases[id]);

    Viper.Util.setHtml(win.Viper.Util.getid('testCaseTitle'), '(Using Test #' + id + ')');

    if (viper.element) {
        viper.element.blur();
    }

    Viper.Selection.removeAllRanges();

    if (Viper.Util.isBrowser('msie') === true) {
        viper.setEditableElement(contentElement);
        viper.setEnabled(false);
        viper.initEditableElement(contentElement);
    } else {
        viper.initEditableElement(contentElement);
    }

    viper.cleanDOM(contentElement);

    viper.getHistoryManager().clear();
    viper.getHistoryManager().add();

}

function pasteFromURL(url)
{
    var copyPastePlugin = viper.getPluginManager().getPlugin('ViperCopyPastePlugin');

    Viper.Util.$.get(url, null, function(data) {
        var tmp = document.createElement('div');
        Viper.Util.setHtml(tmp, data);

        copyPastePlugin._beforePaste();

        if (Viper.Util.isBrowser('msie') === true || Viper.Util.isBrowser('edge') === true) {
            var bookmark = copyPastePlugin._bookmark;
            copyPastePlugin._insertTmpNodeBeforeBookmark(bookmark);
        }

        viper.removeBookmarks(null, true);

        copyPastePlugin._handleFormattedPasteValue(false, tmp, viper.getViperElement());
        sendResult();
    });

}

function clean()
{
    viper.destroy();
    Viper.Util.remove(Viper.Util.getid('windowTarget'));
    Viper.Util.setHtml(Viper.Util.getid('content'), '');

}

function testJSExec()
{
    return 'Pass';
}

function changeTextColour(colour)
{
    Viper.Util.setStyle(viper.getViperElement(), 'color', colour);
}

function getTestHTML() {
    var html = gHtml();
    var keywords = ['A', 'B', 'C', 'D', 'T', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M'];
    for (var i = 0; i < keywords.length; i++) {
        html = html.replace('X' + keywords[i] + 'X', '%' + (i + 1) + '%');
    }

    html.replace('<br /><ol>', '<ol>');
    html.replace('<br /><ul>', '<ul>');

    return html;

};
