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
        $this->useTest(3);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clickField('Title');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" title="test" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content <img class="__viper_selHighlight __viper_cleanOnly" data-viper-attribite-keywords="true" title="test" alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))"> even more content</p>');

        // Edit the title tag
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clearFieldValue('Title');
        $this->type('test title');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" title="test title" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content <img class="__viper_selHighlight __viper_cleanOnly" data-viper-attribite-keywords="true" title="test title" alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))"> even more content</p>');

        // Using top toolbar
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Title');
        $this->clearFieldValue('Title');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->checkPreviewImageSize();
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" title="test" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" title="test"> even more content</p>');

        // Edit the Title tag
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('Title');
        $this->type('test title');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->checkPreviewImageSize();
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" title="test title" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" title="test title"> even more content</p>');

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
        $this->clickKeyword(5);

        $this->assertHTMLMatch('<p>test content %1%<img alt="TITLE" src="((prop:url))" /></p><p>more content&nbsp;&nbsp;even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1% <img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))"></p><p>more content  even more content</p>');

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
        $this->clickKeyword(5);

        $this->assertHTMLMatch('<p>test content %1%<a href="www.squizlabs.com.au"><img alt="TITLE" src="((prop:url))" /></a></p><p>more content&nbsp;&nbsp;even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%<a href="www.squizlabs.com.au"><img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'"></a></p><p>more content  even more content</p>');

    }//end testMovingLinkedImageKeyword()


	/**
     * Test that images using keywords can be moved.
     *
     * @return void
     */
    public function testChangeImageKeywordDecorative()
    {
        // Using inline toolbar
        $this->useTest(3);
        $this->clickKeyword(1);
        sleep(3);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        sleep(3);
        $this->clickField('Image is decorative');
        sleep(3);
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img src="((prop:url))" alt="" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="" class="__viper_selHighlight __viper_cleanOnly" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'"> even more content</p>');

        // Changing back
		$this->clickField('Image is decorative');
		$this->clickField('Alt', true);
		$this->type('TITLE');
        sleep(2);
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" class="__viper_selHighlight __viper_cleanOnly" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'"> even more content</p>');

        // Using top toolbar
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        sleep(1);
        $this->clickField('Image is decorative');
        sleep(3);
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img alt="" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'"> even more content</p>');

        // Changing back
		$this->clickField('Image is decorative');
        sleep(1);
		$this->clickField('Alt', true);
		$this->type('TITLE');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'"> even more content</p>');

    }//end testChangeImageKeywordDecorative()


    /**
     * Test that images using keywords can be copied and pasted.
     *
     * @return void
     */
    public function testCopyAndPasteImageKeyword()
    {
        // Using keyboard shortcuts
        $this->useTest(3);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="((prop:url))" /></p><p>more content<img alt="TITLE" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))"></p><p>more content <img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))"> even more content</p>');

        // Using right click
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->copy(true);
        $this->moveToKeyword(1, 'left');
        $this->paste(true);

        $this->assertHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="((prop:url))" /></p><p><img alt="TITLE" src="((prop:url))" /></p><p>more content<img alt="TITLE" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))"></p><p><img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))"></p><p>more content <img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))"> even more content</p>');

    }//end testCopyAndPasteImageKeyword()


    /**
     * Test that images using keywords can be cut and pasted.
     *
     * @return void
     */
    public function testCutAndPasteImageKeyword()
    {
        // Using keyboard shortcuts
        $this->useTest(3);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="((prop:url))" /></p><p>more content&nbsp;&nbsp;even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))"></p><p>more content  even more content</p>');

        // Using right click
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->cut(true);
        $this->moveToKeyword(1, 'left');
        $this->paste(true);

        $this->assertHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="((prop:url))" /></p><p>more content&nbsp;&nbsp;even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))"></p><p></p><p>more content  even more content</p>');

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
        sleep(1);
        $this->resizeImage(200);

        $this->assertHTMLMatch('<p>test content %1% ((prop:viperKeyword))</p><p>more content <img src="((prop:url))" alt="TITLE" height="170" width="200" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1% <span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span></p><p>more content<img alt="TITLE" data-viper-src="((prop:url))" height="170" src="'.$this->getTestURL('/Web/testImage.png').'" width="200"> even more content</p>');

    }//end testResizingImageKeyword()


    /**
     * Test that images using keywords can be undone and redone.
     *
     * @return void
     */
    public function testDeleteImagesThatUseKeywords()
    {
        $this->useTest(3);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content&nbsp;&nbsp;even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content  even more content</p>');

    }//end testUndoAndRedoDeletingImagesThatUseKeywords()
}
