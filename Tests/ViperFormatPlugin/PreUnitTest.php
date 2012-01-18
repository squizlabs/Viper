<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_PreUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that applying styles to whole pre and selecting the PRE in lineage shows quote tools only.
     *
     * @return void
     */
    public function testSelectPreAfterStylingShowsCorrectIcons()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem', 'dolor');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->selectInlineToolbarLineageItem(0);

        // Make sure the correct icons are being shown.

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is not selected');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_pre_active.png'), 'Quote icon is not active');

    }//end testSelectPreAfterStylingShowsCorrectIcons()


     /**
     * Test selecting text in a Pre shows the Pre icons in the inline toolbar.
     *
     * @return void
     */
    public function testSelectingPreWithFormattedTextShowsCorrectIcons()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem', 'dolor');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is not selected');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_pre_active.png'), 'Quote icon is not active');

        $this->selectText('sit', 'WoW');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is not selected');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_pre_active.png'), 'Quote icon is not active');

    }//end testSelectingPreWithFormattedTextShowsCorrectIcons()


    /**
     * Test bold works in Pre.
     *
     * @return void
     */
    public function testUsingBoldInPre()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<pre><strong>Lorem</strong> xtn dolor</pre><pre>sit amet <strong>WoW</strong></pre>');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<pre>Lorem xtn dolor</pre><pre>sit amet <strong>WoW</strong></pre>');

    }//end testUsingBoldInPre()


    /**
     * Test italics works in pre.
     *
     * @return void
     */
    public function testUsingItalicInPre()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<pre><em>Lorem</em> xtn dolor</pre><pre>sit amet <strong>WoW</strong></pre>');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<pre>Lorem xtn dolor</pre><pre>sit amet <strong>WoW</strong></pre>');

    }//end testUsingItalicInPre()


    /**
     * Test that the Pre icon is selected when you switch between selection and pre.
     *
     * @return void
     */
    public function testPreIcon()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is not selected');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_pre_active.png'), 'Pre icon is not active');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_subActive.png'), 'Toogle formats icon is still active in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_pre.png'), 'Pre icon is still active in the inline toolbar');

    }//end testPreIcon()

}//end class

?>
