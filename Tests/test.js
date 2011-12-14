/**
 * Returns the HTML contents of the specified element.
 */
function gHtml(selector, index)
{
    index = index || 0;
    if (selector) {
        return dfx.getHtml(dfxjQuery(selector)[index]).replace("\n", '');
    } else {
        return dfx.getHtml(dfx.getId('content')).replace("\n", '');
    }

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
