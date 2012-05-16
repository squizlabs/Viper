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
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><strong>Lorem</strong> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testStartOfParaBold()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaBold()
    {
        $this->selectText('XuT');

        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <strong>XuT</strong> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testMidOfParaBold()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaBold()
    {
        $this->selectText('dolor');

        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT <strong>dolor</strong></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->click($this->find('XuT'));

        $this->selectText('dolor');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');

    }//end testEndOfParaBold()


    /**
     * Test that bold is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemovingFormatFromPartOfTheContent()
    {
        $this->selectText('XuT', 'dolor');

        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <strong>XuT dolor</strong></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('dolor');

        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>Lorem <strong>XuT </strong>dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('XuT');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');

    }//end testRemovingFormatFromPartOfTheContent()


    /**
     * Test that the space remains between two words when you remove bold formating from one word and then the other word.
     *
     * @return void
     */
    public function testSpaceRemainsInContentAfterRemovingFormat()
    {
        $this->selectText('XuT', 'dolor');

        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <strong>XuT dolor</strong></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('dolor');
        $this->clickInlineToolbarButton('bold', 'active');

        $this->assertHTMLMatch('<p>Lorem <strong>XuT </strong>dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('XuT');
        $this->clickInlineToolbarButton('bold', 'active');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testSpaceRemainsInContentAfterRemovingFormat()


    /**
     * Test that the strong tags are added in the correct location when you apply, remove and re-apply bold formatting to two words in the content.
     *
     * @return void
     */
    public function testStrongTagsAppliedCorrectlyWhenReapplyingBold()
    {
        $this->selectText('XuT', 'dolor');

        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon does not exist in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Clas icon does not exist in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon does not exist in the inline toolbar');

        $this->assertHTMLMatch('<p>Lorem <strong>XuT dolor</strong></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('dolor');
        $this->clickInlineToolbarButton('bold', 'active');

        $this->assertHTMLMatch('<p>Lorem <strong>XuT </strong>dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('XuT');
        $this->clickInlineToolbarButton('bold', 'active');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->click($this->find('Lorem'));
        sleep(1);
        $this->selectText('XuT', 'dolor');
        $this->clickTopToolbarButton('bold');

        $this->assertHTMLMatch('<p>Lorem <strong>XuT dolor</strong></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

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
    public function testShortcutCommand()
    {
        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><strong>Lorem</strong> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testShortcutCommand()


    /**
     * Test that the Bold icon in the top toolbar works.
     *
     * @return void
     */
    public function testBoldIconInTopToolbar()
    {
        $text = 'Lorem';

        $this->selectText($text);
        $this->clickTopToolbarButton('bold');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><strong>Lorem</strong> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is still active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testBoldIconInTopToolbar()


    /**
     * Test that a paragraph can be made bold using the top toolbar and that the VITP bold icon will appear when that happen. Then remove the bold formatting and check that the VITP bold icon is removed.
     *
     * @return void
     */
    public function testAddingAndRemovingFormattingToAParagraph()
    {
        $start = $this->find('Lorem');
        $end   = $this->find('dolor');
        $this->dragDrop($this->getTopLeft($start), $this->getTopRight($end));

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon appears in the inline toolbar and is active');

        // Click the Top Toolbar icon to make whole paragraph bold.
        $this->clickTopToolbarButton('bold');

        $this->assertHTMLMatch('<p><strong>Lorem XuT dolor</strong></p><p>sit <em>amet</em> <strong>WoW</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon is not active in the top toolbar');

        // Inline Toolbar icon is now displayed
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Active bold icon does not appear in the inline toolbar');

        //Remove bold formating
        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('bold', 'active');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon is still active in the top toolbar');

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon still appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active bold icon still appear in the inline toolbar');

    }//end testAddAndRemoveBoldToAParagraph()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectText('XuT');
        $this->keyDown('Key.CMD + b');

        $this->selectText('Lorem', 'XuT');
        $this->keyDown('Key.CMD + b');

        $this->selectText('XuT', 'dolor');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p><strong>Lorem XuT dolor</strong></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectText('XuT');
        $this->keyDown('Key.CMD + b');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $this->selectText('dolor');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p><strong>Lorem</strong> <strong>XuT</strong> <strong>dolor</strong></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that bold can be removed.
     *
     * @return void
     */
    public function testRemoveFormating()
    {
        $this->selectText('WoW');

        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon is still active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon is still active in the top toolbar');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> WoW</p>');

    }//end testRemoveFormating()


    /**
     * Test that the Bold icons are active when you select a word that is bold.
     *
     * @return void
     */
    public function testIconsAreActive()
    {
        $this->selectText('WoW');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon is not active in the top toolbar');

    }//end testIconsAreActive()


    /**
     * Test that the VITP bold icon is removed from the toolbar when you click the P tag.
     *
     * @return void
     */
    public function testIconIsRemovedFromInlineToolbar()
    {
        $this->selectText('Lorem');

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

    }//end testIconIsRemovedFromInlineToolbar()


    /**
     * Test applying a bold to two words where one word is italics.
     *
     * @return void
     */
    public function testAddingBoldToTwoWordsWhereOneIsItalics()
    {
        $this->selectText('XuT');
        $this->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>Lorem <em>XuT</em> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('XuT', 'dolor');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>Lorem <strong><em>XuT</em> dolor</strong></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testAddingBoldToTwoWordsWhereOneIsItalics()


    /**
     * Test applying bold to two words where one is bold and one is italics.
     *
     * @return void
     */
    public function testAddingBoldToTwoWordsWhereOneIsBoldAndOneItalics()
    {
        $this->selectText('amet', 'WoW');
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <strong><em>amet</em> WoW</strong></p>');

    }//end testAddingBoldToTwoWordsWhereOneIsBoldAndOneItalics()


    /**
     * Test applying bold to two paragraphs where there is a HTML comment in the source code.
     *
     * @return void
     */
    public function testApplyingAndRemovingBoldToTwoParagraphsWhereHtmlCommentsInSource()
    {
        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p><strong>Lorem XuT dolor</strong><!-- hello world! --></p><p>sit amet WoW</p><p>Another p</p>');

        $this->click($this->find('XuT'));
        $this->click($this->find('XuT'));

        $this->selectText('WoW');
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p><strong>Lorem XuT dolor</strong><!-- hello world! --></p><p><strong>sit amet WoW</strong></p><p>Another p</p>');

        $this->selectText('Lorem', 'WoW');
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Lorem XuT dolor<!-- hello world! --></p><p>sit amet WoW</p><p>Another p</p>');

    }//end testApplyingAndRemovingBoldToTwoParagraphsWhereHtmlCommentsInSource()


    /**
     * Test applying and removing bold to two paragraphs.
     *
     * @return void
     */
    public function testApplyingAndRemovingBoldToTwoParagraphs()
    {
        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p><strong>Lorem XuT dolor</strong></p><p>sit amet WoW</p><p>Another p</p>');

        $this->click($this->find('XuT'));
        $this->click($this->find('XuT'));

        $this->selectText('WoW');
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p><strong>Lorem XuT dolor</strong></p><p><strong>sit amet WoW</strong></p><p>Another p</p>');

        $this->selectText('Lorem', 'WoW');
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet WoW</p><p>Another p</p>');

    }//end testApplyingAndRemovingBoldToTwoParagraphs()


    /**
     * Test applying and removing bold to all content. Also checks that class and anchor does not become active when it applies the bold
     *
     * @return void
     */
    public function testApplyingAndRemovingBoldToAllContent()
    {
        $this->click($this->find('XuT'));
        $this->keyDown('Key.CMD + a');
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p><strong>Lorem XuT dolor</strong></p><p><strong>sit <em>amet</em> WoW</strong></p>');

        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon should be active');
        $this->assertFalse($this->topToolbarButtonExists('class', 'active'), 'Class icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('anchor', 'active'), 'Anchor icon should not be active');

        $this->click($this->find('XuT'));
        $this->keyDown('Key.CMD + a');
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> WoW</p>');

        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should not be active');
        $this->assertFalse($this->topToolbarButtonExists('class', 'active'), 'Class icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('anchor', 'active'), 'Anchor icon should not be active');

    }//end testApplyingAndRemovingBoldToAllContent()


}//end class

?>
