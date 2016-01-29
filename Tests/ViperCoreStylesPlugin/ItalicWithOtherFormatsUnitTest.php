<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_ItalicWithOtherFormatsUnitTest extends AbstractViperUnitTest
{

	/**
     * Test format combination of italic then bold.
     *
     * @return void
     */
    public function testItalicThenBold()
    {
        // Test applying italic and bold using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing italic and bold using the top toolbar
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying italic and bold using the top toolbar
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em>%1%</em></strong></p>');

        // Test applying italic and bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->sikuli->keyDown('Key.CMD + b');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing italic and bold using keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + i');
        $this->sikuli->keyDown('Key.CMD + b');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying italic and bold using keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + i');
        $this->sikuli->keyDown('Key.CMD + b');
        
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em>%1%</em></strong></p>');

    }//end testItalicThenBold()


    /**
     * Test format combination of italic then subscript.
     *
     * @return void
     */
    public function testItalicThenSubscript()
    {
        // Test applying italic and subscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing italic and subscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying italic and subscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><em>%1%</em></sub></p>');

    }//end testItalicThenSubscript()


    /**
     * Test format combination of italic then superscript.
     *
     * @return void
     */
    public function testItalicThenSuperscript()
    {
        // Test applying italic and superscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing italic and superscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying italic and superscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><em>%1%</em></sup></p>');

    }//end testItalicThenSuperscript()


    /**
     * Test format combination of italic then strikethrough.
     *
     * @return void
     */
    public function testItalicThenStrikethrough()
    {
        // Test applying italic and strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and strikethrough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and strikethrough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em>%1%</em></del></p>');

    }//end testItalicThenStrikethrough()


    /**
     * Test format combination of italic then bold then subscript.
     *
     * @return void
     */
    public function testItalicThenBoldThenSubscript()
    {
        // Test applying italic and bold then subscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing italic and bold then subscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying italic and bold then subscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><strong><em>%1%</em></strong></sub></p>');

    }//end testItalicThenBoldThenSubscript()


    /**
     * Test format combination of italic then bold then superscript.
     *
     * @return void
     */
    public function testItalicThenBoldThenSuperscript()
    {
        // Test applying italic and bold then superscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing italic and bold then superscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying italic and bold then superscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><strong><em>%1%</em></strong></sup></p>');

    }//end testItalicThenBoldThenSuperscript()


    /**
     * Test format combination of italic then bold then strikethrough.
     *
     * @return void
     */
    public function testItalicThenBoldThenStrikethrough()
    {
        // Test applying italic and bold then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and bold then strikethrough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and bold then strikethrough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><em>%1%</em></strong></del></p>');

    }//end testItalicThenBoldThenStrikethrough()


    /**
     * Test format combination of italic then subscript then bold.
     *
     * @return void
     */
    public function testItalicThenSubscriptThenBold()
    {
        // Test applying italic and subscript then bold
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing italic and subscript then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying italic and subscript then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sub><em>%1%</em></sub></strong></p>');

    }//end testItalicThenSubscriptThenBold()


    /**
     * Test format combination of italic then subscript then strikethrough.
     *
     * @return void
     */
    public function testItalicThenSubscriptThenStrikethrough()
    {
        // Test applying italic and subscript then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and subscript then strikethrough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying italic and subscript then strikethrough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sub><em>%1%</em></sub></del></p>');

    }//end testItalicThenSubscriptThenStrikethrough()


    /**
     * Test format combination of italic then superscript then bold.
     *
     * @return void
     */
    public function testItalicThenSuperscriptThenBold()
    {
        // Test applying italic and superscript then bold
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing italic and superscript then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying italic and superscript then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sup><em>%1%</em></sup></strong></p>');

    }//end testItalicThenSuperscriptThenBold()


    /**
     * Test format combination of italic then superscript then strikethrough.
     *
     * @return void
     */
    public function testItalicThenSuperscriptThenStrikethrough()
    {
        // Test applying italic and superscript then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and superscript then strikethrough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying italic and superscript then strikethrough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sup><em>%1%</em></sup></del></p>');

    }//end testItalicThenSuperscriptThenStrikethrough()


    /**
     * Test format combination of italic then strikethrough then bold.
     *
     * @return void
     */
    public function testItalicThenStrikethroughThenBold()
    {
        // Test applying italic and strikethrough then bold
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing italic and strikethrough then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying italic and strikethrough then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><em>%1%</em></del></strong></p>');

    }//end testItalicThenStrikethroughThenBold()


    /**
     * Test format combination of italic then strikethrough then subscript.
     *
     * @return void
     */
    public function testItalicThenStrikethroughThenSubscript()
    {
        // Test applying italic and strikethrough then subscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing italic and strikethrough then subscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying italic and strikethrough then subscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><del><em>%1%</em></del></sub></p>');

    }//end testItalicThenStrikethroughThenSubscript()


    /**
     * Test format combination of italic then strikethrough then superscript.
     *
     * @return void
     */
    public function testItalicThenStrikethroughThenSuperscript()
    {
        // Test applying italic and strikethrough then superscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing italic and strikethrough then superscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying italic and strikethrough then superscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><del><em>%1%</em></del></sup></p>');

    }//end testItalicThenStrikethroughThenSuperscript()


    /**
     * Test format combination of italic then bold then subscript then strikethrough.
     *
     * @return void
     */
    public function testItalicThenBoldThenSubscriptThenStrikethrough()
    {
        // Test applying italic and bold then subscript then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and bold then subscript then strikethrough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and bold then subscript then strikethrough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sub><strong><em>%1%</em></strong></sub></del></p>');

    }//end testItalicThenBoldThenSubscriptThenStrikethrough()


    /**
     * Test format combination of italic then bold then superscript then strikethrough.
     *
     * @return void
     */
    public function testItalicThenBoldThenSuperscriptThenStrikethrough()
    {
        // Test applying italic and bold then superscript then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and bold then superscript then strikethrough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and bold then superscript then strikethrough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sup><strong><em>%1%</em></strong></sup></del></p>');

    }//end testItalicThenBoldThenSuperscriptThenStrikethrough()


    /**
     * Test format combination of italic then bold then strikethrough then subscript.
     *
     * @return void
     */
    public function testItalicThenBoldThenStrikethroughThenSubscript()
    {
        // Test applying italic and bold then strikethrough then subscript
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing italic and bold then strikethrough then subscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying italic and bold then strikethrough then subscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><del><strong><em>%1%</em></strong></del></sub></p>');

    }//end testItalicThenBoldThenStrikethroughThenSubscript()


    /**
     * Test format combination of italic then bold then strikethrough then superscript.
     *
     * @return void
     */
    public function testItalicThenBoldThenStrikethroughThenSuperscript()
    {
        // Test applying italic and bold then strikethrough then superscript
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing italic and bold then strikethrough then superscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying italic and bold then strikethrough then superscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><del><strong><em>%1%</em></strong></del></sup></p>');

    }//end testItalicThenBoldThenStrikethroughThenSuperscript()


    /**
     * Test format combination of italic then subscript then bold then strikethrough.
     *
     * @return void
     */
    public function testItalicThenSubscriptThenBoldThenStrikethrough()
    {
        // Test applying italic and subscript then bold then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and subscript then bold then strikethrough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and subscript then bold then strikethrough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><sub><em>%1%</em></sub></strong></del></p>');

    }//end testItalicThenSubscriptThenBoldThenStrikethrough()


    /**
     * Test format combination of italic then subscript then strikethrough then bold.
     *
     * @return void
     */
    public function testItalicThenSubscriptThenStrikethroughThenBold()
    {
        // Test applying italic and subscript then strikethrough then bold
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing italic and subscript then strikethrough then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying italic and subscript then strikethrough then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><sub><em>%1%</em></sub></del></strong></p>');

    }//end testItalicThenSubscriptThenStrikethroughThenBold()


    /**
     * Test format combination of italic then superscript then bold then strikethrough.
     *
     * @return void
     */
    public function testItalicThenSuperscriptThenBoldThenStrikethrough()
    {
        // Test applying italic and superscript then bold then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and superscript then bold then strikethrough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and superscript then bold then strikethrough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><sup><em>%1%</em></sup></strong></del></p>');

    }//end testItalicThenSuperscriptThenBoldThenStrikethrough()


    /**
     * Test format combination of italic then superscript then strikethrough then bold.
     *
     * @return void
     */
    public function testItalicThenSuperscriptThenStrikethroughThenBold()
    {
        // Test applying italic and superscript then strikethrough then bold
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing italic and superscript then strikethrough then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying italic and superscript then strikethrough then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><sup><em>%1%</em></sup></del></strong></p>');

    }//end testItalicThenSuperscriptThenStrikethroughThenBold()


    /**
     * Test format combination of italic then strikethrough then bold then subscript.
     *
     * @return void
     */
    public function testItalicThenStrikethroughThenBoldThenSubscript()
    {
        // Test applying italic and strikethrough then bold then subscript
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing italic and strikethrough then bold then subscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying italic and strikethrough then bold then subscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><strong><del><em>%1%</em></del></strong></sub></p>');

    }//end testItalicThenStrikethroughThenBoldThenSubscript()


    /**
     * Test format combination of italic then strikethrough then bold then superscript.
     *
     * @return void
     */
    public function testItalicThenStrikethroughThenBoldThenSuperscript()
    {
        // Test applying italic and strikethrough then bold then superscript
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing italic and strikethrough then bold then superscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying italic and strikethrough then bold then superscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><strong><del><em>%1%</em></del></strong></sup></p>');

    }//end testItalicThenStrikethroughThenBoldThenSuperscript()


    /**
     * Test format combination of italic then strikethrough then subscript then bold.
     *
     * @return void
     */
    public function testItalicThenStrikethroughThenSubscriptThenBold()
    {
        // Test applying italic and strikethrough then subscript then bold
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing italic and strikethrough then subscript then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying italic and strikethrough then subscript then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sub><del><em>%1%</em></del></sub></strong></p>');

    }//end testItalicThenStrikethroughThenSubscriptThenBold()


    /**
     * Test format combination of italic then strikethrough then superscript then bold.
     *
     * @return void
     */
    public function testItalicThenStrikethroughThenSuperscriptThenBold()
    {
        // Test applying italic and strikethrough then superscript then bold
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing italic and strikethrough then superscript then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying italic and strikethrough then superscript then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sup><del><em>%1%</em></del></sup></strong></p>');

    }//end testItalicThenStrikethroughThenSuperscriptThenBold()

}//end class

?>