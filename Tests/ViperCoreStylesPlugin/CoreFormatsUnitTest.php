<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_CoreFormatsUnitTest extends AbstractViperUnitTest
{    
    /**
     * Test format combination of bold then italic.
     *
     * @return void
     */
    public function testBoldWithTheOtherFormatItalicApplied()
    {
        // Test applying bold and italics
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing bold and italics
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying bold and italics
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
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

        // Test removing bold and subscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying bold and subscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
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

        // Test removing bold and superscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying bold and superscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
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

        // Test removing bold and strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying bold and strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
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

        // Test removing bold and italic then subscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying bold and italic then subscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
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

        // Test removing bold and italic then superscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying bold and italic then superscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
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

        // Test removing bold and italic then strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying bold and italic then strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
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

        // Test removing bold and subscript then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying bold and subscript then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
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

        // Test removing bold and subscript then strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying bold and subscript then strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
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

        // Test removing bold and superscript then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying bold and superscript then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
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

        // Test removing bold and superscript then strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying bold and superscript then strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
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

        // Test removing bold and strikethrough then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying bold and strikethrough then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
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

        // Test removing bold and strikethrough then subscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying bold and strikethrough then subscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
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

        // Test removing bold and strikethrough then superscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying bold and strikethrough then superscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
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

        // Test removing bold and italic then subscript then strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying bold and italic then subscript then strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
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

        // Test removing bold and italic then superscript then strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying bold and italic then superscript then strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
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

        // Test removing bold and italic then strikethrough then subscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying bold and italic then strikethrough then subscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<p><sup><del><em><strong>%1%</strong></em></del></sup></p>');

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

        // Test removing bold and italic then strikethrough then superscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying bold and italic then strikethrough then superscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
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

        // Test removing bold and subscript then italic then strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying bold and subscript then italic then strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><del><sup><em><strong>%1%</strong></em></sup></del></p>');

    }//end testBoldWithTheThreeOtherFormatsSubscriptThenItalicThenStrikethroughApplied()

    
}//end class

?>