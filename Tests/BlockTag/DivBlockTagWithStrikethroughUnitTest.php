<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithStrikethroughUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding strikethrough formatting to content
     *
     * @return void
     */
    public function testDivBlockTagAddingStrikethroughFormattingToContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying strikethrough formatting to one word using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<div>This is <del>%1%</del> %2% some content</div>');

        // Test applying strikethrough formatting to multiple words using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<div>This is <del>%1% %2%</del> some content</div>');

    }//end testDivBlockTagAddingStrikethroughFormattingToContent()


    /**
     * Test removing strikethrough formatting from content
     *
     * @return void
     */
    public function testDivBlockTagRemovingStrikethroughFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test removing strikethrough formatting from one word using the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test removing strikethrough formatting from multiple words using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<div>Some strikethrough %1% %2% content to test</div>');

        // Test removing strikethrough formatting from all content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<div>Strikethrough %1% content</div>');

    }//end testDivBlockTagRemovingStrikethroughFormatting()


    /**
     * Test editing strikethrough content
     *
     * @return void
     */
    public function testDivBlockTagEditingStrikethroughContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test adding content to the start of the strikethrough formatting
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some strikethrough test <del>%1% %2%</del> content to test</div>');

        // Test adding content in the middle of strikethrough formatting
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<div>Some strikethrough test <del>%1% test %2%</del> content to test</div>');

        // Test adding content to the end of strikethrough formatting
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' %3%');
        $this->assertHTMLMatch('<div>Some strikethrough test <del>%1% test %2% %3%</del> content to test</div>');

        // Test highlighting some content in the del tags and replacing it
        $this->selectKeyword(2);
        $this->type('abc');
        $this->assertHTMLMatch('<div>Some strikethrough test <del>%1% test abc %3%</del> content to test</div>');

        $this->selectKeyword(1);
        $this->type('%1%');
        $this->assertHTMLMatch('<div>Some strikethrough test <del>%1% test abc %3%</del> content to test</div>');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('abc');
        $this->assertHTMLMatch('<div>Some strikethrough test abc<del> test abc %3%</del> content to test</div>');

        // Undo so we can test backspace
        $this->sikuli->keyDown('Key.CMD + z');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('abc');
        $this->assertHTMLMatch('<div>Some strikethrough test abc<del> test abc %3%</del> content to test</div>');

        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('%1%');
        $this->assertHTMLMatch('<div>Some strikethrough test abc<del> test abc %1%</del> content to test</div>');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('abc');
        $this->assertHTMLMatch('<div>Some strikethrough test abc<del> test abc abc</del> content to test</div>');

    }//end testDivBlockTagEditingStrikethroughContent()


    /**
     * Test deleting strikethrough content
     *
     * @return void
     */
    public function testDivBlockTagDeletingStrikethroughContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test replacing strikethrough content with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some strikethrough <del>test</del> content to test</div>');
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some strikethrough test content to test</div>');
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some strikethrough test content to test</div>');

        // Test replacing strikethrough content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some strikethrough <del>test</del> content to test</div>');
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some strikethrough test content to test</div>');
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some strikethrough test content to test</div>');
        
        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

    }//end testDivBlockTagDeletingStrikethroughContent()


    /**
     * Test splitting a strikethrough section in content
     *
     * @return void
     */
    public function testDivBlockTagSplittingStrikethroughContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test pressing enter in the middle of strikethrough content
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some strikethrough <del>%1%</del></div><div><del>test %2%</del> content to test</div>');

        // Test pressing enter at the start of strikethrough content
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some strikethrough </div><div><del>test %1% %2%</del> content to test</div>');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some strikethrough test</div><div><del>test %1% %2%</del> content to test</div>');

        // Test pressing enter at the end of strikethrough content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some strikethrough <del>%1% %2%</del></div><div>test&nbsp;&nbsp;content to test</div>');

    }//end testDivBlockTagSplittingStrikethroughContent()


    /**
     * Test undo and redo with strikethrough content
     *
     * @return void
     */
    public function testDivBlockTagUndoAndRedoWithStrikethroughContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Apply strikethrough content
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<div>This is <del>%1%</del> %2% some content</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>This is <del>%1%</del> %2% some content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>This is <del>%1%</del> %2% some content</div>');        

    }//end testDivBlockTagUndoAndRedoWithStrikethroughContent()


}//end class
