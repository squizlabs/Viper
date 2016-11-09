<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_BlankBlockTagWithSubscriptUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding subscript formatting to content
     *
     * @return void
     */
    public function testAddingSubscriptFormattingToContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying subscript formatting to one word using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('This is <sub>%1%</sub> %2% some content');

        // Test applying subscript formatting to multiple words using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('This is <sub>%1% %2%</sub> some content');

    }//end testAddingSubscriptFormattingToContent()


    /**
     * Test removing subscript formatting from content
     *
     * @return void
     */
    public function testRemovingSubscriptFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test removing subscript formatting from one word using the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('This is %1% some content');

        // Test removing subscript formatting from multiple words using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('Some %1% subscript %2% content %3% to test %4% more %5% content');

        // Test removing subscript formatting from all content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('Subscript %1% content');

    }//end testRemovingSubscriptFormatting()


    /**
     * Test editing subscript content
     *
     * @return void
     */
    public function testEditingSubscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test adding content before the start of the subscript formatting
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('Some %1% subscript test <sub>%2% content %3% to test %4%</sub> more %5% content');

        // Test adding content in the middle of subscript formatting
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% test content %3% to test %4%</sub> more %5% content');

        // Test adding content to the end of subscript formatting
        $this->useTest(4);
        $this->moveToKeyword(4, 'left');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% content %3% to test %4% test</sub> more %5% content');

        // Test highlighting some content in the subscript tags and replacing it
        $this->useTest(4);
        $this->selectKeyword(3);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% content test to test %4%</sub> more %5% content');

        // Test highlighting the first word of the subscript tags and replace it. Should stay in subscript tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript <sub>test content %3% to test %4%</sub> more %5% content');

        // Test hightlighting the first word, pressing forward + delete and replace it. Should be outside the subscript tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript test<sub> content %3% to test %4%</sub> more %5% content');

        // Test highlighting the first word, pressing backspace and replace it. Should be outside the subscript tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript test<sub> content %3% to test %4%</sub> more %5% content');

        // Test highlighting the last word of the subscript tags and replace it. Should stay in subscript tag.
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% content %3% to test test</sub> more %5% content');

        // Test highlighting the last word of the subscript tags, pressing forward + delete and replace it. Should stay inside subscript
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% content %3% to test test</sub> more %5% content');

        // Test highlighting the last word of the subscript tags, pressing backspace and replace it. Should stay inside subscript.
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% content %3% to test test</sub> more %5% content');

        // Test selecting from before the subscript tag to inside. New content should not be in subscript.
        $this->useTest(4);
        $this->selectKeyword(1, 3);
        $this->type('test');
        $this->assertHTMLMatch('Some test<sub> to test %4%</sub> more %5% content');

        // Test selecting from after the subscript tag to inside. New content should be in subscript.
        $this->useTest(4);
        $this->selectKeyword(3, 5);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% content test</sub> content');

    }//end testEditingSubscriptContent()


    /**
     * Test deleting subscript content
     *
     * @return void
     */
    public function testDeletingSubscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test replacing subscript content with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript <sub>test</sub> more %5% content');

        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript test more %5% content');

        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript test more %5% content');

        // Test replacing subscript content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript <sub>test</sub> more %5% content');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript test more %5% content');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript test more %5% content');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('test');

    }//end testDeletingSubscriptContent()


    /**
     * Test splitting a subscript section in content
     *
     * @return void
     */
    public function testSplittingSubscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test pressing enter in the middle of subscript content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2%<br />test content %3% to test %4%</sub> more %5% content');

        // Test pressing enter at the start of subscript content
        $this->useTest(4);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('Some %1% subscript <br /><sub>test %2% content %3% to test %4%</sub> more %5% content');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript test<br /><sub>test %2% content %3% to test %4%</sub> more %5% content');

        // Test pressing enter at the end of subscript content
        $this->useTest(4);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% content %3% to test %4%</sub><br />test more %5% content');

    }//end testSplittingSubscriptContent()


    /**
     * Test undo and redo when applying subscript content
     *
     * @return void
     */
    public function testUndoAndRedoWithApplyingSubscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Apply subscript content
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('This is <sub>%1%</sub> %2% some content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('This is %1% %2% some content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('This is <sub>%1%</sub> %2% some content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('This is %1% %2% some content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('This is <sub>%1%</sub> %2% some content');

         // Apply subscript content again
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('This is <sub>%1%</sub> <sub>%2%</sub> some content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('This is <sub>%1%</sub> %2% some content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('This is <sub>%1%</sub> <sub>%2%</sub> some content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('This is <sub>%1%</sub> %2% some content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('This is <sub>%1%</sub> <sub>%2%</sub> some content');

    }//end testUndoAndRedoWithApplyingSubscriptContent()


    /**
     * Test undo and redo when editing subscript content
     *
     * @return void
     */
    public function testUndoAndRedoWithEditingSubscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Add content to the middle of the subscript content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% test content %3% to test %4%</sub> more %5% content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% content %3% to test %4%</sub> more %5% content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% test content %3% to test %4%</sub> more %5% content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% content %3% to test %4%</sub> more %5% content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% test content %3% to test %4%</sub> more %5% content');

        // Test deleting content and pressing undo
        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% test content&nbsp;&nbsp;to test %4%</sub> more %5% content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% test content %3% to test %4%</sub> more %5% content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% test content&nbsp;&nbsp;to test %4%</sub> more %5% content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% test content %3% to test %4%</sub> more %5% content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('Some %1% subscript <sub>%2% test content&nbsp;&nbsp;to test %4%</sub> more %5% content');

    }//end testUndoAndRedoWithEditingSubscriptContent()


}//end class
