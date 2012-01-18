<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_DivUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that applying styles to whole Div and selecting the DIV in lineage shows quote tools only.
     *
     * @return void
     */
    public function testSelectDivAfterStylingShowsCorrectIcons()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem', 'dolor');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->selectInlineToolbarLineageItem(0);

        // Make sure the correct icons are being shown.

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is not selected');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_div_active.png'), 'Div icon is not active');

    }//end testSelectDivAfterStylingShowsCorrectIcons()


     /**
     * Test selecting text in a Div shows the Div icons in the inline toolbar.
     *
     * @return void
     */
    public function testSelectingDivWithFormattedTextShowsCorrectIcons()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem', 'dolor');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is not selected');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_div_active.png'), 'Div icon is not active');

        $this->selectText('sit', 'WoW');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is not selected');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_div_active.png'), 'Div icon is not active');

    }//end testSelectingDivWithFormattedTextShowsCorrectIcons()


    /**
     * Test bold works in Div.
     *
     * @return void
     */
    public function testUsingBoldInDiv()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<div><strong>Lorem</strong> xtn dolor</div><div>sit amet <strong>WoW</strong></div>');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<div>Lorem xtn dolor</div><div>sit amet <strong>WoW</strong></div>');

    }//end testUsingBoldInDiv()


    /**
     * Test italics works in Div.
     *
     * @return void
     */
    public function testUsingItalicInDiv()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<div><em>Lorem</em> xtn dolor</div><div>sit amet <strong>WoW</strong></div>');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<div>Lorem xtn dolor</div><div>sit amet <strong>WoW</strong></div>');

    }//end testUsingItalicInDiv()


    /**
     * Test that the div icon is selected when you switch between selection and div.
     *
     * @return void
     */
    public function testDivIcon()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is not selected');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_div_active.png'), 'Div icon is not active');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is still active in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_div.png'), 'Div icon is still active in the inline toolbar');

    }//end testDivIcon()

}//end class

?>
