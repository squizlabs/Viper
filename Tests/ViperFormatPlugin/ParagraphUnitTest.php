<?php

require_once 'AbstractFormatsUnitTest.php';

class Viper_Tests_ViperFormatPlugin_ParagraphUnitTest extends AbstractFormatsUnitTest
{


    /**
     * Test applying and removing the paragraph tag when clicking in a section
     *
     * @return void
     */
    public function testApplingAndRemovingTheParagraphFormatWhenClickingInSection()
    {
        
        // For a single line
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is some content %1% to test paragraph with</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test paragraph with</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // For a multi-line section
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

    }//end testApplingAndRemovingTheParagraphFormatWhenClickingInSection()


    /**
     * Test applying and removing the paragraph when selecting a section
     *
     * @return void
     */
    public function testApplingAndRemovingTheParagraphFormatWhenSelectingASection()
    {
        // Using the inline toolbar on a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is some content %1% to test paragraph with</div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test paragraph with</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        // Using the top toolbar on a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is some content %1% to test paragraph with</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test paragraph with</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // Using the inline toolbar on a multi-line section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        // Using the top toolbar on a multi-line section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');
        
    }//end testApplingAndRemovingTheQuoteFormatWhenSelectingASection()


    /**
     * Test the format icon in the toolbar for a paragraph section.
     *
     * @return void
     */
    public function testCheckWhenPIconIsAvailableInToolbar()
    {
        $this->useTest(1);

        // Check that icon is active in top toolbar when you click in a paragraph.
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // Check that the icon is not available in the inline toolbar or the top toolbar when you select a word.
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'));
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'disabled'));

        // Check that the icon appears in the inline toolbar and top toolbar when you select a p.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // Check that the icon is removed from the inline toolbar when you go from selection, to paragraph and back to selection.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'disabled'));
        
    }//end testCheckWhenPIconIsAvailableInToolbar()


    /**
     * Test clicking the active P icon in the toolbar.
     *
     * @return void
     */
    public function testClickingActivePIconsInToolbar()
    {
        
        // Check that when you click the active P icon in the inline toolbar, nothing happens.
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('P', 'active', TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test paragraph with</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        // Check that when you click the active P icon in the top toolbar, nothing happens.
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('P', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');
        
    }//end testCheckWhenPIconIsAvailableInToolbar()


    /**
     * Test that applying styles to whole paragraph and selecting the P in lineage shows correct icons.
     *
     * @return void
     */
    public function testSelectPAfterStylingShowsCorrectIcons()
    {
        // Apply bold and italics to a one line paragraph section
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');

        // Check that the inline toolbar is still on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }

        // Select p in lineage and make sure the correct icons are being shown in the inline toolbar.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');
        $this->assertEquals($this->replaceKeywords('This is some content %1% to test paragraph with'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');
        $this->assertEquals($this->replaceKeywords('This is some content %1% to test paragraph with'), $this->getSelectedText(), 'Original selection is not selected');

        // Apply bold and italics to a multi-line pre section
        $this->useTest(2); 

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');

        // Check that the inline toolbar is still on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }

        // Select P in the lineage and make sure the correct icons are being shown in the inline toolbar.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');
        $this->assertEquals($this->replaceKeywords('%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');
        $this->assertEquals($this->replaceKeywords('%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectPAfterStylingShowsCorrectIcons()


    /**
     * Test creating new content in pre tags.
     *
     * @return void
     */
    public function testCreatingNewContentWithAPTag()
    {
        $this->useTest(3);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New content');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('More new content');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('This should be a paragraph');

        $this->assertHTMLMatch('<p>Paragraph section XAX</p><p>New content</p><p>More new content</p><p>This should be a paragraph</p>');

    }//end testCreatingNewContentWithAPTag()


    /**
     * Tests changing a paragraph to a div and then back again.
     *
     * @return void
     */
    public function testChangingAParagraphToADiv()
    {
        // Using inline toolbar with a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is some content %1% to test paragraph with</div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test paragraph with</p>');

        // Using top toolbar with a single line
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is some content %1% to test paragraph with</div>');

        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test paragraph with</p>');

        // Using inline toolbar with multiline section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');

        // Using top toolbar with multiline section
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');

    }//end testChangingAParagraphToADiv()


     /**
     * Tests changing a paragraph to a PRE and then back again.
     *
     * @return void
     */
    public function testChangingAParagraphToAPre()
    {

        // Using inline toolbar with a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>This is some content %1% to test paragraph with</pre>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test paragraph with</p>');

        // Using top toolbar with a single line
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>This is some content %1% to test paragraph with</pre>');

        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test paragraph with</p>');

        // Using inline toolbar with multiline section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');

        // Using top toolbar with multiline section
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');

    }//end testChangingAParagraphToAPre()


     /**
     * Tests changing a paragraph to a quote and back again.
     *
     * @return void
     */
    public function testApplyingQuoteToAParagraph()
    {

        // Using inline toolbar with a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>This is some content %1% to test paragraph with</p></blockquote>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test paragraph with</p>');

        // Using top toolbar with a single line
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>This is some content %1% to test paragraph with</p></blockquote>');

        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test paragraph with</p>');

        // Using inline toolbar with multiline section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');

        // Using top toolbar with multiline section
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');

    }//end testApplyingQuoteToAParagraph()


     /**
     * Tests that the list icon is available for a paragraph.
     *
     * @return void
     */
    public function testListIconsAvailableForParagraph()
    {

        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('listOL'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL'), 'Unordered list icon should be available in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('listOL'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL'), 'Unordered list icon should be available in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('listOL'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL'), 'Unordered list icon should be available in the top toolbar');

        // Check multi-line paragraph
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('listOL'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL'), 'Unordered list icon should be available in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('listOL'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL'), 'Unordered list icon should be available in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('listOL'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL'), 'Unordered list icon should be available in the top toolbar');

    }//end testListIconsAvailableForParagraph()


    /**
     * Test undo and redo for a paragraph.
     *
     * @return void
     */
    public function testUndoAndRedoForParagraph()
    {
        $this->useTest(6);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>First paragraph section</p><p>%1% Second div section</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>First paragraph section</p><div>%1% Second div section</div>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>First paragraph section</p><p>%1% Second div section</p>');

    }//end testUndoAndRedoForParagraph()


    /**
     * Test combining different formats to a pre section.
     *
     * @return void
     */
    public function testCombiningAParagraphWithDifferentFormatSections()
    {
        // Combine a p and a quote section
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>First paragraph section%1% Second blockquote section</p>');

        // Combine a pre and a paragraph section
        $this->useTest(5);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>First paragraph section%1% Second pre section</p>');

        // Combine a paragraph and a div section
        $this->useTest(6);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>First paragraph section%1% Second div section</p>');

        // Combine a two paragraphs
        $this->useTest(7);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>First paragraph section%1% Second paragraph section</p>');

    }//end testCombiningAParagraphWithDifferentFormatSections()

}//end class

?>
