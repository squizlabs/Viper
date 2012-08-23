<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_HeadingsUnitTest extends AbstractViperUnitTest
{


    /**
     * Test changing headings using the inline toolbar.
     *
     * @return void
     */
    public function testChangingHeadingsUsingInlineToolbar()
    {

        $this->useTest(1);

        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('headings', 'active');
        $this->clickInlineToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatch('<h2>%1% %2%</h2>');

        $this->clickInlineToolbarButton('H3', NULL, TRUE);
        $this->assertHTMLMatch('<h3>%1% %2%</h3>');

        $this->clickInlineToolbarButton('H4', NULL, TRUE);
        $this->assertHTMLMatch('<h4>%1% %2%</h4>');

        $this->clickInlineToolbarButton('H5', NULL, TRUE);
        $this->assertHTMLMatch('<h5>%1% %2%</h5>');

        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>%1% %2%</h1>');

    }//end testChangingHeadingsUsingInlineToolbar()


    /**
     * Test changing headings using the top toolbar when you click in a paragraph.
     *
     * @return void
     */
    public function testChangingHeadingsWhenClickingInParagraphUsingTopToolbar()
    {

        $this->useTest(1);

        $this->click($this->findKeyword(1));
        $this->clickTopToolbarButton('headings', 'active');
        $this->clickTopToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatch('<h2>%1% %2%</h2>');

        $this->clickTopToolbarButton('H3', NULL, TRUE);
        $this->assertHTMLMatch('<h3>%1% %2%</h3>');

        $this->clickTopToolbarButton('H4', NULL, TRUE);
        $this->assertHTMLMatch('<h4>%1% %2%</h4>');

        $this->clickTopToolbarButton('H5', NULL, TRUE);
        $this->assertHTMLMatch('<h5>%1% %2%</h5>');

        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>%1% %2%</h1>');

    }//end testChangingHeadingsWhenClickingInParagraphUsingTopToolbar()


    /**
     * Test changing headings using the top toolbar when you select the parargraph.
     *
     * @return void
     */
    public function testChangingHeadingsWhenSelectingParagraphUsingTopToolbar()
    {

        $this->useTest(1);

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('headings', 'active');
        $this->clickTopToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatch('<h2>%1% %2%</h2>');

        $this->clickTopToolbarButton('H3', NULL, TRUE);
        $this->assertHTMLMatch('<h3>%1% %2%</h3>');

        $this->clickTopToolbarButton('H4', NULL, TRUE);
        $this->assertHTMLMatch('<h4>%1% %2%</h4>');

        $this->clickTopToolbarButton('H5', NULL, TRUE);
        $this->assertHTMLMatch('<h5>%1% %2%</h5>');

        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>%1% %2%</h1>');

    }//end testChangingHeadingsWhenSelectingParagraphUsingTopToolbar()


    /**
     * Test that remove and apply headings using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingHeadingsUsingInlineToolbar()
    {
        $this->useTest(1);

        // Remove the heading
        $this->selectKeyword(1, 2);
        $this->assertTrue($this->inlineToolbarButtonExists('headings', 'active'), 'Headings icon is not highlighted in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('formats'), 'Formats icon should be enabled in the inline toolbar');

        $this->clickInlineToolbarButton('headings', 'active');
        $this->clickInlineToolbarButton('H1', 'active', TRUE);

        $this->assertTrue($this->inlineToolbarButtonExists('H1', NULL, TRUE), 'H1 icon should not be active');
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Formats icon shoudl be active');

        $this->assertHTMLMatch('<p>%1% %2%</p>');

        // Applying the heading
        $this->selectKeyword(1, 2);

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H2', NULL, TRUE);

        $this->assertTrue($this->inlineToolbarButtonExists('H2', 'active', TRUE), 'H2 icon should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('formats'), 'Formats icon should not be active');

        $this->assertHTMLMatch('<h2>%1% %2%</h2>');

    }//end testApplyingAndRemovingHeadingsUsingInlineToolbar()


    /**
     * Test that remove and apply headings using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingHeadingsUsingTopToolbar()
    {
        $this->useTest(1);

        // Remove the heading
        $this->selectKeyword(1, 2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'active'), 'Headings icon is not highlighted in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats'), 'Formats icon should be enabled in the top toolbar');

        $this->clickTopToolbarButton('headings', 'active');
        $this->clickTopToolbarButton('H1', 'active', TRUE);

        $this->assertTrue($this->topToolbarButtonExists('H1', NULL, TRUE), 'H1 icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Formats icon should be active');

        $this->assertHTMLMatch('<p>%1% %2%</p>');

        // Applying the heading
        $this->selectKeyword(1, 2);

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H2', NULL, TRUE);

        $this->assertTrue($this->topToolbarButtonExists('H2', 'active', TRUE), 'H1 icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('formats'), 'Formats icon should be enabled in the top toolbar');

        $this->assertHTMLMatch('<h2>%1% %2%</h2>');

    }//end testApplyingAndRemovingHeadingsUsingTopToolbar()


    /**
     * Test that you can remove headings when you click in a paragraph.
     *
     * @return void
     */
    public function testRemovingHeadingsWhenClickingInParagraph()
    {
        $this->useTest(1);

        // Remove the heading
        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings', 'active'), 'Headings icon is not highlighted in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats'), 'Formats icon should be enabled in the top toolbar');

        $this->clickTopToolbarButton('headings', 'active');
        $this->clickTopToolbarButton('H1', 'active', TRUE);

        $this->assertTrue($this->topToolbarButtonExists('H1', NULL, TRUE), 'H1 icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Formats icon should be active');

        $this->assertHTMLMatch('<p>%1% %2%</p>');

    }//end testRemovingHeadingsWhenClickingInParagraph()


    /**
     * Test applying headings to new content.
     *
     * @return void
     */
    public function testApplyingHeadingsToNewContent()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('New line of content %3%');

        $this->assertHTMLMatch('<h1>%1% %2%</h1><p>New line of content %3%</p>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H3', NULL, TRUE);
        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('Another new line of content');

        $this->assertHTMLMatch('<h1>%1% %2%</h1><h3>New line of content %3%</h3><p>Another new line of content</p>');

    }//end testApplyingHeadingsToNewContent()


    /**
     * Test applying a heading to different types of Parargraph sections using the inline toolbar
     *
     * @return void
     */
    public function testApplyingAHeadingToParragraphSectionsUsingInlineToolbar()
    {
        $this->useTest(2);

        // Check single line parragraph
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');
        $this->assertTrue($this->inlineToolbarButtonExists('H1', 'active', TRUE), 'H1 icon should be active in the inline toolbar');

        // Check multi-line parargraph
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

    }//end testApplyingAHeadingToParragraphSectionsUsingInlineToolbar()


    /**
     * Test applying a heading to different types of Parargraph sections using the top toolbar
     *
     * @return void
     */
    public function testApplyingAHeadingToParragraphSectionsUsingTopToolbar()
    {
        $this->useTest(2);

        // Check single line parragraph
        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be disabled in the top toolbar');

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE), 'H1 icon should be active in the top toolbar');

        // Check multi-line paragraph
        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be appear in the top toolbar');

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><h1>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</h1>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE), 'H1 icon should be active in the top toolbar');

    }//end testApplyingAHeadingToParragraphSectionsUsingTopToolbar()


    /**
     * Test applying a heading when selecting a bold word in a parragraph section.
     *
     * @return void
     */
    public function testApplyingHeadingToParragraphWhenSelectingBoldWord()
    {
        $this->useTest(2);

        // Make word bold
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>sit amet <strong>%1%</strong></p><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet <strong>%1%</strong></h1><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

    }//end testApplyingHeadingToParragraphWhenSelectingBoldWord()


    /**
     * Test applying a heading when selecting an italic word in a parragraph section.
     *
     * @return void
     */
    public function testApplyingHeadingToParragrahWhenSelectingItalicWord()
    {
        $this->useTest(2);

        // Make word italic
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>sit amet <em>%1%</em></p><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet <em>%1%</em></h1><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

    }//end testApplyingHeadingToParragrahWhenSelectingItalicWord()


    /**
     * Test applying a heading to different types of Pre sections using the inline toolbar
     *
     * @return void
     */
    public function testApplyingAHeadingToPreSectionsUsingInlineToolbar()
    {
        $this->useTest(3);

        // Check single line parragraph
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><pre>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</pre>');
        $this->assertTrue($this->inlineToolbarButtonExists('H1', 'active', TRUE), 'H1 icon should be active in the inline toolbar');

        // Check multi-line pre
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

    }//end testApplyingAHeadingToPreSectionsUsingInlineToolbar()


    /**
     * Test applying a heading to different types of Pre sections using the top toolbar
     *
     * @return void
     */
    public function testApplyingAHeadingToPreSectionsUsingTopToolbar()
    {
        $this->useTest(3);

        // Check single line parragraph
        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be disabled in the top toolbar');

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><pre>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</pre>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE), 'H1 icon should be active in the top toolbar');

        // Check multi-line paragraph
        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be appear in the top toolbar');

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><h1>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</h1>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE), 'H1 icon should be active in the top toolbar');

    }//end testApplyingAHeadingToPreSectionsUsingTopToolbar()


    /**
     * Test applying a heading when selecting a bold word in a pre section.
     *
     * @return void
     */
    public function testApplyingHeadingToPreWhenSelectingBoldWord()
    {
        $this->useTest(3);

        // Make word bold
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<pre>sit amet <strong>%1%</strong></pre><pre>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</pre>');

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet <strong>%1%</strong></h1><pre>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</pre>');

    }//end testApplyingHeadingToPreWhenSelectingBoldWord()


    /**
     * Test applying a heading when selecting an italic word in a pre section.
     *
     * @return void
     */
    public function testApplyingHeadingToPreWhenSelectingItalicWord()
    {
        $this->useTest(3);

        // Make word italic
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<pre>sit amet <em>%1%</em></pre><pre>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</pre>');

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet <em>%1%</em></h1><pre>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</pre>');

    }//end testApplyingHeadingToPreWhenSelectingItalicWord()


    /**
     * Test applying a heading to Quote sections using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingHeadingToQuoteSectionsUsingInlineToolbar()
    {
        $this->useTest(4);

        // Check single line quote
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><blockquote><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p></blockquote><blockquote><p>test1 test2 test3 sit amet %3%</p><p>%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.</p></blockquote>');
        $this->assertTrue($this->inlineToolbarButtonExists('H1', 'active', TRUE), 'H1 icon should be not appear in the inline toolbar');

        // Check multi-line quote
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        // Check quote section with multi P's
        $this->selectKeyword(3);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

    }//end testApplyingHeadingToQuoteSectionsUsingInlineToolbar()


    /**
     * Test applying a heading to Quote sections using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAHeadingToQuoteSectionsUsingTopToolbar()
    {
        $this->useTest(4);

        // Check single line quote
        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><blockquote><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p></blockquote><blockquote><p>test1 test2 test3 sit amet %3%</p><p>%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.</p></blockquote>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE), 'H1 icon should be active in the top toolbar');

        // Check multi-line quote
        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be appear in the top toolbar');

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><h1>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</h1><blockquote><p>test1 test2 test3 sit amet %3%</p><p>%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.</p></blockquote>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE), 'H1 icon should be active in the top toolbar');

        // Check quote section with multi P's
        $this->click($this->findKeyword(3));
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->click($this->findKeyword(4));
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

    }//end testApplyingAHeadingToQuoteSectionsUsingTopToolbar()


    /**
     * Test applying a heading to a P tag that is inside a Quote.
     *
     * @return void
     */
    public function testApplyingHeadingToPSectionInsideQuote()
    {
        $this->useTest(4);

        // Check single line quote
        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        // Check multi-line quote
        $this->click($this->findKeyword(1));
        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be appear in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        // Check quote section with multi P's
        $this->click($this->findKeyword(3));
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->click($this->findKeyword(4));
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

    }//end testApplyingHeadingToPSectionInsideQuote()


    /**
     * Test applying a heading when selecting a bold word in a quote section.
     *
     * @return void
     */
    public function testApplyingHeadingToQuoteWhenSelectingBoldWord()
    {
        $this->useTest(4);

        // Make word bold
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<blockquote><p>sit amet <strong>%1%</strong></p></blockquote><blockquote><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p></blockquote><blockquote><p>test1 test2 test3 sit amet %3%</p><p>%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.</p></blockquote>');

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet <strong>%1%</strong></h1><blockquote><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p></blockquote><blockquote><p>test1 test2 test3 sit amet %3%</p><p>%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.</p></blockquote>');

    }//end testApplyingHeadingToQuoteWhenSelectingBoldWord()


    /**
     * Test applying a heading when selecting an italic word in a quote section.
     *
     * @return void
     */
    public function testApplyingHeadingToQuoteWhenSelectingItalicWord()
    {
        $this->useTest(4);

        // Make word italic
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<blockquote><p>sit amet <em>%1%</em></p></blockquote><blockquote><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p></blockquote><blockquote><p>test1 test2 test3 sit amet %3%</p><p>%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.</p></blockquote>');

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet <em>%1%</em></h1><blockquote><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p></blockquote><blockquote><p>test1 test2 test3 sit amet %3%</p><p>%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.</p></blockquote>');

    }//end testApplyingHeadingToQuoteWhenSelectingItalicWord()


    /**
     * Test applying a heading to Div sections using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingHeadingToDivSectionsUsingInlineToolbar()
    {
        $this->useTest(5);

        // Check single line div
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><div>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</div>');
        $this->assertTrue($this->inlineToolbarButtonExists('H1', 'active', TRUE), 'H1 icon should be not appear in the inline toolbar');

        // Check multi-line div
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

    }//end testApplyingHeadingToDivSectionsUsingInlineToolbar()


    /**
     * Test applying a heading to Div sections using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAHeadingToDivSectionsUsingTopToolbar()
    {
        $this->useTest(5);

        // Check single line div
        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><div>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</div>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE), 'H1 icon should be active in the top toolbar');

        // Check multi-line div
        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be appear in the top toolbar');

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><h1>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</h1>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE), 'H1 icon should be active in the top toolbar');

    }//end testApplyingAHeadingToDivSectionsUsingTopToolbar()


    /**
     * Test applying a heading when selecting a bold word in a div section.
     *
     * @return void
     */
    public function testApplyingHeadingToDivWhenSelectingBoldWord()
    {
        $this->useTest(5);

        // Make word bold
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<div>sit amet <strong>%1%</strong></div><div>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</div>');

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet <strong>%1%</strong></h1><div>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</div>');

    }//end testApplyingHeadingToDivWhenSelectingBoldWord()


    /**
     * Test applying a heading when selecting an italic word in a div section.
     *
     * @return void
     */
    public function testApplyingHeadingToDivWhenSelectingItalicWord()
    {
        $this->useTest(5);

        // Make word italic
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<div>sit amet <em>%1%</em></div><div>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</div>');

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet <em>%1%</em></h1><div>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</div>');

    }//end testApplyingHeadingToDivWhenSelectingItalicWord()


    /**
     * Test that heading icon shows in top toolbar when range is collaped.
     *
     * @return void
     */
    public function testCollapsedRangeEnabledHeadingIconInTopToolbar()
    {
        $this->useTest(14);
        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->click($this->findKeyword(3));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->click($this->findKeyword(4));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->click($this->findKeyword(5));
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not be enabled in the top toolbar');

    }//end testCollapsedRangeEnabledHeadingIconInTopToolbar()


    /**
     * Test applying headings where you have one P inside a Div
     *
     * @return void
     */
    public function testApplyingHeadginsWithOnePInsideADiv()
    {

        $this->useTest(6);

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

        // Apply heading to the P section
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<div><h1>Long paragraph for testing that the heading icon does not appear in the inline toolbar %1%.</h1></div>');

        // Undo the changes so we can test chagning the Div section
        $this->clickTopToolbarButton('historyUndo');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

    }//end testApplyingHeadginsWithOnePInsideADiv()


    /**
     * Test applying headings where you have two P tags inside a Div
     *
     * @return void
     */
    public function testApplyingHeadginsWithTwoPTagsInsideADiv()
    {
        $this->useTest(7);

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        // Apply a heading to the P section
        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<div><h1>sit amet %1%</h1><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar.</p></div>');

        // Undo the changes so we can test chagning the second P section
        $this->keyDown('Key.CMD + z');

        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

        // Apply a heading to the P section
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<div><p>sit amet %1%</p><h1>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar.</h1></div>');

        // Undo the changes so we can test chagning the Div section
        $this->keyDown('Key.CMD + z');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

    }//end testApplyingHeadginsWithTwoPTagsInsideADiv()


    /**
     * Test applying headings where you have Div tag inside a Div
     *
     * @return void
     */
    public function testApplyingHeadginsWithDivTagInsideADiv()
    {
        $this->useTest(8);

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

        // Apply a heading to the Div section
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<div><h1>Long paragraph for testing that the heading icon does not appear in the inline toolbar %1%.</h1></div>');

        // Undo the changes so we can test chagning the Div section
        $this->clickTopToolbarButton('historyUndo');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

    }//end testApplyingHeadginsWithDivTagInsideADiv()


    /**
     * Test applying headings where you have Div tags inside a Div
     *
     * @return void
     */
    public function testApplyingHeadginsWithTwoDivTagsInsideADiv()
    {

        $this->useTest(9);

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        // Apply a heading to the Div section
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<div><h1>sit amet %1%</h1><div>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar.</div></div>');

        // Undo the changes so we can test the second Div section
        $this->keyDown('Key.CMD + z');

        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

        // Apply a heading to the Div section
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<div><div>sit amet %1%</div><h1>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar.</h1></div>');

        // Undo the changes so we can test chagning the Div section
        $this->keyDown('Key.CMD + z');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

    }//end testApplyingHeadginsWithTwoDivTagsInsideADiv()


    /**
     * Test applying headings where you have a quote tag inside a Div
     *
     * @return void
     */
    public function testApplyingHeadginsWithQuoteTagInsideADiv()
    {

        $this->useTest(10);

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

        // Apply a heading to the Quote section
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<div><h1>Long paragraph for testing that the heading icon does not appear in the inline toolbar %1%.</h1></div>');

        // Undo the changes so we can test chagning the Div section
        $this->keyDown('Key.CMD + z');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

    }//end testApplyingHeadginsWithQuoteTagInsideADiv()


    /**
     * Test applying headings where you have two quote tags inside a Div
     *
     * @return void
     */
    public function testApplyingHeadginsWithTwoQuoteTagsInsideADiv()
    {

        $this->useTest(11);

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        // Apply a heading to the Quote section
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<div><h1>sit amet %1%</h1><blockquote><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar.</p></blockquote></div>');

        // Undo the changes so we can test the second quote section
        $this->keyDown('Key.CMD + z');

        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        // Apply a heading to the Quote section
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<div><blockquote><p>sit amet %1%</p></blockquote><h1>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar.</h1></div>');

        // Undo the changes so we can test chagning the Div section
        $this->keyDown('Key.CMD + z');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not be enabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

    }//end testApplyingHeadginsWithTwoQuoteTagsInsideADiv()


    /**
     * Test applying headings where you have a Pre tag inside a Div
     *
     * @return void
     */
    public function testApplyingHeadginsWithPreTagInsideADiv()
    {
        $this->useTest(12);

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        // Apply a heading to the Quote section
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<div><h1>Long paragraph %1% for testing that the heading icon does not appear in the inline toolbar.</h1></div>');

        // Undo the changes so we can test chagning the Div section
        $this->keyDown('Key.CMD + z');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be enabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

    }//end testApplyingHeadginsWithPreTagInsideADiv()


    /**
     * Test applying headings where you have two Pre tags inside a Div
     *
     * @return void
     */
    public function testApplyingHeadginsWithTwoPreTagsInsideADiv()
    {
        $this->useTest(13);

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Heading icon should appear in the inline toolbar');

        // Apply a heading to the Quote section
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<div><h1>sit amet %1%</h1><pre>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar.</pre></div>');

        // Undo the changes so we can test the second Pre section
        $this->keyDown('Key.CMD + z');

        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

        // Apply a heading to the Quote section
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<div><pre>sit amet %1%</pre><h1>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar.</h1></div>');

        // Undo the changes so we can test chagning the Div section
        $this->keyDown('Key.CMD + z');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be enabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

    }//end testApplyingHeadginsWithTwoPreTagsInsideADiv()


    /**
     * Test applying headings to div sections with single block elements inside of them 
     *
     * @return void
     */
    public function testApplyingHeadginsToDivsWithSingleBlockElements()
    {
        // Test P inside a Div
        $this->useTest(6);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Long paragraph for testing that the heading icon does not appear in the inline toolbar %1%.</h1>');
        
        // Test Div inside a Div
        $this->useTest(8);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Long paragraph for testing that the heading icon does not appear in the inline toolbar %1%.</h1>');
        
        // Test Pre inside a Div
        $this->useTest(12);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Long paragraph %1% for testing that the heading icon does not appear in the inline toolbar.</h1>');
        
         // Test Quote inside a Div
        $this->useTest(10);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Long paragraph for testing that the heading icon does not appear in the inline toolbar %1%.</h1>');

    }//end testApplyingHeadginsToDivsWithSingleBlockElements()
    

}//end class

?>
