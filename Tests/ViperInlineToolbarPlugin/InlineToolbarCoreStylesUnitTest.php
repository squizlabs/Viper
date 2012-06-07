<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperInlineToolbarPlugin_InlineToolbarCoreStylesUnitTest extends AbstractViperUnitTest
{


     /**
     * Test that VITP changes when the format of the selected text changes to bold and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenBoldIsAppliedAndRemoved()
    {
        $text    = 1;
        $textLoc = $this->findKeyword($text);
        $this->selectKeyword($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->keyDown('Key.CMD + b');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->keyDown('Key.CMD + b');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenBoldIsAppliedAndRemoved()


    /**
     * Test that VITP changes when the format of the selected text changes to italics and is the removed.
     *
     * @return void
     */
    public function testLineageChangesWhenItalicIsAppliedAndRemoved()
    {
        $text    = 1;
        $textLoc = $this->findKeyword($text);
        $this->selectKeyword($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->keyDown('Key.CMD + i');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->keyDown('Key.CMD + i');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenItalicIsAppliedAndRemoved()


    /**
     * Test that VITP changes when subscript is applied to the selected text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenSubscriptIsAppliedAndRemoved()
    {
        $text    = 1;
        $textLoc = $this->findKeyword($text);
        $this->selectKeyword($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('subscript');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SUB</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('subscript', 'active');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenSubscriptIsAppliedAndRemoved()


    /**
     * Test that VITP changes when superscript is applied to the selected text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenSuperscriptIsAppliedAndRemoved()
    {
        $text    = 1;
        $textLoc = $this->findKeyword($text);
        $this->selectKeyword($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('superscript');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SUP</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('superscript', 'active');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenSuperscriptIsAppliedAndRemoved()


    /**
     * Test that VITP changes when strike through is applied to the selected text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenStrikethroughIsAppliedAndRemoved()
    {
        $text    = 1;
        $textLoc = $this->findKeyword($text);
        $this->selectKeyword($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->clickTopToolbarButton('strikethrough');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">DEL</li>', $lineage);

        $this->clickTopToolbarButton('strikethrough', 'active');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenStrikethroughIsAppliedAndRemoved()


    /**
     * Test that when you select the Bold tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheBoldTagInTheLineage()
    {
        $this->selectKeyword(2);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%2% %9%'), $this->getSelectedText(), 'Bold text is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectKeyword(9);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%2% %9%'), $this->getSelectedText(), 'Bold text is not selected.');

    }//end testSelectingTheBoldTagInTheLineage()


    /**
     * Test that when you select the Italic tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheItalicTagInTheLineage()
    {
        $this->selectKeyword(3);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Italic</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals($this->replaceKeywords('%3% %4%'), $this->getSelectedText(), 'Italics text is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%3% %4%'), $this->getSelectedText(), 'Italics text is not selected.');

    }//end testSelectingTheItalicTagInTheLineage()


    /**
     * Test that when you select the Subscript tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheSubscriptTagInTheLineage()
    {
        $this->selectKeyword(5);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">SUB</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals($this->replaceKeywords('%5% %10%'), $this->getSelectedText(), 'Subscript text is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SUB</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectKeyword(10);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%5% %10%'), $this->getSelectedText(), 'Subscript text is not selected.');

    }//end testSelectingTheItalicTagInTheLineage()


    /**
     * Test that when you select the Superscript tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheSuperscriptTagInTheLineage()
    {
        $this->selectKeyword(6);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">SUP</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals($this->replaceKeywords('%7% %6%'), $this->getSelectedText(), 'Superscript text is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SUP</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectKeyword(7);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%7% %6%'), $this->getSelectedText(), 'superscript text is not selected.');

    }//end testSelectingTheSuperscriptTagInTheLineage()


    /**
     * Test that when you select the strike through tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheStrikethroughTagInTheLineage()
    {
        $this->selectKeyword(6);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">DEL</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals('CROSSED out', $this->getSelectedText(), 'Strikethrough text is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">DEL</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

    }//end testSelectingTheStrikethroughTagInTheLineage()

    /**
     * Test the order of the Bold and Italic lineage
     *
     * @return void
     */
    public function testOrderOfBoldAndItalicLineage()
    {
        $this->selectKeyword(1);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Italic</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

    }//end testOrderOfBoldAndItalicLineage()


    /**
     * Test selecting Bold and Italic in the lineage.
     *
     * @return void
     */
    public function testSelectingBoldAndItalic()
    {
        $this->selectKeyword(1, 8);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->selectKeyword(8);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%1% %8%'), $this->getSelectedText(), 'Formatted text is not selected');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals($this->replaceKeywords('%1% %8%'), $this->getSelectedText(), 'Formatted text is not selected');


    }//end testSelectingBoldAndItalic()


}//end class

?>
