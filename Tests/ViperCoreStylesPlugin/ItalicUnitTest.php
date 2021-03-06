<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_ItalicUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testStartOfParaItalic()
    {
        $this->useTest(1);

        // Apply italic using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p><em>%1%</em> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove italic using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Apply italic using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p><em>%1%</em> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove italic using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStartOfParaItalic()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaItalic()
    {
        $this->useTest(1);

        // Apply italic using inline toolbar
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <em>%2%</em> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove italic using inline toolbar
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Apply italic using top toolbar
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <em>%2%</em> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove italic using top toolbar
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testMidOfParaItalic()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaItalic()
    {
        $this->useTest(1);

        // Apply italic using inline toolbar
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% %2% <em>%3%</em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

         // Remove italic using inline toolbar
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Apply italic using top toolbar
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% %2% <em>%3%</em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove italic using top toolbar
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testEndOfParaItalic()


    /**
     * Test that italics is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemoveItalicsFromPartOfContent()
    {
        $this->useTest(1);

        // Apply italic to two words
        $this->selectKeyword(2, 3);
        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <em>%2% %3%</em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove italic from one word
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% <em>%2% </em>%3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Check icons for second word
        $this->selectKeyword(2);
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');

    }//end testRemoveItalicsFromPartOfContent()


    /**
     * Test deleting italic content
     *
     * @return void
     */
    public function testDeletingItalicContent()
    {
        // Test selecting a single word and replacing with new content
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>this is new content</em></p><p>Some more italic <em>%2% %3%</em> content to test</p>');

        $this->useTest(7);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content this is new content</p><p>Some more italic <em>%2% %3%</em> content to test</p>');

        $this->useTest(7);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content this is new content</p><p>Some more italic <em>%2% %3%</em> content to test</p>');

        // Test replacing italic section with new content with highlighting
        $this->useTest(7);
        $this->selectKeyword(2, 3);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>%1%</em></p><p>Some more italic <em>test</em> content to test</p>');

        $this->useTest(7);
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>%1%</em></p><p>Some more italic test content to test</p>');

        $this->useTest(7);
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>%1%</em></p><p>Some more italic test content to test</p>');

        // Test replacing italic content with new content when selecting one keyword and using the lineage
        $this->useTest(7);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>%1%</em></p><p>Some more italic <em>test</em> content to test</p>');

        $this->useTest(7);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>%1%</em></p><p>Some more italic test content to test</p>');

        $this->useTest(7);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>%1%</em></p><p>Some more italic test content to test</p>');

        // Test replacing all content
        $this->useTest(10);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('<p>test</p>');

    }//end testDeletingItalicContent()


    /**
     * Test deleting content including content with italic formatting
     *
     * @return void
     */
    public function testDeletingAndAddingContentWithItalicFormatting()
    {
         // Check deleting a word after the italic content
        $this->useTest(9);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% <em>a %2% b</em></p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% <em>a %2% b</em> content</p>');

        // Check deleting a word after the italic content up to the italic content
        $this->useTest(9);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% <em>a %2% b</em></p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% <em>a %2% bcontent</em></p>');

        // Check deleting from the end of the paragraph including italic content
        $this->useTest(9);
        $this->moveToKeyword(3, 'right');

        for ($i = 0; $i < 11; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>%1%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% content</p>');

        // Check deleting from the start of the paragraph
        $this->useTest(9);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p><em>a %2% b</em> %3%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content <em>a %2% b</em> %3%</p>');

        // Check deleting from the start of the paragraph up to the italic content
        $this->useTest(9);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p><em>a %2% b</em> %3%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p><em>contenta %2% b</em> %3%</p>');

        // Check deleting from the start of the paragraph including italic content
        $this->useTest(9);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 11; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>%3%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content %3%</p>');

    }//end testDeletingAndAddingContentWithItalicFormatting()


    /**
     * Test that the shortcut command works for Italics.
     *
     * @return void
     */
    public function testShortcutCommandForItalics()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p><em>%1%</em> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testShortcutCommandForItalics()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentItalicStyling()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->selectKeyword(1, 2);
        // Make sure the italic icons are not active in the toolbars
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar should not be active');
        $this->sikuli->keyDown('Key.CMD + i');
        // Make sure the italic icons are now active in the toolbars
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should not be active');

        $this->selectKeyword(2, 3);
        // Make sure the italic icons are not active in the toolbars
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar should not be active');
        $this->sikuli->keyDown('Key.CMD + i');
        // Make sure the italic icons are now active in the toolbars
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should not be active');

        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAdjacentItalicStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedItalicStyling()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p><em>%1%</em> <em>%2%</em> <em>%3%</em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testSpaceSeparatedItalicStyling()


    /**
     * Test that the VITP italc icon is removed from the toolbar when you click the P tag.
     *
     * @return void
     */
    public function testItalicIconIsRemovedFromInlineToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        // Inline Toolbar icon should be displayed.
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon does not appear in the inline toolbar');

        // Click the P tag.
        $this->selectInlineToolbarLineageItem(0);

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon still appears in the inline toolbar');

        // Click the Selection tag.
        $this->selectInlineToolbarLineageItem(1);

        // Inline Toolbar icon should be displayed.
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon is not displayed in the inline toolbar');

    }//end testItalicIconIsRemovedFromInlineToolbar()


    /**
     * Test applying a italics to two words where one word is bold.
     *
     * @return void
     */
    public function testAddItalicsToTwoWordsWhereOneBold()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% <strong>%2%</strong> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->selectKeyword(2, 3);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% <em><strong>%2%</strong> %3%</em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAddItalicsToTwoWordsWhereOneBold()


    /**
     * Test applying italics to two words where one is bold and one is italics.
     *
     * @return void
     */
    public function testAddItalicsToTwoWordsWhereOneBoldAndOneItalics()
    {
        $this->useTest(1);

        $this->selectKeyword(4, 5);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4% <strong>%5%</strong></em></p>');

    }//end testAddItalicsToTwoWordsWhereOneBoldAndOneItalics()


    /**
     * Test that a paragraph can be made italics using the top toolbar and that the VITP italic icon will appear when that happen. Then remove the italics formatting and check that the VITP italic icon is removed.
     *
     * @return void
     */
    public function testAddAndRemoveFormattingToParagraph()
    {
        $this->useTest(1);

        $this->selectKeyword(1, 3);

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('italic', 'active'), 'Active italic icon appears in the inline toolbar');

        // Click the Top Toolbar icon to make whole paragraph italics.
        $this->clickTopToolbarButton('italic');

        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon is not active in the top toolbar');

        // Inline Toolbar icon is now displayed
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Active italic icon does not appear in the inline toolbar');

        //Remove italic formating
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('italic', 'active');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon is still active in the top toolbar');

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('italic', 'active'), 'Active italic icon appears in the inline toolbar');

    }//end testAddAndRemoveFormattingToParagraph()


    /**
     * Test applying italics to two paragraphs where there is a HTML comment in the source code.
     *
     * @return void
     */
    public function testAddAndRemoveItalicsToTwoParagraphsWhereHtmlCommentsInSource()
    {
        $this->useTest(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em><!-- hello world! --></p><p>sit %4% %5%</p><p>Another p</p>');

        $this->moveToKeyword(2);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em><!-- hello world! --></p><p><em>sit %4% %5%</em></p><p>Another p</p>');

        $this->selectKeyword(1, 5);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>%1% %2% %3%<!-- hello world! --></p><p>sit %4% %5%</p><p>Another p</p>');

    }//end testAddAndRemoveItalicsToTwoParagraphsWhereHtmlCommentsInSource()


    /**
     * Test applying and removing italics to two paragraphs.
     *
     * @return void
     */
    public function testAddAndRemoveItalicsToTwoParagraphs()
    {
        $this->useTest(3);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em></p><p>sit %4% %5%</p><p>Another p</p>');

        $this->moveToKeyword(2);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em></p><p><em>sit %4% %5%</em></p><p>Another p</p>');

        $this->selectKeyword(1, 5);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% %5%</p><p>Another p</p>');

    }//end testAddAndRemoveItalicsToTwoParagraphs()


    /**
     * Test applying and removing italics to across multiple paragraphs at the same time.
     *
     * @return void
     */
    public function testAddAndRemoveItalicsToMultipleParagraphs()
    {
        $this->useTest(3);

        // Apply italic using the inline toolbar
        $this->selectKeyword(1, 5);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em></p><p><em>sit %4% %5%</em></p><p>Another p</p>');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Remove italic using inline toolbar
        $this->selectKeyword(1, 5);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar should noy be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar should not be active');

        // Apply italic using the top toolbar
        $this->selectKeyword(1, 5);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em></p><p><em>sit %4% %5%</em></p><p>Another p</p>');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Remove italic using top toolbar
        $this->selectKeyword(1, 5);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Itlaic icon in the inline toolbar should noy be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar should not be active');

    }//end testAddAndRemoveItalicsToMultipleParagraphs()


    /**
     * Test applying and removing italics to all content. Also checks that class and anchor does not become active when it applies the bold
     *
     * @return void
     */
    public function testAddAndRemoveItalicToAllContent()
    {
        $this->useTest(1);

        $this->moveToKeyword(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em></p><p><em>sit %4% <strong>%5%</strong></em></p>');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'), 'Class icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should not be active');

        $this->moveToKeyword(2);
        $this->sikuli->keyDown('Key.CMD + a');
        sleep(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'), 'Class icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should not be active');

    }//end testAddAndRemoveItalicToAllContent()


    /**
     * Test that undo and redo buttons for italic formatting.
     *
     * @return void
     */
    public function testUndoAndRedoForItalic()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic');

        $this->assertHTMLMatch('<p><em>%1%</em> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p><em>%1%</em> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon should be active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon should be active in the top toolbar');

    }//end testUndoAndRedoForBold()


    /**
     * Test applying and removing italic for a link in the content of a page.
     *
     * @return void
     */
    public function testAddAndRemoveItalicForLink()
    {
        $this->useTest(4);

        // Using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('<p>Test content <em><a href="http://www.squizlabs.com">%1%</a></em> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic', 'active'), 'italic icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon should be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        // Check to see if italic icon is in the inline toolbar
        $this->assertTrue($this->inLineToolbarButtonExists('italic', 'active'), 'italic icon should be active');
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic'), 'italic icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'italic icon should not be active');

        // Using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<p>Test content <em><a href="http://www.squizlabs.com">%1%</a></em> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic', 'active'), 'italic icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon should be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        // Check to see if italic icon is in the inline toolbar
        $this->assertTrue($this->inLineToolbarButtonExists('italic', 'active'), 'italic icon should be active');
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic'), 'italic icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'italic icon should not be active');

        // Using keyboard shortcuts
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>Test content <em><a href="http://www.squizlabs.com">%1%</a></em> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic', 'active'), 'italic icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon should be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        // Check to see if italic icon is in the inline toolbar
        $this->assertTrue($this->inLineToolbarButtonExists('italic', 'active'), 'italic icon should be active');
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic'), 'italic icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'italic icon should not be active');

    }//end testAddAndRemoveItalicForLink()


    /**
     * Test applying and removing bold for a link in italics paragraph.
     *
     * @return void
     */
    public function testRemoveItalicsForLinkInItalicParagraph()
    {

       // Using inline toolbar
        $this->useTest(6);
        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        sleep(1);
        $this->clickInlineToolbarButton('italic', 'active');
        sleep(1);
        $this->assertHTMLMatch('<p><em>Test content </em><a href="http://www.squizlabs.com">%1%</a><em> end of test content.</em></p>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic'), 'Italic icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon should not be active');

        // Using top toolbar
        $this->useTest(6);
        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        sleep(1);
        $this->clickTopToolbarButton('italic', 'active');
        sleep(1);
        $this->assertHTMLMatch('<p><em>Test content </em><a href="http://www.squizlabs.com">%1%</a><em> end of test content.</em></p>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic'), 'Italic icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon should not be active');

        // Using keyboard shortcut
        $this->useTest(6);
        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertHTMLMatch('<p><em>Test content </em><a href="http://www.squizlabs.com">%1%</a><em> end of test content.</em></p>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic'), 'Italic icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon should not be active');

    }//end testRemoveItalicsForLinkInItalicParagraph()


    /**
     * Test that italic icon is not available in the inline toolbar for a heading.
     *
     * @return void
     */
    public function testItalicIconForHeadingInInlineToolbar()
    {
        $this->useTest(5);

        // Test H1
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'));

        // Test H2
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'));

        // Test H3
        $this->selectKeyword(3);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'));

        // Test H4
        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'));

        // Test H5
        $this->selectKeyword(5);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'));

        // Test H6
        $this->selectKeyword(6);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'));

    }//end testItalicIconForHeadingInInlineToolbar()


    /**
     * Test that you can remove italic from two different sections of content at the same time.
     *
     * @return void
     */
    public function testRemovingItalicFromDifferentSectionsInContent()
    {
        // Remove using top toolbar
        $this->useTest(8);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('italic', 'active');

        // Perform the check using raw html as there is a bug that removes the space after 'more' when it removes the italic formatting
        $this->assertEquals('<p>Text <em>more </em>%1%text text and more%2%<em> text</em></p>', $this->getRawHtml());

        // Reapply using top toolbar
        $this->clickTopToolbarButton('italic');
        $this->assertEquals('<p>Text <em>more %1%text text and more%2% text</em></p>', $this->getRawHtml());

        // Using inline toolbar
        $this->useTest(8);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertEquals('<p>Text <em>more </em>%1%text text and more%2%<em> text</em></p>', $this->getRawHtml());

        // Reapply using inline toolbar
        $this->clickInlineToolbarButton('italic');
        $this->assertEquals('<p>Text <em>more %1%text text and more%2% text</em></p>', $this->getRawHtml());

        // Using keyboard shortcut
        $this->useTest(8);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertEquals('<p>Text <em>more </em>%1%text text and more%2%<em> text</em></p>', $this->getRawHtml());

        // Reapply using keyboard shortcut
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertEquals('<p>Text <em>more %1%text text and more%2% text</em></p>', $this->getRawHtml());

    }//end testRemovingItalicFromDifferentSectionsInContent()


    /**
     * Test adding content before and after italic content
     *
     * @return void
     */
    public function testAddingContentAroundItalicContent()
    {
        // Test adding content before italic content when cursor starts inside the italic content
        $this->useTest(9);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('new ');
        $this->assertHTMLMatch('<p>%1% new <em>a %2% b</em> %3%</p>');

        // Test adding content before italic content when cursor starts elsewhere in content
        $this->useTest(9);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('new ');
        $this->assertHTMLMatch('<p>%1% new <em>a %2% b</em> %3%</p>');

        // Test adding content after italic content when cursor starts inside the italic content
        $this->useTest(9);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' new');
        $this->assertHTMLMatch('<p>%1% <em>a %2% b new</em> %3%</p>');

        // Test adding content before italic content when cursor starts elsewhere in content
        $this->useTest(9);
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type(' new');
        $this->assertHTMLMatch('<p>%1% <em>a %2% b new</em> %3%</p>');

    }//end testAddingContentAroundItalicContent()


    /**
     * Test editing italic content
     *
     * @return void
     */
    public function testEditingItalicContent()
    {

        // Test adding content before the start of the italic formatting
        $this->useTest(11);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('<p>Some %1% italic test <em>%2% content %3% to test %4%</em> more %5% content</p>');

        // Test adding content in the middle of bold formatting
        $this->useTest(11);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<p>Some %1% italic <em>%2% test content %3% to test %4%</em> more %5% content</p>');

        // Test adding content to the end of italic formatting
        $this->useTest(11);
        $this->moveToKeyword(4, 'left');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('<p>Some %1% italic <em>%2% content %3% to test %4% test</em> more %5% content</p>');

        // Test highlighting some content in the em tags and replacing it
        $this->useTest(11);
        $this->selectKeyword(3);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% italic <em>%2% content test to test %4%</em> more %5% content</p>');

        // Test highlighting the first word of the em tags and replace it. Should stay in em tag.
        $this->useTest(11);
        $this->selectKeyword(2);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% italic <em>test content %3% to test %4%</em> more %5% content</p>');

        // Test hightlighting the first word, pressing forward + delete and replace it. Should be outside the em tag.
        $this->useTest(11);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% italic test<em> content %3% to test %4%</em> more %5% content</p>');

        // Test highlighting the first word, pressing backspace and replace it. Should be outside the em tag.
        $this->useTest(11);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% italic test<em> content %3% to test %4%</em> more %5% content</p>');

        // Test highlighting the last word of the em tags and replace it. Should stay in em tag.
        $this->useTest(11);
        $this->selectKeyword(4);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% italic <em>%2% content %3% to test test</em> more %5% content</p>');

        // Test highlighting the last word of the em tags, pressing forward + delete and replace it. Should stay inside em
        $this->useTest(11);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% italic <em>%2% content %3% to test test</em> more %5% content</p>');

        // Test highlighting the last word of the em tags, pressing backspace and replace it. Should stay inside em.
        $this->useTest(11);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% italic <em>%2% content %3% to test test</em> more %5% content</p>');

        // Test selecting from before the em tag to inside. New content should not be in italic.
        $this->useTest(11);
        $this->selectKeyword(1, 3);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some test<em> to test %4%</em> more %5% content</p>');

        // Test selecting from after the em tag to inside. New content should be in italic.
        $this->useTest(11);
        $this->selectKeyword(3, 5);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% italic <em>%2% content test</em> content</p>');

    }//end testEditingItalicContent()


    /**
     * Test splitting a italic section in content
     *
     * @return void
     */
    public function testSplittingItalicContent()
    {
        // Test pressing enter in the middle of italic content
        $this->useTest(9);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p>%1% <em>a %2%</em></p><p><em>test b</em> %3%</p>');

        // Test pressing enter at the start of italic content
        $this->useTest(9);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<p>%1% </p><p><em>test a %2% b</em> %3%</p>');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('<p>%1% test</p><p><em>test a %2% b</em> %3%</p>');

        // Test pressing enter at the end of italic content
        $this->useTest(9);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<p>%1% <em>a %2% b</em></p><p>test&nbsp;&nbsp;%3%</p>');

    }//end testSplittingItalicContent()


    /**
     * Test undo and redo applying italic to content
     *
     * @return void
     */
    public function testUndoAndRedoApplyingItalicContent()
    {
        // Apply italic content
        $this->useTest(3);
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('<p>%1% <em>%2%</em> %3%</p><p>sit %4% %5%</p><p>Another p</p>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <em>%2%</em> %3%</p><p>sit %4% %5%</p><p>Another p</p>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>%1% <em>%2%</em> %3%</p><p>sit %4% %5%</p><p>Another p</p>');

         // Apply italic content again
        $this->selectKeyword(4);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('<p>%1% <em>%2%</em> %3%</p><p>sit <em>%4%</em> %5%</p><p>Another p</p>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% <em>%2%</em> %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <em>%2%</em> %3%</p><p>sit <em>%4%</em> %5%</p><p>Another p</p>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1% <em>%2%</em> %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>%1% <em>%2%</em> %3%</p><p>sit <em>%4%</em> %5%</p><p>Another p</p>');

    }//end testUndoAndRedoApplyingItalicContent()


    /**
     * Test undo and redo when editing italic content
     *
     * @return void
     */
    public function testUndoAndRedoWithEditingItalicContent()
    {

        // Add content to the middle of the italic content
        $this->useTest(7);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>%1%</em></p><p>Some more italic <em>%2% test %3%</em> content to test</p>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>%1%</em></p><p>Some more italic <em>%2% %3%</em> content to test</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>%1%</em></p><p>Some more italic <em>%2% test %3%</em> content to test</p>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>%1%</em></p><p>Some more italic <em>%2% %3%</em> content to test</p>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>%1%</em></p><p>Some more italic <em>%2% test %3%</em> content to test</p>');

        // Test deleting content and pressing undo
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content </p><p>Some more italic <em>%2% test %3%</em> content to test</p>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>%1%</em></p><p>Some more italic <em>%2% test %3%</em> content to test</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content </p><p>Some more italic <em>%2% test %3%</em> content to test</p>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <em>%1%</em></p><p>Some more italic <em>%2% test %3%</em> content to test</p>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content </p><p>Some more italic <em>%2% test %3%</em> content to test</p>');

    }//end testUndoAndRedoWithEditingBoldContent()

}//end class

?>
