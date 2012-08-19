<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_CreateTableUnitTest extends AbstractViperTableEditorPluginUnitTest
{


   /**
     * Test that creating a table without headers.
     *
     * @return void
     */
    public function testCreateTableWithoutHeaders()
    {
        $this->insertTable(1, 0);
        $this->assertTableWithoutHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->insertTable(1, 0, 5, 8);
        $this->assertTableWithoutHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p></p><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testCreateTableWithoutHeaders()


   /**
     * Test that creating a table with left headers.
     *
     * @return void
     */
    public function testCreateTableWithLeftHeaders()
    {
        $this->insertTable(1, 1);
        $this->assertTableWithoutHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->insertTable(1, 1, 4, 2);
        $this->assertTableWithoutHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><th></th><td></td></tr><tr><th></th><td></td></tr><tr><th></th><td></td></tr><tr><th></th><td></td></tr></tbody></table><p></p><table border="1" style="width: 100%;"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testCreateTableWithLeftHeaders()


    /**
     * Test that you can create the default table using the top toolbar.
     *
     * @return void
     */
    public function testCreateWithTopHeaders()
    {
        $this->insertTable(1);
        $this->assertTableWithoutHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->insertTable(1, 2, 4, 4);
        $this->assertTableWithoutHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testCreateDefaultTable()


   /**
     * Test that creating a table with both headers.
     *
     * @return void
     */
    public function testCreateTableWithBothHeaders()
    {
        $this->insertTable(1, 3);
        $this->assertTableWithoutHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->insertTable(1, 3, 7, 4);
        $this->assertTableWithoutHeaders('<p>Test XAX</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><p></p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end insertTableWithBothHeaders()


    /**
     * Test that creating a table works using the default header layout.
     *
     * @return void
     */
    public function testCreateTableStructure()
    {
        $this->insertTable(1);
        $this->clickCell(0);

        $this->type('One');
        $this->keyDown('Key.TAB');
        $this->type('Two');
        $this->keyDown('Key.TAB');
        $this->type('Three');
        $this->keyDown('Key.TAB');
        $this->type('Four');
        $this->keyDown('Key.TAB');
        $this->type('Five');
        $this->keyDown('Key.TAB');
        $this->type('Six');

        $this->showTools(0, 'cell');
        $this->clickMergeSplitIcon('mergeRight');

        $this->assertTableWithoutHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><th colspan="2">OneTwo</th><th>Three</th><th>Four</th></tr><tr><td>Five</td><td>Six</td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testCreateTableStructure()


    /**
     * Test that creating a table works.
     *
     * @return void
     */
    public function testCreateTableStructure2()
    {
        $this->insertTableWithSpecificId('test', 4, 5, 0, 1);

        $this->clickCell(0);
        $this->type('Survey');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->type('All Genders');
        $this->keyDown('Key.TAB');
        $this->type('By Gender');

        $this->showTools(0, 'cell');
        $this->clickMergeSplitIcon('mergeRight');
        $this->clickMergeSplitIcon('mergeDown');

        $this->showTools(1, 'cell');
        $this->clickMergeSplitIcon('mergeDown');

        // Click within the third cell of the first row (the one that has "By Gender").
        $this->showTools(2, 'cell');
        $this->clickMergeSplitIcon('mergeRight');

        $this->clickCell(2);
        $this->clickCell(3);
        $this->type('Males');
        $this->keyDown('Key.TAB');
        $this->type('Females');

        $this->keyDown('Key.TAB');
        $this->type('All Regions');
        $this->keyDown('Key.TAB');
        $this->type('North');
        $this->keyDown('Key.TAB');
        $this->type('3');
        $this->keyDown('Key.TAB');
        $this->type('1');
        $this->keyDown('Key.TAB');
        $this->type('2');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->type('South');
        $this->keyDown('Key.TAB');
        $this->type('3');
        $this->keyDown('Key.TAB');
        $this->type('1');
        $this->keyDown('Key.TAB');
        $this->type('2');

        $this->showTools(5, 'cell');
        $this->clickMergeSplitIcon('mergeDown');

        // Change the cells to heading cells.
        // Do it in reverse so the inline toolbar doesn't get in the way
        $this->toggleCellHeading(10);
        $this->toggleCellHeading(6);
        $this->toggleCellHeading(5);
        $this->toggleCellHeading(4);
        $this->toggleCellHeading(3);
        $this->toggleCellHeading(2);
        $this->toggleCellHeading(1);
        $this->toggleCellHeading(0);

        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th colspan="2" id="testr1c1" rowspan="2">Survey</th><th id="testr1c2" rowspan="2">All Genders</th><th colspan="2" id="testr1c3">By Gender</th></tr><tr><th id="testr2c1">Males</th><th id="testr2c2">Females</th></tr><tr><th id="testr3c1" rowspan="2">All Regions</th><th id="testr3c2">North</th><td headers="testr1c2 testr3c1 testr3c2">3</td><td headers="testr1c3 testr2c1 testr3c1 testr3c2">1</td><td headers="testr1c3 testr2c2 testr3c1 testr3c2">2</td></tr><tr><th id="testr4c1">South</th><td headers="testr1c2 testr3c1 testr4c1">3</td><td headers="testr1c3 testr2c1 testr3c1 testr4c1">1</td><td headers="testr1c3 testr2c2 testr3c1 testr4c1">2</td></tr></tbody></table><p></p>');

    }//end testCreateTableStructure2()


    /**
     * Tests that you cannot create tables in a list
     *
     * @return void
     */
    public function testCreateTableInList()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.TAB');

        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'), 'Create table icon should be disabled in the toolbar');

        $this->click($this->find(1));
        $this->assertTrue($this->topToolbarButtonExists('table'), 'Create table icon should be enabled in the toolbar');

    }//end testCreateTableInList()


    /**
     * Test that creating a table after selecting a whole paragraph works.
     *
     * @return void
     */
    public function testReplaceParagraphWithTable()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('table');
        $this->clickButton('Insert Table', NULL, TRUE);
        $this->assertTableWithoutHeaders('<p></p><table style="width: 100%;" border="1"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

    }//end testReplaceParagraphWithTable()


    /**
     * Test that creating a table after selecting a word works.
     *
     * @return void
     */
    public function testReplaceWordWithTable()
    {
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('table');
        $this->clickButton('Insert Table', NULL, TRUE);
        $this->assertTableWithoutHeaders('<p>Test</p><table style="width: 100%;" border="1"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testReplaceWordWithTable()


    /**
     * Test that creating you can create a table and then undo your changes.
     *
     * @return void
     */
    public function testCreatingTableThenClickingUndo()
    {
        $this->insertTable(1);
        $this->assertTableWithoutHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Create table icon should be active in the toolbar');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Test %1%</p>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'), 'Create table icon should be disabled in the toolbar');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Create table icon should be active in the toolbar');

    }//end testCreatingTableThenClickingUndo()


    /**
     * Test that you can replace a paragraph with a table and click undo.
     *
     * @return void
     */
    public function testReplacingParagraphWithTableThenClickingUndo()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('table');
        $this->clickButton('Insert Table', NULL, TRUE);
        $this->assertTableWithoutHeaders('<p></p><table style="width: 100%;" border="1"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Create table icon should be active in the toolbar');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Test %1%</p>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'), 'Create table icon should be disabled in the toolbar');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p></p><table style="width: 100%;" border="1"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Create table icon should be active in the toolbar');

    }//end testReplacingParagraphWithTableThenClickingUndo()


}//end class

?>
