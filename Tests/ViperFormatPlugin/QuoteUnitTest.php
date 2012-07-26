<?php

require_once 'AbstractFormatsUnitTest.php';

class Viper_Tests_ViperFormatPlugin_QuoteUnitTest extends AbstractFormatsUnitTest
{


    /**
     * Test applying the quote tag to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testApplingTheQuoteStyleUsingInlineToolbar()
    {

        // Test selecting a word in a p to change to a paragraph
        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Toogle formats icon should not appear in the inline toolbar');

        // Select all content in the p and change to a quote
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Toogle formats should appear in the inline toolbar');
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><blockquote><p>%4% is a paragraph to change to a quote</p></blockquote>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);

        // Check the state of the format icon after we have changed to a paragraph
        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'formats icon should not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Active formats icon should not appear in the inline toolbar');

        // Check the state of the format icon when we click P
        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'), 'Active P icon should not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);


    }//end testApplingTheQuoteStyleUsingInlineToolbar()


    /**
     * Test applying the quote tag to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testApplingTheQuoteStyleUsingTopToolbar()
    {

        // Test clicking in a P to change to a Quote
        $this->click($this->findKeyword(4));
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><blockquote><p>%4% is a paragraph to change to a quote</p></blockquote>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);

        // Change it back to do more testing
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);

        // Test selecting a paragraph to change to a quote
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'active P icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><blockquote><p>%4% is a paragraph to change to a quote</p></blockquote>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);

        // Check the state of the format icon after we have changed to a quote
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should disabled in the top toolbar');

        // Check the state of the format icon when we click P
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);

    }//end testApplingTheQuoteStyleUsingTopToolbar()


    /**
     * Test that applying styles to whole blockquote and selecting the Quote in lineage shows quote tools only.
     *
     * @return void
     */
    public function testSelectQuoteAfterStylingShowsCorrectIcons()
    {
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->selectInlineToolbarLineageItem(0);

        // Make sure the correct icons are being shown in the inline toolbar.
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon does not appear in the inline toolbar');
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'active', 'disabled');
        $this->assertEquals($this->replaceKeywords('%1% xtn %2%'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon does not appear in the top toolbar');
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'active', 'disabled');
        $this->assertEquals($this->replaceKeywords('%1% xtn %2%'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectQuoteAfterStylingShowsCorrectIcons()


    /**
     * Test that applying styles to multi-line blockquote and selecting the Quote in lineage shows quote tools only.
     *
     * @return void
     */
    public function testSelectMultiLineQuoteAfterStylingShowsCorrectIcons()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->selectInlineToolbarLineageItem(0);

        // Make sure the correct icons are being shown in the inline toolbar.
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon does not appear in the inline toolbar');
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'active', 'disabled');
        $this->assertEquals($this->replaceKeywords('%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon does not appear in the top toolbar');
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'active', 'disabled');
        $this->assertEquals($this->replaceKeywords('%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectMultiLineQuoteAfterStylingShowsCorrectIcons()


    /**
     * Test bold works in blockquotes.
     *
     * @return void
     */
    public function testUsingBoldInBlockquotes()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<blockquote><p><strong>%1%</strong> xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

    }//end testUsingBoldInBlockquotes()


    /**
     * Test italics works in blockquotes.
     *
     * @return void
     */
    public function testUsingItalicInBlockquotes()
    {

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<blockquote><p><em>%1%</em> xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

    }//end testUsingItalicInBlockquotes()


    /**
     * Test that the quote icon is selected when you switch between selection and quote.
     *
     * @return void
     */
    public function testQuoteIconIsActiveWhenSelectingQuoteTag()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'active', 'disabled');

        // Go to P
        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Quote icon should not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'), 'P icon should not appear in the inline toolbar');

        // Go back to Quote then Selection
        $this->selectInlineToolbarLineageItem(0);
        $this->selectInlineToolbarLineageItem(2);
        $this->assertFalse($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Toogle formats icon is still active in the inline toolbar');

    }//end testQuoteIconIsActiveWhenSelectingQuoteTag()


    /**
     * Test that when you select part of a blockquote that you cannot change it to another format type.
     *
     * @return void
     */
    public function testPartialSelectionOfQuote()
    {
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'), 'Active P icon should not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Disabled formats icon should appear in the top toolbar');

    }//end testPartialSelectionOfQuote()


    /**
     * Test applying and then removing the Quote format using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingQuoteUsingInlineToolbar()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><blockquote><p>%4% is a paragraph to change to a quote</p></blockquote>');

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>%4% is a paragraph to change to a quote');

        // Make sure all icons are still enabled
        $this->checkStatusOfFormatIconsInTheInlineToolbar();

    }//end testApplyingAndRemovingQuoteUsingInlineToolbar()


    /**
     * Test applying and then removing the Quote format using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingQuoteUsingTopToolbar()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><blockquote><p>%4% is a paragraph to change to a quote</p></blockquote>');

        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>%4% is a paragraph to change to a quote');

        // Make sure all icons are still enabled
        $this->checkStatusOfFormatIconsInTheTopToolbar();

    }//end testApplyingAndRemovingQuoteUsingTopToolbar()


    /**
     * Test creating new content in blockquote tags.
     *
     * @return void
     */
    public function testCreatingNewContentWithABlockquoteTag()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('New %5%');
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->selectKeyword(5);
        $this->keyDown('Key.RIGHT');
        $this->type(' on the page');
        $this->keyDown('Key.ENTER');
        $this->type('More new content');

        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p><blockquote><p>New XTX on the page</p><p>More new content</p></blockquote>');

    }//end testCreatingNewContentWithABlockquoteTag()


    /**
     * Test changing a multi-line div section to a quote.
     *
     * @return void
     */
    public function testChaningMultiLineDivToQuote()
    {

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><blockquote><p>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote><p>%4% is a paragraph to change to a quote</p>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><blockquote><p>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote><p>%4% is a paragraph to change to a quote</p>');

    }//end testChaningMultiLineDivToQuote()


    /**
     * Test applying and then removing the Quote format to a multi line Quote.
     *
     * @return void
     */
    public function testApplyingAndRemovingQuoteToMultiLineQuote()
    {

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><blockquote><p>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote><p>%4% is a paragraph to change to a quote</p>');
        $this->selectInlineToolbarLineageItem(0);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);

        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote> %3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae. <p>%4% is a paragraph to change to a quote</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

    }//end testRemovingAndApplyingQuoteToMultiLineQuote()


     /**
     * Tests that when you select a quote and then a word in that quote, the disabled format icon is shown in the top toolbar.
     *
     * @return void
     */
    public function testFormatIconWhenSwitchingBetweenQuoteAndWord()
    {

        // Highlight the content of a quote
        $this->selectKeyword(1, 2);
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active blockquote icon should appear in the top toolbar');

        // Highlight a word in the selected paragraph
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled in the top toolbar');

    }//end testFormatIconWhenSwitchingBetweenQuoteAndWord()


}//end class

?>
