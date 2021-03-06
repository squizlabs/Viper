 /**
 * Returns the specified table's structure.
 */
function gTS(index, incContent)
{
    var struct = {
        rows: []
    };

    var table = Viper.Util.getTag('table')[0];
    var rows  = Viper.Util.getTag('tr', table);
    for (var i = 0; i < rows.length; i++) {
        var row   = rows[i];
        var cells = Viper.Util.getTag('td,th', row);

        var rowInfo = {
            cells: []
        };

        for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];
            var cellInfo = {
                rowspan: cell.getAttribute('rowspan') || 0,
                colspan: cell.getAttribute('colspan') || 0,
                heading: Viper.Util.isTag(cell, 'th')
            };

            if (incContent) {
                cellInfo.content = Viper.Util.getHtml(cell);
            }

            rowInfo.cells.push(cellInfo);
        }

        struct.rows.push(rowInfo);
    }//end for

    return struct;

}//end gTS()

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
        var elems = Viper.Util.getClass('Viper-' + btn);
        for (var i = 0; i < elems.length; i++) {
            if (Viper.Util.getElementHeight(elems[i]) > 0) {
                if (Viper.Util.hasClass(elems[i], 'Viper-disabled') === false) {
                    btns[btn] = true;
                }

                break;
            }
        }
    }

    return btns;

}//end gTblBStatus()

function gTblH()
{
    return viperTest.get('tableHighlightRect');

}

// Hook in to table
viperTest.addReadyCallback(function() {
    viperTest.set('tableHighlightFunction', viper.getPluginManager().getPlugin('ViperTableEditorPlugin').highlightActiveCell);
    viper.getPluginManager().getPlugin('ViperTableEditorPlugin').highlightActiveCell = function() {
        var retVal = viperTest.get('tableHighlightFunction').apply(this, arguments);
        viperTest.set('tableHighlightRect', Viper.Util.getBoundingRectangle(Viper.Util.getClass('ViperITP-highlight')[0]));
        return retVal;
    }
});

