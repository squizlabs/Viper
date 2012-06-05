<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperImagePlugin_ImageUnitTest extends AbstractViperUnitTest
{


     /**
     * Resize specified image to given width.
     *
     * Returns the rectangle of the image after resize.
     *
     * @param integer $imageIndex The image index on the page.
     * @param integer $width      The new width of the image.
     *
     * @return array
     */
    public function resizeImage($imageIndex, $size)
    {
        $selector = 'img';

        $imageRect   = $this->getBoundingRectangle($selector, $imageIndex);
        $rightHandle = $this->findImage('ImageHandle-se', '.Viper-image-handle-se');

        $width  = ($imageRect['x2'] - $imageRect['x1']);
        $height = ($imageRect['y2'] - $imageRect['y1']);
        $ratio  = ($width / $height);
        $newX   = $this->getX($rightHandle);
        $newY   = ($this->getY($rightHandle) - ceil(($width - $size) / $ratio));

        $loc = $this->createLocation($newX, $newY);

        $this->dragDrop($rightHandle, $loc);

        $imageRect = $this->getBoundingRectangle($selector, $imageIndex);
        return $imageRect;

    }//end resizeImage()


    /**
     * Test that the image icon is available in different circumstances.
     *
     * @return void
     */
    public function testImageIconIsAvailable()
    {
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be enabled.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be enabled.');

        $this->click($this->findKeyword(1));
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be enabled.');

        $this->selectKeyword(2);
        $this->type('Key.RIGHT');
        $this->type('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be enabled.');

    }//end testImageIconIsAvailable()


    /**
     * Test when you don't insert text into the alt field the alt attribute still appears in the source code.
     *
     * @return void
     */
    public function testInsertingWithoutAltAndTitle()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->clickField('Image is decorative');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->selectKeyword(3);

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->clickField('Image is decorative');
        sleep(1);
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p>');

    }//end testInsertingWithAltAndTitle()


    /**
     * Test inserting an image with the alt tag.
     *
     * @return void
     */
    public function testInsertingWithAltTag()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->selectKeyword(3);

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Another Alt tag');
        sleep(1);
        $updateChanges = $this->find('Update Changes', NULL, TRUE);
        $this->click($updateChanges);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Another Alt tag" /></p>');

    }//end testInsertingWithAltTag()


    /**
     * Test switching presentational.
     *
     * @return void
     */
    public function testSwitchingPresentational()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->clickField('Image is decorative');
        sleep(1);
        $this->clickField('Image is decorative');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

    }//end testSwitchingPresentational()


   /**
     * Test inserting an image with the alt and title and then switching to presentational.
     *
     * @return void
     */
    public function testInsertingWithAltAndTitleTagThenSwitchingToPresentational()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->click($this->findKeyword(3));

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

    }//end testInsertingWithAltAndTitleTagThenSwitchingToPresentational()


    /**
     * Test inserting an image with the alt and title.
     *
     * @return void
     */
    public function testInsertingWithAltAndTitleTag()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->selectKeyword(3);

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Another Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Another Title tag');
        sleep(1);
        $updateChanges = $this->find('Update Changes', NULL, TRUE);
        $this->click($updateChanges);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Another Alt tag" title="Another Title tag" /></p>');

    }//end testInsertingWithAltAndTitleTag()


    /**
     * Test inserting an image at the start of a paragraph.
     *
     * @return void
     */
    public function testInsertingAnImageAtStartOfParagraph()
    {
        $this->selectKeyword(4);
        $this->type('Key.LEFT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p>sit amet <strong>%5%</strong></p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />%4% %6% is %3%</p>');

    }//end testInsertingAnImageAtStartOfParagraph()


    /**
     * Test inserting an image at the end of a paragraph.
     *
     * @return void
     */
    public function testInsertingAnImageAtEndOfParagraph()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(3);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        sleep(1);
        $updateChanges = $this->find('Update Changes', NULL, TRUE);
        $this->click($updateChanges);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p>');

    }//end testInsertingAnImageAtEndOfParagraph()


    /**
     * Test inserting an image in the middle of a paragraph.
     *
     * @return void
     */
    public function testInsertingAnImageInMiddleOfParagraph()
    {
        $this->selectKeyword(1);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> %2%</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(6);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        sleep(1);
        $updateChanges = $this->find('Update Changes', NULL, TRUE);
        $this->click($updateChanges);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> %2%</p><p>sit amet <strong>%5%</strong></p><p>%4% %6%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> is %3%</p>');

    }//end testInsertingAnImageInMiddleOfParagraph()


    /**
     * Test trying to insert an image with the incorrect URL.
     *
     * @return void
     */
    public function testInsertingImageWithIncorrectURL()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/homepage-images/hero-shot.jpg');
        $this->clickField('Image is decorative');
        $this->keyDown('Key.ENTER');

        $this->findImage('ViperImagePlugin-loadError', '.Viper-textbox-error');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/homepage-images/hero-shot.jpg" alt="" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

    }//end testInsertingImageWithIncorrectURL()


    /**
     * Test replacing content with an image.
     *
     * @return void
     */
    public function testReplacingContentWithAnImage()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->click($this->findKeyword(5));
        $this->selectKeyword(6);
        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        sleep(1);
        $updateChanges = $this->find('Update Changes', NULL, TRUE);
        $this->click($updateChanges);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% <img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> is %3%</p>');

    }//end testReplacingContentWithAnImage()


    /**
     * Test inserting an image in a new paragraph.
     *
     * @return void
     */
    public function testInsertingImageInNewParagraph()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

    }//end testInsertingImageInNewParagraph()


    /**
     * Test deleting an image.
     *
     * @return void
     */
    public function testDeletingAnImage()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p>&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be active.');

    }//end testDeletingAnImage()


    /**
     * Test inserting an image and then changing the URL.
     *
     * @return void
     */
    public function testEditingTheURLForAnImage()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->clickField('Image is decorative');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/editing.png');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->click($this->findKeyword(7));

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/editing.png" alt="" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

    }//end testEditingTheURLForAnImage()


    /**
     * Test editing the alt tag for an image.
     *
     * @return void
     */
    public function testEditingTheAltTagForAnImage()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');

        // Check that image is not inserted without alt
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickField('Alt');
        $this->clickField('Image is decorative');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image');
        $this->clickField('Image is decorative');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->click($this->findKeyword(3));

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->keyDown('Key.TAB');
        $this->type('Abcd');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->click($this->findKeyword(3));

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Abcd" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

    }//end testEditingTheAltTagForAnImage()


    /**
     * Test editing the title tag for an image.
     *
     * @return void
     */
    public function testEditingTheTitleTagForAnImage()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->click($this->findKeyword(3));
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->type('Abcd');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->click($this->findKeyword(3));
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Abcd" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

    }//end testEditingTheTitleTagForAnImage()


    /**
     * Test inserting an image and then changing it to presentational.
     *
     * @return void
     */
    public function testInsertingImageThenMakingItPresentational()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->click($this->findKeyword(3));
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" />&nbsp;</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

    }//end testInsertingImageThenMakingItPresentational()


    /**
     * Test inserting an image then clicking undo.
     *
     * @return void
     */
    public function testInsertingAnImageThenClickingUndo()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickTopToolbarButton('historyUndo');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

    }//end testInsertingAnImageThenClickingUndo()


    /**
     * Test inserting an image, deleting it and then clicking undo.
     *
     * @return void
     */
    public function testInsertingAnImageDeletingThenClickingUndo()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');


        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

    }//end testInsertingAnImageDeletingThenClickingUndo()


    /**
     * Test inserting an image, deleting it and then clicking undo.
     *
     * @return void
     */
    public function testInsertingTwoImagesDeletingTheFirstOneThenClickingUndo()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(3);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p>');

        $this->clickElement('img', 1);
        $this->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%</p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p>');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p>');

    }//end testInsertingAnImageDeletingThenClickingUndo()


    /**
     * Test loading a new page with an image and starting a new paragraph after it.
     *
     * @return void
     */
    public function testStartingNewParagraphAfterImage()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('New paragraph');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>New paragraph</p><p>%6% is %3%</p>');

    }//end testStartingNewParagraphAfterImage()


    /**
     * Test format icon is disabled when you select an image.
     *
     * @return void
     */
    public function testFormatIconIsDisabled()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->clickField('Image is decorative');
        $this->keyDown('Key.ENTER');

        $this->clickElement('img', 1);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be active.');

    }//end testFormatIconIsDisabled()


    /**
     * Test image resize handles exist.
     *
     * @return void
     */
    public function testImageResizeHandles()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');
        $this->clickElement('img', 1);

        $this->assertTrue($this->exists($this->findImage('ImageHandle-sw', '.Viper-image-handle-sw')));
        $this->assertTrue($this->exists($this->findImage('ImageHandle-se', '.Viper-image-handle-se')));

    }//end testImageResizeHandles()


    /**
     * Test resizing an image.
     *
     * @return void
     */
    public function testResizingAnImage()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->clickField('Image is decorative');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->resizeImage(1, 300);

         $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" width="286px" height="130px" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

    }//end testResizingAnImage()


    /**
     * Test resizing an image and then editing it.
     *
     * @return void
     */
    public function testResizingAnImageAndEditingIt()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->resizeImage(1, 300);

         $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" width="286px" height="130px" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'selected');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" width="286px" height="130px" title="Title tag" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

    }//end testResizingAnImageAndEditingIt()


    /**
     * Test resizing an image and then clicking undo.
     *
     * @return void
     */
    public function testResizingAnImageAndClickingUndo()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->clickField('Image is decorative');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->resizeImage(1, 300);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" width="286px" height="130px" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

    }//end testResizingAnImage()


    /**
     * Test that the image icon appears in the inline toolbar after you insert an image.
     *
     * @return void
     */
    public function testImageIconInInlineToolbar()
    {
        // First insert the image
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->clickField('Image is decorative');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1% %2%<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p><p>sit amet <strong>%5%</strong></p><p>%4% %6% is %3%</p>');

        $this->clickElement('img', 1);
        $this->assertTrue($this->inlineToolbarButtonExists('image', 'active'), 'Image icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('move'), 'Move icon should appear in the inline toolbar.');

    }//end testImageIconInInlineToolbar()


    /**
     * Test editing an image using the inline toolbar.
     *
     * @return void
     */
    public function testEditingTheImageUsingInlineToolbar()
    {
        $this->clickElement('img', 1);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->clickField('Alt');
        $this->type('Alt text');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1%</p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt text" width="369" height="167"/><p>%6% is %3%</p>');

    }//end testEditingTheImageUsingInlineToolbar()


    /**
     * Test moving an image.
     *
     * @return void
     */
    public function testMovingAnImage()
    {
        $this->clickElement('img', 1);
        $this->clickInlineToolbarButton('move');
        $this->click($this->findKeyword(1));

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% X<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" width="369" height="167" />uT</p><p>%6% is %3%</p>');

        $this->assertTrue($this->inlineToolbarButtonExists('image', 'active'), 'Image icon should be active.');

        // Undo the move
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%7% %1%</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" width="369" height="167" /></p><p>%6% is %3%</p>');

    }//end testMovingAnImage()


}//end class

?>
