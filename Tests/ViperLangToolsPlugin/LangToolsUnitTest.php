<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLangToolsPlugin_LangToolsUnitTest extends AbstractViperUnitTest
{


    /**
     * Test applying an abbreviation to a word that has a language applied.
     *
     * @return void
     */
    public function testApplyingAbbreviationToLanguage()
    {
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');

        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->clickField('Abbreviation');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some %1% content</p><p>Squiz<abbr title="abc"><span lang="en">%2%</span></abbr> is orsm</p><p>Squiz<abbr title="abc">%3%</abbr> is orsm</p><p>Squiz<acronym title="abc">%4%</acronym> is orsm</p>');

        // Check that the language button is still active
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should still be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');

        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

    }//end testApplyingAbbreviationToLanguage()


    /**
     * Test applying an abbreviation to a word that has an acronym applied.
     *
     * @return void
     */
    public function testApplyingAbbreviationToAcronym()
    {
        $this->useTest(1);
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');

        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->clickField('Abbreviation');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some %1% content</p><p>Squiz<span lang="en">%2%</span> is orsm</p><p>Squiz<abbr title="abc">%3%</abbr> is orsm</p><p>Squiz<abbr title="abc"><acronym title="abc">%4%</acronym></abbr> is orsm</p>');

        // Check that the acronym button is no longer active as you are now on the abbr instead of the acronym
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should no longer be active');

        $this->selectKeyword(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

    }//end testApplyingAbbreviationToAcronym()


    /**
     * Test applying a language to a word that has an abbreviation applied.
     *
     * @return void
     */
    public function testApplyingLanguageToAbbreviation()
    {
        $this->useTest(1);
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->clickField('Language');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some %1% content</p><p>Squiz<span lang="en">%2%</span> is orsm</p><p>Squiz<abbr lang="abc" title="abc">%3%</abbr> is orsm</p><p>Squiz<acronym title="abc">%4%</acronym> is orsm</p>');

        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

    }//end testApplyingLanguageToAbbreviation()


    /**
     * Test applying a language to a word that has an acronym applied.
     *
     * @return void
     */
    public function testApplyingLanguageToAcronym()
    {
        $this->useTest(1);
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');

        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->clickField('Language');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some %1% content</p><p>Squiz<span lang="en">%2%</span> is orsm</p><p>Squiz<abbr title="abc">%3%</abbr> is orsm</p><p>Squiz<acronym lang="abc" title="abc">%4%</acronym> is orsm</p>');

        $this->selectKeyword(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');

    }//end testApplyingLanguageToAcronym()


    /**
     * Test applying an acronym to a word that has a language applied.
     *
     * @return void
     */
    public function testApplyingAcronymToLanguage()
    {
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');

        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->clickField('Acronym');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some %1% content</p><p>Squiz<acronym title="abc"><span lang="en">%2%</span></acronym> is orsm</p><p>Squiz<abbr title="abc">%3%</abbr> is orsm</p><p>Squiz<acronym title="abc">%4%</acronym> is orsm</p>');

        // Check that the language button is no longer active as you are now on the abbr instead of the span
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should no longer be active');

        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');

    }//end testApplyingAcronymToLanguage()


    /**
     * Test applying an acronym to a word that has an abbreviation applied.
     *
     * @return void
     */
    public function testApplyingAcronymToAbbreviation()
    {
        $this->useTest(1);
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');

        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->clickField('Abbreviation');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some %1% content</p><p>Squiz<span lang="en">%2%</span> is orsm</p><p>Squiz<abbr title="abc">%3%</abbr> is orsm</p><p>Squiz<abbr title="abc"><acronym title="abc">%4%</acronym></abbr> is orsm</p>');

        // Check that the language button is no longer active as you are now on the abbr instead of the span
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should no longer be active');

        $this->selectKeyword(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

    }//end testApplyingAbbreviationToAcronym()


    /**
     * Test applying an abbreviation to a word that has a language applied.
     *
     * @return void
     **/
    public function testApplyingAbbreviationToAcronymWithLanguage()
    {

        $this->useTest(2);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Language button should be active');

        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->clickField('Abbreviation');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some %1% content</p><p>Squiz<abbr title="abc"><acronym lang="en" title="abc">%2%</acronym></abbr> is orsm</p><p>Squiz<acronym title="abc"><span lang="en">%3%</span></acronym> is orsm</p>');

        // Check that the language button is no longer active as you are now on the abbr instead of the span
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'selected', TRUE), 'Abbreviation button should be selected');

        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->selectKeyword(2);

    }//end testApplyingAbbreviationToAcronymWithLanguage()


    /**
     * Test applying an abbreviation to a word that has a language applied.
     *
     * @return void
     */
    public function testApplyingAbbreviationToLanguageWithAcronym()
    {

        $this->useTest(2);
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');

        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->clickField('Abbreviation');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some %1% content</p><p>Squiz<acronym lang="en" title="abc">%2%</acronym> is orsm</p><p>Squiz<acronym title="abc"><abbr title="abc"><span lang="en">%3%</span></abbr></acronym> is orsm</p>');

        // Check that the language button is no longer active as you are now on the abbr instead of the span
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');

        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
    }//end testApplyingAbbreviationToLanguageWithAcronym()

    /**
     * Test applying an abbreviation to a word that has a language applied.
     *
     * @return void
     */
    public function testApplyingLanguageToAbbreviationWithAcronym()
    {

        $this->useTest(3);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Language button should be active');

        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->clickField('Language');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some %1% content</p><p>Squiz<acronym title="abc"><abbr lang="abc" title="abc">%2%</abbr></acronym> is orsm</p><p>Squiz<abbr title="abc"><acronym title="abc">%3%</acronym></abbr> is orsm</p>');

        // Check that the language button is no longer active as you are now on the abbr instead of the span
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'selected', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Language button should be active');

    }//end testApplyingAbbreviationToAcronymWithLanguage()


    /**
     * Test applying an abbreviation to a word that has a language applied.
     *
     * @return void
     */
    public function testApplyingLanguageToAcronymWithAbbreviation()
    {

        $this->useTest(3);
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Language button should be active');

        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->clickField('Language');
        $this->type('abc');
        sleep(3);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some %1% content</p><p>Squiz<acronym title="abc"><abbr title="abc">%2%</abbr></acronym> is orsm</p><p>Squiz<abbr title="abc"><acronym lang="abc" title="abc">%3%</acronym></abbr> is orsm</p>');

        // Check that the language button is no longer active as you are now on the abbr instead of the span
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'selected', TRUE), 'Language button should be selected');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');

        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');

        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');

    }//end testApplyingAbbreviationToLanguageWithAcronym()


    /**
     * Test applying an abbreviation to a word that has a language applied.
     *
     * @return void
     **/
    public function testApplyingAcronymToLanguageWithAbbreviation()
    {

        $this->useTest(4);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Language button should be active');

        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->clickField('Acronym');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some %1% content</p><p>Squiz<abbr title="abc"><acronym title="abc"><span lang="en">%2%</span></acronym> is orsm</abbr></p><p>Squiz<abbr lang="en" title="abc">%3% is orsm</abbr></p>');

        // Check that the language button is no longer active as you are now on the abbr instead of the span
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'selected', TRUE), 'Acronym button should be selected');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should be not active');

        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->selectKeyword(2);

    }//end testApplyingAcronymToLanguageWithAbbreviation()


    /**
     * Test applying an abbreviation to a word that has a language applied.
     *
     * @return void
     **/
    public function testApplyingAcronymToAbbreviationWithLanguage()
    {

        $this->useTest(4);
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Language button should be active');

        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->clickField('Acronym');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some %1% content</p><p>Squiz<abbr title="abc"><span lang="en">%2%</span> is orsm</abbr></p><p>Squiz<abbr lang="en" title="abc"><acronym title="abc">%3%</acronym> is orsm</abbr></p>');

        // Check that the language button is no longer active as you are now on the abbr instead of the span
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'selected', TRUE), 'Acronym button should be selected');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should be not active');

        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->selectKeyword(3);

    }//end testApplyingAcronymToAbbreviationWithLanguage()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsSingleTags()
    {

        // Test single tags
        $this->useTest(5);

        // Test language
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Span</li>', $lineage);
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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li>', $lineage);
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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

    }// end testCorrectLanguageIconsSingleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsDoubleTags()
    {

        // Test double tags
        $this->useTest(6);

        // Test language applied to acronym
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should not be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li>', $lineage);
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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li>', $lineage);
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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li>', $lineage);
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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li>', $lineage);
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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('ACronym', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li>', $lineage);
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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(6);

    } // end testCorrectLanguageIconsDoubleTags()


    /**
     * Test that icons appear when they should depending on language tools applied.
     *
     * @return void
     */
    public function testCorrectLanguageIconsTripleTags()
    {

        $this->useTest(7);

        // Test language applied to acronym applied to abbreviation
        $this->clickKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'disabled', TRUE), 'Language button should not be active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li>', $lineage);
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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(3);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(4);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Span</li>', $lineage);
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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Language button should be active');
        $this->clickKeyword(5);

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Language button should be active');
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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'active', TRUE), 'Acronym button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem Viper-selected">Abbreviation</li><li class="ViperITP-lineageItem">Span</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');
        $this->clickKeyword(6);

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Acronym</li><li class="ViperITP-lineageItem">Abbreviation</li><li class="ViperITP-lineageItem Viper-selected">Span</li>', $lineage);
        $this->clickKeyword(6);

    }//end testCorrectLanguageIconsTripleTags()



}//end class

?>
