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
        $text = 1;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenLanguageIsAppliedAndRemoved()


    /**
     * Test that VITP changes when an acronym is added to the selected text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenAcronymIsAppliedAndRemovedA()
    {
        $text = 1;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">ACRONYM</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->clearFieldValue('Acronym');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenAcronymIsAppliedAndRemoved()


    /**
     * Test that VITP changes when an abbreviation is added to the selected text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenAbbreviationIsAppliedAndRemoved()
    {
        $text = 1;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">ABBR</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenAbbreviationIsAppliedAndRemoved()


    /**
     * Test that VITP changes when a language is added and removed to a word at the start of the paragraph.
     *
     * @return void
     */
    public function testLineageChangesWhenLanguageIsAppliedAndRemovedToFirstWordInParagraph()
    {
        $text = 2;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenLanguageIsAppliedAndRemovedToFirstWordInParagraph()


    /**
     * Test that VITP changes when abbreviation is added and removed to a word at the start of the paragraph.
     *
     * @return void
     */
    public function testLineageChangesWhenAbbreviationIsAppliedAndRemovedToFirstWordInParagraph()
    {
        $text = 2;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">ABBR</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenAbbreviationIsAppliedAndRemovedToFirstWordInParagraph()


    /**
     * Test that VITP changes when acronym is added and removed to a word at the start of the paragraph.
     *
     * @return void
     */
    public function testLineageChangesWhenAcronymIsAppliedAndRemovedToFirstWordInParagraph()
    {
        $text = 2;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">ACRONYM</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->clearFieldValue('Acronym');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenAcronymIsAppliedAndRemovedToFirstWordInParagraph()


    /**
     * Test that VITP doesn't change when a language is added to the selected paragraph.
     *
     * @return void
     */
    public function testLineageDoesNotChangeWhenLanguageIsAppliedToAParagraph()
    {
        $text = 1;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

    }//end testLineageDoesNotChangeWhenLanguageIsAppliedToAParagraph()


    /**
     * Test that when you select the SPAN tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheSpanTagInTheLineage()
    {
        $this->selectKeyword(7);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">SPAN</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals($this->replaceKeywords('%10% %7%'), $this->getSelectedText(), 'Span tag is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectKeyword(10);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%10% %7%'), $this->getSelectedText(), 'Span tag is not selected.');

    }//end testSelectingTheSpanTagInTheLineage()


    /**
     * Test that when you select the ABBREVIATION tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheAbbreviationTagInTheLineage()
    {
        $this->selectKeyword(5);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">ABBR</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals($this->replaceKeywords('%5% %8%'), $this->getSelectedText(), 'Abbreviation tag is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">ABBR</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectKeyword(8);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%5% %8%'), $this->getSelectedText(), 'Abbreviation tag is not selected.');

    }//end testSelectingTheSpanTagInTheLineage()


    /**
     * Test that when you select the ACRONYM tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheAcronymTagInTheLineage()
    {
        $this->selectKeyword(6);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">ACRONYM</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals($this->replaceKeywords('%6% %9%'), $this->getSelectedText(), 'Acronym tag is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">ACRONYM</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectKeyword(9);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%6% %9%'), $this->getSelectedText(), 'Acronym tag is not selected.');

    }//end testSelectingTheAcronymTagInTheLineage()


    /**
     * Test that VITP changes when a language is added to bold text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenLanguageIsAppliedAndRemovedToBoldText()
    {
        $text = 3;
        $textLoc = $this->findKeyword($text);
        $this->selectKeyword($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

    }//end testLineageChangesWhenLanguageIsAppliedAndRemovedToBoldText()


    /**
     * Test that VITP changes when an acronym is added to bold text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenAcronymIsAppliedAndRemovedToBoldText()
    {
        $text = 3;
        $textLoc = $this->findKeyword($text);
        $this->selectKeyword($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">ACRONYM</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->clearFieldValue('Acronym');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

    }//end testLineageChangesWhenAcronymIsAppliedAndRemovedToBoldText()


    /**
     * Test that VITP changes when an abbreviation is added to bold text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenAbbreviationIsAppliedAndRemovedToBoldText()
    {
        $text = 3;
        $textLoc = $this->findKeyword($text);
        $this->selectKeyword($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">ABBR</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

    }//end testLineageChangesWhenAbbreviationIsAppliedAndRemovedToBoldText()


    /**
     * Test that VITP doesn't changes when a language is added to italic text and is then removed.
     *
     * @return void
     */
    public function testLineageDoesNotChangeWhenLanguageIsAppliedAndRemovedToItalicText()
    {
        $text = 4;
        $textLoc = $this->findKeyword($text);
        $this->selectKeyword($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

    }//end testLineageDoesNotChangeWhenLanguageIsAppliedAndRemovedToItalicText()


    /**
     * Test that VITP changes when an acronym is added to italic text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenAcronymIsAppliedAndRemovedToItalicText()
    {
        $text = 4;
        $textLoc = $this->findKeyword($text);
        $this->selectKeyword($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">ACRONYM</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->clearFieldValue('Acronym');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

    }//end testLineageChangesWhenAcronymIsAppliedAndRemovedToItalicText()


    /**
     * Test that VITP changes when an abbreviation is added to italic text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenAbbreviationIsAppliedAndRemovedToItalicText()
    {
        $text = 4;
        $textLoc = $this->findKeyword($text);
        $this->selectKeyword($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('en');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">ABBR</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

    }//end testLineageChangesWhenAbbreviationIsAppliedAndRemovedToItalicText()


}//end class

?>
