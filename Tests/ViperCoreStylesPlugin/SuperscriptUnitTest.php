<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_SuperscriptUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied and removed from various sections of a paragraph.
     *
     * @return void
     */
    public function testAddAndRemoveSuperscript()
    {
        // apply and remove from the start of a paragraph
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p><sup>%1%</sup> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Apply and remove from the middle of a paragraph
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <sup>%2%</sup> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Apply and remove from the end of a paragraph
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% %2% <sup>%3%</sup></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAddAndRemoveSuperscript()


    /**
     * Test that superscript is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemoveSuperscriptFromPartOfTheContent()
    {
        // Apply superscript to multiple keywords
        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <sup>%2% %3%</sup></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove superscript from one keyword
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% <sup>%2% </sup>%3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove superscript from the other keyword
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testRemoveSuperscriptFromPartOfTheContent()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentSuperscriptStyling()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript');

        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('superscript');

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('superscript');

        $this->assertHTMLMatch('<p><sup>%1% %2% %3%</sup></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAdjacentSuperscriptStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedSuperscriptStyling()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('superscript');

        $this->assertHTMLMatch('<p><sup>%1%</sup> <sup>%2%</sup> <sup>%3%</sup></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testSpaceSeparatedSuperscriptStyling()


    /**
     * Test that you can undo superscript after you have applied it and then redo it.
     *
     * @return void
     */
    public function testUndoAndRedoSuperscript()
    {
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <sup>%2%</sup> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <sup>%2%</sup> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testUndoAndRedoSuperscript()

}//end class

?>
