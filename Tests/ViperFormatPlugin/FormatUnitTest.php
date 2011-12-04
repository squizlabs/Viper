<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_FormatUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that paragraphs can be aligned.
     *
     * @return void
     */
    public function testAlignment()
    {
        $this->selectText('Lorem');

        $dir = dirname(__FILE__).'/Images/';
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignLeft_active.png'));
        $this->assertHTMLMatch('<p style="text-align: left; ">Lorem xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

        $this->selectText('Lorem');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignCenter_active.png'));
        $this->assertHTMLMatch('<p style="text-align: center; ">Lorem xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

        $this->selectText('Lorem');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignRight_active.png'));
        $this->assertHTMLMatch('<p style="text-align: right; ">Lorem xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

        $this->selectText('Lorem');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignJustify.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignJustify_active.png'));
        $this->assertHTMLMatch('<p style="text-align: justify; ">Lorem xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testAlignment()


    /**
     * Test that only block level elements are aligned.
     *
     * @return void
     */
    public function testAlignmentInNoneBlockTag()
    {
        $this->selectText('consectetur');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.LEFT');

        $dir = dirname(__FILE__).'/Images/';
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignCenter_active.png'));
        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p style="text-align: center; ">sit amet <strong>consectetur</strong></p>');

    }//end testAlignmentInNoneBlockTag()


}//end class

?>
