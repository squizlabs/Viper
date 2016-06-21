<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_BlankBlockTagWithStrikethroughUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding strikethrough formatting to content
     *
     * @return void
     */
    public function testAddingStrikethroughFormattingToContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying strikethrough formatting to one word using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('This is <del>%1%</del> %2% some content');

        // Test applying strikethrough formatting to multiple words using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('This is <del>%1% %2%</del> some content');

    }//end testAddingStrikethroughFormattingToContent()


    /**
     * Test removing strikethrough formatting from content
     *
     * @return void
     */
    public function testRemovingStrikethroughFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test removing strikethrough formatting from one word using the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('This is %1% some content');

        // Test removing strikethrough formatting from multiple words using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('Some strikethrough %1% %2% content to test');

        // Test removing strikethrough formatting from all content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('Strikethrough %1% content');

    }//end testRemovingStrikethroughFormatting()


    /**
     * Test editing strikethrough content
     *
     * @return void
     */
    public function testEditingStrikethroughContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test adding content to the start of the strikethrough formatting
        $this->useTest(4);
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('Some strikethrough test <del>%1% %2%</del> content to test');

        // Test adding content in the middle of strikethrough formatting
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('Some strikethrough test <del>%1% test %2%</del> content to test');

        // Test adding content to the end of strikethrough formatting
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('Some strikethrough test <del>%1% test %2% test</del> content to test');

        // Test highlighting some content in the del tags and replacing it
        $this->selectKeyword(2);
        $this->type('abc');
        $this->assertHTMLMatch('Some strikethrough test <del>%1% test abc test</del> content to test');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('abc');
        $this->assertHTMLMatch('Some strikethrough test abc<del> test abc test</del> content to test');

    }//end testEditingStrikethroughContent()


    /**
     * Test deleting strikethrough content
     *
     * @return void
     */
    public function testDeletingStrikethroughContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test replacing strikethrough content with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->type('test');
        $this->assertHTMLMatch('Some strikethrough <del>test</del> content to test');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some strikethrough test content to test');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some strikethrough test content to test');

        // Test replacing strikethrough content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('Some strikethrough <del>test</del> content to test');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some strikethrough test content to test');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some strikethrough test content to test');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('test');

    }//end testDeletingStrikethroughContent()


    /**
     * Test splitting a strikethrough section in content
     *
     * @return void
     */
    public function testSplittingStrikethroughContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test pressing enter in the middle of strikethrough content
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('Some strikethrough <del>%1%<br />test %2%</del> content to test');

        // Test pressing enter at the start of strikethrough content
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('Some strikethrough <br />test <del>%1% %2%</del> content to test');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('Some strikethrough test<br />test <del>%1% %2%</del> content to test');

        // Test pressing enter at the end of strikethrough content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('Some strikethrough <del>%1% %2%</del><br />test&nbsp;&nbsp;content to test');

    }//end testSplittingStrikethroughContent()


    /**
     * Test undo and redo with strikethrough content
     *
     * @return void
     */
    public function testUndoAndRedoWithStrikethroughContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Apply strikethrough content
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('This is <del>%1%</del> %2% some content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('This is %1% %2% some content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('This is <del>%1%</del> %2% some content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('This is %1% %2% some content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('This is <del>%1%</del> %2% some content');

    }//end testUndoAndRedoWithStrikethroughContent()


}//end class
