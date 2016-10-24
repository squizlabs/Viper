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

        $this->clickKeyword(1);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

    }//end testNoListToolsForAHeading()


}//end class

?>
