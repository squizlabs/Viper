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
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));
        
        // Check icons when applying italics to a paragraph
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));

        // Check icons when applying bold to a div
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('formats-div', NULL));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-div', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));
        
        // Check icons when applying italics to a div
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('formats-div', NULL));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-div', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));

        // Check icons when applying bold to a quote
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-blockquote', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));
        
        // Check icons when applying italics to a quote
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-blockquote', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));

        // Check icons when applying bold to a pre
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-pre', 'active'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats', NULL));
        
        // Check icons when applying italics to a pre
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'disabled'));
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
        $this->sikuli->click($this->findKeyword(1));
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
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<blockquote><p>lorem %1%</p></blockquote><div><p>Test %2%</p></div>');

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
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div><p>lorem %1%</p></div><p>Test %2%</p>');

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
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->assertHTMLMatch($html);

        $this->useTest(6);
        $html = '<div><p>%1% lorem</p></div><div><div><p>%2% test</p></div></div>';
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>'.$html.'</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->assertHTMLMatch($html);

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
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<div><p>%1% %2%</p><p>test test</p></div>');

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
        $this->sikuli->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the top toolbar.');

        $this->sikuli->click($this->findKeyword(2));
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
        $this->sikuli->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the top toolbar.');

        $this->sikuli->click($this->findKeyword(1));
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


}//end class

?>
