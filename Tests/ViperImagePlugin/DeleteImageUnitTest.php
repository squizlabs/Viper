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
        $this->useTest(1);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<h1>Viper Image Test</h1><p>%1% XuT</p><p>LABS is ORSM</p>');
        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be active.');

    }//end testDeletingAnImage()


    /**
     * Test deleting an image from various places in a paragraph.
     *
     * @return void
     */
    public function testDeletingAnImageWithinAParagraph()
    {
        // Test deleting at the beginning of a paragraph
        // Test mouse selection and backspace key
        $this->useTest(4);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% Test content.</p>');

        // Test mouse selection and delete key
        $this->useTest(4);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1% Test content.</p>');

        // Test arrow keys and backspace key
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% Test content.</p>');

        // Test arrow keys and delete key
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1% Test content.</p>');

        // Test deleting in the middle of a paragraph
        // Test mouse selection and backspace key
        $this->useTest(5);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2% Test content.</p>');

        // Test mouse selection and delete key
        $this->useTest(5);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2% Test content.</p>');

        // Test arrow keys and backspace key
        $this->useTest(5);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2% Test content.</p>');

        // Test arrow keys and delete key
        $this->useTest(5);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2% Test content.</p>');

        // Test deleting at the end of a paragraph
        // Test mouse selection and backspace key
        $this->useTest(6);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Test content. %1%</p>');

        // Test mouse selection and delete key
        $this->useTest(6);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Test content. %1%</p>');

        // Test arrow keys and backspace key
        $this->useTest(6);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Test content. %1%</p>');

        // Test arrow keys and delete key
        $this->useTest(6);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Test content. %1%</p>');

    }//end testDeletingAnImageWithinAParagraph()


    /**
     * Test deleting an image from various places in a paragraph.
     *
     * @return void
     */
    public function testDeletingMultipleImagesWithinAParagraph()
    {
        // Test deleting at the beginning of a paragraph simultaneously
        // Test arrow keys and backspace key
        $this->useTest(7);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% Test content.</p>');

        // Test arrow keys and delete key 
        $this->useTest(7);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1% Test content.</p>');

        // Test deleting in the middle of a paragraph simultaneously
        // Test arrow keys and backspace key
        $this->useTest(8);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2% Test content.</p>');

        // Test arrow keys and delete key 
        $this->useTest(8);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2% Test content.</p>');

        // Test deleting at the end of a paragraph simultaneously
        // Test arrow keys and backspace key
        $this->useTest(9);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Test content. %1%</p>');

        // Test arrow keys and delete key 
        $this->useTest(9);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Test content. %1%</p>');

    }//end testDeletingMultipleImagesWithinAParagraph()


    /**
     * Test deleting an image from various places in a paragraph.
     *
     * @return void
     */
    public function testDeletingAnImageWithContent()
    {
        // Test deleting image at the beginning of a paragraph
        // Test using backspace key
        $this->useTest(10);
        $this->moveToKeyword(1, 'right');
        for ($i = 0; $i < 6; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Test content.</p>');

        // Test using delete key
        $this->useTest(10);
        $this->moveToKeyword(1, 'right');
        for ($i = 0; $i < 6; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Test content.</p>');

        // Test deleting image in the middle of a paragraph
        // Test using backspace key
        $this->useTest(11);
        $this->moveToKeyword(1, 'right');
        for ($i = 0; $i < 6; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Test content more test content.</p>');

        // Test using delete key
        $this->useTest(11);
        $this->moveToKeyword(1, 'right');
        for ($i = 0; $i < 6; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Test content more test content.</p>');

        // Test deleting image at the end of a paragraph
        // Test using backspace key
        $this->useTest(12);
        $this->moveToKeyword(1, 'left');
        for ($i = 0; $i < 6; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Test content</p>');

        // Test using delete key
        $this->useTest(12);
        $this->moveToKeyword(1, 'left');
        for ($i = 0; $i < 6; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Test content</p>');

    }//end testDeletingAnImageWithContent()


    /**
     * Test deleting an image from various places in a paragraph.
     *
     * @return void
     */
    public function testDeletingALinkedImageWithinAParagraph()
    {
        // Test deleting at the beginning of a paragraph
        // Test mouse selection and backspace key
        $this->useTest(13);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% Test content.</p>');

        // Test mouse selection and delete key
        $this->useTest(13);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1% Test content.</p>');

        // Test arrow keys and backspace key
        $this->useTest(13);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% Test content.</p>');

        // Test arrow keys and delete key
        $this->useTest(13);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1% Test content.</p>');

        // Test deleting in the middle of a paragraph
        // Test mouse selection and backspace key
        $this->useTest(14);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2% Test content.</p>');

        // Test mouse selection and delete key
        $this->useTest(14);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2% Test content.</p>');

        // Test arrow keys and backspace key
        $this->useTest(14);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2% Test content.</p>');

        // Test arrow keys and delete key
        $this->useTest(14);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2% Test content.</p>');

        // Test deleting at the end of a paragraph
        // Test mouse selection and backspace key
        $this->useTest(15);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Test content. %1%</p>');

        // Test mouse selection and delete key
        $this->useTest(15);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Test content. %1%</p>');

        // Test arrow keys and backspace key
        $this->useTest(15);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Test content. %1%</p>');

        // Test arrow keys and delete key
        $this->useTest(15);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Test content. %1%</p>');

    }//end testDeletingALinkedImageWithinAParagraph()


}//end class

?>