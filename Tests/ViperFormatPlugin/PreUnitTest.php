<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_PreUnitTest extends AbstractViperUnitTest
{


    /**
     * Test applying the pre tag to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testApplingThePreStyleUsingInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'THIS';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_pre.png');

        $this->assertHTMLMatch('<pre>Lorem xtn dolor</pre><pre>sit amet <strong>WoW</strong></pre><pre>THIS is a paragraph to change to a PrE</pre>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_pre_active.png'), 'Pre icon is not active');

    }//end testApplingThePreStyleUsingInlineToolbar()


    /**
     * Test applying the pre tag to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testApplingThePreStyleUsingTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'THIS';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_pre.png');

        $this->assertHTMLMatch('<pre>Lorem xtn dolor</pre><pre>sit amet <strong>WoW</strong></pre><pre>THIS is a paragraph to change to a PrE</pre>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_pre_active.png'), 'Pre icon is not active');

    }//end testApplingThePreStyleUsingTopToolbar()


    /**
     * Test that applying styles to whole pre and selecting the PRE in lineage shows correct icons.
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

        // Make sure the correct icons are being shown in the inline toolbar.
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_pre_active.png'), 'Pre icon is not active');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_pre_active.png'), 'Pre icon is not active');

    }//end testSelectPreAfterStylingShowsCorrectIcons()


     /**
     * Test selecting text in a Pre shows the Pre icons in the inline toolbar.
     *
     * @return void
     */
    public function testSelectingPreWithFormattedTextShowsCorrectIcons()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_pre_active.png'), 'Pre icon is not active');

        $this->selectText('sit');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_pre_active.png'), 'PRe icon is not active');

    }//end testSelectingPreWithFormattedTextShowsCorrectIcons()


    /**
     * Test bold works in Pre.
     *
     * @return void
     */
    public function testUsingBoldInPre()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text    = 'Lorem';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<pre><strong>Lorem</strong> xtn dolor</pre><pre>sit amet <strong>WoW</strong></pre><p>THIS is a paragraph to change to a PrE</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<pre>Lorem xtn dolor</pre><pre>sit amet <strong>WoW</strong></pre><p>THIS is a paragraph to change to a PrE</p>');

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

        $this->assertHTMLMatch('<pre><em>Lorem</em> xtn dolor</pre><pre>sit amet <strong>WoW</strong></pre><p>THIS is a paragraph to change to a PrE</p>');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<pre>Lorem xtn dolor</pre><pre>sit amet <strong>WoW</strong></pre><p>THIS is a paragraph to change to a PrE</p>');

    }//end testUsingItalicInPre()


    /**
     * Test that the Pre icon is selected when you switch between selection and pre.
     *
     * @return void
     */
    public function testPreIconIsActiveWhenSelectingPreTag()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_pre_active.png'), 'Pre icon is not active');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is still active in the inline toolbar');

    }//end testPreIconIsActiveWhenSelectingPreTag()


    /**
     * Test that when you only select part of a paragraph and apply the pre, it applies it to the whole paragraph.
     *
     * @return void
     */
    public function testPreAppliedToParagraphOnPartialSelection()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('THIS');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon should not appear in the inline toolbar');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_pre.png');

        $this->assertHTMLMatch('<pre>Lorem xtn dolor</pre><pre>sit amet <strong>WoW</strong></pre><pre>THIS is a paragraph to change to a PrE</pre>');

    }//end testPreAppliedToParagraphOnPartialSelection()


    /**
     * Test applying and then removing the Pre format.
     *
     * @return void
     */
    public function testApplyingAndRemovingPre()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('THIS');
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_pre.png');

        $this->assertHTMLMatch('<pre>Lorem xtn dolor</pre><pre>sit amet <strong>WoW</strong></pre><pre>THIS is a paragraph to change to a PrE</pre>');

        $this->selectText('THIS');
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_pre_active.png');

        $this->assertHTMLMatch('<pre>Lorem xtn dolor</pre><pre>sit amet <strong>WoW</strong></pre>THIS is a paragraph to change to a PrE');

    }//end testApplyingAndRemovingPre()


}//end class

?>
