<?php
require_once 'AbstractViperListPluginUnitTest.php';


class Viper_Tests_ViperListPlugin_HeadingsAndListsUnitTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test that list tools are not available when select a heading.
     *
     * @return void
     */
    public function testNoListToolsForAHeading()
    {
        $this->useTest(1);

        $this->sikuli->click($this->findKeyword(1));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testNoListToolsForAHeading()


}//end class

?>
