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
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'selected'), 'Selected quote icon should appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should appear in the inline toolbar');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);

        // Check the state of the format icon after we have changed to a quote
        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'formats icon should not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Active formats icon should not appear in the inline toolbar');

        // Check the state of the format icon when we click P
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Formats icon should not appear in the inline toolbar');

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
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'selected'), 'Selected quote icon should appear in the inline toolbar');
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
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'selected'), 'Selected quote icon should appear in the inline toolbar');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);

        // Check the state of the format icon after we have changed to a quote
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'disabled'), 'Formats icon should disabled in the top toolbar');

        // Check the state of the format icon when we click P
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active blockquote icon should appear in the top toolbar');

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
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertEquals($this->replaceKeywords('%1% xtn %2%'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon does not appear in the top toolbar');
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
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
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertEquals($this->replaceKeywords('%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon does not appear in the top toolbar');
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
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
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);

        // Go to P
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Quote icon should appear in the inline toolbar');

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
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'disabled'), 'Disabled formats icon should appear in the top toolbar');

    }//end testPartialSelectionOfQuote()


    /**
     * Test applying and then removing the Quote format using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingQuoteUsingInlineToolbar()
    {
        // Test single line
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><blockquote><p>%4% is a paragraph to change to a quote</p></blockquote>');

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        // Make sure all icons are still enabled
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        // Test multi-line
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><blockquote><p>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote><p>%4% is a paragraph to change to a quote</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><p>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p><p>%4% is a paragraph to change to a quote</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

    }//end testApplyingAndRemovingQuoteUsingInlineToolbar()


    /**
     * Test applying and then removing the Quote format using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingQuoteUsingTopToolbar()
    {
        // Test single line
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><blockquote><p>%4% is a paragraph to change to a quote</p></blockquote>');

        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        // Make sure all icons are still enabled
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // Test multi-line
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><blockquote><p>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote><p>%4% is a paragraph to change to a quote</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><p>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p><p>%4% is a paragraph to change to a quote</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

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
        $this->moveToKeyword(5, 'right');
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

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><blockquote><p>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote><p>%4% is a paragraph to change to a quote</p>');

    }//end testChaningMultiLineDivToQuote()


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
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'disabled'), 'P icon should be disabled in the top toolbar');

    }//end testFormatIconWhenSwitchingBetweenQuoteAndWord()


    /**
     * Tests changing a blockquote to a div and then back again using the inline toolbar.
     *
     * @return void
     */
    public function testChangingAQuoteToADivUsingInlineToolbar()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn %2%</div><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

    }//end testChangingAQuoteToADivUsingInlineToolbar()


    /**
     * Tests changing a blockquote to a div and then back again using the top toolbar.
     *
     * @return void
     */
    public function testChangingAQuoteToADivUsingTopToolbar()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn %2%</div><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

    }//end testChangingAQuoteToADivUsingTopToolbar()


     /**
     * Tests changing a Quote to a PRE and then back again using the inline toolbar.
     *
     * @return void
     */
    public function testChangingAQuoteToAPreUsingTheInlineToolbar()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

    }//end testChangingAQuoteToAPreUsingTheInlineToolbar()


     /**
     * Tests changing a Quote to a PRE and then back again using the top toolbar.
     *
     * @return void
     */
    public function testChangingAQuoteToAPreUsingTheTopToolbar()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

    }//end testChangingAParagraphToAPreUsingTheTopToolbar()


     /**
     * Tests changing a Quote to a paragraph and then back again using the inline toolbar.
     *
     * @return void
     */
    public function testChangingAQuoteToAParagraphUsingTheInlineToolbar()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

    }//end testApplyingQuoteToAParagraphUsingTheInlineToolbar()


     /**
     * Tests changing a Quote to a paragraph and then back again using the top toolbar.
     *
     * @return void
     */
    public function testChangingAQuoteToAParagraphUsingTheTopToolbar()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

    }//end testChangingAQuoteToAParagraphUsingTheTopToolbar()


     /**
     * Tests selecting the P element in a blockquote and trying to change it to a blockquote.
     *
     * @return void
     */
    public function testChangingThePElementInQuoteToAQuote()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('Quote', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        // Change it back so we can test the top toolbar
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

    }//end testChangingThePElementInQuoteToAQuote()


     /**
     * Tests selecting the P element in a blockquote and changing it to a Div.
     *
     * @return void
     */
    public function testChangingThePElementInQuoteToADiv()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn %2%</div><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        // Change it back so we can test the top toolbar
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn %2%</div><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

    }//end testChangingThePElementInQuoteToADiv()


     /**
     * Tests selecting the P element in a blockquote and changing it to a Pre.
     *
     * @return void
     */
    public function testChangingThePElementInQuoteToAPre()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        // Change it back so we can test the top toolbar
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

    }//end testChangingThePElementInQuoteToAPre()


     /**
     * Tests that the list icons are not available for a quote.
     *
     * @return void
     */
    public function testListIconsNotAvailableForQuote()
    {

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');
        $this->keyDown('Key.RIGHT');

        // Change the div to a quote
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><blockquote><p>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote><p>%4% is a paragraph to change to a quote</p>');

        $this->click($this->findKeyword(3));
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

    }//end testListIconsNotAvailableForQuote()


    /**
     * Test undo and redo for a quote.
     *
     * @return void
     */
    public function testUndoAndRedoForQuote()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><blockquote><p>%4% is a paragraph to change to a quote</p></blockquote>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% is a paragraph to change to a quote</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><blockquote><p>%4% is a paragraph to change to a quote</p></blockquote>');

    }//end testUndoAndRedoForQuote()


    /**
     * Test combining two Quote sections.
     *
     * @return void
     */
    public function testCombiningQuoteSections()
    {
        // Change the div to a quote
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><blockquote><p>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote><p>%4% is a paragraph to change to a quote</p>');

        $this->moveToKeyword(3, 'left');
        $this->keyDown('Key.BACKSPACE');
        
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote><p>%4% is a paragraph to change to a quote</p>');

    }//end testCombiningQuoteSections()


    /**
     * Test combining a Quote sand P section.
     *
     * @return void
     */
    public function testCombiningQuoteAndPSections()
    {
        // Change the div to a P
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><p>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p><p>%4% is a paragraph to change to a quote</p>');

        $this->moveToKeyword(3, 'left');
        $this->keyDown('Key.BACKSPACE');
        
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote><p>%4% is a paragraph to change to a quote</p>');

    }//end testCombiningQuoteAndPSections()


    /**
     * Test combining a Quote sand Div section.
     *
     * @return void
     */
    public function testCombiningQuoteAndDivSections()
    {
        $this->moveToKeyword(3, 'left');
        $this->keyDown('Key.BACKSPACE');
        
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote><p>%4% is a paragraph to change to a quote</p>');

    }//end testCombiningQuoteAndDivSections()


    /**
     * Test combining a Quote sand Pre section.
     *
     * @return void
     */
    public function testCombiningQuoteAndPreSections()
    {
        // Change the div to a Pre
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><pre>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre><p>%4% is a paragraph to change to a quote</p>');

        $this->moveToKeyword(3, 'left');
        $this->keyDown('Key.BACKSPACE');
        
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote><p>%4% is a paragraph to change to a quote</p>');

    }//end testCombiningQuoteAndPreSections()

}//end class

?>
