<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_SubscriptUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testStartOfParaSubscript()
    {
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><sub>%1%</sub> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStartOfParaSubscript()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaSubscript()
    {
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <sub>%2%</sub> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testMidOfParaSubscript()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaSubscript()
    {
        $this->selectKeyword(3);

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% %2% <sub>%3%</sub></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testEndOfParaSubscript()


    /**
     * Test that strikethrough is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemovingFormatFromPartOfTheContent()
    {
        $this->selectKeyword(2, 3);

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <sub>%2% %3%</sub></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->selectKeyword(3);

        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>%1% <sub>%2% </sub>%3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

    }//end testRemovingFormatFromPartOfTheContent()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript');

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('subscript');

        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('subscript');

        $this->assertHTMLMatch('<p><sub>%1% %2% %3%</sub></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('subscript');

        $this->assertHTMLMatch('<p><sub>%1%</sub> <sub>%2%</sub> <sub>%3%</sub></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that subscript can be removed.
     *
     * @return void
     */
    public function testRemoveFormating()
    {
        $this->selectKeyword(5);

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong><sub>%5%</sub></strong></p>');

        $this->selectKeyword(5);

        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon is still active in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testRemoveFormating()


    /**
     * Test that the subscript icon is active when you select a word that has strikethrough applied.
     *
     * @return void
     */
    public function testIconsIsActive()
    {
        $this->selectKeyword(5);

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->selectKeyword(5);
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

    }//end testIconsIsActive()


    /**
     * Test that you can undo subscript after you have applied it.
     *
     * @return void
     */
    public function testUndoSubscript()
    {
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <sub>%2%</sub> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar should not be active');

    }//end testUndoSubscript()



}//end class

?>
