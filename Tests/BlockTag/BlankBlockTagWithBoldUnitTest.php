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
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('Some bold %1% %2% content to test');

        // Test removing bold formatting from multiple words using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('Some bold %1% %2% content to test');

        // Test removing bold formatting from multiple words using the keyboard shortcut
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('Some bold %1% %2% content to test');

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

        // Test adding content to the start of the bold formatting
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('Some bold test <strong>%1% %2%</strong> content to test');

        // Test adding content in the middle of bold formatting
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('Some bold test <strong>%1% test %2%</strong> content to test');

        // Test adding content to the end of bold formatting
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' %3%');
        $this->assertHTMLMatch('Some bold test <strong>%1% test %2% %3%</strong> content to test');

        // Test highlighting some content in the strong tags and replacing it
        $this->selectKeyword(2);
        $this->type('abc');
        $this->assertHTMLMatch('Some bold test <strong>%1% test abc %3%</strong> content to test');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('abc');
        $this->assertHTMLMatch('Some bold test <strong>abc test abc %3%</strong> content to test');

        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some bold test <strong>abc test abc test</strong> content to test');

    }//end testEditingBoldContent()


    /**
     * Test deleting bold content
     *
     * @return void
     */
    public function testDeletingBoldContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test replacing bold content with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->type('test');
        $this->assertHTMLMatch('Some bold <strong>test</strong> content to test');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some bold test content to test');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some bold test content to test');

        // Test replacing bold content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('Some bold <strong>test</strong> content to test');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some bold test content to test');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some bold test content to test');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('test');

    }//end testDeletingBoldContent()


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
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('Some bold <strong>%1%<br />test %2%</strong> content to test');

        // Test pressing enter at the start of bold content
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('Some bold <br /><strong>test %1% %2%</strong> content to test');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('Some bold test<br /><strong>test %1% %2%</strong> content to test');

        // Test pressing enter at the end of bold content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('Some bold <strong>%1% %2%</strong><br />test&nbsp;&nbsp;content to test');

    }//end testSplittingBoldContent()


    /**
     * Test undo and redo with bold content
     *
     * @return void
     */
    public function testUndoAndRedoWithBoldContent()
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

    }//end testUndoAndRedoWithBoldContent()


}//end class
