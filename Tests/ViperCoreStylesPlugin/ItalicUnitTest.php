<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_ItalicUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testStartOfParaItalic()
    {
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><em>Lorem</em> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testStartOfParaItalic()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaItalic()
    {
        $this->selectText('XuT');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <em>XuT</em> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testMidOfParaItalic()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaItalic()
    {
        $this->selectText('dolor');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT <em>dolor</em></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->click($this->find('XuT'));

        $this->selectText('dolor');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the top toolbar is not active');

    }//end testEndOfParaItalic()


    /**
     * Test that italics is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemovingItalicsFromPartOfTheFormattedContent()
    {
        $this->selectText('XuT', 'dolor');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <em>XuT dolor</em></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('dolor');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'), 'Italic icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'), 'Italic icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>Lorem <em>XuT </em>dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('XuT');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the top toolbar is not active');

    }//end testRemovingItalicsFromPartOfTheFormattedContent()


    /**
     * Test that the shortcut command works for Italics.
     *
     * @return void
     */
    public function testShortcutCommandForItalics()
    {
        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><em>Lorem</em> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'), 'Italic icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'), 'Italic icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testShortcutCommandForItalics()


    /**
     * Test that a paragraph can be made italics using the top toolbar and that the VITP italic icon will appear when that happen. Then remove the italics formatting and check that the VITP italic icon is removed.
     *
     * @return void
     */
    public function testAddingAndRemovingFormattingToAParagraph()
    {
        $start = $this->find('Lorem');
        $end   = $this->find('dolor');
        $this->dragDrop($this->getTopLeft($start), $this->getTopRight($end));

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'), 'Italic icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Active italic icon appears in the inline toolbar');

        // Click the Top Toolbar icon to make whole paragraph italics.
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');

        $this->assertHTMLMatch('<p><em>Lorem XuT dolor</em></p><p>sit <em>amet</em> <strong>WoW</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon is not active in the top toolbar');

        // Inline Toolbar icon is now displayed
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Active italic icon does not appear in the inline toolbar');

        //Remove bold formating
        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'), 'Italic icon is still active in the top toolbar');

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'), 'Italic icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Active italic icon appears in the inline toolbar');

    }//end testAddingAndRemovingFormattingToAParagraph()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentAWordStyling()
    {
        $this->selectText('XuT');
        $this->keyDown('Key.CMD + i');

        $this->selectText('Lorem', 'XuT');
        $this->keyDown('Key.CMD + i');

        $this->selectText('XuT', 'dolor');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p><em>Lorem XuT dolor</em></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectText('XuT');
        $this->keyDown('Key.CMD + i');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->selectText('dolor');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p><em>Lorem</em> <em>XuT</em> <em>dolor</em></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that style can be removed.
     *
     * @return void
     */
    public function testRemoveFormating()
    {
        $this->selectText('amet');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'), 'Italic icon is still active in the inline toolbar');

    }//end testRemoveFormating()


    /**
     * Test that the Italic icons are active when you select a word that is italics.
     *
     * @return void
     */
    public function testIconsAreActive()
    {
        $this->selectText('amet');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Active italic icon does not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Italic icon is not active in the top toolbar');

    }//end testIconsAreActive()


    /**
     * Test that the VITP italc icon is removed from the toolbar when you click the P tag.
     *
     * @return void
     */
    public function testIconIsRemovedFromInlineToolbar()
    {
        $this->selectText('Lorem');

        // Inline Toolbar icon should be displayed.
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'), 'Italic icon does not appear in the inline toolbar');

        // Click the P tag.
        $this->selectInlineToolbarLineageItem(0);

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'), 'Italic icon still appears in the inline toolbar');

        // Click the Selection tag.
        $this->selectInlineToolbarLineageItem(1);

        // Inline Toolbar icon should be displayed.
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'), 'Italic icon is not displayed in the inline toolbar');

    }//end testIconIsRemovedFromInlineToolbar()


    /**
     * Test applying a italics to two words where one word is bold.
     *
     * @return void
     */
    public function testAddingItalicsToTwoWordsWhereOneIsBold()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Lorem <strong>XuT</strong> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('XuT', 'dolor');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p>Lorem <em><strong>XuT</strong> dolor</em></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testAddingItalicsToTwoWordsWhereOneIsBold()


}//end class

?>
