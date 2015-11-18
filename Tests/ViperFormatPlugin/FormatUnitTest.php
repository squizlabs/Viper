<?php

require_once 'AbstractFormatsUnitTest.php';

class Viper_Tests_ViperFormatPlugin_FormatUnitTest extends AbstractFormatsUnitTest
{


    /**
     * Test the heading, format, class and anchor icon when selecting two words in paragraph.
     *
     * @return void
     */
    public function testFormatIcons()
    {
        $this->useTest(1);

        $this->selectKeyword(2, 3);

        // Check that headings, formats doesn't appear in the inline but class and anchor do
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'VITP Heading icon should not be available for text selection');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'VITP format icons should not be available for text selection');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'), 'VITP format icons should not be available for text selection');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon in VITP should not be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon in VITP should not be active.');

        // Check that formats and headings is disabled in the top toolbar but class and anchor do
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'disabled'), 'Formats P icon should be disabled in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should appear in the top toolbar');

    }//end testFormatIcons()


    /**
     * Test the format icon in the toolbars when applying bold and italics to a section.
     *
     * @return void
     */
    public function testFormatIconWhenApplyingBoldAndItalics()
    {
        // Check icons when applying bold to a paragraph
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));

        // Check icons when applying italics to a paragraph
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));

        // Check icons when applying bold to a div
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-div', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));

        // Check icons when applying italics to a div
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-div', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));

        // Check icons when applying bold to a quote
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-blockquote', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));

        // Check icons when applying italics to a quote
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-blockquote', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));

        // Check icons when applying bold to a pre
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-pre', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));

        // Check icons when applying italics to a pre
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-pre', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));

    }//end testFormatIconWhenApplyingBoldAndItalics()


    /**
     * Test that you can create a new P section inside a DIV and outside the DIV section.
     *
     * @return void
     */
    public function testCreatingNewPBeforeAndAfterDivSection()
    {
        $this->useTest(2);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Active p icon should appear in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Active p icon should appear in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'Active div icon should appear in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Active div icon should appear in the top toolbar');

        // Create new paragraph inside a div
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test new line %4%');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p><p>test new line %4%</p></div>');

        // Create new paragraph outside a div
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
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
        $this->useTest(2);

        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('%4% new div section');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('with two paragraphs %5%');
        $this->selectKeyword(4, 5);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);

        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></div><div><p>%4% new div section</p><p>with two paragraphs %5%</p></div>');

        $this->selectKeyword(1, 4);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></div><div><p>%4% new div section</p><p>with two paragraphs %5%</p></div></div>');

        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('new paragraph in parent div');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('new paragraph in parent div');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></div><p>new paragraph in parent div</p><p>new paragraph in parent div</p><div><p>%4% new div section</p><p>with two paragraphs %5%</p></div></div>');

        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('new paragraph in child div');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p><p>new paragraph in child div</p></div><p>new paragraph in parent div</p><p>new paragraph in parent div</p><div><p>%4% new div section</p><p>with two paragraphs %5%</p></div></div>');

        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('new paragraph outside parent div');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p><p>new paragraph in child div</p></div><p>new paragraph in parent div</p><p>new paragraph in parent div</p><div><p>%4% new div section</p><p>with two paragraphs %5%</p></div></div><p>new paragraph outside parent div</p>');

        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('new paragraph inside parent div');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p><p>new paragraph in child div</p></div><p>new paragraph in parent div</p><p>new paragraph in parent div</p><div><p>%4% new div section</p><p>with two paragraphs %5%</p></div><p>new paragraph inside parent div</p></div><p>new paragraph outside parent div</p>');

        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('new paragraph inside child div');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p><p>new paragraph in child div</p></div><p>new paragraph in parent div</p><p>new paragraph in parent div</p><div><p>%4% new div section</p><p>with two paragraphs %5%</p><p>new paragraph inside child div</p></div><p>new paragraph inside parent div</p></div><p>new paragraph outside parent div</p>');


    }//end testUsingMultiplePAndDivTagsInContent()


    /**
     * Test applying a div around two P's and then changing it to a quote
     *
     * @return void
     */
    public function testApplyingDivAroundTwoPTagsAndChangingToAQuote()
    {
        // Using the inline toolbar
        $this->useTest(1);

        // Apply the Div
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', NULL, 'disabled');

        // Change the Div to a Quote
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></blockquote>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'active', 'disabled');

        // Change the quote to a div
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><div>sit %2% <strong>%3%</strong></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Using the top toolbar
        $this->useTest(1);

        // Apply the Div
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', NULL, 'disabled');

        // Change the Div to a Quote
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></blockquote>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'active', 'disabled');

        // Change the quote to a div
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><div>sit %2% <strong>%3%</strong></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingDivAroundTwoPTagsAndChangingToAQuote()


    /**
     * Test format icons iwhen selecting a P and Div section
     *
     * @return void
     */
    public function testApplyingFormatsAroundPAndDivTag()
    {
        // Using the inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 3);
        $this->clickinlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the div and p sections
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

        // Using the top toolbar
        $this->useTest(3);
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

    }//end testApplyingFormatsAroundPAndDivTag()


    /**
     * Test applying formats using the P and Quote tag
     *
     * @return void
     */
    public function testApplyingFormatsAroundPAndQuoteTag()
    {
        // Using the inline toolbar
        $this->useTest(4);
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

        // Using the top toolbar
        $this->useTest(4);
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

    }//end testApplyingFormatsAroundPAndQuoteTag()


    /**
     * Test applying formats around a P and Pre tag
     *
     * @return void
     */
    public function testApplyingFormatsAroundPAndPreTag()
    {

        // Using the inline toolbar
        $this->useTest(5);
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

        // Using the top toolbar
        $this->useTest(5);
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
        sleep(1);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><pre>sit %2% <strong>%3%</strong></pre></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><p>%1% xtn dolor</p><pre>sit %2% <strong>%3%</strong></pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingFormatsAroundPAndPreTag()


    /**
     * Test applying formats around two Div tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundTwoDivTags()
    {
        // Using the inline toolbar
        $this->useTest(6);
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

        // Using the top toolbar
        $this->useTest(6);
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

    }//end testApplyingFormatsAroundTwoDivTags()


    /**
     * Test applying formats around Div and Quote tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundDivAndQuote()
    {
        // Using the inline toolbar
        $this->useTest(7);
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
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

        // Check the status of the format icons.
        $this->clickKeyword(1);
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

        // Using the top toolbar
        $this->useTest(7);
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

    }//end testApplyingFormatsAroundDivAndQuote()


    /**
     * Test applying formats around Div and Pre tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundDivAndPre()
    {
        // Using the inline toolbar
        $this->useTest(8);
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
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);

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

        // Using the top toolbar
        $this->useTest(8);
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
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

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

    }//end testApplyingFormatsAroundDivAndPre()


    /**
     * Test applying formats around two Quote tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundTwoQuoteTags()
    {
        // Using the inline toolbar
        $this->useTest(9);
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

        // Using the top toolbar
        $this->useTest(9);
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

    }//end testApplyingFormatsAroundTwoQuoteTags()


    /**
     * Test applying formats around Quote and Pre tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundQuoteAndPreTags()
    {
        // Using inline toolbar
        $this->useTest(10);
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
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><pre>sit %2% <strong>%3%</strong></pre>');

        // Check status of icons
        $this->selectKeyword(1, 3);
        $this->clickInlineToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Test applying Div around the two sections
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div><blockquote><p>%1% xtn dolor</p></blockquote><pre>sit %2% <strong>%3%</strong></pre></div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p></blockquote><pre>sit %2% <strong>%3%</strong></pre>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('disabled', NULL, 'disabled', 'disabled');

        // Using top toolbar
        $this->useTest(10);
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
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

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

    }//end testApplyingFormatsAroundQuoteAndPreTags()


    /**
     * Test applying formats uaround two Pre tags
     *
     * @return void
     */
    public function testApplyingFormatsAroundTwoPreTags()
    {
        // Using inline toolbar
        $this->useTest(11);
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

        // Using top toolbar
        $this->useTest(11);
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

    }//end testApplyingFormatsAroundTwoPreTags()


    /**
     * Test applying different formats to different HTML structures.
     *
     * @return void
     */
    public function testComplexHTMLStructureConversion()
    {
        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div><blockquote><p>lorem %1%</p></blockquote><div><p>Test %2%</p></div></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div><div><blockquote><p>lorem %1%</p></blockquote><div><p>Test %2%</p></div></div></div>');

        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div><div><p>%1% lorem</p></div><p>Test %2%</p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div><p>%1% lorem</p></div><p>Test %2%</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div><div><p>lorem %1%</p></div><p>Test %2%</p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div><div><div><p>lorem %1%</p></div><p>Test %2%</p></div></div>');

        $this->useTest(4);
        $html = '<div><div><blockquote><p>%1% lorem</p></blockquote></div></div><div>Test %2%</div>';
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>'.$html.'</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->assertHTMLMatch($html);

        $this->useTest(5);
        $html = '<div><div><blockquote><p>lorem %1%</p></blockquote></div></div><div><p>%2% Test</p></div>';
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>'.$html.'</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->assertHTMLMatch('<div><div>'.$html.'</div></div>');

        $this->useTest(6);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div><div><p>%1% lorem</p></div><div><div><p>%2% test</p></div></div></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        //To do: commenting this out for now and will add back in once Sertan fixes issue
        /*$this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->assertHTMLMatch('<div><p>%1% lorem</p></div><div><div><p>%2% test</p></div></div>');*/

        $this->useTest(7);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-div');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, NULL);
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<div><p>test test</p><p>%1% %2%</p><p>test test</p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('P', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, NULL);
        $this->assertHTMLMatch('<div><p>test test</p>%1% %2%<p>test test</p></div>');

        $this->useTest(8);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-div');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, NULL);
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<div><p>test test</p><p>%1% %2%</p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('P', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, NULL);
        $this->assertHTMLMatch('<div><p>test test</p>%1% %2%</div>');

        $this->useTest(9);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-div');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, NULL);
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<div><blockquote><p>%1% %2%</p></blockquote><p>test test</p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, NULL);
        $this->assertHTMLMatch('<div>%1% %2%<p>test test</p></div>');

    }//end testComplexHTMLStructureConversion()


    /**
     * Test that a list item or whole list selection does not enable formats icons.
     *
     * @return void
     */
    public function testFormatIconInList()
    {

        $this->useTest(12);

        // Test ul list
        $this->clickKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the top toolbar.');

        $this->clickKeyword(2);
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the top toolbar.');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats button should not be available');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the top toolbar.');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats button should not be available');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the top toolbar.');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats button should not be available');

        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the top toolbar.');

        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New parra');
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Formats icon should appear in the top toolbar.');

        // Test ol list
        $this->clickKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the top toolbar.');

        $this->clickKeyword(1);
        sleep(1);

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the top toolbar.');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats button should not be available');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the top toolbar.');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats button should not be available');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the top toolbar.');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats button should not be available');

        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the top toolbar.');

        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New parra');
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Formats icon should appear in the top toolbar.');

    }//end testFormatIconInList()


    /**
     * Test applying formats to an image
     *
     * @return void
     */
    public function testApplyingFormatsToAnImage()
    {
        $this->useTest(13);

        // Check icon is disabled for the image
        $this->clickElement('img', 0);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', NULL));

        // Select the P in the linage and check the icon
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'));

        // Change format around the image using the inline toolbar
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% XuT</p><div><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/></div><p>LABS is ORSM</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% XuT</p><blockquote><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/></p></blockquote><p>LABS is ORSM</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% XuT</p><pre><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/></pre><p>LABS is ORSM</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% XuT</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/></p><p>LABS is ORSM</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        // Change format around the image using the top toolbar
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% XuT</p><div><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/></div><p>LABS is ORSM</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% XuT</p><blockquote><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/></p></blockquote><p>LABS is ORSM</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% XuT</p><pre><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/></pre><p>LABS is ORSM</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% XuT</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167"/></p><p>LABS is ORSM</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

    }//end testApplyingFormatsToAnImage()


    /**
     * Test that underline can't be added with keyboard shortcuts
     *
     * @return void
     */
    public function testUnderlineFormat()
    {

        // Test not applying underline at the start of a paragraph
        $this->useTest(14);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + u');
        $this->assertHTMLMatch('<p>%1%Test %2% content %3%</p><p><u>%4%Test %5% content %6%</u></p>');

        // Test not applying underline in the middle of a paragraph
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + u');
        $this->assertHTMLMatch('<p>%1%Test %2% content %3%</p><p><u>%4%Test %5% content %6%</u></p>');

        // Test not applying underline at the end of a paragraph
        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.CMD + u');
        $this->assertHTMLMatch('<p>%1%Test %2% content %3%</p><p><u>%4%Test %5% content %6%</u></p>');

        // Test not applying underline to a paragraph
        $this->selectKeyword(1,3);
        $this->sikuli->keyDown('Key.CMD + u');
        $this->assertHTMLMatch('<p>%1%Test %2% content %3%</p><p><u>%4%Test %5% content %6%</u></p>');

        // Test removing underline with remove format at the start of a paragraph
        $this->useTest(14);
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1%Test %2% content %3%</p><p>%4%<u>Test %5% content %6%</u></p>');

        // Test removing underline with remove format in the middle of a paragraph
        $this->useTest(14);
        $this->selectKeyword(5);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1%Test %2% content %3%</p><p><u>%4%Test </u>%5%<u> content %6%</u></p>');

        // Test removing underline with remove format at the end of a paragraph
        $this->useTest(14);
        $this->selectKeyword(6);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1%Test %2% content %3%</p><p><u>%4%Test %5% content </u>%6%</p>');

        // Test removing underline with remove format for an entire paragraph
        $this->useTest(14);
        $this->selectKeyword(4,6);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1%Test %2% content %3%</p><p>%4%Test %5% content %6%</p>');

    }//end testUnderlineFormat()


    /**
     * Test combinations of formats beginning with bold
     *
     * @return void
     */
    public function testBoldWithOneAdditionalFormat()
    {
        // Test applying bold and italics
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing bold and italics
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying bold and italics
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><em><strong>%1%</strong></em></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying bold and subscript
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        // Test removing bold and subscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying bold and subscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<p><em><strong>%1%</strong></em></p><p><sub><strong>%2%</strong></sub></p><p>%3%</p><p>%4%</p>');

        // Test applying bold and superscript
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        // Test removing bold and superscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying bold and superscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<p><em><strong>%1%</strong></em></p><p><sub><strong>%2%</strong></sub></p><p><sup><strong>%3%</strong></sup></p><p>%4%</p>');

        // Test applying bold and strikethrough
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing bold and strikethrough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying bold and strikethrough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><em><strong>%1%</strong></em></p><p><sub><strong>%2%</strong></sub></p><p><sup><strong>%3%</strong></sup></p><p><del><strong>%4%</strong></del></p>');

    }//end testBoldWithOneAdditionalFormat()


    /**
     * Test combinations of formats beginning with bold
     *
     * @return void
     */
    public function testBoldWithTwoAdditionalFormats()
    {
        // Test applying bold and subscript then italic
        $this->useTest(15);
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
        $this->assertHTMLMatch('<p><em><sub><strong>%1%</strong></sub></em></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying bold and subscript then strikethrough
        $this->selectKeyword(2);
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
        $this->assertHTMLMatch('<p><em><sub><strong>%1%</strong></sub></em></p><p><del><sub><strong>%2%</strong></sub></del></p><p>%3%</p><p>%4%</p>');

        // Test applying bold and superscript then italic
        $this->useTest(15);
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
        $this->assertHTMLMatch('<p><em><sup><strong>%1%</strong></sup></em></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying bold and superscript then strikethrough
        $this->selectKeyword(2);
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
        $this->assertHTMLMatch('<p><em><sup><strong>%1%</strong></sup></em></p><p><del><sup><strong>%2%</strong></sup></del></p><p>%3%</p><p>%4%</p>');

        // Test applying bold and strikethrough then italic
        $this->useTest(15);
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
        $this->assertHTMLMatch('<p><em><del><strong>%1%</strong></del></em></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying bold and strikethrough then subscript
        $this->selectKeyword(2);
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
        $this->assertHTMLMatch('<p><em><del><strong>%1%</strong></del></em></p><p><sub><del><strong>%2%</strong></del></sub></p><p>%3%</p><p>%4%</p>');

        // Test applying bold and strikethrough then superscript
        $this->selectKeyword(3);
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
        $this->assertHTMLMatch('<p><em><del><strong>%1%</strong></del></em></p><p><sub><del><strong>%2%</strong></del></sub></p><p><sup><del><strong>%3%</strong></del></sup></p><p>%4%</p>');

    }//end testBoldWithTwoAdditionalFormats()


    /**
     * Test combinations of formats beginning with bold
     *
     * @return void
     */
    public function testBoldWithThreeAdditionalFormats()
    {

        // Test applying bold and italic and subscript then strikethough
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing bold and italic and subscript then strikethough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying bold and italic and subscript then strikethough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><del><sub><em><strong>%1%</strong></em></sub></del></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying bold and italic and superscript then strikethough
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing bold and italic and superscript then strikethough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying bold and italic and superscript then strikethough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><del><sub><em><strong>%1%</strong></em></sub></del></p><p><del><sup><em><strong>%2%</strong></em></sup></del></p><p>%3%</p><p>%4%</p>');

        // Test applying bold and italic and strikethough then subscript
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        // Test removing bold and italic and strikethough then subscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying bold and italic and strikethough then subscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<p><del><sub><em><strong>%1%</strong></em></sub></del></p><p><del><sup><em><strong>%2%</strong></em></sup></del></p><p><sub><del><em><strong>%3%</strong></em></del></sub></p><p>%4%</p>');

        // Test applying bold and italic and strikethough then superscript
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        // Test removing bold and italic and strikethough then superscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying bold and italic and strikethough then superscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<p><del><sub><em><strong>%1%</strong></em></sub></del></p><p><del><sup><em><strong>%2%</strong></em></sup></del></p><p><sub><del><em><strong>%3%</strong></em></del></sub></p><p><sup><del><em><strong>%4%</strong></em></del></sup></p>');

        // Test applying bold and subscript and italic then strikethough
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing bold and subscript and italic then strikethough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying bold and subscript and italic then strikethough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><del><em><sub><strong>%1%</strong></sub></em></del></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying bold and subscript and strikethough then italic
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing bold and subscript and strikethough then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying bold and subscript and strikethough then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><del><em><sub><strong>%1%</strong></sub></em></del></p><p><em><del><sub><strong>%2%</strong></sub></del></em></p><p>%3%</p><p>%4%</p>');

        // Test applying bold and superscript and italic then strikethough
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing bold and superscript and italic then strikethough
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying bold and superscript and italic then strikethough
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><del><em><sup><strong>%1%</strong></sup></em></del></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying bold and superscript and strikethough then italic
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing bold and superscript and strikethough then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying bold and superscript and strikethough then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><del><em><sup><strong>%1%</strong></sup></em></del></p><p><em><del><sup><strong>%2%</strong></sup></del></em></p><p>%3%</p><p>%4%</p>');

        // Test applying bold and strikethough and italic then subscript
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        // Test removing bold and strikethough and italic then subscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying bold and strikethough and italic then subscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<p><sub><em><del><strong>%1%</strong></del></em></sub></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying bold and strikethough and italic then subscript
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        // Test removing bold and strikethough and italic then subscript
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying bold and strikethough and italic then subscript
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<p><sub><em><del><strong>%1%</strong></del></em></sub></p><p><sup><em><del><strong>%2%</strong></del></em></sup></p><p>%3%</p><p>%4%</p>');

        // Test applying bold and strikethough and subscript then italic
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing bold and strikethough and subscript then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying bold and strikethough and subscript then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><sub><em><del><strong>%1%</strong></del></em></sub></p><p><sup><em><del><strong>%2%</strong></del></em></sup></p><p><em><sub><del><strong>%3%</strong></del></sub></em></p><p>%4%</p>');

        // Test applying bold and strikethough and superscript then italic
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing bold and strikethough and superscript then italic
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying bold and strikethough and superscript then italic
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><sub><em><del><strong>%1%</strong></del></em></sub></p><p><sup><em><del><strong>%2%</strong></del></em></sup></p><p><em><sub><del><strong>%3%</strong></del></sub></em></p><p><em><sup><del><strong>%4%</strong></del></sup></em></p>');

    }//end testBoldWithThreeAdditionalFormats()


    /**
     * Test combinations of formats beginning with italic
     *
     * @return void
     */
    public function testItalicWithOneAdditionalFormat()
    {
        // Test applying italic and bold
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing italic and bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying italic and bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><strong><em>%1%</em></strong></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying italic and subscript
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        // Test removing italic and subscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying italic and subscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<p><strong><em>%1%</em></strong></p><p><sub><em>%2%</em></sub></p><p>%3%</p><p>%4%</p>');

        // Test applying italic and superscript
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        // Test removing italic and superscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying italic and superscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<p><strong><em>%1%</em></strong></p><p><sub><em>%2%</em></sub></p><p><sup><em>%3%</em></sup></p><p>%4%</p>');

        // Test applying italic and strikethrough
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing italic and strikethrough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying italic and strikethrough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><strong><em>%1%</em></strong></p><p><sub><em>%2%</em></sub></p><p><sup><em>%3%</em></sup></p><p><del><em>%4%</em></del></p>');

    }//end testItalicWithOneAdditionalFormat()


    /**
     * Test combinations of formats beginning with italic
     *
     * @return void
     */
    public function testItalicWithTwoAdditionalFormats()
    {
        // Test applying italic and subscript then bold
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing italic and subscript then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying italic and subscript then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><strong><sub><em>%1%</em></sub></strong></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying italic and subscript then strikethrough
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing italic and subscript then strikethrough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying italic and subscript then strikethrough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><strong><sub><em>%1%</em></sub></strong></p><p><del><sub><em>%2%</em></sub></del></p><p>%3%</p><p>%4%</p>');

        // Test applying italic and superscript then bold
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing italic and superscript then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying italic and superscript then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><strong><sup><em>%1%</em></sup></strong></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying italic and superscript then strikethrough
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing italic and superscript then strikethrough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying italic and superscript then strikethrough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><strong><sup><em>%1%</em></sup></strong></p><p><del><sup><em>%2%</em></sup></del></p><p>%3%</p><p>%4%</p>');

        // Test applying italic and strikethrough then bold
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing italic and strikethrough then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying italic and strikethrough then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><strong><del><em>%1%</em></del></strong></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying italic and strikethrough then subscript
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        // Test removing italic and strikethrough then subscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying italic and strikethrough then subscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<p><strong><del><em>%1%</em></del></strong></p><p><sub><del><em>%2%</em></del></sub></p><p>%3%</p><p>%4%</p>');

        // Test applying italic and strikethrough then superscript
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        // Test removing italic and strikethrough then superscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying italic and strikethrough then superscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<p><strong><del><em>%1%</em></del></strong></p><p><sub><del><em>%2%</em></del></sub></p><p><sup><del><em>%3%</em></del></sup></p><p>%4%</p>');

    }//end testItalicWithTwoAdditionalFormats()


    /**
     * Test combinations of formats beginning with italic
     *
     * @return void
     */
    public function testItalicWithThreeAdditionalFormats()
    {

        // Test applying italic and bold and subscript then strikethough
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing italic and bold and subscript then strikethough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying italic and bold and subscript then strikethough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><del><sub><strong><em>%1%</em></strong></sub></del></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying italic and bold and superscript then strikethough
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing italic and bold and superscript then strikethough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying italic and bold and superscript then strikethough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><del><sub><strong><em>%1%</em></strong></sub></del></p><p><del><sup><strong><em>%2%</em></strong></sup></del></p><p>%3%</p><p>%4%</p>');

        // Test applying italic and bold and strikethough then subscript
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        // Test removing italic and bold and strikethough then subscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying italic and bold and strikethough then subscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<p><del><sub><strong><em>%1%</em></strong></sub></del></p><p><del><sup><strong><em>%2%</em></strong></sup></del></p><p><sub><del><strong><em>%3%</em></strong></del></sub></p><p>%4%</p>');

        // Test applying italic and bold and strikethough then superscript
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        // Test removing italic and bold and strikethough then superscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying italic and bold and strikethough then superscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<p><del><sub><strong><em>%1%</em></strong></sub></del></p><p><del><sup><strong><em>%2%</em></strong></sup></del></p><p><sub><del><strong><em>%3%</em></strong></del></sub></p><p><sup><del><strong><em>%4%</em></strong></del></sup></p>');

        // Test applying italic and subscript and bold then strikethough
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing italic and subscript and bold then strikethough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying italic and subscript and bold then strikethough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><del><strong><sub><em>%1%</em></sub></strong></del></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying italic and subscript and strikethough then bold
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing italic and subscript and strikethough then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying italic and subscript and strikethough then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><del><strong><sub><em>%1%</em></sub></strong></del></p><p><strong><del><sub><em>%2%</em></sub></del></strong></p><p>%3%</p><p>%4%</p>');

        // Test applying italic and superscript and bold then strikethough
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing italic and superscript and bold then strikethough
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying italic and superscript and bold then strikethough
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><del><strong><sup><em>%1%</em></sup></strong></del></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying italic and superscript and strikethough then bold
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing italic and superscript and strikethough then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying italic and superscript and strikethough then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><del><strong><sup><em>%1%</em></sup></strong></del></p><p><strong><del><sup><em>%2%</em></sup></del></strong></p><p>%3%</p><p>%4%</p>');

        // Test applying italic and strikethough and bold then subscript
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        // Test removing italic and strikethough and bold then subscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying italic and strikethough and bold then subscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<p><sub><strong><del><em>%1%</em></del></strong></sub></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying italic and strikethough and bold then subscript
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        // Test removing italic and strikethough and bold then subscript
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying italic and strikethough and bold then subscript
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<p><sub><strong><del><em>%1%</em></del></strong></sub></p><p><sup><strong><del><em>%2%</em></del></strong></sup></p><p>%3%</p><p>%4%</p>');

        // Test applying italic and strikethough and subscript then bold
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing italic and strikethough and subscript then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying italic and strikethough and subscript then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><sub><strong><del><em>%1%</em></del></strong></sub></p><p><sup><strong><del><em>%2%</em></del></strong></sup></p><p><strong><sub><del><em>%3%</em></del></sub></strong></p><p>%4%</p>');

        // Test applying italic and strikethough and superscript then bold
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing italic and strikethough and superscript then bold
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying italic and strikethough and superscript then bold
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><sub><strong><del><em>%1%</em></del></strong></sub></p><p><sup><strong><del><em>%2%</em></del></strong></sup></p><p><strong><sub><del><em>%3%</em></del></sub></strong></p><p><strong><sup><del><em>%4%</em></del></sup></strong></p>');

    }//end testItalicWithThreeAdditionalFormats()


    /**
     * Test combinations of formats beginning with subscript
     *
     * @return void
     */
    public function testSubscriptWithOneAdditionalFormat()
    {
        // Test applying subscript and bold
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing subscript and bold
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying subscript and bold
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><strong><sub>%1%</sub></strong></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying subscript and italic
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing subscript and italic
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying subscript and italic
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><strong><sub>%1%</sub></strong></p><p><em><sub>%2%</sub></em></p><p>%3%</p><p>%4%</p>');

        // Test applying subscript and strikethrough
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing subscript and strikethrough
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying subscript and strikethrough
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><strong><sub>%1%</sub></strong></p><p><em><sub>%2%</sub></em></p><p>%3%</p><p><del><sub>%4%</sub></del></p>');

    }//end testSubscriptWithOneAdditionalFormat()


    /**
     * Test combinations of formats beginning with subscript
     *
     * @return void
     */
    public function testSubscriptWithTwoAdditionalFormats()
    {
        // Test applying subscript and bold then italic
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing subscript and bold then italic
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying subscript and bold then italic
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><em><strong><sub>%1%</sub></strong></em></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying subscript and bold then strikethrough
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing subscript and bold then strikethrough
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying subscript and bold then strikethrough
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><em><strong><sub>%1%</sub></strong></em></p><p><del><strong><sub>%2%</sub></strong></del></p><p>%3%</p><p>%4%</p>');

        // Test applying subscript and strikethrough then italic
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing subscript and strikethrough then italic
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying subscript and strikethrough then italic
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><em><del><sub>%1%</sub></del></em></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying subscript and strikethrough then bold
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing subscript and strikethrough then bold
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying subscript and strikethrough then bold
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><em><del><sub>%1%</sub></del></em></p><p><strong><del><sub>%2%</sub></del></strong></p><p>%3%</p><p>%4%</p>');

    }//end testSubscriptWithTwoAdditionalFormats()


    /**
     * Test combinations of formats beginning with subscript
     *
     * @return void
     */
    public function testSubscriptWithThreeAdditionalFormats()
    {

        // Test applying subscript and bold and italic then strikethough
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing subscript and bold and italic then strikethough
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying subscript and bold and italic then strikethough
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><del><em><strong><sub>%1%</sub></strong></em></del></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying subscript and bold and strikethough then italic
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing subscript and bold and strikethough then italic
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying subscript and bold and strikethough then italic
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><del><em><strong><sub>%1%</sub></strong></em></del></p><p><em><del><strong><sub>%2%</sub></strong></del></em></p><p>%3%</p><p>%4%</p>');

        // Test applying subscript and italic and strikethough then bold
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing subscript and italic and bold then strikethrough
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying subscript and italic and bold then strikethrough
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><del><em><strong><sub>%1%</sub></strong></em></del></p><p><em><del><strong><sub>%2%</sub></strong></del></em></p><p><del><strong><em><sub>%3%</sub></em></strong></del></p><p>%4%</p>');

        // Test applying subscript and italic and bold then strikethrough
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing subscript and italic and strikethough then bold
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying subscript and italic and strikethough then bold
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><del><em><strong><sub>%1%</sub></strong></em></del></p><p><em><del><strong><sub>%2%</sub></strong></del></em></p><p><del><strong><em><sub>%3%</sub></em></strong></del></p><p><strong><del><em><sub>%4%</sub></em></del></strong></p>');

        // Test applying subscript and strikethough and bold then italic
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing subscript and strikethough and bold then italic
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying subscript and strikethough and bold then italic
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><em><strong><del><sub>%1%</sub></del></strong></em></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying subscript and strikethough and italic then bold
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing subscript and strikethough and italic then bold
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying subscript and strikethough and italic then bold
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><em><strong><del><sub>%1%</sub></del></strong></em></p><p><strong><em><del><sub>%2%</sub></del></em></strong></p><p>%3%</p><p>%4%</p>');

    }//end testSubscriptWithThreeAdditionalFormats()


    /**
     * Test combinations of formats beginning with superscript
     *
     * @return void
     */
    public function testSuperscriptWithOneAdditionalFormat()
    {
        // Test applying superscript and bold
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing superscript and bold
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying superscript and bold
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><strong><sup>%1%</sup></strong></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying superscript and italic
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing superscript and italic
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying superscript and italic
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><strong><sup>%1%</sup></strong></p><p><em><sup>%2%</sup></em></p><p>%3%</p><p>%4%</p>');

        // Test applying superscript and strikethrough
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing superscript and strikethrough
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying superscript and strikethrough
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><strong><sup>%1%</sup></strong></p><p><em><sup>%2%</sup></em></p><p>%3%</p><p><del><sup>%4%</sup></del></p>');

    }//end testSuperscriptWithOneAdditionalFormat()


    /**
     * Test combinations of formats beginning with superscript
     *
     * @return void
     */
    public function testSuperscriptWithTwoAdditionalFormats()
    {
        // Test applying superscript and bold then italic
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing superscript and bold then italic
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying superscript and bold then italic
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><em><strong><sup>%1%</sup></strong></em></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying superscript and bold then strikethrough
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing superscript and bold then strikethrough
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying superscript and bold then strikethrough
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><em><strong><sup>%1%</sup></strong></em></p><p><del><strong><sup>%2%</sup></strong></del></p><p>%3%</p><p>%4%</p>');

        // Test applying superscript and strikethrough then italic
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing superscript and strikethrough then italic
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying superscript and strikethrough then italic
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><em><del><sup>%1%</sup></del></em></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying superscript and strikethrough then bold
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing superscript and strikethrough then bold
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying superscript and strikethrough then bold
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><em><del><sup>%1%</sup></del></em></p><p><strong><del><sup>%2%</sup></del></strong></p><p>%3%</p><p>%4%</p>');

    }//end testSuperscriptWithTwoAdditionalFormats()


    /**
     * Test combinations of formats beginning with superscript
     *
     * @return void
     */
    public function testSuperscriptWithThreeAdditionalFormats()
    {

        // Test applying superscript and bold and italic then strikethough
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing superscript and bold and italic then strikethough
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying superscript and bold and italic then strikethough
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><del><em><strong><sup>%1%</sup></strong></em></del></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying superscript and bold and strikethough then italic
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing superscript and bold and strikethough then italic
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying superscript and bold and strikethough then italic
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><del><em><strong><sup>%1%</sup></strong></em></del></p><p><em><del><strong><sup>%2%</sup></strong></del></em></p><p>%3%</p><p>%4%</p>');

        // Test applying superscript and italic and strikethough then bold
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);

        // Test removing superscript and italic and bold then strikethrough
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');

        // Test re-applying superscript and italic and bold then strikethrough
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<p><del><em><strong><sup>%1%</sup></strong></em></del></p><p><em><del><strong><sup>%2%</sup></strong></del></em></p><p><del><strong><em><sup>%3%</sup></em></strong></del></p><p>%4%</p>');

        // Test applying superscript and italic and bold then strikethrough
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing superscript and italic and strikethough then bold
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying superscript and italic and strikethough then bold
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><del><em><strong><sup>%1%</sup></strong></em></del></p><p><em><del><strong><sup>%2%</sup></strong></del></em></p><p><del><strong><em><sup>%3%</sup></em></strong></del></p><p><strong><del><em><sup>%4%</sup></em></del></strong></p>');

        // Test applying superscript and strikethough and bold then italic
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing superscript and strikethough and bold then italic
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying superscript and strikethough and bold then italic
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><em><strong><del><sup>%1%</sup></del></strong></em></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying superscript and strikethough and italic then bold
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing superscript and strikethough and italic then bold
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying superscript and strikethough and italic then bold
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><em><strong><del><sup>%1%</sup></del></strong></em></p><p><strong><em><del><sup>%2%</sup></del></em></strong></p><p>%3%</p><p>%4%</p>');

    }//end testSuperscriptWithThreeAdditionalFormats()


    /**
     * Test combinations of formats beginning with strikethrough
     *
     * @return void
     */
    public function testStrikethroughWithOneAdditionalFormat()
    {
        // Test applying strikethrough and bold
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing strikethrough and bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying strikethrough and bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><strong><del>%1%</del></strong></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and subscript
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        // Test removing strikethrough and subscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying strikethrough and subscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<p><strong><del>%1%</del></strong></p><p><sub><del>%2%</del></sub></p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and superscript
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        // Test removing strikethrough and superscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying strikethrough and superscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<p><strong><del>%1%</del></strong></p><p><sub><del>%2%</del></sub></p><p><sup><del>%3%</del></sup></p><p>%4%</p>');

        // Test applying strikethrough and italic
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing strikethrough and italic
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying strikethrough and italic
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><strong><del>%1%</del></strong></p><p><sub><del>%2%</del></sub></p><p><sup><del>%3%</del></sup></p><p><em><del>%4%</del></em></p>');

    }//end testStrikethroughWithOneAdditionalFormat()


    /**
     * Test combinations of formats beginning with strikethrough
     *
     * @return void
     */
    public function testStrikethroughWithTwoAdditionalFormats()
    {
        // Test applying strikethrough and subscript then bold
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing strikethrough and subscript then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying strikethrough and subscript then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><strong><sub><del>%1%</del></sub></strong></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and subscript then italic
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing strikethrough and subscript then italic
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying strikethrough and subscript then italic
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><strong><sub><del>%1%</del></sub></strong></p><p><em><sub><del>%2%</del></sub></em></p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and superscript then bold
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing strikethrough and superscript then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying strikethrough and superscript then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><strong><sup><del>%1%</del></sup></strong></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and superscript then italic
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing strikethrough and superscript then italic
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying strikethrough and superscript then italic
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><strong><sup><del>%1%</del></sup></strong></p><p><em><sup><del>%2%</del></sup></em></p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and italic then bold
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing strikethrough and italic then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying strikethrough and italic then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><strong><em><del>%1%</del></em></strong></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and italic then subscript
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        // Test removing strikethrough and italic then subscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying strikethrough and italic then subscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<p><strong><em><del>%1%</del></em></strong></p><p><sub><em><del>%2%</del></em></sub></p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and italic then superscript
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        // Test removing strikethrough and italic then superscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying strikethrough and italic then superscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<p><strong><em><del>%1%</del></em></strong></p><p><sub><em><del>%2%</del></em></sub></p><p><sup><em><del>%3%</del></em></sup></p><p>%4%</p>');

    }//end testStrikethroughWithTwoAdditionalFormats()


    /**
     * Test combinations of formats beginning with strikethrough
     *
     * @return void
     */
    public function testStrikethroughWithThreeAdditionalFormats()
    {

        // Test applying strikethrough and bold and subscript then strikethough
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing strikethrough and bold and subscript then strikethough
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying strikethrough and bold and subscript then strikethough
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><em><sub><strong><del>%1%</del></strong></sub></em></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and bold and superscript then strikethough
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing strikethrough and bold and superscript then strikethough
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying strikethrough and bold and superscript then strikethough
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><em><sub><strong><del>%1%</del></strong></sub></em></p><p><em><sup><strong><del>%2%</del></strong></sup></em></p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and bold and strikethough then subscript
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        // Test removing strikethrough and bold and strikethough then subscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying strikethrough and bold and strikethough then subscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<p><em><sub><strong><del>%1%</del></strong></sub></em></p><p><em><sup><strong><del>%2%</del></strong></sup></em></p><p><sub><em><strong><del>%3%</del></strong></em></sub></p><p>%4%</p>');

        // Test applying strikethrough and bold and strikethough then superscript
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        // Test removing strikethrough and bold and strikethough then superscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying strikethrough and bold and strikethough then superscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<p><em><sub><strong><del>%1%</del></strong></sub></em></p><p><em><sup><strong><del>%2%</del></strong></sup></em></p><p><sub><em><strong><del>%3%</del></strong></em></sub></p><p><sup><em><strong><del>%4%</del></strong></em></sup></p>');

        // Test applying strikethrough and subscript and bold then strikethough
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing strikethrough and subscript and bold then strikethough
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying strikethrough and subscript and bold then strikethough
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><em><strong><sub><del>%1%</del></sub></strong></em></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and subscript and strikethough then bold
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing strikethrough and subscript and strikethough then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying strikethrough and subscript and strikethough then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><em><strong><sub><del>%1%</del></sub></strong></em></p><p><strong><em><sub><del>%2%</del></sub></em></strong></p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and superscript and bold then strikethough
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);

        // Test removing strikethrough and superscript and bold then strikethough
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        // Test re-applying strikethrough and superscript and bold then strikethough
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><em><strong><sup><del>%1%</del></sup></strong></em></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and superscript and strikethough then bold
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing strikethrough and superscript and strikethough then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying strikethrough and superscript and strikethough then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><em><strong><sup><del>%1%</del></sup></strong></em></p><p><strong><em><sup><del>%2%</del></sup></em></strong></p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and strikethough and bold then subscript
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);

        // Test removing strikethrough and strikethough and bold then subscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        // Test re-applying strikethrough and strikethough and bold then subscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<p><sub><strong><em><del>%1%</del></em></strong></sub></p><p>%2%</p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and strikethough and bold then subscript
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);

        // Test removing strikethrough and strikethough and bold then subscript
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('superscript', 'active');

        // Test re-applying strikethrough and strikethough and bold then subscript
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<p><sub><strong><em><del>%1%</del></em></strong></sub></p><p><sup><strong><em><del>%2%</del></em></strong></sup></p><p>%3%</p><p>%4%</p>');

        // Test applying strikethrough and strikethough and subscript then bold
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing strikethrough and strikethough and subscript then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('subscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying strikethrough and strikethough and subscript then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><sub><strong><em><del>%1%</del></em></strong></sub></p><p><sup><strong><em><del>%2%</del></em></strong></sup></p><p><strong><sub><em><del>%3%</del></em></sub></strong></p><p>%4%</p>');

        // Test applying strikethrough and strikethough and superscript then bold
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);

        // Test removing strikethrough and strikethough and superscript then bold
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('superscript', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        // Test re-applying strikethrough and strikethough and superscript then bold
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<p><sub><strong><em><del>%1%</del></em></strong></sub></p><p><sup><strong><em><del>%2%</del></em></strong></sup></p><p><strong><sub><em><del>%3%</del></em></sub></strong></p><p><strong><sup><em><del>%4%</del></em></sup></strong></p>');

    }//end testStrikethroughWithThreeAdditionalFormats()


    /**
     * Test combinations of formats beginning with strikethrough
     *
     * @return void
     */
    public function testRemovingFormatsOnDifferentElements()
    {
        // Test bold using top toolbar
        $this->useTest(16);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>Text <strong>more </strong>%1%text text and more%2%<strong> text</strong></p>');

        // Test bold using inline toolbar
        $this->useTest(16);
        $this->selectKeyword(1,2);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>Text <strong>more </strong>%1%text text and more%2%<strong> text</strong></p>');

        // Test italic using top toolbar
        $this->useTest(17);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p>Text <em>more </em>%1%text text and more%2%<em> text</em></p>');

        // Test itlaic using inline toolbar
        $this->useTest(17);
        $this->selectKeyword(1,2);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p>Text <em>more </em>%1%text text and more%2%<em> text</em></p>');

        // Test strikethrough using top toolbar
        $this->useTest(18);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<p>Text <del>more </del>%1%text text and more%2%<del> text</del></p>');

        // Test subscript using top toolbar
        $this->useTest(19);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('<p>Text <sub>more </sub>%1%text text and more%2%<sub> text</sub></p>');

        // Test superscript using top toolbar
        $this->useTest(20);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<p>Text <sup>more </sup>%1%text text and more%2%<sup> text</sup></p>');
    }//end testStrikethroughWithThreeAdditionalFormats()

}//end class

?>
