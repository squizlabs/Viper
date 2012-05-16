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

        $this->clickTopToolbarButton('subscript');
        $this->clickTopToolbarButton('superscript');
        $this->clickTopToolbarButton('strikethrough');

        // Remove strike and sub.
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

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
        $this->clickTopToolbarButton('removeFormat');

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
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active bold icon is still shown in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon is still shown in the inline toolbar');

        // Make sure italic icon is not shown in the toolbar.
        $this->assertFalse($this->inlineToolbarButtonExists('italic', 'active'), 'Active italic icon is still shown in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon is still shown in the inline toolbar');

    }//end testSelectParaAfterStyling()


    /**
     * Test that bold and italics work together.
     *
     * @return void
     */
    public function testBoldAndItalic()
    {
        $this->selectText('Lorem');

        //Add bold and italics
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon is not active in the top toolbar');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon is not active in the top toolbar');

        $this->assertHTMLMatch('<p><strong><em>Lorem</em></strong> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        //Remove italics
        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon is still active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon is still active in the top toolbar');

        //Remove bold
        $this->keyDown('Key.CMD + b');

        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon is still active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon is still active in the top toolbar');

    }//end testBoldAndItalic()


     /**
     * Tests selecting text in a paragraph.
     *
     * @return void
     */
    public function testSelectingTextInAParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem', 'dolor');
        $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon appears in the inline toolbar');
        $this->assertFalse($this->topToolbarButtonExists('italic', 'active'), 'Active Italic icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active Bold icon appears in the inline toolbar');

        $this->selectText('sit', 'WoW');
         $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon appears in the inline toolbar');
        $this->assertFalse($this->topToolbarButtonExists('italic', 'active'), 'Active Italic icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active Bold icon appears in the inline toolbar');

    }//end testSelectingTextInAParagraph()

}//end class

?>
