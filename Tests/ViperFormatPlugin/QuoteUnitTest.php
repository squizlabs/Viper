<?php

require_once 'AbstractFormatsUnitTest.php';

class Viper_Tests_ViperFormatPlugin_QuoteUnitTest extends AbstractFormatsUnitTest
{


    /**
     * Test applying and removing the quote tag to a paragraph when clicking in a section
     *
     * @return void
     */
    public function testApplingAndRemovingTheQuoteFormatWhenClickingInSection()
    {
        
        // For a single line
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>This is some content %1% to test blockquotes with</p></blockquote>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test blockquotes with</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // For a multi-line section
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);

    }//end testApplingAndRemovingTheQuoteFormatWhenClickingInSection()


    /**
     * Test applying and removing the quote tag to a paragraph when selecting a section
     *
     * @return void
     */
    public function testApplingAndRemovingTheQuoteFormatWhenSelectingASection()
    {
        // Using the inline toolbar on a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>This is some content %1% to test blockquotes with</p></blockquote>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);

        $this->selectKeyword(1);
        // Check the state of the format icon when we click P
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Active blockquote icon should appear in the toolbar');
        // Click the blockquote and change it
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test blockquotes with</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        // Using the top toolbar on a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>This is some content %1% to test blockquotes with</p></blockquote>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);

        $this->selectKeyword(1);
        // Check the state of the format icon when we click P
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active blockquote icon should appear in the toolbar');
        // Click the blockquote and change it
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test blockquotes with</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // Using the inline toolbar on a multi-line section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);

        // Using the top toolbar on a multi-line section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        
    }//end testApplingAndRemovingTheQuoteFormatWhenSelectingASection()


    /**
     * Test the format icon in the toolbar for a quote section.
     *
     * @return void
     */
    public function testCheckWhenQuoteIconIsAvailableInToolbar()
    {
        $this->useTest(3);

        // Check that icon is active in top toolbar when you click in a quote.
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);

        // Check that the icon is not available in the inline toolbar or the top toolbar when you select a word.
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'), 'Active P icon should not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'disabled'), 'Disabled formats icon should appear in the top toolbar');

        // Check that the quote icon appears in the inline toolbar and top toolbar when you select the P in a quote.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should appear in the inline toolbar');
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);

        // Check that the icon appears in the inline toolbar and top toolbar when you select a quote.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should appear in the inline toolbar');
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);

        // Check that the icon is removed from the inline toolbar when you go from selection, to quote and back to selection.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->selectInlineToolbarLineageItem(2);
        $this->assertFalse($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Active quote icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'disabled'), 'Disabled quote icon should appear in the top toolbar');
        
    }//end testCheckWhenQuoteIconIsAvailableInToolbar()


    /**
     * Test clicking the active quote icon in the toolbar change it to a paragraph.
     *
     * @return void
     */
    public function testClickingActiveQuoteIconsInToolbar()
    {
        
        // Check that when you click the active quote icon in the inline toolbar, it is changed to paragraph.
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% xtn dolor</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        // Check that when you click the active quote icon in the top toolbar, it is changed to a paragraph.
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');
        
    }//end testClickingActiveQuoteIconsInToolbar()


    /**
     * Test that applying styles to whole blockquote and selecting the Quote in lineage shows quote tools only.
     *
     * @return void
     */
    public function testSelectQuoteAfterStylingShowsCorrectIcons()
    {
        // Apply bold and italics to a one line quote section
        $this->useTest(3);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');

        // Select quote in lineage and make sure the correct icons are being shown in the inline toolbar.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertEquals($this->replaceKeywords('%1% xtn dolor'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertEquals($this->replaceKeywords('%1% xtn dolor'), $this->getSelectedText(), 'Original selection is not selected');

        // Apply bold and italics to a multi-line quote section
        $this->useTest(2); 

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');

        // Select Quote in the lineage and make sure the correct icons are being shown in the inline toolbar.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-blockquote', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertEquals($this->replaceKeywords('%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertEquals($this->replaceKeywords('%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectQuoteAfterStylingShowsCorrectIcons()


    /**
     * Test bold works in blockquotes.
     *
     * @return void
     */
    public function testUsingBoldInBlockquotes()
    {
        $this->useTest(3);

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<blockquote><p><strong>%1%</strong> xtn dolor</p></blockquote>');

        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

    }//end testUsingBoldInBlockquotes()


    /**
     * Test italics works in blockquotes.
     *
     * @return void
     */
    public function testUsingItalicInBlockquotes()
    {
        $this->useTest(3);

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<blockquote><p><em>%1%</em> xtn dolor</p></blockquote>');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

    }//end testUsingItalicInBlockquotes()


    /**
     * Test creating new content in blockquote tags.
     *
     * @return void
     */
    public function testCreatingNewContentWithABlockquoteTag()
    {
        $this->useTest(4);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');

        $this->type('New %2%');
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);

        $this->moveToKeyword(2, 'right');
        $this->type(' on the page');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('More new content');

        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Outside of blockquote');

        $this->assertHTMLMatch('<p>Paragraph section %1%</p><blockquote><p>New %2% on the page</p><p>More new content</p></blockquote><p>Outside of blockquote</p>');

    }//end testCreatingNewContentWithABlockquoteTag()


    /**
     * Tests changing a blockquote to a div and then back again.
     *
     * @return void
     */
    public function testChangingAQuoteToADiv()
    {
        // Using inline toolbar with a single line
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

        // Using top toolbar with a single line
        $this->useTest(3);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

        // Using inline toolbar with multiline section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

        // Using top toolbar with multiline section
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

    }//end testChangingAQuoteToADiv()


    /**
     * Tests changing a Quote to a PRE and then back again.
     *
     * @return void
     */
    public function testChangingAQuoteToAPre()
    {

        // Using inline toolbar with a single line
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn dolor</pre>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

        // Using top toolbar with a single line
        $this->useTest(3);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn dolor</pre>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

        // Using inline toolbar with multiline section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

        // Using top toolbar with multiline section
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

    }//end testChangingAQuoteToAPre()


    /**
     * Tests changing a Quote to a paragraph and then back again.
     *
     * @return void
     */
    public function testChangingAQuoteToAParagraph()
    {

        // Using inline toolbar with a single line
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% xtn dolor</p>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

        // Using top toolbar with a single line
        $this->useTest(3);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% xtn dolor</p>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

        // Using inline toolbar with multiline section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

        // Using top toolbar with multiline section
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

    }//end testChangingAQuoteToAParagraph()


    /**
     * Tests selecting the P element in a blockquote and trying to change it to a blockquote.
     *
     * @return void
     */
    public function testChangingThePElementInQuoteToAQuote()
    {

        $this->useTest(3);

        // Using the inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('Quote', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn dolor</p>');

        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

        // Using the top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn dolor</p>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

    }//end testChangingThePElementInQuoteToAQuote()


     /**
     * Tests selecting the P element in a blockquote and changing it to a Div.
     *
     * @return void
     */
    public function testChangingThePElementInQuoteToADiv()
    {

        $this->useTest(3);

        // Using the inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');

        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

        // Using the top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

    }//end testChangingThePElementInQuoteToADiv()


    /**
     * Tests selecting the P element in a blockquote and changing it to a Pre.
     *
     * @return void
     */
    public function testChangingThePElementInQuoteToAPre()
    {

        $this->useTest(3);

        // Using the inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn dolor</pre>');

        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

        // Using the top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn dolor</pre>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

    }//end testChangingThePElementInQuoteToAPre()


    /**
     * Test selecting the P element in a blockquote and changing it to a P.
     *
     * @return void
     */
    public function testChangingThePElementInQuoteToAParagraph()
    {

        $this->useTest(3);

        // Using the inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn dolor</p>');

        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

        // Using the top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn dolor</p>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

    }//end testChangingThePElementInQuoteToAParagraph()


    /**
     * Tests that the list icons are not available for a quote.
     *
     * @return void
     */
    public function testListIconsNotAvailableForQuote()
    {

        $this->useTest(3);

        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        // Check multi-line Div section
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

    }//end testListIconsNotAvailableForQuote()


    /**
     * Test undo and redo for a quote.
     *
     * @return void
     */
    public function testUndoAndRedoForQuote()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>This is some content %1% to test blockquotes with</p></blockquote>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>This is some content %1% to test blockquotes with</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<blockquote><p>This is some content %1% to test blockquotes with</p></blockquote>');

    }//end testUndoAndRedoForQuote()


    /**
     * Test combining two Quote sections.
     *
     * @return void
     */
    public function testCombiningAQuoteWithDifferentFormatSections()
    {
        // Combine two blockquote sections
        $this->useTest(5);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<blockquote><p>First blockquote section%1% Second blockquote section</p></blockquote>');

        // Combine a quote and a paragraph section
        $this->useTest(6);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<blockquote><p>First blockquote section%1% Second paragraph section</p></blockquote>');

        // Combine a quote and a div section
        $this->useTest(7);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<blockquote><p>First blockquote section%1% Second div section</p></blockquote>');

        // Combine a quote and a pre section
        $this->useTest(8);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<blockquote><p>First blockquote section%1% Second pre section</p></blockquote>');

    }//end testCombiningAQuoteWithDifferentFormatSections()


    /**
     * Test splitting a blockquote into multiple paragraphs and then joining them back together.
     *
     * @return void
     */
    public function testSplittingOneQuoteIntoMultipleQuotes()
    {
        $this->useTest(2);

        // Split the quote 
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('a');
        sleep(1);
        $this->assertHTMLMatch('<blockquote><p>%1%</p></blockquote><p>a</p><blockquote><p> %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

        // Join the quote together
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<blockquote><p>%1% %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

    }//end testSplittingOneQuoteIntoMultipleQuotes()


    /**
     * Test splitting a paragraph in a quote into multiple paragraphs and then joining them back together.
     *
     * @return void
     */
    public function testSplittingParagraphInQuote()
    {
        $this->useTest(2);

        // Split the paragraph 
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('a');
        $this->assertHTMLMatch('<blockquote><p>%1%</p><p>a %2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

        // Join the paragraph together
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<blockquote><p>%1%&nbsp;%2% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

    }//end testSplittingParagraphInQuote()


    /**
     * Test changing a heading to a quote and then adding new content.
     *
     * @return void
     */
    public function testChaningHeadingToQuote()
    {
        $this->useTest(9);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats', NULL);
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>Heading for the page %1%</p></blockquote><p>First paragraph on the page</p><p>Second paragraph on the page</p>');

        $this->moveToKeyword(1, 'right');
        $this->type(' New content');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('More new content');

        $this->assertHTMLMatch('<blockquote><p>Heading for the page %1% New content</p><p>More new content</p></blockquote><p>First paragraph on the page</p><p>Second paragraph on the page</p>');

    }//end testChaningHeadingToQuote()

}//end class

?>
