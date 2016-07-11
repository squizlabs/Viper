<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithSuperscriptUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding superscript formatting to content
     *
     * @return void
     */
    public function testAddingSuperscriptFormattingToContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying superscript formatting to one word using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<div>This is <sup>%1%</sup> %2% some content</div>');

        // Test applying superscript formatting to multiple words using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<div>This is <sup>%1% %2%</sup> some content</div>');

    }//end testAddingSuperscriptFormattingToContent()


    /**
     * Test removing superscript formatting from content
     *
     * @return void
     */
    public function testRemovingSuperscriptFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test removing superscript formatting from one word using the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test removing superscript formatting from multiple words using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<div>Some %1% superscript %2% content %3% to test %4% more %5% content</div>');

        // Test removing superscript formatting from all content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<div>Superscript %1% content</div>');

    }//end testRemovingSuperscriptFormatting()


    /**
     * Test editing superscript content
     *
     * @return void
     */
    public function testEditingSuperscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test adding content before the start of the superscript formatting
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some %1% superscript test <sup>%2% content %3% to test %4%</sup> more %5% content</div>');

        // Test adding content in the middle of superscript formatting
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% test content %3% to test %4%</sup> more %5% content</div>');

        // Test adding content to the end of superscript formatting
        $this->useTest(4);
        $this->moveToKeyword(4, 'left');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% content %3% to test %4% test</sup> more %5% content</div>');

        // Test highlighting some content in the superscript tags and replacing it
        $this->useTest(4);
        $this->selectKeyword(3);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% content test to test %4%</sup> more %5% content</div>');

        // Test highlighting the first word of the superscript tags and replace it. Should stay in superscript tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>test content %3% to test %4%</sup> more %5% content</div>');

        // Test hightlighting the first word, pressing forward + delete and replace it. Should be outside the superscript tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript test<sup> content %3% to test %4%</sup> more %5% content</div>');

        // Test highlighting the first word, pressing backspace and replace it. Should be outside the superscript tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript test<sup> content %3% to test %4%</sup> more %5% content</div>');

        // Test highlighting the last word of the superscript tags and replace it. Should stay in superscript tag.
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% content %3% to test test</sup> more %5% content</div>');

        // Test highlighting the last word of the superscript tags, pressing forward + delete and replace it. Should stay inside superscript
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% content %3% to test test</sup> more %5% content</div>');

        // Test highlighting the last word of the superscript tags, pressing backspace and replace it. Should stay inside superscript.
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% content %3% to test test</sup> more %5% content</div>');

        // Test selecting from before the superscript tag to inside. New content should not be in superscript.
        $this->useTest(4);
        $this->selectKeyword(1, 3);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some test<sup> to test %4%</sup> more %5% content</div>');

        // Test selecting from after the superscript tag to inside. New content should be in superscript.
        $this->useTest(4);
        $this->selectKeyword(3, 5);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% content test</sup> content</div>');

    }//end testEditingSuperscriptContent()


    /**
     * Test deleting superscript content
     *
     * @return void
     */
    public function testDeletingSuperscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test replacing superscript content with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>test</sup> more %5% content</div>');

        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript test more %5% content</div>');

        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript test more %5% content</div>');

        // Test replacing superscript content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>test</sup> more %5% content</div>');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript test more %5% content</div>');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript test more %5% content</div>');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

    }//end testDeletingSuperscriptContent()


    /**
     * Test splitting a superscript section in content
     *
     * @return void
     */
    public function testSplittingSuperscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test pressing enter in the middle of superscript content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2%<br />test content %3% to test %4%</sup> more %5% content</div>');

        // Test pressing enter at the start of superscript content
        $this->useTest(4);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some %1% superscript <br />test <sup>%2% content %3% to test %4%</sup> more %5% content</div>');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript test<br />test <sup>%2% content %3% to test %4%</sup> more %5% content</div>');

        // Test pressing enter at the end of superscript content
        $this->useTest(4);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% content %3% to test %4%</sup><br />test more %5% content</div>');

    }//end testSplittingSuperscriptContent()


    /**
     * Test undo and redo when applying superscript content
     *
     * @return void
     */
    public function testUndoAndRedoWithApplyingSuperscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Apply superscript content
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<div>This is <sup>%1%</sup> %2% some content</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>This is <sup>%1%</sup> %2% some content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>This is <sup>%1%</sup> %2% some content</div>');

         // Apply superscript content again
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<div>This is <sup>%1%</sup> <sup>%2%</sup> some content</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>This is <sup>%1%</sup> %2% some content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>This is <sup>%1%</sup> <sup>%2%</sup> some content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>This is <sup>%1%</sup> %2% some content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>This is <sup>%1%</sup> <sup>%2%</sup> some content</div>');

    }//end testUndoAndRedoWithApplyingsuperscriptContent()


    /**
     * Test undo and redo when editing superscript content
     *
     * @return void
     */
    public function testUndoAndRedoWithEditingSuperscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Add content to the middle of the superscript content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% test content %3% to test %4%</sup> more %5% content</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% content %3% to test %4%</sup> more %5% content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% test content %3% to test %4%</sup> more %5% content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% content %3% to test %4%</sup> more %5% content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% test content %3% to test %4%</sup> more %5% content</div>');

        // Test deleting content and pressing undo
        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% test content&nbsp;&nbsp;to test %4%</sup> more %5% content</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% test content %3% to test %4%</sup> more %5% content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% test content&nbsp;&nbsp;to test %4%</sup> more %5% content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% test content %3% to test %4%</sup> more %5% content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>Some %1% superscript <sup>%2% test content&nbsp;&nbsp;to test %4%</sup> more %5% content</div>');

    }//end testUndoAndRedoWithEditingsuperscriptContent()


}//end class
