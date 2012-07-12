<?php
require_once 'AbstractViperUnitTest.php';


/**
 * An abstract class that all Table unit tests must extend.
 */
abstract class AbstractViperTableEditorPluginUnitTest extends AbstractViperUnitTest
{

    /**
     * Creates a blank table with the default (top) headers.
     *
     * @param integer $rows Number of rows.
     * @param integer $cols Number of columns.
     *
     * @return void
     */
    protected function insertTable($rows=NULL, $cols=NULL)
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->clickTopToolbarButton('table');

        if ($rows !== NULL && $cols !== NULL) {
            if ($rows > 10 || $cols > 10) {
                throw new Exception('insertTable(rows, cols) only support maximum of 10x10 table');
            }

            $cellCount = $cols;
            if ($rows > 1) {
                $cellCount += (($rows - 1) * 10);
            }

            $this->clickElement('.Viper-sizePicker td', $cellCount);
        }

        $this->clickButton('Insert Table', NULL, TRUE);

    }//end insertTable()


    /**
     * Creates a blank table with no headers.
     *
     * @return void
     */
    protected function insertTableWithNoHeaders()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->clickTopToolbarButton('table');

        $this->clickElement('.VTEP-bubble-headerTitle', 0);
        $this->clickButton('Insert Table', NULL, TRUE);

    }//end insertTableWithNoHeaders()


    /**
     * Creates a blank table with left headers.
     *
     * @return void
     */
    protected function insertTableWithLeftHeaders()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->clickTopToolbarButton('table');

        $this->clickElement('.VTEP-bubble-headerTitle', 1);
        $this->clickButton('Insert Table', NULL, TRUE);

    }//end insertTableWithLeftHeaders()


    /**
     * Creates a blank table with both headers.
     *
     * @return void
     */
    protected function insertTableWithBothHeaders()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->clickTopToolbarButton('table');

        $this->clickElement('.VTEP-bubble-headerTitle', 3);
        $this->clickButton('Insert Table', NULL, TRUE);

    }//end insertTableWithBothHeaders()


    /**
     * Clicks inside the specified cell.
     *
     * @param integer $cellNum The cell to click.
     *
     * @return void
     */
    protected function clickCell($cellNum)
    {
        $cellRect = $this->getBoundingRectangle('td,th', $cellNum);
        $region   = $this->getRegionOnPage($cellRect);

        // Click inside the cell.
        $this->click($region);

    }//end clickCell()


    /**
     * Shows the specified tools for the given cell.
     *
     * @param integer $cellNum The cell to click.
     * @param string  $type    The type of the tools, table, row, col, or cell.
     *
     * @return void
     */
    protected function showTools($cellNum, $type)
    {
        $this->clickCell($cellNum);
        usleep(100);

        $toolIconRect = $this->getBoundingRectangle('#test-ViperTEP', 0);
        $region       = $this->getRegionOnPage($toolIconRect);

        // Move mouse on top of the icon.
        $this->mouseMove($region);
        usleep(100);

        if ($type === 'table') {
            $type = '';
        }

        // Check the highlight for row.
        $this->clickButton('table'.ucFirst($type));

    }//end showRowTools()


    /**
     * Returns the rectangle of the last cell highlight.
     *
     * @return array
     */
    protected function getCellHighlight()
    {
        return $this->execJS('window.opener.gTblH()');

    }//end getCellHighlight()


    /**
     * Returns the match object of the specified table tools button.
     *
     * @param string  $type The type of the tools, table, row, col, or cell.
     *
     * @return string
     */
    protected function getToolsButton($type)
    {
        if ($type === 'table') {
            $type = '';
        }

        return $this->findButton('table'.ucFirst($type));

    }//end getToolsButton()


    /**
     * Clicks the given merge/split button in inline table toolbar.
     *
     * @param string $icon The icon to click.
     *
     * @return void
     */
    protected function clickMergeSplitIcon($icon)
    {
        $this->clickInlineToolbarButton('splitMerge');
        //$this->mouseMoveOffset(-50, -50);
        $this->clickInlineToolbarButton($icon);

    }//end clickMergeSplitIcon()


    /**
     * Toggle's the cell heading option.
     *
     * @param int $cellNum The number of the cell to toggle the heading for
     *
     * @return void
     */
    protected function toggleCellHeading($cellNum)
    {
        $this->showTools($cellNum, 'cell');
        $this->clickField('Heading');
        $this->keyDown('Key.ENTER');

    }//end toggleCellHeading()


    /**
     * Checks that the icon statuses are correct.
     *
     * @param boolean $splitVert  The status of the split vertical button.
     * @param boolean $splitHoriz The status of the split horizontal button.
     * @param boolean $mergeUp    The status of the merge up button.
     * @param boolean $mergeDown  The status of the merge down button.
     * @param boolean $mergeLeft  The status of the merge left button.
     * @param boolean $mergeRight The status of the merge right button.
     *
     * @return void
     */
    protected function assertIconStatusesCorrect(
        $splitVert,
        $splitHoriz,
        $mergeUp,
        $mergeDown,
        $mergeLeft,
        $mergeRight
    ) {
        $icons = array(
                  'splitV',
                  'splitH',
                  'mergeUp',
                  'mergeDown',
                  'mergeLeft',
                  'mergeRight',
                 );

        $statuses = $this->execJS('gTblBStatus()');

        foreach ($statuses as $btn => $status) {
            if ($status === TRUE && $$btn === FALSE) {
                $this->fail('Expected '.$btn.' button to be disabled.');
            } else if ($status === FALSE && $$btn === TRUE) {
                $this->fail('Expected '.$btn.' button to be enabled.');
            }
        }

    }//end assertIconStatusesCorrect()


}//end class

?>
