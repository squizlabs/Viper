<?php
require_once 'AbstractViperUnitTest.php';


/**
 * An abstract class that all Table unit tests must extend.
 */
abstract class AbstractViperTableEditorPluginUnitTest extends AbstractViperUnitTest
{

    /**
     * Creates a blank 3x3 table.
     *
     * @return void
     */
    protected function insertTable($rows=3, $cols=3)
    {
        $this->selectText('IPSUM');
        $this->execJS('insTable('.$rows.','.$cols.')');

    }//end insertTable()


    /**
     * Returns the full path of the specified image file name.
     *
     * @param string $img The image file name.
     *
     * @return string
     */
    protected function getImg($img)
    {
        $path = dirname(__FILE__).'/Images/'.$img;
        return $path;

    }//end getImg()


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

        // Check the highlight for row.
        $icon = $this->find($this->getImg('icon_tools_'.$type.'.png'));
        $this->mouseMove($icon);
        usleep(200);

        $this->click($icon);

    }//end showRowTools()


    /**
     * Clicks the given merge/split button in inline table toolbar.
     *
     * @param string $icon The icon to click.
     *
     * @return void
     */
    protected function clickMergeSplitIcon($icon)
    {
        $this->clickInlineToolbarButton($this->getImg('icon_mergeSplit.png'));
        $this->mouseMove($this->createLocation(200, 200));
        $this->clickInlineToolbarButton($this->getImg($icon));

    }//end clickMergeSplitIcon()


    /**
     * Toggle's the cell heading option.
     *
     * @return void
     */
    protected function toggleCellHeading()
    {
        $toolIconRect = $this->getBoundingRectangle('.cellHeading', 0);
        $region       = $this->getRegionOnPage($toolIconRect);
        $this->click($region);

    }//end toggleCellHeading()


    /**
     * Returns the table structure.
     *
     * @param integer $index The table index on the page.
     *
     * @return array
     */
    protected function getTableStructure($index=0, $incContent=FALSE)
    {
        return $this->execJS('gTS('.$index.', '.((int) $incContent).')');

    }//end getTableStructure()


    /**
     * Asserts that the given table structures match.
     *
     * @param array $expected The expected table structure.
     * @param array $actual   The actual table structure.
     *
     * @return void
     */
    protected function assertTableStructure(array $expected, array $actual)
    {
        if (count($actual['rows']) !== count($expected)) {
            $this->fail('Expected '.count($expected).' rows but found '.count($actual['rows']));
        }

        foreach ($actual['rows'] as $r => $row) {
            if (count($row['cells']) !== count($expected[$r])) {
                $this->fail('Expected '.count($expected[$r]).' columns in row '.$r.' but found '.count($row['cells']));
            }

            foreach ($row['cells'] as $c => $cell) {
                if (is_array($expected[$r][$c]) === FALSE) {
                    $this->fail('Expected table does not have ['.$r.', '.$c.']');
                }

                // Row and colspan.
                if ($cell['rowspan'] !== 0) {
                    // Rowspan is not 0, expected array must have the same value.
                    if (isset($expected[$r][$c]['rowspan']) !== TRUE) {
                        $this->fail('Expected rowspan=1 but found '.$cell['rowspan'].' on ['.$r.', '.$c.']');
                    } else if ((int) $expected[$r][$c]['rowspan'] !== (int) $cell['rowspan']) {
                        $this->fail('Expected rowspan='.$expected[$r][$c]['rowspan'].' but found '.$cell['rowspan'].' on ['.$r.', '.$c.']');
                    }
                } else if (isset($expected[$r][$c]['rowspan']) === TRUE) {
                    $this->fail('Expected rowspan='.$expected[$r][$c]['rowspan'].' but found rowspan=1 on ['.$r.', '.$c.']');
                }

                if ($cell['colspan'] !== 0) {
                    // Rowspan is not 0, expected array must have the same value.
                    if (isset($expected[$r][$c]['colspan']) !== TRUE) {
                        $this->fail('Expected colspan=1 but found '.$cell['colspan'].' on ['.$r.', '.$c.']');
                    } else if ((int) $expected[$r][$c]['colspan'] !== (int) $cell['colspan']) {
                        $this->fail('Expected colspan='.$expected[$r][$c]['colspan'].' but found '.$cell['colspan'].' on ['.$r.', '.$c.']');
                    }
                } else if (isset($expected[$r][$c]['colspan']) === TRUE) {
                    $this->fail('Expected colspan='.$expected[$r][$c]['colspan'].' but found colspan=1 on ['.$r.', '.$c.']');
                }

                if (isset($cell['heading']) === FALSE
                    && isset($expected[$r][$c]['heading']) === TRUE
                    && $expected[$r][$c]['heading'] === TRUE
                ) {
                    $this->fail('Expected ['.$r.', '.$c.'] to be a heading cell');
                } else if (isset($cell['heading']) === TRUE
                    && $cell['heading'] === TRUE
                    && isset($expected[$r][$c]['heading']) === FALSE
                ) {
                    $this->fail('Expected ['.$r.', '.$c.'] to be a normal cell but it was a heading cell');
                }

                if (isset($cell['content']) === TRUE
                    || isset($expected[$r][$c]['content']) === TRUE
                ) {
                    // First remove the great Firefox br tag from the end...
                    $cell['content'] = str_replace('<br>', '', $cell['content']);

                    // Convert all nbsp; in both to space.
                    $cell['content'] = str_replace('&nbsp;', ' ', $cell['content']);
                    $expected[$r][$c]['content'] = str_replace('&nbsp;', ' ', $expected[$r][$c]['content']);

                    $this->assertEquals($expected[$r][$c]['content'], $cell['content'], 'Content of cell ['.$c.', '.$c.'] did not match');
                }

            }//end foreach
        }//end foreach

    }//end assertTableStructure()


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
