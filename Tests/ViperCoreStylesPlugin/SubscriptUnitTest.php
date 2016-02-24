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


    /**
     * Test that you can remove subscript from two different sections of content at the same time.
     *
     * @return void
     */
    public function testRemovingSubscriptFromDifferentSectionsInContent()
    {
        // Remove using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('subscript', 'active');

        // Perform the check using raw html as there is a bug that removes the space after 'more' when it removes the subscript formatting
        $this->assertEquals('<p>Text <sub>more </sub>%1%text text and more%2%<sub> text</sub></p>', $this->getRawHtml());

        // Reapply using top toolbar
        $this->clickTopToolbarButton('subscript');
        $this->assertEquals('<p>Text <sub>more %1%text text and more%2% text</sub></p>', $this->getRawHtml());

    }//end testRemovingSubscriptFromDifferentSectionsInContent()


    /**
     * Test deleting subscript content
     *
     * @return void
     */
    public function testDeletingSubscriptContent()
    {
        // Test selecting a single word and replacing with new content
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sub>this is new content</sub></p><p>Some more subscript <sub>%2% %3%</sub> content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content this is new content</p><p>Some more subscript <sub>%2% %3%</sub> content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content this is new content</p><p>Some more subscript <sub>%2% %3%</sub> content to test</p>');

        // Test replacing subscript section with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(2, 3);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sub>%1%</sub></p><p>Some more subscript <sub>test</sub> content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sub>%1%</sub></p><p>Some more subscript test content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sub>%1%</sub></p><p>Some more subscript test content to test</p>');

        // Test replacing subscript content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sub>%1%</sub></p><p>Some more subscript <sub>test</sub> content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sub>%1%</sub></p><p>Some more subscript test content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sub>%1%</sub></p><p>Some more subscript test content to test</p>');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('<p>test</p>');

    }//end testDeletingSubscriptContent()


    /**
     * Test editing subscript content
     *
     * @return void
     */
    public function testEditingSubscriptContent()
    {

        $this->useTest(4);

        // Test adding content to the start of the subscript formatting
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sub>%1%</sub></p><p>Some more subscript test <sub>%2% %3%</sub> content to test</p>');

        // Test adding content in the middle of subscript formatting
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sub>%1%</sub></p><p>Some more subscript test <sub>%2% test %3%</sub> content to test</p>');

        // Test adding content to the end of subscript formatting
        $this->clickKeyword(3);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' %4%');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sub>%1%</sub></p><p>Some more subscript test <sub>%2% test %3% %4%</sub> content to test</p>');

        // Test highlighting some content in the subscript tags and replacing it
        $this->selectKeyword(3);
        $this->type('abc');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sub>%1%</sub></p><p>Some more subscript test <sub>%2% test abc %4%</sub> content to test</p>');

        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('abc');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sub>%1%</sub></p><p>Some more subscript test <sub>abc test abc %4%</sub> content to test</p>');

        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sub>%1%</sub></p><p>Some more subscript test <sub>abc test abc test</sub> content to test</p>');

    }//end testEditingSubscriptContent()


    /**
     * Test adding content before and after subscript content
     *
     * @return void
     */
    public function testAddingContentAroundSubscriptContent()
    {
        // Test adding content before subscript content when cursor starts inside the subscript content
        $this->useTest(6);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('new ');
        $this->assertHTMLMatch('<p>%1% <sub>new a %2% b</sub> %3%</p>');

        // Test adding content before subscript content when cursor starts elsewhere in content
        $this->useTest(6);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('new ');
        $this->assertHTMLMatch('<p>%1% <sub>new a %2% b</sub> %3%</p>');

        // Test adding content after subscript content when cursor starts inside the subscript content
        $this->useTest(6);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' new');
        $this->assertHTMLMatch('<p>%1% <sub>a %2% b new</sub> %3%</p>');

        // Test adding content before subscript content when cursor starts elsewhere in content
        $this->useTest(6);
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type(' new');
        $this->assertHTMLMatch('<p>%1% <sub>a %2% b new</sub> %3%</p>');

    }//end testAddingContentAroundSubscriptContent()

}//end class

?>
