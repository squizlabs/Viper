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

        $text = 'AuuA';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
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
     * Test that VITP changes when an acronym is added to the selected text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenAcronymIsAppliedAndRemovedA()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'AuuA';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">ACRONYM</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenAcronymIsAppliedAndRemoved()


    /**
     * Test that VITP changes when an abbreviation is added to the selected text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenAbbreviationIsAppliedAndRemoved()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'AuuA';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">ABBR</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenAbbreviationIsAppliedAndRemoved()


    /**
     * Test that VITP changes when a language is added and removed to a word at the start of the paragraph.
     *
     * @return void
     */
    public function testLineageChangesWhenLanguageIsAppliedAndRemovedToFirstWordInParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LaBs';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
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
     * Test that VITP changes when abbreviation is added and removed to a word at the start of the paragraph.
     *
     * @return void
     */
    public function testLineageChangesWhenAbbreviationIsAppliedAndRemovedToFirstWordInParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LaBs';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">ABBR</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenAbbreviationIsAppliedAndRemovedToFirstWordInParagraph()


    /**
     * Test that VITP changes when acronym is added and removed to a word at the start of the paragraph.
     *
     * @return void
     */
    public function testLineageChangesWhenAcronymIsAppliedAndRemovedToFirstWordInParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LaBs';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">ACRONYM</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenAcronymIsAppliedAndRemovedToFirstWordInParagraph()


    /**
     * Test that VITP doesn't change when a language is added to the selected paragraph.
     *
     * @return void
     */
    public function testLineageDoesNotChangeWhenLanguageIsAppliedToAParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'AuuA';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
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

        $this->assertEquals('SubS WoW', $this->getSelectedText(), 'Span tag is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">SPAN</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectText('SubS');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('SubS WoW', $this->getSelectedText(), 'Span tag is not selected.');

    }//end testSelectingTheSpanTagInTheLineage()


    /**
     * Test that when you select the ABBREVIATION tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheAbbreviationTagInTheLineage()
    {
        $this->selectText('QUICK');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">ABBR</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals('QUICK BROWN', $this->getSelectedText(), 'Abbreviation tag is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">ABBR</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectText('BROWN');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('QUICK BROWN', $this->getSelectedText(), 'Abbreviation tag is not selected.');

    }//end testSelectingTheSpanTagInTheLineage()


    /**
     * Test that when you select the ACRONYM tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheAcronymTagInTheLineage()
    {
        $this->selectText('XXX');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">ACRONYM</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals('XXX JuMps', $this->getSelectedText(), 'Acronym tag is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">ACRONYM</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectText('JuMps');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('XXX JuMps', $this->getSelectedText(), 'Acronym tag is not selected.');

    }//end testSelectingTheAcronymTagInTheLineage()


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
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

    }//end testLineageChangesWhenLanguageIsAppliedAndRemovedToBoldText()


    /**
     * Test that VITP changes when an acronym is added to bold text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenAcronymIsAppliedAndRemovedToBoldText()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'DOLOR';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">ACRONYM</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

    }//end testLineageChangesWhenAcronymIsAppliedAndRemovedToBoldText()


    /**
     * Test that VITP changes when an abbreviation is added to bold text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenAbbreviationIsAppliedAndRemovedToBoldText()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'DOLOR';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">ABBR</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

    }//end testLineageChangesWhenAbbreviationIsAppliedAndRemovedToBoldText()


    /**
     * Test that VITP doesn't changes when a language is added to italic text and is then removed.
     *
     * @return void
     */
    public function testLineageDoesNotChangeWhenLanguageIsAppliedAndRemovedToItalicText()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LoreM';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

    }//end testLineageDoesNotChangeWhenLanguageIsAppliedAndRemovedToItalicText()


    /**
     * Test that VITP changes when an acronym is added to italic text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenAcronymIsAppliedAndRemovedToItalicText()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LoreM';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">ACRONYM</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_acronym_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

    }//end testLineageChangesWhenAcronymIsAppliedAndRemovedToItalicText()


    /**
     * Test that VITP changes when an abbreviation is added to italic text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenAbbreviationIsAppliedAndRemovedToItalicText()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LoreM';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation.png');
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">ABBR</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_language_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_abbreviation_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_deleteValue_icon.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

    }//end testLineageChangesWhenAbbreviationIsAppliedAndRemovedToItalicText()


}//end class

?>
