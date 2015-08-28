    <?php

require_once 'AbstractViperImagePluginUnitTest.php';

class Viper_Tests_ViperKeywordPlugin_UndoAndRedoKeywordUnitTest extends AbstractViperImagePluginUnitTest
{

    /**
     * Test that keyword can be deleted.
     *
     * @return void
     */
    public function testUndoAndRedoDeletingKeywords()
    {
        // Using keyboard shortcuts
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1% ((prop:productName)) %2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p><keyword title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</keyword>%1% <keyword title="((prop:productName))" data-viper-keyword="((prop:productName))" contenteditable="false"></keyword> %2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test for redo
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Using top toolbar
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1% ((prop:productName)) %2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p><keyword title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</keyword>%1% <keyword title="((prop:productName))" data-viper-keyword="((prop:productName))" contenteditable="false"></keyword> %2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test for redo
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testUndoAndRedoDeletingKeywords()


    /**
     * Test that images using keywords can be undone and redone.
     *
     * @return void
     */
    public function testUndoAndRedoDeletingImageKeywords()
    {
        // Using keyboard shortcuts
        $this->useTest(2);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" src="((prop:url))" /> even more content</p>');

        $expectedRawHTML = '<p>test content %1%</p><p>more content <img alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"> even more content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test for redo
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content&nbsp;&nbsp;even more content</p>');

        $expectedRawHTML = '<p>test content %1%</p><p>more content  even more content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);
    }//end testUndoAndRedoDeletingImageKeywords()


    /**
     * Test that images that use keywords that have been moved can be undone and redone.
     *
     * @return void
     */
    public function testUndoAndRedoMovingImageKeywords()
    {   
        // Using inline toolbar
        $this->useTest(2);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('move');
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" src="((prop:url))" /> even more content</p>');

        $expectedRawHTML = '<p>test content %1%</p><p>more content <img alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"> even more content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test for redo
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>test content %<img alt="TITLE" src="((prop:url))" />1%</p><p>more content  even more content</p>');

        $expectedRawHTML = '<p>test content %<img alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))">1%</p><p>more content  even more content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);
        sleep(1);

        // Using top toolbar
        $this->clickTopToolbarButton('historyUndo');
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('move');
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content <img alt="TITLE" src="((prop:url))" /> even more content</p>');

        $expectedRawHTML = '<p>test content %1%</p><p>more content <img alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"> even more content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test for redo
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>test content %<img alt="TITLE" src="((prop:url))" />1%</p><p>more content  even more content</p>');

        $expectedRawHTML = '<p>test content %<img alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))">1%</p><p>more content  even more content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testUndoAndRedoMovingImageKeywords()


    /**
     * Test that images that use keywords that have been resized can be undone and redone.
     *
     * @return void
     */
    public function testUndoAndRedoResizingImageKeywords()
    {   
        // Using inline toolbar
        $this->useTest(2);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->resizeImage(200);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" height="170" src="((prop:url))" width="200" /> even more content</p>');

        $expectedRawHTML = '<p>test content %1%</p><p>more content <img alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"> even more content</p></div>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test for redo
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" height="170" src="((prop:url))" width="200" /> even more content</p>');

        $expectedRawHTML = '<p>test content %<img alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))">1%</p><p>more content  even more content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Using top toolbar
        sleep(1);
        $this->clickTopToolbarButton('historyUndo');
        $this->clickElement('img', 0);
        $this->resizeImage(200);
        sleep(1);
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" height="170" src="((prop:url))" width="200" /> even more content</p>');

        $expectedRawHTML = '<p>test content %1%</p><p>more content <img alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))"> even more content</p></div>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test for redo
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content<img alt="TITLE" height="170" src="((prop:url))" width="200" /> even more content</p>');

        $expectedRawHTML = '<p>test content %<img alt="TITLE" src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))">1%</p><p>more content  even more content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testUndoAndRedoResizingImageKeywords()


    /**
     * Test that keywords that have have links added can be undone and redone.
     *
     * @return void
     */
    public function testUndoAndRedoOnLinkedKeywords()
    {   
        // Removing Link using inline toolbar
        $this->useTest(3);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('linkremove');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% <a href="www.squizlabs.com.au">((prop:productName))</a> %2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p>%1% <keyword title="((prop:productName))" data-viper-keyword="((prop:productName))" contenteditable="false">Viper</keyword> %2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test for redo
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% ((prop:productName)) %2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p>%1% <keyword data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</keyword> %2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Removing Link using top toolbar
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('linkremove');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% <a href="www.squizlabs.com.au">((prop:productName))</a> %2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p>%1% <a href="www.squizlabs.com.au"><keyword data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</keyword></a> %2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test for redo
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% ((prop:productName)) %2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p>%1% <keyword data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</keyword> %2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testUndoAndRedoOnLinkedKeywords()    
}