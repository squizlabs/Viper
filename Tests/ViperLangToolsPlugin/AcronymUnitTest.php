<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLangToolsPlugin_AcronymUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that the acronym icon is not active when you don't select some text and when you select a block of text.
     *
     * @return void
     */
    public function testAcronymIconIsDisabled()
    {
        $dir = dirname(__FILE__).'/Images/';

        //$this->assertFalse($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language.png'), 'Language icon in Top Toolbar should not be active.');

        $text = 'XuT';
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_acronym.png'), 'Acronym icon in Top Toolbar should be active.');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language.png'), 'Language icon in Top Toolbar should not be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_acronym_disabled.png'), 'Acronym icon in Top Toolbar should not be active.');

    }//end testAcronymIconIsDisabled()


    /**
     * Test that you can apply the acronym attribute to a word.
     *
     * @return void
     */
    public function testAddingAcronymToAWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym.png');
        $this->clickTopToolbarButton($dir.'input_acronym.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM <acronym title="abc">XuT</acronym> dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <acronym title="abc">LABS</acronym> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_highlighted.png'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_acronym_active.png'), 'Acronym icon in Top Toolbar should be active.');

        $text = 'dolor';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym.png');
        $this->clickTopToolbarButton($dir.'input_acronym.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_updateChanges_disabled.png'), 'Update Changes button should be disabled.');

        $this->clickTopToolbarButton($dir.'input_acronym.png');
        $this->type('def');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>LOREM <acronym title="abc">XuT</acronym> <acronym title="def">dolor</acronym></p><p>sit amet <strong>WoW</strong></p><p>Squiz <acronym title="abc">LABS</acronym> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_highlighted.png'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_acronym_active.png'), 'Acronym icon in Top Toolbar should be active.');

    }//end testAddingAcronymToAWord()


    /**
     * Test that you can remove a acronym from a word.
     *
     * @return void
     */
    public function testRemovingAcronymAttributeFromAWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LABS';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_active.png'), 'Class icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language.png'), 'Language icon is still active in the Top Toolbar.');

        // Reapply the abbreviation so we can delete it by using the update changes icon
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym.png');
        $this->clickTopToolbarButton($dir.'input_acronym.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <acronym title="abc">LABS</acronym> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is orsm</p><p>The <em>QUICK</em> brown fox</p>');

    }//end testRemovingAcronymAttributeFromAWord()


    /**
     * Test that you can edit an acronym that has been applied to a word.
     *
     * @return void
     */
    public function testEditingAcronym()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text    = 'LABS';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_active.png'), 'Class icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym_active.png');
        $this->clickTopToolbarButton($dir.'input_acronym.png');
        $this->type('def');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <acronym title="abcdef">LABS</acronym> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym_active.png');
        $this->clickTopToolbarButton($dir.'input_acronym.png');
        $this->type('ghi');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <acronym title="abcdefghi">LABS</acronym> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

    }//end testEditingAcronym()


    /**
     * Test that you can apply an acronym to a word that is bold.
     *
     * @return void
     */
    public function testAddingAcronymToABoldWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'WoW';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym.png');
        $this->clickTopToolbarButton($dir.'input_acronym.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <acronym title="abc"><strong>WoW</strong></acronym></p><p>Squiz <acronym title="abc">LABS</acronym> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

    }//end testAddingAcronymToABoldWord()


    /**
     * Test that you can apply an acronym to a word that is italic.
     *
     * @return void
     */
    public function testAddingAcronymToAItalicWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'QUICK';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym.png');
        $this->clickTopToolbarButton($dir.'input_acronym.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <acronym title="abc">LABS</acronym> is orsm</p><p>The <acronym title="abc"><em>QUICK</em></acronym> brown fox</p>');

    }//end testAddingAcronymToAItalicWord()


}//end class

?>
