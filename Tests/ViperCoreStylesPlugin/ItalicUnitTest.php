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
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><em>%1%</em> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStartOfParaItalic()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaItalic()
    {
        $this->selectKeyword(2);

        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <em>%2%</em> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testMidOfParaItalic()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaItalic()
    {
        $this->selectKeyword(3);

        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% %2% <em>%3%</em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->sikuli->click($this->findKeyword(2));

        $this->selectKeyword(3);
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');

    }//end testEndOfParaItalic()


    /**
     * Test that italics is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemovingItalicsFromPartOfTheFormattedContent()
    {
        $this->selectKeyword(2, 3);

        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <em>%2% %3%</em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->selectKeyword(3);

        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>%1% <em>%2% </em>%3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->selectKeyword(2);
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');

    }//end testRemovingItalicsFromPartOfTheFormattedContent()


    /**
     * Test that the shortcut command works for Italics.
     *
     * @return void
     */
    public function testShortcutCommandForItalics()
    {
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
     * Test that a paragraph can be made italics using the top toolbar and that the VITP italic icon will appear when that happen. Then remove the italics formatting and check that the VITP italic icon is removed.
     *
     * @return void
     */
    public function testAddingAndRemovingFormattingToAParagraph()
    {
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

    }//end testAddingAndRemovingFormattingToAParagraph()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentAWordStyling()
    {
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p><em>%1%</em> <em>%2%</em> <em>%3%</em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that style can be removed.
     *
     * @return void
     */
    public function testRemoveFormating()
    {
        $this->selectKeyword(4);
        $this->clickInlineToolbarButton('italic', 'active');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon is still active in the inline toolbar');

    }//end testRemoveFormating()


    /**
     * Test that the Italic icons are active when you select a word that is italics.
     *
     * @return void
     */
    public function testIconsAreActive()
    {
        $this->selectKeyword(4);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Active italic icon does not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon is not active in the top toolbar');

    }//end testIconsAreActive()


    /**
     * Test that the VITP italc icon is removed from the toolbar when you click the P tag.
     *
     * @return void
     */
    public function testIconIsRemovedFromInlineToolbar()
    {
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

    }//end testIconIsRemovedFromInlineToolbar()


    /**
     * Test applying a italics to two words where one word is bold.
     *
     * @return void
     */
    public function testAddingItalicsToTwoWordsWhereOneIsBold()
    {
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>%1% <strong>%2%</strong> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p>%1% <em><strong>%2%</strong> %3%</em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAddingItalicsToTwoWordsWhereOneIsBold()


    /**
     * Test applying italics to two words where one is bold and one is italics.
     *
     * @return void
     */
    public function testAddingItalicsToTwoWordsWhereOneIsBoldAndOneItalics()
    {
        $this->selectKeyword(4, 5);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4% <strong>%5%</strong></em></p>');

    }//end testAddingItalicsToTwoWordsWhereOneIsBoldAndOneItalics()


    /**
     * Test applying italics to two paragraphs where there is a HTML comment in the source code.
     *
     * @return void
     */
    public function testApplyingAndRemovingItalicsToTwoParagraphsWhereHtmlCommentsInSource()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em><!-- hello world! --></p><p>sit %4% %5%</p><p>Another p</p>');

        $this->sikuli->click($this->findKeyword(2));

        $this->selectKeyword(5);
        sleep(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em><!-- hello world! --></p><p><em>sit %4% %5%</em></p><p>Another p</p>');

        $this->selectKeyword(1, 5);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>%1% %2% %3%<!-- hello world! --></p><p>sit %4% %5%</p><p>Another p</p>');

    }//end testApplyingAndRemovingItalicsToTwoParagraphsWhereHtmlCommentsInSource()


    /**
     * Test applying and removing italics to two paragraphs.
     *
     * @return void
     */
    public function testApplyingAndRemovingItalicsToTwoParagraphs()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em></p><p>sit %4% %5%</p><p>Another p</p>');

        $this->sikuli->click($this->findKeyword(2));

        $this->selectKeyword(5);
        sleep(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em></p><p><em>sit %4% %5%</em></p><p>Another p</p>');

        $this->selectKeyword(1, 5);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% %5%</p><p>Another p</p>');

    }//end testApplyingAndRemovingItalicsToTwoParagraphs()


    /**
     * Test applying and removing italics to all content. Also checks that class and anchor does not become active when it applies the bold
     *
     * @return void
     */
    public function testApplyingAndRemovingItalicToAllContent()
    {
        $this->sikuli->click($this->findKeyword(2));
        $this->sikuli->keyDown('Key.CMD + a');
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<p><em>%1% %2% %3%</em></p><p><em>sit %4% <strong>%5%</strong></em></p>');

        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'), 'Class icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should not be active');

        $this->sikuli->click($this->findKeyword(2));
        $this->sikuli->keyDown('Key.CMD + a');
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'), 'Class icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should not be active');

    }//end testApplyingAndRemovingItalicToAllContent()


    /**
     * Test that undo and redo buttons for italic formatting.
     *
     * @return void
     */
    public function testUndoAndRedoForItalic()
    {
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


}//end class

?>
