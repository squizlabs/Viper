<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_FormatUnitTest extends AbstractViperUnitTest
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

        $this->selectKeyword('1');
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
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Active pre icon not found');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><p>sit %2% <strong>%3%</strong></p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Toolbar icon not found: toolbarIcon_blockquote_active.png');
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote>%1% xtn dolor</blockquote><p>sit %2% <strong>%3%</strong></p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'));
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><p>sit %2% <strong>%3%</strong></p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Active P icon  not found');
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
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'), 'Active PRE icon  not found');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><p>sit %2% <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active Quote icon not found');
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote>%1% xtn dolor</blockquote><p>sit %2% <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Active DIV icon not found');
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><p>sit %2% <strong>%3%</strong></p>');

        $this->clickTopToolbarButton('P', NULL, TRUE);
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'Active P icon not found');
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
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'), 'VITP format icons should not be available for text selection');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon in VITP should not be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon in VITP should not be active.');

        // Check that headings, formats, class and anchor are availble in the top toolbar
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Active P icon should appear in the top toolbar');
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
     * Test that applying P tags around two P tags.
     *
     * @return void
     */
    public function testApplyingPTagsAroundTwoPTags()
    {
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></div>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p><p>sit %2% <strong>%3%</strong></p></blockquote>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'active', TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor  sit %2% <strong>%3%</strong>  </pre>');

        // P should become enabled because the p tags are removed from the source code for the pre
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor<br /><br />sit %2% <strong>%3%</strong><br /></div>');

    }//end testApplyingPTagsAroundTwoPTags()


    /**
     * Test that applying P tags around a P and DIV tag.
     *
     * @return void
     */
    public function testApplyingPTagsAroundPAndDivTag()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><div>sit %2% <strong>%3%</strong></div></div>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p><div>sit %2% <strong>%3%</strong></div></blockquote>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'active', TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor  sit %2% <strong>%3%</strong>  </pre>');

        // P should become enabled because the p tags are removed from the source code for the pre
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor<br /><br />sit %2% <strong>%3%</strong><br /></div>');

    }//end testApplyingPTagsAroundPAndDivTag()


    /**
     * Test that applying P tags around a DIV and P tag.
     *
     * @return void
     */
    public function testApplyingPTagsAroundDivAndPTag()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div>%1% xtn dolor</div><p>sit %2% <strong>%3%</strong></p></div>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><div>%1% xtn dolor</div><p>sit %2% <strong>%3%</strong></p></blockquote>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'active', TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor  sit %2% <strong>%3%</strong>  </pre>');

        // P should become enabled because the p tags are removed from the source code for the pre
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor<br /><br />sit %2% <strong>%3%</strong><br /></div>');

    }//end testApplyingPTagsAroundDivAndPTag()


    /**
     * Test that applying P tags around two DIV tags.
     *
     * @return void
     */
    public function testApplyingPTagsAroundTwoDivTags()
    {
        // Change the paragraphs to divs for the test
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor</div><div>sit %2% <strong>%3%</strong></div>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'P icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');

        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'active', TRUE), 'P icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><p><div>%1% xtn dolor</div><div>sit %2% <strong>%3%</strong></div></p>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'P icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><div>%1% xtn dolor</div><div>sit %2% <strong>%3%</strong></div></div>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'P icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><div>%1% xtn dolor</div><div>sit %2% <strong>%3%</strong></div></blockquote>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'P icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'active', TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor  sit %2% <strong>%3%</strong>  </pre>');

    }//end testApplyingPTagsAroundTwoDivTags()


    /**
     * Test that applying P tags around a P and PRE tag.
     *
     * @return void
     */
    public function testApplyingPTagsAroundPAndPreTag()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><pre>sit %2% <strong>%3%</strong></pre></div>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p><pre>sit %2% <strong>%3%</strong></pre></blockquote>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'active', TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor  <pre>sit %2% <strong>%3%</strong></pre></pre>');

        // P should become enabled because the p tags are removed from the source code for the pre
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor<br /><br />sit %2% <strong>%3%</strong><br /></div>');

    }//end testApplyingPTagsAroundPAndPreTag()


    /**
     * Test that applying P tags around a PRE and P tag.
     *
     * @return void
     */
    public function testApplyingPTagsAroundPreAndPTag()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><pre>%1% xtn dolor</pre><p>sit %2% <strong>%3%</strong></p></div>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><pre>%1% xtn dolor</pre><p>sit %2% <strong>%3%</strong></p></blockquote>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'active', TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre><pre>%1% xtn dolor</pre>sit %2% <strong>%3%</strong>  </pre>');

        // P should become enabled because the p tags are removed from the source code for the pre
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor<br /><br />sit %2% <strong>%3%</strong><br /></div>');

    }//end testApplyingPTagsAroundPreAndPTag()


    /**
     * Test that applying P tags around two PRE tags.
     *
     * @return void
     */
    public function testApplyingPTagsAroundTwoPreTags()
    {
        // Change the paragraphs to Pre tags for the test
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor</pre><pre>sit %2% <strong>%3%</strong></pre>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><pre>%1% xtn dolor</pre><pre>sit %2% <strong>%3%</strong></pre></div>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><pre>%1% xtn dolor</pre><pre>sit %2% <strong>%3%</strong></pre></blockquote>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'active', TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre><pre>%1% xtn dolor</pre><pre>sit %2% <strong>%3%</strong></pre></pre>');

        // P should become enabled because the p tags are removed from the source code for the pre
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor<br /><br />sit %2% <strong>%3%</strong><br /></div>');

    }//end testApplyingPTagsAroundTwoDivTags()


    /**
     * Test that applying P tags around a P and Quote tag.
     *
     * @return void
     */
    public function testApplyingPTagsAroundPAndQuoteTag()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><p>%1% xtn dolor</p><blockquote>sit %2% <strong>%3%</strong></blockquote></div>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><p>%1% xtn dolor</p><blockquote>sit %2% <strong>%3%</strong></blockquote></blockquote>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'active', TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre>%1% xtn dolor  <blockquote>sit %2% <strong>%3%</strong></blockquote></pre>');

        // P should become enabled because the p tags are removed from the source code for the pre
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor<br /><br />sit %2% <strong>%3%</strong><br /></div>');

    }//end testApplyingPTagsAroundPAndQuoteTag()


    /**
     * Test that applying P tags around a Quote and P tag.
     *
     * @return void
     */
    public function testApplyingPTagsAroundQuoteAndPTag()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><blockquote>%1% xtn dolor</blockquote><p>sit %2% <strong>%3%</strong></p></div>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><blockquote>%1% xtn dolor</blockquote><p>sit %2% <strong>%3%</strong></p></blockquote>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'active', TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre><blockquote>%1% xtn dolor</blockquote>sit %2% <strong>%3%</strong>  </pre>');

        // P should become enabled because the p tags are removed from the source code for the pre
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', NULL, TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div>%1% xtn dolor<br /><br />sit %2% <strong>%3%</strong><br /></div>');

    }//end testApplyingPTagsAroundQuoteAndPTag()


    /**
     * Test that applying P tags around two Quote tags.
     *
     * @return void
     */
    public function testApplyingPTagsAroundTwoQuoteTags()
    {
        // Change the paragraphs to Quote tags for the test
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote>%1% xtn dolor</blockquote><blockquote>sit %2% <strong>%3%</strong></blockquote>');

        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('formats');
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><blockquote>%1% xtn dolor</blockquote><blockquote>sit %2% <strong>%3%</strong></blockquote></div>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><blockquote><blockquote>%1% xtn dolor</blockquote><blockquote>sit %2% <strong>%3%</strong></blockquote></blockquote>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'active', TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><pre><blockquote>%1% xtn dolor</blockquote><blockquote>sit %2% <strong>%3%</strong></blockquote></pre>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon is not active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'PRE icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('Quote', NULL, TRUE), 'Quote icon should be active');
        $this->assertHTMLMatch('<h1>Heading One</h1><div><blockquote>%1% xtn dolor</blockquote><blockquote>sit %2% <strong>%3%</strong></blockquote></div>');

    }//end testApplyingPTagsAroundTwoQuoteTags()


}//end class

?>
