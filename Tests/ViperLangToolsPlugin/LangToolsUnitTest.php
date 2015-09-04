<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLangToolsPlugin_LangToolsUnitTest extends AbstractViperUnitTest
{


    /**
     * Test applying an abbreviation to a word that has a languarge applied.
     *
     * @return void
     */
    public function testApplyingAbbreviationToLanguage()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');

        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->clickField('Abbreviation');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is some %1% content</p><p>Squiz <abbr title="abc"><span lang="en">%2%</span></abbr> is orsm</p><p>Squiz <abbr title="abc">%3%</abbr> is orsm</p><p>Squiz <acronym title="abc">%4%</acronym> is orsm</p>');
        // Check that the language button is no longer active as you are now on the abbr instead of the span
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should no longer be active');

        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">ABBR</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Language', 'active', TRUE), 'Language button should be active');
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">ABBR</li><li class="ViperITP-lineageItem">SPAN</li>', $lineage);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'active', TRUE), 'Abbreviation button should be active');

    }//end testApplyingAbbreviationToLanguage()

}//end class

?>
