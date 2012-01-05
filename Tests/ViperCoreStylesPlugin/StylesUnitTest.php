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
        $this->keyDown('Key.CMD + u');

        $dir = dirname(__FILE__).'/Images/';
        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');

        // Remove strike and sub.
        $this->clickTopToolbarButton($dir.'toolbarIcon_strike_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_sub_active.png');

        $this->assertHTMLMatch('<p><strong><em><u><sup>Lorem</sup></u></em></strong> xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

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
        $this->keyDown('Key.CMD + u');

        $this->assertHTMLMatch('<p><strong>Lor<em>em</em></strong><em> x<u>tn</u></em><u> dol</u>or</p><p>sit amet <strong>consectetur</strong></p>');

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
        $this->keyDown('Key.CMD + u');

        $dir = dirname(__FILE__).'/Images/';
        $this->clickTopToolbarButton($dir.'toolbarIcon_removeFormat.png');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testRemoveFormat()


    /**
     * Test that style can be removed from the selection.
     *
     * @return void
     */
    public function testRemoveUnderlineKeepOthers()
    {
        $this->selectText('Lorem');

        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $this->keyDown('Key.CMD + u');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.CMD + u');

        $this->assertHTMLMatch('<p><strong><em><u>Lo</u>re<u>m</u></em></strong> xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testRemoveUnderlineKeepOthers()


    /**
     * Tests that adding styles spanning multiple paragraphs work.
     *
     * @return void
     */
    public function testMultiParaApplyStyle()
    {
        $this->selectText('Lorem', 'amet');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p><strong>Lorem xtn dolor</strong></p><p><strong>sit amet</strong> <strong>consectetur</strong></p>');

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

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

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

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

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
        $this->keyDown('Key.CMD + u');

        $this->selectInlineToolbarLineageItem(0);

        // Make sure bold icon is not shown in the toolbar.
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));

    }//end testSelectParaAfterStyling()


}//end class

?>
