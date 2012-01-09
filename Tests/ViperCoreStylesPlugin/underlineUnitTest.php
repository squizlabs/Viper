<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_UnderlineUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testStartOfParaUnderline()
    {
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is not active in the inline toolbar');

        $this->assertHTMLMatch('<p><u>Lorem</u> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong> <u>food</u></p>');

    }//end testStartOfParaUnderline()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaUnderline()
    {
        $this->selectText('XuT');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is not active in the top toolbar');

        $this->assertHTMLMatch('<p>Lorem <u>XuT</u> dolor</p><p>sit <em>amet</em> <strong>WoW</strong> <u>food</u></p>');

    }//end testMidOfParaUnderline()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaUnderline()
    {
        $this->selectText('dolor');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is not active in the top toolbar');

        $this->assertHTMLMatch('<p>Lorem XuT <u>dolor</u></p><p>sit <em>amet</em> <strong>WoW</strong> <u>food</u></p>');

    }//end testEndOfParaUnderline()


    /**
     * Test that underline is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemovingFormatFromPartOfTheContent()
    {
        $this->selectText('XuT', 'dolor');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is not active in the top toolbar');

        $this->assertHTMLMatch('<p>Lorem <u>XuT dolor</u></p><p>sit <em>amet</em> <strong>WoW</strong> <u>food</u></p>');

        $this->selectText('dolor');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'), 'Underline icon is still active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'), 'Underline icon is still active in the top toolbar');

        $this->assertHTMLMatch('<p>Lorem <u>XuT </u>dolor</p><p>sit <em>amet</em> <strong>WoW</strong> <u>food</u></p>');

        $this->selectText('XuT');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is not active in the top toolbar');

    }//end testRemovingFormatFromPartOfTheContent()


    /**
     * Test that the shortcut command works for Underline.
     *
     * @return void
     */
    public function testShortcutCommand()
    {
        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + u');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is not active in the top toolbar');

        $this->assertHTMLMatch('<p><u>Lorem</u> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong> <u>food</u></p>');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + u');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'), 'Underline icon is still active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'), 'Underline icon is still active in the top toolbar');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong> <u>food</u></p>');

    }//end testShortcutCommand()


    /**
     * Test that VITP icon is not shown when whole P tag is selected but style can be applied using top toolbar.
     *
     * @return void
     */
    public function testAddingAndRemovingFormattingToAParagraph()
    {
        $start = $this->find('Lorem');
        $end   = $this->find('dolor');
        $this->dragDrop($this->getTopLeft($start), $this->getTopRight($end));

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'), 'Underline icon is displayed in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Active underline icon is displayed in the inline toolbar');

        // Click the Top Toolbar icon to make whole paragraph bold.
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');

        $this->assertHTMLMatch('<p><u>Lorem XuT dolor</u></p><p>sit <em>amet</em> <strong>WoW</strong> <u>food</u></p>');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is active in the top toolbar');

        // Inline Toolbar icon is now displayed
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Active underline icon does not appear in the inline toolbar');

        //Remove bold formating
        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong> <u>food</u></p>');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'), 'Underline icon is still active in the top toolbar');

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'), 'Underline icon is still displayed in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Active underline icon is still displayed in the inline toolbar');

    }//end testAddingAndRemovingFormattingToAParagraph()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectText('XuT');
        $this->keyDown('Key.CMD + u');

        $this->selectText('Lorem', 'XuT');
        $this->keyDown('Key.CMD + u');

        $this->selectText('XuT', 'dolor');
        $this->keyDown('Key.CMD + u');

        $this->assertHTMLMatch('<p><u>Lorem XuT dolor</u></p><p>sit <em>amet</em> <strong>WoW</strong> <u>food</u></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectText('XuT');
        $this->keyDown('Key.CMD + u');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + u');

        $this->selectText('dolor');
        $this->keyDown('Key.CMD + u');

        $this->assertHTMLMatch('<p><u>Lorem</u> <u>XuT</u> <u>dolor</u></p><p>sit <em>amet</em> <strong>WoW</strong> <u>food</u></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that underline can be removed.
     *
     * @return void
     */
    public function testRemoveFormating()
    {
        $this->selectText('Queen');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'), 'Underline icon is still active in the inline toolbar');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong> <u>food</u></p>');

    }//end testRemoveUnderline()


    /**
     * Test that the Underline icons are active when you select a word that is underlined.
     *
     * @return void
     */
    public function testIconsAreActive()
    {
        $this->selectText('food');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'), 'Underline icon is not active in the top toolbar');

    }//end testIconsAreActive()


    /**
     * Test that the VITP underline icon is removed from the toolbar when you click the P tag.
     *
     * @return void
     */
    public function testIconIsRemovedFromInlineToolbar()
    {
        $this->selectText('Lorem');

        // Inline Toolbar icon should be displayed.
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'), 'Underline icon does not appear in the inline toolbar');

        // Click the P tag.
        $this->selectInlineToolbarLineageItem(0);

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'), 'Underline icon still appears in the inline toolbar');

        // Click the Selection tag.
        $this->selectInlineToolbarLineageItem(1);

        // Inline Toolbar icon should be displayed.
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'), 'Underline icon does not appear in the inline toolbar');

    }//end testIconIsRemovedFromInlineToolbar()


}//end class

?>
