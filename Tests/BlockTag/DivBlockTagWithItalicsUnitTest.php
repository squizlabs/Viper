<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithItalicsUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding italic formatting to content
     *
     * @return void
     */
    public function testDivBlockTagAddingItalicFormattingToContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying italic formatting to one word using the inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');

        // Test applying italic formatting to one word using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');

        // Test applying italic formatting to one word using the keyboard shortcut
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');

        // Test applying italic formatting to multiple words using the inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('<div>This is <em>%1% %2%</em> some content</div>');

        // Test applying italic formatting to multiple words using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<div>This is <em>%1% %2%</em> some content</div>');

        // Test applying italic formatting to multiple words using the keyboard shortcut
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<div>This is <em>%1% %2%</em> some content</div>');

    }//end testDivBlockTagAddingItalicFormattingToContent()


    /**
     * Test removing itlaic formatting from content
     *
     * @return void
     */
    public function testDivBlockTagRemovingItalicFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test removing itlaic formatting from one word using the inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test removing italic formatting from one word using the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test removing italic formatting from one word using the keyboard shortcut
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test removing italic formatting from multiple words using the inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div>Some italic %1% %2% content to test</div>');

        // Test removing italic formatting from multiple words using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div>Some italic %1% %2% content to test</div>');

        // Test removing italic formatting from multiple words using the keyboard shortcut
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<div>Some italic %1% %2% content to test</div>');

        // Test removing italic formatting from all content using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div>Italic %1% content</div>');

        // Test removing italic formatting from all content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div>Italic %1% content</div>');

        // Test removing italic formatting from all content using the keyboard shortcut
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<div>Italic %1% content</div>');

    }//end testDivBlockTagRemovingItalicFormatting()


    /**
     * Test editing italic content
     *
     * @return void
     */
    public function testDivBlockTagEditingItalicContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test adding content to the start of the italic formatting
        $this->useTest(4);
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some italic <em>test %1% %2%</em> content to test</div>');

        // Test adding content in the middle of italic formatting
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<div>Some italic <em>test %1% test %2%</em> content to test</div>');

        // Test adding content to the end of italic formatting
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('<div>Some italic <em>test %1% test %2% test</em> content to test</div>');

        // Test highlighting some content in the em tags and replacing it
        $this->selectKeyword(2);
        $this->type('abc');
        $this->assertHTMLMatch('<div>Some italic <em>test %1% test abc test</em> content to test</div>');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('abc');
        $this->assertHTMLMatch('<div>Some italic <em>test abc test abc test</em> content to test</div>');

    }//end testDivBlockTagEditingItalicContent()


    /**
     * Test deleting italic content
     *
     * @return void
     */
    public function testDivBlockTagDeletingItalicContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test replacing italic content with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some italic <em>test</em> content to test</div>');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some italic test content to test</div>');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some italic test content to test</div>');

        // Test replacing italic content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->type('test');
        $this->assertHTMLMatch('<div>Some italic <em>test</em> content to test</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some italic test content to test</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some italic test content to test</div>');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

    }//end testDivBlockTagDeletingItalicContent()


    /**
     * Test splitting a italic section in content
     *
     * @return void
     */
    public function testDivBlockTagSplittingItalicContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test pressing enter in the middle of italic content
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some italic <em>%1%</em></div><div><em>test %2%</em> content to test</div>');

        // Test pressing enter at the start of italic content
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some italic </div><div><em>test %1% %2%</em> content to test</div>');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('<div>Some italic test</div><div><em>test %1% %2%</em> content to test</div>');

        // Test pressing enter at the end of italic content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<div>Some italic <em>%1% %2%</em></div><div>test content to test</div>');

    }//end testDivBlockTagSplittingItalicContent()


    /**
     * Test undo and redo with Italic content
     *
     * @return void
     */
    public function testDivBlockTagUndoAndRedoWithItalicContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Apply italics content
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>This is <em>%1%</em> %2% some content</div>');        

    }//end testDivBlockTagUndoAndRedoWithItalicContent()


}//end class
