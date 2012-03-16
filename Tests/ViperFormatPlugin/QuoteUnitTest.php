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
        $dir = dirname(__FILE__).'/Images/';

        $text = 'THIS';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_blockquote.png');

        $this->assertHTMLMatch('<blockquote>Lorem xtn dolor</blockquote><blockquote>sit amet <strong>WoW</strong></blockquote><blockquote>THIS is a paragraph to change to a quote</blockquote>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_blockquote_active.png'), 'Quote icon is not active');

    }//end testApplingTheQuoteStyleUsingInlineToolbar()


    /**
     * Test applying the quote tag to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testApplingTheQuoteStyleUsingTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'THIS';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_blockquote.png');

        $this->assertHTMLMatch('<blockquote>Lorem xtn dolor</blockquote><blockquote>sit amet <strong>WoW</strong></blockquote><blockquote>THIS is a paragraph to change to a quote</blockquote>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_blockquote_active.png'), 'Quote icon is not active');

    }//end testApplingTheQuoteStyleUsingTopToolbar()


    /**
     * Test that applying styles to whole blockquote and selecting the Quote in lineage shows quote tools only.
     *
     * @return void
     */
    public function testSelectQuoteAfterStylingShowsCorrectIcons()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem', 'dolor');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->selectInlineToolbarLineageItem(0);

       // Make sure the correct icons are being shown in the inline toolbar.
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_blockquote_active.png'), 'Quote icon is not active');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_blockquote_active.png'), 'Quote icon is not active');

    }//end testSelectQuoteAfterStylingShowsCorrectIcons()


     /**
     * Test selecting text in a blockquote shows the quote icons in the inline toolbar.
     *
     * @return void
     */
    public function testSelectingQuotesWithFormattedTextShowsCorrectIcons()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_blockquote_active.png'), 'Quote icon is not active');

        $this->selectText('sit');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_blockquote_active.png'), 'Quote icon is not active');

    }//end testSelectingQuotesWithFormattedTextShowsCorrectIcons()


    /**
     * Test bold works in blockquotes.
     *
     * @return void
     */
    public function testUsingBoldInBlockquotes()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text    = 'Lorem';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<blockquote><strong>Lorem</strong> xtn dolor</blockquote><blockquote>sit amet <strong>WoW</strong></blockquote><p>THIS is a paragraph to change to a quote</p>');

        $this->click($textLoc);
        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<blockquote>Lorem xtn dolor</blockquote><blockquote>sit amet <strong>WoW</strong></blockquote><p>THIS is a paragraph to change to a quote</p>');

    }//end testUsingBoldInBlockquotes()


    /**
     * Test italics works in blockquotes.
     *
     * @return void
     */
    public function testUsingItalicInBlockquotes()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<blockquote><em>Lorem</em> xtn dolor</blockquote><blockquote>sit amet <strong>WoW</strong></blockquote><p>THIS is a paragraph to change to a quote</p>');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<blockquote>Lorem xtn dolor</blockquote><blockquote>sit amet <strong>WoW</strong></blockquote><p>THIS is a paragraph to change to a quote</p>');

    }//end testUsingItalicInBlockquotes()


    /**
     * Test that the quote icon is selected when you switch between selection and quote.
     *
     * @return void
     */
    public function testQuoteIconIsActiveWhenSelectingQuoteTag()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_blockquote_active.png'), 'Quote icon is not active');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is still active in the inline toolbar');

    }//end testQuoteIconIsActiveWhenSelectingQuoteTag()


    /**
     * Test that when you only select part of a paragraph and apply the quote, it applies it to the whole paragraph.
     *
     * @return void
     */
    public function testQuoteAppliedToParagraphOnPartialSelection()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('THIS');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon should not appear in the inline toolbar');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_blockquote.png');

        $this->assertHTMLMatch('<blockquote>Lorem xtn dolor</blockquote><blockquote>sit amet <strong>WoW</strong></blockquote><blockquote>THIS is a paragraph to change to a quote</blockquote>');

    }//end testQuoteAppliedToParagraphOnPartialSelection()


    /**
     * Test applying and then removing the Quote format.
     *
     * @return void
     */
    public function testApplyingAndRemovingQuote()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('THIS');
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_blockquote.png');

        $this->assertHTMLMatch('<blockquote>Lorem xtn dolor</blockquote><blockquote>sit amet <strong>WoW</strong></blockquote><blockquote>THIS is a paragraph to change to a quote</blockquote>');

        $this->selectText('THIS');
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_blockquote_active.png');

        $this->assertHTMLMatch('<blockquote>Lorem xtn dolor</blockquote><blockquote>sit amet <strong>WoW</strong></blockquote>THIS is a paragraph to change to a quote');

    }//end testApplyingAndRemovingQuote()


}//end class

?>
