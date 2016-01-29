<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_CoreFormatsUnitTest extends AbstractViperUnitTest
{    
    /**
     * Test that style can be applied to the selection.
     *
     * @return void
     */
    public function testAllStyles()
    {
        $this->useTest(2);

        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold');
        $this->clickTopToolbarButton('italic');
        $this->clickTopToolbarButton('subscript');
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p><del><sub><em><strong>%1%</strong></em></sub></del> %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'disabled'), 'Superscript icon should be disabled');

        // Remove sub and apply super.
        $this->clickTopToolbarButton('subscript', 'active');
        sleep(1);
        $this->assertHTMLMatch('<p><del><em><strong>%1%</strong></em></del> %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<p><sup><del><em><strong>%1%</strong></em></del></sup> %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');

        // Remove super.
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<p><del><em><strong>%1%</strong></em></del> %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');

        // Remove strike.
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<p><em><strong>%1%</strong></em> %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');

        //Remove italics
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p><strong>%1%</strong> %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');

        //Remove bold
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');

    }//end testAllStyles()

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


    /**
     * Test format combination of subscript then bold.
     *
     * @return void
     */
    public function testSubscriptThenBold()
    {
        // Test applying subscript and bold using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing subscript and bold using the top toolbar
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying subscript and bold using the top toolbar
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sub>%1%</sub></strong></p>');

    }//end testSubscriptThenBold()


    /**
     * Test format combination of subscript then italic.
     *
     * @return void
     */
    public function testSubscriptThenItalic()
    {
        // Test applying subscript and italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing subscript and italic
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying subscript and italic
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><sub>%1%</sub></em></p>');

    }//end testSubscriptThenItalic()


    /**
     * Test format combination of subscript then strikethrough.
     *
     * @return void
     */
    public function testSubscriptThenStrikethrough()
    {
        // Test applying subscript and strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing subscript and strikethrough
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying subscript and strikethrough
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sub>%1%</sub></del></p>');

    }//end testSubscriptThenStrikethrough()


    /**
     * Test format combination of subscript then bold then italic.
     *
     * @return void
     */
    public function testSubscriptThenBoldThenItalic()
    {
        // Test applying subscript and bold then italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing subscript and bold then italic
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying subscript and bold then italic
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><sub>%1%</sub></strong></em></p>');

    }//end testSubscriptThenBoldThenItalic()


    /**
     * Test format combination of subscript then bold then strikethrough.
     *
     * @return void
     */
    public function testSubscriptThenBoldThenStrikethrough()
    {
        // Test applying subscript and bold then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing subscript and bold then strikethrough
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying subscript and bold then strikethrough
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><sub>%1%</sub></strong></del></p>');

    }//end testSubscriptThenBoldThenStrikethrough()


    /**
     * Test format combination of subscript then italic then bold.
     *
     * @return void
     */
    public function testSubscriptThenItalicThenBold()
    {
        // Test applying subscript and italic then bold
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing subscript and italic then bold
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying subscript and italic then bold
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><sub>%1%</sub></em></strong></p>');

    }//end testSubscriptThenItalicThenBold()


    /**
     * Test format combination of subscript then italic then strikethrough.
     *
     * @return void
     */
    public function testSubscriptThenItalicThenStrikethrough()
    {
        // Test applying subscript and italic then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing subscript and italic then strikethrough
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying subscript and italic then strikethrough
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><sub>%1%</sub></em></del></p>');

    }//end testSubscriptThenItalicThenStrikethrough()


    /**
     * Test format combination of subscript then strikethrough then bold.
     *
     * @return void
     */
    public function testSubscriptThenStrikethroughThenBold()
    {
        // Test applying subscript and strikethrough then bold
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing subscript and strikethrough then bold
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying subscript and strikethrough then bold
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><sub>%1%</sub></del></strong></p>');

    }//end testSubscriptThenStrikethroughThenBold()


    /**
     * Test format combination of subscript then strikethrough then italic.
     *
     * @return void
     */
    public function testSubscriptThenStrikethroughThenItalic()
    {
        // Test applying subscript and strikethrough then italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing subscript and strikethrough then italic
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying subscript and strikethrough then italic
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><sub>%1%</sub></del></em></p>');

    }//end testSubscriptThenStrikethroughThenItalic()


    /**
     * Test format combination of subscript then bold then italic then strikethrough.
     *
     * @return void
     */
    public function testSubscriptThenBoldThenItalicThenStrikethrough()
    {
        // Test applying subscript and bold then italic then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing subscript and bold then italic then strikethrough
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying subscript and bold then italic then strikethrough
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><strong><sub>%1%</sub></strong></em></del></p>');

    }//end testSubscriptThenBoldThenItalicThenStrikethrough()


    /**
     * Test format combination of subscript then bold then strikethrough then italic.
     *
     * @return void
     */
    public function testSubscriptThenBoldThenStrikethroughThenItalic()
    {
        // Test applying subscript and bold then strikethrough then italic
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing subscript and bold then strikethrough then italic
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying subscript and bold then strikethrough then italic
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><strong><sub>%1%</sub></strong></del></em></p>');

    }//end testSubscriptThenBoldThenStrikethroughThenItalic()


    /**
     * Test format combination of subscript then italic then bold then strikethrough.
     *
     * @return void
     */
    public function testSubscriptThenItalicThenBoldThenStrikethrough()
    {
        // Test applying subscript and italic then bold then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing subscript and italic then bold then strikethrough
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying subscript and italic then bold then strikethrough
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><em><sub>%1%</sub></em></strong></del></p>');

    }//end testSubscriptThenItalicThenBoldThenStrikethrough()


    /**
     * Test format combination of subscript then italic then strikethrough then bold.
     *
     * @return void
     */
    public function testSubscriptThenItalicThenStrikethroughThenBold()
    {
        // Test applying subscript and italic then strikethrough then bold
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing subscript and italic then strikethrough then bold
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying subscript and italic then strikethrough then bold
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><em><sub>%1%</sub></em></del></strong></p>');

    }//end testSubscriptThenItalicThenStrikethroughThenBold()


    /**
     * Test format combination of subscript then strikethrough then bold then italic.
     *
     * @return void
     */
    public function testSubscriptThenStrikethroughThenBoldThenItalic()
    {
        // Test applying subscript and strikethrough then bold then italic
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing subscript and strikethrough then bold then italic
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying subscript and strikethrough then bold then italic
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><del><sub>%1%</sub></del></strong></em></p>');

    }//end testSubscriptThenStrikethroughThenBoldThenItalic()


    /**
     * Test format combination of subscript then strikethrough then italic then bold.
     *
     * @return void
     */
    public function testSubscriptThenStrikethroughThenItalicThenBold()
    {
        // Test applying subscript and strikethrough then italic then bold
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing subscript and strikethrough then italic then bold
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying subscript and strikethrough then italic then bold
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><del><sub>%1%</sub></del></em></strong></p>');

    }//end testSubscriptThenStrikethroughThenItalicThenBold()


    /**
     * Test format combination of superscript then bold.
     *
     * @return void
     */
    public function testSuperscriptThenBold()
    {
        // Test applying superscript and bold using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing superscript and bold using the top toolbar
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying superscript and bold using the top toolbar
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sup>%1%</sup></strong></p>');

    }//end testSuperscriptThenBold()


    /**
     * Test format combination of superscript then italic.
     *
     * @return void
     */
    public function testSuperscriptThenItalic()
    {
        // Test applying superscript and italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing superscript and italic
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying superscript and italic
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><sup>%1%</sup></em></p>');

    }//end testSuperscriptThenItalic()


    /**
     * Test format combination of superscript then strikethrough.
     *
     * @return void
     */
    public function testSuperscriptThenStrikethrough()
    {
        // Test applying superscript and strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing superscript and strikethrough
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying superscript and strikethrough
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sup>%1%</sup></del></p>');

    }//end testSuperscriptThenStrikethrough()


    /**
     * Test format combination of superscript then bold then italic.
     *
     * @return void
     */
    public function testSuperscriptThenBoldThenItalic()
    {
        // Test applying superscript and bold then italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing superscript and bold then italic
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying superscript and bold then italic
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><sup>%1%</sup></strong></em></p>');

    }//end testSuperscriptThenBoldThenItalic()


    /**
     * Test format combination of superscript then bold then strikethrough.
     *
     * @return void
     */
    public function testSuperscriptThenBoldThenStrikethrough()
    {
        // Test applying superscript and bold then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing superscript and bold then strikethrough
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying superscript and bold then strikethrough
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><sup>%1%</sup></strong></del></p>');

    }//end testSuperscriptThenBoldThenStrikethrough()


    /**
     * Test format combination of superscript then italic then bold.
     *
     * @return void
     */
    public function testSuperscriptThenItalicThenBold()
    {
        // Test applying superscript and italic then bold
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing superscript and italic then bold
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying superscript and italic then bold
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><sup>%1%</sup></em></strong></p>');

    }//end testSuperscriptThenItalicThenBold()


    /**
     * Test format combination of superscript then italic then strikethrough.
     *
     * @return void
     */
    public function testSuperscriptThenItalicThenStrikethrough()
    {
        // Test applying superscript and italic then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing superscript and italic then strikethrough
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying superscript and italic then strikethrough
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><sup>%1%</sup></em></del></p>');

    }//end testSuperscriptThenItalicThenStrikethrough()


    /**
     * Test format combination of superscript then strikethrough then bold.
     *
     * @return void
     */
    public function testSuperscriptThenStrikethroughThenBold()
    {
        // Test applying superscript and strikethrough then bold
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing superscript and strikethrough then bold
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying superscript and strikethrough then bold
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><sup>%1%</sup></del></strong></p>');

    }//end testSuperscriptThenStrikethroughThenBold()


    /**
     * Test format combination of superscript then strikethrough then italic.
     *
     * @return void
     */
    public function testSuperscriptThenStrikethroughThenItalic()
    {
        // Test applying superscript and strikethrough then italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing superscript and strikethrough then italic
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying superscript and strikethrough then italic
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><sup>%1%</sup></del></em></p>');

    }//end testSuperscriptThenStrikethroughThenItalic()


    /**
     * Test format combination of superscript then bold then italic then strikethrough.
     *
     * @return void
     */
    public function testSuperscriptThenBoldThenItalicThenStrikethrough()
    {
        // Test applying superscript and bold then italic then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing superscript and bold then italic then strikethrough
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying superscript and bold then italic then strikethrough
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><strong><sup>%1%</sup></strong></em></del></p>');

    }//end testSuperscriptThenBoldThenItalicThenStrikethrough()


    /**
     * Test format combination of superscript then bold then strikethrough then italic.
     *
     * @return void
     */
    public function testSuperscriptThenBoldThenStrikethroughThenItalic()
    {
        // Test applying superscript and bold then strikethrough then italic
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing superscript and bold then strikethrough then italic
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying superscript and bold then strikethrough then italic
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><strong><sup>%1%</sup></strong></del></em></p>');

    }//end testSuperscriptThenBoldThenStrikethroughThenItalic()


    /**
     * Test format combination of superscript then italic then bold then strikethrough.
     *
     * @return void
     */
    public function testSuperscriptThenItalicThenBoldThenStrikethrough()
    {
        // Test applying superscript and italic then bold then strikethrough
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing superscript and italic then bold then strikethrough
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying superscript and italic then bold then strikethrough
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><em><sup>%1%</sup></em></strong></del></p>');

    }//end testSuperscriptThenItalicThenBoldThenStrikethrough()


    /**
     * Test format combination of superscript then italic then strikethrough then bold.
     *
     * @return void
     */
    public function testSuperscriptThenItalicThenStrikethroughThenBold()
    {
        // Test applying superscript and italic then strikethrough then bold
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing superscript and italic then strikethrough then bold
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying superscript and italic then strikethrough then bold
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><em><sup>%1%</sup></em></del></strong></p>');

    }//end testSuperscriptThenItalicThenStrikethroughThenBold()


    /**
     * Test format combination of superscript then strikethrough then bold then italic.
     *
     * @return void
     */
    public function testSuperscriptThenStrikethroughThenBoldThenItalic()
    {
        // Test applying superscript and strikethrough then bold then italic
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing superscript and strikethrough then bold then italic
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying superscript and strikethrough then bold then italic
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><del><sup>%1%</sup></del></strong></em></p>');

    }//end testSuperscriptThenStrikethroughThenBoldThenItalic()


    /**
     * Test format combination of superscript then strikethrough then italic then bold.
     *
     * @return void
     */
    public function testSuperscriptThenStrikethroughThenItalicThenBold()
    {
        // Test applying superscript and strikethrough then italic then bold
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing superscript and strikethrough then italic then bold
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying superscript and strikethrough then italic then bold
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><del><sup>%1%</sup></del></em></strong></p>');

    }//end testSuperscriptThenStrikethroughThenItalicThenBold()


    /**
     * Test format combination of strikethrough then bold.
     *
     * @return void
     */
    public function testStrikethroughThenBold()
    {
        // Test applying strikethrough and bold
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del>%1%</del></strong></p>');

    }//end testStrikethroughThenBold()


    /**
     * Test format combination of strikethrough then italic.
     *
     * @return void
     */
    public function testStrikethroughThenItalic()
    {
        // Test applying strikethrough and italic using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing strikethrough and italic using the top toolbar
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic using the top toolbar
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><del>%1%</del></em></p>');

    }//end testStrikethroughThenItalic()


    /**
     * Test format combination of strikethrough then subscript.
     *
     * @return void
     */
    public function testStrikethroughThenSubscript()
    {
        // Test applying strikethrough and subscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing strikethrough and subscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and subscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><del>%1%</del></sub></p>');

    }//end testStrikethroughThenSubscript()


    /**
     * Test format combination of strikethrough then superscript.
     *
     * @return void
     */
    public function testStrikethroughThenSuperscript()
    {
        // Test applying strikethrough and superscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing strikethrough and superscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and superscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><del>%1%</del></sup></p>');

    }//end testStrikethroughThenSuperscript()


    /**
     * Test format combination of strikethrough then italic then subscript.
     *
     * @return void
     */
    public function testStrikethroughThenItalicThenSubscript()
    {
        // Test applying strikethrough and italic then subscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing strikethrough and italic then subscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then subscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><em><del>%1%</del></em></sub></p>');

    }//end testStrikethroughThenItalicThenSubscript()


    /**
     * Test format combination of strikethrough then italic then superscript.
     *
     * @return void
     */
    public function testStrikethroughThenItalicThenSuperscript()
    {
        // Test applying strikethrough and italic then superscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing strikethrough and italic then superscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then superscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><em><del>%1%</del></em></sup></p>');

    }//end testStrikethroughThenItalicThenSuperscript()


    /**
     * Test format combination of strikethrough then italic then bold.
     *
     * @return void
     */
    public function testStrikethroughThenItalicThenBold()
    {
        // Test applying strikethrough and italic then bold
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and italic then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><del>%1%</del></em></strong></p>');

    }//end testStrikethroughThenItalicThenBold()


    /**
     * Test format combination of strikethrough then subscript then italic.
     *
     * @return void
     */
    public function testStrikethroughThenSubscriptThenItalic()
    {
        // Test applying strikethrough and subscript then italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing strikethrough and subscript then italic
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying strikethrough and subscript then italic
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><sub><del>%1%</del></sub></em></p>');

    }//end testStrikethroughThenSubscriptThenItalic()


    /**
     * Test format combination of strikethrough then subscript then bold.
     *
     * @return void
     */
    public function testStrikethroughThenSubscriptThenBold()
    {
        // Test applying strikethrough and subscript then bold
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and subscript then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying strikethrough and subscript then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sub><del>%1%</del></sub></strong></p>');

    }//end testStrikethroughThenSubscriptThenBold()


    /**
     * Test format combination of strikethrough then superscript then italic.
     *
     * @return void
     */
    public function testStrikethroughThenSuperscriptThenItalic()
    {
        // Test applying strikethrough and superscript then italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing strikethrough and superscript then italic
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying strikethrough and superscript then italic
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><sup><del>%1%</del></sup></em></p>');

    }//end testStrikethroughThenSuperscriptThenItalic()


    /**
     * Test format combination of strikethrough then superscript then bold.
     *
     * @return void
     */
    public function testStrikethroughThenSuperscriptThenBold()
    {
        // Test applying strikethrough and superscript then bold
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and superscript then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying strikethrough and superscript then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sup><del>%1%</del></sup></strong></p>');

    }//end testStrikethroughThenSuperscriptThenBold()


    /**
     * Test format combination of strikethrough then bold then italic.
     *
     * @return void
     */
    public function testStrikethroughThenBoldThenItalic()
    {
        // Test applying strikethrough and bold then italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing strikethrough and bold then italic
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying strikethrough and bold then italic
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><del>%1%</del></strong></em></p>');

    }//end testStrikethroughThenBoldThenItalic()


    /**
     * Test format combination of strikethrough then bold then subscript.
     *
     * @return void
     */
    public function testStrikethroughThenBoldThenSubscript()
    {
        // Test applying strikethrough and bold then subscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing strikethrough and bold then subscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and bold then subscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><strong><del>%1%</del></strong></sub></p>');

    }//end testStrikethroughThenBoldThenSubscript()


    /**
     * Test format combination of strikethrough then bold then superscript.
     *
     * @return void
     */
    public function testStrikethroughThenBoldThenSuperscript()
    {
        // Test applying strikethrough and bold then superscript
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing strikethrough and bold then superscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and bold then superscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><strong><del>%1%</del></strong></sup></p>');

    }//end testStrikethroughThenBoldThenSuperscript()


    /**
     * Test format combination of strikethrough then italic then subscript then bold.
     *
     * @return void
     */
    public function testStrikethroughThenItalicThenSubscriptThenBold()
    {
        // Test applying strikethrough and italic then subscript then bold
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and italic then subscript then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then subscript then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sub><em><del>%1%</del></em></sub></strong></p>');

    }//end testStrikethroughThenItalicThenSubscriptThenBold()


    /**
     * Test format combination of strikethrough then italic then superscript then bold.
     *
     * @return void
     */
    public function testStrikethroughThenItalicThenSuperscriptThenBold()
    {
        // Test applying strikethrough and italic then superscript then bold
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and italic then superscript then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then superscript then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sup><em><del>%1%</del></em></sup></strong></p>');

    }//end testStrikethroughThenItalicThenSuperscriptThenBold()


    /**
     * Test format combination of strikethrough then italic then bold then subscript.
     *
     * @return void
     */
    public function testStrikethroughThenItalicThenBoldThenSubscript()
    {
        // Test applying strikethrough and italic then bold then subscript
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing strikethrough and italic then bold then subscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then bold then subscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><strong><em><del>%1%</del></em></strong></sub></p>');

    }//end testStrikethroughThenItalicThenBoldThenSubscript()


    /**
     * Test format combination of strikethrough then italic then bold then superscript.
     *
     * @return void
     */
    public function testStrikethroughThenItalicThenBoldThenSuperscript()
    {
        // Test applying strikethrough and italic then bold then superscript
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing strikethrough and italic then bold then superscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then bold then superscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><strong><em><del>%1%</del></em></strong></sup></p>');

    }//end testStrikethroughThenItalicThenBoldThenSuperscript()


    /**
     * Test format combination of strikethrough then subscript then italic then bold.
     *
     * @return void
     */
    public function testStrikethroughThenSubscriptThenItalicThenBold()
    {
        // Test applying strikethrough and subscript then italic then bold
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and subscript then italic then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and subscript then italic then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><sub><del>%1%</del></sub></em></strong></p>');

    }//end testStrikethroughThenSubscriptThenItalicThenBold()


    /**
     * Test format combination of strikethrough then subscript then bold then italic.
     *
     * @return void
     */
    public function testStrikethroughThenSubscriptThenBoldThenItalic()
    {
        // Test applying strikethrough and subscript then bold then italic
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing strikethrough and subscript then bold then italic
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying strikethrough and subscript then bold then italic
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><sub><del>%1%</del></sub></strong></em></p>');

    }//end testStrikethroughThenSubscriptThenBoldThenItalic()


    /**
     * Test format combination of strikethrough then superscript then italic then bold.
     *
     * @return void
     */
    public function testStrikethroughThenSuperscriptThenItalicThenBold()
    {
        // Test applying strikethrough and superscript then italic then bold
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and superscript then italic then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and superscript then italic then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><sup><del>%1%</del></sup></em></strong></p>');

    }//end testStrikethroughThenSuperscriptThenItalicThenBold()


    /**
     * Test format combination of strikethrough then superscript then bold then italic.
     *
     * @return void
     */
    public function testStrikethroughThenSuperscriptThenBoldThenItalic()
    {
        // Test applying strikethrough and superscript then bold then italic
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing strikethrough and superscript then bold then italic
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying strikethrough and superscript then bold then italic
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><sup><del>%1%</del></sup></strong></em></p>');

    }//end testStrikethroughThenSuperscriptThenBoldThenItalic()


    /**
     * Test format combination of strikethrough then bold then italic then subscript.
     *
     * @return void
     */
    public function testStrikethroughThenBoldThenItalicThenSubscript()
    {
        // Test applying strikethrough and bold then italic then subscript
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing strikethrough and bold then italic then subscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and bold then italic then subscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><em><strong><del>%1%</del></strong></em></sub></p>');

    }//end testStrikethroughThenBoldThenItalicThenSubscript()


    /**
     * Test format combination of strikethrough then bold then italic then superscript.
     *
     * @return void
     */
    public function testStrikethroughThenBoldThenItalicThenSuperscript()
    {
        // Test applying strikethrough and bold then italic then superscript
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing strikethrough and bold then italic then superscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and bold then italic then superscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><em><strong><del>%1%</del></strong></em></sup></p>');

    }//end testStrikethroughThenBoldThenItalicThenSuperscript()


    /**
     * Test format combination of strikethrough then bold then subscript then italic.
     *
     * @return void
     */
    public function testStrikethroughThenBoldThenSubscriptThenItalic()
    {
        // Test applying strikethrough and bold then subscript then italic
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing strikethrough and bold then subscript then italic
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying strikethrough and bold then subscript then italic
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><sub><strong><del>%1%</del></strong></sub></em></p>');

    }//end testStrikethroughThenBoldThenSubscriptThenItalic()


    /**
     * Test format combination of strikethrough then bold then superscript then italic.
     *
     * @return void
     */
    public function testStrikethroughThenBoldThenSuperscriptThenItalic()
    {
        // Test applying strikethrough and bold then superscript then italic
        $this->useTest(1);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing strikethrough and bold then superscript then italic
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');       

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying strikethrough and bold then superscript then italic
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><sup><strong><del>%1%</del></strong></sup></em></p>');

    }//end testStrikethroughThenBoldThenSuperscriptThenItalic()
    
}//end class

?>