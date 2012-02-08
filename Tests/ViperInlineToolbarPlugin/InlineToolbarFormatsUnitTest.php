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
        $this->selectText('IPSUM');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->assertEquals('Lorem IPSUM dolor', $this->getSelectedText(), 'Paragraph is not selected.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('IPSUM', $this->getSelectedText(), 'Original selection is not selected');


    }//end testSelectingThePTagInTheLineage()


    /**
     * Test that when you select the Quote tag in the lineage the blockquote is highlighted.
     *
     * @return void
     */
    public function testSelectingTheQuoteTagInTheLineage()
    {
        $this->selectText('quick');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">Quote</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->assertEquals('the quick brown fox', $this->getSelectedText(), 'Blockquote is not selected.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('quick', $this->getSelectedText(), 'Original selection is not selected');


    }//end testSelectingTheQuoteTagInTheLineage()


    /**
     * Test that when you select the Div tag in the lineage the Div is highlighted.
     *
     * @return void
     */
    public function testSelectingTheDivTagInTheLineage()
    {
        $this->selectText('lazy');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">DIV</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->assertEquals('jumps over the lazy dog', $this->getSelectedText(), 'Div is not selected.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('lazy', $this->getSelectedText(), 'Original selection is not selected');


    }//end testSelectingTheDivTagInTheLineage()


    /**
     * Test that when you select the Pre tag in the lineage the Pre is highlighted.
     *
     * @return void
     */
    public function testSelectingThePreTagInTheLineage()
    {
        $this->selectText('LABS');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">PRE</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">PRE</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->assertEquals('Squiz LABS is 0rsm', $this->getSelectedText(), 'Pre is not selected.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('LABS', $this->getSelectedText(), 'Original selection is not selected');


    }//end testSelectingThePreTagInTheLineage()


    /**
     * Test correct lineage is shown when you change a paragraph to a blockquote.
     *
     * @return void
     */
    public function testPChangesToQuoteInLineage()
    {
        $this->selectText('IPSUM');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_toggle_formats_sub.png');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_blockquote.png');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">Quote</li>', $lineage);

    }//end testPChangesToQuoteInLineage()


    /**
     * Test correct lineage is shown when you change a paragraph to a Div.
     *
     * @return void
     */
    public function testPChangesToDivInLineage()
    {
        $this->selectText('IPSUM');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_toggle_formats_sub.png');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_div.png');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">DIV</li>', $lineage);

    }//end testPChangesToDivInLineage()


    /**
     * Test correct lineage is shown when you change a paragraph to a Pre.
     *
     * @return void
     */
    public function testPChangesToPreInLineage()
    {
        $this->selectText('IPSUM');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_toggle_formats_sub.png');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_pre.png');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">PRE</li>', $lineage);

    }//end testPChangesToPreInLineage()


    /**
     * Test selecting the H1 tag in the toolbar.
     *
     * @return void
     */
    public function testSelectingH1Tag()
    {
        $this->selectText('Unit');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H1</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">H1</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);
        
        $this->assertEquals('Inline Toolbar Unit Test', $this->getSelectedText(), 'The H1 tag is not selected');
        
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H1</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);
        
        $this->assertEquals('Unit', $this->getSelectedText(), 'Original text is not selected');

    }//end testSelectingH1Tag()


    /**
     * Test selecting the H2 tag in the toolbar.
     *
     * @return void
     */
    public function testSelectingH2Tag()
    {
        $this->selectText('Two');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H2</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">H2</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);
        
        $this->assertEquals('Heading Two', $this->getSelectedText(), 'The H2 tag is not selected');
        
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H2</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);
        
        $this->assertEquals('Two', $this->getSelectedText(), 'Original text is not selected');

    }//end testSelectingH2Tag()
    

    /**
     * Test selecting the H3 tag in the toolbar.
     *
     * @return void
     */
    public function testSelectingH3Tag()
    {
        $this->selectText('Three');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H3</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">H3</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);
        
        $this->assertEquals('Heading Three', $this->getSelectedText(), 'The H3 tag is not selected');
        
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H3</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);
        
        $this->assertEquals('Three', $this->getSelectedText(), 'Original text is not selected');

    }//end testSelectingH3Tag()
    
}//end class

?>
