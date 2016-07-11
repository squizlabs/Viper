<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithItalicsUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding italic formatting to content
     *
     * @return void
     */
    public function testAddingItalicFormattingToContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying italic formatting to one word using the inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');

        // Test applying italic formatting to one word using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');

        // Test applying italic formatting to one word using the keyboard shortcut
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');

        // Test applying italic formatting to multiple words using the inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('<div>This is <em>%1% %2%</em> some content</div>');

        // Test applying italic formatting to multiple words using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<div>This is <em>%1% %2%</em> some content</div>');

        // Test applying italic formatting to multiple words using the keyboard shortcut
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<div>This is <em>%1% %2%</em> some content</div>');

    }//end testAddingItalicFormattingToContent()


    /**
     * Test removing itlaic formatting from content
     *
     * @return void
     */
    public function testRemovingItalicFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test removing itlaic formatting from one word using the inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test removing italic formatting from one word using the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test removing italic formatting from one word using the keyboard shortcut
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test removing italic formatting from multiple words using the inline toolbar
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div>Some %1% italic %2% content %3% to test %4% more %5% content</div>');

        // Test removing italic formatting from multiple words using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div>Some %1% italic %2% content %3% to test %4% more %5% content</div>');

        // Test removing italic formatting from multiple words using the keyboard shortcut
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<div>Some %1% italic %2% content %3% to test %4% more %5% content</div>');

        // Test removing italic formatting from all content using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div>Italic %1% content</div>');

        // Test removing italic formatting from all content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div>Italic %1% content</div>');

        // Test removing italic formatting from all content using the keyboard shortcut
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<div>Italic %1% content</div>');

    }//end testRemovingItalicFormatting()


    /**
     * Test editing italic content
     *
     * @return void
     */
    public function testEditingItalicContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test adding content before the start of the italic formatting
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some %1% italic test <em>%2% content %3% to test %4%</em> more %5% content</div>');

        // Test adding content in the middle of italic formatting
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% test content %3% to test %4%</em> more %5% content</div>');

        // Test adding content to the end of italic formatting
        $this->useTest(4);
        $this->moveToKeyword(4, 'left');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% content %3% to test %4% test</em> more %5% content</div>');

        // Test highlighting some content in the italics tags and replacing it
        $this->useTest(4);
        $this->selectKeyword(3);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% content test to test %4%</em> more %5% content</div>');

        // Test highlighting the first word of the italics tags and replace it. Should stay in italics tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic <em>test content %3% to test %4%</em> more %5% content</div>');

        // Test hightlighting the first word, pressing forward + delete and replace it. Should be outside the italics tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic test<em> content %3% to test %4%</em> more %5% content</div>');

        // Test highlighting the first word, pressing backspace and replace it. Should be outside the italics tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic test<em> content %3% to test %4%</em> more %5% content</div>');

        // Test highlighting the last word of the italics tags and replace it. Should stay in italics tag.
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% content %3% to test test</em> more %5% content</div>');

        // Test highlighting the last word of the italics tags, pressing forward + delete and replace it. Should stay inside italics
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% content %3% to test test</em> more %5% content</div>');

        // Test highlighting the last word of the italics tags, pressing backspace and replace it. Should stay inside italics.
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% content %3% to test test</em> more %5% content</div>');

        // Test selecting from before the italics tag to inside. New content should not be in italic.
        $this->useTest(4);
        $this->selectKeyword(1, 3);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some test<em> to test %4%</em> more %5% content</div>');

        // Test selecting from after the italics tag to inside. New content should be in italic.
        $this->useTest(4);
        $this->selectKeyword(3, 5);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% content test</em> content</div>');

    }//end testEditingItalicContent()


    /**
     * Test deleting italic content
     *
     * @return void
     */
    public function testDeletingItalicContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test replacing italic content with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic <em>test</em> more %5% content</div>');

        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic test more %5% content</div>');

        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic test more %5% content</div>');

        // Test replacing italic content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic <em>test</em> more %5% content</div>');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic test more %5% content</div>');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic test more %5% content</div>');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

    }//end testDeletingItalicContent()


    /**
     * Test splitting a italic section in content
     *
     * @return void
     */
    public function testSplittingItalicContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test pressing enter in the middle of italic content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2%</em></div><div><em>test content %3% to test %4%</em> more %5% content</div>');

        // Test pressing enter at the start of italic content
        $this->useTest(4);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some %1% italic </div><div><em>test %2% content %3% to test %4%</em> more %5% content</div>');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% italic test</div><div><em>test %2% content %3% to test %4%</em> more %5% content</div>');

        // Test pressing enter at the end of italic content
        $this->useTest(4);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% content %3% to test %4%</em></div><div>test more %5% content</div>');

    }//end testSplittingItalicContent()


    /**
     * Test undo and redo when applying italic content
     *
     * @return void
     */
    public function testUndoAndRedoWithApplyingItalicContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Apply italic content
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');

         // Apply italic content again
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> <em>%2%</em> some content</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> <em>%2%</em> some content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> <em>%2%</em> some content</div>');

    }//end testUndoAndRedoWithApplyingItalicContent()


    /**
     * Test undo and redo when editing italic content
     *
     * @return void
     */
    public function testUndoAndRedoWithEditingItalicContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Add content to the middle of the italic content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% test content %3% to test %4%</em> more %5% content</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% content %3% to test %4%</em> more %5% content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% test content %3% to test %4%</em> more %5% content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% content %3% to test %4%</em> more %5% content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% test content %3% to test %4%</em> more %5% content</div>');

        // Test deleting content and pressing undo
        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% test content&nbsp;&nbsp;to test %4%</em> more %5% content</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% test content %3% to test %4%</em> more %5% content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% test content&nbsp;&nbsp;to test %4%</em> more %5% content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% test content %3% to test %4%</em> more %5% content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>Some %1% italic <em>%2% test content&nbsp;&nbsp;to test %4%</em> more %5% content</div>');

    }//end testUndoAndRedoWithEditingItalicContent()



}//end class
