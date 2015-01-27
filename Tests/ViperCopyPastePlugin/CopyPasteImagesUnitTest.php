<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyPasteImagesUnitTest extends AbstractViperUnitTest
{

    /**
     * Test copy and pasting an image.
     *
     * @return void
     */
    public function testCopyPasteImage()
    {
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><p><img src="%url%/ViperImagePlugin/Images/html-codesniffer.png" alt="Alt tag" /></p><p>This is the second paragraph in the content of the page %1%</p><p></p><p><img src="%url%/ViperImagePlugin/Images/html-codesniffer.png" alt="Alt tag" /></p>');

    }//end testCopyPasteImage()

}//end class

?>
