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
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Lorem %2% dolor'), $this->getSelectedText(), 'Paragraph is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), 'Original selection is not selected');


    }//end testSelectingThePTagInTheLineage()


    /**
     * Test that when you select the Quote tag in the lineage the blockquote is highlighted.
     *
     * @return void
     */
    public function testSelectingTheQuoteTagInTheLineage()
    {
        $this->selectKeyword(5);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('the %5% brown fox'), $this->getSelectedText(), 'Blockquote is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), 'Original selection is not selected');


    }//end testSelectingTheQuoteTagInTheLineage()


    /**
     * Test that when you select the Div tag in the lineage the Div is highlighted.
     *
     * @return void
     */
    public function testSelectingTheDivTagInTheLineage()
    {
        $this->selectKeyword(7);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('jumps %6% the %7% dog'), $this->getSelectedText(), 'Div is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%7%'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectingTheDivTagInTheLineage()


    /**
     * Test that when you select the Pre tag in the lineage the Pre is highlighted.
     *
     * @return void
     */
    public function testSelectingThePreTagInTheLineage()
    {
        $this->selectKeyword(8);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">PRE</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Squiz %8% is 0rsm'), $this->getSelectedText(), 'Pre is not selected.');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%8%'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectingThePreTagInTheLineage()


    /**
     * Test correct lineage is shown when you change a paragraph to a blockquote.
     *
     * @return void
     */
    public function testPChangesToQuoteInLineage()
    {
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Quote</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

    }//end testPChangesToQuoteInLineage()


    /**
     * Test correct lineage is shown when you change a paragraph to a Div.
     *
     * @return void
     */
    public function testPChangesToDivInLineage()
    {
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

    }//end testPChangesToDivInLineage()


    /**
     * Test correct lineage is shown when you change a paragraph to a Pre.
     *
     * @return void
     */
    public function testPChangesToPreInLineage()
    {
        $this->selectKeyword(2);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">PRE</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

    }//end testPChangesToPreInLineage()


    /**
     * Test selecting the H1 tag in the toolbar.
     *
     * @return void
     */
    public function testSelectingH1Tag()
    {
        $this->selectKeyword(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H1</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Inline Toolbar %1% Test'), $this->getSelectedText(), 'The H1 tag is not selected');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">H1</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'Original text is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H1</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testSelectingH1Tag()


    /**
     * Test selecting the H2 tag in the toolbar.
     *
     * @return void
     */
    public function testSelectingH2Tag()
    {
        $this->selectKeyword(3);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H2</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Heading %3%'), $this->getSelectedText(), 'The H2 tag is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">H2</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%3%'), $this->getSelectedText(), 'Original text is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H2</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testSelectingH2Tag()


    /**
     * Test selecting the H3 tag in the toolbar.
     *
     * @return void
     */
    public function testSelectingH3Tag()
    {
        $this->selectKeyword(4);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H3</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('Heading %4%'), $this->getSelectedText(), 'The H3 tag is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">H3</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%4%'), $this->getSelectedText(), 'Original text is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H3</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testSelectingH3Tag()


     /**
     * Test correct lineage is shown when you change a paragraph to a Heading.
     *
     * @return void
     */
    public function testPChangesToH2InLineage()
    {
        $this->selectKeyword(2);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H2', NULL, TRUE);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">H2</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

    }//end testPChangesToH2InLineage()


    /**
     * Test the class span tag in the toolbar.
     *
     * @return void
     */
    public function testClassSpanTag()
    {
        $this->selectKeyword(6);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">DIV</li><li class="ViperITP-lineageItem">SPAN</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%6%'), $this->getSelectedText(), 'Class span tag is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

    }//end testClassSpanTag()


}//end class

?>
