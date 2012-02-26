<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperInlineToolbarPlugin_InlineToolbarLangToolUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that VITP changes when a language is added to the selected text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenLanguageIsAppliedAndRemoved()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'IPSUM';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">SPAN</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenLanguageIsAppliedAndRemoved()


    /**
     * Test that VITP changes when a language is added and removed to a word at the start of the paragraph.
     *
     * @return void
     */
    public function testLineageChangesWhenLanguageIsAppliedAndRemovedToFirstWordInParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LABS';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">SPAN</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenLanguageIsAppliedAndRemovedToFirstWordInParagraph()


    /**
     * Test that VITP doesn't change when a language is added to the selected paragraph.
     *
     * @return void
     */
    public function testLineageDoesNotChangeWhenLanguageIsAppliedToAParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'IPSUM';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

    }//end testLineageDoesNotChangeWhenLanguageIsAppliedToAParagraph()


    /**
     * Test that when you select the SPAN tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheSpanTagInTheLineage()
    {
        $this->selectText('WoW');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">SPAN</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals('SUB WoW', $this->getSelectedText(), 'Span tag is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">SPAN</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectText('SUB');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('SUB WoW', $this->getSelectedText(), 'Span tag is not selected.');

    }//end testSelectingTheSpanTagInTheLineage()


    /**
     * Test that VITP changes when a language is added to bold text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenLanguageIsAppliedAndRemovedToBoldText()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'DOLOR';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem selected">SPAN</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenLanguageIsAppliedAndRemovedToBoldText()


    /**
     * Test that VITP changes when a language is added to italic text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenLanguageIsAppliedAndRemovedToItalicText()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LOREM';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->clickTopToolbarButton($dir.'input_language.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Italic</li><li class="ViperITP-lineageItem selected">SPAN</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Italic</li<li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenLanguageIsAppliedAndRemovedToItalicText()


}//end class

?>
