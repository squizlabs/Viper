<?php

require_once 'AbstractFormatsUnitTest.php';

class Viper_Tests_ViperFormatPlugin_ParagraphUnitTest extends AbstractFormatsUnitTest
{


    /**
     * Test applying the p tag to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testApplingThePStyleUsingInlineToolbar()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><p>%4% paragraph to change to a p</p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Toogle formats icon is not selected');

        $this->clickInlineToolbarButton('formats-p', 'active');

        $this->assertTrue($this->inlineToolbarButtonExists('P', 'active', TRUE), 'P icon is not active');

    }//end testApplingThePStyleUsingInlineToolbar()


    /**
     * Test applying the p tag to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testApplingThePStyleUsingTopToolbar()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><p>%4% paragraph to change to a p</p>');

        $this->click($this->findKeyword(1));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Toogle formats icon is not selected');

        $this->clickTopToolbarButton('formats-p', 'active');

        $this->assertTrue($this->topToolbarButtonExists('P', 'active', NULL), 'P icon should be active');

    }//end testApplingThePStyleUsingTopToolbar()


    /**
     * Tests that applying styles to whole paragraph and selecting the P in lineage shows paragraph tools.
     *
     * @return void
     */
    public function testSelectParaAfterStylingShowsCorrectIcons()
    {
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);

        // Make sure the correct icons are being shown in the inline toolbar.
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('P', 'active', TRUE), 'P icon should active');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->assertTrue($this->topToolbarButtonExists('P', 'active', TRUE), 'P icon should be active');

    }//end testSelectParaAfterStylingShowsCorrectIcons()


     /**
     * Tests selecting text in a paragraph.
     *
     * @return void
     */
    public function testSelectingParagraphsWithFormattedTextShowsCorrectIcons()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->assertEquals($this->replaceKeywords('%1% xtn %2%'), $this->getSelectedText(), 'Original selection is not selected');
        $this->assertTrue($this->inlineToolbarButtonExists('P', 'active', TRUE), 'P icon is not active');

        $this->click($this->findKeyword(1));
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->assertEquals($this->replaceKeywords('sit amet XCX'), $this->getSelectedText(), 'Original selection is not selected');
        $this->assertTrue($this->topToolbarButtonExists('P', 'active', TRUE), 'P icon is not active');

    }//end testSelectingParagraphsWithFormattedTextShowsCorrectIcons()


    /**
     * Test that when you only select part of a paragraph and apply the P, it applies it to the whole paragraph.
     *
     * @return void
     */
    public function testPAppliedToParagraphOnPartialSelection()
    {
        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon should not appear in the inline toolbar');

        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><p>%4% paragraph to change to a p</p>');

    }//end testPAppliedToParagraphOnPartialSelection()


    /**
     * Test applying and then removing the P format.
     *
     * @return void
     */
    public function testApplyingAndRemovingP()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><p>%4% paragraph to change to a p</p>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('P', 'active', TRUE);

        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p> %4% paragraph to change to a p');

        // Make sure that the P is still enabled
        $this->assertTrue($this->inlineToolbarButtonExists('P', NULL, TRUE), 'P icon should be enabled');

    }//end testApplyingAndRemovingP()


    /**
     * Test creating new content in p tags.
     *
     * @return void
     */
    public function testCreatingNewContentWithAPTag()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('New content');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.RIGHT');
        $this->type(' on the page');
        $this->keyDown('Key.ENTER');
        $this->type('More new content');

        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div><p>New content on the page</p><p>More new content</p>');

    }//end testCreatingNewContentWithAPTag()


    /**
     * Tests changing a paragraph to a div and then back again.
     *
     * @return void
     */
    public function testChangingAParagraphToADiv()
    {

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);

        $this->assertTrue($this->inlineToolbarButtonExists('DIV', 'active', TRUE), 'Div icon is not active in the inline toolbar');

        $this->assertHTMLMatch('<div>%1% xtn %2%</div><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);

        $this->assertTrue($this->inlineToolbarButtonExists('P', 'active', TRUE), 'P icon is not active in the inline toolbar');

        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

    }//end testChangingAParagraphToADiv()


     /**
     * Tests changing a paragraph to a PRE and then back again.
     *
     * @return void
     */
    public function testChangingAParagraphToAPre()
    {

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

        $this->assertTrue($this->inlineToolbarButtonExists('PRE', 'active', TRUE), 'Pre icon is not active in the inline toolbar');

        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);

        $this->assertTrue($this->inlineToolbarButtonExists('P', 'active', TRUE), 'P icon is not active in the inline toolbar');

        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

    }//end testChangingAParagraphToAPre()


     /**
     * Tests that when you select a paragraph and apply Quotes, it wraps the P.
     *
     * @return void
     */
    public function testApplyingQuoteToAParagraph()
    {

        $this->click($this->findKeyword(3));
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->assertTrue($this->inlineToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active in the inline toolbar');

        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 2);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Active P icon should appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Active P icon should appear in the top toolbar');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should appear in the top toolbar');

        // Remove the quote tag
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('Quote', 'active', TRUE);

        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

    }//end testApplyingQuoteToAParagraph()


    /**
     * Test trying to apply a P tag around two P tags
     *
     * @return void
     */
    public function testApplingPAroundTwoPTags()
    {
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIcons('disabled');

    }//end testApplingPAroundTwoPTags()


    /**
     * Test trying to apply a P tag around a P and Div tag
     *
     * @return void
     */
    public function testApplingPAroundPAndDivTag()
    {
        // Test Div and P
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><div>sit amet <strong>%3%</strong></div><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

        // Test P and Div
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn %2%</div><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

    }//end testApplingPAroundPAndDivTag()


    /**
     * Test trying to apply a P tag around a P and Quote tag
     *
     * @return void
     */
    public function testApplingPAroundPAndQuoteTag()
    {
        // Test Quote and P
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><blockquote><p>sit amet <strong>%3%</strong></p></blockquote><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

        // Test P and Quote
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

    }//end testApplingPAroundPAndQuoteTag()


    /**
     * Test trying to apply a P tag around a P and Pre tag
     *
     * @return void
     */
    public function testApplingPAroundPAndPreTag()
    {
        // Test Pre and P
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><pre>sit amet <strong>%3%</strong></pre><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

        // Test P and Pre
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

    }//end testApplingPAroundPAndPreTag()


    /**
     * Test trying to apply a P tag around two div tags
     *
     * @return void
     */
    public function testApplingPAroundTwoDivTags()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn %2%</div><div>sit amet <strong>%3%</strong></div><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

    }//end testApplingPAroundTwoDivTags()


    /**
     * Test trying to apply a P tag around Div and Quote tags
     *
     * @return void
     */
    public function testApplingPAroundDivAndQuote()
    {
        // Test Quote and Div
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Div', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn %2%</div><blockquote><p>sit amet <strong>%3%</strong></p></blockquote><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

        // Test Div and Quote
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Div', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>sit amet <strong>%3%</strong></div><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

    }//end testApplingPAroundDivAndQuote()


    /**
     * Test trying to apply a P tag around Div and Pre tags
     *
     * @return void
     */
    public function testApplingPAroundDivAndPre()
    {
        // Test Div and Pre
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Div', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Pre', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>sit amet <strong>%3%</strong></div><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

        // Test Pre and Div
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Pre', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('Div', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn %2%</div><pre>sit amet <strong>%3%</strong></pre><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

    }//end testApplingPAroundDivAndPre()


    /**
     * Test trying to apply a P tag around two Quote tags
     *
     * @return void
     */
    public function testApplingPAroundTwoQuoteTags()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><blockquote><p>sit amet <strong>%3%</strong></p></blockquote><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

    }//end testApplingPAroundTwoQuoteTags()


    /**
     * Test trying to apply a P tag around Quote and Pre tags
     *
     * @return void
     */
    public function testApplingPAroundQuoteAndPreTags()
    {
        // Test Pre and Quote
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Pre', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><pre>sit amet <strong>%3%</strong></pre><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

        // Test Quote and Pre
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><blockquote><p>sit amet <strong>%3%</strong></p></blockquote><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

    }//end testApplingPAroundQuoteAndPreTags()


    /**
     * Test trying to apply a P tag around two Pre tags
     *
     * @return void
     */
    public function testApplingPAroundTwoPreTags()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>sit amet <strong>%3%</strong></pre><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIcons('disabled');

    }//end testApplingPAroundTwoPreTags()


}//end class

?>
