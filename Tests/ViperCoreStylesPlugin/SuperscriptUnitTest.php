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

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        //$this->selectKeyword(2, 3);
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

        $this->clickKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> more test content.</p>');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'superscript icon should not be active');

    }//end testAddAndRemoveSuperscriptForLink()


    /**
     * Test that you can remove superscript from two different sections of content at the same time.
     *
     * @return void
     */
    public function testRemovingSuperscriptFromDifferentSectionsInContent()
    {
        // Remove using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('superscript', 'active');

        // Perform the check using raw html as there is a bug that removes the space after 'more' when it removes the superscript formatting
        $this->assertEquals('<p>Text <sup>more </sup>%1%text text and more%2%<sup> text</sup></p>', $this->getRawHtml());

        // Reapply using top toolbar
        $this->clickTopToolbarButton('superscript');
        $this->assertEquals('<p>Text <sup>more %1%text text and more%2% text</sup></p>', $this->getRawHtml());

    }//end testRemovingSuperscriptFromDifferentSectionsInContent()


    /**
     * Test deleting superscript content
     *
     * @return void
     */
    public function testDeletingSuperscriptContent()
    {
        // Test selecting a single word and replacing with new content
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sup>this is new content</sup></p><p>Some more superscript <sup>%2% %3%</sup> content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content this is new content</p><p>Some more superscript <sup>%2% %3%</sup> content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content this is new content</p><p>Some more superscript <sup>%2% %3%</sup> content to test</p>');

        // Test replacing superscript section with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(2, 3);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sup>%1%</sup></p><p>Some more superscript <sup>test</sup> content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sup>%1%</sup></p><p>Some more superscript test content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sup>%1%</sup></p><p>Some more superscript test content to test</p>');

        // Test replacing superscript content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sup>%1%</sup></p><p>Some more superscript <sup>test</sup> content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sup>%1%</sup></p><p>Some more superscript test content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sup>%1%</sup></p><p>Some more superscript test content to test</p>');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('<p>test</p>');

    }//end testDeletingSuperscriptContent()


    /**
     * Test editing superscript content
     *
     * @return void
     */
    public function testEditingSuperscriptContent()
    {

        $this->useTest(4);

        // Test adding content to the start of the superscript formatting
        $this->moveToKeyword(2, 'left');
        $this->type('test ');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sup>%1%</sup></p><p>Some more superscript <sup>test %2% %3%</sup> content to test</p>');

        // Test adding content in the middle of superscript formatting
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sup>%1%</sup></p><p>Some more superscript <sup>test %2% test %3%</sup> content to test</p>');

        // Test adding content to the end of superscript formatting
        $this->moveToKeyword(3, 'right');
        $this->type(' %4%');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sup>%1%</sup></p><p>Some more superscript <sup>test %2% test %3% %4%</sup> content to test</p>');

        // Test highlighting some content in the superscript tags and replacing it
        $this->selectKeyword(3);
        $this->type('abc');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sup>%1%</sup></p><p>Some more superscript <sup>test %2% test abc %4%</sup> content to test</p>');

        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('abc');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sup>%1%</sup></p><p>Some more superscript <sup>test abc test abc %4%</sup> content to test</p>');

        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <sup>%1%</sup></p><p>Some more superscript <sup>test abc test abc test</sup> content to test</p>');

    }//end testEditingSuperscriptContent()


    /**
     * Test adding content before and after superscript content
     *
     * @return void
     */
    public function testAddingContentAroundSuperscriptContent()
    {
        // Test adding content before superscript content when cursor starts inside the superscript content
        $this->useTest(6);
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('new');
        $this->assertHTMLMatch('<p>%1% new<sup>%2%</sup> %3%</p>');

        // Test adding content before superscript content when cursor starts elsewhere in content
        $this->useTest(6);
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('new');
        $this->assertHTMLMatch('<p>%1% new<sup>%2%</sup> %3%</p>');

        // Test adding content after superscript content when cursor starts inside the superscript content
        $this->useTest(6);
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('new');
        $this->assertHTMLMatch('<p>%1% <sup>%2%new</sup> %3%</p>');

        // Test adding content before superscript content when cursor starts elsewhere in content
        $this->useTest(6);
        $this->clickKeyword(3);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('new');
        $this->assertHTMLMatch('<p>%1% <sup>%2%new</sup> %3%</p>');

    }//end testAddingContentAroundSuperscriptContent()

}//end class

?>
