<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_SubscriptUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that subscript can be applied and removed to different parts of a paragraph.
     *
     * @return void
     */
    public function testApplyAndRemoveSubscript()
    {
        // Apply and remove at the start of a paragraph
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p><sub>%1%</sub> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Apply and remove in the middle of a paragraph
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <sub>%2%</sub> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Apply and remove at the end of a paragraph
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% %2% <sub>%3%</sub></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testApplyAndRemoveSubscript()


    /**
     * Test that subscript is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemoveSubscriptFromPartOfTheContent()
    {
        // Apply strihethrough to multiple keywords
        $this->useTest(1);
        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <sub>%2% %3%</sub></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove it from one keyword
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% %2%<sub> %3%</sub></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove it from the other keyword
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testRemoveSubscriptFromPartOfTheContent()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentSubscriptStyling()
    {
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript');

        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('subscript');

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('subscript');

        $this->assertHTMLMatch('<p><sub>%1% %2% %3%</sub></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAdjacentSubscriptStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedSubscriptStyling()
    {
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('subscript');

        $this->assertHTMLMatch('<p><sub>%1%</sub> <sub>%2%</sub> <sub>%3%</sub></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testSpaceSeparatedSubscriptStyling()


    /**
     * Test that you can undo subscript after you have applied it and then redo it.
     *
     * @return void
     */
    public function testUndoAndRedoSubscript()
    {
        $this->useTest(1);
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <sub>%2%</sub> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <sub>%2%</sub> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testUndoAndRedoSubscript()


    /**
     * Test that you cannot have both subscript and superscript on the same item.
     *
     * @return void
     */
    public function testSubscriptAndSuperscript()
    {
        $this->assertTrue(TRUE);
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'disabled'));
        $this->assertHTMLMatch('<p><sub>%1%</sub> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testSubscriptAndSuperscript()


    /**
     * Test applying and removing subscript for a link in the content of a page.
     *
     * @return void
     */
    public function testAddAndRemoveSubscriptForLink()
    {
        $this->useTest(2);

        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('<p>Test content <sub><a href="http://www.squizlabs.com">%1%</a></sub> more test content.</p>');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'subscript icon should be active');

        $this->clickKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> more test content.</p>');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'subscript icon should not be active');

    }//end testAddAndRemoveSubscriptForLink()


}//end class

?>
