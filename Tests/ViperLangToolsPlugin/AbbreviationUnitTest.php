<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLangToolsPlugin_AbbreviationUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that the abbreviation icon is not active when you don't select some text and when you select a block of text.
     *
     * @return void
     */
    public function testAbbreviationIconIsDisabled()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LOREM';
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_abbreviation.png'), 'Abbreviation icon in Top Toolbar should be active.');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language.png'), 'Language icon in Top Toolbar should not be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_abbreviation_disabled.png'), 'Abbreviation icon in Top Toolbar should not be active.');

    }//end testAbbreviationIconIsDisabled()


    /**
     * Test that the Update Changes button remains inactvie.
     *
     * @return void
     */
    public function testUpdateChangesButton()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text    = 'XuT';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_updateChanges_disabled.png'), 'Update Changes button should be disabled.');

    }//end testUpdateChangesButton()


    /**
     * Test that you can apply the abbreviation attribute to a word.
     *
     * @return void
     */
    public function testAddingAbbreviationToAWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM <abbr title="abc">XuT</abbr> dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <abbr title="abc">LABS</abbr> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_highlighted.png'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_abbreviation_active.png'), 'Abbreviation icon in Top Toolbar should be active.');

        $text = 'dolor';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation.png');
        $this->type('def');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>LOREM <abbr title="abc">XuT</abbr> <abbr title="def">dolor</abbr></p><p>sit amet <strong>WoW</strong></p><p>Squiz <abbr title="abc">LABS</abbr> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_highlighted.png'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_abbreviation_active.png'), 'Abbreviation icon in Top Toolbar should be active.');

    }//end testAddingAbbreviationToAWord()


    /**
     * Test that you can remove an abbreviation from a word.
     *
     * @return void
     */
    public function testRemovingAbbreviationAttributeFromAWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text    = 'LABS';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_active.png'), 'Class icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language.png'), 'Language icon is still active in the Top Toolbar.');

        // Reapply the abbreviation so we can delete it by using the update changes icon
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <abbr title="abc">LABS</abbr> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is orsm</p><p>The <em>QUICK</em> brown fox</p>');

    }//end testRemovingAbbreviationAttributeFromAWord()


    /**
     * Test that you can edit an abbreviation that has been applied to a word.
     *
     * @return void
     */
    public function testEditingAbbreviation()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text    = 'LABS';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_active.png'), 'Class icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation_active.png');
        $this->type('def');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <abbr title="abcdef">LABS</abbr> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation_active.png');
        $this->type('ghi');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <abbr title="abcdefghi">LABS</abbr> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

    }//end testEditingAbbreviation()


    /**
     * Test that you can apply an abbreviation to a word that is bold.
     *
     * @return void
     */
    public function testAddingAbbreviationToABoldWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'WoW';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <abbr title="abc"><strong>WoW</strong></abbr></p><p>Squiz <abbr title="abc">LABS</abbr> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

    }//end testAddingAbbreviationToABoldWord()


    /**
     * Test that you can apply an abbreviation to a word that is italic.
     *
     * @return void
     */
    public function testAddingAbbreviationToAItalicWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'QUICK';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <abbr title="abc">LABS</abbr> is orsm</p><p>The <abbr title="abc"><em>QUICK</em></abbr> brown fox</p>');

    }//end testAddingAbbreviationToAItalicWord()


    /**
     * Test that selection is maintained when switching between abbreviation and class.
     *
     * @return void
     */
    public function testSelectionIsMaintainedWhenSwitchingFromAbbreviationToClass()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation.png');
        $this->assertEquals('XuT', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class.png');
        $this->assertEquals('XuT', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->assertEquals('XuT', $this->getSelectedText(), 'Selected text is not highlighted.');

    }//end testSelectionIsMaintainedWhenSwitchingFromAbbreviationToClass()


}//end class

?>
