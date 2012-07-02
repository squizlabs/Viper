<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_ParagraphUnitTest extends AbstractViperUnitTest
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

        $this->assertTrue($this->inlineToolbarButtonExists('P', NULL, TRUE), 'P icon is not active');

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

        $this->assertTrue($this->topToolbarButtonExists('P', 'active', NULL), 'P icon is not active');

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
        $this->assertTrue($this->inlineToolbarButtonExists('P', NULL, TRUE), 'P icon is not active');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'P icon is not active');

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
        $this->clickTopToolbarButton('P', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p>%4% paragraph to change to a p');

    }//end testApplyingAndRemovingP()


    /**
     * Test the the block quote is added around two selected paragraphs.
     *
     * @return void
     */
    public function testApplingQuoteToMultipleParagraphs()
    {
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p></blockquote><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);

        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p><div>sit amet <strong>%3%</strong></div></blockquote><div>%4% paragraph to change to a p</div>');

    }//end testApplingQuoteToMultipleParagraphs()


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
     * Tests changing a paragraph to a Quote and then back again.
     *
     * @return void
     */
    public function testChangingAParagraphToAQuote()
    {

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->assertTrue($this->inlineToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon is not active in the inline toolbar');

        $this->assertHTMLMatch('<blockquote>%1% xtn %2%</blockquote><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);

        $this->assertTrue($this->inlineToolbarButtonExists('P', NULL, TRUE), 'P icon is not active in the inline toolbar');

        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

    }//end testChangingAParagraphToAQuote()


}//end class

?>
