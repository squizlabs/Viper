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
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3,4, 0, "test")');
        sleep(2);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testHeaderTagsNotAddedWhenNoThCells()


    /**
     * Test that ids are added to the table when you create a table with a left heading column and are removed when you remove the heading column.
     *
     * @return void
     */
    public function testHeaderTagsForTableWithLeftColHeaders()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3,4, 1, "test")');
        sleep(2);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td></tr><tr><th id="testr2c1">&nbsp;</th><td headers="testr2c1">&nbsp;</td><td headers="testr2c1">&nbsp;</td><td headers="testr2c1">&nbsp;</td></tr><tr><th id="testr3c1">&nbsp;</th><td headers="testr3c1">&nbsp;</td><td headers="testr3c1">&nbsp;</td><td headers="testr3c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        // Remove header column and check that ids are taken out
        $this->showTools(0, 'col');
        $this->clickField('Heading');
        sleep(1);
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testHeaderTagsForTableWithLeftColHeaders()


   /**
     * Test that ids are added to the table when you create a table with top heading row and are removed when you remove the heading row.
     *
     * @return void
     */
    public function testHeaderTagsWithTopRowHeaders()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3,4, 2, "test")');
        sleep(2);

        $this->assertHTMLMatch('<p>XAX XBX XCX</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

         // Remove header row and check that ids are taken out
        $this->showTools(0, 'row');
        $this->clickField('Heading');
        sleep(1);
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>XAX XBX XCX</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testHeaderTagsWithTopRowHeaders()


   /**
     * Test that ids are added to the table when you create a table with top and left headings and are removed when you remove the heading column and row.
     *
     * @return void
     */
    public function testHeaderTagsWithTopAndLeftHeaders()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3,4, 3, "test")');
        sleep(2);

        $this->assertHTMLMatch('<p>XAX XBX XCX</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><th id="testr2c1">&nbsp;</th><td headers="testr1c2 testr2c1">&nbsp;</td><td headers="testr1c3 testr2c1">&nbsp;</td><td headers="testr1c4 testr2c1">&nbsp;</td></tr><tr><th id="testr3c1">&nbsp;</th><td headers="testr1c2 testr3c1">&nbsp;</td><td headers="testr1c3 testr3c1">&nbsp;</td><td headers="testr1c4 testr3c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        // Remove header row and check that ids are taken out
        $this->showTools(0, 'row');
        $this->clickField('Heading');
        sleep(1);
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>XAX XBX XCX</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th id="testr2c1">&nbsp;</th><td headers="testr2c1">&nbsp;</td><td headers="testr2c1">&nbsp;</td><td headers="testr2c1">&nbsp;</td></tr><tr><th id="testr3c1">&nbsp;</th><td headers="testr3c1">&nbsp;</td><td headers="testr3c1">&nbsp;</td><td headers="testr3c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        // Remove header column and check that ids are taken out
        $this->clickCell(2);
        $this->showTools(8, 'cell');
        $this->clickField('Heading');
        sleep(1);
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->showTools(4, 'cell');
        $this->clickField('Heading');
        sleep(1);
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>XAX XBX XCX</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testHeaderTagsWithTopAndLeftHeaders()


   /**
     * Test that merging all header cells in the top row causes the id of the cell to be updated.
     *
     * @return void
     */
    public function testHeaderTagsWhenMergingTopRowCells()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3,4, 2, "test")');
        sleep(2);

        $this->showTools(1, 'cell');
        $this->clickButton('splitMerge');
        $this->clickButton('mergeLeft');
        $this->clickButton('mergeRight');
        $this->clickButton('mergeRight');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table id="test" style="width: 100%;" border="1"><tbody><tr><th id="testr1c1" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(0, 'col');
        $this->clickInlineToolbarButton('addRight');
        sleep(1);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table id="test" style="width: 100%;" border="1"><tbody><tr><th id="testr1c1" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;</th><th id="testr1c2">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testHeaderTagsWhenCreatingTableWithRowHeaders()


   /**
     * Test that merging all header cells in the top row causes the id of the cell to be updated.
     *
     * @return void
     */
    public function testHeaderTagsWhenMergingLeftColCells()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3,4, 1, "test")');
        sleep(2);

        $this->showTools(4, 'cell');
        $this->clickButton('splitMerge');
        $this->clickButton('mergeUp');
        $this->clickButton('mergeDown');

        $this->assertHTMLMatch('<p>XAX XBX XCX</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1" rowspan="3">&nbsp;&nbsp;&nbsp;</th><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('addBelow');
        sleep(1);

        $this->assertHTMLMatch('<p>XAX XBX XCX</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1" rowspan="3">&nbsp;&nbsp;&nbsp;</th><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td></tr><tr><th id="testr4c1">&nbsp;</th><td headers="testr4c1">&nbsp;</td><td headers="testr4c1">&nbsp;</td><td headers="testr4c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testHeaderTagsWhenCreatingTableWithRowHeaders()


    /**
     * Test that id tags are added to the table when you apply a header row.
     *
     * @return void
     */
    public function testHeaderTagsAddedWhenHeaderRowAdded()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3,4, 0, "test")');
        sleep(2);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(0, 'row');
        $this->clickField('Heading');
        sleep(1);
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table id="test" style="width: 100%;" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testHeaderTagsAddedWhenHeaderRowAdded()


    /**
     * Test that id tags are added to the table when you apply a header column.
     *
     * @return void
     */
    public function testHeaderTagsAddedWhenHeaderColAdded()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3,4, 0, "test")');
        sleep(2);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(0, 'col');
        $this->clickField('Heading');
        sleep(1);
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>XAX XBX XCX</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1">&nbsp;</th><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td><td headers="testr1c1">&nbsp;</td></tr><tr><th id="testr2c1">&nbsp;</th><td headers="testr2c1">&nbsp;</td><td headers="testr2c1">&nbsp;</td><td headers="testr2c1">&nbsp;</td></tr><tr><th id="testr3c1">&nbsp;</th><td headers="testr3c1">&nbsp;</td><td headers="testr3c1">&nbsp;</td><td headers="testr3c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testHeaderTagsAddedWhenHeaderColAdded()


}//end class

?>
