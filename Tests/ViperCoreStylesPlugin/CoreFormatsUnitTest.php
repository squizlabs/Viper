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
    public function testBoldWithTheOtherFormatItalicApplied()
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
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing bold and italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying bold and italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong>%1%</strong></em></p>');

    }//end testBoldWithTheOtherFormatItalicApplied()


    /**
     * Test format combination of bold then subscript.
     *
     * @return void
     */
    public function testBoldWithTheOtherFormatSubscriptApplied()
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

        // Test applying bold and subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing bold and subscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying bold and subscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);
        
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><strong>%1%</strong></sub></p>');

    }//end testBoldWithTheOtherFormatSubscriptApplied()


    /**
     * Test format combination of bold then superscript.
     *
     * @return void
     */
    public function testBoldWithTheOtherFormatSuperscriptApplied()
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

        // Test applying bold and superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing bold and superscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying bold and superscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);
        
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><strong>%1%</strong></sup></p>');

    }//end testBoldWithTheOtherFormatSuperscriptApplied()


    /**
     * Test format combination of bold then strikethrough.
     *
     * @return void
     */
    public function testBoldWithTheOtherFormatStrikethroughApplied()
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
        $this->assertHTMLMatch('<p><del><strong>%1%</strong></del></p>');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test applying bold and strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong>%1%</strong></del></p>');

    }//end testBoldWithTheOtherFormatStrikethroughApplied()


    /**
     * Test format combination of bold then italic then subscript.
     *
     * @return void
     */
    public function testBoldWithTheTwoOtherFormatsItalicThenSubscriptApplied()
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

        // Test applying bold and italic then subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing bold and italic then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying bold and italic then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><em><strong>%1%</strong></em></sub></p>');

    }//end testBoldWithTheTwoOtherFormatsItalicThenSubscriptApplied()


    /**
     * Test format combination of bold then italic then superscript.
     *
     * @return void
     */
    public function testBoldWithTheTwoOtherFormatsItalicThenSuperscriptApplied()
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

        // Test applying bold and italic then superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing bold and italic then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying bold and italic then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><em><strong>%1%</strong></em></sup></p>');

    }//end testBoldWithTheTwoOtherFormatsItalicThenSuperscriptApplied()


    /**
     * Test format combination of bold then italic then strikethrough.
     *
     * @return void
     */
    public function testBoldWithTheTwoOtherFormatsItalicThenStrikethroughApplied()
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

        // Test applying bold and italic then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and italic then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and italic then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><strong>%1%</strong></em></del></p>');


    }//end testBoldWithTheTwoOtherFormatsItalicThenStrikethroughApplied()


    /**
     * Test format combination of bold then subscript then italic.
     *
     * @return void
     */
    public function testBoldWithTheTwoOtherFormatsSubscriptThenItalicApplied()
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

        // Test applying bold and subscript then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing bold and subscript then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying bold and subscript then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><sub><strong>%1%</strong></sub></em></p>');

    }//end testBoldWithTheTwoOtherFormatsSubscriptThenItalicApplied()


    /**
     * Test format combination of bold then subscript then strikethrough.
     *
     * @return void
     */
    public function testBoldWithTheTwoOtherFormatsSubscriptThenStrikethroughApplied()
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

        // Test applying bold and subscript then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and subscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and subscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sub><strong>%1%</strong></sub></del></p>');

    }//end testBoldWithTheTwoOtherFormatsSubscriptThenStrikethroughApplied()


    /**
     * Test format combination of bold then superscript then italic.
     *
     * @return void
     */
    public function testBoldWithTheTwoOtherFormatsSuperscriptThenItalicApplied()
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

        // Test applying bold and superscript then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing bold and superscript then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying bold and superscript then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><sup><strong>%1%</strong></sup></em></p>');

    }//end testBoldWithTheTwoOtherFormatsSuperscriptThenItalicApplied()


    /**
     * Test format combination of bold then superscript then strikethrough.
     *
     * @return void
     */
    public function testBoldWithTheTwoOtherFormatsSuperscriptThenStrikethroughApplied()
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

        // Test applying bold and superscript then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and superscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and superscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sup><strong>%1%</strong></sup></del></p>');

    }//end testBoldWithTheTwoOtherFormatsSuperscriptThenStrikethroughApplied()


    /**
     * Test format combination of bold then strikethrough then italic.
     *
     * @return void
     */
    public function testBoldWithTheTwoOtherFormatsStrikethroughThenItalicApplied()
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

        // Test applying bold and strikethrough then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing bold and strikethrough then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying bold and strikethrough then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><strong>%1%</strong></del></em></p>');

    }//end testBoldWithTheTwoOtherFormatsStrikethroughThenItalicApplied()


    /**
     * Test format combination of bold then strikethrough then subscript.
     *
     * @return void
     */
    public function testBoldWithTheTwoOtherFormatsStrikethroughThenSubscriptApplied()
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

        // Test applying bold and strikethrough then subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing bold and strikethrough then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying bold and strikethrough then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><del><strong>%1%</strong></del></sub></p>');

    }//end testBoldWithTheTwoOtherFormatsStrikethroughThenSubscriptApplied()


    /**
     * Test format combination of bold then strikethrough then superscript.
     *
     * @return void
     */
    public function testBoldWithTheTwoOtherFormatsStrikethroughThenSuperscriptApplied()
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

        // Test applying bold and strikethrough then superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing bold and strikethrough then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying bold and strikethrough then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><del><strong>%1%</strong></del></sup></p>');

    }//end testBoldWithTheTwoOtherFormatsStrikethroughThenSuperscriptApplied()


    /**
     * Test format combination of bold then italic then subscript then strikethrough.
     *
     * @return void
     */
    public function testBoldWithTheThreeOtherFormatsItalicThenSubscriptThenStrikethroughApplied()
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

        // Test applying bold and italic then subscript then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and italic then subscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and italic then subscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sub><em><strong>%1%</strong></em></sub></del></p>');

    }//end testBoldWithTheThreeOtherFormatsItalicThenSubscriptThenStrikethroughApplied()


    /**
     * Test format combination of bold then italic then superscript then strikethrough.
     *
     * @return void
     */
    public function testBoldWithTheThreeOtherFormatsItalicThenSuperscriptThenStrikethroughApplied()
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

        // Test applying bold and italic then superscript then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and italic then superscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and italic then superscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sup><em><strong>%1%</strong></em></sup></del></p>');

    }//end testBoldWithTheThreeOtherFormatsItalicThenSuperscriptThenStrikethroughApplied()


    /**
     * Test format combination of bold then italic then strikethrough then subscript.
     *
     * @return void
     */
    public function testBoldWithTheThreeOtherFormatsItalicThenStrikethroughThenSubscriptApplied()
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

        // Test applying bold and italic then strikethrough then subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing bold and italic then strikethrough then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying bold and italic then strikethrough then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><del><em><strong>%1%</strong></em></del></sub></p>');

    }//end testBoldWithTheThreeOtherFormatsItalicThenStrikethroughThenSubscriptApplied()


    /**
     * Test format combination of bold then italic then strikethrough then superscript.
     *
     * @return void
     */
    public function testBoldWithTheThreeOtherFormatsItalicThenStrikethroughThenSuperscriptApplied()
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

        // Test applying bold and italic then strikethrough then superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing bold and italic then strikethrough then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying bold and italic then strikethrough then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><del><em><strong>%1%</strong></em></del></sup></p>');

    }//end testBoldWithTheThreeOtherFormatsItalicThenStrikethroughThenSuperscriptApplied()


    /**
     * Test format combination of bold then subscript then italic then strikethrough.
     *
     * @return void
     */
    public function testBoldWithTheThreeOtherFormatsSubscriptThenItalicThenStrikethroughApplied()
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

        // Test applying bold and subscript then italic then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and subscript then italic then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and subscript then italic then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><sub><strong>%1%</strong></sub></em></del></p>');

    }//end testBoldWithTheThreeOtherFormatsSubscriptThenItalicThenStrikethroughApplied()


    /**
     * Test format combination of bold then subscript then strikethrough then italic.
     *
     * @return void
     */
    public function testBoldWithTheThreeOtherFormatsSubscriptThenStrikethroughThenItalicApplied()
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
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

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

        // Test applying bold and subscript then strikethrough then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing bold and subscript then strikethrough then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying bold and subscript then strikethrough then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><sub><strong>%1%</strong></sub></del></em></p>');

    }//end testBoldWithTheThreeOtherFormatsSubscriptThenStrikethroughThenItalicApplied()


    /**
     * Test format combination of bold then superscript then italic then strikethrough.
     *
     * @return void
     */
    public function testBoldWithTheThreeOtherFormatsSuperscriptThenItalicThenStrikethroughApplied()
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

        // Test applying bold and superscript then italic then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing bold and superscript then italic then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying bold and superscript then italic then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><sup><strong>%1%</strong></sup></em></del></p>');

    }//end testBoldWithTheThreeOtherFormatsSuperscriptThenItalicThenStrikethroughApplied()


    /**
     * Test format combination of bold then superscript then strikethrough then italic.
     *
     * @return void
     */
    public function testBoldWithTheThreeOtherFormatsSuperscriptThenStrikethroughThenItalicApplied()
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
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

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

        // Test applying bold and superscript then strikethrough then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing bold and superscript then strikethrough then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying bold and superscript then strikethrough then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><sup><strong>%1%</strong></sup></del></em></p>');

    }//end testBoldWithTheThreeOtherFormatsSuperscriptThenStrikethroughThenItalicApplied()


    /**
     * Test format combination of bold then strikethrough then italic then subscript.
     *
     * @return void
     */
    public function testBoldWithTheThreeOtherFormatsStrikethroughThenItalicThenSubscriptApplied()
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

        // Test applying bold and strikethrough then italic then subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing bold and strikethrough then italic then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying bold and strikethrough then italic then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><em><del><strong>%1%</strong></del></em></sub></p>');

    }//end testBoldWithTheThreeOtherFormatsStrikethroughThenItalicThenSubscriptApplied()


    /**
     * Test format combination of bold then strikethrough then italic then superscript.
     *
     * @return void
     */
    public function testBoldWithTheThreeOtherFormatsStrikethroughThenItalicThenSuperscriptApplied()
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

        // Test applying bold and strikethrough then italic then superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing bold and strikethrough then italic then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying bold and strikethrough then italic then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><em><del><strong>%1%</strong></del></em></sup></p>');

    }//end testBoldWithTheThreeOtherFormatsStrikethroughThenItalicThenSuperscriptApplied()


    /**
     * Test format combination of bold then strikethrough then subscript then italic.
     *
     * @return void
     */
    public function testBoldWithTheThreeOtherFormatsStrikethroughThenSubscriptThenItalicApplied()
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

        // Test applying bold and strikethrough then subscript then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing bold and strikethrough then subscript then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying bold and strikethrough then subscript then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><sub><del><strong>%1%</strong></del></sub></em></p>');

    }//end testBoldWithTheThreeOtherFormatsStrikethroughThenSubscriptThenItalicApplied()


    /**
     * Test format combination of bold then strikethrough then superscript then italic.
     *
     * @return void
     */
    public function testBoldWithTheThreeOtherFormatsStrikethroughThenSuperscriptThenItalicApplied()
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

        // Test applying bold and strikethrough then superscript then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing bold and strikethrough then superscript then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying bold and strikethrough then superscript then italic using keyboard shortcuts
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><sup><del><strong>%1%</strong></del></sup></em></p>');

    }//end testBoldWithTheThreeOtherFormatsStrikethroughThenSuperscriptThenItalicApplied()


    /**
     * Test format combination of italic then bold.
     *
     * @return void
     */
    public function testItalicWithTheOtherFormatBoldApplied()
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
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing italic and bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying italic and bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em>%1%</em></strong></p>');

    }//end testItalicWithTheOtherFormatBoldApplied()


    /**
     * Test format combination of italic then subscript.
     *
     * @return void
     */
    public function testItalicWithTheOtherFormatSubscriptApplied()
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

        // Test applying italic and subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing italic and subscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying italic and subscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);
        
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><em>%1%</em></sub></p>');

    }//end testItalicWithTheOtherFormatSubscriptApplied()


    /**
     * Test format combination of italic then superscript.
     *
     * @return void
     */
    public function testItalicWithTheOtherFormatSuperscriptApplied()
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

        // Test applying italic and superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing italic and superscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying italic and superscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);
        
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><em>%1%</em></sup></p>');

    }//end testItalicWithTheOtherFormatSuperscriptApplied()


    /**
     * Test format combination of italic then strikethrough.
     *
     * @return void
     */
    public function testItalicWithTheOtherFormatStrikethroughApplied()
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
        $this->assertHTMLMatch('<p><del><em>%1%</em></del></p>');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test applying italic and strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em>%1%</em></del></p>');

    }//end testItalicWithTheOtherFormatStrikethroughApplied()


    /**
     * Test format combination of italic then bold then subscript.
     *
     * @return void
     */
    public function testItalicWithTheTwoOtherFormatsBoldThenSubscriptApplied()
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

        // Test applying italic and bold then subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing italic and bold then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying italic and bold then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><strong><em>%1%</em></strong></sub></p>');

    }//end testItalicWithTheTwoOtherFormatsBoldThenSubscriptApplied()


    /**
     * Test format combination of italic then bold then superscript.
     *
     * @return void
     */
    public function testItalicWithTheTwoOtherFormatsBoldThenSuperscriptApplied()
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

        // Test applying italic and bold then superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing italic and bold then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying italic and bold then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><strong><em>%1%</em></strong></sup></p>');

    }//end testItalicWithTheTwoOtherFormatsBoldThenSuperscriptApplied()


    /**
     * Test format combination of italic then bold then strikethrough.
     *
     * @return void
     */
    public function testItalicWithTheTwoOtherFormatsBoldThenStrikethroughApplied()
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

        // Test applying italic and bold then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and bold then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and bold then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><em>%1%</em></strong></del></p>');


    }//end testItalicWithTheTwoOtherFormatsBoldThenStrikethroughApplied()


    /**
     * Test format combination of italic then subscript then bold.
     *
     * @return void
     */
    public function testItalicWithTheTwoOtherFormatsSubscriptThenBoldApplied()
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

        // Test applying italic and subscript then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing italic and subscript then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying italic and subscript then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sub><em>%1%</em></sub></strong></p>');

    }//end testItalicWithTheTwoOtherFormatsSubscriptThenBoldApplied()


    /**
     * Test format combination of italic then subscript then strikethrough.
     *
     * @return void
     */
    public function testItalicWithTheTwoOtherFormatsSubscriptThenStrikethroughApplied()
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

        // Test applying italic and subscript then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and subscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and subscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sub><em>%1%</em></sub></del></p>');

    }//end testItalicWithTheTwoOtherFormatsSubscriptThenStrikethroughApplied()


    /**
     * Test format combination of italic then superscript then bold.
     *
     * @return void
     */
    public function testItalicWithTheTwoOtherFormatsSuperscriptThenBoldApplied()
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

        // Test applying italic and superscript then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing italic and superscript then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying italic and superscript then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sup><em>%1%</em></sup></strong></p>');

    }//end testItalicWithTheTwoOtherFormatsSuperscriptThenBoldApplied()


    /**
     * Test format combination of italic then superscript then strikethrough.
     *
     * @return void
     */
    public function testItalicWithTheTwoOtherFormatsSuperscriptThenStrikethroughApplied()
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

        // Test applying italic and superscript then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and superscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and superscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sup><em>%1%</em></sup></del></p>');

    }//end testItalicWithTheTwoOtherFormatsSuperscriptThenStrikethroughApplied()


    /**
     * Test format combination of italic then strikethrough then bold.
     *
     * @return void
     */
    public function testItalicWithTheTwoOtherFormatsStrikethroughThenBoldApplied()
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

        // Test applying italic and strikethrough then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing italic and strikethrough then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying italic and strikethrough then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><em>%1%</em></del></strong></p>');

    }//end testItalicWithTheTwoOtherFormatsStrikethroughThenBoldApplied()


    /**
     * Test format combination of italic then strikethrough then subscript.
     *
     * @return void
     */
    public function testItalicWithTheTwoOtherFormatsStrikethroughThenSubscriptApplied()
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

        // Test applying italic and strikethrough then subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing italic and strikethrough then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying italic and strikethrough then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><del><em>%1%</em></del></sub></p>');

    }//end testItalicWithTheTwoOtherFormatsStrikethroughThenSubscriptApplied()


    /**
     * Test format combination of italic then strikethrough then superscript.
     *
     * @return void
     */
    public function testItalicWithTheTwoOtherFormatsStrikethroughThenSuperscriptApplied()
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

        // Test applying italic and strikethrough then superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing italic and strikethrough then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying italic and strikethrough then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><del><em>%1%</em></del></sup></p>');

    }//end testItalicWithTheTwoOtherFormatsStrikethroughThenSuperscriptApplied()


    /**
     * Test format combination of italic then bold then subscript then strikethrough.
     *
     * @return void
     */
    public function testItalicWithTheThreeOtherFormatsBoldThenSubscriptThenStrikethroughApplied()
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

        // Test applying italic and bold then subscript then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and bold then subscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and bold then subscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sub><strong><em>%1%</em></strong></sub></del></p>');

    }//end testItalicWithTheThreeOtherFormatsBoldThenSubscriptThenStrikethroughApplied()


    /**
     * Test format combination of italic then bold then superscript then strikethrough.
     *
     * @return void
     */
    public function testItalicWithTheThreeOtherFormatsBoldThenSuperscriptThenStrikethroughApplied()
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

        // Test applying italic and bold then superscript then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and bold then superscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and bold then superscript then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sup><strong><em>%1%</em></strong></sup></del></p>');

    }//end testItalicWithTheThreeOtherFormatsBoldThenSuperscriptThenStrikethroughApplied()


    /**
     * Test format combination of italic then bold then strikethrough then subscript.
     *
     * @return void
     */
    public function testItalicWithTheThreeOtherFormatsBoldThenStrikethroughThenSubscriptApplied()
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

        // Test applying italic and bold then strikethrough then subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing italic and bold then strikethrough then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying italic and bold then strikethrough then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><del><strong><em>%1%</em></strong></del></sub></p>');

    }//end testItalicWithTheThreeOtherFormatsBoldThenStrikethroughThenSubscriptApplied()


    /**
     * Test format combination of italic then bold then strikethrough then superscript.
     *
     * @return void
     */
    public function testItalicWithTheThreeOtherFormatsBoldThenStrikethroughThenSuperscriptApplied()
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

        // Test applying italic and bold then strikethrough then superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing italic and bold then strikethrough then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying italic and bold then strikethrough then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><del><strong><em>%1%</em></strong></del></sup></p>');

    }//end testItalicWithTheThreeOtherFormatsBoldThenStrikethroughThenSuperscriptApplied()


    /**
     * Test format combination of italic then subscript then bold then strikethrough.
     *
     * @return void
     */
    public function testItalicWithTheThreeOtherFormatsSubscriptThenBoldThenStrikethroughApplied()
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

        // Test applying italic and subscript then bold then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and subscript then bold then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and subscript then bold then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><sub><em>%1%</em></sub></strong></del></p>');

    }//end testItalicWithTheThreeOtherFormatsSubscriptThenBoldThenStrikethroughApplied()


    /**
     * Test format combination of italic then subscript then strikethrough then bold.
     *
     * @return void
     */
    public function testItalicWithTheThreeOtherFormatsSubscriptThenStrikethroughThenBoldApplied()
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
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

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

        // Test applying italic and subscript then strikethrough then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing italic and subscript then strikethrough then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying italic and subscript then strikethrough then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><sub><em>%1%</em></sub></del></strong></p>');

    }//end testItalicWithTheThreeOtherFormatsSubscriptThenStrikethroughThenBoldApplied()


    /**
     * Test format combination of italic then superscript then bold then strikethrough.
     *
     * @return void
     */
    public function testItalicWithTheThreeOtherFormatsSuperscriptThenBoldThenStrikethroughApplied()
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

        // Test applying italic and superscript then bold then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing italic and superscript then bold then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying italic and superscript then bold then strikethrough using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><sup><em>%1%</em></sup></strong></del></p>');

    }//end testItalicWithTheThreeOtherFormatsSuperscriptThenBoldThenStrikethroughApplied()


    /**
     * Test format combination of italic then superscript then strikethrough then bold.
     *
     * @return void
     */
    public function testItalicWithTheThreeOtherFormatsSuperscriptThenStrikethroughThenBoldApplied()
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
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

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

        // Test applying italic and superscript then strikethrough then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing italic and superscript then strikethrough then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying italic and superscript then strikethrough then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><sup><em>%1%</em></sup></del></strong></p>');

    }//end testItalicWithTheThreeOtherFormatsSuperscriptThenStrikethroughThenBoldApplied()


    /**
     * Test format combination of italic then strikethrough then bold then subscript.
     *
     * @return void
     */
    public function testItalicWithTheThreeOtherFormatsStrikethroughThenBoldThenSubscriptApplied()
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

        // Test applying italic and strikethrough then bold then subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing italic and strikethrough then bold then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying italic and strikethrough then bold then subscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><strong><del><em>%1%</em></del></strong></sub></p>');

    }//end testItalicWithTheThreeOtherFormatsStrikethroughThenBoldThenSubscriptApplied()


    /**
     * Test format combination of italic then strikethrough then bold then superscript.
     *
     * @return void
     */
    public function testItalicWithTheThreeOtherFormatsStrikethroughThenBoldThenSuperscriptApplied()
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

        // Test applying italic and strikethrough then bold then superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing italic and strikethrough then bold then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying italic and strikethrough then bold then superscript using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><strong><del><em>%1%</em></del></strong></sup></p>');

    }//end testItalicWithTheThreeOtherFormatsStrikethroughThenBoldThenSuperscriptApplied()


    /**
     * Test format combination of italic then strikethrough then subscript then bold.
     *
     * @return void
     */
    public function testItalicWithTheThreeOtherFormatsStrikethroughThenSubscriptThenBoldApplied()
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

        // Test applying italic and strikethrough then subscript then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing italic and strikethrough then subscript then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying italic and strikethrough then subscript then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sub><del><em>%1%</em></del></sub></strong></p>');

    }//end testItalicWithTheThreeOtherFormatsStrikethroughThenSubscriptThenBoldApplied()


    /**
     * Test format combination of italic then strikethrough then superscript then bold.
     *
     * @return void
     */
    public function testItalicWithTheThreeOtherFormatsStrikethroughThenSuperscriptThenBoldApplied()
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

        // Test applying italic and strikethrough then superscript then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing italic and strikethrough then superscript then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying italic and strikethrough then superscript then bold using keyboard shortcuts
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sup><del><em>%1%</em></del></sup></strong></p>');

    }//end testItalicWithTheThreeOtherFormatsStrikethroughThenSuperscriptThenBoldApplied()


    /**
     * Test format combination of subscript then bold.
     *
     * @return void
     */
    public function testSubscriptWithTheOtherFormatBoldApplied()
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

        // Test applying subscript and bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing subscript and bold using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying subscript and bold using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');
        
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sub>%1%</sub></strong></p>');

    }//end testSubscriptWithTheOtherFormatBoldApplied()


    /**
     * Test format combination of subscript then italic.
     *
     * @return void
     */
    public function testSubscriptWithTheOtherFormatItalicApplied()
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

        // Test applying subscript and italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing subscript and italic using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying subscript and italic using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');
        
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><sub>%1%</sub></em></p>');

    }//end testSubscriptWithTheOtherFormatItalicApplied()


    /**
     * Test format combination of subscript then strikethrough.
     *
     * @return void
     */
    public function testSubscriptWithTheOtherFormatStrikethroughApplied()
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
        $this->assertHTMLMatch('<p><del><sub>%1%</sub></del></p>');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test applying subscript and strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing subscript and strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying subscript and strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sub>%1%</sub></del></p>');

    }//end testSubscriptWithTheOtherFormatStrikethroughApplied()


    /**
     * Test format combination of subscript then bold then italic.
     *
     * @return void
     */
    public function testSubscriptWithTheTwoOtherFormatsBoldThenItalicApplied()
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

        // Test applying subscript and bold then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing subscript and bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying subscript and bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><sub>%1%</sub></strong></em></p>');

    }//end testSubscriptWithTheTwoOtherFormatsBoldThenItalicApplied()


    /**
     * Test format combination of subscript then bold then strikethrough.
     *
     * @return void
     */
    public function testSubscriptWithTheTwoOtherFormatsBoldThenStrikethroughApplied()
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

        // Test applying subscript and bold then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing subscript and bold then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying subscript and bold then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><sub>%1%</sub></strong></del></p>');


    }//end testSubscriptWithTheTwoOtherFormatsBoldThenStrikethroughApplied()


    /**
     * Test format combination of subscript then italic then bold.
     *
     * @return void
     */
    public function testSubscriptWithTheTwoOtherFormatsItalicThenBoldApplied()
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

        // Test applying subscript and italic then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing subscript and italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying subscript and italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><sub>%1%</sub></em></strong></p>');

    }//end testSubscriptWithTheTwoOtherFormatsItalicThenBoldApplied()


    /**
     * Test format combination of subscript then italic then strikethrough.
     *
     * @return void
     */
    public function testSubscriptWithTheTwoOtherFormatsItalicThenStrikethroughApplied()
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

        // Test applying subscript and italic then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing subscript and italic then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying subscript and italic then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><sub>%1%</sub></em></del></p>');

    }//end testSubscriptWithTheTwoOtherFormatsItalicThenStrikethroughApplied()


    /**
     * Test format combination of subscript then strikethrough then bold.
     *
     * @return void
     */
    public function testSubscriptWithTheTwoOtherFormatsStrikethroughThenBoldApplied()
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

        // Test applying subscript and strikethrough then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing subscript and strikethrough then bold using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying subscript and strikethrough then bold using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><sub>%1%</sub></del></strong></p>');

    }//end testSubscriptWithTheTwoOtherFormatsStrikethroughThenBoldApplied()


    /**
     * Test format combination of subscript then strikethrough then italic.
     *
     * @return void
     */
    public function testSubscriptWithTheTwoOtherFormatsStrikethroughThenItalicApplied()
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

        // Test applying subscript and strikethrough then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing subscript and strikethrough then italic using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying subscript and strikethrough then italic using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><sub>%1%</sub></del></em></p>');

    }//end testSubscriptWithTheTwoOtherFormatsStrikethroughThenItalicApplied()


    /**
     * Test format combination of subscript then bold then italic then strikethrough.
     *
     * @return void
     */
    public function testSubscriptWithTheThreeOtherFormatsBoldThenItalicThenStrikethroughApplied()
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

        // Test applying subscript and bold then italic then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing subscript and bold then italic then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying subscript and bold then italic then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><strong><sub>%1%</sub></strong></em></del></p>');

    }//end testSubscriptWithTheThreeOtherFormatsBoldThenItalicThenStrikethroughApplied()


    /**
     * Test format combination of subscript then bold then strikethrough then italic.
     *
     * @return void
     */
    public function testSubscriptWithTheThreeOtherFormatsBoldThenStrikethroughThenItalicApplied()
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

        // Test applying subscript and bold then strikethrough then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing subscript and bold then strikethrough then italic using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying subscript and bold then strikethrough then italic using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><strong><sub>%1%</sub></strong></del></em></p>');

    }//end testSubscriptWithTheThreeOtherFormatsBoldThenStrikethroughThenItalicApplied()


    /**
     * Test format combination of subscript then italic then bold then strikethrough.
     *
     * @return void
     */
    public function testSubscriptWithTheThreeOtherFormatsItalicThenBoldThenStrikethroughApplied()
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

        // Test applying subscript and italic then bold then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing subscript and italic then bold then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying subscript and italic then bold then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><em><sub>%1%</sub></em></strong></del></p>');

    }//end testSubscriptWithTheThreeOtherFormatsItalicThenBoldThenStrikethroughApplied()


    /**
     * Test format combination of subscript then italic then strikethrough then bold.
     *
     * @return void
     */
    public function testSubscriptWithTheThreeOtherFormatsItalicThenStrikethroughThenBoldApplied()
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
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

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

        // Test applying subscript and italic then strikethrough then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing subscript and italic then strikethrough then bold using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying subscript and italic then strikethrough then bold using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><em><sub>%1%</sub></em></del></strong></p>');

    }//end testSubscriptWithTheThreeOtherFormatsItalicThenStrikethroughThenBoldApplied()


    /**
     * Test format combination of subscript then strikethrough then bold then italic.
     *
     * @return void
     */
    public function testSubscriptWithTheThreeOtherFormatsStrikethroughThenBoldThenItalicApplied()
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

        // Test applying subscript and strikethrough then bold then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing subscript and strikethrough then bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying subscript and strikethrough then bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><del><sub>%1%</sub></del></strong></em></p>');

    }//end testSubscriptWithTheThreeOtherFormatsStrikethroughThenBoldThenItalicApplied()


    /**
     * Test format combination of subscript then strikethrough then italic then bold.
     *
     * @return void
     */
    public function testSubscriptWithTheThreeOtherFormatsStrikethroughThenItalicThenBoldApplied()
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

        // Test applying subscript and strikethrough then italic then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing subscript and strikethrough then italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying subscript and strikethrough then italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><del><sub>%1%</sub></del></em></strong></p>');

    }//end testSubscriptWithTheThreeOtherFormatsStrikethroughThenItalicThenBoldApplied()


    /**
     * Test format combination of superscript then bold.
     *
     * @return void
     */
    public function testSuperscriptWithTheOtherFormatBoldApplied()
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

        // Test applying superscript and bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing superscript and bold using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying superscript and bold using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');
        
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sup>%1%</sup></strong></p>');

    }//end testSuperscriptWithTheOtherFormatBoldApplied()


    /**
     * Test format combination of superscript then italic.
     *
     * @return void
     */
    public function testSuperscriptWithTheOtherFormatItalicApplied()
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

        // Test applying superscript and italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing superscript and italic using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying superscript and italic using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');
        
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><sup>%1%</sup></em></p>');

    }//end testSuperscriptWithTheOtherFormatItalicApplied()


    /**
     * Test format combination of superscript then strikethrough.
     *
     * @return void
     */
    public function testSuperscriptWithTheOtherFormatStrikethroughApplied()
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
        $this->assertHTMLMatch('<p><del><sup>%1%</sup></del></p>');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test applying superscript and strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing superscript and strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying superscript and strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><sup>%1%</sup></del></p>');

    }//end testSuperscriptWithTheOtherFormatStrikethroughApplied()


    /**
     * Test format combination of superscript then bold then italic.
     *
     * @return void
     */
    public function testSuperscriptWithTheTwoOtherFormatsBoldThenItalicApplied()
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

        // Test applying superscript and bold then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing superscript and bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying superscript and bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><sup>%1%</sup></strong></em></p>');

    }//end testSuperscriptWithTheTwoOtherFormatsBoldThenItalicApplied()


    /**
     * Test format combination of superscript then bold then strikethrough.
     *
     * @return void
     */
    public function testSuperscriptWithTheTwoOtherFormatsBoldThenStrikethroughApplied()
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

        // Test applying superscript and bold then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing superscript and bold then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying superscript and bold then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><sup>%1%</sup></strong></del></p>');


    }//end testSuperscriptWithTheTwoOtherFormatsBoldThenStrikethroughApplied()


    /**
     * Test format combination of superscript then italic then bold.
     *
     * @return void
     */
    public function testSuperscriptWithTheTwoOtherFormatsItalicThenBoldApplied()
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

        // Test applying superscript and italic then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing superscript and italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying superscript and italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><sup>%1%</sup></em></strong></p>');

    }//end testSuperscriptWithTheTwoOtherFormatsItalicThenBoldApplied()


    /**
     * Test format combination of superscript then italic then strikethrough.
     *
     * @return void
     */
    public function testSuperscriptWithTheTwoOtherFormatsItalicThenStrikethroughApplied()
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

        // Test applying superscript and italic then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing superscript and italic then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying superscript and italic then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><sup>%1%</sup></em></del></p>');

    }//end testSuperscriptWithTheTwoOtherFormatsItalicThenStrikethroughApplied()


    /**
     * Test format combination of superscript then strikethrough then bold.
     *
     * @return void
     */
    public function testSuperscriptWithTheTwoOtherFormatsStrikethroughThenBoldApplied()
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

        // Test applying superscript and strikethrough then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing superscript and strikethrough then bold using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying superscript and strikethrough then bold using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><sup>%1%</sup></del></strong></p>');

    }//end testSuperscriptWithTheTwoOtherFormatsStrikethroughThenBoldApplied()


    /**
     * Test format combination of superscript then strikethrough then italic.
     *
     * @return void
     */
    public function testSuperscriptWithTheTwoOtherFormatsStrikethroughThenItalicApplied()
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

        // Test applying superscript and strikethrough then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing superscript and strikethrough then italic using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying superscript and strikethrough then italic using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><sup>%1%</sup></del></em></p>');

    }//end testSuperscriptWithTheTwoOtherFormatsStrikethroughThenItalicApplied()


    /**
     * Test format combination of superscript then bold then italic then strikethrough.
     *
     * @return void
     */
    public function testSuperscriptWithTheThreeOtherFormatsBoldThenItalicThenStrikethroughApplied()
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

        // Test applying superscript and bold then italic then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing superscript and bold then italic then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying superscript and bold then italic then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><em><strong><sup>%1%</sup></strong></em></del></p>');

    }//end testSuperscriptWithTheThreeOtherFormatsBoldThenItalicThenStrikethroughApplied()


    /**
     * Test format combination of superscript then bold then strikethrough then italic.
     *
     * @return void
     */
    public function testSuperscriptWithTheThreeOtherFormatsBoldThenStrikethroughThenItalicApplied()
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

        // Test applying superscript and bold then strikethrough then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing superscript and bold then strikethrough then italic using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying superscript and bold then strikethrough then italic using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><del><strong><sup>%1%</sup></strong></del></em></p>');

    }//end testSuperscriptWithTheThreeOtherFormatsBoldThenStrikethroughThenItalicApplied()


    /**
     * Test format combination of superscript then italic then bold then strikethrough.
     *
     * @return void
     */
    public function testSuperscriptWithTheThreeOtherFormatsItalicThenBoldThenStrikethroughApplied()
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

        // Test applying superscript and italic then bold then strikethrough using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        // Test removing superscript and italic then bold then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', 'active');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');

        // Test re-applying superscript and italic then bold then strikethrough using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');
        $this->clickTopToolbarButton('strikethrough', NULL);

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><del><strong><em><sup>%1%</sup></em></strong></del></p>');

    }//end testSuperscriptWithTheThreeOtherFormatsItalicThenBoldThenStrikethroughApplied()


    /**
     * Test format combination of superscript then italic then strikethrough then bold.
     *
     * @return void
     */
    public function testSuperscriptWithTheThreeOtherFormatsItalicThenStrikethroughThenBoldApplied()
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

        // Test applying superscript and italic then strikethrough then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing superscript and italic then strikethrough then bold using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying superscript and italic then strikethrough then bold using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del><em><sup>%1%</sup></em></del></strong></p>');

    }//end testSuperscriptWithTheThreeOtherFormatsItalicThenStrikethroughThenBoldApplied()


    /**
     * Test format combination of superscript then strikethrough then bold then italic.
     *
     * @return void
     */
    public function testSuperscriptWithTheThreeOtherFormatsStrikethroughThenBoldThenItalicApplied()
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

        // Test applying superscript and strikethrough then bold then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing superscript and strikethrough then bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying superscript and strikethrough then bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Bold');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><del><sup>%1%</sup></del></strong></em></p>');

    }//end testSuperscriptWithTheThreeOtherFormatsStrikethroughThenBoldThenItalicApplied()


    /**
     * Test format combination of superscript then strikethrough then italic then bold.
     *
     * @return void
     */
    public function testSuperscriptWithTheThreeOtherFormatsStrikethroughThenItalicThenBoldApplied()
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

        // Test applying superscript and strikethrough then italic then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        // Test removing superscript and strikethrough then italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the inline toolbar should not be active');

        // Test re-applying superscript and strikethrough then italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->getOSAltShortcut('Bold');

        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><del><sup>%1%</sup></del></em></strong></p>');

    }//end testSuperscriptWithTheThreeOtherFormatsStrikethroughThenItalicThenBoldApplied()


    /**
     * Test format combination of strikethrough then bold.
     *
     * @return void
     */
    public function testStrikethroughWithTheOtherFormatBoldApplied()
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
        $this->assertHTMLMatch('<p><strong><del>%1%</del></strong></p>');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test applying strikethrough and bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><del>%1%</del></strong></p>');

    }//end testStrikethroughWithTheOtherFormatBoldApplied()


    /**
     * Test format combination of strikethrough then italic.
     *
     * @return void
     */
    public function testStrikethroughWithTheOtherFormatItalicApplied()
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

        // Test applying strikethrough and italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing strikethrough and italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><del>%1%</del></em></p>');

    }//end testStrikethroughWithTheOtherFormatItalicApplied()


    /**
     * Test format combination of strikethrough then subscript.
     *
     * @return void
     */
    public function testStrikethroughWithTheOtherFormatSubscriptApplied()
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

        // Test applying strikethrough and subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing strikethrough and subscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and subscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><del>%1%</del></sub></p>');

    }//end testStrikethroughWithTheOtherFormatSubscriptApplied()


    /**
     * Test format combination of strikethrough then superscript.
     *
     * @return void
     */
    public function testStrikethroughWithTheOtherFormatSuperscriptApplied()
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

        // Test applying strikethrough and superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing strikethrough and superscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and superscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><del>%1%</del></sup></p>');

    }//end testStrikethroughWithTheOtherFormatSuperscriptApplied()


    /**
     * Test format combination of strikethrough then italic then subscript.
     *
     * @return void
     */
    public function testStrikethroughWithTheTwoOtherFormatsItalicThenSubscriptApplied()
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

        // Test applying strikethrough and italic then subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing strikethrough and italic then subscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then subscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><em><del>%1%</del></em></sub></p>');

    }//end testStrikethroughWithTheTwoOtherFormatsItalicThenSubscriptApplied()


    /**
     * Test format combination of strikethrough then italic then superscript.
     *
     * @return void
     */
    public function testStrikethroughWithTheTwoOtherFormatsItalicThenSuperscriptApplied()
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

        // Test applying strikethrough and italic then superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing strikethrough and italic then superscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then superscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><em><del>%1%</del></em></sup></p>');

    }//end testStrikethroughWithTheTwoOtherFormatsItalicThenSuperscriptApplied()


    /**
     * Test format combination of strikethrough then italic then bold.
     *
     * @return void
     */
    public function testStrikethroughWithTheTwoOtherFormatsItalicThenBoldApplied()
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

        // Test applying strikethrough and italic then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><del>%1%</del></em></strong></p>');


    }//end testStrikethroughWithTheTwoOtherFormatsItalicThenBoldApplied()


    /**
     * Test format combination of strikethrough then subscript then italic.
     *
     * @return void
     */
    public function testStrikethroughWithTheTwoOtherFormatsSubscriptThenItalicApplied()
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

        // Test applying strikethrough and subscript then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing strikethrough and subscript then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying strikethrough and subscript then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><sub><del>%1%</del></sub></em></p>');

    }//end testStrikethroughWithTheTwoOtherFormatsSubscriptThenItalicApplied()


    /**
     * Test format combination of strikethrough then subscript then bold.
     *
     * @return void
     */
    public function testStrikethroughWithTheTwoOtherFormatsSubscriptThenBoldApplied()
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

        // Test applying strikethrough and subscript then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and subscript then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and subscript then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sub><del>%1%</del></sub></strong></p>');

    }//end testStrikethroughWithTheTwoOtherFormatsSubscriptThenBoldApplied()


    /**
     * Test format combination of strikethrough then superscript then italic.
     *
     * @return void
     */
    public function testStrikethroughWithTheTwoOtherFormatsSuperscriptThenItalicApplied()
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

        // Test applying strikethrough and superscript then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing strikethrough and superscript then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying strikethrough and superscript then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><sup><del>%1%</del></sup></em></p>');

    }//end testStrikethroughWithTheTwoOtherFormatsSuperscriptThenItalicApplied()


    /**
     * Test format combination of strikethrough then superscript then bold.
     *
     * @return void
     */
    public function testStrikethroughWithTheTwoOtherFormatsSuperscriptThenBoldApplied()
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

        // Test applying strikethrough and superscript then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and superscript then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and superscript then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sup><del>%1%</del></sup></strong></p>');

    }//end testStrikethroughWithTheTwoOtherFormatsSuperscriptThenBoldApplied()


    /**
     * Test format combination of strikethrough then bold then italic.
     *
     * @return void
     */
    public function testStrikethroughWithTheTwoOtherFormatsBoldThenItalicApplied()
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

        // Test applying strikethrough and bold then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        // Test removing strikethrough and bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the top toolbar should not be active');

        // Test re-applying strikethrough and bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><del>%1%</del></strong></em></p>');

    }//end testStrikethroughWithTheTwoOtherFormatsBoldThenItalicApplied()


    /**
     * Test format combination of strikethrough then bold then subscript.
     *
     * @return void
     */
    public function testStrikethroughWithTheTwoOtherFormatsBoldThenSubscriptApplied()
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

        // Test applying strikethrough and bold then subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing strikethrough and bold then subscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and bold then subscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><strong><del>%1%</del></strong></sub></p>');

    }//end testStrikethroughWithTheTwoOtherFormatsBoldThenSubscriptApplied()


    /**
     * Test format combination of strikethrough then bold then superscript.
     *
     * @return void
     */
    public function testStrikethroughWithTheTwoOtherFormatsBoldThenSuperscriptApplied()
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

        // Test applying strikethrough and bold then superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing strikethrough and bold then superscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and bold then superscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><strong><del>%1%</del></strong></sup></p>');

    }//end testStrikethroughWithTheTwoOtherFormatsBoldThenSuperscriptApplied()


    /**
     * Test format combination of strikethrough then italic then subscript then bold.
     *
     * @return void
     */
    public function testStrikethroughWithTheThreeOtherFormatsItalicThenSubscriptThenBoldApplied()
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

        // Test applying strikethrough and italic then subscript then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and italic then subscript then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then subscript then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sub><em><del>%1%</del></em></sub></strong></p>');

    }//end testStrikethroughWithTheThreeOtherFormatsItalicThenSubscriptThenBoldApplied()


    /**
     * Test format combination of strikethrough then italic then superscript then bold.
     *
     * @return void
     */
    public function testStrikethroughWithTheThreeOtherFormatsItalicThenSuperscriptThenBoldApplied()
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

        // Test applying strikethrough and italic then superscript then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and italic then superscript then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then superscript then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><sup><em><del>%1%</del></em></sup></strong></p>');

    }//end testStrikethroughWithTheThreeOtherFormatsItalicThenSuperscriptThenBoldApplied()


    /**
     * Test format combination of strikethrough then italic then bold then subscript.
     *
     * @return void
     */
    public function testStrikethroughWithTheThreeOtherFormatsItalicThenBoldThenSubscriptApplied()
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

        // Test applying strikethrough and italic then bold then subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing strikethrough and italic then bold then subscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then bold then subscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><strong><em><del>%1%</del></em></strong></sub></p>');

    }//end testStrikethroughWithTheThreeOtherFormatsItalicThenBoldThenSubscriptApplied()


    /**
     * Test format combination of strikethrough then italic then bold then superscript.
     *
     * @return void
     */
    public function testStrikethroughWithTheThreeOtherFormatsItalicThenBoldThenSuperscriptApplied()
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

        // Test applying strikethrough and italic then bold then superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing strikethrough and italic then bold then superscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and italic then bold then superscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><strong><em><del>%1%</del></em></strong></sup></p>');

    }//end testStrikethroughWithTheThreeOtherFormatsItalicThenBoldThenSuperscriptApplied()


    /**
     * Test format combination of strikethrough then subscript then italic then bold.
     *
     * @return void
     */
    public function testStrikethroughWithTheThreeOtherFormatsSubscriptThenItalicThenBoldApplied()
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

        // Test applying strikethrough and subscript then italic then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and subscript then italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and subscript then italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><sub><del>%1%</del></sub></em></strong></p>');

    }//end testStrikethroughWithTheThreeOtherFormatsSubscriptThenItalicThenBoldApplied()


    /**
     * Test format combination of strikethrough then subscript then bold then italic.
     *
     * @return void
     */
    public function testStrikethroughWithTheThreeOtherFormatsSubscriptThenBoldThenItalicApplied()
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
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

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

        // Test applying strikethrough and subscript then bold then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing strikethrough and subscript then bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying strikethrough and subscript then bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><sub><del>%1%</del></sub></strong></em></p>');

    }//end testStrikethroughWithTheThreeOtherFormatsSubscriptThenBoldThenItalicApplied()


    /**
     * Test format combination of strikethrough then superscript then italic then bold.
     *
     * @return void
     */
    public function testStrikethroughWithTheThreeOtherFormatsSuperscriptThenItalicThenBoldApplied()
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

        // Test applying strikethrough and superscript then italic then bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Test removing strikethrough and superscript then italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');

        // Test re-applying strikethrough and superscript then italic then bold using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('bold', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><strong><em><sup><del>%1%</del></sup></em></strong></p>');

    }//end testStrikethroughWithTheThreeOtherFormatsSuperscriptThenItalicThenBoldApplied()


    /**
     * Test format combination of strikethrough then superscript then bold then italic.
     *
     * @return void
     */
    public function testStrikethroughWithTheThreeOtherFormatsSuperscriptThenBoldThenItalicApplied()
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
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

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

        // Test applying strikethrough and superscript then bold then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing strikethrough and superscript then bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying strikethrough and superscript then bold then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><strong><sup><del>%1%</del></sup></strong></em></p>');

    }//end testStrikethroughWithTheThreeOtherFormatsSuperscriptThenBoldThenItalicApplied()


    /**
     * Test format combination of strikethrough then bold then italic then subscript.
     *
     * @return void
     */
    public function testStrikethroughWithTheThreeOtherFormatsBoldThenItalicThenSubscriptApplied()
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

        // Test applying strikethrough and bold then italic then subscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        // Test removing strikethrough and bold then italic then subscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and bold then italic then subscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('subscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sub><em><strong><del>%1%</del></strong></em></sub></p>');

    }//end testStrikethroughWithTheThreeOtherFormatsBoldThenItalicThenSubscriptApplied()


    /**
     * Test format combination of strikethrough then bold then italic then superscript.
     *
     * @return void
     */
    public function testStrikethroughWithTheThreeOtherFormatsBoldThenItalicThenSuperscriptApplied()
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

        // Test applying strikethrough and bold then italic then superscript using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        // Test removing strikethrough and bold then italic then superscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', 'active');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');

        // Test re-applying strikethrough and bold then italic then superscript using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->getOSAltShortcut('Italic');
        $this->clickTopToolbarButton('superscript', NULL);

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');

        $this->assertHTMLMatch('<p><sup><em><strong><del>%1%</del></strong></em></sup></p>');

    }//end testStrikethroughWithTheThreeOtherFormatsBoldThenItalicThenSuperscriptApplied()


    /**
     * Test format combination of strikethrough then bold then subscript then italic.
     *
     * @return void
     */
    public function testStrikethroughWithTheThreeOtherFormatsBoldThenSubscriptThenItalicApplied()
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

        // Test applying strikethrough and bold then subscript then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing strikethrough and bold then subscript then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL), 'Subscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying strikethrough and bold then subscript then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><sub><strong><del>%1%</del></strong></sub></em></p>');

    }//end testStrikethroughWithTheThreeOtherFormatsBoldThenSubscriptThenItalicApplied()


    /**
     * Test format combination of strikethrough then bold then superscript then italic.
     *
     * @return void
     */
    public function testStrikethroughWithTheThreeOtherFormatsBoldThenSuperscriptThenItalicApplied()
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

        // Test applying strikethrough and bold then superscript then italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        // Test removing strikethrough and bold then superscript then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL), 'Strikethrough icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL), 'Bold icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL), 'Superscript icon in the top toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL), 'Italic icon in the inline toolbar should not be active');

        // Test re-applying strikethrough and bold then superscript then italic using keyboard shortcuts
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->getOSAltShortcut('Italic');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');

        $this->assertHTMLMatch('<p><em><sup><strong><del>%1%</del></strong></sup></em></p>');

    }//end testStrikethroughWithTheThreeOtherFormatsBoldThenSuperscriptThenItalicApplied()
    
}//end class

?>