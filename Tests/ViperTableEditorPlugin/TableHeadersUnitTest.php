<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_TableHeadersUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Test that header and id tags are not added to the table when you have no th cells.
     *
     * @return void
     */
    public function testHeaderTagsNotAddedWhenNoThCells()
    {

        $this->insertTableWithSpecificId('test', 3, 4, 0, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testHeaderTagsNotAddedWhenNoThCells()


    /**
     * Test that ids are added to the table when you create a table with a left heading column and are removed when you remove the heading column.
     *
     * @return void
     */
    public function testHeaderTagsForTableWithLeftColHeaders()
    {

        $this->insertTableWithSpecificId('test', 3, 4, 1, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1"></th><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><th id="testr2c1"></th><td headers="testr2c1"></td><td headers="testr2c1"></td><td headers="testr2c1"></td></tr><tr><th id="testr3c1"></th><td headers="testr3c1"></td><td headers="testr3c1"></td><td headers="testr3c1"></td></tr></tbody></table><p></p>');

        // Remove header column and check that ids are taken out
        $this->showTools(0, 'col');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testHeaderTagsForTableWithLeftColHeaders()


   /**
     * Test that ids are added to the table when you create a table with top heading row and are removed when you remove the heading row.
     *
     * @return void
     */
    public function testHeaderTagsWithTopRowHeaders()
    {

        $this->insertTableWithSpecificId('test', 3, 4, 2, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table><p></p>');

         // Remove header row and check that ids are taken out
        $this->showTools(0, 'row');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testHeaderTagsWithTopRowHeaders()


   /**
     * Test that ids are added to the table when you create a table with top and left headings and are removed when you remove the heading column and row.
     *
     * @return void
     */
    public function testHeaderTagsWithTopAndLeftHeaders()
    {

        $this->insertTableWithSpecificId('test', 3, 4, 3, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr><tr><th id="testr2c1"></th><td headers="testr1c2 testr2c1"></td><td headers="testr1c3 testr2c1"></td><td headers="testr1c4 testr2c1"></td></tr><tr><th id="testr3c1"></th><td headers="testr1c2 testr3c1"></td><td headers="testr1c3 testr3c1"></td><td headers="testr1c4 testr3c1"></td></tr></tbody></table><p></p>');

        // Remove header row and check that ids are taken out
        $this->showTools(0, 'row');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><th id="testr2c1"></th><td headers="testr2c1"></td><td headers="testr2c1"></td><td headers="testr2c1"></td></tr><tr><th id="testr3c1"></th><td headers="testr3c1"></td><td headers="testr3c1"></td><td headers="testr3c1"></td></tr></tbody></table><p></p>');

        // Remove header column and check that ids are taken out
        $this->clickCell(3);
        $this->toggleCellHeading(8);
        $this->toggleCellHeading(4);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testHeaderTagsWithTopAndLeftHeaders()


   /**
     * Test that merging all header cells in the top row causes the id of the cell to be updated.
     *
     * @return void
     */
    public function testHeaderTagsWhenMergingTopRowCells()
    {

        $this->insertTableWithSpecificId('test', 3, 4, 2, 1);

        $this->showTools(1, 'cell');
        $this->clickMergeSplitIcon('mergeLeft');
        $this->clickMergeSplitIcon('mergeRight');
        $this->clickMergeSplitIcon('mergeRight');
        $this->assertHTMLMatch('<p>Test %1%</p><table id="test" style="width: 100%;" border="1"><tbody><tr><th id="testr1c1" colspan="4"></th></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr></tbody></table><p></p>');

        $this->clickCell(4);
        $this->showTools(0, 'col');
        $this->clickInlineToolbarButton('addRight');
        $this->assertHTMLMatch('<p>Test %1%</p><table id="test" style="width: 100%;" border="1"><tbody><tr><th id="testr1c1" colspan="4"></th><th id="testr1c2"></th></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c2"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c2"></td></tr></tbody></table><p></p>');

    }//end testHeaderTagsWhenCreatingTableWithRowHeaders()


   /**
     * Test that merging all header cells in the top row causes the id of the cell to be updated.
     *
     * @return void
     */
    public function testHeaderTagsWhenMergingLeftColCells()
    {

        $this->insertTableWithSpecificId('test', 3, 4, 1, 1);

        $this->showTools(4, 'cell');
        $this->clickMergeSplitIcon('mergeUp');
        $this->clickMergeSplitIcon('mergeDown');

        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1" rowspan="3"></th><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr></tbody></table><p></p>');

        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('addBelow');
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1" rowspan="3"></th><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><th id="testr4c1"></th><td headers="testr4c1"></td><td headers="testr4c1"></td><td headers="testr4c1"></td></tr></tbody></table><p></p>');

    }//end testHeaderTagsWhenCreatingTableWithRowHeaders()


    /**
     * Test that id tags are added to the table when you apply a header row.
     *
     * @return void
     */
    public function testHeaderTagsAddedWhenHeaderRowAdded()
    {

        $this->insertTableWithSpecificId('test', 3, 4, 0, 1);

        $this->assertHTMLMatch('<p>Test %1%</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(0, 'row');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Test %1%</p><table id="test" style="width: 100%;" border="1"><tbody><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table><p></p>');

    }//end testHeaderTagsAddedWhenHeaderRowAdded()


    /**
     * Test that id tags are added to the table when you apply a header column.
     *
     * @return void
     */
    public function testHeaderTagsAddedWhenHeaderColAdded()
    {

        $this->insertTableWithSpecificId('test', 3, 4, 0, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(0, 'col');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1"></th><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><th id="testr2c1"></th><td headers="testr2c1"></td><td headers="testr2c1"></td><td headers="testr2c1"></td></tr><tr><th id="testr3c1"></th><td headers="testr3c1"></td><td headers="testr3c1"></td><td headers="testr3c1"></td></tr></tbody></table><p></p>');

    }//end testHeaderTagsAddedWhenHeaderColAdded()


    /**
     * Test that header conversions and creations are done correctly.
     *
     * @return void
     */
    public function testRowHeaderConversion()
    {
        $results = array(
                    1  => '<table><thead><tr><th>%1%</th><th>test</th></tr></thead></table>',
                    2  => '<table><thead><tr><th>%1%</th><th>test</th></tr></thead></table>',
                    3  => '<table><thead><tr><th>%1%</th><th>test</th></tr></thead><tbody><tr><td colspan="2">test</td></tr></tbody></table>',
                    4  => '<table><tbody><tr><td colspan="2">test</td></tr><tr><th>%1%</th><th>test</th></tr></tbody></table>',
                    5  => '<table><thead><tr><td>test</td><td>test</td></tr><tr><th>%1%</th><th>test</th></tr></thead><tbody><tr><td colspan="2">test</td></tr></tbody></table>',
                    6  => '<table><thead><tr><td>test</td><td>test</td></tr></thead><tbody><tr><td colspan="2">test</td></tr><tr><th>%1%</th><th>test</th></tr></tbody></table>',
                    7  => '<table><tbody><tr><td>%1%</td><td>test</td></tr></tbody></table>',
                    8  => '<table><tbody><tr><td>%1%</td><td>test</td></tr></tbody></table>',
                    9  => '<table><tbody><tr><td>%1%</td><td>test</td></tr><tr><td colspan="2">test</td></tr></tbody></table>',
                    10 => '<table><tbody><tr><td colspan="2">test</td></tr><tr><td>%1%</td><td>test</td></tr></tbody></table>',
                    11 => '<table><thead><tr><td>test</td><td>test</td></tr></thead><tbody><tr><td>%1%</td><td>test</td></tr><tr><td colspan="2">test</td></tr></tbody></table>',
                    12 => '<table><thead><tr><td>test</td><td>test</td></tr></thead><tbody><tr><td colspan="2">test</td></tr><tr><td>%1%</td><td>test</td></tr></tbody></table>',
                    13 => '<table><thead><tr><td>%1%</td><td>test</td></tr><tr><th>test</th><th>test</th></tr></thead><tbody><tr><td colspan="2">test</td></tr></tbody></table>',
                    14 => '<table><thead><tr><th>test</th><th>test</th></tr></thead><tbody><tr><td>%1%</td><td>test</td></tr><tr><td colspan="2">test</td></tr></tbody></table>',
                    15 => '<table><thead><tr><th>test</th><th>test</th></tr></thead><tbody><tr><td>%1%</td><td>test</td></tr></tbody></table>',
                    16 => '<table><tbody><tr><td>%1%</td><td>test</td></tr></tbody></table>',
                    17 => '<table><tfoot><tr><td colspan="2">test</td></tr></tfoot><tbody><tr><td>%1%</td><td>test</td></tr></tbody></table>',
                    18 => '<table><thead><tr><th>test</th><th>test</th></tr></thead><tbody><tr><th>%1%</th><th rowspan="2">test</th></tr><tr><td>test</td></tr></tbody></table>',
                    19 => '<table><thead><tr><th>test</th><th>test</th></tr></thead><tbody><tr><th>test</th><th rowspan="2">%1%</th></tr><tr><td>test</td></tr></tbody></table>',
                    20 => '<table><thead><tr><th>test</th><th>test</th></tr><tr><th rowspan="2">test</th><th rowspan="2">%1%</th></tr></thead><tbody><tr><td>test</td><td>test</td></tr></tbody></table>',
                   );

        $testCount = count($results);
        for ($i = 1; $i <= $testCount; $i++) {
            $this->useTest($i);
            $this->click($this->findKeyword(1));
            $this->showTools(NULL, 'row');
            $this->clickField('Heading');
            $this->keyDown('Key.ENTER');

            $this->assertTableWithoutHeaders($results[$i], 'Test '.$i.' HTML check has failed');
        }

    }//end testRowHeaderConversion()


}//end class

?>
