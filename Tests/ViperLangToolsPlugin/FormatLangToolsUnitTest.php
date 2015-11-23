<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLangToolsPlugin_FormatLangToolsUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithBoldFormatSingleTags()
    {

        // Test single tags
        $this->useTest(1);

        // Test language
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(1);

        // Test acronym
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(2);

        // Test abbreviation
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

    }// end testCorrectLanguageIconsWithBoldFormatSingleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithBoldFormatDoubleTags()
    {

        // Test double tags
        $this->useTest(2);

        // Test language applied to acronym
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(1);

        // Test language applied to abbreviation
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(2);

        // Test abbreviation applied to language
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(3);

        // Test abbreviation applied to acronym
        $this->clickKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(4);

        // Test acronym applied to language
        $this->clickKeyword(5);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('ACronym', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        // Test acronym applied to abbreviation
        $this->clickKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(6);

    } // end testCorrectLanguageIconsWithBoldFormatDoubleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithBoldFormatTripleTags()
    {

        $this->useTest(3);

        // Test language applied to acronym applied to abbreviation
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(1);

        // Test language applied to abbreviation applied to acronym
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);
        $this->clickKeyword(2);

        // Test abbreviation applied to language applied to acronym
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);
       $this->clickKeyword(3);

        // Test abbreviation applied to acronym applied to language
        $this->clickKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
       $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);
       $this->clickKeyword(4);

        // Test acronym applied to language applied to abbreviation
        $this->clickKeyword(5);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);
        $this->clickKeyword(5);


        // Test acronym applied to abbreviation applied to language
        $this->clickKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Bold</li>', $lineage);
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);
        $this->clickKeyword(6);

    }//end testCorrectLanguageIconsWithBoldFormatTripleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithItalicFormatSingleTags()
    {

        // Test single tags
        $this->useTest(4);

        // Test language
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(1);

        // Test acronym
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(2);

        // Test abbreviation
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

    }// end testCorrectLanguageIconsWithItalicFormatSingleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithItalicFormatDoubleTags()
    {

        // Test double tags
        $this->useTest(5);

        // Test language applied to acronym
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(1);

        // Test language applied to abbreviation
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(2);

        // Test abbreviation applied to language
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(3);

        // Test abbreviation applied to acronym
        $this->clickKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(4);

        // Test acronym applied to language
        $this->clickKeyword(5);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('ACronym', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        // Test acronym applied to abbreviation
        $this->clickKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(6);

    } // end testCorrectLanguageIconsWithItalicFormatDoubleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithItalicFormatTripleTags()
    {

        $this->useTest(6);

        // Test language applied to acronym applied to abbreviation
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(1);

        // Test language applied to abbreviation applied to acronym
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);
        $this->clickKeyword(2);

        // Test abbreviation applied to language applied to acronym
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);
       $this->clickKeyword(3);

        // Test abbreviation applied to acronym applied to language
        $this->clickKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
       $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);
       $this->clickKeyword(4);

        // Test acronym applied to language applied to abbreviation
        $this->clickKeyword(5);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);
        $this->clickKeyword(5);


        // Test acronym applied to abbreviation applied to language
        $this->clickKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Italic</li>', $lineage);
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);
        $this->clickKeyword(6);

    }//end testCorrectLanguageIconsWithItalicFormatTripleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithStrikethroughFormatSingleTags()
    {

        // Test single tags
        $this->useTest(7);

        // Test language
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(1);

        // Test acronym
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(2);

        // Test abbreviation
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

    }// end testCorrectLanguageIconsWithStrikethroughFormatSingleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithStrikethroughFormatDoubleTags()
    {

        // Test double tags
        $this->useTest(8);

        // Test language applied to acronym
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(1);

        // Test language applied to abbreviation
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(2);

        // Test abbreviation applied to language
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(3);

        // Test abbreviation applied to acronym
        $this->clickKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(4);

        // Test acronym applied to language
        $this->clickKeyword(5);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('ACronym', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        // Test acronym applied to abbreviation
        $this->clickKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(6);

    } // end testCorrectLanguageIconsWithStrikethroughFormatDoubleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithStrikethroughFormatTripleTags()
    {

        $this->useTest(9);

        // Test language applied to acronym applied to abbreviation
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(1);

        // Test language applied to abbreviation applied to acronym
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Strikethrough</li>', $lineage);
        $this->clickKeyword(2);

        // Test abbreviation applied to language applied to acronym
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Strikethrough</li>', $lineage);
       $this->clickKeyword(3);

        // Test abbreviation applied to acronym applied to language
        $this->clickKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
       $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem Viper-selected">Strikethrough</li>', $lineage);
       $this->clickKeyword(4);

        // Test acronym applied to language applied to abbreviation
        $this->clickKeyword(5);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Strikethrough</li>', $lineage);
        $this->clickKeyword(5);


        // Test acronym applied to abbreviation applied to language
        $this->clickKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Strikethrough</li>', $lineage);
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem Viper-selected">Strikethrough</li>', $lineage);
        $this->clickKeyword(6);

    }//end testCorrectLanguageIconsWithStrikethroughFormatTripleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithSuperscriptFormatSingleTags()
    {

        // Test single tags
        $this->useTest(10);

        // Test language
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(1);

        // Test acronym
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(2);

        // Test abbreviation
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

    }// end testCorrectLanguageIconsWithSuperscriptFormatSingleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithSuperscriptFormatDoubleTags()
    {

        // Test double tags
        $this->useTest(11);

        // Test language applied to acronym
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(1);

        // Test language applied to abbreviation
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(2);

        // Test abbreviation applied to language
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(3);

        // Test abbreviation applied to acronym
        $this->clickKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(4);

        // Test acronym applied to language
        $this->clickKeyword(5);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('ACronym', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        // Test acronym applied to abbreviation
        $this->clickKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(6);

    } // end testCorrectLanguageIconsWithSuperscriptFormatDoubleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithSuperscriptFormatTripleTags()
    {

        $this->useTest(12);

        // Test language applied to acronym applied to abbreviation
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(1);

        // Test language applied to abbreviation applied to acronym
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Superscript</li>', $lineage);
        $this->clickKeyword(2);

        // Test abbreviation applied to language applied to acronym
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Superscript</li>', $lineage);
       $this->clickKeyword(3);

        // Test abbreviation applied to acronym applied to language
        $this->clickKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
       $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem Viper-selected">Superscript</li>', $lineage);
       $this->clickKeyword(4);

        // Test acronym applied to language applied to abbreviation
        $this->clickKeyword(5);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Superscript</li>', $lineage);
        $this->clickKeyword(5);


        // Test acronym applied to abbreviation applied to language
        $this->clickKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Superscript</li>', $lineage);
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem Viper-selected">Superscript</li>', $lineage);
        $this->clickKeyword(6);

    }//end testCorrectLanguageIconsWithSuperscriptFormatTripleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithSubscriptFormatSingleTags()
    {

        // Test single tags
        $this->useTest(13);

        // Test language
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(1);

        // Test acronym
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(2);

        // Test abbreviation
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

    }// end testCorrectLanguageIconsWithSubscriptFormatSingleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithSubscriptFormatDoubleTags()
    {

        // Test double tags
        $this->useTest(14);

        // Test language applied to acronym
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(1);

        // Test language applied to abbreviation
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(2);

        // Test abbreviation applied to language
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(3);

        // Test abbreviation applied to acronym
        $this->clickKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(4);

        // Test acronym applied to language
        $this->clickKeyword(5);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('ACronym', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        // Test acronym applied to abbreviation
        $this->clickKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(6);

    } // end testCorrectLanguageIconsWithSubscriptFormatDoubleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsWithSubscriptFormatTripleTags()
    {

        $this->useTest(15);

        // Test language applied to acronym applied to abbreviation
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(1);

        // Test language applied to abbreviation applied to acronym
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Subscript</li>', $lineage);
        $this->clickKeyword(2);

        // Test abbreviation applied to language applied to acronym
        $this->clickKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Subscript</li>', $lineage);
       $this->clickKeyword(3);

        // Test abbreviation applied to acronym applied to language
        $this->clickKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
       $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem Viper-selected">Subscript</li>', $lineage);
       $this->clickKeyword(4);

        // Test acronym applied to language applied to abbreviation
        $this->clickKeyword(5);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Subscript</li>', $lineage);
        $this->clickKeyword(5);


        // Test acronym applied to abbreviation applied to language
        $this->clickKeyword(6);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li><li class="ViperITP-lineageItem">Subscript</li>', $lineage);
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Span</li><li class="ViperITP-lineageItem Viper-selected">Subscript</li>', $lineage);
        $this->clickKeyword(6);

    }//end testCorrectLanguageIconsWithSubscriptFormatTripleTags()
}
