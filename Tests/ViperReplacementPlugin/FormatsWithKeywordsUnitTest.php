<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperReplacementPlugin_FormatsWithKeywordsUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that keywords can have bold applied.
     *
     * @return void
     */
    public function testApplyingBoldToKeywords()
    {
        // Using top toolbar
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p>%1% <strong>((prop:productName))</strong></p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))"><strong>Viper</strong></span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Using inline toolbar
        $this->moveToKeyword(2 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('bold');
        $this->assertHTMLMatch('<p>%1% <strong>((prop:productName))</strong></p><p>%2% <strong>((prop:productName))</strong></p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></strong></p><p>%2% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></strong></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Using keyboard shortcuts
        $this->moveToKeyword(3 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>%1% <strong>((prop:productName))</strong></p><p>%2% <strong>((prop:productName))</strong></p><p>%3% <strong>((prop:productName))</strong></p>');

        $expectedRawHTML = '<p>%1% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></strong></p><p>%2% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></strong></p><p>%3% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></strong></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test for revert
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('bold', 'active');

        // Using inline toolbar
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('bold', 'active');

        // Using keyboard shortcuts
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
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
        // Using top toolbar
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<p>%1% <em>((prop:productName))</em></p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))"><em>Viper</em></span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Using inline toolbar
        $this->moveToKeyword(2 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatch('<p>%1% <em>((prop:productName))</em></p><p>%2% <em>((prop:productName))</em></p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></em></p><p>%2% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></em></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Using keyboard shortcuts
        $this->moveToKeyword(3 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>%1% <em>((prop:productName))</em></p><p>%2% <em>((prop:productName))</em></p><p>%3% <em>((prop:productName))</em></p>');

        $expectedRawHTML = '<p>%1% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></em></p><p>%2% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></em></p><p>%3% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></em></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test for revert
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('italic', 'active');

        // Using inline toolbar
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('italic', 'active');

        //Using keyboard shortcuts
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
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
        // Using top toolbar
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('<p>%1% <sub>((prop:productName))</sub></p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))"><sub>Viper</sub></span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);
        
        // Test for revert
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
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
        // Using top toolbar
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<p>%1% <sup>((prop:productName))</sup></p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))"><sup>Viper</sup></span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test for revert
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
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
        // Using top toolbar
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p>%1% <del>((prop:productName))</del></p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))"><del>Viper</del></span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Test for revert
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);
    
    }//end testApplyingStrikethroughToKeywords()


    /**
     * Test that keywords that have formats applied retain selection.
     *
     * @return void
     */
    public function testSelectionAfterFormatOnKeywords()
    {
        // Test start of paragraph
        $this->useTest(2);
        $this->clickKeyword(1);
        sleep(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertEquals($this->replaceKeywords('Viper %1%'), $this->getSelectedText(), 'First line of text should be selected');

        // Test middle of paragraph
        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertEquals($this->replaceKeywords('%2% Viper %3%'), $this->getSelectedText(), 'Second line of text should be selected');

        // Test end of paragraph
        $this->moveToKeyword(4, 'left');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertEquals($this->replaceKeywords('%4% Viper'), $this->getSelectedText(), 'Third line of text should be selected');

    }//end testSelectionAfterFormatOnKeywords()

   
    /**
     * Test that keywords that have multiple formats applied remove all formats.
     *
     * @return void
     */
    public function testRemoveMultipleFormats()
    {
        $this->useTest(1);
        $this->clickKeyword(1);
        sleep(1);
        $this->moveToKeyword(1 , 'left');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        $this->moveToKeyword(2 , 'left');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');

        $expectedRawHTML = '<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }// end testRemoveMultipleFormats
}