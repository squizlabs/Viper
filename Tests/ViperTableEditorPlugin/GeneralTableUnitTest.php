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
     * Asserts that the highlight is in correct position.
     *
     * @param integer $actual   The highlight position.
     * @param integer $expected The expected position.
     * @param integer $maxDiff  The max difference between two positions.
     *
     * @return void
     */
    public function assertHighlightPos($actual, $expected, $maxDiff=3)
    {
        $diff = abs((int) ($actual - $expected));
        $this->assertTrue(($diff <= $maxDiff), 'Table highlight is not correct. Diff = '.$diff);

    }//end assertHighlightPos()


    /**
     * Test that you can open and close the table tools using the top toolbar.
     *
     * @return void
     */
    public function testUsingTableIconInTopToolbar()
    {
        $this->insertTable();

        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Create table should be active');

        $this->clickTopToolbarButton('table', 'active');

        // Check to make sure the table editing tools appear.
        $this->assertTrue($this->buttonExists('tableCell'), 'Table tools did not appear on screen');

        $this->clickTopToolbarButton('table', 'active');

        // Check to make sure the table editing tools don't appear.
        $this->assertFalse($this->buttonExists('tableCell'), 'The table icons should no longer appear on the screen');

    }//end testUsingTableIconInTopToolbar()


    /**
     * Test that the HR icon is not available for a %2% and table.
     *
     * @return void
     */
    public function testHRIconNotAvailableForCaptionAndTable()
    {
        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be active in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->click($this->findKeyword(3));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

    }//end testHRIconNotAvailableForCaptionAndTable()


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
        $this->assertTrue($this->buttonExists('tableCell'));

        // Check the highlight for table icon.
        $this->mouseMove($this->getToolsButton('table'));
        usleep(200);

        $highlightRect = $this->getCellHighlight();
        if (($this->_posDiff($highlightRect['x1'], $tableRect['x1']) > 3)
            || ($this->_posDiff($highlightRect['x2'], $tableRect['x2']) > 3)
            || ($this->_posDiff($highlightRect['y1'], $tableRect['y1']) > 3)
            || ($this->_posDiff($highlightRect['y2'], $tableRect['y2']) > 3)
        ) {
            $this->fail('Highlight of table is not in the correct position');
        }

        // Move mouse on top of the icon.
        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for row.
        $this->mouseMove($this->getToolsButton('row'));
        usleep(200);

        // Note that +1 or -1 is for cellpadding.
        $highlightRect = $this->getCellHighlight();
        if (($this->_posDiff($highlightRect['x1'], $tableRect['x1']) > 3)
            || ($this->_posDiff($highlightRect['x2'], $tableRect['x2']) > 3)
            || ($this->_posDiff($highlightRect['y1'], $cellRect['y1']) > 3)
            || ($this->_posDiff($highlightRect['y2'], $cellRect['y2']) > 3)
        ) {
            $this->fail('Highlight of row is not in the correct position');
        }

        // Move mouse on top of the icon.
        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for cell.
        $this->mouseMove($this->getToolsButton('col'));
        usleep(200);

        $highlightRect = $this->getCellHighlight();
        if (($this->_posDiff($highlightRect['x1'], $cellRect['x1']) > 3)
            || ($this->_posDiff($highlightRect['x2'], $cellRect['x2']) > 3)
            || ($this->_posDiff($highlightRect['y1'], $tableRect['y1']) > 3)
            || ($this->_posDiff($highlightRect['y2'], $tableRect['y2']) > 3)
        ) {
            $this->fail('Highlight of col is not in the correct position');
        }

        // Move mouse on top of the icon.
        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for cell.
        $this->mouseMove($this->getToolsButton('cell'));
        usleep(200);

        $highlightRect = $this->getCellHighlight();
        if (($this->_posDiff($highlightRect['x1'], $cellRect['x1']) > 3)
            || ($this->_posDiff($highlightRect['x2'], $cellRect['x2']) > 3)
            || ($this->_posDiff($highlightRect['y1'], $cellRect['y1']) > 3)
            || ($this->_posDiff($highlightRect['y2'], $cellRect['y2']) > 3)
        ) {
            $this->fail('Highlight of cell is not in the correct position');
        }

    }//end testTableEditingIconAndTools()


    /**
     * Tests that table highlights work in complex tables.
     *
     * Complex tables have tbody, thead, tfoot, %2%, cells with rowspan and colspan.
     *
     * @return void
     */
    public function testComplextTableHighlights2()
    {
        $table   = $this->getBoundingRectangle('table');
        $tbody   = $this->getBoundingRectangle('tbody');
        $tfoot   = $this->getBoundingRectangle('tfoot');
        $thead   = $this->getBoundingRectangle('thead');
        $caption = $this->getBoundingRectangle('caption');

        $firstCell = $this->getBoundingRectangle('th');

        // Test highlights in heading.
        $this->clickCell(0);

        $toolIconRect = $this->getBoundingRectangle('#test-ViperTEP', 0);
        $icon         = $this->getRegionOnPage($toolIconRect);

        // Move mouse on top of the icon.
        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for table.
        $this->mouseMove($this->getToolsButton('table'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $table['x1']);
        $this->assertHighlightPos($highlight['x2'], $table['x2']);
        $this->assertHighlightPos($highlight['y1'], $table['y1']);
        $this->assertHighlightPos($highlight['y2'], $tfoot['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for row.
        $this->mouseMove($this->getToolsButton('row'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $tbody['x1']);
        $this->assertHighlightPos($highlight['x2'], $tbody['x2']);
        $this->assertHighlightPos($highlight['y1'], $thead['y1']);
        $this->assertHighlightPos($highlight['y2'], $thead['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('col'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $firstCell['x1']);
        $this->assertHighlightPos($highlight['x2'], $firstCell['x2']);
        $this->assertHighlightPos($highlight['y1'], $thead['y1']);
        $this->assertHighlightPos($highlight['y2'], $tfoot['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('cell'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $firstCell['x1']);
        $this->assertHighlightPos($highlight['x2'], $firstCell['x2']);
        $this->assertHighlightPos($highlight['y1'], $firstCell['y1']);
        $this->assertHighlightPos($highlight['y2'], $firstCell['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Test highlights in a cell with colspan.
        $this->clickCell(8);
        $colspanCell = $this->getBoundingRectangle('td', 5);

        $toolIconRect = $this->getBoundingRectangle('#test-ViperTEP', 0);
        $icon         = $this->getRegionOnPage($toolIconRect);

        // Move mouse on top of the icon.
        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for table.
        $this->mouseMove($this->getToolsButton('table'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $table['x1']);
        $this->assertHighlightPos($highlight['x2'], $table['x2']);
        $this->assertHighlightPos($highlight['y1'], $caption['y1']);
        $this->assertHighlightPos($highlight['y2'], $tfoot['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for row.
        $this->mouseMove($this->getToolsButton('row'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $tbody['x1']);
        $this->assertHighlightPos($highlight['x2'], $tbody['x2']);
        $this->assertHighlightPos($highlight['y1'], $colspanCell['y1']);
        $this->assertHighlightPos($highlight['y2'], $colspanCell['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('col'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $colspanCell['x1']);
        $this->assertHighlightPos($highlight['x2'], $colspanCell['x2']);
        $this->assertHighlightPos($highlight['y1'], $thead['y1']);
        $this->assertHighlightPos($highlight['y2'], $tfoot['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('cell'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $colspanCell['x1']);
        $this->assertHighlightPos($highlight['x2'], $colspanCell['x2']);
        $this->assertHighlightPos($highlight['y1'], $colspanCell['y1']);
        $this->assertHighlightPos($highlight['y2'], $colspanCell['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Test highlights in a row with rowspan.
        $this->clickCell(11);
        $colspanCell = $this->getBoundingRectangle('td', 8);

        $toolIconRect = $this->getBoundingRectangle('#test-ViperTEP', 0);
        $icon         = $this->getRegionOnPage($toolIconRect);

        // Move mouse on top of the icon.
        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for table.
        $this->mouseMove($this->getToolsButton('table'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $table['x1']);
        $this->assertHighlightPos($highlight['x2'], $table['x2']);
        $this->assertHighlightPos($highlight['y1'], $caption['y1']);
        $this->assertHighlightPos($highlight['y2'], $tfoot['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for row.
        $this->mouseMove($this->getToolsButton('row'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $tbody['x1']);
        $this->assertHighlightPos($highlight['x2'], $tbody['x2']);
        $this->assertHighlightPos($highlight['y1'], $colspanCell['y1']);
        $this->assertHighlightPos($highlight['y2'], $colspanCell['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('col'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $colspanCell['x1']);
        $this->assertHighlightPos($highlight['x2'], $colspanCell['x2']);
        $this->assertHighlightPos($highlight['y1'], $thead['y1']);
        $this->assertHighlightPos($highlight['y2'], $tfoot['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('cell'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $colspanCell['x1']);
        $this->assertHighlightPos($highlight['x2'], $colspanCell['x2']);
        $this->assertHighlightPos($highlight['y1'], $colspanCell['y1']);
        $this->assertHighlightPos($highlight['y2'], $colspanCell['y2']);

        // Test highlights in footer.
        $this->clickCell(3);
        $colspanCell = $this->getBoundingRectangle('td', 0);

        $toolIconRect = $this->getBoundingRectangle('#test-ViperTEP', 0);
        $icon         = $this->getRegionOnPage($toolIconRect);

        // Move mouse on top of the icon.
        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for table.
        $this->mouseMove($this->getToolsButton('table'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $table['x1']);
        $this->assertHighlightPos($highlight['x2'], $table['x2']);
        $this->assertHighlightPos($highlight['y1'], $caption['y1']);
        $this->assertHighlightPos($highlight['y2'], $tfoot['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for row.
        $this->mouseMove($this->getToolsButton('row'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $tbody['x1']);
        $this->assertHighlightPos($highlight['x2'], $tbody['x2']);
        $this->assertHighlightPos($highlight['y1'], $colspanCell['y1']);
        $this->assertHighlightPos($highlight['y2'], $colspanCell['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('col'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $colspanCell['x1']);
        $this->assertHighlightPos($highlight['x2'], $colspanCell['x2']);
        $this->assertHighlightPos($highlight['y1'], $thead['y1']);
        $this->assertHighlightPos($highlight['y2'], $tfoot['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('cell'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $colspanCell['x1']);
        $this->assertHighlightPos($highlight['x2'], $colspanCell['x2']);
        $this->assertHighlightPos($highlight['y1'], $colspanCell['y1']);
        $this->assertHighlightPos($highlight['y2'], $colspanCell['y2']);

    }//end testComplextTableHighlights()


    /**
     * Tests that table highlights work in complex tables with no footer.
     *
     * @return void
     */
    public function testComplextTableHighlightsNoFooter()
    {
        $this->execJS('window.opener.dfx.remove(window.opener.dfx.getTag("tfoot"))');

        $table   = $this->getBoundingRectangle('table');
        $tbody   = $this->getBoundingRectangle('tbody');
        $thead   = $this->getBoundingRectangle('thead');
        $caption = $this->getBoundingRectangle('caption');

        $cell = $this->getBoundingRectangle('td', 4);
        sleep(1);

        // Test highlights in heading.
        $this->clickCell(7);

        $toolIconRect = $this->getBoundingRectangle('#test-ViperTEP', 0);
        $icon         = $this->getRegionOnPage($toolIconRect);

        // Move mouse on top of the icon.
        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for table.
        $this->mouseMove($this->getToolsButton('table'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $table['x1']);
        $this->assertHighlightPos($highlight['x2'], $table['x2']);
        $this->assertHighlightPos($highlight['y1'], $caption['y1']);
        $this->assertHighlightPos($highlight['y2'], $tbody['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for row.
        $this->mouseMove($this->getToolsButton('row'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $tbody['x1']);
        $this->assertHighlightPos($highlight['x2'], $tbody['x2']);
        $this->assertHighlightPos($highlight['y1'], $cell['y1']);
        $this->assertHighlightPos($highlight['y2'], $cell['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('col'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $cell['x1']);
        $this->assertHighlightPos($highlight['x2'], $cell['x2']);
        $this->assertHighlightPos($highlight['y1'], $thead['y1']);
        $this->assertHighlightPos($highlight['y2'], $tbody['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('cell'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $cell['x1']);
        $this->assertHighlightPos($highlight['x2'], $cell['x2']);
        $this->assertHighlightPos($highlight['y1'], $cell['y1']);
        $this->assertHighlightPos($highlight['y2'], $cell['y2']);

    }//end testComplextTableHighlightsNoFooter()


    /**
     * Tests that table highlights work in complex tables with no header.
     *
     * @return void
     */
    public function testComplextTableHighlightsNoHeader()
    {
        $this->execJS('window.opener.dfx.remove(window.opener.dfx.getTag("thead"))');

        $table   = $this->getBoundingRectangle('table');
        $tbody   = $this->getBoundingRectangle('tbody');
        $tfoot   = $this->getBoundingRectangle('tfoot');
        $caption = $this->getBoundingRectangle('caption');

        $cell = $this->getBoundingRectangle('td', 4);
        sleep(1);

        // Test highlights in heading.
        $this->clickCell(4);

        $toolIconRect = $this->getBoundingRectangle('#test-ViperTEP', 0);
        $icon         = $this->getRegionOnPage($toolIconRect);

        // Move mouse on top of the icon.
        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for table.
        $this->mouseMove($this->getToolsButton('table'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $table['x1']);
        $this->assertHighlightPos($highlight['x2'], $table['x2']);
        $this->assertHighlightPos($highlight['y1'], $caption['y1']);
        $this->assertHighlightPos($highlight['y2'], $tfoot['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for row.
        $this->mouseMove($this->getToolsButton('row'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $tbody['x1']);
        $this->assertHighlightPos($highlight['x2'], $tbody['x2']);
        $this->assertHighlightPos($highlight['y1'], $cell['y1']);
        $this->assertHighlightPos($highlight['y2'], $cell['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('col'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $cell['x1']);
        $this->assertHighlightPos($highlight['x2'], $cell['x2']);
        $this->assertHighlightPos($highlight['y1'], $tbody['y1']);
        $this->assertHighlightPos($highlight['y2'], $tfoot['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('cell'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $cell['x1']);
        $this->assertHighlightPos($highlight['x2'], $cell['x2']);
        $this->assertHighlightPos($highlight['y1'], $cell['y1']);
        $this->assertHighlightPos($highlight['y2'], $cell['y2']);

    }//end testComplextTableHighlightsNoHeader()


    /**
     * Tests that table highlights work in complex tables with no %2%.
     *
     * @return void
     */
    public function testComplextTableHighlightsNoCaption()
    {
        $this->execJS('window.opener.dfx.remove(window.opener.dfx.getTag("caption"))');

        $table   = $this->getBoundingRectangle('table');
        $tbody   = $this->getBoundingRectangle('tbody');
        $tfoot   = $this->getBoundingRectangle('tfoot');
        $thead   = $this->getBoundingRectangle('thead');

        $cell = $this->getBoundingRectangle('td', 4);
        sleep(1);

        // Test highlights in heading.
        $this->clickCell(7);

        $toolIconRect = $this->getBoundingRectangle('#test-ViperTEP', 0);
        $icon         = $this->getRegionOnPage($toolIconRect);

        // Move mouse on top of the icon.
        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for table.
        $this->mouseMove($this->getToolsButton('table'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $table['x1']);
        $this->assertHighlightPos($highlight['x2'], $table['x2']);
        $this->assertHighlightPos($highlight['y1'], $thead['y1']);
        $this->assertHighlightPos($highlight['y2'], $tfoot['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for row.
        $this->mouseMove($this->getToolsButton('row'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $tbody['x1']);
        $this->assertHighlightPos($highlight['x2'], $tbody['x2']);
        $this->assertHighlightPos($highlight['y1'], $cell['y1']);
        $this->assertHighlightPos($highlight['y2'], $cell['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('col'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $cell['x1']);
        $this->assertHighlightPos($highlight['x2'], $cell['x2']);
        $this->assertHighlightPos($highlight['y1'], $thead['y1']);
        $this->assertHighlightPos($highlight['y2'], $tfoot['y2']);

        $this->mouseMove($icon);
        usleep(200);

        // Check the highlight for col.
        $this->mouseMove($this->getToolsButton('cell'));
        usleep(200);
        $highlight = $this->getCellHighlight();
        $this->assertHighlightPos($highlight['x1'], $cell['x1']);
        $this->assertHighlightPos($highlight['x2'], $cell['x2']);
        $this->assertHighlightPos($highlight['y1'], $cell['y1']);
        $this->assertHighlightPos($highlight['y2'], $cell['y2']);

    }//end testComplextTableHighlightsNoCaption()


    /**
     * Test that table navigation (TAB) with keyboard works.
     *
     * @return void
     */
    public function testTableKeyboardNav()
    {
        $this->insertTable(2, 3);

        $this->clickCell(0);
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->type('2');
        $this->keyDown('Key.TAB');
        $this->type('3');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->type('1');

        usleep(500);
        $actual   = $this->getTableStructure(0, TRUE);
        $expected = array(
                     array(
                      array('content' => '&nbsp;'),
                      array('content' => '1 '),
                      array('content' => '2 '),
                     ),
                     array(
                      array('content' => '3 '),
                      array('content' => '&nbsp;'),
                      array('content' => '&nbsp;'),
                     ),
                    );
        $this->assertTableStructure($expected, $actual);

    }//end testTableKeyboardNav()


    /**
     * Test that table navigation (TAB) with keyboard works.
     *
     * @return void
     */
    public function testTableKeyboardNavWithRowNColSpan()
    {
        $this->insertTable(3, 3);
        $this->showTools(0, 'cell');
        $this->clickMergeSplitIcon('mergeDown');

        $this->showTools(3, 'cell');
        $this->clickMergeSplitIcon('mergeRight');

        $this->clickCell(0);

        // Make sure caret does not go out of table.
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');

        $this->type('2');
        $this->keyDown('Key.TAB');
        $this->type('3');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->type('1');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->type('5');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->type('4');

        usleep(500);
        $actual   = $this->getTableStructure(0, TRUE);
        $expected = array(
                     array(
                      array(
                       'rowspan' => 2,
                       'content' => '  ',
                      ),
                      array('content' => ' '),
                      array('content' => '1 '),
                     ),
                     array(
                      array(
                       'colspan' => 2,
                       'content' => '2  ',
                      ),
                     ),
                     array(
                      array('content' => '3 '),
                      array('content' => ' '),
                      array('content' => '4 '),
                     ),
                     array(
                      array('content' => '5 '),
                      array('content' => ' '),
                      array('content' => ' '),
                     ),
                    );
        $this->assertTableStructure($expected, $actual);

    }//end testTableKeyboardNavWithRowNColSpan()


    /**
     * Test that table is removed when its last row is deleted.
     *
     * @return void
     */
    public function testRemoveTableOnLastRowDelete()
    {
        $this->insertTable(2, 2);

        $this->showTools(0, 'row');
        $this->clickButton('delete');

        $this->showTools(0, 'row');
        $this->clickButton('delete');

        $actTagCounts = $this->execJS('gTagCounts("table")');
        $expected     = array('table' => 1);

        $this->assertEquals($expected, $actTagCounts, 'Table was not removed from the page after its last row was removed');

    }//end testRemoveTableOnLastRowDelete()


    /**
     * Test that table is removed when its last column is deleted.
     *
     * @return void
     */
    public function testRemoveTableOnLastColDelete()
    {
        $this->insertTable(2, 2);

        $this->showTools(0, 'col');
        $this->clickButton('delete');

        $this->showTools(0, 'col');
        $this->clickButton('delete');

        $actTagCounts = $this->execJS('gTagCounts("table")');
        $expected     = array('table' => 1);

        $this->assertEquals($expected, $actTagCounts, 'Table was not removed from the page after its last column was removed');

    }//end testRemoveTableOnLastColDelete()


    /**
     * Tests that right arrow moves caret out of table.
     *
     * @return void
     */
    public function testTableNavEndFromFooter()
    {
        $this->clickCell(3);
        $this->keyDown('Key.RIGHT');
        usleep(100);
        $this->keyDown('t');

        $html = $this->getHtml('p', 3);
        $this->assertEquals('&nbsp;t', $html);

    }//end testTableNavFooter()


    /**
     * Tests that inline toolbar stays open after row move operation.
     *
     * @return void
     */
    public function testInlineToolbarStaysOpenAfterMove()
    {
        $this->execJS('dfx.setHtml(dfx.getTag("td")[6], "&nbsp;")');

        $this->showTools(7, 'row');
        $this->clickInlineToolbarButton('mergeUp');

        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('delete'));

    }//end testInlineToolbarStaysOpenAfterMove()


}//end class

?>
