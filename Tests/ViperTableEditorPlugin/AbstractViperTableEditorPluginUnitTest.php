<?php
require_once 'AbstractViperUnitTest.php';


/**
 * An abstract class that all Table unit tests must extend.
 */
abstract class AbstractViperTableEditorPluginUnitTest extends AbstractViperUnitTest
{


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
        $cellRect = $this->getBoundingRectangle('td', $cellNum);
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

        $icon = $this->find($this->getImg('icon_tableEditor.png'), NULL, 0.9);
        // Move mouse on top of the icon.
        $this->mouseMove($icon);
        usleep(100);

        // Check the highlight for row.
        $icon = $this->find($this->getImg('icon_tools_'.$type.'.png'));
        $this->mouseMove($icon);
        usleep(200);

        $this->click($icon);

    }//end showRowTools()


    /**
     * Returns the table structure.
     *
     * @param integer $index The table index on the page.
     *
     * @return array
     */
    protected function getTableStructure($index=0)
    {
        return $this->execJS('gTS('.$index.')');

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
            }//end foreach
        }//end foreach

    }//end assertTableStructure()


}//end class

?>
