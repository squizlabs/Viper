<?php

require_once 'AbstractViperImagePluginUnitTest.php';

class Viper_Tests_ViperImagePlugin_ResizeImageUnitTest extends AbstractViperImagePluginUnitTest
{

    /**
     * Test image resize handles exist.
     *
     * @return void
     */
    public function testImageResizeHandles()
    {
        $this->useTest(1);

        $this->clickElement('img', 0);
        sleep(1);
        $this->findImage('ImageHandle-sw', '.Viper-image-handle-sw', 0, true);
        $this->findImage('ImageHandle-se', '.Viper-image-handle-se', 0, true);

    }//end testImageResizeHandles()


    /**
     * Test resizing an image.
     *
     * @return void
     */
    public function testResizingAnImage()
    {
        $this->useTest(1);

        $this->clickElement('img', 0);
        $this->resizeImage(200);

        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1% XuT</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="200" height="90"/></p><p>LABS is ORSM</p>');

    }//end testResizingAnImage()


    /**
     * Test resizing an image and then editing it.
     *
     * @return void
     */
    public function testResizingAnImageAndEditingIt()
    {
        // Using inline toolbar
        $this->useTest(1);
        $this->clickElement('img', 0);
        $this->resizeImage(100);
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1% XuT</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="100" height="45"/></p><p>LABS is ORSM</p>');
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1% XuT</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="Alt tag" title="Title tag" width="100" height="45"/></p><p>LABS is ORSM</p>');

         // Using top toolbar
        $this->useTest(1);
        $this->clickElement('img', 0);
        $this->resizeImage(100);
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1% XuT</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="100" height="45"/></p><p>LABS is ORSM</p>');
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1% XuT</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="Alt tag" title="Title tag" width="100" height="45"/></p><p>LABS is ORSM</p>');

    }//end testResizingAnImageAndEditingIt()

}//end class

?>