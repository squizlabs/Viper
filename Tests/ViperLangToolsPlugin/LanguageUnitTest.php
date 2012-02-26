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
        $dir = dirname(__FILE__).'/Images/';

        $this->assertFalse($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language.png'), 'Language icon in Top Toolbar should not be active.');
        $this->assertFalse($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_active.png'), 'Language icon in Top Toolbar should not be active.');
        $this->assertFalse($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_highlighted.png'), 'Language icon in Top Toolbar should not be active.');

    }//end testLanguageIconIsDisabled()


    /**
     * Test that you can apply the language attribute to a word.
     *
     * @return void
     */
    public function testAddingLanguageToAWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LOREM';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span lang="en">LOREM</span> xtn dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_highlighted.png'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_active.png'), 'Language icon in Top Toolbar should be active.');

    }//end testAddingLanguageToAWord()


    /**
     * Test that you can add the language to a paragraph.
     *
     * @return void
     */
    public function testAddingLanguageToAParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LOREM';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p lang="en">LOREM xtn dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_highlighted.png'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_active.png'), 'Language icon in Top Toolbar should be active.');

    }//end testAddingLanguageToAParagraph()


    /**
     * Test that you can remove a language from a paragraph.
     *
     * @return void
     */
    public function testRemovingLanguageAttributeFromAParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'WoW';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_highlighted.png'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM xtn dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language.png'), 'Language icon is still active in the Top Toolbar.');

    }//end testRemovingLanguageAttributeFromAParagraph()


    /**
     * Test that you can remove a language from a word.
     *
     * @return void
     */
    public function testRemovingLanguageAttributeFromAWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LABS';

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_active.png'), 'Class icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM xtn dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Squiz LABS is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->click($this->find($text));
        $this->selectText($text);
         $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language.png'), 'Language icon is still active in the Top Toolbar.');

    }//end testRemovingLanguageAttributeFromAWord()


    /**
     * Test that you can apply a language to a pargraph where the first word is bold.
     *
     * @return void
     */
    public function testAddingLanguageToAParagraphWithBoldFirstWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'OVER';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p lang="en"><strong>jumps</strong> OVER the lazy dog</p>');

    }//end testAddingLanguageToAParagraphWithBoldFirstWord()


    /**
     * Test that you can apply a language to a pargraph where the first word is italic.
     *
     * @return void
     */
    public function testAddingLanguageToAParagraphWithItalicFirstWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'QUICK';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Squiz <span lang="en">LABS</span> is orsm</p><p lang="en"><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

    }//end testAddingLanguageToAParagraphWithItalicFirstWord()


}//end class

?>
