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

        $text    = 'XuT';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM <span lang="en">XuT</span> dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_highlighted.png'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_active.png'), 'Language icon in Top Toolbar should be active.');

        $text = 'dolor';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');

        //$this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_updateChanges_disabled.png'), 'Update Changes button should be disabled.');

        $this->type('def');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>LOREM <span lang="en">XuT</span> <span lang="def">dolor</span></p><p>sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p>The <em>QUICK</em> brown fox</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_highlighted.png'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_language_active.png'), 'Language icon in Top Toolbar should be active.');

    }//end testAddingLanguageToAWord()


    /**
     * Test that you can add the language to a paragraph.
     *
     * @return void
     */
    public function testAddingLanguageToAParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p lang="en">LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_highlighted.png'), 'Language icon in Top Toolbar should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language_active.png'), 'Language icon in Top Toolbar should be active.');

        $text = 'PARA';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('en');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p lang="en">LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p lang="en">Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

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

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language.png'), 'Language icon is still active in the Top Toolbar.');

        // Reapply the language so that we can delete it with the Update Changes button
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

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

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz LABS is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_language.png'), 'Language icon is still active in the Top Toolbar.');

        // Reapply the language so that we can delete it with the Update Changes button
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz LABS is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

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
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p lang="en"><strong>jumps</strong> OVER the lazy dog</p>');

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
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Test PARA</p><p>Squiz <span lang="en">LABS</span> is orsm</p><p lang="en"><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

    }//end testAddingLanguageToAParagraphWithItalicFirstWord()


    /**
     * Test that language textbox is focused when opened.
     *
     * @return void
     */
    public function testAutoFocusLanguageTextbox()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LOREM';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span lang="en">LOREM</span> xtn dolor</p><p lang="en">sit amet <strong>WoW</strong></p><p>Squiz <span lang="en">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

    }//end testAutoFocusLanguageTextbox()


}//end class

?>
