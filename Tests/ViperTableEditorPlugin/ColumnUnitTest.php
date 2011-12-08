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
