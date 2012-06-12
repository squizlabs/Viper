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
    }
};


/**
 * Returns the HTML contents of the specified element.
 */
function gHtml(selector, index)
{
    index = index || 0;
    if (selector) {
        var html = window.opener.dfx.getHtml(window.opener.dfxjQuery(selector)[index]).replace("\n", '');
        return window.opener.viper.getHtml(html);
    } else {
        return window.opener.viper.getHtml();
    }

}

function gText()
{
    var selection    = '';
    var selHighlights = window.opener.dfx.getClass('__viper_selHighlight');
    if (selHighlights.length > 0) {
        for (var i = 0; i < selHighlights.length; i++) {
            selection += window.opener.dfx.getNodeTextContent(selHighlights[i]);
        }
    } else {
        selection = window.opener.viper.getViperRange().toString();
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

    var buttons = window.opener.dfxjQuery.find(selector);
    if (buttons.length === 0) {
        return false;
    }

    var button = null;
    for (var i = 0; i < buttons.length; i++) {
        if (window.opener.dfx.getElementHeight(buttons[i]) !== 0) {
            button = buttons[i];
            break;
        }
    }

    var rect = window.opener.dfx.getBoundingRectangle(button);
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

    var field = window.opener.dfxjQuery.find(selector)[0];
    if (!field) {
        return false;
    }

    var rect = window.opener.dfx.getBoundingRectangle(field);
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
    var val = window.opener.dfx.getId('jsExec').value;
    window.opener.dfx.getId('jsRes').value  = '';
    window.opener.dfx.getId('jsExec').value = '';

    val  = 'var jsResult = ' + val + ';';
    val += 'window.opener.dfx.getId("jsRes").value = window.opener.dfx.jsonEncode(jsResult);';

    // Execute JS.
    eval(val);

}

/**
 * Returns the bounding rectangle values of the specified element.
 */
function gBRec(selector, index)
{
    var rect = window.opener.dfx.getBoundingRectangle(window.opener.dfxjQuery(selector)[index]);
    rect.x1 = parseInt(rect.x1);
    rect.x2 = parseInt(rect.x2);
    rect.y1 = parseInt(rect.y1);
    rect.y2 = parseInt(rect.y2);
    return rect;

}

function gTagCounts(tagNames)
{
    tagNames = tagNames || '*';
    var tagCounts = {};
    var tags = window.opener.dfx.getTag(tagNames, window.opener.dfx.getId('content'));
    for (var i = 0; i < tags.length; i++) {
        var tagName = window.opener.dfx.getTagName(tags[i]);
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
    var activeBubble = window.opener.viper.getPluginManager().getPlugin('ViperToolbarPlugin').getActiveBubble();
    if (!activeBubble) {
        return null;
    }

    var rect = window.opener.dfx.getBoundingRectangle(activeBubble.element);
    return rect;

}

/**
 * Inserts a new table.
 */
function insTable(rows, cols, header, id)
{
    var table = window.opener.viper.getPluginManager().getPlugin('ViperTableEditorPlugin').insertTable(rows, cols, header, id);

    return table;

}//end insTable()

function rmTableHeaders(tblIndex, removeid)
{
    var table = window.opener.dfx.getTag('table')[tblIndex];
    if (!table) {
        return;
    }

    if (removeid === true) {
        table.removeAttribute('id');
    }

    var cells = window.opener.dfx.getTag('td,th');
    for (var i = 0; i < cells.length; i++) {
        cells[i].removeAttribute('id');
    }

    var headers      = window.opener.dfx.find(table, '[headers]');
    var headersCount = headers.length;
    if (headersCount > 0) {
        for (var i = 0; i < headersCount; i++) {
            headers[i].removeAttribute('headers');
        }
    }

}
