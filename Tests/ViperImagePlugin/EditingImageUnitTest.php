<?php

require_once 'AbstractViperImagePluginUnitTest.php';

class Viper_Tests_ViperImagePlugin_EditingImageUnitTest extends AbstractViperImagePluginUnitTest
{

    /**
     * Test editing the URL of the image.
     *
     * @return void
     */
    public function testEditingTheURLForAnImage()
    {
        // Using the inline toolbar

        // Change URL for an image that has no alt and title tag
        $this->useTest(1);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clearFieldValue('URL');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/hero-shot.jpg'));
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->clickInlineToolbarButton('image', 'selected');
        $this->assertHTMLMatch('<p>Image without alt or title %1%</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt=""/></p><p>LABS is ORSM</p>');

        // Change URL for an image that has alt and no title tag
        $this->useTest(2);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clearFieldValue('URL');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/hero-shot.jpg'));
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->clickInlineToolbarButton('image', 'selected');
        $this->assertHTMLMatch('<p>Image with alt no title %1%</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="testalt"/></p><p>LABS is ORSM</p>');

        // Change URL for an image that has alt and title tag
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clearFieldValue('URL');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/hero-shot.jpg'));
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->clickInlineToolbarButton('image', 'selected');
        $this->assertHTMLMatch('<p>Image with alt and title %1%</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="testalt" title="testtitle"/></p><p>LABS is ORSM</p>');

        // Using the top toolbar

        // Change URL for an image that has no alt and title tag
        $this->useTest(1);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('URL');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/hero-shot.jpg'));
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->checkPreviewImageSize();
        $this->clickTopToolbarButton('image', 'selected');
        $this->assertHTMLMatch('<p>Image without alt or title %1%</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt=""/></p><p>LABS is ORSM</p>');

        // Change URL for an image that has alt and no title tag
        $this->useTest(2);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('URL');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/hero-shot.jpg'));
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->clickTopToolbarButton('image', 'selected');
        $this->assertHTMLMatch('<p>Image with alt no title %1%</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="testalt"/></p><p>LABS is ORSM</p>');

        // Change URL for an image that has alt and title tag
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('URL');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/hero-shot.jpg'));
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->clickTopToolbarButton('image', 'selected');
        $this->assertHTMLMatch('<p>Image with alt and title %1%</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="testalt" title="testtitle"/></p><p>LABS is ORSM</p>');

    }//end testEditingTheURLForAnImage()


    /**
     * Test adding an alt tag to an image.
     *
     * @return void
     */
    public function testAddingAltTagToImage()
    {
        // Using inline toolbar
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        // Check Apply Changes button is disabled
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->clickField('Alt');
        $this->type('Alt tag');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image without alt or title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag"/></p><p>LABS is ORSM</p>');
        // Edit the Alt tag
        $this->clearFieldValue('Alt');
        $this->type('test alt');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image without alt or title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="test alt"/></p><p>LABS is ORSM</p>');

        // Using top toolbar
        $this->useTest(1);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        // Check Apply Changes button is disabled
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->clickField('Alt');
        $this->type('Alt tag');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image without alt or title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag"/></p><p>LABS is ORSM</p>');
        // Edit the Alt tag
        $this->clearFieldValue('Alt');
        $this->type('test alt');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image without alt or title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="test alt"/></p><p>LABS is ORSM</p>');

    }//end testAddingAltTagToImage()


    /**
     * Test editing an alt tag for an image.
     *
     * @return void
     */
    public function testEditingAltTagForAnImage()
    {
        // Edit image with alt and no title using inline toolbar
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clearFieldValue('Alt');
        $this->type('Alt tag');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt no title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag"/></p><p>LABS is ORSM</p>');

        // Edit image with alt and no title using top toolbar
        $this->useTest(2);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('Alt');
        $this->type('Alt tag');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt no title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag"/></p><p>LABS is ORSM</p>');

        // Edit image with alt and title using inline toolbar
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clearFieldValue('Alt');
        $this->type('Alt tag');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt and title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" title="testtitle"/></p><p>LABS is ORSM</p>');

        // Edit image with alt and title using top toolbar
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('Alt');
        $this->type('Alt tag');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt and title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" title="testtitle"/></p><p>LABS is ORSM</p>');

    }//end testEditingAltTagForAnImage()


    /**
     * Test editing alt tag by using backspace.
     *
     * @return void
     */
    public function testBackspaceForAltField()
    {
        // Using inline toolbar
        $this->useTest(2);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->sikuli->keyDown('Key.TAB');

        // use backspace to delete the content for IE and Firefox
        for ($i = 1; $i <= 7; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->type('Alt tag');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt no title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag"/></p><p>LABS is ORSM</p>');

        // Using top toolbar
        $this->useTest(2);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->sikuli->keyDown('Key.TAB');

        // use backspace to delete the content for IE and Firefox
        for ($i = 1; $i <= 7; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->type('Alt tag');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt no title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag"/></p><p>LABS is ORSM</p>');

    }//end testBackspaceForAltField()


    /**
     * Test adding an title tag to an image.
     *
     * @return void
     */
    public function testAddingTitleTagToImage()
    {
        // Using inline toolbar
        $this->useTest(2);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Title');
        $this->type('Title tag');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt no title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="testalt" title="Title tag"/></p><p>LABS is ORSM</p>');
        // Edit the title tag
        $this->clearFieldValue('Title');
        $this->type('test title');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt no title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="testalt" title="test title"/></p><p>LABS is ORSM</p>');

        // Using top toolbar
        $this->useTest(2);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Title');
        $this->type('Title tag');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt no title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="testalt" title="Title tag"/></p><p>LABS is ORSM</p>');
        // Edit the Title tag
        $this->clearFieldValue('Title');
        $this->type('test title');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt no title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="testalt" title="test title"/></p><p>LABS is ORSM</p>');

    }//end testAddingTitleTagToImage()


    /**
     * Test editing a title tag for an image.
     *
     * @return void
     */
    public function testEditingTitleTagForAnImage()
    {
        // Using inline toolbar
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clearFieldValue('Title');
        $this->type('Title tag');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt and title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="testalt" title="Title tag"/></p><p>LABS is ORSM</p>');

        // Using top toolbar
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('Title');
        $this->type('Title tag');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt and title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="testalt" title="Title tag"/></p><p>LABS is ORSM</p>');

    }//end testEditingTitleTagForAnImage()


    /**
     * Test editing title tag by using backspace.
     *
     * @return void
     */
    public function testBackspaceForTitleField()
    {
        // Using inline toolbar
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');

        // use backspace to delete the content for IE and Firefox
        for ($i = 1; $i <= 9; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->type('Title tag');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt and title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="testalt" title="Title tag"/></p><p>LABS is ORSM</p>');

        // Using top toolbar
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');

        // use backspace to delete the content for IE and Firefox
        for ($i = 1; $i <= 9; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->type('Title tag');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt and title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="testalt" title="Title tag"/></p><p>LABS is ORSM</p>');

    }//end testBackspaceForTitleField()


    /**
     * Test editing an image that only has the title tag.
     *
     * @return void
     */
    public function testEditingImageWithTitleTagOnly()
    {
        // Using inline toolbar
        $this->useTest(4);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        // Check Apply Changes button is disabled
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->clickField('Alt');
        $this->type('Alt tag');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with title no alt %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" title="testtitle"/></p><p>LABS is ORSM</p>');

        // Using top toolbar
        $this->useTest(4);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        // Check Apply Changes button is disabled
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->clickField('Alt');
        $this->type('Alt tag');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with title no alt %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="Alt tag" title="testtitle"/></p><p>LABS is ORSM</p>');

    }//end testEditingImageWithTitleTagOnly()


    /**
     * Test editing Image is decorative field.
     *
     * @return void
     */
    public function testEditingImageIsDecorativeField()
    {
        // Using inline toolbar with image that has alt tag only
        $this->useTest(2);
        $this->clickElement('img', 0);
        sleep(1);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt no title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt=""/></p><p>LABS is ORSM</p>');

        // Using top toolbar with image that has alt tag only
        $this->useTest(2);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt no title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt=""/></p><p>LABS is ORSM</p>');

        // Using inline toolbar with image that has alt and title
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt and title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt=""/></p><p>LABS is ORSM</p>');

        // Using top toolbar with image that has alt and title
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with alt and title %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt=""/></p><p>LABS is ORSM</p>');

        // Using inline toolbar with image that has title only
        $this->useTest(4);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        // Check Apply Changes button is disabled
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->clickField('Image is decorative');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with title no alt %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt=""/></p><p>LABS is ORSM</p>');

        // Using top toolbar with image that has title only
        $this->useTest(4);
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        // Check Apply Changes button is disabled
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->clickField('Image is decorative');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Image with title no alt %1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt=""/></p><p>LABS is ORSM</p>');

    }//end testEditingImageIsDecorativeField()


    /**
     * Test that the Alt field in the pop up is updated when you edit it in the source code.
     *
     * @return void
     */
    public function testAltFieldIsUpdatedWhenYouUpdateSourceCode()
    {
        $this->useTest(1);

        // Edit the source code
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('<img src="'.$this->getTestURL('/ViperImagePlugin/Images/editing.png').'" alt="New alt tag" />');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="New alt tag" /></p>');

        // Check value of alt field in inline toolbar
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->sikuli->keyDown('Key.TAB');
        $altField = $this->sikuli->execJS('document.activeElement.value');
        $this->assertEquals("New alt tag", $altField, 'Alt field should be updated with new value');

        // Check value of alt field in top toolbar
        $this->clickTopToolbarButton('image', 'active');
        $this->sikuli->keyDown('Key.TAB');
        $altField = $this->sikuli->execJS('document.activeElement.value');
        $this->assertEquals("New alt tag", $altField, 'Alt field should be updated with new value');

        // Edit the source code
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('<img src="'.$this->getTestURL('/ViperImagePlugin/Images/editing.png').'" alt="" />');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><img src="%url%/ViperImagePlugin/Images/editing.png" alt="" /></p>');

        // Check value of alt field in inline toolbar
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.TAB');
        $altField = $this->sikuli->execJS('document.activeElement.value');
        $this->assertEquals("", $altField, 'Alt field should be updated with new value');

        // Check value of alt field in top toolbar
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.TAB');
        $altField = $this->sikuli->execJS('document.activeElement.value');
        $this->assertEquals("", $altField, 'Alt field should be updated with new value');

    }//end testAltFieldIsUpdatedWhenYouUpdateSourceCode()

}//end class

?>