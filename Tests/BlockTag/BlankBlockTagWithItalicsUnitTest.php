<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_BlankBlockTagWithItalicsUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding italic formatting to content
     *
     * @return void
     */
    public function testAddingItalicFormattingToContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying italic formatting to one word using the inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('This is <em>%1%</em> %2% some content');

        // Test applying italic formatting to one word using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('This is <em>%1%</em> %2% some content');

        // Test applying italic formatting to one word using the keyboard shortcut
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('This is <em>%1%</em> %2% some content');

        // Test applying italic formatting to multiple words using the inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('This is <em>%1% %2%</em> some content');

        // Test applying italic formatting to multiple words using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('This is <em>%1% %2%</em> some content');

        // Test applying italic formatting to multiple words using the keyboard shortcut
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('This is <em>%1% %2%</em> some content');

    }//end testAddingItalicFormattingToContent()


    /**
     * Test removing itlaic formatting from content
     *
     * @return void
     */
    public function testRemovingItalicFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test removing itlaic formatting from one word using the inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('This is %1% some content');

        // Test removing italic formatting from one word using the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('This is %1% some content');

        // Test removing italic formatting from one word using the keyboard shortcut
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('This is %1% some content');

        // Test removing italic formatting from multiple words using the inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('Some italic %1% %2% content to test');

        // Test removing italic formatting from multiple words using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('Some italic %1% %2% content to test');

        // Test removing italic formatting from multiple words using the keyboard shortcut
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('Some italic %1% %2% content to test');

        // Test removing italic formatting from all content using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('Italic %1% content');

        // Test removing italic formatting from all content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('Italic %1% content');

        // Test removing italic formatting from all content using the keyboard shortcut
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('Italic %1% content');

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

        // Test adding content to the start of the italic formatting
        $this->useTest(4);
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('Some italic <em>test %1% %2%</em> content to test');

        // Test adding content in the middle of italic formatting
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('Some italic <em>test %1% test %2%</em> content to test');

        // Test adding content to the end of italic formatting
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('Some italic <em>test %1% test %2% test</em> content to test');

        // Test highlighting some content in the em tags and replacing it
        $this->selectKeyword(2);
        $this->type('abc');
        $this->assertHTMLMatch('Some italic <em>test %1% test abc test</em> content to test');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('abc');
        $this->assertHTMLMatch('Some italic <em>test abc test abc test</em> content to test');

    }//end testEditingItalicContent()


    /**
     * Test deleting italic content
     *
     * @return void
     */
    public function testDeletingItalicContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test replacing italic content with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->type('test');
        $this->assertHTMLMatch('Some italic <em>test</em> content to test');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some italic test content to test');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some italic test content to test');

        // Test replacing italic content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('Some italic <em>test</em> content to test');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some italic test content to test');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some italic test content to test');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('test');

    }//end testDeletingItalicContent()


    /**
     * Test splitting a italic section in content
     *
     * @return void
     */
    public function testSplittingItalicContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test pressing enter in the middle of italic content
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('Some italic <em>%1%<br />test %2%</em> content to test');

        // Test pressing enter at the start of italic content
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('Some italic <br /><em>test %1% %2%</em> content to test');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('Some italic test<br /><em>test %1% %2%</em> content to test');

        // Test pressing enter at the end of italic content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('Some italic <em>%1% %2%</em><br />test&nbsp;&nbsp;content to test');

    }//end testSplittingItalicContent()


    /**
     * Test undo and redo with Italic content
     *
     * @return void
     */
    public function testUndoAndRedoWithItalicContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Apply italics content
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('This is <em>%1%</em> %2% some content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('This is %1% %2% some content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('This is <em>%1%</em> %2% some content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('This is %1% %2% some content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('This is <em>%1%</em> %2% some content');        

    }//end testUndoAndRedoWithItalicContent()


}//end class
