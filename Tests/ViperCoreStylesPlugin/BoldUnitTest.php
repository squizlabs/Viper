<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_BoldUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testStartOfParaBold()
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

        // Remove bold using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStartOfParaBold()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaBold()
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

    }//end testMidOfParaBold()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaBold()
    {
        $this->useTest(1);
        
        // Use inline toolbar
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% %2% <strong>%3%</strong></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

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

    }//end testEndOfParaBold()


    /**
     * Test that bold is applied to two words and then removed from one word.
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
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% <strong>%2% </strong>%3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove bold from the other word
        $this->selectKeyword(2);
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');

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
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>%1% <strong>%2% </strong>%3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove bold from the other word
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('bold', 'active');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->moveToKeyword(1);
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
     * Test checking that the strong tag is not used when you delete bold content and add new content.
     *
     * @return void
     */
    public function testDeletingBoldContent()
    {
        $this->useTest(1);
        
        // Delete bold word and replace with new content
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> this is new content</p>');

    }//end testDeletingBoldContent()


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
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

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
     * Test applying a bold to two words where one word is italics.
     *
     * @return void
     */
    public function testAddBoldToTwoWordsWhereOneItalics()
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

    }//end testAddBoldToTwoWordsWhereOneItalics()


    /**
     * Test applying bold to two words where one is bold and one is italics.
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

        $this->sikuli->click($this->findKeyword(2));

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
     * Test that a paragraph can be made bold using the top toolbar and that the VITP bold icon will appear when that happen. Then remove the bold formatting and check that the VITP bold icon is removed.
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

        //Remove bold formating
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
    public function testAddAndRemoveBoldForLink()
    {
        $this->useTest(4);
        
        // Using inline toolbar
        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('bold');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com"><strong>%1%</strong></a> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon should be active');

        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        // Check to see if bold icon is in the inline toolbar
        $this->assertTrue($this->inLineToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold'), 'Bold icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should not be active');

        // Using top toolbar
        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com"><strong>%1%</strong></a> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon should be active');

        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        // Check to see if bold icon is in the inline toolbar
        $this->assertTrue($this->inLineToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold'), 'Bold icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should not be active');

        // Using keyboard shortcuts
        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com"><strong>%1%</strong></a> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon should be active');

        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        // Check to see if bold icon is in the inline toolbar
        $this->assertTrue($this->inLineToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> end of test content.</p>');
        $this->assertTrue($this->inLineToolbarButtonExists('bold'), 'Bold icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should not be active');

    }//end testAddAndRemoveBoldForLink()


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

}//end class

?>
