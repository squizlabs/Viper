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
     * @param integer $keyword      The keyword to select in the content.
     * @param integer $rows         Number of rows.
     * @param integer $cols         Number of columns.
     * @param integer $headerType   The type of header to use when inserting the table.
     *
     * @return void
     */
    protected function insertTable($keyword, $headerType=2, $rows=NULL, $cols=NULL)
    {
        $this->selectKeyword($keyword);
        $this->keyDown('Key.RIGHT');
        $this->clickTopToolbarButton('table');

        if ($rows !== NULL && $cols !== NULL) {
            if ($rows > 6 || $cols > 8) {
                throw new Exception('insertTable(rows, cols) only support maximum of 10x10 table');
            }

            $cellCount = $cols - 1;
            if ($rows > 1) {
                $cellCount += (($rows - 1) * 8);
            }

            $this->clickElement('.Viper-sizePicker td', $cellCount);
        }

        $this->clickElement('.VTEP-bubble-headerTitle', $headerType);
        $this->clickButton('Insert Table', NULL, TRUE);

    }//end insertTable()


    /**
     * Creates a table with a specific id. If nothing is passed in the default table will be created with the id of test.
     *
     * @param string    $id         The id of the new table.
     * @param integer   $rows       Number of rows.
     * @param integer   $cols       Number of columns.
     * @param integer   $headerType The type of headers to use when creating the table.
     * @param integer   $keyword    The keyword to select in the content
     *
     * @return void
     */
    protected function insertTableWithSpecificId($id, $rows, $cols, $headerType, $keyword)
    {
        $this->selectKeyword($keyword);
        $this->keyDown('Key.RIGHT');
        $this->execJS('insTable('.$rows.', '.$cols.', '.$headerType.', "'.$id.'")');

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
     * @param integer $cellNum The cell to click, NULL for the active cell.
     * @param string  $type    The type of the tools, table, row, col, or cell.
     *
     * @return void
     */
    protected function showTools($cellNum, $type)
    {
        if ($cellNum !== NULL) {
            $this->clickCell($cellNum);
        }

        usleep(60000);

        $region = NULL;
        try {
            $region = $this->findImage('ViperTableTools', '#test-ViperTEP');
        } catch (Exception $e) {
            $toolIconRect = $this->getBoundingRectangle('#test-ViperTEP', 0);
            $region       = $this->getRegionOnPage($toolIconRect);
        }

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
        return $this->execJS('viperTest.getWindow().gTblH()');

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
        if ($this->inlineToolbarButtonExists('splitMerge')) {
            $this->clickInlineToolbarButton('splitMerge');
        }

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
     * Checks that the expected html matches the actual html after removing the header tags from the table.
     *
     * @param string $html The expected HTML.
     * @param string $msg  The error message to print.
     *
     * @return void
     */
    protected function assertTableWithoutHeaders($html, $msg=NULL)
    {
        $this->assertHTMLMatchNoHeaders($html, $msg);

    }//end assertTableWithoutHeaders()


    /**
     * Checks that the merge and split icon statuses are correct.
     *
     * @param int     $cell       The cell to check the icons for.
     * @param boolean $splitVert  The status of the split vertical button.
     * @param boolean $splitHoriz The status of the split horizontal button.
     * @param boolean $mergeUp    The status of the merge up button.
     * @param boolean $mergeDown  The status of the merge down button.
     * @param boolean $mergeLeft  The status of the merge left button.
     * @param boolean $mergeRight The status of the merge right button.
     *
     * @return void
     */
    protected function assertMergeAndSplitIconStatuses(
        $cell,
        $splitVert,
        $splitHoriz,
        $mergeUp,
        $mergeDown,
        $mergeLeft,
        $mergeRight
    ) {

        $this->showTools($cell, 'cell');
        $this->clickInlineToolbarButton('splitMerge');

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
