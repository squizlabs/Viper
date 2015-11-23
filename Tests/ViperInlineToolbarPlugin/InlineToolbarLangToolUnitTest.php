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

        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(1);
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Span</li>', $lineage);

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->sikuli->keyDown('Key.ENTER');
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenLanguageIsAppliedAndRemoved()


    /**
     * Test that VITP changes when an acronym is added to the selected text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenAcronymIsAppliedAndRemoved()
    {

        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(1);
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li>', $lineage);

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->clearFieldValue('Acronym');
        $this->sikuli->keyDown('Key.ENTER');
        $this->selectKeyword(2);
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

        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(1);
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li>', $lineage);

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->sikuli->keyDown('Key.ENTER');
        $this->selectKeyword(2);
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

        $this->selectKeyword(6);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(1);
        $this->selectKeyword(6);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Span</li>', $lineage);

        $this->clickKeyword(1);
        $this->selectKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->sikuli->keyDown('Key.ENTER');
        $this->selectKeyword(2);
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
        $this->selectKeyword(6);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(1);
        $this->selectKeyword(6);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li>', $lineage);

        $this->clickKeyword(1);
        $this->selectKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->sikuli->keyDown('Key.ENTER');
        $this->selectKeyword(6);
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

        $this->selectKeyword(6);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(1);
        $this->selectKeyword(6);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li>', $lineage);

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->clearFieldValue('Acronym');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(1);
        $this->selectKeyword(6);
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

        $this->selectKeyword(6);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

    }//end testLineageDoesNotChangeWhenLanguageIsAppliedToAParagraph()


    /**
     * Test that when you select the Span tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheSpanTagInTheLineage()
    {
        $this->selectKeyword(4);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals($this->replaceKeywords('%4% %5%'), $this->getSelectedText(), 'Span tag is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%4% %5%'), $this->getSelectedText(), 'Span tag is not selected.');

    }//end testSelectingTheSpanTagInTheLineage()


    /**
     * Test that when you select the AbbreviationEVIATION tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheAbbreviationTagInTheLineage()
    {
        $this->selectKeyword(7);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals($this->replaceKeywords('%7% %8%'), $this->getSelectedText(), 'Abbreviation tag is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectKeyword(8);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%7% %8%'), $this->getSelectedText(), 'Abbreviation tag is not selected.');

    }//end testSelectingTheSpanTagInTheLineage()


    /**
     * Test that when you select the Acronym tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheAcronymTagInTheLineage()
    {
        $this->selectKeyword(9);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals($this->replaceKeywords('%9% %10%'), $this->getSelectedText(), 'Acronym tag is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectKeyword(10);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%9% %10%'), $this->getSelectedText(), 'Acronym tag is not selected.');

    }//end testSelectingTheAcronymTagInTheLineage()


    /**
     * Test that VITP changes when a language is added to bold text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenLanguageIsAppliedAndRemovedToBoldText()
    {
        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(2);
        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(2);
        $this->selectKeyword(3);
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
        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(2);
        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->clearFieldValue('Acronym');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(2);
        $this->selectKeyword(3);
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
        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(2);
        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(2);
        $this->selectKeyword(3);
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
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(2);
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(2);
        $this->selectKeyword(1);
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
        $this->selectKeyword(1);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(2);
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->clearFieldValue('Acronym');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(2);
        $this->selectKeyword(1);
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
        $this->selectKeyword(1);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('en');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(2);
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickKeyword(2);
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

    }//end testLineageChangesWhenAbbreviationIsAppliedAndRemovedToItalicText()


}//end class

?>
