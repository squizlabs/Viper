<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_ColumnUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Test that creating a new table works.
     *
     * @return void
     */
    public function testColumnToolIconsCorrect()
    {
        $this->showTools(0, 'col');

        $this->assertTrue($this->exists($this->getImg('col_tools.png')));

    }//end testColumnToolIconsCorrect()


      /**
     * Test adding a new table and then adding new columns.
     *
     * @return void
     */
    public function testAddingAndDeletingColumnsInANewTable()
    {
        $this->insertTable();

        $this->showTools(2, 'col');

        //Add a new column after the first column of the table
        $this->click($this->find($this->getImg('icon_insertColAfter.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

        //Add a new column before the first column of the table
        $this->click($this->find($this->getImg('icon_insertColBefore.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

        //Delete the column
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testAddingAndDeletingColumnsInANewTable()

    
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

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(
                      array('colspan' => 2),
                      array('rowspan' => 2),
                      array(),
                      array('colspan' => 3),
                     ),
                     array(
                      array(),
                      array(),
                      array(),
                      array('content' => 'Male'),
                      array(),
                      array('content' => 'Female'),
                     ),
                     array(array(), array(), array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(
                      array('colspan' => 2),
                      array('rowspan' => 2),
                      array(),
                      array('colspan' => 2),
                     ),
                     array(
                      array(),
                      array(),
                      array(),
                      array(),
                      array('content' => 'Female'),
                     ),
                     array(array(), array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

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

        $struct   = $this->getTableStructure(0, TRUE);
        $expected = array(
                     array(
                      array('colspan' => 2, 'content' => ' Survey '),
                      array('rowspan' => 2, 'content' => 'All Genders'),
                      array('content' => 'By Gender '),
                     ),
                     array(
                      array(),
                      array(),
                      array('content' => 'Male'),
                     ),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testColspanChangesWhenYouDeleteTheLastColumn()
      

    /**
     * Test that the 'By Gender' colspan changes when you the first column of the merged cell.
     *
     * @return void
     */
    public function testColspanChangesWhenYouDeleteTheFirstColumnOfMergedCell()
    {
        $this->showTools(5, 'col');

        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $struct   = $this->getTableStructure(0, TRUE);
        $expected = array(
                     array(
                      array('colspan' => 2, 'content' => ' Survey '),
                      array('rowspan' => 2, 'content' => 'All Genders'),
                      array('content' => 'By Gender '),
                     ),
                     array(
                      array(),
                      array(),
                      array('content' => 'Females'),
                     ),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testColspanChangesWhenYouDeleteTheFirstColumnOfMergedCell()
    
    
    /**
     * Test that inserting columns work.
     *
     * @return void
     */
    public function testColInsert()
    {
        $this->showTools(2, 'col');

        $this->click($this->find($this->getImg('icon_insertColBefore.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_insertColAfter.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(
                      array('colspan' => 2),
                      array('rowspan' => 2),
                      array(),
                      array('colspan' => 2),
                      array(),
                     ),
                     array(array(), array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testColInsert()


    /**
     * Test that inserting columns work.
     *
     * @return void
     */
    public function testColInsert2()
    {
        $this->showTools(5, 'col');

        $this->click($this->find($this->getImg('icon_insertColBefore.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_insertColAfter.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(
                      array('colspan' => 2),
                      array('rowspan' => 2),
                      array(),
                      array('colspan' => 3),
                     ),
                     array(array(), array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array(), array(), array()),
                     array(array(), array(), array(), array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testColInsert2()


    /**
     * Test that removing columns work.
     *
     * @return void
     */
    public function testColRemove()
    {
        $this->showTools(6, 'col');

        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(
                      array('colspan' => 2),
                      array('rowspan' => 2),
                      array(),
                     ),
                     array(array(), array(), array()),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testColRemove()


    /**
     * Test that removing columns work.
     *
     * @return void
     */
    public function testColRemove2()
    {
        $this->showTools(5, 'col');

        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(
                      array('colspan' => 2),
                      array('rowspan' => 2),
                      array(),
                     ),
                     array(array(), array(), array()),
                     array(array(), array(), array(), array()),
                     array(array(), array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testColRemove2()


}//end class

?>
