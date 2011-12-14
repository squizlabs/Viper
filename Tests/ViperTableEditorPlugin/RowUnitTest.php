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
     * Test that creating a new table works.
     *
     * @return void
     */
    public function testRowInsert()
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

    }//end testRowInsert()


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
