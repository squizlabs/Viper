<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_ColumnUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Test that correct column icons appear in the toolbar.
     *
     * @return void
     */
    public function testColumnToolIconsCorrect()
    {
        $this->insertTable();

        $this->showTools(0, 'col');
        $this->assertTrue($this->exists($this->getImg('col_tools.png')));

        $this->clickCell(1);
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_createTable_active.png');
        $columnIcon = $this->find($this->getImg('icon_tools_col.png'));
        $this->click($columnIcon);
        sleep(1);

        $this->assertTrue($this->exists($this->getImg('col_tools.png')));

    }//end testColumnToolIconsCorrect()


    /**
     * Test changing the width of columns.
     *
     * @return void
     */
    public function testChangingColumnWidth()
    {
        $this->insertTable();

        // Change the width of the first column and click Update Changes
        $this->showTools(0, 'col');
        $widthField = $this->find($this->getImg('input_width.png'));
        $this->click($widthField);
        $this->type('50');
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%; " border="1"><tbody><tr><td style="width: 50px;">&nbsp;</td><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the width of the last column and press enter
        $this->showTools(3, 'col');
        $widthField = $this->find($this->getImg('input_width.png'));
        $this->click($widthField);
        $this->type('100');
        $this->keyDown('Key.ENTER');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%; " border="1"><tbody><tr><td style="width: 50px; ">&nbsp;</td><th>&nbsp;</th><th>&nbsp;</th><td style="width: 100px;">&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

    }//end testChangingColumnWidth()


    /**
     * Test adding a new table without headers and then changing the settings of columns.
     *
     * @return void
     */
    public function testColumnsInANewTableWithoutHeaders()
    {
        $textLoc = $this->find('IPSUM');

        $this->insertTableWithNoHeaders();
        $this->clickCell(0);
        usleep(300);
        $this->type('One');
        $this->keyDown('Key.TAB');
        $this->type('Two');
        $this->keyDown('Key.TAB');
        $this->type('Three');
        $this->keyDown('Key.TAB');
        $this->type('Four');

        $this->showTools(2, 'col');

        // Add a new column after the third column of the table
        $this->click($this->find($this->getImg('icon_insertColAfter.png'), NULL, 0.83));
        sleep(1);

        // Add a new column before the third column of the table
        $this->click($this->find($this->getImg('icon_insertColBefore.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;One</td><td>Two&nbsp;</td><td>&nbsp;</td><td>Three&nbsp;</td><td>&nbsp;</td><td>Four&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Delete the third column
        $this->showTools(2, 'col');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;One</td><td>Two&nbsp;</td><td>Three&nbsp;</td><td>&nbsp;</td><td>Four&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second column left
        $this->showTools(2, 'col');
        $this->click($this->find($this->getImg('icon_moveColLeft.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;One</td><td>Three&nbsp;</td><td>Two&nbsp;</td><td>&nbsp;</td><td>Four&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the third column right
        $this->showTools(2, 'col');
        $this->click($this->find($this->getImg('icon_moveColRight.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;One</td><td>Three&nbsp;</td><td>&nbsp;</td><td>Two&nbsp;</td><td>Four&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the first colum to be a header column
        $this->showTools(0, 'col');
        $isHeadingField = $this->find($this->getImg('icon_isHeading.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><td>Three&nbsp;</td><td>&nbsp;</td><td>Two&nbsp;</td><td>Four&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');


    }//end testColumnsInANewTableWithoutHeaders()


    /**
     * Test adding a new table with left headers and then adding new columns.
     *
     * @return void
     */
    public function testColumnsInANewTableWithLeftHeaders()
    {
        $textLoc = $this->find('IPSUM');
        $this->insertTableWithLeftHeaders();
        $this->clickCell(0);
        usleep(300);
        $this->type('One');
        $this->keyDown('Key.TAB');
        $this->type('Two');
        $this->keyDown('Key.TAB');
        $this->type('Three');
        $this->keyDown('Key.TAB');
        $this->type('Four');

        $this->showTools(1, 'col');

        //Add a new column before the second column in the table
        $this->click($this->find($this->getImg('icon_insertColBefore.png'), NULL, 0.83));
        sleep(1);

        //Add a new column after the first column of the table
        $this->showTools(0, 'col');
        $this->click($this->find($this->getImg('icon_insertColAfter.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>&nbsp;</th><td>&nbsp;</td><td>Two&nbsp;</td><td>Three&nbsp;</td><td>Four&nbsp;</td></tr><tr><th>&nbsp;</th><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        //Delete the second column
        $this->showTools(1, 'col');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><td>&nbsp;</td><td>Two&nbsp;</td><td>Three&nbsp;</td><td>Four&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second column left
        $this->showTools(2, 'col');
        $this->click($this->find($this->getImg('icon_moveColLeft.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><td>Two&nbsp;</td><td>&nbsp;</td><td>Three&nbsp;</td><td>Four&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second column right
        $this->showTools(2, 'col');
        $this->click($this->find($this->getImg('icon_moveColRight.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><td>Two&nbsp;</td><td>Three&nbsp;</td><td>&nbsp;</td><td>Four&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the first colum not to be a header column
        $this->showTools(0, 'col');
        $isHeadingField = $this->find($this->getImg('icon_isHeading_active.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;One</td><td>Two&nbsp;</td><td>Three&nbsp;</td><td>&nbsp;</td><td>Four&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the third colum not to be a header column
        $this->showTools(2, 'col');
        $isHeadingField = $this->find($this->getImg('icon_isHeading.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;One</td><td>Two&nbsp;</td><th>Three&nbsp;</th><td>&nbsp;</td><td>Four&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');


    }//end testColumnsInANewTableWithLeftHeaders()


    /**
     * Test adding a new table with top headers and then adding new columns.
     *
     * @return void
     */
    public function testColumnsInANewTableWithTopHeaders()
    {

        $textLoc = $this->find('IPSUM');
        $this->insertTable();
        $this->clickCell(0);
        usleep(300);
        $this->type('One');
        $this->keyDown('Key.TAB');
        $this->type('Two');
        $this->keyDown('Key.TAB');
        $this->type('Three');
        $this->keyDown('Key.TAB');
        $this->type('Four');

        $this->showTools(1, 'col');

        //Add a new column before the second column in the table
        $this->click($this->find($this->getImg('icon_insertColBefore.png'), NULL, 0.83));
        sleep(1);

        //Add a new column after the first column of the table
        $this->showTools(0, 'col');
        $this->click($this->find($this->getImg('icon_insertColAfter.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>&nbsp;</th><th>&nbsp;</th><th>Two&nbsp;</th><th>Three&nbsp;</th><th>Four&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        //Delete the second column
        $this->showTools(1, 'col');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>&nbsp;</th><th>Two&nbsp;</th><th>Three&nbsp;</th><th>Four&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second column left
        $this->showTools(2, 'col');
        $this->click($this->find($this->getImg('icon_moveColLeft.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>Two&nbsp;</th><th>&nbsp;</th><th>Three&nbsp;</th><th>Four&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second column right
        $this->showTools(2, 'col');
        $this->click($this->find($this->getImg('icon_moveColRight.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>Two&nbsp;</th><th>Three&nbsp;</th><th>&nbsp;</th><th>Four&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the first colum to be a header column
        $this->showTools(0, 'col');
        $isHeadingField = $this->find($this->getImg('icon_isHeading.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>Two&nbsp;</th><th>Three&nbsp;</th><th>&nbsp;</th><th>Four&nbsp;</th></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the third colum not to be a header column
        $this->showTools(2, 'col');
        $isHeadingField = $this->find($this->getImg('icon_isHeading.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>Two&nbsp;</th><th>Three&nbsp;</th><th>&nbsp;</th><th>Four&nbsp;</th></tr><tr><th>&nbsp;</th><td>&nbsp;</td><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

    }//end testColumnsInANewTableWithTopHeaders()


    /**
     * Test adding a new table with both headers and then adding new columns.
     *
     * @return void
     */
    public function testColumnsInANewTableWithBothHeaders()
    {

        $textLoc = $this->find('IPSUM');
        $this->insertTableWithBothHeaders();
        $this->clickCell(0);
        usleep(300);
        $this->type('One');
        $this->keyDown('Key.TAB');
        $this->type('Two');
        $this->keyDown('Key.TAB');
        $this->type('Three');
        $this->keyDown('Key.TAB');
        $this->type('Four');

        $this->showTools(1, 'col');

        //Add a new column before the second column in the table
        $this->click($this->find($this->getImg('icon_insertColBefore.png'), NULL, 0.83));
        sleep(1);

        //Add a new column after the first column of the table
        $this->showTools(0, 'col');
        $this->click($this->find($this->getImg('icon_insertColAfter.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>&nbsp;</th><th>&nbsp;</th><th>Two&nbsp;</th><th>Three&nbsp;</th><th>Four&nbsp;</th></tr><tr><th>&nbsp;</th><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        //Delete the second column
        $this->showTools(1, 'col');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>&nbsp;</th><th>Two&nbsp;</th><th>Three&nbsp;</th><th>Four&nbsp;</th></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second column left
        $this->showTools(2, 'col');
        $this->click($this->find($this->getImg('icon_moveColLeft.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>Two&nbsp;</th><th>&nbsp;</th><th>Three&nbsp;</th><th>Four&nbsp;</th></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second column right
        $this->showTools(2, 'col');
        $this->click($this->find($this->getImg('icon_moveColRight.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>Two&nbsp;</th><th>Three&nbsp;</th><th>&nbsp;</th><th>Four&nbsp;</th></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the third colum to be a header column
        $this->showTools(2, 'col');
        $isHeadingField = $this->find($this->getImg('icon_isHeading.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>Two&nbsp;</th><th>Three&nbsp;</th><th>&nbsp;</th><th>Four&nbsp;</th></tr><tr><th>&nbsp;</th><td>&nbsp;</td><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the first colum not to be a header column
        $this->showTools(0, 'col');
        $isHeadingField = $this->find($this->getImg('icon_isHeading_active.png'));
        $this->click($isHeadingField);
        sleep(1);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;One</td><th>Two&nbsp;</th><th>Three&nbsp;</th><th>&nbsp;</th><th>Four&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');


    }//end testColumnsInANewTableWithBothHeaders()


    /**
     * Test that the 'By Genders' colspan changes to three when you add a new column and goes back to two when you delete a new column.
     *
     * @return void
     */
    public function testColspanChangesWhenNewColumnAdded()
    {
        $this->showTools(5, 'col');

        $this->click($this->find($this->getImg('icon_insertColAfter.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_insertColBefore.png'), NULL, 0.83));

        $this->click($this->find('IPSUM'));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td>&nbsp;</td><td style="width: 100px;" colspan="3">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>&nbsp;</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

        $this->showTools(8, 'col');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td>&nbsp;</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

    }//end testColspanChangesWhenNewColumnAdded()


    /**
     * Test that the 'By Gender' colspan changes when you delete the last column from the table.
     *
     * @return void
     */
    public function testColspanChangesWhenYouDeleteTheLastColumn()
    {
        $this->showTools(6, 'col');

        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->click($this->find('IPSUM'));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');


    }//end testColspanChangesWhenYouDeleteTheLastColumn()


    /**
     * Test that the 'By Gender' colspan changes when you delete the first column of the merged cell.
     *
     * @return void
     */
    public function testColspanChangesWhenYouDeleteTheFirstColumnOfMergedCell()
    {
        $this->showTools(5, 'col');

        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->click($this->find('IPSUM'));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');


    }//end testColspanChangesWhenYouDeleteTheFirstColumnOfMergedCell()


    /**
     * Test the move icons for a column.
     *
     * @return void
     */
    public function testMoveIconsInTheColumnToolbar()
    {
        $this->insertTable();
        $this->showTools(0, 'col');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveColRight.png'), 'Move column right should be active');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveColLeft_disabled.png'), 'Move column left should not be active');

        $this->showTools(3, 'col');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveColRight_disabled.png'), 'Move column right should not be active');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveColLeft.png'), 'Move column left should be active');

        $this->showTools(2, 'col');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveColRight.png'), 'Move column right should be active');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveColLeft.png'), 'Move column left should be active');

        $this->showTools(1, 'col');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveColRight.png'), 'Move column right should be active');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/icon_moveColLeft.png'), 'Move column left should be active');

    }//end testMoveIconsInTheColumnToolbar()


}//end class

?>
