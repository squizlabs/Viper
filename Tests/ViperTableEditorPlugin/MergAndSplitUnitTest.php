<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_MergAndSplitUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    protected function assertIconStatusesCorrect(
        $splitVert,
        $splitHoriz,
        $mergeUp,
        $mergeDown,
        $mergeLeft,
        $mergeRight
    ) {
        $icons = array(
                  'splitV',
                  'splitH',
                  'mergeUp',
                  'mergeDown',
                  'mergeLeft',
                  'mergeRight',
                 );

        $statuses = $this->execJS('gTblBStatus()');

        foreach ($statuses as $btn => $status) {
            if ($status === TRUE && $$btn === FALSE) {
                $this->fail('Expected '.$btn.' button to be disabled.');
            } else if ($status === FALSE && $$btn === TRUE) {
                $this->fail('Expected '.$btn.' button to be enabled.');
            }
        }

    }


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

        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            TRUE,
            TRUE,
            FALSE,
            TRUE
        );

        $this->clickInlineToolbarButton($this->getImg('icon_mergeRight.png'));

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

        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            TRUE,
            TRUE,
            TRUE,
            TRUE
        );

        $this->clickInlineToolbarButton($this->getImg('icon_mergeDown.png'));
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


}//end class

?>
