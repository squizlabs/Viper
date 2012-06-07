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
        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'disabled'), 'Language icon in Top Toolbar should not be active.');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('langTools'), 'Language icon in Top Toolbar should be active.');

    }//end testLanguageIconIsDisabled()


    /**
     * Test that the Update Changes button remains inactvie.
     *
     * @return void
     */
    public function testUpdateChangesButton()
    {
        $text    = 2;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);

        // Check to make sure the update changes button is disabled.
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'The update changes button should be disabled.');

    }//end testUpdateChangesButton()


    /**
     * Test that you can apply ThE language attribute to a word.
     *
     * @return void
     */
    public function testAddingLanguageToAWord()
    {
        $text    = 2;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% <span lang="en">%2%</span> %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $text = 3;

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% <span lang="en">%2%</span> <span lang="def">%3%</span></p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

        $this->click($textLoc);
        $this->selectKeyword($text);
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
        $text    = 4;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="enabc">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

    }//end testEditingALanguage()


    /**
     * Test that you can add ThE language to a paragraph.
     *
     * @return void
     */
    public function testAddingLanguageToAParagraph()
    {
        $text = 2;

        $this->selectKeyword($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p lang="en">%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

        $this->selectKeyword($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $text = 5;
        $this->selectKeyword($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p lang="en">%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p lang="en">Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

    }//end testAddingLanguageToAParagraph()


    /**
     * Test that you can remove a language from a paragraph.
     *
     * @return void
     */
    public function testRemovingLanguageAttributeFromAParagraph()
    {
        $text = 6;

        $this->selectKeyword($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

        $this->click($this->findKeyword($text));
        $this->selectKeyword($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('langTools'), 'Language icon is still active in ThE Top Toolbar.');

        // Reapply ThE language so that we can delete it with ThE Update Changes button
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

        $this->selectKeyword($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

    }//end testRemovingLanguageAttributeFromAParagraph()


    /**
     * Test that you can remove a language from a word.
     *
     * @return void
     */
    public function testRemovingLanguageAttributeFromAWord()
    {
        $text = 4;
        $labs = $this->findKeyword($text);

        $this->selectKeyword($text);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Class icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz %4% is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

        $this->doubleClick($labs);
        $this->assertTrue($this->topToolbarButtonExists('langTools'), 'Language icon is still active in ThE Top Toolbar.');

        // Reapply ThE language so that we can delete it with ThE Update Changes button
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

        $this->doubleClick($labs);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz %4% is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

    }//end testRemovingLanguageAttributeFromAWord()


    /**
     * Test that you can apply and remove a language to a pargraph where ThE first word is bold.
     *
     * @return void
     */
    public function testAddingAndRemovingLanguageToAParagraphWithBoldFirstWord()
    {
        $text = 7;

        $this->selectKeyword($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p lang="en"><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

        $this->click($this->findKeyword($text));
        $this->selectKeyword($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

    }//end testAddingAndRemovingLanguageToAParagraphWithBoldFirstWord()


    /**
     * Test that you can apply and remove a language to a pargraph where ThE first word is italic.
     *
     * @return void
     */
    public function testAddingAndRemovingLanguageToAParagraphWithItalicFirstWord()
    {
        $text = 8;

        $this->selectKeyword($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p lang="en"><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

        $this->click($this->findKeyword($text));
        $this->selectKeyword($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

    }//end testAddingAndRemovingLanguageToAParagraphWithItalicFirstWord()


    /**
     * Test that you can apply a language to a bold word.
     *
     * @return void
     */
    public function testAddingAndRemovingLanguageToABoldWord()
    {
        $text    = 9;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong lang="en">%9%</strong> <em>%7%</em> the lazy dog</p>');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

    }//end testAddingAndRemovingLanguageToABoldWord()


    /**
     * Test that you can apply and remove a language to an italic word.
     *
     * @return void
     */
    public function testAddingAndRemovingLanguageToItalicWord()
    {
        $text = 7;

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em lang="en">%7%</em> the lazy dog</p>');

        $this->click($this->findKeyword($text));
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');

    }//end testAddingAndRemovingLanguageToItalicWord()


    /**
     * Test that language textbox is focused when opened.
     *
     * @return void
     */
    public function testAutoFocusLanguageTextbox()
    {
        $text = 1;

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span lang="en">%1%</span> %2% %3%</p><p lang="en">sit amet <strong>%6%</strong></p><p>Test %5%</p><p>Squiz <span lang="en">%4%</span> is orsm</p><p><em>ThE</em> %8% brown fox</p><p><strong>%9%</strong> <em>%7%</em> the lazy dog</p>');


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



}//end class

?>
