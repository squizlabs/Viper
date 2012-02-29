<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_CreateTableUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Test that creating a table works.
     *
     * @return void
     */
    public function testCreateTableStructure()
    {
        $this->insertTable(2, 3);
        sleep(1);

        $this->clickCell(0);
        usleep(300);

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
        $this->clickMergeSplitIcon('icon_mergeRight.png');

        $struct   = $this->getTableStructure(0, TRUE);
        $expected = array(
                     array(
                      array(
                       'colspan' => 2,
                       'content' => '&nbsp;OneTwo&nbsp;',
                      ),
                      array('content' => 'Three&nbsp;'),
                     ),
                     array(
                      array('content' => 'Four&nbsp;'),
                      array('content' => 'Five&nbsp;'),
                      array('content' => 'Six&nbsp;'),
                     ),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testCreateTableStructure()


    /**
     * Test that creating a table works.
     *
     * @return void
     */
    public function testCreateTableStructure2()
    {
        $this->insertTable(2, 3);
        sleep(1);

        $this->showTools(0, 'col');
        $this->clickInlineToolbarButton($this->getImg('icon_insertColAfter.png'));
        $this->clickInlineToolbarButton($this->getImg('icon_insertColAfter.png'));

        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton($this->getImg('icon_insertRowAfter.png'));
        $this->clickInlineToolbarButton($this->getImg('icon_insertRowAfter.png'));
        usleep(300);

        $this->clickCell(0);
        usleep(300);
        $this->clickCell(0);
        $this->type('Survey');

        $this->clickCell(2);
        $this->type('All Genders');
        $this->keyDown('Key.TAB');
        $this->type('By Gender');

        $this->showTools(0, 'cell');
        $this->clickMergeSplitIcon('icon_mergeRight.png');

        $this->showTools(1, 'cell');
        $this->clickMergeSplitIcon('icon_mergeDown.png');

        // Click within the fourth cell of the second row (under the "By Gender" heading) and merge options.
        $this->showTools(6, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            TRUE,
            TRUE,
            FALSE,
            TRUE
        );
        sleep(1);

        $this->showTools(5, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            FALSE,
            TRUE,
            TRUE,
            FALSE
        );
        sleep(1);

        $this->showTools(0, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->assertIconStatusesCorrect(
            TRUE,
            FALSE,
            FALSE,
            TRUE,
            FALSE,
            FALSE
        );
        sleep(1);

        $this->clickInlineToolbarButton($this->getImg('icon_mergeDown.png'));

        // Click within the third cell of the first row (the one that has "By Gender").
        $this->showTools(2, 'cell');
        $this->clickMergeSplitIcon('icon_mergeRight.png');

        $this->clickCell(3);
        $this->type('Males');
        $this->keyDown('Key.TAB');
        $this->type('Females');

        $this->clickCell(5);
        $this->type('All Regions');
        $this->keyDown('Key.TAB');
        $this->type('North');
        $this->keyDown('Key.TAB');
        $this->type('3');
        $this->keyDown('Key.TAB');
        $this->type('1');
        $this->keyDown('Key.TAB');
        $this->type('2');

        $this->clickCell(11);
        $this->type('South');
        $this->keyDown('Key.TAB');
        $this->type('3');
        $this->keyDown('Key.TAB');
        $this->type('1');
        $this->keyDown('Key.TAB');
        $this->type('2');

        $this->showTools(5, 'cell');
        $this->clickMergeSplitIcon('icon_mergeDown.png');

        $this->showTools(0, 'cell');
        $this->toggleCellHeading();

        $this->showTools(1, 'cell');
        $this->toggleCellHeading();

        $this->showTools(2, 'cell');
        $this->toggleCellHeading();
        $this->clickCell(0);
        usleep(300);

        $this->showTools(3, 'cell');
        $this->toggleCellHeading();

        $this->showTools(4, 'cell');
        $this->toggleCellHeading();

        $this->showTools(5, 'cell');
        $this->toggleCellHeading();

        $this->showTools(6, 'cell');
        $this->toggleCellHeading();
        $this->clickCell(0);
        usleep(300);

        $this->showTools(10, 'cell');
        $this->toggleCellHeading();

        // Last checks.
        // Survery cell.
        $this->showTools(0, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->assertIconStatusesCorrect(
            TRUE,
            TRUE,
            FALSE,
            FALSE,
            FALSE,
            TRUE
        );
        sleep(1);

        // All Gender cell.
        $this->showTools(1, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->assertIconStatusesCorrect(
            FALSE,
            TRUE,
            FALSE,
            TRUE,
            TRUE,
            FALSE
        );
        sleep(1);

        // By Gender cell.
        $this->showTools(2, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->assertIconStatusesCorrect(
            TRUE,
            FALSE,
            FALSE,
            TRUE,
            FALSE,
            FALSE
        );
        sleep(1);

        // All Regions cell.
        $this->showTools(5, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->assertIconStatusesCorrect(
            FALSE,
            TRUE,
            FALSE,
            FALSE,
            FALSE,
            TRUE
        );
        sleep(1);

        // North cell.
        $this->showTools(6, 'cell');
        $this->click($this->find($this->getImg('icon_mergeSplit.png'), NULL, 0.83));
        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            FALSE,
            TRUE,
            FALSE,
            TRUE
        );
        sleep(1);

        $struct   = $this->getTableStructure(0, TRUE);
        $expected = array(
                     array(
                      array(
                       'colspan' => 2,
                       'rowspan' => 2,
                       'content' => '&nbsp;Survey&nbsp;&nbsp;&nbsp;',
                       'heading' => TRUE,
                      ),
                      array(
                       'rowspan' => '2',
                       'content' => 'All Genders&nbsp;',
                       'heading' => TRUE,
                      ),
                      array(
                       'colspan' => '2',
                       'content' => 'By Gender&nbsp;&nbsp;',
                       'heading' => TRUE,
                      ),
                     ),
                     array(
                      array(
                       'content' => '&nbsp;Males',
                       'heading' => TRUE,
                      ),
                      array(
                       'content' => 'Females&nbsp;',
                       'heading' => TRUE,
                      ),
                     ),
                     array(
                      array(
                       'rowspan' => 2,
                       'content' => '&nbsp;All Regions&nbsp;',
                       'heading' => TRUE,
                      ),
                      array(
                       'content' => 'North',
                       'heading' => TRUE,
                      ),
                      array('content' => '3&nbsp;'),
                      array('content' => '1&nbsp;'),
                      array('content' => '2&nbsp;'),
                     ),
                     array(
                      array(
                       'content' => '&nbsp;South',
                       'heading' => TRUE,
                      ),
                      array('content' => '3&nbsp;'),
                      array('content' => '1&nbsp;'),
                      array('content' => '2&nbsp;'),
                     ),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testCreateTableStructure2()


    /**
     * Tests that its possible to create a table in a list.
     *
     * @return void
     */
    public function testCreateTableInList()
    {
        $this->selectText('consectetur');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.TAB');

        $this->execJS('insTable(1, 1)');
        sleep(1);

        // TODO: Note, Google Chrome seems to add white space at the end of the style attribute..
        $this->assertHTMLMatch(
            '<p>Lorem IPSUM dolor</p><ul><li>sit amet <strong>consectetur</strong><table style="width: 300px;" border="1"><tbody><tr><td style="width: 100px;">&nbsp;</td></tr></tbody></table></li></ul>',
            '<p>Lorem IPSUM dolor</p><ul><li>sit amet <strong>consectetur</strong><table style="width: 300px; " border="1"><tbody><tr><td style="width: 100px;">&nbsp;</td></tr></tbody></table></li></ul>'
        );

    }//end testCreateTableInList()


    /**
     * Test that creating a table after selecting a whole paragraph works.
     *
     * @return void
     */
    public function testReplaceParagraphWithTable()
    {
        $this->selectText('Lorem', 'dolor');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_createTable.png');
        sleep(1);

        $this->assertHTMLMatch('<p>&nbsp;</p><table style="width: 100%;" border="1"><tbody><tr><th>Column 1</th><th>Column 2</th><th>Column 3</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

    }//end testReplaceParagraphWithTable()


}//end class

?>
