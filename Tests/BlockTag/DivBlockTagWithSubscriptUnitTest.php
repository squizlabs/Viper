<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithSubscriptUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding subscript formatting to content
     *
     * @return void
     */
    public function testAddingSubscriptFormattingToContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying subscript formatting to one word using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('<div>This is <sub>%1%</sub> %2% some content</div>');

        // Test applying subscript formatting to multiple words using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('<div>This is <sub>%1% %2%</sub> some content</div>');

    }//end testAddingSubscriptFormattingToContent()


    /**
     * Test removing subscript formatting from content
     *
     * @return void
     */
    public function testRemovingSubscriptFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test removing subscript formatting from one word using the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test removing subscript formatting from multiple words using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('<div>Some subscript %1% %2% content to test</div>');

        // Test removing subscript formatting from all content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('<div>Subscript %1% content</div>');

    }//end testRemovingSubscriptFormatting()


    /**
     * Test editing subscript content
     *
     * @return void
     */
    public function testEditingSubscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test adding content to the start of the subscript formatting
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some subscript test <sub>%1% %2%</sub> content to test</div>');

        // Test adding content in the middle of subscript formatting
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<div>Some subscript test <sub>%1% test %2%</sub> content to test</div>');

        // Test adding content to the end of subscript formatting
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' %3%');
        $this->assertHTMLMatch('<div>Some subscript test <sub>%1% test %2% %3%</sub> content to test</div>');

        // Test highlighting some content in the sub tags and replacing it
        $this->selectKeyword(2);
        $this->type('abc');
        $this->assertHTMLMatch('<div>Some subscript test <sub>%1% test abc %3%</sub> content to test</div>');

        $this->selectKeyword(1);
        $this->type('%1%');
        $this->assertHTMLMatch('<div>Some subscript test <sub>%1% test abc %3%</sub> content to test</div>');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('abc');
        $this->assertHTMLMatch('<div>Some subscript test abc<sub> test abc %3%</sub> content to test</div>');

        // Undo so we can test backspace
        $this->sikuli->keyDown('Key.CMD + z');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('abc');
        $this->assertHTMLMatch('<div>Some subscript test abc<sub> test abc %3%</sub> content to test</div>');

        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('%1%');
        $this->assertHTMLMatch('<div>Some subscript test abc<sub> test abc %1%</sub> content to test</div>');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('abc');
        $this->assertHTMLMatch('<div>Some subscript test abc<sub> test abc abc</sub> content to test</div>');

    }//end testEditingSubscriptContent()


    /**
     * Test deleting subscript content
     *
     * @return void
     */
    public function testDeletingSubscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test replacing subscript content with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some subscript <sub>test</sub> content to test</div>');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some subscript test content to test</div>');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some subscript test content to test</div>');

        // Test replacing subscript content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some subscript <sub>test</sub> content to test</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some subscript test content to test</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some subscript test content to test</div>');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

    }//end testDeletingSubscriptContent()


    /**
     * Test splitting a subscript section in content
     *
     * @return void
     */
    public function testSplittingSubscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test pressing enter in the middle of subscript content
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some subscript <sub>%1%</div><div>test %2%</sub> content to test</div>');

        // Test pressing enter at the start of subscript content
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some subscript </div><div><sub>test %1% %2%</sub> content to test</div>');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type(' test');
        $this->assertHTMLMatch('<div>Some subscript test</div><div><sub>test %1% %2%</sub> content to test</div>');

        // Test pressing enter at the end of subscript content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some subscript <sub>%1% %2%</sub></div><div>test&nbsp;&nbsp;content to test</div>');

    }//end testSplittingSubscriptContent()


    /**
     * Test undo and redo with subscript content
     *
     * @return void
     */
    public function testUndoAndRedoWithSubscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Apply subscript content
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('<div>This is <sub>%1%</sub> %2% some content</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>This is <sub>%1%</sub> %2% some content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>This is <sub>%1%</sub> %2% some content</div>');        

    }//end testUndoAndRedoWithSubscriptContent()


}//end class
