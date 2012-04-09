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
        $dir      = dirname(__FILE__).'/Images/';
        $selector = 'img';

        $imageRect   = $this->getBoundingRectangle($selector, $imageIndex);
        $rightHandle = $this->find($dir.'resize_bottom_right.png');

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
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_image.png'), 'Image icon should be active.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_image.png'), 'Image icon should be active.');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_image.png'), 'Image icon should be active.');

        $this->selectText('dolor');
        $this->type('Key.RIGHT');
        $this->type('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_image.png'), 'Image icon should be active.');

    }//end testImageIconIsAvailable()


    /**
     * Test when you don't insert text into the alt field the alt attribute still appears in the source code.
     *
     * @return void
     */
    public function testInsertingWithoutAltAndTitle()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->clickTopToolbarButton($dir.'toobarIcon_image_presentational.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->selectText('ORSM');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->clickTopToolbarButton($dir.'toobarIcon_image_presentational.png');
        sleep(1);
        $updateChanges = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChanges);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p>');

    }//end testInsertingWithAltAndTitle()


    /**
     * Test inserting an image with the alt tag.
     *
     * @return void
     */
    public function testInsertingWithAltTag()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->selectText('ORSM');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Another Alt tag');
        sleep(1);
        $updateChanges = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChanges);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Another Alt tag" /></p>');

    }//end testInsertingWithAltTag()


    /**
     * Test switching presentational.
     *
     * @return void
     */
    public function testSwitchingPresentational()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->clickTopToolbarButton($dir.'toobarIcon_image_presentational.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image_presentational_active.png');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testSwitchingPresentational()


   /**
     * Test inserting an image with the alt and title and then switching to presentational.
     *
     * @return void
     */
    public function testInsertingWithAltAndTitleTagThenSwitchingToPresentational()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image_highlighted.png');
        $this->clickTopToolbarButton($dir.'toobarIcon_image_presentational.png');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');
        $this->click($this->find('ORSM'));

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testInsertingWithAltAndTitleTagThenSwitchingToPresentational()


    /**
     * Test inserting an image with the alt and title.
     *
     * @return void
     */
    public function testInsertingWithAltAndTitleTag()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->selectText('ORSM');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Another Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Another Title tag');
        sleep(1);
        $updateChanges = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChanges);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Another Alt tag" title="Another Title tag" /></p>');

    }//end testInsertingWithAltAndTitleTag()


    /**
     * Test inserting an image at the start of a paragraph.
     *
     * @return void
     */
    public function testInsertingAnImageAtStartOfParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Squiz');
        $this->type('Key.LEFT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />Squiz LABS is ORSM</p>');

    }//end testInsertingAnImageAtStartOfParagraph()


    /**
     * Test inserting an image at the end of a paragraph.
     *
     * @return void
     */
    public function testInsertingAnImageAtEndOfParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->click($this->find('dolor'));
        $this->selectText('ORSM');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        sleep(1);
        $updateChanges = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChanges);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p>');

    }//end testInsertingAnImageAtEndOfParagraph()


    /**
     * Test inserting an image in the middle of a paragraph.
     *
     * @return void
     */
    public function testInsertingAnImageInMiddleOfParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->click($this->find('dolor'));
        $this->selectText('LABS');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        sleep(1);
        $updateChanges = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChanges);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> is ORSM</p>');

    }//end testInsertingAnImageInMiddleOfParagraph()


    /**
     * Test replacing content with an image.
     *
     * @return void
     */
    public function testReplacingContentWithAnImage()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->click($this->find('WoW'));
        $this->selectText('LABS');
        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        sleep(1);
        $updateChanges = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChanges);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz <img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> is ORSM</p>');

    }//end testReplacingContentWithAnImage()


    /**
     * Test inserting an image in a new paragraph.
     *
     * @return void
     */
    public function testInsertingImageInNewParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testInsertingImageInNewParagraph()


    /**
     * Test deleting an image.
     *
     * @return void
     */
    public function testDeletingAnImage()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->clickElement('img', 1);
        $this->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p>&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_image.png'), 'Image icon should be active.');

    }//end testDeletingAnImage()


    /**
     * Test inserting an image and then changing the URL.
     *
     * @return void
     */
    public function testEditingTheURLForAnImage()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->clickTopToolbarButton($dir.'toobarIcon_image_presentational.png');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/editing.png');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');
        $this->click($this->find('LOREM'));

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/editing.png" alt="" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testEditingTheURLForAnImage()


    /**
     * Test editing the alt tag for an image.
     *
     * @return void
     */
    public function testEditingTheAltTagForAnImage()
    {
        $dir = dirname(__FILE__).'/Images/';

         $this->selectText('dolor');
        $this->type('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');

        // Check that image is not inserted without alt
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $altBox = $this->find($dir.'input_alt.png', $this->getTopToolbar());
        $this->click($altBox);
        $this->clickTopToolbarButton($dir.'toobarIcon_image_presentational.png');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_image_presentational_active.png');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');
        $this->click($this->find('ORSM'));

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image_highlighted.png');
        $this->keyDown('Key.TAB');
        $this->type('Abcd');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');
        $this->click($this->find('ORSM'));

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Abcd" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testEditingTheAltTagForAnImage()


    /**
     * Test editing the title tag for an image.
     *
     * @return void
     */
    public function testEditingTheTitleTagForAnImage()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image_highlighted.png');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');
        $this->click($this->find('ORSM'));
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image_highlighted.png');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->type('Abcd');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');
        $this->click($this->find('ORSM'));
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Abcd" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testEditingTheTitleTagForAnImage()


    /**
     * Test inserting an image and then changing it to presentational.
     *
     * @return void
     */
    public function testInsertingImageThenMakingItPresentational()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image_highlighted.png');
        $this->clickTopToolbarButton($dir.'toobarIcon_image_presentational.png');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');
        $this->click($this->find('ORSM'));
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" />&nbsp;</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testInsertingImageThenMakingItPresentational()


    /**
     * Test inserting an image then clicking undo.
     *
     * @return void
     */
    public function testInsertingAnImageThenClickingUndo()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testInsertingAnImageThenClickingUndo()


    /**
     * Test inserting an image, deleting it and then clicking undo.
     *
     * @return void
     */
    public function testInsertingAnImageDeletingThenClickingUndo()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->clickElement('img', 1);
        $this->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');


        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testInsertingAnImageDeletingThenClickingUndo()


    /**
     * Test inserting an image, deleting it and then clicking undo.
     *
     * @return void
     */
    public function testInsertingTwoImagesDeletingTheFirstOneThenClickingUndo()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_subImage_active.png');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->click($this->find('dolor'));
        $this->selectText('ORSM');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p>');

        $this->clickElement('img', 1);
        $this->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p>');
        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p>');

    }//end testInsertingAnImageDeletingThenClickingUndo()


    public function testImageResizeHandles()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->keyDown('Key.ENTER');
        $this->clickElement('img', 1);

        $this->assertTrue($this->exists($dir.'resize_bottom_left.png'));
        $this->assertTrue($this->exists($dir.'resize_bottom_right.png'));

        $this->resizeImage(1, 300);

    }//end testImageResizeHandles()


}//end class

?>
