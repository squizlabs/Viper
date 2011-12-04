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


}//end class

?>
