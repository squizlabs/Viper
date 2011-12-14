<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_GeneralTableUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Returns the difference in pixel between two positions.
     *
     * @param integer $pos1 A position.
     * @param integer $pos2 A position.
     *
     * @return integer
     */
    private function _posDiff($pos1, $pos2)
    {
        return abs((int) ($pos1 - $pos2));

    }//end _posDiff()


    /**
     * Test that creating a new table works.
     *
     * @return void
     */
    public function testCreateTable()
    {
        $this->insertTable();

        $this->assertHTMLMatch('<p>Lorem </p><table style="width: 300px; " border="1"><tbody><tr><td style="width: 100px; ">&nbsp;</td><td style="width: 100px; ">&nbsp;</td><td style="width: 100px; ">&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p> dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testCreateTable()


    /**
     * Test that clicking in a cell shows the table editing icon.
     *
     * @return void
     */
    public function testTableEditingIconAndTools()
    {
        $this->insertTable();

        // Get the first cell of the table.
        $tableRect = $this->getBoundingRectangle('table');
        sleep(1);

        $cellRect = $this->getBoundingRectangle('td');
        $region   = $this->getRegionOnPage($cellRect);

        // Click inside the cell.
        $this->click($region);

        $toolIconRect = $this->getBoundingRectangle('#test-ViperTEP', 0);
        $icon         = $this->getRegionOnPage($toolIconRect);

        // Check that position is correct.
        $iconX = $this->getPageX($this->getCenter($icon));
        $iconY = $this->getPageY($this->getTopLeft($icon));

        $cellCenter = ($cellRect['x1'] + (($cellRect['x2'] - $cellRect['x1']) / 2));
        $cellBottom = $cellRect['y2'];

        $this->assertTrue((($cellCenter + 3) >= $iconX && ($cellCenter - 3) <= $iconX), 'X Position of table editing icon is incorrect.');
        $this->assertTrue(($cellBottom <= $iconY && $cellBottom + 10 > $iconY), 'Y Position of table editing icon is incorrect.');

        // Move mouse on top of the icon.
        $this->mouseMove($icon);
        usleep(200);

        // Check to make sure the table editing tools appear.
        $this->find($this->getImg('icon_tableEditingTools.png'));

        // Check the highlight for table icon.
        $this->mouseMove($this->getImg('icon_tools_table.png'));
        usleep(200);

        $highlightRect = $this->getBoundingRectangle('.ViperITP-highlight');
        if (($this->_posDiff($highlightRect['x1'], $tableRect['x1']) > 3)
            || ($this->_posDiff($highlightRect['x2'], $tableRect['x2']) > 3)
            || ($this->_posDiff($highlightRect['y1'], $tableRect['y1']) > 3)
            || ($this->_posDiff($highlightRect['y2'], $tableRect['y2']) > 3)
        ) {
            $this->fail('Highlight of table is not in the correct position');
        }

        // Check the highlight for row.
        $this->mouseMove($this->getImg('icon_tools_row.png'));
        usleep(200);

        // Note that +1 or -1 is for cellpadding.
        $highlightRect = $this->getBoundingRectangle('.ViperITP-highlight');
        if (($this->_posDiff($highlightRect['x1'], $tableRect['x1']) > 3)
            || ($this->_posDiff($highlightRect['x2'], $tableRect['x2']) > 3)
            || ($this->_posDiff($highlightRect['y1'], $cellRect['y1']) > 3)
            || ($this->_posDiff($highlightRect['y2'], $cellRect['y2']) > 3)
        ) {
            $this->fail('Highlight of row is not in the correct position');
        }

        // Check the highlight for cell.
        $this->mouseMove($this->getImg('icon_tools_col.png'));
        usleep(200);

        $highlightRect = $this->getBoundingRectangle('.ViperITP-highlight');
        if (($this->_posDiff($highlightRect['x1'], $cellRect['x1']) > 3)
            || ($this->_posDiff($highlightRect['x2'], $cellRect['x2']) > 3)
            || ($this->_posDiff($highlightRect['y1'], $tableRect['y1']) > 3)
            || ($this->_posDiff($highlightRect['y2'], $tableRect['y2']) > 3)
        ) {
            $this->fail('Highlight of col is not in the correct position');
        }

        // Check the highlight for cell.
        $this->mouseMove($this->getImg('icon_tools_cell.png'));
        usleep(200);

        $highlightRect = $this->getBoundingRectangle('.ViperITP-highlight');
        if (($this->_posDiff($highlightRect['x1'], $cellRect['x1']) > 3)
            || ($this->_posDiff($highlightRect['x2'], $cellRect['x2']) > 3)
            || ($this->_posDiff($highlightRect['y1'], $cellRect['y1']) > 3)
            || ($this->_posDiff($highlightRect['y2'], $cellRect['y2']) > 3)
        ) {
            $this->fail('Highlight of cell is not in the correct position');
        }

    }//end testTableEditingIconAndTools()


}//end class

?>
