/**
 * Returns the HTML contents of the specified element.
 */
function gHtml(selector, index)
{
    index = index || 0;
    if (selector) {
        var html = dfx.getHtml(dfxjQuery(selector)[index]).replace("\n", '');
        return viper.getHtml(html);
    } else {
        return viper.getHtml();
    }

}

function gText()
{
    var selection    = '';
    var selHighlights = dfx.getClass('__viper_selHighlight');
    if (selHighlights.length > 0) {
        for (var i = 0; i < selHighlights.length; i++) {
            selection += dfx.getNodeTextContent(selHighlights[i]);
        }
    } else {
        selection = viper.getViperRange().toString();
    }

    return selection;

}

/**
 * Executes the JS string set as the value of jsExec textarea.
 */
function execJS()
{
    var val = dfx.getId('jsExec').value;
    dfx.getId('jsRes').value  = '';
    dfx.getId('jsExec').value = '';

    val  = 'var jsResult = ' + val + ';';
    val += 'dfx.getId("jsRes").value = dfx.jsonEncode(jsResult);';

    // Execute JS.
    eval(val);

}

/**
 * Returns the bounding rectangle values of the specified element.
 */
function gBRec(selector, index)
{
    var rect = dfx.getBoundingRectangle(dfxjQuery(selector)[index]);
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
    var tags = dfx.getTag(tagNames, dfx.getId('content'));
    for (var i = 0; i < tags.length; i++) {
        var tagName = dfx.getTagName(tags[i]);
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

/**
 * Inserts a new table.
 */
function insTable(rows, cols, id)
{
    var table = viper.getPluginManager().getPlugin('ViperTableEditorPlugin').insertTable(rows, cols);

    if (id) {
        table.setAttribute('id', id);
    }

    return table;

}//end insTable()

function rmTableHeaders(tblIndex, removeid)
{
    var table = dfx.getTag('table')[tblIndex];
    if (!table) {
        return;
    }

    if (removeid === true) {
        table.removeAttribute('id');
    }

    var headers      = dfx.find(table, '[headers]');
    var headersCount = headers.length;
    if (headersCount > 0) {
        for (var i = 0; i < headersCount; i++) {
            headers[i].removeAttribute('headers');
        }
    }

}
