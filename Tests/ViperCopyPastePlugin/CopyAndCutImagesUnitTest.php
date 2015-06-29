<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyAdnCutImagesUnitTest extends AbstractViperUnitTest
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
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><p>text %1% <img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /> %2% text</p><p>This is the second paragraph in the content of the page %3%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /></p>');

    }//end testCopyPasteImage()


    /**
     * Test copy and pasting an image with text after.
     *
     * @return void
     */
    public function testCopyPasteImageWithTextAfter()
    {
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><p>text %1% <img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /> %2% text</p><p>This is the second paragraph in the content of the page %3%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /> %2%</p>');

    }//end testCopyPasteImageWithTextAfter()


    /**
     * Test copy and pasting an image with text before.
     *
     * @return void
     */
    public function testCopyPasteImageWithTextBefore()
    {
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><p>text %1% <img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /> %2% text</p><p>This is the second paragraph in the content of the page %3%</p><p>%1% <img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /></p>');

    }//end testCopyPasteImageWithTextBefore()


    /**
     * Test copy and pasting an image with text before and after.
     *
     * @return void
     */
    public function testCopyPasteImageWithTextBeforeAndAfter()
    {
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><p>text %1% <img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /> %2% text</p><p>This is the second paragraph in the content of the page %3%</p><p>%1% <img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" /> %2%</p>');

    }//end testCopyPasteImageWithTextBeforeAndAfter()


}//end class

?>
