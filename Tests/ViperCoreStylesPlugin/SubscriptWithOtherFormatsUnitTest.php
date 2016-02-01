<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_SubscriptWithOtherFormatsUnitTest extends AbstractViperUnitTest
{
	
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

}//end class

?>