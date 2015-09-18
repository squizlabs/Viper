<?php

require_once 'AbstractViperImagePluginUnitTest.php';

class Viper_Tests_ViperReplacementPlugin_ImageWithKeywordsUnitTest extends AbstractViperImagePluginUnitTest
{

    /**
     * Test that images using keywords can have it's title changed.
     *
     * @return void
     */
    public function testImageKeywordTitleChange()
    {
        // Using inline toolbar
        $this->useTest(1);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Title');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" title="test" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p>	<p>more content <img class="__viper_selHighlight __viper_cleanOnly" data-viper-attribite-keywords="true" title="test" alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"> even more content</p>');
        
        // Edit the title tag
        $this->clearFieldValue('Title');
        $this->type('test title');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" title="test title" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p>	<p>more content <img class="__viper_selHighlight __viper_cleanOnly" data-viper-attribite-keywords="true" title="test title" alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"> even more content</p>');
        
        // Using top toolbar
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Title');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->checkPreviewImageSize();
        
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" title="test" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" src="./Images/testImage.png" data-viper-src="((prop:url))" data-viper-attribite-keywords="true" title="test"> even more content</p>');
        
        // Edit the Title tag
        $this->clearFieldValue('Title');
        $this->type('test title');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->checkPreviewImageSize();
        
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" title="test title" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" src="./Images/testImage.png" data-viper-src="((prop:url))" data-viper-attribite-keywords="true" title="test title"> even more content</p>');
        
    }//end testImageKeywordTitleChange()


	/**
     * Test that images using keywords can be moved.
     *
     * @return void
     */
    public function testMovingImageKeyword()
    {
        // Using inline toolbar
        $this->useTest(1);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('move');
        $this->clickKeyword(1);
        
        $this->assertHTMLMatch('<p>test content %<img alt="TITLE" src="((prop:url))" />1%</p><p>more content  even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %<img alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))">1%</p>	<p>more content  even more content</p>');
        
    }//end testMovingImageKeyword()


    /**
     * Test that linked images using keywords can be moved.
     *
     * @return void
     */
    public function testMovingLinkedImageKeyword()
    {
        // Using inline toolbar
        $this->useTest(2);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('move');
        $this->sikuli->mouseMove($this->findKeyword(1));
        $this->sikuli->mouseMoveOffset(15, 0);
        
        $this->assertHTMLMatch('<p>test content %1%<a href="www.squizlabs.com.au"><img alt="TITLE" src="((prop:url))" /></a></p><p>more content even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%<a href="www.squizlabs.com.au"><img alt="TITLE" src="./Images/testImage.png" data-viper-src="((prop:url))"></a></p><p>more content  even more content</p>');
        
    }//end testMovingLinkedImageKeyword()


	/**
     * Test that images using keywords can be moved.
     *
     * @return void
     */
    public function testChangeImageKeywordDecorative()
    {
        // Using inline toolbar
        $this->useTest(1);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img src="((prop:url))" alt="" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p>	<p>more content <img class="__viper_selHighlight __viper_cleanOnly" data-viper-attribite-keywords="true" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"> even more content</p>');
        
        // Changing back
		$this->clickField('Image is decorative');
		$this->clickField('Alt');
		$this->type('TITLE');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p>	<p>more content <img class="__viper_selHighlight __viper_cleanOnly" alt="TITLE" data-viper-attribite-keywords="true" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"> even more content</p>');
        
        // Using top toolbar
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Image is decorative');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        
        $this->assertHTMLMatch('<p>test content %<img src="((prop:url))" />1%</p><p>more content even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p>	<p>more content <img data-viper-attribite-keywords="true" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"> even more content</p>');
        
        // Changing back
		$this->clickField('Image is decorative');
		$this->clickField('Alt');
		$this->type('TITLE');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p>	<p>more content <img alt="TITLE" data-viper-attribite-keywords="true" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"> even more content</p>');
        
    }//end testChangeImageKeywordDecorative()


    /**
     * Test that images using keywords can be copied and pasted.
     *
     * @return void
     */
    public function testCopyAndPasteImageKeyword()
    {
        // Using keyboard shortcuts
        $this->useTest(1);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        
        $this->assertHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="((prop:url))" /></p><p>more content<img alt="TITLE" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="http://localhost/~slabs/Viper/Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"></p><p>more content <img alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"> even more content</p>');
        
        // Using right click
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->copy(true);
        $this->moveToKeyword(1, 'left');
        $this->paste(true);
        
        $this->assertHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="((prop:url))" /></p><p><img alt="TITLE" src="((prop:url))" /></p><p>more content<img alt="TITLE" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="http://localhost/~slabs/Viper/Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"></p><p><img alt="TITLE" src="http://localhost/~slabs/Viper/Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"></p><p>more content <img alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"> even more content</p>');
        
    }//end testCopyAndPasteImageKeyword()


    /**
     * Test that images using keywords can be cut and pasted.
     *
     * @return void
     */
    public function testCutAndPasteImageKeyword()
    {
        // Using keyboard shortcuts
        $this->useTest(1);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        
        $this->assertHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="((prop:url))" /></p><p>more content  even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="http://localhost/~slabs/Viper/Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"></p><p>more content  even more content</p>');
        
        // Using right click
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->cut(true);
        $this->moveToKeyword(1, 'left');
        $this->paste(true);
        
        $this->assertHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="((prop:url))" /></p><p>more content&nbsp;&nbsp;even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="http://localhost/~slabs/Viper/Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"></p><p></p><p>more content  even more content</p>');
        
    }//end testCutAndPasteImageKeyword()


    /**
     * Test that images using keywords can be cut and pasted.
     *
     * @return void
     */
    public function testResizingImageKeyword()
    {
        // Using keyboard shortcuts
        $this->useTest(1);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->resizeImage(100);
        $this->clickKeyword(1);
        sleep(1);
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" height="85" src="((prop:url))" width="100" /> even more content</p>');
        
        // To do: Get sertan to look at why this is failing.
        
        //$this->checkResizeHandles('img', 0);

        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))" width="100" height="85"> even more content</p>');
        
    }//end testResizingImageKeyword()


    /**
     * Test that images using keywords can be undone and redone.
     *
     * @return void
     */
    public function testDeleteImagesThatUseKeywords()
    {
        $this->useTest(1);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');
        
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" src="((prop:url))" height="31" width="91"> even more content</p>');
        
    }//end testUndoAndRedoDeletingImagesThatUseKeywords()
}