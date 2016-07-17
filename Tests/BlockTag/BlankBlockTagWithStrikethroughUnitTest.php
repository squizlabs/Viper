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
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('Some %1% strikethrough %2% content %3% to test %4% more %5% content');

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

        // Test adding content before the start of the strikethrough formatting
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('Some %1% strikethrough test <del>%2% content %3% to test %4%</del> more %5% content');

        // Test adding content in the middle of strikethrough formatting
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% test content %3% to test %4%</del> more %5% content');

        // Test adding content to the end of strikethrough formatting
        $this->useTest(4);
        $this->moveToKeyword(4, 'left');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% content %3% to test %4% test</del> more %5% content');

        // Test highlighting some content in the del tags and replacing it
        $this->useTest(4);
        $this->selectKeyword(3);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% content test to test %4%</del> more %5% content');

        // Test highlighting the first word of the del tags and replace it. Should stay in del tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough <del>test content %3% to test %4%</del> more %5% content');

        // Test hightlighting the first word, pressing forward + delete and replace it. Should be outside the del tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough test<del> content %3% to test %4%</del> more %5% content');

        // Test highlighting the first word, pressing backspace and replace it. Should be outside the del tag.
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough test<del> content %3% to test %4%</del> more %5% content');

        // Test highlighting the last word of the del tags and replace it. Should stay in del tag.
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% content %3% to test test</del> more %5% content');

        // Test highlighting the last word of the del tags, pressing forward + delete and replace it. Should stay inside del
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% content %3% to test test</del> more %5% content');

        // Test highlighting the last word of the del tags, pressing backspace and replace it. Should stay inside del.
        $this->useTest(4);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% content %3% to test test</del> more %5% content');

        // Test selecting from before the del tag to inside. New content should not be in strikethrough.
        $this->useTest(4);
        $this->selectKeyword(1, 3);
        $this->type('test');
        $this->assertHTMLMatch('Some test<del> to test %4%</del> more %5% content');

        // Test selecting from after the del tag to inside. New content should be in strikethrough.
        $this->useTest(4);
        $this->selectKeyword(3, 5);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% content test</del> content');

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
        $this->selectKeyword(2, 4);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough <del>test</del> more %5% content');

        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough test more %5% content');

        $this->useTest(4);
        $this->selectKeyword(2, 4);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough test more %5% content');

        // Test replacing strikethrough content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough <del>test</del> more %5% content');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough test more %5% content');

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough test more %5% content');

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
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2%<br />test content %3% to test %4%</del> more %5% content');

        // Test pressing enter at the start of strikethrough content
        $this->useTest(4);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('Some %1% strikethrough <br /><del>test %2% content %3% to test %4%</del> more %5% content');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough test<br /><del>test %2% content %3% to test %4%</del> more %5% content');

        // Test pressing enter at the end of strikethrough content
        $this->useTest(4);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% content %3% to test %4%</del><br />test more %5% content');

    }//end testSplittingStrikethroughContent()


    /**
     * Test undo and redo when applying strikethrough content
     *
     * @return void
     */
    public function testUndoAndRedoWithApplyingStrikethroughContent()
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

         // Apply strikethrough content again
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('This is <del>%1%</del> <del>%2%</del> some content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('This is <del>%1%</del> %2% some content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('This is <del>%1%</del> <del>%2%</del> some content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('This is <del>%1%</del> %2% some content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('This is <del>%1%</del> <del>%2%</del> some content');

    }//end testUndoAndRedoWithApplyingStrikethroughContent()


    /**
     * Test undo and redo when editing strikethrough content
     *
     * @return void
     */
    public function testUndoAndRedoWithEditingStrikethroughContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Add content to the middle of the strikethrough content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% test content %3% to test %4%</del> more %5% content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% content %3% to test %4%</del> more %5% content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% test content %3% to test %4%</del> more %5% content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% content %3% to test %4%</del> more %5% content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% test content %3% to test %4%</del> more %5% content');

        // Test deleting content and pressing undo
        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% test content&nbsp;&nbsp;to test %4%</del> more %5% content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% test content %3% to test %4%</del> more %5% content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% test content&nbsp;&nbsp;to test %4%</del> more %5% content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% test content %3% to test %4%</del> more %5% content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('Some %1% strikethrough <del>%2% test content&nbsp;&nbsp;to test %4%</del> more %5% content');

    }//end testUndoAndRedoWithEditingStrikethroughContent()


}//end class
