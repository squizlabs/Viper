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
        $this->useTest(1);
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
        $this->useTest(1);
        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <sup>%2% %3%</sup></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove superscript from one keyword
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% %2%<sup> %3%</sup></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove superscript from the other keyword
        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('superscript', 'active');
        sleep(1);
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
        $this->useTest(1);
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
        $this->useTest(1);
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
        $this->useTest(1);
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <sup>%2%</sup> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <sup>%2%</sup> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');


    }//end testUndoAndRedoSuperscript()


    /**
     * Test that you cannot have both subscript and superscript on the same item.
     *
     * @return void
     */
    public function testSuperscriptAndSubscript()
    {
        $this->assertTrue(TRUE);
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'disabled'));
        $this->assertHTMLMatch('<p><sup>%1%</sup> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testSuperscriptAndSubscript()

    /**
     * Test applying and removing superscript for a link in the content of a page.
     *
     * @return void
     */
    public function testAddAndRemoveSuperscriptForLink()
    {
        $this->useTest(2);

        $this->moveToKeyword(1);
        sleep(1);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<p>Test content <sup><a href="http://www.squizlabs.com">%1%</a></sup> more test content.</p>');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'superscript icon should be active');

        $this->moveToKeyword(1);
        sleep(1);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> more test content.</p>');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'superscript icon should not be active');

    }//end testAddAndRemoveSuperscriptForLink()

}//end class

?>
