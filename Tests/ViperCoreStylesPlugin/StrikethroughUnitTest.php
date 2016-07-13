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
     * Test deleting content including content with strikethrough formatting
     *
     * @return void
     */
    public function testDeletingAndAddingContentWithStrikethroughFormatting()
    {
         // Check deleting a word after the strikethrough content
        $this->useTest(6);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% <del>a %2% b</del></p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% <del>a %2% b</del> content</p>');

        // Check deleting a word after the strikethrough content up to the strikethrough content
        $this->useTest(6);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% <del>a %2% b</del></p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% <del>a %2% bcontent</del></p>');

        // Check deleting from the end of the paragraph including strikethrough content
        $this->useTest(6);
        $this->moveToKeyword(3, 'right');

        for ($i = 0; $i < 11; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>%1%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% content</p>');

        // Check deleting from the start of the paragraph
        $this->useTest(6);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p><del>a %2% b</del> %3%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content <del>a %2% b</del> %3%</p>');

        // Check deleting from the start of the paragraph up to the strikethrough content
        $this->useTest(6);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p><del>a %2% b</del> %3%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p><del>contenta %2% b</del> %3%</p>');

        // Check deleting from the start of the paragraph including strikethrough content
        $this->useTest(6);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 11; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>%3%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content %3%</p>');

    }//end testDeletingAndAddingContentWithStrikethroughFormatting()


    /**
     * Test editing strikethrough content
     *
     * @return void
     */
    public function testEditingStrikethroughContent()
    {

        // Test adding content before the start of the strikethrough formatting
        $this->useTest(7);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('<p>Some %1% strikethrough test <del>%2% content %3% to test %4%</del> more %5% content</p>');

        // Test adding content in the middle of strikethrough formatting
        $this->useTest(7);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<p>Some %1% strikethrough <del>%2% test content %3% to test %4%</del> more %5% content</p>');

        // Test adding content to the end of strikethrough formatting
        $this->useTest(7);
        $this->moveToKeyword(4, 'left');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('<p>Some %1% strikethrough <del>%2% content %3% to test %4% test</del> more %5% content</p>');

        // Test highlighting some content in the del tags and replacing it
        $this->useTest(7);
        $this->selectKeyword(3);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% strikethrough <del>%2% content test to test %4%</del> more %5% content</p>');

        // Test highlighting the first word of the del tags and replace it. Should stay in del tag.
        $this->useTest(7);
        $this->selectKeyword(2);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% strikethrough <del>test content %3% to test %4%</del> more %5% content</p>');

        // Test hightlighting the first word, pressing forward + delete and replace it. Should be outside the del tag.
        $this->useTest(7);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% strikethrough test<del> content %3% to test %4%</del> more %5% content</p>');

        // Test highlighting the first word, pressing backspace and replace it. Should be outside the del tag.
        $this->useTest(7);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% strikethrough test<del> content %3% to test %4%</del> more %5% content</p>');

        // Test highlighting the last word of the del tags and replace it. Should stay in del tag.
        $this->useTest(7);
        $this->selectKeyword(4);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% strikethrough <del>%2% content %3% to test test</del> more %5% content</p>');

        // Test highlighting the last word of the del tags, pressing forward + delete and replace it. Should stay inside del
        $this->useTest(7);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% strikethrough <del>%2% content %3% to test test</del> more %5% content</p>');

        // Test highlighting the last word of the del tags, pressing backspace and replace it. Should stay inside del.
        $this->useTest(7);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% strikethrough <del>%2% content %3% to test test</del> more %5% content</p>');

        // Test selecting from before the del tag to inside. New content should not be in strikethrough.
        $this->useTest(7);
        $this->selectKeyword(1, 3);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some test<del> to test %4%</del> more %5% content</p>');

        // Test selecting from after the del tag to inside. New content should be in strikethrough.
        $this->useTest(7);
        $this->selectKeyword(3, 5);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% strikethrough <del>%2% content test</del> content</p>');

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
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('new ');
        $this->assertHTMLMatch('<p>%1% new <del>a %2% b</del> %3%</p>');

        // Test adding content before strikethrough content when cursor starts elsewhere in content
        $this->useTest(6);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('new ');
        $this->assertHTMLMatch('<p>%1% new <del>a %2% b</del> %3%</p>');

        // Test adding content after strikethrough content when cursor starts inside the strikethrough content
        $this->useTest(6);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' new');
        $this->assertHTMLMatch('<p>%1% <del>a %2% b new</del> %3%</p>');

        // Test adding content before strikethrough content when cursor starts elsewhere in content
        $this->useTest(6);
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type(' new');
        $this->assertHTMLMatch('<p>%1% <del>a %2% b new</del> %3%</p>');

    }//end testAddingContentAroundStrikethroughContent()


    /**
     * Test splitting a strikethrough section in content
     *
     * @return void
     */
    public function testSplittingStrikethroughContent()
    {
        // Test pressing enter in the middle of strikethrough content
        $this->useTest(6);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p>%1% <del>a %2%</del></p><p><del>test b</del> %3%</p>');

        // Test pressing enter at the start of strikethrough content
        $this->useTest(6);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<p>%1% </p><p>test <del>a %2% b</del> %3%</p>');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('<p>%1% test</p><p>test <del>a %2% b</del> %3%</p>');

        // Test pressing enter at the end of strikethrough content
        $this->useTest(6);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<p>%1% <del>a %2% b</del></p><p>test&nbsp;&nbsp;%3%</p>');

    }//end testSplittingStrikethroughContent()


    /**
     * Test undo and redo applying strikethrough to content
     *
     * @return void
     */
    public function testUndoAndRedoApplyingStrikethroughContent()
    {
        // Apply strikethrough content
        $this->useTest(8);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit %4% %5%</p><p>Another p</p>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit %4% %5%</p><p>Another p</p>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit %4% %5%</p><p>Another p</p>');

         // Apply strikethrough content again
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit <del>%4%</del> %5%</p><p>Another p</p>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit <del>%4%</del> %5%</p><p>Another p</p>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit <del>%4%</del> %5%</p><p>Another p</p>');

    }//end testUndoAndRedoApplyingStrikethroughContent()


    /**
     * Test undo and redo when editing strikethrough content
     *
     * @return void
     */
    public function testUndoAndRedoWithEditingStrikethroughContent()
    {

        // Add content to the middle of the strikethrough content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough <del>%2% test %3%</del> content to test</p>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough <del>%2% %3%</del> content to test</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough <del>%2% test %3%</del> content to test</p>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough <del>%2% %3%</del> content to test</p>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough <del>%2% test %3%</del> content to test</p>');

        // Test deleting content and pressing undo
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content </p><p>Some more strikethrough <del>%2% test %3%</del> content to test</p>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough <del>%2% test %3%</del> content to test</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content </p><p>Some more strikethrough <del>%2% test %3%</del> content to test</p>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <del>%1%</del></p><p>Some more strikethrough <del>%2% test %3%</del> content to test</p>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content </p><p>Some more strikethrough <del>%2% test %3%</del> content to test</p>');

    }//end testUndoAndRedoWithEditingStrikethroughContent()

}//end class

?>
