<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperInlineToolbarPlugin_InlineToolbarFormatsUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that when you select the P tag in the lineage the paragraph is highlighted.
     *
     * @return void
     */
    public function testSelectingThePTagInTheLineage()
    {
        $this->useTest(1);

        // Check multi-line paragraph
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.'), $this->getSelectedText(), 'The second paragraph should be highlighted.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection should be highlighted');

        // Check single line paragraph
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('sit amet %1%'), $this->getSelectedText(), 'The first paragraph should be highlighted.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'Original selection should be highlighted');

    }//end testSelectingThePTagInTheLineage()


    /**
     * Test that when you select the Quote tag in the lineage the blockquote is highlighted.
     *
     * @return void
     */
    public function testSelectingTheQuoteTagInTheLineage()
    {
        $this->useTest(2);

        // Check multi-paragraph blockquote
                $this->selectKeyword(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.'), $this->getSelectedText(), 'The second paragraoh in the blockquote should be selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('sit amet %3%%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.'), $this->getSelectedText(), 'Both parargraphs in the blockquote should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li><li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('%4%'), $this->getSelectedText(), 'Original selection should be selected');

        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('sit amet %3%'), $this->getSelectedText(), 'The first paragraoh in the blockquote should be selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('sit amet %3%%4% long paragraph for testing that the heading icon work for multiline paragraphs in quotes.'), $this->getSelectedText(), 'Both parargraphs in the blockquote should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li><li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('%3%'), $this->getSelectedText(), 'Original selection should be selected');

        // Check multi-line blockquote
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.'), $this->getSelectedText(), 'The second blockquote section should be selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.'), $this->getSelectedText(), 'The second blockquote section should be selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li><li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection should be selected');

        // Check single line blockquote
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('sit amet %1%'), $this->getSelectedText(), 'The first blockquote section should be selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('sit amet %1%'), $this->getSelectedText(), 'The first blockquote section should be selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li><li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'Original selection should be selected');


    }//end testSelectingTheQuoteTagInTheLineage()


    /**
     * Test that when you select the Div tag in the lineage the Div is highlighted.
     *
     * @return void
     */
    public function testSelectingTheDivTagInTheLineage()
    {
        $this->useTest(3);

        // Check multi-line Div
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.'), $this->getSelectedText(), 'The first Div section should be highlighted');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection is not selected');

        // Check single line Div
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('sit amet %1%'), $this->getSelectedText(), 'The first Div section should be highlighted');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectingTheDivTagInTheLineage()


    /**
     * Test that when you select the Pre tag in the lineage the Pre is highlighted.
     *
     * @return void
     */
    public function testSelectingThePreTagInTheLineage()
    {
        $this->useTest(4);

        // Check multi-line Pre
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">PRE</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('%2% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.'), $this->getSelectedText(), 'The first Pre section should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection is not selected');

        // Check single line Pre
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">PRE</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('sit amet %1%'), $this->getSelectedText(), 'The first Pre section should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectingThePreTagInTheLineage()


    /**
     * Test the lineage for different Div structures.
     *
     * @return void
     */
    public function testLineageWithDifferentDivStructures()
    {
        $this->useTest(5);

        // Check Pre's inside of Div
        $this->selectKeyword(8);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem Viper-selected">PRE</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);
        $this->assertEquals($this->replaceKeywords('%8% long paragraph for testing that the heading icon does not appear in the inline toolbar.'), $this->getSelectedText(), 'The second Pre section should be selected');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('sit amet %7%\n        %8% long paragraph for testing that the heading icon does not appear in the inline toolbar.'), $this->getSelectedText(), 'The div section should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li><li class="ViperITP-lineageItem">PRE</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        // Check Quotes's inside of Div
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);
        $this->assertEquals($this->replaceKeywords('sit amet %5%'), $this->getSelectedText(), 'The P inside the first quote section should be selected');

        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem Viper-selected">Quote</li><li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);
        $this->assertEquals($this->replaceKeywords('sit amet %5%'), $this->getSelectedText(), 'The Quote inside the first quote section should be selected');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('sit amet %5%\n        %6% long paragraph for testing that the heading icon does not appear in the inline toolbar.'), $this->getSelectedText(), 'The second Pre section should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li><li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        // Check Div's inside of Div
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem Viper-selected">DIV</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);
        $this->assertEquals($this->replaceKeywords('%4% long paragraph for testing that the heading icon does not appear in the inline toolbar.'), $this->getSelectedText(), 'The second div section should be selected');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('sit amet %3%\n        %4% long paragraph for testing that the heading icon does not appear in the inline toolbar.'), $this->getSelectedText(), 'The second Pre section should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li><li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        // Check P's inside of Div
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);
        $this->assertEquals($this->replaceKeywords('sit amet %1%'), $this->getSelectedText(), 'The first P section should be selected');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('sit amet %1%\n        %2% long paragraph for testing that the heading icon does not appear in the inline toolbar.'), $this->getSelectedText(), 'The second Pre section should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li><li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

    }//end testLineageWithDifferentDivStructures()


    /**
     * Test correct lineage is shown when you change a P section to different format types.
     *
     * @return void
     */
    public function testChangingPSectionToDifferentFormatTypes()
    {
        $this->useTest(1);

        // Check single line paragraph
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li>', $lineage);
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li>', $lineage);

        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li>', $lineage);
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li>', $lineage);

        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li>', $lineage);
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li>', $lineage);

        // Check multi-line paragraph.
        $this->selectKeyword(2);
        sleep(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li>', $lineage);
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li>', $lineage);

        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li>', $lineage);
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li>', $lineage);

        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li>', $lineage);
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li>', $lineage);

    }//end testChangingPSectionToDifferentFormatTypes()


    /**
     * Test correct lineage is shown when you change a Quote section to different format types.
     *
     * @return void
     */
    public function testChangingQuoteSectionToDifferentFormatTypes()
    {
        $this->useTest(2);

        // Check single line quote
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li>', $lineage);
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li>', $lineage);

        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li>', $lineage);
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li>', $lineage);

        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li>', $lineage);
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li>', $lineage);

        // Check multi-line paragraph
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li>', $lineage);
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li>', $lineage);

        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li>', $lineage);
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li>', $lineage);

        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li>', $lineage);
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li>', $lineage);

    }//end testChangingQuoteSectionToDifferentFormatTypes()


    /**
     * Test correct lineage is shown when you change a Div section to different format types.
     *
     * @return void
     */
    public function testChangingDivSectionToDifferentFormatTypes()
    {
        $this->useTest(3);

        // Check single line div
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li>', $lineage);
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li>', $lineage);

        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li>', $lineage);
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li>', $lineage);

        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li>', $lineage);
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li>', $lineage);

        // Check multi-line paragraph
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li>', $lineage);
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li>', $lineage);

        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li>', $lineage);
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li>', $lineage);

        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li>', $lineage);
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li>', $lineage);

    }//end testChangingDivSectionToDifferentFormatTypes()


    /**
     * Test correct lineage is shown when you change a Pre section to different format types.
     *
     * @return void
     */
    public function testChangingPreSectionToDifferentFormatTypes()
    {
        $this->useTest(4);

        // Check single line pre
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">PRE</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li>', $lineage);
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li>', $lineage);

        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li>', $lineage);
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li>', $lineage);

        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li>', $lineage);
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li>', $lineage);

        // Check multi-line paragraph
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">PRE</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li>', $lineage);
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li>', $lineage);

        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li>', $lineage);
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li>', $lineage);

        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li>', $lineage);
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li>', $lineage);

    }//end testChangingPreSectionToDifferentFormatTypes()


    /**
     * Test selecting different heading tags in the lineage.
     *
     * @return void
     */
    public function testSelectingDifferentHeadingsTags()
    {
        $this->useTest(6);

        // Test H3
        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem">H3</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('Heading 3 %3%'), $this->getSelectedText(), 'The content in the H3 tag should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem Viper-selected">H3</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Heading 3 %3%'), $this->getSelectedText(), 'The content in the Div tag should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li><li class="ViperITP-lineageItem">H3</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('%3%'), $this->getSelectedText(), 'Original text is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem">H3</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        // Test H2
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H2</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Heading 2 %2%'), $this->getSelectedText(), 'The content in the H2 tag should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">H2</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original text is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H2</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        // Test H1
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H1</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Heading 1 %1%'), $this->getSelectedText(), 'The content in the H1 tag should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">H1</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'Original text is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H1</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testSelectingDifferentHeadingsTags()


     /**
     * Test correct lineage is shown when you change a paragraph to a Heading.
     *
     * @return void
     */
    public function testPChangesToH2InLineage()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H2', NULL, TRUE);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">H2</li>', $lineage);

    }//end testPChangesToH2InLineage()


    /**
     * Test the class span tag in the toolbar.
     *
     * @return void
     */
    public function testClassSpanTag()
    {
        $this->useTest(7);

        // Test class around paragraph. Class or Span should not appear in lineage.
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        // Test class around one word
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">SPAN</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'Class span tag should be selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

    }//end testClassSpanTag()


}//end class

?>
