<?php

require_once 'AbstractViperImagePluginUnitTest.php';

class Viper_Tests_ViperImagePlugin_UpdateChangesButtonForImageUnitTest extends AbstractViperImagePluginUnitTest
{
    /**
     * Test that the Apply Changes button is inactive for a new selection after you click away from a previous selection.
     *
     * @return void
     */
    public function testApplyChangesButtonWhenClickingAwayFromImagePopUp()
    {
        $this->useTest(1);

        // Start creating the image for the first selection
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/editing.png'));

        // Click away from the image by selecting a new selection
        $this->selectKeyword(2);

        // Make sure the image was not created
        $this->assertHTMLMatch('<h1>Content without an Image</h1><p>%1% the first paragraph</p><p>The second paragraph on the page %2%</p>');
        $this->clickTopToolbarButton('image');

        // Check icons
        $this->assertTrue($this->topToolbarButtonExists('image', 'selected'));
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE));

        $this->type($this->getTestURL('/ViperImagePlugin/Images/editing.png'));
        sleep(2);
        $this->clickField('Image is decorative');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        sleep(1);
        $this->assertHTMLMatch('<h1>Content without an Image</h1><p>%1% the first paragraph</p><p>The second paragraph on the page <img src="%url%/ViperImagePlugin/Images/editing.png" alt="" /></p>');

    }//end testApplyChangesButtonWhenClickingAwayFromImagePopUp()


    /**
     * Test that the Apply Changes button is inactive for a new selection after you close the image pop without saving the changes.
     *
     * @return void
     */
    public function testApplyChangesButtonWhenClosingTheImagePopUp()
    {
        // Using the top toolbar
        $this->useTest(1);

        // Start creating the image for the first selection
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/editing.png'));

        // Close pop up without saving changes and make new select
        $this->clickTopToolbarButton('image', 'selected');
        $this->selectKeyword(2);

        // Make sure the image was not created
        $this->assertHTMLMatch('<h1>Content without an Image</h1><p>%1% the first paragraph</p><p>The second paragraph on the page %2%</p>');
        $this->clickTopToolbarButton('image');

        // Check icons
        $this->assertTrue($this->topToolbarButtonExists('image', 'selected'));
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE));

        $this->type($this->getTestURL('/ViperImagePlugin/Images/editing.png'));
        sleep(2);
        $this->clickField('URL');
        $this->clickField('Image is decorative');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        sleep(1);
        $this->assertHTMLMatch('<h1>Content without an Image</h1><p>%1% the first paragraph</p><p>The second paragraph on the page <img src="%url%/ViperImagePlugin/Images/editing.png" alt="" /></p>');

    }//end testApplyChangesButtonWhenClosingTheImagePopUp()


    /**
     * Test that the Apply Changes button is inactive iafter you cancel changes to an image.
     *
     * @return void
     */
    public function testApplyChangesButtonIsDisabledAfterCancellingChangesToAnImage()
    {
        // Using the inline toolbar
        $this->useTest(2);

        // Select image and make changes without saving
        $this->clickElement('img', 0);
        sleep(2);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Alt');
        $this->type('alt');
        $this->selectKeyword(2);

        // Check to make sure the HTML did not change.
        $this->assertHTMLMatch('<h1>Content with an Image</h1><p>%1% the first paragraph</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="test" width="369" height="167"/></p><p>The second paragraph on the page %2%</p>');

        // Select the image again and make sure the Apply Changes button is inactive
        $this->clickElement('img', 0);
        sleep(1);
        $this->clickInlineToolbarButton('image', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE), 'Update changes button should be disabled');

        // Edit the image and make sure the Apply Changes button still works.
        $this->clickField('Alt');
        $this->type('alt');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Content with an Image</h1><p>%1% the first paragraph</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="testalt" width="369" height="167"/></p><p>The second paragraph on the page %2%</p>');

        // Using the top toolbar
        $this->useTest(2);

        // Select image and make changes without saving
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Alt');
        $this->type('alt');
        $this->selectKeyword(2);

        // Check to make sure the HTML did not change.
        $this->assertHTMLMatch('<h1>Content with an Image</h1><p>%1% the first paragraph</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="test" width="369" height="167"/></p><p>The second paragraph on the page %2%</p>');

        // Select the image again and make sure the Apply Changes button is inactive
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE), 'Update changes button should be disabled');

        // Edit the image and make sure the Apply Changes button still works.
        $this->clickField('Alt');
        $this->type('alt');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Content with an Image</h1><p>%1% the first paragraph</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="testalt" width="369" height="167"/></p><p>The second paragraph on the page %2%</p>');

    }//end testApplyChangesButtonIsDisabledAfterCancellingChangesToAnImage()

}//end class

?>