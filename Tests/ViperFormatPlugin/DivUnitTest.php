<?php

require_once 'AbstractFormatsUnitTest.php';

class Viper_Tests_ViperFormatPlugin_DivUnitTest extends AbstractFormatsUnitTest
{

    /**
     * Test format icons when selecting divs.
     *
     * @return void
     */
    public function testFormatIconWhenSelectingDivs()
    {
        $this->useTest(13);

        // Check selecting a single div
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'));

        // Check selecting multiple divs
        $this->selectKeyword(1, 2);
        $this->assertTrue($this->topToolbarButtonExists('formats', NULL));

    }//end testFormatIconWhenSelectingDivs()


    /**
     * Test applying and removing the div tag to a paragraph when clicking inside a section
     *
     * @return void
     */
    public function testApplingAndRemovingTheDivFormatWhenClickingInSection()
    {

        // For a single line
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is some content %1% to test divs with</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test divs with</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // For a multi-line section
        $this->useTest(3);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

    }//end testApplingAndRemovingTheDivFormatWhenClickingInSection()


    /**
     * Test applying and removing the div tag to a paragraph
     *
     * @return void
     */
    public function testApplingAndRemovingTheDivFormatWhenSelectingSection()
    {
        // Using the inline toolbar on a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is some content %1% to test divs with</div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test divs with</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        // Using the top toolbar on a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is some content %1% to test divs with</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test divs with</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // Using the inline toolbar on a multi-line section
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);

        // Using the top toolbar on a multi-line section
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

    }//end testApplingAndRemovingTheDivFormatWhenSelectingSection()


    /**
     * Test that the div icon appears and is active in the inline toolbar when you select the Div tag.
     *
     * @return void
     */
    public function testCheckWhenDivIconIsAvailableInToolbar()
    {
        $this->useTest(2);

        // Check that icon is active in top toolbar when you click in a div.
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'Active Div icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        // Check that the icon is not available in the inline toolbar but is available in the top toolbar when you select a word.
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-div'), 'Formats icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-div');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

        // Check that the icon appears in the inline toolbar and top toolbar when you select a div.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Active Div icon should appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'Active Div icon should appear in the top toolbar');
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);

        // Change selection back to a word and check icon status.
        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-div'), 'Formats icon should appear in the top toolbar');

    }//end testCheckWhenDivIconIsAvailableInToolbar()
 

    /**
     * Test clicking the active div icon in the toolbar change it to a paragraph.
     *
     * @return void
     */
    public function testClickingActiveDivIconsInToolbar()
    {
        
        // Check that when you click the active div icon in the inline toolbar, it is changed to paragraph.
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% xtn dolor</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        // Check that when you click the active div icon in the top toolbar, it is changed to a paragraph.
        $this->useTest(3);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');
        
    }//end testClickingActiveDivIconsInToolbar()


    /**
     * Test that applying styles to whole div and selecting the Div value in lineage shows correct format icons in the toolbars.
     *
     * @return void
     */
    public function testSelectDivInLineageAfterStylingShowsCorrectFormatIcons()
    {
        // Apply bold and italics to a one line div section
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');

        // Select Div in lineage and make sure the correct icons are being shown in the inline toolbar.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->assertEquals($this->replaceKeywords('%1% xtn dolor'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertEquals($this->replaceKeywords('%1% xtn dolor'), $this->getSelectedText(), 'Original selection is not selected');

        // Apply bold and italics to a multi-line div section
        $this->useTest(3); 

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');

        // Select Div in the lineage and make sure the correct icons are being shown in the inline toolbar.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->assertEquals($this->replaceKeywords('%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertEquals($this->replaceKeywords('%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectDivInLineageAfterStylingShowsCorrectFormatIcons()


    /**
     * Test applying bold to a word in a Div.
     *
     * @return void
     */
    public function testApplyingBoldToWordInDiv()
    {
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<div><strong>%1%</strong> xtn dolor</div>');

        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');

    }//end testApplyingBoldToWordInDiv()


    /**
     * Test applying italics to a word in a Div.
     *
     * @return void
     */
    public function testApplyingItalicToWordInDiv()
    {
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<div><em>%1%</em> xtn dolor</div>');

        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');

    }//end testApplyingItalicToWordInDiv()


    /**
     * Test that when you only select part of a Div and apply a P, it applies a P inside a Div
     *
     * @return void
     */
    public function testApplyingPInsideDiv()
    {
        
        // Apply and remove the P
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-div'), 'DIV format icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-div');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<div><p>%1%</p> xtn dolor</div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('P', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

        // Do the same to a bold keyword
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->clickTopToolbarButton('formats-div');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<div>Div section with a strong word <p><strong>%1%</strong></p></div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('P', 'active', TRUE);
        $this->assertHTMLMatch('<div>Div section with a strong word <strong>%1%</strong></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

        // Do the same to an italic keyword
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->clickTopToolbarButton('formats-div');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<div>Div section with an italic word <p><em>%1%</em></p></div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('P', 'active', TRUE);
        $this->assertHTMLMatch('<div>Div section with an italic word <em>%1%</em></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar();


    }//end testApplyingPInsideDiv()


    /**
     * Test that when you only select part of a Div and apply a Pre, it applies a Pre inside a Div
     *
     * @return void
     */
    public function testApplyingPreInsideDiv()
    {
        // APply and remove the Pre
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-div'), 'DIV format icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-div');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<div><pre>%1%</pre> xtn dolor</div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('PRE', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

        // Do the same to a bold keyword
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->clickTopToolbarButton('formats-div');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<div>Div section with a strong word <pre><strong>%1%</strong></pre></div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('PRE', 'active', TRUE);
        $this->assertHTMLMatch('<div>Div section with a strong word <strong>%1%</strong></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

        // Do the same to an italic keyword
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->clickTopToolbarButton('formats-div');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<div>Div section with an italic word <pre><em>%1%</em></pre></div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('PRE', 'active', TRUE);
        $this->assertHTMLMatch('<div>Div section with an italic word <em>%1%</em></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

    }//end testApplyingPreInsideDiv()


    /**
     * Test that when you only select part of a Div and apply a quote, it applies a quote inside a Div
     *
     * @return void
     */
    public function testApplyingQuoteInsideDiv()
    {

        // Apply and remove quote section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-div'), 'DIV format icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-div');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<div><blockquote><p>%1%</p></blockquote> xtn dolor</div>');

        // Remove Quote
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<div><p>%1%</p> xtn dolor</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // Do the same to a bold keyword
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->clickTopToolbarButton('formats-div');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<div>Div section with a strong word <blockquote><p><strong>%1%</strong></p></blockquote></div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<div>Div section with a strong word <p><strong>%1%</strong></p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // Do the same to an italic keyword
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->clickTopToolbarButton('formats-div');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<div>Div section with an italic word <blockquote><p><em>%1%</em></p></blockquote></div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<div>Div section with an italic word <p><em>%1%</em></p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

    }//end testApplyingQuoteInsideDiv()


    /**
     * Test that when you only select part of a Div and apply the Div, it applies a Div inside a Div
     *
     * @return void
     */
    public function testApplyingDivInsideAnotherDiv()
    {
        
        // Apply and remove the div
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-div'), 'DIV format icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-div');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div><div>%1%</div> xtn dolor</div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

        // Do the same to a bold keyword
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->clickTopToolbarButton('formats-div');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>Div section with a strong word <div><strong>%1%</strong></div></div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>Div section with a strong word <strong>%1%</strong></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

        // Do the same to an italic keyword
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->clickTopToolbarButton('formats-div');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>Div section with an italic word <div><em>%1%</em></div></div>');

        // Remove Div
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>Div section with an italic word <em>%1%</em></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

    }//end testApplyingDivInsideAnotherDiv()


    /**
     * Test creating new content in div's.
     *
     * @return void
     */
    public function testCreatingNewContentWithinADivTag()
    {
        $this->useTest(6);

        $this->moveToKeyword(1, 'right');

        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New %2%');
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->moveToKeyword(2, 'right');
        $this->type(' on the page');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('More new content');

        $this->assertHTMLMatch('<p>Paragraph section %1%</p><div>New %2% on the page</div><p>More new content</p>');

    }//end testCreatingNewContentWithinADivTag()


    /**
     * Test creating new paragraphs after changing a new paragraph to a div.
     *
     * @return void
     */
    public function testCreatingParagraphsAfterNewlyCreatedDiv()
    {
        $this->useTest(6);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New %2%');

        // Change paragraph to a div
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');

        // Create more content
        $this->type('More new content');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Another paragraph');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Last paragraph');

        $this->assertHTMLMatch('<p>Paragraph section %1%</p><div>New %2%</div><p>More new content</p><p>Another paragraph</p><p>Last paragraph</p>');

    }//end testCreatingParagraphsAfterNewlyCreatedDiv()


    /**
     * Tests changing a div to a paragraph and then back again.
     *
     * @return void
     */
    public function testChangingADivToAParagraph()
    {
        // Using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn dolor</p>');

        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');

        // Using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn dolor</p>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');

    }//end testChangingADivToAParagraph()


     /**
     * Tests changing a div to a PRE and then back again.
     *
     * @return void
     */
    public function testChangingADivToAPre()
    {
        // Using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn dolor</pre>');

        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');

        // Using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn dolor</pre>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');

    }//end testChangingADivToAPre()


     /**
     * Test changing a quote to a div and then back again.
     *
     * @return void
     */
    public function testChangingADivToAQuote()
    {
        // Using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');

        // Using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div>');

    }//end testChangingADivToAQuote()


     /**
     * Tests that the list icons are not available for a div.
     *
     * @return void
     */
    public function testListIconsNotAvailableForDiv()
    {
        // Check single line Div section
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
        $this->sikuli->keyDown('Key.RIGHT');

        // Check multi-line Div section
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

    }//end testListIconsNotAvailableForDiv()


    /**
     * Test undo and redo for a div.
     *
     * @return void
     */
    public function testUndoAndRedoForDiv()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is some content %1% to test divs with</div>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>This is some content %1% to test divs with</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>This is some content %1% to test divs with</div>');

    }//end testUndoAndRedoForDiv()


    /**
     * Test combining two Div sections.
     *
     * @return void
     */
    public function testCombiningADivWithDifferentFormatSections()
    {
        // Combine two div sections
        $this->useTest(7);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<div>First div section%1% second div section</div>');

        // Combine a div and a paragraph section
        $this->useTest(8);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<div>First div section%1% second paragraph section</div>');

        // Combine a div and a blockquote section
        $this->useTest(9);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<div>First div section%1% second quote section</div>');

        // Combine a div and a pre section
        $this->useTest(10);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<div>First div section%1% second pre section</div>');

    }//end testCombiningADivWithDifferentFormatSections()


    /**
     * Test applying div sections around multiple paragraphs.
     *
     * @return void
     */
    public function testApplyDivsAroundMultipleParagraphs()
    {
        // Apply div around four paragraphs and then the bottom two
        $this->useTest(11);
        $this->selectKeyword(1, 4);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div><p>%1% first paragraph</p><p>Second paragraph %2%</p><p>%3% third paragraph</p><p>fourth paragraph %4%</p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        $this->selectKeyword(3, 4);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div><p>%1% first paragraph</p><p>Second paragraph %2%</p><div><p>%3% third paragraph</p><p>fourth paragraph %4%</p></div></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        // Apply div around four paragraphs and then the top two
        $this->useTest(11);
        $this->selectKeyword(1, 4);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div><p>%1% first paragraph</p><p>Second paragraph %2%</p><p>%3% third paragraph</p><p>fourth paragraph %4%</p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div><div><p>%1% first paragraph</p><p>Second paragraph %2%</p></div><p>%3% third paragraph</p><p>fourth paragraph %4%</p></div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

    }//end testApplyDivsAroundMultipleParagraphs()


    /**
     * Test changing a heading to a div and then adding new content.
     *
     * @return void
     */
    public function testChaningHeadingToDiv()
    {
        $this->useTest(12);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats', NULL);
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>Heading for the page %1%</div><p>First paragraph on the page</p><p>Second paragraph on the page</p>');

        $this->moveToKeyword(1, 'right');
        $this->type(' New content');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('More new content');

        $this->assertHTMLMatch('<div>Heading for the page %1% New content</div><p>More new content</p><p>First paragraph on the page</p><p>Second paragraph on the page</p>');

    }//end testChaningHeadingToDiv()


}//end class

?>
