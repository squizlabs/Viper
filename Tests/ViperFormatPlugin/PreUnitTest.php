<?php

require_once 'AbstractFormatsUnitTest.php';

class Viper_Tests_ViperFormatPlugin_PreUnitTest extends AbstractFormatsUnitTest
{

    /**
     * Test format icons when selecting multiple pre sections.
     *
     * @return void
     */
    public function testFormatIconWhenSelectingPreSections()
    {
        $this->useTest(9);

        // Check selecting a single pre section
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-pre', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'));

        // Check selecting multiple pre sections
        $this->selectKeyword(1, 2);
        $this->assertTrue($this->topToolbarButtonExists('formats', NULL));

    }//end testFormatIconWhenSelectingPreSections()


    /**
     * Test applying and removing the pre tag to a paragraph when clicking in a section
     *
     * @return void
     */
    public function testApplingAndRemovingThePreFormatWhenClickingInSection()
    {
        
        // For a single line
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test pre with</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>This is some content %1% to test pre with</pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

        // For a multi-line section
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

    }//end testApplingAndRemovingThePreFormatWhenClickingInSection()


    /**
     * Test applying and removing the pre tag to a paragraph when selecting a section
     *
     * @return void
     */
    public function testApplingAndRemovingThePreFormatWhenSelectingASection()
    {
        // Using the inline toolbar on a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test pre with</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>This is some content %1% to test pre with</pre>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');

        // Using the top toolbar on a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test pre with</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>This is some content %1% to test pre with</pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

        // Using the inline toolbar on a multi-line section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');

        // Using the top toolbar on a multi-line section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        
    }//end testApplingAndRemovingTheQuoteFormatWhenSelectingASection()


    /**
     * Test the format icon in the toolbar for a pre section.
     *
     * @return void
     */
    public function testCheckWhenPreIconIsAvailableInToolbar()
    {
        $this->useTest(1);

        // Check that icon is active in top toolbar when you click in a pre.
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'), 'Active pre icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

        // Check that the icon is not available in the inline toolbar or the top toolbar when you select a word.
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Active pre icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'disabled'), 'Disabled formats icon should appear in the top toolbar');

        // Check that the icon appears in the inline toolbar and top toolbar when you select a pre.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Active pre icon should appear in the inline toolbar');
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'), 'Active pre icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

        // Check that the icon is removed from the inline toolbar when you go from selection, to quote and back to selection.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Active pre icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'disabled'), 'Disabled pre icon should appear in the top toolbar');
        
    }//end testCheckWhenPreIconIsAvailableInToolbar()


    /**
     * Test clicking the active pre icon in the toolbar change it to a paragraph.
     *
     * @return void
     */
    public function testClickingActivePreIconsInToolbar()
    {
        
        // Check that when you click the active pre icon in the inline toolbar, it is changed to paragraph.
        $this->useTest(1);
        sleep(1);
        $this->selectKeyword(1);
        sleep(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('PRE', 'active', TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test pre with</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        // Check that when you click the active pre icon in the top toolbar, it is changed to a paragraph.
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('PRE', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');
        
    }//end testClickingActivePreIconsInToolbar()


    /**
     * Test that applying styles to whole pre and selecting the PRE in lineage shows correct icons.
     *
     * @return void
     */
    public function testSelectPreAfterStylingShowsCorrectIcons()
    {
        // Apply bold and italics to a one line quote section
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

        // Select pre in lineage and make sure the correct icons are being shown in the inline toolbar.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertEquals($this->replaceKeywords('This is some content %1% to test pre with'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertEquals($this->replaceKeywords('This is some content %1% to test pre with'), $this->getSelectedText(), 'Original selection is not selected');

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

        // Select Pre in the lineage and make sure the correct icons are being shown in the inline toolbar.
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertEquals($this->replaceKeywords('%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertEquals($this->replaceKeywords('%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectPreAfterStylingShowsCorrectIcons()


    /**
     * Test bold works in Pre.
     *
     * @return void
     */
    public function testUsingBoldInPre()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<pre>This is some content <strong>%1%</strong> to test pre with</pre>');

        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<pre>This is some content %1% to test pre with</pre>');

    }//end testUsingBoldInPre()


    /**
     * Test italics works in pre.
     *
     * @return void
     */
    public function testUsingItalicInPre()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<pre>This is some content <em>%1%</em> to test pre with</pre>');

        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<pre>This is some content %1% to test pre with</pre>');

    }//end testUsingItalicInPre()


    /**
     * Test creating new content in pre tags.
     *
     * @return void
     */
    public function testCreatingNewContentWithAPreTag()
    {
        $this->useTest(3);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New %2%');

        // Change new content to a pre section
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);

        // Add new content to pre section
        $this->moveToKeyword(2, 'right');
        $this->type(' on the page');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('More new content');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('This should be a paragraph');

        $this->assertHTMLMatch('<p>Paragraph section %1%</p><pre>New %2% on the page More new content </pre><p>This should be a paragraph</p>');

    }//end testCreatingNewContentWithAPreTag()


    /**
     * Test changing a pre to a div and then back again.
     *
     * @return void
     */
    public function testChaningAPreToADiv()
    {
        // Using inline toolbar with a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is some content %1% to test pre with</div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>This is some content %1% to test pre with</pre>');

        // Using top toolbar with a single line
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is some content %1% to test pre with</div>');

        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>This is some content %1% to test pre with</pre>');

        // Using inline toolbar with multiline section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');

        // Using top toolbar with multiline section
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');

    }//end testChaningAPreToADiv()


    /**
     * Test changing a pre to a paragraph and then back again.
     *
     * @return void
     */
    public function testChaningAPreToAParagraph()
    {
        // Using inline toolbar with a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test pre with</p>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>This is some content %1% to test pre with</pre>');

        // Using top toolbar with a single line
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>This is some content %1% to test pre with</p>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>This is some content %1% to test pre with</pre>');

        // Using inline toolbar with multiline section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');

        // Using top toolbar with multiline section
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');

    }//end testChaningAPreToAParagraph()
   

    /**
     * Test changing a pre to a quote and then back again.
     *
     * @return void
     */
    public function testChaningAPreToAQuote()
    {
        // Using inline toolbar with a single line
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>This is some content %1% to test pre with</p></blockquote>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>This is some content %1% to test pre with</pre>');

        // Using top toolbar with a single line
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>This is some content %1% to test pre with</p></blockquote>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>This is some content %1% to test pre with</pre>');

        // Using inline toolbar with multiline section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');

        // Using top toolbar with multiline section
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p></blockquote>');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');

    }//end testChaningAPreToAQuote()
    

    /**
     * Tests that the list icons are not available for a pre.
     *
     * @return void
     */
    public function testListIconsNotAvailableForPre()
    {

        $this->useTest(1);

        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        // Check multi-line pre section
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

    }//end testListIconsNotAvailableForPre()


    /**
     * Test undo and redo for a pre.
     *
     * @return void
     */
    public function testUndoAndRedoForPre()
    {
        $this->useTest(3);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>Paragraph section %1%</pre>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Paragraph section %1%</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<pre>Paragraph section %1%</pre>');

    }//end testUndoAndRedoForPre()


    /**
     * Test combining different formats to a pre section.
     *
     * @return void
     */
    public function testCombiningAPreWithDifferentFormatSections()
    {
        // Combine a pre and a quote section
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<pre>First pre section%1% Second blockquote section</pre>');

        // Combine a pre and a paragraph section
        $this->useTest(5);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<pre>First pre section%1% Second paragraph section</pre>');

        // Combine a quote and a div section
        $this->useTest(6);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<pre>First pre section%1% Second div section</pre>');

        // Combine a two pre sections
        $this->useTest(7);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<pre>First pre section%1% Second pre section</pre>');

    }//end testCombiningAPreWithDifferentFormatSections()


    /**
     * Test changing a heading to a pre and then adding new content.
     *
     * @return void
     */
    public function testChaningHeadingToPre()
    {
        $this->useTest(8);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats', NULL);
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>Heading for the page %1%</pre><p>First paragraph on the page</p><p>Second paragraph on the page</p>');

        $this->moveToKeyword(1, 'right');
        $this->type(' New content');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('More new content');

        $this->assertHTMLMatch('<pre>Heading for the page %1% New content</pre><p>More new content</p><p>First paragraph on the page</p><p>Second paragraph on the page</p>');

    }//end testChaningHeadingToPre()


}//end class

?>
