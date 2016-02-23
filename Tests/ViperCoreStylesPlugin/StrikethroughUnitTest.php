<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_StrikethroughUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that strikethrough can be applied and removed to different parts of a paragraph.
     *
     * @return void
     */
    public function testApplyAndRemoveStrikethrough()
    {
        // Apply and remove at the start of a paragraph
        $this->usetest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p><del>%1%</del> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Apply and remove in the middle of a paragraph
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Apply and remove at the end of a paragraph
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% %2% <del>%3%</del></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStartOfParaStrikethrough()


    /**
     * Test that strikethrough is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemoveStrikethroughFromPartOfTheContent()
    {
        // Apply format to multiple keywords
        $this->usetest(1);
        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <del>%2% %3%</del></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove from one keyword
        $this->clickKeyword(1);
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% <del>%2% </del>%3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove from second keyword
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testRemoveStrikethroughFromPartOfTheContent()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentStrikethroughStyling()
    {
        $this->usetest(1);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough');

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('strikethrough');

        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('strikethrough');

        $this->assertHTMLMatch('<p><del>%1% %2% %3%</del></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAdjacentStrikethroughStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedStrikethroughStyling()
    {
        $this->usetest(1);
        $this->selectKeyword(2);
         $this->clickTopToolbarButton('strikethrough');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough');

        $this->assertHTMLMatch('<p><del>%1%</del> <del>%2%</del> <del>%3%</del></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testSpaceSeparatedStrikethroughStyling()


    /**
     * Test that you can undo strikethrough after you have applied it and then redo it.
     *
     * @return void
     */
    public function testUndoAndRedoStrikethrough()
    {
        $this->usetest(1);
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testUndoAndRedoStrikethrough()


     /**
     * Test applying and removing strikethrough for a link in the content of a page.
     *
     * @return void
     */
    public function testAddAndRemoveStrikethroughForLink()
    {
        $this->useTest(2);

        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p>Test content <del><a href="http://www.squizlabs.com">%1%</a></del> more test content.</p>');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'strikethrough icon should be active');

        $this->moveToKeyword(1);
        sleep(1);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        sleep(1);
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> more test content.</p>');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'strikethrough icon should not be active');

    }//end testAddAndRemoveStrikethroughForLink()


    /**
     * Test that you can remove strikethrough from two different sections of content at the same time.
     *
     * @return void
     */
    public function testRemovingStrikethroughFromDifferentSectionsInContent()
    {
        // Remove using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Perform the check using raw html as there is a bug that removes the space after 'more' when it removes the strikethrough formatting
        $this->assertEquals('<p>Text <del>more </del>%1%text text and more%2%<del> text</del></p>', $this->getRawHtml());

        // Reapply using top toolbar
        $this->clickTopToolbarButton('strikethrough');
        $this->assertEquals('<p>Text <del>more %1%text text and more%2% text</del></p>', $this->getRawHtml());

    }//end testRemovingStrikethroughFromDifferentSectionsInContent()


    /**
     * Test deleting strikethrough content
     *
     * @return void
     */
    public function testDeletingStrikethroughContent()
    {
        // Test selecting a single word and replacing with new content
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>this is new content</del></p><p>Some more strikethrough <del>%2% %3%</del> content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content this is new content</p><p>Some more strikethrough <del>%2% %3%</del> content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content this is new content</p><p>Some more strikethrough <del>%2% %3%</del> content to test</p>');

        // Test replacing strikethrough section with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(2, 3);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough <del>test</del> content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough test content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough test content to test</p>');

        // Test replacing strikethrough content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough <del>test</del> content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough test content to test</p>');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough test content to test</p>');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('<p>test</p>');

    }//end testDeletingStrikethroughContent()


    /**
     * Test editing strikethrough content
     *
     * @return void
     */
    public function testEditingStrikethroughContent()
    {

        $this->useTest(4);

        // Test adding content to the start of the strikethrough formatting
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough test <del>%2% %3%</del> content to test</p>');

        // Test adding content in the middle of strikethrough formatting
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough test <del>%2% test %3%</del> content to test</p>');

        // Test adding content to the end of strikethrough formatting
        $this->clickKeyword(3);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' %4%');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough test <del>%2% test %3% %4%</del> content to test</p>');

        // Test highlighting some content in the strikethrough tags and replacing it
        $this->selectKeyword(3);
        $this->type('abc');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough test <del>%2% test abc %4%</del> content to test</p>');

        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('abc');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough test <del>abc test abc %4%</del> content to test</p>');

        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough test <del>abc test abc test</del> content to test</p>');

    }//end testEditingStrikethroughContent()


    /**
     * Test adding content before and after strikethrough content
     *
     * @return void
     */
    public function testAddingContentAroundStrikethroughContent()
    {
        // Test adding content before strikethrough content when cursor starts inside the strikethrough content
        $this->useTest(6);
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('new');
        $this->assertHTMLMatch('<p>%1% new<del>%2%</del> %3%</p>');

        // Test adding content before strikethrough content when cursor starts elsewhere in content
        $this->useTest(6);
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('new');
        $this->assertHTMLMatch('<p>%1% new<del>%2%</del> %3%</p>');

        // Test adding content after strikethrough content when cursor starts inside the strikethrough content
        $this->useTest(6);
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('new');
        $this->assertHTMLMatch('<p>%1% <del>%2%new</del> %3%</p>');

        // Test adding content before strikethrough content when cursor starts elsewhere in content
        $this->useTest(6);
        $this->clickKeyword(3);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('new');
        $this->assertHTMLMatch('<p>%1% <del>%2%new</del> %3%</p>');

    }//end testAddingContentAroundStrikethroughContent()


}//end class

?>
