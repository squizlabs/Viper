<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_QuoteUnitTest extends AbstractViperUnitTest
{


    /**
     * Test applying the quote tag to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testApplingTheQuoteStyleUsingInlineToolbar()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);

        $this->assertHTMLMatch('<blockquote>%1% xtn %2%</blockquote><blockquote>%3% amet <strong>WoW</strong></blockquote><blockquote>%4% is a paragraph to change to a quote</blockquote>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Toogle formats icon is not selected');

        $this->clickInlineToolbarButton('formats-blockquote', 'active');

        $this->assertTrue($this->inlineToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon is not active');

    }//end testApplingTheQuoteStyleUsingInlineToolbar()


    /**
     * Test applying the quote tag to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testApplingTheQuoteStyleUsingTopToolbar()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->assertHTMLMatch('<blockquote>%1% xtn %2%</blockquote><blockquote>%3% amet <strong>WoW</strong></blockquote><blockquote>%4% is a paragraph to change to a quote</blockquote>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Toogle formats icon is not selected');

        $this->clickTopToolbarButton('formats-blockquote', 'active');

        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon is not active');

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
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon is not active');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon is not active');

    }//end testSelectQuoteAfterStylingShowsCorrectIcons()


     /**
     * Test selecting text in a blockquote shows the quote icons in the inline toolbar.
     *
     * @return void
     */
    public function testSelectingQuotesWithFormattedTextShowsCorrectIcons()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon is not active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon is not active');

    }//end testSelectingQuotesWithFormattedTextShowsCorrectIcons()


    /**
     * Test bold works in blockquotes.
     *
     * @return void
     */
    public function testUsingBoldInBlockquotes()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<blockquote><strong>%1%</strong> xtn %2%</blockquote><blockquote>%3% amet <strong>WoW</strong></blockquote><p>%4% is a paragraph to change to a quote</p>');

        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<blockquote>%1% xtn %2%</blockquote><blockquote>%3% amet <strong>WoW</strong></blockquote><p>%4% is a paragraph to change to a quote</p>');

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

        $this->assertHTMLMatch('<blockquote><em>%1%</em> xtn %2%</blockquote><blockquote>%3% amet <strong>WoW</strong></blockquote><p>%4% is a paragraph to change to a quote</p>');

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<blockquote>%1% xtn %2%</blockquote><blockquote>%3% amet <strong>WoW</strong></blockquote><p>%4% is a paragraph to change to a quote</p>');

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
        $this->assertTrue($this->inlineToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon is not active');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Toogle formats icon is still active in the inline toolbar');

    }//end testQuoteIconIsActiveWhenSelectingQuoteTag()


    /**
     * Test that when you only select part of a paragraph and apply the quote, it applies it to the whole paragraph.
     *
     * @return void
     */
    public function testQuoteAppliedToParagraphOnPartialSelection()
    {

        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Toogle formats icon should not appear in the inline toolbar');

        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->assertHTMLMatch('<blockquote>%1% xtn %2%</blockquote><blockquote>%3% amet <strong>WoW</strong></blockquote><blockquote>%4% is a paragraph to change to a quote</blockquote>');

    }//end testQuoteAppliedToParagraphOnPartialSelection()


    /**
     * Test applying and then removing the Quote format.
     *
     * @return void
     */
    public function testApplyingAndRemovingQuote()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->assertHTMLMatch('<blockquote>%1% xtn %2%</blockquote><blockquote>%3% amet <strong>WoW</strong></blockquote><blockquote>%4% is a paragraph to change to a quote</blockquote>');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->assertHTMLMatch('<blockquote>%1% xtn %2%</blockquote><blockquote>%3% amet <strong>WoW</strong></blockquote>%4% is a paragraph to change to a quote');

    }//end testApplyingAndRemovingQuote()


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

        $this->assertHTMLMatch('<blockquote>%1% xtn %2%</blockquote><blockquote>%3% amet <strong>WoW</strong></blockquote><p>%4% is a paragraph to change to a quote</p><blockquote>New %5% on the page</blockquote><p>More new content</p>');
        
    }//end testCreatingNewContentWithABlockquoteTag()

}//end class

?>
