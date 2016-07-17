<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_BoldUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testApplyBoldToStartOfParragraph()
    {
        $this->useTest(1);

        // Apply bold using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p><strong>%1%</strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove bold using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Apply bold using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p><strong>%1%</strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Rstrongove bold using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testApplyBoldToStartOfParragraph()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testApplyyBoldToMiddleOfParagraph()
    {
        $this->useTest(1);

        // Use inline toolbar
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <strong>%2%</strong> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove bold using inline toolbar
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Use top toolbar
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <strong>%2%</strong> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove bold using top toolbar
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testApplyyBoldToMiddleOfParagraph()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testApplyBoldToEndOfParagraph()
    {
        $this->useTest(1);

        // Use inline toolbar
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% %2% <strong>%3%</strong></p><p>sit <em>%4%</em><strong>%5%</strong></p>');

        // Remove bold using inline toolbar
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Use top toolbar
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% %2% <strong>%3%</strong></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove bold using top toolbar
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testApplyBoldToEndOfParagraph()


    /**
     * Test that bold is applied to two words and then remove from one word.
     *
     * @return void
     */
    public function testRemoveBoldFromPartOfContent()
    {
        $this->useTest(1);

        // Apply bold to two words
        $this->selectKeyword(2, 3);
        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <strong>%2% %3%</strong></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove bold from one word
        $this->clickKeyword(1);
        sleep(1);
        $this->selectKeyword(3);
        sleep(1);
        $this->clickInlineToolbarButton('bold', 'active');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% <strong>%2% </strong>%3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove bold from the other word
        $this->clickKeyword(1);
        sleep(1);
        $this->selectKeyword(2);
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->clickInlineToolbarButton('bold', 'active');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testRemoveBoldFromPartOfContent()


    /**
     * Test that the strong tags are added in the correct location when you apply, remove and re-apply bold formatting to two words in the content.
     *
     * @return void
     */
    public function testStrongTagsAppliedCorrectlyWhenReapplyingBold()
    {
        $this->useTest(1);

        // Apply bold to two words
        $this->selectKeyword(2, 3);
        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon does not exist in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Clas icon does not exist in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon does not exist in the inline toolbar');
        $this->assertHTMLMatch('<p>%1% <strong>%2% %3%</strong></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove bold from one word
        $this->clickKeyword(1);
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>%1% <strong>%2% </strong>%3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove bold from the other word
        $this->clickKeyword(1);
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('bold', 'active');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickKeyword(1);
        sleep(1);

        // Reapply bold formatting to both words
        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p>%1% <strong>%2% %3%</strong></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon does not exist in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Clas icon does not exist in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon does not exist in the inline toolbar');

    }//end testStrongTagsAppliedCorrectlyWhenReapplyingBold()


    /**
     * Test that the shortcut command works for Bold.
     *
     * @return void
     */
    public function testBoldShortcutCommand()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p><strong>%1%</strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em><strong>%5%</strong></p>');

    }//end testShortcutCommand()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentBoldStyling()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + b');

        $this->selectKeyword(1, 2);
        // Make sure the bold icon is inactive in the toolbars.
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'bold icon should appear in the toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should appear in the toolbar');
        $this->sikuli->keyDown('Key.CMD + b');
        // Make sure the bold icon is now active in the toolbars.
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Active bold icon should appear in the toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Active bold icon should appear in the toolbar');

        $this->selectKeyword(2, 3);
        // Make sure the bold icon is inactive in the toolbars.
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'bold icon should appear in the toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should appear in the toolbar');
        $this->sikuli->keyDown('Key.CMD + b');
        // Make sure the bold icon is now active in the toolbars.
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Active bold icon should appear in the toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Active bold icon should appear in the toolbar');

        $this->assertHTMLMatch('<p><strong>%1% %2% %3%</strong></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAdjacentBoldStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedBoldStyling()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + b');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');

        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p><strong>%1%</strong> <strong>%2%</strong> <strong>%3%</strong></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testSpaceSeparatedBoldStyling()


    /**
     * Test that the VITP bold icon is removed from the toolbar when you click the P tag.
     *
     * @return void
     */
    public function testBoldIconIsRemovedFromInlineToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(2);

        // Inline Toolbar icon should be displayed.
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon does not exist in the inline toolbar');

        // Click the P tag.
        $this->selectInlineToolbarLineageItem(0);

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon still appears in the inline toolbar');

        // Click the Selection tag.
        $this->selectInlineToolbarLineageItem(1);

        // Inline Toolbar icon should be displayed.
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon does appear in the inline toolbar');

    }//end testBoldIconIsRemovedFromInlineToolbar()


    /**
     * Test applying a bold to two words where one word is italic.
     *
     * @return void
     */
    public function testAddBoldToTwoWordsWhereOneItalic()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% <em>%2%</em> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->selectKeyword(2, 3);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% <strong><em>%2%</em> %3%</strong></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAddBoldToTwoWordsWhereOneItalic()


    /**
     * Test applying bold to two words where one is bold and one is italic.
     *
     * @return void
     */
    public function testAddBoldToTwoWordsWhereOneBoldAndOneItalics()
    {
        $this->useTest(1);

        $this->selectKeyword(4, 5);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <strong><em>%4%</em> %5%</strong></p>');

    }//end testAddBoldToTwoWordsWhereOneBoldAndOneItalics()


    /**
     * Test applying bold to two paragraphs where there is a HTML comment in the source code.
     *
     * @return void
     */
    public function testAddAndRemoveBoldToTwoParagraphsWhereHtmlCommentsInSource()
    {
        $this->useTest(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p><strong>%1% %2% %3%</strong><!-- hello world! --></p><p>sit %4% %5%</p><p>Another p</p>');

        $this->clickKeyword(2);

        $this->selectKeyword(5);
        sleep(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p><strong>%1% %2% %3%</strong><!-- hello world! --></p><p><strong>sit %4% %5%</strong></p><p>Another p</p>');

        $this->selectKeyword(1, 5);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>%1% %2% %3%<!-- hello world! --></p><p>sit %4% %5%</p><p>Another p</p>');

    }//end testAddAndRemoveBoldToTwoParagraphsWhereHtmlCommentsInSource()


    /**
     * Test that a paragraph can be made bold using the top toolbar and that the VITP bold icon will appear when that happens. Then remove the bold formatting and check that the VITP bold icon is removed.
     *
     * @return void
     */
    public function testAddAndRemoveBoldToParagraph()
    {
        $this->useTest(1);

        $this->selectKeyword(1, 3);

        // The bold icon in the inline toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon appears in the inline toolbar and is active');

        // Click the Top Toolbar icon to make whole paragraph bold.
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p><strong>%1% %2% %3%</strong></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon is not active in the top toolbar');

        // The bold icon should now be disaplyed in the inline toolbar
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Active bold icon does not appear in the inline toolbar');

        //Rstrongove bold formating
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon is still active in the top toolbar');

        // Bold icon in the inline toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon still appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active bold icon still appear in the inline toolbar');

    }//end testAddAndRemoveBoldToParagraph()


    /**
     * Test applying and removing bold to two paragraphs.
     *
     * @return void
     */
    public function testAddAndRemoveBoldToTwoParagraphs()
    {
        $this->useTest(3);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p><strong>%1% %2% %3%</strong></p><p>sit %4% %5%</p><p>Another p</p>');

        $this->moveToKeyword(2);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p><strong>%1% %2% %3%</strong></p><p><strong>sit %4% %5%</strong></p><p>Another p</p>');

        $this->selectKeyword(1, 5);
        // Check toolbar icons
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar should not be active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% %5%</p><p>Another p</p>');

    }//end testAddAndRemoveBoldToTwoParagraphs()


    /**
     * Test applying and removing bold to across multiple paragraphs at the same time.
     *
     * @return void
     */
    public function testAddAndRemoveBoldToMultipleParagraphs()
    {
        $this->useTest(3);

        // Apply bold using the inline toolbar
        $this->selectKeyword(1, 5);
        $this->clickInlineToolbarButton('bold');
        $this->assertHTMLMatch('<p><strong>%1% %2% %3%</strong></p><p><strong>sit %4% %5%</strong></p><p>Another p</p>');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Remove bold using inline toolbar
        $this->selectKeyword(1, 5);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar should noy be active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar should not be active');

        // Apply bold using the top toolbar
        $this->selectKeyword(1, 5);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p><strong>%1% %2% %3%</strong></p><p><strong>sit %4% %5%</strong></p><p>Another p</p>');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');

        // Remove bold using top toolbar
        $this->selectKeyword(1, 5);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar should noy be active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar should not be active');

    }//end testAddAndRemoveBoldToMultipleParagraphs()


    /**
     * Test applying and removing bold to all content. Also checks that class and anchor does not become active when it applies the bold
     *
     * @return void
     */
    public function testAddAndRemoveBoldToAllContent()
    {
        $this->useTest(1);

        $this->moveToKeyword(2);
        $this->sikuli->keyDown('Key.CMD + a');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar should not be active');
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p><strong>%1% %2% %3%</strong></p><p><strong>sit <em>%4%</em> %5%</strong></p>');

        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'), 'Class icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should not be active');

        $this->moveToKeyword(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> %5%</p>');

        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'), 'Class icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should not be active');

    }//end testAddAndRemoveBoldToAllContent()


    /**
     * Test applying and removing bold for a link in the content of a page.
     *
     * @return void
     */
    public function testAddAndRemovingBoldForLink()
    {
        $this->useTest(4);

        // Using inline toolbar
        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickInlineToolbarButton('bold');
        $this->assertHTMLMatch('<p>Test content <strong><a href="http://www.squizlabs.com">%1%</a></strong> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon should be active');

        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        sleep(1);
        // Check to see if bold icon is in the inline toolbar
        $this->assertTrue($this->inLineToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold'), 'Bold icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should not be active');

        // Using top toolbar
        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p>Test content <strong><a href="http://www.squizlabs.com">%1%</a></strong> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon should be active');

        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        sleep(1);
        // Check to see if bold icon is in the inline toolbar
        $this->assertTrue($this->inLineToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold'), 'Bold icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should not be active');

        // Using keyboard shortcuts
        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Test content <strong><a href="http://www.squizlabs.com">%1%</a></strong> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon should be active');

        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        sleep(1);
        // Check to see if bold icon is in the inline toolbar
        $this->assertTrue($this->inLineToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold'), 'Bold icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should not be active');

    }//end testAddAndRemovingBoldForLink()


    /**
     * Test applying and removing bold for a link in bolded paragraph.
     *
     * @return void
     */
    public function testRemoveBoldForLinkInBoldParagraph()
    {
        // Using inline toolbar
        $this->useTest(6);
        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        sleep(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p><strong>Test content </strong><a href="http://www.squizlabs.com">%1%</a><strong> end of test content.</strong></p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold'), 'Bold icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should not be active');

        // Using top toolbar
        $this->useTest(6);
        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        sleep(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p><strong>Test content </strong><a href="http://www.squizlabs.com">%1%</a><strong> end of test content.</strong></p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold'), 'Bold icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should not be active');

        // Using keyboard shortcut
        $this->useTest(6);
        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p><strong>Test content </strong><a href="http://www.squizlabs.com">%1%</a><strong> end of test content.</strong></p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold'), 'Bold icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should not be active');

    }//end testRemoveBoldForLinkInBoldParagraph()


    /**
     * Test that undo and redo buttons for bold formatting.
     *
     * @return void
     */
    public function testUndoAndRedoForBold()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold');

        $this->assertHTMLMatch('<p><strong>%1%</strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p><strong>%1%</strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon should be active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon should be active in the top toolbar');

    }//end testUndoAndRedoForBold()


    /**
     * Test that bold icon is not available in the inline toolbar for a heading.
     *
     * @return void
     */
    public function testBoldIconForHeadingInInlineToolbar()
    {
        $this->useTest(5);

        // Test H1
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('bold'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('bold'));

        // Test H2
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('bold'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('bold'));

        // Test H3
        $this->selectKeyword(3);
        $this->assertFalse($this->inlineToolbarButtonExists('bold'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('bold'));

        // Test H4
        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('bold'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('bold'));

        // Test H5
        $this->selectKeyword(5);
        $this->assertFalse($this->inlineToolbarButtonExists('bold'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('bold'));

        // Test H6
        $this->selectKeyword(6);
        $this->assertFalse($this->inlineToolbarButtonExists('bold'));
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('bold'));

    }//end testBoldIconForHeadingInInlineToolbar()


    /**
     * Test deleting bold content
     *
     * @return void
     */
    public function testDeletingBoldContent()
    {
        // Test selecting a single word and replacing with new content
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>this is new content</strong></p><p>Some more bold <strong>%2% %3%</strong> content to test</p>');

        $this->useTest(7);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content this is new content</p><p>Some more bold <strong>%2% %3%</strong> content to test</p>');

        $this->useTest(7);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content this is new content</p><p>Some more bold <strong>%2% %3%</strong> content to test</p>');

        // Test replacing bold section with new content with highlighting
        $this->useTest(7);
        $this->selectKeyword(2, 3);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>%1%</strong></p><p>Some more bold <strong>test</strong> content to test</p>');

        $this->useTest(7);
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>%1%</strong></p><p>Some more bold test content to test</p>');

        $this->useTest(7);
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>%1%</strong></p><p>Some more bold test content to test</p>');

        // Test replacing bold content with new content when selecting one keyword and using the lineage
        $this->useTest(7);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>%1%</strong></p><p>Some more bold <strong>test</strong> content to test</p>');

        $this->useTest(7);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>%1%</strong></p><p>Some more bold test content to test</p>');

        $this->useTest(7);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>%1%</strong></p><p>Some more bold test content to test</p>');

        // Test replacing all content
        $this->useTest(10);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('<p>test</p>');

    }//end testDeletingBoldContent()


     /**
     * Test deleting content including content with bold formatting
     *
     * @return void
     */
    public function testDeletingAndAddingNewContentWithBoldFormatting()
    {
         // Check deleting a word after the bold content
        $this->useTest(9);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% <strong>a %2% b</strong></p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% <strong>a %2% b</strong> content</p>');

        // Check deleting a word after the bold content up to the bold content
        $this->useTest(9);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% <strong>a %2% b</strong></p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% <strong>a %2% bcontent</strong></p>');

        // Check deleting from the end of the paragraph including bold content
        $this->useTest(9);
        $this->moveToKeyword(3, 'right');

        for ($i = 0; $i < 11; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>%1%</p>');
        sleep(1);

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% content</p>');

        // Check deleting from the start of the paragraph
        $this->useTest(9);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p><strong>a %2% b</strong> %3%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content<strong>a %2% b</strong> %3%</p>');

        // Check deleting from the start of the paragraph up to the bold content
        $this->useTest(9);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p><strong>a %2% b</strong> %3%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p><strong>contenta %2% b</strong> %3%</p>');

        // Check deleting from the start of the paragraph including bold content
        $this->useTest(9);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 11; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>%3%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content %3%</p>');

    }//end testDeletingAndAddingNewContentWithBoldFormatting()


    /**
     * Test that you can remove bold from two different sections of content at the same time.
     *
     * @return void
     */
    public function testRemovingBoldFromDifferentSectionsInContent()
    {
        // Remove using top toolbar
        $this->useTest(8);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('bold', 'active');

        // Perform the check using raw html as there is a bug that removes the space between 'more %1%' when it removes the bold formatting
        $this->assertHTMLMatch('<p>Text <strong>more </strong>%1%text text and more%2%<strong> text</strong></p>', $this->getRawHtml());

        // Reapply using top toolbar
        $this->clickTopToolbarButton('bold');
        $this->assertEquals('<p>Text <strong>more %1%text text and more%2% text</strong></p>', $this->getRawHtml());

        // Using inline toolbar
        $this->useTest(8);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertEquals('<p>Text <strong>more </strong>%1%text text and more%2%<strong> text</strong></p>', $this->getRawHtml());

        // Reapply using inline toolbar
        $this->clickInlineToolbarButton('bold');
        $this->assertEquals('<p>Text <strong>more %1%text text and more%2% text</strong></p>', $this->getRawHtml());

        // Using keyboard shortcut
        $this->useTest(8);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertEquals('<p>Text <strong>more </strong>%1%text text and more%2%<strong> text</strong></p>', $this->getRawHtml());

        // Reapply using keyboard shortcut
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertEquals('<p>Text <strong>more %1%text text and more%2% text</strong></p>', $this->getRawHtml());

    }//end testRemovingBoldFromDifferentSectionsInContent()


    /**
     * Test adding content before and after bold content
     *
     * @return void
     */
    public function testAddingContentAroundBoldContent()
    {
        // Test adding content before bold content when cursor starts inside the bold content
        $this->useTest(9);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('new ');
        $this->assertHTMLMatch('<p>%1% new <strong>a %2% b</strong> %3%</p>');

        // Test adding content before bold content when cursor starts elsewhere in content
        $this->useTest(9);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('new ');
        $this->assertHTMLMatch('<p>%1% new <strong>a %2% b</strong> %3%</p>');

        // Test adding content after bold content when cursor starts inside the bold content
        $this->useTest(9);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' new');
        $this->assertHTMLMatch('<p>%1% <strong>a %2% b new</strong> %3%</p>');

        // Test adding content before bold content when cursor starts elsewhere in content
        $this->useTest(9);
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type(' new');
        $this->assertHTMLMatch('<p>%1% <strong>a %2% b new</strong> %3%</p>');

    }//end testAddingContentAroundBoldContent()


    /**
     * Test editing bold content
     *
     * @return void
     */
    public function testEditingBoldContent()
    {
        // Test adding content before the start of the bold formatting
        $this->useTest(11);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test ');
        $this->assertHTMLMatch('<p>Some %1% bold test <strong>%2% content %3% to test %4%</strong> more %5% content</p>');

        // Test adding content in the middle of bold formatting
        $this->useTest(11);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<p>Some %1% bold <strong>%2% test content %3% to test %4%</strong> more %5% content</p>');

        // Test adding content to the end of bold formatting
        $this->useTest(11);
        $this->moveToKeyword(4, 'left');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('<p>Some %1% bold <strong>%2% content %3% to test %4% test</strong> more %5% content</p>');

        // Test highlighting some content in the strong tags and replacing it
        $this->useTest(11);
        $this->selectKeyword(3);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% bold <strong>%2% content test to test %4%</strong> more %5% content</p>');

        // Test highlighting the first word of the strong tags and replace it. Should stay in strong tag.
        $this->useTest(11);
        $this->selectKeyword(2);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% bold <strong>test content %3% to test %4%</strong> more %5% content</p>');

        // Test hightlighting the first word, pressing forward + delete and replace it. Should be outside the strong tag.
        $this->useTest(11);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% bold test<strong> content %3% to test %4%</strong> more %5% content</p>');

        // Test highlighting the first word, pressing backspace and replace it. Should be outside the strong tag.
        $this->useTest(11);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% bold test<strong> content %3% to test %4%</strong> more %5% content</p>');

        // Test highlighting the last word of the strong tags and replace it. Should stay in strong tag.
        $this->useTest(11);
        $this->selectKeyword(4);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% bold <strong>%2% content %3% to test test</strong> more %5% content</p>');

        // Test highlighting the last word of the strong tags, pressing forward + delete and replace it. Should stay inside strong
        $this->useTest(11);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% bold <strong>%2% content %3% to test test</strong> more %5% content</p>');

        // Test highlighting the last word of the strong tags, pressing backspace and replace it. Should stay inside strong.
        $this->useTest(11);
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% bold <strong>%2% content %3% to test test</strong> more %5% content</p>');

        // Test selecting from before the strong tag to inside. New content should not be in bold.
        $this->useTest(11);
        $this->selectKeyword(1, 3);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some test<strong> to test %4%</strong> more %5% content</p>');

        // Test selecting from after the strong tag to inside. New content should be in bold.
        $this->useTest(11);
        $this->selectKeyword(3, 5);
        $this->type('test');
        $this->assertHTMLMatch('<p>Some %1% bold <strong>%2% content test</strong> content</p>');

    }//end testEditingBoldContent()


    /**
     * Test splitting a bold section in content
     *
     * @return void
     */
    public function testSplittingBoldContent()
    {
        // Test pressing enter in the middle of bold content
        $this->useTest(9);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p>%1% <strong>a %2%</strong></p><p><strong>test b</strong> %3%</p>');

        // Test pressing enter at the start of strong content
        $this->useTest(9);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<p>%1% </p><p><strong>test a %2% b</strong> %3%</p>');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('<p>%1% test</p><p><strong>test a %2% b</strong> %3%</p>');

        // Test pressing enter at the end of strong content
        $this->useTest(9);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('<p>%1% <strong>a %2% b</strong></p><p>test&nbsp;&nbsp;%3%</p>');

    }//end testSplittingBoldContent()


    /**
     * Test undo and redo applying bold to content
     *
     * @return void
     */
    public function testUndoAndRedoApplyingBoldContent()
    {
        // Apply bold content
        $this->useTest(3);
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('bold');
        $this->assertHTMLMatch('<p>%1% <strong>%2%</strong> %3%</p><p>sit %4% %5%</p><p>Another p</p>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <strong>%2%</strong> %3%</p><p>sit %4% %5%</p><p>Another p</p>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>%1% <strong>%2%</strong> %3%</p><p>sit %4% %5%</p><p>Another p</p>');

         // Apply bold content again
        $this->selectKeyword(4);
        $this->clickInlineToolbarButton('bold');
        $this->assertHTMLMatch('<p>%1% <strong>%2%</strong> %3%</p><p>sit <strong>%4%</strong> %5%</p><p>Another p</p>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% <strong>%2%</strong> %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <strong>%2%</strong> %3%</p><p>sit <strong>%4%</strong> %5%</p><p>Another p</p>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1% <strong>%2%</strong> %3%</p><p>sit %4% %5%</p><p>Another p</p>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>%1% <strong>%2%</strong> %3%</p><p>sit <strong>%4%</strong> %5%</p><p>Another p</p>');

    }//end testUndoAndRedoBoldContent()


    /**
     * Test undo and redo when editing bold content
     *
     * @return void
     */
    public function testUndoAndRedoWithEditingBoldContent()
    {

        // Add content to the middle of the bold content
        $this->useTest(7);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>%1%</strong></p><p>Some more bold <strong>%2% test %3%</strong> content to test</p>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>%1%</strong></p><p>Some more bold <strong>%2% %3%</strong> content to test</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>%1%</strong></p><p>Some more bold <strong>%2% test %3%</strong> content to test</p>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>%1%</strong></p><p>Some more bold <strong>%2% %3%</strong> content to test</p>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>%1%</strong></p><p>Some more bold <strong>%2% test %3%</strong> content to test</p>');

        // Test deleting content and pressing undo
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content </p><p>Some more bold <strong>%2% test %3%</strong> content to test</p>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>%1%</strong></p><p>Some more bold <strong>%2% test %3%</strong> content to test</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content </p><p>Some more bold <strong>%2% test %3%</strong> content to test</p>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content <strong>%1%</strong></p><p>Some more bold <strong>%2% test %3%</strong> content to test</p>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>Some content</p><p>sit test content </p><p>Some more bold <strong>%2% test %3%</strong> content to test</p>');

    }//end testUndoAndRedoWithEditingBoldContent()


}//end class

?>
