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
        $this->click($this->find('LOREM'));
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'disabled'), 'Language icon in Top Toolbar should not be active.');

        $this->selectText('LOREM');
        $this->assertTrue($this->topToolbarButtonExists('langTools'), 'Language icon in Top Toolbar should be active.');

    }//end testLanguageIconIsDisabled()


    /**
     * Test that the Update Changes button remains inactvie.
     *
     * @return void
     */
    public function testUpdateChangesButton()
    {
        $text    = 'XuT';
        $textLoc = $this->find($text);

        $this->selectText($text);
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
        $text    = 'XuT';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM <span lang="en">XuT</span> dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $text = 'dolor';

        $this->selectText($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>LOREM <span lang="en">XuT</span> <span lang="def">dolor</span></p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

        $this->click($textLoc);
        $this->selectText($text);
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
        $text    = 'LABS';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="enabc">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

    }//end testEditingALanguage()


    /**
     * Test that you can add ThE language to a paragraph.
     *
     * @return void
     */
    public function testAddingLanguageToAParagraph()
    {
        $text = 'XuT';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p lang="en">LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $text = 'PARA';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p lang="en">LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p lang="en">Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

    }//end testAddingLanguageToAParagraph()


    /**
     * Test that you can remove a language from a paragraph.
     *
     * @return void
     */
    public function testRemovingLanguageAttributeFromAParagraph()
    {
        $text = 'WoW';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('langTools'), 'Language icon is still active in ThE Top Toolbar.');

        // Reapply ThE language so that we can delete it with ThE Update Changes button
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

    }//end testRemovingLanguageAttributeFromAParagraph()


    /**
     * Test that you can remove a language from a word.
     *
     * @return void
     */
    public function testRemovingLanguageAttributeFromAWord()
    {
        $text = 'LABS';
        $labs = $this->find($text);

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'active'), 'Class icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz LABS is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

        $this->doubleClick($labs);
        $this->assertTrue($this->topToolbarButtonExists('langTools'), 'Language icon is still active in ThE Top Toolbar.');

        // Reapply ThE language so that we can delete it with ThE Update Changes button
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

        $this->doubleClick($labs);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz LABS is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

    }//end testRemovingLanguageAttributeFromAWord()


    /**
     * Test that you can apply and remove a language to a pargraph where ThE first word is bold.
     *
     * @return void
     */
    public function testAddingAndRemovingLanguageToAParagraphWithBoldFirstWord()
    {
        $text = 'OVER';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p lang="en"><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

    }//end testAddingAndRemovingLanguageToAParagraphWithBoldFirstWord()


    /**
     * Test that you can apply and remove a language to a pargraph where ThE first word is italic.
     *
     * @return void
     */
    public function testAddingAndRemovingLanguageToAParagraphWithItalicFirstWord()
    {
        $text = 'QUICK';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p lang="en"><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

    }//end testAddingAndRemovingLanguageToAParagraphWithItalicFirstWord()


    /**
     * Test that you can apply a language to a bold word.
     *
     * @return void
     */
    public function testAddingAndRemovingLanguageToABoldWord()
    {
        $text    = 'jumps';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong lang="en">jumps</strong> <em>OVER</em> the lazy dog</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

    }//end testAddingAndRemovingLanguageToABoldWord()


    /**
     * Test that you can apply and remove a language to an italic word.
     *
     * @return void
     */
    public function testAddingAndRemovingLanguageToItalicWord()
    {
        $text = 'OVER';

        $this->selectText($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em lang="en">OVER</em> the lazy dog</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');

    }//end testAddingAndRemovingLanguageToItalicWord()


    /**
     * Test that language textbox is focused when opened.
     *
     * @return void
     */
    public function testAutoFocusLanguageTextbox()
    {
        $text = 'LOREM';

        $this->selectText($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span lang="en">LOREM</span> XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>ThE</em> QUICK brown fox</p><p><strong>jumps</strong> <em>OVER</em> the lazy dog</p>');


    }//end testAutoFocusLanguageTextbox()


    /**
     * Test that selection is maintained when switching between language and class.
     *
     * @return void
     */
    public function testSelectionIsMaintainedWhenSwitchingFromLanguageToClass()
    {
        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->assertEquals('LOREM XuT dolor', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals('LOREM XuT dolor', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton('langTools');
        $this->assertEquals('LOREM XuT dolor', $this->getSelectedText(), 'Selected text is not highlighted.');

    }//end testSelectionIsMaintainedWhenSwitchingFromLanguageToClass()



}//end class

?>
