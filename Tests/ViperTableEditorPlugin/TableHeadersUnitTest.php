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
        $this->assertHTMLMatch('<p>Test %1%</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

    }//end testHeaderTagsNotAddedWhenNoThCells()


    /**
     * Test that ids are added to the table when you create a table with a left heading column and are removed when you remove the heading column.
     *
     * @return void
     */
    public function testHeaderTagsForTableWithLeftColHeaders()
    {

        $this->insertTableWithSpecificId('test', 3, 4, 1, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1"></th><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><th id="testr2c1"></th><td headers="testr2c1"></td><td headers="testr2c1"></td><td headers="testr2c1"></td></tr><tr><th id="testr3c1"></th><td headers="testr3c1"></td><td headers="testr3c1"></td><td headers="testr3c1"></td></tr></tbody></table>');

        // Remove header column and check that ids are taken out
        $this->showTools(0, 'col');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

    }//end testHeaderTagsForTableWithLeftColHeaders()


   /**
     * Test that ids are added to the table when you create a table with top heading row and are removed when you remove the heading row.
     *
     * @return void
     */
    public function testHeaderTagsWithTopRowHeaders()
    {

        $this->insertTableWithSpecificId('test', 3, 4, 2, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr></thead><tbody><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table>');

         // Remove header row and check that ids are taken out
        $this->showTools(0, 'row');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

    }//end testHeaderTagsWithTopRowHeaders()


   /**
     * Test that ids are added to the table when you create a table with top and left headings and are removed when you remove the heading column and row.
     *
     * @return void
     */
    public function testHeaderTagsWithTopAndLeftHeaders()
    {

        $this->insertTableWithSpecificId('test', 3, 4, 3, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr></thead><tbody><tr><th id="testr2c1"></th><td headers="testr1c2 testr2c1"></td><td headers="testr1c3 testr2c1"></td><td headers="testr1c4 testr2c1"></td></tr><tr><th id="testr3c1"></th><td headers="testr1c2 testr3c1"></td><td headers="testr1c3 testr3c1"></td><td headers="testr1c4 testr3c1"></td></tr></tbody></table>');

        // Remove header row and check that ids are taken out
        $this->showTools(0, 'row');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><th id="testr2c1"></th><td headers="testr2c1"></td><td headers="testr2c1"></td><td headers="testr2c1"></td></tr><tr><th id="testr3c1"></th><td headers="testr3c1"></td><td headers="testr3c1"></td><td headers="testr3c1"></td></tr></tbody></table>');

        // Remove header column and check that ids are taken out
        $this->clickCell(9);
        $this->toggleCellHeading(8);
        $this->toggleCellHeading(4);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

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
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th colspan="4" id="testr1c1"></th></tr></thead><tbody><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr></tbody></table>');

        $this->clickCell(0);
        $this->showTools(NULL, 'col');
        $this->clickInlineToolbarButton('addRight');
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th colspan="4" id="testr1c1"></th><th id="testr1c2"></th></tr></thead><tbody><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c2"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c2"></td></tr></tbody></table>');

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

        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1" rowspan="3"></th><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr></tbody></table>');

        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('addBelow');
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1" rowspan="3"></th><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><th id="testr4c1"></th><td headers="testr4c1"></td><td headers="testr4c1"></td><td headers="testr4c1"></td></tr></tbody></table>');

    }//end testHeaderTagsWhenCreatingTableWithRowHeaders()


    /**
     * Test that id tags are added to the table when you apply a header row.
     *
     * @return void
     */
    public function testHeaderTagsAddedWhenHeaderRowAdded()
    {

        $this->insertTableWithSpecificId('test', 3, 4, 0, 1);

        $this->assertHTMLMatch('<p>Test %1%</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

        $this->showTools(0, 'row');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr></thead><tbody><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table>');

    }//end testHeaderTagsAddedWhenHeaderRowAdded()


    /**
     * Test that id tags are added to the table when you apply a header column.
     *
     * @return void
     */
    public function testHeaderTagsAddedWhenHeaderColAdded()
    {

        $this->insertTableWithSpecificId('test', 3, 4, 0, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

        $this->showTools(0, 'col');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1"></th><td headers="testr1c1"></td><td headers="testr1c1"></td><td headers="testr1c1"></td></tr><tr><th id="testr2c1"></th><td headers="testr2c1"></td><td headers="testr2c1"></td><td headers="testr2c1"></td></tr><tr><th id="testr3c1"></th><td headers="testr3c1"></td><td headers="testr3c1"></td><td headers="testr3c1"></td></tr></tbody></table>');

    }//end testHeaderTagsAddedWhenHeaderColAdded()


    /**
     * Test that header conversions and creations are done correctly.
     *
     * @return void
     */
    public function testRowHeaderConversion()
    {
        $results = array(
                    1  => '<p>Content for test %1%</p><table><thead><tr><th>%2%</th><th>test</th></tr></thead></table>',
                    2  => '<p>Content for test %1%</p><table><thead><tr><th>%2%</th><th>test</th></tr></thead></table>',
                    3  => '<p>Content for test %1%</p><table><thead><tr><th>%2%</th><th>test</th></tr></thead><tbody><tr><td colspan="2">test</td></tr></tbody></table>',
                    4  => '<p>Content for test %1%</p><table><tbody><tr><td colspan="2">test</td></tr><tr><th>%2%</th><th>test</th></tr></tbody></table>',
                    5  => '<p>Content for test %1%</p><table><thead><tr><td>test</td><td>test</td></tr><tr><th>%2%</th><th>test</th></tr></thead><tbody><tr><td colspan="2">test</td></tr></tbody></table>',
                    6  => '<p>Content for test %1%</p><table><thead><tr><td>test</td><td>test</td></tr></thead><tbody><tr><td colspan="2">test</td></tr><tr><th>%2%</th><th>test</th></tr></tbody></table>',
                    7  => '<p>Content for test %1%</p><table><tbody><tr><td>%2%</td><td>test</td></tr></tbody></table>',
                    8  => '<p>Content for test %1%</p><table><tbody><tr><td>%2%</td><td>test</td></tr></tbody></table>',
                    9  => '<p>Content for test %1%</p><table><tbody><tr><td>%2%</td><td>test</td></tr><tr><td colspan="2">test</td></tr></tbody></table>',
                    10 => '<p>Content for test %1%</p><table><tbody><tr><td colspan="2">test</td></tr><tr><td>%2%</td><td>test</td></tr></tbody></table>',
                    11 => '<p>Content for test %1%</p><table><thead><tr><td>test</td><td>test</td></tr></thead><tbody><tr><td>%2%</td><td>test</td></tr><tr><td colspan="2">test</td></tr></tbody></table>',
                    12 => '<p>Content for test %1%</p><table><thead><tr><td>test</td><td>test</td></tr></thead><tbody><tr><td colspan="2">test</td></tr><tr><td>%2%</td><td>test</td></tr></tbody></table>',
                    13 => '<p>Content for test %1%</p><table><thead><tr><td>%2%</td><td>test</td></tr><tr><th>test</th><th>test</th></tr></thead><tbody><tr><td colspan="2">test</td></tr></tbody></table>',
                    14 => '<p>Content for test %1%</p><table><thead><tr><th>test</th><th>test</th></tr></thead><tbody><tr><td>%2%</td><td>test</td></tr><tr><td colspan="2">test</td></tr></tbody></table>',
                    15 => '<p>Content for test %1%</p><table><thead><tr><th>test</th><th>test</th></tr></thead><tbody><tr><td>%2%</td><td>test</td></tr></tbody></table>',
                    16 => '<p>Content for test %1%</p><table><tbody><tr><td>%2%</td><td>test</td></tr></tbody></table>',
                    17 => '<p>Content for test %1%</p><table><tfoot><tr><td colspan="2">test</td></tr></tfoot><tbody><tr><td>%2%</td><td>test</td></tr></tbody></table>',
                    18 => '<p>Content for test %1%</p><table><thead><tr><th>test</th><th>test</th></tr></thead><tbody><tr><th>%2%</th><th rowspan="2">test</th></tr><tr><td>test</td></tr></tbody></table>',
                    19 => '<p>Content for test %1%</p><table><thead><tr><th>test</th><th>test</th></tr></thead><tbody><tr><th>test</th><th rowspan="2">%2%</th></tr><tr><td>test</td></tr></tbody></table>',
                    20 => '<p>Content for test %1%</p><table><thead><tr><th>test</th><th>test</th></tr><tr><th rowspan="2">test</th><th rowspan="2">%2%</th></tr></thead><tbody><tr><td>test</td><td>test</td></tr></tbody></table>',
                   );

        $testCount = count($results);
        for ($i = 1; $i <= $testCount; $i++) {
            $this->useTest($i);
            $this->clickKeyword(1);
            $this->sikuli->click($this->findKeyword(2));
            $this->sikuli->click($this->findKeyword(2));
            $this->showTools(NULL, 'row');
            $this->clickField('Heading');
            $this->sikuli->keyDown('Key.ENTER');

            $this->assertHTMLMatchNoHeaders($results[$i], 'Test '.$i.' HTML check has failed');
        }

    }//end testRowHeaderConversion()


}//end class

?>
