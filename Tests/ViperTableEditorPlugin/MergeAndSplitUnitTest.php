<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_MergeAndSplitUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Test that table ids are correct after merging, splitting and deleting cells.
     *
     * @return void
     */
    public function testTableIdWhenMergingSplitingAndDeletingCellsInASingleRow()
    {
        $textLoc = $this->findKeyword(1);

        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3, 6, 3, "test")');
        sleep(2);
        $this->click($textLoc);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th><th id="testr1c5">&nbsp;</th><th id="testr1c6">&nbsp;</th></tr><tr><th id="testr2c1">&nbsp;</th><td headers="testr1c2 testr2c1">&nbsp;</td><td headers="testr1c3 testr2c1">&nbsp;</td><td headers="testr1c4 testr2c1">&nbsp;</td><td headers="testr1c5 testr2c1">&nbsp;</td><td headers="testr1c6 testr2c1">&nbsp;</td></tr><tr><th id="testr3c1">&nbsp;</th><td headers="testr1c2 testr3c1">&nbsp;</td><td headers="testr1c3 testr3c1">&nbsp;</td><td headers="testr1c4 testr3c1">&nbsp;</td><td headers="testr1c5 testr3c1">&nbsp;</td><td headers="testr1c6 testr3c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(8, 'cell');
        $this->clickButton('splitMerge');
        $this->clickButton('mergeRight');
        $this->clickButton('mergeRight');
        $this->clickButton('mergeRight');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th><th id="testr1c5">&nbsp;</th><th id="testr1c6">&nbsp;</th></tr><tr><th id="testr2c1">&nbsp;</th><td headers="testr1c2 testr2c1">&nbsp;</td><td colspan="4" headers="testr1c3 testr1c4 testr1c5 testr1c6 testr2c1">&nbsp;&nbsp;&nbsp;&nbsp;</td></tr><tr><th id="testr3c1">&nbsp;</th><td headers="testr1c2 testr3c1">&nbsp;</td><td headers="testr1c3 testr3c1">&nbsp;</td><td headers="testr1c4 testr3c1">&nbsp;</td><td headers="testr1c5 testr3c1">&nbsp;</td><td headers="testr1c6 testr3c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->clickButton('splitVert');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th><th id="testr1c5">&nbsp;</th><th id="testr1c6">&nbsp;</th></tr><tr><th id="testr2c1">&nbsp;</th><td headers="testr1c2 testr2c1">&nbsp;</td><td colspan="3" headers="testr1c3 testr1c4 testr1c5 testr2c1">&nbsp;&nbsp;&nbsp;&nbsp;</td><td headers="testr1c6 testr2c1">&nbsp;</td></tr><tr><th id="testr3c1">&nbsp;</th><td headers="testr1c2 testr3c1">&nbsp;</td><td headers="testr1c3 testr3c1">&nbsp;</td><td headers="testr1c4 testr3c1">&nbsp;</td><td headers="testr1c5 testr3c1">&nbsp;</td><td headers="testr1c6 testr3c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(4, 'col');
        $this->clickButton('delete');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th><th id="testr1c5">&nbsp;</th></tr><tr><th id="testr2c1">&nbsp;</th><td headers="testr1c2 testr2c1">&nbsp;</td><td colspan="2" headers="testr1c3 testr1c4 testr2c1">&nbsp;&nbsp;&nbsp;&nbsp;</td><td headers="testr1c5 testr2c1">&nbsp;</td></tr><tr><th id="testr3c1">&nbsp;</th><td headers="testr1c2 testr3c1">&nbsp;</td><td headers="testr1c3 testr3c1">&nbsp;</td><td headers="testr1c4 testr3c1">&nbsp;</td><td headers="testr1c5 testr3c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testTableIdWhenMergingSplitingAndDeletingCellsInASingleRow()


    /**
     * Test that table ids are correct after merging and splitting cells across multiple rows.
     *
     * @return void
     */
    public function testTableIdWhenMergingCellsThenSplittingVertThenHorz()
    {

        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3, 4, 2, "test")');
        sleep(2);
        $this->click($this->findKeyword(1));

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(1, 'cell');
        $this->clickButton('splitMerge');
        $this->clickButton('mergeRight');
        $this->clickButton('mergeDown');
        $this->clickButton('mergeDown');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1">&nbsp;</th><th colspan="2" id="testr1c2" rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th id="testr1c3">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2 testr1c3">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2 testr1c3">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->clickButton('splitVert');
        $this->clickButton('splitHoriz');
        $this->clickButton('splitHoriz');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th id="testr1c3" rowspan="3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><th id="testr2c2">&nbsp;</th><td headers="testr1c3 testr1c4 testr2c2">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><th id="testr3c2">&nbsp;</th><td headers="testr1c3 testr1c4 testr3c2">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');


    }//end testTableIdWhenMergingCellsThenSplittingVertThenHorz()


    /**
     * Test that table ids are correct after merging and splitting cells across multiple rows.
     *
     * @return void
     */
    public function testTableIdWhenMergingCellsThenSplittingHorzThenVert()
    {

        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3, 4, 2, "test")');
        sleep(2);
        $this->click($this->findKeyword(1));

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(1, 'cell');
        $this->clickButton('splitMerge');
        $this->clickButton('mergeRight');
        $this->clickButton('mergeDown');
        $this->clickButton('mergeDown');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1">&nbsp;</th><th colspan="2" id="testr1c2" rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th id="testr1c3">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2 testr1c3">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2 testr1c3">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->clickButton('splitHoriz');
        sleep(1);
        $this->clickButton('splitHoriz');
        sleep(1);
        $this->clickButton('splitVert');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><th colspan="2" id="testr2c2">&nbsp;</th><td headers="testr1c4 testr2c2">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><th colspan="2" id="testr3c2">&nbsp;</th><td headers="testr1c4 testr3c2">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');


    }//end testTableIdWhenMergingAndSplitingCellsAcrossMultipleRowsAndColumns()


    /**
     * Test that you can merge all columns and rows into one.
     *
     * @return void
     */
    public function testMergingAllColumnsAndRows()
    {
        $this->insertTable();
        $this->showTools(0, 'cell');
        $this->clickButton('splitMerge');
        $this->clickButton('mergeRight');
        $this->clickButton('mergeRight');
        $this->clickButton('mergeRight');
        $this->clickButton('mergeDown');
        $this->clickButton('mergeDown');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr></tbody></table><p>&nbsp;</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testUsingTableIconInTopToolbar()


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplitA()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->execJS('insTable(4, 5, 0, "test")');
        sleep(1);

        $this->showTools(10, 'cell');

        $this->clickButton('splitMerge');

        // Check that only the merge up, merge down and merge right icons are enabled
        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            TRUE,
            TRUE,
            FALSE,
            TRUE
        );

        $this->clickButton('mergeRight');

         // Check that the split column, merge up, merge down and merge right icons are enabled.
         $this->assertIconStatusesCorrect(
            TRUE,
            FALSE,
            TRUE,
            TRUE,
            FALSE,
            TRUE
        );

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan="2">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(5, 'col');
        $this->clickInlineToolbarButton('addRight');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan="3">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(7, 'col');
        $this->clickInlineToolbarButton('delete');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan="2">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(14, 'col');
        $this->clickInlineToolbarButton('addRight');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan="3">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(12, 'cell');
        $this->clickButton('splitMerge');
        $this->clickInlineToolbarButton('splitVert');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan="2">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(12, 'cell');
        $this->clickButton('splitMerge');
        $this->clickInlineToolbarButton('splitVert');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testMergeSplit()


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplit2()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->execJS('insTable(4, 5, 0, "test")');
        sleep(1);

        $this->showTools(6, 'cell');
        $this->clickButton('splitMerge');

        // Check that all merge icons are enabled.
        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            TRUE,
            TRUE,
            TRUE,
            TRUE
        );

        $this->clickButton('mergeDown');

         // Check that all merge icons still are enabled.
        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            TRUE,
            TRUE,
            TRUE,
            TRUE
        );

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td rowspan="2">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(5, 'row');
        $this->clickInlineToolbarButton('addBelow');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td rowspan="3">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(5, 'row');
        $this->clickInlineToolbarButton('delete');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td rowspan="2">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(11, 'row');
        $this->clickInlineToolbarButton('addAbove');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td rowspan="3">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(6, 'cell');
        $this->clickButton('splitMerge');
        $this->clickInlineToolbarButton('splitHoriz');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table border="1" style="width: 100%;"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td rowspan="2">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(6, 'cell');
        $this->clickButton('splitMerge');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table border="1" style="width: 100%;"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td rowspan="2">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testMergeSplit2()


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplit3()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->execJS('insTable(2, 3, 2, "test")');
        sleep(1);

        $this->showTools(0, 'cell');
        $this->clickButton('splitMerge');

        // Check to see that only the merge down and merge right icons are enabled.
        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            FALSE,
            TRUE,
            FALSE,
            TRUE
        );

        $this->clickButton('mergeRight');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><th colspan="2">&nbsp;&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->clickButton('mergeRight');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><th colspan="3">&nbsp;&nbsp;&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(0, 'col');
        $this->clickInlineToolbarButton('addRight');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><th colspan="3">&nbsp;&nbsp;&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->clickCell(1);
        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('addBelow');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><th colspan="3">&nbsp;&nbsp;&nbsp;</th><th>&nbsp;</th></tr><tr><th colspan="3">&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        // Click another cell to hide the tools incase its covert the 2nd cell.
        $this->clickCell(1);
        $this->showTools(2, 'cell');
        $this->clickButton('splitMerge');
        $this->clickInlineToolbarButton('splitVert');
        $this->clickInlineToolbarButton('splitVert');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><th colspan="3">&nbsp;&nbsp;&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('addAbove');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><th colspan="3">&nbsp;</th><th>&nbsp;</th></tr><tr><th colspan="3">&nbsp;&nbsp;&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(2, 'cell');
        $this->clickButton('splitMerge');
        $this->assertIconStatusesCorrect(
            TRUE,
            FALSE,
            TRUE,
            TRUE,
            FALSE,
            TRUE
        );

        $this->clickButton('mergeUp');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><th colspan="3" rowspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th></tr><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(1, 'cell');
        $this->clickButton('splitMerge');
        $this->clickButton('mergeDown');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><th colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;</th><th>&nbsp;&nbsp;</th></tr><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(0, 'cell');
        $this->clickButton('splitMerge');
        $this->clickButton('mergeDown');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><th colspan="3" rowspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>&nbsp;&nbsp;</th></tr><tr><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(0, 'cell');
        $this->clickButton('splitMerge');
        $this->clickButton('splitHoriz');

        usleep(200);
        $this->showTools(0, 'cell');
        $this->clickButton('splitMerge');
        $this->clickButton('splitVert');

        usleep(200);
        $this->showTools(0, 'cell');
        $this->clickButton('splitMerge');
        $this->clickButton('splitVert');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;&nbsp;</th></tr><tr><th colspan="3">&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testMergeSplit3()


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplit4()
    {
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->execJS('insTable(2, 3, 2, "test")');
        sleep(1);

        $this->showTools(0, 'cell');

        $this->clickButton('splitMerge');
        $this->clickButton('mergeRight');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table border="1" style="width: 100%;"><tbody><tr><th colspan="2">&nbsp;&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->clickButton('splitVert');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><th>&nbsp;&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->clickButton('mergeDown');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><th rowspan="2">&nbsp;&nbsp;&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->clickButton('splitHoriz');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table style="width: 100%; " border="1"><tbody><tr><th>&nbsp;&nbsp;&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->clickCell(1);
        $this->showTools(0, 'cell');
        $this->toggleCellHeading();
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>&nbsp;</p><table border="1" style="width: 100%;"><tbody><tr><th>&nbsp;&nbsp;&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testMergeSplit4()


}//end class

?>
