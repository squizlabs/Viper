<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperReplacementPlugin_ClassWithKeywordsUnitTest extends AbstractViperUnitTest
{

    /**
     * Test applying a class using keywords.
     *
     * @return void
     */
    public function testApplingClasses()
    {
        // Using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('((prop:className))');
        $this->sikuli->KeyDown('Key.ENTER');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>Test content <span class="((prop:className))">%1%</span> more test content</p>');
        $this->assertRawHTMLMatch('<p>Test content <span data-viper-class="((prop:className))" class="footnote-ref replaced-className ((prop:className))" data-viper-attribite-keywords="true">%1%</span> more test content</p>');

        // Using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('((prop:className))');
        $this->sikuli->KeyDown('Key.ENTER');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>Test content <span class="((prop:className))">%1%</span> more test content</p>');
        $this->assertRawHTMLMatch('<p>Test content <span data-viper-class="((prop:className))" class="footnote-ref replaced-className ((prop:className))" data-viper-attribite-keywords="true">%1%</span> more test content</p>');

    }//end testApplingClasses()


    /**
     * Test applying a class to a keyword.
     *
     * @return void
     */
    public function testApplingClassesToKeywords()
    {
        // Using inline toolbar
        $this->useTest(2, 1);
        $this->clickKeyword(5);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('footnote-ref ((prop:className))');
        $this->sikuli->KeyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Test %1% content <span class="footnote-ref ((prop:className))">((prop:viperKeyword))</span> more test content</p>');
        $this->assertRawHTMLMatch('<p>Test %1% content <span class="footnote-ref replaced-className" data-viper-attribite-keywords="true" data-viper-class="footnote-ref ((prop:className))" data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span> more test content</p>');

        // Using top toolbar
        $this->useTest(2, 1);
        $this->clickKeyword(5);
        $this->clickTopToolbarButton('cssClass');
        $this->type('footnote-ref ((prop:className)) ((prop:className))');
        $this->sikuli->KeyDown('Key.ENTER');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>Test %1% content <span class="footnote-ref ((prop:className))">((prop:viperKeyword))</span> more test content</p>');
        $this->assertRawHTMLMatch('<p>Test %1% content <span class="footnote-ref replaced-className" data-viper-attribite-keywords="true" data-viper-class="footnote-ref ((prop:className))" data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span> more test content</p>');

    }//end testApplingClassesToKeywords()


    /**
     * Test removing a keyword class
     *
     * @return void
     */
    public function testRemovingClass()
    {
        // Using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass','active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>Test content %1% more test content</p>');
        $this->assertRawHTMLMatch('<p>Test content %1% more test content</p>');

        // Using top toolbar
        $this->useTest(2);
        sleep(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickTopToolbarButton('cssClass','active');
        sleep(1);
        $this->clearFieldValue('Class');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>Test content %1% more test content</p>');
        $this->assertRawHTMLMatch('<p>Test content %1% more test content</p>');

    }//end testRemovingClass()


    /**
     * Test that you can bold formating to content that has classes applied using keywords.
     *
     * @return void
     */
    public function testApplingBoldToContentUsingKeywordClassNames()
    {
        // Test using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <strong><span class="((prop:className))">%1%</span></strong> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <strong><span class="replaced-className" data-viper-class="((prop:className))">%1%</span></strong> more content %2%</p>');

        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <span class="((prop:className))">%1%</span> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <span class="replaced-className" data-viper-class="((prop:className))">%1%</span> more content %2%</p>');

        // Test using top toolbar
        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <strong><span class="((prop:className))">%1%</span></strong> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <strong><span class="replaced-className" data-viper-class="((prop:className))">%1%</span></strong> more content %2%</p>');

        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <span class="((prop:className))">%1%</span> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <span class="replaced-className" data-viper-class="((prop:className))">%1%</span> more content %2%</p>');

        // Test using keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <strong><span class="((prop:className))">%1%</span></strong> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <strong><span class="replaced-className" data-viper-class="((prop:className))">%1%</span></strong> more content %2%</p>');

        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <span class="((prop:className))">%1%</span> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <span class="replaced-className" data-viper-class="((prop:className))">%1%</span> more content %2%</p>');

    }//end testApplingBoldToContentUsingKeywordClassNames()


    /**
     * Test that you can apply italics to content that has classes applied using keywords.
     *
     * @return void
     */
    public function testApplingItalicToContentUsingKeywordClassNames()
    {
        // Test using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <em><span class="((prop:className))">%1%</span></em> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <em><span class="replaced-className" data-viper-class="((prop:className))">%1%</span></em> more content %2%</p>');

        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <span class="((prop:className))">%1%</span> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <span class="replaced-className" data-viper-class="((prop:className))">%1%</span> more content %2%</p>');

        // Test using top toolbar
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <em><span class="((prop:className))">%1%</span></em> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <em><span class="replaced-className" data-viper-class="((prop:className))">%1%</span></em> more content %2%</p>');

        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <span class="((prop:className))">%1%</span> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <span class="replaced-className" data-viper-class="((prop:className))">%1%</span> more content %2%</p>');

        // Test using keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <em><span class="((prop:className))">%1%</span></em> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <em><span class="replaced-className" data-viper-class="((prop:className))">%1%</span></em> more content %2%</p>');

        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <span class="((prop:className))">%1%</span> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <span class="replaced-className" data-viper-class="((prop:className))">%1%</span> more content %2%</p>');

    }//end testApplingItalicToContentUsingKeywordClassNames()


    /**
     * Test that you can apply strikethrough to content that has classes applied using keywords.
     *
     * @return void
     */
    public function testApplingStrikethroughToContentUsingKeywordClassNames()
    {
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <del><span class="((prop:className))">%1%</span></del> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <del><span class="replaced-className" data-viper-class="((prop:className))">%1%</span></del> more content %2%</p>');

        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <span class="((prop:className))">%1%</span> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <span class="replaced-className" data-viper-class="((prop:className))">%1%</span> more content %2%</p>');

    }//end testApplingStrikethroughToContentUsingKeywordClassNames()


    /**
     * Test that you can apply subscript to content that has classes applied using keywords.
     *
     * @return void
     */
    public function testApplingSubscriptToContentUsingKeywordClassNames()
    {
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <sub><span class="((prop:className))">%1%</span></sub> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <sub><span class="replaced-className" data-viper-class="((prop:className))">%1%</span></sub> more content %2%</p>');

        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <span class="((prop:className))">%1%</span> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <span class="replaced-className" data-viper-class="((prop:className))">%1%</span> more content %2%</p>');

    }//end testApplingSubscriptToContentUsingKeywordClassNames()


    /**
     * Test that you can apply superscript to content that has classes applied using keywords.
     *
     * @return void
     */
    public function testApplingSuperscriptToContentUsingKeywordClassNames()
    {
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <sup><span class="((prop:className))">%1%</span></sup> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <sup><span class="replaced-className" data-viper-class="((prop:className))">%1%</span></sup> more content %2%</p>');

        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'));
        $this->assertHTMLMatch('<p>Test content <span class="((prop:className))">%1%</span> more content %2%</p>');
        $this->assertRawHTMLMatch('<p>Test content <span class="replaced-className" data-viper-class="((prop:className))">%1%</span> more content %2%</p>');

    }//end testApplingSuperscriptToContentUsingKeywordClassNames()


    /**
     * Test using the remove format icon for content that has classes applied to it.
     *
     * @return void
     */
    public function testRemoveFormatAndClasses()
    {

    }//end testRemoveFormatAndClasses()

}
