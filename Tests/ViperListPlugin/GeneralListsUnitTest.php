<?php
require_once 'AbstractViperListPluginUnitTest.php';


class Viper_Tests_ViperListPlugin_GeneralListsUnitTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test that list tools are not available when select a heading.
     *
     * @return void
     */
    public function testNoListToolsForAHeading()
    {
        $this->useTest(1);

        $this->click($this->findKeyword(1));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testNoListToolsForAHeading()


    /**
     * Test that list tools are available for a paragraph.
     *
     * @return void
     */
    public function testListToolsAvailableForAParagraph()
    {
        $this->useTest(2);

        // Test single line paragraph
        $this->click($this->findKeyword(1));
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        // Test multi-line paragraph
        $this->click($this->findKeyword(2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectKeyword(2);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListToolsAvailableForAParagraph()


    /**
     * Test that list tools are not available for a pre section.
     *
     * @return void
     */
    public function testListToolsAreNotAvailableForAPre()
    {
        $this->useTest(3);

        // Test single line pre
        $this->click($this->findKeyword(1));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test multi-line pre
        $this->click($this->findKeyword(2));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

    }//end testListToolsAreNotAvailableForAPre()


    /**
     * Test that list tools are not available for a quote section.
     *
     * @return void
     */
    public function testListToolsAreNotAvailableForAQuote()
    {
        $this->useTest(4);

        // Test single line quote
        $this->click($this->findKeyword(1));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test multi-line quote
        $this->click($this->findKeyword(2));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test quote section inside multiple P's
        $this->click($this->findKeyword(3));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->click($this->findKeyword(4));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(4);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(4);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

    }//end testListToolsAreNotAvailableForAQuote()


    /**
     * Test that list tools are not available for a div section.
     *
     * @return void
     */
    public function testListToolsAreNotAvailableForADiv()
    {
        $this->useTest(5);

        // Test single line div
        $this->click($this->findKeyword(1));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        // Test multi-line div
        $this->click($this->findKeyword(2));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListToolsAreNotAvailableForADiv()


    /**
     * Test that list tools are available for P sections inside a Div section.
     *
     * @return void
     */
    public function testListToolsAvailableForPSectionsInsideDivSection()
    {
        $this->useTest(6);

        // Test one P inside a Div
        $this->click($this->findKeyword(1));
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        // Test two P's inside a div
        $this->click($this->findKeyword(2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->click($this->findKeyword(3));
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListToolsAvailableForPSectionsInsideDivSection()


    /**
     * Test that list tools are not available for Div sections inside a Div section.
     *
     * @return void
     */
    public function testListToolsNotAvailableForDivSectionsInsideDivSection()
    {
        $this->useTest(7);

        // Test one Div inside a Div
        $this->click($this->findKeyword(1));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        // Test two P's inside a div
        $this->click($this->findKeyword(2));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->click($this->findKeyword(3));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListToolsAvailableForPSectionsInsideDivSection()


    /**
     * Test that list tools are not available for quote sections inside a Div section.
     *
     * @return void
     */
    public function testListToolsNotAvailableForQuoteSectionsInsideDivSection()
    {
        $this->useTest(8);

        // Test one quote inside a Div
        $this->click($this->findKeyword(1));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test two quote's inside a div
        $this->click($this->findKeyword(2));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->click($this->findKeyword(3));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

    }//end testListToolsNotAvailableForQuoteSectionsInsideDivSection()


    /**
     * Test that list tools are not available for Pre sections inside a Div section.
     *
     * @return void
     */
    public function testListToolsNotAvailableForPreSectionsInsideDivSection()
    {
        $this->useTest(9);

        // Test one Pre inside a Div
        $this->click($this->findKeyword(1));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test two Pre's inside a div
        $this->click($this->findKeyword(2));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->click($this->findKeyword(3));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

    }//end testListToolsNotAvailableForPreSectionsInsideDivSection()


    /**
     * Test list tools in a table.
     *
     * @return void
     */
    public function testListToolsIconsInATable()
    {
        $this->useTest(10);

        // Test in a caption
        $this->click($this->findKeyword(1));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test in a header section
        $this->click($this->findKeyword(2));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test in the footer section
        $this->click($this->findKeyword(3));
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test in the body section
        $this->click($this->findKeyword(4));
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectKeyword(4);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

    }//end testListToolsIconsInATable()

}//end class

?>
