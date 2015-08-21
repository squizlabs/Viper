    <?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperKeywordPlugin_GeneralKeywordUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that keyword can be deleted.
     *
     * @return void
     */
    public function testDeleteKeyword()
    {

        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testDeleteKeyword()


    /**
     * Test that images using keywords can be undone and redone.
     *
     * @return void
     */
    public function testDeleteImagesThatUseKeywords()
    {
        $this->useTest(2);
        $this->clickKeyword(1);
        sleep(1);
        $this->clickElement('img', 0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>test content %1%</p><p>more content even more content</p>');

        $expectedRawHTML = '<p>test content %1%</p><p>more content <img alt="TITLE" src="((prop:url))" height="31" width="91"> even more content</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testUndoAndRedoDeletingImagesThatUseKeywords()


    /**
     * Test that keywords can have bold applied.
     *
     * @return void
     */
    public function testApplyingBoldToKeywords()
    {
        //Using top toolbar
        $this->useTest(3);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p>%1% <strong>((prop:productName))</strong></p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))"><strong>Viper</strong></span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        //Using inline toolbar
        $this->moveToKeyword(2 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('bold');
        $this->assertHTMLMatch('<p>%1% <strong>((prop:productName))</strong></p><p>%2% <strong>((prop:productName))</strong></p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></strong></p><p>%2% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></strong></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        //Using keyboard shortcuts
        $this->moveToKeyword(3 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>%1% <strong>((prop:productName))</strong></p><p>%2% <strong>((prop:productName))</strong></p><p>%3% <strong>((prop:productName))</strong></p>');

        $expectedRawHTML = '<p>%1% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></strong></p><p>%2% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></strong></p><p>%3% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></strong></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testApplyingBoldToKeywords()


    /**
     * Test that keywords can have italic applied.
     *
     * @return void
     */
    public function testApplyingItalicToKeywords()
    {
        //Using top toolbar
        $this->useTest(3);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<p>%1% <em>((prop:productName))</em></p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))"><em>Viper</em></span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        //Using inline toolbar
        $this->moveToKeyword(2 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('<p>%1% <em>((prop:productName))</em></p><p>%2% <em>((prop:productName))</em></p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></em></p><p>%2% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></em></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        //Using keyboard shortcuts
        $this->moveToKeyword(3 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>%1% <em>((prop:productName))</em></p><p>%2% <em>((prop:productName))</em></p><p>%3% <em>((prop:productName))</em></p>');

        $expectedRawHTML = '<p>%1% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></em></p><p>%2% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></em></p><p>%3% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></em></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testApplyingItalicToKeywords()


    /**
     * Test that keywords can have subscript applied.
     *
     * @return void
     */
    public function testApplyingSubscriptToKeywords()
    {
        //Using top toolbar
        $this->useTest(3);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('<p>%1% <sub>((prop:productName))</sub></p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))"><sub>Viper</sub></span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        //Using inline toolbar
        $this->moveToKeyword(2 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('subscript');
        $this->assertHTMLMatch('<p>%1% <sub>((prop:productName))</sub></p><p>%2% <sub>((prop:productName))</sub></p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <sub><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></sub></p><p>%2% <sub><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></sub></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testApplyingSubscriptToKeywords()


    /**
     * Test that keywords can have superscript applied.
     *
     * @return void
     */
    public function testApplyingSuperscriptToKeywords()
    {
        //Using top toolbar
        $this->useTest(3);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<p>%1% <sup>((prop:productName))</sup></p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))"><sup>Viper</sup></span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        //Using inline toolbar
        $this->moveToKeyword(2 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('superscript');
        $this->assertHTMLMatch('<p>%1% <sup>((prop:productName))</sup></p><p>%2% <sup>((prop:productName))</sup></p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></sup></p><p>%2% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></sup></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testApplyingSuperscriptToKeywords()


    /**
     * Test that keywords can have strikethrough applied.
     *
     * @return void
     */
    public function testApplyingStrikethroughToKeywords()
    {
        //Using top toolbar
        $this->useTest(3);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p>%1% <del>((prop:productName))</del></p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))"><del>Viper</del></span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        //To do
        //$this->clickTopToolbarButton('strikethrough', 'active');

        //Using inline toolbar
        $this->moveToKeyword(2 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p>%1% <del>((prop:productName))</del></p><p>%2% <del>((prop:productName))</del></p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <del><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></del></p><p>%2% <del><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></del></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testApplyingStrikethroughToKeywords()


    /**
     * Test that keywords can have formats removed with remove format key applied.
     *
     * @return void
     */
    public function testRemoveFormatOnKeywords()
    {
        //Test on italic
        $this->useTest(5);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% <strong>((prop:productName))</strong></p><p>%3% <del>((prop:productName))</del></p><p>%4% <sub>((prop:productName))</sub></p><p>%5% <sup>((prop:productName))</sup></p>');
        
        $expectedRawHTML = '<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%2% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></strong></p><p>%3% <del><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></del></p><p>%4% <sub><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></sub></p><p>%5% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></sup></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test on bold
        $this->moveToKeyword(2 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% <del>((prop:productName))</del></p><p>%4% <sub>((prop:productName))</sub></p><p>%5% <sup>((prop:productName))</sup></p>');
        
        $expectedRawHTML = '<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%2% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%3% <del><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></del></p><p>%4% <sub><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></sub></p><p>%5% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></sup></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test on strikethrough
        $this->moveToKeyword(3 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p><p>%4% <sub>((prop:productName))</sub></p><p>%5% <sup>((prop:productName))</sup></p>');
        
        $expectedRawHTML = '<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%2% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%4% <sub><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></sub></p><p>%5% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></sup></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test on subscript
        $this->moveToKeyword(4 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p><p>%4% ((prop:productName))</p><p>%5% <sup>((prop:productName))</sup></p>');
        
        $expectedRawHTML = '<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%2% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%5% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></sup></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test on subscript
        $this->moveToKeyword(5 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p><p>%4% ((prop:productName))</p><p>%5% ((prop:productName))</p>');
        
        $expectedRawHTML = '<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%2% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p><p>%5% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testRemoveFormatOnKeywords()


    /**
     * Test that keywords can work properly with the delete functions.
     *
     * @return void
     */
    public function testDeletingKeywords()
    {
        // Test backspace key on standard keyword
        $this->useTest(4);
        $this->clickKeyword(1);
        sleep(2);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1%</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p><p>%4% ((prop:productName))</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1%</p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%4% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%5% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%6% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Using delete key on standard keyword
        $this->moveToKeyword(2 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1%</p><p>%2%</p><p>%3% ((prop:productName))</p><p>%4% ((prop:productName))</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1%</p><p>%2% </p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test backspace key on content after keyword
        $this->moveToKeyword(3 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('-A');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1%</p><p>%2%</p><p>%3% ((prop:productName)) -</p><p>%4% ((prop:productName))</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1%</p><p>%2% </p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> -</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Using delete key on content after keyword
        $this->moveToKeyword(4 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('-B');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1%</p><p>%2%</p><p>%3% ((prop:productName)) -</p><p>%4% ((prop:productName)) B</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1%</p><p>%2% </p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> -</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> B</p><p>%5% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test backspace key on content before keyword
        $this->moveToKeyword(5 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('C-');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1%</p><p>%2%</p><p>%3% ((prop:productName)) -</p><p>%4% ((prop:productName))</p><p>%5% -((prop:productName))</p><p>%6% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1%</p><p>%2% </p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> -</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> B</p><p>%5% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Using delete key on content before keyword
        $this->moveToKeyword(6 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('D-');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1%</p><p>%2%</p><p>%3% ((prop:productName)) -</p><p>%4% ((prop:productName)) B</p><p>%5% ((prop:productName))</p><p>%6% D((prop:productName))</p>');

        $expectedRawHTML = '<p>%1%</p><p>%2% </p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> -</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> B</p><p>%5% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6% D<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testApplyingStrikethroughToKeywords()
}