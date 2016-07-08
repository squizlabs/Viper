<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_BlankBlockTagWithBoldUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding bold formatting to content
     *
     * @return void
     */
    public function testAddingBoldFormattingToContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying bold formatting to one word using the inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold');
        $this->assertHTMLMatch('This is <strong>%1%</strong> %2% some content');

        // Test applying bold formatting to one word using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('This is <strong>%1%</strong> %2% some content');

        // Test applying bold formatting to one word using the keyboard shortcut
        $this->useTest(2);
        sleep(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertHTMLMatch('This is <strong>%1%</strong> %2% some content');

        // Test applying bold formatting to multiple words using the inline toolbar
        $this->useTest(2);
        sleep(1);
        $this->selectKeyword(1, 2);
        sleep(1);
        $this->clickInlineToolbarButton('bold');
        sleep(1);
        $this->assertHTMLMatch('This is <strong>%1% %2%</strong> some content');

        // Test applying bold formatting to multiple words using the top toolbar
        $this->useTest(2);
        sleep(1);
        $this->selectKeyword(1, 2);
        sleep(1);
        $this->clickTopToolbarButton('bold');
        sleep(1);
        $this->assertHTMLMatch('This is <strong>%1% %2%</strong> some content');

        // Test applying bold formatting to multiple words using the keyboard shortcut
        $this->useTest(2);
        sleep(1);
        $this->selectKeyword(1, 2);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertHTMLMatch('This is <strong>%1% %2%</strong> some content');

    }//end testAddingBoldFormattingToContent()


    /**
     * Test removing bold formatting from content
     *
     * @return void
     */
    public function testRemovingBoldFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test removing bold formatting from one word using the inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('This is %1% some content');

        // Test removing bold formatting from one word using the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('This is %1% some content');

        // Test removing bold formatting from one word using the keyboard shortcut
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('This is %1% some content');

        // Test removing bold formatting from multiple words using the inline toolbar
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('Some %1% bold %2% content %3% to test %4% more %5% content');

        // Test removing bold formatting from multiple words using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('Some %1% bold %2% content %3% to test %4% more %5% content');

        // Test removing bold formatting from multiple words using the keyboard shortcut
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('Some %1% bold %2% content %3% to test %4% more %5% content');

        // Test removing bold formatting from all content using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('Bold %1% content');

        // Test removing bold formatting from all content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('Bold %1% content');

        // Test removing bold formatting from all content using the keyboard shortcut
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('Bold %1% content');

    }//end testRemovingBoldFormatting()


    /**
     * Test editing bold content
     *
     * @return void
     */
    public function testEditingBoldContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test adding content before the start of the bold formatting
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('Some %1% bold test <strong>%2% content %3% to test %4%</strong> more %5% content');

        // Test adding content in the middle of bold formatting
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% test content %3% to test %4%</strong> more %5% content');

        // Test adding content to the end of bold formatting
        $this->useTest(4);
        $this->moveToKeyword(4, 'left');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% content %3% to test %4% test</strong> more %5% content');

        // Test highlighting some content in the strong tags and replacing it
        $this->useTest(4);
        $this->selectKeyword(3);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% content test to test %4%</strong> more %5% content');

        // Test highlighting the first word of the strong tags and replace it. Should stay in strong tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold <strong>test content %3% to test %4%</strong> more %5% content');

        // Test hightlighting the first word, pressing forward + delete and replace it. Should be outside the strong tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold test<strong> content %3% to test %4%</strong> more %5% content');

        // Test highlighting the first word, pressing backspace and replace it. Should be outside the strong tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold test<strong> content %3% to test %4%</strong> more %5% content');

        // Test highlighting the last word of the strong tags and replace it. Should stay in strong tag.
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% content %3% to test test</strong> more %5% content');

        // Test highlighting the last word of the strong tags, pressing forward + delete and replace it. Should stay inside strong
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% content %3% to test test</strong> more %5% content');

        // Test highlighting the last word of the strong tags, pressing backspace and replace it. Should stay inside strong.
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% content %3% to test test</strong> more %5% content');

        // Test selecting from before the strong tag to inside. New content should not be in bold.
        $this->useTest(4);
        $this->selectKeyword(1, 3);
        $this->type('test');
        $this->assertHTMLMatch('Some test<strong> to test %4%</strong> more %5% content');

        // Test selecting from after the strong tag to inside. New content should be in bold.
        $this->useTest(4);
        $this->selectKeyword(3, 5);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% content test</strong> content');

    }//end testEditingBoldContent()


    /**
     * Test deleting bold content
     *
     * @return void
     */
    public function testDeletingAllBoldContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test replacing bold content with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold <strong>test</strong> more %5% content');

        // Test highlightling all bold content, pressing forward + delete and adding new content
        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold test more %5% content');

        // Test highlightling all bold content, pressing backspace and adding new content
        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold test more %5% content');

        // Test replacing bold content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold <strong>test</strong> more %5% content');

        // Select the content, press forward + delete and then add new content
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold test more %5% content');

        // Select the content, press backspace and then add new content
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold test more %5% content');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('test');

    }//end testDeletingAllBoldContent()


    /**
     * Test splitting a bold section in content
     *
     * @return void
     */
    public function testSplittingBoldContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test pressing enter in the middle of bold content
        $this->useTest(4);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% content %3%<br />test to test %4%</strong> more %5% content');

        // Test pressing enter at the start of bold content
        $this->useTest(4);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('Some %1% bold <br />test <strong>%2% content %3% to test %4%</strong> more %5% content');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold test<br />test <strong>%2% content %3% to test %4%</strong> more %5% content');

        // Test pressing enter at the end of bold content
        $this->useTest(4);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% content %3% to test %4%</strong><br />test more %5% content');

    }//end testSplittingBoldContent()


    /**
     * Test undo and redo when applying bold content
     *
     * @return void
     */
    public function testUndoAndRedoWithApplyingBoldContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Apply bold content
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold');
        $this->assertHTMLMatch('This is <strong>%1%</strong> %2% some content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('This is %1% %2% some content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('This is <strong>%1%</strong> %2% some content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('This is %1% %2% some content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('This is <strong>%1%</strong> %2% some content');

         // Apply bold content again
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('bold');
        $this->assertHTMLMatch('This is <strong>%1%</strong> <strong>%2%</strong> some content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('This is <strong>%1%</strong> %2% some content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('This is <strong>%1%</strong> <strong>%2%</strong> some content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('This is <strong>%1%</strong> %2% some content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('This is <strong>%1%</strong> <strong>%2%</strong> some content');

    }//end testUndoAndRedoWithApplyingBoldContent()


    /**
     * Test undo and redo when editing bold content
     *
     * @return void
     */
    public function testUndoAndRedoWithEditingBoldContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Add content to the middle of the bold content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% test content %3% to test %4%</strong> more %5% content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% content %3% to test %4%</strong> more %5% content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% test content %3% to test %4%</strong> more %5% content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% content %3% to test %4%</strong> more %5% content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% test content %3% to test %4%</strong> more %5% content');

        // Test deleting content and pressing undo
        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% test content&nbsp;&nbsp;to test %4%</strong> more %5% content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% test content %3% to test %4%</strong> more %5% content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% test content&nbsp;&nbsp;to test %4%</strong> more %5% content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% test content %3% to test %4%</strong> more %5% content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('Some %1% bold <strong>%2% test content&nbsp;&nbsp;to test %4%</strong> more %5% content');

    }//end testUndoAndRedoWithEditingBoldContent()


}//end class
