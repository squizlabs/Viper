<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithTablesUnitTest extends AbstractViperTableEditorPluginUnitTest
{
	/**
     * Test creating a table with a blank block tag
     *
     * @return void
     */
    public function testDivBlockTagAddingATableInsideBlankBlockTag()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
        $this->insertTable(1, 0);
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table style="width: 100%;" border="1"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><div> %2% some content</div>');

    }//end testDivBlockTagAddingATableInsideBlankBlockTag()


    /**
     * Test deleting a table with a blank block tag
     *
     * @return void
     */
    public function testDivBlockTagDeletingATableInsideBlankBlockTag()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        $this->useTest(3);
        $this->moveToKeyword(1, 'right');
        $this->showTools(0, 'table');
        $this->clickInlineToolbarButton('delete');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><div> %2% some content</div>');

    }//end testDivBlockTagDeletingATableInsideBlankBlockTag()


    /**
     * Test editing a cell within a table with a blank block tag
     *
     * @return void
     */
    public function testDivBlockTagEditingATableCellInsideBlankBlockTag()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test editing first cell
        $this->useTest(4);
        $this->clickCell(0);
        $this->type(' modified');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1 modified</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test editing a middle cell
        $this->useTest(4);
        $this->clickCell(6);
        $this->type(' modified');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2 modified</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test editing last cell
        $this->useTest(4);
        $this->clickCell(11);
        $this->type(' modified');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3 modified</td></tr></tbody></table><div> %2% some content</div>');

    }//end testDivBlockTagEditingATableCellInsideBlankBlockTag()


    /**
     * Test adding columns to a table with a blank block tag
     *
     * @return void
     */
    public function testDivBlockTagAddingTableColumnsInsideBlankBlockTag()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test far left column
        // Test adding column to left
        $this->useTest(4);
        $this->showTools(0, 'col');
        $this->clickInlineToolbarButton('addLeft');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td></td><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test adding column to right
        $this->useTest(4);
        $this->showTools(0, 'col');
        $this->clickInlineToolbarButton('addRight');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test a middle column
        // Test adding column to left
        $this->useTest(4);
        $this->showTools(6, 'col');
        $this->clickInlineToolbarButton('addLeft');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test adding column to right
        $this->useTest(4);
        $this->showTools(6, 'col');
        $this->clickInlineToolbarButton('addRight');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test far right column
        // Test adding column to left
        $this->useTest(4);
        $this->showTools(11, 'col');
        $this->clickInlineToolbarButton('addLeft');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test adding column to right
        $this->useTest(4);
        $this->showTools(11, 'col');
        $this->clickInlineToolbarButton('addRight');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td><td></td></tr></tbody></table><div> %2% some content</div>');

    }//end testDivBlockTagAddingTableColumnsInsideBlankBlockTag()


    /**
     * Test adding rows to a table with a blank block tag
     *
     * @return void
     */
    public function testDivBlockTagAddingTableRowsInsideBlankBlockTag()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test top row
        // Test adding row above
        $this->useTest(4);
        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('addAbove');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test adding row below
        $this->useTest(4);
        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('addBelow');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test a middle row
        // Test adding row above
        $this->useTest(4);
        $this->showTools(6, 'row');
        $this->clickInlineToolbarButton('addAbove');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test adding row below
        $this->useTest(4);
        $this->showTools(6, 'row');
        $this->clickInlineToolbarButton('addBelow');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test bottom row
        // Test adding row above
        $this->useTest(4);
        $this->showTools(11, 'row');
        $this->clickInlineToolbarButton('addAbove');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test adding row below
        $this->useTest(4);
        $this->showTools(11, 'row');
        $this->clickInlineToolbarButton('addBelow');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><div> %2% some content</div>');
        
    }//end testDivBlockTagAddingTableRowsInsideBlankBlockTag()


    /**
     * Test deleting columns and rows in tables with a blank block tag
     *
     * @return void
     */
    public function testDivBlockTagDeletingTableElementsInsideBlankBlockTag()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test columns
        // Test far left column
        $this->useTest(4);
        $this->showTools(0, 'col');
        $this->clickInlineToolbarButton('delete');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td></td><td></td><td></td></tr><tr><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test a middle column
        $this->useTest(4);
        $this->showTools(6, 'col');
        $this->clickInlineToolbarButton('delete');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td></tr><tr><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test far right column
        $this->useTest(4);
        $this->showTools(11, 'col');
        $this->clickInlineToolbarButton('delete');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td></tr><tr><td></td><td></td><td></td></tr></tbody></table><div> %2% some content</div>');

        // Test rows
        // Test top row
        $this->useTest(4);
        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('delete');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test a middle row
        $this->useTest(4);
        $this->showTools(6, 'row');
        $this->clickInlineToolbarButton('delete');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test bottom row
        $this->useTest(4);
        $this->showTools(11, 'row');
        $this->clickInlineToolbarButton('delete');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr></tbody></table><div> %2% some content</div>');

    }//end testDivBlockTagDeletingTableElementsInsideBlankBlockTag()


    /**
     * Test editing columns in a table with a blank block tag
     *
     * @return void
     */
    public function testDivBlockTagEditingTableColumnsInsideBlankBlockTag()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test far left column
        // Test merging right
        $this->useTest(4);
        $this->showTools(0, 'col');
        $this->clickInlineToolbarButton('mergeRight');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table style="width: 100%;" border="1"><tbody><tr><td></td><td>test cell-1</td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test merging left
        $this->showTools(1, 'col');
        $this->clickInlineToolbarButton('mergeLeft');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table style="width: 100%;" border="1"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test applying heading
        $this->showTools(0, 'col');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><th>test cell-1</th><td></td><td></td><td></td></tr><tr><th></th><td></td><td>test cell-2</td><td></td></tr><tr><th></th><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test a middle column
        // Test merging left
        $this->useTest(4);
        $this->showTools(6, 'col');
        $this->clickInlineToolbarButton('mergeLeft');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td>test cell-2</td><td></td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test merging right
        $this->showTools(5, 'col');
        $this->clickInlineToolbarButton('mergeRight');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table style="width: 100%;" border="1"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test applying heading
        $this->showTools(6, 'col');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><th></th><td></td></tr><tr><td></td><td></td><th>test cell-2</th><td></td></tr><tr><td></td><td></td><th></th><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test far right column
        // Test merging left
        $this->useTest(4);
        $this->showTools(11, 'col');
        $this->clickInlineToolbarButton('mergeLeft');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-2</td></tr><tr><td></td><td></td><td>test cell-3</td><td></td></tr></tbody></table><div> %2% some content</div>');

        // Test merging right
        $this->showTools(10, 'col');
        $this->clickInlineToolbarButton('mergeRight');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table style="width: 100%;" border="1"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test applying heading
        $this->showTools(11, 'col');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><th></th></tr><tr><td></td><td></td><td>test cell-2</td><th></th></tr><tr><td></td><td></td><td></td><th>test cell-3</th></tr></tbody></table><div> %2% some content</div>');

    }//end testDivBlockTagEditingTableColumnsInsideBlankBlockTag()


    /**
     * Test editing rows in a table with a blank block tag
     *
     * @return void
     */
    public function testDivBlockTagEditingTableRowsInsideBlankBlockTag()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test top row
        // Test merging down
        $this->useTest(4);
        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('mergeDown');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test merging up
        $this->showTools(5, 'row');
        $this->clickInlineToolbarButton('mergeUp');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table style="width: 100%;" border="1"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test applying heading
        $this->showTools(0, 'row');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><thead><tr><th>test cell-1</th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test a middle row
        // Test merging up
        $this->useTest(4);
        $this->showTools(6, 'row');
        $this->clickInlineToolbarButton('mergeUp');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test merging down
        $this->showTools(1, 'row');
        $this->clickInlineToolbarButton('mergeDown');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test applying heading
        $this->showTools(6, 'row');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><th></th><th></th><th>test cell-2</th><th></th></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test bottom row
        // Test merging up
        $this->useTest(4);
        $this->showTools(11, 'row');
        $this->clickInlineToolbarButton('mergeUp');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr></tbody></table><div> %2% some content</div>');

        // Test merging down
        $this->showTools(5, 'row');
        $this->clickInlineToolbarButton('mergeDown');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table style="width: 100%;" border="1"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test applying heading
        $this->showTools(11, 'row');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><th></th><th></th><th></th><th>test cell-3</th></tr></tbody></table><div> %2% some content</div>');

    }//end testDivBlockTagEditingTableRowsInsideBlankBlockTag()


    /**
     * Test editing the width of a column in a table with a blank block tag
     *
     * @return void
     */
    public function testDivBlockTagEditingTableColumnWidthInsideBlankBlockTag()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test far left column
        $this->useTest(4);
        $this->showTools(0, 'col');
        $this->clickField('Width');
        $this->type('50');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td style="width:50px;">test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test a middle column
        $this->useTest(4);
        $this->showTools(6, 'col');
        $this->clickField('Width');
        $this->type('50');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td style="width:50px;"></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test far right column
        $this->useTest(4);
        $this->showTools(11, 'col');
        $this->clickField('Width');
        $this->type('50');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td style="width:50px;"></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

    }//end testDivBlockTagEditingTableColumnWidthInsideBlankBlockTag()


    /**
     * Test adding classes to different parts of a table with a blank block tag
     *
     * @return void
     */
    public function testDivBlockTagAddingClassesToTablesInsideBlankBlockTag()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test single cell
        $this->useTest(4);
        $this->showTools(0, 'cell');
        $this->clickInlineToolbarButton('cssClass');
        $this->type('cell test-class');
        $this->sikuli->keyDown('Key.ENTER');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr><td class="cell test-class">test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test row
        $this->useTest(4);
        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('cssClass');
        $this->type('row test-class');
        $this->sikuli->keyDown('Key.ENTER');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" style="width:100%;"><tbody><tr class="row test-class"><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

        // Test table
        $this->useTest(4);
        $this->showTools(0, 'table');
        $this->clickInlineToolbarButton('cssClass');
        $this->type('table test-class');
        $this->sikuli->keyDown('Key.ENTER');
//        $this->assertHTMLMatchNoHeaders('<div>This is %1%</div><table border="1" class="table test-class" style="width:100%;"><tbody><tr><td>test cell-1</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td>test cell-2</td><td></td></tr><tr><td></td><td></td><td></td><td>test cell-3</td></tr></tbody></table><div> %2% some content</div>');

    }//end testDivBlockTagAddingClassesToTablesInsideBlankBlockTag()

}//end class