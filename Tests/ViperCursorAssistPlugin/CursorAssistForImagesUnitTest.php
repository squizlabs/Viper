<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCursorAssistPlugin_CursorAssistForImagesUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that the cursor assit line appears above an image and you can click it.
     *
     * @return void
     */
    public function testCursorAssistAboveImage()
    {
        $this->useTest(1);

        $this->clickKeyword(1);

        $this->moveMouseToElement('img', 'top');

        // Check to see if the cursor assit line appears above the list
        $this->assertTrue($this->isCursorAssistLineVisible('img', 'top'));

        // Click the cursor assit line and add new content above list
        $this->clickCursorAssistLine();
        $this->type('New content above the image');
        $this->assertHTMLMatch('<p>New content above the image</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt=""/></p><p>%1%</p>');

    }//end testCursorAssistAboveImage()


    /**
     * Test that the cursor assit line appears below an image and that you can click it.
     *
     * @return void
     */
    public function testCursorAssistBelowImage()
    {
        $this->useTest(2);

        $this->clickKeyword(1);

        $this->moveMouseToElement('img', 'bottom', 0, -25);

        // Check to see if the cursor assit line appears above the list
        $this->assertTrue($this->isCursorAssistLineVisible('img', 'bottom'));

        // Click the cursor assit line and add new content above list
        $this->clickCursorAssistLine();
        $this->type('New content below the image');
        $this->assertHTMLMatch('<p>%1%</p><p><img src="%url%/ViperImagePlugin/Images/editing.png" alt=""/></p><p>New content below the image</p>');

    }//end testCursorAssistBelowImage()

}//end class

?>
