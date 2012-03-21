<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperImagePlugin_ImageUnitTest extends AbstractViperUnitTest
{


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
    public function testBlankAltAttributeInSource()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.ENTER');

         $this->assertHTMLMatch(
             '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>',
             '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt=""></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testBlankAltAttributeInSource()


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

        $this->assertHTMLMatch(
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" />Squiz LABS is ORSM</p>',
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag">Squiz LABS is ORSM</p>');

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

        $this->assertHTMLMatch(
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>',
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag"></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->click($this->find('dolor'));
        $this->selectText('ORSM');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');
        //$this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch(
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p>',
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag"></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag"></p>');

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

        $this->assertHTMLMatch(
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>',
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag"> dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->click($this->find('dolor'));
        $this->selectText('LABS');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');
   //     $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch(
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> is ORSM</p>',
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag"> dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS<img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag"> is ORSM</p>');

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

        $this->assertHTMLMatch(
            '<h1>Viper Image Plugin Unit Tests</h1><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>',
            '<h1>Viper Image Plugin Unit Tests</h1><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag"></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->click($this->find('WoW'));
        $this->selectText('LABS');
        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.TAB');
        $this->type('Alt tag');
        $this->keyDown('Key.ENTER');
        //$this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch(
            '<h1>Viper Image Plugin Unit Tests</h1><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz <img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /> is ORSM</p>',
            '<h1>Viper Image Plugin Unit Tests</h1><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag"></p><p>sit amet <strong>WoW</strong></p><p>Squiz <img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag"> is ORSM</p>');

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

        $this->assertHTMLMatch(
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>',
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag"></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testInsertingImageInNewParagraph()


    /**
     * Test inserting and deleting an image using the delete key.
     *
     * @return void
     */
    public function testInsertingAndDeletingImageUsingDelete()
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

        $this->assertHTMLMatch(
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>',
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag"></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->clickElement('img', 1);
        $this->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testInsertingAndDeletingImageUsingDelete()


    /**
     * Test inserting and deleting an image using the insert image icon.
     *
     * @return void
     */
    public function testDeletingTheURLForAnImage()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');
        $this->type('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton($dir.'toolbarIcon_image.png');
        $this->type('http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>',
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt=""></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="" alt="" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>',
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="" alt=""></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testInsertingAndDeletingImageUsingTheIcon()


    /**
     * Test editing an image.
     *
     * @return void
     */
    public function testEditingAnImage()
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

        $this->assertHTMLMatch(
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>',
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag"></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_image_highlighted.png');
        $this->keyDown('Key.TAB');
        $this->type('Abcd');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Abcd" /></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>',
            '<h1>Viper Image Plugin Unit Tests</h1><p>LOREM XuT dolor</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Abcd"></p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is ORSM</p>');

    }//end testEditingAnImage()


}//end class

?>
