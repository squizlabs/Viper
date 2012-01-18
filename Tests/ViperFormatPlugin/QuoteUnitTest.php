<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_QuoteUnitTest extends AbstractViperUnitTest
{


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

        // Make sure the correct icons are being shown.

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is not selected');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_blockquote_active.png'), 'Quote icon is not active');

    }//end testSelectQuoteAfterStylingShowsCorrectIcons()


     /**
     * Test selecting text in a blockquote shows the quote icons in the inline toolbar.
     *
     * @return void
     */
    public function testSelectingQuotesWithFormattedTextShowsCorrectIcons()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem', 'dolor');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is not selected');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_blockquote_active.png'), 'Quote icon is not active');

        $this->selectText('sit', 'WoW');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is not selected');
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

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<blockquote><strong>Lorem</strong> xtn dolor</blockquote><blockquote>sit amet <strong>WoW</strong></blockquote>');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<blockquote>Lorem xtn dolor</blockquote><blockquote>sit amet <strong>WoW</strong></blockquote>');

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

        $this->assertHTMLMatch('<blockquote><em>Lorem</em> xtn dolor</blockquote><blockquote>sit amet <strong>WoW</strong></blockquote>');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<blockquote>Lorem xtn dolor</blockquote><blockquote>sit amet <strong>WoW</strong></blockquote>');

    }//end testUsingItalicInBlockquotes()


    /**
     * Test that the quote icon is selected when you switch between selection and quote.
     *
     * @return void
     */
    public function testQuoteIcon()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is not selected');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_blockquote_active.png'), 'Quote icon is not active');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is still active in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_blockquote.png'), 'Quote icon is still active in the inline toolbar');

    }//end testQuoteIcon()

}//end class

?>
