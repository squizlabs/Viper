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
        $classField = $this->find(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class.png');
        $this->click($classField);
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
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>One</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>Three</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table><p>dolor</p>');

        // Move the second row down
        $this->showTools(6, 'row');
        $this->click($this->find($this->getImg('icon_moveColRight.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>One</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>Three</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table><p>dolor</p>');

        // Change the first row to be a header column
        $this->showTools(0, 'row');
        $isHeadingField = $this->find($this->getImg('icon_isHeading.png'));
        $this->click($isHeadingField);
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr class="test"><th>One</th><th></th><th></th><th></th></tr><tr><td>Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr class="abc"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>Three</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table><p>dolor</p>');

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
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>One</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row down
        $this->showTools(6, 'row');
        $this->click($this->find($this->getImg('icon_moveColRight.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>One</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the first row to be a header column
        $this->showTools(0, 'row');
        $isHeadingField = $this->find($this->getImg('icon_isHeading.png'));
        $this->click($isHeadingField);
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr class="test"><th>One</th><th></th><th></th><th></th></tr><tr><td>Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr class="abc"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>Three</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table><p>dolor</p>');

        
    }//end testRowsInANewTableWithLeftHeaders()

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

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(
                      array('colspan' => 2),
                      array(),
                      array('colspan' => 2),
                     ),
                     array(
                      array('colspan' => 2),
                      array('rowspan' => 3),
                      array('colspan' => 2),
                     ),
                     array(
                      array('colspan' => 2),
                      array('colspan' => 2),
                     ),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(
                      array('colspan' => 2),
                      array(),
                      array('colspan' => 2),
                     ),
                     array(
                      array('colspan' => 2),
                      array('rowspan' => 2),
                      array('colspan' => 2),
                     ),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

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

        $struct   = $this->getTableStructure(0, TRUE);
        $expected = array(
                     array(
                      array(),
                      array(),
                      array('content' => 'All Genders'),
                      array('content' => 'Male'),
                      array('content' => 'Females'),
                     ),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

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

        $struct   = $this->getTableStructure(0, TRUE);
        $expected = array(
                     array(
                      array(
                       'colspan' => 2,
                       'content' => '&nbsp;Survey&nbsp;'
                      ),
                      array('content' => 'All Genders'),
                      array(
                       'colspan' => 2,
                       'content' => 'By Gender&nbsp;'
                      ),
                     ),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testRowspanChangesWhenYouDeleteTheLastRow()


    /**
     * Test that creating a new table works.
     *
     * @return void
     */
   /* public function testRowInsert2()
    {
        $this->showTools(0, 'row');

        $this->click($this->find($this->getImg('icon_insertRowAfter.png'), NULL, 0.83));

        $this->clickCell(2);

        $this->showTools(3, 'row');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(
                      array('colspan' => 2),
                      array('rowspan' => 2),
                      array('colspan' => 2),
                     ),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testRowInsert2()*/


    /**
     * Test that creating a new table works.
     *
     * @return void
     */
    /*public function testRowInsert3()
    {
        $this->showTools(1, 'row');

        $this->click($this->find($this->getImg('icon_insertRowAfter.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_insertRowBefore.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(
                      array('colspan' => 2),
                      array(),
                      array('colspan' => 2),
                     ),
                     array(
                      array('colspan' => 2),
                      array('rowspan' => 2),
                      array('colspan' => 2),
                     ),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testRowInsert3()*/


    /**
     * Test that creating a new table works.
     *
     * @return void
     */
   /* public function testRowInsert4()
    {
        $this->showTools(5, 'row');

        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(
                      array('colspan' => 2),
                      array(),
                      array('colspan' => 2),
                     ),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testRowInsert4()*/


    /**
     * Test that creating a new table works.
     *
     * @return void
     */
    public function testRowInsert5()
    {
        $this->showTools(2, 'row');

        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testRowInsert5()


}//end class

?>
