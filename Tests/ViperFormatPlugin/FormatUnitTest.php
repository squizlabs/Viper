<?php

require_once 'AbstractFormatsUnitTest.php';

class Viper_Tests_ViperFormatPlugin_FormatUnitTest extends AbstractFormatsUnitTest
{


    /**
     * Test that selecting text does not show formatting icons in VITP.
     *
     * @return void
     */
    public function testTextSelectionNoOptions()
    {
        $this->selectKeyword(2);

        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'VITP Heading icon should not be available for text selection');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'VITP format icons should not be available for text selection');

        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'VITP Heading icon should not be available for text selection');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'VITP format icons should not be available for text selection');

    }//end testTextSelectionNoOptions()


    /**
     * Test that block formats (blockquote, P, DIV, PRE) works.
     *
     * @return void
     */
    public function testBlockFormats()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><p>sit %2% <strong>%3%</strong></p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote>%1% xtn dolor</blockquote><p>sit %2% <strong>%3%</strong></p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        sleep(1);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><p>sit %2% <strong>%3%</strong></p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        sleep(1);
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p>');


    }//end testBlockFormats()


    /**
     * Test that you can switch between block formats (blockquote, P, DIV, PRE) using the top toolbar.
     *
     * @return void
     */
    public function testSwitchingBetweenFormatsUsingTheTopToolbar()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        sleep(1);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><p>sit %2% <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        sleep(1);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote>%1% xtn dolor</blockquote><p>sit %2% <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        sleep(1);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><p>sit %2% <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('P', NULL, TRUE);
        sleep(1);
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p>');

    }//end testSwitchingBetweenFormatsUsingTheTopToolbar()


    /**
     * Test that selecting text does not show formatting icons in VITP.
     *
     * @return void
     */
    public function testMultiParentNoOpts()
    {
        $this->selectKeyword(2, 3);

        // Check that headings, formats doesn't appear in the inline but class and anchor do
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'VITP Heading icon should not be available for text selection');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'VITP format icons should not be available for text selection');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'), 'VITP format icons should not be available for text selection');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon in VITP should not be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon in VITP should not be active.');

        // Check that formats doesn't appear in the top toolbar but headings, class and anchor do
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled in the top toolbar');
        $this->assertFalse($this->topToolbarButtonExists('formats-p', 'active'), 'Active P icon should not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should appear in the top toolbar');

    }//end testMultiParentNoOpts()


    /**
     * Test that you can create a new P section inside a DIV and outside the DIV section.
     *
     * @return void
     */
    public function testCreatingNewPBeforeAndAfterDivSection()
    {
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></div>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Active p icon should appear in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Active p icon should appear in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'Active div icon should appear in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Active div icon should appear in the top toolbar');

        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('test new line %4%');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p><p>test new line %4%</p></div>');

        $this->selectKeyword(4);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('test new paragraph');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p><p>test new line %4%</p></div><p>test new paragraph</p>');

    }//end testCreatingNewPBeforeAndAfterDivSection()


    /**
     * Test that multiple P and DIV tags together in the content.
     *
     * @return void
     */
    public function testUsingMultiplePAndDivTagsInContent()
    {
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></div>');

        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('%4% new div section');
        $this->keyDown('Key.ENTER');
        $this->type('with two paragraphs %5%');
        $this->selectKeyword(4, 5);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);

        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></div><div><p>%4% new div section</p><p>with two paragraphs %5%</p></div>');

        $this->selectKeyword(1, 4);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></div><div><p>%4% new div section</p><p>with two paragraphs %5%</p></div></div>');

        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('new paragraph in parent div');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('new paragraph in parent div');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></div><p>new paragraph in parent div</p><p>new paragraph in parent div</p><div><p>%4% new div section</p><p>with two paragraphs %5%</p></div></div>');

        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('new paragraph in child div');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p><p>new paragraph in child div</p></div><p>new paragraph in parent div</p><p>new paragraph in parent div</p><div><p>%4% new div section</p><p>with two paragraphs %5%</p></div></div>');

        $this->selectKeyword(5);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('new paragraph outside parent div');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p><p>new paragraph in child div</p></div><p>new paragraph in parent div</p><p>new paragraph in parent div</p><div><p>%4% new div section</p><p>with two paragraphs %5%</p></div></div><p>new paragraph outside parent div</p>');

        $this->selectKeyword(5);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('new paragraph inside parent div');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p><p>new paragraph in child div</p></div><p>new paragraph in parent div</p><p>new paragraph in parent div</p><div><p>%4% new div section</p><p>with two paragraphs %5%</p></div><p>new paragraph inside parent div</p></div><p>new paragraph outside parent div</p>');

        $this->selectKeyword(5);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('new paragraph inside child div');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p><p>new paragraph in child div</p></div><p>new paragraph in parent div</p><p>new paragraph in parent div</p><div><p>%4% new div section</p><p>with two paragraphs %5%</p><p>new paragraph inside child div</p></div><p>new paragraph inside parent div</p></div><p>new paragraph outside parent div</p>');


    }//end testUsingMultiplePAndDivTagsInContent()


    /**
     * Test format icons in the inline toolbar when selecting two P section
     *
     * @return void
     */
    public function testApplyingFormatsAroundTwoPTagsUsingTheInlineToolbar()
    {
        $this->selectKeyword(1, 3);

        // Check the status of the format icons in the toolbars
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, NULL, 'disabled');

        // Test applying Div around the two P sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', NULL, 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, NULL, 'disabled');

        // Test applying a Quote around the two P sections
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></blockquote>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'active', 'disabled');
        $this->clickInlineToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p>');

    }//end testApplyingFormatsAroundTwoPTagsUsingTheInlineToolbar()


    /**
     * Test format icons in the top toolbar when selecting two P section
     *
     * @return void
     */
    public function testApplyingFormatsAroundTwoPTagsUsingTheTopToolbar()
    {
        $this->selectKeyword(1, 3);

        // Check the status of the format icons in the toolbar
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, NULL, 'disabled');

        // Test applying Div around the two P sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', NULL, 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, NULL, 'disabled');

        // Test applying a Quote around the two P sections
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></blockquote>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'active', 'disabled');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p>');

    }//end testApplyingFormatsAroundTwoPTagsUsingTheTopToolbar()


    /**
     * Test format icons in the inline toolbar when selecting a P and Div section
     *
     * @return void
     */
    public function testApplyingFormatsAroundPAndDivTagUsingInlineToolbar()
    {
        // Test Div and P
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><p>sit %2% <strong>%3%</strong></p>');

        // Check the status of the icons
        $this->selectKeyword(1, 3);
        $this->clickinlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div>%1% xtn dolor</div><p>sit %2% <strong>%3%</strong></p></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><p>sit %2% <strong>%3%</strong></p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test P and Div
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><div>sit %2% <strong>%3%</strong></div>');

        // Check the status of the icons
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><div>sit %2% <strong>%3%</strong></div></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><div>sit %2% <strong>%3%</strong></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundPAndDivTagUsingInlineToolbar()


    /**
     * Test format icons in the top toolbar when selecting a P and Div section
     *
     * @return void
     */
    public function testApplyingFormatsAroundPAndDivTagUsingTopToolbar()
    {
        // Test Div and P
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><p>sit %2% <strong>%3%</strong></p>');

        // Check the status of the icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div>%1% xtn dolor</div><p>sit %2% <strong>%3%</strong></p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><p>sit %2% <strong>%3%</strong></p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test P and Div
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><div>sit %2% <strong>%3%</strong></div>');

        // Check the status of the icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><div>sit %2% <strong>%3%</strong></div></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><div>sit %2% <strong>%3%</strong></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundPAndDivTagUsingTopToolbar()


    /**
     * Test applying formats using the inline toolbar using the P and Quote tag
     *
     * @return void
     */
    public function testApplyingFormatsAroundPAndQuoteTagUsingInlineToolbar()
    {
        // Test Quote and P
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><p>sit %2% <strong>%3%</strong></p>');

        // Check the status of the icons
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><blockquote><p>%1% xtn dolor</p></blockquote><p>sit %2% <strong>%3%</strong></p></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><p>sit %2% <strong>%3%</strong></p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test P and Quote
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');

        // Check the status of the icon
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundPAndQuoteTagUsingInlineToolbar()


    /**
     * Test applying formats using the top toolbar using the P and Quote tag
     *
     * @return void
     */
    public function testApplyingFormatsAroundPAndQuoteTagUsingTopToolbar()
    {
        // Test Quote and P
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><p>sit %2% <strong>%3%</strong></p>');

        // Check the status of the icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><blockquote><p>%1% xtn dolor</p></blockquote><p>sit %2% <strong>%3%</strong></p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><p>sit %2% <strong>%3%</strong></p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test P and Quote
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');

        // Check the status of the icon
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundPAndQuoteTagUsingTopToolbar()


    /**
     * Test applying formats using the inline toolbar around a P and Pre tag
     *
     * @return void
     */
    public function testApplyingFormatsAroundPAndPreTagUsingInlineToolbar()
    {
        // Test Pre and P
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><p>sit %2% <strong>%3%</strong></p>');

        // Check the status of the icons
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><pre>%1% xtn dolor</pre><p>sit %2% <strong>%3%</strong></p></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><p>sit %2% <strong>%3%</strong></p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test P and Pre
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><pre>sit %2% <strong>%3%</strong></pre>');

        // Check the status of the icons
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><pre>sit %2% <strong>%3%</strong></pre></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><pre>sit %2% <strong>%3%</strong></pre>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundPAndPreTagUsingInlineToolbar()


    /**
     * Test applying formats using the top toolbar around a P and Pre tag
     *
     * @return void
     */
    public function testApplyingFormatsAroundPAndPreTagUsingTopToolbar()
    {
        // Test Pre and P
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><p>sit %2% <strong>%3%</strong></p>');

        // Check the status of the icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><pre>%1% xtn dolor</pre><p>sit %2% <strong>%3%</strong></p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><p>sit %2% <strong>%3%</strong></p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test P and Pre
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><pre>sit %2% <strong>%3%</strong></pre>');

        // Check the status of the icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><pre>sit %2% <strong>%3%</strong></pre></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><pre>sit %2% <strong>%3%</strong></pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundPAndPreTagUsingTopToolbar()


    /**
     * Test applying formats using the inline toolbar around two Div tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundTwoDivTagsUsingTheInlineToolbar()
    {
        // Change the P's to Div's
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><div>sit %2% <strong>%3%</strong></div>');

        // Check the status of the icons
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div>%1% xtn dolor</div><div>sit %2% <strong>%3%</strong></div></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><div>sit %2% <strong>%3%</strong></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');


    }//end testApplyingFormatsAroundTwoDivTagsUsingTheInlineToolbar()


    /**
     * Test applying formats using the top toolbar around two Div tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundTwoDivTagsUsingTheTopToolbar()
    {
        // Change the P's to Div's
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><div>sit %2% <strong>%3%</strong></div>');

        // Check the status of the icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div>%1% xtn dolor</div><div>sit %2% <strong>%3%</strong></div></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><div>sit %2% <strong>%3%</strong></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');


    }//end testApplyingFormatsAroundTwoDivTagsUsingTheTopToolbar()


    /**
     * Test applying formats using the inline toolbar around Div and Quote tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundDivAndQuoteUsingInlineToolbar()
    {
        // Test Quote and Div
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><div>sit %2% <strong>%3%</strong></div>');

        // Check the status of the format icons
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><blockquote><p>%1% xtn dolor</p></blockquote><div>sit %2% <strong>%3%</strong></div></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><div>sit %2% <strong>%3%</strong></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test Div and Quote
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('Div', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');

        // Check the status of the format icons
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div>%1% xtn dolor</div><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundDivAndQuoteUsingInlineToolbar()


    /**
     * Test applying formats using the top toolbar around Div and Quote tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundDivAndQuoteUsingTopToolbar()
    {
        // Test Quote and Div
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><div>sit %2% <strong>%3%</strong></div>');

        // Check the status of the format icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><blockquote><p>%1% xtn dolor</p></blockquote><div>sit %2% <strong>%3%</strong></div></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><div>sit %2% <strong>%3%</strong></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test Div and Quote
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Div', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');

        // Check the status of the format icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div>%1% xtn dolor</div><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundDivAndQuoteUsingTopToolbar()


    /**
     * Test applying formats using the inline toolbar around Div and Pre tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundDivAndPreUsingInlineToolbar()
    {
        // Test Pre and Div
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Div', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Pre', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><div>sit %2% <strong>%3%</strong></div>');

        // Check the status of the format icons
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><pre>%1% xtn dolor</pre><div>sit %2% <strong>%3%</strong></div></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><div>sit %2% <strong>%3%</strong></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test Div and Pre
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('Pre', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('Div', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><pre>sit %2% <strong>%3%</strong></pre>');

        // Check the status of the format icons
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div>%1% xtn dolor</div><pre>sit %2% <strong>%3%</strong></pre></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><pre>sit %2% <strong>%3%</strong></pre>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundDivAndPreUsingInlineToolbar()


    /**
     * Test applying formats using the top toolbar around Div and Pre tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundDivAndPreUsingTopToolbar()
    {
        // Test Pre and Div
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Div', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Pre', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><div>sit %2% <strong>%3%</strong></div>');

        // Check the status of the format icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><pre>%1% xtn dolor</pre><div>sit %2% <strong>%3%</strong></div></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><div>sit %2% <strong>%3%</strong></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test Div and Pre
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Pre', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('Div', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><pre>sit %2% <strong>%3%</strong></pre>');

        // Check the status of the format icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div>%1% xtn dolor</div><pre>sit %2% <strong>%3%</strong></pre></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><pre>sit %2% <strong>%3%</strong></pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundDivAndPreUsingTopToolbar()


    /**
     * Test applying formats using the inline toolbar around two Quote tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundTwoQuoteTagsUsingInlineToolbar()
    {
        // Change the P's to Quote tags
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');

        // Check the status of the fomrat icons
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><blockquote><p>%1% xtn dolor</p></blockquote><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundTwoQuoteTagsUsingInlineToolbar()


    /**
     * Test applying formats using the top toolbar around two Quote tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundTwoQuoteTagsUsingTopToolbar()
    {
        // Change the P's to Quote tags
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');

        // Check the status of the fomrat icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><blockquote><p>%1% xtn dolor</p></blockquote><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundTwoQuoteTagsUsingTopToolbar()


    /**
     * Test applying formats using the inline toolbar around Quote and Pre tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundQuoteAndPreTagsUsingInlineToolbar()
    {
        // Test Pre and Quote
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Pre', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');

        // Check the status of the format icons
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><pre>%1% xtn dolor</pre><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test Quote and Pre
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('Pre', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><pre>sit %2% <strong>%3%</strong></pre>');

        // Check status of icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><blockquote><p>%1% xtn dolor</p></blockquote><pre>sit %2% <strong>%3%</strong></pre></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><pre>sit %2% <strong>%3%</strong></pre>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundQuoteAndPreTagsUsingInlineToolbar()


    /**
     * Test applying formats using the top toolbar around Quote and Pre tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundQuoteAndPreTagsUsingTopToolbar()
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
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');

        // Check the status of the format icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><pre>%1% xtn dolor</pre><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test Quote and Pre
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Pre', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><pre>sit %2% <strong>%3%</strong></pre>');

        // Check status of icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><blockquote><p>%1% xtn dolor</p></blockquote><pre>sit %2% <strong>%3%</strong></pre></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><pre>sit %2% <strong>%3%</strong></pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundQuoteAndPreTagsUsingTopToolbar()


    /**
     * Test applying formats using the inline toolbar around two Pre tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundTwoPreTagsUsingInlineToolbar()
    {
        // Change the P's to Pre's
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><pre>sit %2% <strong>%3%</strong></pre>');

        // Check the status of the format icons
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><pre>%1% xtn dolor</pre><pre>sit %2% <strong>%3%</strong></pre></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><pre>sit %2% <strong>%3%</strong></pre>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundTwoPreTagsUsingInlineToolbar()


    /**
     * Test applying formats using the top toolbar around two Pre tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundTwoPreTagsUsingTopToolbar()
    {
        // Change the P's to Pre's
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><pre>sit %2% <strong>%3%</strong></pre>');

        // Check the status of the format icons
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><pre>%1% xtn dolor</pre><pre>sit %2% <strong>%3%</strong></pre></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><pre>sit %2% <strong>%3%</strong></pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundTwoPreTagsUsingTopToolbar()


}//end class

?>
