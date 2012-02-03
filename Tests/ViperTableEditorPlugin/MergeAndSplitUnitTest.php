<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_MergeAndSplitUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplit()
    {
        $this->insertTable(4, 5);
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
         
        $struct   = $this->getTableStructure();
        $expected = array(
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                     array(array('colspan' => 2), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                    );
         
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(5, 'col');
        $this->clickInlineToolbarButton($this->getImg('icon_insertColAfter.png'));

        $struct = $this->getTableStructure();

        $expectedAfter = array(
                          array(array(), array(), array(), array(), array(), array()),
                          array(array(), array(), array(), array(), array(), array()),
                          array(array('colspan' => 3), array(), array(), array()),
                          array(array(), array(), array(), array(), array(), array()),
                         );

        $this->assertTableStructure($expectedAfter, $struct);
        sleep(1);

        $this->showTools(7, 'col');
        $this->clickInlineToolbarButton($this->getImg('icon_trash.png'));

        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(14, 'col');
        $this->clickInlineToolbarButton($this->getImg('icon_insertColAfter.png'));

        $struct = $this->getTableStructure();
        $this->assertTableStructure($expectedAfter, $struct);
        sleep(1);

        $this->showTools(12, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->clickInlineToolbarButton($this->getImg('icon_splitVert.png'));

        $expected = array(
                     array(array(), array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array(), array()),
                     array(array('colspan' => 2), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);
        sleep(1);

        $this->showTools(12, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->clickInlineToolbarButton($this->getImg('icon_splitVert.png'));

        $expected = array(
                     array(array(), array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array(), array()),
                    );
        $struct = $this->getTableStructure();
        $this->assertTableStructure($expected, $struct);

    }//end testMergeSplit()


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplit2()
    {
        $this->insertTable(4, 5);
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
        $this->insertTable(2, 3);
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
        $this->insertTable(2, 3);
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
