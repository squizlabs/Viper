<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithBoldUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding bold formatting to content
     *
     * @return void
     */
    public function testDivBlockTagAddingBoldFormattingToContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying bold formatting to one word using the inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold');
        sleep(2);
        $this->assertHTMLMatch('<div>This is <strong>%1%</strong> %2% some content</div>');

        // Test applying bold formatting to one word using the top toolbar
        $this->useTest(2);
        sleep(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold');
        sleep(2);
        $this->assertHTMLMatch('<div>This is <strong>%1%</strong> %2% some content</div>');

        // Test applying bold formatting to one word using the keyboard shortcut
        $this->useTest(2);
        sleep(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertHTMLMatch('<div>This is <strong>%1%</strong> %2% some content</div>');

        // Test applying bold formatting to multiple words using the inline toolbar
        $this->useTest(2);
        sleep(1);
        $this->selectKeyword(1, 2);
        sleep(1);
        $this->clickInlineToolbarButton('bold');
        sleep(1);
        $this->assertHTMLMatch('<div>This is <strong>%1% %2%</strong> some content</div>');

        // Test applying bold formatting to multiple words using the top toolbar
        $this->useTest(2);
        sleep(2);
        $this->selectKeyword(1, 2);
        sleep(1);
        $this->clickTopToolbarButton('bold');
        sleep(2);
        $this->assertHTMLMatch('<div>This is <strong>%1% %2%</strong> some content</div>');

        // Test applying bold formatting to multiple words using the keyboard shortcut
        $this->useTest(2);
        sleep(1);
        $this->selectKeyword(1, 2);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertHTMLMatch('<div>This is <strong>%1% %2%</strong> some content</div>');

    }//end testDivBlockTagAddingBoldFormattingToContent()


    /**
     * Test removing bold formatting from content
     *
     * @return void
     */
    public function testDivBlockTagRemovingBoldFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test removing bold formatting from one word using the inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test removing bold formatting from one word using the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', 'active');
        sleep(3);
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test removing bold formatting from one word using the keyboard shortcut
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test removing bold formatting from multiple words using the inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<div>Some bold %1% %2% content to test</div>');

        // Test removing bold formatting from multiple words using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<div>Some bold %1% %2% content to test</div>');

        // Test removing bold formatting from multiple words using the keyboard shortcut
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<div>Some bold %1% %2% content to test</div>');

        // Test removing bold formatting from all content using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<div>Bold %1% content</div>');

        // Test removing bold formatting from all content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<div>Bold %1% content</div>');

        // Test removing bold formatting from all content using the keyboard shortcut
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<div>Bold %1% content</div>');

    }//end testDivBlockTagRemovingBoldFormatting()


    /**
     * Test editing bold content
     *
     * @return void
     */
    public function testDivBlockTagEditingBoldContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test adding content to the start of the bold formatting
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some bold test <strong>%1% %2%</strong> content to test</div>');

        // Test adding content in the middle of bold formatting
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<div>Some bold test <strong>%1% test %2%</strong> content to test</div>');

        // Test adding content to the end of bold formatting
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' %3%');
        $this->assertHTMLMatch('<div>Some bold test <strong>%1% test %2% %3%</strong> content to test</div>');

        // Test highlighting some content in the strong tags and replacing it
        $this->selectKeyword(2);
        $this->type('abc');
        $this->assertHTMLMatch('<div>Some bold test <strong>%1% test abc %3%</strong> content to test</div>');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('abc');
        $this->assertHTMLMatch('<div>Some bold test abc<strong> test abc %3%</strong> content to test</div>');

        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some bold test abc<strong> test abc test</strong> content to test</div>');

    }//end testDivBlockTagEditingBoldContent()


    /**
     * Test deleting bold content
     *
     * @return void
     */
    public function testDivBlockTagDeletingBoldContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test replacing bold content with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some bold <strong>test</strong>content to test</div>');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some bold test content to test</div>');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some bold test content to test</div>');

        // Test replacing bold content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some bold <strong>test</strong>content to test</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some bold test content to test</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some bold test content to test</div>');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

    }//end testDivBlockTagDeletingBoldContent()


    /**
     * Test splitting a bold section in content
     *
     * @return void
     */
    public function testDivBlockTagSplittingBoldContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');
        sleep(5);

        // Test pressing enter in the middle of bold content
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        sleep(5);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(5);
        $this->type('test');
        sleep(5);
        $this->assertHTMLMatch('<div>Some bold<strong>%1%</strong></div><div><strong>test %2%</strong>content to test</div>');

        // Test pressing enter at the start of bold content
        $this->useTest(4);
        sleep(3);
        $this->moveToKeyword(1, 'left');
        sleep(3);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(3);
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some bold </div><div><strong>test %1% %2%</strong>content to test</div>');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type(' test');
        $this->assertHTMLMatch('<div>Some bold test</div><div><strong>test %1% %2%</strong>content to test</div>');

        // Test pressing enter at the end of bold content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some bold <strong>%1% %2%</strong></div><div>test content to test</div>');

    }//end testDivBlockTagSplittingBoldContent()


    /**
     * Test undo and redo with bold content
     *
     * @return void
     */
    public function testDivBlockTagUndoAndRedoWithBoldContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Apply bold content
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold');
        $this->assertHTMLMatch('<div>This is <strong>%1%</strong> %2% some content</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>This is <strong>%1%</strong> %2% some content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>This is <strong>%1%</strong> %2% some content</div>');

    }//end testDivBlockTagUndoAndRedoWithBoldContent()


}//end class
