<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_DivUnitTest extends AbstractViperUnitTest
{


    /**
     * Test applying the div tag to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testApplingTheDivStyleUsingInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'THIS';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_div.png');

        $this->assertHTMLMatch('<div>Lorem xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>WoW</strong></div><div>THIS is a paragraph to change to a div</div>');

        $this->click($this->find('WoW'));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_div_active.png'), 'Div icon is not active');

    }//end testApplingTheDivStyleUsingInlineToolbar()


    /**
     * Test applying the div tag to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testApplingTheDivStyleUsingTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'THIS';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_div.png');

        $this->assertHTMLMatch('<div>Lorem xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>WoW</strong></div><div>THIS is a paragraph to change to a div</div>');

        $this->click($this->find('WoW'));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_div_active.png'), 'Quote icon is not active');

    }//end testApplingTheDivStyleUsingTopToolbar()


    /**
     * Test that applying styles to whole Div and selecting the DIV in lineage shows quote tools only.
     *
     * @return void
     */
    public function testSelectDivAfterStylingShowsCorrectIcons()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);

        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->selectInlineToolbarLineageItem(0);

        // Make sure the correct icons are being shown in the inline toolbar.
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_div_active.png'), 'Div icon is not active');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_div_active.png'), 'Div icon is not active');

    }//end testSelectDivAfterStylingShowsCorrectIcons()


     /**
     * Test selecting text in a Div shows the Div icons in the inline toolbar.
     *
     * @return void
     */
    public function testSelectingDivWithFormattedTextShowsCorrectIcons()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_div_active.png'), 'Div icon is not active');

        $this->click($this->find('Lorem'));
        $this->selectText('sit');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
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

        $this->assertHTMLMatch('<div><strong>Lorem</strong> xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>WoW</strong></div><p>THIS is a paragraph to change to a div</p>');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<div>Lorem xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>WoW</strong></div><p>THIS is a paragraph to change to a div</p>');

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

        $this->assertHTMLMatch('<div><em>Lorem</em> xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>WoW</strong></div><p>THIS is a paragraph to change to a div</p>');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<div>Lorem xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>WoW</strong></div><p>THIS is a paragraph to change to a div</p>');

    }//end testUsingItalicInDiv()


    /**
     * Test that the div icon is selected when you switch between selection and div.
     *
     * @return void
     */
    public function testDivIconIsActiveWhenSelectingDivTag()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_div_active.png'), 'Div icon is not active');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon is still active in the inline toolbar');

    }//end testDivIconIsActiveWhenSelectingDivTag()


    /**
     * Test that when you only select part of a paragraph and apply the div, it applies it to the whole paragraph.
     *
     * @return void
     */
    public function testDivAppliedToParagraphOnPartialSelection()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('THIS');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Toogle formats icon should not appear in the inline toolbar');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_div.png');

        $this->assertHTMLMatch('<div>Lorem xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>WoW</strong></div><div>THIS is a paragraph to change to a div</div>');

    }//end testDivAppliedToParagraphOnPartialSelection()


    /**
     * Test applying and then removing the Div format.
     *
     * @return void
     */
    public function testApplyingAndRemovingDiv()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('THIS');
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_div.png');

        $this->assertHTMLMatch('<div>Lorem xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>WoW</strong></div><div>THIS is a paragraph to change to a div</div>');

        $this->click($this->find('WoW'));
        $this->selectText('THIS' );
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_div_active.png');

        $this->assertHTMLMatch('<div>Lorem xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>WoW</strong></div>THIS is a paragraph to change to a div');

    }//end testApplyingAndRemovingQuote()


    /**
     * Test creating new content in div's.
     *
     * @return void
     */
    public function testCreatingNewContentWithADivTag()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('THIS');
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('New content');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_div.png');
        $this->keyDown('Key.RIGHT');
        $this->type(' on the page');
        $this->keyDown('Key.ENTER');
        $this->type('More new content');

        $this->assertHTMLMatch('<div>Lorem xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>WoW</strong></div><p>THIS is a paragraph to change to a div</p><div>New content on the page</div><p>More new content</p>');

    }//end testCreatingNewContentWithADivTag()


}//end class

?>
