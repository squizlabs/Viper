<?php

require_once 'AbstractViperImagePluginUnitTest.php';

class Viper_Tests_ViperImagePlugin_MovingImageUnitTest extends AbstractViperImagePluginUnitTest
{

    /**
     * Test moving an image.
     *
     * @return void
     */
    public function testMovingAnImage()
    {
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('move');
        $this->sikuli->mouseMove($this->findKeyword(1));
        $this->sikuli->mouseMoveOffset(15, 0);
        $this->sikuli->click($this->sikuli->getMouseLocation());
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1%<img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/> XuT</p><p>LABS is ORSM</p>');

    }//end testMovingAnImage()

}//end class

?>