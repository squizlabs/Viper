<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_RowUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Test that creating a new table works.
     *
     * @return void
     */
    public function testRowToolIconsCorrect()
    {
        $this->showTools(0, 'row');

        $this->assertTrue($this->exists($this->getImg('row_tools.png')));

    }//end testRowToolIconsCorrect()


    /**
     * Test adding a new table and then adding new rows.
     *
     * @return void
     */
    public function testAddingAndDeletingRowsInANewTable()
    {
        $this->insertTable();

        $this->showTools(2, 'row');

        //Add a new row after the first row of the table
        $this->click($this->find($this->getImg('icon_insertRowAfter.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(array(), array(), array()),
                     array(array(), array(), array()),
                     array(array(), array(), array()),
                     array(array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

        //Add a new row before the first row of the table
        $this->click($this->find($this->getImg('icon_insertRowBefore.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(array(), array(), array()),
                     array(array(), array(), array()),
                     array(array(), array(), array()),
                     array(array(), array(), array()),
                     array(array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

        //Delete the row
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $struct   = $this->getTableStructure();
        $expected = array(
                     array(array(), array(), array()),
                     array(array(), array(), array()),
                     array(array(), array(), array()),
                     array(array(), array(), array()),
                    );

        $this->assertTableStructure($expected, $struct);

    }//end testAddingAndDeletingRowsInANewTable()


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

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p>
<p>sit amet <strong>consectetur</strong></p>
<table style="width: 300px;" border="1" cellspacing="2" cellpadding="2">
    <tbody>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>All Genders</td>
            <td>Male</td>
            <td>Females</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>');

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

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p>
            <table style="width: 300px;" border="1" cellpadding="2" cellspacing="2">
            <tbody>
            <tr>
            <td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td>
            <td>All Genders</td>
            <td style="width: 100px;" colspan="2">By Gender&nbsp;</td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
            </tbody></table>');

    }//end testRowspanChangesWhenYouDeleteTheLastRow()


    /**
     * Test that creating a new table works.
     *
     * @return void
     */
    public function testRowInsert2()
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

    }//end testRowInsert2()


    /**
     * Test that creating a new table works.
     *
     * @return void
     */
    public function testRowInsert3()
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

    }//end testRowInsert3()


    /**
     * Test that creating a new table works.
     *
     * @return void
     */
    public function testRowInsert4()
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

    }//end testRowInsert4()


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
