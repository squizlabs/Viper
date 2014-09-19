<?php

require_once 'AbstractViperImagePluginUnitTest.php';

class Viper_Tests_ViperImagePlugin_DeleteImageUnitTest extends AbstractViperImagePluginUnitTest
{

    /**
     * Test deleting an image.
     *
     * @return void
     */
    public function testDeletingAnImage()
    {
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1% XuT</p><p></p><p>LABS is ORSM</p>');
        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be active.');

    }//end testDeletingAnImage()

}//end class

?>