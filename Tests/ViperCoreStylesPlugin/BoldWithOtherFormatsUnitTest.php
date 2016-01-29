<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_BoldWithOtherFormatsUnitTest extends AbstractViperUnitTest
{

    /**
     * Test format combination of bold then italic.
     *
     * @return void
     */
    public function testBoldThenItalic()
    {
        // Test applying bold and italic using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing bold and italic using the top toolbar
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying bold and italic using the top toolbar
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong>%1%</strong></em></p>');

        // Test applying bold and italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing bold and italic using keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying bold and italic using keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');
        
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong>%1%</strong></em></p>');

    }//end testBoldThenItalic()


    /**
     * Test format combination of bold then subscript.
     *
     * @return void
     */
    public function testBoldThenSubscript()
    {
        // Test applying bold and subscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing bold and subscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying bold and subscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><strong>%1%</strong></sub></p>');

    }//end testBoldThenSubscript()


    /**
     * Test format combination of bold then superscript.
     *
     * @return void
     */
    public function testBoldThenSuperscript()
    {
        // Test applying bold and superscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing bold and superscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying bold and superscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><strong>%1%</strong></sup></p>');

    }//end testBoldThenSuperscript()


    /**
     * Test format combination of bold then strikethrough.
     *
     * @return void
     */
    public function testBoldThenStrikethrough()
    {
        // Test applying bold and strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong>%1%</strong></del></p>');

    }//end testBoldThenStrikethrough()


    /**
     * Test format combination of bold then italic then subscript.
     *
     * @return void
     */
    public function testBoldThenItalicThenSubscript()
    {
        // Test applying bold and italic then subscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing bold and italic then subscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying bold and italic then subscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><em><strong>%1%</strong></em></sub></p>');

    }//end testBoldThenItalicThenSubscript()


    /**
     * Test format combination of bold then italic then superscript.
     *
     * @return void
     */
    public function testBoldThenItalicThenSuperscript()
    {
        // Test applying bold and italic then superscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing bold and italic then superscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying bold and italic then superscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><em><strong>%1%</strong></em></sup></p>');

    }//end testBoldThenItalicThenSuperscript()


    /**
     * Test format combination of bold then italic then strikethrough.
     *
     * @return void
     */
    public function testBoldThenItalicThenStrikethrough()
    {
        // Test applying bold and italic then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and italic then strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and italic then strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><strong>%1%</strong></em></del></p>');

    }//end testBoldThenItalicThenStrikethrough()


    /**
     * Test format combination of bold then subscript then italic.
     *
     * @return void
     */
    public function testBoldThenSubscriptThenItalic()
    {
        // Test applying bold and subscript then italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing bold and subscript then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying bold and subscript then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><sub><strong>%1%</strong></sub></em></p>');

    }//end testBoldThenSubscriptThenItalic()


    /**
     * Test format combination of bold then subscript then strikethrough.
     *
     * @return void
     */
    public function testBoldThenSubscriptThenStrikethrough()
    {
        // Test applying bold and subscript then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and subscript then strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying bold and subscript then strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sub><strong>%1%</strong></sub></del></p>');

    }//end testBoldThenSubscriptThenStrikethrough()


    /**
     * Test format combination of bold then superscript then italic.
     *
     * @return void
     */
    public function testBoldThenSuperscriptThenItalic()
    {
        // Test applying bold and superscript then italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing bold and superscript then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying bold and superscript then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><sup><strong>%1%</strong></sup></em></p>');

    }//end testBoldThenSuperscriptThenItalic()


    /**
     * Test format combination of bold then superscript then strikethrough.
     *
     * @return void
     */
    public function testBoldThenSuperscriptThenStrikethrough()
    {
        // Test applying bold and superscript then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and superscript then strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying bold and superscript then strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sup><strong>%1%</strong></sup></del></p>');

    }//end testBoldThenSuperscriptThenStrikethrough()


    /**
     * Test format combination of bold then strikethrough then italic.
     *
     * @return void
     */
    public function testBoldThenStrikethroughThenItalic()
    {
        // Test applying bold and strikethrough then italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing bold and strikethrough then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying bold and strikethrough then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><strong>%1%</strong></del></em></p>');

    }//end testBoldThenStrikethroughThenItalic()


    /**
     * Test format combination of bold then strikethrough then subscript.
     *
     * @return void
     */
    public function testBoldThenStrikethroughThenSubscript()
    {
        // Test applying bold and strikethrough then subscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing bold and strikethrough then subscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying bold and strikethrough then subscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><del><strong>%1%</strong></del></sub></p>');

    }//end testBoldThenStrikethroughThenSubscript()


    /**
     * Test format combination of bold then strikethrough then superscript.
     *
     * @return void
     */
    public function testBoldThenStrikethroughThenSuperscript()
    {
        // Test applying bold and strikethrough then superscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing bold and strikethrough then superscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying bold and strikethrough then superscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><del><strong>%1%</strong></del></sup></p>');

    }//end testBoldThenStrikethroughThenSuperscript()


    /**
     * Test format combination of bold then italic then subscript then strikethrough.
     *
     * @return void
     */
    public function testBoldThenItalicThenSubscriptThenStrikethrough()
    {
        // Test applying bold and italic then subscript then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and italic then subscript then strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and italic then subscript then strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sub><em><strong>%1%</strong></em></sub></del></p>');

    }//end testBoldThenItalicThenSubscriptThenStrikethrough()


    /**
     * Test format combination of bold then italic then superscript then strikethrough.
     *
     * @return void
     */
    public function testBoldThenItalicThenSuperscriptThenStrikethrough()
    {
        // Test applying bold and italic then superscript then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and italic then superscript then strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and italic then superscript then strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sup><em><strong>%1%</strong></em></sup></del></p>');

    }//end testBoldThenItalicThenSuperscriptThenStrikethrough()


    /**
     * Test format combination of bold then italic then strikethrough then subscript.
     *
     * @return void
     */
    public function testBoldThenItalicThenStrikethroughThenSubscript()
    {
        // Test applying bold and italic then strikethrough then subscript
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing bold and italic then strikethrough then subscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying bold and italic then strikethrough then subscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><del><em><strong>%1%</strong></em></del></sub></p>');

    }//end testBoldThenItalicThenStrikethroughThenSubscript()


    /**
     * Test format combination of bold then italic then strikethrough then superscript.
     *
     * @return void
     */
    public function testBoldThenItalicThenStrikethroughThenSuperscript()
    {
        // Test applying bold and italic then strikethrough then superscript
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing bold and italic then strikethrough then superscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying bold and italic then strikethrough then superscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><del><em><strong>%1%</strong></em></del></sup></p>');

    }//end testBoldThenItalicThenStrikethroughThenSuperscript()


    /**
     * Test format combination of bold then subscript then italic then strikethrough.
     *
     * @return void
     */
    public function testBoldThenSubscriptThenItalicThenStrikethrough()
    {
        // Test applying bold and subscript then italic then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and subscript then italic then strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and subscript then italic then strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><sub><strong>%1%</strong></sub></em></del></p>');

    }//end testBoldThenSubscriptThenItalicThenStrikethrough()


    /**
     * Test format combination of bold then subscript then strikethrough then italic.
     *
     * @return void
     */
    public function testBoldThenSubscriptThenStrikethroughThenItalic()
    {
        // Test applying bold and subscript then strikethrough then italic
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing bold and subscript then strikethrough then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying bold and subscript then strikethrough then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><sub><strong>%1%</strong></sub></del></em></p>');

    }//end testBoldThenSubscriptThenStrikethroughThenItalic()


    /**
     * Test format combination of bold then superscript then italic then strikethrough.
     *
     * @return void
     */
    public function testBoldThenSuperscriptThenItalicThenStrikethrough()
    {
        // Test applying bold and superscript then italic then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and superscript then italic then strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and superscript then italic then strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><sup><strong>%1%</strong></sup></em></del></p>');

    }//end testBoldThenSuperscriptThenItalicThenStrikethrough()


    /**
     * Test format combination of bold then superscript then strikethrough then italic.
     *
     * @return void
     */
    public function testBoldThenSuperscriptThenStrikethroughThenItalic()
    {
        // Test applying bold and superscript then strikethrough then italic
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing bold and superscript then strikethrough then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying bold and superscript then strikethrough then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><sup><strong>%1%</strong></sup></del></em></p>');

    }//end testBoldThenSuperscriptThenStrikethroughThenItalic()


    /**
     * Test format combination of bold then strikethrough then italic then subscript.
     *
     * @return void
     */
    public function testBoldThenStrikethroughThenItalicThenSubscript()
    {
        // Test applying bold and strikethrough then italic then subscript
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing bold and strikethrough then italic then subscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying bold and strikethrough then italic then subscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><em><del><strong>%1%</strong></del></em></sub></p>');

    }//end testBoldThenStrikethroughThenItalicThenSubscript()


    /**
     * Test format combination of bold then strikethrough then italic then superscript.
     *
     * @return void
     */
    public function testBoldThenStrikethroughThenItalicThenSuperscript()
    {
        // Test applying bold and strikethrough then italic then superscript
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing bold and strikethrough then italic then superscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying bold and strikethrough then italic then superscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><em><del><strong>%1%</strong></del></em></sup></p>');

    }//end testBoldThenStrikethroughThenItalicThenSuperscript()


    /**
     * Test format combination of bold then strikethrough then subscript then italic.
     *
     * @return void
     */
    public function testBoldThenStrikethroughThenSubscriptThenItalic()
    {
        // Test applying bold and strikethrough then subscript then italic
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing bold and strikethrough then subscript then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying bold and strikethrough then subscript then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><sub><del><strong>%1%</strong></del></sub></em></p>');

    }//end testBoldThenStrikethroughThenSubscriptThenItalic()


    /**
     * Test format combination of bold then strikethrough then superscript then italic.
     *
     * @return void
     */
    public function testBoldStrikethroughThenSuperscriptThenItalic()
    {
        // Test applying bold and strikethrough then superscript then italic
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing bold and strikethrough then superscript then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying bold and strikethrough then superscript then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><sup><del><strong>%1%</strong></del></sup></em></p>');

    }//end testBoldStrikethroughThenSuperscriptThenItalic()

}//end class

?>