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
        $this->useTest(1);

        $this->moveToKeyword(1, 'right');

        $this->insertTable(1, 0);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

        $this->insertTable(1, 0, 5, 8);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

    }//end testCreateTableWithoutHeaders()


   /**
     * Test that creating a table with left headers.
     *
     * @return void
     */
    public function testCreateTableWithLeftHeaders()
    {
        $this->useTest(1);

        $this->insertTable(1, 1);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table>');

        $this->insertTable(1, 1, 4, 2);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><th></th><td></td></tr><tr><th></th><td></td></tr><tr><th></th><td></td></tr><tr><th></th><td></td></tr></tbody></table><table border="1" style="width: 100%;"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table>');

    }//end testCreateTableWithLeftHeaders()


    /**
     * Test that you can create the default table using the top toolbar.
     *
     * @return void
     */
    public function testCreateWithTopHeaders()
    {
        $this->useTest(1);

        $this->insertTable(1);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

        $this->insertTable(1, 2, 4, 4);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

    }//end testCreateDefaultTable()


   /**
     * Test that creating a table with both headers.
     *
     * @return void
     */
    public function testCreateTableWithBothHeaders()
    {
        $this->useTest(1);

        $this->insertTable(1, 3);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table>');

        $this->insertTable(1, 3, 6, 4);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table>');

    }//end insertTableWithBothHeaders()


    /**
     * Test that creating a table works using the default header layout.
     *
     * @return void
     */
    public function testCreateTableStructure()
    {
        $this->useTest(1);

        $this->insertTable(1);
        $this->clickCell(0);

        $this->type('One');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Two');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Three');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Four');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Five');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Six');

        $this->showTools(0, 'cell');
        $this->clickMergeSplitIcon('mergeRight');

        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th colspan="2">OneTwo</th><th>Three</th><th>Four</th></tr></thead><tbody><tr><td>Five</td><td>Six</td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

    }//end testCreateTableStructure()


    /**
     * Test that creating a table works.
     *
     * @return void
     */
    public function testCreateTableStructure2()
    {
        $this->useTest(1);

        $this->insertTableWithSpecificId('test', 4, 5, 0, 1);

        $this->clickCell(0);
        $this->type('Survey');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('All Genders');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('By Gender');

        $this->showTools(0, 'cell');
        $this->clickMergeSplitIcon('mergeRight');
        $this->clickMergeSplitIcon('mergeDown', FALSE);

        $this->showTools(1, 'cell');
        $this->clickMergeSplitIcon('mergeDown');

        // Click within the third cell of the first row (the one that has "By Gender").
        $this->showTools(2, 'cell');
        $this->clickMergeSplitIcon('mergeRight');

        $this->clickCell(2);
        $this->clickCell(3);
        $this->type('Males');
        sleep(1);
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
        $this->type('Females');

        $this->sikuli->keyDown('Key.TAB');
        $this->type('All Regions');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('North');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('3');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('1');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('2');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('South');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('3');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('1');
        $this->sikuli->keyDown('Key.TAB');
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

        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th colspan="2" id="testr1c1" rowspan="2">Survey</th><th id="testr1c2" rowspan="2">All Genders</th><th colspan="2" id="testr1c3">By Gender</th></tr><tr><th id="testr2c1">Males</th><th id="testr2c2">Females</th></tr><tr><th id="testr3c1" rowspan="2">All Regions</th><th id="testr3c2">North</th><td headers="testr1c2 testr3c1 testr3c2">3</td><td headers="testr1c3 testr2c1 testr3c1 testr3c2">1</td><td headers="testr1c3 testr2c2 testr3c1 testr3c2">2</td></tr><tr><th id="testr4c1">South</th><td headers="testr1c2 testr3c1 testr4c1">3</td><td headers="testr1c3 testr2c1 testr3c1 testr4c1">1</td><td headers="testr1c3 testr2c2 testr3c1 testr4c1">2</td></tr></tbody></table>');

    }//end testCreateTableStructure2()


    /**
     * Tests that you cannot create tables in a list
     *
     * @return void
     */
    public function testCreateTableInList()
    {
        $this->useTest(1);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.TAB');

        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'), 'Create table icon should be disabled in the toolbar');

        $this->sikuli->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'), 'Create table icon should be disabled in the toolbar');

    }//end testCreateTableInList()


    /**
     * Test that creating a table after selecting a whole paragraph works.
     *
     * @return void
     */
    public function testReplaceParagraphWithTable()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('table');
        $this->clickButton('Insert Table', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

    }//end testReplaceParagraphWithTable()


    /**
     * Test that creating a table after selecting a word works.
     *
     * @return void
     */
    public function testReplaceWordWithTable()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('table');
        $this->clickButton('Insert Table', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<p>Test</p><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

    }//end testReplaceWordWithTable()


    /**
     * Test that creating you can create a table and then undo your changes.
     *
     * @return void
     */
    public function testCreatingTableThenClickingUndo()
    {
        $this->useTest(1);

        $this->insertTable(1);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Create table icon should be active in the toolbar');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Test %1%</p>');
        $this->assertTrue($this->topToolbarButtonExists('table'), 'Create table icon should be enabled in the toolbar');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Create table icon should be active in the toolbar');

    }//end testCreatingTableThenClickingUndo()


    /**
     * Test that you can replace a paragraph with a table and click undo.
     *
     * @return void
     */
    public function testReplacingParagraphWithTableThenClickingUndo()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('table');
        $this->clickButton('Insert Table', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Create table icon should be active in the toolbar');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Test %1%</p>');
        $this->assertTrue($this->topToolbarButtonExists('table'), 'Create table icon should be enabled in the toolbar');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Create table icon should be active in the toolbar');

    }//end testReplacingParagraphWithTableThenClickingUndo()


    /**
     * Test that you can replace a paragraph with a table and click undo.
     *
     * @return void
     */
    public function testInsertTableAfterCuttingContent()
    {
        $this->useTest(2);

        $location = $this->findKeyword(1);
        // Cut the content from the page
        $this->selectKeyword(1, 2);
        $this->cut(TRUE);
        $this->sikuli->click($location);

        // Insert a new table
        $this->clickTopToolbarButton('table');
        $this->clickButton('Insert Table', NULL, TRUE);
        sleep(1);
        $this->assertHTMLMatchNoHeaders('<h1>Insert Table</h1><table border="1" style="width:100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p>Third paragraph</p>');

    }//end testInsertTableAfterCuttingContent()


    /**
     * Test creating table when page is zoomed.
     *
     * @return void
     */
    public function testCreateTableWithZoom()
    {
        $this->useTest(1);

        $this->moveToKeyword(1, 'right');

        // Zoom in.
        $this->sikuli->keyDown('Key.CMD + =');

        // Need to insert the table using JS calls due to zoom level increase causes issues with JS positioning.
        // TODO: most likely need to add scaling to JS location values etc. How do we solve scale issue for Sikuli?
        $this->sikuli->execJS('viper.ViperPluginManager.getPlugin("ViperTableEditorPlugin").insertTable(3, 4, 0)');

        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

        // Zoom out.
        $this->sikuli->keyDown('Key.CMD + 0');

        $this->moveToKeyword(1, 'right');

        // Zoom in.
        $this->sikuli->keyDown('Key.CMD + =');

        $this->sikuli->execJS('viper.ViperPluginManager.getPlugin("ViperTableEditorPlugin").insertTable(5, 8, 0)');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table>');

    }//end testCreateTableWithZoom()


}//end class

?>
