 /**
 * Returns the specified table's structure.
 */
function gTS(index, incContent)
{
    var struct = {
        rows: []
    };

    var table = dfx.getTag('table')[0];
    var rows  = dfx.getTag('tr', table);
    for (var i = 0; i < rows.length; i++) {
        var row   = rows[i];
        var cells = dfx.getTag('td,th', row);

        var rowInfo = {
            cells: []
        };

        for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];
            var cellInfo = {
                rowspan: cell.getAttribute('rowspan') || 0,
                colspan: cell.getAttribute('colspan') || 0,
                heading: dfx.isTag(cell, 'th')
            };

            if (incContent) {
                cellInfo.content = dfx.getHtml(cell);
            }

            rowInfo.cells.push(cellInfo);
        }

        struct.rows.push(rowInfo);
    }//end for

    return struct;

}//end gTS()

/**
 * Inserts a new table.
 */
function insTable(rows, cols)
{
    return viper.getPluginManager().getPlugin('ViperTableEditorPlugin').insertTable(rows, cols);

}//end insTable()

function gTblBStatus()
{
    var btns = {
        splitVert: false,
        splitHoriz: false,
        mergeUp: false,
        mergeDown: false,
        mergeLeft: false,
        mergeRight: false
    };

    for (var btn in btns) {
        if (dfx.hasClass(dfx.getClass(btn)[0], 'disabled') === false){
            btns[btn] = true;
        }
    }

    return btns;

}//end gTblBStatus()
