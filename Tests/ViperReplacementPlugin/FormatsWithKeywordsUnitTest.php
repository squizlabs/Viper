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
        $this->assertRawHTMLMatch('<p>%1% <strong><span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></strong></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');

        // Using inline toolbar
        $this->moveToKeyword(2 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('bold');

        $this->assertHTMLMatch('<p>%1% <strong>((prop:productName))</strong></p><p>%2% <strong>((prop:productName))</strong></p><p>%3% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></strong></p><p>%2% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></strong></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');

        // Using keyboard shortcuts
        $this->moveToKeyword(3 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>%1% <strong>((prop:productName))</strong></p><p>%2% <strong>((prop:productName))</strong></p><p>%3% <strong>((prop:productName))</strong></p>');
        $this->assertRawHTMLMatch('<p>%1% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></strong></p><p>%2% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></strong></p><p>%3% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></strong></p>');

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
        $this->assertRawHTMLMatch('<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');

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
        $this->assertRawHTMLMatch('<p>%1% <em><span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></em></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');

        // Using inline toolbar
        $this->moveToKeyword(2 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('italic');

        $this->assertHTMLMatch('<p>%1% <em>((prop:productName))</em></p><p>%2% <em>((prop:productName))</em></p><p>%3% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></em></p><p>%2% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></em></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');

        // Using keyboard shortcuts
        $this->moveToKeyword(3 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p>%1% <em>((prop:productName))</em></p><p>%2% <em>((prop:productName))</em></p><p>%3% <em>((prop:productName))</em></p>');
        $this->assertRawHTMLMatch('<p>%1% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></em></p><p>%2% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></em></p><p>%3% <em><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></em></p>');

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
        $this->assertRawHTMLMatch('<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');

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
        $this->assertRawHTMLMatch('<p>%1% <sub><span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></sub></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');

        // Test for revert
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');

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
        $this->assertRawHTMLMatch('<p>%1% <sup><span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></sup></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');

        // Test for revert
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');

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
        $this->assertRawHTMLMatch('<p>%1% <del><span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></del></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');

        // Test for revert
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');

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
        $this->moveToKeyword(1, 'right');
        sleep(1);
        for ($i = 0; $i < 5; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }

        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertEquals($this->replaceKeywords('Viper %1%'), $this->getSelectedText(), 'First line of text should be selected');

        // Test middle of paragraph
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertEquals($this->replaceKeywords('%2% Viper %3%'), $this->getSelectedText(), 'Second line of text should be selected');

        // Test end of paragraph
        $this->moveToKeyword(4, 'left');
        for ($i = 0; $i < 5; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }

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
        // Italic then bold tag
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
        $this->assertRawHTMLMatch('<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');
         // Bold then Italic tag
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
        $this->assertRawHTMLMatch('<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');

    }// end testRemoveMultipleFormats


    /**
     * Test that keywords can have formats removed with remove format key applied.
     *
     * @return void
     */
    public function testRemoveFormatOnKeywords()
    {
        // Test on italic
        $this->useTest(3);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT + Key.SHIFT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% <strong>((prop:productName))</strong></p><p>%3% <del>((prop:productName))</del></p><p>%4% <sub>((prop:productName))</sub></p><p>%5% <sup>((prop:productName))</sup></p>');
        $this->assertRawHTMLMatch('<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%2% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></strong></p><p>%3% <del><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></del></p><p>%4% <sub><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sub></p><p>%5% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sup></p>');

        // Test on bold
        $this->moveToKeyword(2 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% <del>((prop:productName))</del></p><p>%4% <sub>((prop:productName))</sub></p><p>%5% <sup>((prop:productName))</sup></p>');
        $this->assertRawHTMLMatch('<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%2% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%3% <del><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></del></p><p>%4% <sub><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sub></p><p>%5% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sup></p>');

        // Test on strikethrough
        $this->moveToKeyword(3 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p><p>%4% <sub>((prop:productName))</sub></p><p>%5% <sup>((prop:productName))</sup></p>');
        $this->assertRawHTMLMatch('<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%2% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4% <sub><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sub></p><p>%5% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sup></p>');

        // Test on subscript
        $this->moveToKeyword(4 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p><p>%4% ((prop:productName))</p><p>%5% <sup>((prop:productName))</sup></p>');
        $this->assertRawHTMLMatch('<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%2% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sup></p>');

        // Test on subscript
        $this->moveToKeyword(5 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p><p>%4% ((prop:productName))</p><p>%5% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%2% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');

    }//end testRemoveFormatOnKeywords()


    /**
     * Test that the keyword is still selected when removing bold formatting.
     *
     * @return void
     */
    public function testKeywordStillSelectedWhenRemoveBoldFormating()
    {
        // Using keyboard shortcut toolbar
        $this->useTest(4, 1);
        $this->clickKeyword(5);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), '%5% should be selected');
        $this->assertHTMLMatch('<p><strong>Test %1% content </strong>((prop:viperKeyword))<strong> more test content</strong></p>');
        $this->assertRawHTMLMatch('<p><strong>Test %1% content</strong><span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span><strong> more test content</strong></p>');

        // Using inline toolbar
        $this->useTest(4, 1);
        $this->clickKeyword(5);
        sleep(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), '%5% should be selected');
        $this->assertHTMLMatch('<p><strong>Test %1% content </strong>((prop:viperKeyword))<strong> more test content</strong></p>');
        $this->assertRawHTMLMatch('<p><strong>Test %1% content</strong><span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span><strong> more test content</strong></p>');

        // Using top toolbar
        $this->useTest(4, 1);
        $this->clickKeyword(5);
        sleep(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), '%5% should be selected');
        $this->assertHTMLMatch('<p><strong>Test %1% content </strong>((prop:viperKeyword))<strong> more test content</strong></p>');
        $this->assertRawHTMLMatch('<p><strong>Test %1% content</strong><span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span><strong> more test content</strong></p>');

    }//end testKeywordStillSelectedWhenRemoveBoldFormating()


    /**
     * Test that the keyword is still selected when removing italic formatting.
     *
     * @return void
     */
    public function testKeywordStillSelectedWhenRemoveItalicFormating()
    {
        // Using keyboard shortcut toolbar
        $this->useTest(5, 1);
        $this->clickKeyword(5);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), '%5% should be selected');
        $this->assertHTMLMatch('<p><em>Test %1% content </em>((prop:viperKeyword))<em> more test content</em></p>');
        $this->assertRawHTMLMatch('<p><em>Test %1% content</em><span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span><em> more test content</em></p>');

        // Using inline toolbar
        $this->useTest(5, 1);
        $this->clickKeyword(5);
        sleep(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), '%5% should be selected');
        $this->assertHTMLMatch('<p><em>Test %1% content </em>((prop:viperKeyword))<em> more test content</em></p>');
        $this->assertRawHTMLMatch('<p><em>Test %1% content</em><span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span><em> more test content</em></p>');

        // Using top toolbar
        $this->useTest(5, 1);
        $this->clickKeyword(5);
        sleep(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), '%5% should be selected');
        $this->assertHTMLMatch('<p><em>Test %1% content </em>((prop:viperKeyword))<em> more test content</em></p>');
        $this->assertRawHTMLMatch('<p><em>Test %1% content</em><span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span><em> more test content</em></p>');

    }//end testKeywordStillSelectedWhenRemoveItalicFormating()


    /**
     * Test that the keyword is still selected when removing strikethrough formatting.
     *
     * @return void
     */
    public function testKeywordStillSelectedWhenRemoveStrikethroughFormating()
    {
        $this->useTest(6, 1);
        $this->clickKeyword(5);
        sleep(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), '%5% should be selected');
        $this->assertHTMLMatch('<p><del>Test %1% content </del>((prop:viperKeyword))<del> more test content</del></p>');
        $this->assertRawHTMLMatch('<p><del>Test %1% content</del><span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span><del> more test content</del></p>');

    }//end testKeywordStillSelectedWhenRemoveStrikethroughFormating()


     /**
     * Test that the keyword is still selected when removing subscript formatting.
     *
     * @return void
     */
    public function testKeywordStillSelectedWhenRemoveSubscriptFormating()
    {
        $this->useTest(7, 1);
        $this->clickKeyword(5);
        sleep(1);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), '%5% should be selected');
        $this->assertHTMLMatch('<p><sub>Test %1% content </sub>((prop:viperKeyword))<sub> more test content</sub></p>');
        $this->assertRawHTMLMatch('<p><sub>Test %1% content</sub><span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span><sub> more test content</sub></p>');

    }//end testKeywordStillSelectedWhenRemoveSubscriptFormating()


    /**
     * Test that the keyword is still selected when removing superscript formatting.
     *
     * @return void
     */
    public function testKeywordStillSelectedWhenRemoveSuperscriptFormating()
    {
        $this->useTest(8, 1);
        $this->clickKeyword(5);
        sleep(1);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), '%5% should be selected');
        $this->assertHTMLMatch('<p><sup>Test %1% content </sup>((prop:viperKeyword))<sup> more test content</sup></p>');
        $this->assertRawHTMLMatch('<p><sup>Test %1% content</sup><span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span><sup> more test content</sup></p>');

    }//end testKeywordStillSelectedWhenRemoveSuperscriptFormating()

}