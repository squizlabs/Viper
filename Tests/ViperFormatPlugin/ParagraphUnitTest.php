<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_ParagraphUnitTest extends AbstractViperUnitTest
{


    /**
     * Test applying the p tag to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testApplingThePStyleUsingInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'THIS';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_p.png');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet <strong>WoW</strong></p><p>THIS is a paragraph to change to a p</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_p_active.png'), 'P icon is not active');

    }//end testApplingThePStyleUsingInlineToolbar()


    /**
     * Test applying the p tag to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testApplingThePStyleUsingTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'THIS';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_p.png');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet <strong>WoW</strong></p><p>THIS is a paragraph to change to a p</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_p_active.png'), 'P icon is not active');

    }//end testApplingThePStyleUsingTopToolbar()
    

    /**
     * Tests that applying styles to whole paragraph and selecting the P in lineage shows paragraph tools.
     *
     * @return void
     */
    public function testSelectParaAfterStylingShowsCorrectIcons()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem', 'dolor');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->selectInlineToolbarLineageItem(0);

        // Make sure the correct icons are being shown in the inline toolbar.
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_p_active.png'), 'P icon is not active');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_p_active.png'), 'P icon is not active');

    }//end testSelectParaAfterStylingShowsCorrectIcons()


     /**
     * Tests selecting text in a paragraph.
     *
     * @return void
     */
    public function testSelectingParagraphsWithFormattedTextShowsCorrectIcons()
    {
         $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_p_active.png'), 'P icon is not active');

        $this->click($this->find('Lorem'));
        $this->selectText('sit');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_p_active.png'), 'P icon is not active');

    }//end testSelectingParagraphsWithFormattedTextShowsCorrectIcons()


    /**
     * Test that when you only select part of a paragraph and apply the P, it applies it to the whole paragraph.
     *
     * @return void
     */
    public function testDivAppliedToParagraphOnPartialSelection()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('THIS');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon should not appear in the inline toolbar');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_p.png');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet <strong>WoW</strong></p><p>THIS is a paragraph to change to a p</p>');

    }//end testDivAppliedToParagraphOnPartialSelection()


    /**
     * Test applying and then removing the P format.
     *
     * @return void
     */
    public function testApplyingAndRemovingP()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('THIS');
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_p.png');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet <strong>WoW</strong></p><p>THIS is a paragraph to change to a p</p>');

        $this->selectText('THIS');
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_p_active.png');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet <strong>WoW</strong></p>THIS is a paragraph to change to a p');

    }//end testApplyingAndRemovingP()
    
}//end class

?>
