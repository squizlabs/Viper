<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_RowUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Test that correct row icons appear in the toolbar.
     *
     * @return void
     */
    public function testRowToolIconsCorrect()
    {
        $this->insertTable();

        $this->showTools(0, 'row');
        $this->assertTrue($this->exists($this->getImg('row_tools.png')));

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_createTable_active.png');
        $columnIcon = $this->find($this->getImg('icon_tools_row.png'));
        $this->click($columnIcon);
        sleep(1);

        $this->assertTrue($this->exists($this->getImg('row_tools.png')));

    }//end testRowToolIconsCorrect()


    /**
     * Test that you can add and remove a class from a row.
     *
     * @return void
     */
    public function testAddingClassToRow()
    {
        $textLoc = $this->find('IPSUM');

        $this->insertTable();

        // Apply a class to the first row and click click Update Changes
        $this->showTools(0, 'row');
        sleep(1);
        $classField = $this->find(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class.png');
        $this->click($classField);
        $this->type('test');
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr class="test"><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Apply a class to the third row and press enter
        $this->showTools(9, 'row');
        sleep(1);
        $classField = $this->clickInlineToolbarButton(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr class="test"><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr class="abc"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Remove the class from the first row and click Update Changes
        $this->showTools(0, 'row');
        sleep(1);
        $classField = $this->find(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class_active.png');
        $this->click($classField);

        $deleteIcon = $this->find(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_delete_icon.png');
        $this->click($deleteIcon);

        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr class="abc"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Remove the class from the third row and press enter
        $this->showTools(9, 'row');
        sleep(1);
        $classField = $this->find(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class_active.png');
        $this->click($classField);

        $deleteIcon = $this->find(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_delete_icon.png');
        $this->click($deleteIcon);

        $this->keyDown('Key.ENTER');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

    }//end testAddingClassToRow()


    /**
     * Test adding a new table without headers and then changing the settings of rows.
     *
     * @return void
     */
    public function testRowsInANewTableWithoutHeaders()
    {
        $textLoc = $this->find('IPSUM');

        $this->insertTableWithNoHeaders();

        $this->clickCell(8);
        usleep(300);
        $this->type('Three');
        $this->clickCell(4);
        usleep(300);
        $this->type('Two');
        $this->clickCell(0);
        usleep(300);
        $this->type('One');

        $this->showTools(0, 'row');

        // Add a new row after the first row of the table
        $this->click($this->find($this->getImg('icon_insertRowAfter.png'), NULL, 0.83));
        sleep(1);

        // Add a new row before the first row of the table
        $this->click($this->find($this->getImg('icon_insertRowBefore.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;One</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Delete the third row
        $this->clickCell(0);
        $this->showTools(10, 'row');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;One</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row up
        $this->showTools(4, 'row');
        $this->click($this->find($this->getImg('icon_moveRowUp.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;One</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row down
        $this->showTools(6, 'row');
        $this->click($this->find($this->getImg('icon_moveRowDown.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;One</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the first row to be a header column
        $this->showTools(0, 'row');
        $isHeadingField = $this->find($this->getImg('icon_isHeading.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

    }//end testRowsInANewTableWithoutHeaders()


    /**
     * Test adding a new table with left headers and then adding new rows.
     *
     * @return void
     */
    public function testRowsInANewTableWithLeftHeaders()
    {
        $textLoc = $this->find('IPSUM');
        $this->insertTableWithLeftHeaders();

        $this->clickCell(8);
        usleep(300);
        $this->type('Three');
        $this->clickCell(4);
        usleep(300);
        $this->type('Two');
        $this->clickCell(0);
        usleep(300);
        $this->type('One');

        $this->showTools(0, 'row');

        // Add a new row after the first row of the table
        $this->click($this->find($this->getImg('icon_insertRowAfter.png'), NULL, 0.83));
        sleep(1);

        // Add a new row before the first row of the table
        $this->click($this->find($this->getImg('icon_insertRowBefore.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>One&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Delete the third row
        $this->clickCell(0);
        $this->showTools(10, 'row');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>One&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row up
        $this->showTools(4, 'row');
        $this->click($this->find($this->getImg('icon_moveRowUp.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row down
        $this->clickCell(0);
        $this->showTools(6, 'row');
        $this->click($this->find($this->getImg('icon_moveRowDown.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the first row to be a header row
        $this->showTools(0, 'row');
        $isHeadingField = $this->find($this->getImg('icon_isHeading.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

    }//end testRowsInANewTableWithLeftHeaders()


    /**
     * Test adding a new table with left headers and then adding new rows.
     *
     * @return void
     */
    public function testRowsInANewTableWithTopHeaders()
    {
        $textLoc = $this->find('IPSUM');
        $this->insertTable();

        $this->clickCell(8);
        usleep(300);
        $this->type('Three');
        $this->clickCell(4);
        usleep(300);
        $this->type('Two');
        $this->clickCell(0);
        usleep(300);
        $this->type('One');

        $this->showTools(0, 'row');

        // Add a new row after the first row of the table
        $this->click($this->find($this->getImg('icon_insertRowAfter.png'), NULL, 0.83));
        sleep(1);

        // Add a new row before the third row of the table
        $this->showTools(9, 'row');
        $this->click($this->find($this->getImg('icon_insertRowBefore.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Delete the second row
        $this->clickCell(0);
        $this->showTools(5, 'row');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row up
        $this->showTools(6, 'row');
        $this->click($this->find($this->getImg('icon_moveRowUp.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row down
        $this->clickCell(0);
        $this->showTools(5, 'row');
        $this->click($this->find($this->getImg('icon_moveRowDown.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the first row to be a header row
        $this->showTools(0, 'row');
        $isHeadingField = $this->find($this->getImg('icon_isHeading.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

         // Change the third row not to be a header row
        $this->showTools(10, 'row');
        $isHeadingField = $this->find($this->getImg('icon_isHeading_active.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>One&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');


    }//end testRowsInANewTableWithTopHeaders()


    /**
     * Test adding a new table with both headers and then adding new rows.
     *
     * @return void
     */
    public function testRowsInANewTableWithBothHeaders()
    {
        $textLoc = $this->find('IPSUM');
        $this->insertTableWithBothHeaders();

        $this->clickCell(8);
        usleep(300);
        $this->type('Three');
        $this->clickCell(4);
        usleep(300);
        $this->type('Two');
        $this->clickCell(0);
        usleep(300);
        $this->type('One');

        $this->showTools(0, 'row');

        // Add a new row after the first row of the table
        $this->click($this->find($this->getImg('icon_insertRowAfter.png'), NULL, 0.83));
        sleep(1);

        // Add a new row before the third row of the table
        $this->showTools(9, 'row');
        $this->click($this->find($this->getImg('icon_insertRowBefore.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Delete the third row
        $this->clickCell(0);
        $this->showTools(9, 'row');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row up
        $this->showTools(6, 'row');
        $this->click($this->find($this->getImg('icon_moveRowUp.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row down
        $this->clickCell(0);
        $this->showTools(5, 'row');
        $this->click($this->find($this->getImg('icon_moveRowDown.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

         // Change the third row not to be a header row
        //$this->showTools(10, 'row');
        $isHeadingField = $this->find($this->getImg('icon_isHeading_active.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>One&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');


    }//end testRowsInANewTableWithBothHeaders()


    /**
     * Test that the 'All Genders' rowspan changes to three when you add a new row and goes back to two when you delete a new row.
     *
     * @return void
     */
    public function testRowspanChangesWhenNewRowAdded()
    {
        $this->showTools(0, 'row');

        $this->click($this->find($this->getImg('icon_insertRowAfter.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_insertRowBefore.png'), NULL, 0.83));

        $this->click($this->find('IPSUM'));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td colspan="2">&nbsp;</td><td>&nbsp;</td><td colspan="2">&nbsp;</td></tr><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="3">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

        $this->showTools(6, 'row');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td colspan="2">&nbsp;</td><td>&nbsp;</td><td colspan="2">&nbsp;</td></tr><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

    }//end testRowspanChangesWhenNewRowAdded()


    /**
     * Test that the 'All Genders' rowspan changes when you delete the first row from it.
     *
     * @return void
     */
    public function testRowspanChangesWhenYouDeleteTheFirstRow()
    {
        $this->showTools(2, 'row');

        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $this->click($this->find('IPSUM'));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>All Genders</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

    }//end testRowspanChangesWhenYouDeleteTheLastRow()


    /**
     * Test that the 'All Genders' rowspan changes when you delete the last row from it.
     *
     * @return void
     */
    public function testRowspanChangesWhenYouDeleteTheLastRow()
    {
        $this->showTools(5, 'row');

        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $this->click($this->find('IPSUM'));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td>All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');


    }//end testRowspanChangesWhenYouDeleteTheLastRow()


    /**
     * Test the move icons for a row.
     *
     * @return void
     */
    public function testMoveIconsInTheRowToolbar()
    {
        $this->insertTable();
        $this->showTools(0, 'row');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveRowDown.png'), 'Move row down should be active');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveRowUp_disabled.png'), 'Move row up should not be active');

        $this->showTools(10, 'row');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveRowDown_disabled.png'), 'Move row down should not be active');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveRowUp.png'), 'Move row up should be active');

        $this->showTools(5, 'row');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveRowDown.png'), 'Move row down should be active');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveRowUp.png'), 'Move row up should be active');

    }//end testMoveIconsInTheRowToolbar()


    /**
     * Test that header ids are removed from the table when you remove a header row.
     *
     * @return void
     */
    public function testHeaderIdsRemovedWhenYouRemoveHeaderRow()
    {
        $this->selectText('dolor');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3,4, 2, "test")');
        sleep(2);

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4"></td></tr></tbody></table>');

        $this->showTools(0, 'row');
        $isHeadingField = $this->find($this->getImg('icon_isHeading_active.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

        $isHeadingField = $this->find($this->getImg('icon_isHeading.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4"></td></tr></tbody></table>');

    }//end testHeaderIdsRemovedWhenYouRemoveHeaderRow()


}//end class

?>
