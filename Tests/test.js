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


/**
 * Returns the HTML contents of the specified element.
 */
function gHtml(selector, index)
{
    index = index || 0;
    if (selector) {
        var html = viperTest.getWindow().dfx.getHtml(viperTest.getWindow().dfxjQuery(selector)[index]).replace("\n", '');
        return viperTest.getWindow().viper.getHtml(html);
    } else {
        return viperTest.getWindow().viper.getHtml();
    }

}

function gText()
{
    var selection    = '';
    var selHighlights = viperTest.getWindow().dfx.getClass('__viper_selHighlight');
    if (selHighlights.length > 0) {
        for (var i = 0; i < selHighlights.length; i++) {
            selection += viperTest.getWindow().dfx.getNodeTextContent(selHighlights[i]);
        }
    } else {
        selection = viperTest.getWindow().viper.getViperRange().toString();
    }

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

    var buttons = viperTest.getWindow().dfxjQuery.find(selector);
    if (buttons.length === 0) {
        return false;
    }

    var button = null;
    for (var i = 0; i < buttons.length; i++) {
        if (viperTest.getWindow().dfx.getHtml(buttons[i]) !== text) {
            continue;
        }

        if (viperTest.getWindow().dfx.getElementHeight(buttons[i]) !== 0) {
            button = buttons[i];
            break;
        }
    }

    if (!state
        && (viperTest.getWindow().dfx.hasClass(button, 'Viper-active') === true || viperTest.getWindow().dfx.hasClass(button, 'Viper-disabled') === true)
    ) {
        return false;
    }

    var rect = viperTest.getWindow().dfx.getBoundingRectangle(button);
    if (rect) {
        rect.x1 = parseInt(rect.x1);
        rect.x2 = parseInt(rect.x2);
        rect.y1 = parseInt(rect.y1);
        rect.y2 = parseInt(rect.y2);
    }

    return rect;

}

function gField(label)
{
    var selector = '.Viper-subSection.Viper-active label span';
    selector    += ':contains(' + label + ')';

    var field = viperTest.getWindow().dfxjQuery.find(selector)[0];
    if (!field) {
        return false;
    }

    var rect = viperTest.getWindow().dfx.getBoundingRectangle(field);
    if (rect) {
        rect.x1 = parseInt(rect.x1);
        rect.x2 = parseInt(rect.x2);
        rect.y1 = parseInt(rect.y1);
        rect.y2 = parseInt(rect.y2);
    }

    return rect;

}


/**
 * Executes the JS string set as the value of jsExec textarea.
 */
function execJS()
{
    var val = viperTest.getWindow().dfx.getId('jsExec').value;
    viperTest.getWindow().dfx.getId('jsRes').value  = '';
    viperTest.getWindow().dfx.getId('jsExec').value = '';

    val  = 'var jsResult = ' + val + ';';
    val += 'viperTest.getWindow().dfx.getId("jsRes").value = viperTest.getWindow().dfx.jsonEncode(jsResult);';

    // Execute JS.
    eval(val);

}

/**
 * Returns the bounding rectangle values of the specified element.
 */
function gBRec(selector, index)
{
    var rect = viperTest.getWindow().dfx.getBoundingRectangle(viperTest.getWindow().dfxjQuery(selector)[index]);
    rect.x1 = parseInt(rect.x1);
    rect.x2 = parseInt(rect.x2);
    rect.y1 = parseInt(rect.y1);
    rect.y2 = parseInt(rect.y2);
    return rect;

}

function gVITPArrow()
{
    var toolbar = viperTest.getWindow().viper.getPluginManager().getPlugin('ViperInlineToolbarPlugin').getToolbar().element;
    var rect    = viperTest.getWindow().dfx.getBoundingRectangle(toolbar);

    var arrow = {
        x1: (((rect.x2 - rect.x1) / 2) - 10),
        x2: (((rect.x2 - rect.x1) / 2) + 10),
        y1: (rect.y1 - 10),
        y2: rect.y1
    }

    return arrow;

}

function gTagCounts(tagNames)
{
    tagNames = tagNames || '*';
    var tagCounts = {};
    var tags = viperTest.getWindow().dfx.getTag(tagNames, viperTest.getWindow().dfx.getId('content'));
    for (var i = 0; i < tags.length; i++) {
        var tagName = viperTest.getWindow().dfx.getTagName(tags[i]);
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

    var rect = viperTest.getWindow().dfx.getBoundingRectangle(activeBubble.element);
    return rect;

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
    var table = viperTest.getWindow().dfx.getTag('table')[tblIndex];
    if (!table) {
        return;
    }

    if (removeid === true) {
        table.removeAttribute('id');
    }

    var cells = viperTest.getWindow().dfx.getTag('td,th');
    for (var i = 0; i < cells.length; i++) {
        cells[i].removeAttribute('id');
    }

    var headers      = viperTest.getWindow().dfx.find(table, '[headers]');
    var headersCount = headers.length;
    if (headersCount > 0) {
        for (var i = 0; i < headersCount; i++) {
            headers[i].removeAttribute('headers');
        }
    }

}
