<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_GeneralTableUnitTest extends AbstractViperUnitTest
{


    /**
     * Returns the full path of the specified image file name.
     *
     * @param string $img The image file name.
     *
     * @return string
     */
    private function _getImg($img)
    {
        $path = dirname(__FILE__).'/Images/'.$img;
        return $path;

    }//end _getImg()


    /**
     * Creates a blank 3x3 table.
     *
     * @return void
     */
    private function _insertTable()
    {
        $this->selectText('IPSUM');
        $this->clickTopToolbarButton($this->_getImg('toolbarIcon_createTable.png'));

    }//end _insertTable()


    /**
     * Test that creating a new table works.
     *
     * @return void
     */
    public function testCreateTable()
    {
        $this->_insertTable();

        $this->assertHTMLMatch('<p>Lorem </p><table style="width: 300px; " border="1"><tbody><tr><td style="width: 100px; ">&nbsp;</td><td style="width: 100px; ">&nbsp;</td><td style="width: 100px; ">&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p> dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testCreateTable()


    /**
     * Test that clicking in a cell shows the table editing icon.
     *
     * @return void
     */
    public function testTableEditingIconAndTools()
    {
        $this->_insertTable();

        // Get the first cell of the table.
        $tableRect = $this->getBoundingRectangle('table');
        sleep(1);

        $cellRect = $this->getBoundingRectangle('td');
        $region   = $this->getRegionOnPage($cellRect);

        // Click inside the cell.
        $this->click($region);

        $icon = $this->find($this->_getImg('icon_tableEditor.png'), NULL, 0.9);

        // Check that position is correct.
        $iconX = $this->getPageX($this->getCenter($icon));
        $iconY = $this->getPageY($this->getTopLeft($icon));

        $cellCenter = ($cellRect['x1'] + (($cellRect['x2'] - $cellRect['x1']) / 2));
        $cellBottom = $cellRect['y2'];

        $this->assertTrue((($cellCenter + 3) >= $iconX && ($cellCenter - 3) <= $iconX), 'Y Position of table editing icon is incorrect.');
        $this->assertTrue(($cellBottom <= $iconY && $cellBottom + 5 > $iconY), 'Y Position of table editing icon is incorrect.');

        // Move mouse on top of the icon.
        $this->mouseMove($icon);
        usleep(200);

        // Check to make sure the table editing tools appear.
        $this->find($this->_getImg('icon_tableEditingTools.png'));

        // Check the highlight for table icon.
        $this->mouseMove($this->_getImg('icon_tools_table.png'));
        usleep(200);

        $highlightRect = $this->getBoundingRectangle('.ViperITP-highlight');
        if ($highlightRect['x1'] !== $tableRect['x1']
            || $highlightRect['x2'] !== $tableRect['x2']
            || $highlightRect['y1'] !== $tableRect['y1']
            || $highlightRect['y2'] !== $tableRect['y2']
        ) {
            $this->fail('Highlight of table is not in the correct position');
        }

        // Check the highlight for row.
        $this->mouseMove($this->_getImg('icon_tools_row.png'));
        usleep(200);

        // Note that +1 or -1 is for cellpadding.
        $highlightRect = $this->getBoundingRectangle('.ViperITP-highlight');
        if ((int) $highlightRect['x1'] !== (int) $tableRect['x1']
            || (int) $highlightRect['x2'] !== (int) $tableRect['x2']
            || $highlightRect['y1'] !== ($cellRect['y1'] - 1)
            || $highlightRect['y2'] !== ($cellRect['y2'] + 1)
        ) {
            $this->fail('Highlight of row is not in the correct position');
        }

        // Check the highlight for cell.
        $this->mouseMove($this->_getImg('icon_tools_col.png'));
        usleep(200);

        $highlightRect = $this->getBoundingRectangle('.ViperITP-highlight');
        if ($highlightRect['x1'] !== ($cellRect['x1'] - 1)
            || $highlightRect['x2'] !== ($cellRect['x2'] + 1)
            || $highlightRect['y1'] !== $tableRect['y1']
            || $highlightRect['y2'] !== $tableRect['y2']
        ) {
            $this->fail('Highlight of col is not in the correct position');
        }

        // Check the highlight for cell.
        $this->mouseMove($this->_getImg('icon_tools_cell.png'));
        usleep(200);

        $highlightRect = $this->getBoundingRectangle('.ViperITP-highlight');
        if ($highlightRect['x1'] !== ($cellRect['x1'] - 1)
            || $highlightRect['x2'] !== ($cellRect['x2'] + 1)
            || $highlightRect['y1'] !== ($cellRect['y1'] - 1)
            || $highlightRect['y2'] !== ($cellRect['y2'] + 1)
        ) {
            $this->fail('Highlight of cell is not in the correct position');
        }

    }//end testTableEditingIconAndTools()


}//end class

?>
