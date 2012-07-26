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

        // Test selecting a word in a div to change to a paragraph
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Toogle formats icon should not appear in the inline toolbar');

        // Select all content in the div and change to a paragraph
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Toogle formats should appear in the inline toolbar');
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><p>%4% paragraph to change to a p</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);

        // Check the state of the format icon after we have changed to a paragraph
        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'formats icon should not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'), 'Active formats icon should not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Active toogle formats icon should be active in the inline toolbar');
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);

    }//end testApplingThePStyleUsingInlineToolbar()


    /**
     * Test applying the p tag to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testApplingThePStyleUsingTopToolbar()
    {

        // Test clicking in a div to change to a paragraph
        $this->click($this->findKeyword(4));
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><p>%4% paragraph to change to a p</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);

        // Change it back to do more testing
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        // Test selecting a word in a div to change to a paragraph
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'active'), 'Active toogle formats icoun should appear in the top toolbar');

        // Select all content in the div and change to a paragraph
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'active Div icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><p>%4% paragraph to change to a p</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);

        // Check the state of the format icon after we have changed to a paragraph
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should disabled in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Active toogle formats icon should be active in the top toolbar');
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);

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
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Active P icon does not appear in the inline toolbar');
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->assertEquals($this->replaceKeywords('%1% xtn %2%'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Active P icon does not appear in the top toolbar');
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertEquals($this->replaceKeywords('%1% xtn %2%'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectParaAfterStylingShowsCorrectIcons()


    /**
     * Test that when you select part of a paragraph that you cannot change it to another format type.
     *
     * @return void
     */
    public function testPartialSelectionOfParagraph()
    {
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'), 'Active P icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Disabled formats icon should appear in the top toolbar');

    }//end testPartialSelectionOfParagraph()


    /**
     * Test applying and then removing the P format using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingPUsingInlineToolbar()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><p>%4% paragraph to change to a p</p>');

        $this->clickInlineToolbarButton('P', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p> %4% paragraph to change to a p');

        // Make sure that the P is still enabled
        $this->checkStatusOfFormatIconsInTheInlineToolbar();

    }//end testApplyingAndRemovingPUsingInlineToolbar()


    /**
     * Test applying and then removing the P format using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingPUsingTopToolbar()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><p>%4% paragraph to change to a p</p>');

        $this->clickTopToolbarButton('P', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p> %4% paragraph to change to a p');

        // Make sure that the P is still enabled
        $this->checkStatusOfFormatIconsInTheTopToolbar();

    }//end testApplyingAndRemovingPUsingTopToolbar()


    /**
     * Test applying and then removing the P format to a multi line paragraph.
     *
     * @return void
     */
    public function testRemovingAndApplyingPToMultiLineParagraph()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('P', 'active', TRUE);
        $this->assertHTMLMatch('%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

    }//end testRemovingAndApplyingPToMultiLineParagraph()


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
     * Tests changing a paragraph to a div and then back again using the inline toolbar.
     *
     * @return void
     */
    public function testChangingAParagraphToADivUsingInlineToolbar()
    {

        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn %2%</div><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

    }//end testChangingAParagraphToADivUsingInlineToolbar()


    /**
     * Tests changing a paragraph to a div and then back again using the top toolbar.
     *
     * @return void
     */
    public function testChangingAParagraphToADivUsingTopToolbar()
    {

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn %2%</div><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

    }//end testChangingAParagraphToADivUsingTopToolbar()


     /**
     * Tests changing a paragraph to a PRE and then back again using the inline toolbar.
     *
     * @return void
     */
    public function testChangingAParagraphToAPreUsingTheInlineToolbar()
    {

        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

    }//end testChangingAParagraphToAPreUsingTheInlineToolbar()


     /**
     * Tests changing a paragraph to a PRE and then back again using the top toolbar.
     *
     * @return void
     */
    public function testChangingAParagraphToAPreUsingTheTopToolbar()
    {

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

    }//end testChangingAParagraphToAPreUsingTheTopToolbar()


     /**
     * Tests that when you select a paragraph and apply Quotes using the inline toolbar, it wraps the P.
     *
     * @return void
     */
    public function testApplyingQuoteToAParagraphUsingTheInlineToolbar()
    {

        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 2);
        // Check that the formats icon is not active as you cannot change the P when in a quote
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'), 'Active P icon should not appear in the inline toolbar');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should appear in the inline toolbar');

        // Remove the quote tag
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

    }//end testApplyingQuoteToAParagraphUsingTheInlineToolbar()


     /**
     * Tests that when you select a paragraph and apply Quotes using the top toolbar, it wraps the P.
     *
     * @return void
     */
    public function testApplyingQuoteToAParagraphUsingTheTopToolbar()
    {

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

        $this->selectKeyword(1, 2);
        // Check that the formats icon is not active as you cannot change the P when in a quote
        $this->assertFalse($this->topToolbarButtonExists('formats-p', 'active'), 'Active P icon should not appear in the top toolbar');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should appear in the top toolbar');

        // Remove the quote tag
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><p>sit amet <strong>%3%</strong></p><div>%4% paragraph to change to a p</div>');

    }//end testApplyingQuoteToAParagraphUsingTheTopToolbar()

}//end class

?>
