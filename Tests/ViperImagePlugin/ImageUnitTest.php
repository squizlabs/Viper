<?php

require_once 'AbstractViperImagePluginUnitTest.php';

class Viper_Tests_ViperImagePlugin_ImageUnitTest extends AbstractViperImagePluginUnitTest
{


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

        $this->sikuli->click($this->findKeyword(1));
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be enabled.');

        $this->moveToKeyword(2, 'right');
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
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->selectKeyword(3);

        sleep(1);
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->clickField('Image is decorative');
        sleep(1);
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p><p>sit amet<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p>');

    }//end testInsertingWithAltAndTitle()


    /**
     * Test inserting an image with the alt tag.
     *
     * @return void
     */
    public function testInsertingWithAltTag()
    {
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->selectKeyword(3);

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Another Alt tag');
        sleep(1);
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p><p>sit amet<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Another Alt tag" /></p>');

    }//end testInsertingWithAltTag()


    /**
     * Test switching presentational.
     *
     * @return void
     */
    public function testSwitchingPresentational()
    {
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->clickField('Image is decorative');
        sleep(1);
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p><p>sit amet <strong>%3%</strong></p>');

    }//end testSwitchingPresentational()


   /**
     * Test inserting an image with the alt and title and then switching to presentational.
     *
     * @return void
     */
    public function testInsertingWithAltAndTitleTagThenSwitchingToPresentational()
    {
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->sikuli->click($this->findKeyword(3));

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p><p>sit amet <strong>%3%</strong></p>');

    }//end testInsertingWithAltAndTitleTagThenSwitchingToPresentational()


    /**
     * Test inserting an image with the alt and title.
     *
     * @return void
     */
    public function testInsertingWithAltAndTitleTag()
    {
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->selectKeyword(3);

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Another Alt tag');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Another Title tag');
        sleep(1);
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Another Alt tag" title="Another Title tag" /></p>');

    }//end testInsertingWithAltAndTitleTag()


    /**
     * Test inserting an image at the start of a paragraph.
     *
     * @return void
     */
    public function testInsertingAnImageAtStartOfParagraph()
    {
        $this->selectKeyword(1);
        $this->type('Key.LEFT');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" />%1% %2%</p><p>sit amet <strong>%3%</strong></p>');

    }//end testInsertingAnImageAtStartOfParagraph()


    /**
     * Test inserting an image at the end of a paragraph.
     *
     * @return void
     */
    public function testInsertingAnImageAtEndOfParagraph()
    {
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->moveToKeyword(3, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        sleep(1);
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p><p>sit amet <strong>%3%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></strong></p>');

    }//end testInsertingAnImageAtEndOfParagraph()


    /**
     * Test inserting an image in the middle of a paragraph.
     *
     * @return void
     */
    public function testInsertingAnImageInMiddleOfParagraph()
    {
        $this->moveToKeyword(1, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /> %2%</p><p>sit amet <strong>%3%</strong></p>');

        $this->sikuli->click($this->findKeyword(2));
        $this->selectKeyword(3);
        $this->type('Key.LEFT');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        sleep(1);
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /> %2%</p><p>sit amet <img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /><strong>%3%</strong></p>');

    }//end testInsertingAnImageInMiddleOfParagraph()


    /**
     * Test trying to insert an image with the incorrect URL.
     *
     * @return void
     */
    public function testInsertingImageWithIncorrectURL()
    {
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type('http://www.squizlabs.com/html-codesniffer.png');
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');

        sleep(2);
        $this->findImage('ViperImagePlugin-loadError', '.Viper-textbox-error');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="http://www.squizlabs.com/html-codesniffer.png" alt="" /></p><p>sit amet <strong>%3%</strong></p>');

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
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->sikuli->click($this->findKeyword(3));
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        sleep(1);
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p><p>sit amet<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p>');

    }//end testReplacingContentWithAnImage()


    /**
     * Test inserting an image in a new paragraph.
     *
     * @return void
     */
    public function testInsertingImageInNewParagraph()
    {
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p><p>sit amet <strong>%3%</strong></p>');

    }//end testInsertingImageInNewParagraph()


    /**
     * Test deleting an image.
     *
     * @return void
     */
    public function testDeletingAnImage()
    {
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p></p><p>sit amet <strong>%3%</strong></p>');

        $this->assertTrue($this->topToolbarButtonExists('image'), 'Image icon should be active.');

    }//end testDeletingAnImage()


    /**
     * Test inserting an image and then changing the URL.
     *
     * @return void
     */
    public function testEditingTheURLForAnImage()
    {
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('URL');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p><p>sit amet <strong>%3%</strong></p>');

    }//end testEditingTheURLForAnImage()


    /**
     * Test editing the alt tag for an image.
     *
     * @return void
     */
    public function testEditingTheAltTagForAnImage()
    {
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));

        // Check that image is not inserted without alt
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p>sit amet <strong>%3%</strong></p>');

        $this->clickField('Alt');
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->sikuli->click($this->findKeyword(3));

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Abcd');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->sikuli->click($this->findKeyword(3));

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Abcd" /></p><p>sit amet <strong>%3%</strong></p>');

    }//end testEditingTheAltTagForAnImage()


    /**
     * Test editing the title tag for an image.
     *
     * @return void
     */
    public function testEditingTheTitleTagForAnImage()
    {
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->sikuli->click($this->findKeyword(3));
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Abcd');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->sikuli->click($this->findKeyword(3));
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Abcd" /></p><p>sit amet <strong>%3%</strong></p>');

    }//end testEditingTheTitleTagForAnImage()


    /**
     * Test inserting an image and then changing it to presentational.
     *
     * @return void
     */
    public function testInsertingImageThenMakingItPresentational()
    {
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->sikuli->click($this->findKeyword(3));
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p><p>sit amet <strong>%3%</strong></p>');

    }//end testInsertingImageThenMakingItPresentational()


    /**
     * Test inserting an image then clicking undo.
     *
     * @return void
     */
    public function testInsertingAnImageThenClickingUndo()
    {
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p>sit amet <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%3%</strong></p>');

    }//end testInsertingAnImageThenClickingUndo()


    /**
     * Test inserting an image, deleting it and then clicking undo.
     *
     * @return void
     */
    public function testInsertingAnImageDeletingThenClickingUndo()
    {
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p>sit amet <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%3%</strong></p>');

    }//end testInsertingAnImageDeletingThenClickingUndo()


    /**
     * Test inserting an image, deleting it and then clicking undo.
     *
     * @return void
     */
    public function testInsertingTwoImagesDeletingTheFirstOneThenClickingUndo()
    {
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->moveToKeyword(3, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%3%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></strong></p>');

        $this->clickElement('img', 1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p>sit amet <strong>%3%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%3%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></strong></p>');

    }//end testInsertingAnImageDeletingThenClickingUndo()


    /**
     * Test loading a new page with an image and starting a new paragraph after it.
     *
     * @return void
     */
    public function testStartingNewParagraphAfterImage()
    {
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New paragraph');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM %1%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p><p>New paragraph</p><p>LABS is ORSM</p>');

    }//end testStartingNewParagraphAfterImage()


    /**
     * Test format icon is disabled when you select an image.
     *
     * @return void
     */
    public function testFormatIconIsDisabled()
    {
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');

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
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->click($this->findKeyword(1));
        $this->clickElement('img', 1);

        $this->findImage('ImageHandle-sw', '.Viper-image-handle-sw');
        $this->findImage('ImageHandle-se', '.Viper-image-handle-se');

    }//end testImageResizeHandles()


    /**
     * Test resizing an image.
     *
     * @return void
     */
    public function testResizingAnImage()
    {
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->resizeImage(1, 200);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" width="200" height="186" /></p><p>sit amet <strong>%3%</strong></p>');

    }//end testResizingAnImage()


    /**
     * Test resizing an image and then editing it.
     *
     * @return void
     */
    public function testResizingAnImageAndEditingIt()
    {
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->resizeImage(1, 100);

         $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>XAX XBX<img alt="Alt tag" height="93" src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" width="100" /></p><p>sit amet <strong>XCX</strong></p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('image', 'active');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" width="100" height="93" title="Title tag" /></p><p>sit amet <strong>%3%</strong></p>');

    }//end testResizingAnImageAndEditingIt()


    /**
     * Test resizing an image and then clicking undo.
     *
     * @return void
     */
    public function testResizingAnImageAndClickingUndo()
    {
        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->resizeImage(1, 300);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" width="300" height="280" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" width="300" height="280" /></p><p>sit amet <strong>%3%</strong></p>');

    }//end testResizingAnImage()


    /**
     * Test that the image icon appears in the inline toolbar after you insert an image at the start of a paragraph.
     *
     * @return void
     */
    public function testImageIconInInlineToolbarWhenImageAtStartOfParagraph()
    {
        $this->moveToKeyword(1, 'left');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        sleep(1);
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" />%1% %2%</p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->assertTrue($this->inlineToolbarButtonExists('image', 'active'), 'Image icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('move'), 'Move icon should appear in the inline toolbar.');

    }//end testImageIconInInlineToolbarWhenImageAtStartOfParagraph()


    /**
     * Test that the image icon appears in the inline toolbar after you insert an image in the middle of a paragraph.
     *
     * @return void
     */
    public function testImageIconInInlineToolbarWhenImageInMiddleOfParagraph()
    {
        $this->moveToKeyword(1, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        sleep(1);
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /> %2%</p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->assertTrue($this->inlineToolbarButtonExists('image', 'active'), 'Image icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('move'), 'Move icon should appear in the inline toolbar.');

    }//end testImageIconInInlineToolbarWhenImageInMiddleOfParagraph()


    /**
     * Test that the image icon appears in the inline toolbar after you insert an image at the end of a paragraph.
     *
     * @return void
     */
    public function testImageIconInInlineToolbarWhenImageAtEndOfParagraph()
    {

        $this->moveToKeyword(2, 'right');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        sleep(1);
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->assertTrue($this->inlineToolbarButtonExists('image', 'active'), 'Image icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('move'), 'Move icon should appear in the inline toolbar.');

    }//end testImageIconInInlineToolbarWhenImageAtEndOfParagraph()


    /**
     * Test that the image icon appears in the inline toolbar after you insert an image in a new paragraph.
     *
     * @return void
     */
    public function testImageIconInInlineToolbarWhenImageInNewParagraph()
    {

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        sleep(1);
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 1);
        $this->assertTrue($this->inlineToolbarButtonExists('image', 'active'), 'Image icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('move'), 'Move icon should appear in the inline toolbar.');

    }//end testImageIconInInlineToolbarWhenImageInNewParagraph()


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
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt text');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT</p><p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt text" width="369" height="167" /></p><p>LABS is ORSM</p>');

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
        $this->sikuli->mouseMove($this->findKeyword(1));
        $this->sikuli->mouseMoveOffset(15, 0);
        $this->sikuli->click($this->sikuli->getMouseLocation());

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>Another paragraph %1%<img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167" /></p><p>LOREM</p><p>LABS is ORSM</p>');

        // Undo the move
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>Another paragraph %1%</p><p>LOREM</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/></p><p>LABS is ORSM</p>');

    }//end testMovingAnImage()


    /**
     * Test that inserting image with no base tag specified works.
     *
     * @return void
     */
    public function testInsertingImageWithNoBaseTag()
    {
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<img alt="" src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" />');

        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('%1%<img alt="" src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" /> %2%');

        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<img alt="" src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" />');

    }//end testInsertingImageWithNoBaseTag()


    /**
     * Test inserting an image and then clicking undo and redo.
     *
     * @return void
     */
    public function testUndoAndRedoForInsertingAnImage()
    {
        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Title tag');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p>sit amet <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" title="Title tag" /></p><p>sit amet <strong>%3%</strong></p>');

    }//end testUndoAndRedoForInsertingAnImage()


    /**
     * Test that the Apply Changes button is inactive after you cancel changes.
     *
     * @return void
     */
    public function testUpdateChangesButtonIsDisabledAfterCancellingChanges()
    {
        $this->moveToKeyword(1, 'right');
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        sleep(2);
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->moveToKeyword(3, 'right');

        // Make sure the image wasn't inserted into the content
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p>sit amet <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('image');
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE), 'Update changes button should be disabled');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% %2%</p><p>sit amet <strong>%3%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="Alt tag" /></strong></p>');

    }//end testUpdateChangesButtonIsDisabledAfterCancellingChanges()


    /**
     * Test that the Apply Changes button is inactive after you cancel changes to an image.
     *
     * @return void
     */
    public function testUpdateChangesButtonIsDisabledAfterCancellingChangesToAnImage()
    {
        // Insert the image
        $this->selectKeyword(1);
        $this->type('Key.RIGHT');
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /> %2%</p><p>sit amet <strong>%3%</strong></p>');

        $this->moveToKeyword(3, 'left');
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->moveToKeyword(3, 'left');

        // Make sure the image wasn't changed
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1%<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /> %2%</p><p>sit amet <strong>%3%</strong></p>');

        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE), 'Update changes button should be disabled');
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE), 'Update changes button should be disabled');

    }//end testUpdateChangesButtonIsDisabledAfterCancellingChangesToAnImage()


    /**
     * Test that the Alt field in the pop up is updated when you edit it in the source code.
     *
     * @return void
     */
    public function testAltFieldIsUpdatedWhenYouUpdateSourceCode()
    {
        // Insert the image
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image', 'selected');
        $this->assertHTMLMatch('<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /><p></p>');

        // Edit the source code
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="New alt tag" />');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="New alt tag" /></p>');

        // Check value of alt field
        $this->clickElement('img', 0);
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
        $this->type('<img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" />');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><img src="'.$this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png').'" alt="" /></p>');

        // Check value of alt field
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.TAB');
        $altField = $this->sikuli->execJS('document.activeElement.value');
        $this->assertEquals("", $altField, 'Alt field should be updated with new value');

    }//end testAltFieldIsUpdatedWhenYouUpdateSourceCode()


}//end class

?>
