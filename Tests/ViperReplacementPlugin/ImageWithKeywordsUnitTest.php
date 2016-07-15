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
        sleep(1);
        $this->type('test');
        sleep(1);
        $this->applyChanges('inline', 'update');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" title="test" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" title="test" /> even more content</p>');

        // Edit the title tag
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('image', 'active');
        $this->clearFieldValue('Title');
        sleep(1);
        $this->type('test title');
        sleep(1);
        $this->applyChanges('inline', 'update');
        sleep(1);
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" title="test title" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" title="test title" /> even more content</p>');

        // Using top toolbar
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clickField('Title');
        sleep(1);
        $this->clearFieldValue('Title');
        sleep(1);
        $this->type('test');
        sleep(1);
        $this->applyChanges('top', 'update');
        sleep(1);
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" title="test" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" title="test" /> even more content</p>');

        // Edit the Title tag
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('image', 'active');
        $this->clearFieldValue('Title');
        sleep(1);
        $this->type('test title');
        sleep(1);
        $this->applyChanges('top', 'update');
        sleep(1);
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" title="test title" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" title="test title" /> even more content</p>');

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
        $loc = $this->findKeyword(5);
        $this->sikuli->mouseMove($loc);
        $this->sikuli->mouseDown('Button.LEFT');
        usleep(300000);
        $this->sikuli->mouseUp('Button.LEFT');

        $this->assertHTMLMatch('<p>test content %1%<img alt="TITLE" src="((prop:url))" /></p><p>more content&nbsp;&nbsp;even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1% <img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))" /></p><p>more content&nbsp;&nbsp;even more content</p>');

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
        $loc = $this->findKeyword(5);
        $this->sikuli->mouseMove($loc);
        $this->sikuli->mouseDown('Button.LEFT');
        usleep(300000);
        $this->sikuli->mouseUp('Button.LEFT');

        $this->assertHTMLMatch('<p>test content %1%<a href="www.squizlabs.com.au"><img alt="TITLE" src="((prop:url))" /></a></p><p>more content&nbsp;&nbsp;even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%<a href="www.squizlabs.com.au"><img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))" /></a></p><p>more content&nbsp;&nbsp;even more content</p>');

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
        sleep(2);
        $this->clickInlineToolbarButton('image', 'active');
        sleep(3);
        $this->clickField('Image is decorative');
        sleep(3);
        $this->applyChanges('inline', 'update');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img src="((prop:url))" alt="" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /> even more content</p>');

        // Changing back
        $this->clickElement('img', 0);
        sleep(2);
        $this->clickInlineToolbarButton('image', 'active');
        sleep(3);
		$this->clickField('Image is decorative');
        sleep(2);
		$this->clickField('Alt', true);
        sleep(2);
		$this->type('TITLE');
        sleep(2);
        $this->applyChanges('inline', 'update');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /> even more content</p>');

        // Using top toolbar
        $this->clickElement('img', 0);
        sleep(2);
        $this->clickTopToolbarButton('image', 'active');
        sleep(1);
        $this->clickField('Image is decorative');
        sleep(3);
        $this->applyChanges('top', 'update');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img alt="" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /> even more content</p>');

        // Changing back
        $this->clickElement('img', 0);
        sleep(2);
        $this->clickTopToolbarButton('image', 'active');
        sleep(1);
		$this->clickField('Image is decorative');
        sleep(1);
		$this->clickField('Alt', true);
        sleep(2);
		$this->type('TITLE');
        sleep(2);
        $this->applyChanges('top', 'update');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" data-viper-attribite-keywords="true" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /> even more content</p>');

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
        sleep(3);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="((prop:url))" /></p><p>more content<img alt="TITLE" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))" /></p><p>more content <img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))" /> even more content</p>');

        // Using right click
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->copy(true);
        sleep(3);
        $this->moveToKeyword(1, 'right');
        $this->paste(true);

        $this->assertHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="((prop:url))" /></p><p><img alt="TITLE" src="((prop:url))" /></p><p>more content<img alt="TITLE" src="((prop:url))" /> even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /></p><p><img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /></p><p>more content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /> even more content</p>');

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
        $this->assertRawHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))" /></p><p>more content&nbsp;&nbsp;even more content</p>');

        // Using right click
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        sleep(1);
        $this->cut(true, true);
        sleep(1);
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->paste(true);
        sleep(1);

        $this->assertHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="((prop:url))" /></p><p>more content&nbsp;&nbsp;even more content</p>');
        $this->assertRawHTMLMatch('<p>test content %1%</p><p><img alt="TITLE" src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))" /></p><p>more content&nbsp;&nbsp;even more content</p>');

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
        $this->assertRawHTMLMatch('<p>test content %1% <span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span></p><p>more content<img alt="TITLE" data-viper-src="((prop:url))" height="170px" src="'.$this->getTestURL('/Web/testImage.png').'" width="200px" /> even more content</p>');

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
        $this->assertRawHTMLMatch('<p>test content %1%</p><p>more content&nbsp;&nbsp;even more content</p>');

    }//end testUndoAndRedoDeletingImagesThatUseKeywords()


    /**
     * Test that images using keywords can be undone and redone.
     *
     * @return void
     */
    public function testUndoAndRedoDeletingImageKeywords()
    {
        // Using keyboard shortcuts
        $this->useTest(4);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.CMD + z');

        $this->assertHTMLMatch('<p>%1% test content ((prop:viperKeyword)) </p><p>more content <img alt="TITLE" src="((prop:url))" /> even more %2% content</p>');
        $this->assertRawHTMLMatch('<p>%1% test content<span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span></p><p>more content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /> even more %2% content</p>');

        // Test for redo
        $this->clickKeyword(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');

        $this->assertHTMLMatch('<p>%1% test content ((prop:viperKeyword))</p><p>more content&nbsp;&nbsp;even more %2% content</p>');
        $this->assertRawHTMLMatch('<p>%1% test content<span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span></p><p>more content&nbsp;&nbsp;even more %2% content</p>');

        // Using top toolbar
        $this->clickTopToolbarButton('historyUndo', NULL);

        $this->assertHTMLMatch('<p>%1% test content ((prop:viperKeyword)) </p><p>more content <img alt="TITLE" src="((prop:url))" /> even more %2% content</p>');
        $this->assertRawHTMLMatch('<p>%1% test content<span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span></p><p>more content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /> even more %2% content</p>');

        // Test for redo
        $this->clickTopToolbarButton('historyRedo', NULL);

        $this->assertHTMLMatch('<p>%1% test content ((prop:viperKeyword))</p><p>more content&nbsp;&nbsp;even more %2% content</p>');
        $this->assertRawHTMLMatch('<p>%1% test content<span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span></p><p>more content&nbsp;&nbsp;even more %2% content</p>');

    }//end testUndoAndRedoDeletingImageKeywords()


    /**
     * Test that images that use keywords that have been moved can be undone and redone using keyboard shortcuts.
     *
     * @return void
     */
    public function testUndoAndRedoMovingImageKeywordsUsingKeyboardShortcuts()
    {
        // Using keyboard shortcuts
        $this->useTest(4);
        sleep(1);
        $this->clickKeyword(2);
        sleep(3);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('move');
        $loc = $this->findKeyword(5);
        $this->sikuli->mouseMove($loc);
        $this->sikuli->mouseDown('Button.LEFT');
        usleep(300000);
        $this->sikuli->mouseUp('Button.LEFT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + z');

        $this->assertHTMLMatch('<p>%1% test content ((prop:viperKeyword))</p><p>more content<img alt="TITLE" src="((prop:url))" /> even more %2% content</p>');
        $this->assertRawHTMLMatch('<p>%1% test content<span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span></p><p>more content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /> even more %2% content</p>');

        // Test for redo
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        sleep(2);
        $this->assertHTMLMatch('<p>%1% test content<img alt="TITLE" src="((prop:url))" /></p><p>more content&nbsp;&nbsp;even more %2% content</p>');
        $this->assertRawHTMLMatch('<p>%1% test content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /></p><p>more content&nbsp;&nbsp;even more %2% content</p>');

    }//end testUndoAndRedoMovingImageKeywordsUsingKeyboardShortcuts()


    /**
     * Test that images that use keywords that have been moved can be undone and redone using toolbar icons.
     *
     * @return void
     */
    public function testUndoAndRedoMovingImageKeywordsUsingToolbarIcons()
    {

        // Using top toolbar
        $this->useTest(4);
        sleep(1);
        $this->clickKeyword(2);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('move');
        $loc = $this->findKeyword(5);
        $this->sikuli->mouseMove($loc);
        $this->sikuli->mouseDown('Button.LEFT');
        usleep(300000);
        $this->sikuli->mouseUp('Button.LEFT');
        $this->clickTopToolbarButton('historyUndo');

        $this->assertHTMLMatch('<p>%1% test content ((prop:viperKeyword))</p><p>more content<img alt="TITLE" src="((prop:url))" /> even more %2% content</p>');
        $this->assertRawHTMLMatch('<p>%1% test content<span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span></p><p>more content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /> even more %2% content</p>');

        // Test for redo
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('historyRedo', NULL);
        sleep(1);
        $this->assertHTMLMatch('<p>%1% test content<img alt="TITLE" src="((prop:url))" /></p><p>more content&nbsp;&nbsp;even more %2% content</p>');
        $this->assertRawHTMLMatch('<p>%1% test content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /></p><p>more content&nbsp;&nbsp;even more %2% content</p>');

    }//end testUndoAndRedoMovingImageKeywordsUsingToolbarIcons()


    /**
     * Test that images that use keywords that have been resized can be undone and redone.
     *
     * @return void
     */
    public function testUndoAndRedoResizingImageKeywords()
    {
        // Using keyboard shortcuts
        $this->useTest(4);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        sleep(1);
        $this->resizeImage(200);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + z');

        $this->assertHTMLMatch('<p>%1% test content ((prop:viperKeyword))</p><p>more content <img src="((prop:url))" alt="TITLE" /> even more %2% content</p>');
        $this->assertRawHTMLMatch('<p>%1% test content<span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span></p><p>more content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /> even more %2% content</p>');

        // Test for redo
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');

        $this->assertHTMLMatch('<p>%1% test content ((prop:viperKeyword))</p><p>more content <img src="((prop:url))" alt="TITLE" height="170" width="200" /> even more %2% content</p>');
        $this->assertRawHTMLMatch('<p>%1% test content<span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span></p><p>more content<img alt="TITLE" data-viper-src="((prop:url))" height="170px" src="'.$this->getTestURL('/Web/testImage.png').'" width="200px" /> even more %2% content</p>');

        // Using top toolbar
        sleep(1);
        $this->clickTopToolbarButton('historyUndo');
        $this->clickElement('img', 0);
        $this->resizeImage(200);
        sleep(1);
        $this->clickTopToolbarButton('historyUndo', NULL);

        $this->assertHTMLMatch('<p>%1% test content ((prop:viperKeyword))</p><p>more content<img alt="TITLE" src="((prop:url))" /> even more %2% content</p>');
        $this->assertRawHTMLMatch('<p>%1% test content<span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span></p><p>more content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /> even more %2% content</p>');

        // Test for redo
        $this->clickTopToolbarButton('historyRedo', NULL);

        $this->assertHTMLMatch('<p>%1% test content ((prop:viperKeyword))</p><p>more content <img src="((prop:url))" alt="TITLE" height="170" width="200" /> even more %2% content</p>');
        $this->assertRawHTMLMatch('<p>%1% test content<span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span></p><p>more content<img alt="TITLE" data-viper-src="((prop:url))" height="170px" src="'.$this->getTestURL('/Web/testImage.png').'" width="200px" /> even more %2% content</p>');

    }//end testUndoAndRedoResizingImageKeywords()
}
