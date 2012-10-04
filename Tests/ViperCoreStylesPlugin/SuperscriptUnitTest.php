<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_SuperscriptUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testStartOfParaSuperscript()
    {
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><sup>%1%</sup> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStartOfParaSuperscript()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaSuperscript()
    {

        $this->selectKeyword(2);

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <sup>%2%</sup> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testMidOfParaSuperscript()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaSuperscript()
    {
        $this->selectKeyword(3);

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% %2% <sup>%3%</sup></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testEndOfParaSuperscript()


    /**
     * Test that superscript is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemovingFormatFromPartOfTheContent()
    {
        $this->selectKeyword(2, 3);

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <sup>%2% %3%</sup></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');

        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>%1% <sup>%2% </sup>%3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

    }//end testRemovingFormatFromPartOfTheContent()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript');

        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('superscript');

        $this->selectKeyword(1);
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('superscript');

        $this->assertHTMLMatch('<p><sup>%1% %2% %3%</sup></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectKeyword(2);
         $this->clickTopToolbarButton('superscript');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('superscript');

        $this->assertHTMLMatch('<p><sup>%1%</sup> <sup>%2%</sup> <sup>%3%</sup></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that subscripy can be removed.
     *
     * @return void
     */
    public function testRemoveFormating()
    {
        $this->selectKeyword(5);

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong><sup>%5%</sup></strong></p>');

        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon is still active in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testRemoveFormating()


    /**
     * Test that the superscript icon is active when you select a word that has superscript applied.
     *
     * @return void
     */
    public function testIconsIsActive()
    {
        $this->selectKeyword(5);

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

        $this->moveToKeyword(4, 'right');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

    }//end testIconsIsActive()


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
