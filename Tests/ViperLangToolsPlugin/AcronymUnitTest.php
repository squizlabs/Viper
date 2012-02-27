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

        $text = 'LOREM';
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

        $text = 'LOREM';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym.png');
        $this->clickTopToolbarButton($dir.'input_acronym.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><acronym title="abc">LOREM</acronym> xtn dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <acronym title="abc">LABS</acronym> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

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

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_active.png'), 'Class icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM xtn dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz LABS is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language.png'), 'Language icon is still active in the Top Toolbar.');

    }//end testRemovingAcronymAttributeFromAWord()


    /**
     * Test that you can apply an acronym to a word that is bold.
     *
     * @return void
     */
    public function testAddingLanguageToABoldWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'WoW';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym.png');
        $this->clickTopToolbarButton($dir.'input_acronym.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM xtn dolor</p><p>sit amet <acronym title="abc"><strong>WoW</strong></acronym></p><p>Squiz <acronym title="abc">LABS</acronym> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

    }//end testAddingLanguageToABoldWord()


    /**
     * Test that you can apply an acronym to a word that is italic.
     *
     * @return void
     */
    public function testAddingLanguageToAItalicWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'QUICK';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym.png');
        $this->clickTopToolbarButton($dir.'input_acronym.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM xtn dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <acronym title="abc">LABS</acronym> is orsm</p><p>The <acronym title="abc"><em>QUICK</em></acronym> brown fox</p>');

    }//end testAddingLanguageToAItalicWord()


}//end class

?>
