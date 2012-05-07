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
        $textLoc = $this->find('IPSUM');

        $this->selectText('dolor');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3, 6, 3, "test")');
        sleep(2);
        $this->click($textLoc);

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th><th id="testr1c5">&nbsp;</th><th id="testr1c6">&nbsp;</th></tr><tr><th id="testr2c1">&nbsp;</th><td headers="testr1c2 testr2c1">&nbsp;</td><td headers="testr1c3 testr2c1">&nbsp;</td><td headers="testr1c4 testr2c1">&nbsp;</td><td headers="testr1c5 testr2c1">&nbsp;</td><td headers="testr1c6 testr2c1">&nbsp;</td></tr><tr><th id="testr3c1">&nbsp;</th><td headers="testr1c2 testr3c1">&nbsp;</td><td headers="testr1c3 testr3c1">&nbsp;</td><td headers="testr1c4 testr3c1">&nbsp;</td><td headers="testr1c5 testr3c1">&nbsp;</td><td headers="testr1c6 testr3c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(8, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeRight.png'));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeRight.png'));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeRight.png'));

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th><th id="testr1c5">&nbsp;</th><th id="testr1c6">&nbsp;</th></tr><tr><th id="testr2c1">&nbsp;</th><td headers="testr1c2 testr2c1">&nbsp;</td><td colspan="4" headers="testr1c3 testr1c4 testr1c5 testr1c6 testr2c1">&nbsp;&nbsp;&nbsp;&nbsp;</td></tr><tr><th id="testr3c1">&nbsp;</th><td headers="testr1c2 testr3c1">&nbsp;</td><td headers="testr1c3 testr3c1">&nbsp;</td><td headers="testr1c4 testr3c1">&nbsp;</td><td headers="testr1c5 testr3c1">&nbsp;</td><td headers="testr1c6 testr3c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->click($this->find($this->getImg('icon_splitVert.png'), NULL, 0.83));
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th><th id="testr1c5">&nbsp;</th><th id="testr1c6">&nbsp;</th></tr><tr><th id="testr2c1">&nbsp;</th><td headers="testr1c2 testr2c1">&nbsp;</td><td colspan="3" headers="testr1c3 testr1c4 testr1c5 testr2c1">&nbsp;&nbsp;&nbsp;&nbsp;</td><td headers="testr1c6 testr2c1">&nbsp;</td></tr><tr><th id="testr3c1">&nbsp;</th><td headers="testr1c2 testr3c1">&nbsp;</td><td headers="testr1c3 testr3c1">&nbsp;</td><td headers="testr1c4 testr3c1">&nbsp;</td><td headers="testr1c5 testr3c1">&nbsp;</td><td headers="testr1c6 testr3c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(4, 'col');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th><th id="testr1c6">&nbsp;</th></tr><tr><th id="testr2c1">&nbsp;</th><td headers="testr1c2 testr2c1">&nbsp;</td><td colspan="2" headers="testr1c3 testr1c4 testr2c1">&nbsp;&nbsp;&nbsp;&nbsp;</td><td headers="testr1c6 testr2c1">&nbsp;</td></tr><tr><th id="testr3c1">&nbsp;</th><td headers="testr1c2 testr3c1">&nbsp;</td><td headers="testr1c3 testr3c1">&nbsp;</td><td headers="testr1c4 testr3c1">&nbsp;</td><td headers="testr1c6 testr3c1">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');


    }//end testTableIdWhenMergingSplitingAndDeletingCellsInASingleRow()


    /**
     * Test that table ids are correct after merging and splitting cells across multiple rows.
     *
     * @return void
     */
    public function testTableIdWhenMergingCellsThenSplittingVertThenHorz()
    {
        $textLoc = $this->find('IPSUM');

        $this->selectText('dolor');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3, 4, 2, "test")');
        sleep(2);
        $this->click($textLoc);

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(1, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeRight.png'));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeDown.png'));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeDown.png'));
        exit();
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%; " id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2" colspan="2" rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->click($this->find($this->getImg('icon_splitVert.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_splitHoriz.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_splitHoriz.png'), NULL, 0.83));
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2" colspan="2" rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2 testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2 testr1c4">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');


    }//end testTableIdWhenMergingCellsThenSplittingVertThenHorz()


    /**
     * Test that table ids are correct after merging and splitting cells across multiple rows.
     *
     * @return void
     */
    public function testTableIdWhenMergingCellsThenSplittingHorzThenVert()
    {
        $textLoc = $this->find('IPSUM');

        $this->selectText('dolor');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3, 4, 2, "test")');
        sleep(2);
        $this->click($textLoc);

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(1, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeRight.png'));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeDown.png'));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeDown.png'));
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2" colspan="2" rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->click($this->find($this->getImg('icon_splitHoriz.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_splitHoriz.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_splitVert.png'), NULL, 0.83));

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><th colspan="2" id="testr2c2">&nbsp;</th><td headers="testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><th colspan="2" id="testr3c2">&nbsp;</th><td headers="testr1c4">&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');


    }//end testTableIdWhenMergingAndSplitingCellsAcrossMultipleRowsAndColumns()


    /**
     * Test that you can merge all columns and rows into one.
     *
     * @return void
     */
    public function testMergingAllColumnsAndRows()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->insertTable();
        $this->showTools(0, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeRight.png'));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeRight.png'));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeRight.png'));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeDown.png'));
        $this->clickInlineToolbarButton($this->getImg('icon_mergeDown.png'));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr></tbody></table><p>dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testUsingTableIconInTopToolbar()


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplitA()
    {
        $this->selectText('dolor');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->execJS('insTable(4, 5, 0, "test")');
        sleep(1);

        $this->showTools(10, 'cell');

        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));

        // Check that only the merge up, merge down and merge right icons are enabled
        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            TRUE,
            TRUE,
            FALSE,
            TRUE
        );

        $this->clickInlineToolbarButton($this->getImg('icon_mergeRight.png'));

         // Check that the split column, merge up, merge down and merge right icons are enabled.
         $this->assertIconStatusesCorrect(
            TRUE,
            FALSE,
            TRUE,
            TRUE,
            FALSE,
            TRUE
        );

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan="2">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(5, 'col');
        $this->clickInlineToolbarButton($this->getImg('icon_insertColAfter.png'));

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan="3">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(7, 'col');
        $this->clickInlineToolbarButton($this->getImg('icon_trash.png'));

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan="2">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(14, 'col');
        $this->clickInlineToolbarButton($this->getImg('icon_insertColAfter.png'));

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan="3">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(12, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->clickInlineToolbarButton($this->getImg('icon_splitVert.png'));

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan="2">&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

        $this->showTools(12, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->clickInlineToolbarButton($this->getImg('icon_splitVert.png'));

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testMergeSplit()


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplit2()
    {
        $this->selectText('dolor');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->execJS('insTable(4, 5, 2, "test")');
        sleep(1);

        $this->showTools(6, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));

        // Check that all merge icons are enabled.
        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            TRUE,
            TRUE,
            TRUE,
            TRUE
        );

        $this->clickInlineToolbarButton($this->getImg('icon_mergeDown.png'));

         // Check that all merge icons still are enabled.
        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            TRUE,
            TRUE,
            TRUE,
            TRUE
        );

        $expected = array(
                     array(array(), array(), array(), array(), array()),
                     array(array(), array('rowspan' => 2), array(), array(), array()),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(5, 'row');
        $this->clickInlineToolbarButton($this->getImg('icon_insertRowAfter.png'));

        $expectedAfter = array(
                          array(array(), array(), array(), array(), array()),
                          array(array(), array('rowspan' => 3), array(), array(), array()),
                          array(array(), array(), array(), array()),
                          array(array(), array(), array(), array()),
                          array(array(), array(), array(), array(), array()),
                         );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expectedAfter, $struct);
        sleep(1);

        $this->showTools(5, 'row');
        $this->clickInlineToolbarButton($this->getImg('icon_trash.png'));

        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(11, 'row');
        $this->clickInlineToolbarButton($this->getImg('icon_insertRowBefore.png'));

        $struct = $this->getTableStructure();
        $this->assertTableStructure($expectedAfter, $struct);
        sleep(1);

        $this->showTools(6, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->clickInlineToolbarButton($this->getImg('icon_splitHoriz.png'));
        $expected = array(
                     array(array(), array(), array(), array(), array()),
                     array(array(), array('rowspan' => 2), array(), array(), array()),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(6, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->clickInlineToolbarButton($this->getImg('icon_splitHoriz.png'));
        $expected = array(
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);

    }//end testMergeSplit2()


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplit3()
    {
        $this->selectText('dolor');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->execJS('insTable(2, 3, 2, "test")');
        sleep(1);

        $this->showTools(0, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));

        // Check to see that only the merge down and merge right icons are enabled.
        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            FALSE,
            TRUE,
            FALSE,
            TRUE
        );

        $this->clickInlineToolbarButton($this->getImg('icon_mergeRight.png'));
        $expected = array(
                     array(array('colspan' => 2), array()),
                     array(array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->clickInlineToolbarButton($this->getImg('icon_mergeRight.png'));
        $expected = array(
                     array(array('colspan' => 3)),
                     array(array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(0, 'col');
        $this->clickInlineToolbarButton($this->getImg('icon_insertColAfter.png'));
        $expected = array(
                     array(array('colspan' => 3), array()),
                     array(array(), array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton($this->getImg('icon_insertRowAfter.png'));
        $expected = array(
                     array(array('colspan' => 3), array()),
                     array(array('colspan' => 3), array()),
                     array(array(), array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        // Click another cell to hide the tools incase its covert the 2nd cell.
        $this->selectText('Lorem');

        $this->showTools(2, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->clickInlineToolbarButton($this->getImg('icon_splitVert.png'));
        $this->clickInlineToolbarButton($this->getImg('icon_splitVert.png'));
        $expected = array(
                     array(array('colspan' => 3), array()),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton($this->getImg('icon_insertRowBefore.png'));
        $expected = array(
                     array(array('colspan' => 3), array()),
                     array(array('colspan' => 3), array()),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(2, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->assertIconStatusesCorrect(
            TRUE,
            FALSE,
            TRUE,
            TRUE,
            FALSE,
            TRUE
        );

        $this->clickInlineToolbarButton($this->getImg('icon_mergeUp.png'));
        $expected = array(
                     array(array('colspan' => 3, 'rowspan' => 2), array()),
                     array(array()),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(1, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_mergeDown.png'), NULL, 0.83));
        $expected = array(
                     array(array('colspan' => 3), array()),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(0, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_mergeDown.png'), NULL, 0.83));
        $expected = array(
                     array(array('colspan' => 3, 'rowspan' => 2), array()),
                     array(array()),
                     array(array(), array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(0, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_splitHoriz.png'), NULL, 0.83));

        usleep(200);
        $this->showTools(0, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_splitVert.png'), NULL, 0.83));

        usleep(200);
        $this->showTools(0, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_splitVert.png'), NULL, 0.83));
        $expected = array(
                     array(array(), array(), array(), array()),
                     array(array('colspan' => 3), array()),
                     array(array(), array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);

    }//end testMergeSplit3()


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplit4()
    {
        $this->selectText('dolor');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->execJS('insTable(2, 3, 2, "test")');
        sleep(1);

        $this->showTools(0, 'cell');

        $this->toggleCellHeading();
        usleep(100);
        $this->toggleCellHeading();
        usleep(100);
        $this->toggleCellHeading();

        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_mergeRight.png'), NULL, 0.83));
        $expected = array(
                     array(
                      array(
                       'heading' => TRUE,
                       'colspan' => 2,
                      ),
                      array(),
                     ),
                     array(array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->click($this->find($this->getImg('icon_splitVert.png'), NULL, 0.83));
        $expected = array(
                     array(
                      array(
                       'heading' => TRUE,
                      ),
                      array(
                       'heading' => TRUE,
                      ),
                      array(),
                     ),
                     array(array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(0, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_mergeDown.png'), NULL, 0.83));
        $expected = array(
                     array(
                      array(
                       'heading' => TRUE,
                       'rowspan' => 2,
                      ),
                      array('heading' => TRUE),
                      array(),
                     ),
                     array(array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(0, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_splitHoriz.png'), NULL, 0.83));
        $expected = array(
                     array(
                      array(
                       'heading' => TRUE,
                      ),
                      array(
                       'heading' => TRUE,
                      ),
                      array(),
                     ),
                     array(array('heading' => TRUE), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(0, 'cell');
        $this->toggleCellHeading();

        $expected = array(
                     array(
                      array(),
                      array(
                       'heading' => TRUE,
                      ),
                      array(),
                     ),
                     array(array('heading' => TRUE), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);

    }//end testMergeSplit4()


}//end class

?>
