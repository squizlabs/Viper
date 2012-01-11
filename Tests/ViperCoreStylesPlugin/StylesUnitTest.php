<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_StylesUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that style can be applied to the selection.
     *
     * @return void
     */
    public function testAllStyles()
    {
        $this->selectText('Lorem');

        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $dir = dirname(__FILE__).'/Images/';
        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');

        // Remove strike and sub.
        $this->clickTopToolbarButton($dir.'toolbarIcon_strike_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_sub_active.png');

        $this->assertHTMLMatch('<p><strong><em><sup>Lorem</sup></em></strong> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        //Remove italics
        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p><strong><sup>Lorem</sup></strong> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        //Remove bold
        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p><sup>Lorem</sup> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testAllStyles()


    /**
     * Test that styling.
     *
     * @return void
     */
    public function testStyleTags()
    {
        $this->selectText('Lorem');

        $this->keyDown('Key.CMD + b');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.CMD + i');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');

        $this->assertHTMLMatch('<p><strong>Lor<em>em</em></strong><em> XuT</em> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testStyleTags()


    /**
     * Test that style can be removed from the selection.
     *
     * @return void
     */
    public function testRemoveFormat()
    {
        $this->selectText('Lorem');

        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p><strong><em>Lorem</em></strong> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('Lorem');
        $dir = dirname(__FILE__).'/Images/';
        $this->clickTopToolbarButton($dir.'toolbarIcon_removeFormat.png');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testRemoveFormat()


    /**
     * Tests that adding styles spanning multiple paragraphs work.
     *
     * @return void
     */
    public function testMultiParaApplyStyle()
    {
        $this->selectText('Lorem', 'amet');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p><strong>Lorem XuT dolor</strong></p><p><strong>sit </strong><em><strong>amet</strong></em> <strong>WoW</strong></p>');

    }//end testMultiParaApplyStyle()


    /**
     * Tests that removing styles spanning multiple paragraphs work.
     *
     * @return void
     */
    public function testMultiParaRemoveStyle()
    {
        $this->selectText('Lorem', 'amet');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testMultiParaRemoveStyle()


    /**
     * Tests that removing multiple styles spanning multiple paragraphs work.
     *
     * @return void
     */
    public function testMultiParaRemoveStyles()
    {
        $this->selectText('Lorem', 'amet');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $this->keyDown('Key.CMD + i');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testMultiParaRemoveStyles()


    /**
     * Tests that applying styles to whole paragraph and selecting the P in lineage shows paragraph tools.
     *
     * @return void
     */
    public function testSelectParaAfterStyling()
    {
        $this->selectText('Lorem', 'dolor');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->selectInlineToolbarLineageItem(0);

        // Make sure bold icon is not shown in the toolbar.
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'), 'Active bold icon is still shown in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'), 'Bold icon is still shown in the inline toolbar');

        // Make sure italic icon is not shown in the toolbar.
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Active italic icon is still shown in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'), 'Italic icon is still shown in the inline toolbar');

    }//end testSelectParaAfterStyling()


    /**
     * Test that bold and italics work together.
     *
     * @return void
     */
    public function testBoldAndItalic()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');

        //Add bold and italics
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_bold_active.png'), 'Bold icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_bold_active.png'), 'Bold icon is not active in the top toolbar');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_italic_active.png'), 'Italic icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_italic_active.png'), 'Italic icon is not active in the top toolbar');

        $this->assertHTMLMatch('<p><strong><em>Lorem</em></strong> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        //Remove italics
        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_italic.png'), 'Italic icon is still active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_italic.png'), 'Italic icon is still active in the top toolbar');

        //Remove bold
        $this->keyDown('Key.CMD + b');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_bold.png'), 'Bold icon is still active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_bold.png'), 'Bold icon is still active in the top toolbar');

    }//end testBoldAndItalic()

}//end class

?>
