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
        $this->insertTableWithNoHeaders();
        sleep(2);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>%3%</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testCreateTableWithoutHeaders()


   /**
     * Test that creating a table with left headers.
     *
     * @return void
     */
    public function testCreateTableWithLeftHeaders()
    {
        $this->insertTableWithLeftHeaders();
        sleep(2);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>%3%</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testCreateTableWithLeftHeaders()


   /**
     * Test that creating a table with both headers.
     *
     * @return void
     */
    public function testCreateTableWithBothHeaders()
    {
        $this->insertTableWithBothHeaders();
        sleep(2);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>%3%</p><p>sit amet <strong>consectetur</strong></p>');

    }//end insertTableWithBothHeaders()


    /**
     * Test that creating a table works using the default header layout.
     *
     * @return void
     */
    public function testCreateTableStructure()
    {
        $this->insertTable();
        sleep(2);

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
        $this->clickMergeSplitIcon('mergeRight');
        $this->click($this->find(1));

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th colspan="2">&nbsp;OneTwo&nbsp;</th><th>Three&nbsp;</th><th>Four&nbsp;</th></tr><tr><td>Five&nbsp;</td><td>Six&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>%3%</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testCreateTableStructure()


    /**
     * Test that creating a table works.
     *
     * @return void
     */
    public function testCreateTableStructure2()
    {
        $this->insertTable();
        sleep(2);

        $this->showTools(0, 'col');
        $this->clickInlineToolbarButton('addRight');

        $this->click($this->findKeyword(1));
        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('addBelow');
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
        $this->clickMergeSplitIcon('mergeRight');

        $this->showTools(1, 'cell');
        $this->clickMergeSplitIcon('mergeDown');

        // Click within the fourth cell of the second row (under the "By Gender" heading) and merge options.
        $this->showTools(6, 'cell');
        $this->clickButton('splitMerge');
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
        $this->clickButton('splitMerge');
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
        $this->clickButton('splitMerge');
        $this->assertIconStatusesCorrect(
            TRUE,
            FALSE,
            FALSE,
            TRUE,
            FALSE,
            FALSE
        );
        sleep(1);

        $this->clickInlineToolbarButton('mergeDown');

        // Click within the third cell of the first row (the one that has "By Gender").
        $this->showTools(2, 'cell');
        $this->clickMergeSplitIcon('mergeRight');

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
        $this->clickMergeSplitIcon('mergeDown');

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
        $this->clickButton('splitMerge');
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
        $this->clickButton('splitMerge');
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
        $this->clickButton('splitMerge');
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
        $this->clickButton('splitMerge');
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
        $this->clickButton('splitMerge');
        $this->assertIconStatusesCorrect(
            FALSE,
            FALSE,
            FALSE,
            TRUE,
            FALSE,
            TRUE
        );
        sleep(1);

        $this->click($this->find(1));
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
                       'content' => 'All Genders&nbsp;&nbsp;',
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
                       'content' => 'Males&nbsp;',
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
                       'content' => 'North&nbsp;',
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
     * Tests that you cannot create tables in a list
     *
     * @return void
     */
    public function testCreateTableInList()
    {
        $this->selectKeyword('consectetur');
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
        $this->selectKeyword(2, 3);

        $this->clickTopToolbarButton('table');
        $this->clickButton('Insert Table', NULL, TRUE);

        sleep(1);
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>&nbsp;</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');

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

        sleep(1);
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>%3%</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testReplaceWordWithTable()


    /**
     * Test that creating you can create a table and then undo your changes.
     *
     * @return void
     */
    public function testCreatingTableThenClickingUndo()
    {
        $this->insertTable();
        sleep(2);
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>%3%</p><p>sit amet <strong>consectetur</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Create table icon should be active in the toolbar');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%2% %1% %3%</p><p>sit amet <strong>consectetur</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'), 'Create table icon should be disabled in the toolbar');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>%3%</p><p>sit amet <strong>consectetur</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Create table icon should be active in the toolbar');

    }//end testCreatingTableThenClickingUndo()


    /**
     * Test that you can replace a paragraph with a table and click undo.
     *
     * @return void
     */
    public function testReplacingParagraphWithTableThenClickingUndo()
    {
        $this->selectKeyword(2, 3);

        $this->clickTopToolbarButton('table');
        $this->clickButton('Insert Table', NULL, TRUE);

        sleep(1);
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>&nbsp;</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Create table icon should be active in the toolbar');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%2% %1% %3%</p><p>sit amet <strong>consectetur</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'disabled'), 'Create table icon should be disabled in the toolbar');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>&nbsp;</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Create table icon should be active in the toolbar');

    }//end testReplacingParagraphWithTableThenClickingUndo()


}//end class

?>
