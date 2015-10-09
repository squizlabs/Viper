<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLangToolsPlugin_LanguageUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that the language icon is not active when you don't select some text.
     *
     * @return void
     */
    public function testLanguageIconIsDisabled()
    {
        $this->clickKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'disabled'), 'Language icon in Top Toolbar should not be active.');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('langTools'), 'Language icon in Top Toolbar should be active.');

    }//end testLanguageIconIsDisabled()


    /**
     * Test that the Apply Changes button remains inactvie.
     *
     * @return void
     */
    public function testUpdateChangesButton()
    {

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);

        // Check to make sure the update changes button is disabled.
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE), 'The update changes button should be disabled.');

    }//end testUpdateChangesButton()


    /**
     * Test that you can apply ThE language attribute to a word.
     *
     * @return void
     */
    public function testAddingLanguageToAWord()
    {

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% <span lang="en">%2%</span> %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        $this->clickKeyword(2);
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% <span lang="en">%2%</span> <span lang="def">%3%</span></p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        $this->clickKeyword(3);
        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language icon in Top Toolbar should be active.');

    }//end testAddingLanguageToAWord()


    /**
     * Test that you can edit a language.
     *
     * @return void
     */
    public function testEditingALanguage()
    {

        $this->selectKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="enabc">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

    }//end testEditingALanguage()


    /**
     * Test that you can add ThE language to a paragraph.
     *
     * @return void
     */
    public function testAddingLanguageToAParagraph()
    {

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p lang="en">%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language icon in Top Toolbar should be active.');

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p lang="en">%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p lang="en">Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

    }//end testAddingLanguageToAParagraph()


    /**
     * Test that you can remove a language from a paragraph.
     *
     * @return void
     */
    public function testRemovingLanguageAttributeFromAParagraph()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        $this->clickKeyword(4);
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('langTools'), 'Language icon is still active in ThE Top Toolbar.');

        // Reapply ThE language so that we can delete it with ThE Apply Changes button
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

    }//end testRemovingLanguageAttributeFromAParagraph()


    /**
     * Test that you can remove a language from a word.
     *
     * @return void
     */
    public function testRemovingLanguageAttributeFromAWord()
    {

        $this->selectKeyword(6);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Class icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz %6% is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        $this->selectKeyword(6);
        $this->assertTrue($this->topToolbarButtonExists('langTools'), 'Language icon is still active in ThE Top Toolbar.');

        // Reapply ThE language so that we can delete it with ThE Apply Changes button
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        $this->selectKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz %6% is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

    }//end testRemovingLanguageAttributeFromAWord()


    /**
     * Test that you can apply and remove a language to a pargraph where ThE first word is bold.
     *
     * @return void
     */
    public function testAddingAndRemovingLanguageToAParagraphWithBoldFirstWord()
    {

        $this->selectKeyword(8);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p lang="en"><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        $this->clickKeyword(8);
        $this->selectKeyword(8);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

    }//end testAddingAndRemovingLanguageToAParagraphWithBoldFirstWord()


    /**
     * Test that you can apply and remove a language to a pargraph where ThE first word is italic.
     *
     * @return void
     */
    public function testAddingAndRemovingLanguageToAParagraphWithItalicFirstWord()
    {

        $this->selectKeyword(7);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p lang="en"><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        $this->clickKeyword(7);
        $this->selectKeyword(7);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

    }//end testAddingAndRemovingLanguageToAParagraphWithItalicFirstWord()


    /**
     * Test that you can apply a language to a bold word.
     *
     * @return void
     */
    public function testAddingAndRemovingLanguageToABoldWord()
    {

        $this->selectKeyword(8);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong lang="en">%8%</strong> <em>%9%</em> the lazy dog</p>');

        $this->clickKeyword(8);
        $this->selectKeyword(8);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

    }//end testAddingAndRemovingLanguageToABoldWord()


    /**
     * Test that you can apply and remove a language to an italic word.
     *
     * @return void
     */
    public function testAddingAndRemovingLanguageToItalicWord()
    {

        $this->selectKeyword(9);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em lang="en">%9%</em> the lazy dog</p>');

        $this->clickKeyword(9);
        $this->selectKeyword(9);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

    }//end testAddingAndRemovingLanguageToItalicWord()


    /**
     * Test that language textbox is focused when opened.
     *
     * @return void
     */
    public function testAutoFocusLanguageTextbox()
    {

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span lang="en">%1%</span> %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');


    }//end testAutoFocusLanguageTextbox()


    /**
     * Test that selection is maintained when switching between language and class.
     *
     * @return void
     */
    public function testSelectionIsMaintainedWhenSwitchingFromLanguageToClass()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->assertEquals('%1% %2% %3%', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals('%1% %2% %3%', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton('langTools');
        $this->assertEquals('%1% %2% %3%', $this->getSelectedText(), 'Selected text is not highlighted.');

    }//end testSelectionIsMaintainedWhenSwitchingFromLanguageToClass()


    /**
     * Test undo and redo for language.
     *
     * @return void
     */
    public function testUndoAndRedoForLanguage()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% <span lang="en">%2%</span> %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <span lang="en">%2%</span> %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

    }//end testUndoAndRedoForLanguage()


    /**
     * Test applying language, deleting it and then clicking undo.
     *
     * @return void
     */
    public function testUndoAfterDeletingLanguage()
    {
        // Apply language
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>%1% <span lang="en">%2%</span> %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        // Delete language
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('langTools', 'selected');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        // Press undo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% <span lang="en">%2%</span> %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%4%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%6%</span> is orsm</p><p><em>ThE</em> %7% brown fox</p><p><strong>%8%</strong> <em>%9%</em> the lazy dog</p>');

    }//end testUndoAfterDeletingLanguage()


}//end class

?>
