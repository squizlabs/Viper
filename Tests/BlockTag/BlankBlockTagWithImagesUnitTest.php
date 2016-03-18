<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_BlankBlockTagWithImagesUnitTest extends AbstractViperUnitTest
{
	
	/**
     * Test adding an image to content with a blank block tag
     *
     * @return void
     */
    public function testAddingImageWithAltInBlankBlockTag()
    {
    	$this->useTest(1);
    	$this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

    	$this->useTest(2);
    	$this->moveToKeyword(1, 'right');
    	$this->clicktopToolbarButton('image', NULL);
        $this->clickField('URL', true);
        $this->type('%url%/ViperImagePlugin/Images/hero-shot.jpg');
        sleep(1);
        $this->clickField('Alt', true);
        $this->type('test_Alt');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is %1%<img alt="test_Alt" src="http://localhost/~slabs/Viper/Tests/ViperImagePlugin/Images/hero-shot.jpg" /> %2% some content');

    }//end testAddingImageInBlankBlockTag()


    /**
     * Test adding an image with an alt and title to content with a blank block tag
     *
     * @return void
     */
    public function testAddingImageWithAltAndTitleInBlankBlockTag()
    {
    	$this->useTest(1);
    	$this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

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
        $this->assertHTMLMatch('This is %1%<img alt="test_Alt" src="http://localhost/~slabs/Viper/Tests/ViperImagePlugin/Images/hero-shot.jpg" title="test_Title" /> %2% some content');

    }//end testAddingImageWithAltAndTitleInBlankBlockTag()


    /**
     * Test adding an image without an alt or title to content with a blank block tag
     *
     * @return void
     */
    public function testAddingImageWithoutAltAndTitleInBlankBlockTag()
    {
    	$this->useTest(1);
    	$this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

    	$this->useTest(2);
    	$this->moveToKeyword(1, 'right');
    	$this->clicktopToolbarButton('image', NULL);
        $this->clickField('URL', true);
        $this->type('%url%/ViperImagePlugin/Images/hero-shot.jpg');
        sleep(1);
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is %1%<img alt="" src="http://localhost/~slabs/Viper/Tests/ViperImagePlugin/Images/hero-shot.jpg" /> %2% some content');

    }//end testAddingImageWithoutAltAndTitleInBlankBlockTag()


    /**
     * Test deleting an image in content with a blank block tag
     *
     * @return void
     */
    public function testDeletingImageInBlankBlockTag()
    {
    	$this->useTest(1);
    	$this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

    	// Test using backspace key
    	$this->useTest(3);
    	$this->moveToKeyword(2, 'left');
    	$this->sikuli->keyDown('Key.LEFT');
    	$this->sikuli->keyDown('Key.BACKSPACE');
    	$this->assertHTMLMatch('This is %1% %2% some content');

    	// Test using delete key
    	$this->useTest(3);
    	$this->moveToKeyword(1, 'right');
    	$this->sikuli->keyDown('Key.DELETE');
    	$this->assertHTMLMatch('This is %1% %2% some content');

    }//end testDeletingImageInBlankBlockTag()

}//end class