<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_HeadingsUnitTest extends AbstractViperUnitTest
{


    /**
     * Test changing headings using the inline toolbar.
     *
     * @return void
     */
    public function testEditingAHeading()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        // Check that the heading icon does not appear in the inline toolbar
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'active'));
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('headings', 'active');
        $this->clickInlineToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatch('<h2>Heading %1%</h2>');
        $this->clickInlineToolbarButton('H3', NULL, TRUE);
        $this->assertHTMLMatch('<h3>Heading %1%</h3>');
        $this->clickInlineToolbarButton('H4', NULL, TRUE);
        $this->assertHTMLMatch('<h4>Heading %1%</h4>');
        $this->clickInlineToolbarButton('H5', NULL, TRUE);
        $this->assertHTMLMatch('<h5>Heading %1%</h5>');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading %1%</h1>');

        // Using the top toolbar and clicking in the heading
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('headings', 'active');
        $this->clickTopToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatch('<h2>Heading %1%</h2>');
        $this->clickTopToolbarButton('H3', NULL, TRUE);
        $this->assertHTMLMatch('<h3>Heading %1%</h3>');
        $this->clickTopToolbarButton('H4', NULL, TRUE);
        $this->assertHTMLMatch('<h4>Heading %1%</h4>');
        $this->clickTopToolbarButton('H5', NULL, TRUE);
        $this->assertHTMLMatch('<h5>Heading %1%</h5>');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading %1%</h1>');

        // Using the top toolbar and selecting a word
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('headings', 'active');
        $this->clickTopToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatch('<h2>Heading %1%</h2>');
        $this->clickTopToolbarButton('H3', NULL, TRUE);
        $this->assertHTMLMatch('<h3>Heading %1%</h3>');
        $this->clickTopToolbarButton('H4', NULL, TRUE);
        $this->assertHTMLMatch('<h4>Heading %1%</h4>');
        $this->clickTopToolbarButton('H5', NULL, TRUE);
        $this->assertHTMLMatch('<h5>Heading %1%</h5>');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading %1%</h1>');

        // Using the top toolbar and selecting the heading
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('headings', 'active');
        $this->clickTopToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatch('<h2>Heading %1%</h2>');
        $this->clickTopToolbarButton('H3', NULL, TRUE);
        $this->assertHTMLMatch('<h3>Heading %1%</h3>');
        $this->clickTopToolbarButton('H4', NULL, TRUE);
        $this->assertHTMLMatch('<h4>Heading %1%</h4>');
        $this->clickTopToolbarButton('H5', NULL, TRUE);
        $this->assertHTMLMatch('<h5>Heading %1%</h5>');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Heading %1%</h1>');

    }//end testEditingAHeading()


    /**
     * Test removing a heading.
     *
     * @return void
     */
    public function testRemovingAHeading()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('headings', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('formats'));
        $this->clickInlineToolbarButton('headings', 'active');
        $this->clickInlineToolbarButton('H1', 'active', TRUE);
        $this->assertTrue($this->inlineToolbarButtonExists('H1', NULL, TRUE));
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->assertHTMLMatch('<p>Heading %1%</p>');

        // Using the top toolbar and clicking in the heading
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('headings', 'active');
        $this->clickTopToolbarButton('H1', 'active', TRUE);
        $this->assertTrue($this->topToolbarButtonExists('H1', NULL, TRUE));
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->assertHTMLMatch('<p>Heading %1%</p>');

        // Using the top toolbar and selecting a word in the heading
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('headings', 'active');
        $this->clickTopToolbarButton('H1', 'active', TRUE);
        $this->assertTrue($this->topToolbarButtonExists('H1', NULL, TRUE));
        $this->assertHTMLMatch('<p>Heading %1%</p>');

        // Using the top toolbar and selecting the heading
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('headings', 'active');
        $this->clickTopToolbarButton('H1', 'active', TRUE);
        $this->assertTrue($this->topToolbarButtonExists('H1', NULL, TRUE));
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->assertHTMLMatch('<p>Heading %1%</p>');

    }//end testRemovingAHeading()


    /**
     * Test deleting a heading from the page.
     *
     * @return void
     */
    public function testDeletingAHeadingFromContent()
    {
        $this->useTest(16);

        // Remove the heading
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>Test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test</p>');

    }//end testDeletingAHeadingFromContent()


    /**
     * Test deleting a heading by tripple clicking the heading.
     *
     * @return void
     */
    public function testDeleteHeadingWithTrippleClick()
    {
        $this->useTest(17);

        // Tripple click the heading
        $location = $this->findKeyword(1);
        $this->sikuli->tripleClick($location);
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>Test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test</p>');

    }//end testDeleteHeadingWithTrippleClick()


    /**
     * Test applying headings to new content.
     *
     * @return void
     */
    public function testApplyingHeadingsToNewContent()
    {
        $this->useTest(1);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New line of content %2%');

        $this->assertHTMLMatch('<h1>Heading %1%</h1><p>New line of content %2%</p>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H3', NULL, TRUE);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Another new line of content');

        $this->assertHTMLMatch('<h1>Heading %1%</h1><h3>New line of content %2%</h3><p>Another new line of content</p>');

    }//end testApplyingHeadingsToNewContent()


    /**
     * Test applying a heading to a Parargraph
     *
     * @return void
     */
    public function testApplyingAHeadingToParragraphSections()
    {
        // Using the inline toolbar
        $this->useTest(2);

        // Check single line paragraph
        $this->selectKeyword(1); 
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('headings'));
        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');
        $this->assertTrue($this->inlineToolbarButtonExists('H1', 'active', TRUE), 'H1 icon should be active in the inline toolbar');

        // Check that the heading toolbar doesn't appear in the inline toolbar for a multiline paragraph (by design)
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));

        // Using the top toolbar
        $this->useTest(2);

        // Check single line parragraph
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE));

        // Check multi-line paragraph
        $this->moveToKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><h1>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</h1>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE));

    }//end testApplyingAHeadingToParragraphSections()


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
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertHTMLMatch('<p>sit amet <strong>%1%</strong></p><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'));

        sleep(1);
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));

        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->assertTrue($this->inlineToolbarButtonExists('headings'));

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
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertHTMLMatch('<p>sit amet <em>%1%</em></p><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

        $this->sikuli->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'));

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));

        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->assertTrue($this->inlineToolbarButtonExists('headings'));

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet <em>%1%</em></h1><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

    }//end testApplyingHeadingToParragrahWhenSelectingItalicWord()


    /**
     * Test applying a heading to different types of Pre sections
     *
     * @return void
     */
    public function testApplyingAHeadingToPreSections()
    {
        // Using the inline toolbar
        $this->useTest(3);

        // Check single line parragraph
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><pre>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</pre>');
        $this->assertTrue($this->inlineToolbarButtonExists('H1', 'active', TRUE));

        // Check that the heading toolbar doesn't appear in the inline toolbar for a multiline pre (by design)
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));

        // Using top toolbar
        $this->useTest(3);

        // Check single line parragraph
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><pre>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</pre>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE));

        // Check multi-line paragraph
        $this->moveToKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'));

        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><h1>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</h1>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE));

    }//end testApplyingAHeadingToPreSections()


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
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<pre>sit amet <strong>%1%</strong></pre><pre>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</pre>');

        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->assertTrue($this->inlineToolbarButtonExists('headings'));

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
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<pre>sit amet <em>%1%</em></pre><pre>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</pre>');

        $this->sikuli->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'));

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->assertTrue($this->inlineToolbarButtonExists('headings'));

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet <em>%1%</em></h1><pre>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</pre>');

    }//end testApplyingHeadingToPreWhenSelectingItalicWord()


    /**
     * Test applying a heading to Quote sections.
     *
     * @return void
     */
    public function testApplyingHeadingToQuoteSections()
    {
        // Using the inline toolbar
        $this->useTest(4);

        // Check single line quote
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        // Check the the heading icon does not appear in the toolbar when you click the P
        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><blockquote><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p></blockquote><blockquote><p>test1 test2 test3 sit amet %3%</p><p>%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.</p></blockquote>');
        $this->assertTrue($this->inlineToolbarButtonExists('H1', 'active', TRUE));

        // Check that the heading toolbar doesn't appear in the inline toolbar for a multiline quote (by design)
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));

        // Check that the heading icon doesn't appear in the inline toolbar for a quote with multiple paragraphs (by design)
        $this->selectKeyword(3);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));

        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));

        // Using the top toolbar
        $this->useTest(4);

        // Check single line quote
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        // Check the the heading icon is disabled in the toolbar when you click the P
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><blockquote><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p></blockquote><blockquote><p>test1 test2 test3 sit amet %3%</p><p>%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.</p></blockquote>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE));

        // Check multi-line quote
        $this->moveToKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        // Check the the heading icon is disabled in the toolbar when you click the P
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><h1>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</h1><blockquote><p>test1 test2 test3 sit amet %3%</p><p>%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.</p></blockquote>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE));

        // Check that the heading icon doesn't appear in the top toolbar for a quote with multiple paragraphs (by design)
        $this->moveToKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));

        $this->moveToKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));

    }//end testApplyingHeadingToQuoteSections()


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
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<blockquote><p>sit amet <strong>%1%</strong></p></blockquote><blockquote><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p></blockquote><blockquote><p>test1 test2 test3 sit amet %3%</p><p>%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.</p></blockquote>');

        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->assertTrue($this->inlineToolbarButtonExists('headings'));

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
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<blockquote><p>sit amet <em>%1%</em></p></blockquote><blockquote><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p></blockquote><blockquote><p>test1 test2 test3 sit amet %3%</p><p>%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.</p></blockquote>');

        $this->sikuli->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        sleep(1);
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->assertTrue($this->inlineToolbarButtonExists('headings'));

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet <em>%1%</em></h1><blockquote><p>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p></blockquote><blockquote><p>test1 test2 test3 sit amet %3%</p><p>%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.</p></blockquote>');

    }//end testApplyingHeadingToQuoteWhenSelectingItalicWord()


    /**
     * Test applying a heading to Div sections.
     *
     * @return void
     */
    public function testApplyingHeadingToDivSections()
    {
        // Using the inline toolbar
        $this->useTest(5);

        // Check single line div
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><div>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</div>');
        $this->assertTrue($this->inlineToolbarButtonExists('H1', 'active', TRUE));

        // Check that the heading toolbar doesn't appear in the inline toolbar for a multiline div (by design)
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));

        // Using the top toolbar
        $this->useTest(5);

        // Check single line div
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><div>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</div>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE));

        // Check multi-line div
        $this->moveToKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet %1%</h1><h1>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</h1>');
        $this->assertTrue($this->topToolbarButtonExists('H1', 'active', TRUE));

    }//end testApplyingHeadingToDivSections()


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
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertHTMLMatch('<div>sit amet <strong>%1%</strong></div><div>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</div>');

        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->assertTrue($this->inlineToolbarButtonExists('headings'));
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
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertHTMLMatch('<div>sit amet <em>%1%</em></div><div>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</div>');

        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->selectKeyword(1);
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->assertFalse($this->inlineToolbarButtonExists('headings'));
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'));
        $this->assertTrue($this->inlineToolbarButtonExists('headings'));
        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>sit amet <em>%1%</em></h1><div>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</div>');

    }//end testApplyingHeadingToDivWhenSelectingItalicWord()


    /**
     * Test applying headings where you have one P inside a Div
     *
     * @return void
     */
    public function testApplyingHeadginsWithOnePInsideADiv()
    {
        // Test changing the p to a heading
        $this->useTest(6);

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

        // Test changing the div to a heading
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>Long paragraph for testing that the heading icon does not appear in the inline toolbar %1%.</h1>');

    }//end testApplyingHeadginsWithOnePInsideADiv()


    /**
     * Test applying headings where you have two P tags inside a Div
     *
     * @return void
     */
    public function testApplyingHeadginsWithTwoPTagsInsideADiv()
    {
        $this->useTest(7);

        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->moveToKeyword(2);
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
        $this->sikuli->keyDown('Key.CMD + z');

        $this->moveToKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');

        $this->moveToKeyword(1);
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

        // Apply a heading to the P section
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<div><p>sit amet %1%</p><h1>%2% long paragraph for testing that the heading icon does not appear in the inline toolbar.</h1></div>');

        // Undo the changes so we can test chagning the Div section
        $this->sikuli->keyDown('Key.CMD + z');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
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

        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        sleep(1);
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
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
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

        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        sleep(1);
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
        $this->sikuli->keyDown('Key.CMD + z');

        $this->sikuli->click($this->findKeyword(2));
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
        $this->sikuli->keyDown('Key.CMD + z');

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
        $this->sikuli->keyDown('Key.CMD + z');

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

        $this->moveToKeyword(1);
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
        $this->sikuli->keyDown('Key.CMD + z');

        sleep(1);

        $this->moveToKeyword(2);
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
        $this->sikuli->keyDown('Key.CMD + z');

        sleep(1);
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

        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar');

        sleep(1);
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
        $this->sikuli->keyDown('Key.CMD + z');
        sleep(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled in the top toolbar');
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

        $this->moveToKeyword(1);
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
        $this->sikuli->keyDown('Key.CMD + z');

        $this->moveToKeyword(2);
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
        $this->sikuli->keyDown('Key.CMD + z');

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


     /**
     * Test that the heading icon is not available for a list.
     *
     * @return void
     */
    public function testHeadingIconNotAvailableForList()
    {
        $this->useTest(15);

        // Check ul list
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->type('New parra');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar.');

        // Check 0l list
        $this->moveToKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the top toolbar.');

        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->type('New parra');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should appear in the top toolbar.');

    }//end testHeadingIconNotAvailableForList()


    /**
     * Test undo and redo for headings.
     *
     * @return void
     */
    public function testUndoAndRedoForHeadings()
    {

        $this->useTest(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('headings', 'active');
        $this->clickInlineToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatch('<h2>Heading %1%</h2>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<h1>Heading %1%</h1>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<h2>Heading %1%</h2>');

    }//end testUndoAndRedoForHeadings()


}//end class

?>
