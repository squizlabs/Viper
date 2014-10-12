<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLinkPlugin_ImageWithLinkUnitTest extends AbstractViperUnitTest
{

     /**
     * Test inserting and removing a link for an image.
     *
     * @return void
     */
    public function testLinkingAnImage()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('link');
        $this->type('www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1% XuT</p><p><a href="www.squizlabs.com" title="Squiz Labs"><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/></a></p><p>LABS is ORSM</p>');

        $this->moveToKeyword(1);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1% XuT</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/></p><p>LABS is ORSM</p>');

        // Using the top toolbar
        $this->useTest(1);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('link');
        $this->type('www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1% XuT</p><p><a href="www.squizlabs.com" title="Squiz Labs"><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/></a></p><p>LABS is ORSM</p>');

        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1% XuT</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/></p><p>LABS is ORSM</p>');

    }//end testLinkingAnImage()


}//end class

?>