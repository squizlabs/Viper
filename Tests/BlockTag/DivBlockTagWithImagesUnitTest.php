<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithImagesUnitTest extends AbstractViperUnitTest
{
	
	/**
     * Test adding an image to content with a div block tag
     *
     * @return void
     */
    public function testAddingImageWithAlt()
    {
    	$this->useTest(1);
    	$this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

    	$this->useTest(2);
    	$this->moveToKeyword(1, 'right');
    	$this->clicktopToolbarButton('image', NULL);
        $this->clickField('URL', true);
        $this->type('%url%/ViperImagePlugin/Images/hero-shot.jpg');
        sleep(1);
        $this->clickField('Alt', true);
        $this->type('test_Alt');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is %1%<img alt="test_Alt" src="%url%/ViperImagePlugin/Images/hero-shot.jpg" /> %2% some content</div>');

    }//end testAddingImageWithAlt()


    /**
     * Test adding an image with an alt and title to content with a div block tag
     *
     * @return void
     */
    public function testAddingImageWithAltAndTitle()
    {
    	$this->useTest(1);
    	$this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

    	$this->useTest(2);
    	$this->moveToKeyword(1, 'right');
    	$this->clicktopToolbarButton('image', NULL);
        $this->clickField('URL', true);
        $this->type('%url%/ViperImagePlugin/Images/hero-shot.jpg');
        sleep(1);
        $this->clickField('Alt', true);
        $this->type('test_Alt');
        sleep(1);
        $this->clickField('Title');
        $this->type('test_Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is %1%<img alt="test_Alt" src="%url%/ViperImagePlugin/Images/hero-shot.jpg" title="test_Title" /> %2% some content</div>');

    }//end testAddingImageWithAltAndTitle()


    /**
     * Test adding an image without an alt or title to content with a div block tag
     *
     * @return void
     */
    public function testAddingImageWithoutAltAndTitle()
    {
    	$this->useTest(1);
    	$this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

    	$this->useTest(2);
    	$this->moveToKeyword(1, 'right');
    	$this->clicktopToolbarButton('image', NULL);
        $this->clickField('URL', true);
        $this->type('%url%/ViperImagePlugin/Images/hero-shot.jpg');
        sleep(1);
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is %1%<img alt="" src="%url%/ViperImagePlugin/Images/hero-shot.jpg" /> %2% some content</div>');

    }//end testAddingImageWithoutAltAndTitle()


    /**
     * Test deleting an image in content with a div block tag
     *
     * @return void
     */
    public function testDeletingImage()
    {
    	$this->useTest(1);
    	$this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

    	// Test using backspace key
    	$this->useTest(3);
    	$this->moveToKeyword(2, 'left');
    	$this->sikuli->keyDown('Key.LEFT');
    	$this->sikuli->keyDown('Key.BACKSPACE');
    	$this->assertHTMLMatch('<div>This is %1% %2% some content</div>');

    	// Test using delete key
    	$this->useTest(3);
    	$this->moveToKeyword(1, 'right');
    	$this->sikuli->keyDown('Key.DELETE');
    	$this->assertHTMLMatch('<div>This is %1% %2% some content</div>');

    }//end testDeletingImage()


    /**
     * Test applying and removing a link on an image in content with a div block tag
     *
     * @return void
     */
    public function testApplyingAndRemovingLinkOnImage()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test using top toolbar
        // Test applying link
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clicktopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is %1%<a href="http://www.squizlabs.com"><img alt="test_Alt" src="%url%/ViperImagePlugin/Images/hero-shot.jpg" /></a> %2% some content</div>');

        // Test removing link
        $this->clickElement('img', 0);
        $this->clicktopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<div>This is %1%<img alt="test_Alt" src="%url%/ViperImagePlugin/Images/hero-shot.jpg" /> %2% some content</div>');

        // Test using inline toolbar
        // Test applying link
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is %1%<a href="http://www.squizlabs.com"><img alt="test_Alt" src="%url%/ViperImagePlugin/Images/hero-shot.jpg" /></a> %2% some content</div>');

        // Test removing link
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<div>This is %1%<img alt="test_Alt" src="%url%/ViperImagePlugin/Images/hero-shot.jpg" /> %2% some content</div>');

    }//end testApplyingAndRemovingLinkOnImage()


    /**
     * Test editing an image alt in content with a div block tag
     *
     * @return void
     */
    public function testEditingImageAlt()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test using inline toolbar
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Alt');
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('modified-');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<div>This is %1%<img alt="modified-test_Alt" src="%url%/ViperImagePlugin/Images/hero-shot.jpg" /> %2% some content</div>');

        // Test using top toolbar
        $this->useTest(3);
        $this->clickElement('img', 0);
        $this->clicktopToolbarButton('image', 'active');
        $this->clickField('Alt');
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('modified-');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<div>This is %1%<img alt="modified-test_Alt" src="%url%/ViperImagePlugin/Images/hero-shot.jpg" /> %2% some content</div>');

    }//end testEditingImageAlt()


    /**
     * Test editing an image title in content with a div block tag
     *
     * @return void
     */
    public function testEditingImageTitle()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test using inline toolbar
        $this->useTest(4);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Title');
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('modified-');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<div>This is %1%<img alt="test_Alt" src="%url%/ViperImagePlugin/Images/hero-shot.jpg" title="modified-test_Title" /> %2% some content</div>');

        // Test using top toolbar
        $this->useTest(4);
        $this->clickElement('img', 0);
        $this->clicktopToolbarButton('image', 'active');
        $this->clickField('Title');
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('modified-');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<div>This is %1%<img alt="test_Alt" src="%url%/ViperImagePlugin/Images/hero-shot.jpg" title="modified-test_Title" /> %2% some content</div>');

    }//end testEditingImageTitle()

}//end class